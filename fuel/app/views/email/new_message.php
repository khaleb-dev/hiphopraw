<div id="middle">
    <div id="content" class="full">
        <p>
            <?php echo 'You have a new Message on hiphopraw'; ?>    

        </p>
        <p>  <?php
                $today = date("F j, Y, g:i a");
                echo "This message was sent to you on ".$today;
                ?>   
        </p>
        <p>
        	<?php echo $message; ?>  
        	
        </p>
        <p>
        	<?php echo Html::anchor(Uri::create("users/login"), "Click here to read your Message on Hiphopraw!") ?>
        	
        </p>
    </div>
</div>