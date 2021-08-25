<div id="center" class="clearfix">
    <div id="sidebar-left">
        <?php echo View::forge("admin/partials/admin_side_nav", array("current_user" => $current_user, "menu" => "Contests")); ?>

        <?php echo View::forge("pages/partials/enter_your_videoke"); ?>
    </div>
    <div id="content" class="with-sidebar-left profile">

        <!--<h2 style="line-height:18px" ><span>Contests</span></h2>-->	

        <div class="title" >
            <p class="pull-left main-title">CURRENT CONTEST</p>

                <p class="pull-right right-title">HHR - The <span class="red">New</span> place for <span class="red">Hip Hop</span>
                </p>
               
                
        </div>
                <hr class="divider"/>


        <div id="contest" class="content-box">
            <?php echo Form::open(array("action" => "admin/contests")); ?>


            <div class="items clearfix">    				
                <?php
                //echo Html::anchor('admin/contests/add', "Add Contest", array("class" => "button rounded-corners"));
                ## print_r($contests_by_category);
                ?><table style="border:0;width:100%;">
                    <tr style="border:0; height: 30px;">
                        <th class="row2" align="left">Category</th>
                        <th class="row2">Contest Active</th>
                        <th class="row2">Next Round</th>
                        <th class="row2">Contest Ends</th>
                        <th class="row2" colspan="2">&nbsp;</th>
                    </tr><?php
                    $color = 0;

                    foreach ($categories as $cid => $cat) {

                        $class = 'row' . ($color++ % 2);
                        ?><tr>
                            <td class="<?= $class ?>"><?= $cat ?></td>
                            <td class="<?= $class ?>" align="center"><?php
                                if (isset($contests_by_category[$cid])) {

                                    echo "Yes - ";

                                    echo Html::anchor(Router::get("contest/:contest_id", array("contest_id" => $cid)), "View", array("class" => "black-btn"));
                                } else {

                                    echo "No - ";

                                    echo Html::anchor('admin/contests/add/?category_id=' . $cid, "Add", array("class" => "button rounded-corners"));
                                }
                                ?></td>
                            <td class="<?= $class ?>" align="center"><?php
                                if (isset($contests_by_category[$cid])) {

                                    // CALCULATE START TIME + (round * (one week))


                                    $round_time = $contests_by_category[$cid][0]['start_time'] + ($contests_by_category[$cid][0]['current_round'] * 604800);

                                    echo date("m/d/Y", $round_time);
                                } else {

                                    echo "-";
                                }
                                ?></td>
                            <td class="<?= $class ?>" align="center"><?php
                                if (isset($contests_by_category[$cid])) {


                                    #print_r($contests_by_category[$cid]);
                                    echo date("m/d/Y", $contests_by_category[$cid][0]['end_time']);
                                } else {

                                    echo "-";
                                }
                                ?></td>
                            <td class="<?= $class ?>" align="center"><?php
                                echo Html::anchor('admin/contests/history/?category_id=' . $cid, "History", array("class" => "black-btn"));
                                ?></td>
                            <td class="<?= $class ?>" align="center"><?php
//                                if (isset($contests_by_category[$cid]) && $contests_by_category[$cid][0]['current_round'] <= 0) {
                                if (isset($contests_by_category[$cid]) ) {
                                    echo Html::anchor('admin/contests/?delete_contest=' . $contests_by_category[$cid][0]['id'], "Delete", array("class" => "button rounded-corners"));
                                } else {
                                    echo "-";
                                }
                                ?></td>


                        </tr><?php
                    }
                    ?></table>
            </div> 

            <?php echo Form::close(); ?>
             <hr class="divider1"/>
        </div>

       

       <div class="title" >
            <p class="pull-left main-title">PAST CONTESTS</p>

                <p class="pull-right right-title">HHR - The <span class="red">New</span> place for <span class="red">Hip Hop</span>
                </p>

               
                <hr class="divider"/>
        </div>

         <div class="items clearfix">
    <?php
        if(isset($pastcontests)){
    ?>
        <div id="contest" class="content-box">
            <?php echo Form::open(array("action" => "admin/contests")); ?>


            <div class="items clearfix">                    
                <?php
                //echo Html::anchor('admin/contests/add', "Add Contest", array("class" => "button rounded-corners"));
                ## print_r($contests_by_category);
                ?><table style="border:0;width:100%; ">
                    <tr style="border:0; height: 30px; bottom: 0; ">
                        <th class="row2" align="left">Category</th>
                        <th class="row2">Contest Status</th>
                        <th class="row2">Last Round</th>
                        <th class="row2">Contest Ended</th>
                        <th class="row2" colspan="2">&nbsp;</th>
                    </tr><?php
                    $color = 0;

                    foreach ($pastcontests as $cid => $contest) {

                        $class = 'row' . ($color++ % 2);
                        ?>
                        <tbody class="contest-<?= $contest['id'] ?>">
                        <tr >
                            <td class="<?= $class ?>"><?= $categories[$contest['category_id']]; ?></td>
                            <td class="<?= $class ?>" align="center"><?php
                                
                                        echo $contest['status'];
                                   
                                ?></td>
                            <td class="<?= $class ?>" align="center"><?php
                            


                                    $round_time = $contest['start_time'] + ($contest['current_round'] * 604800);

                                    echo date("m/d/Y", $round_time);
                                
                                ?></td>
                            <td class="<?= $class ?>" align="center"><?php
                                
                                    echo date("m/d/Y", $contest['end_time']);
                                ?></td>
                            <td class="<?= $class ?>" align="center"><?php
                                echo Html::anchor('admin/contests/history/?category_id=' . $contest['category_id'], "History", array("class" => "black-btn"));
                                ?></td>
                            <td class="<?= $class ?>" align="center" ><?php
//                                if (isset($contests_by_category[$cid]) && $contests_by_category[$cid][0]['current_round'] <= 0) {
                                    ?>
                                   
                                        <a url="<?php echo Uri::create('admin/contests_remove')?>" class="button rounded-corners" id="dlt-btn" data-contestid="<?= $contest['id'] ?>">Delete </a>
                                     
                                    <?php
                                    //echo Html::anchor('admin/contests/?delete_contest=' . $contest['id'], "Delete", array("class" => "button rounded-corners"));
                                
                                ?></td>


                        </tr>
                        </tbody>
                    <?php
                    }
                    ?></table>
            </div> 

            <?php echo Form::close(); ?>
            <hr class="divider1"/>
        </div>
    <?php 
    }else{
        echo "There are no past contests";
    }
    ?>
      
    </div>
    <div class="clear">&nbsp</div>
</div>

