<div class="modal-header">
	<h5 class="modal-title mt-0" id="addRiderModalLabel">Profile Suspend</h5>
	<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
	<div id="responseContainer"></div>
	<div class="mt-2">
		<div class="size-inner-section px-1 py-1 mx-1">
			<div class="card-header">Basic Detail</div>
			<div class="d-flex align-items-center employee-detail">
				<div class="image">
					<?php if(!empty($emp_detail['employee_pic']) && $emp_detail['employee_pic'] !== ''){ ?>
						<img src="<?php echo $emp_detail['employee_pic'];?>" class="rounded" width="140">
					<?php }else{ ?>
						<img src="<?php echo base_url('images/user-img.png'); ?>" class="rounded" width="140">
					<?php } ?>
				</div>
				<div class="p-3 w-100">
					<h5 class="mb-0 mt-0"> <?php echo $emp_detail['full_name'];?> / <?php echo $emp_detail['employee_arabic_name'];?> </h5>
					<span><?php echo $emp_detail['designation_name'];?> | <?php echo $emp_detail['department_name'];?></span>
					<hr class="my-1">
					<table>
						<tr>
							<td>Emp No.</td>
							<td> : </td>
							<td><?php echo $emp_detail['emp_no'];?></td>
						</tr>
						<tr>
							<td>Nationality</td>
							<td> : </td>
							<td><?php echo $emp_detail['nationality_name'];?></td>
						</tr>
						<tr>
							<td>Flex Number</td>
							<td> : </td>
							<td><?php echo (!empty($sim_detail['mobile'])) ? $sim_detail['mobile'] : 'NA';?></td>
						</tr>
						<tr>
							<td>Mobile No</td>
							<td> : </td>
							<td><?php echo $emp_detail['mobile'];?></td>
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
			<div class="card-header">Profile Detail</div>
			
			<div class="row p-2">
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<label for="platform">Aggregator <span class="text-danger">*</span></label>
					<select name="platform" id="platform" class="form-select" required disabled>
						<option value="">Select Aggregator</option>
						<?php foreach(fdCompanyHelper() as $fdcompany) { ?>
							<option value="<?php echo $fdcompany->id; ?>" <?php echo ($fdcompany->id == $profile['platform']) ? ' selected ' : '';?>><?php echo $fdcompany->company_name; ?></option>
						<?php } ?>
					</select>
				</div>

				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<label for="id_number">Aggregator ID <span class="text-danger">*</span></label>
					<input type="text" name="id_number" id="id_number" class="form-control" value="<?php echo $profile['id_number'];?>" required disabled />
				</div>
				
				<div id="aggregator_detail" class="col-md-12 aggregator-detail"></div>
				
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<label for="rider_status">Current Status</label>
					<select name="rider_status" id="rider_status" class="form-control" disabled readonly>
						<option value="">Select ID Type</option>
						<option value="active" <?php echo ($profile['rider_status'] == 'active') ? ' selected ' : '';?>>Active</option>
						<option value="inactive" <?php echo ($profile['rider_status'] == 'inactive') ? ' selected ' : '';?>>Inactive</option>
						<option value="requested" <?php echo ($profile['rider_status'] == 'requested') ? ' selected ' : '';?> >Requested</option>
						<option value="suspend" <?php echo ($profile['rider_status'] == 'suspend') ? ' selected ' : '';?> disabled>Suspend</option>
					</select>
				</div>
			</div>
		</div>
		<div class="size-inner-section px-1 py-1 mx-1">
			<div class="card-header">Fill Suspend Information</div>
			<?php echo form_open("admin/logistic-management/rider/save-suspend", array("id" => "riderProfileForm", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
				<input type="hidden" id="emp_id" name="employee_id" value="<?php echo $emp_detail['id'];?>" required />
				<input type="hidden" id="id" name="id" value="<?php echo $profile['id'];?>" required />
				<div class="row p-2">

					<div class="col-md-12 col-sm-12 mb-2 form-group">
						<label for="rider_status">Status <span class="text-danger">*</span></label>
						<select name="rider_status" id="rider_status" class="form-control" readonly>
							<option value="">Select ID Type</option>
							<option value="suspend" selected>Suspend</option>
						</select>
					</div>
					<div class="col-lg-6 col-md-4 col-sm-12">
						<div class="form-group mb-2">
							<label>Suspend From <span class="text-danger">*</span></label>
							<input type="datetime-local" class="form-control" id="suspend_from" name="suspend_from" autocomplete="off" min="<?php echo $profile['activation_date'];?>" placeholder="Start Date" />
						</div>
					</div>
					<div class="col-lg-6 col-md-4 col-sm-12">
						<div class="form-group mb-2">
							<label>Suspend To <span class="text-danger">*</span></label>
							<input type="datetime-local" class="form-control" id="suspend_to" name="suspend_to" autocomplete="off" min="<?php echo $profile['activation_date'];?>" placeholder="Start Date" />
						</div>
					</div>
					<div class="col-md-12 col-sm-12 mb-2 form-group">
						<label for="reason">Reason <span class="text-danger">*</span></label>
						<select name="reason" id="reason" class="form-select" required>
							<option value="">Select Reason</option>
							<?php foreach (masterReasons('suspend_reason') as $mreason) { ?>
								<option value="<?php echo $mreason->reason_title_en;?>" <?php echo ($profile['reason'] == $mreason->reason_title_en) ? ' selected disabled ' : '';?>><?php echo $mreason->reason_title_en;?></option>
							<?php } ?>
						</select>
					</div>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<div class="modal-footer" id="searchModalFooter">
	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetModalData()">Cancel</button>
	<button type="submit" form="riderProfileForm" class="btn btn-custom-success">Suspend</button>
</div>

<script>
	$(document).ready(function() {
		setIdDetail();
		$('#riderProfileForm').submit(function(e) {
			e.preventDefault();
			var formData = new FormData($(this)[0]);
			$.ajax({
				url: '<?php echo base_url('admin/logistic-management/rider/save-suspend');?>',
				type: 'POST',
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				success: function(response) {
					// Handle server response
					if (response.type === 'success') {
						//initializeDataTable();
						toastr.success(response.message);
						//$('#addRiderModal').modal('hide');
						setTimeout(function() {
							location.reload();
						}, 800);
					} else {
						toastr.error(response.message);
					}
				},
				error: function() {
					toastr.error('An error occurred. Please try again.');
				}
			});
		});
	});

	function formatDate(dateString) {
		const date = new Date(dateString);
		const day = String(date.getDate()).padStart(2, '0');
		const month = String(date.getMonth() + 1).padStart(2, '0');
		const year = date.getFullYear();
		return `${day}-${month}-${year}`;
	}

	function setIdDetail() {
		var idNumber = $('#id_number').val(); 
		if (idNumber !== "") {
			$.ajax({
				url: "<?php echo base_url('admin/logistic-management/rider/get-aggregator-id-detail'); ?>",
				type: "POST",
				data: {
					id_number: idNumber
				},
				dataType: "json",
				success: function(data) {
					if (data.status === 'success') {
						// Build the detail HTML
						var detailHtml = '<div class="size-inner-section p-3 my-2">';
						detailHtml += '<h5>Aggregator Details:</h5>';
						detailHtml += '<p class="mb-0"><strong>ID Type:</strong> ' + data.output.id_type + '</p>';
						detailHtml += '<p class="mb-0"><strong>Owner Name:</strong> ' + data.output.full_name + '</p>';
						detailHtml += '<p class="mb-0"><strong>Owner Name:</strong> ' + data.output.full_name + '</p>';
						detailHtml += '<p class="mb-0"><strong>Request Date:</strong> ' + formatDate(data.output.request_date) + '</p>';
						detailHtml += '<p class="mb-0"><strong>Activation Date:</strong> ' + formatDate(data.output.activation_date) + '</p>';
						detailHtml += '</div>';
						$('#aggregator_detail').html(detailHtml);
					} else {
						$('#aggregator_detail').html('<p class="text-danger">' + data.message + '</p>');
					}
				},
				error: function() {
					$('#aggregator_detail').html('<p class="text-danger">An error occurred while fetching aggregator details.</p>');
				}
			});
		} else {
			$('#aggregator_detail').html('');
		}
	}
</script>
