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
input[switch]+label {
    width: 58px;
    height: 32px;
}
input[switch]+label:before{
	font-weight: 700;
    font-size: 13px;
    line-height: 26px;
	top: 0px;
}
input[switch]+label:after{
	top: 6px;
}
#sim_info p{
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
				<h4>Postpaid Mobile Invoice</h4>
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/mobile-invoice/list">Postpaid Mobile Invoice</a></li>
					<li class="breadcrumb-item active">List</li>
				</ol>
			</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if($inv_count > 0 && check_action_permission(get_user_role(), 'sim_invoices', 'print_report')): ?>
					<a type="reset" href="<?php echo base_url();?>admin/mobile-invoice/print_report?inv_no=<?php echo $this->input->get('inv_no') ?>&sim_no=<?php echo $this->input->get('sim_no') ?>&network=<?php echo $this->input->get('network') ?>&plan=<?php echo $this->input->get('plan') ?>&owner=<?php echo $this->input->get('owner') ?>&period_start=<?php echo $this->input->get('period_start') ?>&period_end=<?php echo $this->input->get('period_end') ?>&user=<?php echo $this->input->get('user') ?>&is_gps_sim=<?php echo $this->input->get('is_gps_sim')?>" class="btn btn-custom-white btn-sm pull-right me-2" target="_blank"><i class="fa fa-print me-2"></i>Print Report</a>
					<?php if(check_action_permission(get_user_role(), 'sim_invoices', 'delete')): ?>
					<button type="button" class="btn btn-custom-danger btn-sm pull-right" onclick="deleteAction()" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					<?php endif; endif; if(check_action_permission(get_user_role(), 'sim_invoices', 'save_sim')): ?>
					<button class="btn btn-custom-success btn-sm pull-right ms-1" title="Add Postpaid Invoice" data-bs-toggle="modal" data-bs-target=".add-invoice-modal"><i class="fa fa-plus"></i> Add Invoice</button>
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
									<label>Search By Invoice Number</label>
									<input type="text" id="inv_no" name="inv_no" placeholder="Enter invoice number" value="<?php echo $this->input->get('inv_no') ? $this->input->get('inv_no') : ''; ?>" autocomplete="off" class="form-control">
								</div>
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

								<?php
									$adv_show = false;
									if(!empty($this->input->get('period_start')) || !empty($this->input->get('period_end')) || !empty($this->input->get('user')) || !empty($this->input->get('plan')) || !empty($this->input->get('owner')) || !empty($this->input->get('is_gps_sim'))){
										$adv_show = true;
									}
								?>
								<div class="collapse <?php if($adv_show){ echo ' show';}?>" id="advanceFilter">
									<div class="row">
										<div class="col-lg-4 col-sm-6 mb-2">
											<label class="form-label">Period Start</label>
											<div class="position-relative" id="datepicker4">
												<input type="text" name="period_start" value="<?php echo $this->input->get('period_start') ?>" class="form-control" data-date-container="#datepicker4" data-provide="datepicker" data-date-format="MM yyyy" data-date-min-view-mode="1" autocomplete="off">
											</div>
										</div>
										<div class="col-lg-4 col-sm-6 mb-2">
											<label class="form-label">Period End</label>
											<div class="position-relative" id="datepicker4">
												<input type="text" name="period_end" value="<?php echo $this->input->get('period_end') ?>" class="form-control" data-date-container="#datepicker4" data-provide="datepicker" data-date-format="MM yyyy" data-date-min-view-mode="1" autocomplete="off">
											</div>
										</div>
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
										<div class="form-group col-lg-4 col-sm-6 mb-3">
											<label for="is_gps_sim">GPS Sim</label>
											<select name="is_gps_sim" class="form-control select2">
												<option value="">[Any]</option>
												<option value="on" <?php echo $this->input->get('is_gps_sim') == 'on' ? 'selected' : '' ?>>Yes</option>
												<option value="off" <?php echo $this->input->get('is_gps_sim') == 'off' ? 'selected' : '' ?>>No</option>
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
										<a href="<?php echo base_url('admin/mobile-invoice/list'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
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
										<th>#</th>
										<th>S.No.</th>
										<th>Invoice Number</th>
										<th>Mobile Number</th>
										<th>Bill Period</th>
										<th>Sim Network</th>
										<th>Is GPS Sim</th>
										<th>Sim Plan</th>
										<th>User</th>
										<th>Total Fees</th>
										<th>Status</th>
										<th>Created On</th>
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


<?php $this->load->view('admin/home/footer');?>
<div class="modal fade payment-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0">Invoice Payment</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<?php echo form_open("admin/mobile-invoice/update-payment", array("id" => "payment-form", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
					<input type="hidden" id="invoice_id" name="invoice_id" value="" required />
					<div class="row">
						<div class="col-md-6 col-sm-12 mb-3 form-group">
							<label for="amount_paid">Amount Paid<span class="text-danger">*</span></label>
							<input id="amount_paid" name="amount_paid" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" inputmode="numeric" required style="text-align: right;">
							<p class="hint">Amount paid for invoice</p>
						</div>
						<div class="col-md-6 col-sm-12 mb-3">
							<div class="form-group">
								<label for="date_of_payment">Payment Date <span class="text-danger">*</span></label>
								<input type="date" class="form-control" id="date_of_payment" name="date_of_payment" required />
								<p class="hint">Enter date of payment</p>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 mb-3">
							<div class="form-group">
								<label for="payment_source">Source of Payment <span class="text-danger">*</span></label>
								<select name="payment_source" class="form-select" id="payment_source" required>
									<option value=""> Select Payment Souirce </option>
									<option value="COO Rajhi"> COO Rajhi </option>
									<option value="Arif Rajhi"> Arif Rajhi </option>
									<option value="Afaq Rajh"> Afaq Rajh </option>
									<option value="Wasim Rajhi"> Wasim Rajhi </option>
								</select>
								<p class="hint">Enter source of payment</p>
							</div>
						</div>
						
						<div class="form-group col-lg-12 col-md-12 col-12 mb-3">
							<input type="submit" value="Update Status" class="form-control btn btn-custom-success" />
						</div>
					</div>
				<?php echo form_close(); ?>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal -->
<div class="modal fade add-invoice-modal" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" style="max-width: 900px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0">Add Postpaid Invoice</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<?php echo form_open("admin/mobile-invoice/submit", array("id" => "invoiceForm", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
					<input type="hidden" id="id" name="id" value="" />
					
					<div class="row">
						<div class="col-md-4 col-sm-12 mb-3 form-group">
							<label for="sim_id">Sim/Mobile No <span class="text-danger">*</span></label>
							<select name="sim_id" class="form-control select2" id="sim_id" required>
								<option value="">-- Select Sim Card --</option>
								<?php if (!empty($sims)) {  
									foreach($sims as $key => $item) { ?>
										<option value="<?php echo $sims[$key]->id; ?>"><?php echo $sims[$key]->mobile . ' ('.$item->sim_no.')'; ?></option>
									<?php } } else { ?>
									<option value="" disabled>No data found</option>
								<?php } ?>
							</select>
						</div>

						<div class="col-md-4 col-sm-12 mb-3 form-group">
							<label for="group_invoice">Group Invoice</label>
							<div class="bg-light p-2">
								<input class="checkbox" type="checkbox" id="group_invoice" name="group_invoice" style="margin-right: 5px;height: 23px;width: 23px;vertical-align: middle;" data-parsley-multiple="group_invoice">
								<span>Group Invoice.</span>
							</div>
						</div>

						<div class="col-md-4 col-sm-12 mb-3 form-group">
							<label for="invoice_no">Invoice No <span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="invoice_no" name="invoice_no" maxlength="55" onBlur="checkDuplicateInvoiceNo()" required="required" />
							<small class="hint res-msg">Enter invoice number</small>
						</div>
						
						<div class="col-md-4 col-sm-12 mb-3">
							<label class="form-label">Period <span class="text-danger">*</span></label>
							<div class="position-relative" id="datepicker4">
								<input type="month" name="period" id="period" class="form-control" onBlur="checkPrevoiusInvoice()" required autocomplete="off">
							</div>
							<small class="res-msg-period"></small>
						</div>
						
						<div class="col-md-4 col-sm-12 mb-3 form-group">
							<label for="previous_bal">Previous Balance</label>
							<input id="previous_bal" name="previous_bal" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" inputmode="numeric" style="text-align: right;">
						</div>
						<div class="col-md-4 col-sm-12 mb-3 form-group">
							<label for="fee">Monthly Fees <span class="text-danger">*</span></label>
							<input id="fee" name="fee" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" inputmode="numeric" required style="text-align: right;">
						</div>
						<div class="col-md-4 col-sm-12 mb-3 form-group">
							<label for="off_plan">Off Plan Charges</label>
							<input id="off_plan" name="off_plan" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" inputmode="numeric" style="text-align: right;">
						</div>
						<div class="col-md-4 col-sm-12 mb-3 form-group">
							<label class="d-block">Off Plan Deduction (from Payroll)</label>
							<input type="checkbox" id="switch3" switch="bool" name="offplan_deduct_payslip" />
							<label for="switch3" data-on-label="Yes" data-off-label="No"></label>
						</div>
						<div class="col-md-4 col-sm-12 mb-3 form-group">
							<label for="add_on">Add-Ons & Other Services</label>
							<input id="add_on" name="add_on" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" inputmode="numeric" style="text-align: right;">
						</div>
						<div class="col-md-4 col-sm-12 mb-3 form-group">
							<label class="d-block">Add-ons & other Services Deduction</label>
							<input type="checkbox" id="switch4" switch="bool" name="addon_deduct_payslip" />
							<label for="switch4" data-on-label="Yes" data-off-label="No"></label> <span style="float: right;margin-right: 20px;">(from Payroll)</span>
						</div>
						<div class="col-md-4 col-sm-12 mb-3 form-group">
							<label for="adjustment">Adjustments</label>
							<input id="adjustment" name="adjustment" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" inputmode="numeric" style="text-align: right;">
						</div>
						<div class="col-md-4 col-sm-12 mb-3 form-group">
							<label for="discount">Discounts</label>
							<input id="discount" name="discount" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" inputmode="numeric" style="text-align: right;">
						</div>
						<div class="col-md-4 col-sm-12 mb-3 form-group">
							<label for="installment">Installments</label>
							<input type="text" class="form-control" id="installment" name="installment" maxlength="7" />
						</div>
						<div class="col-md-4 col-sm-12 mb-3 form-group">
							<label for="vat_percent">VAT Percentage</label>
							<select name="vat_percent" class="form-select" id="vat_percent">
								<option value=""> Select VAT Percentage </option>
								<option value="15"> VAT 15% Applicable </option>
							</select>
						</div>
						<div class="col-md-4 col-sm-12 mb-3 form-group">
							<label for="total_amount">Total SAR<span class="text-danger">*</span></label>
							<input id="total_amount" name="total_amount" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" inputmode="numeric" required style="text-align: right;">
						</div>
						<div class="col-md-4 col-sm-12 mb-3 form-group">
							<label for="payment_source">Payment Source</label>
							<select name="payment_source" class="form-select" id="payment_source">
								<option value=""> Select Payment Souirce </option>
								<option value="COO Rajhi"> COO Rajhi </option>
								<option value="Arif Rajhi"> Arif Rajhi </option>
								<option value="Afaq Rajh"> Afaq Rajh </option>
								<option value="Wasim Rajhi"> Wasim Rajhi </option>
							</select>
						</div>
						<div class="col-md-4 col-sm-12 mb-3 form-group">
							<label for="attachment">Attach Invoice</label>
							<input type="file" class="form-control" id="attachment" name="attachment[]" multiple />
							<p class="hint">Attach Invoice Copy</p>
						</div>
						
						<!-- <div class="col-md-4 col-sm-12 mb-3">
							<div class="form-group">
								<label>Amount Paid</label>
								<input type="text" class="form-control text-right">
							</div>
						</div>
						<div class="col-md-4 col-sm-12 mb-3">
							<div class="form-group">
								<label>Payment Date</label>
								<input type="text" class="form-control" />
							</div>
						</div> -->
					</div>
				<?php echo form_close(); ?>
				<div class="row modal-info d-none">
					<hr>
					<div class="col-md-6" id="sim_info"></div>
				</div>
			</div>
			<div class="modal-footer">
                <button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="invoiceForm" class="btn btn-success">Submit</button>
            </div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
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
			url:"<?php echo base_url();?>admin/Mobile_invoice/get_list?inv_no=<?php echo $this->input->get('inv_no') ?>&sim_no=<?php echo $this->input->get('sim_no') ?>&network=<?php echo $this->input->get('network') ?>&plan=<?php echo $this->input->get('plan') ?>&owner=<?php echo $this->input->get('owner') ?>&period_start=<?php echo $this->input->get('period_start') ?>&period_end=<?php echo $this->input->get('period_end') ?>&user=<?php echo $this->input->get('user') ?>&is_gps_sim=<?php echo $this->input->get('is_gps_sim')?>",
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
			 "targets":[0,1,2,3,4,5,6,7,8,9,10,11,12],
			 "orderable":false
			},
		],
	});

	$('#sim_id').on('change',function(){
		getSimDetail();
	});
});

function deleteAction() {
	var inputCount = $('[name="checklist[]"]:checked').length;
	if(inputCount > 0){
		if (confirm("Do you want to delete selected mobile invoice?") == true) {
			changeActionAndSubmit('admin/mobile-invoice/delete');
		} else {
			userPreference = "Action Cancelled!";
		}
	}else{
		alert('Plese select check box first');
	}
}

var EnableStatus = function() {
	var inputCount = $('[name="checklist[]"]:checked').length;
	if(inputCount > 0){
		if (confirm("Do you want to enable selected store?") == true) {
			changeActionAndSubmit('admin/store_manage/setStatusEnable');
		} else {
			userPreference = "Action Cancelled!";
		}
	}else{
		alert('Plese select check box first');
	}
}

function DisableStatus() {
	var inputCount = $('[name="checklist[]"]:checked').length;
	if(inputCount > 0){
		if (confirm("Do you want to disable selected store?") == true) {
			changeActionAndSubmit('admin/store_manage/setStatusDisable');
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

function paymentPopup(identifier) {
	let invoice_id = $(identifier).data('id');
	$('.payment-modal #invoice_id').val('');
	if(invoice_id > 0){
		$('.payment-modal #invoice_id').val(invoice_id);
		$('.payment-modal').modal('show');
	}else{
		alert('Invalid request id!');
	}
}

function getSimDetail() {
	var sim_id = $('#sim_id option:selected').val();
	if(sim_id !== "") {
		$.ajax({
			url: "<?php echo base_url('admin/Mobile_invoice/get_sim_detail');?>",
			type: "POST",
			data: {
				id: sim_id,
			},
			dataType: "json",
			success: function (data) {
				if(data.status == 'success'){
					$('.modal-info').removeClass('d-none');
					$("#sim_info").html('<h6>Sim Card Detail:</h6><p><strong>SIM No : </strong>'+ data.sim_detail.sim_no +'</p><p><strong>Service Provider : </strong>'+ data.sim_detail.network_name +'</p><p><strong>Service Type : </strong>'+ data.sim_detail.sim_type +'</p><p><strong>Plan : </strong>'+ data.sim_detail.plan_name +'</p><p><strong>Employee ID : </strong>'+ data.sim_detail.emp_no +'</p><p><strong>Employee Name : </strong>'+ data.sim_detail.emp_full_name +'</p>');
				}else{
					$("#sim_info").html('');
					return false;
				}
			},
			error: function () {
				$("#sim_info").html('');
				return false;
			},
		});
	}
}

function checkDuplicateInvoiceNo() {
	var invoice_no = $("#invoice_no").val();
	var isGroup = $('#group_invoice').is(':checked');
	if(isGroup){
		var group = 'yes';
	}else{
		var group = 'no';
	}
	var id = $("#id").val();
	//alert(group);
	if (invoice_no !== "") {
		$.ajax({
			url: "<?php echo base_url();?>admin/mobile-invoice/check-invoice-no",
			type: "GET",
			data: {
				invoice_no: invoice_no,
				group_invoice: group,
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
		$("#invoice_no").addClass('parsley-error');
		$(".res-msg").html('<span class="text-danger">Enter Invoice number.</span>');
	}
}

function checkPrevoiusInvoice() {
	var sim_id = $('#sim_id').find(":selected").val();;
	var id = $("#id").val();
	if (sim_id !== "") {
		$.ajax({
			url: "<?php echo base_url();?>admin/mobile-invoice/check-prevoius-invoice",
			type: "GET",
			data: {
				sim_id: sim_id,
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
