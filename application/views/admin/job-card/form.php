<?php $this->load->view('admin/home/header');?>
<style>
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    border-top: none;
}
.table {
    margin-bottom: -16px;
}
table{
	color: #000;
}
.table-responsive {
    min-height: .01%;
    overflow-x: inherit;
    margin-bottom: 50px;
}
.d-none{
	display:none;
}
.searchResults{
	list-style: none;
    position: absolute;
    left: 13px;
    width: 97%;
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
<div class="page-title">
	<div class="title_left">
		<h3>Purchase Order</h3>
	</div>
	<div class="title_right">
		<a class="btn btn-sm btn-default pull-right"  data-toggle="tooltip" title="Back" href="<?php echo base_url();?>admin/purchase_order"><i class="fa fa-reply"></i></a>
		<button form="demo-form2" type="submit" class="btn btn-sm btn-info pull-right" data-toggle="tooltip" title="Save"><i class="fa fa-save"></i></button>
	</div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h5><i class="fa fa-pencil"></i> Purchase Order</h5>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
				<div class="table-responsive">
					<form id="demo-form2" method="post" action="<?php echo base_url()?>admin/purchase_order/add_order" class="form-label-left" data-toggle="validator" role="form">
						<table class="table" width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; line-height: 22px;">
							<tr style="height: 95px;">
								<td>
									<label style="display:block">Select Vendor</label>
									<select name="vendor_id" id="vendor_id" class="form-control select2" required>
										<option value="">Select Vendor</option>
										<?php foreach($vendor_list as $vendor){?>
										<option value="<?php echo $vendor->id;?>"><?php echo $vendor->vendor_name;?></option>
										<?php } ?>
									</select>
								</td>
								<td></td>
								<td align="left" valign="top">
									<h2 style="padding-bottom: 0px; margin-bottom: 0px;"><strong>Purchase Order</strong></h2>
									<br />
								</td>
							</tr>
							<tr></tr>
							<tr>
								<td valign="top" style="width:40%">
									<p style="margin: 0px; line-height: 0px; padding-bottom: 10px;font-weight:600;">Billing Address:</p>
									<span id="vendor_name"></span><br/>
									<span id="vendor_contact"></span><br/>
									<span id="building_no"></span> <span id="street_name"></span> <span id="district_name"></span><br/>
									<span id="additional_no"></span>
									<span id="unit_no"></span><br>
									<span id="city_name"></span>
									<span id="zip_code"></span>
								</td>

								<td valign="top" style="width:30%">
									<p style="margin: 0px; line-height: 0px; padding-bottom: 10px;font-weight:600;">Deliver To:</p>
									<span id="s_name"></span><br/>
									<span id="s_vendor_contact"></span><br/>
									<span id="s_building_no"></span> <span id="s_street_name"></span> <span id="s_district_name"></span><br/>
									<span id="s_additional_no"></span>
									<span id="s_unit_no"></span><br>
									<span id="s_city_name"></span>
									<span id="s_zip_code"></span>
								</td>

								<td valign="top" style="width:30%">
									<p style="margin: 0px; padding-bottom: 5px;"><b>P.O. Number:</b> _______</p>
									<div><b>P.O Date:</b> <span id="po_date"></span></div>
									<div><b>P.O Term:</b> <span id="po_term"></span></div>
									<div><b>Contact:</b> <span id="po_contact"></span></div>
									</div>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									<div class="search-bar-container">
										<h5 style="font-weight: 600;">Search and add product to purchase list</h5>
										<div class="input-group custom-search-form" style="margin-bottom: 1px;">
											<input type="search" name="term" class="form-control txt_search_po" placeholder="Search by Product SKU or Name">
											<span class="input-group-btn">
												<button class="btn btn-danger" id="reset_btn" type="button">
												<span class="glyphicon glyphicon-remove"></span>
												</button>
											</span>
										</div>
									</div>
									<div class="search-result-container">
										<div id="result_box" class="searchResults d-none"></div>
									</div>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									<table class="table table-striped jambo_table table-bordered mb-0" id="item_table" width="100%" border="1" cellspacing="0" cellpadding="5">
										<thead>
											<tr>
												<td valign="top" bgcolor="#CCCCCC" style="width: 5%;"><strong><i class="fa fa-plus"></i></strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 15%;"><strong>SKU</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 50%;"><strong>DESCRIPTION</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 10%;"><strong>UNIT/QTY</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 10%;"><strong>UNIT PRICE (SAR)</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 10%;"><strong>TOTAL (SAR)</strong></td>
											</tr>
										</thead>
										<tbody>
										
										</tbody>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									<table class="table" style="width: 100%; border-spacing: 0px;">
										<tbody>
											<tr>
												<td style="width: 60%;">
													<p>1. Please send two copies of your invoice.</p>
													<p>2. Enter this order in accordance with the prices, terms, delivery method, and specifications listed above.</p>
													<p>3. Please notify us immediately if you are unable to ship as specified.</p>
													<p>4. Send all correspondence to:</p>
													<p style="padding-left: 20px;">
														
													</p>
												</td>

												<td style="vertical-align: top; width: 40%;padding: 0;">
													<table class="table table-bordered" id="tab_logic_total" width="100%" cellspacing="0" cellpadding="5" style="border: 1px solid gray; border-top: 0px;">
														<tr>
															<td style="text-align: left;">SUBTOTAL:</td>
															<td class="amount subtotal"><input type="text" name="sub_total" id="sub_total" class="form-control" /></td>
														</tr>
														<tr>
															<td style="text-align: left;">VAT %:</td>
															<td class="amount">
																<div class="input-group mb-2 mb-sm-0">
																	<input type="number" class="form-control" name="sale_tax" id="sale_tax" placeholder="0" value="15">
																	<div class="input-group-addon">%</div>
																</div>
															</td>
														</tr>
														<tr>
															<td style="text-align: left;">VAT AMOUNT:</td>
															<td class="amount"><input type="text" id="sale_tax_amt" name="sale_tax_amt" class="form-control" /></td>
														</tr>
														<tr>
															<td style="text-align: left;">SHIPPING &amp; HANDLING:</td>
															<td class="amount"><input type="text" name="shipping_handling" id="shipping_handling" class="form-control" /></td>
														</tr>
														<tr>
															<td style="text-align: left; width: 70%;">TOTAL:</td>
															<td class="total-amount"><input type="text" name="total"  id="total_amount" class="form-control total" /></td>
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
        </div>
    </div>
</div>

<?php $this->load->view('admin/home/footer');?>

<script>
	$('#vendor_id').on('change', function() {
		var clientid = $( "#vendor_id option:selected" ).attr("value");
		//alert(clientid);
		get_vendor_detail(clientid);
	});
	
	function get_vendor_detail(u){
		$.ajax({
			url: '<?php echo base_url();?>admin/purchase_order/vendor_detail',
			type: "GET",
			data: {'id':u},
			success: function(data){ 
				var result = JSON.parse(data);
				var today_date = $.datepicker.formatDate('yy-mm-dd', new Date());
				//alert(result.vendor_name);
				if(result){
					$("#vendor_name").html(result.vendor_name);
					$("#vendor_contact").html(result.telephone);
					$("#building_no").html(result.building_no);
					$("#street_name").html(result.street_name);
					$("#district_name").html(result.district);
					$("#additional_no").html(result.additional_no + ',');
					$("#unit_no").html(result.unit_no);
					$("#city_name").html(result.city_name + ',');
					$("#zip_code").html(result.postal_code);
					
					$("#s_name").html(result.contact_person_name);
					$("#s_vendor_contact").html(result.telephone);
					$("#s_building_no").html(result.building_no);
					$("#s_street_name").html(result.street_name);
					$("#s_district_name").html(result.district);
					$("#s_additional_no").html(result.additional_no + ',');
					$("#s_unit_no").html(result.unit_no);
					$("#s_city_name").html(result.city_name + ',');
					$("#s_zip_code").html(result.postal_code);
					
					$("#po_no").html('');
					$("#po_date").html(today_date);
					$("#po_term").html(result.payment_terms);
					$("#po_contact").html(result.telephone);
				}else{
					alert('Data not found');
					$("#vendor_name").html('');
					$("#vendor_contact").html('');
					$("#building_no").html('');
					$("#street_name").html('');
					$("#district_name").html('');
					$("#additional_no").html('');
					$("#unit_no").html('');
					$("#city_name").html('');
					$("#zip_code").html('');
					
					$("#s_name").html('');
					$("#s_vendor_contact").html('');
					$("#s_building_no").html('');
					$("#s_street_name").html('');
					$("#s_district_name").html('');
					$("#s_additional_no").html('');
					$("#s_unit_no").html('');
					$("#s_city_name").html('');
					$("#s_zip_code").html('');
					
					$("#po_date").html(today_date);
					$("#po_term").html('');
					$("#po_contact").html('');
				}
				
			},
			error: function(data){
				alert(data);
			}
		});
	}
	
	var item_row = 1;

	function addItem(id,name,sku,arabic_name,barcode){
		html  = '<tr id="item-row' + id + '">';
		html += '  <td class="text-right"><button type="button" onclick="remove_item(' + id + ')" data-toggle="tooltip" title="Remove" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></button></td>';
		html += ' <td class="text-left"><input type="text" name="item_sku[]" class="form-control" value="' + sku + '" /><input type="hidden" name="barcode[]" value="' + barcode + '" /></td>';
		html += ' <td class="text-left"><input type="text" name="item_description[]" id="item-list" value="' + name + '" class="form-control" readonly="readonly" /><input type="hidden" name="item_desc_arabic[]" id="item-arabic-list" value="' + arabic_name + '" /></td>';
		html += '<td class="text-left"><input type="number" min="1" max="1000" name="item_unit[]" class="form-control item_unit" /></td>';
		html += '<td class="text-left"><input type="text" min="0" max="1000" name="unit_price[]" class="form-control unit_price" /></td>';
		html += '<td class="text-left"><input type="text" min="0" max="1000" name="item_total[]" class="form-control item_total" /></td>';
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

	$(document).ready(function() {
		$('#description').summernote({
		height: 200
		});
	});
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
	   // alert($(this).val());
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
								var name = response['result'][i]['name'];
								var arabic_name = response['result'][i]['name_arabic'];
								var sku = response['result'][i]['sku'];
								var barcode = response['result'][i]['barcode'];
								var image = (response['result'][i]['image'] == "") ? "images/image-not-available.jpg" : response['result'][i]['image'];
								$('.searchResults').append('<div class="item-list"><button type="button" data-name="'+name+'" data-arabic="'+arabic_name+'" data-id="'+id+'" data-sku="'+sku+'" data-barcode="'+barcode+'" class="item-button btn btn-primary btn-sm">+</button> <img src="<?php echo base_url();?>'+image+'" class="img-fluid rounded shadow-sm mr-3" width="40px" style="margin-right: 10px;float: left;min-height: 35px;" /><span class="item-name">'+name+'<br/>SKU - <span>'+sku+'</span></span></div>');

							}
							$('.item-list').on('click', '.item-button', function() {
								var p_name = $(this).data('name');
								var p_id = $(this).data('id');
								var p_sku = $(this).data('sku');
								var arabic_name = $(this).data('arabic');
								var barcode = $(this).data('barcode');
								addItem(p_id,p_name,p_sku,arabic_name,barcode);
								$(this).prop('disabled', true);
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
			$("#result_box").addClass("d-none");
		});
	});
</script> 
