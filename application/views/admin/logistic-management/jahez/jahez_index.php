<?php $this->load->view('admin/home/header'); ?>
<style>
	.dataTables_wrapper::-webkit-scrollbar {
		display: none;
	}

	.nav-md .container.body .right_col {
		padding: 10px 10px 0;
		margin-left: 230px;
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
					<h4>Jahez Daily Order</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/logistic-management/jahez/index'); ?>">Jahez Orders</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if (check_action_permission(get_user_role(), 'daily_performance', 'delete')): ?>
						<button type="button" class="btn btn-custom-danger btn-sm pull-right mr-2" onclick="deleteAction()" title="Delete"><i class="fa fa-trash me-1"></i> Delete</button>
					<?php endif;
					if (check_action_permission(get_user_role(), 'daily_performance', 'import_file')): ?>
						<a class="btn btn-custom-white btn-sm pull-right ms-2" title="Import New Orders" href="javascript:;" data-bs-toggle="modal" data-bs-target=".bulkImportModal"><i class="ti-import"></i> Import New Orders</a>
					<?php endif;
					if (check_action_permission(get_user_role(), 'daily_performance', 'print_report') || check_action_permission(get_user_role(), 'daily_performance', 'print_detail_report')): ?>
						<div class="btn-group ms-2 float-end">
							<button class="btn btn-custom-white btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fas fa-file-pdf"></i> Print Reports <i class="mdi mdi-chevron-down"></i>
							</button>
							<div class="dropdown-menu dropdown-menu-end">
								<?php if (check_action_permission(get_user_role(), 'daily_performance', 'print_report')): ?>
									<a class="dropdown-item" title="Daily Summary Report" href="<?php echo base_url('admin/logistic-management/jahez/print-report?keyword=' . $this->input->get('keyword') . '&driver_id=' . $this->input->get('driver_id') . '&start_date=' . $this->input->get('start_date') . '&end_date=' . $this->input->get('end_date') . '&ref_id=' . $this->input->get('ref_id') . '&driver_username=' . $this->input->get('driver_username')); ?>" class="btn btn-custom-white btn-sm float-end me-2" target="_blank">Daily Performance Report</a>
								<?php endif; ?>
									<div class="dropdown-divider"></div>
									<a type="button" class="dropdown-item" title="Day Wise Performance Report" data-name="daywise" onclick="loadModalContent(this.getAttribute('data-name'))">Day Wise Report</a>
									<div class="dropdown-divider"></div>
									<a type="button" class="dropdown-item" title="Weekly Report" data-name="weekly" onclick="loadModalContent(this.getAttribute('data-name'))">Weekly Report</a>
									<div class="dropdown-divider"></div>
									<a type="button" class="dropdown-item" title="Monthly Performance Report" data-name="monthly" onclick="loadModalContent(this.getAttribute('data-name'))">Monthly Performance Report</a>
								<?php if (check_action_permission(get_user_role(), 'daily_performance', 'print_detail_report')): ?>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" title="Detail Performance Report" href="<?php echo base_url('admin/logistic-management/jahez/print-detail-report?keyword=' . $this->input->get('keyword') . '&driver_id=' . $this->input->get('driver_id') . '&start_date=' . $this->input->get('start_date') . '&end_date=' . $this->input->get('end_date') . '&ref_id=' . $this->input->get('ref_id') . '&driver_username=' . $this->input->get('driver_username')); ?>" class="btn btn-custom-white btn-sm float-end me-2" target="_blank">Detail Performance Report</a>
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
						<form action="<?php echo base_url('admin/logistic-management/jahez/index'); ?>" method="get" id="filter_form">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Search by Employee No. / Name</label>
										<input type="search" id="keyword" name="keyword" placeholder="Search by Employee Name" value="<?php echo $this->input->get('keyword') ? $this->input->get('keyword') : ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>

								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>DID</label>
										<input type="search" id="did" name="did" placeholder="Search DID Number" value="<?php echo $this->input->get('did') ? $this->input->get('did') : ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Driver ID</label>
										<input type="search" id="driver_id" name="driver_id" placeholder="Search Driver ID" value="<?php echo $this->input->get('driver_id') ? $this->input->get('driver_id') : ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>
							</div>
							<?php
							$adv_show = false;
							if (!empty($this->input->get('ref_id'))) {
								$adv_show = true;
							}
							if (!empty($this->input->get('driver_username'))) {
								$adv_show = true;
							}
							if (!empty($this->input->get('driver_id'))) {
								$adv_show = true;
							}
							if (!empty($this->input->get('start_date'))) {
								$adv_show = true;
							}
							if (!empty($this->input->get('end_date'))) {
								$adv_show = true;
							}
							?>
							<div class="collapse <?php if ($adv_show) {
														echo ' show';
													} ?>" id="advanceFilter">
								<div class="row">
									<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
										<label for="date_range">Date Range:</label>
										<div class="input-daterange input-group" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#datepicker6">
											<input type="text" class="form-control" name="start_date" placeholder="Start Date" value="<?php echo $this->input->get('start_date'); ?>" autocomplete="off">
											<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
											<input type="text" class="form-control" name="end_date" placeholder="End Date" value="<?php echo $this->input->get('end_date'); ?>" autocomplete="off">
											<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label>Reference ID</label>
											<input type="search" id="ref_id" name="ref_id" placeholder="Search by Ref ID" value="<?php echo $this->input->get('ref_id') ? $this->input->get('ref_id') : ''; ?>" autocomplete="off" class="form-control">
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label>Driver Username</label>
											<input type="search" id="driver_username" name="driver_username" placeholder="Search Driver Username" value="<?php echo $this->input->get('driver_username') ? $this->input->get('driver_username') : ''; ?>" autocomplete="off" class="form-control">
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
									<a href="<?php echo base_url('admin/logistic-management/jahez/index'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
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
							<table id="empTable" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
								<thead>
									<tr>
										<th>#</th>
										<th>S.No.</th>
										<th>Date</th>
										<th>EMP No.</th>
										<th>Employee Name</th>
										<th>DID</th>
										<th>Ref. ID</th>
										<th>Driver Name</th>
										<th>Username</th>
										<th>Driver ID</th>
										<th>Amount</th>
										<th>Price</th>
										<th>Debit Amount</th>
										<th>Credit Amount</th>
										<th>Is Free Order</th>
										<th>Dispatch Time</th>
										<th>Subscriber</th>
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
				<h5 class="modal-title px-3" id="bulkImportModalLabel">Rider Daily Performance <b>(Jahez)</b></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="messageContainer" class="px-3"></div>
				<form id="delivery_bulk_form" method="post" enctype="multipart/form-data" autocomplete="off">
					<div class="row px-3">
						<div class="col-md-12 col-sm-12 mb-3 form-group">
							<label for="order_date">Date Of <span class="text-danger">*</span></label>
							<input type="date" name="order_date" id="order_date" class="form-control" required>
						</div>
						<div class="col-md-12 col-sm-12 mb-3 form-group">
							<label for="attachment">Upload Daily Performance <span class="text-secondary">(Supported file format is: .xls .xlsx)</span></label>
							<input type="file" name="file" id="attachment" class="dropify" accept=".xls,.xlsx,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" data-max-file-size="2M" data-height="100" required>
						</div>
						<div class="col-md-12">
							<p class="text-secondary">Upload the same file format in (.xls) provided from Baqala Station to avoid any errors while importing your data.</p>
							<p style="text-align: center;"><a type="button" href="<?php echo base_url('admin_assets/samples/Jahez_Sample_File.xlsx'); ?>" class="btn bt btn-link text-success" target="_blank" download>Download sample file</a></p>
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
			
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php $this->load->view('admin/home/footer'); ?>
<script>
	$(document).ready(function() {
		$('.dropify').dropify();

		function initializeDataTable() {
			if ($.fn.DataTable.isDataTable('#empTable')) {
				$('#empTable').DataTable().destroy();
			}

			$('#empTable').dataTable({
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
				"ajax": {
					url: "<?php echo base_url(); ?>admin/logistic-management/jahez/ajax-list?keyword=<?php echo $this->input->get('keyword') ?>&did=<?php echo $this->input->get('did') ?>&ref_id=<?php echo $this->input->get('ref_id') ?>&driver_username=<?php echo $this->input->get('driver_username') ?>&driver_id=<?php echo $this->input->get('driver_id') ?>&start_date=<?php echo $this->input->get('start_date') ?>&end_date=<?php echo $this->input->get('end_date') ?>",
					type: "POST"
				},
				"columnDefs": [{
					"targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17],
					"orderable": false
				}, ],
			});
		}

		// Call the function to initialize DataTable
		$(document).ready(function() {
			initializeDataTable();
		});

		$("body").on("submit", "#delivery_bulk_form", function(e) {
			e.preventDefault();
			var data = new FormData(this);
			$.ajax({
				type: 'POST',
				url: "<?php echo base_url('admin/logistic-management/jahez/import') ?>",
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
							tableHtml += '<h6>Duplicate Rows</h6><table class="table border-danger"><tr><th>S.No.</th><th>DID</th><th>Ref. ID</th></tr>';
							$.each(jsonResponse.duplicate_rows, function(index, row) {
								tableHtml += '<tr>';
								tableHtml += '<td>' + row[0] + '</td>';
								tableHtml += '<td>' + row[1] + '</td>';
								tableHtml += '<td>' + row[2] + '</td>';
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
						tableHtml += '<h6>Duplicate Rows</h6><table class="table border-danger"><tr><th>S.No.</th><th>DID</th><th>Ref. ID</th></tr>';
						$.each(jsonResponse.duplicate_rows, function(index, row) {
							tableHtml += '<tr>';
							tableHtml += '<td>' + row[0] + '</td>';
							tableHtml += '<td>' + row[1] + '</td>';
							tableHtml += '<td>' + row[2] + '</td>';
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
		let inputDate = date_string;

		let dateObj = new Date(inputDate);

		let day = dateObj.getDate();
		let month = dateObj.getMonth() + 1; // Months are zero-based, so add 1
		let year = dateObj.getFullYear();

		let formattedDate = `${day}-${month}-${year}`;

		return formattedDate;
	}

	function deleteAction() {
		var inputCount = $('[name="checklist[]"]:checked').length;
		if (inputCount > 0) {
			if (confirm("Do you want to delete selected items?") == true) {
				changeActionAndSubmit('admin/employed-rider/jahez/delete');
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

	function loadModalContent(modalName) {
		const base_url = "<?= base_url(); ?>";
		const url = base_url + 'admin/logistic-management/jahez/print-modal/' + modalName;

		$('#filterModal .modal-content').html('<div class="p-4 text-center">Loading...</div>');
		$('#filterModal').modal('show');

		$.ajax({
			url: url,
			type: 'GET',
			success: function(response) {
				$('#filterModal .modal-content').html(response);

				// Re-initialize the datepicker after content is loaded
				$('.input-daterange').datepicker({
					format: 'dd-mm-yyyy',
					autoclose: true,
					todayHighlight: true
				});
			},
			error: function() {
				$('#filterModal .modal-content').html('<div class="p-4 text-danger">Failed to load content.</div>');
			}
		});
	}
	
</script>