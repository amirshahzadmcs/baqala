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
					<h4>Manage Roles</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/roles/list'); ?>">Manage Roles</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-none d-sm-block">
					<?php if (check_action_permission(get_user_role(), 'roles', 'delete')): ?>
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
			<?php if(check_action_permission(get_user_role(), 'roles', 'add')):?>
			<div class="col-4">
				<div class="card">
					<div class="card-body">
						<form class="needs-validation" method="POST" action="<?php echo base_url('admin/roles/submit'); ?>" novalidate>
							<input type="hidden" name="id" value="" />
							<div class="row">
								<div class="col-md-12">
									<div class="mb-3">
										<label for="name" class="form-label">Role Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="name" placeholder="Role Name" name="name" required>
										<div class="invalid-feedback">
											Please provide a role name.
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="mb-3">
										<label for="name" class="form-label">Arabic Name</label>
										<input type="text" class="form-control" id="ar_name" placeholder="Role Arabic Name" name="ar_name">
										<div class="invalid-feedback">
											Please provide a role arabic name.
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="mb-3">
										<label for="status-select" class="form-label">Status <span class="text-danger">*</span></label>
										<select class="form-select" name="is_active" id="status-select" required>
											<option value="">--- Select Status ---</option>
											<option value="1">Active</option>
											<option value="0">Deactive</option>
										</select>
										<div class="invalid-feedback">
											Please provide a status.
										</div>
									</div>
								</div>
								<!-- <div class="col-md-12">
									<div class="mb-3">
										<label for="status-select" class="form-label">Is Superadmin <span class="text-danger">*</span></label>
										<select class="form-select" name="is_superadmin" id="status-select" required>
											<option value="">--- Select Status ---</option>
											<option value="1">Yes</option>
											<option value="0">No</option>
										</select>
										<div class="invalid-feedback">
											Select 'YES' if role is superadmin.
										</div>
									</div>
								</div> -->
							</div>

							<div>
								<button class="btn btn-custom-success" type="submit">Submit form</button>
							</div>
						</form>

					</div>
				</div>
			</div>
			<?php endif;?>
			<div class="<?php echo check_action_permission(get_user_role(), 'roles', 'add') ? 'col-8' : 'col-12'; ?>">
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
						<?php echo form_open('admin/roles/delete', array("id" => "delete_form")); ?>
						<table id="datatable-roles" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
							<thead>
								<tr>
									<th>#</th>
									<th>Role Name</th>
									<th>Ar Name</th>
									<th>Status</th>
									<th>Superadmin</th>
									<th>Created On</th>
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

<div class="modal fade role-detail-modal" role="dialog" aria-labelledby="ModalFullscreenLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title mt-0" id="summaryModalFullscreenLabel">Edit Role</h6>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" id="summary_body_modal">

			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this->load->view('admin/home/footer'); ?>

<script>
	$(document).ready(function() {
		$('#datatable-roles').dataTable({
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
			],
			"responsive": true,
			"processing": true,
			"serverSide": true,
			fixedHeader: true,
			"order": [],
			"ajax": {
				url: "<?php echo base_url(); ?>admin/roles/ajax-list",
				type: "POST"
			},
			"columnDefs": [{
				"targets": [0, 1, 2, 3, 4, 5],
				"orderable": false
			}, ]
		});
	});
	$.fn.dataTable.ext.errMode = function(settings, helpPage, message) {
		console.log(message);
	};

	function quickEdit(id) {
		if (id > 0) {
			$.ajax({
				type: "post",
				url: "<?php echo base_url('admin/roles/quick-edit'); ?>",
				data: {
					'role_id': id
				},
				//dataType: "json",
				success: function(response) {
					console.log(response);
					$('.role-detail-modal').modal('show');
					$('#summary_body_modal').html(response);
				},
				error: function(request, error) {
					//console.log(" Can't do because: " + JSON.stringify(request));
					$('#summary_body_modal').after(JSON.stringify(request));
				},
			});
		} else {
			alert('Invalid request id!');
		}
	}
</script>