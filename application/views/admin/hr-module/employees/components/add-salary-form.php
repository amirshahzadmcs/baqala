<div class="modal-header">
	<h5 class="modal-title mt-0" id="salaryModalFullscreenLabel">Update Salary</h5>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
	<div class="size-inner-section p-2">
		<div id="responseContainer"></div>
		<div class="card-header px-2 mb-3">Fill Salary Detail</div>
		<?php echo form_open("admin/hr/employees/update-salary", array("id" => "salaryForm", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
			<input type="hidden" name="emp_id" value="<?php echo $emp_detail->id;?>" required />
			<input type="hidden" name="redirect_path" value="<?php echo $redirect_path;?>" required />
			<!-- Tab panes -->
			<div id="ajaxRes"></div>
			<div class="row">
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<label for="basic_salary">Basic Salary</label>
					<input type="text" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" id="basic_salary" name="basic_salary" value="<?php echo $emp_detail->basic_salary;?>" />
				</div>

				<div class="col-md-6 col-sm-12 mb-2 pt-4 form-group">
					<input class="checkbox" type="checkbox" id="is_housing_provided" name="is_housing_provided" <?php echo ($emp_detail->is_housing_provided == 'on') ? 'checked' : '' ?> style="vertical-align: sub;margin-right: 10px;">
					<label class="form-check-label" for="is_housing_provided">
					Houisng Provided
					</label>
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group housing-checked <?php echo ($emp_detail->is_housing_provided == 'on') ? 'd-block' : 'd-none' ?>">
					<label for="camp">Select Camp</label>
					<select class="form-select select2" data-parsley-allselected="true" name="camp" id="camp">
						<option value="">Select Camp</option>
						<?php foreach(masterCampHelper() as $camps) { ?>
							<option value="<?php echo $camps->id; ?>" <?php echo ($camps->id == $emp_detail->camp) ? ' selected' : '' ?>><?php echo $camps->camp_name; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group housing-checked <?php echo ($emp_detail->is_housing_provided == 'on') ? 'd-block' : 'd-none' ?>">
					<label for="room">Select Room</label>
					<select class="form-select select2" data-parsley-allselected="true" name="room" id="room">
						<option value="">Select Room</option>
						<?php foreach(selectedRoomHelper($emp_detail->camp) as $rooms) { ?>
							<option value="<?php echo $rooms->id; ?>" <?php echo ($rooms->id == $emp_detail->room) ? ' selected' : '' ?>><?php echo $rooms->room_name; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group housing-checked <?php echo ($emp_detail->is_housing_provided == 'on') ? 'd-block' : 'd-none' ?>">
					<label for="bed">Select Bed</label>
					<select class="form-select select2" data-parsley-allselected="true" name="bed" id="bed">
						<option value="">Select Bed</option>
						<?php foreach(selectedBedHelper($emp_detail->room) as $beds) { ?>
							<option value="<?php echo $beds->id; ?>" <?php echo ($beds->id == $emp_detail->bed) ? ' selected' : '' ?>><?php echo $beds->bed_name; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<label for="housing_allowance">Housing Allowance</label>
					<input type="text" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" id="housing_allowance" name="housing_allowance" value="<?php echo $emp_detail->housing_allowance;?>" <?php echo ($emp_detail->is_housing_provided == 'on') ? 'readonly' : '' ?> />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<label for="transport_allowance">Transport Allowance</label>
					<input type="text" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" id="transport_allowance" name="transport_allowance" value="<?php echo $emp_detail->transport_allowance;?>" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<label for="food_allowance">Food Allowance</label>
					<input type="text" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" id="food_allowance" name="food_allowance" value="<?php echo $emp_detail->food_allowance;?>" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<label for="mobile_allowance">Mobile Allowance</label>
					<input type="text" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" id="mobile_allowance" name="mobile_allowance" value="<?php echo $emp_detail->mobile_allowance;?>" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<label for="other_allowance">Other Allowance</label>
					<input type="text" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" id="other_allowance" name="other_allowance" value="<?php echo $emp_detail->other_allowance;?>" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<label for="total_package">Total Package</label>
					<input type="text" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" id="total_package" name="total_package" value="<?php echo $emp_detail->total_package;?>" readonly />
				</div>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>
<div class="modal-footer">
	<div class="row">
		<div class="col-md-12">
			<button form="salaryForm" type="submit" class="btn btn-success btn-md">Save Detail</button>
			<button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-outline-danger btn-md ms-2">Cancel </button>
		</div>
	</div>
</div>

<script type="text/javascript">

	$(document).ready(function(){
		$(".input-mask").inputmask();
	});

	$('#camp').change(function() {
		var camp_id = $(this).find('option:selected').val();
		$("#room").val(null).trigger("change");
		$("#bed").val(null).trigger("change");
		$.ajax({
			url: "<?php echo base_url(); ?>admin/hr-module/employees/Employee/getRooms",
			data: {
				camp_id: camp_id
			},
			dataType: "json",
			type: "POST",
			success: function(data) {
				//console.log(data);
				var html = '<option value="">Select Room</option>';
				if (Object.keys(data).length > 0) {
					$.each(data, function(index, item) {
						html += '<option value="' + item.id + '" data-id="' + item.id + '">' + item.room_name + '</option>';
					});
				} else {
					var html = '<option value="">No room found</option>';
				}
				$('#room').html(html);
			}
		});
	});

	$('#room').change(function() {
		var room_id = $(this).find('option:selected').val();
		//alert(room_id);
		$("#bed").val(null).trigger("change");
		$.ajax({
			url: "<?php echo base_url(); ?>admin/hr-module/employees/Employee/getBeds",
			data: {
				room_id: room_id
			},
			dataType: "json",
			type: "POST",
			success: function(data) {
				//console.log(data);
				var html = '<option value="">Select Bed</option>';
				if (Object.keys(data).length > 0) {
					$.each(data, function(index, item) {
						html += '<option value="' + item.id + '" data-id="' + item.id + '">' + item.bed_name + '</option>';
					});
				} else {
					var html = '<option value="">No bed found</option>';
				}
				$('#bed').html(html);
			}
		});
	});

	$(document).ready(function() {
		function calculateTotalPackage() {
			var basic_salary = parseFloat($("#basic_salary").val()) || 0;
			var housing_allowance = parseFloat($("#housing_allowance").val()) || 0;
			var transport_allowance = parseFloat($("#transport_allowance").val()) || 0;
			var food_allowance = parseFloat($("#food_allowance").val()) || 0;
			var mobile_allowance = parseFloat($("#mobile_allowance").val()) || 0;
			var other_allowance = parseFloat($("#other_allowance").val()) || 0;
			
			var total_package = basic_salary + housing_allowance + transport_allowance + food_allowance + mobile_allowance + other_allowance;
			
			$("#total_package").val(total_package.toFixed(2));
		}

		$("#basic_salary, #housing_allowance, #transport_allowance, #food_allowance, #mobile_allowance, #other_allowance").on('input', calculateTotalPackage);

		$('#is_housing_provided').on('click', function() {
			$(".housing-checked select").val(null).trigger("change");
			//$('.housing-checked input[type="checkbox"]:checked').prop('checked',false);
			if($("#is_housing_provided").is(":checked")) {
				$('.housing-checked').removeClass('d-none');
				$("#housing_allowance").val(0);
				$('#housing_allowance').prop('readonly',true);
			}else{
				$('.housing-checked').addClass('d-none');
				$('#housing_allowance').prop('readonly',false);
			}
			calculateTotalPackage();  
		});
		
		// Initial calculation
		calculateTotalPackage();
	});

	$(document).ready(function() {
		$('#salaryForm').submit(function(e) {
			e.preventDefault();
			var formData = new FormData($(this)[0]);
			//alert(formData);
			$.ajax({
				url: '<?php echo base_url('admin/hr/employees/update-salary');?>',
				type: 'POST',
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				success: function(response) {
					// Handle server response
					if (response.type === 'success') {
						toastr.success(response.message);
						location.reload();
					} else {
						toastr.error(response.message);
					}
				},
				error: function() {
					toastr.error(response.message);
				}
			});
		});
	});
</script>
