<?php

class Controller_Comments extends Controller_Base {

    public $template = 'layout/user-template';

    public function before() {
        parent::before();

        $login_exception = array("show");

        parent::check_permission($login_exception);
    }

    public function action_index($user_id) {
        $view = View::forge('comments/index');

        $result = DB::query("select id from videokes where user_id = $user_id")->as_assoc()->execute();
        $vids = $result->as_array('id', 'id');

        if ($user = Model_User::find($user_id) && $result->count() > 0) {

            $comments = Model_Comment::query()->where("videoke_id", "IN", $vids);

           /*   // Configure the pagination
            $pagination = \Pagination::forge('pagination', array(
                'pagination_url' => \Uri::base(false).'comments/index/'. $this->current_user->id,
                'total_items' => $comments->count(),
                'per_page' => 10,
                'uri_segment' => 4,
                'num_links' => 5,
            )); */

           // $view->pagination = $pagination;
            $view->comments = $comments
                                ->order_by('created_at', 'desc')
                               // ->offset($pagination->offset)
                              //  ->limit($pagination->per_page)
                                ->get();
        } else {
            Session::set_flash("error", "Could not find the user comments!");
            Response::redirect("users/show/" . $this->current_user->id);
        }

        $view->set_global('page_css', 'comments/index.css');
        $view->set_global('page_js', 'comments/index.js');

        $this->template->title = 'Hip Hop Raw &raquo; Comments ';
        $this->template->content = $view;
    }

    /* public function action_create($user_id = null) {
        $response = Response::forge();
        if (Input::method() !== 'POST' or !Input::is_ajax() or $this->current_user->id !== $user_id) {
            return $response->set_status(400);
        }

        $val = Validation::forge();

        $val->add('detail', 'Comment')
                ->add_rule('required');

        if ($val->run()) {
            $post = Input::post();
            $post["user_id"] = $user_id;
            $comment = Model_Comment::forge($post);
            $comment->save();
            $response->body(json_encode(array(
                'status' => true,
                'user_id' => $comment->user_id,
                'comment_id' => $comment->id,
                'detail' => $comment->detail,
            )));
        } else {
            $response->body(json_encode(array(
                'status' => false,
                'validation' => array(
                    'detail' => $val->error('detail')->get_message()
                )
            )));
        }

        return $response;
    } */

    public function action_show($comment_id) {
        $response = Response::forge();
         if (Input::method() !== 'GET' or !Input::is_ajax()) {
            return $response->set_status(400);
        } 

        if ($comment = Model_Comment::find($comment_id)) {
        	$videoke = Model_Videoke::find($comment->videoke_id);
            $response->body(json_encode(array(
                'status' => true,
                'html' => View::forge('videokes/partials/single_comment', array("comment" => $comment,"videoke" => $videoke))->render(),
            )));
        } else {
            return $response->set_status(500);
        }

        return $response;
    }
    
    public function action_show_comment_reply($reply_id) {
    	$response = Response::forge();
    	if (Input::method() !== 'GET' or !Input::is_ajax()) {
    		return $response->set_status(400);
    	}
    
    	if ($comment = Model_Comment::find($reply_id)) {
    		//$videoke = Model_Videoke::find($comment->videoke_id);
    		$response->body(json_encode(array(
    				'status' => true,
    				'html' => View::forge('videokes/partials/single_reply', array("reply" => $comment))->render(),
    		)));
    	} else {
    		return $response->set_status(500);
    	}
    
    	return $response;
    }

    public function action_destroy($user_id, $comment_id) {
        $response = Response::forge();
        if (Input::method() !== 'DELETE' or !Input::is_ajax() or $this->current_user->id !== $user_id) {
            return $response->set_status(400);
        }

        if ($comment = Model_Comment::find($comment_id)) {
            $comment->delete();
            $response->body(json_encode(array(
                'status' => ture,
                'message' => "Your comment has been deleted."
            )));
        } else {
            return $response->set_status(500);
        }

        return $response;
    }
    public function action_create()
    {
    	 $this->template="";
    	/* if( ! \Fuel\Core\Input::is_ajax() or ! Input::post()){
    		\Fuel\Core\Response::redirect('pages/404');
    	} */
    	 
    	 if (Input::method() !== 'POST' or !Input::is_ajax()) {
    	 	\Fuel\Core\Response::redirect('pages/404');
    	 }
    	 
    	 $val = Validation::forge();   	    	 
    	 $val->add('message', 'Comment')
    	 ->add_rule('required');
    	 if ($val->run()) { 
    	$comment = Model_Comment::forge();
    	 
    	$comment->detail = trim(Input::post('message'));
    	$comment->videoke_id = Input::post('comment_to');
    	$comment->user_id = $this->current_user->id;
    	$comment->is_deleted = false;
    	$comment->parent_comment_id = 0;
      if($comment->save()){
    	$response=array();
    	$response["status"]= true;
    	$response["heading"]= "success";
    	$response["description"]="Your comment is successfully posted ";
    	$response["user_id"]= $comment->user_id;
    	$response["comment_id"]= $comment->id;
    	$response["detail"]= $comment->detail;
      }
      else{
      	$response=array();
      	$response["status"]= false;
      	$response["heading"]= "error";
      	$response["description"]="Your comment is not posted ";
      	$response["user_id"]= $comment->user_id;
      	$response["comment_id"]= $comment->id;
      	$response["detail"]= $comment->detail;
      }
    }
    else{
    	$response=array();
    	$response["status"]= false;
    	$response["heading"]= "error";
    	$response["description"]="Please type a comment";
    }
    echo json_encode($response);
    }
    public function action_replay()
    {
    	$this->template="";
    	/* if( ! \Fuel\Core\Input::is_ajax() or ! Input::post()){
    	 \Fuel\Core\Response::redirect('pages/404');
    	} */
    	$comment = Model_Comment::forge();
    
    	$comment->detail = trim(Input::post('message'));
    	$comment->videoke_id = Input::post('comment_to');
    	$comment->user_id = $this->current_user->id;
    	$comment->is_deleted = false;
    	$comment->parent_comment_id = Input::post('parent_comment_id');

    	$comment->save();
    
    	$comment_by = Model_User::find($comment->user_id);
    	Response::redirect(Uri::create("users/home_login/".$this->current_user->id));
    }
    public function action_home_replay()
    {
    	$this->template="";
    	/* if( ! \Fuel\Core\Input::is_ajax() or ! Input::post()){
    	 \Fuel\Core\Response::redirect('pages/404');
    	} */
    	$comment = Model_Comment::forge();
    
    	$comment->detail = trim(Input::post('message'));
    	$comment->videoke_id = Input::post('comment_to');
    	$comment->user_id = $this->current_user->id;
    	$comment->is_deleted = false;
    	$comment->parent_comment_id = Input::post('parent_comment_id');
    
    	$comment->save();
    
    	$comment_by = Model_User::find($comment->user_id);
    	Response::redirect(Uri::create("users/comments/".$this->current_user->id));
    }
    public function action_remove($comment_id)
    {
    	/* if( ! Input::is_ajax())
    		\Fuel\Core\Response::redirect('page/404'); */
    
    	$response = \Fuel\Core\Response::forge();
    	$comment = Model_Comment::find($comment_id);
    	$comment->is_deleted = true;
    	if($comment->save())
    	{
    		$response->body(json_encode(
    				array('status' => true)
    		));
    
    		return $response;
    	}
    
    	$response->body(json_encode(
    			array('status' => false)
    	));
    
    	return false;
    }
    public function action_show_replay($user_id)
    {
    	$this->template="";
    	/* if( ! \Fuel\Core\Input::is_ajax() or ! Input::post()){
    	 \Fuel\Core\Response::redirect('pages/404');
    	} */
    	$comment = Model_Comment::forge();
    
    	$comment->detail = trim(Input::post('message'));
    	$comment->videoke_id = Input::post('comment_to');
    	$comment->user_id = $this->current_user->id;
    	$comment->is_deleted = false;
    	$comment->parent_comment_id = Input::post('parent_comment_id');
    
    	$comment->save();
    
    	$comment_by = Model_User::find($comment->user_id);
    	Response::redirect(Uri::create("users/comment/".$user_id));
    }
    public function action_video_replay()
    {
    	$this->template="";
    	 /* if (Input::method() !== 'POST' or !Input::is_ajax()) {
    	 	\Fuel\Core\Response::redirect('pages/404');
    	 } */
    	 $val = Validation::forge();
    	 $val->add('message', 'Reply')
    	 ->add_rule('required');
    	 if ($val->run()) {
    	$comment = Model_Comment::forge();
    
    	$comment->detail = trim(Input::post('message'));
    	$comment->videoke_id = Input::post('comment_to');
    	$comment->user_id = $this->current_user->id;
    	$comment->is_deleted = false;
    	$comment->parent_comment_id = Input::post('parent_comment_id');
    
    	if($comment->save()){
    		$response=array();
    		$response["status"]= true;
    		$response["heading"]= "success";
    		$response["description"]="Your reply is successfully posted ";
    		$response["user_id"]= $comment->user_id;
    		$response["comment_id"]= $comment->id;
    		$response["detail"]= $comment->detail;
    		$response["parent_comment_id"]= $comment->parent_comment_id;
    	}
    	else{
    		$response=array();
    		$response["status"]= false;
    		$response["heading"]= "error";
    		$response["description"]="Your reply is not posted ";
    		$response["user_id"]= $comment->user_id;
    		$response["comment_id"]= $comment->id;
    		$response["detail"]= $comment->detail;
    		$response["parent_comment_id"]= $comment->parent_comment_id;
    	}
    	}
    	else{
    		$response=array();
    		$response["status"]= false;
    		$response["heading"]= "error";
    		$response["description"]="Please type a reply";
    	}
    	echo json_encode($response);
    	}

}
