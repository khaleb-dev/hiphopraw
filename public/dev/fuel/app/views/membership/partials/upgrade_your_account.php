<?php if($current_profile->member_type_id == 1): ?>
<div id="upgrade-your-account">
<div id="upgrade1">
    <h3>Upgrade Your Account</h3>
	</div>
    <div class="content">
        <p>Upgrade now to take advantage
of benefits such as sending mes-
sages and creating a chat room
to communicate with members.</p>
        <ul>
            <li style="padding-left:"><?php echo Html::anchor("#", "Utilize Dating Agents&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"); ?></li>
            <li><?php echo Html::anchor("#", "Attend Locallized Events"); ?></li>
            <li><?php echo Html::anchor("#", "Send Friend Request&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"); ?></li>
            <li><?php echo Html::anchor("#", "Create Chat Rooms &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"); ?></li>
        </ul>
        <?php echo Html::anchor(\Fuel\Core\Uri::create('membership/upgrade', array(), array(), true), "Upgrade Now!", array("class" => "button")); ?>
    </div>
</div>
<?php endif; ?>