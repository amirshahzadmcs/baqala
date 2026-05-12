<?php $this->load->view('admin/home/header'); ?>
<style>
	.dataTables_wrapper::-webkit-scrollbar {
		display: none;
	}

	.nav-md .container.body .right_col {
		padding: 10px 10px 0;
		margin-left: 230px;
	}

	input[type=text],
	input[type=select] {
		height: 38px !important;
	}
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Job Cards</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item active">Job Cards List</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if (check_action_permission(get_user_role(), 'job_cards', 'create_job')): ?>
						<button type="button" class="btn btn-custom-success btn-sm pull-right me-1" data-bs-toggle="modal" data-bs-target=".jobcard-modal"><i class="fa fa-plus"></i> Add Job Cards</button>
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
						<form action="<?php echo base_url('admin/job-card/list'); ?>" method="get" id="filter_form">
							<div class="row">
								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="vehicle_filter">Select Vehicle:</label>
									<select name="vehicle_filter" id="vehicle_filter" class="form-control select2 w-100" data-placeholder="Choose Vehicle...">
										<option value="">ALL</option>
										<?php foreach ($riders_list as $list) { ?>
											<option value="<?php echo $list->bike_no; ?>" <?php echo ($list->bike_no == $this->input->get('vehicle_filter')) ? 'selected' : ''; ?>><?php echo $list->bike_no . '-' . $list->vehicle_type; ?></option>
										<?php } ?>
									</select>
								</div>

								<div class="col-4 px-1">
									<div class="form-group">
										<label>Job Number</label>
										<div class="input-group">
											<span class="input-group-text">JC-</span>
											<input type="text" id="job_number" name="job_number" value="<?php echo $this->input->get('job_number') ? $this->input->get('job_number') : ''; ?>" class="form-control" maxlength="6" autocomplete="off">
										</div>
									</div>
								</div>
								<div class="col-4 px-1">
									<div class="form-group mb-2">
										<label class="d-block">Job Type </label>
										<select style="height:410px;" name="job_type" class="form-control select2 w-100">
											<option value="">All Type</option>
											<option value="Repair" <?php if ($this->input->get('job_type') == 'Repair') {
																		echo 'selected';
																	} ?>>Repair</option>
											<option value="Maintenance" <?php if ($this->input->get('job_type') == 'Maintenance') {
																			echo 'selected';
																		} ?>>Maintenance</option>
										</select>
									</div>
								</div>
								<?php
								$adv_show = false;
								if (!empty($this->input->get('rider_name')) || !empty($this->input->get('from')) || !empty($this->input->get('to')) || !empty($this->input->get('business_nature')) || !empty($this->input->get('status'))) {
									$adv_show = true;
								}
								?>
								<div class="collapse <?php if ($adv_show) {
															echo ' show';
														} ?>" id="advanceFilter">
									<div class="row">
										<div class="col-lg-4 col-md-4 col-sm-12">
											<div class="form-group mb-2">
												<label>Search by Rider Name</label>
												<input type="search" id="rider_name" name="rider_name" placeholder="Search by Rider Name" value="<?php echo $this->input->get('rider_name') ? $this->input->get('rider_name') : ''; ?>" maxlength="99" autocomplete="off" class="form-control">
											</div>
										</div>
										<div class="col-md-4 px-1">
											<div class="form-group">
												<label>Date Between (From and To)</label>
												<div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
													<input type="text" class="form-control" id="_from" name="from" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" autocomplete="off" placeholder="Start Date" />
													<input type="text" class="form-control" id="_to" name="to" value="<?php echo $this->input->get('to') ? $this->input->get('to') : ''; ?>" autocomplete="off" placeholder="End Date" />
												</div>
											</div>
										</div>
										<div class="col-4 px-1">
											<div class="form-group mb-2">
												<label class="d-block">Job Status </label>
												<select style="height:410px;" name="status" class="form-control select2 w-100">
													<option value="">All Status</option>
													<option value="open" <?php if ($this->input->get('status') == 'open') {
																				echo 'selected';
																			} ?>>Open</option>
													<option value="closed" <?php if ($this->input->get('status') == 'closed') {
																				echo 'selected';
																			} ?>>Closed</option>
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
									<a href="<?php echo base_url('admin/job-card/list'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div> <!-- end col -->

			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<form id="myform" name="myform" method="post" action="">
							<table id="job-table" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
								<thead>
									<tr>
										<th>#</th>
										<th>Job No.</th>
										<th>Job Date</th>
										<th>Job Type</th>
										<th>Rider Name</th>
										<th>Vehicle No.</th>
										<th>Vehicle Year</th>
										<th>Vehicle Make</th>
										<th>Vehicle Type</th>
										<th>Meter Reading</th>
										<th>Total</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
							</table>
						</form>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>

<!-- Modal -->
<div class="modal fade jobcard-modal" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0">Create Job Card</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="demo-form2" method="post" action="<?php echo base_url() ?>admin/job-card/create" data-toggle="validator" role="form" enctype="multipart/form-data">
					<div class="row">
						<div class="col-md-6 mb-3 form-group">
							<label class="control-label" for="job_type" style="width:100%">Job Type <span class="text-danger">*</span></label>
							<select id="job_type" name="job_type" class="form-control col-md-12 select2" required>
								<option value="">Select Job Type</option>
								<option value="Maintenance">Maintenance</option>
								<option value="Repair">Repair</option>
							</select>
						</div>

						<div class="col-md-6 mb-3 form-group">
							<label class="control-label" for="job_date">Job Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control" name="job_date" max="<?php echo date('Y-m-d'); ?>" required />
						</div>

						<div class="col-md-6 mb-3 form-group">
							<label class="control-label" for="bike_no" style="width:100%">Select Bike <span class="text-danger">*</span></label>
							<select id="bike_no" name="bike_no" class="form-control col-md-12 select2" required>
								<option value="">Select Bike</option>
								<?php foreach ($vehicles_list as $vehicle) { ?>
									<option value="<?php echo $vehicle->vehicle_no; ?>" data-id="<?php echo $vehicle->id; ?>"><?php echo $vehicle->vehicle_no; ?></option>
								<?php } ?>
							</select>
						</div>

						<div class="col-md-6 mb-3 form-group">
							<label class="control-label" for="vehicle_year">Vehicle Year <span class="text-danger">*</span></label>
							<input type="text" class="form-control" maxlength="4" name="vehicle_year" id="vehicle_year" required readonly />
						</div>

						<div class="col-md-6 mb-3 form-group">
							<label class="control-label" for="vehicle_p_date">Vehicle Purchase Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control" maxlength="100" name="vehicle_p_date" id="vehicle_p_date" required readonly />
						</div>

						<div class="col-md-6 mb-3 form-group">
							<label class="control-label" for="vehicle_make">Vehicle Make <span class="text-danger">*</span></label>
							<input type="text" class="form-control" maxlength="120" name="vehicle_make" id="vehicle_make" required readonly />
						</div>

						<div class="col-md-6 mb-3 form-group">
							<label class="control-label" for="vehicle_type">Vehicle Type <span class="text-danger">*</span></label>
							<input type="text" class="form-control" maxlength="120" name="vehicle_type" id="vehicle_type" required readonly />
						</div>

						<div class="col-md-6 mb-3 form-group">
							<label class="control-label" for="vehicle_color">Vehicle Color <span class="text-danger">*</span></label>
							<input type="text" class="form-control" maxlength="120" name="vehicle_color" id="vehicle_color" required readonly />
						</div>

						<div class="col-md-6 mb-3 form-group">
							<label class="control-label" for="meter_reading">Meter Reading <span class="text-danger">*</span></label>
							<input type="text" class="form-control" name="meter_reading" id="meter_reading" required />
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
				<button type="submit" form="demo-form2" class="btn btn-success">Submit</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this->load->view('admin/home/footer'); ?>
<script>
	$(document).ready(function() {
		$('#job-table').dataTable({
			"lengthMenu": [
				[25, 50, 100, 500],
				[25, 50, 100, 500]
			],
			order: [
				[0, 'asc']
			],
			dom: 'Blfrtip',
			buttons: [{
					extend: "copy",
					className: "btn-md"
				},
				{
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
			fixedHeader: true,
			"order": [],
			"ajax": {
				url: "<?php echo base_url(); ?>admin/job-card/ajax-list?vehicle_filter=<?php echo $this->input->get('vehicle_filter'); ?>&job_number=<?php echo $this->input->get('job_number'); ?>&job_type=<?php echo $this->input->get('job_type'); ?>&from=<?php echo $this->input->get('from'); ?>&to=<?php echo $this->input->get('to'); ?>&rider_name=<?php echo $this->input->get('rider_name'); ?>&status=<?php echo $this->input->get('status'); ?>",
				type: "POST",
				error: function(request, error) {
					console.log(" Can't do because: " + JSON.stringify(request));
				},
			},
			"columnDefs": [{
				"targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
				"orderable": false
			}, ]
		});
	});
	$.fn.dataTable.ext.errMode = function(settings, helpPage, message) {
		console.log(message);
	};

	function changeActionAndSubmit(action) {
		document.getElementById('myform').action = action;
		document.getElementById('myform').submit();
	}

	$('#bike_no').on('change', function() {
		var riderid = $("#bike_no option:selected").data("id");
		//alert(clientid);
		get_bike_detail(riderid);
	});

	function get_bike_detail(u) {
		$.ajax({
			url: '<?php echo base_url(); ?>admin/job-card/vehicle-detail',
			type: "GET",
			data: {
				'id': u
			},
			success: function(data) {
				var result = JSON.parse(data);
				//alert(data);
				if (result) {
					$("#vehicle_year").val(result.vehicle_year);
					$("#vehicle_p_date").val(result.purchase_date);
					$("#vehicle_make").val(result.make_name);
					$("#vehicle_type").val(result.vehicle_model);
					$("#vehicle_color").val(result.color_name);

				} else {
					//alert('Data not found');
					$("#vehicle_year").val('');
					$("#vehicle_p_date").val('');
					$("#vehicle_make").val('');
					$("#vehicle_type").val('');
					$("#vehicle_color").val('');
				}

			},
			error: function(data) {
				alert(data);
			}
		});
	}
</script>