<?php $this->load->view('admin/home/header'); ?>
<style>
	.dataTables_wrapper::-webkit-scrollbar {
		display: none;
	}

	.nav-md .container.body .right_col {
		padding: 10px 10px 0;
		margin-left: 230px;
	}

	#messageContainer {
		max-height: 250px;
		overflow: auto;
		margin-bottom: 5px;
	}

	.size-inner-section {
		box-shadow: 0px 1px 4px #c5c5c5;
		border-radius: 5px;
		margin-bottom: 10px;
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

	#responseContainer {
		position: fixed;
		width: 93%;
		top: 60px;
	}
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Hunger Daily Order</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/logistic-management/hunger/list'); ?>">Hunger Orders</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if (check_action_permission(get_user_role(), 'rider_daily_performance', 'delete')): ?>
						<div class="btn-group">
							<button class="btn btn-custom-danger btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fa fa-trash me-1"></i> Delete <i class="mdi mdi-chevron-down"></i>
							</button>
							<div class="dropdown-menu dropdown-menu-end">
								<a type="button" class="dropdown-item" title="Delete Selected" onclick="deleteAction()">Delete Selected</a>
								<div class="dropdown-divider"></div>
								<a type="button" class="dropdown-item" title="Delete Datewise" onclick="deleteDatewise()">Delete Datewise</a>
							</div>
						</div>
					<?php endif;
					if (check_action_permission(get_user_role(), 'rider_daily_performance', 'import_file')): ?>
						<a class="btn btn-custom-white btn-sm pull-right ms-2" title="Import New Orders" href="javascript:;" data-bs-toggle="modal" data-bs-target=".bulkImportModal"><i class="ti-import"></i> Import New Orders</a>
					<?php endif;
					$dailyPerformanceReport = check_action_permission(get_user_role(), 'rider_daily_performance', 'print_daily_performance');
					$dayWiseReport = check_action_permission(get_user_role(), 'rider_daily_performance', 'print_day_wise_performance');
					$weeklyReport = check_action_permission(get_user_role(), 'rider_daily_performance', 'print_weekly_performance');
					$monthlyPerformanceReport = check_action_permission(get_user_role(), 'rider_daily_performance', 'print_monthly_performance');

					if ($dailyPerformanceReport || $dayWiseReport || $weeklyReport || $monthlyPerformanceReport): ?>
						<div class="btn-group ms-2 float-end">
							<button class="btn btn-custom-white btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fas fa-file-pdf"></i> Print Reports <i class="mdi mdi-chevron-down"></i>
							</button>
							<div class="dropdown-menu dropdown-menu-end">
								<?php if ($dailyPerformanceReport): ?>
									<a class="dropdown-item" title="Daily Performance Report" href="<?php echo base_url('admin/logistic-management/hunger/print-report?keyword=' . $this->input->get('keyword') . '&rider_id=' . $this->input->get('rider_id') .'&vehicle_type=' . $this->input->get('vehicle_type') . '&start_date=' . $this->input->get('start_date') . '&end_date=' . $this->input->get('end_date') . '&team=' . $this->input->get('team') . '&deliveries_less_than=' . $this->input->get('deliveries_less_than')); ?>" target="_blank">Daily Performance Report</a>
								<?php endif; ?>

								<?php if ($dayWiseReport): ?>
									<div class="dropdown-divider"></div>
									<a type="button" class="dropdown-item" title="Day Wise Performance Report" data-bs-toggle="modal" data-bs-target="#filterModal">Day Wise Report</a>
								<?php endif; ?>

								<?php if ($weeklyReport): ?>
									<div class="dropdown-divider"></div>
									<a type="button" class="dropdown-item" title="Weekly Performance Report" data-bs-toggle="modal" data-bs-target=".weeklyReportModal">Weekly Report</a>
								<?php endif; ?>

								<?php if ($monthlyPerformanceReport): ?>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" title="Monthly Performance Report" href="<?php echo base_url('admin/logistic-management/hunger/monthly-report?keyword=' . $this->input->get('keyword') . '&rider_id=' . $this->input->get('rider_id') .'&vehicle_type=' . $this->input->get('vehicle_type') . '&start_date=' . $this->input->get('start_date') . '&end_date=' . $this->input->get('end_date') . '&team=' . $this->input->get('team')); ?>" target="_blank">Monthly Performance Report</a>
								<?php endif; ?>

								<?php if ($monthlyPerformanceReport): ?>
									<div class="dropdown-divider"></div>
									<a type="button" class="dropdown-item" title="Monthly Revenue Report" data-bs-toggle="modal" data-bs-target=".revenueModal">Monthly Revenue Report</a>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
				<?php if ($this->admin->getInfo()) {
					$info = explode("--", $this->admin->getInfo());
					$info_type = $info[0];
					$msg_data = $info[1];
					if ($info_type == 1) {
				?>
						<div class="alert alert-success alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong><?php echo $msg_data; ?></strong>
						</div>

					<?php } else { ?>
						<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong><?php echo $msg_data; ?></strong>
						</div>
				<?php }
				}
				$this->admin->removeInfo();  ?>
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
						<form action="<?php echo base_url('admin/logistic-management/hunger/list'); ?>" method="get" id="filter_form">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Search by Employee Name/Number</label>
										<input type="search" id="keyword" name="keyword" placeholder="Search by Employee Name" value="<?php echo $this->input->get('keyword') ? $this->input->get('keyword') : ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>

								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Rider Id</label>
										<input type="search" id="rider_id" name="rider_id" placeholder="Search Rider ID" value="<?php echo $this->input->get('rider_id') ? $this->input->get('rider_id') : ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>

								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="date_range">Date Range: </label>
									<div class="input-daterange input-group" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#datepicker6">
										<input type="text" class="form-control" name="start_date" placeholder="Start Date" value="<?php echo $this->input->get('start_date'); ?>" autocomplete="off">
										<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
										<input type="text" class="form-control" name="end_date" placeholder="End Date" value="<?php echo $this->input->get('end_date'); ?>" autocomplete="off">
										<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
									</div>
								</div>
							</div>
							<?php
							$adv_show = false;
							if (!empty($this->input->get('team')) || !empty($this->input->get('vehicle_type')) || !empty($this->input->get('deliveries_less_than')) || !empty($this->input->get('city')) || !empty($this->input->get('employer'))) {
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
											<select name="team" class="form-select">
												<option value="">[ All Team]</option>
												<?php foreach ($teams as $mteam) { ?>
													<option value="<?php echo $mteam->id; ?>" <?php echo ($mteam->id == $this->input->get('team')) ? ' selected ' : ''; ?>><?php echo $mteam->name; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label>Vehicle Type</label>
											<select name="vehicle_type" class="form-select">
												<option value="">[ All Type ]</option>
												<option value="bike" <?php echo ('bike' == $this->input->get('vehicle_type')) ? ' selected ' : ''; ?>>Bike</option>
												<option value="car" <?php echo ('car' == $this->input->get('vehicle_type')) ? ' selected ' : ''; ?>>Car</option>
											</select>
										</div>
									</div>
									<div class="col-lg-4 col-md-12 col-sm-12">
										<div class="form-group mb-2">
											<label>Employer</label>
											<select name="employer" class="form-select">
												<option value="">[ All Employers]</option>
												<?php foreach (sponsorsHelper() as $sponsor) { ?>
													<option value="<?php echo $sponsor['id']; ?>" <?php echo ($sponsor['id'] == $this->input->get('employer')) ? ' selected ' : ''; ?>><?php echo $sponsor['employer_name']; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="col-lg-4 col-md-12 col-sm-12">
										<div class="form-group mb-2">
											<label>City</label>
											<select name="city" class="form-select select2">
												<option value="">[ All Cities]</option>
												<?php 
												$cities_list = selectedCitiesHelp('6');
												if(!empty($cities_list)){
													foreach ($cities_list as $city) { ?>
														<option value="<?php echo $city->city_name; ?>" <?php echo ($city->city_name == $this->input->get('city')) ? ' selected ' : ''; ?>><?php echo $city->city_name; ?></option>
												<?php } 
												} ?>
											</select>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label>Deliveries Less Than</label>
											<select name="deliveries_less_than" class="form-select">
												<option value="">[ All Deliveries ]</option>
												<option value="13" <?php echo ('13' == $this->input->get('deliveries_less_than')) ? ' selected ' : ''; ?>>Less Than 13</option>
												<option value="15" <?php echo ('15' == $this->input->get('deliveries_less_than')) ? ' selected ' : ''; ?>>Less Than 15</option>
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
									<a href="<?php echo base_url('admin/logistic-management/hunger/list'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
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
							<table id="hungerTable" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
								<thead>
									<tr>
										<th>#</th>
										<th>S.No.</th>
										<th>Rider Id</th>
										<th>Emp No.</th>
										<th>Rider Name</th>
										<th>&nbsp;&nbsp;&nbsp;Team&nbsp;&nbsp;&nbsp;</th>
										<th>Phone Number</th>
										<th>City Name</th>
										<th>Date_Local</th>
										<th>Completed Deliveries</th>
										<th>Cancelled Deliveries</th>
										<th>Notified Deliveries</th>
										<th>Declined Deliveries</th>
										<th>Accepted Deliveries</th>
										<th>Not Accepted Deliveries</th>
										<th>Monthly Wallet Bal.</th>
										<th>Rider Earnings</th>
										<th>Acceptance Rate</th>
										<th>Rider Delivery Time</th>
										<th>Working Hours</th>
										<th>Vehicle Type</th>
										<th>Created At</th>
										<!-- <th>Tools</th> -->
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

<!-- Modal -->
<div class="modal fade bulkImportModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="bulkImportModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title px-3" id="bulkImportModalLabel">Rider Daily Performance <b>(Hunger)</b></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="messageContainer" class="px-3"></div>
				<form id="delivery_bulk_form" method="post" enctype="multipart/form-data" autocomplete="off">
					<div class="row px-3">
						<div class="col-md-12 col-sm-12 mb-3 form-group">
							<label for="order_date">Date Of Order<span class="text-danger">*</span></label>
							<input type="date" name="order_date" id="order_date" class="form-control" required>
						</div>
						<div class="col-md-12 col-sm-12 mb-3 form-group">
							<label for="attachment">Rider Daily Performance <span class="text-secondary">(Supported file format is: .xls .xlsx)</span></label>
							<input type="file" name="file" id="attachment" class="dropify" accept=".xls,.xlsx,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" data-max-file-size="2M" data-height="100" required>
						</div>
						<div class="col-md-12">
							<p class="text-secondary">Upload the same file format in (.xls) provided from Baqala Station to avoid any errors while importing your data.</p>
							<p style="text-align: center;"><a type="button" href="<?php echo base_url('admin_assets/samples/Hunger_Sample_File.xlsx'); ?>" class="btn bt btn-link text-success" target="_blank" download>Download sample file</a></p>
						</div>
						<div class="col-md-12 mb-3">
							<button type="save" id="btnUpload" class="btn btn-custom-success btn-md w-100">Import</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade staticBackdrop fixed-left filterModal" id="filterModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="#filterModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0" id="filterModalLabel">Print Daily Summary</h5>
				<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url('admin/logistic-management/hunger/print-report2'); ?>" target="_blank" method="get" id="filterForm">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-3">
								<label>Search by Employee Name/Number</label>
								<input type="search" name="filter_keyword" placeholder="Search by Employee Name" value="<?php echo $this->input->get('keyword') ? $this->input->get('keyword') : ''; ?>" autocomplete="off" class="form-control">
							</div>
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-3">
								<label>Rider Id</label>
								<input type="search" name="filter_rider_id" placeholder="Search Rider ID" value="<?php echo $this->input->get('rider_id') ? $this->input->get('rider_id') : ''; ?>" autocomplete="off" class="form-control">
							</div>
						</div>

						<div class="form-group col-lg-12 col-md-12 col-12 mb-3">
							<label for="date_range">Select Month: </label>
							<div class="position-relative" id="datepicker4">
								<input type="text" class="form-control" data-date-container='#datepicker4' data-provide="datepicker"
									data-date-format="MM yyyy" data-date-min-view-mode="1" name="month_of" id="month_of" autocomplete="off" value="<?php echo $this->input->get('month_of'); ?>" required>
							</div>
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-2">
								<label>Team</label>
								<select name="team" class="form-select">
									<option value="">[ All Team]</option>
									<?php foreach ($teams as $mteam) { ?>
										<option value="<?php echo $mteam->id; ?>" <?php echo ($mteam->id == $this->input->get('team')) ? ' selected ' : ''; ?>><?php echo $mteam->name; ?></option>
									<?php } ?>
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

<div class="modal fade staticBackdrop fixed-left weeklyReportModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="#weeklyReportLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0" id="weeklyReportLabel">Print Weekly Summary</h5>
				<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url('admin/logistic-management/hunger/weekly-report'); ?>" target="_blank" method="get" id="weeklyReportForm">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-3">
								<label>Search by Employee Name/Number</label>
								<input type="search" name="filter_keyword" placeholder="Search by Employee Name" value="<?php echo $this->input->get('keyword') ? $this->input->get('keyword') : ''; ?>" autocomplete="off" class="form-control">
							</div>
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-3">
								<label>Rider Id</label>
								<input type="search" name="filter_rider_id" placeholder="Search Rider ID" value="<?php echo $this->input->get('rider_id') ? $this->input->get('rider_id') : ''; ?>" autocomplete="off" class="form-control">
							</div>
						</div>

						<div class="form-group col-lg-12 col-md-12 col-12 mb-3">
							<label for="week_date">Select Week (Sunday–Saturday):</label>
							<div class="position-relative" id="datepicker4">
								<input type="text" id="week_date" name="week_date" class="form-control" 
									value="<?= $this->input->get('week_date') ?? '' ?>" required readonly>
							</div>
							<div id="weekRange" class="mt-2 font-weight-bold"></div>
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12 mb-3">
							<div class="form-group mb-2">
								<label>Team</label>
								<select name="team" class="form-select">
									<option value="">[ All Team]</option>
									<?php foreach ($teams as $mteam) { ?>
										<option value="<?php echo $mteam->id; ?>" <?php echo ($mteam->id == $this->input->get('team')) ? ' selected ' : ''; ?>><?php echo $mteam->name; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-2">
								<label>Employer</label>
								<select name="employer" class="form-select">
									<option value="">[ All Employers]</option>
									<?php foreach (sponsorsHelper() as $sponsor) { ?>
										<option value="<?php echo $sponsor['id']; ?>" <?php echo ($sponsor['id'] == $this->input->get('employer')) ? ' selected ' : ''; ?>><?php echo $sponsor['employer_name']; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-2">
								<label>Performance</label>
								<select name="performance" class="form-select">
									<option value="">[ All Performance]</option>
									<option value="Good" <?php echo ("Good" == $this->input->get('performance')) ? ' selected ' : ''; ?>>Good</option>
									<option value="Needs Focus" <?php echo ("Needs Focus" == $this->input->get('performance')) ? ' selected ' : ''; ?>>Needs Focus</option>
									<option value="Low Performer" <?php echo ("Low Performer" == $this->input->get('performance')) ? ' selected ' : ''; ?>>Low Performer</option>
								</select>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="submit" form="weeklyReportForm" class="btn btn-custom-success">Print Weekly Summary</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade staticBackdrop fixed-left revenueModal" id="revenueModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="#revenueModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0" id="revenueModalLabel">Monthly Revenue Report</h5>
				<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url('admin/logistic-management/hunger/monthly-revenue-report'); ?>" target="_blank" method="get" id="revenueFilterForm">
					<div class="row">
						<div class="form-group col-lg-12 col-md-12 col-12 mb-3">
							<label for="month_of">Select Month <span class="text-danger">*</span></label>
							<div class="position-relative" id="datepicker5">
								<input type="text" class="form-control" data-date-container='#datepicker5' data-provide="datepicker" data-date-format="MM yyyy" data-date-min-view-mode="1" name="month_of" id="month_of" autocomplete="off" value="<?php echo $this->input->get('month_of'); ?>" required>
							</div>
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-2">
								<label>Vehicle Type</label>
								<select name="vehicle_type" class="form-select">
									<option value="">[ All Vehicle Types]</option>
									<option value="bike" <?php echo ($this->input->get('vehicle_type') == 'bike') ? ' selected ' : ''; ?>>Bike</option>
									<option value="car" <?php echo ($this->input->get('vehicle_type') == 'car') ? ' selected ' : ''; ?>>Car</option>
								</select>
							</div>
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-2">
								<label>Employer</label>
								<select name="employer" class="form-select">
									<option value="">[ All Employers]</option>
									<?php foreach (sponsorsHelper() as $sponsor) { ?>
										<option value="<?php echo $sponsor['id']; ?>" <?php echo ($sponsor['id'] == $this->input->get('employer')) ? ' selected ' : ''; ?>><?php echo $sponsor['employer_name']; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="submit" form="revenueFilterForm" class="btn btn-custom-success">Print Revenue Report</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php $this->load->view('admin/home/footer'); ?>
<script>
	/*---- Week ----*/
	function formatDate(date) {
		const options = { year: 'numeric', month: 'short', day: 'numeric' };
		return date.toLocaleDateString(undefined, options);
	}

	$(document).ready(function () {
		$('#week_date').datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true,
			todayHighlight: true
		}).on('changeDate', function (e) {
			const selected = new Date(e.date);
			const day = selected.getDay(); // 0 = Sunday
			const sunday = new Date(selected);
			sunday.setDate(selected.getDate() - day);

			const saturday = new Date(sunday);
			saturday.setDate(sunday.getDate() + 6);

			const weekText = `${formatDate(sunday)} - ${formatDate(saturday)}`;

			// Show inside the input field
			$('#week_date').val(weekText);

			// Optional: show below as well
			$('#weekRange').html(`Week Range: <strong>${weekText}</strong>`);

			// Optional: store hidden values
			// $('<input>').attr({ type: 'hidden', name: 'from_date', value: sunday.toISOString().slice(0,10) }).appendTo('form');
			// $('<input>').attr({ type: 'hidden', name: 'to_date', value: saturday.toISOString().slice(0,10) }).appendTo('form');
		});

		// Re-trigger if already set
		const preset = $('#week_date').val();
		if (preset && preset.match(/^\d{4}-\d{2}-\d{2}$/)) {
			$('#week_date').datepicker('update', preset);
			$('#week_date').trigger('changeDate');
		}
	});
	/*---- Week ----*/
	
	function initializeDataTable() {
		if ($.fn.DataTable.isDataTable('#hungerTable')) {
			$('#hungerTable').DataTable().destroy();
		}

		$('#hungerTable').dataTable({
			"lengthMenu": [
				[25, 50, 100, 500],
				[25, 50, 100, 500]
			],
			//order: [[0, 'asc']],
			dom: 'Blfrtip',
			buttons: [{
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
			"processing": true,
			"serverSide": true,
			"fixedHeader": true,
			"searching": false,
			"ajax": {
				url: "<?php echo base_url(); ?>admin/logistic-management/hunger/ajax-list?keyword=<?php echo $this->input->get('keyword') ?>&rider_id=<?php echo $this->input->get('rider_id') ?>&start_date=<?php echo $this->input->get('start_date') ?>&end_date=<?php echo $this->input->get('end_date') ?>&team=<?php echo $this->input->get('team') ?>&vehicle_type=<?php echo $this->input->get('vehicle_type') ?>&deliveries_less_than=<?php echo $this->input->get('deliveries_less_than') ?>&city=<?php echo $this->input->get('city') ?>&employer=<?php echo $this->input->get('employer') ?>",
				type: "POST"
			},
			"columnDefs": [
				{
					"targets": [0,1,2,3,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21],
					"className": "text-center",
					"orderable": false
				},
				{
					"targets": [4],
					"className": "text-left",
					"orderable": false
				}
			],
		});
	}

	// Call the function to initialize DataTable
	$(document).ready(function() {
		initializeDataTable();
	});


	function deleteAction() {
		var inputCount = $('[name="checklist[]"]:checked').length;
		if (inputCount > 0) {
			if (confirm("Do you want to delete selected items?") == true) {
				changeActionAndSubmit('admin/logistic-management/hunger/delete');
			} else {
				userPreference = "Action Cancelled!";
			}
		} else {
			alert('Plese select check box first');
		}
	}

	function changeActionAndSubmit(action) {
		document.getElementById('myform').action = action;
		document.getElementById('myform').submit();
	}

	$('.dropify').dropify();

	$(document).ready(function() {
		$("body").on("submit", "#delivery_bulk_form", function(e) {
			e.preventDefault();
			var data = new FormData(this);
			$.ajax({
				type: 'POST',
				url: "<?php echo base_url('admin/logistic-management/hunger/import') ?>",
				data: data,
				//dataType: 'json',
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function() {
					$("#btnUpload").prop('disabled', true);
					$("#btnUpload").html('<i class="fa fa-spinner fa-spin"></i> <small>Please wait ...</small>');
				},
				success: function(response) {
					//console.log(response);
					$("#btnUpload").prop('disabled', false);
					$("#btnUpload").html('Import');
					$("#attachment").val('');
					var jsonResponse = JSON.parse(response);
					if (jsonResponse.error_message) {
						var tableHtml = '<p style="color: red;">Error: ' + jsonResponse.error_message + '</p>';
						if (jsonResponse.duplicate_rows) {
							tableHtml += '<h6>Duplicate Rows</h6><table class="table border-danger"><tr><th>S.No.</th><th>Rider ID</th><th>Date</th></tr>';
							$.each(jsonResponse.duplicate_rows, function(index, row) {
								tableHtml += '<tr>';
								tableHtml += '<td>' + row[0] + '</td>';
								tableHtml += '<td>' + row[1] + '</td>';
								tableHtml += '<td>' + formatDateJS(row[2]) + '</td>';
								// $.each(row, function(key, value) {
								// 	tableHtml += '<td>' + value + '</td>';
								// });
								tableHtml += '</tr>';
							});
							tableHtml += '</table>';
						}
						$('#messageContainer').html(tableHtml);
					} else if (jsonResponse.success_message) {
						$('#messageContainer').html('<p style="color: green;">Success: ' + jsonResponse.success_message + '</p>');
					} else if (jsonResponse.duplicate_rows) {
						tableHtml += '<h6>Duplicate Rows</h6><table class="table border-danger"><tr><th>S.No.</th><th>Rider ID</th><th>Date</th></tr>';
						$.each(jsonResponse.duplicate_rows, function(index, row) {
							tableHtml += '<tr>';
							tableHtml += '<td>' + row[0] + '</td>';
							tableHtml += '<td>' + row[1] + '</td>';
							tableHtml += '<td>' + formatDateJS(row[2]) + '</td>';
							// $.each(row, function(key, value) {
							// 	tableHtml += '<td>' + value + '</td>';
							// });
							tableHtml += '</tr>';
						});
						tableHtml += '</table>';
						$('#messageContainer').html(tableHtml);
					}
					initializeDataTable();
				},
				error: function(xhr, status, error) {
					//console.log(error);
					$("#btnUpload").prop('disabled', false);
					$("#btnUpload").html('Import');
					$('#messageContainer').html('<p style="color: red;">Error: ' + error + '</p>');
				}
			});
		});
	});

	function formatDateJS(date_string) {
		// Input date string
		let inputDate = date_string;

		// Convert the input date string into a Date object
		let dateObj = new Date(inputDate);

		// Extract the day, month, and year from the Date object
		let day = dateObj.getDate();
		let month = dateObj.getMonth() + 1; // Months are zero-based, so add 1
		let year = dateObj.getFullYear();

		// Format the date into "d-m-Y"
		let formattedDate = `${day}-${month}-${year}`;

		// Output the formatted date
		return formattedDate;
	}
	/*
	$(document).ready(function() {
		var today = new Date();
		$('#datepicker6').datepicker({
			endDate: today
		});
	});*/
</script>
<script>
	function deleteDatewise() {
		Swal.fire({
			title: 'Delete Records by Date',
			html: `
				<label for="delete-date">Select Date</label>
				<input type="date" id="delete-date" class="swal2-input" />
			`,
			showCancelButton: true,
			confirmButtonText: 'Delete',
			cancelButtonText: 'Cancel',
			confirmButtonColor: '#dc3545',
			cancelButtonColor: '#6c757d',
			customClass: {
				popup: 'my-custom-alert'
			},
			preConfirm: () => {
				const selectedDate = document.getElementById('delete-date').value;
				if (!selectedDate) {
					Swal.showValidationMessage('Please select a date');
					return false;
				}
				return selectedDate;
			}
		}).then((result) => {
			if (result.isConfirmed) {
				const date = result.value;
				const formattedDate = formatDateJS(date);
				// Optional: Confirm again before deletion
				Swal.fire({
					title: `Confirm delete data for ${formattedDate}?`,
					icon: 'warning',
					showCancelButton: true,
					confirmButtonText: 'Yes, delete it',
					cancelButtonText: 'No, cancel',
					confirmButtonColor: '#dc3545',
					cancelButtonColor: '#6c757d'
				}).then((confirmResult) => {
					if (confirmResult.isConfirmed) {
						// Call AJAX to delete data by date
						$.ajax({
							url: '<?= base_url("admin/logistic-management/hunger/delete-datewise") ?>',
							type: 'POST',
							data: { date: date },
							success: function(response) {
								if (response.status) {
									Swal.fire('Deleted!', response.message, 'success');
									// Optionally refresh your table here
									window.location.reload();
								} else {
									Swal.fire('Error!', response.message, 'error');
								}
							},
							error: function() {
								Swal.fire('Error!', 'Something went wrong.', 'error');
							}
						});
					}
				});
			}
		});
	}
</script>