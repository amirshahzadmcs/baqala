<?php $this->load->view('admin/home/header'); ?>

<style>
	.dataTables_wrapper::-webkit-scrollbar {
		display: none;
	}

	.nav-md .container.body .right_col {
		padding: 10px 10px 0;
		margin-left: 230px;
	}

	th, td {
		white-space: nowrap;
	}
	#summaryTable {
		width: 100%;
		border-collapse: collapse;
		font-size: 14px;
		text-align: left;
	}
	.table-responsive{
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
		scrollbar-width: thin; /* Firefox */
		scrollbar-color:rgb(160, 160, 160) #f1f1f1; /* Firefox custom scrollbar */
	}

	/* Scrollbar Customization for WebKit (Chrome, Safari) */
	.table-responsive::-webkit-scrollbar {
		height: 8px;
	}

	.table-responsive::-webkit-scrollbar-track {
		background: #f1f1f1;
		border-radius: 10px;
	}
	#searchInput {
		padding-right: 30px; /* Space for the clear icon */
	}

	#clearSearch:hover {
		color: #333; /* Highlight effect */
	}
	#columnManagementForm .card {
		border: 1px solid #dde0e5;
		min-height: 100%;
	}
	#columnManagementForm .card-header {
		background-color: #ffffff;
		border-bottom: 1px solid #dde0e5;
	}
	.form-check .form-check-input {
		margin-right: 8px;
		margin-top: 0px;
	}
	.visible-column {
		padding: 5px;
	}
	.visible-column:hover {
		box-shadow: 2px 2px 5px #ddd;
		padding: 5px;
		border-radius: 5px;
	}
	.visible-columns .remove-column i{
		border-radius: 5px;
	}
	.visible-columns .remove-column i:hover{
		background: #efefef;
		color:#333 !important;
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
					<h4>Hunger <?= ((isset($summaryData['summary_month'])) ? date('F Y', strtotime($summaryData['summary_month'])) : ''); ?> Sales Data</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/logistic-management/invoices/hunger-sales/list'); ?>">Hunger Sales Data</a></li>
						<li class="breadcrumb-item active">
							<?= ((isset($summaryData['from_date'])) ? date('d M', strtotime($summaryData['from_date'])) : ''); ?>
							to
							<?= ((isset($summaryData['to_date'])) ? date('d M', strtotime($summaryData['to_date'])) : ''); ?>
							<?= ((isset($summaryData['summary_month'])) ? date('Y', strtotime($summaryData['summary_month'])) : ''); ?>
						</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url('admin/logistic-management/invoices/hunger-sales/list'); ?>"><i class="fa fa-reply"></i> Back</a>
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
									<div class="me-2" style="line-height: 42px;">
										<span id="paginationInfo">Showing <?= count($summaryDetails) ?> entries</span>
									</div>
									<div id="paginationLinks">
										<?= $pagination_links ?>
									</div>
									
                                    <div class="btn-group ms-2">
                                        <button class="btn btn-sm dropdown-toggle border" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
								<table id="summaryTable" class="table table-striped">
									<thead>
										<tr>
											<th>#</th>
											<?php
												if (!empty($visibleTableColumns)) {
													foreach ($visibleTableColumns as $column) {
														$cleanedHeader = str_replace(['mhss.', 'me.'], '', $column);
														$styleSet = ($cleanedHeader == 'full_name') ? "align='left'" : " align='center'";
													?>
														<th <?= $styleSet; ?>><?= strtoupper(str_replace('_', ' ', $cleanedHeader)); ?></th>
													<?php
													}
												}
											?>
										</tr>
									</thead>
									<tbody id="summaryTableBody">
										<?php 
											if (!empty($summaryDetails)) {
												$serialNumber = 1;
												foreach ($summaryDetails as $detail) {
										?>
											<tr>
												<td><?php echo $serialNumber++; ?></td>
												<?php
													foreach ($visibleTableColumns as $column) {
														$cleanedColumn = strtolower(str_replace(['mhss.', 'me.'], '', $column));
										
														// Ensure array keys are accessed in lowercase
														$detailKeys = array_change_key_case($detail);
														$styleSet = ($cleanedColumn == 'full_name') ? 'align="left"' : ' align="center"';
														?>
														<td <?= $styleSet; ?>>
															<?php 
																$value = $detailKeys[$cleanedColumn] ?? '[NA]';
																echo (is_numeric($value) && strpos($value, '.') !== false) ? number_format($value, 2) : $value;
															?>
														</td>
												<?php
													}
												?>
											</tr>
										<?php
												}
											} else {
												echo "<tr><td colspan='30' class='text-center'>No data available</td></tr>";
											}
										?>
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
<div class="modal fade" id="exportModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title px-3" id="exportModalLabel">Export Monthly Entries</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="alert alert-info custom-export-alert" role="alert">Current filters will be applied to the exported data set.</div>
				<form id="exportForm" action="<?php echo base_url('admin/logistic-management/invoices/hunger-sales/print-monthly-sales'); ?>" method="POST">
					<input type="hidden" id="request_id" name="request_id" value="<?= $summaryData['id'];?>" required>
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
	document.querySelector('.dropdown-menu .form-select').addEventListener('click', function(event) {
		event.stopPropagation(); // Prevents the dropdown from closing
	});
</script>
<script>
$(document).ready(function() {
    // Load filters from URL on page load
    loadFiltersFromURL();
    loadFilteredData();  // ✅ Ensures data is loaded after filters are set

    let debounceTimer;

    $('#searchInput').on('keyup', function () {
        clearTimeout(debounceTimer);

        const searchValue = $(this).val().trim();

        // Minimum 1 character for search
        if (searchValue.length >= 1 || searchValue === '') {
            debounceTimer = setTimeout(function () {
                loadFilteredData(1);
            }, 300);
        }
    });

    $('#perPageSelect').on('change', function () {
        loadFilteredData(1);
    });

    function loadFilteredData(page = 1) {
        const search = $('#searchInput').val().trim();
        const perPage = $('#perPageSelect').val();

        // Update URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('search', search);
        urlParams.set('per_page', perPage);
        urlParams.set('page', page);

        const newUrl = window.location.pathname + '?' + urlParams.toString();
        history.pushState(null, '', newUrl);

        // AJAX Request
        $.ajax({
            url: "<?= base_url('admin/logistic-management/invoices/hunger-sales/detail/' . $summaryData['id']) ?>",
            type: 'GET',
            data: { search: search, page: page, per_page: perPage },
            dataType: 'json',
            beforeSend: function() {
                $('#summaryTableBody').html('<tr><td colspan="7" align="center">Loading...</td></tr>');
            },
            success: function(response) {
				// Pagination info logic
				const start = response.start;
				const end = response.end;
				const total = response.total;
				$('#paginationInfo').html(`${start} - ${end} of ${total}`);
                const availableColumns = response.available_columns || [];

				if (availableColumns.length) {
					let tableHeaders = `<tr><th>#</th>`;
					availableColumns.forEach(column => {
						const cleanedHeader = column.replace('mhss.', '').replace('me.', '');
						tableHeaders += `<th>${cleanedHeader.replace(/_/g, ' ').toUpperCase()}</th>`;
					});
					tableHeaders += `</tr>`;
					$('#summaryTable thead').html(tableHeaders);
				}

				$('#summaryTableBody').html(response.html);
				$('#paginationLinks').html(response.pagination_links);
            },
            error: function() {
                $('#summaryTableBody').html('<tr><td colspan="7" align="center">Error fetching data. Please try again.</td></tr>');
            }
        });
    }

	$(document).on('click', '.page-link', function(e) {
		e.preventDefault();

		// Extract the 'page' parameter correctly from URL
		const pageUrl = $(this).attr('href');
		const urlParams = new URLSearchParams(pageUrl.split('?')[1]);

		const page = urlParams.get('page') || 1; // ✅ Extract correct page number
		loadFilteredData(page);
	});

    // Load filters from URL on page refresh
    function loadFiltersFromURL() {
        const urlParams = new URLSearchParams(window.location.search);
        $('#searchInput').val(urlParams.get('search') || '');
        $('#perPageSelect').val(urlParams.get('per_page') || '50');
    }

	// Show the 'X' icon only when there's text in the input
    $('#searchInput').on('input', function () {
        const searchValue = $(this).val().trim();
        $('#clearSearch').toggle(searchValue.length > 0);
    });

    // Clear the search input and reload data
    $('#clearSearch').on('click', function () {
        $('#searchInput').val('');
        $(this).hide(); // Hide the 'X' when cleared
        loadFilteredData(1); // Trigger data reload with empty search
    });
});

function getColumnForm() {
	$.ajax({
		url: "<?php echo base_url('admin/manage-column/get-column-form'); ?>",
		method: 'GET',
		data: { request_type: 'hunger_sales_data' },
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
						visibleColumns.push({ columnName, columnText });
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

$(document).ready(function() {
    $('#exportForm').on('submit', function(e) {
        e.preventDefault();

        let formData = $(this).serialize();
        let fileFormat = $('input[name="file_format"]:checked').val();
        let exportUrl = (fileFormat === 'file_format_xlsx') 
            ? 'admin/logistic-management/invoices/hunger-sales/export-monthly-sales' 
            : 'admin/logistic-management/invoices/hunger-sales/print-monthly-sales';

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

        downloadForm.submit().remove();  // Submit form and remove it afterward
    });
});
</script>