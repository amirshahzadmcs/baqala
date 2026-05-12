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
					<h4>Daily Fuel Consumptions</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/logistic-management/fuel/list'); ?>">Daily Fuel Consumptions</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<button type="button" class="btn btn-custom-white btn-sm pull-right ms-2" title="Import Fuel Consumption" data-bs-toggle="modal" data-bs-target=".bulkImportModal"><i class="fas fa-gas-pump me-1"></i> Import Fuel Consumption</button>
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
									<th class="text-center">Total Vehicles</th>
									<th class="text-center">Total Cost</th>
									<th class="text-center">Total Records</th>
									<th class="text-center">Tools</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if (count($fuel_summary) > 0) {
									foreach ($fuel_summary as $summary) {
								?>
										<tr>
											<td>
												<?= ((isset($summary['fuel_month'])) ? date('F Y', strtotime($summary['fuel_month'])) : ''); ?><br>
												<small><?= ((isset($summary['start_date'])) ? date('M d', strtotime($summary['start_date'])) : ''); ?></small>
												->
												<small><?= ((isset($summary['end_date'])) ? date('M d', strtotime($summary['end_date'])) : ''); ?></small>
											</td>
											<td align="center"><?= $summary['total_vehicles']; ?></td>
											<td align="center"><?= $summary['total_cost']; ?></td>
											<td align="center"><?= $summary['total_records']; ?></td>
											<td align="center">
												<div class="btn-group ms-2">
													<button class="btn btn-light-grey btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														<i class="dripicons-dots-3"></i>
													</button>
													<div class="dropdown-menu dropdown-menu-end">
														<?php
															echo '<a class="dropdown-item" href="'. base_url('admin/logistic-management/fuel/detail/' . $summary['fuel_month']) . '">
																<i class="mdi mdi-stretch-to-page-outline me-2"></i> Detail
															</a>';
															echo '<div class="dropdown-divider"></div>
															<a class="dropdown-item" href="' . base_url('admin/logistic-management/fuel/view-monthly-fuel-summary/' . $summary['fuel_month']) . '" target="_blank">
																<i class="mdi mdi-stretch-to-page-outline me-2"></i> View Monthly Summary
															</a>';
															echo '<div class="dropdown-divider"></div>
															<a href="javascript:void(0);" class="dropdown-item delete-fuel" data-month="' . $summary['fuel_month'] . '">
																<i class="mdi mdi-delete me-2"></i> Delete
															</a>';
															echo '<div class="dropdown-divider"></div>
															<a class="dropdown-item" href="' . base_url('admin/logistic-management/fuel/print-monthly-fuel-summary/' . $summary['fuel_month']) . '" target="_blank">
																<i class="mdi mdi-download me-2"></i> Export PDF
															</a>';
															echo '<div class="dropdown-divider"></div>
															<a class="dropdown-item" href="' . base_url('admin/logistic-management/fuel/export-monthly-fuel-summary-excel/' . $summary['fuel_month']) . '" target="_blank">
																<i class="mdi mdi-download me-2"></i> Export Excel
															</a>';
														?>
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
				<h5 class="modal-title px-3" id="bulkImportModalLabel">Fuel Consumption File (Excel, .xlsx)</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="messageContainer" class="px-3"></div>
				<form id="delivery_bulk_form" method="post" enctype="multipart/form-data" autocomplete="off">
					<div class="row px-3">
						<div class="col-md-12 col-sm-12 mb-3 form-group">
							<label for="fuel_date">Date of Fuel<span class="text-danger">*</span></label>
							<input type="date" name="fuel_date" id="fuel_date" class="form-control" required>
						</div>
						<div class="col-md-12 col-sm-12 mb-3 form-group">
							<label for="attachment">Fuel Consumption File <span class="text-secondary">(Supported file format is: .xls .xlsx)</span></label>
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
		$(".delete-fuel").click(function() {
			var fuelMonth = $(this).data("month");
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
					window.location.href = "<?= base_url('admin/logistic-management/fuel/delete/') ?>" + fuelMonth;
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
		$("body").on("submit", "#delivery_bulk_form", function(e) {
			e.preventDefault();
			var data = new FormData(this);
			$.ajax({
				type: 'POST',
				url: "<?php echo base_url('admin/logistic-management/fuel/import') ?>",
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
							tableHtml += '<h6>Duplicate Rows</h6><table class="table border-danger"><tr><th>S.No.</th><th>Vehicle No.</th><th>Fuel</th></tr>';
							$.each(jsonResponse.duplicate_rows, function(index, row) {
								tableHtml += '<tr>';
								tableHtml += '<td>' + row[0] + '</td>';
								tableHtml += '<td>' + row[1] + '</td>';
								tableHtml += '<td>' + row[2] + '</td>';
								tableHtml += '</tr>';
							});
							tableHtml += '</table>';
						}
						$('#messageContainer').html(tableHtml);
					} else if (jsonResponse.success_message) {
						$('#messageContainer').html('<p style="color: green;">Success: ' + jsonResponse.success_message + '</p>');
						setTimeout(function() {
							window.location.href = "<?php echo base_url('admin/logistic-management/fuel/list'); ?>";
						}, 1000);
					} else if (jsonResponse.duplicate_rows) {
						tableHtml += '<h6>Duplicate Rows</h6><table class="table border-danger"><tr><th>S.No.</th><th>Vehicle No.</th><th>Fuel</th></tr>';
						$.each(jsonResponse.duplicate_rows, function(index, row) {
							tableHtml += '<tr>';
							tableHtml += '<td>' + row[0] + '</td>';
							tableHtml += '<td>' + row[1] + '</td>';
							tableHtml += '<td>' + row[2] + '</td>';
							tableHtml += '</tr>';
						});
						tableHtml += '</table>';
						$('#messageContainer').html(tableHtml);
					}
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