<?php
    $reported_user = Model_Users::find($reported_profile->user_id);
?>
<div id="middle">
    <div id="content" class="full">
        <h1><?php echo $current_user->username ?>
            has reported a violation!
        </h1>
        <h2>Reported Profile</h2>
        <p>
            Full Name: <?php
                echo $reported_profile->first_name.' '.$reported_profile->last_name;
            ?><br />
            Email Address: <?php
                echo $reported_user->email;
            ?><br />
        </p>
        <h2>Message</h2>
        <p>
            <?php echo $message; ?>
        </p>
    </div>
</div>
