<nav id="agent_nav">
    <div id="collection">
        Quick Links
    </div>
	<?php echo Html::anchor(Uri::create('profile/my_friends'), '<i class="fa fa-envelope"></i> My Clients'); ?>
    <?php echo Html::anchor(Uri::create('message/index'), 
    		'<i class="fa fa-envelope"></i> Messages'); ?>
    <?php echo Html::anchor(Uri::create('profile/my_favorites'), 
    		'<i class="fa fa-users"></i> My Referrals'); ?>
    <?php echo Html::anchor(Uri::create('event/my_events'), 
    		'<i class="fa fa-calendar"></i> My Events'); ?>
    
    <?php echo Html::anchor(Uri::create('agent#comments'), 
    		'<i class="fa fa-comments"></i> My Comments'); ?>
    <?php echo Html::anchor(Uri::create('profile/my_hellos'), 
    		'<i class="fa fa-comment"></i> My Hellos'); ?>
</nav>