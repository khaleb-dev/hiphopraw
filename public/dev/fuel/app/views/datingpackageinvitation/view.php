<h2>Viewing <span class='muted'>#<?php echo $datingpackageinvitation->id; ?></span></h2>

<p>
	<strong>From member id:</strong>
	<?php echo $datingpackageinvitation->from_member_id; ?></p>
<p>
	<strong>To member id:</strong>
	<?php echo $datingpackageinvitation->to_member_id; ?></p>
<p>
	<strong>Date invited:</strong>
	<?php echo $datingpackageinvitation->date_invited; ?></p>
<p>
	<strong>Status:</strong>
	<?php echo $datingpackageinvitation->status; ?></p>

<?php echo Html::anchor('datingpackageinvitation/edit/'.$datingpackageinvitation->id, 'Edit'); ?> |
<?php echo Html::anchor('datingpackageinvitation', 'Back'); ?>