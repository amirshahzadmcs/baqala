<?php $this->load->view('admin/home/header');?>

<style>
.required-field{
	color:#f00;
}
.nav-pills .nav-link.active, .nav-pills .show>.nav-link {
	color: #fff !important;
	background-color: #005500!important;
}
.nav-tabs-custom .nav-item .nav-link::after {
	content: "";
	background: #005500;
}
.nav-tabs-custom .nav-item .nav-link {
	background: #eee;
}
.size-inner-section {
	box-shadow: 0px 1px 4px #c5c5c5;
	border-radius: 5px;
	margin-bottom: 10px;
}
.cv-documents{
	border: 1px dashed #a9a9a9;
	padding: 6px;
	width: 60px;
	height: 60px;
	margin-top: -9px;
}
.image-container {
	position: relative;
	display: inline-block;
}
.image-container .overlay{
	opacity: 0;
}
.image-container:hover .overlay{
	background: #0006;
	opacity: .9;
	position: absolute;
	top: -9px;
	bottom: 0;
	width: 130px;
	height: 130px;
}
.image-container:hover .edit {
	display: block;
}
.image-container .edit {
	padding-top: 7px;	
	padding-right: 7px;
	position: absolute;
	right: 0;
	left: 0;
	top: 20%;
	display: none;
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
					<h4>New Employee</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/hr/employees'); ?>">Employees</a></li>
						<li class="breadcrumb-item active">New Employee</li>
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
								$active_step = 8;
								$nav_emp_id = isset($emp_detail->id) ? $emp_detail->id : null;
								$this->load->view('admin/hr-module/employees/components/add_step_navigation', compact('active_step', 'nav_emp_id'));
							?>
						</div>
						<div class="row size-inner-section px-2 py-4 mx-2">
							<div class="w-50"><h4 class="header-title float-start">Reporting Line</h4></div>
							
							<?php if (!empty($team_members)) : ?>
							<div class="teamMembers">
								<table class="table border">
									<thead>
										<tr>
											<th>S.No.</th>
											<th>Emp. No.</th>
											<th>Member Name</th>
											<th>Mobile No.</th>
											<th>Designation</th>
											<th>Department</th>
											<th>Joining Date</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
										<?php $sno=1;foreach($team_members as $emp_info){ ?>
										<tr>
											<td><?php echo $sno++;?></td>
											<td><?php echo $emp_info->emp_no;?></td>
											<td><?php echo $emp_info->full_name;?></td>
											<td><?php echo ($emp_info->mobile == '') ? 'NA' : $emp_info->mobile;?></td>
											<td><?php echo ($emp_info->designation_name == '') ? 'NA' : $emp_info->designation_name;?></td>
											<td><?php echo ($emp_info->department_name == '') ? 'NA' : $emp_info->department_name;?></td>
											<td><?php echo ($emp_info->work_joining_date !== '' && $emp_info->work_joining_date !== NULL) ? date('d-m-Y', strtotime($emp_info->work_joining_date)) : 'NA';?></td>
											<?php
											if($emp_info->status == 'Active'){
												$estatus = '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>';
											}elseif($emp_info->status == 'Inactive'){
												$estatus = '<span class="badge badge-pill badge-soft-warning font-size-13">Inactive</span>';
											}elseif($emp_info->status == 'Resigned'){
												$estatus = '<span class="badge badge-pill badge-soft-danger font-size-13">Resigned</span>';
											}elseif($emp_info->status == 'Absconded'){
												$estatus = '<span class="badge badge-pill badge-soft-secondary font-size-13">Absconded</span>';
											}else{
												$estatus = '<span class="badge badge-pill badge-soft-dark font-size-13">Final Exit</span>';
											}
											?>
											<td><?php echo $estatus;?></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
							<?php else : ?>
							<div class="text-center m-auto">
								<p><i class="dripicons-user text-secondary fa-3x"></i></p>
								<p>No Reporting Line</p>
							</div>
							<?php endif; ?>
						</div>
						<div class="twitter-bs-wizard">
							<ul class="pager wizard twitter-bs-wizard-pager-link">
								<li class="previous"><a href="<?php echo ($emp_detail->id > 0) ? base_url('admin/hr/employees/add/step-7/'.$emp_detail->id) : base_url('admin/hr/employees/add/step-1'); ?>" class="btn btn-custom-success"><i class="mdi mdi-arrow-left me-1"></i> Prevoius </a></li>
							</ul>
						</div>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<?php $this->load->view('admin/home/footer');?>

<script type="text/javascript">
$('.dropify').dropify();
</script>
