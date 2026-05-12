<?php $this->load->view('admin/home/header'); ?>
<style>
	.dataTables_wrapper::-webkit-scrollbar {
		display: none;
	}

	.nav-md .container.body .right_col {
		padding: 10px 10px 0;
		margin-left: 230px;
	}
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>CV Master</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/hr/recruitment/cv">CV</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if (check_action_permission(get_user_role(), 'manage_cv', 'delete_cv')): ?>
						<button type="button" class="btn btn-custom-danger btn-sm pull-right me-2" onclick="deleteAction()" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					<?php endif;
					if (check_action_permission(get_user_role(), 'manage_cv', 'cvExport') || check_action_permission(get_user_role(), 'manage_cv', 'cvExportMedical')): ?>
						<div class="btn-group ms-2 float-end">
							<button class="btn btn-custom-white btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fas fa-file-export"></i> Export Reports <i class="mdi mdi-chevron-down"></i>
							</button>
							<div class="dropdown-menu dropdown-menu-end">
								<?php if (check_action_permission(get_user_role(), 'manage_cv', 'cvExport')): ?>
									<a id="export-btn" class="dropdown-item btn" target="_blank">
										<i class="fas fa-file-excel me-2"></i>Export Excel Report
									</a>
								<?php endif;
								if (check_action_permission(get_user_role(), 'manage_cv', 'cvExportMedical')): ?>
									<div class="dropdown-divider"></div>
									<a id="export-iqama-btn" class="dropdown-item btn" target="_blank">
										<i class="fas fa-file-excel me-2"></i>Export Iqama Medical
									</a>
								<?php endif; ?>
							</div>
						</div>
					<?php endif;
					if (check_action_permission(get_user_role(), 'manage_cv', 'add_cv')): ?>
						<a class="btn btn-custom-success btn-sm pull-right me-1" title="Add New CV" href="<?php echo base_url('admin/hr/recruitment/cv/add') ?>"><i class="fa fa-plus"></i> Add New CV</a>
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
						<!-- <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button></div> -->
					<?php } else { ?>
						<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong><?php echo $msg_data; ?></strong>
						</div>
						<!-- <div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button></div> -->
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
					<div class="card-header">
						<h4 class="header-title mb-0">Search</h4>
					</div>
					<div class="card-body">
						<form action="<?php echo base_url('admin/hr/recruitment/cv'); ?>" method="get" id="filter_form">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Search Applicant Name or CV No.</label>
										<input type="search" id="keyword" name="keyword" placeholder="Enter name or cv number" value="<?php echo $this->input->get('keyword') ? $this->input->get('keyword') : ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>

								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label class="control-label" for="applicant_type">Applicant Type </label>
										<select name="applicant_type" id="applicant_type" class="form-select">
											<option value="">[Any Type]</option>
											<option value="Fresher" <?php echo ($this->input->get('applicant_type') == 'Fresher') ? 'selected' : '' ?>>Fresher</option>
											<option value="Saudi Return" <?php echo ($this->input->get('applicant_type') == 'Saudi Return') ? 'selected' : '' ?>>Saudi Return</option>
											<option value="GCC Return" <?php echo ($this->input->get('applicant_type') == 'GCC Return') ? 'selected' : '' ?>>GCC Return</option>
										</select>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label class="control-label" for="applied_for">Position Applied For </label>
										<select style="height:410px;" name="applied_for" id="applied_for" class="form-control select2">
											<option value="">[Any Position]</option>
											<?php foreach ($positions as $pos) { ?>
												<option value="<?php echo $pos->id; ?>" <?php echo ($pos->id == $this->input->get('applied_for')) ? 'selected' : '' ?>><?php echo $pos->name; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<?php
								$adv_show = false;
								if (!empty($this->input->get('from')) || !empty($this->input->get('to')) || !empty($this->input->get('cv_status')) || !empty($this->input->get('medical_status')) || !empty($this->input->get('interview_status')) || !empty($this->input->get('agency_name')) || !empty($this->input->get('arrival_from')) || !empty($this->input->get('arrival_to')) || !empty($this->input->get('sponsor_id')) || !empty($this->input->get('nationality'))) {
									$adv_show = true;
								}
								?>
								<div class="collapse <?php if ($adv_show) {
															echo ' show';
														} ?>" id="advanceFilter">
									<div class="row">
										<div class="col-lg-4 col-md-4 col-sm-12">
											<div class="form-group mb-2">
												<label>Date Between (From and To)</label>
												<div class="input-daterange input-group" id="datepicker6" data-date-format="dd-m-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
													<input type="text" class="form-control" id="_from" name="from" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" autocomplete="off" placeholder="Start Date" />
													<input type="text" class="form-control" id="_to" name="to" value="<?php echo $this->input->get('to') ? $this->input->get('to') : ''; ?>" autocomplete="off" placeholder="End Date" />
												</div>
											</div>
										</div>

										<div class="col-lg-4 col-md-4 col-sm-12">
											<div class="form-group mb-2">
												<label class="d-block">Select CV Status </label>
												<select name="cv_status" class="form-select">
													<option value="">[Any CV Status]</option>
													<option value="new" <?php echo ($this->input->get('cv_status') == 'new') ? 'selected' : ''; ?>>New</option>
													<option value="shortlisted" <?php echo ($this->input->get('cv_status') == 'shortlisted') ? 'selected' : ''; ?>>Shortlisted</option>
													<option value="not_qualified" <?php echo ($this->input->get('cv_status') == 'not_qualified') ? 'selected' : ''; ?>>Not Qualified</option>
												</select>
											</div>
										</div>

										<div class="col-lg-4 col-md-4 col-sm-12">
											<div class="form-group mb-2">
												<label class="d-block">Select Medical Status </label>
												<select name="medical_status" class="form-select">
													<option value="">[Any Medical Status]</option>
													<option value="Medical Done - Fit to Work" <?php echo ($this->input->get('medical_status') == 'Medical Done - Fit to Work') ? 'selected' : '' ?>>Medical Done - Fit to Work</option>
													<option value="Medical Done - Unfit to Work" <?php echo ($this->input->get('medical_status') == 'Medical Done - Unfit to Work') ? 'selected' : '' ?>>Medical Done - Unfit to Work</option>
												</select>
											</div>
										</div>

										<div class="col-lg-4 col-md-4 col-sm-12">
											<div class="form-group mb-2">
												<label class="d-block">Select Interview Status </label>
												<select name="interview_status" class="form-select">
													<option value="">[Any Interview Status]</option>
													<option value="selected" <?php echo ($this->input->get('interview_status') == 'selected') ? 'selected' : '' ?>>Selected</option>
													<option value="rejected" <?php echo ($this->input->get('interview_status') == 'rejected') ? 'selected' : '' ?>>Rejected</option>
												</select>
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-12">
											<div class="form-group mb-2">
												<label class="control-label" for="agency_name">Hiring Agency </label>
												<select style="height:410px;" name="agency_name" id="agency_name" class="form-control select2">
													<option value="">[Any Hiring Agency]</option>
													<?php foreach (agencyListHelper() as $agency) { ?>
														<option value="<?php echo $agency->id; ?>" <?php echo ($agency->id == $this->input->get('agency_name')) ? 'selected' : '' ?>><?php echo $agency->agency_name; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-12">
											<div class="form-group mb-2">
												<label>Arrival Between (From and To)</label>
												<div class="input-daterange input-group" id="datepicker6" data-date-format="dd-m-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
													<input type="text" class="form-control" id="arrival_from" name="arrival_from" value="<?php echo $this->input->get('arrival_from') ? $this->input->get('arrival_from') : ''; ?>" autocomplete="off" placeholder="Arrival Date" />
													<input type="text" class="form-control" id="arrival_to" name="arrival_to" value="<?php echo $this->input->get('arrival_to') ? $this->input->get('arrival_to') : ''; ?>" autocomplete="off" placeholder="Arrival Date" />
												</div>
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-12">
											<div class="form-group mb-2">
												<label>Sponsor ID</label>
												<input type="search" id="sponsor_id" name="sponsor_id" placeholder="Enter Sponsor ID" value="<?php echo $this->input->get('sponsor_id') ? $this->input->get('sponsor_id') : ''; ?>" autocomplete="off" class="form-control">
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-12">
											<div class="form-group mb-2">
												<label class="control-label" for="nationality">Nationality </label>
												<select name="nationality" id="nationality" class="form-control select2">
													<option value="">[Any Nationality]</option>
													<?php foreach (nationalityList() as $mnationality) { ?>
														<option value="<?php echo $mnationality->name; ?>" <?php echo ($mnationality->name == $this->input->get('nationality')) ? 'selected' : '' ?>><?php echo $mnationality->name; ?></option>
													<?php } ?>
												</select>
											</div>
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
									<a href="<?php echo base_url('admin/hr/recruitment/cv'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
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
							<table id="store-table" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
								<thead style="white-space: nowrap;">
									<tr>
										<th>#</th>
										<th>#</th>
										<th>CV No</th>
										<th>Full Name</th>
										<th>Nationality</th>
										<th>Age</th>
										<th>Passport No.</th>
										<th>Position Applied For</th>
										<th>Agency Name</th>
										<th>Sponsor ID</th>
										<th>Border No.</th>
										<th>Arrival Date</th>
										<th>Candidate Status</th>
										<th>Interview Status</th>
										<th>Offer Status</th>
										<th>Arrival Status</th>
										<th>Created At</th>
										<th>Action</th>
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

<?php $this->load->view('admin/home/footer'); ?>

<div class="modal fade upload-image-modal" role="dialog" aria-labelledby="ModalFullscreenLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title mt-0" id="summaryModalFullscreenLabel">Upload</h6>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" id="summary_body_modal">

			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
	$(document).ready(function() {
		$('#store-table').dataTable({
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
				url: "<?php echo base_url(); ?>admin/hr/recruitment/cv-ajax?keyword=<?php echo $this->input->get('keyword') ?>&applicant_type=<?php echo $this->input->get('applicant_type') ?>&applied_for=<?php echo $this->input->get('applied_for') ?>&from=<?php echo $this->input->get('from') ?>&to=<?php echo $this->input->get('to') ?>&cv_status=<?php echo $this->input->get('cv_status') ?>&medical_status=<?php echo $this->input->get('medical_status') ?>&interview_status=<?php echo $this->input->get('interview_status') ?>&agency_name=<?php echo $this->input->get('agency_name') ?>&arrival_from=<?php echo $this->input->get('arrival_from') ?>&arrival_to=<?php echo $this->input->get('arrival_to') ?>&sponsor_id=<?php echo $this->input->get('sponsor_id') ?>&nationality=<?php echo $this->input->get('nationality') ?>",
				type: "POST"
			},
			"columnDefs": [{
				"targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17],
				"orderable": false
			}, ],
		});
	});

	function deleteAction() {
		var inputCount = $('[name="checklist[]"]:checked').length;
		if (inputCount > 0) {
			if (confirm("Do you want to delete selected cv data?") == true) {
				changeActionAndSubmit('admin/hr/recruitment/cv/delete');
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

	function uploadCertificate(identifier) {
		let id = $(identifier).data('id');
		let type = $(identifier).data('type');
		if (id > 0) {
			$.ajax({
				type: "post",
				url: "<?php echo base_url('admin/hr/recruitment/cv/upload-form'); ?>",
				data: {
					'id': id,
					'type': type
				},
				//dataType: "json",
				success: function(response) {
					console.log(response);
					$('.upload-image-modal').modal('show');
					$('#summary_body_modal').html(response);
					$('#summaryModalFullscreenLabel').html('UPLOAD ' + type.toUpperCase());
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

	$(document).ready(function() {
		$('#export-btn').on('click', function(e) {
			e.preventDefault(); // Prevent the default behavior

			// Get all selected checkbox values
			var selectedIds = [];
			$('input[name="checklist[]"]:checked').each(function() {
				selectedIds.push($(this).val());
			});

			// Construct the query string for selected IDs
			var selectedIdsQuery = selectedIds.map(id => `checklist[]=${id}`).join('&');
			// Construct the full export URL with the selected IDs and other parameters
			var exportUrl = "<?php echo base_url(); ?>admin/hr/recruitment/cv/export-excel?keyword=<?php echo $this->input->get('keyword') ?>&applicant_type=<?php echo $this->input->get('applicant_type') ?>&applied_for=<?php echo $this->input->get('applied_for') ?>&from=<?php echo $this->input->get('from') ?>&to=<?php echo $this->input->get('to') ?>&cv_status=<?php echo $this->input->get('cv_status') ?>&medical_status=<?php echo $this->input->get('medical_status') ?>&interview_status=<?php echo $this->input->get('interview_status') ?>&agency_name=<?php echo $this->input->get('agency_name') ?>&arrival_from=<?php echo $this->input->get('arrival_from') ?>&arrival_to=<?php echo $this->input->get('arrival_to') ?>&sponsor_id=<?php echo $this->input->get('sponsor_id') ?>&nationality=<?php echo $this->input->get('nationality') ?>";

			// Append selected IDs to the URL
			if (selectedIdsQuery) {
				exportUrl += '&' + selectedIdsQuery;
			}

			// Redirect to the export URL
			window.open(exportUrl, '_blank');
		});

		$('#export-iqama-btn').on('click', function(e) {
			e.preventDefault(); // Prevent the default behavior

			// Get all selected checkbox values
			var selectedIds = [];
			$('input[name="checklist[]"]:checked').each(function() {
				selectedIds.push($(this).val());
			});

			// Construct the query string for selected IDs
			var selectedIdsQuery = selectedIds.map(id => `checklist[]=${id}`).join('&');
			// Construct the full export URL with the selected IDs and other parameters
			var exportUrl = "<?php echo base_url(); ?>admin/hr/recruitment/cv/export-iqama-excel?keyword=<?php echo $this->input->get('keyword') ?>&applicant_type=<?php echo $this->input->get('applicant_type') ?>&applied_for=<?php echo $this->input->get('applied_for') ?>&from=<?php echo $this->input->get('from') ?>&to=<?php echo $this->input->get('to') ?>&cv_status=<?php echo $this->input->get('cv_status') ?>&medical_status=<?php echo $this->input->get('medical_status') ?>&interview_status=<?php echo $this->input->get('interview_status') ?>&agency_name=<?php echo $this->input->get('agency_name') ?>&arrival_from=<?php echo $this->input->get('arrival_from') ?>&arrival_to=<?php echo $this->input->get('arrival_to') ?>&sponsor_id=<?php echo $this->input->get('sponsor_id') ?>&nationality=<?php echo $this->input->get('nationality') ?>";

			// Append selected IDs to the URL
			if (selectedIdsQuery) {
				exportUrl += '&' + selectedIdsQuery;
			}

			// Redirect to the export URL
			window.open(exportUrl, '_blank');
		});
	});
</script>