<div id="center" class="clearfix">
    <div id="sidebar-left">
        <?php echo View::forge("admin/partials/admin_side_nav", array("current_user" => $current_user, "menu" => "Contests")); ?>

        <?php echo View::forge("pages/partials/enter_your_videoke"); ?>
    </div>
    <div id="content" class="with-sidebar-left profile">
        <h2 class="white-txt">Create a New Contest</h2>
        <div id="contest">
            <?php echo Form::open(array("onsubmit" => "return checkAddContest(this)", "action" => "admin/contests/add/")); ?>
            <div id="category">
                <h2>CATEGORY</h2>
                <div class="content-box">
                    <p>
                        <?php //echo Form::label('Category: ', 'lblCategory'); ?>
                        <?php
                        echo Form::select('category_id', "hhr", $categories); 

                        ///echo '<label>' . $categories[intval($_REQUEST['category_id'])] . '</label>';
                        ?>	
                    </p>
                    <div class="clear">&nbsp</div>
                </div>
            </div>


            <div id ="contest-time">
                <h2>DATE</h2>
                <div class="content-box">
                    <table style="border:0;width:100%;height:40px">
                        <tr valign="bottom">
                            <td style="width:70px"><label for="form_lblCategory">Start Date: </label></td>
                            <td style="width: 205px;">
                              <input name="start_date" type="text" id="start_date" onchange="$('#end_date_span').html(calculateEndofContest(this.value))" value="<?php echo date("m/d/Y", time() + 86400) ?>">
                              <input name="start_date" type="text" id="start_date" onchange="$('#end_date_span').html(calculateEndofContest(this.value))" value="<?php echo date("m/d/Y", time() + 86400) ?>">
                            </td>


                            <td style="width:70px"><label for="form_lblCategory">End Date: </label></td>
                            <td style="width: 205px;">
                              <input name="start_date" type="text" id="start_date" onchange="$('#end_date_span').html(calculateEndofContest(this.value))" value="<?php echo date("m/d/Y", time() + 86400) ?>">
                              <input name="start_date" type="text" id="start_date" onchange="$('#end_date_span').html(calculateEndofContest(this.value))" value="<?php echo date("m/d/Y", time() + 86400) ?>">
                            <!--<label id="end_date_span">[Select Start date]</label>-->
                            </td>
                        </tr>
                    </table>



                    <?php /**
                      <div id="beginning-time" class="input-append">
                      <label for="form_lblCategory">Beginning Time: </label>
                      <input name="start_time" data-format="hh:mm:ss" type="text"></input>
                      <span class="add-on">
                      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                      </i>
                      </span>
                      </div>
                      <div id="end-time" class="input-append">
                      <label for="form_lblCategory">End Time: </label>
                      <input name="end_time" data-format="hh:mm:ss" type="text" />
                      <span class="add-on">
                      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                      </i>
                      </span>
                      </div>
                      <div class="clear">&nbsp</div>
                     * */ ?>


                </div>

                <script>

                    $(function() {

                        var nowTemp = new Date();
                        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

                        $('#start_date').datepicker({
                            onRender: function(date) {
                                return date.valueOf() < now.valueOf() ? 'disabled' : '';
                            }
                        }).on('changeDate', function(ev) {
                            $('#end_date_span').html(calculateEndofContest($("#start_date").val()))
                            $('#start_date')[0].focus();
                        }).data('datepicker');



                        //$('#end_date_span').html(calculateEndofContest($("#start_date").val()))

                    });

                </script>

            </div>

            <div id="contest-name">
                <h2>Contest Name</h2>
                <div class="content-box">
                    <p>
                        <?php echo Form::label('Name: ', 'lblName'); ?>
                        <?php echo Form::input('name', '', array("class" => "text-field long","placeholder"=>"Name of Your Contest")); ?>
                    </p>
                </div>
            </div>

            <div id="create-contest">
                <?php echo Form::submit('', 'Create Contest', array("class" => "button")); ?>
            </div>


            <p class="back"><?php echo Html::anchor("admin/contests", "&ll;Back"); ?></p>


            <?php echo Form::close(); ?>
        </div>
    </div>
    <div class="clear">&nbsp</div>
    <div id="slogan-bottom">
        <?php echo Html::anchor(Router::get('home'), Asset::img('logo_slogan.png', array("alt" => 'slogan'))); ?>
    </div>
</div>

