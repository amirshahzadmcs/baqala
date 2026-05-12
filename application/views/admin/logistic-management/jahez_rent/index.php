<?php $this->load->view('admin/home/header'); ?>
<style>
	th {
		white-space: nowrap;
	}

	#rentTable td {
		white-space: nowrap;
	}
	.dataTables_wrapper::-webkit-scrollbar {
		display: none;
	}

	.nav-md .container.body .right_col {
		padding: 10px 10px 0;
		margin-left: 230px;
	}
	
	.table-responsive.mb-0 {
		min-height: 300px;
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

	.daterangepicker {
		z-index: 99999 !important;
	}

	input#searchInput {
		border-radius: 5px;
		border-color: #b3b3b3;
		min-width: 250px;
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

	#rentTable thead {
		position: sticky;
		z-index: 2;
		top: 0px;
		background: #fff;
		box-shadow: 2px 1px 4px -1px #a5a3a3;
	}
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Jahez Rent Agreement Form</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/logistic-management/jahez-rent'); ?>">Jahez Rent Agreement</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if (check_action_permission(get_user_role(), 'jahez_rent', 'delete')): ?>
					<button type="button" class="btn btn-custom-danger btn-sm pull-right me-2" onclick="deleteAction()" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					<?php endif;
					if (check_action_permission(get_user_role(), 'jahez_rent', 'add')): ?>
					<button class="btn btn-custom-success btn-sm pull-right" title="Add" onclick="addRentPopup()"><i class="fa fa-plus"></i> Add Jahez Rent</button>
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
				<?php if ($this->input->get('msg')) { ?>
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<strong><?php echo $this->input->get('msg'); ?></strong>
					</div>
				<?php } ?>
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
						<div class="row">
							<div class="col-md-12">
								<div class="d-flex align-items-center justify-content-between position-relative float-start" style="max-width: 480px;">
									<div class="relative">
										<div class="relative">
											<div class="search-box chat-search-box">
												<div class="position-relative">
													<input type="text" id="searchInput" name="keyword" class="form-control" placeholder="Search..." value="<?= $this->input->get('keyword'); ?>">
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
									<div class="d-flex">
										<button class="btn btn-secondary btn-sm ms-2 font-size-15" id="btnSearch" type="button" style="height: 39px;line-height: 16px;width: 90px;border-radius: 5px;" data-bs-toggle="modal" data-bs-target="#filtersModal">
											<i class="mdi mdi-filter-variant font-size-18"></i> Filters
										</button>
										<button id="resetFilters" class="btn btn-outline-danger btn-sm ms-2 font-size-15" style="height: 39px;line-height: 16px;width: 105px;border-radius: 5px; display: none;">
											<i class="mdi mdi-filter-remove-outline font-size-18"></i> Reset All
										</button>
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
								<form id="myform" name="myform" method="post" action="">
									<table id="rentTable" class="table table-striped" style="width:100%">
										<thead class="text-center">
											<tr>
												<th>#</th>
												<th>S.No.</th>
												<?php
													if (!empty($visibleTableColumns)) {
														foreach ($visibleTableColumns as $column) {
															if ($column == 'id') continue; // ✅ Skip rendering ID in header
															$styleSet = ($column == 'agreement_date') ? "align='center'" : " align='center'";
													?>
															<th <?= $styleSet; ?>><?= strtoupper(str_replace('_', ' ', $column)); ?></th>
													<?php
														}
													}
												?>
												<th>Action</th>
											</tr>
										</thead>
										<tbody class="text-center">

										</tbody>
									</table>
								</form>
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

<div class="modal fade fixed-left" id="filtersModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="filtersModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title px-3" id="filtersModalLabel">Filters</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url('admin/logistic-management/jahez-rent'); ?>" method="get" id="applyFiltersBtn">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 mb-3">
							<div class="form-group">
								<label>Name / Agreement No.</label>
								<input type="search" id="keyword" name="keyword" placeholder="Search By Name / Agreement No." value="<?php echo $this->input->get('keyword') ? $this->input->get('keyword') : ''; ?>" autocomplete="off" class="form-control">
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 mb-3">
							<label for="filterRange">Select Agreement Date Range</label>
							<div id="filterRange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
								<i class="fa fa-calendar"></i>&nbsp;
								<span></span> <i class="fa fa-caret-down"></i>
							</div>
							<input type="hidden" name="date_from" id="filter_start_date" required>
							<input type="hidden" name="date_to" id="filter_end_date" required>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<a href="<?php echo base_url('admin/logistic-management/jahez-rent'); ?>" type="button" class="btn btn-secondary">Cancel</a>
				<button type="submit" form="applyFiltersBtn" class="btn btn-custom-success">Apply Filters</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade fixed-left rent-modal" role="dialog" aria-labelledby="ModalFullscreenLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this->load->view('admin/home/footer'); ?>
<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
<script>
	$(document).ready(function() {
		$('#perPageSelect').on('click change', function(event) {
			event.stopPropagation(); // Prevent dropdown from closing
		});
	});

	// Restore filters from URL into hidden inputs
	$(document).ready(function() {
		const urlParams = new URLSearchParams(window.location.search);
		const df = urlParams.get('date_from');
		const dt = urlParams.get('date_to');

		if (df && dt) {
			$('#filter_start_date').val(df);
			$('#filter_end_date').val(dt);
			$('#filterRange span').html(
				moment(df).format('MMMM D, YYYY') + ' - ' +
				moment(dt).format('MMMM D, YYYY')
			);
		}
	});

	$(document).ready(function() {
		let currentPage = 0; // Track current page
		let table;

		function initializeDataTable() {
			// Destroy existing DataTable before reinitializing
			if ($.fn.DataTable.isDataTable('#rentTable')) {
				$('#rentTable').DataTable().destroy();
			}

			table = $('#rentTable').DataTable({
				"serverSide": true,
				"processing": true,
				"ajax": {
					url: "<?php echo base_url(); ?>admin/logistic-management/jahez-rent-ajax",
					type: "POST",
					data: function(d) {
						let searchVal = $('#searchInput').val();
						d.search = searchVal;
						d.keyword = searchVal; // same value
						d.date_from = $('input[name="date_from"]').val();
						d.date_to = $('input[name="date_to"]').val();
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
			const perPage = parseInt($('#perPageSelect').val());
			const totalPages = Math.ceil(totalRecords / perPage);
			const maxVisiblePages = 5; // Adjust this to control how many pages you want visible
			let paginationHTML = `<ul class="pagination justify-content-center mb-0">`;

			// Previous button
			paginationHTML += `<li class="page-item ${currentPage === 0 ? 'disabled' : ''}">
				<a class="page-link pagination-link" href="#" data-page="${currentPage - 1}">«</a>
			</li>`;

			let startPage = Math.max(currentPage - Math.floor(maxVisiblePages / 2), 0);
			let endPage = startPage + maxVisiblePages - 1;

			if (endPage >= totalPages) {
				endPage = totalPages - 1;
				startPage = Math.max(endPage - maxVisiblePages + 1, 0);
			}

			// First page
			if (startPage > 0) {
				paginationHTML += `<li class="page-item">
					<a class="page-link pagination-link" href="#" data-page="0">1</a>
				</li>`;
				if (startPage > 1) {
					paginationHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
				}
			}

			// Visible pages
			for (let i = startPage; i <= endPage; i++) {
				paginationHTML += `<li class="page-item ${i === currentPage ? 'active' : ''}">
					<a class="page-link pagination-link" href="#" data-page="${i}">${i + 1}</a>
				</li>`;
			}

			// Last page
			if (endPage < totalPages - 1) {
				if (endPage < totalPages - 2) {
					paginationHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
				}
				paginationHTML += `<li class="page-item">
					<a class="page-link pagination-link" href="#" data-page="${totalPages - 1}">${totalPages}</a>
				</li>`;
			}

			// Next button
			paginationHTML += `<li class="page-item ${currentPage === totalPages - 1 ? 'disabled' : ''}">
				<a class="page-link pagination-link" href="#" data-page="${currentPage + 1}">»</a>
			</li>`;

			paginationHTML += `</ul>`;

			$('#paginationLinks').html(paginationHTML);
			$('#paginationInfo').text(`Showing ${currentRecords} of ${totalRecords} entries`);
		}

		// ✅ Event: Search Input
		$('#searchInput').on('input', function() {
			$('#keyword').val($(this).val());
			currentPage = 0; // Reset to first page on search
			const searchValue = $(this).val().trim();
			$('#clearSearch').toggle(searchValue.length > 0);
			table.ajax.reload();
		});

		// Sync main search input when typing in modal
		$('#keyword').on('input', function() {
			$('#searchInput').val($(this).val());
			$('#clearSearch').toggle($(this).val().trim().length > 0);
		});

		// Apply filters via modal
		$('#applyFiltersBtn').on('click', function() {
			$('#searchInput').val($('#keyword').val()); // sync before submit
			currentPage = 0;
			table.ajax.reload();
			//$('#filtersModal').modal('hide');
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

		$(document).ready(function() {
			// Show reset button if any filter/search is applied
			function checkFilters() {
				const search = $('#searchInput').val();
				const dateFrom = $('#filter_start_date').val();
				const dateTo = $('#filter_end_date').val();

				if (search || dateFrom || dateTo) {
					$('#resetFilters').show();
				} else {
					$('#resetFilters').hide();
				}
			}

			// Initial check
			checkFilters();

			// Run on filter change
			$('#searchInput, #filter_start_date, #filter_end_date').on('input change', function() {
				checkFilters();
			});

			// Reset filters
			$('#resetFilters').click(function() {
				window.location.href = "<?php echo base_url('admin/logistic-management/jahez-rent'); ?>";
			});
		});
		
		$('.dropify').dropify();

	});

	function getColumnForm() {
		$.ajax({
			url: "<?php echo base_url('admin/manage-column/get-column-form'); ?>",
			method: 'GET',
			data: {
				request_type: 'jahez_rent'
			},
			success: function(response) {
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
				toastr.error('Failed to load manage column form.');
			}
		});
	}

	function updateVisibleColumnCount() {
		const count = $('.visible-columns .visible-column').length;
		$('.badge.bg-primary').text(count);
	}

	function deleteAction() {
		var inputCount = $('[name="checklist[]"]:checked').length;
		if (inputCount > 0) {
			if (confirm("Do you want to delete selected jahez rent data?") == true) {
				changeActionAndSubmit('admin/logistic-management/jahez-rent/delete');
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

	$(document).ready(function () {

		// ----------------------------------------
		// Open Export Modal
		// ----------------------------------------
		$('#export-btn').on('click', function (e) {
			e.preventDefault();
			$('#exportModal').modal('show');
		});

		// ----------------------------------------
		// Handle Export Submit
		// ----------------------------------------
		$('#exportForm').on('submit', function (e) {
			e.preventDefault();

			let exportUrl = "<?php echo base_url('admin/logistic-management/jahez-rent/export-excel'); ?>";

			let params = [];

			// ----------------------------------------
			// Filters (same as DataTable)
			// ----------------------------------------
			let keyword     = $('#keyword').val();
			let date_from   = $('#filter_start_date').val();
			let date_to     = $('#filter_end_date').val();

			if (keyword)     params.push('keyword=' + encodeURIComponent(keyword));
			if (date_from)   params.push('from=' + encodeURIComponent(date_from));
			if (date_to)     params.push('to=' + encodeURIComponent(date_to));

			// ----------------------------------------
			// Export Options from Modal
			// ----------------------------------------
			let columnType = $('input[name="column_type"]:checked').val();
			let fileFormat = $('input[name="file_format"]:checked').val();

			params.push('column_type=' + encodeURIComponent(columnType));
			params.push('file_format=' + encodeURIComponent(fileFormat));

			// ----------------------------------------
			// Selected checkboxes
			// ----------------------------------------
			let selectedIds = [];
			$('input[name="checklist[]"]:checked').each(function () {
				selectedIds.push($(this).val());
			});

			if (selectedIds.length > 0) {
				selectedIds.forEach(function (id) {
					params.push('checklist[]=' + encodeURIComponent(id));
				});
			}

			// ----------------------------------------
			// Final URL
			// ----------------------------------------
			if (params.length > 0) {
				exportUrl += '?' + params.join('&');
			}

			// ----------------------------------------
			// Open Export
			// ----------------------------------------
			window.open(exportUrl, '_blank');
			$('#exportModal').modal('hide');
		});

	});

	function addRentPopup() {
		$.ajax({
			type: "get",
			url: "<?php echo base_url('admin/logistic-management/jahez-rent/add'); ?>",
			success: function(response) {
				// Show modal and inject HTML
				$('.rent-modal').modal('show');
				$('.rent-modal .modal-content').html(response);

				// Initialize Select2 on any desired select fields
				$('.rent-modal .select2').select2({
					width: '100%', // Ensures proper width
					dropdownParent: $('.rent-modal') // Fixes dropdown appearing under modals
				});
			},
			error: function(request, error) {
				console.log("Can't do because: " + JSON.stringify(request));
				toastr.error("Error loading add rent form.");
			}
		});
	}

	function editRentPopup(id) {
		$.ajax({
			type: "get",
			url: "<?php echo base_url('admin/logistic-management/jahez-rent/edit'); ?>?id=" + id,
			success: function(response) {
				// Show modal and inject HTML
				$('.rent-modal').modal('show');
				$('.rent-modal .modal-content').html(response);

				// Initialize Select2 on any desired select fields
				$('.rent-modal .select2').select2({
					width: '100%', // Ensures proper width
					dropdownParent: $('.rent-modal') // Fixes dropdown appearing under modals
				});
			},
			error: function(request, error) {
				console.log("Can't do because: " + JSON.stringify(request));
				toastr.error("Error loading interview form.");
			}
		});
	}

	function detailRentPopup(id) {
		$.ajax({
			type: "get",
			url: "<?php echo base_url('admin/logistic-management/jahez-rent/detail'); ?>?id=" + id,
			success: function(response) {
				// Show modal and inject HTML
				$('.rent-modal').modal('show');
				$('.rent-modal .modal-content').html(response);

				// Initialize Select2 on any desired select fields
				$('.rent-modal .select2').select2({
					width: '100%', // Ensures proper width
					dropdownParent: $('.rent-modal') // Fixes dropdown appearing under modals
				});
			},
			error: function(request, error) {
				console.log("Can't do because: " + JSON.stringify(request));
				toastr.error("Error loading interview form.");
			}
		});
	}
</script>
<script type="text/javascript">
$(function() {

    function cb(start, end) {
        // Show selected range
        $('#filterRange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

        // Set hidden values
        $('#filter_start_date').val(start.format('YYYY-MM-DD'));
        $('#filter_end_date').val(end.format('YYYY-MM-DD'));
    }

    $('#filterRange').daterangepicker({
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

    // When user selects date manually
    $('#filterRange').on('apply.daterangepicker', function(ev, picker) {
        cb(picker.startDate, picker.endDate);
    });

    // When user presses CLEAR button
    $('#filterRange').on('cancel.daterangepicker', function(ev, picker) {
        $('#filterRange span').html('');  // blank display
        $('#filter_start_date').val('');
        $('#filter_end_date').val('');
    });

});
</script>
