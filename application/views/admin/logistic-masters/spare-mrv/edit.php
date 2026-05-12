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
#item_table tbody td {
    padding: 0.75rem 0.3rem !important;
}
#item_table tbody td .form-control{
	padding: 0.47rem 0.5rem;
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
	float: left;
    margin-top: 7px;
	margin-right: 20px;
}
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>SP MRV MASTER</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/spare-parts/mrv/list');?>">SP MRV Master</a></li>
						<li class="breadcrumb-item active">Edit</li>
					</ol>
				</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-1" title="Back" href="<?php echo base_url('admin/spare-parts/mrv/list');?>"><i class="fa fa-reply"></i> Back</a>
					<button form="demo-form2" type="submit" class="btn btn-custom-success btn-sm pull-right me-1"><i class="fa fa-save"></i> Save</button>
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
					 	<form id="demo-form2" method="post" action="<?php echo base_url('admin/spare-parts/mrv/update')?>" class="form-label-left" data-toggle="validator" role="form">
							<input type="hidden" id="mrv_id" name="mrv_id" value="<?php echo $order->id;?>" required="required">
							<table class="table" width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td colspan="2" style="border-bottom: 2px solid #f4c53a;">
										<img src="<?php echo base_url('admin_assets/images/header-top.png');?>" style="width:100%;max-width: 100%;" />
									</td>
								</tr>
								<tr>
									<td align="left" valign="top" style="width: 40%;">
										<strong>SUPPLIER ADDRESS <br /> </strong><?php echo $order->vendor_name; ?><br/>
										Contact No. - <?php echo $order->b_contact; ?><br/>
										Address: <?php echo $order->b_building_no .','; ?> <?php echo $order->b_street_name .','; ?> <?php echo $order->b_district; ?><br />
										<?php echo $order->b_additional_no .','; ?> <?php echo $order->b_unit_no; ?><br/>
										<?php echo $order->billing_city_name .','; ?> <?php echo $order->b_zip_code; ?>
									</td>
									<td valign="top" style="float: right;">
										<table>
											<tr>
												<td><strong>SP MRV No. </strong></td>
												<td> : <?php echo $order->mrv_no; ?></td>
											</tr>
											<tr>
												<td><strong>SP MRV Date </strong></td>
												<td> : <?php echo date("d-m-Y", strtotime($order->mrv_date)); ?></td>
											</tr>
											<tr>
												<td><strong>SP P.O. No. </strong></td>
												<td> : <?php echo $order->po_no; ?></td>
											</tr>
											<tr>
												<td><strong>Requisition No. </strong></td>
												<td> : <?php echo $order->requisition_no; ?></td>
											</tr>
											<tr>
												<td><strong>Requisition Type. </strong></td>
												<td> : <?php echo ucfirst($order->requisition_type); ?></td>
											</tr>
											<tr>
												<td><strong>Contact No </strong></td>
												<td> : <?php echo $order->b_contact; ?></td>
											</tr>
											<tr>
												<td><strong>Supp Vat No. </strong></td>
												<td> : <?php echo $order->vat_no; ?></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td valign="top">
										<strong>BILLING ADDRESS</strong><br/><?php echo $this->admin->getWarehouseDetail()->contact_person;?><br/>
										Contact No. - <?php echo $this->admin->getWarehouseDetail()->warehouse_phone;?><br/>
										Address: <?php echo $this->admin->getWarehouseDetail()->complete_address;?>,<br>Kindom of Saudi Arabia.<br>
										VAT No. - 300034911400003
									</td>
								</tr>
								
								<tr>
									<td colspan="3" class="pb-0">
										<table class="table table-striped jambo_table table-bordered mb-0" id="item_table" width="100%" border="1" cellspacing="0" cellpadding="5">
											<thead>
												<tr>
													<td valign="top" bgcolor="#CCCCCC" style="width: 4%;"><strong>#</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 8%;"><strong>Part No.</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 10%;"><strong>Make</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 10%;"><strong>Model</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 36%;"><strong>Particular Name</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 8%;"><strong>Required Qty</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 8%;"><strong>Received Qty</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 8%;"><strong>SAR</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 8%;"><strong>Total</strong></td>
												</tr>
											</thead>
											<tbody>
												<?php $item_row = 1;if(!empty($items)){ foreach($items as $product){ ?>
												<tr id="item-row<?php echo $item_row;?>">
													<td valign="middle" align="center"><?php echo $item_row;?></td>
													<td valign="middle"><input type="text" name="item_code[]" value="<?php echo $product->item_code; ?>" class="form-control" readonly="readonly" required="required" /><input type="hidden" name="part_id[]" value="<?php echo $product->part_id; ?>" /></td>
													<td valign="middle"><input type="text" name="vehicle_make[]" value="<?php echo $product->make_name; ?>" class="form-control" readonly="readonly" required="required" /></td>
													<td valign="middle"><input type="text" name="vehicle_model[]" value="<?php echo $product->vehicle_model; ?>" class="form-control" readonly="readonly" required="required" /></td>
													<td valign="middle"><textarea name="spare_part_name[]" class="form-control" readonly="readonly" required="required" style="height: 38px;"><?php echo $product->part_name_en; ?></textarea></td>
													<td valign="middle"><input type="number" min="0" name="qty[]" value="<?php echo $product->qty; ?>" class="form-control" required="required" readonly="readonly" /></td>
													<td valign="middle"><input type="number" min="0" name="request_qty[]" value="<?php echo $product->qty; ?>" class="form-control item_unit" required="required" /></td>
													<td valign="middle"><input type="text" min="0" name="price[]" value="<?php echo $product->price; ?>" class="form-control unit_price" required="required" readonly="readonly" /></td>
													<td valign="middle"><input type="text" min="0" name="line_total[]" value="<?php echo $product->total; ?>" class="form-control item_total" required="required" readonly="readonly" /></td>
												</tr>
												<?php $item_row = $item_row + 1;}}?>
											</tbody>
										</table>
									</td>
								</tr>
								<tr>
									<td colspan="3" class="pt-0">
										<table class="table" style="width: 100%; border-spacing: 0px;">
											<tbody>
												<tr>
													<td style="width: 63%;"></td>

													<td style="vertical-align: top; width: 40%;padding: 0;">
														<table class="table table-bordered" id="tab_logic_total" width="100%" cellspacing="0" cellpadding="5" style="border: 1px solid #ddd;">
															<tr>
																<td valign="middle" style="text-align: left;">SUBTOTAL:</td>
																<td valign="middle" class="amount subtotal"><input type="text" name="sub_total" value="<?php echo $order->sub_total;?>" id="sub_total" class="form-control" readonly /></td>
															</tr>
															<tr>
																<td valign="middle" style="text-align: left;">TOTAL VAT %:</td>
																<td valign="middle" class="amount">
																	<div class="input-group mb-2 mb-sm-0">
																		<input type="number" class="form-control" name="vat_percent" id="vat_percent" value="<?php echo $order->vat_percent;?>" placeholder="0">
																		<span class="input-group-addon p-2 bg-light border">%</span>
																	</div>
																</td>
															</tr>
															<tr>
																<td valign="middle" style="text-align: left;">TOTAL VAT AMOUNT:</td>
																<td valign="middle" class="amount"><input type="text" id="total_vat_amt" name="total_vat_amt" value="<?php echo $order->total_vat_amt;?>" class="form-control" readonly /></td>
															</tr>
															<tr>
																<td valign="middle" style="text-align: left; width: 68%;">TOTAL SAR (VAT INC.):</td>
																<td valign="middle" class="total-amount"><input type="text" name="total" value="<?php echo $order->total_cost;?>" id="total_amount" class="form-control total" readonly /></td>
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
		$("#number").on("keypress",function(e){
			if($(this).val().length<='15'){
				if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {

				$("#errmsg").html("Digits Only").show();
				return false;
				}
			}else{
				$("#errmsg").html("Input Maxium 15 Digits Only").show();
				return false;
			}
		});
    });
   
	$(document).ready(function(){
		$('#item_table tbody').on('keyup change', function() {
			calc();
		});
		/*
		$('#fcy').on('keyup change', function() {
			calc_total();
		});
		
		$('#shipping_handling').on('keyup change', function() {
			calc_total();
		});*/
		
		$('#vat_percent').on('keyup change', function() {
			calc_total();
		});
	});

	function calc() {
		$('#item_table tbody tr').each(function(item_row, element) {
			var html = $(this).html();
			//alert(html);
			if (html != '') {
				var qty = $(this).find('.item_unit').val();
				var price = $(this).find('.unit_price').val();
				//var vat_price = $(this).find('.item_vatprice').val();
				var line_total = (qty * price);
				$(this).find('.item_total').val(line_total.toFixed(2));
				calc_total();
			}
		});
	}

	function calc_total() {
		var total = 0;
		var total_vat_amt = 0;
		$('.item_total').each(function() {
		    //total += parseInt($(this).val());
			total += parseFloat($(this).val());
		});
		$('#sub_total').val(total.toFixed(2));
		var tax_sum = (total / 100) * $('#vat_percent').val();
		$('#total_vat_amt').val(tax_sum.toFixed(2));
		main_total = tax_sum + total;
		$('#total_amount').val((main_total).toFixed(2));
	}
</script> 
