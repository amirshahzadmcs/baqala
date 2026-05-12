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
.searchResults{
	list-style: none;
    position: absolute;
	left: 33px;
    width: 94%;
    cursor: pointer;
    overflow-y: auto;
    max-height: 420px;
    box-sizing: border-box;
    z-index: 99;
    padding: 12px;
    background-color: #fff;
    box-shadow: 1px 2px 5px #484848;
}
.searchResults .item-list{
	padding: 10px 0px;
    border-bottom: 1px solid #ddd;
}
.searchResults .item-name{
	line-height: 21px !important;
}
.searchResults button{
	float: right;
    margin-top: -20px;
}
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Good Received Voucher</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item active">Good Received Voucher</li>
					</ol>
				</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-1" title="Back" href="<?php echo base_url('admin/grv/list');?>"><i class="fa fa-reply"></i> Back</a>
					<button form="grv-form2" type="submit" class="btn btn-custom-success btn-sm pull-right me-1"><i class="fa fa-save"></i> Save</button>
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
					 	<form id="grv-form2" method="post" action="<?php echo base_url('admin/grv/submit')?>" class="form-label-left" data-toggle="validator" role="form">
							<input type="hidden" id="id" name="id" value="<?php echo $grv->id;?>" required="required">
							<input type="hidden" id="po_id" name="po_id" value="<?php echo $order->id;?>" required="required">
							<input type="hidden" id="vendor_id" name="vendor_id" value="<?php echo $order->vendor_id;?>" required="required">
							<table class="table" width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; line-height: 22px;">
								<tr>
									<td colspan="2"><img src="<?php echo base_url('admin_assets/images/purchase_order/grv-header.jpg');?>" style="width:100%;max-width: 100%;" /></td>
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
										GRV Number : <?php echo $grv->invoice_prefix .'-'. $grv->grv_no; ?><br/>
										P.O Number : <?php echo $grv->po_no; ?><br/>
										GRV Date : <?php echo date("d-m-Y", strtotime($grv->created_at)); ?><br/>
										GRV Value: <?php echo $grv->grv_value .' SAR'; ?><br />
										GRV Status: <?php echo ($grv->grv_status == 'open') ? '<span class="label label-primary">Open</span>' : (($grv->grv_status == 'closed') ? '<span class="label label-success bg-success">Closed</span>' : (($grv->grv_status == 'rejected') ? '<span class="label label-danger">Rejected</span>' : '<span class="label label-warning">NULL</span>')); ?>
									</td>
								</tr>
								<tr>
									<td valign="top">
										<strong>BILLING ADDRESS</strong><br/>
										<?= $this->admin->getWarehouseDetail()->complete_address;?>
									</td>
								</tr>
							
								<tr>
									<td colspan="3" class="pb-0">
										<table class="table table-bordered mb-0" id="item_table" width="100%" border="1" cellspacing="0" cellpadding="5">
											<thead>
												<tr>
													<td valign="top" bgcolor="#CCCCCC" style="width: 8%;"><strong>SKU</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 27%;"><strong>DESCRIPTION</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 7%;"><strong>EXPTD. QTY</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 11%;"><strong>UNIT PRICE<p class="m-0 text-muted">(Excluding VAT)</p></strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 9%;"><strong>TOTAL (SAR)<p class="m-0 text-muted">(Excl. VAT)</p></strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 8%;"><strong>RECV. QTY</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 7%;"><strong>SELLABLE QTY</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 7%;"><strong>UNSELLABLE QTY</strong></td>
												</tr>
											</thead>
											<tbody>
												<?php $item_row = 1;foreach($products as $product){ ?>
												<tr id="item-row<?php echo $item_row;?>">
													<input type="hidden" id="item_id" name="item_id[]" value="<?php echo $product->id;?>" required="required">
													<td valign="middle"><?php echo $product->item_sku; ?></td>
													<td valign="middle"><?php echo $product->item_description; ?></td>
													<td valign="middle" style="text-align: center;"><?php echo $product->item_unit; ?></td>
													<td valign="middle" style="text-align: right;"><?php echo $product->unit_price; ?></td>
													<td valign="middle" style="text-align: right;"><?php echo $product->item_total; ?></td>
													<td valign="middle"><input type="number" min="0" max="<?php echo $product->item_unit; ?>" name="received_qty[]" value="<?php echo $product->received_qty; ?>" class="form-control received_qty" required="required" /></td>
													<td valign="middle"><input type="number" min="0" max="<?php echo $product->item_unit; ?>" name="sellable_qty[]" value="<?php echo $product->sellable_qty; ?>" class="form-control sellable_qty" required="required" /></td>
													<td valign="middle"><input type="number" min="0" max="<?php echo $product->item_unit; ?>" name="unsellable_qty[]" value="<?php echo $product->unsellable_qty; ?>" class="form-control unsellable_qty" required="required" /></td>
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
													<td style="width: 63%;">
														<p>1. Please send two copies of your invoice.</p>
														<p>2. Enter this order in accordance with the prices, terms, delivery method, and specifications listed above.</p>
														<p>3. Please notify us immediately if you are unable to ship as specified.</p>
														<p>4. Send all correspondence to:</p>
														<p style="padding-left: 20px;">
														<?php if(!empty($order->attachment)){ ?>Attachment: <a href="<?php echo base_url($order->attachment);?>" target="_blank">view file</a><?php } ?>
														</p>
													</td>

													<td style="vertical-align: top; width: 27%;padding: 0;">
														<table class="table table-bordered" id="tab_logic_total" width="100%" cellspacing="0" cellpadding="5" style="border: 1px solid #ddd;border-top: 1px solid #fff;">
															<tr>
																<td style="text-align: left;">SUBTOTAL:</td>
																<td class="amount subtotal"><?php echo $order->sub_total;?></td>
															</tr>
															<tr>
																<td style="text-align: left;">VAT %:</td>
																<td class="amount">
																	<?php echo $order->sale_tax;?>%
																</td>
															</tr>
															<tr>
																<td style="text-align: left;">VAT AMOUNT:</td>
																<td class="amount"><?php echo $order->sale_tax_amt;?></td>
															</tr>
															<tr>
																<td style="text-align: left;">SHIPPING &amp; HANDLING:</td>
																<td class="amount"><?php echo $order->shipping_handling;?></td>
															</tr>
															<tr>
																<td style="text-align: left; width: 68%;">TOTAL:</td>
																<td class="total-amount"><?php echo $order->total;?></td>
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
	
	$(document).ready(function(){
		$('#item_table tbody .received_qty').on('keyup change', function() {
			calc();
		});

		$('#item_table tbody .sellable_qty').on('keyup change', function() {
			calc();
		});
	});
	
	function calc() {
		$('#item_table tbody tr').each(function(item_row, element) {
			var html = $(this).html();
			if (html != '') {
				var recv_qty = $(this).find('.received_qty').val();
				var sell_qty = $(this).find('.sellable_qty').val();
				$(this).find('.unsellable_qty').val(recv_qty - sell_qty);
			}
		});
	}
</script>
