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
	padding: 0.35rem 0.35rem;
}

</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Purchase Return Details</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/pr/list');?>">Purchase Order Return</a></li>
						<li class="breadcrumb-item active">Purchase Return Details</li>
					</ol>
				</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-1" title="Back" href="<?php echo base_url('admin/pr/list');?>"><i class="fa fa-reply"></i> Back</a>
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
						<table class="table" width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; line-height: 22px;margin-bottom: 0;">
							<tr>
								<td colspan="2"><img src="<?php echo base_url('admin_assets/images/purchase_return/header-top.jpg');?>" style="max-width: 100%;" /></td>
							</tr>

							<tr>
								<td align="left" valign="top" style="width: 40%;">
									<strong>CUSTOMER INFORMATION</strong><br/>
									Company Name: Baqala Station<br />
									Contact No: 057 058 0603<br/>
									Address: 8411 Istanbul Street Sulay,<br>Riyadh 14322<br />
									Kingdom of Saudi Arabia
								</td>
								<td valign="top" style="width: 60%; float: right;text-align: right;">
									<strong>Purchase Return Voucher No. :</strong> <?php echo 'PR-'.$order->id; ?><br/>
									<strong>Purchase Return Date :</strong> <?php echo date("d-m-Y", strtotime($order->po_date)); ?><br/>
									<strong>Goods Received Voucher No. :</strong> <?php echo $order->grv_no; ?><br/>
									<strong>Purchase Order Number :</strong> <?php echo 'PO-'.$order->po_id; ?><br/>
									<strong>Contact No:</strong> <?php echo $order->po_contact; ?><br />
									<strong>Supp Vat No.:</strong> <?php echo $order->vat_no; ?>
								</td>
							</tr>
							<tr>
								<td valign="top">
									<strong>BILLING ADDRESS <br /> </strong><?php echo $order->vendor_name; ?><br/>
									Contact No. - <?php echo $order->b_contact; ?><br/>
									Address: <?php echo $order->b_building_no .','; ?> <?php echo $order->b_street_name .','; ?> <?php echo $order->b_district; ?><br />
									<?php echo $order->b_additional_no .','; ?> <?php echo $order->b_unit_no; ?><br/>
									<?php echo $order->b_city_name .','; ?> <?php echo $order->b_zip_code; ?>
								</td>
								<td valign="top" style="width: 60%; float: right;text-align: right;">
									<strong>DELIVER TO <br /> </strong><?php echo $order->delivery_name; ?><br/>
									Contact No. - <?php echo $order->d_contact; ?><br/>
									<?php echo $order->d_building_no .','; ?> <?php echo $order->d_street_name .','; ?> <?php echo $order->d_district; ?><br />
									<?php echo $order->d_additional_no .','; ?> <?php echo $order->d_unit_no; ?><br/>
									<?php echo $order->d_city_name .','; ?> <?php echo $order->d_zip_code; ?>
								</td>
							</tr>
							
							<tr>
								<td colspan="3" class="pb-0">
									<table class="table table-bordered mb-0" width="100%" border="1" cellspacing="0" cellpadding="0" style="border: 1px solid #878787;">
										<tr style="background-color: #eee;">
											<td valign="top" bgcolor="#CCCCCC" style="width: 5%;"><strong>S. No.</strong></td>
											<td valign="top" bgcolor="#CCCCCC" style="width: 9.5%;"><strong>CHILD SKU</strong></td>
											<td valign="top" bgcolor="#CCCCCC" style="width: 10%;"><strong>SUPPLIER SKU</strong></td>
											<td valign="top" bgcolor="#CCCCCC" style="width: 13%;"><strong>BARCODE</strong></td>
											<td valign="top" bgcolor="#CCCCCC" style="width: 22%;"><strong>PRODUCT NAME/ DESCRIPTION</strong></td>
											<td valign="top" bgcolor="#CCCCCC" style="width: 5%;"><strong>QTY</strong></td>
											<td valign="top" bgcolor="#CCCCCC" style="width: 9%;"><strong>UNIT PRICE</strong></td>
											<td valign="top" bgcolor="#CCCCCC" style="width: 9%;"><strong>AMT. EXCL. VAT</strong></td>
											<td valign="top" bgcolor="#CCCCCC" style="width: 8.5%;text-align:right"><strong>VAT AMT.</strong></td>
											<td valign="top" bgcolor="#CCCCCC" style="width: 9%;text-align:right"><strong>AMT. INC. VAT</strong></td>
										</tr>
										<?php $item_row = 1;foreach($products as $product){ ?>
										<tr>
											<td valign="top" style="text-align: center;"><?php echo $item_row;?></td>
											<td valign="top"><?php echo strtoupper($product->item_sku);?></td>
											<td valign="top"><?php echo strtoupper($product->seller_sku);?></td>
											<td valign="top"><?php echo $product->barcode;?></td>
											<td valign="top">
												<?php echo $product->item_description; ?>
											</td>
											<td valign="top" style="text-align: center;"><?php echo $product->item_unit;?></td>
											<td valign="top" style="text-align: right;"><?php echo $product->unit_price;?></td>
											<td valign="top" style="text-align: right;"><?php echo $product->item_total;?></td>
											<td valign="top" align="right"><?php echo $product->vat_price;?></td>
											<td valign="top" align="right"><?php echo $product->amt_incl_vat;?></td>
										</tr>
										<?php $item_row = $item_row + 1;}?>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="3" class="pt-0">
									<table style="width: 100%; border-spacing: 0px;">
										<tbody>
											<tr>
												<td style="width: 50.8%;" cellspacing="0" cellpadding="5">
													<p>1. Please send two copies of your invoice.</p>
													<p>2. Enter this order in accordance with the prices, terms, delivery method, and specifications listed above.</p>
													<p>3. Please notify us immediately if you are unable to ship as specified.</p>
													<p>4. Send all correspondence to:</p>
													<p style="padding-left: 20px;">
													<?php if(!empty($order->attachment)){ ?>Attachment: <a href="<?php echo base_url($order->attachment);?>" target="_blank">view file</a><?php } ?>
													</p>
												</td>

												<td style="vertical-align: top; width: 28.2%;">
													<table class="table" width="100%" cellspacing="0" cellpadding="0" style="border: 1px solid gray; border-top: 0px;">
														<tr>
															<td style="text-align: left; border-bottom: 1px solid gray; border-right: 1px solid gray; width: 75%;">SUBTOTAL</td>
															<td style="border-bottom: 1px solid gray;text-align:right" class="amount subtotal"><?php echo $order->sub_total;?></td>
														</tr>
														<tr>
															<td style="text-align: left; border-bottom: 1px solid gray; border-right: 1px solid gray; width: 75%;">VAT %</td>
															<td style="border-bottom: 1px solid gray;text-align:right" class="amount"><?php echo $order->sale_tax;?></td>
														</tr>
														<tr>
															<td style="text-align: left; border-bottom: 1px solid gray; border-right: 1px solid gray; width: 75%;">VAT AMOUNT</td>
															<td style="border-bottom: 1px solid gray;text-align:right" class="amount"><?php echo $order->sale_tax_amt;?></td>
														</tr>
														<tr>
															<td style="text-align: left; border-bottom: 1px solid gray; border-right: 1px solid gray; width: 75%;">SHIPPING &amp; HANDLING</td>
															<td style="border-bottom: 1px solid gray;text-align:right" class="amount"><?php echo $order->shipping_handling;?></td>
														</tr>
														<tr>
															<td style="text-align: left; width: 75%; border-right: 1px solid gray;">TOTAL</td>
															<td class="total amount" align="right"><?php echo $order->total;?></td>
														</tr>
													</table>
												</td>
											</tr>
										</tbody>
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

<?php $this->load->view('admin/home/footer');?>
