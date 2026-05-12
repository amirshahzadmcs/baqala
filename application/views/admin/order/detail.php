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
.dropdown-divider {
    margin: 0rem 0;
}

/*---- Timeline ----*/
.history-tl-container {
    margin: auto;
    display: block;
    position: relative;
}
.history-tl-container ul.tl {
    margin: 20px 0;
    padding: 0;
    display: inline-block;
}
.history-tl-container ul.tl li {
    list-style: none;
    margin: auto;
    margin-left: 150px;
    min-height: 50px;
    /*background: rgba(255,255,0,0.1);*/
    border-left: 1px dashed #86d6ff;
    padding: 0 0 50px 30px;
    position: relative;
}
.history-tl-container ul.tl li:last-child {
    border-left: 0;
}
.history-tl-container ul.tl li:last-child::before {
	animation: pulseshodow 2s infinite;
    border-radius: 99px!important;
    background-size: 100% 100%;
    background-image: linear-gradient(to top,#03a9f4 50%,transparent 50%);
    -webkit-transition: background-position 300ms,color 300ms ease,border-color 300ms ease!important;
    -webkit-transition: background-position 300ms,color 300ms ease,border-color 300ms ease!important;
    -ms-transition: background-position 300ms,color 300ms ease,border-color 300ms ease!important;
    -o-transition: background-position 300ms,color 300ms ease,border-color 300ms ease!important;
    transition: background-position 300ms,color 300ms ease,border-color 300ms ease!important;
}
@-webkit-keyframes pulseshodow{0%{-webkit-box-shadow:0 0 0 0 rgb(64 196 255)}70%{-webkit-box-shadow:0 0 0 20px rgba(204,169,44,0)}100%{-webkit-box-shadow:0 0 0 0 rgba(204,169,44,0)}}@keyframes pulseshodow{0%{-moz-box-shadow:0 0 0 0 rgb(3,169,244);box-shadow:0 0 0 0 rgb(3,169,244)}70%{-moz-box-shadow:0 0 0 20px rgba(204,169,44,0);box-shadow:0 0 0 20px rgba(204,169,44,0)}100%{-moz-box-shadow:0 0 0 0 rgba(204,169,44,0);box-shadow:0 0 0 0 rgba(204,169,44,0)}}

.history-tl-container ul.tl li::before {
    position: absolute;
    left: -10px;
    top: -5px;
    content: " ";
    border: 8px solid rgba(255, 255, 255, 0.74);
    border-radius: 500%;
    background: #258cc7;
    height: 20px;
    width: 20px;
    transition: all 500ms ease-in-out;
}
.history-tl-container ul.tl li:hover::before {
    border-color: #258cc7;
    transition: all 1000ms ease-in-out;
}

ul.tl li .item-detail {
    color: #000;
    font-size: 12px;
}
ul.tl li .timestamp {
    color: #8d8d8d;
    position: absolute;
    width: 100px;
    left: -125px;
    text-align: right;
    font-size: 12px;
}
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Order Detail</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/order/list');?>">Order</a></li>
						<li class="breadcrumb-item active">Detail</li>
					</ol>
				</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					
					<div class="btn-group me-1">
						<button class="btn btn-custom-success btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Print Options <i class="mdi mdi-chevron-down"></i>
						</button>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="<?php echo base_url('admin/order/print-delivery-note?id='. $this->input->get('id'));?>" target="_blank">Delivery Note</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo base_url('admin/order/print-label?id='. $this->input->get('id'))?>" target="_blank">Label</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo base_url('admin/order/print-retailer-invoice?id='. $this->input->get('id'))?>" target="_blank">Retail Invoice</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo base_url('admin/order/print-invoice?id='. $this->input->get('id'))?>" target="_blank">Corporate Invoice</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo base_url('admin/order/print-invoice-wt?id='. $this->input->get('id'))?>" target="_blank">Corporate Invoice Without Tax</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo base_url('admin/order/print-arabic-invoice?id='. $this->input->get('id'))?>" target="_blank">Corporate Arabic Invoice</a>
						</div>
					</div>
                    
					<div class="btn-group me-1">
						<button class="btn btn-custom-danger btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Send Mail <i class="mdi mdi-chevron-down"></i>
						</button>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="<?php echo base_url('admin/mail-invoice/invoice?lang=en&id='. $this->input->get('id'));?>">Send Corporate Invoice</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo base_url('admin/mail-invoice/invoice?lang=ar&id='. $this->input->get('id'));?>">Send Corporate Arabic Invoice</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo base_url('admin/mail-invoice/delivery-note?id='. $this->input->get('id'));?>">Send Delivery Note</a>
						</div>
					</div>

					<a class="btn btn-sm btn-custom-white pull-right me-1" title="Back" href="<?php echo base_url('admin/order/list');?>"><i class="fa fa-reply"></i> Back</a>
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
								<td colspan="2" style="border-bottom: 2px solid #d7af00;"><img src="<?php echo base_url('admin_assets/images/invoice/corporate/header-top.jpg');?>" style="width: 100%;max-width: 100%;" /></td>
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
								<td valign="top" style="width: 60%; float: right;text-align: right;">
									<?php if(!empty($result['order']['payment_code'])){?>
									<strong>TransRef ID :</strong> <?php echo $result['order']['payment_code']; ?><br/>
									<?php } ?>
									<strong>Invoice Number :</strong> <?php echo $result['order']['invoice_prefix'] .'-'. $result['order']['order_no'];?><br/>
									<strong>Invoice Date :</strong> <?php echo date('d-m-Y H:i:s'); ?><br>
									<strong>Created By :</strong> <?php echo ($result['order']['associate_id'] > 0) ? $result['order']['associate_name'].' / Admin' : '@'.$result['order']['staff_username'] .' / '. $result['order']['staff_display_name'];?>
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
									<?php echo $result['order']['shipping_person_name'] .' ('. $result['order']['c_company'] .')';?><br/>
									<?php echo $result['order']['shipping_mobile'];?><br/>
									<?php echo $result['order']['shipping_email'];?><br/>
									<?php echo $result['order']['villa_building'];?>-<?php echo $result['order']['shipping_house_no'];?>, <?php echo $result['order']['shipping_street'];?><br/>
									<?php echo $result['order']['shipping_city'];?> <?php echo $result['order']['shipping_postcode'];?><br/>
									<?php echo $result['order']['shipping_country'];?>
								</td>
							</tr>
							<button class="btn btn-outline-success position-absolute" onclick="checkStatus()" style="right: 20px;">Check Status</button>
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
													<tr>
														<td colspan="2" align="right"><img src="<?php $bcode = $result['order']['invoice_prefix'] . $result['order']['order_no']; echo generate_barcode($bcode)['barcode'];?>"></td>
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
		<div class="row">
 			 <div class="col-12">
 				<div class="card">
 					<div class="card-body" id="trackStatus">
						<h5>Track Order</h5><hr>
						<div class="row">
							<div class="col-md-6">
								<div class="history-tl-container">
									<ul class="tl">

										<li class="tl-item">
											<div class="timestamp">
												<?= date("d M Y", strtotime($result['order']['date_added']));?><br />
												<?= date("h:i A", strtotime($result['order']['date_added']));?>
											</div>
											<div class="item-title">Placed</div>
											<div class="item-detail">Order Placed</div>
										</li>
										<?php foreach($result['logs'] as $log){ ?>
										<li class="tl-item">
											<div class="timestamp">
												<?= date("d M Y", strtotime($log['created_at']));?><br />
												<?= date("h:i A", strtotime($log['created_at']));?>
											</div>
											<div class="item-title"><?= $log['status_type'];?></div>
											<div class="item-detail"><?= $log['description'];?></div>
										</li>
										<?php } ?>
									</ul>
								</div>

							</div>
							<div class="col-md-6">
								<h6>Picker Information</h6>
								<ul class="ps-0">
									<li class="d-block">Name: </li>
									<li class="d-block">Mobile: </li>
									<li class="d-block">Email ID: </li>
								</ul><br>
								<h6>Rider Information</h6>
								<ul class="ps-0">
									<li class="d-block">Name: <?= $result['order']['db_name'];?></li>
									<li class="d-block">Mobile: <?= $result['order']['db_mob'];?></li>
									<li class="d-block">Email ID: <?= $result['order']['db_email'];?></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
 	</div>
 </div>

<?php $this->load->view('admin/home/footer');?>

<script>
	function checkStatus(){
		$('html, body').animate({
			scrollTop: eval($('#trackStatus').offset().top - 80)
		}, 500, 'linear');
	}
</script>