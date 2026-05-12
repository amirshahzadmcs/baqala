<?php $this->load->view('admin/home/header'); ?>
<style>
	.dataTables_wrapper::-webkit-scrollbar {
		display: none;
	}

	.nav-md .container.body .right_col {
		padding: 10px 10px 0;
		margin-left: 230px;
	}

	th {
		white-space: nowrap;
	}

	#fuelTable td {
		white-space: nowrap;
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
		width: 30%;
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

	#logsModal table th, #logsModal table td {
		white-space: nowrap;
	}
	#modalLogsContent {
		overflow-x: auto;
	}
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<?php
					$monthParam = $this->uri->segment(5); // Adjust segment index as per your URL structure
					$payrollMonth = (!empty($monthParam)) ? date('F Y', strtotime($monthParam . '-01')) : '';
					?>
					<h4><b><?= $payrollMonth ?> Fuel Consumption</b></h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/logistic-management/fuel/list'); ?>">Fuel Consumption</a></li>
						<li class="breadcrumb-item active">Detail</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url('admin/logistic-management/fuel/list'); ?>"><i class="fa fa-reply"></i> Back</a>
					<div class="btn-group ms-2 float-end">
						<button class="btn btn-custom-white btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fas fa-file-pdf"></i> Print Reports <i class="mdi mdi-chevron-down"></i>
						</button>
						<div class="dropdown-menu dropdown-menu-end" style="margin: 0px;">
							<a class="dropdown-item" title="Daily Consumption Report" href="javascript:void(0);" target="_blank">Daily Consumption Report <br><small>Current Filter will be applied</small></a>

							<div class="dropdown-divider"></div>
							<a type="button" class="dropdown-item" title="Day Wise Consumption Report" data-bs-toggle="modal" data-bs-target="#filterModal">Day Wise Consumption Report</a>

							<div class="dropdown-divider"></div>
							<a type="button" class="dropdown-item" title="Weekly Consumption Report" data-bs-toggle="modal" data-bs-target=".weeklyReportModal">Weekly Consumption Report</a>

							<div class="dropdown-divider"></div>
							<a class="dropdown-item" title="Monthly Consumption Report" href="javascript:void(0);" target="_blank">Monthly Consumption Report</a>
						</div>
					</div>
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
					<div class="card-body" style="overflow: scroll;">
						<div class="d-flex align-items-center justify-content-between position-relative float-end mb-2" style="max-width: 480px;">
							<button class="btn btn-secondary btn-sm ms-2 font-size-15" id="btnSearch" type="button" style="height: 39px;" data-bs-toggle="modal" data-bs-target="#filtersModal">
								<i class="mdi mdi-filter-variant font-size-18"></i> Filters
							</button>
							<button id="resetFilters" class="btn btn-outline-danger btn-sm ms-2 font-size-15" style="height: 39px; display: none;">
								<i class="mdi mdi-filter-remove-outline font-size-18"></i> Reset
							</button>
						</div>
						<table id="fuelTable" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
							<thead>
								<tr>
									<th>S.No.</th>
									<th>Vehicle No</th>
									<th>Vehicle Type</th>
									<th>Allotment Status</th>
									<th>Emp No</th>
									<th>Employee Name</th>
									<th>Fuel Date</th>
									<th>Fuel Consumption</th>
									<th>Order Completed</th>
									<th>Average Per Order</th>
									<th>Aggregator ID</th>
									<!--
									<th>Designation</th>
									<th>Team</th>
									<th>Aggregator Name</th>
									-->
									<th>Remarks</th>
									<th>Created At</th>
									<th>Updated At</th>
									<th>Tools</th>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<div class="modal fade staticBackdrop fixed-left filtersModal" id="filtersModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="#filtersModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title px-3" id="filtersModalLabel">Filters</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url('admin/logistic-management/fuel/detail/' . $monthParam); ?>" method="get" id="applyFiltersBtn">
					<div class="row">
						<div class="col-md-12 mb-2">
							<label for="date_from">Select Date Range</label>
							<div class="input-daterange input-group" id="datepicker_filter" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#datepicker_filter">
								<input type="text" class="form-control" name="date_from" id="dateFrom" placeholder="Start Date" value="<?php echo $this->input->get('date_from'); ?>" autocomplete="off">
								<input type="text" class="form-control" name="date_to" id="dateTo" placeholder="End Date" value="<?php echo $this->input->get('date_to'); ?>" autocomplete="off">
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-2">
								<label>Search by Emp. Name or Emp. No.</label>
								<select class="form-control" class="form-control" placeholder="Search by Emp. Name or Emp. ID" aria-label="Employee Number" name="keyword" id="filter_keyword" aria-describedby="button-addon2">
									<option value="">Search...</option>
								</select>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-2">
								<label>Team</label>
								<select name="team" class="form-select">
									<option value="">[ All Team]</option>
									<?php foreach ($teams as $mteam) { ?>
										<option value="<?php echo $mteam->name; ?>" <?php echo ($mteam->name == $this->input->get('team')) ? ' selected ' : ''; ?>><?php echo $mteam->name; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-2">
								<label>Vehicle No.</label>
								<input type="search" id="filter_vehicle_no" name="vehicle_no" placeholder="Search by Vehicle No. etc." value="<?php echo $this->input->get('vehicle_no') ? $this->input->get('vehicle_no') : ''; ?>" autocomplete="off" class="form-control">
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-2">
								<label>Vehicle Type</label>
								<select name="vehicle_type" id="filter_vehicle_type" class="form-control select2">
									<option value="">[Any Type]</option>
									<option value="bike" <?php echo ($this->input->get('attendance_type') == 'bike') ? "selected" : ""; ?>>Bike</option>
									<option value="car" <?php echo ($this->input->get('attendance_type') == 'car') ? "selected" : ""; ?>>Car</option>
								</select>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-2">
								<label>Vehicle Category</label>
								<select name="vehicle_category" id="filter_vehicle_category" class="form-control select2">
									<option value="">[Any Category]</option>
									<option value="Staff" <?php echo ($this->input->get('vehicle_category') == 'Staff') ? "selected" : ""; ?>>Staff</option>
                                    <option value="TGA" <?php echo ($this->input->get('vehicle_category') == 'TGA') ? "selected" : ""; ?>>TGA</option>
                                    <option value="Route" <?php echo ($this->input->get('vehicle_category') == 'Route') ? "selected" : ""; ?>>Route</option>
								</select>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<a href="<?php echo base_url('admin/logistic-management/fuel/detail/' . $monthParam); ?>" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</a>
				<button type="submit" form="applyFiltersBtn" class="btn btn-custom-success">Apply Filters</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<?php $this->load->view('admin/home/footer'); ?>
<script>
	$(document).ready(function() {
		$('#fuelTable').dataTable({
			"lengthMenu": [
				[25, 50, 100, 500],
				[25, 50, 100, 500]
			],
			//order: [[0, 'asc']],
			//dom: 'blrtip',
			dom: 'blrtip',
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

			"responsive": false,
			"processing": true,
			"serverSide": true,
			"fixedHeader": true,
			"ajax": {
				url: "<?php echo base_url(); ?>admin/logistic-management/fuel/monthly-fuel/<?php echo $monthParam; ?>?keyword=<?php echo $this->input->get('keyword') ?>&vehicle_no=<?php echo $this->input->get('vehicle_no') ?>&vehicle_type=<?php echo $this->input->get('vehicle_type') ?>&vehicle_category=<?php echo $this->input->get('vehicle_category') ?>&team=<?php echo $this->input->get('team') ?>&date_from=<?php echo $this->input->get('date_from') ?>&date_to=<?php echo $this->input->get('date_to') ?>",
				type: "POST"
			},
			"columnDefs": [{
					"targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
					"orderable": false
				},
				{
					"targets": [0, 1, 2, 3, 4, 6, 7, 8, 9, 10, 11, 12, 13, 14],
					"className": "text-center"
				}
			],
		});
	});

	$(document).ready(function() {
		// Show reset button if any filter/search is applied
		function checkFilters() {
			const search      = $('#filter_keyword').val();
			const vehicleNo   = $('#filter_vehicle_no').val();
			const vehicleType = $('#filter_vehicle_type').val();
			const vehicleCategory = $('#filter_vehicle_category').val();
			const vehicleTeam = $('#filter_vehicle_team').val();
			const dateFrom    = $('#dateFrom').val();
			const dateTo      = $('#dateTo').val();

			if (search || vehicleNo || vehicleType || vehicleCategory || vehicleTeam || dateFrom || dateTo) {
				$('#resetFilters').show();
			} else {
				$('#resetFilters').hide();
			}
		}

		// Initial check
		checkFilters();

		// Run on filter change
		$('#filter_keyword, #filter_vehicle_no, #filter_vehicle_type, #filter_vehicle_category, #filter_vehicle_team, #dateFrom, #dateTo').on('input change', function() {
			checkFilters();
		});

		// Reset filters
		$('#resetFilters').click(function() {
			window.location.href = "<?php echo base_url('admin/logistic-management/fuel/detail/' . $monthParam); ?>";
			$(this).hide();
		});
	});

	$(document).ready(function () {
		$('#filter_keyword').select2({
			placeholder: 'Search...',
			allowClear: true,
			minimumInputLength: 3,
			ajax: {
				url: "<?php echo base_url('admin/logistic-management/fuel/search-emp-list'); ?>",
				type: 'GET',
				dataType: 'json',
				delay: 250,
				data: function(params) {
					return {
						search: params.term
					};
				},
				processResults: function(data) {
					return {
						results: $.map(data, function(item) {
							//console.log(item);
							return {
								id: item.emp_no,
								text: item.emp_no + ' - ' + item.full_name
							};
						})
					};
				},
				error: function(xhr, status, error) {
					console.log(xhr.responseText);
				}
			}
		});

		// Preselect value if already chosen
		var selectedKeyword = "<?php echo $this->input->get('keyword'); ?>";
		if (selectedKeyword) {
			$.ajax({
				url: "<?php echo base_url('admin/logistic-management/fuel/search-emp-list'); ?>",
				type: "GET",
				data: { search: selectedKeyword },
				dataType: 'json',
				success: function (data) {
					let item = data.find(emp => emp.emp_no === selectedKeyword);
					if (item) {
						var option = new Option(item.emp_no + " - " + item.full_name, item.emp_no, true, true);
						$('#filter_keyword').append(option).trigger('change'); 
					}
				}
			});
		}
	});
</script>