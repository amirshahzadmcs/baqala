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
	padding: 0.2rem 0.3rem;
}
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Purchase Order Return</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/pr/list');?>">Purchase Order Return</a></li>
						<li class="breadcrumb-item active">Purchase Return Form</li>
					</ol>
				</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-1" title="Back" href="<?php echo base_url('admin/pr/list');?>"><i class="fa fa-reply"></i> Back</a>
					<button form="pr-form" type="submit" class="btn btn-custom-success btn-sm pull-right me-1"><i class="fa fa-save"></i> Save</button>
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
					 	<form id="pr-form" method="post" action="<?php echo base_url('admin/pr/submit')?>" class="form-label-left" data-toggle="validator" role="form">
							<input type="hidden" id="po_id" name="po_id" value="<?php echo $order->id;?>" required="required">
							<input type="hidden" id="po_number" name="po_number" value="<?php echo $order->po_number;?>" required="required">
							<input type="hidden" id="vendor_id" name="vendor_id" value="<?php echo $order->vendor_id;?>" required="required">
							<table class="table" width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; line-height: 22px;">
								<tr>
									<td colspan="2"><img src="<?php echo base_url('admin_assets/images/purchase_return/header-top.jpg');?>" style="max-width: 100%;" /></td>
								</tr>
								<tr>
									<td align="left" valign="top" style="width: 40%;">
										<strong>SUPPLIER ADDRESS <br /> </strong><?php echo $order->vendor_name; ?><br/>
										Contact No. - <?php echo $order->b_contact; ?><br/>
										Address: <?php echo $order->b_building_no .','; ?> <?php echo $order->b_street_name .','; ?> <?php echo $order->b_district; ?><br />
										<?php echo $order->b_additional_no .','; ?> <?php echo $order->b_unit_no; ?><br/>
										<?php echo $order->b_city_name .','; ?> <?php echo $order->b_zip_code; ?>
									</td>
									<td valign="top" style="width: 60%; float: right;text-align: right;">
										GRV Number : <?php echo $order->grv_no; ?><br/>
										P.O Number : <?php echo $order->po_number; ?><br/>
										P.O Date : <?php echo date("d-m-Y", strtotime($order->po_date)); ?><br/>
										P.O Term: <?php echo $order->po_terms; ?><br />
										Contact: <?php echo $order->po_contact; ?><br />
										Supp Vat No.: <?php echo $order->vat_no; ?>
									</td>
								</tr>
								<tr>
									<td valign="top">
										<strong>BILLING ADDRESS</strong><br/>
										<?= $this->admin->getWarehouseDetail()->complete_address;?>
									</td>
								</tr>
								<tr>
									<td colspan="3"><p><strong style="color:red">Note:</strong> Please remove the product that is not returnable.</p></td>
								</tr>
								<tr>
									<td colspan="3" class="pb-0">
										<table class="table table-bordered mb-0" id="item_table" width="100%" border="1" cellspacing="0" cellpadding="5">
											<thead>
												<tr>
												<td valign="top" bgcolor="#CCCCCC" style="width: 5%;"><strong><i class="fa fa-plus"></i></strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 8%;"><strong>SKU</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 27%;"><strong>DESCRIPTION</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 8%;"><strong>RECV. QTY</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 7%;"><strong>SELLABLE QTY</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 7%;"><strong>RETURN QTY</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 11%;"><strong>UNIT PRICE<p class="m-0 text-muted">(Excluding VAT)</p></strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 9%;"><strong>TOTAL (SAR)<p class="m-0 text-muted">(Excl. VAT)</p></strong></td>
												</tr>
											</thead>
											<tbody>
												<?php $item_row = 1;foreach($products as $product){ ?>
												<tr id="item-row<?php echo $item_row;?>">
													<td valign="top"><button type="button" onclick="remove_item(<?php echo $item_row;?>)" data-toggle="tooltip" title="Remove" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></button></td>
													<td valign="top"><input type="text" name="item_sku[]" value="<?php echo $product->item_sku; ?>" class="form-control" readonly="readonly" required="required" /><input type="hidden" name="barcode[]" value="<?php echo $product->barcode; ?>" /><input type="hidden" name="seller_sku[]" value="<?php echo $product->seller_sku; ?>" /><input type="hidden" name="prod_id[]" value="<?php echo $product->prod_id; ?>" required /><input type="hidden" name="size_id[]" value="<?php echo $product->size_id; ?>" required /></td>
													<td valign="top"><input type="text" name="item_description[]" value="<?php echo $product->item_description; ?>" class="form-control" readonly="readonly" required="required" /><input type="hidden" name="item_desc_arabic[]" id="item-arabic-list" value="<?php echo $product->item_desc_arabic; ?>" /></td>
													<td valign="middle"><input type="number" min="1" max="<?php echo $product->received_qty; ?>" name="received_qty[]" value="<?php echo $product->received_qty; ?>" readonly="readonly" class="form-control" required="required" /></td>
													<td valign="middle"><input type="number" min="1" max="<?php echo $product->received_qty; ?>" name="sellable_qty[]" value="<?php echo $product->sellable_qty; ?>" readonly="readonly" class="form-control" required="required" /></td>
													<td valign="middle"><input type="number" min="1" max="<?php echo $product->sellable_qty; ?>" name="item_unit[]" value="" class="form-control item_unit" required="required" /></td>
													<td valign="top"><input type="text" min="0" max="100" readonly="readonly" name="unit_price[]" value="<?php echo $product->unit_price; ?>" class="form-control unit_price" required="required" /></td>
													<td valign="top"><input type="text" min="0" max="100" name="item_total[]" value="<?php echo $product->item_total; ?>" readonly="readonly" class="form-control item_total" /></td>
												</tr>
												<?php $item_row = $item_row + 1;}?>
											</tbody>
										</table>
									</td>
								</tr>
								<tr>
									<td colspan="3" class="pt-0">
										<table class="table" style="width: 100%; border-spacing: 0px;">
											<tbody>
												<tr>
													<td style="width: 62%;">
														<p>1. Please send two copies of your invoice.</p>
														<p>2. Enter this order in accordance with the prices, terms, delivery method, and specifications listed above.</p>
														<p>3. Please notify us immediately if you are unable to ship as specified.</p>
														<p>4. Send all correspondence to:</p>
														<p style="padding-left: 20px;">
														<?php if(!empty($order->attachment)){ ?>Attachment: <a href="<?php echo base_url($order->attachment);?>" target="_blank">view file</a><?php } ?>
														</p>
													</td>

													<td style="vertical-align: top; width: 30%;padding: 0;">
														<table class="table table-bordered" id="tab_logic_total" width="100%" cellspacing="0" cellpadding="5" style="border: 1px solid #ddd;border-top: 1px solid #fff;">
															<tr>
																<td valign="middle" style="text-align: left;">SUBTOTAL:</td>
																<td class="amount subtotal"><input type="text" name="sub_total" value="<?php echo $order->sub_total;?>" id="sub_total" readonly="readonly" class="form-control" /></td>
															</tr>
															<tr>
																<td valign="middle" style="text-align: left;">VAT %:</td>
																<td class="amount">
																	<div class="input-group mb-2 mb-sm-0">
																		<input type="number" class="form-control" name="sale_tax" id="sale_tax" value="<?php echo $order->sale_tax;?>" readonly="readonly" placeholder="0">
																	</div>
																</td>
															</tr>
															<tr>
																<td valign="middle" style="text-align: left;">VAT AMOUNT:</td>
																<td class="amount"><input type="text" id="sale_tax_amt" name="sale_tax_amt" value="<?php echo $order->sale_tax_amt;?>" class="form-control" readonly="readonly" /></td>
															</tr>
															<tr>
																<td valign="middle" style="text-align: left;">SHIPPING &amp; HANDLING:</td>
																<td class="amount"><input type="text" name="shipping_handling" id="shipping_handling" value="<?php echo $order->shipping_handling;?>" class="form-control" readonly="readonly" /></td>
															</tr>
															<tr>
																<td valign="middle" style="text-align: left; width: 67%;">TOTAL:</td>
																<td class="total-amount"><input type="text" name="total"  value="<?php echo $order->total;?>" id="total_amount" readonly="readonly" class="form-control total" /></td>
															</tr>
														</table>
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</table>
						</form> 
 					</div>
 				</div>
 			</div> <!-- end col -->
 		</div> <!-- end row -->
 	</div>
 </div>

<?php $this->load->view('admin/home/footer');?>

<script>
	var item_row = <?php echo $item_row;?>;

	function remove_item(u){
		$('#item-row'+u).remove();
		calc();
	}

	$(document).ready(function(){
		$('#item_table tbody').on('keyup change', function() {
			calc();
		});
		
		$('#sale_tax').on('keyup change', function() {
			calc_total();
		});
		
		$('#shipping_handling').on('keyup change', function() {
			calc_total();
		});
	});

	function calc() {
		$('#item_table tbody tr').each(function(item_row, element) {
			var html = $(this).html();
			if (html != '') {
				var qty = $(this).find('.item_unit').val();
				var price = $(this).find('.unit_price').val();
				$(this).find('.item_total').val(qty * price);
				calc_total();
			}
		});
	}

	function calc_total() {
		var total = 0;
		var ship_amt = 0;
		$('.item_total').each(function() {
			total += parseInt($(this).val());
		});
		$('#sub_total').val(total.toFixed(2));
		tax_sum = (total / 100) * $('#sale_tax').val();
		$('#sale_tax_amt').val(tax_sum.toFixed(2));
		ship_amt = parseFloat($('#shipping_handling').val());
		main_total = ship_amt + total;
		$('#total_amount').val((tax_sum + main_total).toFixed(2));
	}

</script>
