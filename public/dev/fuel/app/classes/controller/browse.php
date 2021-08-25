<?php
session_start();
use \Model\Quicksearch;
class Controller_Browse extends Controller_Base {
    public $template = 'layout/template';

    public function before()
    {
        parent::before();

        $login_exception = array("");

        parent::check_permission($login_exception);
    }

    public function action_index() {
        $identifier = 0;
        $refine = 0;
        $username = Auth::get_screen_name();
        $password = Auth::get('password');


        $default_members = Quicksearch::get_default_members($username, $password);
        $online_members = Quicksearch::get_online_members($username, $password);
        $view = View::forge('browse_friend/index');
        $view->state_list = Model_State::find('all');
        $view->occupation_list = Model_Occupation::find('all');
        $view->body_type = Model_Bodytype::find('all');
        $view->ethnicity_list = Model_Ethnicity::find('all');
        $view->religion_list = Model_Religion::find('all');

        $view->online_members  =  $online_members;
        $view->result  =  $default_members;

        $view->set('identifier',$identifier, false);
        $view->set('refine',$refine, false);
        $view->set_global("active_page", "browse");
        $view->set_global('page_js', 'browse/member.js');
        $view->set_global('page_css', 'browse_friend/browse_friend.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; Browse';
        $this->template->content = $view;
    }

    public function action_browse_members()
    {     	
    	if(! Input::post()){
    		if(Session::get('search_form_post')) {
                $post = Session::get('search_form_post');
            }
            else {
                Response::redirect('Browse');
            }
        }
        else {
            $post = Input::post();
            Session::set('search_form_post', $post);
        }
    	$username = Auth::get_screen_name();
    	$password = Auth::get('password');
        $online_members = Quicksearch::get_online_members($username, $password);


        $view_all_result = true;


        $view = \View::forge('browse_friend/index');

        if(isset($post["find_friend_button"])){
            $search_param = array(
                'email' => $post['email'],
                'first_name' => $post['first_name'],
                'last_name' => $post['last_name'],
                'view_all_result' => $view_all_result,
            );

            $result = Quicksearch::browse_member_friends($search_param);

            $view->set('email',$post['email']);
            $view->set('first_name',$post['first_name']);
            $view->set('last_name',$post['last_name']);
        }
        else {
            $birth_date_from = Model_Profile::get_birth_date_from_age($post['age-range-2']);
            $birth_date_to = Model_Profile::get_birth_date_from_age($post['age-range-1']);

            $photo = isset($post['photo']) ? 1 : 0;
            $online = isset($post['online']) ? 1: 0;

            if(isset($post["quick_search_button"])){
                $post['body'] = "";
                $post['ethnicity'] = "";
                $post['occupation'] = "";
                $post['faith'] = "";
                $post['kids'] = "";
            }

            $search_param = array(
                'seeking_gender_id' => $post['seeking']== 'Male'? 1 : 2,
                'birth_date_from' => $birth_date_from,
                'birth_date_to' => $birth_date_to,
                'state' => $post['state'],
                'key_words' => $post['keywords'],
                'online_members' => $online,
                'body_type_id' => isset($post["body"]) ? $post["body"] : '',
                'ethnicity_id' => isset($post["ethnicity"]) ? $post["ethnicity"] : '',
                'occupation_id' => isset($post["occupation"]) ? $post["occupation"] : '',
                'faith_id' => isset($post["faith"]) ? $post["faith"] : '',
                'kids' => isset($post["kids"]) ? $post["kids"] : '',
                'view_all_result' => $view_all_result,
            );

            $result = Quicksearch::browse_members($search_param);

            $view->set('Iam',$post['Iam']);
            $view->set('seeking',$post['seeking']);
            $view->set('age_from',$post['age-range-1']);
            $view->set('age_to',$post['age-range-2']);
            $view->set('state',$post['state']);
            $view->set('keyword',$post['keywords']);
            $view->set('photo_selected',$photo);
            $view->set('online_selected',$online);

            $view->set('body',isset($post['body']) ? $post['body'] : '');
            $view->set('ethnicity',isset($post['ethnicity']) ? $post['ethnicity'] : '');
            $view->set('occupation',isset($post['occupation']) ? $post['occupation'] : '');
            $view->set('faith',isset($post['faith']) ? $post['faith'] : '');
            $view->set('kids',isset($post['kids']) ? $post['kids']:'');
        }

        $view->online_members  =  $online_members;
        $view->result  =  $result;
        $view->state_list = Model_State::find('all');
        $view->occupation_list = Model_Occupation::find('all');
        $view->body_type = Model_Bodytype::find('all');
        $view->ethnicity_list = Model_Ethnicity::find('all');
        $view->religion_list = Model_Religion::find('all');

    	$view->set_global("active_page", "browse");
    	$view->set_global('page_js', 'browse/member.js');
        $view->set_global('page_css', 'browse_friend/browse_friend.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; Do Browse';
        $this->template->content = $view;
    }

}