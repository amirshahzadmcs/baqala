<?php echo form_open("admin/hr-module/leave-types/update-holidays", array("id" => "updateHolidayForm", "class" => "form-label-left", "data-parsley-validate" => "")); ?>

<input type="hidden" name="id" value="<?php echo set_value('id', $holidays['id']); ?>" />

<div class="row tab-inner-section m-1 py-4">
    <div class="col-md-12 col-sm-12 mb-3 form-group">
        <label for="holiday_name">Holiday name in En</label>
        <input type="text" class="form-control" name="holiday_name" id="holiday_name" placeholder="Name in English" value="<?php echo set_value('holiday_name', $holidays['holiday_name']); ?>" required />
    </div>
    <div class="col-md-12 col-sm-12 mb-3 form-group">
        <label for="holiday_name_ar">Holiday name in Ar</label>
        <input type="text" class="form-control rtl-input" name="holiday_name_ar" id="holiday_name_ar" placeholder="Name in Arabic" value="<?php echo set_value('holiday_name_ar', $holidays['holiday_name_ar']); ?>" required />
    </div>
    <div class="col-md-6 col-sm-12 mb-3 form-group">
        <label for="date_from">From date</label>
        <input type="date" class="form-control" name="date_from" id="date_from" value="<?php echo set_value('date_from', $holidays['date_from']); ?>" required />
    </div>
    <div class="col-md-6 col-sm-12 mb-3 form-group">
        <label for="date_to">To date</label>
        <input type="date" class="form-control" name="date_to" id="date_to" value="<?php echo set_value('date_to', $holidays['date_to']); ?>" required />
    </div>

	<div class="col-md-12 col-sm-12 form-group">
		<div class="card text-dark bg-info-light">
			<div class="card-body p-3">
				<blockquote class="card-bodyquote mb-0">
					<div class="d-flex">
						<div class="form-check mb-1">
							<input class="form-check-input" type="radio" name="group_type" id="group_type1" value="all_company" <?php echo ($holidays['group_type'] == 'all_company') ? 'checked' : ''; ?>>
							<label class="form-check-label" for="group_type1">
								All employees
							</label>
						</div>
					</div>
				</blockquote>
			</div>
		</div>
	</div>
	<div class="col-md-12 col-sm-12 form-group">
		<div class="card text-dark bg-light">
			<div class="card-body p-3">
				<blockquote class="card-bodyquote mb-0">
					<div class="d-flex">
						<div class="form-check mb-1">
							<input class="form-check-input" type="radio" name="group_type" id="group_type2" value="category_type" <?php echo ($holidays['group_type'] == 'category_type') ? 'checked' : ''; ?>>
							<label class="form-check-label" for="group_type2">
								By Group
							</label>
						</div>
					</div>
				</blockquote>
				<div id="returnGroup" class="col-md-12 col-sm-12" style="display: <?php echo ($holidays['group_type'] == 'category_type') ? 'block' : 'none'; ?>;">
					<div class="form-group mb-2">
						<label class="form-label"><small>Location</small></label>
						<div class="">
							<select name="location[]" id="location" class="form-select select2" multiple="multiple">
								<?php foreach(masterLocationHelper() as $mlocation) { ?>
									<option value="<?php echo $mlocation->id; ?>" <?php echo (in_array($mlocation->id, json_decode($holidays['location'], true))) ? 'selected' : ''; ?>>
										<?php echo $mlocation->location_name; ?>
									</option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group mb-2">
						<label class="form-label"><small>Department</small></label>
						<div class="">
							<select name="departments[]" id="departments" class="form-select select2" multiple="multiple">
								<?php foreach(masterDepartments() as $mdepartment) { ?>
									<option value="<?php echo $mdepartment->id; ?>" <?php echo (in_array($mdepartment->id, json_decode($holidays['departments'], true))) ? 'selected' : ''; ?>>
										<?php echo $mdepartment->name; ?>
									</option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group mb-2">
						<label class="form-label"><small>Business unit</small></label>
						<div class="">
							<select name="business_unit[]" id="business_unit" class="form-select select2" multiple="multiple">
								<?php foreach(allBusinessUnitHelper() as $mbusiness) { ?>
									<option value="<?php echo $mbusiness->id; ?>" <?php echo (in_array($mbusiness->id, json_decode($holidays['business_unit'], true))) ? 'selected' : ''; ?>>
										<?php echo $mbusiness->business_unit_name; ?>
									</option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

    <div class="col-md-12 col-sm-12 mb-2 form-group">
        <input class="form-check-input" type="checkbox" id="extend_probation" name="extend_probation" <?php echo ($holidays['extend_probation'] == 'yes') ? 'checked' : ''; ?>>
        <label class="form-check-label" for="extend_probation">Extend for Probation Period employees</label>
    </div>
</div>

<?php echo form_close(); ?>
<script>
	$(document).ready(function() {
		$('.select2').select2({
			placeholder: "Select Options",
            allowClear: true
		});

		function updateToDateMax() {
			var fromDate = $('#date_from').val();
			var toDateInput = $('#date_to');
			
			if (fromDate) {
				// Set the max attribute of the To date input to the selected From date
				toDateInput.attr('min', fromDate);
			} else {
				// Remove the min attribute if From date is not set
				toDateInput.removeAttr('min');
			}
		}

		function validateDates() {
			var dateFrom = new Date($('#date_from').val());
			var dateTo = new Date($('#date_to').val());
			var errorMessage = $('#date-error');
			
			if (dateFrom && dateTo && dateTo < dateFrom) {
				errorMessage.show();
			} else {
				errorMessage.hide();
			}
		}

		// Update max date whenever From date changes
		$('#date_from').on('change', function() {
			updateToDateMax();
			validateDates();
		});

		// Validate dates whenever To date changes
		$('#date_to').on('change', function() {
			validateDates();
		});

		// Initial setup for min attribute on page load
		updateToDateMax();
	});

	$(document).ready(function() {
		$('input[name="group_type"]').on('change', function() {
			if ($('#group_type2').is(':checked')) {
				$('#returnGroup').show();
			} else {
				$('#returnGroup').hide();
				$('#returnGroupError').hide();
			}
		});
	});

	// Initialize visibility
	if ($('#group_type2').is(':checked')) {
		$('#returnGroup').show();
	}
</script>
