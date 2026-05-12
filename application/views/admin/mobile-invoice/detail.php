
<?php $this->load->view('admin/home/header');?>

<style>
	.required-field{
		color: #f00;
	}
	.table th, .table td {
		vertical-align: middle;
		padding: 6px 10px;
	}
	input, textarea, select, select.select2, input[type='checkbox'], label{
		pointer-events: none;
	}
	span.required{
		color:red;
	}
	.cv-documents{
		border: 1px dashed #a9a9a9;
		padding: 6px;
		width: 130px;
		height: 130px;
		margin-top: -9px;
	}
	.image-container {
		position: relative;
		display: inline-block;
	}
	.image-container .overlay{
		opacity: 0;
	}
	.image-container:hover .overlay{
		background: #0006;
		opacity: .9;
		position: absolute;
		top: -9px;
		bottom: 0;
		width: 130px;
    	height: 130px;
	}
	.image-container:hover .edit {
		display: block;
	}
	.image-container .edit {
		padding-top: 7px;	
		padding-right: 7px;
		position: absolute;
		right: 0;
		left: 0;
		top: 20%;
		display: none;
	}
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Postpaid Mobile Invoice</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/mobile-invoice/list">Postpaid Mobile Invoice</a></li>
						<li class="breadcrumb-item active">Detail</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id');?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url(); ?>admin/mobile-invoice/list"><i class="fa fa-reply"></i> Back</a>
					

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
							<div class="row">
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="sim_id">Sim/Mobile No <span class="required-field">*</span></label>
									<select name="sim_id" class="form-control" id="sim_id" required>
										<option value="">-- Select Sim Card --</option>
										<?php if (!empty($sims)) {  
											foreach($sims as $key => $item) { ?>
												<option value="<?php echo $sims[$key]->id; ?>" <?php echo ($sims[$key]->id == $sim_id) ? ' selected ' : ''; ?>><?php echo $sims[$key]->mobile . ' ('.$item->sim_no.')'; ?></option>
											<?php } } else { ?>
											<option value="" disabled>Add Network First</option>
										<?php } ?>
									</select>
									<p class="hint res-msg-sim">Enter sim no</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="group_invoice">Group Invoice</label>
									<div class="bg-light p-2">
										<input class="checkbox" type="checkbox" id="group_invoice" name="group_invoice" style="margin-right: 5px;height: 23px;width: 23px;vertical-align: middle;" data-parsley-multiple="group_invoice" <?php echo ($group_invoice == 'on') ? ' checked ' : '' ;?>>
										<span>Group Invoice.</span>
									</div>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="invoice_no">Invoice No <span class="required-field">*</span></label>
									<input type="text" class="form-control" id="invoice_no" name="invoice_no" maxlength="55" value="<?php echo $invoice_no; ?>" onBlur="checkDuplicateInvoiceNo()" required="required" <?php echo ($id !== '') ? 'readonly' : '';?> />
									<p class="hint res-msg">Enter invoice number</p>
								</div>
								
								<div class="col-md-4 col-sm-12 mb-3">
									<label class="form-label">Period <span class="required-field">*</span></label>
									<div class="position-relative" id="datepicker4">
										<input type="text" name="period" id="period" value="<?php echo !empty($period) ? date('M Y', strtotime($period)) : ''; ?>" class="form-control" data-date-container="#datepicker4" data-provide="datepicker" data-date-format="MM yyyy" data-date-min-view-mode="1" onBlur="checkDuplicateInvoice()" required autocomplete="off">
									</div>
									<p class="hint res-msg-period">Enter Period</p>
								</div>
								
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="previous_bal">Previous Balance</label>
									<input id="previous_bal" name="previous_bal" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" inputmode="numeric" value="<?php echo $previous_bal;?>" style="text-align: right;">
									<p class="hint">Enter Previous Balance</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="fee">Monthly Fees <span class="required-field">*</span></label>
									<input id="fee" name="fee" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" inputmode="numeric" value="<?php echo $fee;?>" required style="text-align: right;">
									<p class="hint">Enter Monthly Fees</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="off_plan">Off Plan Charges</label>
									<input id="off_plan" name="off_plan" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" inputmode="numeric" value="<?php echo $off_plan;?>" style="text-align: right;">
									<p class="hint">Enter Off Plan Charges</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label class="d-block">Off Plan Deduction (from pay slip)</label>
									<input type="checkbox" id="switch3" switch="bool" name="offplan_deduct_payslip" <?php echo ($offplan_deduct_payslip == 'on') ? "checked":"" ?> />
									<label for="switch3" data-on-label="Yes" data-off-label="No"></label>
									<p class="hint">Switch Yes, If deduct from pay slip</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="add_on">Add-Ons & Other Services</label>
									<input id="add_on" name="add_on" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" inputmode="numeric" value="<?php echo $add_on;?>" style="text-align: right;">
									<p class="hint">Enter Add-Ons & Other Services</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label class="d-block">Add-ons & other Services Deduction (from pay slip)</label>
									<input type="checkbox" id="switch4" switch="bool" name="addon_deduct_payslip" <?php echo ($addon_deduct_payslip == 'on') ? "checked":"" ?> />
									<label for="switch4" data-on-label="Yes" data-off-label="No"></label>
									<p class="hint">Switch Yes, If deduct from pay slip</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="adjustment">Adjustments</label>
									<input id="adjustment" name="adjustment" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" inputmode="numeric" value="<?php echo $adjustment;?>" style="text-align: right;">
									<p class="hint">Enter Adjustments</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="discount">Discounts</label>
									<input id="discount" name="discount" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" inputmode="numeric" value="<?php echo $discount;?>" style="text-align: right;">
									<p class="hint">Enter Discounts</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="installment">Installments</label>
									<input type="text" class="form-control" id="installment" name="installment" maxlength="7" value="<?php echo $installment; ?>" />
									<p class="hint">Enter Installments</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="vat_percent">VAT Percentage</label>
									<select name="vat_percent" class="form-select" id="vat_percent">
										<option value="15" <?php echo ($vat_percent == '15') ? "selected" : "" ?>> VAT 15% Applicable </option>
									</select>
									<p class="hint text-dark">Applicable VAT Percentage</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="total_amount">Total Invoice Amount<span class="required-field">*</span></label>
									<input id="total_amount" name="total_amount" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" inputmode="numeric" value="<?php echo $total_amount;?>" required style="text-align: right;">
									<p class="hint">Enter Total Invoice Amount</p>
								</div>
								
								<?php if($date_of_payment !== ''){ ?>
								<div class="col-md-4 col-sm-12 mb-3">
									<div class="form-group">
										<label>Amount Paid</label>
										<input type="text" class="form-control text-right" value="<?php echo $amount_paid;?>" disabled>
									</div>
								</div>
								<div class="col-md-4 col-sm-12 mb-3">
									<div class="form-group">
										<label>Payment Date</label>
										<input type="text" class="form-control" value="<?php echo date('d-m-Y',strtotime($date_of_payment));?>" disabled />
									</div>
								</div>
								<div class="col-md-4 col-sm-12 mb-3">
									<div class="form-group">
										<label>Source of Payment</label>
										<input type="text" class="form-control" value="<?php echo $payment_source;?>" maxlength="100" disabled />
									</div>
								</div>
								<?php } ?>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="attachment">Attach Invoice<span class="required-field">*</span></label>
									<div class="col-md-12 mt-2">
										<?php 
											if(count($attachment) > 0){ 
											foreach($attachment as $cv_doc){
											$file_extension = pathinfo($cv_doc['file_name'], PATHINFO_EXTENSION);
										?>
										<div class="float-start text-center image-container mt-2 me-2" id="img_<?php echo $cv_doc['id'];?>">
											<img src="<?php echo ($file_extension == 'doc' || $file_extension == 'docx' || $file_extension == 'pdf') ? base_url('images/attached-file.png') : base_url($cv_doc['file_name']); ?>" class="cv-documents" />
											<div class="overlay"></div>
											<div class="edit"><a href="<?php echo base_url($cv_doc['file_name']);?>" class="btn btn-primary btn-sm" target="_blank" title="View"><i class="fa fa-eye"></i></a></div>
										</div>
										<?php }} ?>
									</div>
								</div>
							</div>
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

	$(function(){
		var dtToday = new Date();

		var month = dtToday.getMonth() + 1;
		var day = dtToday.getDate();
		var year = dtToday.getFullYear();

		$('#vat_expiry').attr('min', maxDate);
		$('#cr_expiry').attr('min', maxDate);
		$('#agrement_expiry').attr('min', maxDate);
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

	function checkDuplicateInvoiceNo() {
		var invoice_no = $("#invoice_no").val();
		var id = $("#id").val();
		if (invoice_no !== "") {
			$.ajax({
				url: "<?php echo base_url();?>admin/mobile-invoice/check-invoice-no",
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
			$("#invoice_no").addClass('parsley-error');
			$(".res-msg").html('<span class="text-danger">Enter Invoice number.</span>');
		}
	}

	function checkDuplicateInvoice() {
		var sim_id = $('#sim_id').find(":selected").val();;
		var id = $("#id").val();
		var period = $("#period").val();
		if (period !== "") {
			$.ajax({
				url: "<?php echo base_url();?>admin/mobile-invoice/check-invoice",
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
			$(".res-msg-period").html('<span class="text-danger">Enter mobile number.</span>');
		}
	}

	$('.remove-cv-image').click(function() {
		var img_id = $(this).data('id');
		var item_id = "<?php echo $this->input->get('id');?>";
		//alert(size_id);
		if(confirm('Are you sure want to delete?')) {
			if(img_id > 0){
				$.ajax({
					url: "<?php echo base_url('admin/mobile-invoice/delete-doc');?>",
					type: "POST",
					data: {
						img_id: img_id,
						item_id: item_id,
					},
					dataType: "json",
					success: function (data) {
						if(data.type == 'success'){
							$('#img_'+img_id).remove();
							Swal.fire({
								icon: 'success',
								title: 'Success',
								text: data.message,
								timer: 1500
							});
						}else{
							Swal.fire({
								icon: 'error',
								title: 'Error',
								text: data.message,
								timer: 1500
							});
						}
					},
					error: function (data) {
						console.log(data);
					},
				});
			}else{
				return false;
			}
		}else{
			return false;
		}
		return false;
	});
</script>
