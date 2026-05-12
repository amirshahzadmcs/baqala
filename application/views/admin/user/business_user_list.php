<?php $this->load->view('admin/home/header'); ?>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Manage Corporate Clients</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="javascript:;">Corporate Clients</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php //if (check_action_permission(get_user_role(), 'manage_corporate_clients', 'add_business')): ?>
						<button class="btn btn-custom-danger btn-sm pull-right me-2" onclick="confirm('Really want to delete these Users?') ? $('#delete_form').submit() : false;" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					<?php //endif; ?>
					<?php if(check_action_permission(get_user_role(),'manage_corporate_clients','add_business')):?>
						<a href="<?php echo base_url('admin/user/business-form'); ?>" type="button" class="btn btn-custom-success btn-sm pull-right" title="Add"><i class="fa fa-plus"></i> Add Corporate Client</a>
						<?php endif;?>
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
					<?php } ?> <?php } $this->admin->removeInfo(); ?>
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
						<form action="<?php echo base_url('admin/business-user/list'); ?>" method="get" id="filter_form">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Search by Company Name or Email Address</label>
										<input type="search" id="keyword" name="keyword" placeholder="Search by Company Name or Email Address" value="<?php echo $this->input->get('keyword') ? $this->input->get('keyword') : ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label class="d-block">Type of Company </label>
										<select style="height:410px;" name="company_type" class="form-control select2 w-100">
											<option value="">[All Types]</option>
											<option value="Establishment" <?php echo ($this->input->get('company_type') == 'Establishment') ? ' selected' : ''; ?>>Establishment</option>
											<option value="SPC" <?php echo ($this->input->get('company_type') == 'SPC') ? 'selected' : ''; ?>>SPC</option>
											<option value="Pvt. Ltd. Company" <?php echo ($this->input->get('company_type') == 'Pvt. Ltd. Company') ? ' selected' : ''; ?>>Pvt. Ltd. Company</option>
											<option value="Partnership Company" <?php echo ($this->input->get('company_type') == 'Partnership Company') ? ' selected' : ''; ?>>Partnership Company</option>
										</select>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label class="d-block">Select Status</label>
										<select name="status" class="form-select">
											<option value="">[All Status]</option>
											<option value="active" <?php echo ($this->input->get('status') == 'active') ? ' selected' : '' ?>>Active</option>
											<option value="inactive" <?php echo ($this->input->get('status') == 'inactive') ? ' selected' : '' ?>>Inactive</option>
											<option value="blocked" <?php echo ($this->input->get('status') == 'blocked') ? ' selected' : '' ?>>Block</option>
										</select>
									</div>
								</div>

								<?php
								$adv_show = false;
								if (!empty($this->input->get('account_manager')) || !empty($this->input->get('from')) || !empty($this->input->get('to')) || !empty($this->input->get('business_nature'))) {
									$adv_show = true;
								}
								?>
								<div class="collapse <?php if ($adv_show) {
															echo ' show';
														} ?>" id="advanceFilter">
									<div class="row">
										<div class="col-lg-4 col-md-4 col-sm-12">
											<div class="form-group mb-2">
												<label class="d-block">Account Manager </label>
												<select style="height:410px;" name="account_manager" class="form-control select2 w-100">
													<option value="">[All Account Manager]</option>
													<?php foreach (employeeListHelper() as $employee_list) { ?>
														<option value="<?= $employee_list->id; ?>" <?php echo ($this->input->get('account_manager') == $employee_list->id) ? "selected" : ""; ?>><?= $employee_list->full_name; ?> - <?= $employee_list->designation_name; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-12">
											<div class="form-group">
												<label>Register Between (From and To)</label>
												<div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
													<input type="text" class="form-control" id="_from" name="from" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" autocomplete="off" placeholder="Start Date" />
													<input type="text" class="form-control" id="_to" name="to" value="<?php echo $this->input->get('to') ? $this->input->get('to') : ''; ?>" autocomplete="off" placeholder="End Date" />
												</div>
											</div>
										</div>

										<div class="col-lg-4 col-md-4 col-sm-12">
											<div class="form-group mb-2">
												<label class="d-block">Nature of Business </label>
												<select style="height:410px;" name="business_nature" class="form-control select2 w-100">
													<option value="">[All Nature]</option>
													<option value="Trading" <?php echo ($this->input->get('business_nature') == 'Trading') ? "selected" : ""; ?>>Trading</option>
													<option value="Manufacturing" <?php echo ($this->input->get('business_nature') == 'Manufacturing') ? "selected" : ""; ?>>Manufacturing</option>
													<option value="Service Provider" <?php echo ($this->input->get('business_nature') == 'Service Provider') ? "selected" : ""; ?>>Service Provider</option>
													<option value="Contracting" <?php echo ($this->input->get('business_nature') == 'Contracting') ? "selected" : ""; ?>>Contracting</option>
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
									<a href="<?php echo base_url('admin/business-user/list'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<?php echo form_open("admin/user/delete_corporate", array("id" => "delete_form")); ?>
						<table id="user-table" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
							<thead>
								<tr>
									<th>#</th>
									<th>Customer No</th>
									<th>Company Name</th>
									<th>Email</th>
									<th>Contact</th>
									<th>A/C Type</th>
									<th>Credit A/C Status</th>
									<th>Status</th>
									<th>Completed Orders</th>
									<th>Total Value</th>
									<th>Wallet</th>
									<th>Created</th>
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
		$('#user-table').dataTable({
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
				url: "<?php echo base_url(); ?>admin/business-user/list-ajax?keyword=<?php echo $this->input->get('keyword') ?>&status=<?php echo $this->input->get('status') ?>&company_type=<?php echo $this->input->get('company_type') ?>&account_manager=<?php echo $this->input->get('account_manager') ?>&business_nature=<?php echo $this->input->get('business_nature') ?>&from=<?php echo $this->input->get('from') ?>&to=<?php echo $this->input->get('to') ?>",
				type: "POST"
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
</script>