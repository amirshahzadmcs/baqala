<?php $this->load->view('admin/home/header'); ?>
<style>
	.page-content-wrapper {
		min-height: 550px;
	}

	.dataTables_wrapper::-webkit-scrollbar {
		display: none;
	}

	#employeeTable td {
		vertical-align: middle;
	}

	.nav-md .container.body .right_col {
		padding: 10px 10px 0;
		margin-left: 230px;
	}

	.bulkImportModal tbody td,
	.bulkImportModal tbody th,
	.bulkImportModal tbody tr {
		border-color: inherit;
		border-style: solid;
		border-width: 1px;
		padding: 3px 5px !important;
	}

	th {
		white-space: nowrap;
	}

	#vehicleTable td {
		white-space: nowrap;
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
	}

	.modal-dialog-aside {
		width: 35%;
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
					<h4>Fuel Management</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/logistic-management/fuel-management/list'); ?>">Fuel Management</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<button type="button" class="btn btn-custom-white btn-sm pull-right" title="Import Fuel Consumption" data-bs-toggle="modal" data-bs-target=".bulkImportModal"><i class="fas fa-gas-pump me-1"></i> Import Fuel Consumption</button>
					<button class="btn btn-custom-success btn-sm pull-right ms-2" title="Add" id="load_add_modal"><i class="fa fa-plus"></i> Add Vehicle</button>
					<div class="btn-group float-end ms-2">
						<button class="btn btn-custom-white btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="ti-export"></i> Export <i class="mdi mdi-chevron-down"></i>
						</button>
						<div class="dropdown-menu dropdown-menu-end" style="margin: 0px;">
							<h6 class="dropdown-header">EXPORT AS</h6>
							<a type="button" class="dropdown-item" title="Daily Consumption Report" id="openFilterModal">Daily Consumption Report</a>
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
					<div class="card-body" style="overflow: scroll;">
						<div class="d-flex align-items-center justify-content-between position-relative float-end mb-2" style="max-width: 480px;position: absolute !important;right: 11px;top: 11px;">
							<button class="btn btn-secondary btn-sm ms-2 font-size-15" id="btnSearch" type="button" style="height: 39px;" data-bs-toggle="modal" data-bs-target="#filtersModal">
								<i class="mdi mdi-filter-variant font-size-18"></i> Filters
							</button>
							<button id="resetFilters" class="btn btn-outline-danger btn-sm ms-2 font-size-15" style="height: 39px; display: none;">
								<i class="mdi mdi-filter-remove-outline font-size-18"></i> Reset
							</button>
						</div>
						<?php echo form_open('admin/master-vehicle/delete', array("id" => "delete_form")); ?>
						<table id="vehicleTable" class="table table-striped table-bordered jambo_table bulk_action w-100">
							<thead>
								<tr>
									<th>S.No.</th>
									<th>Vehicle No.</th>
									<th>Vehicle Type</th>
									<th>Allotment Status</th>
									<th>Vehicle Category</th>
									<th>Emp No.</th>
									<th>Employee Name</th>
									<th>Date</th>
                                    <th>Fuel Consumption</th>
                                    <th>Order Completed</th>
                                    <th>Avg Per Order</th>
                                    <th>Avg Order Per Day</th>
                                    <th>Working Days</th>
                                    <th>Orders Group</th>
                                    <th>Fuel Group</th>
                                    <th>Aggregator</th>
                                    <th>Aggregator ID</th>
									<!-- <th>Tools</th> -->
								</tr>
							</thead>
						</table>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->
<div class="modal fade staticBackdrop fixed-left vehicle-form-modal" id="vehicleFormModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="#vehicleFormModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">

		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal -->
<div class="modal fade bulkImportModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="bulkImportModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title px-3" id="bulkImportModalLabel">Fuel Consumption File (Excel, .xlsx)</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="messageContainer" class="px-3"></div>
				<form id="delivery_bulk_form" method="post" enctype="multipart/form-data" autocomplete="off">
					<div class="row px-3">
						<div class="col-md-12 col-sm-12 mb-3 form-group">
							<label for="fuel_date">Date of Fuel Consumption <span class="text-danger">*</span></label>
							<input type="date" name="fuel_date" id="fuel_date" class="form-control" required>
						</div>
						<div class="col-md-12 col-sm-12 mb-3 form-group">
							<label for="attachment">Fuel Consumption File <span class="text-danger">*</span> <span class="text-secondary">(Supported file format is: .xls .xlsx)</span></label>
							<input type="file" name="file" id="attachment" class="dropify" accept=".xls,.xlsx,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" data-max-file-size="2M" data-height="100" required>
						</div>
						<div class="col-md-12">
							<p class="text-secondary">Upload the same file format in (.xls) provided from Baqala Station to avoid any errors while importing your data.</p>
							<p style="text-align: center;"><a type="button" href="<?php echo base_url('admin_assets/samples/Fuel-Consumed-Upload.xlsx'); ?>" class="btn bt btn-link text-success" target="_blank" download>Download sample file</a></p>
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

<div class="modal fade staticBackdrop fixed-left filtersModal" id="filtersModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="#filtersModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title px-3" id="filtersModalLabel">Filters</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url('admin/logistic-management/fuel-management/list'); ?>" method="get" id="applyFiltersBtn">
					<div class="row">
						<div class="col-md-12 mb-2">
							<label for="reportrange">Select Date Range:</label>
							<div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
								<i class="fa fa-calendar"></i>&nbsp;
								<span></span> <i class="fa fa-caret-down"></i>
							</div>
							<!-- Hidden inputs to submit selected range -->
							<input type="hidden" name="start_date" id="pending_start_date" value="<?php echo $this->input->get('start_date');?>" required>
							<input type="hidden" name="end_date" id="pending_end_date" value="<?php echo $this->input->get('end_date');?>" required>
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
								<select name="team" id="filter_vehicle_team" class="form-select">
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
									<option value="bike" <?php echo ($this->input->get('vehicle_type') == 'bike') ? "selected" : ""; ?>>Bike</option>
									<option value="car" <?php echo ($this->input->get('vehicle_type') == 'car') ? "selected" : ""; ?>>Car</option>
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
				<a href="<?php echo base_url('admin/logistic-management/fuel-management/list'); ?>" type="button" class="btn btn-secondary">Cancel</a>
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
	$(document).ready(function () {
		var table = $('#vehicleTable').DataTable({
			lengthMenu: [
				[25, 50, 100, 500],
				[25, 50, 100, 500]
			],
			order: [[0, 'desc']],
			dom: 'blrtip',
			buttons: [
				{ extend: 'csv', className: 'btn btn-md btn-outline-secondary' },
				{ extend: 'excel', className: 'btn btn-md btn-outline-secondary' },
				{ extend: 'pdfHtml5', className: 'btn btn-md btn-outline-secondary' },
				{ extend: 'print', className: 'btn btn-md btn-outline-secondary' }
			],
			responsive: false,
			processing: true,
			serverSide: true,
			fixedHeader: true,
			ajax: {
				url: "<?php echo base_url('admin/logistic-management/fuel-management/ajax-list'); ?>",
				type: "POST",
				data: function (d) {
					d.keyword = "<?php echo $this->input->get('keyword'); ?>";
					d.vehicle_no = "<?php echo $this->input->get('vehicle_no'); ?>";
					d.vehicle_type = "<?php echo $this->input->get('vehicle_type'); ?>";
					d.vehicle_category = "<?php echo $this->input->get('vehicle_category'); ?>";
					d.team = "<?php echo $this->input->get('team'); ?>";
					d.start_date = "<?php echo $this->input->get('start_date'); ?>";
					d.end_date = "<?php echo $this->input->get('end_date'); ?>";

					// CSRF Token (if enabled in CodeIgniter)
					d["<?php echo $this->security->get_csrf_token_name(); ?>"] =
						"<?php echo $this->security->get_csrf_hash(); ?>";
				}
			},
			columnDefs: [
				{
					targets: [0,1,2,3,4,5,7,8,9,10,11,12,13,14,15,16],
					orderable: false,
					className: "text-center align-middle"
				},
				{
					targets: 6,
					orderable: false,
					className: "text-start align-middle"
				}
			],
			language: {
				processing: '<div class="spinner-border text-primary" role="status"></div>'
			}
		});

		// Optional: Redraw table on filter change (if you have filter inputs)
		$('#filterForm input, #filterForm select').on('change', function () {
			table.ajax.reload();
		});
	});


	$(document).ready(function() {
		// Check whether any filter is active
		function checkFilters() {
			const filters = [
				$('#filter_keyword').val(),
				$('#filter_vehicle_no').val(),
				$('#filter_vehicle_type').val(),
				$('#filter_vehicle_category').val(),
				$('#filter_vehicle_team').val(),
				$('#pending_start_date').val(),
				$('#pending_end_date').val()
			];
			const hasFilters = filters.some(v => v && v !== '');
			if (hasFilters) $('#resetFilters').show();
			else $('#resetFilters').hide();
		}

		// Initial check
		checkFilters();

		// Watch for changes in any filter
		$('#filter_keyword, #filter_vehicle_no, #filter_vehicle_type, #filter_vehicle_category, #filter_vehicle_team, #pending_start_date, #pending_end_date')
			.on('input change', function() {
				checkFilters();
			});

		// Reset filters
		$('#resetFilters').click(function(e) {
			e.preventDefault();
			window.location.href = "<?php echo base_url('admin/logistic-management/fuel-management/list'); ?>";
		});
	});

	$('.dropify').dropify();

    $(document).ready(function() {
		$('#load_add_modal').click(function() {
			$.ajax({
				url: "<?php echo base_url('admin/logistic-management/fuel-management/add-vehicle'); ?>",
				type: 'GET',
				success: function(response) {
					$('#vehicleFormModal').modal('show');
					$('#vehicleFormModal .modal-content').html(response);
					$('.select2').select2();
				},
				error: function(request, error) {
					console.log(" Can't do because: " + JSON.stringify(request));
					toastr.error('Error loading view.');
				}
			});
		});

		$('#openFilterModal').click(function() {
			$.ajax({
				url: "<?php echo base_url('admin/logistic-management/fuel-management/filter-modal'); ?>",
				type: 'GET',
				success: function(response) {
					$('#vehicleFormModal').modal('show');
					$('#vehicleFormModal .modal-content').html(response);
					$('.select2').select2();
				},
				error: function(request, error) {
					console.log(" Can't do because: " + JSON.stringify(request));
					toastr.error('Error loading view.');
				}
			});
		});
	});

	$(document).ready(function() {
		$("body").on("submit", "#delivery_bulk_form", function(e) {
			e.preventDefault();
			var data = new FormData(this);

			$.ajax({
				type: 'POST',
				url: "<?php echo base_url('admin/logistic-management/fuel/import') ?>",
				data: data,
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function() {
					$("#btnUpload").prop('disabled', true);
					$("#btnUpload").html('<i class="fa fa-spinner fa-spin"></i> <small>Please wait ...</small>');
				},
				success: function(response) {
					$("#btnUpload").prop('disabled', false);
					$("#btnUpload").html('Import');
					$("#attachment").val('');
					$('#messageContainer').html('');

					let jsonResponse = JSON.parse(response);
					let tableHtml = '';

					// 🟥 Show Error Message
					if (jsonResponse.error_message) {
						tableHtml += '<p style="color: red;">Error: ' + jsonResponse.error_message + '</p>';
					}

					// 🟧 Show Duplicate Rows
					if (jsonResponse.duplicate_rows && jsonResponse.duplicate_rows.length > 0) {
						tableHtml += '<h6 class="mt-3 text-danger">Duplicate Rows</h6>';
						tableHtml += '<table class="table table-bordered table-sm">';
						tableHtml += '<thead><tr><th>S.No.</th><th>Vehicle No.</th><th>Fuel</th></tr></thead><tbody>';
						$.each(jsonResponse.duplicate_rows, function(index, row) {
							tableHtml += `<tr>
								<td>${row[0]}</td>
								<td>${row[1]}</td>
								<td>${row[2]}</td>
							</tr>`;
						});
						tableHtml += '</tbody></table>';
					}

					// 🟨 Show Missing Vehicles
					if (jsonResponse.missing_vehicles && jsonResponse.missing_vehicles.length > 0) {
						tableHtml += '<h6 class="mt-3 text-danger">Missing Vehicles (Not Found in System)</h6>';
						tableHtml += '<table class="table table-bordered table-sm">';
						tableHtml += '<thead><tr><th>Row No.</th><th>Vehicle No.</th><th>Fuel</th></tr></thead><tbody>';
						$.each(jsonResponse.missing_vehicles, function(index, row) {
							tableHtml += `<tr>
								<td>${row[0]}</td>
								<td><span class="text-danger fw-bold">${row[1]}</span></td>
								<td>${row[2]}</td>
							</tr>`;
						});
						tableHtml += '</tbody></table>';
					}

					// 🟩 Show Success Message
					if (jsonResponse.success_message) {
						tableHtml += '<p style="color: green;">Success: ' + jsonResponse.success_message + '</p>';
					}

					$('#messageContainer').html(tableHtml);

					// Optional: Redirect only if fully successful
					if (jsonResponse.success_message && 
						(!jsonResponse.missing_vehicles || jsonResponse.missing_vehicles.length === 0) &&
						(!jsonResponse.duplicate_rows || jsonResponse.duplicate_rows.length === 0)) {

						setTimeout(function() {
							window.location.href = "<?php echo base_url('admin/logistic-management/fuel-management/list'); ?>";
						}, 1000);
					}
				},
				error: function(xhr, status, error) {
					$("#btnUpload").prop('disabled', false);
					$("#btnUpload").html('Import');
					$('#messageContainer').html('<p style="color: red;">Error: ' + error + '</p>');
				}
			});
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
<script type="text/javascript">
$(function() {
    // Get PHP values from GET parameters
    var start = "<?php echo $this->input->get('start_date'); ?>";
    var end   = "<?php echo $this->input->get('end_date'); ?>";

    function cb(start, end) {
        // Update text display
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        // Update hidden inputs for form
        $('#pending_start_date').val(start.format('YYYY-MM-DD'));
        $('#pending_end_date').val(end.format('YYYY-MM-DD'));
    }

    $('#reportrange').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        },
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    // If user had already selected a range, display it
    if (start && end) {
        $('#reportrange').data('daterangepicker').setStartDate(moment(start));
        $('#reportrange').data('daterangepicker').setEndDate(moment(end));
        cb(moment(start), moment(end));
    } else {
        // No previous filter — clear text and hidden inputs
        $('#reportrange span').html('No date selected');
        $('#pending_start_date').val('');
        $('#pending_end_date').val('');
    }

    // When user clears selection
    $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
        $(this).find('span').html('No date selected');
        $('#pending_start_date').val('');
        $('#pending_end_date').val('');
    });
});
</script>


