<div class="modal-header">
	<h5 class="modal-title mt-0">Edit Insurance Company</h5>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
	<form data-parsley-validate="" id="editInsuranceForm" method="POST" action="<?php echo base_url('admin/master/insurance-company/save');?>">
		<input type="hidden" id="id" name="id" value="<?php echo $detail->id;?>" required>
		<div class="row">
			<div class="col-md-12">
				<div class="mb-3">
					<label for="company_name" class="form-label">Company Name <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="company_name" name="company_name" value="<?php echo $detail->company_name;?>" required>
					<div class="invalid-feedback">
						Please provide a company name.
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="mb-3">
					<label for="company_name_ar" class="form-label">Company Name (Arabic) <span class="text-danger">*</span></label>
					<input type="text" class="form-control rtl-input" id="company_name_ar" name="company_name_ar" value="<?php echo $detail->company_name_ar;?>" required>
					<div class="invalid-feedback">
						Please provide a company name in arabic.
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
