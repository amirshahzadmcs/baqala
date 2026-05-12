<div class="row">
	<div class="col-12 mx-auto">
		<div class="card">
			<div class="card-body pb-2">
				<form class="needs-validation" method="POST" action="<?php echo base_url('admin/modules/submit'); ?>" novalidate>
					<input type="hidden" name="id" value="<?= $result->id; ?>" required />
					<div class="row">
						<div class="col-md-12">
							<div class="mb-3">
								<label class="control-label" for="perm_group_id">Parent Group</label>
								<select class="form-control select2" name="perm_group_id" data-placeholder="Choose Group..." required>
									<option value="0" <?php echo ($result->perm_group_id == '0') ? "selected" : "" ?>>No Parent</option>
									<?php foreach ($category_list as $category) { ?>
										<option value="<?php echo $category['id']; ?>" <?php echo ($category['id'] == $result->perm_group_id) ? "selected" : "" ?>><?php echo $category['name']; ?></option>
										<?php foreach ($category['child'] as $child) { ?>
											<option value="<?php echo $child['id']; ?>" <?php echo ($child['id'] == $result->perm_group_id) ? "selected" : "" ?>><?php echo $category['name'] . " > " . $child['name']; ?></option>
											<?php foreach ($child['child'] as $sub_child) { ?>
												<option value="<?php echo $sub_child['id']; ?>" <?php echo ($sub_child['id'] == $result->perm_group_id) ? "selected" : "" ?>><?php echo $category['name'] . " > " . $child['name'] . " > " . $sub_child['name']; ?></option>
												<?php foreach ($sub_child['child'] as $grand_child) { ?>
													<option value="<?php echo $grand_child['id']; ?>" <?php echo ($grand_child['id'] == $result->perm_group_id) ? "selected" : "" ?>><?php echo $category['name'] . " > " . $child['name'] ." > " . $sub_child['name'] . " > " . $grand_child['name']; ?></option>
									<?php } }
										}
									} ?>
								</select>
							</div>
						</div>
						<div class="col-md-12">
							<div class="mb-3">
								<label for="name" class="form-label">Module Name <span class="text-danger">*</span></label>
								<input type="text" class="form-control" id="name" placeholder="Module Name" name="name" value="<?= $result->name; ?>" required>
								<div class="invalid-feedback">
									Please provide a module name.
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="mb-3">
								<label for="short_code" class="form-label">Module Code <span class="text-danger">*</span></label>
								<input type="text" class="form-control" id="short_code" placeholder="Module Short Code" name="short_code" value="<?= $result->short_code; ?>" required>
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
									<option value="1" <?php echo ($result->status == '1') ? "selected" : ""; ?>>Active</option>
									<option value="0" <?php echo ($result->status == '0') ? "selected" : ""; ?>>Deactive</option>
								</select>
								<div class="invalid-feedback">
									Please provide a status.
								</div>
							</div>
						</div>

						<label for="short_code" class="form-label">Define Methods <span class="text-danger"> (optional)</span></label>
						<div class="col-md-2 align-content-around">
							<div class="mb-3">
								<button type="button" class="btn-custom-success addMoreMethod" action_type="edit"><i class="fa fa-plus"></i></button>
							</div>
						</div>
						<div id="methodDataEdit">

						</div>

					</div>

					<div>
						<button class="btn btn-custom-success" type="submit">Submit form</button>
					</div>
				</form>
			</div>
		</div>
	</div> <!-- end col -->


</div> <!-- end row -->