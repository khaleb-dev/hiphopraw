<div id="center">
	<div id="content">
		<h2>See Who's a Member <span>Which star would you vote for?</span></h2>
		<div class="items members clearfix">
			<?php foreach($users as $user){ ?>
				<div class="item content-box">
					<?php echo Html::anchor("users/show/$user->id", Html::img(Model_User::get_picture($user, "home_page"))); ?>
					<h3><?php echo Html::anchor("users/show/$user->id", $user->username); ?></h3>
					<div class="clearfix">
						<p class="location"><?php echo $user->city . ", " . $user->state;  ?></p>
						<p class="icons">
							<?php echo Html::anchor("videokes/index/$user->id", Asset::img("icons/user_icon.png")); ?>
							<?php if( $current_user && $user->id != $current_user->id){ ?>
								<?php echo Html::anchor("#", Asset::img("icons/message_icon.png"), array("class" => "send-message-button", "data-username" => $user->username, "data-user-id" => $user->id)); ?>
							<?php } ?>
						</p>
					</div>					
				</div>
			<?php } ?>
			<div class="paging">
				<?php echo $pagination->render(); ?>				
			</div>
		</div>
		<?php echo View::forge("pages/partials/join_smvk"); ?>
	</div>
</div>

<?php if( $current_user && $user->id != $current_user->id){ ?>
	<?php echo View::forge("messages/partials/form_alt_modal"); ?>
<?php } ?>