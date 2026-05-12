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
					<h4>Purchase Orders</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item active">Purchase Orders List</li>
					</ol>
				</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-1" title="Back" href="<?php echo base_url('admin/purchase/list');?>"><i class="fa fa-reply"></i> Back</a>
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
					 	<form id="demo-form2" method="post" action="<?php echo base_url()?>admin/purchase_order/add_order" class="form-label-left" data-toggle="validator" role="form">
							<input type="hidden" id="id" name="id" value="<?php echo $order->id;?>" required="required">
							<input type="hidden" id="vendor_id" name="vendor_id" value="<?php echo $order->vendor_id;?>" required="required">
							<table class="table" width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; line-height: 22px;">
								<tr>
									<td colspan="2"><img src="<?php echo base_url('admin_assets/images/purchase_order/header-top.jpg');?>" style="width:100%;max-width: 100%;" /></td>
								</tr>
								<tr>
									<td align="left" valign="top" style="width: 40%;">
										<strong>SUPPLIER ADDRESS <br /> </strong><?php echo $order->vendor_name; ?><br/>
										Contact No. - <?php echo $order->b_contact; ?><br/>
										Address: <?php echo $order->b_building_no .','; ?> <?php echo $order->b_street_name .','; ?> <?php echo $order->b_district; ?><br />
										<?php echo $order->b_additional_no .','; ?> <?php echo $order->b_unit_no; ?><br/>
										<?php echo $order->billing_city_name .','; ?> <?php echo $order->b_zip_code; ?>
									</td>
									<td valign="top" style="width: 60%; float: right;text-align: right;">
										<strong>P.O. Number :</strong> <?php echo $order->invoice_prefix .'-'. $order->po_number; ?><br/>
										<strong>P.O Date :</strong> <?php echo date("d-m-Y", strtotime($order->po_date)); ?><br/>
										<strong>P.O Term:</strong> <?php echo $order->po_terms; ?><br />
										<strong>Contact No:</strong> <?php echo $order->po_contact; ?><br />
										<strong>Supp Vat No.:</strong> <?php echo $order->vat_no; ?><br>
										<strong>Reference:</strong> <?php echo $order->reference; ?>
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
									<td colspan="3">
										<div class="search-bar-container">
											<h5>Search and add product to purchase list</h5>
											<div class="input-group" style="border: 1px solid #ddd;">
												<input type="search" name="term" id="search_input" class="form-control txt_search_po" placeholder="Search by Product SKU or Name" style="border: none;">
												<span class="input-group-text bg-primary text-dark border-0" id="reset_btn"><i class="mdi mdi-undo"></i> Reset</span>
											</div>
										</div>
										<div class="search-result-container">
											<div id="result_box" class="searchResults d-none"></div>
										</div>
									</td>
								</tr>
							
								<tr>
									<td colspan="3" class="pb-0">
										<table class="table table-striped jambo_table table-bordered mb-0" id="item_table" width="100%" border="1" cellspacing="0" cellpadding="5">
											<thead>
												<tr>
													<td valign="top" bgcolor="#CCCCCC" style="width: 5%;"><strong><i class="fa fa-plus"></i></strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 15%;"><strong>SKU</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 43%;"><strong>DESCRIPTION</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 10%;"><strong>UNIT/QTY</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 15%;"><strong>UNIT PRICE<p class="m-0">(Excluding VAT)</p></strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 12%;"><strong>TOTAL (SAR)<p class="m-0">(Excl. VAT)</p></strong></td>
												</tr>
											</thead>
											<tbody>
												<?php $item_row = 1;foreach($products as $product){ ?>
												<tr id="item-row<?php echo $item_row;?>">
													<td valign="top"><button type="button" onclick="remove_item(<?php echo $item_row;?>)" data-toggle="tooltip" title="Remove" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></button></td>
													<td valign="top"><input type="text" name="item_sku[]" value="<?php echo $product->item_sku; ?>" class="form-control" readonly="readonly" required="required" /><input type="hidden" name="barcode[]" value="<?php echo $product->barcode; ?>" /><input type="hidden" name="seller_sku[]" value="<?php echo $product->seller_sku; ?>" /><input type="hidden" name="prod_id[]" value="<?php echo $product->prod_id; ?>" required /><input type="hidden" name="size_id[]" value="<?php echo $product->size_id; ?>" required /></td>
													<td valign="top"><input type="text" name="item_description[]" value="<?php echo $product->item_description; ?>" class="form-control" readonly="readonly" required="required" /><input type="hidden" name="item_desc_arabic[]" id="item-arabic-list" value="<?php echo $product->item_desc_arabic; ?>" /></td>
													<td valign="top"><input type="number" min="1" max="100" name="item_unit[]" value="<?php echo $product->item_unit; ?>" class="form-control item_unit" required="required" /></td>
													<td valign="top"><input type="text" min="0" max="100" name="unit_price[]" value="<?php echo $product->unit_price; ?>" class="form-control unit_price" required="required" /></td>
													<td valign="top"><input type="text" min="0" max="100" name="item_total[]" value="<?php echo $product->item_total; ?>" class="form-control item_total" /></td>
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

													<td style="vertical-align: top; width: 40%;padding: 0;">
														<table class="table table-bordered" id="tab_logic_total" width="100%" cellspacing="0" cellpadding="5" style="border: 1px solid #ddd;">
															<tr>
																<td style="text-align: left;">SUBTOTAL:</td>
																<td class="amount subtotal"><input type="text" name="sub_total" value="<?php echo $order->sub_total;?>" id="sub_total" class="form-control" /></td>
															</tr>
															<tr>
																<td style="text-align: left;">VAT %:</td>
																<td class="amount">
																	<div class="input-group mb-2 mb-sm-0">
																		<input type="number" class="form-control" name="sale_tax" id="sale_tax" value="<?php echo $order->sale_tax;?>" placeholder="0">
																		<span class="input-group-addon">%</span>
																	</div>
																</td>
															</tr>
															<tr>
																<td style="text-align: left;">VAT AMOUNT:</td>
																<td class="amount"><input type="text" id="sale_tax_amt" name="sale_tax_amt" value="<?php echo $order->sale_tax_amt;?>" class="form-control" /></td>
															</tr>
															<tr>
																<td style="text-align: left;">SHIPPING &amp; HANDLING:</td>
																<td class="amount"><input type="text" name="shipping_handling" id="shipping_handling" value="<?php echo $order->shipping_handling;?>" class="form-control" /></td>
															</tr>
															<tr>
																<td style="text-align: left; width: 68%;">TOTAL:</td>
																<td class="total-amount"><input type="text" name="total"  value="<?php echo $order->total;?>" id="total_amount" class="form-control total" /></td>
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

	function addItem(id,p_prod_id,p_size_id,name,sku,parentsku,sellersku,arabic_name,barcode){
		html  = '<tr id="item-row' + id + '">';
		html += '  <td class="text-right"><button type="button" onclick="remove_item(' + id + ')" data-toggle="tooltip" title="Remove" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></button></td>';
		html += ' <td class="text-left"><input type="text" name="item_sku[]" class="form-control" value="' + parentsku +'-'+ sku + '" required readonly /><input type="hidden" name="barcode[]" value="' + barcode + '" /><input type="hidden" name="seller_sku[]" value="' + sellersku + '" /><input type="hidden" name="prod_id[]" value="' + p_prod_id + '" required="required" /><input type="hidden" name="size_id[]" value="' + p_size_id + '" required="required" /></td>';
		html += ' <td class="text-left"><input type="text" name="item_description[]" id="item-list" value="' + name + '" class="form-control" readonly="readonly" required /><input type="hidden" name="item_desc_arabic[]" id="item-arabic-list" value="' + arabic_name + '" /></td>';
		html += '<td class="text-left"><input type="number" min="1" max="1000" name="item_unit[]" class="form-control item_unit" required /></td>';
		html += '<td class="text-left"><input type="text" min="0" max="1000" name="unit_price[]" class="form-control unit_price" required /></td>';
		html += '<td class="text-left"><input type="text" min="0" max="1000" name="item_total[]" class="form-control item_total" required /></td>';
		html += '</tr>';

		$('#item_table tbody').append(html);
	}

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
				$(this).find('.item_total').val((qty * price).toFixed(2));
				calc_total();
			}
		});
	}

	function calc_total() {
		var total = 0;
		var ship_amt = 0;
		$('.item_total').each(function() {
		    //total += parseInt($(this).val());
			total += parseFloat($(this).val());
		});
		$('#sub_total').val(total.toFixed(2));
		tax_sum = (total / 100) * $('#sale_tax').val();
		$('#sale_tax_amt').val(tax_sum.toFixed(2));
		ship_amt = parseFloat($('#shipping_handling').val());
		main_total = ship_amt + total;
		$('#total_amount').val((tax_sum + main_total).toFixed(2));
	}

</script>
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
	
    function Alpha(evt)
    {
        var keyCode = (evt.which) ? evt.which : evt.keyCode
        if ((keyCode < 65 || keyCode > 90) && (keyCode < 97 || keyCode > 123) && keyCode != 32)
         
        return false;
            return true;
    }
	
    function numerics(key) {
	   //getting key code of pressed key
	   //alert($(this).val());
	   var keycode = (key.which) ? key.which : key.keyCode;
	   //comparing pressed keycodes

	   if (keycode > 31 && (keycode < 48 || keycode > 57)) {
		   alert(" You can enter only characters 0 to 9 ");
		   return false;
	   }
	   else return true;


   }
   
	$(document).ready(function(){
		$('.txt_search_po').on('search', function(evt) {
			$(".searchResults").html('');
		});

		$(".txt_search_po").keyup(function(){
			var search = $(this).val();
			if(search.length > 2){
				$("#result_box").removeClass("d-none");
				$.ajax({
					url: '<?php echo base_url();?>admin/Purchase_order/get_search_list',
					type: 'get',
					data: {term:search},
					dataType: 'json',
					success:function(response){
						var len = response['result'].length;
						//console.log(response);
						//alert(response);
						$(".searchResults").empty();
						if(len > 0){
							for( var i = 0; i<len; i++){
								
								var id = response['result'][i]['id'];
								var prod_id = response['result'][i]['prod_id'];
								var size_id = response['result'][i]['size_id'];
								var name = response['result'][i]['name'];
								var arabic_name = response['result'][i]['name_arabic'];
								var parent_sku = response['result'][i]['parent_sku'];
								var sku = response['result'][i]['sku'];
								if(response['result'][i]['seller_sku'] == ''){
									var seller_sku = 'NULL';
								}else{
									var seller_sku = response['result'][i]['seller_sku'];
								}
								var barcode = response['result'][i]['barcode'];
								var image = (response['result'][i]['image'] == "" || response['result'][i]['image'] == null) ? "images/image-not-available.jpg" : response['result'][i]['image'];
								$('.searchResults').append('<div class="item-list"><button type="button" data-name="'+name+'" data-arabic="'+arabic_name+'" data-id="'+id+'" data-size_id="'+size_id+'" data-prod_id="'+prod_id+'" data-sku="'+sku+'" data-parentsku="'+parent_sku+'" data-sellersku="'+seller_sku+'" data-barcode="'+barcode+'" class="item-button btn btn-primary btn-sm">+</button> <img src="<?php echo base_url();?>'+image+'" class="img-fluid rounded shadow-sm mr-3" width="40px" style="margin-right: 10px;float: left;min-height: 35px;" /><span class="item-name">'+name+'<br/>SKU - <span>'+parent_sku+'-'+sku+' ('+ barcode + ') '+'</span></span></div>');

							}
							$('.item-list').on('click', '.item-button', function() {
								var p_name = $(this).data('name');
								var p_id = $(this).data('id');
								var p_prod_id = $(this).data('prod_id');
								var p_size_id = $(this).data('size_id');
								var p_sku = $(this).data('sku');
								var p_parentsku = $(this).data('parentsku');
								var p_sellersku = $(this).data('sellersku');
								var arabic_name = $(this).data('arabic');
								var barcode = $(this).data('barcode');
								addItem(p_id,p_prod_id,p_size_id,p_name,p_sku,p_parentsku,p_sellersku,arabic_name,barcode);
								$(this).prop('disabled', true);
								$("#reset_btn").click();
							});
						}else{
							$('.searchResults').append('<a class="text-dark"><div class="d-flex align-items-center border-bottom p-3"><span class="font-weight-bold">No search result found. Try another keyword.</span></div></a>');
						}
					},
					error: function(data){
						alert(JSON.stringify(data));
					}
				});
			}else{
				$(".searchResults").html('');
				$("#result_box").addClass("d-none");
			}
		});
		
		$("#reset_btn").click(function(){
			$(".searchFormPo").html('');
			$(".searchResults").html('');
			$('#search_input').val('');
			$("#result_box").addClass("d-none");
		});
	});
</script> 
