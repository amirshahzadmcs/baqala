<?php $this->load->view('admin/home/header'); ?>
<style>
	.parent_row {
		background-color: #ffd04542;
	}
</style>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Manage Modules</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/modules/list'); ?>">Manage Roles</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-none d-sm-block">
					<button class="btn btn-custom-danger btn-sm pull-right" onclick="confirm('Really want to delete this item?') ? $('#delete_form').submit() : false;" title="Delete"><i class="fa fa-trash"></i> Delete</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end page title -->

<div class="container-fluid">
	<div class="page-content-wrapper">
		<div class="row">
			<div class="col-4">
				<div class="card">
					<div class="card-body">
						<form class="needs-validation" method="POST" action="<?php echo base_url('admin/modules/submit'); ?>" novalidate>
							<input type="hidden" name="id" value="" />
							<div class="row">
								<div class="col-md-12">
									<div class="mb-3">
										<label class="control-label" for="perm_group_id">Parent Group</label>
										<select class="form-control select2" name="perm_group_id" data-placeholder="Choose Group..." required>
											<option value="0">No Parent</option>
											<?php foreach ($category_list as $category) { ?>
												<option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
												<?php foreach ($category['child'] as $child) { ?>
													<option value="<?php echo $child['id']; ?>"><?php echo $category['name'] . " > " . $child['name']; ?></option>
													<?php foreach ($child['child'] as $sub_child): ?>
														<option value="<?php echo $sub_child['id']; ?>"><?php echo $category['name'] . " > " . $child['name'] . " > " . $sub_child['name']; ?></option>
														<?php foreach ($sub_child['child'] as $grand_child): ?>
															<option value="<?php echo $grand_child['id']; ?>"><?php echo $category['name'] . " > " . $child['name'] . " > " . $sub_child['name'] . " > " . $grand_child['name']; ?></option>
											<?php endforeach;
													endforeach;
												}
											} ?>
										</select>
									</div>
								</div>
								<div class="col-md-12">
									<div class="mb-3">
										<label for="name" class="form-label">Module Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="name" placeholder="Module Name" name="name" required>
										<div class="invalid-feedback">
											Please provide a module name.
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="mb-3">
										<label for="short_code" class="form-label">Module Code <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="short_code" placeholder="Module Short Code" name="short_code" required>
										<div class="invalid-feedback">
											Please provide a module short code.
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="mb-3">
										<label for="status-select" class="form-label">Status <span class="text-danger">*</span></label>
										<select class="form-select" name="status" id="status-select" required>
											<option value="">--- Select Status ---</option>
											<option value="1">Active</option>
											<option value="0">Deactive</option>
										</select>
										<div class="invalid-feedback">
											Please provide a status.
										</div>
									</div>
								</div>

								<label for="short_code" class="form-label">Define Methods <span class="text-danger"> (optional)</span></label>
								<div class="col-md-2 align-content-around">
									<div class="mb-3">
										<button type="button" class="btn-custom-success addMoreMethod" action_type="create"><i class="fa fa-plus"></i></button>
									</div>
								</div>
								<div id="methodDataAdd">

								</div>
							</div>

							<div>
								<button class="btn btn-custom-success" type="submit">Submit form</button>
							</div>
						</form>

					</div>
				</div>
			</div>
			<div class="col-8">
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
						<?php echo form_open('admin/modules/delete', array("id" => "delete_form")); ?>
						<table id="example" class="table table-bordered">
							<thead>
								<tr>
									<th>#</th>
									<th>ID</th>
									<th>Module Name</th>
									<th>Short Code</th>
									<th>Status</th>
									<th>Tools</th>
								</tr>
							</thead>

							<tbody>
								<?php
								foreach ($category_list as $result) { ?>
									<tr class="<?php echo ($result['perm_group_id'] == '0') ? 'parent_row' : 'child_row'; ?>">
										<th scope="row"><input type="checkbox" name="checklist[]" value="<?php echo $result['id']; ?>"></th>
										<td><?php echo $result['id']; ?></td>
										<td><?php echo $result['name']; ?></td>
										<td><?php echo $result['short_code']; ?></td>
										<td><?php echo $result['status'] == 1 ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>'; ?></td>
										<td><button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" onclick="quickEdit('<?php echo $result['id']; ?>')"><i class="mdi mdi-pencil font-size-18"></i></button></td>
									</tr>
									<?php foreach ($result['child'] as $child) { ?>
										<tr class="<?php echo ($child['perm_group_id'] == '0') ? 'parent_row' : 'child_row'; ?>">
											<th scope="row"><input type="checkbox" name="checklist[]" value="<?php echo $child['id']; ?>"></th>
											<td><?php echo $child['id']; ?></td>
											<td><?php echo $result['name'] . " > " . $child['name']; ?></td>
											<td><?php echo $child['short_code']; ?></td>
											<td><?php echo $child['status'] == 1 ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>'; ?></td>
											<td><button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" onclick="quickEdit('<?php echo $child['id']; ?>')"><i class="mdi mdi-pencil font-size-18"></i></button></td>
										</tr>
										<?php foreach ($child['child'] as $sub) { ?>
											<tr class="<?php echo ($sub['perm_group_id'] == '0') ? 'parent_row' : 'child_row'; ?>">
												<th scope="row"><input type="checkbox" name="checklist[]" value="<?php echo $sub['id']; ?>"></th>
												<td><?php echo $sub['id']; ?></td>
												<td><?php echo $result['name'] . " > " . $child['name'] . " > " . $sub['name']; ?></td>
												<td><?php echo $sub['short_code']; ?></td>
												<td><?php echo $sub['status'] == 1 ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>'; ?></td>
												<td><button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" onclick="quickEdit('<?php echo $sub['id']; ?>')"><i class="mdi mdi-pencil font-size-18"></i></button></td>
											</tr>
											<?php foreach ($sub['child'] as $subChild) { ?>
												<tr class="<?php echo ($subChild['perm_group_id'] == '0') ? 'parent_row' : 'child_row'; ?>">
													<th scope="row"><input type="checkbox" name="checklist[]" value="<?php echo $subChild['id']; ?>"></th>
													<td><?php echo $subChild['id']; ?></td>
													<td><?php echo $result['name'] . " > " . $child['name'] . " > " . $sub['name'] . " > " . $subChild['name']; ?></td>
													<td><?php echo $subChild['short_code']; ?></td>
													<td><?php echo $subChild['status'] == 1 ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>'; ?></td>
													<td><button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" onclick="quickEdit('<?php echo $subChild['id']; ?>')"><i class="mdi mdi-pencil font-size-18"></i></button></td>
												</tr>
												<?php foreach ($subChild['child'] as $grandChild) { ?>
													<tr class="<?php echo ($grandChild['perm_group_id'] == '0') ? 'parent_row' : 'child_row'; ?>">
														<th scope="row"><input type="checkbox" name="checklist[]" value="<?php echo $grandChild['id']; ?>"></th>
														<td><?php echo $grandChild['id']; ?></td>
														<td><?php echo $result['name'] . " > " . $child['name'] . " > " . $sub['name'] . " > "  . $subChild['name']. " > " . $grandChild['name']; ?></td>
														<td><?php echo $grandChild['short_code']; ?></td>
														<td><?php echo $grandChild['status'] == 1 ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>'; ?></td>
														<td><button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" onclick="quickEdit('<?php echo $grandChild['id']; ?>')"><i class="mdi mdi-pencil font-size-18"></i></button></td>
													</tr>
								<?php }
											}
										}
									}
								} ?>
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
				<h6 class="modal-title mt-0" id="summaryModalFullscreenLabel">Edit Module</h6>
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
		$('#example').dataTable({
			"lengthMenu": [
				[10, 25, 50, 100, 500],
				[10, 25, 50, 100, 500]
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
		});
	});
	$.fn.dataTable.ext.errMode = function(settings, helpPage, message) {
		console.log(message);
	};

	function quickEdit(id) {
		if (id > 0) {
			$.ajax({
				type: "post",
				url: "<?php echo base_url('admin/modules/quick-edit'); ?>",
				data: {
					'module_id': id
				},
				dataType: "json",
				success: function(response) {
					$('#summary_body_modal').html(response.html);
					if (response.data.methods) {
						methods = JSON.parse(response.data.methods);
					} else {
						methods = [];
					}
					methods.forEach(value => {
						$('#methodDataEdit').append(getMethodRawHtml(value));
					});
					$('.role-detail-modal').modal('show');
				},
				error: function(request, error) {
					$('#summary_body_modal').after(JSON.stringify(request));
				},
			});
		} else {
			alert('Invalid request id!');
		}
	}

	// For Short Code Creation

	$(document).on('input', 'input[name="short_code"]', function() {
		let value = $(this).val();
		let slug = value
			.toLowerCase()
			.trim()
			.replace(/[^a-z0-9\s-]/g, '')
			.replace(/\s+/g, '_')
			.replace(/-+/g, '_');
		$(this).val(slug);
	});

	$(document).on('click', '.addMoreMethod', function() {
		var contentHtml = getMethodRawHtml();
		if ($(this).attr('action_type') == 'create') {
			$('#methodDataAdd').append(contentHtml);
		} else if ($(this).attr('action_type') == 'edit') {
			$('#methodDataEdit').append(contentHtml);
		}
	});

	function getMethodRawHtml(data = {}, isEdit = false) {
		return `<div class="row method_row">
								<div class="col-md-6">
									<div class="mb-3">
										<input type="text" class="form-control" placeholder="key" name="method_key[]" value="${data.method_key || ''}" required>
										<div class="invalid-feedback">
											Please provide a method key.
										</div>
									</div>
								</div>
								<div class="col-md-5">
									<div class="mb-3">
										<input type="text" class="form-control" placeholder="value" name="method_value[]" value="${data.method_value || ''}" required>
										<div class="invalid-feedback">
											Please provide a method value.
										</div>
									</div>
								</div>
								<div class="col-md-1 align-content-around">
									<div class="mb-3">
										<button type="button" class="btn-custom-danger removeMethodBtn"><i class="fa fa-trash"></i></button>
									</div>
								</div></div>`;
	}

	$(document).on('click', '.removeMethodBtn', function() {
		$(this).closest('.method_row').remove();
	});
</script>