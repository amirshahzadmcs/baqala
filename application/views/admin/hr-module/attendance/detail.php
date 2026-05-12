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

	#attendanceTable td {
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
					<h4><b><?= $payrollMonth ?> Attendance</b></h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/hr/attendance/list'); ?>">Employee Attendance</a></li>
						<li class="breadcrumb-item active">Detail</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url('admin/hr/attendance/list'); ?>"><i class="fa fa-reply"></i> Back</a>
					<!-- <button type="button" class="btn btn-custom-white btn-sm pull-right me-2" title="Export"><i class="fas fa-file-excel me-2"></i>Export</button> -->
					<div class="btn-group ms-2 float-end">
						<button class="btn btn-custom-white btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="ti-export"></i> Export <i class="mdi mdi-chevron-down"></i>
						</button>
						<div class="dropdown-menu dropdown-menu-end">
							<h6 class="dropdown-header">EXPORT AS</h6>
							<a type="button" class="dropdown-item" id="exportReport" title="Attendance Compliance Report">Compliance Report</a>
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
							<button class="btn btn-secondary btn-sm ms-2 font-size-15" id="btnSearch" type="button" style="height: 39px;">
								<i class="mdi mdi-filter-variant font-size-18"></i> Filters
							</button>
							<button id="resetFilters" class="btn btn-outline-danger btn-sm ms-2 font-size-15" style="height: 39px; display: none;">
								<i class="mdi mdi-filter-remove-outline font-size-18"></i> Reset
							</button>
						</div>
						<table id="attendanceTable" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
							<thead>
								<tr>
									<th>S.No.</th>
									<th>Emp No</th>
									<th>Employee Name</th>
									<th>Iqama No.</th>
									<th>Date</th>
									<th>Attendance</th>
									<th>Vehicle No</th>
									<th>Vehicle Type</th>
									<th>Aggregator ID</th>
									<th>Aggregator Name</th>
									<th>Final Deliveries</th>
									<th>Team</th>
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
			
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade staticBackdrop fixed-left editAttendanceModal" id="editAttendanceModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="#editAttendanceModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">

		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="logsModal" tabindex="-1" aria-labelledby="logsModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="logsModalLabel">Attendance Logs</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>
			<div class="modal-body p-0">
				<div id="logsModalContent" class="p-2" style="overflow-x: scroll;">
					<!-- Logs content will load here -->
				</div>
			</div>
		</div>
	</div>
</div>


<?php $this->load->view('admin/home/footer'); ?>
<script>
	$(document).ready(function() {
		$('#attendanceTable').dataTable({
			"lengthMenu": [
				[25, 50, 100, 500],
				[25, 50, 100, 500]
			],
			//order: [[0, 'asc']],
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
				url: "<?php echo base_url(); ?>admin/hr/attendance/monthly-attendance/<?php echo $monthParam; ?>?keyword=<?php echo $this->input->get('keyword') ?>&attendance_type=<?php echo $this->input->get('attendance_type') ?>&platform=<?php echo $this->input->get('platform') ?>&employer=<?php echo $this->input->get('employer') ?>&team=<?php echo $this->input->get('team') ?>&vehicle_no=<?php echo $this->input->get('vehicle_no') ?>&vehicle_type=<?php echo $this->input->get('vehicle_type') ?>&date_from=<?php echo $this->input->get('date_from') ?>&date_to=<?php echo $this->input->get('date_to') ?>",
				type: "POST"
			},
			"columnDefs": [{
					"targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15],
					"orderable": false
				},
				{
					"targets": [0, 1, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15],
					"className": "text-center"
				}
			],
		});
	});

	$(document).on('click', '.edit-attendance', function() {
		var id = $(this).data('id');

		// Show loader inside modal content
		$('#editAttendanceModal .modal-content').html(
			'<div class="text-center p-5"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Loading...</p></div>'
		);
		$('#editAttendanceModal').modal('show');

		$.ajax({
			url: "<?php echo base_url('admin/hr-module/employees/Attendance/edit_attendance_detail'); ?>/" + id,
			type: "GET",
			dataType: "json",
			success: function(response) {
				if (response.status === 'success') {
					// Inject returned HTML into modal
					$('#editAttendanceModal .modal-content').html(response.html);
				} else {
					$('#editAttendanceModal .modal-content').html(
						'<div class="p-3 text-danger">' + response.message + '</div>'
					);
				}
			},
			error: function() {
				$('#editAttendanceModal .modal-content').html(
					'<div class="p-3 text-danger">Error loading attendance details.</div>'
				);
			}
		});
	});

	$(document).on('click', '.load_logs_modal', function () {
		var id = $(this).data('id');

		// Show loader inside modal body
		$('#logsModalContent').html('<div class="text-center p-4"><i class="fa fa-spinner fa-spin fa-2x"></i></div>');
		$('#logsModal').modal('show');

		$.ajax({
			url: "<?php echo base_url('admin/hr/attendance/view_logs/'); ?>" + id,
			type: "GET",
			dataType: "json",
			success: function (res) {
				if (res.status === 'success') {
					$('#logsModalContent').html(res.html);
				} else {
					$('#logsModalContent').html('<p class="text-danger p-3">' + res.message + '</p>');
				}
			},
			error: function () {
				$('#logsModalContent').html('<p class="text-danger p-3">Error loading logs.</p>');
			}
		});
	});

</script>
<script type="text/javascript">
	$(document).ready(function () {
		$('#btnSearch').on('click', function () {
			// Show loading
			$('#filtersModal .modal-content').html('<div class="p-4 text-center">Loading...</div>');

			// Show modal
			$('#filtersModal').modal('show');

			// Fetch modal content via AJAX
			$.ajax({
				url: "<?php echo base_url('admin/hr/attendance/filter-modal/' . $monthParam);?>",
				type: "GET",
				success: function (response) {
					//console.log(response);
					$('#filtersModal .modal-content').html(response);
				},
				error: function () {
					$('#filtersModal .modal-content').html('<div class="p-4 text-danger text-center">Failed to load content.</div>');
				}
			});
		});
	});

	$(document).ready(function () {
		$('#exportReport').on('click', function () {
			// Show loading
			$('#filtersModal .modal-content').html('<div class="p-4 text-center">Loading...</div>');

			// Show modal
			$('#filtersModal').modal('show');

			// Fetch modal content via AJAX
			$.ajax({
				url: "<?php echo base_url('admin/hr/attendance/export-report-modal/' . $monthParam);?>",
				type: "GET",
				success: function (response) {
					//console.log(response);
					$('#filtersModal .modal-content').html(response);
				},
				error: function () {
					$('#filtersModal .modal-content').html('<div class="p-4 text-danger text-center">Failed to load content.</div>');
				}
			});
		});
	});
</script>

