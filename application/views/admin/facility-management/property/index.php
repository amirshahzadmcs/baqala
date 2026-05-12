<?php $this->load->view('admin/home/header'); ?>
<style>
	.dataTables_wrapper::-webkit-scrollbar {
		display: none;
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

	.nav-tabs .nav-item.show .nav-link,
	.nav-tabs .nav-link.active {
		color: #176a1a;
		background-color: #fff;
		border-color: #4CAF50 #4caf50 #fff;
		font-weight: 600;
		box-shadow: 1px -2px 8px -4px #6c6b6b;
	}

	th,
	td {
		white-space: nowrap;
	}

	#propertyTable {
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

	#propertyTable thead {
		position: sticky;
		z-index: 2;
		top: 0px;
		background: #fff;
		box-shadow: 2px 1px 4px -1px #a5a3a3;
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

	.dt-buttons.btn-group.flex-wrap {
		position: absolute;
		top: 12px;
		left: 20px;
	}

	div#propertyTable_info {
		position: absolute;
		top: 10px;
		right: 21%;
	}

	div#propertyTable_paginate {
		position: absolute;
		top: 8px;
		right: 6%;
	}
</style>


<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Add Property</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/facility-management/property/list'); ?>">Facility Management</a></li>
						<li class="breadcrumb-item active">Property List</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if (check_action_permission(get_user_role(), 'property_list', 'delete')): ?>
						<button type="button" class="btn btn-custom-danger btn-sm pull-right me-2" onclick="deleteAction()" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					<?php endif;
					if (check_action_permission(get_user_role(), 'property_list', 'add')): ?>
						<a class="btn btn-custom-success btn-sm pull-right me-2" title="New Property" href="<?php echo base_url('admin/facility-management/property/add') ?>"><i class="fa fa-plus"></i> Add Property</a>
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
			<!-- <div class="col-12">
				<div class="card">
					<div class="card-header">
						<h4 class="header-title mb-0">Search</h4>
					</div>
					
				</div>
			</div> -->
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<div class="float-end d-flex ms-4 mb-2" style="position: absolute; top: 12px; right: 23px;">
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
										<option value="50">50</option>
										<option value="100">100</option>
										<option value="200">200</option>
									</select>
								</div>
							</div>
						</div>

						<form id="myform" name="myform" method="post" action="" style="margin-top: 35px;">
							<div class="table-rep-plugin">
								<div class="table-responsive mb-0" data-pattern="priority-columns">
									<table id="propertyTable" class="table table-striped bulk_action" style="width:100%">
										<thead>
											<tr>
												<th>#</th>
												<th>#</th>

												<?php
												$excludedCols = ['id']; // Only 'id' is excluded in the controller
												foreach ($visibleTableColumns as $col) {
													if (in_array($col, $excludedCols)) continue;

													// Special case: Convert snake_case to Proper Case
													echo '<th>' . ucwords(str_replace('_', ' ', $col)) . '</th>';
												}
												?>

												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
							</div>
						</form>
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

<?php $this->load->view('admin/home/footer'); ?>
<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
<script>
	document.querySelector('.dropdown-menu .form-select').addEventListener('click', function(event) {
		event.stopPropagation(); // Prevents the dropdown from closing
	});
</script>
<script>
	var visibleColumns = <?php echo json_encode(array_values($visibleTableColumns)); ?>;
	var allColumns = <?php echo json_encode(array_values($selectedTableColumns)); ?>;

	function initializeDataTable() {
		if ($.fn.DataTable.isDataTable('#propertyTable')) {
			$('#propertyTable').DataTable().destroy();
		}

		let columnDefs = [];
		for (let i = 0; i < allColumns.length; i++) {
			columnDefs.push({
				targets: i,
				visible: visibleColumns.includes(allColumns[i])
			});
		}

		let selectedLength = $('#perPageSelect').val() || 50;

		$('#propertyTable').dataTable({
			lengthMenu: [
				[25, 50, 100, 500],
				[25, 50, 100, 500]
			],
			pageLength: parseInt(selectedLength),
			dom: 'Bfrtip',
			buttons: ['excel', 'pdfHtml5', 'print'],
			responsive: false,
			processing: true,
			serverSide: true,
			fixedHeader: true,
			searching: false,
			"ajax": {
				url: "<?php echo base_url(); ?>admin/facility-management/property/ajax-list?keyword=<?php echo $this->input->get('keyword') ?>&designation=<?php echo $this->input->get('designation') ?>&nationality=<?php echo $this->input->get('nationality') ?>&department=<?php echo $this->input->get('department') ?>&iqama_status=<?php echo $this->input->get('iqama_status') ?>&filter_status=<?php echo $this->input->get('filter_status') ?>&iqama=<?php echo $this->input->get('iqama') ?>&iqama_expiry_start=<?php echo $this->input->get('iqama_expiry_start') ?>&iqama_expiry_end=<?php echo $this->input->get('iqama_expiry_end') ?>&start_date=<?php echo $this->input->get('start_date') ?>&end_date=<?php echo $this->input->get('end_date') ?>",
				type: "POST",
				data: function(d) {
					d.length = $('#perPageSelect').val();
				}
			},
			columnDefs: columnDefs
		});
	}

	$(document).ready(function() {
		initializeDataTable();
	});

	function deleteAction() {
		var inputCount = $('[name="checklist[]"]:checked').length;
		if (inputCount > 0) {
			if (confirm("Do you want to delete selected property?") == true) {
				changeActionAndSubmit('admin/facility-management/property/delete');
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

	function statusModal(id) {
		$.ajax({
			url: '<?php echo base_url('admin/hr/employees/manage-status'); ?>',
			type: 'POST',
			data: {
				'id': id
			},
			dataType: 'json',
			success: function(response) {
				//console.log(response);
				$('#manageEmployeeModal').modal('show');
				$('#manageEmployeeModal .modal-content').html(response.output_html);
			},
			error: function(request, error) {
				console.log(" Can't do because: " + JSON.stringify(request));
				alert('Error loading view');
			}
		});
	}

	function getColumnForm() {
		$.ajax({
			url: "<?php echo base_url('admin/manage-column/get-column-form'); ?>",
			method: 'GET',
			data: {
				request_type: 'facilities_properties'
			},
			success: function(response) {
				//console.log('RAW response:', response);
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
				toastr.error('Failed to load column preference form!');
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

			var selectedIds = [];
			$('input[name="checklist[]"]:checked').each(function() {
				selectedIds.push($(this).val());
			});

			var selectedIdsQuery = selectedIds.map(id => `checklist[]=${id}`).join('&');
			// Get selected export options
			var columnType = $('input[name="column_type"]:checked').val();
			var fileFormat = $('input[name="file_format"]:checked').val();

			// Determine export URL based on format
			let exportUrl = (columnType === 'all_columns') ?
				'admin/hr/employees/bulk-export?' :
				'admin/hr/employees/bulk-export?';
			// Build full export URL with filters and selected IDs
			var finalUrl = "<?php echo base_url(); ?>" + exportUrl +
				"keyword=<?= $this->input->get('keyword') ?>&" +
				"designation=<?= $this->input->get('designation') ?>&" +
				"nationality=<?= $this->input->get('nationality') ?>&" +
				"department=<?= $this->input->get('department') ?>&" +
				"iqama_status=<?= $this->input->get('iqama_status') ?>&" +
				"status=<?= $this->input->get('filter_status') ?>&" +
				"iqama=<?= $this->input->get('iqama') ?>&" +
				"iqama_expiry_start=<?= $this->input->get('iqama_expiry_start') ?>&" +
				"iqama_expiry_end=<?= $this->input->get('iqama_expiry_end') ?>&" +
				"start_date=<?= $this->input->get('start_date') ?>&" +
				"end_date=<?= $this->input->get('end_date') ?>&" +
				"column_type=" + columnType +
				"&file_format=" + fileFormat;

			if (selectedIdsQuery) {
				finalUrl += '&' + selectedIdsQuery;
			}

			// Trigger download
			window.open(finalUrl, '_blank');
			$('#exportModal').modal('hide');
		});

	});
</script>