<div class="row tab-inner-section m-1 py-4">
	<input type="hidden" name="id" value="<?php echo $labour_laws->id;?>" required />
    <div class="col-md-12 col-sm-12 mb-3 form-group">
        <label for="leave_type">Leave Name</label>
        <input type="text" class="form-control" name="name" id="leave_name" value="<?php echo $labour_laws->name;?>" required disabled />
    </div>
    <div class="col-md-12 col-sm-12 mb-3 form-group">
        <label for="start_date">Leave Name AR</label>
        <input type="text" class="form-control" name="name_ar" id="leave_name_ar" value="<?php echo $labour_laws->name_ar;?>" required disabled />
    </div>
    <div class="col-md-12 col-sm-12 mb-3 form-group">
        <label for="end_date">Days per year</label>
        <input type="text" class="form-control" name="days_allowed_per_year" id="days_allowed_per_year" value="<?php echo $labour_laws->days_allowed_per_year;?>" min="1" max="364" required />
    </div>
    <div class="col-md-12 col-sm-12 mb-2 form-group">
		<input class="form-check-input" type="checkbox" id="extend_probation" name="extend_probation" <?php echo $labour_laws->extend_probation == 'yes' ? 'checked' : ''; ?>>
		<label class="form-check-label" for="extend_probation">Extend for Probation Period employees</label>
	</div>
</div>
