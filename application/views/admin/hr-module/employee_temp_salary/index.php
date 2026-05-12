<?php $this->load->view('admin/home/header'); ?>
<style>
	.page-content-wrapper{
		min-height:550px;
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
					<h4>Employees Payroll</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/hr/payslip/list'); ?>">Employee Payroll</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if (check_action_permission(get_user_role(), 'employees_payslip', 'delete')): ?>
						<!-- <button type="button" class="btn btn-custom-danger btn-sm pull-right me-2" onclick="deleteAction()" title="Delete"><i class="fa fa-trash"></i> Delete</button> -->
					<?php endif;
					if (check_action_permission(get_user_role(), 'employees_payslip', 'import_file')): ?>
						<button type="button" class="btn btn-custom-success btn-sm pull-right me-2" title="Bulk Import" data-bs-toggle="modal" data-bs-target=".bulkImportModal"><i class="ti-import me-2"></i> Import Payslip Excel</button>
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
					<div class="card-body">
						<table id="employeeTable" class="table table-bordered jambo_table" style="width:100%">
							<thead>
								<tr>
									<th>Month</th>
									<th class="text-center">Total Emp.</th>
									<th class="text-center">Status</th>
									<th class="text-center">Closing Date</th>
									<th class="text-center">Net Total</th>
									<th class="text-center">Created At</th>
									<th class="text-center">Tools</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if (count($payroll_summary) > 0) {
									$statusMapping = [
										1 => ['label' => 'Review', 'badgeClass' => 'badge-soft-primary'],
										2 => ['label' => 'Confirmed', 'badgeClass' => 'badge-soft-success'],
										3 => ['label' => 'Paid', 'badgeClass' => 'badge-soft-success'],
									];
									foreach ($payroll_summary as $summary) {
								?>
										<tr>
											<td>
												<?= ((isset($summary['payroll_month'])) ? date('F Y', strtotime($summary['payroll_month'])) : ''); ?><br>
												<small><?= ((isset($summary['from_date'])) ? date('M d', strtotime($summary['from_date'])) : ''); ?></small>
												->
												<small><?= ((isset($summary['to_date'])) ? date('M d', strtotime($summary['to_date'])) : ''); ?></small>
											</td>
											<td align="center"><?= $summary['Total_Employees']; ?></td>
											<?php $status = $statusMapping[$summary['status']] ?? ['label' => 'Unknown', 'badgeClass' => 'badge-soft-info']; ?>
											<td align="center"><span class="badge rounded-pill <?= $status['badgeClass'] ?> px-3 py-2 font-size-12"><?= $status['label'] ?></span></td>
											<td align="center">
												<?= ((isset($summary['closing_date'])) ? date('d M Y', strtotime($summary['closing_date'])) : 'NA'); ?><br>
												<small><?= ((isset($summary['closing_date'])) ? date('H:i A', strtotime($summary['closing_date'])) : ''); ?></small>
											</td>
											<td align="center"><?= $summary['Net_Total']; ?></td>
											<td align="center">
												<?= ((isset($summary['created_at'])) ? date('d M Y', strtotime($summary['created_at'])) : 'NA'); ?><br>
												<small><?= ((isset($summary['created_at'])) ? date('H:i A', strtotime($summary['created_at'])) : ''); ?></small>
											</td>
											<td align="center">
												<div class="btn-group ms-2">
													<button class="btn btn-light-grey btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														<i class="dripicons-dots-3"></i>
													</button>
													<div class="dropdown-menu dropdown-menu-end">
													<?= (check_action_permission(get_user_role(), 'employees_payslip', 'detail') ? 
														'<a class="dropdown-item" href="'. base_url('admin/hr/payslip/detail/' . $summary['id']) .'">
															<i class="mdi mdi-stretch-to-page-outline me-2"></i> Detail
														</a>'
													: ''); ?>
													<?= (check_action_permission(get_user_role(), 'employees_payslip', 'detail') ? 
															'<div class="dropdown-divider"></div>
															<a href="javascript:void(0);" class="dropdown-item delete-payslip" data-id="'. $summary['id'] .'">
																<i class="mdi mdi-delete me-2"></i> Delete
															</a>'
														: ''); ?>
													<?= (check_action_permission(get_user_role(), 'employees_payslip', 'payrollDetailExport') ?
														'<div class="dropdown-divider"></div>
														<a class="dropdown-item" href="'. base_url('admin/hr/payslip/export/' . $summary['id']) .'" target="_blank">
															<i class="mdi mdi-upload me-2"></i> Export Excel
														</a>'
													: ''); ?>
													<?= (check_action_permission(get_user_role(), 'employees_payslip', 'payrollDetailExport') ?
														'<div class="dropdown-divider"></div>
														<a class="dropdown-item" href="'. base_url('admin/hr/payslip/download-selected/' . $summary['id']) .'" target="_blank">
															<i class="mdi mdi-upload me-2"></i> Export PDF
														</a>'
													: ''); ?>
													</div>
												</div>
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
<div class="modal fade bulkImportModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="bulkImportModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title px-3" id="bulkImportModalLabel">Bulk Import For <b>Employees Payslip</b></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="messageContainer" class="px-3" style="max-height: 350px;overflow: scroll;"></div>
				<form id="employee_bulk_form" method="post" enctype="multipart/form-data" autocomplete="off">
					<div class="row px-3">
						<div class="col-md-12 col-sm-12 mb-3 form-group">
							<label for="salary_month">Payslip Month <span class="text-danger">*</span></label>
							<div class="position-relative" id="datepicker4">
								<input type="text" class="form-control" data-date-container='#datepicker4' data-provide="datepicker" name="salary_month" id="salary_month" data-date-format="MM yyyy" data-date-autoclose="true" placeholder="Payslip Month" data-date-min-view-mode="1" required>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 mb-3 form-group">
							<label for="attachment">Upload File <span class="text-secondary">(Supported file format is: .xls .xlsx)</span></label>
							<input type="file" name="file" id="attachment" class="dropify" accept=".xls,.xlsx,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" data-max-file-size="2M" data-height="100" required>
						</div>
						<div class="col-md-12">
							<p class="text-secondary">Upload the same file format in (.xls) provided from Baqala Station to avoid any errors while importing your data.</p>
							<p style="text-align: center;"><a type="button" href="<?php echo base_url('admin_assets/samples/Payslip_Sample_File.xlsx'); ?>" class="btn bt btn-link text-success" target="_blank" download>Download sample file</a></p>
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

<?php $this->load->view('admin/home/footer'); ?>
<script>
	/*
	function initializeDataTable() {
		if ($.fn.DataTable.isDataTable('#employeeTable')) {
			$('#employeeTable').DataTable().destroy();
		}

		$('#employeeTable').dataTable({
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
				url: "<?php echo base_url(); ?>admin/hr/payslip/ajax-list?keyword=<?php echo $this->input->get('keyword') ?>&designation=<?php echo $this->input->get('designation') ?>&nationality=<?php echo $this->input->get('nationality') ?>&department=<?php echo $this->input->get('department') ?>&iqama_status=<?php echo $this->input->get('iqama_status') ?>&status=<?php echo $this->input->get('status') ?>&iqama=<?php echo $this->input->get('iqama') ?>&start_date=<?php echo $this->input->get('start_date') ?>&end_date=<?php echo $this->input->get('end_date') ?>",
				type: "POST"
			},
			"columnDefs": [{
				"targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
				"orderable": false
			}, ],
		});
	}
	
	$(document).ready(function () {
        // "Select All" checkbox functionality
        $('#selectAll').on('change', function () {
            $('.rowCheckbox').prop('checked', $(this).prop('checked'));
        });

        // Ensure "Select All" checkbox updates if individual checkboxes change
        $('.rowCheckbox').on('change', function () {
            $('#selectAll').prop('checked', $('.rowCheckbox:checked').length === $('.rowCheckbox').length);
        });
    });
	*/
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
		$(".delete-payslip").click(function() {
			var payslipId = $(this).data("id");
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
					window.location.href = "<?= base_url('admin/hr/payslip/delete/') ?>" + payslipId;
				}
			});
		});
	});

	function changeActionAndSubmit(action) {
		document.getElementById('myform').action = action;
		document.getElementById('myform').submit();
	}

	$('.dropify').dropify();

	$(document).ready(function() {
		$("body").on("submit", "#employee_bulk_form", function(e) {
			e.preventDefault();
			var data = new FormData(this);
			$.ajax({
				type: 'POST',
				url: "<?php echo base_url('admin/hr/payslip/bulk-import') ?>",
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
						$('#messageContainer').html('<p style="color: red;">Error: ' + jsonResponse.error_message + '</p>');
					} else if (jsonResponse.success_message) {
						$('#messageContainer').html('<p style="color: green;">Success: ' + jsonResponse.success_message + '</p>');
						setTimeout(function() {
							location.reload();
						}, 1000);
					} else {
						$('#messageContainer').html('<p style="color: red;">Error: Something went wrong, Try again!</p>');
					}
					//initializeDataTable();
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
</script>