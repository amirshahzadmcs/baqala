<?php $this->load->view('admin/home/header');?>

<style>
.required-field{
	color:#f00;
}

.size-inner-section {
	box-shadow: 0px 1px 4px #c5c5c5;
	border-radius: 5px;
	margin-bottom: 10px;
}
.cv-documents{
	border: 1px dashed #a9a9a9;
	padding: 6px;
	width: 50px;
	height: 50px;
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
								$active_step = 3;
								$nav_emp_id = isset($emp_detail->id) ? $emp_detail->id : null;
								$this->load->view('admin/hr-module/employees/components/view_step_navigation', compact('active_step', 'nav_emp_id'));
							?>
						</div>
						<div class="employee_form">
							<input type="hidden" id="id" name="id" value="<?php echo $emp_detail->id;?>" required />
							<!-- Tab panes -->
							<div class="row size-inner-section px-2 py-4 mx-2">
								<h4 class="header-title">Qualification</h4><hr>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="edu_degree">Qualification</label>
									<select class="form-control" data-parsley-allselected="true" name="edu_degree" id="edu_degree">
										<option value="">Select Degree</option>
										<?php foreach(degreeEduHelper() as $degree) { ?>
											<option value="<?php echo $degree->name; ?>" <?php echo ($degree->name == $emp_detail->edu_degree) ? ' selected' : '' ?>><?php echo $degree->name; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<!--- Work Information ---->
							<div class="row size-inner-section px-2 py-4 mx-2">
								<h4 class="header-title">Work Details</h4><hr>
                                <div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="work_joining_date">Joining Date (Gregorian) <span class="text-danger">*</span></label>
									<input type="date" class="form-control" id="work_joining_date" name="work_joining_date" value="<?php echo $emp_detail->work_joining_date;?>" required />
								</div>
                                <div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="joining_date_hijri">Joining Date (Hijri)</label>
									<input id="joining_date_hijri" name="joining_date_hijri" class="form-control input-mask" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="dd-mm-yyyy" value="<?php echo (isset($emp_detail->joining_date_hijri) && ($emp_detail->joining_date_hijri !== '0000-00-00')) ? date('d-m-Y', strtotime($emp_detail->joining_date_hijri)) : '';?>">
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="department">Department <span class="text-danger">*</span></label>
									<select class="form-control" data-parsley-allselected="true" name="department" id="department" required>
										<option value="">Select Department</option>
										<?php foreach(masterDepartments() as $departments) { ?>
											<option value="<?php echo $departments->id; ?>" <?php echo ($departments->id == $emp_detail->department) ? ' selected' : '' ?>><?php echo $departments->name; ?></option>
										<?php } ?>
									</select>
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="designation">Job Title <span class="text-danger">*</span></label>
									<select class="form-control" data-parsley-allselected="true" name="designation" id="designation" required>
										<option value="">Select Job Title</option>
										<?php foreach(masterDesignation($emp_detail->department) as $mdesignation) { ?>
											<option value="<?php echo $mdesignation->id; ?>" <?php echo ($mdesignation->id == $emp_detail->designation) ? ' selected' : '' ?>><?php echo $mdesignation->name; ?></option>
										<?php } ?>
									</select>
								</div>
								
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="work_line_manager">Line Manager</label>
									<select class="form-control" data-parsley-allselected="true" name="work_line_manager" id="work_line_manager">
										<option value="">Select Line Manager</option>
										<?php foreach(employeeListHelper() as $emp_list) { ?>
											<option value="<?php echo $emp_list->id; ?>" <?php echo ($emp_list->id == $emp_detail->work_line_manager) ? ' selected' : '' ?>><?php echo $emp_list->full_name; ?> (<?php echo $emp_list->designation_name; ?>) - <?php echo $emp_list->emp_no; ?></option>
										<?php } ?>
									</select>
								</div>
								
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="department_head">Department Head</label>
									<select class="form-control" data-parsley-allselected="true" name="department_head" id="department_head">
										<option value="">Select Department Head</option>
										<?php foreach(employeeListHelper() as $emp_list) { ?>
											<option value="<?php echo $emp_list->id; ?>" <?php echo ($emp_list->id == $emp_detail->department_head) ? ' selected' : '' ?>><?php echo $emp_list->full_name; ?> (<?php echo $emp_list->designation_name; ?>) - <?php echo $emp_list->emp_no; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="employment_type">Employment Type</label>
									<select class="form-control" data-parsley-allselected="true" name="employment_type" id="employment_type">
										<option value="">Select Employment Type</option>
										<?php foreach(employmentTypeHelper() as $emp_type) { ?>
											<option value="<?php echo $emp_type->name; ?>" <?php echo ($emp_type->name == $emp_detail->employment_type) ? ' selected' : '' ?>><?php echo $emp_type->name; ?></option>
										<?php } ?>
									</select>
								</div>
                                <div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="working_hours">Working Hours</label>
									<input type="text" class="form-control" id="working_hours" name="working_hours" maxlength="150" value="<?php echo $emp_detail->working_hours;?>" />
								</div>
                                <div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="working_days">Working Days</label>
									<input type="text" class="form-control" id="working_days" name="working_days" maxlength="150" value="<?php echo $emp_detail->working_days;?>" />
								</div>
                                <div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="work_location">Work Location <span class="text-danger">*</span></label>
									<select class="form-control" data-parsley-allselected="true" name="work_location" id="work_location" required>
										<option value="">Select Location</option>
										<?php foreach(masterLocationHelper() as $location) { ?>
											<option value="<?php echo $location->id; ?>" <?php echo ($location->id == $emp_detail->work_location) ? ' selected' : '' ?>><?php echo $location->location_name; ?></option>
										<?php } ?>
									</select>
								</div>
								<!--
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="work_country">Country <span class="text-danger">*</span></label>
									<select class="form-control" name="work_country" id="work_country" required>
										<option value="">Select Country</option>
										<?php foreach(masterCountries() as $country) { ?>
										<option value="<?php echo $country->id; ?>" data-id="<?php echo $country->id; ?>" <?php echo ($country->id == $emp_detail->work_country) ? 'selected' : '' ?>><?php echo $country->name; ?></option>
										<?php } ?>
									</select>
								</div>
                                <div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="work_city">City <span class="text-danger">*</span></label>
									<select class="form-control" data-parsley-allselected="true" name="work_city" id="work_city" required>
										<option value="">Select City</option>
										<?php foreach(selectedCitiesHelp($emp_detail->work_country) as $cities) { ?>
											<option value="<?php echo $cities->id; ?>" <?php echo ($cities->id == $emp_detail->work_city) ? ' selected' : '' ?>><?php echo $cities->city_name; ?></option>
										<?php } ?>
									</select>
								</div>
								-->
							</div>

							<div class="row size-inner-section px-2 py-4 mx-2">
								<h4 class="header-title">Salary Details</h4><hr>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="basic_salary">Basic Salary</label>
									<input type="text" class="form-control" id="basic_salary" name="basic_salary" maxlength="250" value="<?php echo $emp_detail->basic_salary;?>" />
								</div>
								
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label>Houisng Provided</label>
									<input type="text" class="form-control" value="<?php echo ($emp_detail->is_housing_provided == 'on') ? 'Yes' : 'No' ?>" />
								</div>
                                <div class="col-md-4 col-sm-12 mb-2 form-group housing-checked <?php echo ($emp_detail->is_housing_provided == 'on') ? 'd-block' : 'd-none' ?>">
									<label for="camp">Select Camp</label>
									<select class="form-control" data-parsley-allselected="true" name="camp" id="camp">
										<option value="">Select Camp</option>
										<?php foreach(masterCampHelper() as $camps) { ?>
											<option value="<?php echo $camps->id; ?>" <?php echo ($camps->id == $emp_detail->camp) ? ' selected' : '' ?>><?php echo $camps->camp_name; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group housing-checked <?php echo ($emp_detail->is_housing_provided == 'on') ? 'd-block' : 'd-none' ?>">
									<label for="room">Select Room</label>
									<select class="form-control" data-parsley-allselected="true" name="room" id="room">
										<option value="">Select Room</option>
										<?php foreach(selectedRoomHelper($emp_detail->camp) as $rooms) { ?>
											<option value="<?php echo $rooms->id; ?>" <?php echo ($rooms->id == $emp_detail->room) ? ' selected' : '' ?>><?php echo $rooms->room_name; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group housing-checked <?php echo ($emp_detail->is_housing_provided == 'on') ? 'd-block' : 'd-none' ?>">
									<label for="bed">Select Bed</label>
									<select class="form-control" data-parsley-allselected="true" name="bed" id="bed">
										<option value="">Select Bed</option>
										<?php foreach(selectedBedHelper($emp_detail->room) as $beds) { ?>
											<option value="<?php echo $beds->id; ?>" <?php echo ($beds->id == $emp_detail->bed) ? ' selected' : '' ?>><?php echo $beds->bed_name; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group <?php echo ($emp_detail->is_housing_provided == 'on') ? 'd-block' : 'd-none' ?>">
									<label for="housing_allowance">Housing Allowance</label>
									<input type="text" class="form-control" id="housing_allowance" name="housing_allowance" maxlength="250" value="<?php echo $emp_detail->housing_allowance;?>" <?php echo ($emp_detail->is_housing_provided == 'on') ? 'readonly' : '' ?> />
								</div>
                                <div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="transport_allowance">Transport Allowance</label>
									<input type="text" class="form-control" id="transport_allowance" name="transport_allowance" maxlength="250" value="<?php echo $emp_detail->transport_allowance;?>" />
								</div>
                                <div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="food_allowance">Food Allowance</label>
									<input type="text" class="form-control" id="food_allowance" name="food_allowance" maxlength="250" value="<?php echo $emp_detail->food_allowance;?>" />
								</div>
                                <div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="mobile_allowance">Mobile Allowance</label>
									<input type="text" class="form-control" id="mobile_allowance" name="mobile_allowance" maxlength="250" value="<?php echo $emp_detail->mobile_allowance;?>" />
								</div>
                                <div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="other_allowance">Other Allowance</label>
									<input type="text" class="form-control" id="other_allowance" name="other_allowance" maxlength="250" value="<?php echo $emp_detail->other_allowance;?>" />
								</div>
                                <div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="total_package">Total Package</label>
									<input type="text" class="form-control" id="total_package" name="total_package" maxlength="250" value="<?php echo $emp_detail->total_package;?>" />
								</div>
							</div>

                            <div class="row size-inner-section px-2 py-4 mx-2">
								<h4 class="header-title">Contract</h4><hr>
								<div class="col-md-12">
									<!-- Nav tabs -->
									<ul class="nav nav-tabs nav-tabs-custom" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" data-bs-toggle="tab" href="#currentContract" role="tab">
												<span class="d-none d-sm-block">Current</span> 
											</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-bs-toggle="tab" href="#prevContract" role="tab">
												<span class="d-block d-sm-none"><i class="far fa-user"></i></span>
												<span class="d-none d-sm-block">Previous contracts</span> 
											</a>
										</li>
									</ul>
	
									<!-- Tab panes -->
									<div class="tab-content p-3 px-0 text-muted">
										<div class="tab-pane active" id="currentContract" role="tabpanel">
											<?php if(count($active_contract) > 0){ ?>
												<div class="active-contract">
													<table class="table border">
														<thead>
															<tr class="bg-light">
																<th>Contract Period</th>
																<th>Contract Start Date (Gregorian)</th>
																<th>Contract End Date (Gregorian)</th>
																<th>Status</th>
																<th>Attachment</th>
																<th>Action</th>
															</tr>
														</thead>
														<tbody>
															<?php foreach($active_contract as $actcont){ ?>
															<tr>
																<td><?php if($actcont['contract_duration'] == 'custom'){ echo ucfirst($actcont['contract_duration']); }else{ echo $actcont['contract_duration'] .' Year '; } ?></td>
																<td><?php echo ($actcont['contract_start_date'] !== '') ? date('d-m-Y', strtotime($actcont['contract_start_date'])) : 'NA';?></td>
																<td><?php echo ($actcont['contract_end_date'] !== '') ? date('d-m-Y', strtotime($actcont['contract_end_date'])) : 'NA';?></td>
																<td><span class="badge badge-pill badge-soft-success font-size-13">Active</span></td>
																<td>
																	<?php 
																	if($actcont['attachment'] !== ''){
																		echo '<a href="'.base_url($actcont['attachment']).'" target="_blank"><i class="fas fa-paperclip"></i> '.substr($actcont['attachment'], 30, 50).'</a>';
																	}else{
																		echo 'NA';
																	}
																	?>
																</td>
																<td>
																	<div class="btn-group">
																		<button type="button" class="btn btn-link btn-sm waves-light waves-effect dropdown-toggle py-0" data-bs-toggle="dropdown" aria-expanded="false">
																			<i class="mdi mdi-dots-horizontal font-size-20 text-dark"></i>
																		</button>
																		<div class="dropdown-menu" style="margin: 0px;">
																			<a class="dropdown-item" href="javascript:;" data-id="<?php echo $actcont['id'] ;?>" data-type="Update" onclick="updateContractForm(this)">Edit</a>
																		</div>
																	</div>
																</td>
															</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>
											<?php }else{ ?>
												<div class="text-center m-auto p-3">
													<p><svg width="100" height="98" viewBox="0 0 100 98" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 64px; height: 64px;"><path d="M63.483 22.0388H36.5371C35.923 22.0396 35.3344 22.2848 34.9002 22.7207C34.466 23.1567 34.2217 23.7477 34.2209 24.3642V84.4897L33.9121 84.5842L27.3019 86.6166C26.9886 86.7125 26.6502 86.6797 26.361 86.5253C26.0718 86.371 25.8554 86.1078 25.7594 85.7934L6.09687 21.3118C6.00118 20.9972 6.0338 20.6574 6.18754 20.367C6.34129 20.0766 6.60359 19.8594 6.91679 19.7631L17.1032 16.6316L46.6339 7.55661L56.8202 4.42515C56.9753 4.37726 57.1382 4.36052 57.2996 4.3759C57.4611 4.39128 57.618 4.43848 57.7612 4.51479C57.9045 4.59111 58.0314 4.69504 58.1346 4.82064C58.2379 4.94625 58.3154 5.09105 58.3628 5.24677L63.3888 21.7288L63.483 22.0388Z" fill="#F6F8F9"></path><path d="M69.3637 21.7289L63.3062 1.86425C63.2054 1.53327 63.0407 1.22547 62.8214 0.958442C62.6021 0.691412 62.3325 0.470386 62.0281 0.307993C61.7236 0.145601 61.3903 0.0450227 61.0471 0.0120109C60.704 -0.021001 60.3577 0.0142001 60.0281 0.115599L45.7067 4.51669L16.1775 13.5933L1.85609 17.9959C1.1908 18.201 0.633732 18.6628 0.307179 19.2798C-0.0193747 19.8968 -0.0887393 20.6187 0.114314 21.287L20.8175 89.1761C20.9824 89.7156 21.3153 90.1878 21.7671 90.5234C22.219 90.8591 22.7661 91.0405 23.3282 91.041C23.5884 91.0411 23.8471 91.002 24.0956 90.9248L33.9129 87.908L34.2217 87.8119V87.4879L33.9129 87.5825L24.0045 90.6287C23.4173 90.8084 22.783 90.7469 22.2408 90.4578C21.6986 90.1686 21.2928 89.6753 21.1124 89.0862L0.410842 21.1956C0.321453 20.9037 0.290299 20.5969 0.319162 20.2929C0.348025 19.9888 0.436336 19.6935 0.579044 19.4238C0.721752 19.1541 0.916053 18.9153 1.15082 18.7211C1.38558 18.5269 1.65619 18.3811 1.94717 18.292L16.2686 13.8894L45.7978 4.81434L60.1193 0.411695C60.34 0.344074 60.5694 0.309595 60.8002 0.30938C61.2954 0.310496 61.7772 0.470783 62.1751 0.766762C62.573 1.06274 62.8661 1.47886 63.0113 1.95417L69.041 21.7289L69.1367 22.0389H69.4579L69.3637 21.7289Z" fill="#4B6175"></path><path d="M18.9419 19.8138C18.6443 19.8136 18.3546 19.7177 18.1153 19.54C17.876 19.3624 17.6997 19.1124 17.6123 18.8268L15.6234 12.3048C15.57 12.1296 15.5514 11.9455 15.5688 11.7631C15.5863 11.5807 15.6393 11.4036 15.7249 11.2418C15.8105 11.08 15.9271 10.9367 16.0678 10.8201C16.2086 10.7035 16.3709 10.6159 16.5454 10.5623L43.712 2.21218C44.0644 2.10421 44.4451 2.14103 44.7705 2.31456C45.0959 2.48809 45.3395 2.78416 45.4477 3.13777L47.4365 9.65992C47.544 10.0137 47.5073 10.3959 47.3344 10.7226C47.1616 11.0493 46.8668 11.2938 46.5146 11.4025L19.3479 19.7526C19.2164 19.7931 19.0795 19.8138 18.9419 19.8138Z" fill="#93A0AC"></path><path d="M29.3597 6.96751C31.0652 6.96751 32.4478 5.57939 32.4478 3.86705C32.4478 2.15472 31.0652 0.766602 29.3597 0.766602C27.6541 0.766602 26.2715 2.15472 26.2715 3.86705C26.2715 5.57939 27.6541 6.96751 29.3597 6.96751Z" fill="#93A0AC"></path><path d="M29.3598 5.83066C30.4398 5.83066 31.3154 4.95166 31.3154 3.86736C31.3154 2.78305 30.4398 1.90405 29.3598 1.90405C28.2798 1.90405 27.4043 2.78305 27.4043 3.86736C27.4043 4.95166 28.2798 5.83066 29.3598 5.83066Z" fill="white"></path><path d="M92.707 93H41.293C40.9502 92.9996 40.6215 92.8551 40.3791 92.5984C40.1367 92.3416 40.0004 91.9935 40 91.6303V26.3697C40.0004 26.0065 40.1367 25.6584 40.3791 25.4016C40.6215 25.1448 40.9502 25.0004 41.293 25H92.707C93.0498 25.0004 93.3785 25.1449 93.6209 25.4016C93.8633 25.6584 93.9996 26.0065 94 26.3697V91.6303C93.9996 91.9935 93.8632 92.3416 93.6209 92.5984C93.3785 92.8551 93.0498 92.9996 92.707 93Z" fill="#EDF0F3"></path><path d="M67 75.75C75.6985 75.75 82.75 68.6985 82.75 60C82.75 51.3015 75.6985 44.25 67 44.25C58.3015 44.25 51.25 51.3015 51.25 60C51.25 68.6985 58.3015 75.75 67 75.75Z" stroke="#BEC6CD" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M62.9492 55.9499V55.9499C63.3638 54.1629 64.9914 52.9239 66.8243 53V53C68.8756 52.8863 70.6341 54.4495 70.7618 56.5C70.7618 59.1318 66.9993 60 66.9993 61.75" stroke="#BEC6CD" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M67.2188 66.5625C67.2188 66.6833 67.1208 66.7812 67 66.7812C66.8792 66.7812 66.7812 66.6833 66.7812 66.5625C66.7812 66.4417 66.8792 66.3438 67 66.3438" stroke="#BEC6CD" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M67 66.3438V66.3438C67.1208 66.3437 67.2188 66.4417 67.2188 66.5625" stroke="#BEC6CD" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M69.0411 21.729H36.538C35.8422 21.73 35.1751 22.008 34.683 22.502C34.1909 22.996 33.9141 23.6657 33.9131 24.3644V87.5826L34.2219 87.488V24.3644C34.2227 23.7479 34.4669 23.1569 34.9011 22.721C35.3353 22.285 35.924 22.0398 36.538 22.039H69.1369L69.0411 21.729ZM97.3752 21.729H36.538C35.8422 21.73 35.1751 22.008 34.683 22.502C34.1909 22.996 33.9141 23.6657 33.9131 24.3644V95.3647C33.9141 96.0634 34.1909 96.7331 34.683 97.2271C35.1751 97.7212 35.8422 97.9991 36.538 98.0001H97.3752C98.0711 97.9991 98.7382 97.7212 99.2302 97.2271C99.7223 96.7331 99.9992 96.0634 100 95.3647V24.3644C99.9992 23.6657 99.7223 22.996 99.2302 22.502C98.7382 22.008 98.0711 21.73 97.3752 21.729ZM99.6913 95.3647C99.6906 95.9812 99.4463 96.5723 99.0121 97.0082C98.5779 97.4441 97.9892 97.6893 97.3752 97.6901H36.538C35.924 97.6893 35.3353 97.4441 34.9011 97.0082C34.4669 96.5723 34.2227 95.9812 34.2219 95.3647V24.3644C34.2227 23.7479 34.4669 23.1569 34.9011 22.721C35.3353 22.285 35.924 22.0398 36.538 22.039H97.3752C97.9892 22.0398 98.5779 22.285 99.0121 22.721C99.4463 23.1569 99.6906 23.7479 99.6913 24.3644V95.3647Z" fill="#4B6175"></path><path d="M81.1623 28.5499H52.751C52.3826 28.5495 52.0293 28.4023 51.7688 28.1408C51.5083 27.8792 51.3617 27.5246 51.3613 27.1547V20.3337C51.3617 19.9638 51.5083 19.6091 51.7688 19.3476C52.0293 19.086 52.3826 18.9389 52.751 18.9385H81.1623C81.5307 18.9389 81.8839 19.086 82.1445 19.3476C82.405 19.6091 82.5515 19.9638 82.552 20.3337V27.1547C82.5515 27.5246 82.405 27.8792 82.1445 28.1408C81.8839 28.4023 81.5307 28.5495 81.1623 28.5499Z" fill="#93A0AC"></path><path d="M66.9563 19.4033C68.6619 19.4033 70.0445 18.0152 70.0445 16.3028C70.0445 14.5905 68.6619 13.2024 66.9563 13.2024C65.2508 13.2024 63.8682 14.5905 63.8682 16.3028C63.8682 18.0152 65.2508 19.4033 66.9563 19.4033Z" fill="#93A0AC"></path><path d="M66.9562 18.1915C67.995 18.1915 68.8372 17.346 68.8372 16.303C68.8372 15.26 67.995 14.4146 66.9562 14.4146C65.9173 14.4146 65.0752 15.26 65.0752 16.303C65.0752 17.346 65.9173 18.1915 66.9562 18.1915Z" fill="white"></path></svg></p>
													<button type="button" class="btn btn-outline-secondary" data-type="New" data-empid="<?php echo $emp_detail->id;?>" onclick="addContractForm(this)"><i class="fa fa-plus"></i> Add Contract</button>
												</div>
											<?php } ?>
										</div>
										<div class="tab-pane" id="prevContract" role="tabpanel">
											<?php if(count($expired_contract) > 0){ ?>
												<div class="active-contract">
													<table class="table border">
														<thead>
															<tr class="bg-light">
																<th>Contract Period</th>
																<th>Contract Start Date (Gregorian)</th>
																<th>Contract End Date (Gregorian)</th>
																<th>Status</th>
																<th>Attachment</th>
															</tr>
														</thead>
														<tbody>
															<?php foreach($expired_contract as $actcont){ ?>
															<tr>
																<td><?php if($actcont['contract_duration'] == 'custom'){ echo ucfirst($actcont['contract_duration']); }else{ echo $actcont['contract_duration'] .' Year '; } ?></td>
																<td><?php echo ($actcont['contract_start_date'] !== '') ? date('d-m-Y', strtotime($actcont['contract_start_date'])) : 'NA';?></td>
																<td><?php echo ($actcont['contract_end_date'] !== '') ? date('d-m-Y', strtotime($actcont['contract_end_date'])) : 'NA';?></td>
																<td><span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span></td>
																<td>
																	<?php 
																		if($actcont['attachment'] !== ''){
																			echo '<a href="'.base_url($actcont['attachment']).'" target="_blank"><i class="fas fa-paperclip"></i> '.substr($actcont['attachment'], 30, 50).'</a>';
																		}else{
																			echo 'NA';
																		}
																	?>
																</td>
																
															</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>
											<?php }else{ ?>
												<div class="text-center m-auto p-3">
													<p><svg width="100" height="98" viewBox="0 0 100 98" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 64px; height: 64px;"><path d="M63.483 22.0388H36.5371C35.923 22.0396 35.3344 22.2848 34.9002 22.7207C34.466 23.1567 34.2217 23.7477 34.2209 24.3642V84.4897L33.9121 84.5842L27.3019 86.6166C26.9886 86.7125 26.6502 86.6797 26.361 86.5253C26.0718 86.371 25.8554 86.1078 25.7594 85.7934L6.09687 21.3118C6.00118 20.9972 6.0338 20.6574 6.18754 20.367C6.34129 20.0766 6.60359 19.8594 6.91679 19.7631L17.1032 16.6316L46.6339 7.55661L56.8202 4.42515C56.9753 4.37726 57.1382 4.36052 57.2996 4.3759C57.4611 4.39128 57.618 4.43848 57.7612 4.51479C57.9045 4.59111 58.0314 4.69504 58.1346 4.82064C58.2379 4.94625 58.3154 5.09105 58.3628 5.24677L63.3888 21.7288L63.483 22.0388Z" fill="#F6F8F9"></path><path d="M69.3637 21.7289L63.3062 1.86425C63.2054 1.53327 63.0407 1.22547 62.8214 0.958442C62.6021 0.691412 62.3325 0.470386 62.0281 0.307993C61.7236 0.145601 61.3903 0.0450227 61.0471 0.0120109C60.704 -0.021001 60.3577 0.0142001 60.0281 0.115599L45.7067 4.51669L16.1775 13.5933L1.85609 17.9959C1.1908 18.201 0.633732 18.6628 0.307179 19.2798C-0.0193747 19.8968 -0.0887393 20.6187 0.114314 21.287L20.8175 89.1761C20.9824 89.7156 21.3153 90.1878 21.7671 90.5234C22.219 90.8591 22.7661 91.0405 23.3282 91.041C23.5884 91.0411 23.8471 91.002 24.0956 90.9248L33.9129 87.908L34.2217 87.8119V87.4879L33.9129 87.5825L24.0045 90.6287C23.4173 90.8084 22.783 90.7469 22.2408 90.4578C21.6986 90.1686 21.2928 89.6753 21.1124 89.0862L0.410842 21.1956C0.321453 20.9037 0.290299 20.5969 0.319162 20.2929C0.348025 19.9888 0.436336 19.6935 0.579044 19.4238C0.721752 19.1541 0.916053 18.9153 1.15082 18.7211C1.38558 18.5269 1.65619 18.3811 1.94717 18.292L16.2686 13.8894L45.7978 4.81434L60.1193 0.411695C60.34 0.344074 60.5694 0.309595 60.8002 0.30938C61.2954 0.310496 61.7772 0.470783 62.1751 0.766762C62.573 1.06274 62.8661 1.47886 63.0113 1.95417L69.041 21.7289L69.1367 22.0389H69.4579L69.3637 21.7289Z" fill="#4B6175"></path><path d="M18.9419 19.8138C18.6443 19.8136 18.3546 19.7177 18.1153 19.54C17.876 19.3624 17.6997 19.1124 17.6123 18.8268L15.6234 12.3048C15.57 12.1296 15.5514 11.9455 15.5688 11.7631C15.5863 11.5807 15.6393 11.4036 15.7249 11.2418C15.8105 11.08 15.9271 10.9367 16.0678 10.8201C16.2086 10.7035 16.3709 10.6159 16.5454 10.5623L43.712 2.21218C44.0644 2.10421 44.4451 2.14103 44.7705 2.31456C45.0959 2.48809 45.3395 2.78416 45.4477 3.13777L47.4365 9.65992C47.544 10.0137 47.5073 10.3959 47.3344 10.7226C47.1616 11.0493 46.8668 11.2938 46.5146 11.4025L19.3479 19.7526C19.2164 19.7931 19.0795 19.8138 18.9419 19.8138Z" fill="#93A0AC"></path><path d="M29.3597 6.96751C31.0652 6.96751 32.4478 5.57939 32.4478 3.86705C32.4478 2.15472 31.0652 0.766602 29.3597 0.766602C27.6541 0.766602 26.2715 2.15472 26.2715 3.86705C26.2715 5.57939 27.6541 6.96751 29.3597 6.96751Z" fill="#93A0AC"></path><path d="M29.3598 5.83066C30.4398 5.83066 31.3154 4.95166 31.3154 3.86736C31.3154 2.78305 30.4398 1.90405 29.3598 1.90405C28.2798 1.90405 27.4043 2.78305 27.4043 3.86736C27.4043 4.95166 28.2798 5.83066 29.3598 5.83066Z" fill="white"></path><path d="M92.707 93H41.293C40.9502 92.9996 40.6215 92.8551 40.3791 92.5984C40.1367 92.3416 40.0004 91.9935 40 91.6303V26.3697C40.0004 26.0065 40.1367 25.6584 40.3791 25.4016C40.6215 25.1448 40.9502 25.0004 41.293 25H92.707C93.0498 25.0004 93.3785 25.1449 93.6209 25.4016C93.8633 25.6584 93.9996 26.0065 94 26.3697V91.6303C93.9996 91.9935 93.8632 92.3416 93.6209 92.5984C93.3785 92.8551 93.0498 92.9996 92.707 93Z" fill="#EDF0F3"></path><path d="M67 75.75C75.6985 75.75 82.75 68.6985 82.75 60C82.75 51.3015 75.6985 44.25 67 44.25C58.3015 44.25 51.25 51.3015 51.25 60C51.25 68.6985 58.3015 75.75 67 75.75Z" stroke="#BEC6CD" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M62.9492 55.9499V55.9499C63.3638 54.1629 64.9914 52.9239 66.8243 53V53C68.8756 52.8863 70.6341 54.4495 70.7618 56.5C70.7618 59.1318 66.9993 60 66.9993 61.75" stroke="#BEC6CD" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M67.2188 66.5625C67.2188 66.6833 67.1208 66.7812 67 66.7812C66.8792 66.7812 66.7812 66.6833 66.7812 66.5625C66.7812 66.4417 66.8792 66.3438 67 66.3438" stroke="#BEC6CD" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M67 66.3438V66.3438C67.1208 66.3437 67.2188 66.4417 67.2188 66.5625" stroke="#BEC6CD" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M69.0411 21.729H36.538C35.8422 21.73 35.1751 22.008 34.683 22.502C34.1909 22.996 33.9141 23.6657 33.9131 24.3644V87.5826L34.2219 87.488V24.3644C34.2227 23.7479 34.4669 23.1569 34.9011 22.721C35.3353 22.285 35.924 22.0398 36.538 22.039H69.1369L69.0411 21.729ZM97.3752 21.729H36.538C35.8422 21.73 35.1751 22.008 34.683 22.502C34.1909 22.996 33.9141 23.6657 33.9131 24.3644V95.3647C33.9141 96.0634 34.1909 96.7331 34.683 97.2271C35.1751 97.7212 35.8422 97.9991 36.538 98.0001H97.3752C98.0711 97.9991 98.7382 97.7212 99.2302 97.2271C99.7223 96.7331 99.9992 96.0634 100 95.3647V24.3644C99.9992 23.6657 99.7223 22.996 99.2302 22.502C98.7382 22.008 98.0711 21.73 97.3752 21.729ZM99.6913 95.3647C99.6906 95.9812 99.4463 96.5723 99.0121 97.0082C98.5779 97.4441 97.9892 97.6893 97.3752 97.6901H36.538C35.924 97.6893 35.3353 97.4441 34.9011 97.0082C34.4669 96.5723 34.2227 95.9812 34.2219 95.3647V24.3644C34.2227 23.7479 34.4669 23.1569 34.9011 22.721C35.3353 22.285 35.924 22.0398 36.538 22.039H97.3752C97.9892 22.0398 98.5779 22.285 99.0121 22.721C99.4463 23.1569 99.6906 23.7479 99.6913 24.3644V95.3647Z" fill="#4B6175"></path><path d="M81.1623 28.5499H52.751C52.3826 28.5495 52.0293 28.4023 51.7688 28.1408C51.5083 27.8792 51.3617 27.5246 51.3613 27.1547V20.3337C51.3617 19.9638 51.5083 19.6091 51.7688 19.3476C52.0293 19.086 52.3826 18.9389 52.751 18.9385H81.1623C81.5307 18.9389 81.8839 19.086 82.1445 19.3476C82.405 19.6091 82.5515 19.9638 82.552 20.3337V27.1547C82.5515 27.5246 82.405 27.8792 82.1445 28.1408C81.8839 28.4023 81.5307 28.5495 81.1623 28.5499Z" fill="#93A0AC"></path><path d="M66.9563 19.4033C68.6619 19.4033 70.0445 18.0152 70.0445 16.3028C70.0445 14.5905 68.6619 13.2024 66.9563 13.2024C65.2508 13.2024 63.8682 14.5905 63.8682 16.3028C63.8682 18.0152 65.2508 19.4033 66.9563 19.4033Z" fill="#93A0AC"></path><path d="M66.9562 18.1915C67.995 18.1915 68.8372 17.346 68.8372 16.303C68.8372 15.26 67.995 14.4146 66.9562 14.4146C65.9173 14.4146 65.0752 15.26 65.0752 16.303C65.0752 17.346 65.9173 18.1915 66.9562 18.1915Z" fill="white"></path></svg></p>
													<p>No Expired Contracts</p>
												</div>
											<?php } ?>
										</div>
										
									</div>
								</div>
                                <!--  -->
                                <!-- <div class="col-md-12 col-sm-12 mb-2">
                                    <div id="fixterm-container" class="row d-none">
                                        <div class="col-md-4 col-sm-12 mb-3 form-group">
                                            <label for="dl_no">Custom</label>
                                            <input type="text" class="form-control" id="probation_period" name="probation_period" />
                                        </div>
                                    </div>
                                </div> -->
							</div>

                            <div class="row size-inner-section px-2 py-4 mx-2">
								<h4 class="header-title">Annual Leave Entitlement</h4><hr>
                                <div class="col-md-4 col-sm-12 mb-2 form-group">
									<!-- <label for="fix_term">Fix Term</label> -->
									<div>
										<?php if($emp_detail->annual_leave_entitlement == '0'){ echo '0'; } ?><?php if($emp_detail->annual_leave_entitlement == '21'){ echo '21'; } ?><?php if($emp_detail->annual_leave_entitlement == '30'){ echo '30'; } ?>
									</div>
								</div>
							</div>
							<div class="twitter-bs-wizard">
								<ul class="pager wizard twitter-bs-wizard-pager-link">
									<li class="previous"><a href="<?php echo ($emp_detail->id > 0) ? base_url('admin/hr/employees/view/step-2/'.$emp_detail->id) : base_url('admin/hr/employees'); ?>" class="btn btn-custom-secondary"><i class="mdi mdi-arrow-left me-1"></i> Prevoius </a></li>
									<li class="next"><a type="button" href="<?php echo base_url('admin/hr/employees/view/step-4/'.$emp_detail->id);?>" class="btn btn-custom-success">Next Step <i class="mdi mdi-arrow-right ms-1"></i></a></li>
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

<div class="modal fade fixed-left contractModal" aria-labelledby="#contModalFullscreenLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-aside">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="contModalFullscreenLabel">New Contract</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
				
            </div>
			<div class="modal-footer">
				<div class="row">
					<div class="col-md-12">
						<button form="contract_form" type="submit" class="btn btn-success btn-md">Save Contract</button>
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

	$('#work_country').change(function() {
		var country_id = $(this).find('option:selected').val();
		$.ajax({
			url: "<?php echo base_url(); ?>admin/hr-module/employees/Employee/getCities",
			data: {
				country_id: country_id
			},
			dataType: "json",
			type: "POST",
			success: function(data) {
				//console.log(data);
				var html = '<option value="">Select City</option>';
				if (Object.keys(data).length > 0) {
					$.each(data, function(index, item) {
						html += '<option value="' + item.id + '" data-id="' + item.id + '">' + item.city_name + '</option>';
					});
				} else {
					var html = '<option value="">No city found</option>';
				}
				$('#work_city').html(html);
			}
		});
	});

	$('#department').change(function() {
		var department_id = $(this).find('option:selected').val();
		$.ajax({
			url: "<?php echo base_url(); ?>admin/hr-module/employees/Employee/getDesignation",
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
				$('#designation').html(html);
			}
		});

		$.ajax({
			url: "<?php echo base_url(); ?>admin/hr-module/employees/Employee/getBusinessUnit",
			data: {
				department_id: department_id
			},
			dataType: "json",
			type: "POST",
			success: function(data) {
				//console.log(data);
				var html = '<option value="">Select Business Unit</option>';
				if (Object.keys(data).length > 0) {
					$.each(data, function(index, item) {
						html += '<option value="' + item.business_unit_name + '" data-id="' + item.id + '">' + item.business_unit_name + '</option>';
					});
				} else {
					var html = '<option value="">No business unit found</option>';
				}
				$('#business_unit').html(html);
			}
		});
	});

	$('#is_housing_provided').on('click', function() {
		$(".housing-checked select").val(null).trigger("change");
		//$('.housing-checked input[type="checkbox"]:checked').prop('checked',false);
		if($("#is_housing_provided").is(":checked")) {
			$('.housing-checked').removeClass('d-none');
			$("#housing_allowance").val(0);
			$('#housing_allowance').prop('readonly',true);
		}else{
			$('.housing-checked').addClass('d-none');
			$('#housing_allowance').prop('readonly',false);
		}    
	});

	$('#camp').change(function() {
		var camp_id = $(this).find('option:selected').val();
		$("#room").val(null).trigger("change");
		$("#bed").val(null).trigger("change");
		$.ajax({
			url: "<?php echo base_url(); ?>admin/hr-module/employees/Employee/getRooms",
			data: {
				camp_id: camp_id
			},
			dataType: "json",
			type: "POST",
			success: function(data) {
				//console.log(data);
				var html = '<option value="">Select Room</option>';
				if (Object.keys(data).length > 0) {
					$.each(data, function(index, item) {
						html += '<option value="' + item.id + '" data-id="' + item.id + '">' + item.room_name + '</option>';
					});
				} else {
					var html = '<option value="">No room found</option>';
				}
				$('#room').html(html);
			}
		});
	});

	$('#room').change(function() {
		var room_id = $(this).find('option:selected').val();
		$("#bed").val(null).trigger("change");
		$.ajax({
			url: "<?php echo base_url(); ?>admin/hr-module/employees/Employee/getBeds",
			data: {
				room_id: room_id
			},
			dataType: "json",
			type: "POST",
			success: function(data) {
				//console.log(data);
				var html = '<option value="">Select Bed</option>';
				if (Object.keys(data).length > 0) {
					$.each(data, function(index, item) {
						html += '<option value="' + item.id + '" data-id="' + item.id + '">' + item.bed_name + '</option>';
					});
				} else {
					var html = '<option value="">No bed found</option>';
				}
				$('#bed').html(html);
			}
		});
	});

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

	function addContractForm(identifier) {
		let emp_id = $(identifier).data('empid');
		let type = $(identifier).data('type');
		$.ajax({
			type: "POST",
			url: "<?php echo base_url('admin/hr-module/employees/Employee/add_contract_form');?>",
			data: {'emp_id': emp_id,'redirect':'view'},
			//dataType: "json",
			success: function (response) {
				//console.log(response);
				$('.contractModal').modal('show');
				$('.contractModal .modal-body').html(response);
				$('#contModalFullscreenLabel').html(type + ' Contract');
			},
			error: function (request, error) {
				console.log(" Can't do because: " + JSON.stringify(request));
				$('.contractModal .modal-body').after(JSON.stringify(request));
			},
		});
	}

	function updateContractForm(identifier) {
		let id = $(identifier).data('id');
		let type = $(identifier).data('type');
		if(id > 0){
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('admin/hr-module/employees/Employee/update_contract_form');?>",
				data: {'id': id,'redirect':'view'},
				//dataType: "json",
				success: function (response) {
					//console.log(response);
					$('.contractModal').modal('show');
					$('.contractModal .modal-body').html(response);
					$('#contModalFullscreenLabel').html(type + ' Contract');
				},
				error: function (request, error) {
					console.log(" Can't do because: " + JSON.stringify(request));
					$('.contractModal .modal-body').after(JSON.stringify(request));
				},
			});
		}else{
			alert('Invalid request id!');
		}
	}

	$(document).ready(function() {
		getDepartmentHead();
	});
	
	$('#work_line_manager').change(function() {
		getDepartmentHead();
	});

	function getDepartmentHead(){
		var lm_id = $('#work_line_manager').find('option:selected').val();
		$.ajax({
			url: "<?php echo base_url('admin/hr/employees/get-department-head'); ?>",
			data: {
				emp_id: lm_id
			},
			type: "POST",
			success: function(data) {
				console.log(data);
				$('#department_head').html(data);
			},
			error: function (request, error) {
				console.log(" Can't do because: " + JSON.stringify(request));
			},
		});
	}
</script>
