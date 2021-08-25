<div id="center" class="clearfix">
    <div id="sidebar-left">
        <?php echo View::forge("admin/partials/admin_side_nav", array("current_user" => $current_user, "menu" => "Contests")); ?>

        <?php echo View::forge("pages/partials/enter_your_videoke"); ?>
    </div>
    <div id="content" class="with-sidebar-left profile contest-main">

        <!--<h2 style="line-height:18px" ><span>Contests</span></h2>-->	
	<!--
        <div class="title" >
            <p class="pull-left main-title">CURRENT CONTEST</p>

                <p class="pull-right right-title">HHR - The <span class="red">New</span> place for <span class="red">Hip Hop</span>
                </p>
               
                
        </div>-->
        
		<h3 class="white">Viewing all Contest History</h3>
		<hr class="divider"/>

		<table class="table contest-all-tbl">
		  <thead>
			<tr>
			  <th>CATEGORY</th>
			  <th>START DATE</th>
			  <th>END DATE</th>
			  <th>CONTEST WINNER</th>
			  <th>STATUS</th>
			</tr>
		  </thead>
		  <tbody>
		  <?php if(count($all_contest) <= 0){?>
		  	<tr>
				<td colspan="5" align="center"><i>No contests found</i></td>
			</tr>
			<?php }else
			{?>
				<?php foreach($all_contest as $contest){ ?>
						<tr>
						  <td><span class="contest-dot contest-dot-white"></span><?php echo $contest['category_id']; ?></td>
						  <td><?php echo date("m/d/Y", $contest['start_time']);?></td>
						  <td><?php echo date("m/d/Y", $contest['end_time']);?></td>
						  <td><?php echo Html::anchor('videos/show/' . $contest['winner'], "Video ID#".$contest['winner'], array("class"=>"red"));?></td>
						  <?php if($contest["status"]=="active"){?>
						  <td><span class="green"><?php  echo $contest["status"]; ?></span></td>
						  <?php }else { ?>
						  <td><span class="red"><?php  echo $contest["status"]; ?></span></td><?php } ?>

							 <?php  if ($contest["status"]=="deleted") {?>
							    <td>
                                <?php    echo "-"; ?>
                               </td>
                             <?php } else { ?>
						 	   <td>
                                <?php    echo Html::anchor('admin/contests/?delete_contest=' . $contest['id'], "Delete", array("class" => "red-btn")); ?>
                               </td>
                               <?php } ?>
						</tr>
	 		<?php  } }?>
			
		  </tbody>
		</table>
		
		<center class="new-contest-btn">
		<?php
            echo Html::anchor('admin/contests/add', "Create New Contest", array("class" => "button rounded-corners"));
		?>
		</center>
      
    </div>
    <div class="clear">&nbsp;</div>
</div>
</div>
