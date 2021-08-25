<h2>Listing <span class='muted'>Datingpackageinvitations</span></h2>
<br>
<?php if ($datingpackageinvitations): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>From member id</th>
			<th>To member id</th>
			<th>Date invited</th>
			<th>Status</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($datingpackageinvitations as $item): ?>		<tr>

			<td><?php echo $item->from_member_id; ?></td>
			<td><?php echo $item->to_member_id; ?></td>
			<td><?php echo $item->date_invited; ?></td>
			<td><?php echo $item->status; ?></td>
			<td>
				<div class="btn-toolbar">
					<div class="btn-group">
						<?php echo Html::anchor('datingpackageinvitation/view/'.$item->id, '<i class="icon-eye-open"></i> View', array('class' => 'btn btn-small')); ?>						<?php echo Html::anchor('datingpackageinvitation/edit/'.$item->id, '<i class="icon-wrench"></i> Edit', array('class' => 'btn btn-small')); ?>						<?php echo Html::anchor('datingpackageinvitation/delete/'.$item->id, '<i class="icon-trash icon-white"></i> Delete', array('class' => 'btn btn-small btn-danger', 'onclick' => "return confirm('Are you sure?')")); ?>					</div>
				</div>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Datingpackageinvitations.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('datingpackageinvitation/create', 'Add new Datingpackageinvitation', array('class' => 'btn btn-success')); ?>

</p>
