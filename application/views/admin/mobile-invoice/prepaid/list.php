<?php $this->load->view('admin/home/header');?>
<style>
.dataTables_wrapper::-webkit-scrollbar {
  display: none;
}
.nav-md .container.body .right_col {
    padding: 10px 10px 0;
    margin-left: 230px;
}
#wait{
	display: none;
	width: 100%;
	height: 100%;
	position: fixed;
	padding: 2px;
	z-index: 9999;
	background: #ffffffde;
	text-align: center;
	padding-top: 17%;
	top: 0;
	bottom: 0;
}
.sim-detail-ajax p{
	margin-top: 0;
    font-size: 13px;
    margin-bottom: 0rem;
    font-weight: 200;
}
</style>

<div id="wait"><img src="<?= base_url('images/sample-loader.gif'); ?>" /><br>Loading..</div>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
			<div class="page-title">
				<h4>Prepaid Mobile Invoice</h4>
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="<?php echo base_url('admin/prepaid-mobile-invoice/list');?>">Prepaid Mobile Invoice</a></li>
					<li class="breadcrumb-item active">List</li>
				</ol>
			</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if($inv_count > 0 && check_action_permission(get_user_role(), 'recharges', 'print_report')):?>
					<a type="reset" href="<?php echo base_url();?>admin/prepaid-mobile-invoice/print-report?sim_no=<?php echo $this->input->get('sim_no') ?>&network=<?php echo $this->input->get('network') ?>&plan=<?php echo $this->input->get('plan') ?>&owner=<?php echo $this->input->get('owner') ?>&period_start=<?php echo $this->input->get('period_start') ?>&period_end=<?php echo $this->input->get('period_end') ?>&user=<?php echo $this->input->get('user') ?>" class="btn btn-custom-white btn-sm pull-right me-2" target="_blank"><i class="fa fa-print me-2"></i>Print Report</a>
					<!-- <button type="button" class="btn btn-custom-danger btn-sm pull-right" onclick="deleteAction()" title="Delete"><i class="fa fa-trash"></i> Delete</button> -->
					<?php endif; if(check_action_permission(get_user_role(), 'recharges', 'save_invoice')):?>
					<button class="btn btn-custom-success btn-sm pull-right ms-1" title="Add Prepaid Recharge" data-bs-toggle="modal" data-bs-target=".add-recharge-modal"><i class="fa fa-plus"></i> Prepaid Recharge</button>
					<?php endif; ?>
				</div>
				<?php if($this->admin->getInfo()){
				$info = explode("--", $this->admin->getInfo());
				$info_type = $info[0];
				$msg_data = $info[1];
				if($info_type == 1){
				?>
				<div class="alert alert-success alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					<strong><?php echo $msg_data; ?></strong>
				</div>
				<?php } else{?>
				<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					<strong><?php echo $msg_data;?></strong>
				</div>
				<?php }} $this->admin->removeInfo();  ?>
				<?php if($this->input->get('msg')){ ?>
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<strong><?php echo $this->input->get('msg'); ?></strong>
					</div>
				<?php }?>
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
						<form method="get">
							<div class="row align-items-center">
								
								<div class="col-lg-4 col-sm-6 mb-2">
									<label for="sim_no">Select Sim Number</label>
									<select name="sim_no" class="form-control select2" id="sim_no">
										<option value="">[ANY]</option>
										<?php foreach($inv_sim_list as $sim_list) { ?>
											<option value="<?php echo $sim_list->id;?>" <?php echo $this->input->get('sim_no') == $sim_list->id ? 'selected' : '' ?>><?php echo $sim_list->mobile; ?> (<?php echo $sim_list->sim_no; ?>)</option>
										<?php } ?>
									</select>
								</div>
								<div class="col-lg-4 col-sm-6 mb-2">
									<label for="network">Select Sim Network</label>
									<select name="network" class="form-control select2" id="network">
										<option value="">[ANY]</option>
										<?php if (!empty($networks)) {  
											foreach($networks as $key => $item) { ?>
												<option value="<?php echo $networks[$key]->id; ?>" <?php echo ($this->input->get('network') == $networks[$key]->id) ? 'selected' : ''; ?>><?php echo $networks[$key]->network_name; ?></option>
											<?php } } else { ?>
											<option value="" disabled>Add Network First</option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="date_range">Recharge Between: <span class="text-danger">*</span></label>
									<div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#datepicker6">
										<input type="text" class="form-control" name="period_start" placeholder="Start Date" value="<?php echo $this->input->get('period_start'); ?>" autocomplete="off">
										<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
										<input type="text" class="form-control" name="period_end" placeholder="End Date" value="<?php echo $this->input->get('period_end'); ?>" autocomplete="off">
										<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
									</div>
								</div>
								<?php
									$adv_show = false;
									if(!empty($this->input->get('user')) || !empty($this->input->get('plan')) || !empty($this->input->get('owner'))){
										$adv_show = true;
									}
								?>
								<div class="collapse <?php if($adv_show){ echo ' show';}?>" id="advanceFilter">
									<div class="row">
										<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
											<label for="plan">Select Plan:</label>
											<select name="plan" id="plan" class="form-control select2 w-100">
												<option value="">[Any Plan]</option>
												<?php foreach($plans as $plan) { ?>
													<option value="<?php echo $plan->id;?>" <?php echo ($plan->id == $this->input->get('plan')) ? 'selected' : ''; ?>><?php echo $plan->plan_name; ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-lg-4 col-sm-6 mb-2">
											<label for="owner">Select Owner</label>
											<select name="owner" class="form-control select2" id="owner">
												<option value="">[ANY]</option>
												<?php foreach($inv_sim_list as $sim_list) { ?>
													<option value="<?php echo $sim_list->owner_name;?>" <?php echo $this->input->get('owner') == $sim_list->owner_name ? 'selected' : '' ?>><?php echo $sim_list->owner_name; ?> (<?php echo $sim_list->owner_id; ?>)</option>
												<?php } ?>
											</select>
										</div>
										<div class="col-lg-4 col-sm-6 mb-2">
											<label for="user">User</label>
											<select name="user" class="form-control select2" id="user_no">
												<option value="">[ANY]</option>
												<?php foreach($emp_list as $item) { ?>
													<option value="<?php echo $item->id;?>" <?php echo $this->input->get('user') == $item->id ? 'selected' : '' ?>><?php echo $item->full_name; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>

								<div class="row mt-2">
									<div class="col-lg-6 col-md-6 col-sm-12">
										<button class="btn btn-outline-secondary waves-effect waves-light" type="button" data-bs-toggle="collapse" data-bs-target="#advanceFilter" aria-expanded="false" aria-controls="advanceFilter"><i class="fas fa-sliders-h"></i> Advance Search</button>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12">
										<button type="submit" class="btn btn-success btn-md float-end ms-2">Apply Filter</button>
										<a href="<?php echo base_url('admin/prepaid-mobile-invoice/list'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
									</div>
								</div>
								
							</div>
						</form>
					</div>
				</div>
			</div>
			
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<form id="myform" name="myform" method="post" action="">
							<table id="invoiceTable" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
								<thead>
									<tr>
										<!-- <th>#</th> -->
										<th>S.No.</th>
										<th>Mobile No.</th>
										<th>Service Provider</th>
										<th>Employee ID</th>
										<th>Employee Name</th>
										<th>Recharge Date</th>
										<th>Total Amount</th>
										<th>Recharge Card Sr No</th>
										<th>Created At</th>
										<th>Tools</th>
									</tr>
								</thead>
								<tbody>
									
								</tbody>
							</table>
						</form>
					</div>
					
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
 	</div>
</div>
 <!-- container-fluid -->

<!-- Modal -->
<div class="modal fade add-recharge-modal" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0">Recharge SIM</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<?php echo form_open("admin/prepaid-mobile-invoice/submit", array("id" => "rechargeForm", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
					<div class="row">
						<div class="col-md-6 col-sm-12 mb-3 form-group">
							<label for="sim_id">Select Sim Card <span class="text-danger">*</span></label>
							<select name="sim_id" id="sim_id" class="form-select select2" required>
								<option value="">Select Sim Card</option>
								<?php foreach($prepaid_sim_list as $sim_card){ ?>
								<option value="<?php echo $sim_card->id;?>" data-network="<?php echo $sim_card->network;?>"><?php echo $sim_card->mobile;?> - <?php echo $sim_card->sim_no;?></option>
								<?php } ?>
							</select>
							<small class="hint sim-provider-msg mb-0 mt-1">Select sim card</small>
						</div>
						<div class="col-md-6 col-sm-12 mb-3 form-group">
							<label for="recharge_date">Recharge Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control" id="recharge_date" name="recharge_date" required />
							<small class="hint">Enter recharge date</small>
						</div>
						<div class="col-md-6 col-sm-12 mb-3 form-group">
							<label for="voucher_id">Recharge Card Sr No<span class="text-danger">*</span></label>
							<select name="voucher_id" id="voucher_id" class="form-select select2" required>
								<option value="">Select Recharge Card</option>
							</select>
							<small class="hint">Select recharge card number</small>
						</div>
					</div>
				<?php echo form_close(); ?>
				<div class="row modal-info d-none">
					<hr>
					<div class="col-md-6" id="sim_info"></div>
					<div class="col-md-6" id="voucher_info"></div>
				</div>
			</div>
			<div class="modal-footer">
                <button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="rechargeForm" class="btn btn-success">Submit</button>
            </div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal -->
<div class="modal fade view-recharge-modal" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0">Recharge Detail</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" id="recharge_modal">
				
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this->load->view('admin/home/footer');?>

<script>
$(document).ready(function() {
	$('#invoiceTable').dataTable({
		"lengthMenu": [[25, 50, 100, 500], [25, 50, 100, 500]],
		order: [[0, 'asc']],
		dom: 'Blfrtip',
		buttons: [
			{
				extend: "csv",
				className: "btn-md"
			},
			{
				extend: "excel",
				className: "btn-md"
			},
			{
				extend: "pdfHtml5",
				className: "btn-md"
			},
			{
				extend: "print",
				className: "btn-md"
			},
		],

		"responsive": true,
		"processing":true,
		"serverSide":true,
		"fixedHeader": true,
		searching: false,
		"ajax":{
			url:"<?php echo base_url();?>admin/PrepaidMobileInvoice/get_list?sim_no=<?php echo $this->input->get('sim_no') ?>&network=<?php echo $this->input->get('network') ?>&plan=<?php echo $this->input->get('plan') ?>&owner=<?php echo $this->input->get('owner') ?>&period_start=<?php echo $this->input->get('period_start') ?>&period_end=<?php echo $this->input->get('period_end') ?>&user=<?php echo $this->input->get('user') ?>",
			type:"POST",
			// success: function(response){
			// 	console.log(response);
			// },
			error: function (request, error) {
				console.log(" Can't do because: " + JSON.stringify(request));
			},
		},
		"columnDefs":[
			{
			 "targets":[0,1,2,3,4,5,6,7,8,9],
			 "orderable":false
			},
		],
	});
});

function deleteAction() {
	var inputCount = $('[name="checklist[]"]:checked').length;
	if(inputCount > 0){
		if (confirm("Do you want to delete selected mobile invoice?") == true) {
			changeActionAndSubmit('admin/prepaid-mobile-invoice/delete');
		} else {
			userPreference = "Action Cancelled!";
		}
	}else{
		alert('Plese select check box first');
	}
}

function changeActionAndSubmit(action) {
	document.getElementById('myform').action = action;
	document.getElementById('myform').submit();
}

$('#sim_id').on('change',function(){
	getSimDetail();
});

$('#voucher_id').on('change',function(){
	getVoucherDetail();
});

function getSimDetail() {
	var sim_id = $('#sim_id option:selected').val();
	var network_id = $('#sim_id option:selected').data('network');
	//alert(network_id);
	if (sim_id !== "") {
		$.ajax({
			url: "<?php echo base_url('admin/PrepaidMobileInvoice/sim_detail_view');?>",
			type: "GET",
			data: {
				sim_id: sim_id,
			},
			dataType: "html",
			success: function (data) {
				//console.log(data);
				$('.modal-info').removeClass('d-none');
				$("#sim_info").html(data);
				$.ajax({
					url: "<?php echo base_url()?>admin/PrepaidMobileInvoice/getActiveVouchers",
					data: { "id": network_id },
					//dataType:"html",
					type: "get",
					success: function(data2){
						//console.log(network_id);
						$('#voucher_id').html(data2);
					},
					error: function(data){
						console.log(data2);
					}
				});
			},
			error: function (response) {
				console.log(response);
				$("#sim_info").html('');
				return false;
			},
		});
	}
}

function getVoucherDetail() {
	var voucher_id = $('#voucher_id option:selected').val();
	//alert(network_id);
	if (voucher_id !== "") {
		$.ajax({
			url: "<?php echo base_url('admin/PrepaidMobileInvoice/voucher_detail_view');?>",
			type: "GET",
			data: {
				voucher_id: voucher_id,
			},
			dataType: "html",
			success: function (data) {
				//console.log(data);
				$("#voucher_info").html(data);
			},
			error: function (response) {
				console.log(response);
				$("#voucher_info").html('');
				return false;
			},
		});
	}
}

function rechargeDetailView(id) {
	//alert(network_id);
	if (id !== "") {
		$.ajax({
			url: "<?php echo base_url('admin/PrepaidMobileInvoice/recharge_detail_view');?>",
			type: "GET",
			data: {
				id: id,
			},
			//dataType: "html",
			success: function (data) {
				//console.log(data);
				$("#recharge_modal").html(data);
				$('.view-recharge-modal').modal('show'); 
			},
			error: function (response) {
				console.log(response);
				$("#recharge_modal").html(data);
				//return false;
			},
		});
	}
}

</script>
