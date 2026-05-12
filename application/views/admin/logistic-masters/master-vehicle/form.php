<?php $this->load->view('admin/home/header');?>
	<!-- start page title -->
	<div class="page-title-box">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-sm-6">
					<div class="page-title">
						<h4>Master Vehicle</h4>
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
							<li class="breadcrumb-item"><a href="<?php echo base_url('admin/master-vehicle/list');?>">Master Vehicle</a></li>
							<li class="breadcrumb-item active">Create Or Edit</li>
						</ol>
					</div>
				</div>
				<?php  $admin_id= $this->session->userdata('admin_id'); ?>
				<div class="col-sm-6">
					<div class="float-end d-sm-block">
						<a class="btn btn-sm btn-custom-white pull-right me-2" title="Back" href="<?php echo base_url();?>admin/master-vehicle/list"><i class="fa fa-reply"></i> Back</a>
						<button form="demo-form2" type="submit" class="btn btn-sm btn-custom-success pull-right" title="Save"><i class="fa fa-save"></i> Save</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end page title -->


    <div class="container-fluid">
    	<div class="page-content-wrapper">
   			 <div class="row">
   			 	<div class="col-12">
   			 		<div class="card">
   			 			<div class="card-body">
							<?php echo form_open("admin/master-vehicle/submit", array("id"=>"demo-form2", "enctype"=>"multipart/form-data", "class"=>"form-horizontal form-label-left")); ?>
								<input type="hidden" id="id" name="id" value="<?php echo $id;?>">

								<div class="row">
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="vehicle_ownership">Vehicle Ownership<span class="required-field text-danger">*</span></label>
										<select name="vehicle_ownership" id="vehicle_ownership" class="form-select" required>
											<option value="">Select Vehicle Ownership Type</option>
											<option value="Lease" <?php echo ($vehicle_ownership == 'Lease') ? "selected":"";?>>Lease</option>
											<option value="Owned" <?php echo ($vehicle_ownership == 'Owned') ? "selected":"";?>>Owned</option>
										</select>
										<small class="hint">Select vehicle ownership</small>
									</div>

									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="vehicle_type">Vehicle Type<span class="required-field text-danger">*</span></label>
										<select name="vehicle_type" id="vehicle_type" class="form-control select2" required>
											<option value="">Select Vehicle</option>
											<option value="bike" <?php echo ($vehicle_type == 'bike') ? "selected":"";?>>Bike</option>
											<option value="car" <?php echo ($vehicle_type == 'car') ? "selected":"";?>>Car</option>
											<option value="van" <?php echo ($vehicle_type == 'van') ? "selected":"";?>>Van</option>
										</select>
										<small class="hint">Select vehicle type</small>
									</div>

									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="vehicle_no">Vehicle Plate Number <span class="text-danger">*</span></label>
										<input type="text" id="vehicle_no" name="vehicle_no" minlength="6" maxlength="7" required="required" value="<?= $vehicle_no; ?>" class="form-control">
										<small class="hint">Enter vehicle plate number</small>
									</div>
									
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="vehicle_expiry">Vehicle Expiry Date <span class="required-field text-danger">*</span></label>
										<input type="date" class="form-control" id="vehicle_expiry" name="vehicle_expiry" min="<?php echo date("Y-m-d"); ?>" value="<?= $vehicle_expiry; ?>" required />
										<small class="hint">Enter vehicle expiry date</small>
									</div>
									
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="vehicle_year">Vehicle Year <span class="text-danger">*</span></label>
										<select style="height:410px;" name="vehicle_year" id="vehicle_year" class="form-control select2" required>
											<option value="">Select Vehicle Year</option>
											<?php 
												//$year_start  = 2001;
												$year_start  = (date('Y') - 6);
												$year_end = date('Y'); // current Year
												$vehicle_year = $vehicle_year; // user selected date
											
												for ($i_year = $year_end; $i_year >= $year_start; $i_year--) {
													$selected = ($vehicle_year == $i_year ? ' selected' : '');
													echo '<option value="'.$i_year.'"'.$selected.'>'.$i_year.'</option>'."\n";
												}
											?>
										</select>
										<small class="hint">Enter vehicle year of Rider</small>
									</div>
									
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="vehicle_make">Vehicle Make <span class="text-danger">*</span></label>
										<select style="height:410px;" name="vehicle_make" id="vehicle_make" class="form-control select2" required>
											<option value="">Select Service Type First</option>
										</select>
										<small class="hint">Select vehicle make of Rider</small>
									</div>
									
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="vehicle_model">Vehicle Type <span class="text-danger">*</span></label>
										<select style="height:410px;" name="vehicle_model" id="vehicle_model" class="form-control select2" required>
											<option value="">Select Vehicle Make First</option>
										</select>
										<small class="hint">Select vehicle type</small>
									</div>

									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="vehicle_color">Vehicle Color <span class="text-danger">*</span></label>
										<select style="height:410px;" name="vehicle_color" id="vehicle_color" class="form-control select2" required>
											<option value="">Select Vehicle Color</option>
											<?php foreach(colorList() as $color){?>
											<option value="<?php echo $color->id;?>" <?php echo ($vehicle_color == $color->id) ? "selected":"";?>><?php echo $color->color_name;?></option>
											<?php } ?>
										</select>
										<small class="hint">Enter vehicle colour of Rider</small>
									</div>
									
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="purchase_date">Vehicle Purchase Date</label>
										<input type="date" class="form-control" id="purchase_date" name="purchase_date" max="<?php echo date("Y-m-d"); ?>" value="<?= $purchase_date; ?>" />
										<small class="hint">Enter vehicle purcase date</small>
									</div>
									
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="chassis_no">Vehicle chassis Number</label>
										<input type="text" id="chassis_no" name="chassis_no" maxlength="35" value="<?= $chassis_no; ?>" class="form-control">
										<small class="hint">Enter vehicle chassis number</small>
									</div>
									
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="insurance_no">Select Insurance Policy No</label>
										<select class="form-select select2" data-parsley-allselected="true" name="insurance_no" id="insurance_no">
											<option value="">Select Policy No.</option>
											<?php foreach(vehiclePolicyList() as $insPolicy) { ?>
												<option value="<?php echo $insPolicy->id; ?>" <?php echo ($insPolicy->id == $insurance_no) ? ' selected' : '' ?>><?php echo $insPolicy->policy_number; ?></option>
											<?php } ?>
										</select>
										<small class="hint">Enter vehicle policy number</small>
									</div>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="insurance_company_name">Insurance Company Name</label>
										<select class="form-control" data-parsley-allselected="true" name="insurance_company_name" id="insurance_company_name" readonly style="pointer-events: none;">
											<option value="">Select Policy No. First</option>
											<?php foreach(insuCompanyHelper() as $insCompany) { ?>
												<option value="<?php echo $insCompany->id; ?>" <?php echo ($insCompany->id == $insurance_company_name) ? ' selected' : '' ?>><?php echo $insCompany->company_name; ?></option>
											<?php } ?>
										</select>
										<small class="hint">Enter Insurance Company Name</small>
									</div>
									
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="insurance_issue_date">Insurance Issue Date</label>
										<input type="date" class="form-control" id="insurance_issue_date" name="insurance_issue_date" value="<?php echo $insurance_issue_date;?>" readonly />
										<small class="hint">Enter Insurance Issue Date</small>
									</div>
									<div class="col-md-4 col-sm-12 mb-2 form-group">
										<label for="insurance_expiry">Insurance End Date</label>
										<input type="date" class="form-control" id="insurance_expiry" name="insurance_expiry" min="" value="<?php echo $insurance_expiry;?>" readonly />
										<small class="hint">Enter Insurance End Date</small>
									</div>
									<div class="col-md-4 col-sm-12 mb-2 form-group">
										<label for="insurance_class">Policy Class</label>
										<select class="form-select" data-parsley-allselected="true" name="insurance_class" id="insurance_class">
											<option value="">Select Policy No. First</option>
										</select>
									</div>
									
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="sequel_no">Vehicle Sequel Number</label>
										<input type="text" id="sequel_no" name="sequel_no" maxlength="35" value="<?= $sequel_no; ?>" class="form-control">
										<small class="hint">Enter vehicle sequel number</small>
									</div>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="gps_device_serial">GPS Tracking Device IMEI Number</label>
										<input type="text" id="gps_device_serial" name="gps_device_serial" maxlength="55" value="<?= $gps_device_serial; ?>" class="form-control">
										<small class="hint">Enter GPS Tracking Device IMEI Number</small>
									</div>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="gps_installation_date">GPS Tracking Device Installation Date</label>
										<input type="date" class="form-control" id="gps_installation_date" name="gps_installation_date" value="<?php echo $gps_installation_date;?>" max="<?php echo date('Y-m-d');?>" />
										<small class="hint">Enter Device Installation Date</small>
									</div>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="gps_expiry_date">GPS Tracking Device Expiry Date</label>
										<input type="date" class="form-control" id="gps_expiry_date" name="gps_expiry_date" value="<?php echo $gps_expiry_date;?>" readonly />
										<small class="hint">Enter Device Expiry Date</small>
									</div>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="gsp_mobile_no">GPS Mobile No</label>
										<input type="text" id="gsp_mobile_no" name="gsp_mobile_no" maxlength="15" value="<?= $gsp_mobile_no; ?>" class="form-control" disabled>
										<small class="hint">GPS mobile number</small>
									</div>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="custom_card_no">Custom Card No</label>
										<input type="text" id="custom_card_no" name="custom_card_no" maxlength="30" value="<?= $custom_card_no; ?>" class="form-control">
										<small class="hint">Enter custom card number</small>
									</div>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label class="d-block">Gasoline Chip Status</label>
										<input type="checkbox" id="switch4" switch="bool" name="gasoline_chip_status" <?php echo ($gasoline_chip_status == 'on') ? "checked":"" ?> />
										<label for="switch4" data-on-label="Yes" data-off-label="No"></label>
										<div><small class="hint">Switch Yes, If vehicle has gasoline chip</small></div>
									</div>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="registration_certificate">Registration Certificate</label>
										<input type="hidden" name="o_registration_certificate" value="<?= $registration_certificate; ?>">
										<input type="file" id="registration_certificate" name="registration_certificate" class="form-control">
										<small class="hint">Upload vehicle registration certificate</small>
										<?php if(!empty($registration_certificate)){ ?>
										    <a href="<?php echo base_url($registration_certificate);?>" target="_blank">View File</a>
										<?php } ?>
									</div>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="insurance_certificate">Insurance Certificate</label>
										<input type="hidden" name="o_insurance_certificate" value="<?= $insurance_certificate; ?>">
										<input type="file" id="insurance_certificate" name="insurance_certificate" class="form-control">
										<small class="hint">Upload vehicle insurance certificate</small>
										<?php if(!empty($insurance_certificate)){ ?>
										    <a href="<?php echo base_url($insurance_certificate);?>" target="_blank">View File</a>
										<?php } ?>
									</div>
									
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="operation_card_no">Operation Card No</label>
										<input type="text" id="operation_card_no" name="operation_card_no" maxlength="30" value="<?= $operation_card_no; ?>" class="form-control">
										<small class="hint">Enter operation card number</small>
									</div>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="operation_card_issue_date">Operation Card Issue Date</label>
										<input type="date" class="form-control" id="operation_card_issue_date" name="operation_card_issue_date" value="<?php echo $operation_card_issue_date;?>" />
										<small class="hint">Enter operation card issue date</small>
									</div>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="operation_card_expiry_date">Operation Card Expiry Date</label>
										<input type="date" class="form-control" id="operation_card_expiry_date" name="operation_card_expiry_date" value="<?php echo $operation_card_expiry_date;?>" />
										<small class="hint">Enter operation card issue date</small>
									</div>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="attached_file">Attach File</label>
										<input type="hidden" name="o_attached_file" value="<?= $attached_file; ?>">
										<input type="file" id="attached_file" name="attached_file" class="form-control">
										<small class="hint">Upload attachment</small>
										<?php if(!empty($attached_file)){ ?>
										    <a href="<?php echo base_url($attached_file);?>" target="_blank">View File</a>
										<?php } ?>
									</div>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<div class="form-group mb-2">
											<label class="control-label" for="status">Status <span class="text-danger">*</span></label>
											<select name="status" id="vehicle_status" class="form-select" required>
												<option value="">Select Status</option>
												<option value="active" <?php echo ($status == 'active') ? "selected":"";?>>Active</option>
												<option value="inactive" <?php echo ($status == 'inactive') ? "selected":"";?>>Inactive</option>
											</select>
										</div>
									</div>
									<div class="col-md-4 col-sm-12 mb-3 form-group inactive-reason d-none">
										<div class="form-group mb-2">
											<label class="control-label" for="inactive_reason">Inactive Reason <span class="text-danger">*</span></label>
											<select name="inactive_reason" id="inactive_reason" class="form-select">
												<option value="">Select Inactive Reason</option>
												<option value="Accident" <?php echo ($inactive_reason == 'Accident') ? "selected":"";?>>Accident</option>
												<option value="Accident - Zero Depth" <?php echo ($inactive_reason == 'Accident - Zero Depth') ? "selected":"";?>>Accident - Zero Depth</option>
												<option value="Engine Dead" <?php echo ($inactive_reason == 'Engine Dead') ? "selected":"";?>>Engine Dead</option>
												<option value="Insurance Workshop" <?php echo ($inactive_reason == 'Insurance Workshop') ? "selected":"";?>>Insurance Workshop</option>
												<option value="Sized by Morror" <?php echo ($inactive_reason == 'Sized by Morror') ? "selected":"";?>>Sized by Morror</option>
												<option value="Stolen" <?php echo ($inactive_reason == 'Stolen') ? "selected":"";?>>Stolen</option>
												<option value="Workshop - Repair" <?php echo ($inactive_reason == 'Workshop - Repair') ? "selected":"";?>>Workshop - Repair</option>
                                            </select>
										</div>
									</div>
								</div>
							<?php echo form_close(); ?>
   			 			</div>
   			 		</div>
   			 	</div> <!-- end col -->
   			 </div> <!-- end row -->
    	</div>
    </div>
    <!-- container-fluid -->

<?php $this->load->view('admin/home/footer');?>
<script>
	$(document).ready(function(){
		$(document).ajaxStart(function(){
			$("#wait").css("display", "block");
		});
		$(document).ajaxComplete(function(){
			$("#wait").css("display", "none");
		});
		$(document).ajaxError(function(){
			$("#wait").css("display", "none");
		});
	});
	
	function validateInsDates() {
		$('#insurance_expiry').val('');
        var startDate = $('#insurance_issue_date').val();
        var endDateInput = document.getElementById("insurance_expiry");
        endDateInput.min = startDate;
        return true;
    }

	$(document).ready(function() {
		var vehicle_type = "<?= ($vehicle_type == '') ? 'NULL' : $vehicle_type; ?>";
	    selectedVehicleMake(vehicle_type);

		var vehicle_make = "<?= ($vehicle_make == '') ? 'NULL' : $vehicle_make; ?>";
	    selectedVehicleModel(vehicle_make);
	    
	    vehicleReason();
		getInsuranceDetail();
	});
	
	function selectedVehicleMake(vehicle_type){
		var make_id = "<?= ($vehicle_make == '') ? 'NULL' : $vehicle_make; ?>";
		if(vehicle_type == 'bike'){
			$("#vehicle_no").attr("maxlength", "6");
			$("#vehicle_no").attr("minlength", "5");
			$(".vehicle-type").html("Bike");
		}else{
			$("#vehicle_no").attr("maxlength", "7");
			$("#vehicle_no").attr("minlength", "6");
			$(".vehicle-type").html("Car");
		}
		if(vehicle_type !== 'NULL'){
			$.ajax({
				url: "<?php echo base_url(); ?>admin/deliveryvehicle/vehicle_make_list",
				data: {
					service_id: vehicle_type
				},
				dataType: "json",
				type: "post",
				success: function(data) {
					//alert(JSON.stringify(data, null, 4));
					var html = '<option value="">Select Vehicle Make</option>';
			
					if (Object.keys(data).length > 0) {
						$.each(data, function(index, item) {
							var isSelected = (make_id == item.id ? 'selected' : '');
							html += '<option value="' + item.id + '" data-id="' + item.id + '" ' + isSelected + '>' + item.make_name + '</option>';
						});
					} else {
						var html = '<option value="">No vehicle make found</option>';
					}
					$('#vehicle_make').html(html);
				}
			});
		}
	}

	function selectedVehicleModel(vehicle_make){
		var vehicle_model = "<?= ($vehicle_model == '') ? 'NULL' : $vehicle_model; ?>";
		if(vehicle_make !== 'NULL'){
			$.ajax({
				url: "<?php echo base_url(); ?>admin/deliveryvehicle/get_vehicle_type",
				data: {
					make_id: vehicle_make
				},
				dataType: "json",
				type: "post",
				success: function(data) {
					var html = '<option value="">Select Vehicle Type</option>';
			
					if (Object.keys(data).length > 0) {
						$.each(data, function(index, item) {
							var isSelected = (vehicle_model == item.vehicle_type ? 'selected' : '');
							html += '<option value="' + item.vehicle_type + '" data-id="' + item.id + '" ' + isSelected + '>' + item.vehicle_type + '</option>';
						});
					} else {
						var html = '<option value="">No vehicle type found</option>';
					}
					$('#vehicle_model').html(html);
				}
			});
		}
	}
	
	$('#vehicle_type').change(function() {
		var service_id = $(this).find('option:selected').val();
		if(service_id == 'bike'){
			$("#vehicle_no").attr("maxlength", "6");
			$("#vehicle_no").attr("minlength", "5");
			$(".vehicle-type").html("Bike");
		}else{
			$("#vehicle_no").attr("maxlength", "7");
			$("#vehicle_no").attr("minlength", "6");
			$(".vehicle-type").html("Car");
		}
		$.ajax({
			url: "<?php echo base_url(); ?>admin/deliveryvehicle/vehicle_make_list",
			data: {
				service_id: service_id
			},
			dataType: "json",
			type: "post",
			success: function(data) {
				var html = '<option value="">Select Vehicle Make</option>';
		
				if (Object.keys(data).length > 0) {
					$.each(data, function(index, item) {
						html += '<option value="' + item.id + '" data-id="' + item.id + '">' + item.make_name + '</option>';
					});
				} else {
					var html = '<option value="">No vehicle make found</option>';
				}
				$('#vehicle_make').html(html);
			}
		});
	});

	$('#vehicle_make').change(function() {
		var make_id = $(this).find('option:selected').val();
		$.ajax({
			url: "<?php echo base_url(); ?>admin/deliveryvehicle/get_vehicle_type",
			data: {
				make_id: make_id
			},
			dataType: "json",
			type: "post",
			success: function(data) {
				var html = '<option value="">Select Vehicle Type</option>';
		
				if (Object.keys(data).length > 0) {
					$.each(data, function(index, item) {
						html += '<option value="' + item.vehicle_type + '" data-id="' + item.id + '">' + item.vehicle_type + '</option>';
					});
				} else {
					var html = '<option value="">No vehicle type found</option>';
				}
				$('#vehicle_model').html(html);
			}
		});
	});
	
	$('#vehicle_status').change(function() {
		vehicleReason();
	});
	
	function vehicleReason(){
	    var vehicle_status = $('#vehicle_status').find('option:selected').val();
	    //alert(vehicle_status);
		if(vehicle_status == 'inactive'){
			//$("#inactive_reason").attr("required", "true");
			$(".inactive-reason").removeClass("d-none");
		}else{
		    //$("#inactive_reason").attr("required", "false");
			$(".inactive-reason").addClass("d-none");
		}
	}

	$('#insurance_no').change(function() {
		getInsuranceDetail();
	});

	function getInsuranceDetail(){
		var policy_id = $('#insurance_no').find('option:selected').val();
		var policy_type = '<?php echo ($insurance_class !== '') ? $insurance_class : 0;?>';
		$('#insurance_company_name').html('<option value="">Select Policy No. First</option>');
		$('#insurance_issue_date').val('');
		$('#insurance_expiry').val('');
		$('#insurance_class').html('<option value="">Select Policy Class</option>');
		if(policy_id > 0){
			$.ajax({
				url: "<?php echo base_url(); ?>admin/logistic-masters/Master_vehicle/getPolicyDetail",
				data: {
					policy_id: policy_id
				},
				dataType: "json",
				type: "POST",
				success: function(data) {
					console.log(data);

					// Update company name
					var company_input = '<option value="'+data.id+'">'+data.company_name+'</option>';
					$('#insurance_company_name').html(company_input);

					// Update policy dates
					$('#insurance_issue_date').val(data.policy_date);
					$('#insurance_expiry').val(data.policy_expiry);

					// Update policy class dropdown
					var classSelectContainer = '<option value="">Select Policy Class</option>';
					if (data.insurance_type_details && data.insurance_type_details.length > 0) {
						$.each(data.insurance_type_details, function(index, insuranceType) {
							var isSelected = (insuranceType.id == policy_type) ? 'selected' : '';
							classSelectContainer += '<option value="'+insuranceType.id+'" '+ isSelected +'>'+insuranceType.insurance_type+'</option>';
						});
					}
					$('#insurance_class').html(classSelectContainer);
				},
				error: function (request, error) {
					console.log(" Can't do because: " + JSON.stringify(request));
				},
			});
		}
	}
	
	$(document).ready(function() {
		$('#gps_installation_date').on('change', function() {
			var installDate = new Date($(this).val());
			if (installDate instanceof Date && !isNaN(installDate)) {
				var expiryDate = new Date(installDate);
				expiryDate.setFullYear(installDate.getFullYear() + 1);
				var yyyy = expiryDate.getFullYear();
				var mm = String(expiryDate.getMonth() + 1).padStart(2, '0'); // Months are zero-based
				var dd = String(expiryDate.getDate()).padStart(2, '0');
				$('#gps_expiry_date').val(`${yyyy}-${mm}-${dd}`);
			} else {
				$('#gps_expiry_date').val(''); // Clear the expiry date if the installation date is invalid
			}
		});
	});
</script>
