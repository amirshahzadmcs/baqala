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
</style>


<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Employees Attendance</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/hr/attendance/list'); ?>">Employee Attendance</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if (check_action_permission(get_user_role(), 'new_attendance', 'delete')): ?>
						<button type="button" class="btn btn-custom-danger btn-sm pull-right me-2" onclick="deleteAction()" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					<?php endif; ?>
					<?php if (check_action_permission(get_user_role(), 'new_attendance', 'generate_monthly_attendance')): ?>
						<button type="button" class="btn btn-custom-success btn-sm pull-right me-2" title="Generate Attendance" data-bs-toggle="modal" data-bs-target=".addAttendanceModal"><i class="mdi mdi-calendar me-2"></i> Generate Attendance</button>
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
					<div class="card-body">
						<table id="employeeTable" class="table table-bordered jambo_table" style="width:100%">
							<thead>
								<tr>
									<th>Month</th>
									<th class="text-center">Total Emp.</th>
									<th class="text-center">Total Present</th>
									<th class="text-center">Total Absent</th>
									<th class="text-center">Total Records</th>
									<th class="text-center">Created At</th>
									<th class="text-center">Tools</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if (count($attendance_summary) > 0) {
									foreach ($attendance_summary as $summary) {
								?>
										<tr>
											<td>
												<?= ((isset($summary['attendance_month'])) ? date('F Y', strtotime($summary['attendance_month'])) : ''); ?><br>
												<small><?= ((isset($summary['start_date'])) ? date('M d', strtotime($summary['start_date'])) : ''); ?></small>
												->
												<small><?= ((isset($summary['end_date'])) ? date('M d', strtotime($summary['end_date'])) : ''); ?></small>
											</td>
											<td align="center"><?= $summary['total_employees']; ?></td>
											<td align="center"><?= $summary['total_present']; ?></td>
											<td align="center"><?= $summary['total_absent']; ?></td>
											<td align="center"><?= $summary['total_records']; ?></td>
											<td align="center">
												<?= ((isset($summary['created_at'])) ? date('d M Y', strtotime($summary['created_at'])) : 'NA'); ?><br>
												<small><?= ((isset($summary['created_at'])) ? date('H:i A', strtotime($summary['created_at'])) : ''); ?></small>
											</td>
											<td align="center">
												<?php if (check_action_permission(get_user_role(), 'new_attendance', 'detail') || check_action_permission(get_user_role(), 'new_attendance', 'delete') || check_action_permission(get_user_role(), 'new_attendance', 'print_monthly_attendance_summary')): ?>
													<div class="btn-group ms-2">
														<button class="btn btn-light-grey btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															<i class="dripicons-dots-3"></i>
														</button>
														<div class="dropdown-menu dropdown-menu-end">
															<?php
															if (check_action_permission(get_user_role(), 'new_attendance', 'detail')) {
																echo '<a class="dropdown-item" href="' . base_url('admin/hr/attendance/detail/' . $summary['attendance_month']) . '">
                        <i class="mdi mdi-stretch-to-page-outline me-2"></i> Detail
                    </a>';
															}

															if (check_action_permission(get_user_role(), 'new_attendance', 'delete')) {
																echo '<div class="dropdown-divider"></div>
                    <a href="javascript:void(0);" class="dropdown-item delete-attendance" data-month="' . $summary['attendance_month'] . '">
                        <i class="mdi mdi-delete me-2"></i> Delete
                    </a>';
															}

															if (check_action_permission(get_user_role(), 'new_attendance', 'export')) {
																echo '<div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="' . base_url('admin/hr/attendance/export/' . $summary['attendance_month']) . '" target="_blank">
                        <i class="mdi mdi-upload me-2"></i> Export Excel
                    </a>';
															}

															if (check_action_permission(get_user_role(), 'new_attendance', 'print_monthly_attendance_summary')) {
																echo '<div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="' . base_url('admin/hr/attendance/print-monthly-attendance-summary/' . $summary['attendance_month']) . '" target="_blank">
                        <i class="mdi mdi-upload me-2"></i> Export PDF
                    </a>';
															}
															?>
														</div>
													</div>
												<?php endif; ?>
											</td>
										</tr>
									<?php }
								} else { ?>
									<tr>
										<td colspan="7" align="center">No Data Found</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->
<!-- Modal -->
<div class="modal fade addAttendanceModal" id="generateAttendanceModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="addAttendanceModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title px-3" id="addAttendanceModalLabel">Generate Attendance</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="addAttendanceForm" method="post" autocomplete="off">
					<div class="row px-3">
						<div class="col-md-12 col-sm-12 mb-3 form-group">
							<label for="date_of_attend">Attendance Month <span class="text-danger">*</span></label>
							<div class="position-relative" id="datepicker4">
								<input type="text" class="form-control" data-date-container='#datepicker4' data-provide="datepicker" name="date_of_attend" id="date_of_attend" data-date-format="MM yyyy" data-date-autoclose="true" placeholder="Attendance Month" data-date-min-view-mode="1" required>
							</div>
						</div>
						<div id="progressLoader" class="mt-3 text-center" style="display: none;">
							<span class="spinner-border text-primary"></span> Generating Attendance...
						</div>
						<div class="col-md-12 mb-3">
							<button type="save" id="btnUpload" class="btn btn-custom-success btn-md w-100">Generate</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('admin/home/footer'); ?>
<script>
	$(document).ready(function() {
		//initializeDataTable();

		$('#exportBtn').on('click', function(e) {
			e.preventDefault();

			var selectedIds = [];
			$('input[name="checklist[]"]:checked').each(function() {
				selectedIds.push($(this).val());
			});
			var selectedIdsQuery = selectedIds.map(id => `checklist[]=${id}`).join('&');
			var exportUrl = "<?php echo base_url(); ?>admin/hr/payslip/excel-export?keyword=<?php echo $this->input->get('keyword') ?>&designation=<?php echo $this->input->get('designation') ?>&nationality=<?php echo $this->input->get('nationality') ?>&department=<?php echo $this->input->get('department') ?>&iqama_status=<?php echo $this->input->get('iqama_status') ?>&status=<?php echo $this->input->get('status') ?>&iqama=<?php echo $this->input->get('iqama') ?>&start_date=<?php echo $this->input->get('start_date') ?>&end_date=<?php echo $this->input->get('end_date') ?>";

			if (selectedIdsQuery) {
				exportUrl += '&' + selectedIdsQuery;
			}

			window.open(exportUrl, '_blank');
		});
	});

	$(document).ready(function() {
		$(".delete-attendance").click(function() {
			var attendanceMonth = $(this).data("month");
			Swal.fire({
				title: "Are you sure?",
				text: "You won't be able to revert this!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#d33",
				cancelButtonColor: "#3085d6",
				confirmButtonText: "Yes, delete it!"
			}).then((result) => {
				if (result.isConfirmed) {
					window.location.href = "<?= base_url('admin/hr/attendance/delete/') ?>" + attendanceMonth;
				}
			});
		});
	});

	function changeActionAndSubmit(action) {
		document.getElementById('myform').action = action;
		document.getElementById('myform').submit();
	}

	$('.dropify').dropify();

	$("body").on("submit", "#addAttendanceForm", function(e) {
		e.preventDefault(); // Prevent default form submission

		const month = $('#date_of_attend').val();
		if (!month) {
			Swal.fire('Error', 'Please select a month', 'warning');
			return;
		}

		// Check if attendance exists
		$.ajax({
			url: '<?php echo base_url('admin/hr/attendance/check-month-exists'); ?>',
			type: 'POST',
			dataType: 'json', // ✅ Important
			data: {
				month: month
			},
			success: function(data) {
				if (data.exists) {
					Swal.fire({
						title: 'Overwrite Existing Attendance?',
						text: `Attendance for ${month} already exists. Do you want to overwrite it?`,
						icon: 'warning',
						showCancelButton: true,
						confirmButtonText: 'Yes, Overwrite',
						cancelButtonText: 'Cancel'
					}).then((result) => {
						if (result.isConfirmed) {
							generateMonthlyAttendance(month, true);
						}
					});
				} else {
					generateMonthlyAttendance(month, false);
				}
			},
			error: function(xhr, status, error) {
				console.error("AJAX error:", status, error);
				Swal.fire('Error', 'Failed to check existing attendance', 'error');
			}
		});
	});

	function generateMonthlyAttendance(month, overwrite = false) {
		$('#progressLoader').show();

		// Disable the button to prevent multiple submissions
		$('#btnUpload').prop('disabled', true).text('Generating...');

		$.ajax({
			url: '<?php echo base_url('admin/hr/attendance/generate-attendance'); ?>',
			type: 'POST',
			data: {
				month: month,
				overwrite: overwrite ? 1 : 0
			},
			success: function(response) {
				console.log(response);
				$('#progressLoader').hide();
				$('#btnUpload').prop('disabled', false).text('Generate');
				const res = JSON.parse(response);
				const modal = bootstrap.Modal.getInstance(document.getElementById('generateAttendanceModal'));
				modal.hide();
				Swal.fire({
					title: 'Done!',
					text: response.message || 'Attendance generated successfully.',
					icon: 'success'
				}).then(() => {
					location.reload();
				});
			},
			error: function() {
				$('#progressLoader').hide();
				$('#btnUpload').prop('disabled', false).text('Generate');
				Swal.fire('Error', 'Failed to generate attendance', 'error');
			}
		});
	}
</script>