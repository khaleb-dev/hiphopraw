<div id="center" class="clearfix">
    <div id="sidebar-left">
        <?php echo View::forge("admin/partials/admin_side_nav", array("current_user" => $current_user, "menu" => "Contests")); ?>

        <?php echo View::forge("pages/partials/enter_your_videoke"); ?>
    </div>
    <div id="content" class="with-sidebar-left profile">
    
    	<h2 style="line-height:18px" ><span>Contest History: <?php echo $categories[$category_id]; ?></span></h2>	
    
        <div id="contest" class="content-box">
            <?php echo Form::open(array("action" => "admin/contests")); ?>

            
            <div class="items clearfix">    				
                <?php
                //echo Html::anchor('admin/contests/add', "Add Contest", array("class" => "button rounded-corners"));
                ## print_r($contests_by_category);
                
                ?><table style="border:0;width:100%">
                <tr>
                	<th class="row2" align="left">Name</th>
                	<th class="row2">Started</th>
                	<th class="row2">Ended</th>
                	<th class="row2">Winner</th>
                </tr><?php 
                
                if(count($contests) <= 0){

					?><tr>
						<td colspan="4" align="center"><i>No contests found for this category</i></td>
					</tr><?php 
				}
                
                $color=0;
                foreach($contests as $contest){
					$class='row'.($color++%2);


					?><tr>
						<td class="<?php echo $class;?>"><?php echo $contest['name']; ?></td>
						<td class="<?php echo $class;?>" align="center"><?php
						
							echo date("m/d/Y", $contest['start_time']);
						
						?></td>
						<td class="<?php echo $class;?>" align="center"><?php
						
							echo date("m/d/Y", $contest['end_time']);
						
						?></td>
						<td class="<?php echo $class;?>" align="center"><?php 
						
							echo Html::anchor('videos/show/' . $contest['winner'], "Video ID#".$contest['winner'], array("class" => "button rounded-corners"));
							
						
						?></td>					
					</tr><?php 
				}
                
                ?></table>
            </div> 
    
            <?php echo Form::close(); ?>
        </div>
        
        <p class="back">&nbsp;<br /><?php echo Html::anchor("admin/contests", "Back"); ?></p>
        
    </div>
    <div class="clear">&nbsp</div>
    <div id="slogan-bottom">
        <?php echo Html::anchor(Router::get('home'), Asset::img('logo_slogan.png', array("alt" => 'slogan'))); ?>
    </div>
</div>

