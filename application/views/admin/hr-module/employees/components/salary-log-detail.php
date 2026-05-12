<div class="modal-header">
	<h5 class="modal-title mt-0" id="salaryModalFullscreenLabel">Salary Detail</h5>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
	<div class="size-inner-section p-2">
		<div id="responseContainer"></div>
		<div class="card-header px-2 mb-3">Salary Detail</div>
		<!-- Tab panes -->
		<div id="ajaxRes"></div>
		<?php if(!empty($log_single)){ ?>
		<?php $log_detail = json_decode($log_single->log_detail, true); ?>
		<div class="row">
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="basic_salary">Basic Salary</label>
				<input type="text" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" id="basic_salary" name="basic_salary" value="<?php echo $log_detail['basic_salary'];?>" disabled />
			</div>

			<div class="col-md-6 col-sm-12 mb-2 pt-4 form-group">
				<input class="checkbox" type="checkbox" id="is_housing_provided" name="is_housing_provided" <?php echo ($log_detail['is_housing_provided'] == 'on') ? 'checked' : '' ?> disabled style="vertical-align: sub;margin-right: 10px;">
				<label class="form-check-label" for="is_housing_provided">
				Houisng Provided
				</label>
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group housing-checked <?php echo ($log_detail['is_housing_provided'] == 'on') ? 'd-block' : 'd-none' ?>">
				<label for="camp">Select Camp</label>
				<select class="form-select select2" data-parsley-allselected="true" name="camp" id="camp" disabled style="color:#000000;">
					<option value="">Select Camp</option>
					<?php foreach(masterCampHelper() as $camps) { ?>
						<option value="<?php echo $camps->id; ?>" <?php echo ($camps->id == $log_detail['camp']) ? ' selected' : '' ?>><?php echo $camps->camp_name; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group housing-checked <?php echo ($log_detail['is_housing_provided'] == 'on') ? 'd-block' : 'd-none' ?>">
				<label for="room">Select Room</label>
				<select class="form-select select2" data-parsley-allselected="true" name="room" id="room" disabled style="color:#000000;">
					<option value="">Select Room</option>
					<?php foreach(selectedRoomHelper($log_detail['camp']) as $rooms) { ?>
						<option value="<?php echo $rooms->id; ?>" <?php echo ($rooms->id == $log_detail['room']) ? ' selected' : '' ?>><?php echo $rooms->room_name; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group housing-checked <?php echo ($log_detail['is_housing_provided'] == 'on') ? 'd-block' : 'd-none' ?>">
				<label for="bed">Select Bed</label>
				<select class="form-select select2" data-parsley-allselected="true" name="bed" id="bed" disabled style="color:#000000;">
					<option value="">Select Bed</option>
					<?php foreach(selectedBedHelper($log_detail['room']) as $beds) { ?>
						<option value="<?php echo $beds->id; ?>" <?php echo ($beds->id == $log_detail['bed']) ? ' selected' : '' ?>><?php echo $beds->bed_name; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="housing_allowance">Housing Allowance</label>
				<input type="text" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" id="housing_allowance" name="housing_allowance" value="<?php echo $log_detail['housing_allowance'];?>" <?php echo ($log_detail['is_housing_provided'] == 'on') ? 'readonly' : '' ?> disabled />
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="transport_allowance">Transport Allowance</label>
				<input type="text" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" id="transport_allowance" name="transport_allowance" value="<?php echo $log_detail['transport_allowance'];?>" disabled />
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="food_allowance">Food Allowance</label>
				<input type="text" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" id="food_allowance" name="food_allowance" value="<?php echo $log_detail['food_allowance'];?>" disabled />
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="mobile_allowance">Mobile Allowance</label>
				<input type="text" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" id="mobile_allowance" name="mobile_allowance" value="<?php echo $log_detail['mobile_allowance'];?>" disabled />
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="other_allowance">Other Allowance</label>
				<input type="text" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" id="other_allowance" name="other_allowance" value="<?php echo $log_detail['other_allowance'];?>" disabled />
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="total_package">Total Package</label>
				<input type="text" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" id="total_package" name="total_package" value="<?php echo $log_detail['total_package'];?>" readonly />
			</div>
		</div>
		<?php } ?>
	</div>
</div>

<script type="text/javascript">

	$(document).ready(function(){
		$(".input-mask").inputmask();
	});
</script>
