<?php $this->load->view('admin/home/header'); ?>
<style>
	.dataTables_wrapper::-webkit-scrollbar {
		display: none;
	}

	.nav-md .container.body .right_col {
		padding: 10px 10px 0;
		margin-left: 230px;
	}

	th,
	td {
		white-space: nowrap;
	}

	#summaryTable {
		width: 100%;
		border-collapse: collapse;
		font-size: 14px;
		text-align: left;
	}

	.table-responsive {
		overflow-x: scroll;
		max-height: 70vh;
		min-height: 500px;
	}

	#summaryTable thead {
		position: sticky;
		z-index: 2;
		top: 0px;
		background: #fff;
		box-shadow: 2px 1px 4px -1px #a5a3a3;
	}

	.payslipDropdown {
		margin-top: -15px;
	}

	/* Table Container for Consistent Scrolling */
	.table-responsive {
		width: 100%;
		overflow-x: auto;
		scrollbar-width: thin;
		/* Firefox */
		scrollbar-color: rgb(160, 160, 160) #f1f1f1;
		/* Firefox custom scrollbar */
	}

	/* Scrollbar Customization for WebKit (Chrome, Safari) */
	.table-responsive::-webkit-scrollbar {
		height: 8px;
	}

	.table-responsive::-webkit-scrollbar-track {
		background: #f1f1f1;
		border-radius: 10px;
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

	#searchInput {
		padding-right: 30px;
		/* Space for the clear icon */
	}

	#clearSearch:hover {
		color: #333;
		/* Highlight effect */
	}

	#responseContainer {
		position: fixed;
		width: 93%;
		top: 60px;
	}

	.visible-column {
		padding: 5px;
	}

	.visible-column:hover {
		box-shadow: 2px 2px 5px #ddd;
		padding: 5px;
		border-radius: 5px;
	}

	.visible-columns .remove-column i {
		border-radius: 5px;
	}

	.visible-columns .remove-column i:hover {
		background: #efefef;
		color: #333 !important;
		border-radius: 5px;
		cursor: pointer;
	}

	.visible-columns .cursor-move {
		cursor: move;
	}

	.visible-columns .ui-state-highlight {
		background-color: #e9ecef;
		height: 40px;
		border: 2px dashed #6c757d;
	}

	.alert.alert-info.custom-export-alert {
		border-top: 4px solid #0091e6;
		border-radius: 5px;
	}
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Keeta Sales Invoice</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/logistic-management/invoices/keeta-sales-invoice/list'); ?>">Keeta Sales Invoice</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if (check_action_permission(get_user_role(), 'keeta_sales_invoice', 'export_sales_data')): ?>
						<div class="btn-group ms-2 float-end">
							<button class="btn btn-custom-white btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="ti-export"></i> Export <i class="mdi mdi-chevron-down"></i>
							</button>
							<div class="dropdown-menu dropdown-menu-end">
								<h6 class="dropdown-header">EXPORT AS</h6>
								<a type="button" class="dropdown-item" title="Performance Report" data-bs-toggle="modal" data-bs-target="#exportModal">Performance Report</a>
								<!-- <div class="dropdown-divider"></div> -->
							</div>
						</div>
					<?php endif;
					if (check_action_permission(get_user_role(), 'keeta_sales_invoice', 'import_file')): ?>

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
						<div class="row">
							<div class="col-md-12">
								<div class="d-flex align-items-center justify-content-between position-relative float-start" style="max-width: 480px;">
									<div class="relative">
										<div class="search-box chat-search-box">
											<div class="position-relative">
												<input type="text" id="searchInput" class="form-control" placeholder="Search..." value="<?= htmlspecialchars($search) ?>">
												<i class="mdi mdi-magnify search-icon"></i>
												<span id="clearSearch"
													style="
														position: absolute; 
														right: 10px; 
														top: 50%; 
														transform: translateY(-50%); 
														cursor: pointer; 
														display: none; 
														font-weight: bold;
														color: #999;
													">
													✖
												</span>
											</div>
										</div>
									</div>
								</div>
								<div class="float-end d-flex ms-4">
									<div class="me-2" style="line-height: 39px;">
										<span id="paginationInfo">Showing entries</span>
									</div>
									<div id="paginationLinks"></div>

									<div class="btn-group ms-2">
										<button class="btn btn-sm dropdown-toggle border" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="max-height: 40px;">
											<i class="mdi mdi-cog-outline font-size-18"></i>
										</button>
										<div class="dropdown-menu dropdown-menu-end" data-bs-auto-close="outside">
											<a class="dropdown-item" href="javascript:;" onclick="getColumnForm()">
												Manage Columns <i class="mdi mdi-table-edit ms-2"></i>
											</a>
											<div class="dropdown-divider"></div>
											<p class="dropdown-header">Items Per Page</p>
											<select id="perPageSelect" class="form-select mx-4" aria-label="Items per page" style="max-width:145px;">
												<option value="50" <?= $perPage == 50 ? 'selected' : '' ?>>50</option>
												<option value="100" <?= $perPage == 100 ? 'selected' : '' ?>>100</option>
												<option value="200" <?= $perPage == 200 ? 'selected' : '' ?>>200</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12 pb-1"></div>
						</div>
						<div class="table-rep-plugin">
							<div class="table-responsive mb-0" data-pattern="priority-columns">
								<table id="summaryTable" class="table table-striped" style="width:100%">
									<thead class="text-center">
										<tr>
											<th>#</th>
											<!-- <th>S.No.</th> -->
											<?php
											if (!empty($visibleTableColumns)) {
												foreach ($visibleTableColumns as $column) {
													$styleSet = ($column == 'invoice_month') ? "align='center'" : " align='center'";
											?>
													<th <?= $styleSet; ?>><?= strtoupper(str_replace('_', ' ', $column)); ?></th>
											<?php
												}
											}
											?>
										</tr>
									</thead>
									<tbody class="text-center">

									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<!-- Modal -->
<div class="modal fade manageColumnModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="manageColumnModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">

		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade bulkImportModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="bulkImportModalLabel">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title px-3" id="bulkImportModalLabel">Keeta Sales Invoice</h5>
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
							<label for="attachment">Sales Invoice File <span class="text-secondary">(Supported file format is: .xls .xlsx)</span></label>
							<input type="file" name="file" id="attachment" class="dropify" accept=".xls,.xlsx,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" data-max-file-size="2M" data-height="100" required>
						</div>
						<div class="col-md-12">
							<p class="text-secondary">Upload the same file format in (.xls) provided from Baqala Station to avoid any errors while importing your data.</p>
							<p style="text-align: center;"><a type="button" href="<?php echo base_url('admin_assets/samples/Keeta-Sales-Invoice.xlsx'); ?>" class="btn bt btn-link text-success" target="_blank" download>Download sample file</a></p>
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
				<form id="exportForm" action="<?php echo base_url('admin/logistic-management/invoices/keeta-sales/print-monthly-sales'); ?>" method="POST">
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
						<div class="col-md-12">
							<div class="form-check mb-3">
								<input class="form-check-input" type="radio" name="file_format" id="file_format_pdf" value="file_format_pdf" checked="">
								<label class="form-check-label" for="file_format_pdf">
									PDF
								</label>
								<p class="text-muted">.pdf, Portable Document Format.</p>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-check mb-3">
								<input class="form-check-input" type="radio" name="file_format" id="file_format_xlsx" value="file_format_xlsx">
								<label class="form-check-label" for="file_format_xlsx">
									XLSX
								</label>
								<p class="text-muted">.xlsx, Microsoft Excel, OpenOffice, Google Sheets.</p>
							</div>
						</div>
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
<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
<script>
	$(document).ready(function() {
		$('#perPageSelect').on('click change', function(event) {
			event.stopPropagation(); // Prevent dropdown from closing
		});
	});

	$(document).ready(function() {
		let currentPage = 0; // Track current page
		let table;

		function initializeDataTable() {
			// Destroy existing DataTable before reinitializing
			if ($.fn.DataTable.isDataTable('#summaryTable')) {
				$('#summaryTable').DataTable().destroy();
			}

			table = $('#summaryTable').DataTable({
				"serverSide": true,
				"processing": true,
				"ajax": {
					url: "<?php echo base_url(); ?>admin/logistic-management/invoices/keeta-sales-invoice/ajax-list",
					type: "POST",
					data: function(d) {
						d.search = $('#searchInput').val(); // Search input
						d.length = $('#perPageSelect').val(); // Custom per-page selection
						d.start = currentPage * d.length; // Handle pagination manually
					},
					dataSrc: function(json) {
						updatePagination(json.recordsTotal, json.data.length);
						return json.data;
					}
				},
				"paging": false,
				"searching": false,
				"lengthChange": false,
				"ordering": false,
				"info": false,
				"responsive": false,
				"fixedHeader": true,
			});
		}

		// ✅ Function to Update Bootstrap Pagination
		function updatePagination(totalRecords, currentRecords) {
			let totalPages = Math.ceil(totalRecords / $('#perPageSelect').val());
			let paginationHTML = `<ul class="pagination justify-content-center mb-0">`;

			// Previous Button
			paginationHTML += `<li class="page-item ${currentPage === 0 ? 'disabled' : ''}">
            <a class="page-link pagination-link" href="#" data-page="${currentPage - 1}">«</a>
        </li>`;

			// Page Numbers
			for (let i = 0; i < totalPages; i++) {
				paginationHTML += `<li class="page-item ${i === currentPage ? 'active' : ''}">
                <a class="page-link pagination-link" href="#" data-page="${i}">${i + 1}</a>
            </li>`;
			}

			// Next Button
			paginationHTML += `<li class="page-item ${currentPage === totalPages - 1 ? 'disabled' : ''}">
            <a class="page-link pagination-link" href="#" data-page="${currentPage + 1}">»</a>
        </li>`;

			paginationHTML += `</ul>`;

			$('#paginationLinks').html(paginationHTML);
			$('#paginationInfo').text(`Showing ${currentRecords} of ${totalRecords} entries`);
		}

		// ✅ Event: Search Input
		$('#searchInput').on('input', function() {
			currentPage = 0; // Reset to first page on search
			const searchValue = $(this).val().trim();
			$('#clearSearch').toggle(searchValue.length > 0);
			table.ajax.reload();
		});

		// ✅ Event: Per Page Selection
		$('#perPageSelect').on('change', function() {
			currentPage = 0; // Reset to first page
			table.ajax.reload();
		});

		// ✅ Event: Pagination Button Click
		$(document).on('click', '.pagination-link', function(e) {
			e.preventDefault();
			let page = $(this).data('page');
			if (page >= 0) {
				currentPage = page;
				table.ajax.reload();
			}
		});

		initializeDataTable();

		// Clear the search input and reload data
		$('#clearSearch').on('click', function() {
			$('#searchInput').val('');
			$(this).hide();
			table.ajax.reload();
		});
	});

	$('.dropify').dropify();

	$(document).ready(function() {
		$("body").on("submit", "#delivery_bulk_form", function(e) {
			e.preventDefault();
			var data = new FormData(this);
			$.ajax({
				type: 'POST',
				url: "<?php echo base_url('admin/logistic-management/invoices/keeta-sales-invoice/import-file') ?>",
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

	function getColumnForm() {
		$.ajax({
			url: "<?php echo base_url('admin/manage-column/get-column-form'); ?>",
			method: 'GET',
			data: {
				request_type: 'keeta_sales_invoice'
			},
			success: function(response) {
				//console.log('Response:', response);
				try {
					if (typeof response === "string") {
						response = JSON.parse(response);
					}
					if (response.type === 'success') {
						$('.manageColumnModal .modal-content').html(response.data);
						$('.manageColumnModal').modal('show');

						// Automatically populate visible columns
						const visibleColumnOrder = JSON.parse('<?php echo json_encode($visibleTableColumns); ?>');

						// Collect visible columns
						const visibleColumns = [];
						$('.available-column:checked').each(function() {
							const columnName = $(this).data('column');
							const columnText = $(this).closest('label').text().trim();
							visibleColumns.push({
								columnName,
								columnText
							});
						});
						// Sort visible columns based on the defined order
						const sortedVisibleColumns = visibleColumnOrder
							.filter(column => visibleColumns.some(vc => vc.columnName === column))
							.map(column => visibleColumns.find(vc => vc.columnName === column));

						// Append sorted columns

						console.log(visibleColumnOrder);
						$('.visible-columns').empty();
						sortedVisibleColumns.forEach(column => {
							const newColumn = `
							<div class="d-flex align-items-center mb-1 visible-column" data-column="${column.columnName}">
								<div class="visible-column-icon cursor-move">
									<i class="fas fa-grip-vertical text-muted me-2"></i>
								</div>
								<div class="visible-column-text">${column.columnText}</div>
								<div class="ms-auto remove-column" data-column="${column.columnName}">
									<i class="mdi mdi-close-circle text-muted p-1"></i>
								</div>
							</div>
						`;
							$('.visible-columns').append(newColumn);
						});

						updateVisibleColumnCount();
					} else {
						toastr.error(response.message || 'Unable to fetch details.');
					}
				} catch (error) {
					console.error('Error parsing response:', error);
					toastr.error('Invalid server response.');
				}
			},
			error: function(xhr, status, error) {
				console.error('AJAX Error:', error);
				toastr.error('Failed to load correction form.');
			}
		});
	}

	function updateVisibleColumnCount() {
		const count = $('.visible-columns .visible-column').length;
		$('.badge.bg-primary').text(count);
	}

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
				'admin/logistic-management/invoices/keeta-sales-invoice/export-monthly-sales' :
				'admin/logistic-management/invoices/keeta-sales-invoice/print-monthly-sales';
			let searchValue = $('#searchInput').val(); // 🔍 Get the value of search input
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

			// ✅ Add search value as an additional input
			$('<input>').attr({
				type: 'hidden',
				name: 'searched_value',
				value: searchValue
			}).appendTo(downloadForm);

			downloadForm.submit().remove(); // Submit form and remove it afterward
		});
	});
</script>