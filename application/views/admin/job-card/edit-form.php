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
					<h4>Job Cards</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/job-card/list');?>">Job Cards</a></li>
						<li class="breadcrumb-item active">Update</li>
					</ol>
				</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-1" title="Back" href="<?php echo base_url('admin/job-card/list');?>"><i class="fa fa-reply"></i> Back</a>
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
					 	<form id="demo-form2" method="post" action="<?php echo base_url('admin/job-card/submit')?>" class="form-label-left" data-toggle="validator" role="form">
							<input type="hidden" id="job_id" name="job_id" value="<?php echo $order->id;?>" required="required">
							<table class="table" width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td colspan="2" style="border-bottom: 2px solid #f4c53a;">
										<img src="<?php echo base_url('admin_assets/images/job-card/header-top.jpg');?>" style="width:100%;max-width: 100%;" />
									</td>
								</tr>
								<tr>
									<td align="left" valign="top" style="width: 40%;">
										<strong>JOB DETAIL </strong><br /><br/>Ref. No. - <?php echo 'JC-'. invoiceNmFormat($order->id); ?><br/>
										Job Type - <?php echo $order->job_type; ?><br/>
										Job Date - <?php echo date("d-m-Y", strtotime($order->job_date)); ?><br/>
										
									</td>
									<td valign="top" style="width: 60%; float: right;text-align: right;">
										<strong>Vehicle Number :</strong> <?php echo $order->bike_no; ?><br/>
										<strong>Purchase Date :</strong> <?php echo date("d-m-Y", strtotime($order->vehicle_p_date)); ?><br/>
										<strong>Vehicle Make:</strong> <?php echo $order->vehicle_make; ?><br />
										<strong>Vehicle Type:</strong> <?php echo $order->vehicle_type; ?><br />
										<strong>Vehicle Color:</strong> <?php echo $order->vehicle_color; ?><br>
										<strong>Vehicle Year:</strong> <?php echo $order->vehicle_year; ?>
									</td>
								</tr>
								
								<tr>
									<td colspan="3">
										<div class="search-bar-container">
											<h5>Search and add spare parts to purchase list</h5>
											<div class="input-group" style="border: 1px solid #ddd;">
												<input type="search" name="term" id="search_input" class="form-control txt_search_po" placeholder="Search by Item Code or Name" style="border: none;">
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
													<td valign="top" bgcolor="#CCCCCC" style="width: 10%;"><strong>S. No.</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 15%;"><strong>Item Code</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 45%;"><strong>Spare Part Name</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 10%;"><strong>Qty.</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 10%;"><strong>Unit Price</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 10%;"><strong>Line Amt.</strong></td>
												</tr>
											</thead>
											<tbody>
												<?php $item_row = 1;foreach($items as $product){ ?>
												<tr id="item-row<?php echo $item_row;?>">
													<td valign="top"><button type="button" onclick="remove_item(<?php echo $item_row;?>)" data-toggle="tooltip" title="Remove" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></button></td>
													<td valign="top"><input type="text" name="item_code[]" value="<?php echo $product->item_code; ?>" class="form-control" readonly="readonly" required="required" /><input type="hidden" name="item_id[]" value="<?php echo $product->item_id; ?>" /></td>
													<td valign="top"><input type="text" name="spare_part_name[]" value="<?php echo $product->spare_part_name; ?>" class="form-control" readonly="readonly" required="required" /><input type="hidden" name="spare_part_name_ar[]" value="<?php echo $product->spare_part_name_ar; ?>" /></td>
													<td valign="top"><input type="number" min="1" max="100" name="qty[]" value="<?php echo $product->qty; ?>" class="form-control item_unit" required="required" /></td>
													<td valign="top"><input type="text" min="0" max="1000" name="cost[]" value="<?php echo $product->cost; ?>" class="form-control unit_price" required="required" /></td>
													<td valign="top"><input type="text" min="0" max="1000" name="line_amount[]" value="<?php echo $product->line_amount; ?>" class="form-control item_total" /></td>
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
																<td style="text-align: left;">SERVICE CHARGE:</td>
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

	function addItem(id,part_name_en,part_name_ar,item_code,cost_price){
		html  = '<tr id="item-row' + id + '">';
		html += '  <td class="text-right"><button type="button" onclick="remove_item(' + id + ')" data-toggle="tooltip" title="Remove" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></button></td>';
		html += ' <td class="text-left"><input type="text" name="item_code[]" class="form-control" value="' + item_code + '" required readonly /><input type="hidden" name="item_id[]" value="' + id + '" /></td>';
		html += ' <td class="text-left"><input type="text" name="spare_part_name[]" id="item-list" value="' + part_name_en + '" class="form-control" readonly="readonly" required /><input type="hidden" name="spare_part_name_ar[]" value="' + part_name_ar + '" /></td>';
		html += '<td class="text-left"><input type="number" min="1" max="1000" name="qty[]" class="form-control item_unit" required /></td>';
		html += '<td class="text-left"><input type="text" min="0" max="1000" name="cost[]" value="' + cost_price + '" class="form-control unit_price" required /></td>';
		html += '<td class="text-left"><input type="text" min="0" max="1000" name="line_amount[]" class="form-control item_total" required /></td>';
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
					url: '<?php echo base_url();?>admin/Jobcard/get_search_list',
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
								var item_code = response['result'][i]['item_code'];
								var part_name_en = response['result'][i]['part_name_en'];
								if(response['result'][i]['part_name_ar'] == ''){
									var part_name_ar = 'NULL';
								}else{
									var part_name_ar = response['result'][i]['part_name_ar'];
								}
								var quantity = response['result'][i]['quantity'];
								var cost_price = response['result'][i]['cost_price'];
								var available_qty = response['result'][i]['available_qty'];
								var status = response['result'][i]['status'];
								$('.searchResults').append('<div class="item-list"><button type="button" data-name="'+part_name_en+'" data-arabic="'+part_name_ar+'" data-id="'+id+'" data-item_code="'+item_code+'" data-cost_price="'+cost_price+'" class="item-button btn btn-primary btn-sm">+</button> <span class="item-name">'+part_name_en+'<br/>'+ part_name_ar +'Item Code - <span>'+item_code+'</span></span></div>');

							}
							$('.item-list').on('click', '.item-button', function() {
								var p_id = $(this).data('id');
								var part_name_en = $(this).data('name');
								var part_name_ar = $(this).data('arabic');
								var item_code = $(this).data('item_code');
								var cost_price = $(this).data('cost_price');
								addItem(p_id,part_name_en,part_name_ar,item_code,cost_price);
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
