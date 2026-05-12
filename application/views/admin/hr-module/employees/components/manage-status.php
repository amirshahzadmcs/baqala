<div class="modal-header">
	<h5 class="modal-title mt-0" id="manageEmployeeModalLabel">Manage Employee Status</h5>
	<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
	<div id="responseContainer"></div>
	<div class="mt-2">
		<div class="size-inner-section px-1 py-1 mx-1">
			<div class="card-header">Basic Detail</div>
			<div class="d-flex align-items-center employee-detail">
				<div class="image">
					<?php if(!empty($emp_detail->employee_pic) && $emp_detail->employee_pic !== ''){ ?>
						<img src="<?php echo $emp_detail->employee_pic;?>" class="rounded" width="140">
					<?php }else{ ?>
						<img src="<?php echo base_url('images/user-img.png'); ?>" class="rounded" width="140">
					<?php } ?>
				</div>
				<div class="p-3 w-100">
					<h5 class="mb-0 mt-0"> <?php echo $emp_detail->full_name;?> / <?php echo $emp_detail->employee_arabic_name;?> </h5>
					<span><?php echo $emp_detail->designation_name;?> | <?php echo $emp_detail->department_name;?></span>
					<hr class="my-1">
					<table>
						<tr>
							<td>Emp No.</td>
							<td> : </td>
							<td><?php echo $emp_detail->emp_no;?></td>
						</tr>
						<tr>
							<td>Nationality</td>
							<td> : </td>
							<td><?php echo $emp_detail->nationality_name;?></td>
						</tr>
						<tr>
							<td>Flex Number</td>
							<td> : </td>
							<td><?php echo (!empty($sim_detail['mobile'])) ? $sim_detail['mobile'] : 'NA';?></td>
						</tr>
						<tr>
							<td>Mobile No</td>
							<td> : </td>
							<td><?php echo $emp_detail->mobile;?></td>
						</tr>
						<tr>
							<td>DL Number</td>
							<td> : </td>
							<td><?php if(!empty($other_detail['driving_license_number'])){ echo $other_detail['driving_license_number'];}else{ echo 'NA';}?></td>
						</tr>
						<tr>
							<td>Vehicle No</td>
							<td> : </td>
							<td><?php if(!empty($vehicle_detail['vehicle_no'])){ echo $vehicle_detail['vehicle_no'];?> / <?php echo $vehicle_detail['vehicle_model'];?> / <?php echo $vehicle_detail['make_name'];?> <?php echo ($vehicle_detail['vehicle_type'] == 'bike') ? '<i class="fas fa-motorcycle"></i>' : '<i class="mdi mdi-car"></i>';}else{ echo 'NA';}?></td>
						</tr>
						<tr>
							<td>GPS Tracking</td>
							<td> : </td>
							<td><?php echo (!empty($vehicle_detail['gps_device_serial'])) ? '<span class="text-success">Yes</span>' : '<span class="text-danger">No</span>';?></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		
		<div class="size-inner-section px-1 py-1 mx-1">
			<div class="card-header">Update Status</div>
			<?php echo form_open("admin/hr/employees/update-status", array("id" => "statusUpdateForm", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
				<input type="hidden" id="emp_id" name="employee_id" value="<?php echo $emp_detail->id;?>" required />
				<div class="row p-2">

					<div class="col-md-12 col-sm-12 mb-2 form-group">
						<label for="emp_status">Status <span class="text-danger">*</span></label>
						<select name="status" id="emp_status" class="form-select" required>
							<option value="">Select Status</option>
							<option value="Active" <?php echo ($emp_detail->status == 'Active') ? ' selected ' : '' ?>>Active</option>
							<option value="Terminated" <?php echo ($emp_detail->status == 'Terminated') ? ' selected ' : '' ?>>Terminated</option>
						</select>
					</div>
                    <div class="col-md-12 col-sm-12 mb-2 form-group">
                        <label for="terminate_reason">Reason <span class="text-danger">*</span></label>
                        <select name="terminate_reason" id="terminate_reason" class="form-select" required>
                            <option value="">Select Reason</option>
							<option value="Final Exit - Attendance No Show" <?php echo ($emp_detail->terminate_reason == 'Final Exit - Attendance No Show') ? ' selected ' : '' ?>>Final Exit - Attendance No Show</option>
							<option value="Final Exit - Contract Completed" <?php echo ($emp_detail->terminate_reason == 'Final Exit - Contract Completed') ? ' selected ' : '' ?>>Final Exit - Contract Completed</option>
							<option value="Final Exit - Refusal to Work" <?php echo ($emp_detail->terminate_reason == 'Final Exit - Refusal to Work') ? ' selected ' : '' ?>>Final Exit - Refusal to Work</option>
							<option value="Final Exit - Resigned" <?php echo ($emp_detail->terminate_reason == 'Final Exit - Resigned') ? ' selected ' : '' ?>>Final Exit - Resigned</option>
							<option value="Resigned - Final Exit" <?php echo ($emp_detail->terminate_reason == 'Resigned - Final Exit') ? ' selected ' : '' ?>>Resigned - Final Exit</option>
							<option value="Resigned - Local Transferred" <?php echo ($emp_detail->terminate_reason == 'Resigned - Local Transferred') ? ' selected ' : '' ?>>Resigned - Local Transferred</option>
                            <option value="Terminated - Absconded" <?php echo ($emp_detail->terminate_reason == 'Terminated - Absconded') ? ' selected ' : '' ?>>Terminated - Absconded</option>
                            <option value="Terminated - Drop Off" <?php echo ($emp_detail->terminate_reason == 'Terminated - Drop Off') ? ' selected ' : '' ?>>Terminated - Drop Off</option>
							<option value="Terminated - Management" <?php echo ($emp_detail->terminate_reason == 'Terminated - Management') ? ' selected ' : '' ?>>Terminated - Management</option>
                            <option value="Terminated - Refusal to Work" <?php echo ($emp_detail->terminate_reason == 'Terminated - Refusal to Work') ? ' selected ' : '' ?>>Terminated - Refusal to Work</option>
                        </select>
                    </div>
					<div class="col-lg-12 col-md-12 col-sm-12 mb-3 form-group">
						<div class="form-group">
							<label for="last_working_date">Last Working Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control" id="last_working_date" name="last_working_date" autocomplete="off" max="<?php echo date('Y-m-d');?>" value="<?php echo ($emp_detail->last_working_date !== NULL || $emp_detail->last_working_date !== '0000-00-00') ? $emp_detail->last_working_date : '';?>" placeholder="Last Working Date" required />
						</div>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12">
						<div class="form-group">
							<div class="d-flex mb-2">
								<input class="checkbox me-2" type="checkbox" name="remove_reporting_roles" id="remove_reporting_roles" style="height: 36px;width: 36px;">
								<label class="form-check-label" for="remove_reporting_roles">
									Tick Check Box if You Want to Remove employee from Line Manager / Department Head role
								</label>
							</div>
						</div>
					</div>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<div class="modal-footer" id="searchModalFooter">
	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
	<button type="submit" form="statusUpdateForm" class="btn btn-custom-success">Update</button>
</div>
<script>
    $(document).ready(function () {
        // Function to handle the visibility of fields
        function toggleTerminationFields() {
            const status = $('#emp_status').val();
            if (status === 'Terminated') {
                $('#terminate_reason').closest('.form-group').show().find('select').prop('required', true);
                $('#last_working_date').closest('.form-group').show().find('input').prop('required', true);
                $('#remove_reporting_roles').closest('.form-group').show();
            } else {
                $('#terminate_reason').closest('.form-group').hide().find('select').prop('required', false).val('');
                $('#last_working_date').closest('.form-group').hide().find('input').prop('required', false).val('');
                $('#remove_reporting_roles').closest('.form-group').hide();
            }
        }

        // Initialize visibility on page load
        toggleTerminationFields();

        // Trigger visibility change on status selection
        $('#emp_status').change(function () {
            toggleTerminationFields();
        });

        // Submit form handling
		var initialStatus = '<?php echo $emp_detail->status; ?>';
		var initialReason = '<?php echo $emp_detail->terminate_reason; ?>';

		$('#statusUpdateForm').submit(function (e) {
			e.preventDefault();
			var currentStatus = $('#emp_status').val();
			var currentReason = $('#terminate_reason').val();
			if (initialStatus === currentStatus && initialReason === currentReason) {
				toastr.warning('The selected status is the same as the current status. No changes made.');
				return;
			}
			var formData = new FormData($(this)[0]);
			$.ajax({
				url: '<?php echo base_url('admin/hr/employees/update-status'); ?>',
				type: 'POST',
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				success: function (response) {
					if (response.type === 'success') {
						initializeDataTable();
						toastr.success(response.message);
						$('#manageEmployeeModal').modal('hide');
					} else {
						toastr.error(response.message);
					}
				},
				error: function () {
					toastr.error('An error occurred. Please try again.');
				}
			});
		});
    });
</script>

