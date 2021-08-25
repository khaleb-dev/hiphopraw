<?php

class Controller_Index extends Controller_Base {

	public $template = 'layout/index';	

    public function before() {
        parent::before();

        $login_exception = array("*");

        parent::check_permission($login_exception);
    }

		public function action_index() {
		
        $view = View::forge('pages/index');

        $view->set_global("active_page", "home");
        $view->set_global('page_css', 'pages/index.css');
        //$view->set_global('page_js', 'pages/home.js');

        $this->template->title = 'Hiphopraw &raquo; index';
        $this->template->content = $view;
    }
}