<?php $this->load->view('admin/home/header'); ?>
<style>
	th {
		white-space: nowrap;
	}
	table#vehicleTable {
		min-height: 400px;
	}
	#vehicleTable td {
		white-space: nowrap;
	}
	.dataTables_wrapper::-webkit-scrollbar {
		display: none;
	}
	.tab-inner-section {
		box-shadow: 0px 1px 4px #c5c5c5;
		border-radius: 5px;
		margin-bottom: 10px;
	}

	/*---- Sidebar ----*/
	.modal .modal-dialog-aside {
		width: 30%;
		max-width: 80%;
		height: 100%;
		margin: 0;
		transform: translate(0);
		transition: transform .2s;
	}

	#requestTable th:hover {
		background: #e9e9e9;
	}

	.modal .modal-dialog-aside .modal-content {
		height: inherit;
		border: 0;
		border-radius: 0;
	}

	.modal .modal-dialog-aside .modal-content .modal-body {
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

	#vehicleTable thead {
		position: sticky;
		z-index: 2;
		top: 0px;
		background: #fff;
		box-shadow: 2px 1px 4px -1px #a5a3a3;
	}
	/*----- End ------*/
</style>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Master Vehicle</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/master-vehicle/list'); ?>">Master Vehicle</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if (check_action_permission(get_user_role(), 'vehicles', 'delete')): ?>
						<button class="btn btn-custom-danger btn-sm pull-right me-2" onclick="confirm('Really want to delete this item?') ? $('#delete_form').submit() : false;" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					<?php endif;
					if (check_action_permission(get_user_role(), 'vehicles', 'all_logs')): ?>
						<a class="btn btn-sm btn-custom-white pull-right me-2" title="Back" href="<?php echo base_url('admin/master-vehicle/all-logs'); ?>" target="_blank"><i class="fa fa-receipt"></i> Vehicle Logs</a>
					<?php endif;
					if (check_action_permission(get_user_role(), 'vehicles', 'vehicleExport')): ?>
						<a class="btn btn-sm btn-custom-white pull-right me-2" title="Export" 
							id="exportExcelBtn" 
							href="#" 
							target="_blank">
							<i class="fas fa-file-export"></i> Export Excel
						</a>
					<?php endif;
					if (check_action_permission(get_user_role(), 'vehicles', 'addVehicleForm')): ?>
						<button class="btn btn-custom-success btn-sm pull-right" title="Add" onclick="addVehiclePopup()"><i class="fa fa-plus"></i> Add Vehicle</button>
					<?php endif; ?>
				</div>
				<?php if ($this->admin->getInfo()) {
					$info = explode("--", $this->admin->getInfo());
					$info_type = $info[0];
					$msg_data = $info[1];
					if ($info_type == 2) {
				?>
						<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong><?php echo $msg_data; ?></strong>
						</div>
					<?php } else { ?>
						<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong><?php echo $msg_data; ?></strong>
						</div>
					<?php } ?> <?php }
							$this->admin->removeInfo(); ?>
				<!-- </div> -->
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
								<?php echo form_open('admin/master-vehicle/delete', array("id" => "delete_form")); ?>
									<table id="vehicleTable" class="table table-striped" style="width:100%">
										<thead>
											<tr>
												<th>#</th>
												<th>S.No.</th>

												<?php
													if (!empty($visibleTableColumns)) {
														foreach ($visibleTableColumns as $column) {

															// Skip ID column
															if ($column == 'id') continue;

															// Alignment (you can customize per column if needed)
															$styleSet = ($column == 'alloted_user') ? "align='left'" : " align='center'";
												?>
															<th <?= $styleSet; ?>>
																<?= strtoupper(str_replace('_', ' ', $column)); ?>
															</th>
												<?php
														}
													}
												?>

												<th>Tools</th>
											</tr>
										</thead>

										<tbody class="text-center"></tbody>
									</table>
								<?php echo form_close(); ?>
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

<div class="modal fade log-detail-modal" role="dialog" aria-labelledby="ModalFullscreenLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title mt-0" id="summaryModalFullscreenLabel">Vehicle Log</h6>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" id="summary_body_modal">

			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade fixed-left allotment-modal" role="dialog" aria-labelledby="ModalFullscreenLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade fixed-left" id="filtersModal" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="filtersModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title px-3" id="filtersModalLabel">Filters</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url('admin/master-vehicle/list'); ?>" method="get" id="applyFiltersBtn">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-3">
								<label>Vehicle No.</label>
								<input type="search" id="keyword" name="keyword" placeholder="Search By Vehicle No." value="<?php echo $this->input->get('keyword') ? $this->input->get('keyword') : ''; ?>" autocomplete="off" class="form-control">
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-2">
								<label>Alloted To</label>
								<select name="alloted_user" class="form-select select2 select2-ajax" data-filter-type="alloted_user" data-selected="<?php echo $this->input->get('alloted_user'); ?>">
									<option value="">[Any Alloted]</option>
									<?php if ($this->input->get('alloted_user')) {
										$allotedUserId = $this->input->get('alloted_user');
										$allotedUserName = employeeDetailHelper($allotedUserId);
									?>
										<option value="<?php echo $allotedUserId; ?>" selected>
											<?php echo $allotedUserName->full_name; ?>
										</option>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-2">
								<label>Type</label>
								<select name="vehicle_type" class="form-control select2">
									<option value="">[Any Vehicle Type]</option>
									<option value="bike" <?php echo ($this->input->get('vehicle_type') == 'bike') ? "selected" : ""; ?>>Bike</option>
									<option value="car" <?php echo ($this->input->get('vehicle_type') == 'car') ? "selected" : ""; ?>>Car</option>
								</select>
							</div>
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-2">
								<label>Make</label>
								<select name="vehicle_make" class="form-control select2">
									<option value="">[Any Make]</option>
									<?php foreach (makeList() as $vmake) { ?>
										<option value="<?php echo $vmake->id; ?>" <?php echo ($this->input->get('vehicle_make') == $vmake->id) ? "selected" : ""; ?>><?php echo $vmake->make_name; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-2">
								<label>Model</label>
								<select name="vehicle_model" class="form-control select2 select2-ajax" data-filter-type="vehicle_model" data-selected="<?php echo $this->input->get('vehicle_model'); ?>">
									<option value="">[Any Model]</option>
									<?php if ($this->input->get('vehicle_model')) { ?>
										<option value="<?php echo $this->input->get('vehicle_model'); ?>" selected>
											<?php echo $this->input->get('vehicle_model'); ?>
										</option>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-2">
								<label class="control-label" for="vehicle_color">Color </label>
								<select name="vehicle_color" class="form-control select2">
									<option value="">[Any Color]</option>
									<?php foreach (colorList() as $color) { ?>
										<option value="<?php echo $color->id; ?>" <?php echo ($this->input->get('vehicle_color') == $color->id) ? "selected" : ""; ?>><?php echo $color->color_name; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-2">
								<label>Sequel No.</label>
								<select name="sequel_no" class="form-control select2 select2-ajax" data-filter-type="sequel_no" data-selected="<?php echo $this->input->get('sequel_no'); ?>">
									<option value="">[Any Sequel No.]</option>
									<?php if ($this->input->get('sequel_no')) { ?>
										<option value="<?php echo $this->input->get('sequel_no'); ?>" selected>
											<?php echo $this->input->get('sequel_no'); ?>
										</option>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-2">
								<label>Year</label>
								<select name="vehicle_year" class="form-control select2">
									<option value="">[Any Year]</option>
									<?php
									//$year_start  = 2001;
									$year_start  = (date('Y') - 20);
									$year_end = date('Y'); // current Year
									$vehicle_year = $this->input->get('vehicle_year'); // user selected date

									for ($i_year = $year_end; $i_year >= $year_start; $i_year--) {
										$selected = ($vehicle_year == $i_year ? ' selected' : '');
										echo '<option value="' . $i_year . '"' . $selected . '>' . $i_year . '</option>' . "\n";
									}
									?>
								</select>
							</div>
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-2">
								<label>Status</label>
								<select name="status" class="form-select select2">
									<option value="">[Any Status]</option>
									<option value="">Select Status</option>
									<option value="active" <?php echo ($this->input->get('status') == 'active') ? "selected" : ""; ?>>Active</option>
									<option value="inactive" <?php echo ($this->input->get('status') == 'inactive') ? "selected" : ""; ?>>Inactive</option>
									<option value="discontinued" <?php echo ($this->input->get('status') == 'discontinued') ? "selected" : ""; ?>>Discontinued</option>
									<option value="workshop" <?php echo ($this->input->get('status') == 'workshop') ? "selected" : ""; ?>>Workshop</option>
								</select>
							</div>
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-2">
								<label>Vehicle Ownership</label>
								<select name="vehicle_ownership" class="form-control select2">
									<option value="">[Any Ownership]</option>
									<option value="Owned" <?php echo ($this->input->get('vehicle_ownership') == 'Owned') ? "selected" : ""; ?>>Owned</option>
									<option value="Lease" <?php echo ($this->input->get('vehicle_ownership') == 'Lease') ? "selected" : ""; ?>>Lease</option>
								</select>
							</div>
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-2">
								<label>Select Owner</label>
								<select class="form-select" name="owner_select">
									<option value="">Select Vehicle Owner</option>
									<?php foreach ($sponsors as $sponsor) : ?>
										<option value="<?= $sponsor->employer_name ?>" 
											data-cr_no="<?= $sponsor->employer_cr_no; ?>">
											<?= $sponsor->employer_name ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-2">
								<label>Added Date (From and To)</label>
								<div class="input-daterange input-group" id="datepicker6" data-date-format="dd-m-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
									<input type="text" class="form-control" id="_from" name="from" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" autocomplete="off" placeholder="Start Date" />
									<input type="text" class="form-control" id="_to" name="to" value="<?php echo $this->input->get('to') ? $this->input->get('to') : ''; ?>" autocomplete="off" placeholder="End Date" />
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<a href="<?php echo base_url('admin/master-vehicle/list'); ?>" type="button" class="btn btn-secondary">Cancel</a>
				<button type="submit" form="applyFiltersBtn" class="btn btn-custom-success">Apply Filters</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php $this->load->view('admin/home/footer'); ?>
<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>

<script>
	$(document).ready(function() {
		$('#perPageSelect').on('click change', function(event) {
			event.stopPropagation(); // Prevent dropdown from closing
		});
	});

	$(document).ready(function() {

		let currentPage = 0;
		let table;

		function getQueryParams() {
			const params = new URLSearchParams(window.location.search);
			let filters = {};

			for (const [key, value] of params.entries()) {
				filters[key] = value;
			}
			return filters;
		}

		function initializeDataTable() {

			if ($.fn.DataTable.isDataTable('#vehicleTable')) {
				$('#vehicleTable').DataTable().destroy();
			}

			let filters = getQueryParams();

			table = $('#vehicleTable').DataTable({
				serverSide: true,
				processing: true,
				ajax: {
					url: "<?php echo base_url(); ?>admin/master-vehicle/ajax-list?filters=" + encodeURIComponent(JSON.stringify(filters)),
					type: "POST",
					data: function(d) {
						let searchVal = $('#searchInput').val();
						d.search = searchVal;
						d.keyword = searchVal;
						d.length = $('#perPageSelect').val();
						d.start = currentPage * d.length;
					},
					dataSrc: function(json) {
						updatePagination(json.recordsTotal, json.data.length);
						checkFilters();
						return json.data;
					}
				},
				paging: false,
				searching: false,
				lengthChange: false,
				ordering: false,
				info: false,
				responsive: false,
				fixedHeader: true,
			});
		}

		function updatePagination(totalRecords, currentRecords) {
			const perPage = parseInt($('#perPageSelect').val());
			const totalPages = Math.ceil(totalRecords / perPage);
			const maxVisiblePages = 5;
			let paginationHTML = `<ul class="pagination justify-content-center mb-0">`;

			paginationHTML += `<li class="page-item ${currentPage === 0 ? 'disabled' : ''}">
				<a class="page-link pagination-link" href="#" data-page="${currentPage - 1}">«</a>
			</li>`;

			let startPage = Math.max(currentPage - Math.floor(maxVisiblePages / 2), 0);
			let endPage = startPage + maxVisiblePages - 1;

			if (endPage >= totalPages) {
				endPage = totalPages - 1;
				startPage = Math.max(endPage - maxVisiblePages + 1, 0);
			}

			if (startPage > 0) {
				paginationHTML += `<li class="page-item"><a class="page-link pagination-link" data-page="0">1</a></li>`;
				if (startPage > 1) paginationHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
			}

			for (let i = startPage; i <= endPage; i++) {
				paginationHTML += `<li class="page-item ${i === currentPage ? 'active' : ''}">
					<a class="page-link pagination-link" data-page="${i}">${i + 1}</a>
				</li>`;
			}

			if (endPage < totalPages - 1) {
				if (endPage < totalPages - 2) paginationHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
				paginationHTML += `<li class="page-item"><a class="page-link pagination-link" data-page="${totalPages - 1}">${totalPages}</a></li>`;
			}

			paginationHTML += `<li class="page-item ${currentPage === totalPages - 1 ? 'disabled' : ''}">
				<a class="page-link pagination-link" data-page="${currentPage + 1}">»</a>
			</li>`;

			paginationHTML += `</ul>`;

			$('#paginationLinks').html(paginationHTML);
			$('#paginationInfo').text(`Showing ${currentRecords} of ${totalRecords} entries`);
		}

		// -------------------------------
		// Reset Filter Visibility Handler
		// -------------------------------
		function checkFilters() {

			const search = $('#searchInput').val().trim();
			const urlParams = new URLSearchParams(window.location.search);

			let anyFilterApplied =
				search !== "" ||
				urlParams.toString() !== ""; // URL filter mode

			if (anyFilterApplied) {
				$('#resetFilters').show();
			} else {
				$('#resetFilters').hide();
			}
		}

		// -------------------------------
		// Event Bindings
		// -------------------------------

		$('#searchInput').on('input', function() {
			$('#keyword').val($(this).val());
			currentPage = 0;
			$('#clearSearch').toggle($(this).val().trim().length > 0);
			table.ajax.reload();
			checkFilters();
		});

		$('#keyword').on('input', function() {
			$('#searchInput').val($(this).val());
			$('#clearSearch').toggle($(this).val().trim().length > 0);
			checkFilters();
		});

		$('#applyFiltersBtn').on('click', function() {
			$('#searchInput').val($('#keyword').val());
			currentPage = 0;
			table.ajax.reload();
			checkFilters();
		});

		$('#perPageSelect').on('change', function() {
			currentPage = 0;
			table.ajax.reload();
			checkFilters();
		});

		$(document).on('click', '.pagination-link', function(e) {
			e.preventDefault();
			let page = $(this).data('page');
			if (page >= 0) {
				currentPage = page;
				table.ajax.reload();
				checkFilters();
			}
		});

		$('#clearSearch').on('click', function() {
			$('#searchInput').val('');
			$(this).hide();
			table.ajax.reload();
			checkFilters();
		});

		$('#resetFilters').click(function() {
			window.location.href = "<?php echo base_url('admin/master-vehicle/list'); ?>";
		});

		// Initialize on page load
		initializeDataTable();
		checkFilters();

	});

	function quickView(van_no) {
		if (van_no !== '' || van_no == undefined) {
			$.ajax({
				type: "post",
				url: "<?php echo base_url('admin/master-vehicle/quick-log-list'); ?>",
				data: {
					'vehicle_no': van_no
				},
				//dataType: "json",
				success: function(response) {
					console.log(response);
					$('.log-detail-modal').modal('show');
					$('#summary_body_modal').html(response);
				},
				error: function(request, error) {
					console.log(" Can't do because: " + JSON.stringify(request));
					$('#summary_body_modal').after(JSON.stringify(request));
				},
			});
		} else {
			alert('Invalid request id!');
		}
	}

	function allotmentPopup(identifier) {
		let id = $(identifier).data('id');
		let type = $(identifier).data('type');
		if (id > 0) {
			$.ajax({
				type: "post",
				url: "<?php echo base_url('admin/master-vehicle/allotment-form'); ?>",
				data: {
					'id': id,
					'type': type
				},
				//dataType: "json",
				success: function(response) {
					//console.log(response);
					$('.allotment-modal').modal('show');
					$('.allotment-modal .modal-content').html(response);
				},
				error: function(request, error) {
					console.log(" Can't do because: " + JSON.stringify(request));
					toastr.error(JSON.stringify(request));
				},
			});
		} else {
			alert('Invalid request id!');
		}
	}

	function parkingPopup(identifier) {
		let id = $(identifier).data('id');
		if (id > 0) {
			$.ajax({
				type: "post",
				url: "<?php echo base_url('admin/master-vehicle/parking-allotment-form'); ?>",
				data: {
					'id': id
				},
				//dataType: "json",
				success: function(response) {
					//console.log(response);
					$('.allotment-modal').modal('show');
					$('.allotment-modal .modal-content').html(response);
				},
				error: function(request, error) {
					console.log(" Can't do because: " + JSON.stringify(request));
					toastr.error(JSON.stringify(request));
				},
			});
		} else {
			alert('Invalid request id!');
		}
	}

	function addVehiclePopup() {
		$.ajax({
			type: "get",
			url: "<?php echo base_url('admin/master-vehicle/add-vehicle'); ?>",
			success: function(response) {
				// Show modal and inject HTML
				$('.allotment-modal').modal('show');
				$('.allotment-modal .modal-content').html(response);

				// Initialize Select2 on any desired select fields
				$('.allotment-modal .select2').select2({
					width: '100%', // Ensures proper width
					dropdownParent: $('.allotment-modal') // Fixes dropdown appearing under modals
				});
			},
			error: function(request, error) {
				console.log("Can't do because: " + JSON.stringify(request));
				toastr.error("Error loading vehicle form.");
			}
		});
	}

	function editVehiclePopup(id) {
		if(id > 0){
			$.ajax({
				type: "get",
				url: "<?php echo base_url('admin/master-vehicle/edit-vehicle'); ?>/" + id, 
				success: function(response) {
					$('.allotment-modal').modal('show');
					$('.allotment-modal .modal-content').html(response);

					// Initialize select2
					$('.allotment-modal .select2').select2({
						width: '100%',
						dropdownParent: $('.allotment-modal')
					});
				},
				error: function(request, error) {
					console.log("Can't do because: " + JSON.stringify(request));
					toastr.error("Error loading vehicle form.");
				}
			});
		}else{
			toastr.error("Invalid request ID!");
		}
	}

	function getColumnForm() {
		$.ajax({
			url: "<?php echo base_url('admin/manage-column/get-column-form'); ?>",
			method: 'GET',
			data: {
				request_type: 'vehicles'
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
</script>
<!-- Global AJAX Function for all filters -->
<script type="text/javascript">
	$('.select2-ajax').each(function() {
		var $this = $(this);
		var filterType = $this.data('filter-type');
		var selectedValue = $this.data('selected'); // Get selected value from data attribute

		$this.select2({
			placeholder: '[Any ' + filterType.charAt(0).toUpperCase() + filterType.slice(1) + ']',
			minimumInputLength: 2,
			ajax: {
				url: '<?php echo base_url('admin/master-vehicle/fetch-filter-data'); ?>',
				dataType: 'json',
				delay: 250,
				data: function(params) {
					return {
						query: params.term,
						filter_type: filterType
					};
				},
				processResults: function(data) {
					var results = $.map(data, function(item) {
						var textField = '';

						// Map the correct field based on filter type
						if (filterType === 'vehicle_no') {
							textField = item.vehicle_no;
						} else if (filterType === 'sequel_no') {
							textField = item.sequel_no;
						} else if (filterType === 'vehicle_model') {
							textField = item.vehicle_model;
						} else if (filterType === 'vehicle_year') {
							textField = item.year_name;
						} else if (filterType === 'alloted_user') {
							textField = item.full_name;
						}

						return {
							id: item.key_value, // Use key_value or actual ID field from DB
							text: textField
						};
					});
					return {
						results: results
					};
				},
				cache: true
			}
		});

		// Ensure the selected value is retained after refresh
		var selectedValue = $this.data('selected');
		if (selectedValue) {
			$this.val(selectedValue).trigger('change');
		}
	});

	$(document).ready(function() {
		$('#exportExcelBtn').on('click', function(e) {
			e.preventDefault();

			// Build query string from current filter values
			let params = {
				vehicle_no: $('input[name="vehicle_no"]').val(),
				sequel_no: $('input[name="sequel_no"]').val(),
				vehicle_type: $('select[name="vehicle_type"]').val(),
				vehicle_make: $('select[name="vehicle_make"]').val(),
				vehicle_model: $('select[name="vehicle_model"]').val(),
				vehicle_color: $('select[name="vehicle_color"]').val(),
				vehicle_year: $('select[name="vehicle_year"]').val(),
				status: $('select[name="status"]').val(),
				alloted_user: $('select[name="alloted_user"]').val(),
				vehicle_ownership: $('select[name="vehicle_ownership"]').val(),
				owner_select: $('select[name="owner_select"]').val(),
				from: $('input[name="from"]').val(),
				to: $('input[name="to"]').val()
			};

			// Convert params to URL query string
			let queryString = $.param(params);

			// Redirect to export URL with query params
			let exportUrl = "<?php echo base_url('admin/master-vehicle/export-excel'); ?>?" + queryString;
			window.open(exportUrl, '_blank');
		});
	});

	$(document).ready(function() {
		var $ownerSelect = $('select[name="owner_select"]');
		var $vehicleOwnership = $('select[name="vehicle_ownership"]');

		// Backup all sponsor options (except the placeholder)
		var sponsorOptions = $ownerSelect.find('option').not(':first').clone();

		// Get owner from PHP GET for pre-selection
		var selectedOwner = "<?php echo $this->input->get('owner_select', true); ?>";

		function updateOwnerOptions() {
			var ownership = $vehicleOwnership.val();

			$ownerSelect.empty();
			$ownerSelect.append('<option value="">Any Owner</option>');

			if (ownership === 'Lease') {
				var theebOption = sponsorOptions.filter(function() {
					return $(this).val().trim() === 'Theeb Rent a Car';
				});

				if (theebOption.length > 0) {
					var cloned = theebOption.clone();
					$ownerSelect.append(cloned);
				} else {
					$ownerSelect.append('<option value="Theeb Rent a Car">Theeb Rent a Car</option>');
				}

				$ownerSelect.val('Theeb Rent a Car');
				$ownerSelect.prop('readonly', true);

			} else if (ownership === 'Owned') {
				$ownerSelect.append(sponsorOptions.clone());
				
				if (selectedOwner !== '') {
					$ownerSelect.val(selectedOwner);
				}

				$ownerSelect.prop('readonly', false);

			} else {
				// No ownership selected or unhandled type
				$ownerSelect.prop('readonly', true);
			}
		}

		// Trigger update when vehicle ownership changes
		$vehicleOwnership.on('change', function() {
			updateOwnerOptions();
		});

		// Run once on page load
		updateOwnerOptions();
	});
</script>