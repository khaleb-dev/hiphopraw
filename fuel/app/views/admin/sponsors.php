<div id="center" class="clearfix">
    <div id="sidebar-left">
        <?php echo View::forge("admin/partials/admin_side_nav", array("current_user" => $current_user, "menu" => "Sponsors")); ?>

        <?php echo View::forge("pages/partials/enter_your_videoke"); ?>
    </div>
    <div id="content" class="with-sidebar-left profile">
        <div id="sponsors" >
            <div class="content-box">
				<h3 class="sponor-title" >Sponsors</h3>
                
                <?php echo Form::open(array("action" => "admin/sponsors","enctype" => "multipart/form-data")); ?>
                <div class="items clearfix">
                    
                    <p>
                        <?php echo Form::label('Title: ', 'lblSponsor'); ?>
                        <?php echo Form::input('sponsor', '', array("class" => "text-field long", "placeholder" => "Name of sponsor")); ?>
                    </p>
					<p>
						<label> Sponsor Photo</label>
						<?php echo Form::file('sponsor_image'); ?>
					</p>
                    <!--<p>
                        <?php //echo Form::label('Contact Info: ', 'lblContactInfo'); ?>
                        <?php //echo Form::input('contact_info1', '', array("class" => "text-field long")); ?>
                        <?php //echo Form::input('contact_info2', '', array("class" => "text-field long")); ?>
                    </p>
                    <p>
                        <?php //echo Form::label('Joined: ', 'lblJoined'); ?>
                        <?php //echo Form::input('joined_date', '', array("class" => "date-picker")); ?>
                    </p>-->
                    <div id="save-sponsor">
                        <?php echo Form::submit('', 'Publish New Sponsor', array("class" => "button publish-sponsor-btn")); ?>
                    </div>
                    
                </div>
				<!--
                <p id="search-sponsor">
                    <?php //echo Form::label('Search Sponsors: ', 'lblSearchSponsors'); ?>
                    <?php //echo Form::input('search', '', array("class" => "text-field long")); ?>
                    <?php //echo Form::submit('btnSearch', 'Go', array("class" => "button")); ?>
                </p> -->
                <?php echo Form::close(); ?>
                <!--<div>
                    <table>
                        <thead>
                            <tr class="table-heading">
                                <th>&nbsp;</th>
                                <th class="text-left">Sponsor</th>
                                <th>Contact Info</th>
                                <th class="text-right">Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; ?>
                            <?php foreach ($sponsors as $sponsor) : ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td><?php echo $sponsor->sponsor; ?></td>
                                <td><?php echo $sponsor->contact_info1; ?><span>&nbsp;|&nbsp;</span> <?php echo $sponsor->contact_info2; ?></td>
                                <td class="text-right"><?php echo date('m/d/Y', $sponsor->joined_date) ; ?></td>
                                <?php $i++; ?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <p class="back"><?php echo Html::anchor(Router::get("profile"), "Back"); ?></p>-->
				
				<form style="margin:40px 0px 0px; ">
				<table class="table contest-all-tbl">
				  <thead>
					<tr>
                        <th width="30px"></th>
                          <th>SPONSOR TITLE</th>
                          <th>SPONSOR Image</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($sponsors as $sponsor) : ?>
                    <tr id="<?php echo $sponsor->id; ?>">
                      <td><input class="move-to-trash" data-sponsor-id="<?php echo $sponsor->id; ?>" type="checkbox" /></td>
                      <td><?php echo $sponsor->sponsor; ?></td>
                      <td><a href="#"class="red"><?php echo $sponsor->image; ?></a></td>
					</tr>
                    <?php endforeach; ?>
				  </tbody>
				</table>
				<center>
               <!--  <?php //echo Html::anchor("#", "Delete Selected", array("id" => "sponsor-delete", "url"=>"<?php echo Uri::create('admin/manage_sponsors')?>","class" => "button rounded-corners")); ?> --> 
				<?php //echo Form::submit('', 'Delete Selected', array("class" => "button publish-sponsor-btn")); ?>
                <a id="sponsor-delete" url="<?php echo Uri::create('admin/manage_sponsors')?>" class="button rounded-corners" href="#">Delete Selected</a>
				</center>
				</form>
				
            </div>
        </div>
    </div>
    <div class="clear">&nbsp</div>
</div>

