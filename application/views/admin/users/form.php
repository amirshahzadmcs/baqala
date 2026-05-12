<?php $this->load->view('admin/home/header'); ?>
<style>
	.changePasswordModal .modal-dialog-aside {
		width: 30%;
		max-width: 80%;
		height: 100%;
		margin: 0;
		transform: translate(0);
		transition: transform .2s;
	}

	.changePasswordModal .modal-dialog-aside .modal-content {
		height: inherit;
		border: 0;
		border-radius: 0;
	}

	.changePasswordModal .modal-dialog-aside .modal-content .modal-body {
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
					<h4>User Management</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?= base_url('admin/users/list');?>">User</a></li>
						<li class="breadcrumb-item active">Create or Edit</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url('admin/users/list'); ?>"><i class="fa fa-reply"></i> Back</a>
					&nbsp;
					<?php if ($this->input->get('id') && check_action_permission(get_user_role(), 'users', 'changePassword')): ?>
						<a type="button" class="btn btn-sm btn-custom-danger pull-right" title="Change Password" data-bs-toggle="modal" data-bs-target="#changePasswordModal"> Change Password</a>
					<?php endif; ?>
					&nbsp;
					<button form="demo-form2" type="submit" class="btn btn-sm btn-custom-success pull-right" title="Save"><i class="fa fa-save"></i> Save</button>
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
				<?php }
				}
				$this->admin->removeInfo();  ?>
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
						<h5 class="scheduler-border">Individual User:</h5>
						<?php echo form_open("admin/users/submit", ["id" => "demo-form2", "enctype" => "multipart/form-data", "class" => "form-horizontal form-label-left custom-validation"]); ?>
						<input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
						<input type="hidden" id="password1" name="password1" value="<?php echo $password; ?>">
						<div class="form-group row mb-2">
							<label for="role" class="col-md-3 col-form-label">Employee Id<span class="text-danger">*</span></label>
							<div class="col-md-6">
								<?php if ($this->input->get('id')): ?>
									<input type="text" class="form-control" value="<?php echo $username; ?>" readonly>
								<?php else: ?>
									<select class="form-select select2" id="employeeId" name="employee_id" required>
										<option value="">--Choose Employee--</option>
										<?php foreach ($employees as $emp): $designation_name = ($emp->designation != '') ? designationInfo($emp->designation) : 'N/A';?>
											<option value="<?php echo $emp->id; ?>" <?php echo $username == $emp->emp_no ? 'selected' : ''; ?>><?php echo $emp->emp_no .' -'.$emp->full_name.'- ('.$designation_name->name.')';?></option>
										<?php endforeach; ?>
									</select>
								<?php endif; ?>
							</div>
						</div>
						<div class="form-group row mb-2">
							<label for="role" class="col-md-3 col-form-label">Role <span class="text-danger">*</span></label>
							<div class="col-md-6">
								<select class="form-select" name="role" required>
									<option value="">--Choose Role--</option>
									<?php foreach ($roles as $rol): ?>
										<option value="<?php echo $rol->id; ?>" <?php echo $role == $rol->id ? 'selected' : ''; ?>><?php echo $rol->name . (!empty($rol->arabic_name) ? ' (' . $rol->arabic_name . ')' : ''); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group row mb-2">
							<label for="name" class="col-md-3 col-form-label">Name <span class="text-danger">*</span></label>
							<div class="col-md-6">
								<input type="text" id="name" name="name" value="<?php echo $name; ?>" required class="form-control" readonly>
							</div>
						</div>

						<div class="form-group row mb-2">
							<label for="email" class="col-md-3 col-form-label">Email <span class="text-danger">*</span></label>
							<div class="col-md-6">
								<input type="email" id="email" name="email" value="<?php echo $email; ?>" required class="form-control" readonly>
							</div>
						</div>

						<div class="form-group row mb-2">
							<label for="mobile" class="col-md-3 col-form-label">Mobile <span class="text-danger">*</span></label>
							<div class="col-md-6">
								<input type="text" onKeyPress="return numerics(event);" class="form-control" id="mobile" name="mobile"  maxlength="<?= MOB_LENGTH; ?>" value="<?php echo $mobile; ?>" readonly />
							</div>
						</div>

						<div class="form-group row mb-2">
							<label for="username" class="col-md-3 col-form-label">Username <span class="text-danger">*</span></label>
							<div class="col-md-6">
								<input type="text" id="username" name="username" value="<?php echo $username; ?>" required class="form-control" readonly>
							</div>
						</div>

						<?php if (empty($id)) { ?>
							<div class="form-group row mb-2">
								<label for="password" class="col-md-3 col-form-label">Password <span class="text-danger">*</span></label>
								<div class="col-md-6">
									<input type="password" id="password" name="password" required class="form-control">
								</div>
							</div>
						<?php } ?>
						<div class="form-group row mb-2">
							<label for="user_status" class="col-md-3 col-form-label">Status</label>
							<div class="col-md-6">
								<select id="user_status" name="status" class="form-select" required>
									<option value="1" <?php echo ($status === '1') ? "selected" : ""; ?>>Enable</option>
									<option value="0" <?php echo ($status === '0') ? "selected" : ""; ?>>Disable</option>
								</select>
							</div>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->

	</div>
</div>
<!-- container-fluid -->
<?php $this->load->view('admin/home/footer'); ?>
<div class="modal fade fixed-left changePasswordModal" id="changePasswordModal" aria-labelledby="#changePasswordModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0" id="changePasswordModalLabel">Change Password</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="password_form" action="<?php echo base_url('admin/users/password-change'); ?>" method="POST" data-parsley-validate="">
					<input type="hidden" name="emp_id" value="<?php echo $id; ?>" required>
					<div class="row">
						<div class="form-group col-lg-12 col-md-12 col-12 mb-3">
							<label for="password">New Password <span class="text-danger">*</span></label>
							<input type="password" class="form-control" id="password" name="password" minlength="6" maxlength="50" suggestion="on" autocomplete="on" required />
						</div>
						<div class="form-group col-lg-12 col-md-12 col-12 mb-3">
							<label for="confirm_password">Confirm New Password <span class="text-danger">*</span></label>
							<input type="password" class="form-control" id="confirm_password" name="confirm_password" minlength="6" maxlength="50" autocomplete="on" suggestion="on" required />
						</div>
						<!-- <div class="form-group col-lg-12 col-md-12 col-12 mb-1">
							<input class="checkbox" type="checkbox" id="send_credential" name="send_credential" style="vertical-align: sub;margin-right: 10px;">
							<label class="form-check-label" for="send_credential">
							Send credentials to user on email
							</label>
						</div>
						<p class="hint"> (Check if you want to send credential to User.)</p> -->
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button type="submit" form="password_form" class="btn btn-custom-success">Change Password</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<script>
	function numerics(key) {
		//getting key code of pressed key
		var keycode = (key.which) ? key.which : key.keyCode;
		//comparing pressed keycodes
		if (keycode > 31 && (keycode < 48 || keycode > 57)) {
			alert("You can enter only characters 0 to 9 ");
			return false;
		} else return true;
	}

	$('#employeeId').on('change', function() {
		var emp_id = $(this).val();
		$.get('admin/users/search-emp', {
			emp_id: emp_id
		}, (response) => {
			if (response.status) {
				var emp = response.employee;
				$('#name').val(emp.full_name);
				$('#email').val(emp.email);
				$('#mobile').val(emp.alloted_mobile);
				$('#username').val(emp.emp_no);
			}
		}, "Json").fail((error) => {});
	});
</script>