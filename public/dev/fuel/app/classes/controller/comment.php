<?php

use Fuel\Core\Response;

use Fuel\Core\Fuel;

class Controller_Comment extends Controller_Base
{
    public $template = 'layout/template';

    public function before()
    {
        parent::before();

        $login_exception = array("");

        parent::check_permission($login_exception);
    }
    
    public function action_create()
    {
       	if( ! \Fuel\Core\Input::is_ajax() or ! Input::post()){
    		\Fuel\Core\Response::redirect('pages/404');
    	}
    	$comment = Model_Comment::forge();	
    	
    	$comment->comment = trim(Input::post('message'));
    	$comment->comment_to = Input::post('comment_to'); 	
    	$comment->comment_from = $this->current_profile->id;
        $comment->is_deleted = false;
    	if(null !== Input::post('parent_comment_id')){
    		$comment->parent_comment_id = Input::post('parent_comment_id');
    	}
    	$comment->save();
    	
    	$comment_by = Model_Profile::find($comment->comment_from);
    	$comment_view = render('comment/create', array('comment'=>$comment, 'comment_by'=>$comment_by));
    	
    	$response = Response::forge();
    	$response->body(json_encode(array('status' => true, 
    			'comment' => $comment_view,
    			'parent_comment_id' => $comment->parent_comment_id)));
    	
    	return $response;
    	
    	
    }

    public function action_remove_comment($comment_id)
    {
        if( ! Input::is_ajax())
            \Fuel\Core\Response::redirect('page/404');

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
}