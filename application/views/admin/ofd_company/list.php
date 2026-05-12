<?php $this->load->view('admin/home/header'); ?>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Manage Food Delivery Company</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/ofd-company/list'); ?>">Food Delivery Company</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-none d-sm-block">
					<?php if (check_action_permission(get_user_role(), 'online_food_delivery_company', 'delete')): ?>
						<button class="btn btn-custom-danger btn-sm pull-right" onclick="confirm('Really want to delete this item?') ? $('#delete_form').submit() : false;" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end page title -->

<div class="container-fluid">
	<div class="page-content-wrapper">
		<div class="row">
			<?php if (check_action_permission(get_user_role(), 'online_food_delivery_company', 'add')): ?>
				<div class="col-4">
					<div class="card">
						<div class="card-body">
							<form class="needs-validation" method="POST" action="<?php echo base_url('admin/ofd-company/submit'); ?>" novalidate>
								<div class="row">
									<div class="col-md-12">
										<div class="mb-3">
											<label for="company_name" class="form-label">Company Name <span class="text-danger">*</span></label>
											<input type="text" class="form-control" id="company_name" placeholder="Company Name" name="company_name" required>
											<div class="invalid-feedback">
												Please provide a company name.
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="mb-3">
											<label for="company_name_ar" class="form-label">Company Name (Arabic)</label>
											<input type="text" class="form-control rtl-input" id="company_name_ar" placeholder="Company arabic name" name="company_name_ar">
											<div class="invalid-feedback">
												Please provide a company name (Arabic).
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="mb-3">
											<label for="id_length" class="form-label">ID Number Length <span class="text-danger">*</span></label>
											<div class="input-group">
												<input type="number" class="form-control" id="id_length" value="<?php echo $id_length;?>" minlength="1" maxlength="55" placeholder="Min Length" name="id_length" required>
												<input type="number" class="form-control" id="max_id_length" value="<?php echo $max_id_length;?>" minlength="1" maxlength="55" placeholder="Max Length" name="max_id_length" required>
											</div>
											<div class="invalid-feedback">
												Please provide length of id number.
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="mb-3">
											<label for="status-select" class="form-label">Status <span class="text-danger">*</span></label>
											<select class="form-select" name="status" id="status-select" required>
												<option value="">--- Select Status ---</option>
												<option value="active">Active</option>
												<option value="inactive">Deactive</option>
											</select>
											<div class="invalid-feedback">
												Please provide a status.
											</div>
										</div>
									</div>
								</div>

								<div>
									<button class="btn btn-custom-success" type="submit">Submit form</button>
								</div>
							</form>

						</div>
					</div>
				</div>
			<?php endif; ?>
			<div class="<?php echo check_action_permission(get_user_role(), 'online_food_delivery_company', 'add') ? 'col-8' : 'col-12' ?>">
				<div class="card">
					<div class="card-body">
						<div>
							<?php if ($this->admin->getInfo()) {
								$info = explode("--", $this->admin->getInfo());
								$info_type = $info[0];
								$msg_data = $info[1];
								if ($info_type == 2) {
							?>
									<div class="alert alert-danger alert-dismissible fade show" role="alert">
										<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										<strong>Error!</strong> <?php echo $msg_data; ?>
									</div>
								<?php } else { ?>
									<div class="alert alert-success alert-dismissible fade show" role="alert">
										<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										<strong>Success!</strong> <?php echo $msg_data; ?>
									</div>
							<?php }
							}
							$this->admin->removeInfo(); ?>
						</div>
						<?php echo form_open('admin/ofd-company/delete', array("id" => "delete_form")); ?>
						<table id="datatable-company" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
							<thead>
								<tr>
									<th>#</th>
									<th>Company Name</th>
									<th>Total Orders</th>
									<th>ID Length</th>
									<th>Status</th>
									<th>Created On</th>
									<th>Updated On</th>
									<th>Tools</th>
								</tr>
							</thead>

							<tbody>

							</tbody>
						</table>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<?php $this->load->view('admin/home/footer'); ?>

<script>
	$(document).ready(function() {
		$('#datatable-company').dataTable({
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
			],
			"responsive": true,
			"processing": true,
			"serverSide": true,
			fixedHeader: true,
			"order": [],
			"ajax": {
				url: "<?php echo base_url(); ?>admin/ofd_company/get_list",
				type: "POST"
			},
			"columnDefs": [{
				"targets": [0, 1, 2, 3, 4, 5, 6, 7],
				"orderable": false
			}, ]
		});
	});
	$.fn.dataTable.ext.errMode = function(settings, helpPage, message) {
		console.log(message);
	};
</script>