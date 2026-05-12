<?php $this->load->view('admin/home/header');?>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Master Package</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/hr/master/package/list');?>">Master Package</a></li>
						<li class="breadcrumb-item active">Edit</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-none d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-2" title="Back" href="<?php echo base_url('admin/hr/master/package/list');?>"><i class="fa fa-reply"></i> Back</a>
					<button form="packageForm" type="submit" class="btn btn-sm btn-custom-success pull-right" title="Save"><i class="fa fa-save"></i> Save</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end page title -->

<div class="container-fluid">
	<div class="page-content-wrapper">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<form class="needs-validation" method="POST" id="packageForm" action="<?php echo base_url('admin/hr/master/package/save');?>" novalidate>
							<input type="hidden" id="id" name="id" value="<?php echo $id;?>">
							<div class="row">
								<div class="col-md-6">
									<div class="mb-3">
										<label for="package_name" class="form-label">Package Name (English)<span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="package_name" value="<?php echo $package_name;?>" name="package_name" required>
										<div class="invalid-feedback">
											Please provide a Package name in english.
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label for="package_name_ar" class="form-label">Package Name (Arabic)</label>
										<input type="text" class="form-control rtl-input" id="package_name_ar" value="<?php echo $package_name_ar;?>" name="package_name_ar">
										<div class="invalid-feedback">
											Please provide a package name in arabic.
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-12 mb-3 form-group">
									<label for="basic_salary">Basic Salary<span class="text-danger">*</span></label>
									<input id="basic_salary" name="basic_salary" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" required="" inputmode="numeric" value="<?php echo $basic_salary;?>" style="text-align: right;">
								</div>
								<div class="col-md-6 col-sm-12 mb-3 form-group">
									<label for="housing_allow">Housing</label>
									<input type="text" class="form-control" id="housing_allow" name="housing_allow" value="<?php echo $housing_allow;?>" />
								</div>
								<div class="col-md-6 col-sm-12 mb-3 form-group">
									<label for="transportation_allow">Transportation Allowance</label>
									<input type="text" class="form-control" id="transportation_allow" name="transportation_allow" value="<?php echo $transportation_allow;?>" />
								</div>
								<div class="col-md-6 col-sm-12 mb-3 form-group">
									<label for="food_allow">Food Allowance</label>
									<input id="food_allow" name="food_allow" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" inputmode="numeric" value="<?php echo $food_allow;?>" style="text-align: right;">
								</div>
								<div class="col-md-6 col-sm-12 mb-3 form-group">
									<label for="order_allowance">Other Allowance</label>
									<input type="text" class="form-control" id="order_allowance" name="order_allowance" value="<?php echo $order_allowance;?>" />
								</div>
								<div class="col-md-6 col-sm-12 mb-3 form-group">
									<label for="no_of_orders">No. of Orders</label>
									<input type="text" class="form-control" id="no_of_orders" name="no_of_orders" value="<?php echo $no_of_orders;?>" />
								</div>
								<div class="col-md-6 col-sm-12 mb-3 form-group">
									<label for="total_package">Total Package</label>
									<input type="text" class="form-control" id="total_package" name="total_package" value="<?php echo $total_package;?>" />
								</div>
								<div class="col-md-6 col-sm-12 mb-3 form-group">
									<label for="vacations">Vacation</label>
									<input type="text" class="form-control" id="vacations" name="vacations" value="<?php echo $vacations;?>" />
								</div>
								<div class="col-md-6 col-sm-12 mb-3 form-group">
									<label for="medical_insurance">Medical Insurance (Use comma ',' for line break)</label>
									<input type="text" class="form-control" id="medical_insurance" name="medical_insurance" value="<?php echo $medical_insurance;?>" />
								</div>
								<div class="col-md-6 col-sm-12 mb-3 form-group">
									<label for="remarks">Remarks (Use comma ',' for line break)</label>
									<input type="text" class="form-control" id="remarks" name="remarks" value="<?php echo $remarks;?>" />
								</div>
								<div class="col-md-6 col-sm-12 mb-3 form-group">
									<label for="remarks">Offer Validity</label>
									<input type="text" class="form-control" id="offer_validity" name="offer_validity" value="<?php echo $offer_validity;?>" />
								</div>

								<div class="col-md-6 col-sm-12 mb-3 form-group">
									<label for="project_code">Project Code</label>
									<input type="text" class="form-control" id="project_code" name="project_code" value="<?php echo (isset($project_code) && !empty($project_code)) ? $project_code : 'FDHS'; ?>" />
								</div>
								<div class="col-md-6 col-sm-12 mb-3 form-group">
									<label for="project_name">Project Name</label>
									<input type="text" class="form-control" id="project_name" name="project_name" value="<?php echo (isset($project_name) && !empty($project_name)) ? $project_name : 'Food Delivery – Hunger Station'; ?>" />
								</div>
								<div class="col-md-6 col-sm-12 mb-2 form-group">
									<label for="department">Department</label>
									<select name="department" id="department" class="form-select select2">
										<option value="">Select Department</option>
										<?php foreach(masterDepartments() as $depart) { ?>
											<option value="<?php echo $depart->id; ?>" <?php echo ($department == $depart->id) ? ' selected ' : '' ?>><?php echo $depart->name; ?></option>
										<?php } ?>
									</select>
								</div>
								
								<div class="col-md-6 col-sm-12 mb-3 form-group">
									<label for="reporting_to">Reporting to</label>
									<select name="reporting_to" id="reporting_to" class="form-select select2" data-placeholder="Choose Reporting to">
										<option value="">Select Designation</option>
										<?php 
										if(!empty($reporting_to)){
										foreach(masterDesignation($department) as $pos) { ?>
											<option value="<?php echo $pos->id; ?>" <?php echo ($reporting_to == $pos->id) ? ' selected ' : '' ?>><?php echo $pos->name; ?></option>
										<?php }}else{ ?>
											<option value="">Select Department First</option>
										<?php } ?>
									</select>
								</div>
								
								<div class="col-md-6 col-sm-12 mb-3 form-group">
									<label for="work_location">Work Location</label>
									<input type="text" class="form-control" id="work_location" name="work_location" value="<?php echo (isset($work_location)) ? $work_location : 'Riyadh'; ?>" />
								</div>
								<div class="col-md-6 col-sm-12 mb-3 form-group">
									<label for="working_hrs">Woking Hours</label>
									<input type="text" class="form-control" id="working_hrs" name="working_hrs" value="<?php echo (isset($working_hrs)) ? $working_hrs : 'Flexible – 6 Days'; ?>" />
								</div>
								<div class="col-md-6 col-sm-12 mb-3 form-group">
									<label for="probation_period">Probation Period</label>
									<input type="text" class="form-control" id="probation_period" name="probation_period" value="<?php echo (isset($probation_period)) ? $probation_period : '90 Days'; ?>" />
								</div>
								<div class="col-md-6 col-sm-12 mb-3 form-group">
									<label for="contract_period">Contract Period</label>
									<input type="text" class="form-control" id="contract_period" name="contract_period" value="<?php echo (isset($contract_period)) ? $contract_period : 'Two (2) Years'; ?>" />
								</div>
								<div class="col-md-6 col-sm-12 mb-2 form-group">
									<label for="package_status">Status<span class="text-danger">*</span></label>
									<select name="status" id="package_status" class="form-select select2" required>
										<option value="">Select Status</option>
										<option value="1" <?php echo ($status == '1') ? ' selected ' : '' ?>>Active</option>
										<option value="2" <?php echo ($status == '2') ? ' selected ' : '' ?>>Inactive</option>
									</select>
								</div>
							</div>
						</form>

					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<?php $this->load->view('admin/home/footer');?>
<script>
	$('#department').change(function() {
		var department_id = $(this).find('option:selected').val();
		//alert(department_id);
		$.ajax({
			url: "<?php echo base_url(); ?>admin/hr/master/package/departmentwise_designations",
			data: {
				department_id: department_id
			},
			dataType: "json",
			type: "POST",
			success: function(data) {
				//console.log(data);
				var html = '<option value="">Select Designation</option>';
				if (Object.keys(data).length > 0) {
					$.each(data, function(index, item) {
						html += '<option value="' + item.id + '" data-id="' + item.id + '">' + item.name + '</option>';
					});
				} else {
					var html = '<option value="">No designation found</option>';
				}
				$('#reporting_to').html(html);
			},
			error: function(repsonse) {
				console.log(repsonse);
			}
		});
	});
</script>
