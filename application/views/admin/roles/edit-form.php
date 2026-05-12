<div class="row">
	<div class="col-12 mx-auto">
		<div class="card">
			<div class="card-body pb-2">
				<form class="needs-validation" method="POST" action="<?php echo base_url('admin/roles/submit'); ?>" novalidate>
					<input type="hidden" name="id" value="<?= $id; ?>" required />
					<div class="row">
						<div class="col-md-12">
							<div class="mb-3">
								<label for="name" class="form-label">Role Name <span class="text-danger">*</span></label>
								<input type="text" class="form-control" id="name" placeholder="Role Name" name="name" value="<?= $name; ?>" required>
								<div class="invalid-feedback">
									Please provide a role name.
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="mb-3">
								<label for="name" class="form-label">Arabic Name</label>
								<input type="text" class="form-control" id="ar_name" placeholder="Role Arabic Name" name="ar_name" value="<?= $arabic_name; ?>" required>
								<div class="invalid-feedback">
									Please provide a role name.
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="mb-3">
								<label for="status-select" class="form-label">Status <span class="text-danger">*</span></label>
								<select class="form-select" name="is_active" id="status-select" required>
									<option value="">--- Select Status ---</option>
									<option value="1" <?php echo ($is_active == '1') ? "selected" : ""; ?>>Active</option>
									<option value="0" <?php echo ($is_active == '0') ? "selected" : ""; ?>>Deactive</option>
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
									<option value="1" <?php //echo ($is_superadmin == '1') ? "selected":"";
														?>>Yes</option>
									<option value="0" <?php //echo ($is_superadmin == '0') ? "selected":"";
														?>>No</option>
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
	</div> <!-- end col -->


</div> <!-- end row -->