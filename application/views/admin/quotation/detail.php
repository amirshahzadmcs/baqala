<?php $this->load->view('admin/home/header');?>
<style>
.dataTables_wrapper::-webkit-scrollbar {
  display: none;
}
.nav-md .container.body .right_col {
    padding: 10px 10px 0;
    margin-left: 230px;
}
.table>:not(caption)>*>* {
    border-bottom-width: 0;
    border-top-width: 0px;
}

#tableOrder tbody tr td{
    font-size: 13px;
    font-weight: 500;
}
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Quotation Detail</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('quotation');?>">Quotation</a></li>
						<li class="breadcrumb-item active">Detail</li>
					</ol>
				</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-1" title="Back" href="<?php echo base_url('admin/quotation/list');?>"><i class="fa fa-reply"></i> Back</a>
					<a class="btn btn-sm btn-custom-white pull-right me-1" title="Print" href="<?php echo base_url('admin/quotation/print-delivery-note?id='. $this->input->get('id'));?>" target="_blank"><i class="fa fa-print"></i> Delivery Note</a>
					<button form="updateForm" type="submit" class="btn btn-custom-success btn-sm pull-right me-1 d-none"><i class="fa fa-save"></i> Save</button>
					<?php if($result['order']['order_status_id'] == '1'){ ?>
						<?php if($result['order']['quotation_status'] !== 'accept' && $result['order']['quotation_status'] !== 'converted'){ ?>
						<a class="btn btn-sm btn-custom pull-right me-1" title="Edit" href="<?php echo base_url().'admin/quotation/edit?id='.$result['order']['id'];?>"><i class="fa fa-pen"></i></a>
						<?php } ?>
						<button type="button" class="btn btn-custom-danger btn-sm pull-right me-1" data-bs-toggle="modal" data-bs-target=".convert-modal"><i class="fa fa-forward"></i> Convert to Order</button>
						<a href="<?php echo base_url();?>admin/quotation/send-mail?id=<?php echo $this->input->get('id');?>" class="btn btn-custom-white btn-sm pull-right" data-toggle="tooltip" title="Send Mail"><i class="fa fa-paper-plane"></i> Send Mail</a>
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
				<strong><?php echo $msg_data;?></strong>
				</div>

				<?php } else{?>
				<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					<strong><?php echo $msg_data;?></strong>
				</div>
				<?php } ?> <?php } $this->admin->removeInfo();?>
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
					 	<table class="table" width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; line-height: 22px;">
							<tr>
								<td colspan="2"><img src="<?php echo base_url('admin_assets/images/quotation/header-top.jpg');?>" style="width: 100%;max-width: 100%;" /></td>
							</tr>
							<tr>
								<td align="left" valign="top" style="width: 40%;">
									<strong>SUPPLIER ADDRESS <br /> </strong><?php echo $this->admin->getWarehouseDetail()->contact_person;?><br/>
									Contact No. - <?php echo $this->admin->getWarehouseDetail()->warehouse_phone;?><br/>
									Address: <?php echo $this->admin->getWarehouseDetail()->complete_address;?>,<br>Kindom of Saudi Arabia.<br>
									VAT No. - 300034911400003
								</td>
								<td valign="top" style="width: 60%; float: right;text-align: right;">
									<?php if(!empty($result['order']['payment_code'])){?>
									<strong>TransRef ID :</strong> <?php echo $result['order']['payment_code']; ?><br/>
									<?php } ?>
									<strong>Quotation Number :</strong> <?php echo $result['order']['invoice_prefix'] .'-'. $result['order']['quotation_no'];?><br/>
									<strong>Associate Name:</strong> <?php echo $result['order']['associate_name'];?><br />
									<strong>Payment type:</strong> <?php echo $result['order']['payment_method']; ?><br />
									<strong>Quotation Date:</strong> <?php $qdate=$result['order']['date_added']; echo date('d-m-Y', strtotime($qdate)); ?><br/>
									<strong>Quotation Valid Till:</strong> <?php echo date('d-m-Y', strtotime($result['order']['quotation_expiry_date'])); ?><br/>
									<?php
										if($result['order']['quotation_status'] == 'pending'){
											$status_message = '<span class="badge badge-pill badge-soft-secondary font-size-13"> Pending</span>';
										}
										elseif($result['order']['quotation_status'] == 'review'){
											$status_message = '<span class="badge badge-pill badge-soft-info font-size-13"> In Review</span>';
										}elseif($result['order']['quotation_status'] == 'reject'){
											$status_message = '<span class="badge badge-pill badge-soft-danger font-size-13">Rejected</span>';
										}elseif($result['order']['quotation_status'] == 'approved'){
											$status_message = '<span class="badge badge-pill badge-soft-dark font-size-13">Approved</span>';
										}elseif($result['order']['quotation_status'] == 'accept'){
											$status_message = '<span class="badge badge-pill badge-soft-primary font-size-13">Accepted</span>';
										}elseif($result['order']['quotation_status'] == 'converted'){
											$status_message = '<span class="badge badge-pill badge-soft-success font-size-13">Converted</span>';
										}elseif($result['order']['quotation_status'] == 'delivered'){
											$status_message = '<span class="badge badge-pill bg-success font-size-13">Delivered</span>';
										}
									?>
									<strong>Status:</strong> <?= $status_message;?>
								</td>
							</tr>
							<tr>
								<td valign="top" style="width: 40%;">
									<strong>BILLING ADDRESS</strong><br/>
									<?php echo $result['order']['name'];?><br/>
									<?php echo $result['order']['mobile'];?><br/>
									<?php echo $result['order']['email'];?><br/>
									<?php echo $result['order']['building_no'];?> <?php echo $result['order']['street_name'];?> - <?php echo $result['order']['district_name'];?><br/>
									Unit No <?php echo $result['order']['unit_no'];?><br/>
									<?php echo $result['order']['sel_city_name'];?> <?php echo $result['order']['zip_code'];?> - <?php echo $result['order']['additional_no'];?><br/>
									<?php echo $result['order']['country'];?>
								</td>
								<td valign="top" style="width: 60%; float: right;text-align: right;">
									<strong>SHIPPING ADDRESS</strong><br/>
									<?php echo $result['order']['s_person_name'] .' ('. $result['order']['c_company'] .')';?><br/>
									<?php echo $result['order']['s_mobile'];?>, <?php echo $result['order']['s_phone'];?><br/>
									<?php echo $result['order']['s_email'];?><br/>
									<?php echo $result['order']['s_address_type'];?>-<?php echo $result['order']['s_building_villa_no'];?>, <?php echo $result['order']['s_street'];?><br/>
									<?php echo $result['order']['s_city'];?> <?php echo $result['order']['s_postal'];?><br/>
									<?php echo $result['order']['s_country'];?>
								</td>
							</tr>
							
							<tr>
								<td colspan="3" class="pb-0">
									<table class="table table-striped jambo_table table-bordered mb-0" id="tableOrder" width="100%" border="1" cellspacing="0" cellpadding="5">
										<thead>
											<tr>
												<td valign="top" bgcolor="#CCCCCC" style="width: 5%; text-align: center;"><strong>#</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 8%; text-align: center;"><strong>IMAGE</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 12%; text-align: center;"><strong>BARCODE</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 34%; text-align: center;"><strong>PRODUCT NAME/ DESCRIPTION</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 8%; text-align: center;"><strong>PRICE</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 6%; text-align: center;"><strong>QTY</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 5%; text-align: center;"><strong>VALUE</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 5%; text-align: center;"><strong>NET</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 5%; text-align: center;"><strong>VAT</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 5%; text-align: center;"><strong>VAT%</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 7%; text-align: center;"><strong>TOTAL</strong></td>
											</tr>
										</thead>
										<tbody>
                                            <?php 
                                                $total_qty =0;$i = 1;$amt_exl_vat = 0;$amt_incl_vat = 0;$total_vat = 0;$saving = 0;$ptotal = 0;
                                                foreach($result['product'] as $product){
                                                //$p_price = $product['real_price']; 
                                                $p_price = ($product['discounted_price'] == 0) ? $product['real_price'] : $product['discounted_price'];
                                                //$vat_initial = ($product['gst_rate'] / 100) * $p_price;
                                                $initial_price = $product['order_price'] - $product['vat_price'];
                                                $total_qty += $product['quantity'];
                                                $total_vat += $product['vat_price'];
                                                //$mrp += $product['real_price'] * $product['quantity'];
                                                $amt_exl_vat += $product['order_price'] - $product['vat_price'];
                                                $amt_incl_vat += $product['order_price'];
                                            ?>
                                            
                                            <tr>
                                                <input type="hidden" name="product_id[]" value="<?php echo $product['product_id'];?>" required />
                                                <input type="hidden" name="size_id[]" value="<?php echo $product['size_id'];?>" required />
                                                <td valign="top" style="text-align: center;width:5%;"><?php echo $i++;?></td>
                                                <td valign="top" style="text-align: center;width:8%;"><img src="<?php echo ($product['product_image'] == "" OR !file_exists($product['product_image'])) ? 'images/notfound.jpg':base_url($product['product_image']);?>" width="50px"></td>
                                                <td valign="top" style="text-align: center;width:12%;"><?php echo $product['barcode'];?></td>
                                                <td valign="top" style="width:34%;">
                                                    <?php echo $product['product_name']; ?><br />
                                                    <span style="display: block; text-align: right;"><?php echo $product['arabic_name']; ?> </span>
                                                </td>
                                                <td valign="top" style="text-align: right;width:8%;"><?php echo  sprintf("%.2f", $p_price); ?></td>
                                                <td valign="top" style="text-align: center;width:6%;"><?php echo $product['quantity'];?></td>
                                                <td valign="top" style="text-align: right;width:5%;"><?php echo  sprintf("%.2f", $product['order_price']); ?></td>
                                                <td valign="top" style="text-align: right;width:5%;"><?php echo sprintf("%.2f", $initial_price); ?></td>
                                                <td valign="top" style="text-align: center;width:5%;"><?php echo sprintf("%.2f", $product['vat_price']); ?></td>
                                                <td valign="top" style="text-align: center;width:5%;"><?php echo $product['gst_rate'] .'%'; ?></td>
                                                <td valign="top" style="text-align: right;width:7%;"><?php echo sprintf("%.2f", $product['order_price']); ?></td>
                                            </tr>
                                            <?php } ?>
										</tbody>
									</table>
									<table class="table table-bordered jambo_table mb-0" width="100%" border="1" cellspacing="0" cellpadding="5">
										<tr>
											<td colspan="12">
												<table style="width: 100%; margin-top: 0px; padding: 5px; border-top: none;">
													<tr>
														<td style="font-size: 12px; font-weight: 500;">أجمالي الأصناف / Total Items : <?php echo count($result['product']); ?></td>
														<td style="font-size: 12px; font-weight: 500;">الإجمالي بدون الضريبة / Total Excluding VAT : <?php echo round($amt_exl_vat,2); ?> SAR</td>
													</tr>
													<tr>
														<td style="font-size: 12px; font-weight: 500;">أجمالي الكمية / Total Qty. : <?php echo $total_qty; ?></td>
														<td style="font-size: 12px; font-weight: 500;"><?php if($result['order']['promo_code_price'] > 0){ echo 'الخصم / Discount: '. $result['order']['promo_code_price'] .'SAR ('. $result['order']['promo_code_name'] .')'; } ?></td>
													</tr>

													<tr>
														<td style="font-size: 12px; font-weight: 500;">طريقة الدفع / Mode of Payment: <?php echo $result['order']['payment_method']; ?></td>
														<td style="font-size: 12px; font-weight: 500;">الضريبة / VAT : <?php echo sprintf("%.2f",$total_vat); ?>  SAR</td>
													</tr>
													<tr>
														<?php if($result['order']['cashback_applied'] > 0){ ?>
														<td style="font-size: 12px; font-weight: 500;">Rewards used: <?php echo $result['order']['cashback_applied']; ?></td>
														<?php } ?>
														<?php if($result['order']['wallet_applied'] > 0){ ?>
														<td style="font-size: 12px; font-weight: 500;">Walet used:<b> <?php $net_amt = $result['order']['wallet_applied']; echo sprintf("%.2f",$net_amt);?> SAR</b></td>
														<?php } ?>
													</tr>
													<tr>
														<td style="font-size: 12px; font-weight: 500;">مصاريف الشحن / Shipping Charge: <?php echo $result['order']['shipping_charge']; ?></td>
														<td style="font-size: 12px; font-weight: 500;">المبلغ شامل الضريبة / Total Including VAT:<b> <?php $net_amt = $result['order']['order_total']; echo sprintf("%.2f",$net_amt);?> SAR</b></td>
													</tr>
													<tr>
														<?php if($result['order']['net_payble_amt'] > 0){ ?>
														<td colspan="2" style="font-size: 12px; font-weight: 500;">
															Net Payable Amount: 
															<strong><?php $net_payble_amt = $result['order']['net_payble_amt']; echo sprintf("%.2f",$net_payble_amt);?> SAR</strong>
														</td>
														<?php } ?>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
 					</div>
 				</div>
 			</div> <!-- end col -->
 		</div> <!-- end row -->
 	</div>
 </div>
<!-- Modal -->
<!-- Modal -->
<div class="modal fade convert-modal" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0">Convert To Order</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="convert-form" method="post" action="<?php echo base_url('admin/quotation/convert-order')?>" data-toggle="validator" role="form">
					<div class="row">
						<input type="hidden" name="id" value="<?php echo $this->input->get("id");?>" />
						<div class="col-md-6 form-group mb-3">
							<label for="shipping_date_slot">Delivery Date Slot <span class="required text-danger">*</span></label>
							<input type="date" class="form-control" id="shipping_date_slot" placeholder="Pick Date" name="shipping_date_slot" required />
						</div>
						<div class="col-md-6 form-group mb-3">
							<label for="shipping_time_slot">Delivery Time Slot <span class="required text-danger">*</span></label>
							<select id="shipping_time_slot" name="shipping_time_slot" class="form-control" required>
								<option value="">Select Time Slot</option>
							</select>
						</div>
						<div class="col-md-6 form-group mb-3">
							<label for="po_number">PO Number <span class="required text-danger">*</span></label>
							<input type="text" class="form-control" id="po_number" maxlength="40" placeholder="PO Number" name="po_number" required />
						</div>
						<div class="col-md-6 form-group mb-3">
							<label for="po_date">PO Date <span class="required text-danger">*</span></label>
							<input type="date" class="form-control" id="po_date" placeholder="Pick Date" name="po_date" required />
						</div>
						<div class="col-md-6 form-group mb-3">
							<label class="control-label" for="payment_method">Payment Terms <span class="required text-danger">*</span></label>
							<select id="payment_method" name="payment_method" class="form-control" required>
								<option value="">---- Select Payment Method ----</option>
								<?php foreach(payMethodsHelper() as $methods){ ?>
								<option value="<?= $methods->method_name;?>" <?php echo ( $methods->method_name == $result['order']['payment_method']) ? "selected":"" ?>><?= $methods->method_name;?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
                <button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="convert-form" class="btn btn-success">Submit</button>
            </div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this->load->view('admin/home/footer');?>

<script type="text/javascript">
	
	$(document).on('change', '#shipping_date_slot', function(){
		var date_slot = $("input[name='shipping_date_slot']").val();
		//$("#current_slot").html(todays_slot + '<br/>' + 'Select Time');
		if(date_slot != ''){
			$.ajax({
				url: '<?php echo base_url();?>admin/quotation/delivery_slot_ajax',
				type: "POST",
				data: {'delv_date':date_slot},
				success: function (data){
					//alert(data);
					$("#shipping_time_slot").html(data);
				},
				error: function (xhr, ajaxOptions, thrownError){
					alert(JSON.stringify(xhr));
				}
			});
		}else{
			$('#shipping_time_slot').html('<option value="">Select time slot</option>');
		}
	});
</script>
