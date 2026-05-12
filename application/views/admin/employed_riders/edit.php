
<?php $this->load->view('admin/home/header');?>

<style>
	.required-field{
		color:#f00;
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
</style>
<div id="wait"><i class="fa fa-spinner fa-spin"></i><br>Updating..</div>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Employed Riders</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/employed-rider/list'); ?>">Employed Riders</a></li>
						<li class="breadcrumb-item active">Edit</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id');?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if ($this->customer->userd($admin_id)->role == "Admin") {?>
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url('admin/employed-rider/list'); ?>"><i class="fa fa-reply"></i> Back</a>
					<?php }?>
					&nbsp;
					<button onclick="submitButton()" form="employee_form" type="submit" class="btn btn-sm btn-custom-success pull-right" title="Save"><i class="fa fa-save"></i> Save</button>

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
						<?php echo form_open("admin/employed-rider/update", array("id" => "employee_form", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
							<input type="hidden" id="id" name="id" value="<?php echo $emp_detail->id; ?>" />
							<div id="addproduct-nav-pills-wizard" class="twitter-bs-wizard">
								<ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" data-bs-toggle="tab" href="#profileTab" role="tab">
											<span class="d-block d-sm-none"><i class="fas fa-user"></i></span>
											<span class="d-none d-sm-block">Basic Details</span>
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-bs-toggle="tab" href="#vehicleTab" role="tab">
											<span class="d-block d-sm-none"><i class="fas fa-car"></i></span>
											<span class="d-none d-sm-block">Bike Details</span>
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-bs-toggle="tab" href="#bankTab" role="tab">
											<span class="d-block d-sm-none"><i class="fas fa-university"></i></span>
											<span class="d-none d-sm-block">Sim Details</span>
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-bs-toggle="tab" href="#salaryTab" role="tab">
											<span class="d-block d-sm-none"><i class="dripicons-wallet"></i></span>
											<span class="d-none d-sm-block">Salary Structure</span>
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-bs-toggle="tab" href="#documentsTab" role="tab">
											<span class="d-block d-sm-none"><i class="dripicons-document"></i></span>
											<span class="d-none d-sm-block">Platform ID</span>
										</a>
									</li>
									
								</ul>
								<div class="tab-content py-3 text-muted">
									<div class="tab-pane active" id="profileTab" role="tabpanel">
										<div class="size-inner-section px-3 py-4">
											<div class="row">
												<div class="col-md-4 col-sm-12 mb-2 form-group">
													<label for="emp_id">Employee Name <span class="required-field">*</span></label>
													<input type="hidden" class="form-control" id="emp_id" name="emp_id" value="<?php echo $emp_detail->emp_id;?>" required />
													<input type="text" class="form-control" id="emp_name" name="emp_name" value="<?php echo $emp_detail->full_name;?>" required readonly />
												</div>
												<div class="col-md-4 mb-3 form-group">
													<label for="emp_no">Emp ID <span class="text-danger">*</span></label>
													<input type="text" class="form-control" id="emp_no" name="emp_no" value="<?php echo $emp_detail->emp_no;?>" required readonly />
												</div>
												<div class="col-md-4 mb-3 form-group">
													<label for="iqama_no">Iqama No<span class="text-danger">*</span></label>
													<input type="text" class="form-control" id="iqama_no" name="iqama_no" value="<?php echo $emp_detail->iqama_no;?>" required readonly />
												</div>
												<div class="col-md-4 mb-3 form-group">
													<label for="iqama_expiry">Iqama Expiry<span class="text-danger">*</span></label>
													<input type="text" class="form-control" id="iqama_expiry" name="iqama_expiry" value="<?php echo date('d-m-Y', strtotime($emp_detail->iqama_exp));?>" required readonly />
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="vehicleTab" role="tabpanel">
										<div class="size-inner-section px-3 py-4">
											<div class="row">
												<div class="col-md-4 mb-3 form-group">
													<label for="vehicle_type">Vehicle Type <span class="text-danger">*</span></label>
													<input type="text" class="form-control" id="vehicle_type" name="vehicle_type" value="" required readonly />
												</div>
												<div class="col-md-4 mb-3 form-group">
													<label for="vehicle_no">Vehicle Plate No<span class="text-danger">*</span></label>
													<input type="text" class="form-control" id="vehicle_no" name="vehicle_no" value="" required readonly />
												</div>
												<div class="col-md-4 mb-3 form-group">
													<label for="vehicle_sequel">Vehicle Sequel No<span class="text-danger">*</span></label>
													<input type="text" class="form-control" id="vehicle_sequel" name="vehicle_sequel" value="" required readonly />
												</div>
												<div class="col-md-4 mb-3 form-group">
													<label for="vehicle_make">Vehicle Make<span class="text-danger">*</span></label>
													<input type="text" class="form-control" id="vehicle_make" name="vehicle_make" value="" required readonly />
												</div>
												<div class="col-md-4 mb-3 form-group">
													<label for="vehicle_model">Vehicle Model<span class="text-danger">*</span></label>
													<input type="text" class="form-control" id="vehicle_model" name="vehicle_model" value="" required readonly />
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="bankTab" role="tabpanel">
										<div class="size-inner-section px-3 py-4">
											<div class="row">
												<div class="col-md-4 col-sm-12 mb-2 form-group">
													<label for="sim_id">Mobile No for Flex </label>
													<input type="text" class="form-control" id="company_mobile" name="company_mobile" value="<?php echo $emp_detail->company_mobile;?>" readonly />
												</div>
												<?php if(isset($emp_detail->company_mobile)){ ?>
												<div class="col-md-4 col-sm-12 mb-2 form-group">
													<label for="sim_id">Sim No for Flex <span class="required-field">*</span></label>
													<input type="text" class="form-control" id="company_sim_no" name="company_sim_no" value="<?php echo $emp_detail->company_sim_no;?>" readonly required />
												</div>
												<div class="col-md-4 col-sm-12 mb-2 form-group">
													<label for="sim_id">Sim Card Network for Flex <span class="required-field">*</span></label>
													<input type="text" class="form-control" id="sim_network" name="sim_network" value="<?php echo simNetworkHelper($emp_detail->sim_network)->network_name;?>" readonly required />
												</div>
												<div class="col-md-4 col-sm-12 mb-2 form-group">
													<label for="sim_id">Sim Plan for Flex <span class="required-field">*</span></label>
													<input type="text" class="form-control" id="sim_plan" name="sim_plan" value="<?php echo simPlanHelper($emp_detail->sim_plan)->plan_name;?>" readonly required />
												</div>
												<?php } ?>
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="personal_mobile">Personal Mobile No <span class="required-field text-danger">*</span></label>
													<input type="text" class="form-control" id="personal_mobile" name="personal_mobile" onkeypress="return numerics(event);" minlength="<?= MOB_LENGTH ;?>" value="<?php echo $emp_detail->personal_mobile;?>" maxlength="<?= MOB_LENGTH ;?>"  required />
													<small class="hint">Format 651 234 5678</small>
												</div>
												
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="imei_no">IMEI Number <span class="required-field text-danger">*</span></label>
													<input type="text" class="form-control" id="imei_no" name="imei_no" maxlength="20" value="<?php echo $emp_detail->imei_no;?>" required />
													<small class="hint">Format AA-BBBBBB-CCCCCC-D</small>
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="salaryTab" role="tabpanel">
										<div class="size-inner-section px-3 py-4">
											<div class="row">
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="monthly_salary">Salary <span class="required-field">*</span> (in SAR)</label>
													<input id="monthly_salary" name="monthly_salary" class="form-control input-mask text-left" value="<?php echo $emp_detail->monthly_salary;?>" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" required>
													<small class="hint">Enter rider salary</small>
												</div>
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="target_order">Target Orders <span class="required-field">*</span> (Monthly)</label>
													<input type="text" class="form-control" id="target_order" name="target_order" value="<?php echo $emp_detail->target_order;?>" onKeyPress="return numerics(event);" required="required" />
													<small class="hint">Enter rider minimum orders monthly</small>
												</div>
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="add_incentive">Incentive <span class="required-field">*</span> (after target order)</label>
													<input id="add_incentive" name="add_incentive" class="form-control input-mask text-left" value="<?php echo $emp_detail->add_incentive;?>" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" required>
													<small class="hint">Enter rider incentive after minimum orders</small>
												</div>
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="deduction_incentive">Incentive Deduction <span class="required-field">*</span> (below target order)</label>
													<input id="deduction_incentive" name="deduction_incentive" class="form-control input-mask text-left" value="<?php echo $emp_detail->deduction_incentive;?>" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" required>
													<small class="hint">Enter rider bonus commision below minimum orders</small>
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="documentsTab" role="tabpanel">
										<div class="size-inner-section px-3 py-4">
											<div class="row">
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="hunger_platform_id">Hunger Station ID</label>
													<input type="text" class="form-control" id="hunger_platform_id" name="hunger_platform_id" value="<?php echo $emp_detail->hunger_platform_id;?>" maxlength="20" />
													<small class="hint">Eg: 327317</small>
												</div>
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="jahez_platform_id">Jahez ID</label>
													<input type="text" class="form-control" id="jahez_platform_id" name="jahez_platform_id" value="<?php echo $emp_detail->jahez_platform_id;?>" maxlength="20" />
													<small class="hint">Eg: 327317</small>
												</div>
											</div>
										</div>
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

<script type="text/javascript">
	
	function submitButton() {
		window.onbeforeunload = null;
	}
	
	$(document).ready(function () {
		$('#employee_form').data('initial-state', $('#employee_form').serialize()); // On load save form current state

		// Prevent user from leaving page with inputs with new values
		window.onbeforeunload = function() {
			if ($('#employee_form').serialize() != $('#employee_form').data('initial-state')) {
				return 'You have unsaved changes! If you leave this page, your changes will be lost.';
			}
		};
		fetchVehicleDetail(<?php echo $emp_detail->emp_id;?>);
	});

	function fetchVehicleDetail(u){
		$.ajax({
			url: '<?php echo base_url();?>admin/employed_riders/getBikeDetail',
			type: "GET",
			data: {'id':u},
			success: function(data){ 
				var result = JSON.parse(data);
				console.log(data);
				if(result){
					$('#vehicle_type').val(result.vehicle_type);
					$('#vehicle_no').val(result.vehicle_no);
					$('#vehicle_sequel').val(result.sequel_no);
					$('#vehicle_make').val(result.make_name);
					$('#vehicle_model').val(result.vehicle_model);
					
				}else{
					$('#vehicle_type').val('');
					$('#vehicle_no').val('');
					$('#vehicle_sequel').val('');
					$('#vehicle_make').val('');
					$('#vehicle_model').val('');
				}
			},
			error: function(data){
				console.log(data);
			}
		});
	}

	function checkField(u){
		var id = $("#"+u).val();
		if(id == ""){
			$("#"+u).addClass("alert_text");
		}
		else{
			$("#"+u).removeClass("alert_text");
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
</script>
