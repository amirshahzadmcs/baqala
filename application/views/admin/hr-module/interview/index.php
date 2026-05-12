<?php $this->load->view('admin/home/header'); ?>
<style>
	th {
		white-space: nowrap;
	}

	#interviewTable td {
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

	#interviewTable thead {
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
					<h4>Interview Form</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/hr/recruitment/interview'); ?>">Interview</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if (check_action_permission(get_user_role(), 'manage_interview', 'delete_interview')): ?>
					<button type="button" class="btn btn-custom-danger btn-sm pull-right me-2" onclick="deleteAction()" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					<?php endif;
					if (check_action_permission(get_user_role(), 'manage_interview', 'addInterviewForm')): ?>
					<button class="btn btn-custom-success btn-sm pull-right" title="Add" onclick="addInterviewPopup()"><i class="fa fa-plus"></i> Add Interview</button>
					<?php endif; ?>
					<div class="btn-group float-end ms-2">
						<button class="btn btn-custom-white btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="ti-export"></i> Export <i class="mdi mdi-chevron-down"></i>
						</button>
						<div class="dropdown-menu dropdown-menu-end">
							<h6 class="dropdown-header">EXPORT AS</h6>
							<?php if (check_action_permission(get_user_role(), 'manage_interview', 'addInterviewForm')): ?>
								<a type="button" class="dropdown-item" title="Interview List" id="export-btn">Interview List (Excel)</a>
								<div class="dropdown-divider"></div>
							<?php endif;?>
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
									<table id="interviewTable" class="table table-striped" style="width:100%">
										<thead class="text-center">
											<tr>
												<th>#</th>
												<th>S.No.</th>
												<?php
													if (!empty($visibleTableColumns)) {
														foreach ($visibleTableColumns as $column) {
															if ($column == 'id') continue; // ✅ Skip rendering ID in header
															$styleSet = ($column == 'order_date') ? "align='center'" : " align='center'";
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
				<h5 class="modal-title px-3" id="filtersModalLabel">Interview Filters</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url('admin/hr/recruitment/interview'); ?>" method="get" id="applyFiltersBtn">
					<div class="row">
						<div class="col-md-12 mb-3">
							<label for="filterRange">Select Interview Date Range</label>
							<div id="filterRange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
								<i class="fa fa-calendar"></i>&nbsp;
								<span></span> <i class="fa fa-caret-down"></i>
							</div>
							<input type="hidden" name="date_from" id="filter_start_date" value="<?php echo $this->input->get('date_from'); ?>">
							<input type="hidden" name="date_to" id="filter_end_date" value="<?php echo $this->input->get('date_to'); ?>">
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-3">
								<label>Applicant Name / Interview No. / IBAN No. / DL No.</label>
								<input type="search" id="keyword" name="keyword" placeholder="Search By Applicant Name / Interview No." value="<?php echo $this->input->get('keyword') ? $this->input->get('keyword') : ''; ?>" autocomplete="off" class="form-control">
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-3">
								<label class="control-label" for="filter_status">Status </label>
								<select name="status" id="filter_status" class="form-select">
									<option value="">[ Any Status ]</option>
									<option value="Screening" <?php echo ($this->input->get('status') == 'Screening') ? 'selected' : ''; ?>>Screening</option>
									<option value="Phone Interview" <?php echo ($this->input->get('status') == 'Phone Interview') ? 'selected' : ''; ?>>Phone Interview</option>
									<option value="Onsite Interview" <?php echo ($this->input->get('status') == 'Onsite Interview') ? 'selected' : ''; ?>>Onsite Interview</option>
									<option value="Rejected" <?php echo ($this->input->get('status') == 'Rejected') ? 'selected' : ''; ?>>Rejected</option>
									<option value="Document Verification" <?php echo ($this->input->get('status') == 'Document Verification') ? 'selected' : ''; ?>>Document Verification</option>
									<option value="Hold - Need Clarification" <?php echo ($this->input->get('status') == 'Hold - Need Clarification') ? 'selected' : ''; ?>>Hold - Need Clarification</option>
									<option value="Qiwa Requested" <?php echo ($this->input->get('status') == 'Qiwa Requested') ? 'selected' : ''; ?>>Qiwa Requested</option>
									<option value="Qiwa Rejected" <?php echo ($this->input->get('status') == 'Qiwa Rejected') ? 'selected' : ''; ?>>Qiwa Rejected</option>
									<option value="Resend Qiwa" <?php echo ($this->input->get('status') == 'Resend Qiwa') ? 'selected' : ''; ?>>Resend Qiwa</option>
									<option value="Onboarding" <?php echo ($this->input->get('status') == 'Onboarding') ? 'selected' : ''; ?>>Onboarding</option>
									<option value="Hired" <?php echo ($this->input->get('status') == 'Hired') ? 'selected' : ''; ?>>Hired</option>
								</select>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-3">
								<label class="control-label" for="applied_for">Position Applied For </label>
								<select style="height:410px;" name="applied_for" id="filter_applied_for" class="form-control select2">
									<option value="">[Any Position]</option>
									<?php foreach ($positions as $pos) { ?>
										<option value="<?php echo $pos->id; ?>" <?php echo ($pos->id == $this->input->get('applied_for')) ? 'selected' : '' ?>><?php echo $pos->name; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-3">
								<label class="control-label" for="filter_nationality">Nationality </label>
								<select name="nationality" id="filter_nationality" class="form-control select2">
                                    <option value="">[Any Nationality]</option>
                                    <?php foreach(nationalityList() as $nationality){?>
                                    <option value="<?php echo $nationality->id;?>" <?php echo ($nationality->id == $this->input->get('nationality')) ? 'selected' : '' ?>><?php echo $nationality->name;?></option>
                                    <?php } ?>
                                </select>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-3">
								<label for="filtr_city">Preferred City</label>
                                <select name="preferred_city" id="filtr_city" class="form-control select2">
                                    <option value="">[Any City]</option>
                                    <?php foreach(selectedCitiesHelp(6) as $city){?>
                                    <option value="<?php echo $city->id;?>" <?php echo ($city->id == $this->input->get('preferred_city')) ? 'selected' : '' ?>><?php echo $city->city_name;?></option>
                                    <?php } ?>
                                </select>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-3">
								<label for="filtr_iqama_profession">Iqama Profession</label>
                                <select class="form-control form-select select2" data-parsley-allselected="true" name="iqama_profession" id="filtr_iqama_profession">
                                    <option value="">[Any Profession]</option>
                                    <?php foreach (professionList() as $profession) { ?>
                                        <option value="<?php echo $profession->id; ?>" <?php echo ($profession->id == $this->input->get('iqama_profession')) ? 'selected' : '' ?>><?php echo $profession->profession_name; ?></option>
                                    <?php } ?>
                                </select>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-3">
								<label for="filtr_no_of_transfer">No of Transfer</label>
                                <select class="form-control form-select" data-parsley-allselected="true" name="no_of_transfer" id="filtr_no_of_transfer">
                                    <option value="">[Any No. of Transfer]</option>
                                    <option value="1st - 2000" <?php echo ($this->input->get('no_of_transfer') == '1st - 2000') ? 'selected' : ''; ?>>1st - 2000</option>
                                    <option value="2nd - 4000" <?php echo ($this->input->get('no_of_transfer') == '2nd - 4000') ? 'selected' : ''; ?>>2nd - 4000</option>
                                    <option value="3rd - 6000" <?php echo ($this->input->get('no_of_transfer') == '3rd - 6000') ? 'selected' : ''; ?>>3rd - 6000</option>
                                </select>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-3">
								<label for="filtr_has_driving_license">Does he have Driving License</label>
                                <select class="form-control" data-parsley-allselected="true" name="has_driving_license" id="filtr_has_driving_license">
                                    <option value="">[Any Driving License Status]</option>
                                    <option value="yes" <?php echo ($this->input->get('has_driving_license') == 'yes') ? 'selected' : ''; ?>>Yes</option>
                                    <option value="no" <?php echo ($this->input->get('has_driving_license') == 'no') ? 'selected' : ''; ?>>No</option>
                                    <option value="home_land" <?php echo ($this->input->get('has_driving_license') == 'home_land') ? 'selected' : ''; ?>>Home Land</option>
                                </select>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-3">
								<label for="filtr_driving_license_type">Driving License Type</label>
                                <select class="form-control form-select" data-parsley-allselected="true" name="driving_license_type" id="filtr_driving_license_type">
                                    <option value="">[Any DL Type]</option>
                                    <option value="Bike" <?php echo ($this->input->get('driving_license_type') == 'Bike') ? 'selected' : ''; ?>>Bike</option>
                                    <option value="Car" <?php echo ($this->input->get('driving_license_type') == 'Car') ? 'selected' : ''; ?>>Car</option>
                                    <option value="Light Transport" <?php echo ($this->input->get('driving_license_type') == 'Light Transport') ? 'selected' : ''; ?>>Light Transport</option>
                                </select>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-3">
								<label>Driving License Expiry Date (From and To)</label>
								<div class="input-daterange input-group" id="datepicker6" data-date-format="dd-m-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
									<input type="text" class="form-control" id="driving_license_expiry_from" name="driving_license_expiry_from" value="<?php echo $this->input->get('driving_license_expiry_from') ? $this->input->get('driving_license_expiry_from') : ''; ?>" autocomplete="off" placeholder="Start Date" />
									<input type="text" class="form-control" id="driving_license_expiry_to" name="driving_license_expiry_to" value="<?php echo $this->input->get('driving_license_expiry_to') ? $this->input->get('driving_license_expiry_to') : ''; ?>" autocomplete="off" placeholder="End Date" />
								</div>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-3">
								<label>Arrival Date (From and To)</label>
								<div class="input-daterange input-group" id="datepicker6" data-date-format="dd-m-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
									<input type="text" class="form-control" id="arrival_date_from" name="arrival_date_from" value="<?php echo $this->input->get('arrival_date_from') ? $this->input->get('arrival_date_from') : ''; ?>" autocomplete="off" placeholder="Start Date" />
									<input type="text" class="form-control" id="arrival_date_to" name="arrival_date_to" value="<?php echo $this->input->get('arrival_date_to') ? $this->input->get('arrival_date_to') : ''; ?>" autocomplete="off" placeholder="End Date" />
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<a href="<?php echo base_url('admin/hr/recruitment/interview'); ?>" type="button" class="btn btn-secondary">Cancel</a>
				<button type="submit" form="applyFiltersBtn" class="btn btn-custom-success">Apply Filters</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade fixed-left interview-modal" role="dialog" aria-labelledby="ModalFullscreenLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal -->
<div class="modal fade" id="exportModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title px-3" id="exportModalLabel">Export Interview Entries</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="alert alert-info custom-export-alert" role="alert">Current filters will be applied to the exported data set.</div>
				<form id="exportForm" action="<?php echo base_url('admin/hr/recruitment/interview/export'); ?>" method="POST">
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
						<!-- <div class="col-md-12">
							<div class="form-check mb-3">
								<input class="form-check-input" type="radio" name="file_format" id="file_format_pdf" value="file_format_pdf" checked="">
								<label class="form-check-label" for="file_format_pdf">
									PDF
								</label>
								<p class="text-muted">.pdf, Portable Document Format.</p>
							</div>
						</div> -->
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
			if ($.fn.DataTable.isDataTable('#interviewTable')) {
				$('#interviewTable').DataTable().destroy();
			}

			table = $('#interviewTable').DataTable({
				"serverSide": true,
				"processing": true,
				"ajax": {
					url: "<?php echo base_url(); ?>admin/hr/recruitment/interview-ajax",
					type: "POST",
					data: function(d) {
						let searchVal = $('#searchInput').val();
						d.search = searchVal;
						d.keyword = searchVal; // same value
						d.date_from = $('input[name="date_from"]').val();
						d.date_to = $('input[name="date_to"]').val();
						d.applied_for = $('select[name="applied_for"] option:selected').val();
						d.status = $('select[name="status"] option:selected').val();
						d.nationality = $('select[name="nationality"] option:selected').val();
						d.preferred_city = $('select[name="preferred_city"] option:selected').val();
						d.iqama_profession = $('select[name="iqama_profession"] option:selected').val();
						d.no_of_transfer = $('select[name="no_of_transfer"] option:selected').val();
						d.has_driving_license = $('select[name="has_driving_license"] option:selected').val();
						d.driving_license_type = $('select[name="driving_license_type"] option:selected').val();
						d.driving_license_expiry_from = $('input[name="driving_license_expiry_from"]').val();
						d.driving_license_expiry_to = $('input[name="driving_license_expiry_to"]').val();
						d.arrival_date_from = $('input[name="arrival_date_from"]').val();
						d.arrival_date_to = $('input[name="arrival_date_to"]').val();
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
			//table.ajax.reload();
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
				const appliedFor = $('#filter_applied_for').val();
				const status = $('#filter_status').val();
				const nationality = $('#filter_nationality').val();
				const city = $('#filtr_city').val();
				const iqamaProfession = $('#filtr_iqama_profession').val();
				const noOfTransfer = $('#filtr_no_of_transfer').val();
				const hasDrivingLicense = $('#filtr_has_driving_license').val();
				const drivingLicenseType = $('#filtr_driving_license_type').val();
				const drivingLicenseExpiryFrom = $('#driving_license_expiry_from').val();
				const drivingLicenseExpiryTo = $('#driving_license_expiry_to').val();
				const arrivalDateFrom = $('#arrival_date_from').val();
				const arrivalDateTo = $('#arrival_date_to').val();

				if (search || dateFrom || dateTo || appliedFor || status || nationality || city || iqamaProfession || noOfTransfer || hasDrivingLicense || drivingLicenseType || drivingLicenseExpiryFrom || drivingLicenseExpiryTo || arrivalDateFrom || arrivalDateTo) {
					$('#resetFilters').show();
				} else {
					$('#resetFilters').hide();
				}
			}

			// Initial check
			checkFilters();

			// Run on filter change
			// $('#searchInput, #dateFrom, #dateTo, #filter_applied_for, #filter_status, #filter_nationality, #filtr_city, #filtr_iqama_profession, #filtr_no_of_transfer, #filtr_has_driving_license, #filtr_driving_license_type, #driving_license_expiry_from, #driving_license_expiry_to, #arrival_date_from, #arrival_date_to').on('input change', function() {
			// 	checkFilters();
			// });
			
			// Reset filters
			$('#resetFilters').click(function() {
				window.location.href = "<?php echo base_url('admin/hr/recruitment/interview'); ?>";
			});
		});
		
		$('.dropify').dropify();

	});

	function getColumnForm() {
		$.ajax({
			url: "<?php echo base_url('admin/manage-column/get-column-form'); ?>",
			method: 'GET',
			data: {
				request_type: 'interview_forms'
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
			if (confirm("Do you want to delete selected interview data?") == true) {
				changeActionAndSubmit('admin/hr/recruitment/interview/delete');
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
			let exportUrl = "<?php echo base_url('admin/hr/recruitment/interview/export-excel'); ?>";
			let params = [];

			// ----------------------------------------
			// Filters (same as DataTable)
			// ----------------------------------------
			let keyword     = $('#keyword').val();
			let applied_for = $('#applied_for').val();
			let date_from   = $('#date_from').val();
			let date_to     = $('#date_to').val();
			let status 		= $('#filter_status').val();
			let nationality = $('#filter_nationality').val();
			let city 		= $('#filtr_city').val();
			let iqamaProfession = $('#filtr_iqama_profession').val();
			let noOfTransfer 	= $('#filtr_no_of_transfer').val();
			let hasDrivingLicense = $('#filtr_has_driving_license').val();
			let drivingLicenseType = $('#filtr_driving_license_type').val();
			let drivingLicenseExpiryFrom = $('#driving_license_expiry_from').val();
			let drivingLicenseExpiryTo = $('#driving_license_expiry_to').val();
			let arrivalDateFrom = $('#arrival_date_from').val();
			let arrivalDateTo = $('#arrival_date_to').val();

			if (keyword)     params.push('keyword=' + encodeURIComponent(keyword));
			if (applied_for) params.push('applied_for=' + encodeURIComponent(applied_for));
			if (date_from)   params.push('from=' + encodeURIComponent(date_from));
			if (date_to)     params.push('to=' + encodeURIComponent(date_to));
			if (status)      params.push('status=' + encodeURIComponent(status));
			if (nationality)  params.push('nationality=' + encodeURIComponent(nationality));
			if (city)         params.push('preferred_city=' + encodeURIComponent(city));
			if (iqamaProfession) params.push('iqama_profession=' + encodeURIComponent(iqamaProfession));
			if (noOfTransfer)    params.push('no_of_transfer=' + encodeURIComponent(noOfTransfer));
			if (hasDrivingLicense) params.push('has_driving_license=' + encodeURIComponent(hasDrivingLicense));
			if (drivingLicenseType) params.push('driving_license_type=' + encodeURIComponent(drivingLicenseType));
			if (drivingLicenseExpiryFrom) params.push('driving_license_expiry_from=' + encodeURIComponent(drivingLicenseExpiryFrom));
			if (drivingLicenseExpiryTo) params.push('driving_license_expiry_to=' + encodeURIComponent(drivingLicenseExpiryTo));
			if (arrivalDateFrom) params.push('arrival_date_from=' + encodeURIComponent(arrivalDateFrom));
			if (arrivalDateTo) params.push('arrival_date_to=' + encodeURIComponent(arrivalDateTo));

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

	function addInterviewPopup() {
		$.ajax({
			type: "get",
			url: "<?php echo base_url('admin/hr/recruitment/interview/add'); ?>",
			success: function(response) {
				// Show modal and inject HTML
				$('.interview-modal').modal('show');
				$('.interview-modal .modal-content').html(response);

				// Initialize Select2 on any desired select fields
				$('.interview-modal .select2').select2({
					width: '100%', // Ensures proper width
					dropdownParent: $('.interview-modal') // Fixes dropdown appearing under modals
				});
			},
			error: function(request, error) {
				console.log("Can't do because: " + JSON.stringify(request));
				toastr.error("Error loading interview form.");
			}
		});
	}

	function editInterviewPopup(id) {
		$.ajax({
			type: "get",
			url: "<?php echo base_url('admin/hr/recruitment/interview/edit'); ?>?id=" + id,
			success: function(response) {
				// Show modal and inject HTML
				$('.interview-modal').modal('show');
				$('.interview-modal .modal-content').html(response);

				// Initialize Select2 on any desired select fields
				$('.interview-modal .select2').select2({
					width: '100%', // Ensures proper width
					dropdownParent: $('.interview-modal') // Fixes dropdown appearing under modals
				});
			},
			error: function(request, error) {
				console.log("Can't do because: " + JSON.stringify(request));
				toastr.error("Error loading interview form.");
			}
		});
	}

	function detailInterviewPopup(id) {
		$.ajax({
			type: "get",
			url: "<?php echo base_url('admin/hr/recruitment/interview/detail'); ?>?id=" + id,
			success: function(response) {
				// Show modal and inject HTML
				$('.interview-modal').modal('show');
				$('.interview-modal .modal-content').html(response);

				// Initialize Select2 on any desired select fields
				$('.interview-modal .select2').select2({
					width: '100%', // Ensures proper width
					dropdownParent: $('.interview-modal') // Fixes dropdown appearing under modals
				});
			},
			error: function(request, error) {
				console.log("Can't do because: " + JSON.stringify(request));
				toastr.error("Error loading interview form.");
			}
		});
	}
	
	function changeStatusPopup(id) {
		if (id > 0) {
			$.ajax({
				url: "<?php echo base_url('admin/hr/recruitment/interview/status-form'); ?>",
				type: 'POST',
				data: {
					'id': id,
				},
				dataType: 'json',
				success: function(response) {
					//console.log(response);
					if (response.type === 'success') {
						$('.interview-modal').modal('show');
						toastr.success(response.message);
						$('.interview-modal .modal-content').html(response.output_html);
					} else {
						//console.log(response);
						toastr.error(response.message);
					}
				},
				error: function(error) {
					//console.log(error);
					toastr.error('An error occurred. Please try again.');
				}
			});
		} else {
			toastr.error('Invalid request id!');
		}
	}
</script>
<script>
$(function () {

    function cb(start, end) {
        $('#filterRange span').html(
            start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY')
        );
        $('#filter_start_date').val(start.format('YYYY-MM-DD'));
        $('#filter_end_date').val(end.format('YYYY-MM-DD'));
    }

    $('#filterRange').daterangepicker({
        autoUpdateInput: false,
        locale: { cancelLabel: 'Clear' },
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [
                moment().subtract(1, 'month').startOf('month'),
                moment().subtract(1, 'month').endOf('month')
            ]
        }
    }, cb);

    // ✅ Restore from URL (GET)
    let startDate = $('#filter_start_date').val();
    let endDate   = $('#filter_end_date').val();

    if (startDate && endDate) {
        let start = moment(startDate, 'YYYY-MM-DD');
        let end   = moment(endDate, 'YYYY-MM-DD');

        $('#filterRange').data('daterangepicker').setStartDate(start);
        $('#filterRange').data('daterangepicker').setEndDate(end);
        cb(start, end);
    }

    $('#filterRange').on('cancel.daterangepicker', function () {
        $('#filterRange span').html('');
        $('#filter_start_date').val('');
        $('#filter_end_date').val('');
    });

});
</script>


