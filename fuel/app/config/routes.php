<?php
return array(
	//'_root_'  => 'index/index',
	'_root_'  => 'pages/home',  // The default route
	'_404_'   => 'pages/404',    // The main 404 route
	'_500_'   => 'pages/404',
	
	'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
		
    'login' => 'users/login',
    'logout' => 'users/logout',
    'sign_up' => 'users/sign_up',
    'model_sign_up' => 'pages/model_landing',
    'artist_sign_up' => 'pages/artist_landing',
    'members/(:num)' => 'users/index/$1',
    'members' => 'users/index',
    'build_profile' => 'users/edit',
    'edit_profile' => 'users/edit',
    'hhrnews' => 'pages/hhrnews',
	'home' => 'pages/home',
	'about_us' => 'pages/about_us',
	'videos' => 'pages/videos',
	'models' => 'pages/models',
	'contest_winners'=> 'pages/contest_winners',
	'contest/:contest_id' => 'pages/contest',
	'contest' => 'pages/contest',


	//'contest' => 'contest/index',
		
	'contest' => 'pages/contest',	
	'contest_winners' => 'pages/contest_winners',
	'contest_how_to' => 'pages/contest_how_to',
	'contest_battle' => 'pages/contest_battle',
	'contact_us' => 'pages/contact_us',

	
	//'friends' => 'pages/friends',

	'my_profile' => 'pages/my_profile',
	'my_friends' => 'pages/my_friends',
	'my_videokes' => 'pages/my_videokes',
	'my_comments' => 'pages/my_comments',
	'my_messages' => 'pages/my_messages',
	'my_message' => 'pages/my_message',

		
	'admin/contests/add' => 'admin/contests_add',
	'admin/contests/history' => 'admin/contests_history',
		
	'my_contests/joined' => 'pages/my_contests',
	'my_contests/join/:contest_id' => 'pages/my_contests',
	'my_contests' =>'pages/my_contests',
	'settings' => 'pages/settings',

	
	'invite' => 'invites/send',

	'browse/(:num)' => 'videokes/browse/$1',
	'browse' => 'videokes/browse',
	'upload_videoke' => 'videokes/new',
	
    // For /users/1/comments you can use the route
    // 'users/(:num)/comments' => 'comments/index/$1',
    // and in your comments controller use
    // public function index($userid = null) { }
    // For links like /users/1/comments/new you can use the route
    // 'users/(:num)/comments/(:any)' => 'comments/$2/$1',
    // and in your comments controller use
    // public function new($userid = null) { }
    // For the others, like /users/1/comments/1/show, you can use the route
    // 'users/(:num)/comments/(:num)/(:any)' => 'comments/$3/$1/$2',
    // and in your comments controller use
    // public function show($userid = null, $commentid = null) { }
    // Define them with the longest one first.
    
   // 'users/(:num)/comments/(:num)/(:any)' => 'comments/$3/$1/$2',
    //'users/(:num)/comments/(:any)' => 'comments/$2/$1',
    
    /* 'users/(:num)/messages/list/(:any)/(:num)' => 'messages/index/$2/$1/$3',
    'users/(:num)/messages/list/(:any)' => 'messages/index/$2/$1',
    'users/(:num)/messages/(:any)/(:num)' => 'messages/$2/$3/$1',
    'users/(:num)/messages/(:any)' => 'messages/$2/$1', */
		

		
    'users/(:num)/friends/index/(:num)' => 'friendships/index/$1/$2',
    
);
