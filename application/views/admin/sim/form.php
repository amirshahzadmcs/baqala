<?php $this->load->view('admin/home/header');?>
<style>
.size-inner-section {
	box-shadow: 0px 1px 4px #c5c5c5;
	border-radius: 5px;
	margin-bottom: 10px;
}
</style>
<div id="wait"><i class="fa fa-spinner fa-spin"></i><br>Loading..</div>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Sim Card Management</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/sim/list">Sim Cards</a></li>
						<li class="breadcrumb-item active">Add</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id');?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
				    <a class="btn btn-sm btn-custom-white pull-right ms-2" title="Back" href="<?php echo base_url(); ?>admin/sim/list"><i class="fa fa-reply"></i> Back</a>
					
					<button form="demo-form2" type="submit" class="btn btn-sm btn-custom-success pull-right ms-2" title="Save"><i class="fa fa-save"></i> Save</button>

				</div>
				<?php if ($this->admin->getInfo()) {
				$info = explode("--", $this->admin->getInfo());
				$info_type = $info[0];
				$msg_data = $info[1];
				if ($info_type == 2) {
				?>
				<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<strong><?php echo $msg_data; ?></strong>
				</div>
				<?php } else {?>
				<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<strong><?php echo $msg_data; ?></strong>
				</div>
				<?php }}
				$this->admin->removeInfo();?>
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
						<?php echo form_open("admin/sim/submit", array("id" => "demo-form2", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
							<input type="hidden" id="id" name="id" value="" />

							<div class="row size-inner-section px-2 py-4">
								<h4 class="header-title">SIM Ownership</h4><hr>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="ownership_type">Ownership Type<span class="text-danger">*</span></label>
									<select name="ownership_type" id="ownership_type" class="form-select" required>
										<option value="">Select Ownership</option>
										<option value="corporate">Corporate</option>
										<option value="individual">Individual</option>
									</select>
									<p class="hint">Select sim ownership type</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="owner_name">Owner Name <span class="text-danger">*</span></label>
									<input type="text" class="form-control" id="owner_name_input" name="owner_name_text" maxlength="150" required />
									<select class="form-select" id="owner_name_select" name="owner_name_dropdown" style="display: none;">
										<option value="">Select Sponsor</option>
										<?php foreach ($sponsors as $sponsor) : ?>
											<option value="<?= $sponsor->employer_name ?>" data-cr_no="<?= $sponsor->employer_cr_no; ?>"><?= $sponsor->employer_name ?></option>
										<?php endforeach; ?>
									</select>
									<p class="hint">Enter owner name of sim card</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="owner_id">Owner I'd <span class="text-danger">*</span></label>
									<input type="text" class="form-control" id="owner_id" name="owner_id" maxlength="10" required />
									<p class="hint">Enter owner i'd for sim card</p>
								</div>
							</div>
							<div class="row size-inner-section px-2 py-4">
								<h4 class="header-title">Sim Information</h4><hr>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="date_of_purchase">Date Of Purchase <span class="text-danger">*</span></label>
									<input type="date" class="form-control" id="date_of_purchase" name="date_of_purchase" maxlength="150" required />
									<p class="hint">Enter date of purchase of sim</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="network">Service Provider <span class="text-danger">*</span></label>
									<select name="network" class="form-control select2" id="network" data-placeholder="Choose Network..." required>
										<option value="">-- Select Provider --</option>
										<?php if (!empty($networks)) {  
											foreach($networks as $key => $item) { ?>
												<option value="<?php echo $networks[$key]->id; ?>"><?php echo $networks[$key]->network_name; ?></option>
											<?php } } else { ?>
											<option value="" disabled>Add Service Provider</option>
										<?php } ?>
									</select>
									<p class="hint">Select Service Provider</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="sim_type">Service Type<span class="text-danger">*</span></label>
									<select name="sim_type" id="sim_type" class="form-select" required>
										<option value="">-- Select Type --</option>
										<option value="prepaid">Prepaid</option>
										<option value="postpaid">Postpaid</option>
										<option value="Postpaid - Data SIM">Postpaid - Data SIM</option>
									</select>
									<p class="hint">Select Service Type</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="plan">Plan <span class="text-danger">*</span></label>
									<input type="hidden" name="plan_id" id="plan_id">
									<select name="plan" class="form-control select2" id="plan" data-placeholder="Choose Plan...">
										<option value="">-- Select Plan --</option>
									</select>
									<p class="hint">Enter plan for sim card</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="internet_data">Internet Data</label>
									<select name="internet_data" id="internet_data" class="form-select">
										<option value="">-- Select Internet Data --</option>
										<option value="15 GB">15 GB</option>
										<option value="25 GB">25 GB</option>
									</select>
									<p class="hint">Select Service Type</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label class="d-block">Is GPS Sim (for Postpaid Sim)</label>
									<input type="checkbox" id="switch3" switch="bool" name="is_gps_sim" />
									<label for="switch3" data-on-label="Yes" data-off-label="No"></label>
									<p class="hint">Switch Yes, If sim is GPS sim</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group d-none" id="gps_vehicle">
									<label for="gps_installed_vehicle">Select Vehicle</label>
									<select name="gps_installed_vehicle" class="form-control select2" id="gps_installed_vehicle">
										<option value="">-- Select Vehicle --</option>
										<?php if (!empty($unalloted_vehicle)) {  
											foreach($unalloted_vehicle as $key => $item) { ?>
												<option value="<?php echo $item['id']; ?>"><?php echo $item['vehicle_no'] .' - '. ucfirst($item['vehicle_type']); ?></option>
											<?php } } else { ?>
											<option value="" disabled>No Unalloted Vehicle Found</option>
										<?php } ?>
									</select>
									<p class="hint">Select vehicle in which GPS installed</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="mobile">Mobile No <span class="text-danger">*</span></label>
									<input type="text" class="form-control" id="mobile" name="mobile" onKeyPress="return numerics(event);" onBlur="checkDuplicateMob()" minlength="<?php echo MOB_LENGTH; ?>" maxlength="<?php echo MOB_LENGTH; ?>" required />
									<p class="hint res-msg">Enter mobile number</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="sim_no">Sim Card No <span class="text-danger">*</span></label>
									<input type="text" class="form-control" id="sim_no" name="sim_no" onKeyPress="return numerics(event);" onBlur="checkDuplicateSim()" minlength="<?php echo SIM_LENGTH; ?>" maxlength="<?php echo SIM_LENGTH; ?>" required />
									<p class="hint res-msg-sim">Enter sim card number</p>
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

<script type="text/javascript">
	$(document).ready(function() {
		$('#sim_type').change(function() {
			var mobileNumberInput = $('#mobile');
			var simNumberInput = $('#sim_no');
			var simNetwork = $('#network option:selected').val();
			mobileNumberInput.val('');
			if ($(this).val() === 'Postpaid - Data SIM') {
				mobileNumberInput.attr('minlength', '12');
				mobileNumberInput.attr('maxlength', '12');
				simNumberInput.attr('minlength', '19');
				simNumberInput.attr('maxlength', '19');
			} else {
				mobileNumberInput.attr('minlength', '10');
				mobileNumberInput.attr('maxlength', '10');
				if(simNetwork == '5'){
					simNumberInput.attr('minlength', '19');
					simNumberInput.attr('maxlength', '19');
				}else{
					simNumberInput.attr('minlength', '18');
					simNumberInput.attr('maxlength', '18');
				}
			}
		});
	});

	function checkDuplicateMob() {
		var mobile = $("#mobile").val();
		var id = $("#id").val();
		if (mobile !== "") {
			$.ajax({
				url: "<?php echo base_url();?>admin/sim/check-duplicate-mob",
				type: "GET",
				data: {
					mobile: mobile,
					id: id,
				},
				dataType: "json",
				success: function (data) {
					if(data.status == 'success'){
						$("#mobile").removeClass('parsley-error');
						$(".res-msg").html(data.msg);
					}else{
						$("#mobile").val('');
						$("#mobile").addClass('parsley-error');
						$(".res-msg").html(data.msg);
						return false;
					}
				},
				error: function () {
					$("#mobile").val('');
					$("#mobile").addClass('parsley-error');
					$(".res-msg").html('<span class="text-danger">Some error occured, refresh page.</span>');
					return false;
				},
			});
		} else {
			$("#mobile").addClass('parsley-error');
			$(".res-msg").html('<span class="text-danger">Enter mobile number.</span>');
		}
	}

	function checkDuplicateSim() {
		var sim_no = $("#sim_no").val();
		var id = $("#id").val();
		if (sim_no !== "") {
			$.ajax({
				url: "<?php echo base_url();?>admin/sim/check-duplicate-sim",
				type: "GET",
				data: {
					sim_no: sim_no,
					id: id,
				},
				dataType: "json",
				success: function (data) {
					if(data.status == 'success'){
						$("#sim_no").removeClass('parsley-error');
						$(".res-msg-sim").html(data.msg);
					}else{
						$("#sim_no").val('');
						$("#sim_no").addClass('parsley-error');
						$(".res-msg-sim").html(data.msg);
						return false;
					}
				},
				error: function () {
					$("#sim_no").val('');
					$("#sim_no").addClass('parsley-error');
					$(".res-msg-sim").html('<span class="text-danger">Some error occured, refresh page.</span>');
					return false;
				},
			});
		} else {
			$("#sim_no").addClass('parsley-error');
			$(".res-msg-sim").html('<span class="text-danger">Enter sim number.</span>');
		}
	}

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

	$(function(){
		$('#network').on('change',function(){
			$('#sim_type').val('');
			$('#plan').val(null).trigger('change');
			$('#plan').html('<option value="">-- Select Plan --</option>');
		});

		$('#sim_type').on('change',function(){
			var network = $('#network option:selected').val();
			var sim_type = $('#sim_type option:selected').val();
			//alert(network);
			$.ajax({
				url: "<?php echo base_url()?>admin/Sim_card/getPlans",
				data: { "id": network,"sim_type": sim_type },
				//dataType:"html",
				type: "get",
				success: function(data){
					$('#plan').html(data);
				},
				error: function(data){
					console.log(data);
				}
			});
		});

		$('#manage_status').on('change',function(){
			var status_val = $('#manage_status option:selected').val();
			if(status_val == '2'){
				$(".discont-field").removeClass('d-none');
				$("#date_of_discontinued").prop('required',true);
			}else{
				$(".discont-field").addClass('d-none');
				$("#date_of_discontinued").prop('required',false);
			}
			
		});

		$('input[type=checkbox][name=is_gps_sim]').change(function() {
			if($(this).prop("checked") == true){
				$('#gps_vehicle').removeClass('d-none');
			}else{
				$('#gps_vehicle').addClass('d-none');
			}
		});

		$('#ownership_type').on('change',function(){
			var ownership_type = $('#ownership_type option:selected').val();
			// if(ownership_type == 'corporate'){
			// 	$("#owner_id").val('1010758117');
			// 	$("#owner_name_input").val('Maha Al Fala');
			// }else{
			// 	$("#owner_id").val('');
			// 	$("#owner_name_input").val('');
			// }
			$("#owner_id").val('');
			if (ownership_type === 'corporate') {
				$('#owner_name_input').hide().prop('required', false);
				$('#owner_name_select').show().prop('required', true);
			} else {
				$('#owner_name_select').hide().prop('required', false);
				$('#owner_name_input').show().prop('required', true);
			}
		});
		
		$('#owner_name_select').change(function() {
			var ownership_type = $('#ownership_type option:selected').val();
			var cr_no = $('#owner_name_select option:selected').data('cr_no');
			if (ownership_type === 'corporate') {
				$("#owner_id").val(cr_no);
			}else{
				$("#owner_id").val('');
			}
		});
		
	});

	function showVehicleSelect(){
		if($('input[type=checkbox][name=is_gps_sim]').prop("checked") == true){
			$('#gps_vehicle').removeClass('d-none');
		}else{
			$('#gps_vehicle').addClass('d-none');
		}
	}

	$(document).ready(function(){
		selectedPlan();
		showVehicleSelect();
	});

	function selectedPlan() {
		var id = $('#id').val();
		if (id != '') {
			var network = $('#network option:selected').val();
			var sim_type = $('#sim_type option:selected').val();
			var plan_id = $('#plan_id').val();
			// alert(plan_id);
			$.ajax({
				url: "<?php echo base_url()?>admin/Sim_card/getPlans",
				data: { "id": network, "plan_id": plan_id, "sim_type": sim_type },
				//dataType:"html",
				type: "get",
				success: function(data){
					$('#plan').html(data);
				},
				error: function(data){
					console.log(data);
				}
			});
		}
	}

	$(document).ready(function() {
		$('#regionTable').dataTable({
			"lengthMenu": [
				[25, 50, 100, 500],
				[25, 50, 100, 500]
			],
			order: [
				[0, 'asc']
			],
			"responsive": true,
			fixedHeader: true,
		});
	});
</script>
