<table id="batchDetailTable" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
	<thead>
		<tr>
			<th>S.No.</th>
			<th>Batch No.</th>
			<th>Emp No.</th>
			<th>Employee Name</th>
			<th>Designation</th>
			<th>Iqama No.</th>
			<th>Old Profession</th>
			<th>New Profession</th>
			<th>Debit Cost To</th>
			<th>Fee Amount</th>
			<th>Request Date</th>
			<th>Status</th>
			<th>Tools</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if(count($profession_list) > 0){ 
			$count = 1;

			// status mapping with badge classes
			$statuses = [
				1 => ['label' => 'Approved', 'class' => 'badge-soft-success'],
				2 => ['label' => 'Pending Current Employer Approval', 'class' => 'badge-soft-info'],
				3 => ['label' => 'Completing', 'class' => 'badge-soft-success'],
				4 => ['label' => 'Rejected', 'class' => 'badge-soft-danger']
			];

			foreach ($profession_list as $key => $value) {
		?>
			<tr>
				<td><?php echo $count++;?></td>
				<td><?php echo $value['batch_no'];?></td>
				<td><?php echo $value['emp_no'];?></td>
				<td><?php echo $value['full_name'];?></td>
				<td><?php echo $value['designation_name'];?></td>
				<td><?php echo $value['iqama_no'];?></td>
				<td><?php echo $value['old_profession_name'];?></td>
				<td><?php echo $value['new_profession_name'];?></td>
				<td><?php echo ucfirst($value['debit_cost_to']);?></td>

				<!-- Transfer Type -->
				<td class="text-right">
					<?php echo $value['fee_amount'] ?? 'NA'; ?>
				</td>
				<td><?php echo date('d-m-Y', strtotime($value['request_date']));?></td>
				<!-- Status with badge -->
				<td align="center">
					<?php 
						$status = $statuses[$value['status']] ?? ['label' => $value['status'], 'class' => 'badge-soft-secondary'];
						echo '<span class="badge rounded-pill '.$status['class'].' px-2 py-1 font-size-12">'.$status['label'].'</span>';
					?>
				</td>
				<td>
					<?php 
						if ($this->action && !check_action_permission(get_user_role(), 'change_profession', 'print_employee_batch_detail')) {
						echo '<a type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Print" href="' . base_url('admin/hr/change-profession/print-change-profession-detail/' . $value['id']) . '" target="_blank">
									<i class="mdi mdi-printer font-size-18"></i>
								</a>';
						}
					?>
				</td>
			</tr>
		<?php 
			}}else{ 
		?>
		<tr>
			<td colspan="13" align="center">Data not available</td>
		</tr>
		<?php } ?>
	</tbody>
</table>

<script>
	$(document).ready(function() {
		$('#batchDetailTable').DataTable({
			"ordering": false,
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			"pageLength": 10,
			"language": {
				"emptyTable": "No data available in table",
				"info": "Showing _START_ to _END_ of _TOTAL_ entries",
				"infoEmpty": "Showing 0 to 0 of 0 entries",
				"lengthMenu": "Show _MENU_ entries",
				"search": "Search:",
				"zeroRecords": "No matching records found",
				"paginate": {
					"first": "First",
					"last": "Last",
					"next": "Next",
					"previous": "Previous"
				}
			}
		});
	});
</script>