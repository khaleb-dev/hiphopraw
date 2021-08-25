<script type="text/javascript">

function checkAll(checkId){
    var inputs = document.getElementsByTagName("input");
    var input = document.getElementById("chk_new");
    for (var i = 0; i < inputs.length; i++) {
        if (inputs[i].type == "checkbox" && inputs[i].id == checkId) {
            if(input.checked == false) {
                inputs[i].checked = false ;
            } else if (input.checked == true ) {
                inputs[i].checked = true ;
            }
        } 
    } 
}

</script>

<div id="content" class="clearfix">
                    <div class="sub-nav">
                    <ul  class="nav nav-pills">
                        <li><?php echo \Fuel\Core\Html::anchor('admin/index', 'Members Privilege',array('class' => 'active-link')) ?>   </li>
                        <li><?php echo \Fuel\Core\Html::anchor('admin/event_plan', 'Event Planning') ?></li>
                        <li><?php echo \Fuel\Core\Html::anchor('admin/dating_packages', 'Dating packages') ?></li>                       
                    </ul>
                </div>
				<div id="main">
				   <div id="submain">
			        <div class="allcontent">
					<form name=myform  method=post action = "index">
					    <ul  class="nav nav-pills">
					    <li style="padding-left:1%;" ><input type="checkbox" id="chk_new"  name="CheckAll" onclick="checkAll('list');"></li>
                        <li style="padding-left:1%;">Select All</li>
                          <li style="padding-left:12%;">Name</li>
                        <li style="padding-left:17%;">Date Joined</li>
                        <li style="padding-left:20%; padding-right:175px;">Membership Status</li>
                    </ul>
					<div id="content-members">
					<?php foreach($profiles as $profile): ?>
					<span id="personal">
					<div id="box">
				    <input type="checkbox" id="list" name="list[<?php echo $profile->id; ?>]" value=<?php echo $profile->id; ?>>
					<br><br><br>
					   <br>
						 <br>
					</div>
					
				<span><?php echo Html::img(Model_Profile::get_picture($profile->picture, $profile->user_id, "members_medium")); ?></span>
				
                <div id="name">  
				  <?php echo Model_Profile::get_username($profile->user_id); ?>
				          <br>
						    <br>
							  <br>
		               </div>
					    <div id="joined">	 
						<?php echo date("m-d-Y ",$profile->created_at); ?>
						<br>
						    <br>
							  <br>
						</div>
						<input name="id[]" type="hidden" value=<?php echo $profile->id; ?>  >
						
					   <div id="member-status">
					 	  <select style="width:288px; height:31px;" name='membertype[<?php echo $profile->id ?>]' >
						
						<?php foreach($membershiptype as $member): ?>
						 <option value=<?php echo $member->id; ?> <?php echo ($member->id == $profile->member_type_id)? 'selected' : '' ;?>><?php echo $member->name; ?> </option>
						 <?php endforeach; ?>
							   </select>
						  </div>
						  </span>
						  <br>
					  <?php endforeach; ?>
					 
					 </div>
					 <div id="save-members">
					  <input type="submit" id="save" name="submit1" value="Save" >
					  <input type="submit" id="delete" name="submit1" value="Delete" >
					
					  <a style="margin-left:75%; font-weight:bold;">   
					                		 <?php echo Pagination::instance('mypagination')->previous(); ?>
											 <?php  echo Pagination::instance('mypagination')->pages_render(); ?>
                                             <?php  echo Pagination::instance('mypagination')->next(); ?>
					                         
					  </a>
					  </div>
					  </form>
					 </div>
               </div>					
				</div>
        
</div>

