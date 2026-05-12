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

	#employeeTable {
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

	#employeeTable thead {
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
		right: 50px;
	}

	div#employeeTable_info {
		position: absolute;
		top: 10px;
		right: 50%;
	}

	div#employeeTable_paginate {
		position: absolute;
		top: 8px;
		right: 22%;
	}

	input#searchInput {
		border-radius: 25px;
		border-color: #b3b3b3;
		min-width: 250px;
	}

	.custom-dropdown-btn .btn-outline-success {
		color: #1a1a1a;
		border-color: #bfbfbf;
		border-radius: 30px;
	}

	.custom-dropdown-btn .btn-outline-success:hover {
		color: #1a1a1a;
		background-color: #f3f3f3;
		border-color: #545454;
	}

	.custom-dropdown-btn .btn.active {
		background-color: #c7f1d5;
		color: #067748;
		border-color: #c7f1d5;
	}

	.vscomp-ele {
		max-width: 100% !important;
	}

	.filter-item {
		margin-bottom: 15px;
		padding: 10px;
		border: 1px solid #ddd;
		border-radius: 6px;
		background: #f9f9f9;
		position: relative;
	}

	.filter-item .remove-btn {
		position: absolute;
		top: -20px;
		right: -10px;
		cursor: pointer;
		color: #ff5555;
	}

	#noFiltersMessage {
		font-size: 14px;
	}

	/* Default: Show all buttons */
	#filterButtons button {
		flex: 1;
		margin: 0 2px;
	}

	/* Single button state: only Add Filter full width */
	#filterButtons.single-button #addFilterBtn {
		width: 100%;
		flex: unset;
	}

	#filterButtons.single-button #clearAllFilters,
	#filterButtons.single-button #applyFiltersBtn {
		display: none;
	}

	.filter-item .select2-container {
		margin-bottom: 0.5rem !important;
		/* same as mb-2 */
		width: 100% !important;
	}
</style>
<link href="https://cdn.jsdelivr.net/npm/virtual-select-plugin/dist/virtual-select.min.css" rel="stylesheet">

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Employees</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/hr/employees'); ?>">Employees</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if (check_action_permission(get_user_role(), 'view_employees', 'delete')): ?>
						<button type="button" class="btn btn-custom-danger btn-sm pull-right me-2" onclick="deleteAction()" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					<?php endif;
					if (check_action_permission(get_user_role(), 'view_employees', 'add_step1')): ?>
						<a class="btn btn-custom-success btn-sm pull-right me-2" title="New Employee" href="<?php echo base_url('admin/hr/employees/add/step-1') ?>"><i class="fa fa-plus"></i> New Employee</a>
					<?php endif;
					$bulkImport = check_action_permission(get_user_role(), 'view_employees', 'import_file');
					$bulkExport = check_action_permission(get_user_role(), 'view_employees', 'employeeExport');
					$salaryFile = check_action_permission(get_user_role(), 'view_employees', 'activeEmployeeExport');

					if ($bulkImport || $bulkExport || $salaryFile): ?>
						<div class="btn-group ms-2 float-end">
							<button class="btn btn-custom-white btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fas fa-file-excel"></i> Bulk Action <i class="mdi mdi-chevron-down"></i>
							</button>
							<div class="dropdown-menu dropdown-menu-end">
								<?php if ($bulkImport): ?>
									<a class="dropdown-item" title="Bulk Import" href="javascript:;" data-bs-toggle="modal" data-bs-target=".bulkImportModal">
										<i class="ti-import me-2"></i> Bulk Import
									</a>
									<div class="dropdown-divider"></div>
								<?php endif; ?>

								<?php if ($bulkExport): ?>
									<a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#exportModal">
										<i class="ti-export me-2"></i> Bulk Export
									</a>
									<div class="dropdown-divider"></div>
								<?php endif; ?>

								<?php if ($salaryFile): ?>
									<a class="dropdown-item" type="button" id="exportSalaryBtn" target="_blank">
										<i class="ti-export me-2"></i> Export Salary Upload File
									</a>
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
						<!-- Nav tabs -->
						<ul class="nav nav-tabs mb-2">
							<?php
							$tabs = [
								'all' => 'All',
								'active' => 'Active',
								'terminated' => 'Terminated'
							];
							// Set "All" as active if $currentSegment is empty
							$currentSegment = $this->uri->segment(4);
							if (empty($currentSegment)) {
								$currentSegment = 'all';
							}
							?>

							<?php foreach ($tabs as $key => $label): ?>
								<li class="nav-item">
									<a class="nav-link disable-right-click <?php echo ($currentSegment === $key) ? 'active' : ''; ?>"
										href="<?php echo base_url("admin/hr/employees/$key"); ?>">
										<span class="d-block d-sm-none">
											<i class="far fa-envelope"></i>
										</span>
										<span class="d-none d-sm-block"><?php echo $label; ?></span>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
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

						<div class="d-flex align-items-center justify-content-between position-relative float-start" style="max-width: 720px;margin-bottom: 4px;">
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

							<div class="dropdown d-inline-block ms-3 custom-dropdown-btn" id="nationalityFilterDropdown" data-bs-auto-close="false">
								<button class="btn btn-outline-success dropdown-toggle" type="button" data-bs-toggle="dropdown">
									Nationality <i class="mdi mdi-chevron-down"></i>
								</button>

								<div class="dropdown-menu p-3" style="min-width: 350px;">
									<!-- Loader -->
									<div id="loaderNationality" class="text-center py-2" style="display:none;">
										<div class="spinner-border text-success" role="status" style="width:1.5rem;height:1.5rem;">
											<span class="visually-hidden">Loading...</span>
										</div>
									</div>

									<!-- Virtual Select container -->
									<div id="nationalityTypeSelect" style="max-width: 100%;"></div>

									<div class="mt-3 d-flex justify-content-between">
										<button class="btn btn-sm btn-light" id="clearNationality">Clear</button>
										<button class="btn btn-sm btn-success" id="applyNationality">Apply</button>
									</div>
								</div>
							</div>

							<!-- Designation -->
							<div class="dropdown d-inline-block ms-3 custom-dropdown-btn" id="designationFilterDropdown" data-bs-auto-close="false">
								<button class="btn btn-outline-success dropdown-toggle w-100" type="button" data-bs-toggle="dropdown">
									Designation <i class="mdi mdi-chevron-down"></i>
								</button>

								<div class="dropdown-menu p-3" style="min-width: 350px;">
									<!-- Loader -->
									<div id="loaderDesignation" class="text-center py-2" style="display:none;">
										<div class="spinner-border text-success" role="status" style="width:1.5rem;height:1.5rem;">
											<span class="visually-hidden">Loading...</span>
										</div>
									</div>

									<!-- Virtual Select -->
									<div id="designationTypeSelect" style="max-width: 100%;"></div>

									<div class="mt-3 d-flex justify-content-between">
										<button class="btn btn-sm btn-light" id="clearDesignation">Clear</button>
										<button class="btn btn-sm btn-success" id="applyDesignation">Apply</button>
									</div>
								</div>
							</div>

							<!-- Department -->
							<div class="dropdown d-inline-block ms-3 custom-dropdown-btn" id="departmentFilterDropdown" data-bs-auto-close="false">
								<button class="btn btn-outline-success dropdown-toggle w-100" type="button" data-bs-toggle="dropdown">
									Department <i class="mdi mdi-chevron-down"></i>
								</button>

								<div class="dropdown-menu p-3" style="min-width: 350px;">
									<div id="loaderDepartment" class="text-center py-2" style="display:none;">
										<div class="spinner-border text-success" role="status" style="width:1.5rem;height:1.5rem;">
											<span class="visually-hidden">Loading...</span>
										</div>
									</div>
									<div id="departmentTypeSelect" style="max-width: 100%;"></div>
									<div class="mt-3 d-flex justify-content-between">
										<button class="btn btn-sm btn-light" id="clearDepartment">Clear</button>
										<button class="btn btn-sm btn-success" id="applyDepartment">Apply</button>
									</div>
								</div>
							</div>

							<!-- Status (only if $currentSegment empty or all) -->
							<?php if (empty($currentSegment) || $currentSegment == 'all') { ?>
								<div class="dropdown d-inline-block ms-3 custom-dropdown-btn" id="statusFilterDropdown" data-bs-auto-close="false">
									<button class="btn btn-outline-success dropdown-toggle w-100" type="button" data-bs-toggle="dropdown">
										Status <i class="mdi mdi-chevron-down"></i>
									</button>

									<div class="dropdown-menu p-3" style="min-width: 350px;">
										<div id="loaderStatus" class="text-center py-2" style="display:none;">
											<div class="spinner-border text-success" role="status" style="width:1.5rem;height:1.5rem;">
												<span class="visually-hidden">Loading...</span>
											</div>
										</div>
										<div id="statusTypeSelect" style="max-width: 100%;"></div>
										<div class="mt-3 d-flex justify-content-between">
											<button class="btn btn-sm btn-light" id="clearFilterStatus">Clear</button>
											<button class="btn btn-sm btn-success" id="applyFilterStatus">Apply</button>
										</div>
									</div>
								</div>
							<?php } ?>


							<div class="d-flex">
								<button class="btn btn-secondary btn-sm ms-2 font-size-15" id="btnSearch" type="button" style="height: 36px;line-height: 16px;width: 90px;border-radius: 30px;" data-bs-toggle="modal" data-bs-target="#filtersModal">
									<i class="mdi mdi-filter-variant font-size-18"></i> Filters
								</button>
								<button id="resetFilters" class="btn btn-outline-danger btn-sm ms-2 font-size-15" style="height: 36px;line-height: 16px;width: 105px;border-radius: 30px; display: none;">
									<i class="mdi mdi-filter-remove-outline font-size-18"></i> Reset All
								</button>
							</div>
						</div>

						<form id="myform" name="myform" method="post" action="">
							<div class="table-rep-plugin">
								<div class="table-responsive mb-0" data-pattern="priority-columns">
									<table id="employeeTable" class="table table-striped bulk_action" style="width:100%">
										<thead>
											<tr>
												<th>#</th>
												<th>#</th>
												<?php
												$excludedCols = ['employee_pic', 'id']; // Add any others here
												foreach ($visibleTableColumns as $col) {
													if (in_array($col, $excludedCols)) continue;

													// Handle payment_type_detail specially
													if ($col === 'payment_type_detail') {
														echo '<th>Account Type</th>';
														echo '<th>Bank Name</th>';
														echo '<th>IBAN No</th>';
													} else {
														echo '<th>' . ucwords(str_replace('_', ' ', $col)) . '</th>';
													}
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
<div class="modal fade bulkImportModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="bulkImportModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title px-3" id="bulkImportModalLabel">Bulk import for <b>Employees</b></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="messageContainer" class="px-3" style="max-height: 350px;overflow: scroll;"></div>
				<form id="employee_bulk_form" method="post" enctype="multipart/form-data" autocomplete="off">
					<div class="row px-3">
						<div class="col-md-12 col-sm-12 mb-3 form-group">
							<label for="attachment">Upload File <span class="text-secondary">(Supported file format is: .xls .xlsx)</span></label>
							<input type="file" name="file" id="attachment" class="dropify" accept=".xls,.xlsx,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" data-max-file-size="2M" data-height="100" required>
						</div>
						<div class="col-md-12">
							<p class="text-secondary">Upload the same file format in (.xls) provided from Baqala Station to avoid any errors while importing your data.</p>
							<p style="text-align: center;"><a type="button" href="<?php echo base_url('admin_assets/samples/Mahaalfala-employees-sample-bulk-upload.xlsx'); ?>" class="btn bt btn-link text-success" target="_blank" download>Download sample file</a></p>
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

<div class="modal fade staticBackdrop fixed-left manageEmployeeModal" id="manageEmployeeModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="#manageEmployeeModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">

		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

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
				<form id="exportForm" action="<?php echo base_url('admin/hr/employees/excel-export'); ?>" method="POST">
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
<!-- Filter Modal -->
<div class="modal fade staticBackdrop fixed-left filtersModal" id="filtersModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="#filtersModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="filtersModalLabel">
					<i class="mdi mdi-filter-variant"></i> Filters
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="filterDrawer">
					<div id="filterContainer">
						<p id="noFiltersMessage" class="text-muted text-center my-3">No filters applied</p>
					</div>

					<!-- Buttons section -->
					<div id="filterButtons" class="d-flex justify-content-between mt-2 single-button">
						<button id="clearAllFilters" class="btn btn-sm btn-outline-danger">Clear all</button>
						<button id="addFilterBtn" class="btn btn-success btn-sm">+ Add Filter</button>
						<button id="applyFiltersBtn" class="btn btn-success btn-sm">Apply Filters</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<?php $this->load->view('admin/home/footer'); ?>
<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/virtual-select-plugin/dist/virtual-select.min.js"></script>
<script>
	document.querySelector('.dropdown-menu .form-select').addEventListener('click', function(event) {
		event.stopPropagation(); // Prevents the dropdown from closing
	});
</script>
<script>
	var visibleColumns = <?php echo json_encode(array_values($visibleTableColumns)); ?>;
	var allColumns = <?php echo json_encode(array_values($selectedTableColumns)); ?>;
	function getQueryParams() {
		const params = new URLSearchParams(window.location.search);
		let filters = {};

		for (const [key, value] of params.entries()) {
			filters[key] = value;
		}

		return filters;
	}

	function initializeDataTable() {
		if ($.fn.DataTable.isDataTable('#employeeTable')) {
			$('#employeeTable').DataTable().destroy();
		}
		let filters = getQueryParams();
		let columnDefs = [];
		for (let i = 0; i < allColumns.length; i++) {
			columnDefs.push({
				targets: i,
				visible: visibleColumns.includes(allColumns[i])
			});
		}

		let selectedLength = $('#perPageSelect').val() || 50;

		$('#employeeTable').dataTable({
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
				url: "<?php echo base_url(); ?>admin/hr-module/employees/Employee/get_list?view_type=<?php echo $currentSegment; ?>&filters=" + encodeURIComponent(JSON.stringify(filters)),
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

		// Reinitialize when custom dropdown changes
		$('#perPageSelect').on('change', function() {
			initializeDataTable();
		});

		$('#exportSalaryBtn').on('click', function(e) {
			e.preventDefault();

			var selectedIds = [];
			$('input[name="checklist[]"]:checked').each(function() {
				selectedIds.push($(this).val());
			});
			var selectedIdsQuery = selectedIds.map(id => `checklist[]=${id}`).join('&');
			var exportUrl = "<?php echo base_url(); ?>admin/hr/employees/export-salary-file?keyword=<?php echo $this->input->get('keyword') ?>&designation=<?php echo $this->input->get('designation') ?>&nationality=<?php echo $this->input->get('nationality') ?>&department=<?php echo $this->input->get('department') ?>&iqama_status=<?php echo $this->input->get('iqama_status') ?>&status=<?php echo $this->input->get('filter_status') ?>&iqama=<?php echo $this->input->get('iqama') ?>&start_date=<?php echo $this->input->get('start_date') ?>&end_date=<?php echo $this->input->get('end_date') ?>";

			if (selectedIdsQuery) {
				exportUrl += '&' + selectedIdsQuery;
			}

			window.open(exportUrl, '_blank');
		});
	});

	function deleteAction() {
		var inputCount = $('[name="checklist[]"]:checked').length;
		if (inputCount > 0) {
			if (confirm("Do you want to delete selected employee?") == true) {
				changeActionAndSubmit('admin/hr/employees/delete');
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
		$("body").on("submit", "#employee_bulk_form", function(e) {
			e.preventDefault();
			var data = new FormData(this);
			$.ajax({
				type: 'POST',
				url: "<?php echo base_url('admin/hr/employees/bulk-import') ?>",
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
					console.log(response);
					$("#btnUpload").prop('disabled', false);
					$("#btnUpload").html('Import');
					$("#attachment").val('');
					var jsonResponse = JSON.parse(response);
					if (jsonResponse.error_message) {
						var tableHtml = '<p style="color: red;">Error: ' + jsonResponse.error_message + '</p>';
						if (jsonResponse.duplicate_rows) {
							tableHtml += '<h6>Duplicate Rows</h6><table class="table border-danger"><tr><th>Emp ID</th><th>Emp. Name</th></tr>';
							$.each(jsonResponse.duplicate_rows, function(index, row) {
								tableHtml += '<tr>';
								tableHtml += '<td>' + row[1] + '</td>';
								tableHtml += '<td>' + row[6] + '</td>';
								// $.each(row, function(key, value) {
								// tableHtml += '<td>' + value + '</td>';
								// });
								tableHtml += '</tr>';
							});
							tableHtml += '</table>';
						}
						$('#messageContainer').html(tableHtml);
					} else if (jsonResponse.success_message) {
						$('#messageContainer').html('<p style="color: green;">Success: ' + jsonResponse.success_message + '</p>');
					} else if (jsonResponse.duplicate_rows) {
						var tableHtml = '<h2>Duplicate Rows</h2><table border="1"><tr><th>Column 1</th><th>Column 2</th><th>...</th></tr>';
						$.each(jsonResponse.duplicate_rows, function(index, row) {
							tableHtml += '<tr>';
							$.each(row, function(key, value) {
								tableHtml += '<td>' + value + '</td>';
							});
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
	
	function iqamaModal(id) {
		$.ajax({
			url: '<?php echo base_url('admin/hr/employees/iqama-updation-form'); ?>',
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
				request_type: 'master_employees_data'
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
				toastr.error('Failed to load correction form.');
			}
		});
	}

	function updateVisibleColumnCount() {
		const count = $('.visible-columns .visible-column').length;
		$('.badge.bg-primary').text(count);
	}

	$(document).ready(function () {
		$('#exportForm').on('submit', function (e) {
			e.preventDefault();

			// Get filters (same as DataTable)
			let filters = getQueryParams();

			// Collect selected checkboxes
			var selectedIds = [];
			$('input[name="checklist[]"]:checked').each(function () {
				selectedIds.push($(this).val());
			});

			// Build selected IDs query string
			var selectedIdsQuery = selectedIds.map(id => `checklist[]=${encodeURIComponent(id)}`).join('&');

			// Get selected export options
			var columnType = $('input[name="column_type"]:checked').val();
			var fileFormat = $('input[name="file_format"]:checked').val();

			// Build final URL (SAME structure as DataTable)
			var finalUrl = "<?php echo base_url(); ?>admin/hr/employees/bulk-export" +
				"?view_type=<?php echo $currentSegment; ?>" +
				"&filters=" + encodeURIComponent(JSON.stringify(filters)) +
				"&column_type=" + columnType +
				"&file_format=" + fileFormat;

			// Append selected IDs
			if (selectedIdsQuery) {
				finalUrl += '&' + selectedIdsQuery;
			}

			// Trigger download
			window.open(finalUrl, '_blank');
			$('#exportModal').modal('hide');
		});
	});
</script>
<script src="<?php echo base_url('admin_assets/js/employee_filter.js'); ?>"></script>