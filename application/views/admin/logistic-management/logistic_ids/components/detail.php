<style> 
#responseContainer{
	position: fixed;
    width: 93%;
    top: 60px;
}
</style>
<div class="modal-header">
	<h5 class="modal-title mt-0" id="addRiderModalLabel">Aggregator Detail</h5>
	<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
	<div class="size-inner-section px-1 py-1 mx-1">
		<div class="card-header"><span class="text-danger">*</span> Marked field is required.</div>
		<div class="row p-2">
			<div class="col-md-12 col-sm-12 mb-2 form-group">
				<label for="request_date">Requested Date <span class="text-danger">*</span></label>
				<input type="date" class="form-control" id="request_date" name="request_date" value="<?php echo $id_detail['request_date'];?>" required disabled />
			</div>

			<div class="col-md-12 col-sm-12 mb-2 form-group">
				<label for="platform_id">Platform <span class="text-danger">*</span></label>
				<select name="platform_id" id="platform_id" class="form-select" required disabled>
					<option value="">Select Platform</option>
					<?php foreach(fdCompanyHelper() as $fdcompany) { ?>
						<option value="<?php echo $fdcompany->id; ?>" <?php echo ($fdcompany->id == $id_detail['platform_id']) ? ' selected ' : '';?>><?php echo $fdcompany->company_name; ?></option>
					<?php } ?>
				</select>
			</div>

			<div class="col-md-12 col-sm-12 mb-2 form-group">
				<label for="id_type">ID Type <span class="text-danger">*</span></label>
				<select name="id_type" id="id_type" class="form-select" disabled>
					<option value="">Select ID Type</option>
					<option value="Freelancer" <?php echo ($id_detail['id_type'] == 'Freelancer') ? ' selected ' : '';?>>Freelancer</option>
					<option value="Company" <?php echo ($id_detail['id_type'] == 'Company') ? ' selected ' : '';?>>Company</option>
				</select>
			</div>

			<div class="col-md-12 col-sm-12 mb-2 form-group">
				<label for="id_number">ID Number <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="id_number" name="id_number" value="<?php echo $id_detail['id_number'];?>" required disabled />
			</div>
			
			<div class="col-md-12 col-sm-12 mb-2 form-group">
				<label for="owner_id">ID Owner <span class="text-danger">*</span></label>
				<select name="owner_id" id="owner_id" class="form-select select2" required disabled>
					<option value="">Select Owner</option>
					<?php if(!empty(employeeListHelper())){ foreach(employeeListHelper() as $emp_list){ ?>
					<option value="<?php echo $emp_list->id; ?>" <?php echo ($emp_list->id == $id_detail['owner_id']) ? ' selected ' : '';?>><?php echo $emp_list->emp_no; ?> - <?php echo $emp_list->full_name; ?> (<?php echo $emp_list->designation_name; ?>)</option>
					<?php }}else{ echo '<option value="">No employee found, add new employee first</option>';} ?>
				</select>
			</div>

			<div class="col-md-12 col-sm-12 mb-2 form-group">
				<label for="activation_date">Activation Date</label>
				<input type="date" class="form-control" id="activation_date" name="activation_date" value="<?php echo $id_detail['activation_date'];?>" disabled />
			</div>

			<div class="col-md-12 col-sm-12 mb-2 form-group">
				<label for="rider_status">Status <span class="text-danger">*</span></label>
				<select name="status" id="rider_status" class="form-select" required disabled>
					<option value="">Select ID Type</option>
					<option value="active" <?php echo ($id_detail['status'] == 'active') ? ' selected ' : '';?>>Active</option>
					<option value="inactive" <?php echo ($id_detail['status'] == 'inactive') ? ' selected ' : '';?>>Inactive</option>
					<option value="terminated" <?php echo ($id_detail['status'] == 'terminated') ? ' selected ' : '';?>>Terminated</option>
				</select>
			</div>

			<div class="col-md-12 col-sm-12 mb-2 form-group">
				<label for="created_at">Created Date</label>
				<input type="text" class="form-control" id="created_at" name="created_at" value="<?php echo date('d-m-Y h:i A', strtotime($id_detail['created_at']));?>" disabled />
			</div>

			<div class="col-md-12 col-sm-12 mb-2 form-group">
				<label for="updated_at">Updated Date</label>
				<input type="text" class="form-control" id="updated_at" name="updated_at" value="<?php if(!empty($id_detail['updated_at'])){ echo date('d-m-Y h:i A', strtotime($id_detail['updated_at']));}?>" disabled />
			</div>
			
		</div>
	</div>
	<?php if($id_detail['status'] == 'terminated'){ ?>
	<div id="terminatedSection" class="size-inner-section px-1 py-1 mx-1">
		<div class="card-header">Terminate Detail</div>
		<div class="row p-2">
			<div class="col-md-12 col-sm-12 mb-2 form-group">
				<label for="termination_date">Termination Date</label>
				<input type="date" class="form-control" id="termination_date" value="<?= $id_detail['termination_date'];?>" name="termination_date" disabled />
			</div>
			<div class="col-md-12 col-sm-12 mb-2 form-group">
				<label for="reason">Termination Reason</label>
				<textarea class="form-control" id="reason" name="reason" rows="3" disabled><?= $id_detail['reason'];?></textarea>
			</div>
		</div>
	</div>
	<?php } ?>
</div>
