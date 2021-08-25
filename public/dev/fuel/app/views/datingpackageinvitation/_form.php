<?php echo Form::open(array("class"=>"form-horizontal")); ?>

	<fieldset>
		<div class="form-group">
			<?php echo Form::label('From member id', 'from_member_id', array('class'=>'control-label')); ?>

				<?php echo Form::input('from_member_id', Input::post('from_member_id', isset($datingpackageinvitation) ? $datingpackageinvitation->from_member_id : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'From member id')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('To member id', 'to_member_id', array('class'=>'control-label')); ?>

				<?php echo Form::input('to_member_id', Input::post('to_member_id', isset($datingpackageinvitation) ? $datingpackageinvitation->to_member_id : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'To member id')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('Date invited', 'date_invited', array('class'=>'control-label')); ?>

				<?php echo Form::input('date_invited', Input::post('date_invited', isset($datingpackageinvitation) ? $datingpackageinvitation->date_invited : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Date invited')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('Status', 'status', array('class'=>'control-label')); ?>

				<?php echo Form::input('status', Input::post('status', isset($datingpackageinvitation) ? $datingpackageinvitation->status : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Status')); ?>

		</div>
		<div class="form-group">
			<label class='control-label'>&nbsp;</label>
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>		</div>
	</fieldset>
<?php echo Form::close(); ?>