<div class="modal-header">
	<h5 class="modal-title mt-0" id="addRiderModalLabel">Profile Transfer</h5>
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
					<label for="activate_date">Requested Date</label>
					<input type="text" class="form-control" value="<?php echo formatedDate($profile['request_date']);?>" readonly />
				</div>

				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<label for="platform">Platform</label>
					<select name="platform" id="platform" class="form-control" disabled readonly>
						<option value="">Select Platform</option>
						<?php foreach(fdCompanyHelper() as $fdcompany) { ?>
							<option value="<?php echo $fdcompany->id; ?>" <?php echo ($fdcompany->id == $profile['platform']) ? ' selected ' : '';?>><?php echo $fdcompany->company_name; ?></option>
						<?php } ?>
					</select>
				</div>
				
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<label for="id_type">ID Type</label>
					<select class="form-control" disabled readonly>
						<option value="">Select ID Type</option>
						<option value="Freelancer" <?php echo ($profile['id_type'] == 'Freelancer') ? ' selected ' : '';?>>Freelancer</option>
						<option value="Company" <?php echo ($profile['id_type'] == 'Company') ? ' selected ' : '';?>>Company</option>
					</select>
				</div>
				
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<label for="rider_status">Status</label>
					<select name="rider_status" id="rider_status" class="form-control" disabled readonly>
						<option value="">Select ID Type</option>
						<option value="active" <?php echo ($profile['rider_status'] == 'active') ? ' selected ' : '';?>>Active</option>
						<option value="inactive" <?php echo ($profile['rider_status'] == 'inactive') ? ' selected ' : '';?>>Inactive</option>
						<option value="requested" <?php echo ($profile['rider_status'] == 'requested') ? ' selected ' : '';?>>Requested</option>
						<option value="suspend" <?php echo ($profile['rider_status'] == 'suspend') ? ' selected ' : '';?>>Suspend</option>
					</select>
				</div>
				
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<label for="activate_date">Activatation Date</label>
					<input type="text" class="form-control" value="<?php echo formatedDate($profile['activate_date']);?>" readonly />
				</div>

				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<label for="id_number">ID Number</label>
					<input type="text" class="form-control" id="id_number" name="id_number" maxlength="25" value="<?php echo $profile['id_number'];?>" readonly />
				</div>
				
			</div>
		</div>
		<div class="size-inner-section px-1 py-1 mx-1">
			<div class="card-header">Fill Transfer Information</div>
			<?php echo form_open("admin/logistic-management/rider/save-transfer", array("id" => "riderProfileForm", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
				<input type="hidden" id="emp_id" name="employee_id" value="<?php echo $emp_detail['id'];?>" required />
				<input type="hidden" id="id" name="id" value="<?php echo $profile['id'];?>" required />
				<div class="row p-2">
					<div class="col-md-6 col-sm-12 mb-2 form-group">
						<label for="transfer_date">Transfer Date <span class="text-danger">*</span></label>
						<input type="date" class="form-control" name="transfer_date" id="transfer_date" min="<?php echo $profile['activate_date'];?>" required />
					</div>

					<div class="col-md-6 col-sm-12 mb-2 form-group">
						<label for="id_type">ID Type <span class="text-danger">*</span></label>
						<select name="id_type" id="id_type" class="form-select" required>
							<option value="">Select ID Type</option>
							<option value="Freelancer" <?php echo ($profile['id_type'] == 'Freelancer') ? ' selected disabled ' : '';?>>Freelancer</option>
							<option value="Company" <?php echo ($profile['id_type'] == 'Company') ? ' selected disabled ' : '';?>>Company</option>
						</select>
					</div>

				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<div class="modal-footer" id="searchModalFooter">
	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetModalData()">Cancel</button>
	<button type="submit" form="riderProfileForm" class="btn btn-custom-success">Transfer</button>
</div>

<script>
	$(document).ready(function() {

		$('#riderProfileForm').submit(function(e) {
			e.preventDefault();
			var formData = new FormData($(this)[0]);
			$.ajax({
				url: '<?php echo base_url('admin/logistic-management/rider/save-transfer');?>',
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
						setTimeout(function() {
							location.reload();
						}, 800);
						//$('#responseContainer').html('<div class="alert alert-success alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' + response.message + '</div>');
					} else {
						$('#responseContainer').html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' + response.message + '</div>');
					}
				},
				error: function() {
					$('#responseContainer').html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>An error occurred. Please try again.</div>');
				}
			});
		});
	});

</script>
