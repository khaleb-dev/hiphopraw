 <div class="all-friend1">
                  <div id="pic1"> <?php echo Html::anchor("users/show/" . $friend->id, Html::img(Model_User::get_picture($friend, "profile"))); ?></div>
				    <div id="name-of-member"><?php echo $friend->username;?></div>                    
</div>
