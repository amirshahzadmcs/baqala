
<?php $this->load->view('admin/home/header');?>

<style>
.required-field{
	color:#f00;
}

.tab-inner-section {
	box-shadow: 0px 1px 4px #c5c5c5;
	border-radius: 5px;
	margin-bottom: 10px;
}
.cv-documents{
	border: 1px dashed #a9a9a9;
	padding: 6px;
	width: 130px;
	height: 130px;
	margin-top: -9px;
}
.image-container {
	position: relative;
	display: inline-block;
}
.employee_form input, .employee_form textarea, .employee_form select, .employee_form select.select2, .employee_form .form-control{
    pointer-events: none;
	background-color: #f5f5f5;
    border: 1px dotted #ced4da;
}
.modal input, .modal textarea, .modal select, .modal select.select2{
    pointer-events: auto;
}
.employee-profle-pic {
    height: 39px;
    width: 36px;
    background-color: #eaedf1;
    padding: 3px;
}
::-webkit-scrollbar{
	height: 5px;
	width: 5px;
	background: #eee;
}
::-webkit-scrollbar-thumb:horizontal{
	background: #bbb;
	border-radius: 10px;
}
/*---- Sidebar ----*/
.modal .modal-dialog-aside{
	width: 40%;
	max-width:80%; height: 100%; margin:0;
	transform: translate(0); transition: transform .2s;
}


.modal .modal-dialog-aside .modal-content{  height: inherit; border:0; border-radius: 0;}
.modal .modal-dialog-aside .modal-content .modal-body{ overflow-y: auto }
.modal.fixed-left .modal-dialog-aside{ margin-left:auto;  transform: translateX(100%); }
.modal.fixed-right .modal-dialog-aside{ margin-right:auto; transform: translateX(-100%); }

.modal.show .modal-dialog-aside{ transform: translateX(0);  }
</style>
<div id="wait"><i class="fa fa-spinner fa-spin"></i><br>Updating..</div>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Employee</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/hr/employees'); ?>">Employees</a></li>
						<li class="breadcrumb-item active">Detail</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id');?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-2" title="Back" href="<?php echo base_url('admin/hr/employees'); ?>"><i class="fa fa-reply"></i> Back</a>
				</div>
				<?php if ($this->admin->getInfo()) {
					$info = explode("--", $this->admin->getInfo());
					$info_type = $info[0];
					$msg_data = $info[1];
					if ($info_type == 2) {
				?>
				<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					<strong><?php echo $msg_data; ?></strong>
				</div>
				<?php } else {?>
				<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<strong><?php echo $msg_data; ?></strong>
				</div>
				<?php }}
				$this->admin->removeInfo();?>
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
						<?php $this->load->view('admin/hr-module/employees/components/top-profile-section');?>
						<div class="step-wraper">
							<?php
								$active_step = 2;
								$nav_emp_id = isset($emp_detail->id) ? $emp_detail->id : null;
								$this->load->view('admin/hr-module/employees/components/view_step_navigation', compact('active_step', 'nav_emp_id'));
							?>
						</div>
						<div class="employee_form">
							<input type="hidden" id="id" name="id" value="<?php echo $emp_detail->id;?>" required />
							<!---- Saudi Address ----->
							<div class="row tab-inner-section px-2 py-4">
								<h4 class="header-title">Address in Saudi</h4><hr>
								<?php 
									$saudiAddress = (isset($emp_detail->saudi_address)) ? json_decode($emp_detail->saudi_address) : '';
								?>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="sa_building_no">Building Number</label>
									<input type="text" class="form-control" id="sa_building_no" name="saudi_address[building_no]" value="<?php echo $saudiAddress->building_no;?>" />
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="sa_street_name">Street Name</label>
									<input type="text" class="form-control" id="sa_street_name" name="saudi_address[street_name]" maxlength="100" value="<?php echo $saudiAddress->street_name;?>" />
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="sa_district">District</label>
									<input type="text" class="form-control" id="sa_district" name="saudi_address[district]" maxlength="100" value="<?php echo $saudiAddress->district;?>" />
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="sa_city">City</label>
									<input type="text" class="form-control" id="sa_city" name="saudi_address[city]" maxlength="100" value="<?php echo $saudiAddress->city;?>" />
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="sa_additional_no">Additional Number</label>
									<input type="text" class="form-control" id="sa_additional_no" name="saudi_address[additional_no]" maxlength="100" value="<?php echo $saudiAddress->additional_no;?>" />
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="sa_pin_code">Pin Code</label>
									<input type="text" class="form-control" id="sa_pin_code" name="saudi_address[pin_code]" maxlength="6" value="<?php echo $saudiAddress->pin_code;?>" />
								</div>
							</div>
							<!---- Address in Home Country ----->
							<div class="row tab-inner-section px-2 py-4">
								<h4 class="header-title">Address in Home Country</h4><hr>
								<?php 
									$homeAddress = (isset($emp_detail->home_address)) ? json_decode($emp_detail->home_address) : '';
								?>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="home_address">Address <span class="required-field">*</span></label>
									<input type="text" class="form-control" id="home_address" name="home_address[address]" value="<?php echo $homeAddress->address;?>" required />
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="home_city">Town/City <span class="required-field">*</span></label>
									<input type="text" class="form-control" id="home_city" name="home_address[city]" maxlength="100" value="<?php echo $homeAddress->city;?>" required />
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="home_country">Country <span class="required-field">*</span></label>
									<select name="home_address[country]" id="home_country" class="form-control" required>
										<option value="">Select Country</option>
										<?php foreach (masterCountries() as $country_list) { ?>
											<option value="<?php echo $country_list->id; ?>" data-id="<?php echo $country_list->id; ?>" <?php echo ($country_list->id == $homeAddress->country) ? ' selected ' : '' ?>><?php echo $country_list->name; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>

							<!---- Emergency Contact Details ----->
							<div class="row tab-inner-section px-2 py-4">
								<h4 class="header-title">Home Land Emergency Contact Details</h4>
								<hr>
								<table id="emergency_sections" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<td class="text-left">Contact Person Name</td>
											<td class="text-left">Contact Person Relationship</td>
											<td class="text-left">Contact Person Mobile</td>
										</tr>
									</thead>
									<tbody>
										<?php 
											$emergencyContacts = (isset($emp_detail->emergency_contact_detail)) ? json_decode($emp_detail->emergency_contact_detail) : '';
										?>
										<?php 
											$ec_count = 1;
											if(!empty($emergencyContacts)){ 
											foreach($emergencyContacts as $e_contact){ 
										?>
										<tr class="emergency-inner-section">
											<td class="text-left">
												<div class="input-group">
													<input type="text" name="emergency[<?php echo $ec_count;?>][name]" class="form-control" value="<?php echo $e_contact->name;?>" maxlength="100">
												</div>
											</td>
											<td class="text-left" style="width: 30%;">
												<select name="emergency[<?php echo $ec_count;?>][relationship]" class="form-control">
													<option value="">Select Relationship</option>
													<option value="Son" <?php echo ($e_contact->relationship == 'Son') ? ' selected ' : '' ?>>Son</option>
													<option value="Wife" <?php echo ($e_contact->relationship == 'Wife') ? ' selected ' : '' ?>>Wife</option>
													<option value="Daughter" <?php echo ($e_contact->relationship == 'Daughter') ? ' selected ' : '' ?>>Daughter</option>
													<option value="Mother" <?php echo ($e_contact->relationship == 'Mother') ? ' selected ' : '' ?>>Mother</option>
													<option value="Brother" <?php echo ($e_contact->relationship == 'Brother') ? ' selected ' : '' ?>>Brother</option>
													<option value="Sister" <?php echo ($e_contact->relationship == 'Sister') ? ' selected ' : '' ?>>Sister</option>
													<option value="Mother in Law" <?php echo ($e_contact->relationship == 'Mother in Law') ? ' selected ' : '' ?>>Mother in Law</option>
													<option value="Father in Law" <?php echo ($e_contact->relationship == 'Father in Law') ? ' selected ' : '' ?>>Father in Law</option>
													<option value="Uncle" <?php echo ($e_contact->relationship == 'Uncle') ? ' selected ' : '' ?>>Uncle</option>
													<option value="Aunt" <?php echo ($e_contact->relationship == 'Aunt') ? ' selected ' : '' ?>>Aunt</option>
												</select>
											</td>
											<td class="text-left">
												<div class="input-group">
													<input type="text" name="emergency[<?php echo $ec_count;?>][contact_no]" class="form-control" maxlength="10" value="<?php echo $e_contact->contact_no;?>">
												</div>
											</td>
										</tr>
										<?php $ec_count++;} }else{ ?>
											<tr><td colspan="3">
												<div class="text-center m-auto">
													<p><i class="fas fa-address-book text-secondary fa-3x"></i></p>
													<p>No Emergency Contact Details</p>
												</div>
											</td></tr>
										<?php } ?>
									</tbody>

								</table>
							</div>
							
							<!--- Family Information ---->
							<div class="row tab-inner-section px-2 py-4">
								<div class="w-50"><h4 class="header-title float-start">Family Member Information</h4></div>
								<div class="w-50"><?php if(isset($emp_detail->family_contact_detail)){ ?><button type="button" class="btn btn-outline-secondary float-end" data-type="New" data-empid="<?php echo $emp_detail->id;?>" onclick="addFamilyForm(this)" style="margin-top: -16px;padding: 0.27rem 0.75rem;"><i class="fa fa-plus"></i> New Member</button><?php } ?></div><hr>
								<div id="family_sections" class="col-md-12">
									<?php 
										$familyMembers = (isset($emp_detail->family_contact_detail)) ? json_decode($emp_detail->family_contact_detail) : '';
									?>
									<?php 
										$fdc_count = 1;
										if(!empty($familyMembers)){ 
									?>
									<div class="table-responsive mb-0" data-pattern="priority-columns">
										<table class="table border table-hover">
											<thead>
												<tr>
													<th>Name</th>
													<th>Gender</th>
													<th>Relationship</th>
													<th>Nationality</th>
													<th>Marital Status</th>
													<th>DOB</th>
													<th>ID/Iqama Number</th>
													<th>Passport Number</th>
													<th>Passport Expiry Date</th>
													<th>Insurance No.</th>
													<th>Medical insurance expiry date</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach($familyMembers as $key => $value){  ?>
												<tr>
													<td><?php echo $value->name;?></td>
													<td><?php echo $value->gender;?></td>
													<td><?php echo $value->relationship;?></td>
													<td><?php echo $value->nationality;?></td>
													<td><?php echo $value->marital_status;?></td>
													<td><div style="width: 100px;"><?php echo ($value->dob !== '') ? date('d-m-Y', strtotime($value->dob)) : 'NA';?></div></td>
													<td><?php echo $value->iqama_no;?></td>
													<td><?php echo $value->passport_no;?></td>
													<td><div style="width: 100px;"><?php echo ($value->passport_expiry_date !== '') ? date('d-m-Y', strtotime($value->passport_expiry_date)) : 'NA';?></div></td>
													<td><?php echo $value->insurance_no;?></td>
													<td><div style="width: 100px;"><?php echo ($value->medical_expiry_date !== '') ? date('d-m-Y', strtotime($value->medical_expiry_date)) : 'NA';?></div></td>
													<td>
														<div class="btn-group">
															<button type="button" class="btn btn-link btn-sm waves-light waves-effect dropdown-toggle py-0" data-bs-toggle="dropdown" aria-expanded="false">
																<i class="mdi mdi-dots-horizontal font-size-20 text-dark"></i>
															</button>
															<div class="dropdown-menu" style="margin: 0px;">
																<a class="dropdown-item" href="javascript:;" data-id="<?php echo $key;?>" data-empid="<?php echo $emp_detail->id;?>" data-type="Update" onclick="updateFamilyForm(this)">Edit</a>
																<a class="dropdown-item" href="<?php echo base_url('admin/hr/employees/delete-family/'.$emp_detail->id.'/'.$key.'/view');?>" onclick="return confirm('Are you sure?')">Delete</a>
															</div>
														</div>
													</td>
												</tr>
												<?php $fdc_count++;} ?>
											</tbody>
										</table>
									</div>
									
									<?php }else{ ?>
										<div class="text-center m-auto">
											<p><i class="fas fa-users text-secondary fa-3x"></i></p>
											<p>No Family Members</p>
											<button type="button" class="btn btn-outline-secondary" data-type="New" data-empid="<?php echo $emp_detail->id;?>" onclick="addFamilyForm(this)"><i class="fa fa-plus"></i> Add Members</button>
										</div>
									<?php } ?>
								</div>
							</div>
							<div class="twitter-bs-wizard">
								<ul class="pager wizard twitter-bs-wizard-pager-link">
									<li class="previous"><a href="<?php echo ($emp_detail->id > 0) ? base_url('admin/hr/employees/view/step-1/'.$emp_detail->id) : base_url('admin/hr/employees'); ?>" class="btn btn-custom-secondary"><i class="mdi mdi-arrow-left me-1"></i> Prevoius </a></li>
									<li class="next"><a type="button" href="<?php echo base_url('admin/hr/employees/view/step-3/'.$emp_detail->id);?>" class="btn btn-custom-success">Next Step <i class="mdi mdi-arrow-right ms-1"></i></a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<?php $this->load->view('admin/home/footer');?>

<div class="modal fade fixed-left familyModal" aria-labelledby="#familyModalFullscreenLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-aside">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="familyModalFullscreenLabel">Add Family Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
				
            </div>
			<div class="modal-footer">
				<div class="row">
					<div class="col-md-12">
						<button form="family_form" type="submit" class="btn btn-success btn-md">Save Member</button>
						<button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-outline-danger btn-md ms-2">Cancel </button>
					</div>
				</div>
			</div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script type="text/javascript">
	$('.dropify').dropify();
	function checkField(u){
		var id = $("#"+u).val();
		if(id == ""){
			$("#"+u).addClass("alert_text");
		}
		else{
			$("#"+u).removeClass("alert_text");
		}
	}
	
	function Alpha(evt) {
		var keyCode = (evt.which) ? evt.which : evt.keyCode
		if ((keyCode < 65 || keyCode > 90) && (keyCode < 97 || keyCode > 123) && keyCode != 32)

			return false;
		return true;
	}

	function numerics(key) {
		//getting key code of pressed key
		// alert($(this).val());
		var keycode = (key.which) ? key.which : key.keyCode;
		//comparing pressed keycodes

		if (keycode > 31 && (keycode < 48 || keycode > 57)) {
			alert("You can enter only characters 0 to 9 ");
			return false;
		} else return true;
	}

	//Add Emergency Contacts
	
	//define counter
	var ecCount = "<?php echo $ec_count;?>";
	//add new section
	$("body").on("click", ".addemergencysection", function() {
		//increment
		var sectionsCount = ++ecCount;
		var template = `<tr class="emergency-inner-section">
			<td class="text-left">
				<div class="input-group">
					<input type="text" name="emergency[${sectionsCount}][name]" class="form-control" maxlength="100">
				</div>
			</td>
			<td class="text-left" style="width: 30%;">
				<select name="emergency[${sectionsCount}][relationship]" class="form-control">
					<option value="">Select Relationship</option>
					<option value="Son">Son</option>
					<option value="Wife">Wife</option>
					<option value="Daughter">Daughter</option>
					<option value="Mother">Mother</option>
					<option value="Brother">Brother</option>
					<option value="Sister">Sister</option>
					<option value="Mother in Law">Mother in Law</option>
					<option value="Father in Law">Father in Law</option>
					<option value="Uncle">Uncle</option>
					<option value="Aunt">Aunt</option>
				</select>
			</td>
			<td class="text-left">
				<div class="input-group">
					<input type="text" name="emergency[${sectionsCount}][contact_no]" class="form-control" maxlength="10">
				</div>
			</td>
			<td class="text-right">
				<a href="javascript:;" class="btn btn-danger btn-sm float-end remove"><i class="fa fa-minus-circle"></i></a>
			</td>
		</tr>`;
		//loop through each input
		$('#emergency_sections tbody').append(template);
		return false;
	});

	//remove section
	$("#emergency_sections").on("click", ".remove", function() {
		//fade out section
		$(this)
			.parent()
			.fadeOut(300, function() {
				//remove parent element (main section)
				$(this).parent().empty();
				return false;
			});
		return false;
	});

	//Add Family Members
	
	function addFamilyForm(identifier) {
		let emp_id = $(identifier).data('empid');
		let type = $(identifier).data('type');
		$.ajax({
			type: "POST",
			url: "<?php echo base_url('admin/hr-module/employees/Employee/add_family_form');?>",
			data: {'emp_id': emp_id,'redirect':'view'},
			//dataType: "json",
			success: function (response) {
				//console.log(response);
				$('.familyModal').modal('show');
				$('.familyModal .modal-body').html(response);
				$('#familyModalFullscreenLabel').html(type + ' Family Member');
			},
			error: function (request, error) {
				console.log(" Can't do because: " + JSON.stringify(request));
				$('.familyModal .modal-body').after(JSON.stringify(request));
			},
		});
	}

	function updateFamilyForm(identifier) {
		let id = $(identifier).data('id');
		let empid = $(identifier).data('empid');
		let type = $(identifier).data('type');
		if(id !== '' && empid > 0){
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('admin/hr-module/employees/Employee/update_family_form');?>",
				data: {'key_id': id,'emp_id': empid,'redirect':'view'},
				//dataType: "json",
				success: function (response) {
					//console.log(response);
					$('.familyModal').modal('show');
					$('.familyModal .modal-body').html(response);
					$('#familyModalFullscreenLabel').html(type + ' Family Member');
				},
				error: function (request, error) {
					console.log(" Can't do because: " + JSON.stringify(request));
					$('.familyModal .modal-body').after(JSON.stringify(request));
				},
			});
		}else{
			alert('Invalid request id!');
		}
	}
</script>
