<?php

class Controller_Admin extends Controller_Base {

    public $template = 'layout/template';

    public function before()
    {
        parent::before();

        $login_exception = array("");

        parent::check_permission($login_exception);
        
          $admin = Model_Users::query()
        ->where("user_id", $this->current_user->user_id)
        ->where("group_id", 5)
        ->get_one();
        if(!$admin){
        	\Fuel\Core\Response::redirect('pages/home');
        } 
    }
	

	 public function action_index() {
         $users = Model_Users::find('all');
         $messages = Model_message::find('all');
		//$Membershiptype=Model_membershiptype::find('all');
	      $fromusername = Auth::instance()->get_screen_name();
          $membershiptype=Model_membershiptype::find('all');
       
          $latest_members = DB::select()
                        ->from('profiles')
                        ->where('id', '<>', $this->current_profile->id)                        
                        ->order_by('created_at','desc')
                        ->limit(8)->execute()->as_array();
          if(Input::post()) {
              if ($_POST['submit1'] == 'Save')
              {
                    $members=$_POST['membertype'];
                    foreach($members as $key=> $val){
                        DB::update('profiles')
                              ->where('id',$key)
                              ->value('member_type_id',$val)
                              ->execute();
                    }
                    Response::redirect('admin/index');
              }
              if ($_POST['submit1'] == 'Delete')
              {
                if(!isset($_POST['list']))
                {
                    Session::set_flash("error", "Please select at least one member to delete.");
                }
                else
                {
                    $delete_members = $_POST['list'];
                    foreach($delete_members as $key=> $val){
                        DB::update('profiles')
                            ->where('id',$key)
                            ->value('disable',1)
                            ->execute();
                    }
                }
                Response::redirect('admin/index');
              }
          }

		  $base_url=\uri::base(false).'admin/index';
		 //Pagination::get('offset');
		  Pagination::set('per_page', 10);
	      $config = array(
              'pagination_url' => $base_url,
              'total_items'    => Model_profile::count(),
              'per_page'       => 10,
              'uri_segment'    => 3,
              'template' => array(
                  'wrapper_start' => '<div class="my-pagination"> ',
                  'wrapper_end' => ' </div>',
              ),
          );
	
	      $pagination = Pagination::forge('mypagination',$config);
	

    $data['profiles'] = Model_profile::query()->related('user')->where('user.group_id', '!=', '5')->where('disable','<>', 1)->order_by('created_at', 'DESC')
	                        //->rows_offset(\Pagination::get('offset'))
							 ->rows_offset($pagination->offset)
                            ->rows_limit(\Pagination::get('per_page'))
                            ->get();
	$data['pagination'] = $pagination->render();

		//$data['pagination'] = $pagination;
		
	
	$view = View::forge('admin/members_privilage',$data);	
    $membershiptype=Model_membershiptype::find('all');					
	    $view->membershiptype = $membershiptype;
        $view->latest_members = $latest_members;
        $view->set('users', $users);
        $view->set_global('page_css', 'admin/admin.css');
        $this->template->title = 'WHERE WE ALL MEET &raquo; Admin';
        $this->template->content = $view;
    }
    
    public function action_event_plan() {
    	
    	
    	$events = Model_Event::query()->order_by('created_at', 'DESC')->get();
    	$identifier = 0;
    	$view = View::forge('admin/event_plan');
    	$view->events = $events;
    	$view->identifier = $identifier;
    	
    	if(\Fuel\Core\Input::post())
    	{
    		$val = \Fuel\Core\Validation::forge();
    		$val->add('title', 'Event Name')->add_rule('required');
    		$val->add('long_description', 'Long Description')->add_rule('required');
    		$val->add('short_description', 'Short Description')->add_rule('required');
    		$val->add('organizers_details', 'Organizers Details')->add_rule('required');
    		//$val->add('state', 'State')->add_rule('required');
    		//$val->add('city', 'City')->add_rule('required');
    		//$val->add('venue', 'Address')->add_rule('required');
    		//$val->add('start_date', 'Time Zone')->add_rule('required');
    		//$val->add('zip', 'ZIP Code')->add_rule('required');
    		//$val->add('event_date', 'Event Start Date')->add_rule('required');
    		//$val->add('event_end_date', 'Event End Date')->add_rule('required');
    	
    		if( ! $val->run()){
    	
    			$view->set_global('page_css', 'admin/event_plan.css');
    			$this->template->title = 'The Man You Want &raquo; Admin';
    			$view->set_global('page_js', 'events/create.js');
    			$view->set_global('errors',$val->error());
    			$this->template->content = $view;
    	
    	
    		}
    		if($val->run()){
    		$event = Model_Event::forge();
    		$upload_file = Input::file("photo");
    		
    		if ($upload_file["size"] > 0) {
    	
    			$config = array(
    					'path' => DOCROOT . "uploads" . DIRECTORY_SEPARATOR .'events',
    					'auto_rename' => false,
    					'overwrite' => true,
    					'randomize' => true,
    					'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
    					'create_path' => true,
    					'path_chmod' => 0777,
    					'file_chmod' => 0777,
    			);
    	
    			\Fuel\Core\Upload::process($config);
    	
    			if (\Fuel\Core\Upload::is_valid()) {
    				\Fuel\Core\Upload::save();
    				$file = Upload::get_files(0);
    				$event->photo = $file['saved_as'];
    				$event->title = Input::post('title');
    				$event->organizers_details = Input::post('organizers_details');
    				$event->long_description = Input::post('long_description');
    				$event->short_description = Input::post('short_description');
    				$event->url = Input::post('url');
    				$event->state = Input::post('state');
    				$event->city = Input::post('city');
    				$event->venue = Input::post('venue');
    				$event->start_date = Input::post('event_date');
    				$event->time_zone = Input::post('start_date');
    				$event->start_time = Input::post('start_time_hour');
    				$event->end_time = Input::post('end_time_hour');
    				$event->zip = Input::post('zip');
    				$event->event_end_date = Input::post('event_end_date');
    				$event->start_pm_am = Input::post('start_pm_am');
    				$event->end_pm_am = Input::post('end_pm_am');
    	
    				if(isset($_POST['is_featured']))
    				{
    					$event->is_featured = 1;
    				} else{
    					$event->is_featured = 0;
    				}
    	
    				$filepath = $file['saved_to'] . $file['saved_as'];
    	
    				foreach (Model_Event::$thumbnails as $type => $dimensions) {
    					Image::load($filepath)->crop_resize($dimensions["width"], $dimensions["height"])->save($file['saved_to'] . $type . "_" . $file['saved_as']);
    				}
    	
    				if($event->save()){
    					Session::set_flash('success', 'You have successfully saved the event.');
    					\Fuel\Core\Response::redirect('admin/event_plan');
    				}
    	           
    				else
    				{
    					Session::set_flash('error', 'There is an error and the event is not saved. Please try again');
    				}
    				
    			}
    		}
    	}
     }
    	    	   

    	$view->set_global('page_js', 'events/create.js');
    	$view->set_global('page_css', 'admin/event_plan.css');
    	$this->template->title = 'WHERE WE ALL MEET &raquo; Admin';
    	$this->template->content = $view;
    	 
    }

    public function action_dating_packages() {
    	$events = Model_Datepackage::query()->order_by('created_at', 'DESC')->get();
    	$identifier = 0;
    	$view = View::forge('admin/dating_packages');
    	$view->events = $events;
    	$view->identifier = $identifier;
    	if(\Fuel\Core\Input::post())
    	{
    		$val = \Fuel\Core\Validation::forge();
    		$val->add('title', 'Venue Name')->add_rule('required');
    		$val->add('long_description', 'Dating Package Description')->add_rule('required');
    		$val->add('short_description', 'Venue Details')->add_rule('required');
    		//$val->add('state', 'State')->add_rule('required');
    		//$val->add('city', 'City')->add_rule('required');
    		//$val->add('event_venue', 'Address')->add_rule('required');
    		//$val->add('zip', 'ZIP Code')->add_rule('required');
    		$val->add('price', 'Price')->add_rule('required');
    		//$val->add('event_date', 'Dating Package Start date')->add_rule('required');
    		//$val->add('event_end_date', 'Dating Package End Date')->add_rule('required');
    		if( ! $val->run()){
    			 
    			$view->set_global('page_css', 'admin/event_plan.css');
    			$this->template->title = 'The Man You Want &raquo; Admin';
    			$view->set_global('page_js', 'events/create.js');
    			$view->set_global('errors',$val->error());
    			$this->template->content = $view;
    			 
    			 
    		}
    		if($val->run()){
    		$event = Model_Datepackage::forge();
    		$upload_file = Input::file("photo");
    	
    		if ($upload_file["size"] > 0) {
    			 
    			$config = array(
    					'path' => DOCROOT . "uploads" . DIRECTORY_SEPARATOR .'packages',
    					'auto_rename' => false,
    					'overwrite' => true,
    					'randomize' => true,
    					'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
    					'create_path' => true,
    					'path_chmod' => 0777,
    					'file_chmod' => 0777,
    			);
    			 
    			\Fuel\Core\Upload::process($config);
    			 
    			if (\Fuel\Core\Upload::is_valid()) {
    				\Fuel\Core\Upload::save();
    				$file = Upload::get_files(0);
    				$event->picture = $file['saved_as'];
    				$event->title = Input::post('title');
    				$event->short_description = Input::post('short_description');
    				$event->long_description = Input::post('long_description');
                    $event->url = Input::post('url');
    				$event->state = Input::post('state');
    				$event->city = Input::post('city');
    				$event->event_venue = Input::post('event_venue');
    				$event->event_date = Input::post('event_date');
    				$event->time_from = Input::post('time_from');
    				$event->time_to = Input::post('time_to');
    				$event->zip_code = Input::post('zip');
    				$event->price = Input::post('price');
    				$event->event_end_date = Input::post('event_end_date');
    				$event->start_pm_am = Input::post('start_pm_am');
    				$event->end_pm_am = Input::post('end_pm_am');
    				if(isset($_POST['is_featured']))
    				{
    					$event->is_featured = 1;
    				} else{
    					$event->is_featured = 0;
    				}
    				 
    				$filepath = $file['saved_to'] . $file['saved_as'];
    				    				
    			  foreach (Model_Datepackage::$thumbnails as $type => $dimensions) {
    					Image::load($filepath)->crop_resize($dimensions["width"], $dimensions["height"])->save($file['saved_to'] . $type . "_" . $file['saved_as']);
    				}
    				   				 
    				if($event->save()){
    					Session::set_flash('success', 'You have successfully saved the dating pakage.');
    					\Fuel\Core\Response::redirect('admin/dating_packages');
    				}
    	
    				else
    				{
    					Session::set_flash('error', 'There is an error and the dating package is not saved. Please try again');
    				}
    	          
    			}
    		}
    	}
    	} 
    	 
    	
    	$view->set_global('page_js', 'events/create.js');
    	$view->set_global('page_css', 'admin/event_plan.css');
    	$this->template->title = 'WHERE WE ALL MEET &raquo; Admin';
    	$this->template->content = $view;
    
    }
    
    public function action_manage_events() 
    {
    	if(! Input::post())
    		Response::redirect('Admin');   	
    	if(Input::post()) {
    	if ($_POST['action1'] == 'Edit') 
    	{
    		   			
    			if(!isset($_POST['eventids']))
    			{
    				
    				$events = Model_Event::query()->order_by('created_at', 'DESC')->get();
    				$identifier = 0;
    				$view = View::forge('admin/event_plan');
    				$view->events = $events;
    				$view->identifier = $identifier;
    				Session::set_flash("error", "Please select at least one event to edit.");
    			}
    		 else
    		   {
    		   	$edit_events = $_POST['eventids'];
    			foreach($edit_events as $key=> $val){
    				$editevents = Model_Event::query()
    				->where("id", $key)
    				->get_one();
    				 
    			}
    			$identifier = 1;
    			$events = Model_Event::query()->order_by('created_at', 'DESC')->get(); 
    			$view = View::forge('admin/event_plan');
    			$view->events = $events;
    			$view->identifier = $identifier;
    			$view->editevents = $editevents;
    	}  		
    		
    	}  
    	if ($_POST['action1'] == 'Delete') 
    	{
    		
    		if(!isset($_POST['eventids']))
    		{
    		
    			$events = Model_Event::query()->order_by('created_at', 'DESC')->get();
    			$identifier = 0;
    			$view = View::forge('admin/event_plan');
    			$view->events = $events;
    			$view->identifier = $identifier;
    			Session::set_flash("error", "Please select at least one event to delete.");
    		}
    		else
    		{
    			$delete_events = $_POST['eventids'];   	
    			 foreach($delete_events as $key=> $val){
    				DB::delete('events')
    				->where('id',$key)
    				->execute();
    			
    			 }
    			$events = Model_Event::query()->order_by('created_at', 'DESC')->get();
    			$identifier = 0;
    			$view = View::forge('admin/event_plan');
    			$view->events = $events;
    			$view->identifier = $identifier;    	  	 
         
    	}
      }
      
      $view->set_global('page_js', 'events/create.js');
      $view->set_global('page_css', 'admin/event_plan.css');
      $this->template->title = 'WHERE WE ALL MEET &raquo; Admin';
      $this->template->content = $view;
    }
   } 
    public function action_edit_events()
    {
    	if(! Input::post())
    		Response::redirect('Admin');    	
    	if(Input::post()) {    	
    	$identifier = 0;
    	$view = View::forge('admin/event_plan');
    	$events = Model_Event::query()->order_by('created_at', 'DESC')->get();
    	  		   
    			$val = \Fuel\Core\Validation::forge();
    			$val->add('title', 'Event Name')->add_rule('required');
    			$val->add('long_description', 'Long Description')->add_rule('required');
    			$val->add('short_description', 'Short Description')->add_rule('required');
    			$val->add('url', 'URL')->add_rule('required');
    			$val->add('organizers_details', 'Organizers Details')->add_rule('required');
    			$val->add('state', 'State')->add_rule('required');
    			$val->add('city', 'City')->add_rule('required');
    			$val->add('venue', 'Address')->add_rule('required');
    			$val->add('start_date', 'Time Zone')->add_rule('required');
    			$val->add('zip', 'ZIP Code')->add_rule('required');
    			$val->add('event_date', 'Event Start Date')->add_rule('required');
    		    $val->add('event_end_date', 'Event End Date')->add_rule('required');
    			
    			if( ! $val->run()){
    				$view = View::forge('admin/event_plan');
    				$view->events = $events;
    				$view->identifier = $identifier;
    				$view->set_global('page_css', 'admin/event_plan.css');
    				$this->template->title = 'The Man You Want &raquo; Admin';
    				$view->set_global('page_js', 'events/create.js');
    				$view->set_global('errors',$val->error());
    				$this->template->content = $view;
    				 
    				 
    			}
    			if($val->run()){
    				$event = Model_Event::find($_POST['idholder']);   
    				$view = View::forge('admin/event_plan');
    				$view->events = $events;
    				$view->identifier = $identifier;
    				$upload_file = Input::file("photo");
    				
    				if ($upload_file["size"] > 0) {
    					 
    					$config = array(
    							'path' => DOCROOT . "uploads" . DIRECTORY_SEPARATOR .'events',
    							'auto_rename' => false,
    							'overwrite' => true,
    							'randomize' => true,
    							'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
    							'create_path' => true,
    							'path_chmod' => 0777,
    							'file_chmod' => 0777,
    					);
    					 
    					\Fuel\Core\Upload::process($config);
    					 
    					if (\Fuel\Core\Upload::is_valid()) {
    						\Fuel\Core\Upload::save();
    						$file = Upload::get_files(0);
    						$event->photo = $file['saved_as'];
    						$filepath = $file['saved_to'] . $file['saved_as'];
    						 
    						foreach (Model_Event::$thumbnails as $type => $dimensions) {
    							Image::load($filepath)->crop_resize($dimensions["width"], $dimensions["height"])->save($file['saved_to'] . $type . "_" . $file['saved_as']);
    						}
    					}
    				}
    						$event->title = Input::post('title');
    						$event->organizers_details = Input::post('organizers_details');
    						$event->long_description = Input::post('long_description');
    						$event->short_description = Input::post('short_description');
    						$event->url = Input::post('url');
    						$event->state = Input::post('state');
    						$event->city = Input::post('city');
    						$event->venue = Input::post('venue');
    						$event->start_date = Input::post('event_date');
    						$event->time_zone = Input::post('start_date');
    						$event->start_time = Input::post('start_time_hour');
    						$event->end_time = Input::post('end_time_hour');
    						$event->zip = Input::post('zip');
    						$event->event_end_date = Input::post('event_end_date');
    						$event->start_pm_am = Input::post('start_pm_am');
    						$event->end_pm_am = Input::post('end_pm_am');
    						if(isset($_POST['is_featured']))
    						{
    							$event->is_featured = 1;
    						} else{
    							$event->is_featured = 0;
    						}
    						
    					   						
    						if($event->save()){
    							Session::set_flash('success', 'You have successfully saved the event.');
    							 						
    						}
    			
    						else
    						{
    							Session::set_flash('error', 'There is an error and the event is not saved. Please try again');
    						}
    			
    					
    			}
					      			
    		} 
    	  		
    		$view->set_global('page_js', 'events/create.js');
    		$view->set_global('page_css', 'admin/event_plan.css');
    		$this->template->title = 'WHERE WE ALL MEET &raquo; Admin';
    		$this->template->content = $view;
    	
    }

    public function action_manage_packages()
    {
    	if(! Input::post())
    		Response::redirect('Admin');
    	
    	if(Input::post()) {
    	if ($_POST['action1'] == 'Edit')
    	{
    		if(!isset($_POST['eventids']))
    		{
    		
    			$events = Model_Datepackage::query()->order_by('created_at', 'DESC')->get();
    			$identifier = 0;
    			$view = View::forge('admin/dating_packages');
    			$view->events = $events;
    			$view->identifier = $identifier;
    			Session::set_flash("error", "Please select at least one dating package to edit.");
    		}
    		else
    		{
    			$edit_events = $_POST['eventids'];
    			foreach($edit_events as $key=> $val){
    				$editevents = Model_Datepackage::query()
    				->where("id", $key)
    				->get_one();
    					
    			}
    			$identifier = 1;
    			$events = Model_Datepackage::query()->order_by('created_at', 'DESC')->get();
    			$view = View::forge('admin/dating_packages');
    			$view->events = $events;
    			$view->identifier = $identifier;
    			$view->editevents = $editevents;
    			   
    		}
    	}
    	if ($_POST['action1'] == 'Delete')
    	{
    		
    		if(!isset($_POST['eventids']))
    		{
    		
    			$events = Model_Datepackage::query()->order_by('created_at', 'DESC')->get();
    			$identifier = 0;
    			$view = View::forge('admin/dating_packages');
    			$view->events = $events;
    			$view->identifier = $identifier;
    			Session::set_flash("error", "Please select at least one dating package to delete.");
    		}
    		else
    		{
    			$delete_events = $_POST['eventids'];
    			foreach($delete_events as $key=> $val){
    				DB::delete('datepackages')
    				->where('id',$key)
    				->execute();
    				 
    			}
    			$events = Model_Datepackage::query()->order_by('created_at', 'DESC')->get();
    			$identifier = 0;
    			$view = View::forge('admin/dating_packages');
    			$view->events = $events;
    			$view->identifier = $identifier;
    			
    	}
      }
     $view->set_global('page_js', 'events/create.js');
     $view->set_global('page_css', 'admin/event_plan.css');
     $this->template->title = 'WHERE WE ALL MEET &raquo; Admin';
     $this->template->content = $view;
    }
    }
    
    public function action_edit_packages()
    {
    	if(! Input::post())
    		Response::redirect('Admin');   	
    	if(Input::post()) {
    		$identifier = 0;
    	$events = Model_Datepackage::query()->order_by('created_at', 'DESC')->get();   	    		   	
    		$val = \Fuel\Core\Validation::forge();
    		$val->add('title', 'Venue Name')->add_rule('required');
    		$val->add('long_description', 'Dating Package Description')->add_rule('required');
    		$val->add('short_description', 'Venue Details')->add_rule('required');
    		$val->add('state', 'State')->add_rule('required');
    		$val->add('city', 'City')->add_rule('required');
    		//$val->add('event_venue', 'Address')->add_rule('required');
    		//$val->add('zip', 'ZIP Code')->add_rule('required');
    		$val->add('price', 'Price')->add_rule('required');
    		$val->add('event_date', 'Dating Package Start date')->add_rule('required');
    		//$val->add('event_end_date', 'Dating Package end date')->add_rule('required');
    
    		if( ! $val->run()){
    			$view = View::forge('admin/dating_packages');
    			$view->events = $events;
    			$view->identifier = $identifier;
    			$view->set_global('page_css', 'admin/event_plan.css');
    			$this->template->title = 'The Man You Want &raquo; Admin';
    			$view->set_global('page_js', 'events/create.js');
    			$view->set_global('errors',$val->error());
    			$this->template->content = $view;
    				
    				
    		}
    		if($val->run()){    			
    			$view = View::forge('admin/dating_packages');
    			$view->events = $events;
    			$view->identifier = $identifier;
    			$event = Model_Datepackage::find($_POST['idholder']);
    			$upload_file = Input::file("photo");
    
    			if ($upload_file["size"] > 0) {
    
    				$config = array(
    						'path' => DOCROOT . "uploads" . DIRECTORY_SEPARATOR .'packages',
    						'auto_rename' => false,
    						'overwrite' => true,
    						'randomize' => true,
    						'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
    						'create_path' => true,
    						'path_chmod' => 0777,
    						'file_chmod' => 0777,
    				);
    
    				\Fuel\Core\Upload::process($config);
    
    				if (\Fuel\Core\Upload::is_valid()) {
    					\Fuel\Core\Upload::save();
    					$file = Upload::get_files(0);
    					$event->picture = $file['saved_as'];
    					$filepath = $file['saved_to'] . $file['saved_as'];
    						
    					foreach (Model_Datepackage::$thumbnails as $type => $dimensions) {
    						Image::load($filepath)->crop_resize($dimensions["width"], $dimensions["height"])->save($file['saved_to'] . $type . "_" . $file['saved_as']);
    					}
    				}
    			}
    			    $event->title = Input::post('title');
    				$event->short_description = Input::post('short_description');
    				$event->long_description = Input::post('long_description');
                    $event->url = Input::post('url');
    				$event->state = Input::post('state');
    				$event->city = Input::post('city');
    				$event->event_venue = Input::post('event_venue');
    				$event->event_date = Input::post('event_date');
    				$event->time_from = Input::post('time_from');
    				$event->time_to = Input::post('time_to');
    				$event->zip_code = Input::post('zip');
    				$event->price = Input::post('price');
    				$event->event_end_date = Input::post('event_end_date');
    				$event->start_pm_am = Input::post('start_pm_am');
    				$event->end_pm_am = Input::post('end_pm_am');
    			if(isset($_POST['is_featured']))
    			{
    				$event->is_featured = 1;
    			} else{
    				$event->is_featured = 0;
    			}
    
    
    			if($event->save()){
    				Session::set_flash('success', 'You have successfully saved the dating pakage.');
    
    			}
    			 
    			else
    			{
    				Session::set_flash('error', 'There is an error and the dating package is not saved. Please try again');
    			}
    			 
    				
    		}
    
    	}   	  	
    	$view->set_global('page_js', 'events/create.js');
    	$view->set_global('page_css', 'admin/event_plan.css');
    	$this->template->title = 'WHERE WE ALL MEET &raquo; Admin';
    	$this->template->content = $view;
    	 
    }
    
    
    
    
	
}