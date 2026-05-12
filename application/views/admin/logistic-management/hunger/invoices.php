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
		margin-bottom: 20px;
	}
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Hunger Invoice</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/logistic-management/hunger/invoice-list'); ?>">Hunger Invoice</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if(check_action_permission(get_user_role(), 'hunger_invoice', 'delete')):?>
					<button type="button" class="btn btn-custom-danger btn-sm pull-right" onclick="deleteAction()" title="Delete"><i class="fa fa-trash me-1"></i> Delete</button>
					<?php endif; if(check_action_permission(get_user_role(), 'hunger_invoice', 'import_file')):?>
					<a class="btn btn-custom-white btn-sm pull-right ms-2" title="Import New Compliance" href="javascript:;" data-bs-toggle="modal" data-bs-target=".bulkImportModal"><i class="ti-import"></i> Import New Invoice</a>
					<?php endif; if(check_action_permission(get_user_role(), 'hunger_invoice', 'print_invoice') || check_action_permission(get_user_role(), 'hunger_invoice', 'avgRiderAcceptance')):?>
					<div class="btn-group ms-2 float-end">
						<button class="btn btn-custom-white btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-file-pdf"></i> Print Reports <i class="mdi mdi-chevron-down"></i>
						</button>
						<div class="dropdown-menu dropdown-menu-end">
							<?php if(check_action_permission(get_user_role(), 'hunger_invoice', 'print_invoice')):?>
							<a type="button" class="dropdown-item" title="Print Hunger Invoice" data-bs-toggle="modal" data-bs-target="#monthlyInvoiceReportViewModal">Print Invoice</a>
							<?php endif; if(check_action_permission(get_user_role(), 'hunger_invoice', 'avgRiderAcceptance')):?>
							<div class="dropdown-divider"></div>
							<a type="button" class="dropdown-item" title="Average Rider Acceptance Report" data-bs-toggle="modal" data-bs-target=".avgReportModal">Average Report</a>
							<?php endif;?>
						</div>
					</div>
					<?php endif;?>
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
						<form action="<?php echo base_url('admin/logistic-management/hunger/invoice-list'); ?>" method="get" id="filter_form">
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
									<div class="input-daterange input-group" data-date-format="MM yyyy" data-date-autoclose="true" data-provide="datepicker">
										<input type="text" class="form-control" name="start_date" placeholder="Start Month" value="<?php echo $this->input->get('start_date'); ?>" data-date-format="MM yyyy" autocomplete="off">
										<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
										<input type="text" class="form-control" name="end_date" placeholder="End Month" value="<?php echo $this->input->get('end_date'); ?>" data-date-format="MM yyyy" autocomplete="off">
										<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
									</div>
								</div>
							</div>

							<div class="row mt-2">
								<div class="col-lg-6 col-md-6 col-sm-12">

								</div>
								<div class="col-lg-6 col-md-6 col-sm-12">
									<button type="submit" class="btn btn-success btn-md float-end ms-2">Apply Filter</button>
									<a href="<?php echo base_url('admin/logistic-management/hunger/invoice-list'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
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
							<table id="invoiceTable" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
								<thead>
									<tr>
										<th>#</th>
										<th>S.No.</th>
										<th>Invoice Month</th>
										<th>Rider ID</th>
										<th>Emp. No.</th>
										<th>Rider Name</th>
										<th>Orders</th>
										<th>Total Amount (Exc. VAT)</th>
										<th>Stacking Deduction(excl vat)</th>
										<th>Total Amount (Exc. VAT)</th>
										<th>VAT</th>
										<th>Amount (Inc.VAT)</th>
										<th>Courier Basic Payment</th>
										<th>Courier Scoring Payment</th>
										<th>Rider Balance</th>
										<th>New Total Deduction</th>
										<th>New Net Amount To Pay</th>
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
				<h5 class="modal-title px-3" id="bulkImportModalLabel">Import Hunger Invoice</b></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="messageContainer" class="px-3"></div>
				<form id="delivery_bulk_form" method="post" enctype="multipart/form-data" autocomplete="off">
					<div class="row px-3">
						<div class="col-md-12 col-sm-12 mb-3 form-group">
							<label for="invoice_month">Invoice Month<span class="text-danger">*</span></label>
							<div class="position-relative" id="datepicker4">
								<input type="text" class="form-control" data-date-container='#datepicker4' data-provide="datepicker" name="invoice_month" id="invoice_month" data-date-format="MM yyyy" data-date-autoclose="true" placeholder="Invoice Month" data-date-min-view-mode="1" required>
							</div>
						</div>

						<div class="col-md-12 col-sm-12 mb-3 form-group">
							<label for="attachment">Hunger Invoice <span class="text-secondary">(Supported file format is: .xls .xlsx)</span></label>
							<input type="file" name="file" id="attachment" class="dropify" accept=".xls,.xlsx,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" data-max-file-size="2M" data-height="100" required>
						</div>
						<div class="col-md-12">
							<p class="text-secondary">Upload the same file format in (.xls) provided from Baqala Station to avoid any errors while importing your data.</p>
							<p style="text-align: center;"><a type="button" href="<?php echo base_url('admin_assets/samples/Hunger_Invoice_File.xlsx'); ?>" class="btn bt btn-link text-success" target="_blank" download>Download sample file</a></p>
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

<!--  Monthly Invoice Report Modal-->
<div class="modal fade " id="monthlyInvoiceReportViewModal" data-bs-backdrop="static" role="dialog" aria-labelledby="monthlyInvoiceReportViewModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<div>
					<h5 class="modal-title mt-0">Print Hunger Invoice</h5>
				</div>
				<div>
					<button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
					<form id="invoiceReportForm" action="<?php echo base_url('admin/logistic-management/hunger/invoice-print'); ?>" target="_blank" method="post" class="" data-parsley-validate>
						<div class="mb-4 form-group">
							<label class="form-label">Select Month:</label><br>
							<div class="position-relative" id="datepicker8">
								<input type="text" class="form-control" name="month" data-date-container="#datepicker8" data-provide="datepicker" data-date-format="MM yyyy" data-date-min-view-mode="1" data-date-end-date="-1m" data-date-autoclose="1" autocomplete="off" required>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-success" form="invoiceReportForm">Submit</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade staticBackdrop fixed-left avgReportModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="#avgReportLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0" id="avgReportLabel">Average Rider Acceptance Report</h5>
				<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url('admin/logistic-management/hunger/print-acceptance-report'); ?>" target="_blank" method="POST" id="avgReportForm">
					<div class="row">

						<div class="form-group col-lg-12 col-md-12 col-12 mb-3">
							<label for="date_range">Select Month: </label>
							<div class="position-relative" id="datepicker9">
								<input type="text" class="form-control" name="month" data-date-container="#datepicker9" data-provide="datepicker" data-date-format="MM yyyy" data-date-min-view-mode="1" data-date-end-date="-1m" autocomplete="off" data-date-autoclose="1" required>
							</div>
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-2">
								<label>Team</label>
								<select name="team" class="form-select">
									<option value="">[ All Team]</option>
									<?php foreach($teams as $mteam) { ?>
										<option value="<?php echo $mteam->name; ?>" <?php echo ($mteam->name == $this->input->get('team')) ? ' selected ' : '';?>><?php echo $mteam->name; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-success" form="avgReportForm">Print Acceptance Report</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php $this->load->view('admin/home/footer'); ?>
<script>
	function initializeDataTable() {
		if ($.fn.DataTable.isDataTable('#invoiceTable')) {
			$('#invoiceTable').DataTable().destroy();
		}

		$('#invoiceTable').dataTable({
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
				url: "<?php echo base_url(); ?>admin/logistic-management/hunger/invoice-ajax-list?keyword=<?php echo $this->input->get('keyword') ?>&rider_id=<?php echo $this->input->get('rider_id') ?>&start_date=<?php echo $this->input->get('start_date') ?>&end_date=<?php echo $this->input->get('end_date') ?>",
				type: "POST"
			},
			"columnDefs": [{
				"targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15],
				"orderable": false,
			}, ],
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
				changeActionAndSubmit('admin/logistic-management/hunger/invoice-delete');
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
				url: "<?php echo base_url('admin/logistic-management/hunger/invoice-import') ?>",
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
							tableHtml += '<h6>Duplicate Rows</h6><table class="table border-danger"><tr><th>Rider ID</th></tr>';
							$.each(jsonResponse.duplicate_rows, function(index, row) {
								tableHtml += '<tr>';
								tableHtml += '<td>' + row[0] + '</td>';
								//tableHtml += '<td>' + row[1] + '</td>';
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
						tableHtml += '<h6>Duplicate Rows</h6><table class="table border-danger"><tr><th>Rider ID</th></tr>';
						$.each(jsonResponse.duplicate_rows, function(index, row) {
							tableHtml += '<tr>';
							tableHtml += '<td>' + row[0] + '</td>';
							//tableHtml += '<td>' + row[1] + '</td>';
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
</script>
