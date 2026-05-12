<?php $this->load->view('admin/home/header'); ?>
<style>
	.dataTables_wrapper::-webkit-scrollbar {
		display: none;
	}

	.nav-md .container.body .right_col {
		padding: 10px 10px 0;
		margin-left: 230px;
	}


	.main-body {
		padding: 15px;
	}

	.main-body hr {
		margin: 0.7rem 0;
	}

	.card {
		box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
	}

	.card {
		position: relative;
		display: flex;
		flex-direction: column;
		min-width: 0;
		word-wrap: break-word;
		background-color: #fff;
		background-clip: border-box;
		border: 0 solid rgba(0, 0, 0, .125);
		border-radius: .25rem;
	}

	.card-body {
		flex: 1 1 auto;
		min-height: 1px;
		padding: 1rem;
	}

	.gutters-sm {
		margin-right: -8px;
		margin-left: -8px;
	}

	.gutters-sm>.col,
	.gutters-sm>[class*=col-] {
		padding-right: 8px;
		padding-left: 8px;
	}

	.mb-3,
	.my-3 {
		margin-bottom: 1rem !important;
	}

	.bg-gray-300 {
		background-color: #e2e8f0;
	}

	.h-100 {
		height: 100% !important;
	}

	.shadow-none {
		box-shadow: none !important;
	}


	@media only screen and (max-width: 600px) {
		.modal-dialog-aside {
			width: 100% !important;
			max-width: 100% !important;
		}

		.employee-detail {
			display: block !important;
		}

		.employee-detail .image {
			text-align: center;
			margin-top: 10px;
		}
	}

	.modal-dialog-aside {
		width: 25%;
		max-width: 80%;
		height: 100%;
		margin: 0;
		transform: translate(0);
		transition: transform .2s;
	}

	.modal-dialog-aside .modal-content {
		height: inherit;
		border: 0;
		border-radius: 0;
	}

	.modal-dialog-aside .modal-content .modal-body {
		overflow-y: auto
	}

	.modal.fixed-left .modal-dialog-aside {
		margin-left: auto;
		transform: translateX(100%);
	}

	.modal.fixed-right .modal-dialog-aside {
		margin-right: auto;
		transform: translateX(-100%);
	}

	.modal.show .modal-dialog-aside {
		transform: translateX(0);
	}
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Timesheet</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/asset/all-conditions'); ?>">Timesheet</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>

			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a href="javascript:;" class="btn btn-custom-danger btn-sm pull-right me-1" onclick="location.reload()"> <i class="fas fa-sync"></i> </a>
					<?php
					$monthlyReport = check_action_permission(get_user_role(), 'timesheet', 'print_monthly_report');
					$printTimesheet = check_action_permission(get_user_role(), 'timesheet', 'print_timesheet');
					$attendanceReport = check_action_permission(get_user_role(), 'timesheet', 'print_attendance_summary');
					if ($monthlyReport || $printTimesheet || $attendanceReport): ?>
						<div class="btn-group ms-2 float-end">
							<button class="btn btn-custom-white btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fas fa-file-pdf"></i> Print Reports <i class="mdi mdi-chevron-down"></i>
							</button>
							<div class="dropdown-menu dropdown-menu-end">
								<?php if ($monthlyReport): ?>
									<a type="button" class="dropdown-item" title="Monthly Report" data-bs-toggle="modal" data-bs-target="#monthlyReportViewModal" onclick="setFormAction('admin/vehicle/print-monthly-report', true)">Monthly Report</a>
									<div class="dropdown-divider"></div>
									<a type="button" class="dropdown-item" title="Monthly Attendance Report" data-bs-toggle="modal" data-bs-target="#monthlyReportViewModal" onclick="setFormAction('admin/attendance/print-monthly-attendance-report', false)">Monthly Attendance Report (PDF)</a>
									<div class="dropdown-divider"></div>
									<a type="button" class="dropdown-item" title="Export Attendance Report" data-bs-toggle="modal" data-bs-target="#monthlyReportViewModal" onclick="setFormAction('admin/attendance/export-monthly-attendance-report', false)">Monthly Attendance Export (Excel)</a>
								<?php endif;
								if ($printTimesheet): ?>
									<div class="dropdown-divider"></div>
									<a target="_blank" href="<?php echo base_url('admin/vehicle/print-timesheet?emp=' . $this->input->get('emp') . '&platform=' . $this->input->get('platform') . '&camp=' . $this->input->get('camp') . '&from=' . $this->input->get('from') . '&to=' . $this->input->get('to')); ?>" class="dropdown-item" title="Print Timesheet">Print Timesheet</a>
								<?php endif;
								if ($attendanceReport): ?>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" title="Attendance Report" type="button" class="btn btn-custom-white btn-sm float-end me-2" data-bs-toggle="modal" data-bs-target="#filterModal">Attendance Report</a>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
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

					<?php } else { ?>
						<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong><?php echo $msg_data; ?></strong>
						</div>
					<?php } ?> <?php }
							$this->admin->removeInfo(); ?>
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
						<form action="<?php echo base_url('admin/vehicle/get-timesheet'); ?>" method="get" id="filter_form">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Date Between (From and To)</label>
										<div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
											<input type="text" class="form-control" id="_from" name="from" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" autocomplete="off" placeholder="Start Date" />
											<input type="text" class="form-control" id="_to" name="to" value="<?php echo $this->input->get('to') ? $this->input->get('to') : ''; ?>" autocomplete="off" placeholder="End Date" />
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Employee Id</label>
										<select class="form-control select2" name="emp" id="">
											<option value="">[Any]</option>
											<?php foreach ($employees as $emp) { ?>
												<option value="<?php echo $emp->id; ?>" <?php echo $this->input->get('emp') == $emp->id ? 'selected' : ''; ?>><?php echo $emp->emp_no; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Aggregator</label>
										<select class="form-control select2" name="platform" id="">
											<option value="">[Any]</option>
											<?php foreach ($platforms as $platform) { ?>
												<option value="<?php echo $platform->id; ?>" <?php echo $this->input->get('platform') == $platform->id ? 'selected' : ''; ?>><?php echo $platform->company_name; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<?php
							$adv_show = false;
							if (!empty($this->input->get('team'))) {
								$adv_show = true;
							}
							if (!empty($this->input->get('location'))) {
								$adv_show = true;
							}
							?>
							<div class="collapse <?php if ($adv_show) {
														echo ' show';
													} ?>" id="advanceFilter">
								<div class="row">

									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label>Team</label>
											<select class="form-control select2" name="team" id="">
												<option value="">[Any]</option>
												<?php foreach ($teams as $team) { ?>
													<option value="<?php echo $team->id; ?>" <?php echo $this->input->get('team') == $team->id ? 'selected' : ''; ?>><?php echo $team->name; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label>Location</label>
											<select class="form-control select2" name="camp" id="">
												<option value="">[Any]</option>
												<?php foreach ($camps as $camp) { ?>
													<option value="<?php echo $camp->id; ?>" <?php echo $this->input->get('camp') == $camp->id ? 'selected' : ''; ?>><?php echo $camp->camp_name; ?></option>
												<?php } ?>
											</select>
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
									<a href="<?php echo base_url('admin/vehicle/get-timesheet'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<?php if (!empty($this->input->get())) { ?>
							<form id="myform" name="myform" method="post" action="">
								<table id="timesheet-table" class="table text-center table-striped table-bordered jambo_table bulk_action" style="width:100%">
									<thead>
										<tr>
											<th>S.No.</th>
											<th>Emp No</th>
											<th>Employee Name</th>
											<th>Vehicle No</th>
											<th>Platform</th>
											<th>Out Time</th>
											<th>Working Hours</th>
											<th>Final Delivery</th>
											<th>Km</th>
											<th>Battery(%)</th>
											<th>Team</th>
											<th>Tools</th>
										</tr>
									</thead>
									<tbody>

									</tbody>
								</table>
							</form>
						<?php } else { ?>
							<h5 class="text-center mb-0 py-5">Apply filter to show data</h5>
						<?php } ?>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>

<!-- Vehicle Timesheet add/Edit Modal -->
<div class="modal fade " id="vehicleModal" data-bs-backdrop="static" role="dialog" aria-labelledby="vehicleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<div>
					<h5 class="modal-title mt-0">Vehicle Timesheet</h5>
				</div>
				<div>
					<!-- <a href="<?php echo base_url() ?>admin/application-manage/department-form-builder" class="btn btn-sm"><i class="fas fa-pencil-alt"></i></a> -->
					<button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
			</div>
			<div class="modal-body">
				<form id="empCheck" action="<?php echo base_url('admin/vehicle/check_employee'); ?>" method="post" data-parsley-validate>
					<div class="row justify-content-center">
						<div class="card bg-light col-md-6">
							<div class="card-body row" id="empNo">
								<div class="col-md-8 form-group">
									<label class="form-label">Employee Id<span class="text-danger">*</span></label>
									<input class="form-control" type="text" name="employee_no" required>
								</div>
								<div class="col-md-4 form-group align-content-end">
									<button form="empCheck" type="submit" class="btn btn-success submit_button">Submit</button>
								</div>
								<p id="empCheckMsg" class="mt-1"></p>
							</div>
						</div>
					</div>
				</form>
				<hr>
				<div class="col-md-12 mb-3" id="empDetails" style="display:none;">

				</div>

			</div>
		</div>
	</div>
</div>

<!-- Vehichle Timesheet View Modal-->
<div class="modal fade " id="timesheetViewModal" data-bs-backdrop="static" role="dialog" aria-labelledby="timesheetViewModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<div>
					<h5 class="modal-title mt-0">Detail</h5>
				</div>
				<div>
					<!-- <button type="button" class="btn btn-sm"><i class="fas fa-pencil-alt"></i></button> -->
					<button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-3 mb-4 form-group">
						<label class="form-label">Vehicle No</label><br>
						<span class="text-muted sheet_view_vehicle_no">Emp No</span>
					</div>
					<div class="col-md-3 mb-4 form-group">
						<label class="form-label">Emp No</label><br>
						<span class="text-muted sheet_view_emp_no">Human Resources</span>
					</div>
					<div class="col-md-3 mb-4 form-group">
						<label class="form-label">Employee Name</label><br>
						<span class="text-muted sheet_view_name">Human Resources</span>
					</div>
					<div class="col-md-3 mb-4 form-group">
						<label class="form-label">Check Out Km</label><br>
						<span class="text-muted sheet_view_checkOut_km">Human Resources</span>
					</div>
					<div class="col-md-3 mb-4 form-group">
						<label class="form-label">Check In Km</label><br>
						<span class="text-muted sheet_view_checkIn_km">Human Resources</span>
					</div>
					<div class="col-md-3 mb-4 form-group">
						<label class="form-label">Check Out Battery(%)</label><br>
						<span class="text-muted sheet_view_checkOut_battery">Human Resources</span>
					</div>
					<div class="col-md-3 mb-4 form-group">
						<label class="form-label">Check In Battery(%)</label><br>
						<span class="text-muted sheet_view_checkIn_battery">Human Resources</span>
					</div>
					<div class="col-md-3 mb-4 form-group">
						<label class="form-label">Check Out Time</label><br>
						<span class="text-muted sheet_view_checkOut_time">Human Resources</span>
					</div>
					<!-- <div class="col-md-3 mb-4 form-group">
						<label class="form-label">Check In Time</label><br>
						<span class="text-muted sheet_view_checkIn_time">Human Resources</span>
					</div> -->
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

<!-- Monthly Report Modal-->
<div class="modal fade " id="monthlyReportViewModal" data-bs-backdrop="static" role="dialog" aria-labelledby="monthlyReportViewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mt-0">Monthly Report</h5>
                </div>
                <div>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form id="monthlyReportForm" target="_blank" method="post" class="" data-parsley-validate>
						<div class="mb-4 form-group" id="employeeField">
                            <label class="form-label">Select Employee</label><br>
                            <select name="emp_id" id="emp_id" class="form-control select2" required>
                                <option value="">Select...</option>
                                <?php foreach ($employees as $emp) { ?>
                                    <option value="<?php echo $emp->id; ?>"><?php echo $emp->emp_no .' - '. $emp->full_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
						<div class="form-group mb-3">
							<label>Team</label>
							<select class="form-control select2" name="team">
								<option value="">[Any]</option>
								<?php foreach ($teams as $team) { ?>
									<option value="<?php echo $team->id; ?>" <?php echo $this->input->get('team') == $team->id ? 'selected' : ''; ?>><?php echo $team->name; ?></option>
								<?php } ?>
							</select>
						</div>
                        <div class="mb-4 form-group">
                            <label class="form-label">Select Month <span class="text-danger">*</span></label><br>
                            <div class="position-relative" id="datepicker4">
                                <input type="text" class="form-control" name="month" data-date-container="#datepicker4" data-provide="datepicker" data-date-format="MM yyyy" data-date-min-view-mode="1" data-date-end-date="1m" autocomplete="off" required>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success" form="monthlyReportForm">Submit</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade staticBackdrop fixed-left filterModal" id="filterModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="#filterModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0" id="filterModalLabel">Print Attendance Summary</h5>
				<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url('admin/vehicle/print-daily-attendance'); ?>" target="_blank" method="get" id="filterForm">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-2">
								<label>Employee Id</label>
								<select class="form-control select2" name="emp">
									<option value="">[Any]</option>
									<?php foreach ($employees as $emp) { ?>
										<option value="<?php echo $emp->id; ?>" <?php echo $this->input->get('emp') == $emp->id ? 'selected' : ''; ?>><?php echo $emp->emp_no; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-2">
								<label>Platform</label>
								<select class="form-control select2" name="platform">
									<option value="">[Any]</option>
									<?php foreach ($platforms as $platform) { ?>
										<option value="<?php echo $platform->id; ?>" <?php echo $this->input->get('platform') == $platform->id ? 'selected' : ''; ?>><?php echo $platform->company_name; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-2">
								<label>Location</label>
								<select class="form-control select2" name="camp">
									<option value="">[Any]</option>
									<?php foreach ($camps as $camp) { ?>
										<option value="<?php echo $camp->id; ?>" <?php echo $this->input->get('camp') == $camp->id ? 'selected' : ''; ?>><?php echo $camp->camp_name; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-2">
								<label>Date of<span class="text-danger">*</span></label>
								<div class="input-group" id="datepicker2">
									<input type="text" class="form-control" name="from" placeholder="dd M, yyyy"
										data-date-format="dd M, yyyy" data-date-container='#datepicker2' data-provide="datepicker"
										data-date-autoclose="true" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" required>
								</div>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-2">
								<label>Attendance Status</label>
								<select class="form-control select2" name="attendance_status">
									<option value="">[Any]</option>
									<option value="P" <?php echo $this->input->get('attendance_status') == 'P' ? 'selected' : ''; ?>>Present</option>
									<option value="A" <?php echo $this->input->get('attendance_status') == 'A' ? 'selected' : ''; ?>>Absent</option>
								</select>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="submit" form="filterForm" class="btn btn-custom-success">Print Summary</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php $this->load->view('admin/home/footer'); ?>
<script type="text/javascript">
	$(function() {
		$('.checkAll').click(function() {
			if (this.checked) {
				$(".checkboxesall").prop("checked", true);
			} else {
				$(".checkboxesall").prop("checked", false);
			}
		});

		$(".checkboxesall").click(function() {
			var numberOfCheckboxes = $(".checkboxesall").length;
			var numberOfCheckboxesChecked = $('.checkboxesall:checked').length;
			if (numberOfCheckboxes == numberOfCheckboxesChecked) {
				$(".checkAll").prop("checked", true);
			} else {
				$(".checkAll").prop("checked", false);
			}
		});
	});

	$(document).ready(function() {
		$('#filterModal').on('shown.bs.modal', function() {
			$('#datepicker6_from, #datepicker6_to').datepicker({
				format: "dd M, yyyy",
				autoclose: true,
				container: '#filterModal'
			});
		});
	});
</script>

<script>
	$(document).ready(function() {
		$('#timesheet-table').dataTable({
			"lengthMenu": [
				[25, 50, 100, 500],
				[25, 50, 100, 500]
			],
			dom: 'Blfrtip',
			buttons: [{
					extend: "copy",
					className: "btn-md"
				},
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
			processing: true,
			serverSide: true,
			responsive: true,
			fixedHeader: true,
			searching: false,
			ajax: {
				url: "<?php echo base_url('admin/vehicle/get-list?emp=' . $this->input->get('emp') . '&platform=' . $this->input->get('platform') . '&camp=' . $this->input->get('camp') . '&from=' . $this->input->get('from') . '&to=' . $this->input->get('to')) . '&team=' . $this->input->get('team'); ?>",
				type: "POST",
				error: function(request, error) {
					console.log(" Can't do because: " + JSON.stringify(request));
				},
			},

			columnDefs: [{
					targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
					orderable: false,
				},
				{
					targets: [2, 5],
					className: 'text-start'
				}
			],

		});
	});

	function setFormAction(action, showEmployeeField) {
        // Set the form action
        document.getElementById('monthlyReportForm').action = `<?php echo base_url(); ?>${action}`;
        
        // Show or hide the employee field
        const employeeField = document.getElementById('employeeField');
        const empSelect = document.getElementById('emp_id');
        if (showEmployeeField) {
            empSelect.setAttribute("required", "required");
        } else {
            empSelect.removeAttribute("required");
        }
    }
</script>