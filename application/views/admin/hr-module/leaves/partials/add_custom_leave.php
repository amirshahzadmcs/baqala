<?php echo form_open("admin/hr-module/leave-types/save-custom-leave", array("id" => "addCustomLeaveForm", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
	<div class="row tab-inner-section m-1 py-4">
		<div class="col-md-12 col-sm-12 mb-3 form-group">
			<label for="leave_type">Leave Name</label>
			<input type="text" class="form-control" name="name" id="leave_name" placeholder="Name in English" required />
		</div>
		<div class="col-md-12 col-sm-12 mb-3 form-group">
			<label for="start_date">Leave Name AR</label>
			<input type="text" class="form-control rtl-input" name="name_ar" id="leave_name_ar" placeholder="Name in Arabic" required />
		</div>
		<div class="col-md-12 col-sm-12 mb-3 form-group">
			<label for="end_date">Days per year</label>
			<input type="text" class="form-control" name="days_allowed_per_year" id="days_allowed_per_year" min="1" max="364" required />
		</div>
		<div class="col-md-12 col-sm-12 mb-2 form-group">
			<input class="form-check-input" type="checkbox" id="extend_probation" name="extend_probation">
			<label class="form-check-label" for="extend_probation">Extend for Probation Period employees</label>
		</div>
	</div>
<?php echo form_close(); ?>
