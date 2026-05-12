<div class="modal-header">
	<h5 class="modal-title mt-0">Edit Insurance Policy Class</h5>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
	<form data-parsley-validate="" id="editInsuranceForm" method="POST" action="<?php echo base_url('admin/master/insurance-type/save');?>">
		<input type="hidden" id="id" name="id" value="<?php echo $detail->id;?>" required>
		<div class="row">
			<div class="col-md-12">
				<div class="mb-3">
					<label for="insurance_type" class="form-label">Policy Class (English) <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="insurance_type" value="<?php echo $detail->insurance_type;?>" name="insurance_type" required>
					<div class="invalid-feedback">
						Please provide a insurance policy class in english.
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="mb-3">
					<label for="insurance_type_ar" class="form-label">Policy Class (Arabic) <span class="text-danger">*</span></label>
					<input type="text" class="form-control rtl-input" id="insurance_type_ar" value="<?php echo $detail->insurance_type_ar;?>" name="insurance_type_ar" required>
					<div class="invalid-feedback">
						Please provide a insurance policy class in arabic.
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="mb-3">
					<label for="status-select" class="form-label">Status <span class="text-danger">*</span></label>
					<select id="status-select" name="status" class="form-select" required>
						<option value="active" <?php echo ($detail->status == 'active') ? "selected":"";?>>Active</option>
						<option value="inactive" <?php echo ($detail->status == 'inactive') ? "selected":"";?>>Deactive</option>
					</select>
					<div class="invalid-feedback">
						Please provide a status.
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
	<button type="submit" form="editInsuranceForm" class="btn btn-success">Save</button>
</div>
