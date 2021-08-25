<div id="middle">
    <div id="content" class="full">
        <h1><?php echo $current_user->username ?>
            sent RSVP to <?php echo $event->title ?> event!
        </h1>
        <p>
            Click <a href="<?php Uri::create('event/view/'.$event->slug) ?>">here</a> to see the event.
        </p>
    </div>
</div>
