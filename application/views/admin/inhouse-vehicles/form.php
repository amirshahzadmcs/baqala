<?php $this->load->view('admin/home/header');?>
<style>
.page-content-wrapper label {
    color: #252525;
}
.nav-pills .nav-link.active, .nav-pills .show>.nav-link {
	color: #fff !important;
    background-color: #005500!important;
}
.nav-tabs-custom .nav-item .nav-link::after {
    content: "";
    background: #005500;
}
.nav-tabs-custom .nav-item .nav-link {
    background: #eee;
}
.size-inner-section {
    box-shadow: 0px 1px 4px #c5c5c5;
    border-radius: 5px;
    margin-bottom: 10px;
}
.custom-label{
	min-height: 28px;
}
@media (max-width: 425px){
	#wait img {
		margin-top: 40%;
	}
}
</style>
<div id="wait"><img src="<?= base_url('images/sample-loader.gif');?>" /><br>Loading..</div>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Delivery VAN</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/in-house-vehicle/list">Delivery VAN</a></li>
						<li class="breadcrumb-item active">Create or Edit</li>
					</ol>
				</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if($this->customer->userd($admin_id)->role=="Admin" ){?>
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url();?>admin/in-house-vehicle/list"><i class="fa fa-reply"></i> Back</a>
					<?php } ?>
				</div>
				<?php if($this->admin->getInfo()){
				$info = explode("--", $this->admin->getInfo());
				$info_type = $info[0];
				$msg_data = $info[1];
				if($info_type == 2){
				?>
				<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					<strong><?php echo $msg_data; ?></strong>
				</div>
				<?php } else{?>
				<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					<strong><?php echo $msg_data; ?></strong>
				</div>
				<?php }} $this->admin->removeInfo();  ?>
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
					<div class="card-body" style="min-height: 506px;">
						<?php echo form_open("admin/in-house-vehicle/save", array("id"=>"van-form", "enctype"=>"multipart/form-data", "class"=>"form-label-left", "data-parsley-validate"=> "")); ?>
							<input type="hidden" id="id" name="id" value="<?= $id;?>" required>
							<div class="row size-inner-section p-2">
								<h4 class="header-title">Fill van information</h4>
								
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="van_no">Van Plate Number <span class="text-danger">*</span></label>
									<input type="text" id="van_no" name="van_no" minlength="7" maxlength="7" required="required" value="<?= $van_no; ?>" class="form-control">
									<small class="hint">Enter Van plate number</small>
								</div>
								
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="vehicle_expiry">Van Expiry Date <span class="required-field text-danger">*</span></label>
									<input type="date" class="form-control" id="vehicle_expiry" name="vehicle_expiry" min="<?php echo isset($id) ? '' : date("Y-m-d"); ?>" value="<?= $vehicle_expiry; ?>" required />
									<small class="hint">Enter Van expiry date</small>
								</div>
								
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="vehicle_year">Van Year <span class="text-danger">*</span></label>
									<select style="height:410px;" name="vehicle_year" id="vehicle_year" class="form-control select2" required>
										<option value="">Select Van Year</option>
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
									<small class="hint">Enter Van year</small>
								</div>
								
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="van_make">Van Make <span class="text-danger">*</span></label>
									<select style="height:410px;" name="van_make" id="van_make" value="<?= $van_make; ?>" class="form-control select2" required>
										<option value="">Select Service Type First</option>
									</select>
									<small class="hint">Select Van make</small>
								</div>
								
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="van_model">Van Model <span class="text-danger">*</span></label>
									<select style="height:410px;" name="van_model" id="van_model" value="<?= $van_model; ?>" class="form-control select2" required>
										<option value="">Select Van Make First</option>
									</select>
									<small class="hint">Select Van Model</small>
								</div>

								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="van_color">Van Color <span class="text-danger">*</span></label>
									<select style="height:410px;" name="van_color" id="van_color" class="form-control select2" required>
										<option value="">Select Vehicle Color</option>
										<?php foreach(colorList() as $color){?>
										<option value="<?php echo $color->id;?>" <?php echo ($van_color == $color->id) ? "selected":"";?>><?php echo $color->color_name;?></option>
										<?php } ?>
									</select>
									<small class="hint">Enter van colour</small>
								</div>

								<div class="col-md-4 mb-3 form-group">
									<label for="region_id">Region <span class="text-danger">*</span></label>
									<select id="region_id" name="region_id" class="form-control col-md-12 select2" required>
										<option value="">Select Region</option>
										<?php foreach(getRegions() as $master_region){?>
										<option value="<?php echo $master_region->id;?>" data-id="<?php echo $master_region->id;?>" <?php echo ($region_id == $master_region->id) ? "selected":"";?>><?php echo $master_region->region_name;?></option>
										<?php } ?>
									</select>
								</div>

								<div class="col-md-4 mb-3 form-group">
									<label for="city">City Name <span class="text-danger">*</span></label>
									<select id="city" name="city" class="form-control col-md-12 select2" required>
										<option value="">Select Region First</option>
									</select>
								</div>

								<div class="col-md-4 mb-3 form-group">
									<label for="district">District Name <span class="text-danger">*</span></label>
									<input type="text" class="form-control" id="district" name="district" onKeyPress="return Alpha(event);" value="<?= $district; ?>" required maxlength="150" />
								</div>
								
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="name">Driver Name (English) <span class="required-field text-danger">*</span></label>
									<input type="text" class="form-control" id="name" name="name" onKeyPress="return Alpha(event);" value="<?= $name; ?>" maxlength="150"  required />
									<small class="hint">Enter display name for Driver</small>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="arabic_name">Driver Name (Arabic) <span class="required-field text-danger">*</span></label>
									<input type="text" class="form-control rtl-input" id="arabic_name" name="arabic_name" value="<?= $arabic_name; ?>" maxlength="150" required />
									<small class="hint">Enter display name for Driver in arabic</small>
								</div>
								<div class="col-md-4 mb-3 form-group">
									<label for="email">Rider Email <span class="text-danger">*</span></label>
									<input type="email" class="form-control" id="email" name="email" value="<?= $email; ?>" required maxlength="150" />
								</div>
								
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="mobile">Mobile Number <span class="required-field text-danger">*</span></label>
									<input type="text" class="form-control" id="mobile" name="mobile" onkeypress="return numerics(event);" value="<?= $mobile; ?>" minlength="<?= MOB_LENGTH ;?>" maxlength="<?= MOB_LENGTH ;?>"  required />
									<small class="hint">Format 651 234 5678</small>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="iqama_no">Iqama No <span class="required-field text-danger">*</span></label>
									<input type="text" class="form-control" id="iqama_no" name="iqama_no"  minlength="<?= ICAMA_LENGTH ;?>" maxlength="<?= ICAMA_LENGTH ;?>" value="<?= $iqama_no; ?>" required />
									<small class="hint">Enter Iqama No of driver</small>
								</div>
									
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="iqama_exp">Iqama Expiry Date <span class="required-field text-danger">*</span></label>
									<input type="date" class="form-control" id="iqama_exp" name="iqama_exp" min="<?php echo isset($id) ? '' : date("Y-m-d"); ?>" value="<?= $iqama_exp; ?>" required />
									<small class="hint">Enter Iqama expiry date</small>
								</div>
								
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="dl_no">Driving License No <span class="required-field text-danger">*</span></label>
									<input type="text" class="form-control" id="dl_no" name="dl_no" minlength="<?= DL_LENGTH ;?>" maxlength="<?= DL_LENGTH ;?>" value="<?= $dl_no; ?>" required="required" />
									<small class="hint">Enter driving license number</small>
								</div>
								
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="dl_expiry">Driving License Expiry <span class="required-field text-danger">*</span></label>
									<input type="date" class="form-control" id="dl_expiry" name="dl_expiry" min="<?php echo date("Y-m-d"); ?>" value="<?= $dl_expiry; ?>" required />
									<small class="hint">Enter driving license expiry date</small>
								</div>
								
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="profession">Profession <span class="text-danger">*</span></label>
									<select style="height:410px;" name="profession" id="profession" class="form-control select2" required>
										<option value="">Select Profession</option>
										<?php foreach(professionList() as $professions){?>
										<option value="<?php echo $professions->id;?>" <?php echo ($profession == $professions->id) ? "selected":"";?>><?php echo $professions->profession_name;?></option>
										<?php } ?>
									</select>
									<small class="hint">Enter profession for Rider</small>
								</div>
								
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="nationality">Nationality <span class="required-field text-danger">*</span></label>
									<select id="nationality" name="nationality" class="form-control col-md-12 select2" required>
										<option value="">Select Nationality</option>
										<?php foreach(nationalityList() as $master_nationality){?>
										<option value="<?php echo $master_nationality->name;?>" data-id="<?php echo $master_nationality->name;?>" <?php echo ($nationality == $master_nationality->name) ? "selected":"";?>><?php echo $master_nationality->name;?></option>
										<?php } ?>
									</select>
									<small class="hint">Select rider nationality</small>
								</div>
								
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="doj">Date Of Joining <span class="text-danger">*</span></label>
									<input type="date" class="form-control" id="doj" name="doj" value="<?php echo $doj;?>" required="required" />
									<small class="hint">Enter rider date of joining</small>
									<span id="errmsgadhar" class="err-msg"></span>
								</div>

								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="partner_id">Logistic Partner <span class="text-danger">*</span></label>
									<select style="height:410px;" name="partner_id" id="partner_id" class="form-control select2" required>
										<option value="">Select Partner</option>
										<?php foreach(logisticPartnerList() as $partners){?>
										<option value="<?php echo $partners->id;?>" <?php echo ($partners->id == $partner_id) ? "selected":"";?>><?php echo $partners->company_name;?></option>
										<?php } ?>
									</select>
									<small class="hint">Select logistic partner belong to Rider</small>
								</div>

								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="service_area">Service Area <span class="text-danger">*</span></label>
									<select name="service_area" id="service_area" class="form-control select2" required>
										<option value="">Select Service Area</option>
										<?php foreach(areaList() as $areas){?>
										<option value="<?php echo $areas->id;?>" <?php echo ($areas->id == $service_area) ? "selected":"";?>><?php echo $areas->area_name;?></option>
										<?php } ?>
									</select>
									<small class="hint">Enter service area for Rider</small>
								</div>

								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="status">Status<span class="text-danger" required>*</span></label>
									<select name="status" class="form-control select2" required>
										<option value="">Select Status</option>
										<option value="1" <?php echo ($status == '1') ? "selected":"";?>>Enable</option>
										<option value="0" <?php echo ($status == '0') ? "selected":"";?>>Disable</option>
										<option value="2" <?php echo ($status == '2') ? "selected":"";?>>Block</option>
									</select>
									<small class="hint">Set status for your Rider</small>
								</div>

								<div class="col-md-4 col-sm-12 mb-3 form-group <?php echo ($status == 2) ? '' : 'd-none'; ?>" id="blockReason">
									<label for="block_reason">Block Reason<span class="text-danger" required>*</span></label>
									<select name="block_reason" id="block_reason" class="form-control select2">
										<option value="">Select Block Reason</option>
										<?php foreach( blockReasonsHelper() as $item) { ?>
											<option value="<?php echo $item->name; ?>" <?php echo ($block_reason == $item->name) ? "selected":"";?>><?php echo $item->name .' ( '.$item->name_ar.' )'; ?></option>
										<?php } ?>												
									</select>
									<small class="hint">Set block reason for your Rider</small>
								</div>
								
								<div class="col-md-12 col-sm-12 mb-3 form-group">
									<button class="btn btn-success btn-md float-end">Update</button>
								</div>
							</div>
						<?= form_close();?>
					</div>
				</div>
			</div> <!-- end col -->
		 </div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<?php $this->load->view('admin/home/footer');?>
<script type="text/javascript">
	var base_url = '<?= base_url();?>';
</script>
<script>
	$(function(){
		var dtToday = new Date();
		
		var month = dtToday.getMonth() + 1;
		var day = dtToday.getDate();
		var year = dtToday.getFullYear();
	   
		//$('#cr_expiry').attr('min', maxDate);
		//$('#agrement_expiry').attr('min', maxDate);
		//$('#vehicle_expiry').attr('min', maxDate);
		//$('#passport_exp').attr('min', maxDate);
	});

	$(document).ready(function() {
	    var region_id = "<?= ($region_id == '') ? 'NULL' : $region_id; ?>";
	    selectedCity(region_id);

		var service_type = "car";
	    selectedVehicleMake(service_type);

		var van_make = "<?= ($van_make == '') ? 'NULL' : $van_make; ?>";
	    selectedVehicleModel(van_make);

		
	});

	function selectedCity(region_id){
		var add_city_id = "<?= ($city == '') ? 'NULL' : $city; ?>";
		//alert(region_id);
		if(region_id !== 'NULL'){
			$.ajax({
				url: "<?php echo base_url(); ?>admin/deliveryvehicle/get_region_cities",
				type: "POST",
				data: {'region_id':region_id},
				dataType: "json",
				success: function(data){
					var html = '<option value="">Select City</option>';
			
					if (Object.keys(data).length > 0) {
						$.each(data, function(index, item) {
							var isSelected = (add_city_id == item.id ? 'selected' : '');
							html += '<option value="' + item.id + '" data-id="' + item.id + '" ' + isSelected + '>' + item.city_name + '</option>';
						});
					} else {
						var html = '<option value="">No city found</option>';
					}
					$('#city').html(html);
				},
				error: function(){}
			});
		}
	}

	function selectedVehicleMake(service_type){
		var make_id = "<?= ($van_make == '') ? 'NULL' : $van_make; ?>";
		if(service_type !== 'NULL'){
			$.ajax({
				url: "<?php echo base_url(); ?>admin/deliveryvehicle/vehicle_make_list",
				data: {
					service_id: service_type
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
					$('#van_make').html(html);
				}
			});
		}
	}

	function selectedVehicleModel(van_make){
		var van_model = "<?= ($van_model == '') ? 'NULL' : $van_model; ?>";
		if(van_make !== 'NULL'){
			$.ajax({
				url: "<?php echo base_url(); ?>admin/deliveryvehicle/get_vehicle_type",
				data: {
					make_id: van_make
				},
				dataType: "json",
				type: "post",
				success: function(data) {
					var html = '<option value="">Select Vehicle Type</option>';
			
					if (Object.keys(data).length > 0) {
						$.each(data, function(index, item) {
							var isSelected = (van_model == item.vehicle_type ? 'selected' : '');
							html += '<option value="' + item.vehicle_type + '" data-id="' + item.id + '" ' + isSelected + '>' + item.vehicle_type + '</option>';
						});
					} else {
						var html = '<option value="">No vehicle type found</option>';
					}
					$('#van_model').html(html);
				}
			});
		}
	}

	$('#region_id').change(function() {
		var region_id = $(this).find('option:selected').data('id');
		$.ajax({
			url: "<?php echo base_url(); ?>admin/deliveryvehicle/get_region_cities",
			data: {
				region_id: region_id
			},
			dataType: "json",
			type: "post",
			success: function(data) {
				//console.log(data);
				var html = '<option value="">Select City</option>';
		
				if (Object.keys(data).length > 0) {
					$.each(data, function(index, item) {
						html += '<option value="' + item.id + '" data-id="' + item.id + '">' + item.city_name + '</option>';
					});
				} else {
					var html = '<option value="">No city found</option>';
				}
				$('#city').html(html);
			}
		});
	});

	$('#service_type').change(function() {
		var service_id = 'car';
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
				$('#van_make').html(html);
			}
		});
	});

	$('#van_make').change(function() {
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
				$('#van_model').html(html);
			}
		});
	});
	
	$("#mobile").on("keypress",function(e){
		if($(this).val().length<='10'){
			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				
				$("#errmsg1").html("Digits Only").show();
				return false;
			}
		}else{
			$("#errmsg1").html("Maximum input 10 Digits Only").show();
			return false;
		}
	});
	
	$("#adhar").on("keypress",function(e){
		if($(this).val().length<='12'){
			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				
				$("#errmsgadhar").html("Aadhar number not valid").show();
				return false;
			}
		}else{
			$("#errmsgadhar").html("Maximum input 12 Digits Only").show();
			return false;
		}
	});

	function Alpha(evt) {
		var keyCode = (evt.which) ? evt.which : evt.keyCode
		if ((keyCode < 65 || keyCode > 90) && (keyCode < 97 || keyCode > 123) && keyCode != 32)
			return false;
		return true;
	}

	function numerics(key) {
		//getting key code of pressed key
		// alert($(this).val());
		var keycode = (key.which) ? key.which : key.keyCode;
		//comparing pressed keycodes

		if (keycode > 31 && (keycode < 48 || keycode > 57)) {
			alert("You can enter only characters 0 to 9 ");
			return false;
		} else return true;
	}

	function verifyAction(e) {
		if (confirm("Do you sure want to verify this rider?") == true) {
			var uID = (e.getAttribute("data-id"));
			if(uID > 0){
				$.ajax({
					url: '<?php echo base_url();?>admin/deliveryvehicle/verify',
					type: 'POST',
					dataType: 'json',
					data: {id: uID},
					success: function(data){
						alert(data.succ);
						location.reload();
					},
					error:function(data){
						console.log(data);
					}
				});
			}else{
				alert('Invalid rider ID');
			}
		} else {
			userPreference = "Action Cancelled!";
		}
	}

	$('select[name=status]').on('change',function(){
		var value = $('select[name=status] option:selected').val();
		// alert(value);
		if (value === '2') {
			$('#blockReason').removeClass('d-none');
			$('#block_reason').attr('required',true);
		} else {
			$('#blockReason').addClass('d-none');
			$('#block_reason').attr('required',false);
		}
	});

	$('select[name=doc_info_status]').on('change',function(){
		var value = $('select[name=doc_info_status] option:selected').val();
		// alert(value);
		if (value === '2') {
			$('#docReason').removeClass('d-none');
			$('#doc_reason').attr('required',true);
		} else {
			$('#docReason').addClass('d-none');
			$('#doc_reason').attr('required',false);
		}
	});
</script>

