
<?php $this->load->view('admin/home/header');?>


<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Prepaid Mobile Invoice</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/prepaid-mobile-invoice/list">Prepaid Mobile Invoice</a></li>
						<li class="breadcrumb-item active">Add</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id');?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url(); ?>admin/prepaid-mobile-invoice/list"><i class="fa fa-reply"></i> Back</a>
					
					&nbsp;
					<button form="demo-form2" type="submit" class="btn btn-sm btn-custom-success pull-right" title="Save"><i class="fa fa-save"></i> Save</button>

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
			<div class="col-6">
				<div class="card">
					<div class="card-header">Fetch SIM Detail</div>
					<div class="card-body">
						<?php echo form_open("#", array("id" => "recharge-form1", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
						<div class="row py-1">
							<div class="col-md-9 col-sm-12 mb-3 form-group">
								<label for="selected_sim_id">Select Mobile Number<span class="text-danger">*</span></label>
								<select name="selected_sim_id" id="selected_sim_id" class="form-select select2" required>
									<option value="">Select Mobile No.</option>
									<?php foreach($sim_list as $sim_card){ ?>
									<option value="<?php echo $sim_card->id;?>"><?php echo $sim_card->mobile;?> - <?php echo $sim_card->sim_no;?></option>
									<?php } ?>
								</select>
								<small class="res-msg"></small>
							</div>
							<div class="col-md-3 col-sm-12 mb-3 form-group">
								<label class="d-block">&nbsp;</label>
								<button type="button" onclick="getSimDetail()" class="btn btn-success btn-md">Get Detail</button>
							</div>
						</div>
						<?php echo form_close(); ?>
						<div class="row py-1 d-none" id="simInfo">
							<h4 class="header-title">Recharge SIM Detail</h4><hr>
							<div class="mb-2">
								<p class="mb-1"><strong>Mobile Number: </strong><span id="sim_mobile"></span></p>
								<p class="mb-1"><strong>SIM Number: </strong><span id="sim_simno"></span></p>
								<p class="mb-1"><strong>Service Provider: </strong><span id="sim_provider"></span></p>
								<p class="mb-1"><strong>Service Type: </strong><span id="sim_servicetype"></span></p>
								<p class="mb-1"><strong>Plan: </strong><span id="sim_plan"></span></p>
								<p class="mb-1"><strong>Employee ID: </strong><span id="employee_id"></span></p>
								<p class="mb-1"><strong>Employee Name: </strong><span id="employee_name"></span></p>
								<p class="mb-1"><strong>Last Recharge Date: </strong><span id="last_recharge"></span></p>
								<p class="mb-1"><strong>Last Recharge Amount: </strong><span id="last_amount"></span></p>
								<p class="mb-1"><strong>Days: </strong><span id="days_count"></span></p>
							</div>
						</div>
						
					</div>
				</div>
			</div> <!-- end col -->
			<div class="col-6">
				<div class="card" style="min-height: 172px;">
					<div class="card-header">Enter Recharge Detail</div>
					<div class="card-body">
						<!-- <h6 class="port-detail-heading">First Fetch SIM Detail</h6> -->
						<div id="portInfo">
							<?php echo form_open("admin/sim/save-port-detail", array("id" => "port-form2", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
								<input type="hidden" name="id" id="sim_id" value="" required />
								<div class="row">
									<div class="col-md-6 col-sm-12 mb-3 form-group">
										<label for="date_of_purchase">New Recharge Date <span class="text-danger">*</span></label>
										<input type="date" class="form-control" id="date_of_purchase" name="date_of_purchase" maxlength="150" required />
										<small class="hint">Enter new recharge date</small>
									</div>
									<div class="col-md-6 col-sm-12 mb-3 form-group">
										<label for="owner_name">New Recharge Amount <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="owner_name" name="owner_name" maxlength="150" required />
										<small class="hint">Enter new recharge amount</small>
									</div>
									<div class="col-md-6 col-sm-12 mb-3 form-group">
										<label for="sim_type">Recharge Card Sr No<span class="text-danger">*</span></label>
										<select name="sim_type" class="form-select" required>
											<option value="">Select Recharge Card</option>
											<option value="prepaid">Prepaid</option>
											<option value="postpaid">Postpaid</option>
										</select>
										<small class="hint">Select recharge card number</small>
									</div>
									<div class="col-md-6 col-sm-12 mb-3 form-group">
										<label for="sim_type">Recharge Source<span class="text-danger">*</span></label>
										<select name="sim_type" class="form-select" required>
											<option value="">Select Recharge Source</option>
											<option value="prepaid">Prepaid Recharge Card</option>
										</select>
										<small class="hint">Select new recharge source</small>
									</div>
									<div class="col-md-12 col-sm-12 mb-3 float-end">
										<button type="submit" class="btn btn-success btn-md float-end">Submit Detail</button>
									</div>
								</div>
							<?php echo form_close(); ?>
						</div>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<?php $this->load->view('admin/home/footer');?>

<script type="text/javascript">
	
	function getSimDetail() {
		var sim_id = $('#selected_sim_id option:selected').val();
		emptySimDetail();
		if (sim_id !== "") {
			$.ajax({
				url: "<?php echo base_url('admin/sim/port-sim-detail');?>",
				type: "POST",
				data: {
					id: sim_id,
				},
				dataType: "json",
				success: function (data) {
					console.log(data);
					var allotment_status = '0';
					if(data.status == 'success'){
						$("#selected_sim_id").removeClass('parsley-error');
						$("#simInfo").removeClass('d-none');
						$("#sim_mobile").html(data.sim_detail.mobile);
						$("#sim_simno").html(data.sim_detail.sim_no);
						$("#sim_provider").html(data.sim_detail.network_name);
						$("#sim_servicetype").html(data.sim_detail.sim_type);
						$("#sim_plan").html(data.sim_detail.plan_name);
						if(data.sim_detail.allotment == '0'){
							allotment_status = '<span class="badge badge-pill badge-soft-primary font-size-13">New</span>';
							$("#sim_allotment").html(allotment_status);
							$(".port-detail-heading").html('<span class="text-danger">First unallot sim card!</span>');
						}
						if(data.sim_detail.allotment == '1'){
							allotment_status = '<span class="badge badge-pill badge-soft-success font-size-13">Alloted</span>';
							$("#sim_allotment").html(allotment_status);
							$(".port-detail-heading").html('<span class="text-danger">First unallot sim card to port !</span>');
						}
						if(data.sim_detail.allotment == '2'){
							allotment_status = '<span class="badge badge-pill badge-soft-danger font-size-13">Unalloted</span>';
							$("#sim_allotment").html(allotment_status);
							$(".port-detail-heading").html('');
							$("#portInfo").removeClass('d-none');
						}
						$("#sim_id").val(data.sim_detail.id);
						$(".res-msg").html(data.msg);
					}else{
						$("#selected_sim_id").val('');
						$("#selected_sim_id").addClass('parsley-error');
						$("#simInfo").addClass('d-none');
						$("#portInfo").addClass('d-none');
						$(".res-msg").html(data.msg);
						return false;
					}
				},
				error: function () {
					$("#selected_sim_id").val('');
					$("#selected_sim_id").addClass('parsley-error');
					$("#simInfo").addClass('d-none');
					$("#portInfo").addClass('d-none');
					$(".res-msg").html('<span class="text-danger">Some error occured, refresh page.</span>');
					return false;
				},
			});
		} else {
			$("#selected_sim_id").addClass('parsley-error');
			$(".res-msg").html('<span class="text-danger">Select SIM Card.</span>');
		}
	}

	function emptySimDetail(){
		$("#sim_mobile").html('');
		$("#sim_simno").html('');
		$("#sim_provider").html('');
		$("#sim_servicetype").html('');
		$("#sim_plan").html('');
		$("#sim_id").val('');
	}

	function checkDuplicateInvoiceNo() {
		var invoice_no = $("#invoice_no").val();
		var id = $("#id").val();
		if (invoice_no !== "") {
			$.ajax({
				url: "<?php echo base_url();?>admin/prepaid-mobile-invoice/check-invoice-no",
				type: "GET",
				data: {
					invoice_no: invoice_no,
					id: id,
				},
				dataType: "json",
				success: function (data) {
					if(data.status == 'success'){
						$("#invoice_no").removeClass('parsley-error');
						$(".res-msg").html(data.msg);
					}else{
						$("#invoice_no").val('');
						$("#invoice_no").addClass('parsley-error');
						$(".res-msg").html(data.msg);
						return false;
					}
				},
				error: function () {
					$("#invoice_no").val('');
					$("#invoice_no").addClass('parsley-error');
					$(".res-msg").html('<span class="text-danger">Some error occured, refresh page.</span>');
					return false;
				},
			});
		} else {
			$("#invoice_no").removeClass('parsley-error');
			$(".res-msg").html('');
		}
	}
	
	function checkDuplicateInvoice() {
		var sim_id = $('#sim_id').find(":selected").val();;
		var id = $("#id").val();
		var period = $("#period").val();
		if (period !== "") {
			$.ajax({
				url: "<?php echo base_url();?>admin/prepaid-mobile-invoice/check-invoice",
				type: "GET",
				data: {
					sim_id: sim_id,
					period: period,
					id: id,
				},
				dataType: "json",
				success: function (data) {
					if(data.status == 'success'){
						$("#period").removeClass('parsley-error');
						$(".res-msg-period").html(data.msg);
					}else{
						$("#period").val('');
						$("#period").addClass('parsley-error');
						$(".res-msg-period").html(data.msg);
						return false;
					}
				},
				error: function () {
					$("#period").val('');
					$("#period").addClass('parsley-error');
					$(".res-msg-period").html('<span class="text-danger">Some error occured, refresh page.</span>');
					return false;
				},
			});
		} else {
			$("#period").addClass('parsley-error');
			$(".res-msg-period").html('<span class="text-danger">Enter Invoice Period.</span>');
		}
	}

</script>
