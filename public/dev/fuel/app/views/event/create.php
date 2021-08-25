<?php
function hours()
{
    $option = array();
    $option[''] = 'Hour';
    for($i=0;$i<24;$i++){
        if($i < 10){
            $option['0'.$i] = '0'.$i;
        }
        else{
            $option[$i] = $i;
        }

    }
    return $option;
}
function minutes()
{
    $option = array();
    $option[''] = 'Minute';
    for($i=0;$i<60;$i=$i+5){
        if($i < 10){
            $option['0'.$i] = '0'.$i;
        }
        else{
            $option[$i] = $i;
        }

    }
    return $option;
}

function get_states()
{
    $state_array = array();
    $state_array[''] = 'Please Select';
    $states = Model_State::find('all');

    foreach($states as $state){
        $state_array[$state->name] = $state->name;
    }

    return $state_array;
}
?>
<div id="content" class="clearfix">
    <aside id="left-sidebar">
        <div id="profile-summary">
            <div class="content">
                <?php echo Html::anchor('#', Html::img(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "profile_medium"))); ?>
                <?php echo Html::anchor("#", $current_user->username, array("id" => "profile-link")); ?>
            </div>
        </div>

        <?php echo View::forge("profile/partials/profile_nav"); ?>
        <?php echo View::forge("membership/partials/upgrade_your_account"); ?>
    </aside>
    <div id="middle">
        <section id="event-create">
            <h2>Create New Event</h2>

        <?php
        echo \Fuel\Core\Form::open(array('enctype'=>'multipart/form-data'));
        ?>
            <?php
            if(isset($errors)){
                foreach ($errors as $field => $error)
                {
                    echo $error->get_message().'<br>';
                }
            }

            ?>
            <div>
                <label for="photo">Upload Photo</label>
                <?php echo \Fuel\Core\Form::file('photo')?>
            </div>

            <div>
                <label for="title">Title</label>
                <?php echo \Fuel\Core\Form::input('title')?>
            </div>

            <div>
                <label for="short_description">Short Description</label>
                <?php echo \Fuel\Core\Form::textarea('short_description')?>
            </div>

            <div>
                <label for="long_description">Long Description</label>
                <?php echo \Fuel\Core\Form::textarea('long_description')?>
            </div>

            <div>
                <label for="state">State</label>
                <?php echo \Fuel\Core\Form::select('state', '', get_states())?>
            </div>

            <div>
                <label for="city">City</label>
                <?php echo \Fuel\Core\Form::input('city')?>
            </div>

            <div>
                <label for="venue">Venue</label>
                <?php echo \Fuel\Core\Form::input('venue')?>
            </div>

            <div>
                <label for="start_date">Date</label>
                <?php echo \Fuel\Core\Form::input('start_date', null, array('id'=>'datepicker'))?>
            </div>

            <div>
                <label for="start_time_hour">Start Time</label>

                <?php echo \Fuel\Core\Form::select('start_time_hour','', hours())?>
                <?php echo \Fuel\Core\Form::select('start_time_minute','', minutes())?>
            </div>

            <div>
                <label for="end_time_hour">End Time</label>
                <?php echo \Fuel\Core\Form::select('end_time_hour','', hours())?>
                <?php echo \Fuel\Core\Form::select('end_time_minute','', minutes())?>
            </div>

            <div>
                <label for="end_time_hour">Featured</label>
                <?php echo \Fuel\Core\Form::checkbox('is_featured', 'is_featured', false) ?>
            </div>

            <div>
                <?php
                echo \Fuel\Core\Form::submit('submit','Create Event')
                ?>
            </div>
                <?php
                echo \Fuel\Core\Form::close()
                ?>

        </section>
    </div>
    <aside id="right-sidebar">
        <?php //echo View::forge("profile/partials/friends_online"); ?>

        <div class="ad">
            <a href="<?php echo \Fuel\Core\Uri::create('event') ?>"><?php echo Asset::img("temp/dating_agent_ad_2.jpg"); ?></a>
        </div>
        <div class="ad">
            <a href="<?php echo \Fuel\Core\Uri::create('package') ?>"><?php echo Asset::img("temp/dating_agent_ad_3.jpg"); ?></a>
        </div>
        <div class="ad">
            <a href="<?php echo \Fuel\Core\Uri::create('agent') ?>"><?php echo Asset::img("temp/dating_agent_ad.jpg"); ?></a>
        </div>
    </aside>
</div>

<script src="//code.jquery.com/jquery-1.9.1.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
    $(function() {
        $( "#datepicker" ).datepicker({ dateFormat: "yy-mm-dd" });
    });
</script>