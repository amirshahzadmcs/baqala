<div class="modal-header">
	<h5 class="modal-title mt-0">Edit Sponsor</h5>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
	<form data-parsley-validate="" id="sponsorForm" method="POST" action="<?php echo base_url('admin/master/sponsors/update');?>">
        <input type="hidden" name="id" value="<?= $sponsor_detail['id'];?>" required>
		<div class="row">
			<div class="col-md-12">
				<div class="mb-3">
					<label for="employer_id" class="form-label">Employer ID <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="employer_id" name="employer_id" value="<?= $sponsor_detail['employer_id'];?>" required>
					<div class="invalid-feedback">
						Please provide a employer id.
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="mb-3">
					<label for="employer_name" class="form-label">Employer Name <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="employer_name" name="employer_name" value="<?= $sponsor_detail['employer_name'];?>" required>
					<div class="invalid-feedback">
						Please provide a employer name.
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="mb-3">
					<label for="employer_arabic_name" class="form-label">Employer Name (Arabic)</label>
					<input type="text" class="form-control rtl-input" id="employer_arabic_name" name="employer_arabic_name" value="<?= $sponsor_detail['employer_arabic_name'];?>">
					<div class="invalid-feedback">
						Please provide a employer name in arabic.
					</div>
				</div>
			</div>
            <div class="col-md-12">
				<div class="mb-3">
					<label for="employer_cr_no" class="form-label">CR Number <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="employer_cr_no" name="employer_cr_no" value="<?= $sponsor_detail['employer_cr_no'];?>" required>
					<div class="invalid-feedback">
						Please provide a employer cr no.
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="mb-3">
					<label for="mol_id" class="form-label">MOL ID</label>
					<input type="text" class="form-control" id="mol_id" name="mol_id" minlength="<?= MOL_LENGTH;?>" maxlength="<?= MOL_LENGTH;?>" value="<?= $sponsor_detail['mol_id'];?>">
					<div class="invalid-feedback">
						Please provide a MOL ID.
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="mb-3">
					<label for="employer_address" class="form-label">Address</label>
					<input type="text" class="form-control" id="employer_address" name="employer_address" value="<?= $sponsor_detail['employer_address'];?>">
					<div class="invalid-feedback">
						Please provide a address.
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="mb-3">
					<label for="employer_work_location" class="form-label">Work Location</label>
					<input type="text" class="form-control" id="employer_work_location" name="employer_work_location" value="<?= $sponsor_detail['employer_work_location'];?>">
					<div class="invalid-feedback">
						Please provide a employer work location.
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="mb-3">
					<label for="employer_email" class="form-label">Email Address</label>
					<input type="text" class="form-control" id="employer_email" name="employer_email" value="<?= $sponsor_detail['employer_email'];?>">
					<div class="invalid-feedback">
						Please provide a email address.
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="mb-3">
					<label for="represented_by" class="form-label">Represented by</label>
					<input type="text" class="form-control" id="represented_by" name="represented_by" value="<?= $sponsor_detail['represented_by'];?>">
					<div class="invalid-feedback">
						Please provide a represented by.
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
	<button type="submit" form="sponsorForm" class="btn btn-success">Update</button>
</div>
