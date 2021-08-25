<?php
function time_zones()
{
	$option = array();
	$option[''] = 'Please select';	
	for($i=1;$i<13;$i++){
		if($i < 13){
			$option['UTC -'.$i] = 'UTC -'.$i;
			$j = $i;
		}
	}
	$option['UTC'] = 'UTC';
	if($i > 12){
			$i=1;
		for($i=1;$i<14;$i++){
			$option['UTC +'.$i] = 'UTC +'.$i;
			}	
		}

	
	return $option;
}

function hours()
{
    $option = array();
    $option[''] = 'Please select';
    for($i=0;$i<12;$i++){
    for($j=0;$j<60;$j=$j+5){
        if($i < 10){
        	if($j < 10){
            $option['0'.$i.':0'.$j.':00'] = '0'.$i.':0'.$j.':00';
        	}
        	else{
        	$option['0'.$i.':'.$j.':00'] = '0'.$i.':'.$j.':00';
        	}
        }
        else{
        	if($j < 10){
        		$option[$i.':0'.$j.':00'] = $i.':0'.$j.':00';
        	}
        	else{
        		$option[$i.':'.$j.':00'] = $i.':'.$j.':00';
        	}
        }
    }
    }
    return $option;
}
function minutes()
{
    $option = array();
    $option[''] = 'Minute';
    for($i=0;$i<60;$i=$i++){
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
          <div class="sub-nav">
            <ul  class="nav nav-pills">
              <li><?php echo \Fuel\Core\Html::anchor('admin', 'Members Privilege') ?> </li>
              <li><?php echo \Fuel\Core\Html::anchor('admin/event_plan', 'Event Planning',array('class' => 'active-link')) ?></li>
              <li><?php echo \Fuel\Core\Html::anchor('admin/dating_packages', 'Dating packages') ?></li>
                        
              </ul>
            </div>
                           
    <div id="main-content">
    <?php if($identifier == 0): ?>
     <div id="sub-content">
                
           <div id="common-content">
            <?php
         echo \Fuel\Core\Form::open(array('action' => 'admin/event_plan','enctype'=>'multipart/form-data'));
        ?>
            <?php
            if(isset($errors)){
                foreach ($errors as $field => $error)
                {
                    echo $error->get_message().'<br>';
                }
            }

            ?>  
            
             
            <div class="fileUpload btn btn-primary">
               <span>Upload Image</span>  
                <input id="imgInp" name = "photo" type="file" class="upload" /> 
             </div>
              
              <div id = "no-file">          
               <input id="uploadFile" placeholder="No file selected" disabled="disabled" />      
              </div>

            <div id = "preview-big-event">               
                 <img id="preview"/>           
            </div>
             
            <div id = "event-name">
                <label for="title">Event Name:</label>
                <?php echo \Fuel\Core\Form::input('title',null, array('size'=>'55'))?>
            </div>

            <div id = "short-description">
                <label for="short_description">Organizers Details:</label>
                <?php echo \Fuel\Core\Form::input('organizers_details',null, array('size'=>'55'))?>
            </div>

           <div id = "long-description">
               <label for="long_description">Short Description(Recommended not exceed 160 characters):</label>
               <?php echo \Fuel\Core\Form::textarea('short_description',null, array('cols'=>'122'))?>
           </div>

            <div id = "long-description">
                <label for="long_description">Long Description:</label>
                <?php echo \Fuel\Core\Form::textarea('long_description',null, array('cols'=>'122', 'id' => 'long_description'))?>
            </div>
            
            <div id="address">
                <label for="venue">URL:</label>
                <?php echo \Fuel\Core\Form::input('url',null, array('size'=>'120'))?>
            </div>

            <div id="address">
                <label for="venue">Address:</label>
                <?php echo \Fuel\Core\Form::input('venue',null, array('size'=>'120'))?>
            </div>
            
             <div id="city">
                <label for="city">City:</label>
                <?php echo \Fuel\Core\Form::input('city',null, array('size'=>'55'))?>
            </div>
            
            <div id="state">
                <label for="state">State:</label>
                <?php echo \Fuel\Core\Form::select('state', '', get_states(),array('id'=>'state-select'))?>
            </div>
            
             <div id="zip">
                <label for="zip">Zip Code:</label>
                <?php echo \Fuel\Core\Form::input('zip',null, array('size'=>'22'))?>
            </div>   
           
            <div id="start-date">
                <label for="start_date">Time Zone:</label>
                <?php echo \Fuel\Core\Form::select('start_date', '', time_zones(),array('id'=>'start'))?>
            </div>

            <div id="start-hour">
                <label for="start_time_hour">Event Times:</label>

                <?php echo \Fuel\Core\Form::select('start_time_hour','', hours(),array('id'=>'start-event'))?>
            </div>
    
             <div id="start-pm-am">
                <?php echo \Fuel\Core\Form::select('start_pm_am','',array(''=>'','am'=>'am','pm'=>'pm'),array('id'=>'start_pm_am'))?>             
            </div>
    
            <div id="end-hour">
                <label for="end_time_hour">To</label>
                <?php echo \Fuel\Core\Form::select('end_time_hour','',hours(),array('id'=>'end-event'))?>             
            </div>
               
              <div id="end-pm-am">
                <?php echo \Fuel\Core\Form::select('end_pm_am','',array(''=>'','am'=>'am','pm'=>'pm'),array('id'=>'end_pm_am'))?>             
            </div> 
                       
            <div id="event-date">
                <label for="event_date">Event Start Date:</label>
               <?php echo \Fuel\Core\Form::input('event_date', null, array('id'=>'datepicker'))?>
            </div>
            
            <div id="event-end-date">
                <label for="event_end_date">Event End Date:</label>
               <?php echo \Fuel\Core\Form::input('event_end_date', null, array('id'=>'datepicker2'))?>
            </div>
            
            <div id="featured">
                <label for="end_time_hour">Featured</label>
                <?php echo \Fuel\Core\Form::checkbox('is_featured', 'is_featured', false,array('id'=>'feature-box')) ?>
            </div>
            
            
            <div>
                <?php
                echo \Fuel\Core\Form::submit('submit','SAVE',array('id'=>'save-button'))
                ?>
            </div>
            
                <?php
               echo \Fuel\Core\Form::close();
                ?>
             </div>
                         
         </div>
        <?php endif; ?> 
   
   
        <?php if($identifier == 1): ?>
     <div id="sub-content">
                
           <div id="common-content">
            <?php
         echo \Fuel\Core\Form::open(array('action' => 'admin/edit_events','enctype'=>'multipart/form-data'));
        ?>
            <?php
            if(isset($errors)){
                foreach ($errors as $field => $error)
                {
                    echo $error->get_message().'<br>';
                }
            }

            ?>  
            
             
            <div class="fileUpload btn btn-primary">
               <span>Upload Image</span>  
                <input id="imgInp" name = "photo" type="file" class="upload" /> 
             </div>
              
              <div id = "no-file">          
               <input id="uploadFile" placeholder="No file selected" disabled="disabled" />      
              </div>

            <div id = "preview-big-event">               
                 <img src="<?php echo \Fuel\Core\Uri::base().'uploads/events/event_list_'.$editevents->photo ?>" id="preview"/>           
            </div>
             
            <div id = "event-name">
                <label for="title">Event Name:</label>
                <?php echo \Fuel\Core\Form::input('title',$editevents->title, array('size'=>'55'))?>
            </div>

            <div id = "short-description">
                <label for="short_description">Organizers Details:</label>
                <?php echo \Fuel\Core\Form::input('organizers_details',$editevents->organizers_details, array('size'=>'55'))?>
            </div>



               <div id = "long-description">
                   <label for="long_description">Short Description(Recommended not exceed 160 characters):</label>
                   <?php echo \Fuel\Core\Form::textarea('short_description',$editevents->short_description, array('cols'=>'122'))?>
               </div>

               <div id = "long-description">
                   <label for="long_description">Long Description:</label>
                   <?php echo \Fuel\Core\Form::textarea('long_description',$editevents->long_description, array('cols'=>'122', 'id' => 'long_description'))?>
               </div>

               <div id="address">
                   <label for="venue">URL:</label>
                   <?php echo \Fuel\Core\Form::input('url',$editevents->url, array('size'=>'120'))?>
               </div>

<!--            <div id = "long-description">-->
<!--                <label for="long_description">Event Description:</label>-->
<!--                --><?php //echo \Fuel\Core\Form::textarea('long_description',$editevents->long_description, array('cols'=>'122'))?>
<!--            </div>-->
            
            <div id="address">
                <label for="venue">Address:</label>
                <?php echo \Fuel\Core\Form::input('venue',$editevents->venue, array('size'=>'120'))?>
            </div>
            
             <div id="city">
                <label for="city">City:</label>
                <?php echo \Fuel\Core\Form::input('city',$editevents->city, array('size'=>'55'))?>
            </div>   
            
            <div id="state">
                <label for="state">State:</label>
                <?php echo \Fuel\Core\Form::select('state',$editevents->state, get_states(),array('id'=>'state-select'))?>
            </div>
            
             <div id="zip">
                <label for="zip">Zip Code:</label>
                <?php echo \Fuel\Core\Form::input('zip',$editevents->zip, array('size'=>'22'))?>
            </div>   
           
            <div id="start-date">
                <label for="start_date">Time Zone:</label>
                <?php echo \Fuel\Core\Form::select('start_date',$editevents->time_zone, time_zones(),array('id'=>'start'))?>
            </div>

            <div id="start-hour">
                <label for="start_time_hour">Event Times:</label>

                <?php echo \Fuel\Core\Form::select('start_time_hour',$editevents->start_time, hours(),array('id'=>'start-event'))?>
            </div>
            
            <div id="start-pm-am">
                <?php echo \Fuel\Core\Form::select('start_pm_am',$editevents->start_pm_am,array(''=>'','am'=>'am','pm'=>'pm'),array('id'=>'start_pm_am'))?>             
            </div>
            
            <div id="end-hour">
                <label for="end_time_hour">To</label>
                <?php echo \Fuel\Core\Form::select('end_time_hour',$editevents->end_time,hours(),array('id'=>'end-event'))?>             
            </div>
             
             <div id="end-pm-am">
                <?php echo \Fuel\Core\Form::select('end_pm_am',$editevents->end_pm_am,array(''=>'','am'=>'am','pm'=>'pm'),array('id'=>'end_pm_am'))?>             
            </div> 
                      
            <div id="event-date">
                <label for="event_date">Event Date:</label>
               <?php echo \Fuel\Core\Form::input('event_date',$editevents->start_date, array('id'=>'datepicker'))?>
            </div>
            
            <div id="event-end-date">
                <label for="event_end_date">Event End Date:</label>
               <?php echo \Fuel\Core\Form::input('event_end_date', $editevents->event_end_date, array('id'=>'datepicker2'))?>
            </div>
            
             <?php if($editevents->is_featured == 1): ?> 
             <?php $bool = true; ?>
             <?php else: ?>
             <?php $bool = false; ?>
             <?php endif; ?>
            
            <div id="featured">
                <label for="end_time_hour">Featured</label>
                <?php echo \Fuel\Core\Form::checkbox('is_featured', $editevents->is_featured, $bool,array('id'=>'feature-box')) ?>
            </div>
             
            <div>
                <?php
                echo \Fuel\Core\Form::submit('submit','Update',array('id'=>'save-button'))
                ?>
            </div>
            <input type="hidden" name="idholder" value="<?php echo $editevents->id;?>" />
                <?php
               echo \Fuel\Core\Form::close();
                ?>
             </div>
                         
         </div>
        <?php endif; ?> 
           
         
          <div id = "events-lists">
          <div id = "headers-event">
            <ul  class="nav nav-pills">
		    <li><input type="checkbox" id="checkevents"  name="CheckAll" onclick="checkAll('list');"></li>
            <li>Select All</li>
             <li>Event Picture</li>
            <li>Event Name</li>
            <li>Created On</li>
            </ul>
            </div>
            <div id = "event-container">
             <?php if($events): ?>
              <?php echo Form::open('admin/manage_events'); ?>              
              <?php foreach($events as $event): ?>
              <div id = "event-detail">
              <div id = "checks">
             <input type="checkbox" id="list" name='eventids[<?php echo $event->id; ?>]' value=<?php echo $event->id; ?>> 
             </div>
             <div id = "images"> 
              <img src="<?php echo \Fuel\Core\Uri::base().'uploads/events/event_list_'.$event['photo'] ?>" />
              </div>
              <div id = "titles">
             <?php if(strlen($event->title) > 45): ?>
              <?php echo substr($event->title,0,45).'...'; ?>
               <?php else: ?>
               <?php echo $event->title; ?> 
               <?php endif; ?> 
              </div>
              <div id = "dates">
              <?php echo date("m-d-Y ",$event->created_at); ?>
              </div>
               </div>
               
              <?php endforeach; ?>
              <div id = "buttons">
               <input type="submit" name="action1" value="Edit" />
             <div id = "delete-button">
               <input type="submit" name="action1" value="Delete" />
            </div> 
             </div>             
              <?php echo Form::close();?>
             <?php else: ?>
            <p class="nodata-message">There are no created events.</p>
             <?php endif; ?> 
            </div>
         </div>
             
         
      </div>     
</div>

<script src="//code.jquery.com/jquery-1.9.1.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
    CKEDITOR.replace('long_description');

    function checkAll(checkId){
    var inputs = document.getElementsByTagName("input");
    var input = document.getElementById("checkevents");
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

                
    $(function() {
        $( "#datepicker" ).datepicker({ dateFormat: "yy-mm-dd" });
    });
    $(function() {
        $( "#datepicker2" ).datepicker({ dateFormat: "yy-mm-dd" });
    });

    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#preview').attr('src', e.target.result);
                
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp").change(function(){
        readURL(this);
       
    });
    document.getElementById("imgInp").onchange = function () {
        document.getElementById("uploadFile").value = this.value;
    }

</script>