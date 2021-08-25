<div id="member-profile-dialog-<?php echo $member['id'] ?>" class="member-profile-dialog">
          <div class="clearfix">
                       <?php echo Html::anchor(( ! Model_Profile::is_dating_agent($current_profile->id)) ? Uri::create('profile/public_profile/' . $member['id']) : Uri::create('agent/client_view/' . $member['id'])
                           ,Html::img(Model_Profile::get_picture($member['picture'], $member['user_id'], "members_medium"))); ?>
                       <div class="left-details">
                           <?php
                               $seeking_all = Model_Gender::find($member['id']);
                                $seeking =  $seeking_all['seeking_gender_id'];
                                $relationship_all = Model_Relationshipstatus::find($member['id']);
                                $relationship = $relationship_all['relationship_status_id'];
                                $ethnicity_all = Model_Ethnicity::find($member['id']);
                                $ethnicity = $ethnicity_all['ethnicity_id'];
                                $body_type_all = Model_Bodytype::find($member['id']);
                                $body_type = $body_type_all['body_type_id'];
                                $profile_all = Model_Profile::find($member['id']);
                                $ages_from = $profile_all['ages_from'];
                                $ages_to = $profile_all['ages_to'];
                                $want_kids = $profile_all['want_kids'];
                           ?>
                           <p class="full-name"><?php echo Model_Profile::get_username($member['user_id'],14)  ?></p>
                           <p class="location"><?php echo $member['city'] . ' ' . $member['state'] ?></p>
                           <p>Seeking: <span><?php echo $seeking==null ? '' : $seeking->name; ?></span></p>
                           <p>Ages: <span><?php echo $ages_from.' to '. $ages_to  ?></span></p>
                       </div>
                   </div>
                   <div class="bottom-detail">
                       <p>Relationship Status: <span><?php echo $relationship==null ? '' : $relationship->name; ?></p>
                       <p>Want Kids: <span><?php echo $want_kids ?></span></p>
                       <p>Ethnicity: <span><?php echo $ethnicity==null ? '' : $ethnicity->name; ?></span></p>
                       <p>Body Type: <span><?php echo $body_type==null ? '' : $body_type->name; ?></span></p>
        <?php echo Html::anchor("#", '<i class="fa fa-user"></i>  Send Chat Request', array("class" => "send-chat-request", "data-username" => Model_Profile::get_username($member['user_id']), "data-full-name" => Model_Profile::get_username($member['user_id']), "data-container" => "member-profile-dialog-". $member['id'])); ?>
    </div>
</div>

<div id="member-profile-message-dialog-<?php echo $member['id'] ?>" class="member-profile-dialog1">
                   <div class="clearfix">
                       <?php echo Html::anchor(( ! Model_Profile::is_dating_agent($current_profile->id)) ? Uri::create('profile/public_profile/' . $member['id']) : Uri::create('agent/client_view/' . $member['id'])
                           ,Html::img(Model_Profile::get_picture($member['picture'], $member['user_id'], "members_medium"))); ?>
                       <div class="left-details">
                           <?php
                               $seeking_all = Model_Gender::find($member['id']);
                                $seeking =  $seeking_all['seeking_gender_id'];
                                $relationship_all = Model_Relationshipstatus::find($member['id']);
                                $relationship = $relationship_all['relationship_status_id'];
                                $ethnicity_all = Model_Ethnicity::find($member['id']);
                                $ethnicity = $ethnicity_all['ethnicity_id'];
                                $body_type_all = Model_Bodytype::find($member['id']);
                                $body_type = $body_type_all['body_type_id'];
                                $profile_all = Model_Profile::find($member['id']);
                                $ages_from = $profile_all['ages_from'];
                                $ages_to = $profile_all['ages_to'];
                                $want_kids = $profile_all['want_kids'];
                           ?>
                           <p class="full-name"><?php echo Model_Profile::get_username($member['user_id'],14)  ?></p>
                           <p class="location"><?php echo $member['city'] . ' ' . $member['state'] ?></p>
                           <p>Seeking: <span><?php echo $seeking==null ? '' : $seeking->name; ?></span></p>
                           <p>Ages: <span><?php echo $ages_from.' to '. $ages_to  ?></span></p>
                       </div>
                   </div>
                   <div class="bottom-detail">
                       <p>Relationship Status: <span><?php echo $relationship==null ? '' : $relationship->name; ?></p>
                       <p>Want Kids: <span><?php echo $want_kids ?></span></p>
                       <p>Ethnicity: <span><?php echo $ethnicity==null ? '' : $ethnicity->name; ?></span></p>
                       <p>Body Type: <span><?php echo $body_type==null ? '' : $body_type->name; ?></span></p>
                       <?php echo Html::anchor("#", '<i class="fa fa-envelope"></i>  Send Message', array("class" => "send-message", "data-dialog" => "send-message-dialog", "data-from-member-id" => $current_profile->id, "data-to-member-id" => $member['id'], "data-message-to" => Model_Profile::get_username($member['user_id']))); ?>
                   </div>
              </div>


<div id="member-profile-hello-dialog-<?php echo $member['id'] ?>" class="member-profile-dialog2">
                   <div class="clearfix">
                       <?php echo Html::anchor(( ! Model_Profile::is_dating_agent($current_profile->id)) ? Uri::create('profile/public_profile/' . $member['id']) : Uri::create('agent/client_view/' . $member['id'])
                           ,Html::img(Model_Profile::get_picture($member['picture'], $member['user_id'], "members_medium"))); ?>
                       <div class="left-details">
                           <?php
                                $seeking_all = Model_Gender::find($member['id']);
                                $seeking =  $seeking_all['seeking_gender_id'];
                                $relationship_all = Model_Relationshipstatus::find($member['id']);
                                $relationship = $relationship_all['relationship_status_id'];
                                $ethnicity_all = Model_Ethnicity::find($member['id']);
                                $ethnicity = $ethnicity_all['ethnicity_id'];
                                $body_type_all = Model_Bodytype::find($member['id']);
                                $body_type = $body_type_all['body_type_id'];
                                $profile_all = Model_Profile::find($member['id']);
                                $ages_from = $profile_all['ages_from'];
                                $ages_to = $profile_all['ages_to'];
                                $want_kids = $profile_all['want_kids'];
                           ?>
                           <p class="full-name"><?php echo Model_Profile::get_username($member['user_id'],14) ?></p>
                           <p class="location"><?php echo $member['city'] . ' ' . $member['state'] ?></p>
                           <p>Seeking: <span><?php echo $seeking==null ? '' : $seeking->name; ?></span></p>
                           <p>Ages: <span><?php echo $ages_from.' to '. $ages_to  ?></span></p>
                       </div>
                   </div>
                   <div class="bottom-detail">
                       <p>Relationship Status: <span><?php echo $relationship==null ? '' : $relationship->name; ?></p>
                       <p>Want Kids: <span><?php echo $want_kids ?></span></p>
                       <p>Ethnicity: <span><?php echo $ethnicity==null ? '' : $ethnicity->name; ?></span></p>
                       <p>Body Type: <span><?php echo $body_type==null ? '' : $body_type->name; ?></span></p>
                      <?php echo Html::anchor("#", '<i class="fa fa-comment"> </i> Send Hello', array("class" => "send-hello", "data-dialog" => "send-hello-dialog", "data-from-member-id" => $current_profile->id, "data-to-member-id" => $member['id'], "data-message-to" => Model_Profile::get_username($member['user_id']))); ?>
                   </div>
  </div> 
                  
            
            
            <div id="member-profile-favorite-dialog-<?php echo $member['id'] ?>" class="member-profile-dialog3">
                   <div class="clearfix">
                       <?php echo Html::anchor(( ! Model_Profile::is_dating_agent($current_profile->id)) ? Uri::create('profile/public_profile/' . $member['id']) : Uri::create('agent/client_view/' . $member['id'])
                           ,Html::img(Model_Profile::get_picture($member['picture'], $member['user_id'], "members_medium"))); ?>
                       <div class="left-details">
                           <?php
                                $seeking_all = Model_Gender::find($member['id']);
                                $seeking =  $seeking_all['seeking_gender_id'];
                                $relationship_all = Model_Relationshipstatus::find($member['id']);
                                $relationship = $relationship_all['relationship_status_id'];
                                $ethnicity_all = Model_Ethnicity::find($member['id']);
                                $ethnicity = $ethnicity_all['ethnicity_id'];
                                $body_type_all = Model_Bodytype::find($member['id']);
                                $body_type = $body_type_all['body_type_id'];
                                $profile_all = Model_Profile::find($member['id']);
                                $ages_from = $profile_all['ages_from'];
                                $ages_to = $profile_all['ages_to'];
                                $want_kids = $profile_all['want_kids'];
                           ?>
                           <p class="full-name"><?php echo Model_Profile::get_username($member['user_id'],14)  ?></p>
                           <p class="location"><?php echo $member['city'] . ' ' . $member['state'] ?></p>
                           <p>Seeking: <span><?php echo $seeking==null ? '' : $seeking->name; ?></span></p>
                           <p>Ages: <span><?php echo $ages_from.' to '. $ages_to  ?></span></p>
                       </div>
                   </div>
                   <div class="bottom-detail">
                       <p>Relationship Status: <span><?php echo $relationship==null ? '' : $relationship->name; ?></p>
                       <p>Want Kids: <span><?php echo $want_kids ?></span></p>
                       <p>Ethnicity: <span><?php echo $ethnicity==null ? '' : $ethnicity->name; ?></span></p>
                       <p>Body Type: <span><?php echo $body_type==null ? '' : $body_type->name; ?></span></p>
                      <?php echo Html::anchor("#", '<i class="fa fa-star"></i> Send Favorite', array("class" => "save-as-favorite", "data-dialog" => "save-favorite-dialog", "data-from-member-id" => $current_profile->id, "data-to-member-id" => $member['id'], "data-message-to" =>Model_Profile::get_username($member['user_id']) )); ?>
                   </div>
  </div> 

