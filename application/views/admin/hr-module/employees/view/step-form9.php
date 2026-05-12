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

.teamMembers table th, td {
	white-space: nowrap;
}
.table-responsive{
	overflow-x: scroll;
	max-height: 70vh;
	min-height: 200px;
}
.teamMembers table thead {
	position: sticky;
	z-index: 2;
	top: 0px;
	background: #fff;
	box-shadow: 2px 1px 4px -1px #a5a3a3;
}
/* Table Container for Consistent Scrolling */
.table-responsive {
	width: 100%;
	overflow-x: auto;
	scrollbar-width: thin; /* Firefox */
	scrollbar-color:rgb(160, 160, 160) #f1f1f1; /* Firefox custom scrollbar */
}

/* Scrollbar Customization for WebKit (Chrome, Safari) */
.table-responsive::-webkit-scrollbar {
	height: 8px;
}

.table-responsive::-webkit-scrollbar-track {
	background: #f1f1f1;
	border-radius: 10px;
}

/*----- Timeline -----*/
.timeline-wrapper {
	display: flex;
	align-items: center;
	justify-content: space-around;
	position: relative;
}

.timeline-line {
	position: absolute;
	height: 2px;
	background: #ccc;
    width: 65%;
    top: 8%;
	z-index: 1;
}

.timeline-step {
	display: flex;
	flex-direction: column;
	align-items: center;
	position: relative;
	z-index: 2;
	width: 33.33%;
}

.timeline-dot {
	width: 12px;
	height: 12px;
	border-radius: 50%;
	margin-bottom: 4px;
	border: 2px solid #fff;
	box-shadow: 0 0 0 2px #ccc;
	background-color: #ccc; /* Default gray */
}

.timeline-dot.active-alloted {
	background-color: #2ecc71;
	box-shadow: 0 0 0 2px #2ecc71;
}

.timeline-dot.active-unalloted {
	background-color: #e67e22;
	box-shadow: 0 0 0 2px #e67e22;
}

.timeline-dot.active-return {
	background-color: #e74c3c;
	box-shadow: 0 0 0 2px #e74c3c;
}

.timeline-label {
	font-size: 12px;
	text-align: center;
	white-space: nowrap;
}

.timeline-date {
	font-size: 11px;
	color: #555;
	margin-top: 2px;
}

.timeline-meter {
	font-size: 11px;
	color: #999;
	margin-top: 2px;
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
					<button onclick="submitButton()" form="employee_form" type="submit" class="btn btn-sm btn-custom-success pull-right" title="Save"><i class="fa fa-save"></i> Save</button>
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
								$active_step = 9;
								$nav_emp_id = isset($emp_detail->id) ? $emp_detail->id : null;
								$this->load->view('admin/hr-module/employees/components/view_step_navigation', compact('active_step', 'nav_emp_id'));
							?>
						</div>
						<div class="row size-inner-section px-2 py-4 mx-2">
							<div class="w-50"><h4 class="header-title float-start">Alloted/Unalloted Vehicle List</h4></div>
							<?php if (!empty($vehicle_logs)) : ?>
							<div class="teamMembers table-responsive">
								<table id="vehicleLogTable" class="table border text-center">
									<thead>
										<tr>
											<th>S.No.</th>
											<th>Type</th>
											<th>Vehicle No.</th>
											<th>Make</th>
											<th>Model</th>
											<th>Color</th>
											<th>Sequel No</th>
											<th>Chassis No</th>
											<th colspan="3">Status</th>
										</tr>
									</thead>
									<tbody>
										<?php $sno=1;foreach($vehicle_logs as $cycle){ ?>
											<tr>
												<td><?= $sno++; ?></td>
												<td><?= $cycle['alloted']['vehicle_no'] ?? 'N/A'; ?></td>
												<td><?= $cycle['alloted']['vehicle_type'] ?? 'N/A'; ?></td>
												<td><?= $cycle['alloted']['make_name'] ?? 'N/A'; ?></td>
												<td><?= $cycle['alloted']['vehicle_model'] ?? 'N/A'; ?></td>
												<td><?= $cycle['alloted']['color_name'] ?? 'N/A'; ?></td>
												<td><?= $cycle['alloted']['sequel_no'] ?? 'N/A'; ?></td>
												<td><?= $cycle['alloted']['chassis_no'] ?? 'N/A'; ?></td>

												<!-- Timeline Column -->
												<td colspan="3">
													<div class="timeline-wrapper">
														<div class="timeline-line"></div>

														<!-- Alloted -->
														<div class="timeline-step">
															<div class="timeline-dot <?= isset($cycle['alloted']) ? 'active-alloted' : ''; ?>"></div>
															<div class="timeline-label">Alloted</div>
															<div class="timeline-date">
																<?= isset($cycle['alloted']) ? date('d-m-Y', strtotime($cycle['alloted']['status_date'])) : '-'; ?>
															</div>
															<div class="timeline-meter">
																<?= $cycle['alloted']['meter_reading'] ?? '-'; ?> km
															</div>
														</div>

														<!-- Unalloted -->
														<div class="timeline-step">
															<div class="timeline-dot <?= isset($cycle['unalloted']) ? 'active-unalloted' : ''; ?>"></div>
															<div class="timeline-label">Unalloted</div>
															<div class="timeline-date">
																<?= isset($cycle['unalloted']) ? date('d-m-Y', strtotime($cycle['unalloted']['status_date'])) : '-'; ?>
															</div>
															<div class="timeline-meter">
																<?= $cycle['unalloted']['meter_reading'] ?? '-'; ?> km
															</div>
														</div>

														<!-- Return -->
														<div class="timeline-step">
															<div class="timeline-dot <?= isset($cycle['return']) ? 'active-return' : ''; ?>"></div>
															<div class="timeline-label">Return</div>
															<div class="timeline-date">
																<?= isset($cycle['return']) ? date('d-m-Y', strtotime($cycle['return']['status_date'])) : '-'; ?>
															</div>
															<div class="timeline-meter">
																<?= $cycle['return']['meter_reading'] ?? '-'; ?> km
															</div>
														</div>
													</div>
												</td>

											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
							<?php else : ?>
							<div class="text-center m-auto">
								<p><i class="dripicons-user text-secondary fa-3x"></i></p>
								<p>No Logs Found</p>
							</div>
							<?php endif; ?>
						</div>

						<div class="row size-inner-section px-2 py-4 mx-2">
							<div class="w-50"><h4 class="header-title float-start">Accident Logs</h4></div>
							<?php if (!empty($accident_logs)) : ?>
							<div class="teamMembers table-responsive">
								<table id="accidentLogTable" class="table border">
									<thead>
										<tr>
											<th>S.No.</th>
											<th>Type</th>
											<th>Vehicle No.</th>
											<th>Make</th>
											<th>Model</th>
											<th>Chassis No</th>
											<th>Date</th>
											<th>Ins. Status</th>
											<th>Ins. Provider</th>
											<th>Accident Attended By</th>
										</tr>
									</thead>
									<tbody>
										<?php $sno1=1;foreach($accident_logs as $accident_info){ ?>
										<tr>
											<td><?php echo $sno1++;?></td>
											<td><?= ucfirst($accident_info['vehicle_type']);?></td>
											<td><?= $accident_info['vehicle_no'];?></td>
											<td><?= $accident_info['make_name'];?></td>
											<td><?= $accident_info['vehicle_model'];?></td>
											<td><?= $accident_info['chassis_no'];?></td>
											<td><?= date('d-m-Y', strtotime($accident_info['accident_date']));?></td>
											<td>
												<?php
													if ($accident_info['ins_status'] == 'Active') {
														$insurance_status = '<span class="badge badge-pill badge-soft-success font-size-13">'.$accident_info['ins_status'].'</span>';
													} else {
														$insurance_status = '<span class="badge badge-pill badge-soft-danger font-size-13">'.$accident_info['ins_status'].'</span>';
													}
												?>
												<?= $insurance_status;?>
												<td><?= $accident_info['insurance_provider'];?></td>
												<td><?= $accident_info['accident_attended_by'];?></td>
											</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
							<?php else : ?>
							<div class="text-center m-auto">
								<p><i class="dripicons-user text-secondary fa-3x"></i></p>
								<p>No Accident Logs Found</p>
							</div>
							<?php endif; ?>
						</div>
						<div class="twitter-bs-wizard">
							<ul class="pager wizard twitter-bs-wizard-pager-link">
								<li class="previous"><a href="<?php echo ($emp_detail->id > 0) ? base_url('admin/hr/employees/view/step-8/'.$emp_detail->id) : base_url('admin/hr/employees'); ?>" class="btn btn-custom-secondary"><i class="mdi mdi-arrow-left me-1"></i> Prevoius </a></li>
								<li class="next"><a type="button" href="<?php echo ($emp_detail->id > 0) ? base_url('admin/hr/employees/view/step-10/'.$emp_detail->id) : base_url('admin/hr/employees'); ?>" class="btn btn-custom-success"> Next Step <i class="mdi mdi-arrow-right ms-1"></i></a></li>
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
	$(document).ready(function() {
		const employeeInfo = "<?php echo $emp_detail->emp_no . ' - ' . $emp_detail->full_name; ?>";

		$('#accidentLogTable').DataTable({
			dom: 'Blfrtip',
			lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
			buttons: [
				{
					extend: 'excel',
					title: 'Accident Log Report',
					messageTop: 'Vehicle Accident Logs of: ' + employeeInfo
				},
				{
					extend: 'pdf',
					title: 'Accident Log Report',
					messageTop: 'Vehicle Accident Logs of: ' + employeeInfo,
					customize: function(doc) {
						doc.styles.title = {
							color: '#4c4c4c',
							fontSize: '16',
							alignment: 'center'
						};
						doc.styles.message = {
							fontSize: 12,
							italics: true,
							alignment: 'center'
						};
					}
				},
				{
					extend: 'print',
					title: 'Accident Log Report',
					messageTop: function () {
						return 'Vehicle Accident Logs of: ' + employeeInfo;
					}
				},
				'colvis'
			],
			pageLength: 10,
			responsive: true
		});

		$('#vehicleLogTable').DataTable({
			dom: 'Blfrtip',
			lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
			buttons: [
				{
					extend: 'excel',
					title: 'Vehicle Report',
					messageTop: 'Alloted/Unalloted Vehicle List of: ' + employeeInfo
				},
				{
					extend: 'pdf',
					title: 'Vehicle Report',
					messageTop: 'Alloted/Unalloted Vehicle List of: ' + employeeInfo,
					customize: function(doc) {
						doc.styles.title = {
							color: '#4c4c4c',
							fontSize: '16',
							alignment: 'center'
						};
						doc.styles.message = {
							fontSize: 12,
							italics: true,
							alignment: 'center'
						};
					}
				},
				{
					extend: 'print',
					title: 'Vehicle Report',
					messageTop: function () {
						return 'Alloted/Unalloted Vehicle List of: ' + employeeInfo;
					}
				},
				'colvis'
			],
			pageLength: 10,
			responsive: true
		});
	});
	$('.dropify').dropify();
</script>
