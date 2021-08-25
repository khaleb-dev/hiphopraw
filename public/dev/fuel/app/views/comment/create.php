<?php if( ! is_null($comment->parent_comment_id)):?>
<div class="separate"></div>
<?php endif;?>
<div class="<?php echo is_null($comment->parent_comment_id)? 'comment" id="'.$comment->id.'':'reply' ;  ?>">
<?php echo Html::anchor(Uri::create('profile/public_profile/'.$comment_by->id), Html::img(Model_Profile::get_picture($comment_by->picture,
    $comment_by->user_id, "members_medium")));?>
    <?php if(is_null($comment->parent_comment_id)):?>
    <span class="comment-info"><?php echo $comment_by->first_name.' '.$comment_by->last_name ?> 
    posted a comment on <?php echo date('M d, Y', $comment_by->created_at)?>

    </span>
    <?php endif;?>
    <?php
    if(Model_Profile::is_dating_agent($current_profile->id)):?>
        <a title="Remove" id="remove-comment-<?php echo $comment->id?>" class="delete remove-comment" href="<?php echo \Fuel\Core\Uri::create('comment/remove_comment/'.$comment->id)?>">
            <i class="fa fa-times-circle-o"></i>
        </a>
    <?php
    endif;
    ?>
    <p class="content"><?php echo $comment->comment ?></p>
</div>
                	
<?php if(is_null($comment->parent_comment_id)):?>
<div class="separate"></div>
<?php endif;?>