<?php $this->load->view('admin/home/header');?>
<style>
.dataTables_wrapper::-webkit-scrollbar {
  display: none;
}
.nav-md .container.body .right_col {
    padding: 10px 10px 0;
    margin-left: 230px;
}
</style>


<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
			<div class="page-title">
				<h4>Employee Master</h4>
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="<?php echo base_url('admin/hr/master/employee'); ?>">Employee</a></li>
					<li class="breadcrumb-item active">List</li>
				</ol>
			</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<button type="button" class="btn btn-custom-danger btn-sm pull-right" onclick="deleteAction()" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					&nbsp;
					<a class="btn btn-custom-success btn-sm pull-right me-1" title="Add New Employee" href="<?php echo base_url('admin/hr/master/employee/add')?>"><i class="fa fa-plus"></i> Add Employee</a>
					<div class="btn-group ms-2 float-end">
						<button class="btn btn-custom-white btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-file-export"></i> Export Excel <i class="mdi mdi-chevron-down"></i>
						</button>
						<div class="dropdown-menu dropdown-menu-end">
							<!-- <div class="dropdown-divider"></div> -->
							<a class="dropdown-item" href="<?php echo base_url();?>admin/hr/master/employee/excel-export?keyword=<?php echo $this->input->get('keyword')?>&status=<?php echo $this->input->get('status')?>&mode=<?php echo $this->input->get('mode')?>&role=<?php echo $this->input->get('role')?>&branch=<?php echo $this->input->get('branch')?>&department=<?php echo $this->input->get('department')?>&designation=<?php echo $this->input->get('designation')?>&attendance_restriction=<?php echo $this->input->get('attendance_restriction')?>&emp_id=<?php echo $this->input->get('emp_id')?>" class="btn btn-custom-white btn-sm float-end me-2" target="_blank"><i class="fas fa-file-excel me-2"></i>Export Insurance Info</a>
						</div>
					</div>
				</div>
				<?php if($this->admin->getInfo()){
				$info = explode("--", $this->admin->getInfo());
				$info_type = $info[0];
				$msg_data = $info[1];
				if($info_type == 1){
				?>
				<div class="alert alert-success alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					<strong><?php echo $msg_data; ?></strong>
				</div>
				
				<?php } else{?>
				<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					<strong><?php echo $msg_data;?></strong>
				</div>
				<?php }} $this->admin->removeInfo();  ?>
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
					<div class="card-header">
						<h4 class="header-title mb-0">Search</h4>
					</div>
					<div class="card-body">
						<form action="<?php echo base_url('admin/hr/master/employee'); ?>" method="get" id="filter_form">
							<div class="row">
								<div class="col-lg-8 col-md-8 col-sm-12">
									<div class="form-group mb-2">
										<label>Search by Employee Name or Email Address</label>
										<input type="search" id="keyword" name="keyword" placeholder="Search by Employee Name, ID or Email Address" value="<?php echo $this->input->get('keyword') ? $this->input->get('keyword') : ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>
								
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label class="d-block">Select Status </label>
										<select name="status" class="form-select">
											<option value="">[All Status]</option>
											<option value="active" <?php echo ($this->input->get('status') == 'active') ? 'selected' : '' ?>>Active</option>
											<option value="inactive" <?php echo ($this->input->get('status') == 'inactive') ? 'selected' : '' ?>>Inactive</option>
										</select>
									</div>
								</div>
							</div>
							<?php
								$adv_show = false;
								if(!empty($this->input->get('mode'))){
									$adv_show = true;
								}
								if(!empty($this->input->get('role'))){
									$adv_show = true;
								}
								if(!empty($this->input->get('branch'))){
									$adv_show = true;
								}
								if(!empty($this->input->get('department'))){
									$adv_show = true;
								}
								if(!empty($this->input->get('designation'))){
									$adv_show = true;
								}
								if(!empty($this->input->get('attendance_restriction'))){
									$adv_show = true;
								}
								if(!empty($this->input->get('emp_id'))){
									$adv_show = true;
								}
							?>
							<div class="collapse <?php if($adv_show){ echo ' show';}?>" id="advanceFilter">
								<div class="row">
									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label class="control-label" for="mode">Select Type </label>
											<select name="mode" id="mode" class="form-select">
												<option value="">[All Type]</option>
												<option value="employee" <?php echo ($this->input->get('mode') == 'employee') ? 'selected' : '' ?>>Employee</option>
												<option value="user" <?php echo ($this->input->get('mode') == 'user') ? 'selected' : '' ?>>User</option>
											</select>
										</div>
									</div>

									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label class="control-label" for="role">Select Role </label>
											<select style="height:410px;" name="role" id="role" class="form-control select2">
												<option value="">[All Role]</option>
												<?php foreach(rolesList() as $roles){ ?>
												<option value="<?php echo $roles->id; ?>" <?php echo ($this->input->get('role') == $roles->id) ? 'selected' : '' ?>><?php echo $roles->name; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									
									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label class="d-block">Select Branch </label>
											<select name="branch" class="form-select select2">
												<option value="">[All Branch]</option>
												<?php foreach(branchHelper() as $mbranch) { ?>
													<option value="<?php echo $mbranch->id; ?>" <?php echo ($this->input->get('role') == $mbranch->id) ? 'selected' : '' ?>><?php echo $mbranch->branch_name; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									
									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label class="d-block">Select Department</label>
											<select name="department" class="form-select select2">
												<option value="">[All Department]</option>
												<?php foreach($departments as $department) { ?>
													<option value="<?php echo $department->id; ?>" <?php echo ($this->input->get('department') == $department->id) ? 'selected' : '' ?>><?php echo $department->name; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>

									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label class="d-block">Select Designation</label>
											<select name="designation" class="form-select select2">
												<option value="">[All Designation]</option>
												<?php foreach($positions as $pos) { ?>
													<option value="<?php echo $pos->id; ?>" <?php echo ($this->input->get('designation') == $pos->id) ? 'selected' : '' ?>><?php echo $pos->name; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>

									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label class="control-label" for="attendance_restriction">Select Attendance Restriction </label>
											<select name="attendance_restriction" id="attendance_restriction" class="form-select select2">
												<option value="">[All Attendance Restriction]</option>
											</select>
										</div>
									</div>

									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label>Employee ID</label>
											<input type="search" id="emp_id" name="emp_id" placeholder="Search by Employee ID" value="<?php echo $this->input->get('emp_id') ? $this->input->get('emp_id') : ''; ?>" autocomplete="off" class="form-control">
										</div>
									</div>
								</div>
							</div>
							
							<div class="row mt-2">
								<div class="col-lg-6 col-md-6 col-sm-12">
									<button class="btn btn-outline-secondary waves-effect waves-light" type="button" data-bs-toggle="collapse" data-bs-target="#advanceFilter" aria-expanded="false" aria-controls="advanceFilter"><i class="fas fa-sliders-h"></i> Advance Search</button>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12">
									<button type="submit" class="btn btn-success btn-md float-end ms-2">Apply Filter</button>
									<a href="<?php echo base_url('admin/hr/master/employee'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<form id="myform" name="myform" method="post" action="">
							<table id="store-table" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
								<thead>
									<tr>
										<th>#</th>
										<th>ID</th>
										<th>Emp No</th>
										<th>Name</th>
										<th>Iqama No</th>
										<th>Designation</th>
										<th>Department</th>
										<th>Joining Date</th>
										<th>IBAN</th>
										<th>Status</th>
										<th>Created</th>
										<th>Tools</th>
									</tr>
								</thead>
								<tbody>

								</tbody>
							</table>
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
$(document).ready(function() {
	$('#store-table').dataTable({
		"lengthMenu": [[25, 50, 100, 500], [25, 50, 100, 500]],
		//order: [[0, 'asc']],
		dom: 'Blfrtip',
		buttons: [
			{
				extend: "csv",
				className: "btn-md"
			},
			{
				extend: "excel",
				className: "btn-md"
			},
			{
				extend: "pdfHtml5",
				className: "btn-md"
			},
			{
				extend: "print",
				className: "btn-md"
			},
		],

		"responsive": true,
		"processing":true,
		"serverSide":true,
		"fixedHeader": true,
		"ajax":{
			url:"<?php echo base_url();?>admin/hr/master/Employee/get_list?keyword=<?php echo $this->input->get('keyword')?>&status=<?php echo $this->input->get('status')?>&mode=<?php echo $this->input->get('mode')?>&role=<?php echo $this->input->get('role')?>&branch=<?php echo $this->input->get('branch')?>&department=<?php echo $this->input->get('department')?>&designation=<?php echo $this->input->get('designation')?>&attendance_restriction=<?php echo $this->input->get('attendance_restriction')?>&emp_id=<?php echo $this->input->get('emp_id')?>",
			type:"POST"
		},
		"columnDefs":[
			{
			 "targets":[0,1,2,3,4,5,6,7,8,9,10],
			 "orderable":false
			},
		],
	});
	
});


function deleteAction() {
	var inputCount = $('[name="checklist[]"]:checked').length;
	if(inputCount > 0){
		if (confirm("Do you want to delete selected employee?") == true) {
			changeActionAndSubmit('admin/hr/master/employee/delete');
		} else {
			userPreference = "Action Cancelled!";
		}
	}else{
		alert('Plese select check box first');
	}
}

function changeActionAndSubmit(action) {
	document.getElementById('myform').action = action;
	document.getElementById('myform').submit();
}

</script>
