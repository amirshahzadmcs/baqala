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
					<h4>Visa Assurance</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/talent-aquisition/visa'); ?>">Visa Assurance</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if (check_action_permission(get_user_role(), 'visa', 'delete')): ?>
						<button type="button" class="btn btn-custom-danger btn-sm pull-right" onclick="deleteAction()" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					<?php endif;
					if (check_action_permission(get_user_role(), 'visa', 'save')): ?>
						<button class="btn btn-custom-success btn-sm pull-right ms-1" title="Add New Visa" data-bs-toggle="modal" data-bs-target=".add-visa-modal"><i class="fa fa-plus"></i> Add Visa</button>
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
						<form action="<?php echo base_url('admin/talent-aquisition/visa'); ?>" method="get" id="filter_form">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Unified No.</label>
										<select name="unified_no" class="form-control select2">
											<option value="">[Any Unified No.]</option>
											<?php foreach ($unified_nos as $item) { ?>
												<option value="<?php echo $item->unified_no; ?>" <?php echo ($item->unified_no == $this->input->get('unified_no')) ? 'selected' : '' ?>><?php echo $item->unified_no; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>

								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Sponsor Name</label>
										<select name="keyword" class="form-control select2">
											<option value="">[Any Sponsor]</option>
											<?php foreach ($sponsor_names as $item) { ?>
												<option value="<?php echo $item->sponsor_name; ?>" <?php echo ($item->sponsor_name == $this->input->get('keyword')) ? 'selected' : '' ?>><?php echo $item->sponsor_name; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>

								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Visa Issue No.</label>
										<select name="visa_issue_no" class="form-control select2">
											<option value="">[Any Visa Issue No.]</option>
											<?php foreach ($visa_issue_nos as $item) { ?>
												<option value="<?php echo $item->visa_issue_no; ?>" <?php echo ($item->visa_issue_no == $this->input->get('visa_issue_no')) ? 'selected' : '' ?>><?php echo $item->visa_issue_no; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>

								<?php
								$adv_show = false;
								if (!empty($this->input->get('from')) || !empty($this->input->get('to')) || !empty($this->input->get('nationality')) || !empty($this->input->get('occupation')) || !empty($this->input->get('embassy')) || !empty($this->input->get('agency'))) {
									$adv_show = true;
								}
								?>
								<div class="collapse <?php if ($adv_show) {
															echo ' show';
														} ?>" id="advanceFilter">
									<div class="row">
										<div class="col-lg-4 col-md-4 col-sm-12">
											<div class="form-group mb-2">
												<label>Visa Issue Date (From and To)</label>
												<div class="input-daterange input-group" id="datepicker6" data-date-format="dd-m-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
													<input type="text" class="form-control" id="_from" name="from" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" autocomplete="off" placeholder="Start Date" />
													<input type="text" class="form-control" id="_to" name="to" value="<?php echo $this->input->get('to') ? $this->input->get('to') : ''; ?>" autocomplete="off" placeholder="End Date" />
												</div>
											</div>
										</div>

										<div class="col-lg-4 col-md-4 col-sm-12">
											<div class="form-group mb-2">
												<label class="control-label" for="nationality">Nationality </label>
												<select name="nationality" class="form-control select2">
													<option value="">[Any Nationality]</option>
													<?php foreach (nationalityList() as $mnationality) { ?>
														<option value="<?php echo $mnationality->id; ?>" <?php echo ($mnationality->id == $this->input->get('nationality')) ? 'selected' : '' ?>><?php echo $mnationality->name; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>

										<div class="col-lg-4 col-md-4 col-sm-12">
											<div class="form-group mb-2">
												<label class="control-label" for="occupation">Occupation </label>
												<select name="occupation" class="form-control select2">
													<option value="">[Any Occupation]</option>
													<?php foreach (professionList() as $profession) { ?>
														<option value="<?php echo $profession->id; ?>" <?php echo ($profession->id == $this->input->get('occupation')) ? 'selected' : '' ?>><?php echo $profession->profession_name; ?> <?php echo (isset($profession->arabic_name)) ? '/ ' . $profession->arabic_name : ''; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>

										<div class="col-lg-4 col-md-4 col-sm-12">
											<div class="form-group mb-2">
												<label>Embassy</label>
												<select name="embassy" class="form-control select2">
													<option value="">[Any Embassy]</option>
													<?php foreach ($embassys as $item) { ?>
														<option value="<?php echo $item->embassy; ?>" <?php echo ($item->embassy == $this->input->get('embassy')) ? 'selected' : '' ?>><?php echo $item->embassy; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-12">
											<div class="form-group mb-2">
												<label>Agency</label>
												<select name="agency" class="form-select select2">
													<option value="">[Any Agency]</option>
													<?php foreach (agencyListHelper() as $key => $value) { ?>
														<option value="<?php echo $value->id; ?>" <?php echo ($value->id == $this->input->get('agency')) ? 'selected' : '' ?>><?php echo $value->agency_name; ?></option>
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
									<a href="<?php echo base_url('admin/talent-aquisition/visa'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
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
							<table id="voucherTable" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
								<thead>
									<tr>
										<th>#</th>
										<th>S.No.</th>
										<th>Visa Issue Date</th>
										<th>Visa Issue No.</th>
										<th>Unified No</th>
										<th>Establishment Name</th>
										<th>Sponsor Name</th>
										<th>Visa Issued</th>
										<th>Visa Used</th>
										<th>Visa Balance</th>
										<th>Nationality</th>
										<th>Occupation</th>
										<th>Embassy</th>
										<th>Gender</th>
										<th>Religion</th>
										<th>Agency Name</th>
										<th>Status</th>
										<th>Created At</th>
										<th>Updated At</th>
										<th>Tools</th>
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
<div class="modal fade add-visa-modal" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0">Add New Visa</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<?php echo form_open("admin/talent-aquisition/visa/save", array("id" => "visForm", "class" => "form-label-left", "data-parsley-validate" => "", "enctype" => "multipart/form-data")); ?>
				<input type="hidden" id="id" name="id" value="" />
				<div class="row">
					<div class="col-md-4 col-sm-12 mb-3 form-group">
						<label for="visa_issue_date">Visa Issue Date <span class="text-danger">*</span></label>
						<input type="date" class="form-control" id="visa_issue_date" name="visa_issue_date" required />
					</div>
					<div class="col-md-4 col-sm-12 mb-3 form-group">
						<label for="unified_no">Unified No. <span class="text-danger">*</span></label>
						<input type="text" class="form-control" id="unified_no" name="unified_no" maxlength="25" required />
					</div>
					<div class="col-md-4 col-sm-12 mb-3 form-group">
						<label for="establishment_name">Establishment Name (AR) <span class="text-danger">*</span></label>
						<input type="text" class="form-control rtl-input" id="establishment_name" name="establishment_name" maxlength="100" required />
					</div>
					<div class="col-md-4 col-sm-12 mb-3 form-group">
						<label for="sponsor_name">Sponsor Name (EN) <span class="text-danger">*</span></label>
						<input type="text" class="form-control" id="sponsor_name" name="sponsor_name" maxlength="100" required />
					</div>
					<div class="col-md-4 col-sm-12 mb-3 form-group">
						<label for="cr_no">CR Number <span class="text-danger">*</span></label>
						<input type="text" class="form-control" id="cr_no" name="cr_no" maxlength="<?php echo CR_LENGTH; ?>" required />
					</div>
					<div class="col-md-4 col-sm-12 mb-3 form-group">
						<label for="establishment_no">Establishment Number <span class="text-danger">*</span></label>
						<input type="text" class="form-control" id="establishment_no" name="establishment_no" minlength="8" maxlength="9" required />
					</div>
					<div class="col-md-4 col-sm-12 mb-3 form-group">
						<label for="visa_issue_no">Visa Issue Number <span class="text-danger">*</span></label>
						<input type="text" class="form-control" id="visa_issue_no" name="visa_issue_no" maxlength="50" required />
					</div>
					<div class="col-md-4 col-sm-12 mb-3 form-group">
						<label for="request_no">Request No <span class="text-danger">*</span></label>
						<input type="text" class="form-control" id="request_no" name="request_no" maxlength="50" required />
					</div>

					<div class="col-md-4 col-sm-12 mb-3 form-group">
						<label for="no_of_visa">No. of Visa <span class="text-danger">*</span></label>
						<input type="number" class="form-control" id="no_of_visa" name="no_of_visa" maxlength="5" required />
					</div>
					<div class="col-md-4 col-sm-12 mb-3 form-group">
						<label for="occupation">Occupation <span class="text-danger">*</span></label>
						<select class="form-select select2" data-parsley-allselected="true" name="occupation" id="occupation" required>
							<option value="">Select Occupation</option>
							<?php foreach (professionList() as $profession) { ?>
								<option value="<?php echo $profession->id; ?>" data-id="<?php echo $profession->id; ?>"><?php echo $profession->profession_name; ?> <?php echo (isset($profession->arabic_name)) ? '/ ' . $profession->arabic_name : ''; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-md-4 col-sm-12 mb-3 form-group">
						<label for="gender">Gender <span class="text-danger">*</span></label>
						<select name="gender" id="gender" class="form-select" required>
							<option value="">Select Gender</option>
							<option value="male">Male</option>
							<option value="female">Female</option>
							<option value="other">Other</option>
						</select>
					</div>
					<div class="col-md-4 col-sm-12 mb-3 form-group">
						<label for="religion">Religion <span class="text-danger">*</span></label>
						<select name="religion" id="religion" class="form-select" required>
							<option value="">Select Religion</option>
							<option value="Islam">Islam</option>
							<option value="Non Islam">Non Islam</option>
						</select>
					</div>

					<div class="col-md-4 col-sm-12 mb-2 form-group">
						<label for="visa_country">Country <span class="text-danger">*</span></label>
						<select class="form-select" name="visa_country" id="visa_country" required>
							<option value="">Select Country</option>
							<?php foreach (masterCountries() as $country_list) { ?>
								<option value="<?php echo $country_list->id; ?>" data-id="<?php echo $country_list->id; ?>"><?php echo $country_list->name; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-md-4 col-sm-12 mb-3 form-group">
						<label for="nationality">Nationality <span class="text-danger">*</span></label>
						<select class="form-select select2" data-parsley-allselected="true" name="nationality" id="nationality" required>
							<option value="">Select Nationality</option>
							<?php foreach (nationalityList() as $nation) { ?>
								<option value="<?php echo $nation->id; ?>" data-id="<?php echo $nation->id; ?>" data-name="<?php echo $nation->name; ?>"><?php echo $nation->name; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-md-4 col-sm-12 mb-3 form-group">
						<label for="embassy">Embassy <span class="text-danger">*</span></label>
						<select class="form-select select2" data-parsley-allselected="true" name="embassy" id="embassy" required>
							<option value="">Select Embassy</option>

						</select>
					</div>
					<div class="col-md-4 col-sm-12 mb-2 form-group" id="agency-container">
						<label for="agency">Agency Name <span class="text-danger">*</span></label>
						<select name="agency" id="agency" class="form-control select2" required>
							<option value="">Select Country First</option>
						</select>
					</div>

					<div class="col-md-4 col-sm-12 mb-3 form-group">
						<label for="vstatus">Status <span class="text-danger">*</span></label>
						<select name="vstatus" id="vstatus" class="form-select" required>
							<option value="">Select Status</option>
							<option value="0">New</option>
							<option value="1">Wakala Issued</option>
							<option value="2">Cancelled</option>
						</select>
					</div>
					<div class="col-md-4 col-sm-12 mb-3 form-group">
						<label for="attachment">Attachment</label>
						<input type="file" class="form-control" id="attachment" name="attachment" />
					</div>
				</div>
				<?php echo form_close(); ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
				<button type="submit" form="visForm" class="btn btn-success">Submit</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this->load->view('admin/home/footer'); ?>

<script>
	$(document).ready(function() {
		$('#voucherTable').dataTable({
			"lengthMenu": [
				[25, 50, 100, 500],
				[25, 50, 100, 500]
			],
			order: [
				[0, 'asc']
			],

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
			searching: false,
			"ajax": {
				url: "<?php echo base_url('admin/talent-aquisition/visa/ajax-list') . '?unified_no=' . $this->input->get('unified_no') . '&keyword=' . $this->input->get('keyword') . '&visa_issue_no=' . $this->input->get('visa_issue_no') . '&from=' . $this->input->get('from') . '&to=' . $this->input->get('to') . '&nationality=' . $this->input->get('nationality') . '&occupation=' . $this->input->get('occupation') . '&embassy=' . $this->input->get('embassy') . '&agency=' . $this->input->get('agency'); ?>",
				type: "POST",
				error: function(request, error) {
					console.log(" Can't do because: " + JSON.stringify(request));
				},
			},
			"columnDefs": [{
				"targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19],
				"orderable": false
			}, ],
		});
	});

	function deleteAction() {
		var inputCount = $('[name="checklist[]"]:checked').length;
		if (inputCount > 0) {
			if (confirm("Do you want to delete selected item?") == true) {
				changeActionAndSubmit('admin/talent-aquisition/visa/delete');
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

	const embassyList = {
		"Indian": ["Mumbai", "Delhi"],
		"Pakistani": ["Karachi", "Islamabad", "Lahore"],
		"Bangladeshi": ["Dhaka"],
		"Nepali": ["Kathmandu"],
		"Yemani": ["Sana`a", "Aden"],
		"Saudi Arabian": ["Riyadh", "Jeddah"]
	};

	$(document).ready(function() {
		// Event listener for nationality dropdown change
		$('#nationality').change(function() {
			var selectedOption = $('#nationality option:selected'); // Get the selected option
			var selectedNationality = selectedOption.data('name'); // Get the data-name attribute
			var embassies = embassyList[selectedNationality] || []; // Get embassies for selected nationality

			// Clear previous embassy options
			$('#embassy').empty();
			$('#embassy').append('<option value="">Select Embassy</option>'); // Default option

			// Populate the embassy dropdown with new options
			$.each(embassies, function(index, embassy) {
				$('#embassy').append('<option value="' + embassy + '">' + embassy + '</option>');
			});
		});
	});

	$('#visa_country').change(function() {
		var country_id = $(this).find('option:selected').val();
		$.ajax({
			url: "<?php echo base_url(); ?>admin/Cv_controller/getAgency",
			data: {
				country_id: country_id
			},
			dataType: "json",
			type: "POST",
			success: function(data) {
				//console.log(data);
				var html = '<option value="">Select Agency</option>';
				if (Object.keys(data).length > 0) {
					$.each(data, function(index, item) {
						html += '<option value="' + item.id + '" data-id="' + item.id + '">' + item.agency_name + '</option>';
					});
				} else {
					var html = '<option value="">No agency found</option>';
				}
				$('#agency').html(html);
			}
		});
	});
</script>
