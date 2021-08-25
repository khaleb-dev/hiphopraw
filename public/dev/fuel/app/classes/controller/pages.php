<?php

class Controller_Pages extends Controller_Base 
{
	public $template = 'layout/template';
    
    public function action_home()
    {
        if(\Auth\Auth::check())
        {
            Response::redirect("profile/dashboard/");
        }
        else
        {
            $state = Model_State::find('all');
            $view = View::forge('pages/home');
            $view->state = $state;
            $view->set_global("home_page", true);
            $view->set_global('page_js', 'pages/custom.js');
            $view->set_global('page_css', 'pages/home.css');
        }


        $view->set_global("active_page", "home");


        $view->genders = Model_Gender::find('all');
        $this->template->title = 'WHERE WE ALL MEET  &raquo; Home';
        $this->template->content = $view; 
    }

    public function action_404()
    {
        $view = View::forge('pages/404');

        $this->template->title = 'WHERE WE ALL MEET  &raquo; Page Not Found!';
        $this->template->content = $view;
    }
}
