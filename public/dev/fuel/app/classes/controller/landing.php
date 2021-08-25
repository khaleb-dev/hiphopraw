<?php

class Controller_Landing extends Controller_Template
{
	public $template = 'layout/template';
    
    public function action_vacation()
    {
        $state = Model_State::find('all');
        $view = View::forge('landing/vacation');
        $view->state = $state;
        $view->set_global("home_page", true);
        $view->set_global('page_css', 'landing/vacation.css');


        $view->set_global("active_page", "home");


        $view->genders = Model_Gender::find('all');
        $this->template->title = 'WHERE WE ALL MEET  &raquo; Landing';
        $this->template->content = $view; 
    }

    public function action_club()
    {
        $state = Model_State::find('all');
        $view = View::forge('landing/club');
        $view->state = $state;
        $view->set_global("home_page", true);
        $view->set_global('page_css', 'landing/club.css');


        $view->set_global("active_page", "home");


        $view->genders = Model_Gender::find('all');
        $this->template->title = 'WHERE WE ALL MEET  &raquo; Landing';
        $this->template->content = $view;
    }

}
