<form id="upload_form" action="<?php echo base_url('admin/hr/master/employee/submit-documents'); ?>" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="emp_id" value="<?php echo $empid;?>" required>
	<input type="hidden" name="doc_type" value="<?php echo $type;?>" required>
	<div class="row">
		<div class="form-group col-lg-12 col-md-12 col-12 mb-3">
			<label for="attachments">Upload File <span class="text-danger">*</span></label>
			<input type="file" class="form-control" id="attachments" required name="attachments[]" multiple />
		</div>
		<div class="form-group col-lg-12 col-md-12 col-12 mb-3">
			<label for="doc_category">Select Category <span class="text-danger">*</span></label>
			<select name="doc_category" id="doc_category" class="form-select" required>
				<option value="">Select Category</option>
				<option value="my_documents">My Documents</option>
				<option value="shared_documents">Shared Documents</option>
				<option value="my_hr_letter">My Hr Letter</option>
			</select>
		</div>
		<div class="form-group col-lg-12 col-md-12 col-12 mb-3">
			<input type="submit" value="Upload" class="btn btn-custom-success float-end" />
		</div>
	</div>
</form>
