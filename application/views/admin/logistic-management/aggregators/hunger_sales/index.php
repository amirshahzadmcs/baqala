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
					<h4>Hunger Sales Data</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/logistic-management/invoices/hunger-sales/list'); ?>">Hunger Sales Data</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if (check_action_permission(get_user_role(), 'sales_data', 'delete')): ?>
						<button type="button" class="btn btn-custom-danger btn-sm pull-right" onclick="deleteAction()" title="Delete"><i class="fa fa-trash me-1"></i> Delete</button>
					<?php endif;
					if (check_action_permission(get_user_role(), 'sales_data', 'import_file')): ?>
						<a class="btn btn-custom-white btn-sm pull-right ms-2" title="Import" href="javascript:;" data-bs-toggle="modal" data-bs-target=".bulkImportModal"><i class="ti-import"></i> Import</a>
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
									<th class="text-center">Completed Orders</th>
									<th class="text-center">Total Basic Payment</th>
									<th class="text-center">Total Monthly Balance</th>
									<th class="text-center">Created At</th>
									<th class="text-center">Tools</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if (count($hunger_summary) > 0) {
									foreach ($hunger_summary as $summary) {
								?>
										<tr>
											<td>
												<?= ((isset($summary['summary_month'])) ? date('F Y', strtotime($summary['summary_month'])) : ''); ?><br>
												<small><?= ((isset($summary['from_date'])) ? date('M d', strtotime($summary['from_date'])) : ''); ?></small>
												->
												<small><?= ((isset($summary['to_date'])) ? date('M d', strtotime($summary['to_date'])) : ''); ?></small>
											</td>
											<td align="center"><?= $summary['Total_Employees']; ?></td>

											<td align="center"><?= $summary['Completed_Orders']; ?></td>
											<td align="center"><?= $summary['Total_Basic_Payment']; ?></td>
											<td align="center"><?= $summary['Total_Monthly_Balance']; ?></td>
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
														<?php if (check_action_permission(get_user_role(), 'sales_data', 'detail')): ?>
															<a class="dropdown-item" href="<?= base_url('admin/logistic-management/invoices/hunger-sales/detail/' . $summary['id']); ?>">
																<i class="mdi mdi-stretch-to-page-outline me-2"></i> Detail
															</a>
														<?php endif;
														if (check_action_permission(get_user_role(), 'sales_data', 'print_sales_data') || check_action_permission(get_user_role(), 'sales_data', 'export_sales_data')): ?>
															<div class="dropdown-divider"></div>
															<a type="button" class="dropdown-item export-btn" title="Sales Report" data-bs-toggle="modal" data-bs-target="#exportModal" data-requestid="<?= $summary['id']; ?>">
																<i class="mdi mdi-download me-2"></i> Download
															</a>
														<?php endif; ?>
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
<div class="modal fade bulkImportModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="bulkImportModalLabel">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title px-3" id="bulkImportModalLabel">Hunger Sales Data</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="messageContainer" class="px-3"></div>
				<form id="delivery_bulk_form" method="post" enctype="multipart/form-data" autocomplete="off">
					<div class="row px-3">
						<div class="col-md-12 col-sm-12 mb-3 form-group">
							<label for="summary_month">Summary Month<span class="text-danger">*</span></label>
							<div class="position-relative" id="datepicker4">
								<input type="text" class="form-control" data-date-container='#datepicker4' data-provide="datepicker" name="summary_month" id="summary_month" data-date-format="MM yyyy" data-date-autoclose="true" placeholder="Select Month" data-date-min-view-mode="1" required>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 mb-3 form-group">
							<label for="attachment">Sales Data File <span class="text-secondary">(Supported file format is: .xls .xlsx)</span></label>
							<input type="file" name="file" id="attachment" class="dropify" accept=".xls,.xlsx,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" data-max-file-size="2M" data-height="100" required>
						</div>
						<div class="col-md-12">
							<p class="text-secondary">Upload the same file format in (.xls) provided from Baqala Station to avoid any errors while importing your data.</p>
							<p style="text-align: center;"><a type="button" href="<?php echo base_url('admin_assets/samples/Hunger-Sales-Data.xlsx'); ?>" class="btn bt btn-link text-success" target="_blank" download>Download sample file</a></p>
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

<!-- Modal -->
<div class="modal fade" id="exportModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title px-3" id="exportModalLabel">Export Sales Entries</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="alert alert-info custom-export-alert" role="alert">Current filters will be applied to the exported data set.</div>
				<form id="exportForm" action="<?php echo base_url('admin/logistic-management/invoices/hunger-sales/print-monthly-sales'); ?>" method="POST">
					<input type="hidden" id="request_id" name="request_id" value="" required>
					<h6 class="mb-3">Columns to Export</h6>
					<div class="row">
						<div class="col-md-12">
							<div class="form-check mb-3">
								<input class="form-check-input" type="radio" name="column_type" id="visible_columns" value="visible_columns" checked="">
								<label class="form-check-label" for="visible_columns">
									Visible Columns
								</label>
								<p class="text-muted">Export only the columns that are visible on the page. This will keep the current column order.</p>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-check mb-3">
								<input class="form-check-input" type="radio" name="column_type" id="all_columns" value="all_columns">
								<label class="form-check-label" for="all_columns">
									All Columns
								</label>
								<p class="text-muted">Export all available columns. This will NOT keep the current column order, and some additional columns may be included.</p>
							</div>
						</div>
					</div>

					<h6 class="mb-3">File format</h6>
					<div class="row">
						<?php if (check_action_permission(get_user_role(), 'sales_data', 'print_sales_data')): ?>
							<div class="col-md-12">
								<div class="form-check mb-3">
									<input class="form-check-input" type="radio" name="file_format" id="file_format_pdf" value="file_format_pdf" checked="">
									<label class="form-check-label" for="file_format_pdf">
										PDF
									</label>
									<p class="text-muted">.pdf, Portable Document Format.</p>
								</div>
							</div>
						<?php endif;
						if (check_action_permission(get_user_role(), 'sales_data', 'export_sales_data')): ?>
							<div class="col-md-12">
								<div class="form-check mb-3">
									<input class="form-check-input" type="radio" name="file_format" id="file_format_xlsx" value="file_format_xlsx" checked>
									<label class="form-check-label" for="file_format_xlsx">
										XLSX
									</label>
									<p class="text-muted">.xlsx, Microsoft Excel, OpenOffice, Google Sheets.</p>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-custom-white" data-bs-dismiss="modal">Close</button>
				<button type="submit" form="exportForm" class="btn btn-custom">Export</button>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('admin/home/footer'); ?>
<script>
	function deleteAction() {
		var inputCount = $('[name="checklist[]"]:checked').length;
		if (inputCount > 0) {
			if (confirm("Do you want to delete selected items?") == true) {
				changeActionAndSubmit('admin/logistic-management/invoices/hunger-sales/delete');
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
				url: "<?php echo base_url('admin/logistic-management/invoices/hunger-sales/import-file') ?>",
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

	$(document).ready(function() {
		var today = new Date();
		$('#datepicker6').datepicker({
			endDate: today
		});
	});

	$(document).ready(function() {
		// Capture the click event on the download button
		$('.export-btn').on('click', function() {
			let requestId = $(this).data('requestid');
			$('#request_id').val(requestId);
		});

		$('#exportForm').on('submit', function(e) {
			e.preventDefault();

			let formData = $(this).serialize();
			let fileFormat = $('input[name="file_format"]:checked').val();
			let exportUrl = (fileFormat === 'file_format_xlsx') ?
				'admin/logistic-management/invoices/hunger-sales/export-monthly-sales' :
				'admin/logistic-management/invoices/hunger-sales/print-monthly-sales';

			// Creating a hidden form to handle file download
			let downloadForm = $('<form>', {
				method: 'POST',
				action: exportUrl,
				target: '_blank'
			}).appendTo('body');

			// Add form data as hidden inputs
			$.each(formData.split('&'), function(index, pair) {
				let [name, value] = pair.split('=');
				$('<input>').attr({
					type: 'hidden',
					name: decodeURIComponent(name),
					value: decodeURIComponent(value)
				}).appendTo(downloadForm);
			});

			downloadForm.submit().remove(); // Submit form and remove it afterward
		});
	});
</script>