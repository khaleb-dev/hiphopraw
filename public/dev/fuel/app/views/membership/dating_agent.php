<div id="content">
    <h1>Concierge Agent</h1>
    <p>As your personal dating concierge agent, we take the work out of the online dating process. Let us help you improve the quality
    and quantity of your dates and maximize your online experience.</p>
    <p>Our dating concierge are socially on point savvy women and men highly educated in communication and the art of online dating.
    We are dedicated to helping you put your best foot forward and helping you navigate through the often scary world of online dating.</p>

    <?php echo Form::open(array("action" => "membership/dating_agent_update", "id" => "upgrade-form", "class" => "clearfix")) ?>
        <h2>Enter Your Payment Info</h2>
        <div class="form-elements">
            <p>
                <label>First:</label>
                <?php echo Form::input("first_name", $profile->first_name, array("class" => "required", "disabled"=>"")); ?>
                <span class="error with-margin ">First Name is a required field</span>
            </p>

            <p>
                <label>Last Name:</label>
                <?php echo Form::input("last_name", $profile->last_name, array("class" => "required", "disabled"=>"")); ?>
                <span class="error with-margin ">Last Name is a required field</span>
            </p>

            <p>
                <label>Country:</label>
                <select name="country" class="required">
                    <?php foreach($countries as $country) {?>
                        <option value="<?php echo $country->id; ?>" <?php echo $country->id == $profile->id ? "selected" : "" ?>>
                            <?php echo $country->name; ?>
                        </option>
                    <?php } ?>
                </select>
                <span class="error with-margin ">Country is a required field</span>
            </p>

            <p>
                <label>State:</label>
                <?php echo Form::input("state", $billing->state, array("class" => "required")); ?>
                <span class="error with-margin ">State is a required field</span>
            </p>

            <p>
                <label>City:</label>
                <?php echo Form::input("city", $billing->city, array("class" => "required")); ?>
                <span class="error with-margin ">City is a required field</span>
            </p>

            <p>
                <label>Address:</label>
                <?php echo Form::input("address", $billing->street_address, array("class" => "required")); ?>
                <span class="error with-margin ">Address is a required field</span>
            </p>

            <p>
                <label>Postal Code:</label>
                <?php echo Form::input("postal_code", $billing->postal_code, array("class" => "short required")); ?>
                <span class="explain">What is this?</span>
                <span class="error with-margin ">Postal Code is a required field</span>
            </p>

            <p>
                <label>Email:</label>
                <?php echo Form::input("email", $current_user->email, array("class" => "email required")); ?>
                <span class="error with-margin">Email is a required field</span>
                <span class="error with-margin email">Email should be in appropriate format</span>
            </p>
        </div>
        <div class="form-elements">
            <p>
                <label>Card Type:</label>
                <?php echo Form::select(
                    "card_type",
                    "none",
                    array(
                        "" => "Please Select",
                        "American Express" => "American Express",
                        "Discover" => "Discover",
                        "Mastercard" => "Mastercard",
                        "Visa" => "Visa",
                        "JCB" => "JCB",
                        "Diners Club/ Carte Blanche" => "Diners Club/ Carte Blanche"
                    ),
                    array("class" => "required")
                ); ?>
                <span class="error with-margin ">Card Type is a required field</span>
            </p>

            <p>
                <label>Card Number:</label>
                <?php echo Form::input("card_num", null, array("class" => "required")); ?>
                <span class="error with-margin ">Card Number is a required field</span>
            </p>

            <p>
                <label>Exp Date:</label>
                <select name="exp_month" class="required">
                    <?php for ($i = 1; $i <= 12; $i++) { ?>
                        <option
                            value="<?php echo $i < 10 ? "0" . $i : $i; ?>"><?php echo $i < 10 ? "0" . $i : $i; ?></option>
                    <?php
                    }
                    $i = 0; ?>
                </select>
                <select name="exp_year" class="required">
                    <?php for ($i = date('Y'); $i <= date('Y') + 5; $i++) { ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php
                    }
                    $i = 0; ?>
                </select>
                <span class="error with-margin ">Expiry Date is a required field</span>
            </p>
            <p>
                <label>Security Code:</label>
                <?php echo Form::input("security_code", null, array("class" => "short required")); ?>
                <span class="explain">What is this?</span>
                <span class="error with-margin ">Security Code is a required field</span>
            </p>
        </div>

        <p class="submit">
            <span><input id="agree-to-terms" type="checkbox" name="agree" class="required"/> I have read and Agree to the Terms and Conditions</span>
            <?php echo Form::submit("upgrade_now", "Upgrade Now"); ?>
            <span class="error with-margin ">You must Agree to the Terms and Conditions</span>
        </p>

        <div id="how-it-works">
            <h2>How it Works</h2>
            <article>
                <header>By subscribing to a Dating Agent you will receive the benefits of having a Dating Agent</header>
                <p>
                <ul>
                    <li>Receive personal assistance in finding a match</li>
                    <li>Receive suggested matches from searches offline and online</li>
                    <li>Assistance in organizing dating packages</li>
                    <li>Personal dating advice </li>
                    <li>Personal dating survey questionnaire</li>
                </ul>
                </p>
                <p>Your dating agent subscription is for one month only. Your subscription will not auto renew after one month.
                    You will have to renew the Dating Agent service after one month if you wish to continue using the Dating Agent service.
                </p>
            </article>
        </div>
    <?php echo Form::close(); ?>


</div>