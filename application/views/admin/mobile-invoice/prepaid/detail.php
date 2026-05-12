
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
	.detail-inputs input, .detail-inputs textarea, .detail-inputs select, .detail-inputs .select2{
		pointer-events: none;
		background-color: #edf1f5;
	}
	.select2-container--default.select2-container--disabled .select2-selection--single {
		background-color: #fff !important;
		border-color: #eee !important;
		pointer-events: none;
	}
</style>

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
						<li class="breadcrumb-item active">Detail</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id');?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if ($this->customer->userd($admin_id)->role == "Admin") {?>
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url(); ?>admin/prepaid-mobile-invoice/list"><i class="fa fa-reply"></i> Back</a>
					<?php }?>

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
						<div class="row detail-inputs">
							<div class="col-md-4 col-sm-12 mb-3 form-group">
								<label for="invoice_no">Invoice No (Optional)</label>
								<input type="text" class="form-control" id="invoice_no" name="invoice_no" maxlength="55" value="<?php echo $invoice_no; ?>" onBlur="checkDuplicateInvoiceNo()" <?php echo ($id !== '') ? 'readonly' : '';?> />
								<p class="hint res-msg">Enter invoice number</p>
							</div>
							<div class="col-md-4 col-sm-12 mb-3 form-group">
								<label for="sim_id">Mobile No <span class="required-field">*</span></label>
								<select name="sim_id" class="form-control" id="sim_id" onchange="checkDuplicateInvoice()" required>
									<option value="">-- Select Sim Card --</option>
									<?php if (!empty($sims)) {  
										foreach($sims as $key => $item) { ?>
											<option value="<?php echo $sims[$key]->id; ?>" <?php echo ($sims[$key]->id == $sim_id) ? 'selected' : ''; ?>><?php echo $sims[$key]->mobile . ' ('.$item->sim_no.')'; ?></option>
										<?php } } else { ?>
										<option value="" disabled>No data found</option>
									<?php } ?>
								</select>
								<p class="hint res-msg-sim">Select Sim Card</p>
							</div>
							<div class="col-md-4 col-sm-12 mb-3">
								<label class="form-label">Recharge Date <span class="required-field">*</span></label>
								<input type="date" name="recharge_date" id="recharge_date" value="<?php echo $recharge_date; ?>" class="form-control" onBlur="checkDuplicateInvoice()" required autocomplete="off">
								<p class="hint res-msg-period">Enter Recharge Date</p>
							</div>
							
							<div class="col-md-4 col-sm-12 mb-3 form-group">
								<label for="plan_days">Recharge Plan Days <span class="required-field">*</span></label>
								<input type="number" class="form-control" id="plan_days" name="plan_days" maxlength="3" min="1" max="366" value="<?php echo $plan_days; ?>" required />
								<p class="hint">Enter Recharge Plan Days</p>
							</div>
							
							<div class="col-md-4 col-sm-12 mb-3 form-group">
								<label for="total_amount">Recharge Amount <span class="required-field">*</span></label>
								<input id="total_amount" name="total_amount" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" inputmode="numeric" value="<?php echo $total_amount;?>" required style="text-align: right;">
								<p class="hint">Enter Recharge Amount</p>
							</div>
							<div class="col-md-4 col-sm-12 mb-3 form-group">
								<label for="vat_percent">VAT Amount <span class="required-field">*</span></label>
								<input id="vat_percent" name="vat_percent" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" inputmode="numeric" value="<?php echo $vat_percent;?>" required style="text-align: right;">
								<p class="hint">Enter VAT Amount</p>
							</div>
							<div class="col-md-4 col-sm-12 mb-3">
								<div class="form-group">
									<label>Source <span class="required-field">*</span></label>
									<input type="text" class="form-control" name="payment_source" value="<?php echo $payment_source;?>" maxlength="100" required />
									<p class="hint">Enter source of payment</p>
								</div>
							</div>
							<div class="col-md-4 col-sm-12 mb-3">
								<label class="form-label">Created Date <span class="required-field">*</span></label>
								<input type="text" name="created_at" id="created_at" value="<?php echo ($created_at !== '') ? date('d-m-Y', strtotime($created_at)) : ''; ?>" class="form-control" required autocomplete="off">
								<p class="hint res-msg-period">Created Date</p>
							</div>
							<div class="col-md-4 col-sm-12 mb-3">
								<label class="form-label">Updated Date <span class="required-field">*</span></label>
								<input type="text" name="updated_at" id="updated_at" value="<?php echo ($updated_at !== '') ? date('d-m-Y', strtotime($updated_at)) : ''; ?>" class="form-control" required autocomplete="off">
								<p class="hint res-msg-period">Updated Date</p>
							</div>
							<div class="col-md-4 col-sm-12 mb-3 form-group">
								<label for="attachment">Attach Voucher (Optional)</label>
								<input type="file" class="form-control" id="attachment" name="attachment[]" multiple />
								<p class="hint">Attach Voucher Copy</p>
								<div class="col-md-12 mt-2">
									<?php 
										if(count($attachment) > 0){ 
										foreach($attachment as $cv_doc){
										$file_extension = pathinfo($cv_doc['file_name'], PATHINFO_EXTENSION);
									?>
									<div class="float-start text-center image-container mt-2 me-2" id="img_<?php echo $cv_doc['id'];?>">
										<img src="<?php echo ($file_extension == 'doc' || $file_extension == 'docx' || $file_extension == 'pdf') ? base_url('images/attached-file.png') : base_url($cv_doc['file_name']); ?>" class="cv-documents" />
										<div class="overlay"></div>
										<div class="edit"><a href="<?php echo base_url($cv_doc['file_name']);?>" class="btn btn-primary btn-sm" target="_blank" title="View"><i class="fa fa-eye"></i></a> <a type="button" class="btn btn-danger btn-sm remove-inv-image" data-id="<?php echo $cv_doc['id'];?>" title="Delete"><i class="fa fa-trash"></i></a></div>
									</div>
									<?php }} ?>
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
