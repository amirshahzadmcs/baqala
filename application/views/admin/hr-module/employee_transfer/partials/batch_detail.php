<table id="batchDetailTable" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
	<thead>
		<tr>
			<th>S.No.</th>
			<th>Batch No.</th>
			<th>Emp No.</th>
			<th>Employee Name</th>
			<th>Designation</th>
			<th>Iqama No.</th>
			<th>Old Employer</th>
			<th>New Employer</th>
			<th>Transfer Type</th>
			<th>Request Date</th>
			<th>Update Joining Date</th>
			<th>Reason</th>
			<th>Contract ID</th>
			<th>Contract Period</th>
			<th>Contract Start Date</th>
			<th>Contract End Date</th>
			<th>Status</th>
			<th>Tools</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if(count($transfer_list) > 0){ 
			$count = 1;

			// status mapping with badge classes
			$statuses = [
				1 => ['label' => 'Pending Employee Approval', 'class' => 'badge-soft-warning'],
				2 => ['label' => 'Pending Current Employer Approval', 'class' => 'badge-soft-info'],
				3 => ['label' => 'Completing', 'class' => 'badge-soft-success'],
				4 => ['label' => 'Rejected', 'class' => 'badge-soft-danger']
			];

			// transfer type mapping
			$transferTypes = [
				1 => 'Transfer Laborer from another Establishment',
				2 => 'Internal Transfer'
			];

			foreach ($transfer_list as $key => $value) {
		?>
			<tr>
				<td><?php echo $count++;?></td>
				<td><?php echo $value['batch_no'];?></td>
				<td><?php echo $value['emp_no'];?></td>
				<td><?php echo $value['full_name'];?></td>
				<td><?php echo $value['designation_name'];?></td>
				<td><?php echo $value['iqama_no'];?></td>
				<td><?php echo $value['old_employer_id'] .' - '. $value['old_employer_name'];?></td>
				<td><?php echo $value['new_employer_id'] .' - '. $value['new_employer_name'];?></td>

				<!-- Transfer Type -->
				<td class="text-center">
					<?php echo $transferTypes[$value['transfer_type']] ?? $value['transfer_type']; ?>
				</td>

				<td><?php echo date('d-m-Y', strtotime($value['request_date']));?></td>
				<td class="text-center"><?php echo ucfirst($value['update_joining_date']);?></td>
				<td><?php echo $value['reason'] ?? 'NA';?></td>
				<td class="text-center"><?php echo $value['contract_id'] ?? 'NA';?></td>
				<td class="text-center"><?php echo $value['contract_period'] ?? 'NA';?></td>
				<td class="text-center"><?php echo $value['contract_start_date'] ? date('d-m-Y', strtotime($value['contract_start_date'])) : 'NA';?></td>
				<td class="text-center"><?php echo $value['contract_end_date'] ? date('d-m-Y', strtotime($value['contract_end_date'])) : 'NA';?></td>
				<!-- Status with badge -->
				<td align="center">
					<?php 
						$status = $statuses[$value['status']] ?? ['label' => $value['status'], 'class' => 'badge-soft-secondary'];
						echo '<span class="badge rounded-pill '.$status['class'].' px-2 py-1 font-size-12">'.$status['label'].'</span>';
					?>
				</td>

				<td>
					<?php
						$actionButtons = '';
					?>
					<?php 
						if (!in_array($value['status'], [3, 4])) {
							if (check_action_permission(get_user_role(), 'employee_transfer', 'update_status')) {
							$actionButtons .=  '<button type="button" class="btn btn-outline-success btn-custom-light btn-sm edit approve-transfer-btn" data-toggle="tooltip" title="Approve" data-transfer_id="'.$value['id'].'">
									<i class="mdi mdi-check-circle-outline font-size-18"></i>
								</button>';
							}
							if (check_action_permission(get_user_role(), 'employee_transfer', 'update_status')) {
							$actionButtons .= '
								<button type="button" class="btn btn-outline-danger btn-custom-light btn-sm edit reject-transfer-btn" data-toggle="tooltip" title="Reject" data-transfer_id="'.$value['id'].'">
									<i class="mdi mdi-close-circle-outline font-size-18"></i>
								</button>';
							}
							if (check_action_permission(get_user_role(), 'employee_transfer', 'print_employee_batch_detail')) {
							$actionButtons .= '
								<a type="button" class="btn btn-outline-primary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Print" href="' . base_url('admin/hr/employee-transfer/print-transfer-detail/' . $value['id']) . '" target="_blank">
									<i class="mdi mdi-printer font-size-18"></i>
								</a>';
							}
						} else {
							if (check_action_permission(get_user_role(), 'employee_transfer', 'print_employee_batch_detail')) {
							$actionButtons .= '
								<a type="button" class="btn btn-outline-primary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Print" href="' . base_url('admin/hr/employee-transfer/print-transfer-detail/' . $value['id']) . '" target="_blank">
									<i class="mdi mdi-printer font-size-18"></i>
								</a>';
							}
						}
						echo $actionButtons;
					?>
				</td>
			</tr>
		<?php 
			}}else{ 
		?>
		<tr>
			<td colspan="18" align="center">Data not available</td>
		</tr>
		<?php } ?>
	</tbody>
</table>

<script>
	$(document).on('click', '.approve-transfer-btn, .reject-transfer-btn', function() {
		let transfer_id = $(this).data('transfer_id');
		let isApprove = $(this).hasClass('approve-transfer-btn');
		let status = isApprove ? '3' : '4';
		let actionText = isApprove ? 'approve' : 'reject';

		if (isApprove) {
			// Show input form for Approve action
			Swal.fire({
				title: 'Approve Transfer',
				html: `
					<div class="mt-3" style="text-align: left;">
						<label for="qiwa_contract_no"><strong>Qiwa Contract No</strong></label>
						<input type="text" id="qiwa_contract_no" class="form-control swal2-input mt-0" placeholder="Enter Qiwa Contract No" maxlength="30" style="width: 100%;">

						<label for="qiwa_contract_date"><strong>Qiwa Contract Date</strong></label>
						<input type="date" id="qiwa_contract_date" class="form-control swal2-input mt-0" style="width: 100%;">

						<div style="margin-top:10px;">
							<input type="checkbox" class="checkbox" id="update_hr_date">
							<label for="update_hr_date" style="vertical-align: middle;">Update Operation Date in HR System</label>
						</div>
					</div>
				`,
				focusConfirm: false,
				showCancelButton: true,
				confirmButtonText: 'Approve',
				allowOutsideClick: false,
				allowEscapeKey: false,
				preConfirm: () => {
					const contractNo = document.getElementById('qiwa_contract_no').value.trim();
					const contractDate = document.getElementById('qiwa_contract_date').value;
					const updateHr = document.getElementById('update_hr_date').checked ? 1 : 0;

					// Validation
					if (contractNo === '' || contractNo.length > 30) {
						Swal.showValidationMessage('Qiwa Contract No is required (max 30 characters)');
						return false;
					}
					if (contractDate === '') {
						Swal.showValidationMessage('Qiwa Contract Date is required');
						return false;
					}

					return { contractNo, contractDate, updateHr };
				}
			}).then((result) => {
				if (result.isConfirmed) {
					let formData = {
						transfer_id: transfer_id,
						status: status,
						qiwa_contract_no: result.value.contractNo,
						qiwa_contract_date: result.value.contractDate,
						update_hr_date: result.value.updateHr
					};

					$.ajax({
						url: "<?php echo base_url('admin/hr-module/transfer/update-status'); ?>",
						type: "POST",
						data: formData,
						dataType: "json",
						success: function(res) {
							if (res.status === 'success') {
								Swal.fire({
									icon: 'success',
									title: 'Approved!',
									text: res.message,
									timer: 2000,
									showConfirmButton: false
								}).then(() => {
									location.reload();
								});
							} else {
								Swal.fire({
									icon: 'error',
									title: 'Oops...',
									text: res.message
								});
							}
						}
					});
				}
			});
		} else {
			// Reject confirmation (no inputs)
			Swal.fire({
				title: 'Are you sure?',
				text: "Do you really want to reject this transfer request?",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#d33',
				cancelButtonColor: '#6c757d',
				confirmButtonText: 'Yes, reject it!'
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						url: "<?php echo base_url('admin/hr-module/transfer/update-status'); ?>",
						type: "POST",
						data: { transfer_id: transfer_id, status: status },
						dataType: "json",
						success: function(res) {
							if (res.status === 'success') {
								Swal.fire({
									icon: 'success',
									title: 'Rejected!',
									text: res.message,
									timer: 2000,
									showConfirmButton: false
								}).then(() => {
									location.reload();
								});
							} else {
								Swal.fire({
									icon: 'error',
									title: 'Oops...',
									text: res.message
								});
							}
						}
					});
				}
			});
		}
	});
</script>