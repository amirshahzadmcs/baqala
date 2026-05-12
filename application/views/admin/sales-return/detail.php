<?php $this->load->view('admin/home/header');?>
<style>
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    border-top: 1px solid #4a4a4a;
}
</style>
<div class="page-title">
	<div class="title_left">
		<h3>Sales Return</h3>
	</div>
	<div class="title_right">
		<a class="btn btn-sm btn-default pull-right"  data-toggle="tooltip" title="Back" href="<?php echo base_url();?>admin/sales_return"><i class="fa fa-reply"></i></a>
		
		<div>
			<?php if($this->admin->getInfo()){ 
			$info = explode("--", $this->admin->getInfo());
			$info_type = $info[0];
			$msg_data = $info[1];
			if($info_type == 2){
			?>  
			<div class="alert alert-danger" style="width: 75%;">
				<button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>
				<?php echo $msg_data; ?> 
			</div> 
			<?php } else{?>
			<div class="alert alert-info" style="width: 75%;">
				<button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>
				<?php echo $msg_data; ?> 
			</div>
			<?php } $this->admin->removeInfo(); } ?>
		</div>
	</div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
			<!--
            <div class="x_title">
                <h5><i class="fa fa-pencil"></i> Purchase Order</h5>
                <div class="clearfix"></div>
            </div>-->
            <div class="x_content">
				<table border="0" cellspacing="0" cellpadding="10" style="font-size: 13px; line-height: 22px;width: 100%;color:#000">
					<tr>
						<td colspan="2"><img src="<?php echo base_url('build/images/sales_return/header-top.jpg');?>" style="max-width: 100%;" /></td>
					</tr>

					<tr>
						<td align="left" valign="top" style="width: 50%;">
							<strong>Customer Name:</strong> <?php echo $result['order']['name'];?><br />
							<?php if(!empty($result['order']['c_company'])) { ?>
							<strong>Company Name:</strong> <?php echo $result['order']['c_company'];?><br />
							<?php } ?>
								<?php if($result['order']['c_role'] == 2){ echo '<strong>Customer VAT:</strong> ' . $result['order']['c_vat'];  ?><br/><?php } ?>
							<strong>Mobile Number:</strong> <?php echo $result['order']['mobile'];?>
					
						</td>
						<td valign="top" style="width: 50%; float: right;">
							<?php if(!empty($result['order']['payment_code'])){?>
							<strong>TransRef ID :</strong> <?php echo $result['order']['payment_code']; ?><br/>
							<?php } ?>
							<strong>Invoice Number :</strong> #<?php echo $result['order']['invoice_prefix'] .'-'. $result['order']['id'];?><br/>
							<strong>Invoice Date :</strong> <?php echo date('Y-m-d H:i:s'); ?>
						</td>
					</tr>
					<tr><td><br/></td></tr>
					<tr>
						<td valign="top">
							<strong>Shipping Address :<br /> </strong>
							<?php echo $result['order']['name'];?><br/>
							<?php echo $result['order']['building_no'];?> <?php echo $result['order']['street_name'];?> - <?php echo $result['order']['district_name'];?><br/>
							Unit No <?php echo $result['order']['unit_no'];?><br/>
							<?php echo $result['order']['city_name'];?> <?php echo $result['order']['zip_code'];?> - <?php echo $result['order']['additional_no'];?><br/>
							<?php echo $result['order']['country'];?>
						</td>
						<td valign="top" style="width: 50%; float: right;">
						<strong>Payments:</strong> <?php echo $result['order']['payment_method']; ?><br />
						<strong>Order Date:</strong> <?php echo $result['order']['date_added']; ?><br/>
						<strong>Delivery Date:</strong> <?php echo $result['order']['shipping_date_slot']; ?><br/>
						<strong>Delivery Time:</strong> <?php echo $result['order']['shipping_time_slot'] ; ?><br/>
						
						</td>
					</tr>
					<tr><td><br/></td></tr>
					<tr>
						<td colspan="2">
							<table class="table" width="100%" border="1" cellspacing="5" cellpadding="5">
								<tr>
									<td colspan="11" align="center">
										<b>Product Detail</b>
									</td>
								</tr>
								<tr>
									<td valign="top" bgcolor="#CCCCCC" style="width: 4%; text-align: center;"><strong>S. No</strong></td>
									<td valign="top" bgcolor="#CCCCCC" style="width: 10%; text-align: center;"><strong>Image</strong></td>
									<td valign="top" bgcolor="#CCCCCC" style="width: 8%; text-align: center;"><strong>Barcode</strong></td>
									<td valign="top" bgcolor="#CCCCCC" style="width: 26%; text-align: center;"><strong>Description</strong></td>
									<td valign="top" bgcolor="#CCCCCC" style="width: 6%; text-align: center;"><strong>Price</strong></td>
									<td valign="top" bgcolor="#CCCCCC" style="width: 4%; text-align: center;"><strong>Qty</strong></td>
									<td valign="top" bgcolor="#CCCCCC" style="width: 7%; text-align: center;"><strong>P/Before VAT</strong></td>
									<td valign="top" bgcolor="#CCCCCC" style="width: 5%; text-align: center;"><strong>Value</strong></td>
									<td valign="top" bgcolor="#CCCCCC" style="width: 5%; text-align: center;"><strong>VAT</strong></td>
									<td valign="top" bgcolor="#CCCCCC" style="width: 5%; text-align: center;"><strong>VAT %</strong></td>
									<td valign="top" bgcolor="#CCCCCC" style="width: 7%; text-align: center;"><strong>Total</strong></td>
								</tr>
								<?php 
									$total_qty =0;$i = 1;$amt_exl_vat = 0;$amt_incl_vat = 0;$total_vat = 0;$saving = 0;$ptotal = 0;
									foreach($result['products'] as $product){
									//$p_price = $product['real_price']; 
									$p_price = ($product['discounted_price'] == '0') ? $product['real_price'] : $product['discounted_price'];
									//$vat_initial = ($product['gst_rate'] / 100) * $p_price;
									$initial_price = $product['order_price'] - $product['vat_price'];
									$total_qty += $product['quantity'];
									$total_vat += $product['vat_price'];
									//$mrp += $product['real_price'] * $product['quantity'];
									$amt_exl_vat += $product['order_price'] - $product['vat_price'];
									$amt_incl_vat += $product['order_price'];
								?>
								<tr>
									<td valign="top" style="text-align: center;"><?php echo $i++;?></td>
									<td valign="top" style="text-align: center;"><img src="<?php echo ($product['product_image'] == "" OR !file_exists($product['product_image'])) ? base_url().'images/notfound.jpg':base_url().$product['product_image'];?>" width="80px"></td>
									<td valign="top" style="text-align: center;"><?php echo $product['barcode'];?></td>
									<td valign="top">
									<?php echo $product['product_name']; ?><br />
									<span style="display: block; text-align: right;"><?php echo $product['arabic_name']; ?> </span>
									</td>
									<td valign="top" style="text-align: right;"><?php echo sprintf("%.2f",$p_price); ?></td>
									<td valign="top" style="text-align: center;"><?php echo $product['quantity'];?></td>
									<td valign="top" style="text-align: right;"><?php echo sprintf("%.2f", $initial_price); ?></td>
									<td valign="top" style="text-align: right;"><?php echo  sprintf("%.2f", $product['order_price']); ?></td>
									<td valign="top" style="text-align: center;"><?php echo sprintf("%.2f", $product['vat_price']); ?></td>
									<td valign="top" style="text-align: center;"><?php echo $product['gst_rate'] .'%'; ?></td>
									<td valign="top" style="text-align: right;"><?php echo sprintf("%.2f", $product['order_price']).' SAR'; ?></td>
								</tr>
								<?php } ?>
								<tr>
									<td colspan="10">
										<table style="width: 100%; margin-top: 0px; padding: 5px; border-top: none;">
											<tr>
												<td style="font-size: 12px; font-weight: 500;">أجمالي الأصناف / Total Items : <?php echo count($result['products']); ?></td>
												<td style="font-size: 12px; font-weight: 500;">الإجمالي بدون الضريبة / Total Excluding VAT : <?php echo sprintf("%.2f",$amt_exl_vat); ?> SAR</td>
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
												<td style="font-size: 12px; font-weight: 500;">المبلغ شامل الضريبة / Total Amount:<b> <?php $net_amt = $result['order']['order_total']; echo sprintf("%.2f",$net_amt);?> SAR</b></td>
											</tr>
										</table>
									</td>
									<td colspan="3">
										<?php $qrimg = 'uploads/qrcodes/'.$result['order']['trans_id'].'-Qrcode.png';echo"<center><img src=". base_url($qrimg) ." width='75px'></center"; ?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr><td><br/></td></tr>
				</table>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/home/footer');?>

