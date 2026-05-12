<?php $this->load->view('admin/home/header'); ?>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Category Management</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item active">Category List</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php
					if (
						$enableStatus = check_action_permission(get_user_role(), 'manage_category', 'setStatusEnable') ||
						$disableStatus = check_action_permission(get_user_role(), 'manage_category', 'setStatusDisable') ||
						$deleteStatus = check_action_permission(get_user_role(), 'manage_category', 'delete')
					): ?>
						<div class="btn-group me-1">
							<button class="btn btn-custom-danger btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Bulk Action <i class="mdi mdi-chevron-down"></i>
							</button>
							<div class="dropdown-menu">
								<?php if ($enableStatus): ?>
									<a class="dropdown-item" onclick="deleteAction()" href="javascript:;">Delete Category</a>
									<div class="dropdown-divider"></div>
								<?php endif;
								if ($disableStatus): ?>
									<a class="dropdown-item" onclick="EnableStatus()" href="javascript:;">Enable Category</a>
									<div class="dropdown-divider"></div>
								<?php endif;
								if ($deleteStatus): ?>
									<a class="dropdown-item" onclick="DisableStatus()" href="javascript:;">Disable Category</a>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
					<?php if (check_action_permission(get_user_role(), 'manage_category', 'add_category')): ?>
						<a class="btn btn-custom-success btn-sm pull-right" title="Add" href="<?php echo base_url() ?>admin/category/add">
							<i class="fa fa-plus"></i> Add
						</a>
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
					<div class="card-body">
						<form id="myform" name="myform" method="post" action="">
							<table id="example" class="table table-bordered">
								<thead>
									<tr>
										<th>#</th>
										<th>Category ID</th>
										<th>Image</th>
										<th>Category Name</th>
										<th>Arabic Name</th>
										<th>Status</th>
										<?php if (check_action_permission(get_user_role(), 'manage_category', 'add_category')): ?>
											<th>Tools</th>
										<?php endif; ?>
									</tr>
								</thead>
								<tbody>
									<?php


									foreach ($results as $result) {
									?>
										<tr>
											<th scope="row"><input type="checkbox" name="checklist[]" value="<?php echo $result['id']; ?>"></th>
											<td><?php echo $result['id']; ?></td>
											<td><img src="<?php echo ($result['image'] !== '') ? base_url($result['image']) : base_url('assets/image/no-image.jpg'); ?>" width="50px" /></td>
											<td><?php echo $result['name']; ?></td>
											<td><?php echo $result['arabic_name']; ?></td>
											<td><?php echo $result['status'] == 1 ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>'; ?></td>
											<?php if (check_action_permission(get_user_role(), 'manage_category', 'add_category')): ?>
												<td><a class="btn btn-outline-secondary btn-custom-light btn-sm edit" href="<?php echo base_url() ?>admin/category/add?id=<?php echo $result['id']; ?>"><i class="mdi mdi-pencil font-size-18"></i></button></td>
											<?php endif; ?>
										</tr>
										<?php foreach ($result['child'] as $child) {
										?>
											<tr>
												<th scope="row"><input type="checkbox" name="checklist[]" value="<?php echo $child['id']; ?>"></th>
												<td><?php echo $child['id']; ?></td>
												<td><img src="<?php echo ($child['image'] !== '') ? base_url($child['image']) : base_url('assets/image/no-image.jpg'); ?>" width="50px" /></td>
												<td><?php echo $result['name'] . " > " . $child['name']; ?></td>
												<td><?php echo $child['arabic_name']; ?></td>
												<td><?php echo $child['status'] == 1 ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>'; ?></td>
												<?php if (check_action_permission(get_user_role(), 'manage_category', 'add_category')): ?>
													<td><a class="btn btn-outline-secondary btn-custom-light btn-sm edit" href="<?php echo base_url() ?>admin/category/add?id=<?php echo $child['id']; ?>"><i class="mdi mdi-pencil font-size-18"></i></button></td>
												<?php endif; ?>
											</tr>
											<?php foreach ($child['child'] as $sub) {
											?>
												<tr>
													<th scope="row"><input type="checkbox" name="checklist[]" value="<?php echo $sub['id']; ?>"></th>
													<td><?php echo $sub['id']; ?></td>
													<td><img src="<?php echo ($sub['image'] !== '') ? base_url($sub['image']) : base_url('assets/image/no-image.jpg'); ?>" width="50px" /></td>
													<td><?php echo $result['name'] . " > " . $child['name'] . " > " . $sub['name']; ?></td>
													<td><?php echo $sub['arabic_name']; ?></td>
													<td><?php echo $sub['status'] == 1 ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>'; ?></td>
													<?php if (check_action_permission(get_user_role(), 'manage_category', 'add_category')): ?>
														<td><a class="btn btn-outline-secondary btn-custom-light btn-sm edit" href="<?php echo base_url() ?>admin/category/add?id=<?php echo $sub['id']; ?>"><i class="mdi mdi-pencil font-size-18"></i></button></td>
													<?php endif; ?>
												</tr>
									<?php }
										}
									} ?>
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
<script>
	$(document).ready(function() {
		$('#example').dataTable({
			"lengthMenu": [
				[25, 50, 100, 500],
				[25, 50, 100, 500]
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

	function deleteAction() {
		var inputCount = $('[name="checklist[]"]:checked').length;
		if (inputCount > 0) {
			if (confirm("Do you want to delete selected category?") == true) {
				changeActionAndSubmit('admin/category/delete');
			} else {
				userPreference = "Action Cancelled!";
			}
		} else {
			alert('Plese select check box first');
		}
	}

	var EnableStatus = function() {
		var inputCount = $('[name="checklist[]"]:checked').length;
		if (inputCount > 0) {
			if (confirm("Do you want to enable selected category?") == true) {
				changeActionAndSubmit('admin/category/setStatusEnable');
			} else {
				userPreference = "Action Cancelled!";
			}
		} else {
			alert('Plese select check box first');
		}
	}

	function DisableStatus() {
		var inputCount = $('[name="checklist[]"]:checked').length;
		if (inputCount > 0) {
			if (confirm("Do you want to disable selected category?") == true) {
				changeActionAndSubmit('admin/category/setStatusDisable');
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
</script>