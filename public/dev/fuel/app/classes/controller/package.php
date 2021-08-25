<?php

class Controller_Package extends Controller_Base
{
    public $template = 'layout/template';

    public function before()
    {
        parent::before();

        $login_exception = array("");

        parent::check_permission($login_exception);
    }

    public function action_index()
    {
        if( ! \Auth\Auth::check())
            \Fuel\Core\Response::redirect('users/login');

        $view = View::forge('datingPackage/index');
        $latest_members = DB::select()
            ->from('profiles')
            ->where('id', '<>', $this->current_profile->id )
            ->order_by('created_at', 'desc')
            ->limit(8)->execute()->as_array();

		$view->profile_address = $this->current_profile->city;
        $view->profile_state = $this->current_profile->state;
        $view->latest_members = $latest_members;

        $view->set_global("active_page", "dating_packages");
        $view->set_global('page_js', 'dating_package/package.js');
        $view->set_global('page_css', 'datingPackage/datingPackage.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; Dating Packages';
        $this->template->content = $view;
    }

    public function action_view()
    {
        if( ! \Auth\Auth::check())
            \Fuel\Core\Response::redirect('users/login');

        $view = View::forge('datingPackage/view');
        $latest_members = DB::select()
            ->from('profiles')
            ->where('id', '<>', $this->current_profile->id )
            ->order_by('created_at', 'desc')
            ->limit(8)->execute()->as_array();
        $view->latest_members = $latest_members;
        $view->set_global("active_page", "dating_packages");
        $view->set_global('page_css', 'datingPackage/datingPackage_detail.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; Dating Package Details';
        $this->template->content = $view;
    }

}