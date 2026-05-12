<?php $this->load->view('admin/home/header');?>
<style>
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    border-top: none;
}

table{
	color: #000;
}
.table-responsive{
	font-family: inherit
}
</style>
<div class="page-title">
	<div class="title_left">
		<h3>Sales Return Form</h3>
	</div>
	<div class="title_right">
		<a class="btn btn-sm btn-default pull-right"  data-toggle="tooltip" title="Back" href="<?php echo base_url();?>admin/sales_return"><i class="fa fa-reply"></i></a>
		<button form="updateForm" type="submit" class="btn btn-sm btn-info pull-right" data-toggle="tooltip" title="Save"><i class="fa fa-save"></i></button>
		<?php if($result['order']['order_status_id'] == '1'){ ?>
		<button type="button" class="btn btn-danger btn-sm pull-right" title="Convert to order" data-toggle="modal" data-target="#convertModal"><i class="fa fa-mail-forward"></i> Convert to Order</button>
		<?php } ?>
	</div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
			<!--
            <div class="x_title">
                <h5><i class="fa fa-pencil"></i> Sales Return Form</h5>
                <div class="clearfix"></div>
            </div>
			-->
            <div class="x_content">
				<div>
					<input type="hidden" id="id" name="id" value="<?php echo $result['order']['id'];?>">
					<table class="table" width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family: inherit; font-size: 14px; line-height: 22px;">
						
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
						<tr>
							<td valign="top">
							<strong>Shipping Address :<br /> </strong><?php echo $result['order']['shipping_firstname'];?><br/><?php echo $result['order']['villa_building'];?>, <?php echo $result['order']['shipping_complete_address'];?>
							</td>
							<td valign="top" style="width: 50%; float: right;">
							<strong>Payments:</strong> <?php echo $result['order']['payment_method']; ?><br />
							<strong>Order Date:</strong> <?php echo $result['order']['date_added']; ?><br/>
							<strong>Delivery Date:</strong> <?php echo $result['order']['shipping_date_slot']; ?><br/>
							<strong>Delivery Time:</strong> <?php echo $result['order']['shipping_time_slot'] ; ?><br/>
							
							</td>
						</tr>
					</table>
					<table class="table" id="tableOrder" width="100%" border="1" cellspacing="0" cellpadding="0" style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; line-height: 22px;margin-top:30px">
						<tr>
							<td colspan="12" align="center" style="padding: 10px 0px;">
								<b>Product Detail</b>
							</td>
						</tr>
						<tr>
							<td valign="top" bgcolor="#CCCCCC" style="width: 4%; text-align: center;"><strong>S. No</strong></td>
							<td valign="top" bgcolor="#CCCCCC" style="width: 12%; text-align: center;"><strong>Image</strong></td>
							<td valign="top" bgcolor="#CCCCCC" style="width: 8%; text-align: center;"><strong>Barcode</strong></td>
							<td valign="top" bgcolor="#CCCCCC" style="width: 26%; text-align: center;"><strong>Description</strong></td>
							<td valign="top" bgcolor="#CCCCCC" style="width: 6%; text-align: center;"><strong>Price</strong></td>
							<td valign="top" bgcolor="#CCCCCC" style="width: 4%; text-align: center;"><strong>Qty</strong></td>
							<td valign="top" bgcolor="#CCCCCC" style="width: 5%; text-align: center;"><strong>Value</strong></td>
							<td valign="top" bgcolor="#CCCCCC" style="width: 5%; text-align: center;"><strong>Net</strong></td>
							<td valign="top" bgcolor="#CCCCCC" style="width: 5%; text-align: center;"><strong>VAT</strong></td>
							<td valign="top" bgcolor="#CCCCCC" style="width: 5%; text-align: center;"><strong>VAT %</strong></td>
							<td valign="top" bgcolor="#CCCCCC" style="width: 7%; text-align: center;"><strong>Total</strong></td>
							<td valign="top" bgcolor="#CCCCCC" style="width: 7%; text-align: center;"><strong>Tools</strong></td>
						</tr>
						
						<?php echo form_open('admin/sales_return/return_order', array("id"=>"updateForm")); ?>
							<input type="hidden" name="order_id" value="<?php echo $result['order']['id'];?>" required />
							<input type="hidden" name="po_number" value="<?php echo $result['order']['po_number'];?>" required />
							<input type="hidden" name="po_date" value="<?php echo $result['order']['po_date'];?>" required />
							<input type="hidden" name="quotation_no" value="<?php echo $result['order']['quotation_no'];?>" required />
							<input type="hidden" name="payment_method" value="<?php echo $result['order']['payment_method'];?>" required />
							<input type="hidden" name="shipping_charge" value="<?php echo $result['order']['shipping_charge']; ?>" required />
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
								<input type="hidden" name="price[]" value="<?php echo $p_price;?>" required />
								<input type="hidden" name="product_name[]" value="<?php echo $product['product_name'];?>" required />
								<input type="hidden" name="short_name[]" value="<?php echo $product['short_name'];?>" />
								<input type="hidden" name="arabic_name[]" value="<?php echo $product['arabic_name'];?>" />
								<input type="hidden" name="gst_rate[]" value="<?php echo $product['gst_rate'];?>" required />
								<input type="hidden" name="product_slug[]" value="<?php echo $product['product_slug'];?>" required />
								<input type="hidden" name="size[]" value="<?php echo $product['size'];?>" required />
								<input type="hidden" name="discounted_price[]" value="<?php echo $product['discounted_price'];?>" />
								<input type="hidden" name="gift_value[]" value="<?php echo $product['gift_value'];?>" required />
								<input type="hidden" name="product_sku[]" value="<?php echo $product['product_sku'];?>" required />
								<input type="hidden" name="barcode[]" value="<?php echo $product['barcode'];?>" />
								<input type="hidden" name="product_image[]" value="<?php echo $product['product_image'];?>" />
								
								<td valign="top" style="text-align: center;"><?php echo $i++;?></td>
								<td valign="top" style="text-align: center;"><img src="<?php echo ($product['product_image'] == "" OR !file_exists($product['product_image'])) ? base_url('images/notfound.jpg'):base_url($product['product_image']);?>" width="80px"></td>
								<td valign="top" style="text-align: center;"><?php echo $product['barcode'];?></td>
								<td valign="top">
								<?php echo $product['product_name']; ?><br />
								<span style="display: block; text-align: right;"><?php echo $product['arabic_name']; ?> </span>
								</td>
								<td valign="top" style="text-align: right;"><?php echo sprintf("%.2f",$p_price); ?></td>
								<td valign="top" style="text-align: center;"><input type="number" name="quantity[]" value="<?php echo $product['quantity'];?>" min="1" max="<?php echo $product['quantity'];?>" required style="width: 55px;margin-top: 7px;"/></td>
								<td valign="top" style="text-align: right;"><?php echo  sprintf("%.2f", $product['order_price']); ?></td>
								<td valign="top" style="text-align: right;"><?php echo sprintf("%.2f", $initial_price); ?></td>
								<td valign="top" style="text-align: center;"><?php echo sprintf("%.2f", $product['vat_price']); ?></td>
								<td valign="top" style="text-align: center;"><?php echo $product['gst_rate'] .'%'; ?></td>
								<td valign="top" style="text-align: right;"><?php echo sprintf("%.2f", $product['order_price']).' SAR'; ?></td>
								<td valign="top" style="text-align: right;padding-top:10px;"><button class="btn btn-danger btn-sm btnDelete"><i class="fa fa-remove"></i></td>
							</tr>
							<?php } ?>
						<?php echo form_close();?>
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
										<td style="font-size: 12px; font-weight: 500;">المبلغ شامل الضريبة / Total Amount:<b> <?php $net_amt = $result['order']['order_total']; echo sprintf("%.2f",$net_amt);?> SAR</b></td>
									</tr>
									<tr>
										<?php if($result['order']['net_payble_amt'] > 0){ ?>
										<td colspan="2" style="font-size: 12px; font-weight: 500;">
											Net Payable Amount: 
											 <strong><?php $net_payble_amt = $result['order']['net_payble_amt'] + $result['order']['shipping_charge']; echo sprintf("%.2f",$net_payble_amt);?> SAR</strong>
										</td>
										<?php } ?>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/home/footer');?>

<script type="text/javascript">
	$('#searchForm').on('submit', (function(e) {
		e.preventDefault();
		$.ajax({
			url: '<?php echo base_url();?>admin/quotation/get_product_ajax?oid=<?php echo $this->input->get("id");?>',
			type: "POST",
			data:  new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			success: function(data){
				//alert(JSON.stringify(data));
				$('#searchResult').html(data);
			},
			error: function(data){
				alert('Someting went wrong, try again or contact to administrator.');
			}
		});
	}));

	$(document).ready(function(){
		$("#tableOrder").on('click','.btnDelete',function(){
		   var x = confirm("Are you sure you want to remove this product from order?");
			if (x){
				$(this).closest('tr').remove();
			}else{
				return false;
			}
	    });
	});
	
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
