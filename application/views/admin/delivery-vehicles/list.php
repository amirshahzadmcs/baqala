<?php $this->load->view('admin/home/header'); ?>
<style>
	.dataTables_wrapper::-webkit-scrollbar {
		display: none;
	}

	.nav-md .container.body .right_col {
		padding: 10px 10px 0;
		margin-left: 230px;
	}

	.modal .modal-dialog-aside {
		width: 350px;
		max-width: 80%;
		height: 100%;
		margin: 0;
		transform: translate(0);
		transition: transform .2s;
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
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>3P Rider Management</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/deliveryvehicle'); ?>">3P Rider</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if (check_action_permission(get_user_role(), '3p_rider', 'delete')): ?>
						<button class="btn btn-custom-danger btn-sm pull-right me-2" onclick="confirm('Really want to delete this rider?') ? $('#delete_form').submit() : false;" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					<?php endif;
					if (check_action_permission(get_user_role(), '3p_rider', 'add')): ?>
						<a href="<?php echo base_url('admin/deliveryvehicle/add'); ?>" type="button" class="btn btn-custom-success btn-sm pull-right" title="Add"><i class="fa fa-plus"></i> Add</a>
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
						<!-- <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button> -->
					<?php } else { ?>
						<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong><?php echo $msg_data; ?></strong>
						</div>
						<!-- <div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button> -->
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
					<div class="card-header">
						<h4 class="header-title mb-0">Search</h4>
					</div>
					<div class="card-body">
						<form action="<?php echo base_url('admin/deliveryvehicle'); ?>" method="get" id="filter_form">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Search by Rider Name / DID / Email Address</label>
										<input type="search" id="keyword" name="keyword" placeholder="Search by Rider Name, DID or Email Address" value="<?php echo $this->input->get('keyword') ? $this->input->get('keyword') : ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>

								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label class="d-block">Rider Status </label>
										<select name="status" class="form-select">
											<option value="">[All Status]</option>
											<option value="active" <?php echo ($this->input->get('status') == 'active') ? 'selected' : '' ?>>Active</option>
											<option value="inactive" <?php echo ($this->input->get('status') == 'inactive') ? 'selected' : '' ?>>Inactive</option>
											<option value="blocked" <?php echo ($this->input->get('status') == 'blocked') ? 'selected' : '' ?>>Blocked</option>
										</select>
									</div>
								</div>

								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label class="d-block">Application Status </label>
										<select name="application_status" class="form-select">
											<option value="">[All Status]</option>
											<option value="verified" <?php echo ($this->input->get('application_status') == 'verified') ? 'selected' : '' ?>>Verified</option>
											<option value="unverified" <?php echo ($this->input->get('application_status') == 'unverified') ? 'selected' : '' ?>>Unverified</option>
										</select>
									</div>
								</div>
							</div>
							<?php
							$adv_show = false;
							if (!empty($this->input->get('rider_type'))) {
								$adv_show = true;
							}
							if (!empty($this->input->get('partner_id'))) {
								$adv_show = true;
							}
							if (!empty($this->input->get('iqama_no'))) {
								$adv_show = true;
							}
							if (!empty($this->input->get('plate_no'))) {
								$adv_show = true;
							}
							if (!empty($this->input->get('from'))) {
								$adv_show = true;
							}
							if (!empty($this->input->get('to'))) {
								$adv_show = true;
							}
							?>
							<div class="collapse <?php if ($adv_show) {
														echo ' show';
													} ?>" id="advanceFilter">
								<div class="row">
									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label class="control-label" for="rider_type">Select Rider Type </label>
											<select name="rider_type" id="rider_type" class="form-select">
												<option value="">[All Type]</option>
												<option value="1" <?php echo ($this->input->get('rider_type') == '1') ? 'selected' : '' ?>>3PL (Rider_Captain)</option>
												<option value="2" <?php echo ($this->input->get('rider_type') == '2') ? 'selected' : '' ?>>Freelancer (Rider)</option>
											</select>
										</div>
									</div>

									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label class="control-label" for="partner_id">Select Logistic Partner </label>
											<select style="height:410px;" name="partner_id" id="partner_id" class="form-control select2">
												<option value="">[All Logistic Partner]</option>
												<?php foreach (logisticPartnerList() as $partner) { ?>
													<option value="<?php echo $partner->id; ?>" <?php echo ($this->input->get('partner_id') == $partner->id) ? 'selected' : '' ?>><?php echo $partner->company_name; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>

									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label>Iqama Number</label>
											<input type="search" id="iqama_no" name="iqama_no" placeholder="Search by Iqama Number" value="<?php echo $this->input->get('iqama_no') ? $this->input->get('iqama_no') : ''; ?>" autocomplete="off" class="form-control">
										</div>
									</div>

									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label>Vehicle Number</label>
											<input type="search" id="plate_no" name="plate_no" placeholder="Search by Plate Number" value="<?php echo $this->input->get('plate_no') ? $this->input->get('plate_no') : ''; ?>" autocomplete="off" class="form-control">
										</div>
									</div>

									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label>Registration Between (From and To)</label>
											<div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
												<input type="text" class="form-control" id="_from" name="from" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" autocomplete="off" placeholder="Start Date" />
												<input type="text" class="form-control" id="_to" name="to" value="<?php echo $this->input->get('to') ? $this->input->get('to') : ''; ?>" autocomplete="off" placeholder="End Date" />
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
									<a href="<?php echo base_url('admin/deliveryvehicle'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<?php echo form_open("admin/deliveryvehicle/delete", array("id" => "delete_form")); ?>
						<table id="vendor-table" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
							<thead>
								<tr>
									<th>#</th>
									<th>D. ID</th>
									<th>Name</th>
									<th>Mobile</th>
									<th>Iqama No.</th>
									<th>Bike No.</th>
									<th>Logistic Partner</th>
									<th>Lifetime Earning</th>
									<th>Current Month Earn.</th>
									<th>Last Online</th>
									<th>Reg. Date</th>
									<th>Status</th>
									<th>Appl. Status</th>
									<th>Tools</th>
								</tr>
							</thead>
						</table>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>

<?php $this->load->view('admin/home/footer'); ?>
<script>
	$(document).ready(function() {
		$('#vendor-table').dataTable({
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
			"fixedHeader": true,
			"searching": false,
			"order": [],
			"ajax": {
				url: "<?php echo base_url(); ?>admin/deliveryvehicle/get_list?keyword=<?php echo $this->input->get('keyword') ?>&status=<?php echo $this->input->get('status') ?>&application_status=<?php echo $this->input->get('application_status') ?>&from=<?php echo $this->input->get('from') ?>&to=<?php echo $this->input->get('to') ?>&rider_type=<?php echo $this->input->get('rider_type') ?>&partner_id=<?php echo $this->input->get('partner_id') ?>&iqama_no=<?php echo $this->input->get('iqama_no') ?>&plate_no=<?php echo $this->input->get('plate_no') ?>",
				type: "POST"
			},
			"columnDefs": [{
					"targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
					"orderable": false
				},
				{
					"width": "200px",
					"targets": [6]
				},
				{
					"targets": [7, 8],
					"className": "text-center",
				},
			],
			fixedColumns: true,
		});
	});
	$.fn.dataTable.ext.errMode = function(settings, helpPage, message) {
		console.log(message);
	};
</script>