<div class="size-inner-section px-1 py-1 mx-1">
	<div class="card-header">Rider Detail</div>
	<div class="d-flex align-items-center employee-detail">
		<div class="image">
			<img src="<?= !empty($emp_detail['employee_pic']) ? $emp_detail['employee_pic'] : base_url('images/user-img.png'); ?>"
				class="rounded" width="140">
		</div>
		<div class="p-3 w-100">
			<h5 class="mb-0 mt-0"> <?= $emp_detail['full_name']; ?> / <?= $emp_detail['employee_arabic_name']; ?> </h5>
			<span><?= $emp_detail['designation_name']; ?> | <?= $emp_detail['department_name']; ?></span>
			<hr class="my-1">
			<table>
				<tr>
					<td>Emp No.</td>
					<td> : </td>
					<td><?= $emp_detail['emp_no']; ?></td>
				</tr>
				<tr>
					<td>Nationality</td>
					<td> : </td>
					<td><?= $emp_detail['nationality_name']; ?></td>
				</tr>
				<tr>
					<td>Flex Number</td>
					<td> : </td>
					<td><?= !empty($emp_detail['sim_mobile']) ? $emp_detail['sim_mobile'] : 'NA'; ?></td>
				</tr>
				<tr>
					<td>Mobile No</td>
					<td> : </td>
					<td><?= $emp_detail['mobile']; ?></td>
				</tr>
				<tr>
					<td>DL Number</td>
					<td> : </td>
					<td><?= !empty($emp_detail['driving_license_number']) ? $emp_detail['driving_license_number'] : 'NA'; ?></td>
				</tr>
				<tr>
					<td>Vehicle No</td>
					<td> : </td>
					<td>
						<?= !empty($emp_detail['vehicle_no'])
							? "{$emp_detail['vehicle_no']} / {$emp_detail['vehicle_model']} / {$emp_detail['vehicle_make']} " .
							($emp_detail['vehicle_type'] == 'bike' ? '<i class="fas fa-motorcycle"></i>' : '<i class="mdi mdi-car"></i>')
							: 'NA'; ?>
					</td>
				</tr>
				<tr>
					<td>GPS Tracking</td>
					<td> : </td>
					<td><?= !empty($emp_detail['gps_device_serial']) ? '<span class="text-success">Yes</span>' : '<span class="text-danger">No</span>'; ?></td>
				</tr>
				<tr>
					<td>Team Name</td>
					<td> : </td>
					<td><?= !empty($emp_detail['team_detail']['team_name']) ? $emp_detail['team_detail']['team_name'] : 'NA'; ?></td>
				</tr>
				<tr>
					<td>Team Leader</td>
					<td> : </td>
					<td><?= !empty($emp_detail['team_detail']['team_leader_name']) ? $emp_detail['team_detail']['team_leader_name'] : 'NA'; ?></td>
				</tr>
			</table>
		</div>
	</div>
</div>

<?php echo form_open("admin/hr-module/sanat-al-amar/submit", array("id" => "sanatCollectionForm", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
<div class="size-inner-section px-1 py-1 mx-1">
	<div class="card-header">Fill Detail</div>
	<input type="hidden" id="emp_id" name="emp_id" value="<?php echo $emp_detail['employee_id']; ?>" required />
	<input type="hidden" id="rider_id" name="rider_id" value="<?php echo $emp_detail['rider_id']; ?>" required />
	<div class="row p-2">
		<div class="col-md-12" id="dateCheckMsg">
		</div>
		<div class="col-md-6 col-sm-12 mb-2 form-group">
			<label for="attendance_date">Date <span class="text-danger">*</span></label>
			<input type="date" class="form-control" id="attendance_date" name="date" max="<?php echo date('Y-m-d'); ?>" required />
		</div>

		<div class="col-md-6 col-sm-12 mb-3 form-group">
			<label for="sanat_no">Change Status<span class="text-danger">*</span></label>
			<select class="form-control" name="new_status" id="new_status">
				<option value="" disabled selected>Choose...</option>
				<option value="P">P - Regular</option>
				<option value="L">L - Leave</option>
				<option value="A">A - Absent</option>
				<option value="WO">WO - Week Off</option>
				<option value="AL">AL - Annual Leave</option>
				<option value="SL">SL - Sick Leave</option>
				<option value="CL">CL - Casual Leave</option>
				<option value="ML">ML - Maternity Leave</option>
				<option value="PL">PL - Paternity Leave</option>
				<option value="COL">COL - Compassionate Leave</option>
				<option value="BT">BT - Business Trip</option>
				<option value="UL">UL - Unpaid Leave</option>
				<option value="MAR">MAR - Marriage Leave</option>
				<option value="WL">WL - Widow Leave</option>
			</select>
		</div>
		<div class="col-md-12 col-sm-12 mb-3 form-group">
			<label for="description">Remark</label>
			<input type="text" class="form-control" id="remark" name="remark" maxlength="255" />
		</div>
	</div>
</div>

<?php echo form_close(); ?>

<script>
	$(document).ready(function() {
		$(".input-mask").inputmask();
		$('.dropify').dropify();
		$('#sanatCollectionForm').submit(function(e) {
			e.preventDefault();
			var formData = new FormData($(this)[0]);
			$.ajax({
				url: '<?php echo base_url('admin/manage-attendance/save'); ?>',
				type: 'POST',
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				success: function(response) {
					if (response.type === 'success') {
						toastr.success(response.message);
						$('#sanatCollectionForm')[0].reset();
						$('#addCashModal').modal('hide');
						initializeDataTable();
					} else {
						toastr.error(response.message);
					}
				},
				error: function() {
					toastr.error('An error occurred. Please try again.');
				}
			});
		});

		$('#attendance_date').on('change', function() {
			$.get('<?php echo base_url('admin/manage-attendance/check_date'); ?>', {
				'date': $(this).val(),
				'emp_id': $('#emp_id').val()
			}, function(response) {
				$('#dateCheckMsg').html(response.message);
				if (response.type) {
					$('#new_status option[value="' + response.status + '"]').prop('selected', true);
					$('#remark').val(response.remark);
				} else {
					$('#new_status').val('');
					$('#remark').val('');
				}
			}, "json");
		});
	});
</script>