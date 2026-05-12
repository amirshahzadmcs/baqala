<div>
    <?php echo form_open("admin/hr/employees/update-family", array("id" => "family_form", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
        <input type="hidden" name="emp_id" value="<?php echo $emp_detail->id;?>" required />
        <input type="hidden" name="key_id" value="<?php echo $key_id;?>" required />
        <input type="hidden" name="redirect_path" value="<?php echo $redirect_path;?>" required />
        <!-- Tab panes -->
        <div id="ajaxRes"></div>
        <div class="row">
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="fam_name">Name in English</label>
				<input type="text" class="form-control" onKeyPress="return Alpha(event);" name="name" value="<?php echo $fam_contact['name'];?>" maxlength="150" />
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="fam_name_ar">Name in Arabic</label>
				<input type="text" class="form-control rtl-input" name="name_ar" maxlength="150" value="<?php echo $fam_contact['name_ar'];?>" />
			</div>
			
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="fam_gender">Gender</label>
				<select name="gender" class="form-select select2">
					<option value="">Select Gender</option>
					<option value="male" <?php echo ($fam_contact['gender'] == 'male') ? ' selected ' : '' ?>>Male</option>
					<option value="female" <?php echo ($fam_contact['gender'] == 'female') ? ' selected ' : '' ?>>Female</option>
					<option value="other" <?php echo ($fam_contact['gender'] == 'other') ? ' selected ' : '' ?>>Other</option>
				</select>
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="fam_relationship">Relationship</label>
				<input type="text" class="form-control" name="relationship" value="<?php echo $fam_contact['relationship'];?>" maxlength="150" />
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="fam_nationality">Nationality</label>
				<select class="form-select select2" name="nationality">
					<option value="">Select Nationality</option>
					<?php foreach(nationalityList() as $nation) { ?>
					<option value="<?php echo $nation->name; ?>" <?php echo ($nation->id == $fam_contact['nationality']) ? ' selected ' : '' ?>><?php echo $nation->name; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="fam_marital_status">Marital Status</label>
				<select name="marital_status" class="form-select select2">
					<option value="">Select Marital Status</option>
					<option value="Single" <?php echo ($fam_contact['marital_status'] == 'Single') ? ' selected ' : '' ?>>Single</option>
					<option value="Married" <?php echo ($fam_contact['marital_status'] == 'Married') ? ' selected ' : '' ?>>Married</option>
					<option value="Divorced" <?php echo ($fam_contact['marital_status'] == 'Divorced') ? ' selected ' : '' ?>>Divorced</option>
				</select>
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="fam_dob">Date of Birth (Gregorian)</label>
				<input type="date" class="form-control" name="dob" max="<?php echo date("Y-m-d"); ?>" value="<?php echo $fam_contact['dob'];?>" />
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="fam_iqama_no">ID/Iqama Number</label>
				<input type="text" class="form-control" name="iqama_no" minlength="<?= ICAMA_LENGTH ;?>" maxlength="<?= ICAMA_LENGTH ;?>" value="<?php echo $fam_contact['iqama_no'];?>" />
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="fam_iqama_issue_date">ID/Iqama Issue Date (Gregorian)</label>
				<input type="date" class="form-control" name="iqama_issue_date" value="<?php echo $fam_contact['iqama_issue_date'];?>" />
			</div>

			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="fam_iqama_expiry_date">ID/Iqama Expiry Date (Gregorian)</label>
				<input type="date" name="iqama_expiry_date" class="form-control" value="<?php echo $fam_contact['iqama_expiry_date'];?>">
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="fam_iqama_issue_date_hijri">ID/Iqama Expiry Date (Hijri)</label>
				<input type="text" name="iqama_issue_date_hijri" class="form-control input-mask" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="dd-mm-yyyy" value="<?php echo (isset($fam_contact['iqama_issue_date_hijri']) && ($fam_contact['iqama_issue_date_hijri'] !== '0000-00-00')) ? date('d-m-Y', strtotime($fam_contact['iqama_issue_date_hijri'])) : '';?>" />
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="fam_passport_no">Passport Number</label>
				<input type="text" class="form-control" name="passport_no" minlength="8" maxlength="<?= PASSPORT_LENGTH;?>" value="<?php echo $fam_contact['passport_no'];?>" />
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="passport_expiry_date">Passport Expiry Date (Gregorian)</label>
				<input type="date" name="passport_expiry_date" class="form-control" value="<?php echo $fam_contact['passport_expiry_date'];?>">
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="fam_medical_expiry_date">Medical Insurance Expiry Date (Gregorian)</label>
				<input type="date" name="medical_expiry_date" class="form-control" value="<?php echo $fam_contact['medical_expiry_date'];?>">
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="fam_insurance_no">Insurance Number</label>
				<input type="text" class="form-control" name="insurance_no" value="<?php echo $fam_contact['insurance_no'];?>" />
			</div>
		</div>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript">
	$('.dropify').dropify();
</script>
