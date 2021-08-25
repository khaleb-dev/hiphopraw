<?php

class Controller_Membership extends Controller_Base
{
    public $template = 'layout/template';

    public function before()
    {
        parent::before();

        $login_exception = array("");

        parent::check_permission($login_exception);
    }


    public function action_upgrade()
    {
        $countries = Model_Country::find('all', array('order_by' => 'name'));
        $payment_types = Model_Paymenttype::find('all');
        $profile = Model_Profile::query()->where('user_id', $this->current_user->id)->get_one();
        $billing = Model_Billing::query()->where('profile_id', $profile->id)->get_one();
        $billing = $billing == null ? Model_Billing::forge() : $billing;

        $view = View::forge('membership/upgrade', array(
            'countries' => $countries,
            'payment_types' => $payment_types,
            'profile' => $profile,
            'billing' => $billing
        ));

        $view->set_global("active_page", "upgrade");
        $view->set_global('page_js', 'membership/upgrade.js');
        $view->set_global('page_css', 'membership/upgrade.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; Upgrade';
        $this->template->content = $view;
    }

    public function action_account_upgrade()
    {
        // Check for POST
        if (Input::method() != "POST") {
            Response::redirect("membership/upgrade");
        }

        $post = Input::post();

        $profile = Model_Profile::query()->where('user_id', $this->current_user->id)->get_one();
        $country = Model_Country::find(intval($post['country']));
        $recurring_payment = isset($post['recurring']) ? Model_Paymenttype::find($post['recurring']) : null;
        $one_time_payment = isset($post['one-time']) ? Model_Paymenttype::find($post['one-time']) : null;

        // Load Package and Config
        Package::load('authorizenet');
        Config::load('authorizenet');

        // Read config
        $api_login_id = Config::get("api_login_id");
        $transaction_key = Config::get("transaction_key");
        $sandbox = Config::get("sandbox");

        // Find Billing Address or Create a new one
        $billing = Model_Billing::query()->where("profile_id", $profile->id)->get_one();

        $billing_info = array(
            "profile_id" => $profile->id,
            "country_id" => $country->id,
            "state" => $post['state'],
            "city" => $post['city'],
            "postal_code" => $post['postal_code'],
            "street_address" => $post['address']
        );

        if ($billing) {
            $billing->set($billing_info);
        } else {
            $billing = Model_Billing::forge($billing_info);
        }

        $billing->save();

        // Check if plan is chosen
        if ($recurring_payment) {


            // The id of the one-time payment from the database
            $one_time = Model_Paymenttype::query()->where('mode', 'one-time')->get_one();
            // Find previous subscription of different type
            $prev_subscription = Model_Service::query()
                ->where("profile_id", $profile->id)
                ->where("payment_type_id", '!=', $recurring_payment->id)
                ->where("payment_type_id", '!=', $one_time->id)->get_one();
            // Cancel Subscription First
            if ($prev_subscription) {
                // Un-subscribe
                $unsubscribe_request = new AuthorizeNetARB($api_login_id, $transaction_key);
                $unsubscribe_request->setSandbox($sandbox);
                $unsubscribe_response = $unsubscribe_request->cancelSubscription($prev_subscription->transaction_id);

                if ($unsubscribe_response->isError()) {
                    Session::set_flash("success", array("Unable to cancel subscription! Please contact administrator."));
                    Response::redirect("membership/upgrade");
                }
                // Also remove from DB
                $prev_subscription->delete();
            }

            // Create New Subscription
            $subscription = new AuthorizeNet_Subscription;
            $subscription->name = "The Man You Want Paid Membership Plan";
            $subscription->intervalLength = intval($recurring_payment->name);
            $subscription->intervalUnit = "months";
            $subscription->startDate = date('Y-m-d');
            $subscription->totalOccurrences = "9999";
            $subscription->amount = $recurring_payment->amount;
            $subscription->creditCardCardNumber = $post['card_num'];
            $subscription->creditCardExpirationDate = $post['exp_month'] . $post['exp_year'];
            $subscription->creditCardCardCode = $post['security_code'];
            $subscription->billToFirstName = $post['first_name'];
            $subscription->billToLastName = $post['last_name'];


            // Subscription Object
            $arb_request = new AuthorizeNetARB($api_login_id, $transaction_key);
            $arb_request->setSandbox($sandbox);
            $arb_response = $arb_request->createSubscription($subscription);

            if (!$arb_response->isError()) {
                $recurring_service = Model_Service::forge(array(
                    "profile_id" => $profile->id,
                    "payment_type_id" => $recurring_payment->id,
                    "payment_amount" => $recurring_payment->amount,
                    "transaction_id" => $arb_response->getSubscriptionId()
                ));

                $recurring_service->save();

                //Change membership type
                $this->current_profile->member_type_id = 2; //Premium
                $this->current_profile->save();

                Session::set_flash("success", array("You have successfully upgraded your account to a paid membership!"));
            } else {
                Session::set_flash("error", array($arb_response->getMessageText()));
                Response::redirect("membership/upgrade");
            }
        }


        if ($one_time_payment) {
            // Collect One-time Payment Info
            $aimFields = array(
                'amount' => $one_time_payment->amount,
                'card_num' => $post['card_num'],
                'exp_date' => $post['exp_month'] . $post['exp_year'],
                'card_code' => $post['security_code'],
                'first_name' => $post['first_name'],
                'last_name' => $post['last_name'],
                'address' => $post['address'],
                'city' => $post['city'],
                'state' => $post['state'],
                'country' => $country->name,
                'zip' => $post['postal_code'],
                'email' => $post['email']
            );

            // Transact
            $transaction = new AuthorizeNetAIM($api_login_id, $transaction_key);
            $transaction->setSandbox($sandbox);
            $transaction->setFields($aimFields);

            $aim_response = $transaction->authorizeAndCapture();

            if ($aim_response->approved) {
                // Save Transaction Info to database
                $dating_agent_service = Model_Service::forge(array(
                    "profile_id" => $profile->id,
                    "payment_type_id" => $one_time_payment->id,
                    "payment_amount" => $one_time_payment->amount,
                    "transaction_id" => $aim_response->transaction_id
                ));

                $dating_agent_service->save();

                //Change membership type
                $this->current_profile->member_type_id = 3; //Dating Agent
                $this->current_profile->save();

                $flash = Session::get_flash("success");

                if ($flash) {
                    array_push($flash, "You have successfully hired a Dating Agent!");
                } else {
                    $flash = array("You have successfully hired a Dating Agent!");
                }
                Session::set_flash("success", $flash);
            } else {
                Session::set_flash("error", $aim_response->error_message);
                Response::redirect("membership/upgrade");
            }
        }

        Response::redirect('profile/dashboard');
    }

    public function action_dating_agent()
    {
        $countries = Model_Country::find('all', array('order_by' => 'name'));
        $payment_types = Model_Paymenttype::find('all');
        $profile = Model_Profile::query()->where('user_id', $this->current_user->id)->get_one();
        $billing = Model_Billing::query()->where('profile_id', $profile->id)->get_one();
        $billing = $billing == null ? Model_Billing::forge() : $billing;

        $view = View::forge('membership/dating_agent', array(
            'countries' => $countries,
            'payment_types' => $payment_types,
            'profile' => $profile,
            'billing' => $billing
        ));

        $view->set_global("active_page", "dating_agent");
        $view->set_global('page_js', 'membership/dating_agent.js');
        $view->set_global('page_css', 'membership/dating_agent.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; Dating Agent';
        $this->template->content = $view;
    }

    public function action_dating_agent_update()
    {
        // Check for POST
        if (Input::method() != "POST") {
            Response::redirect("membership/upgrade");
        }

        $post = Input::post();

        $profile = Model_Profile::query()->where('user_id', $this->current_user->id)->get_one();
        $country = Model_Country::find(intval($post['country']));
        $one_time_payment = Model_Paymenttype::query()->where('mode', 'one-time')->get_one();

        $dating_agent_service = Model_Service::query()
            ->where('profile_id', $profile->id)
            ->where('payment_type_id', $one_time_payment->id)
            ->get_one();

        // Check if dating agent has already been hired
        if ($dating_agent_service) {
            Session::set_flash("error", "You already have a dating agent hired!");
            Response::redirect("membership/dating_agent");
        }

        // Load Package and Config
        Package::load('authorizenet');
        Config::load('authorizenet');

        // Read config
        $api_login_id = Config::get("api_login_id");
        $transaction_key = Config::get("transaction_key");
        $sandbox = Config::get("sandbox");

        // Find Billing Address or Create a new one
        $billing = Model_Billing::query()->where("profile_id", $profile->id)->get_one();

        $billing_info = array(
            "profile_id" => $profile->id,
            "country_id" => $country->id,
            "state" => $post['state'],
            "city" => $post['city'],
            "postal_code" => $post['postal_code'],
            "street_address" => $post['address']
        );

        if ($billing) {
            $billing->set($billing_info);
        } else {
            $billing = Model_Billing::forge($billing_info);
        }

        $billing->save();

        // Collect One-time Payment Info
        $aimFields = array(
            'amount' => $one_time_payment->amount,
            'card_num' => $post['card_num'],
            'exp_date' => $post['exp_month'] . $post['exp_year'],
            'card_code' => $post['security_code'],
            'first_name' => $post['first_name'],
            'last_name' => $post['last_name'],
            'address' => $post['address'],
            'city' => $post['city'],
            'state' => $post['state'],
            'country' => $country->name,
            'zip' => $post['postal_code'],
            'email' => $post['email']
        );

        // Transact
        $transaction = new AuthorizeNetAIM($api_login_id, $transaction_key);
        $transaction->setSandbox($sandbox);
        $transaction->setFields($aimFields);

        $aim_response = $transaction->authorizeAndCapture();

        if ($aim_response->approved) {
            // Save Transaction Info to database
            $new_dating_agent_service = Model_Service::forge(array(
                "profile_id" => $profile->id,
                "payment_type_id" => $one_time_payment->id,
                "payment_amount" => $one_time_payment->amount,
                "transaction_id" => $aim_response->transaction_id
            ));

            $new_dating_agent_service->save();

            Session::set_flash("success", "You have successfully hired a Dating Agent!");
        } else {
            Session::set_flash("error", $aim_response->error_message);
            Response::redirect("membership/dating_agent");
        }

        Response::redirect('profile/dashboard');
    }

}