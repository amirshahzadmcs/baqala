<div>
	<?php echo form_open("admin/hr/employees/add-family", array("id" => "family_form", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
		<input type="hidden" name="emp_id" value="<?php echo $emp_detail->id;?>" required />
		<input type="hidden" name="redirect_path" value="<?php echo $redirect_path;?>" required />
		<!-- Tab panes -->
		<div id="ajaxRes"></div>
		<div class="row">
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="fam_name">Name in English</label>
				<input type="text" class="form-control" onKeyPress="return Alpha(event);" name="name" maxlength="150" required />
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="fam_name_ar">Name in Arabic</label>
				<input type="text" class="form-control rtl-input" name="name_ar" maxlength="150" />
			</div>
			
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="fam_gender">Gender</label>
				<select name="gender" class="form-select select2" required>
					<option value="">Select Gender</option>
					<option value="male">Male</option>
					<option value="female">Female</option>
					<option value="other">Other</option>
				</select>
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="fam_relationship">Relationship</label>
				<input type="text" class="form-control" name="relationship" maxlength="150" required />
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="fam_nationality">Nationality</label>
				<select class="form-select select2" name="nationality" required>
					<option value="">Select Nationality</option>
					<?php foreach(nationalityList() as $nation) { ?>
					<option value="<?php echo $nation->name; ?>"><?php echo $nation->name; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="fam_marital_status">Marital Status</label>
				<select name="marital_status" class="form-select select2">
					<option value="">Select Marital Status</option>
					<option value="Single">Single</option>
					<option value="Married">Married</option>
					<option value="Divorced">Divorced</option>
				</select>
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="fam_dob">Date of Birth (Gregorian)</label>
				<input type="date" class="form-control" name="dob" max="<?php echo date("Y-m-d"); ?>" />
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="fam_iqama_no">ID/Iqama Number</label>
				<input type="text" class="form-control" name="iqama_no" minlength="<?= ICAMA_LENGTH ;?>" maxlength="<?= ICAMA_LENGTH ;?>" required />
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="fam_iqama_issue_date">ID/Iqama Issue Date (Gregorian)</label>
				<input type="date" class="form-control" name="iqama_issue_date" />
			</div>

			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="fam_iqama_expiry_date">ID/Iqama Expiry Date (Gregorian)</label>
				<input type="date" name="iqama_expiry_date" class="form-control">
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="fam_iqama_issue_date_hijri">ID/Iqama Expiry Date (Hijri)</label>
				<input type="text" name="iqama_issue_date_hijri" class="form-control input-mask" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="dd-mm-yyyy" />
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="fam_passport_no">Passport Number</label>
				<input type="text" class="form-control" name="passport_no" minlength="8" maxlength="<?= PASSPORT_LENGTH;?>" />
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="passport_expiry_date">Passport Expiry Date (Gregorian)</label>
				<input type="date" name="passport_expiry_date" class="form-control">
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="fam_medical_expiry_date">Medical Insurance Expiry Date (Gregorian)</label>
				<input type="date" name="medical_expiry_date" class="form-control">
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="fam_insurance_no">Insurance Number</label>
				<input type="text" class="form-control" name="insurance_no" />
			</div>
		</div>
	<?php echo form_close(); ?>
</div>
<script type="text/javascript">
	$('.dropify').dropify();
</script>
