<h6>Upload Visa Copy of <span class="text-primary"><?php echo $name;?></span></h6>
<form id="upload_form" action="<?php echo base_url('hiring-agency/cv/upload-certificates'); ?>" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="cv_id" value="<?php echo $id;?>" required>
	<input type="hidden" name="doc_type" value="<?php echo $type;?>" required>
	<div class="row">
		<div class="form-group col-lg-12 col-md-12 col-12 mb-3">
			<label for="attachments">Upload Visa Copy<span class="text-danger">*</span></label>
			<input type="file" class="form-control" id="attachments" required name="attachments[]" multiple />
		</div>
		<div class="form-group col-lg-3 col-md-12 col-12 mb-3">
			<input type="submit" value="Upload" class="form-control btn btn-custom-success" />
		</div>
	</div>
</form>
