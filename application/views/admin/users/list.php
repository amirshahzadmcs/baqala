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
					<h4>User Management</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="javascript:;">User</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if (check_action_permission(get_user_role(), 'users', 'delete')): ?>
						<button type="button" class="btn btn-custom-danger btn-sm pull-right me-1" onclick="deleteAction()" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					<?php endif;
					if (check_action_permission(get_user_role(), 'users', 'setStatusEnable')): ?>
						<button type="button" class="btn btn-custom-success btn-sm pull-right me-1" onclick="EnableStatus()" title="Enable"><i class="fa fa-eye"></i> Enable</button>
					<?php endif;
					if (check_action_permission(get_user_role(), 'users', 'setStatusDisable')): ?>
						<button type="button" class="btn btn-custom-danger btn-sm pull-right me-1" onclick="DisableStatus()" title="Disable"><i class="fa fa-ban"></i> Disable</button>
					<?php endif;
					if (check_action_permission(get_user_role(), 'users', 'add')): ?>
						<a class="btn btn-custom-success btn-sm pull-right me-1" title="Add" href="<?php echo base_url() ?>admin/users/add"><i class="fa fa-plus"></i> Add User</a>
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
					<div class="card-body">
						<form id="myform" name="myform" method="post" action="">
							<table id="vendor-table" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
								<thead>
									<tr>
										<th>#</th>
										<th>Name</th>
										<th>Username</th>
										<th>Role</th>
										<th>Status</th>
										<th>Tools</th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($results as $result) {
									?>
										<tr>
											<th scope="row"><input type="checkbox" name="checklist[]" value="<?php echo $result->admin_id; ?>"></th>
											<td><?php echo $result->name; ?></td>
											<td><?php echo $result->username; ?></td>
											<td><?php echo $result->role_name; ?></td>
											<td><?php echo $result->status == 1 ? '<div class="badge badge-pill badge-soft-success font-size-13">Enabled</div>' : '<div class="badge badge-pill badge-soft-danger font-size-13">Disabled</div>'; ?></td>
											<td><a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="<?php echo base_url() ?>admin/users/add?id=<?php echo $result->admin_id; ?>"><i class="mdi mdi-pencil font-size-18"></i></a></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</form>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<div class="modal fade staticBackdrop fixed-left addCashModal" id="addCashModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="#addCashModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">

		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php $this->load->view('admin/home/footer'); ?>
<script>
	function deleteAction() {
		var inputCount = $('[name="checklist[]"]:checked').length;
		if (inputCount > 0) {
			if (confirm("Do you want to delete selected users?") == true) {
				changeActionAndSubmit('admin/users/delete');
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
			if (confirm("Do you want to enable selected users?") == true) {
				changeActionAndSubmit('admin/users/status-enable');
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
			if (confirm("Do you want to disable selected users?") == true) {
				changeActionAndSubmit('admin/users/status-disable');
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