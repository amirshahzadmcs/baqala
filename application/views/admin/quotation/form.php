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
    max-height: 330px;
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
#tableOrder tbody tr td{
	font-size: 12px;
    font-weight: 600;
}
#status_text i{
	border-radius: 50%;
    padding: 10px;
}

</style>
<div id="wait"><i class="fa fa-spinner fa-spin"></i><br>Updating..</div>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Quotation Form</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/quotation/list');?>">Quotation</a></li>
						<li class="breadcrumb-item active">Edit</li>
					</ol>
				</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-1" title="Back" href="<?php echo base_url('admin/quotation/list');?>"><i class="fa fa-reply"></i> Back</a>
					<button type="button" class="btn btn-custom-success btn-sm pull-right me-1" data-bs-toggle="modal" data-bs-target=".quotation-modal"><i class="fa fa-pen"></i> Edit Basic Info</button>
					<button form="updateForm" type="submit" class="btn btn-custom-success btn-sm pull-right me-1 d-none"><i class="fa fa-save"></i> Save</button>
					<?php if($result['order']['quotation_status'] !== 'accept'){ ?>
						<button type="button" class="btn btn-custom btn-sm pull-right me-1" onclick="changeStatus('review')"><i class="ti-share"></i> Send for Review</button>
						<button type="button" class="btn btn-custom-danger btn-sm pull-right me-1" onclick="changeStatus('reject')"><i class="ti-close"></i> Reject</button>
					<?php } ?>
					<?php if($result['order']['quotation_status'] == 'approved'){ ?>
						<button class="btn btn-custom-success btn-sm pull-right" data-toggle="tooltip" title="Close Quotation" onclick="changeStatus('accept')"><i class="fa fa-lock"></i> Close Quotation</button>
					<?php } ?>
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
								<td colspan="2"><img src="<?php echo base_url('admin_assets/images/quotation/header-top.jpg');?>" style="width: 100%;max-width: 100%;" /></td>
							</tr>
							<tr>
								<td align="left" valign="top" style="width: 40%;">
									<strong>SUPPLIER ADDRESS <br /> </strong>Maha Alfala Trading Est.<br/>
									Contact No. - <?php echo INV_MOBILE;?><br/>
									Address: 8411 Istanbul Street Sulay, Riyadh 14322,<br>Kindom of Saudi Arabia.<br>
									VAT No. - 300034911400003
								</td>
								<td valign="top" style="width: 60%; float: right;text-align: right;">
									<?php if(!empty($result['order']['payment_code'])){?>
									<strong>TransRef ID :</strong> <?php echo $result['order']['payment_code']; ?><br/>
									<?php } ?>
									<strong>Quotation Number :</strong> <?php echo $result['order']['invoice_prefix'] .'-'. $result['order']['quotation_no'];?><br/>
									<strong>Associate Name:</strong> <?php echo $result['order']['associate_name'];?><br />
									<strong>Payment type:</strong> <?php echo $result['order']['payment_method']; ?><br />
									<strong>Quotation Date:</strong> <?php $qdate=$result['order']['date_added']; echo date('d-m-Y', strtotime($qdate)); ?><br/>
									<strong>Quotation Valid Till:</strong> <?php echo date('d-m-Y', strtotime($result['order']['quotation_expiry_date'])); ?><br/>
									<?php
										if($result['order']['quotation_status'] == 'pending'){
											$status_message = '<span class="badge badge-pill bg-secondary"> Pending</span>';
										}
										elseif($result['order']['quotation_status'] == 'review'){
											$status_message = '<span class="badge badge-pill bg-info"> In Review</span>';
										}elseif($result['order']['quotation_status'] == 'reject'){
											$status_message = '<span class="badge badge-pill bg-danger">Rejected</span>';
										}elseif($result['order']['quotation_status'] == 'approved'){
											$status_message = '<span class="badge badge-pill bg-dark">Approved</span>';
										}elseif($result['order']['quotation_status'] == 'accept'){
											$status_message = '<span class="badge badge-pill bg-primary">Accepted</span>';
										}elseif($result['order']['quotation_status'] == 'converted'){
											$status_message = '<span class="badge badge-pill bg-success">Converted</span>';
										}
									?>
									<strong>Status:</strong> <?= $status_message;?>
									
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
									<?php echo $result['order']['s_person_name'] .' ('. $result['order']['c_company'] .')';?><br/>
									<?php echo $result['order']['s_mobile'];?>, <?php echo $result['order']['s_phone'];?><br/>
									<?php echo $result['order']['s_email'];?><br/>
									<?php echo $result['order']['s_address_type'];?>-<?php echo $result['order']['s_building_villa_no'];?>, <?php echo $result['order']['s_street'];?><br/>
									<?php echo $result['order']['s_city'];?> <?php echo $result['order']['s_postal'];?><br/>
									<?php echo $result['order']['s_country'];?>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									<div class="search-bar-container">
										<h5>Search and add product to quotation list</h5>
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
									<table class="table table-striped jambo_table table-bordered mb-0" id="tableOrder" width="100%" border="1" cellspacing="0" cellpadding="5">
										<thead>
											<tr>
												<td valign="top" bgcolor="#CCCCCC" style="width: 5%; text-align: center;"><strong>#</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 8%; text-align: center;"><strong>IMAGE</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 12%; text-align: center;"><strong>BARCODE</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 27%; text-align: center;"><strong>PRODUCT NAME/ DESCRIPTION</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 8%; text-align: center;"><strong>PRICE</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 6%; text-align: center;"><strong>QTY</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 5%; text-align: center;"><strong>VALUE</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 5%; text-align: center;"><strong>NET</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 5%; text-align: center;"><strong>VAT</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 5%; text-align: center;"><strong>VAT%</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 7%; text-align: center;"><strong>TOTAL</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 7%; text-align: center;"><strong>TOOLS</strong></td>
											</tr>
										</thead>
										<tbody>
											<?php echo form_open('admin/quotation/update', array("id"=>"updateForm")); ?>
												<input type="hidden" name="order_id" value="<?php echo $this->input->get('id');?>" required />
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
													<input type="hidden" name="seller_sku[]" value="<?php echo $product['seller_sku'];?>" />
													<input type="hidden" name="barcode[]" value="<?php echo $product['barcode'];?>" />
													<input type="hidden" name="size[]" value="<?php echo $product['size'];?>" />
													<input type="hidden" name="product_sku[]" value="<?php echo $product['product_sku'];?>" />
													<td valign="top" style="text-align: center;width:5%;"><?php echo $i++;?></td>
													<td valign="top" style="text-align: center;width:8%;"><img src="<?php echo ($product['product_image'] == "" OR !file_exists($product['product_image'])) ? 'images/notfound.jpg':base_url($product['product_image']);?>" width="50px"></td>
													<td valign="top" style="text-align: center;width:12%;"><?php echo $product['barcode'];?></td>
													<td valign="top" style="width:27%;">
														<?php echo $product['product_name']; ?><br />
														<!--<span style="display: block; text-align: right;"><?php echo $product['arabic_name']; ?> </span>-->
													</td>
													<td valign="top" style="text-align: right;width:8%;"><input type="text" class="form-control updateBtn" name="price[]" value="<?php echo  sprintf("%.2f", $p_price); ?>" required style="width: 75px;"/></td>
													<td valign="top" style="text-align: center;width:6%;"><input type="number" class="form-control updateBtn" name="quantity[]" value="<?php echo $product['quantity'];?>" min="1" required style="width: 55px;"/></td>
													<td valign="top" style="text-align: right;width:5%;"><?php echo  sprintf("%.2f", $product['order_price']); ?></td>
													<td valign="top" style="text-align: right;width:5%;"><?php echo sprintf("%.2f", $initial_price); ?></td>
													<td valign="top" style="text-align: center;width:5%;"><?php echo sprintf("%.2f", $product['vat_price']); ?></td>
													<td valign="top" style="text-align: center;width:5%;"><?php echo $product['gst_rate'] .'%'; ?></td>
													<td valign="top" style="text-align: right;width:7%;"><?php echo sprintf("%.2f", $product['order_price']); ?></td>
													<td valign="top" style="text-align: right;padding-top:10px;width:7%;"><button class="btn btn-danger btn-sm btnDelete"><i class="fa fa-minus-circle"></i></td>
												</tr>
												<?php } ?>
											<?php echo form_close();?>
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
 	</div>
 </div>

 <!-- Modal -->
<div class="modal fade status-modal" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0">Change Status</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="status-form" method="post" action="<?php echo base_url('admin/quotation/update-status')?>" data-toggle="validator" role="form">
					<div class="row">
						<input type="hidden" name="quotation_id" value="<?php echo $this->input->get('id');?>" required />
						<input type="hidden" name="customer_id" value="<?php echo $result['order']['customer_id'];?>" required />
						<input type="hidden" name="staff_id" value="<?php echo $result['order']['staff_id'];?>" required />
						<input type="hidden" name="quotation_no" value="<?php echo $result['order']['invoice_prefix'] .'-'. $result['order']['quotation_no'];?>" required />
						<input type="hidden" name="quotation_status" id="quotation_status" value="" required />
						<p id="status_text" class="text-center font-size-16 text-dark mt-3"></p>
					</div>
				</form>
			</div>
			<div class="modal-footer">
                <button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="status-form" class="btn btn-success">Update</button>
            </div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal -->
<div class="modal fade quotation-modal" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0">Edit Quotation</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="demo-form2" method="post" action="<?php echo base_url('admin/quotation/update-basic')?>" data-toggle="validator" role="form" enctype="multipart/form-data">
					<input type="hidden" name="quote_id" value="<?php echo $result['order']['id'];?>" required />
					<input type="hidden" name="customer_id" value="<?php echo $result['order']['customer_id'];?>" required />
					<div class="row">
						<div class="col-md-12 mb-3 form-group">
							<label class="control-label" for="address_id" style="width:100%">Select Customer Address <span class="text-danger">*</span></label>
							<select id="address_id" name="address_id" class="form-control select2" required>
								<option value="">--- Select Address ---</option>
							</select>
						</div>
						<div class="col-md-6 form-group">
							<label class="control-label" for="payment_method">Payment Terms <span class="text-danger">*</span></label>
							<select id="payment_method" name="payment_method" class="form-control select2" required>
								<option value="">---- Select Payment Method ----</option>
								<?php foreach(payMethodsHelper() as $methods){ ?>
								<option value="<?= $methods->method_name;?>" <?php echo ($methods->method_name == $result['order']['payment_method']) ? "selected":"";?>><?= $methods->method_name;?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-md-6 form-group">
							<label for="date_added">Quotation Date: <span class="text-danger">*</span></label>
							<input type="date" class="form-control" placeholder="Pick Date" name="date_added" value="<?php echo date('Y-m-d', strtotime($result['order']['date_added'])); ?>"  required />
							<p><small>Note: Quotation will be expired after 15 days of date added.</small></p>
						</div>
					</div>
					<!--- Additional Field ---->
					<div class="row">
						<div class="col-md-12 mb-3 form-group">
							<label class="form-label">Delivery Instructions (If any)</label>
							<input id="instruction" name="instruction" type="text" value="<?php echo $result['order']['shipping_instruction']; ?>" class="form-control" />
						</div>
					</div>
					<div class="row d-none" id="manualAddress">
						<div class="col-md-6 mb-3 form-group">
							<label>Deliver To:</label><br>
							<label class="me-2">Label: </label><span id="c_address_label"></span><br/>
							<label class="me-2">Contact Person: </label><span id="c_person_name"></span><br/>
							<label class="me-2">Contact Number: </label><span id="c_contact_number"></span><br/>
							<label class="me-2">Email: </label><span id="c_email_address"></span>
						</div>
						<div class="col-md-6">
							<label class="me-2">Address: </label>
							<span id="c_floor"></span> <span id="c_street_name"></span><br/>
							<span id="c_city_name"></span> <span id="c_country_name"></span>
							<span id="c_zip_code"></span><br>
							Landmark: <span id="c_reference"></span> <span id="c_extension"></span>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
                <button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="demo-form2" class="btn btn-success">Submit</button>
            </div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this->load->view('admin/home/footer');?>

<script type="text/javascript">
	$(document).ready(function(){
		$(document).ajaxStart(function () {
			$("#wait").css("display", "block");
		});
		$(document).ajaxComplete(function () {
			$("#wait").css("display", "none");
		});
		$(document).ajaxError(function () {
			$("#wait").css("display", "none");
		});

		$('.txt_search_po').on('search', function(evt) {
			$(".searchResults").html('');
		});

		get_address_book();

		$(".txt_search_po").keyup(function(){
			var search = $(this).val();
			if(search.length > 2){
				$("#result_box").removeClass("d-none");
				$.ajax({
					url: '<?php echo base_url();?>admin/quotation/get_search_list',
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
								var size_id = response['result'][i]['size_id'];
								var size = response['result'][i]['size'];
								var image = (response['result'][i]['image'] == "") ? "images/image-not-available.jpg" : response['result'][i]['image'];
								$('.searchResults').append('<div class="item-list"><button type="button" data-name="'+name+'" data-arabic="'+arabic_name+'" data-id="'+id+'" data-sku="'+sku+'" data-barcode="'+barcode+'" data-sizeid="'+size_id+'"  data-size="'+size+'" class="item-button btn btn-primary btn-sm">+</button><img src="<?php echo base_url();?>'+image+'" class="img-fluid rounded shadow-sm mr-3" width="40px" style="margin-right: 10px;float: left;min-height: 35px;" /><span class="item-name">'+name+'<br/>SKU - <span>'+sku+'</span></span></div>');

							}
							$('.item-list').on('click', '.item-button', function() {
								var p_name = $(this).data('name');
								var p_id = $(this).data('id');
								var p_sku = $(this).data('sku');
								var arabic_name = $(this).data('arabic');
								var barcode = $(this).data('barcode');
								var size_id = $(this).data('sizeid');
								var size = $(this).data('size');
								addItem(p_id,p_name,barcode,size_id,size);
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
	
	function addItem(p_id,p_name,barcode,size_id,size){
		var order_id = <?php echo $this->input->get('id');?>;
		$.ajax({
			url: '<?php echo base_url();?>admin/quotation/add_product_to_order',
			type: "POST",
			data: {'order_id':order_id,'product_id':p_id,'size_id':size_id,'size':size,'quantity':'1'},
			success: function (data){
				//if(!alert(data)){window.location.reload();}
				window.location.reload()
			},
			error: function (xhr, ajaxOptions, thrownError){
				//alert(JSON.stringify(xhr));
				if(!alert('No result found')){window.location.reload();}
			}
		});
	}
	
	$(document).ready(function(){
		$("#tableOrder").on('click','.btnDelete',function(){
			var rowCount = $('#tableOrder tbody tr').length;
			//alert(rowCount);
			if(rowCount > 1){
				var x = confirm("Are you sure you want to remove this product from order?");
				if(x){
					$("#wait").css("display", "block");
					$(this).closest('tr').remove();
					$('form#updateForm').submit();
					$("#wait").css("display", "none");
				}else{
					$("#wait").css("display", "none");
					return false;
				}
			}else{
				$("#wait").css("display", "none");
				alert("You can't delete all products from quotation.");
				return false;
			}
	    });

		$("#tableOrder").on('change','.updateBtn',function(){
			$("#wait").css("display", "block");
			$('form#updateForm').submit();
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

	function changeStatus(status){
		if(status !== 'undefined' && status !== ''){
			//alert(address_id);
			if(status == 'review'){
				var status_message = '<i class="ti-share font-size-24 text-white bg-info"></i> <br/><br/> Are you sure want to send this quotation for review to customer? <br/> Press below "UPDATE" button to update status!';
			}else if(status == 'reject'){
				var status_message = '<i class="ti-close font-size-24 text-white bg-danger"></i> <br/><br/> Are you sure want to reject this quotation? <br/> Press below "UPDATE" button to update status!';
			}else if(status == 'accept'){
				var status_message = '<i class="ti-check font-size-24 text-white bg-success"></i> <br/><br/> Are you sure want to close this quotation? You can\'t make any changes after this step!<br/> Press below "UPDATE" button to update status!';
			}
			$('.status-modal .modal-body #status_text').html(status_message);
			$('#quotation_status').val(status);
			$(".status-modal").modal('show');
		}else{
			alert('Invalid request id!');
		}
	}

	/*----- Address -----*/

	function get_address_book(){
		var sel_user = <?php echo $result['order']['customer_id']; ?>;
		var sel_address = "<?php echo ($result['order']['address_id'] == '') ? 'NULL' : $result['order']['address_id']; ?>";
		//alert(sel_user);
		$.ajax({
			url: "<?php echo base_url(); ?>admin/quotation/getAddress",
			data: {
				user_id: sel_user
			},
			dataType: "json",
			type: "post",
			success: function(data) {
				//console.log(data);
				var html = '<option value="">Select Address</option>';
		
				if (Object.keys(data).length > 0) {
					$.each(data, function(index, item) {
						var isSelected = (sel_address == item.id ? 'selected' : '');
						html += '<option value="' + item.id + '" ' + isSelected + '>' + item.address_label + ' - ' + item.person_name + '</option>';
					});
				} else {
					var html = '<option value="">No address found</option>';
				}
				$('#address_id').html(html);
			}
		});
	}

	$('#address_id').on('change', function() {
		var address_id = $(this).find('option:selected').val();
		//alert(address_id);
		get_address_detail(address_id);
	});

	function get_address_detail(u){
		$.ajax({
			url: '<?php echo base_url();?>admin/quotation/address_detail',
			type: "POST",
			data: {'id':u},
			success: function(data){ 
				var result = JSON.parse(data);
				console.log(result);
				//alert(result.vendor_name);
				if(result){
					$('#manualAddress').removeClass('d-none');
					$("#c_address_label").html(result.address_label);
					$("#c_person_name").html(result.person_name);
					$("#c_contact_number").html(result.mobile + ', ' + result.phone + ', ' + result.extension);
					$("#c_email_address").html(result.email);
					$("#c_floor").html(result.address_type + '-' + result.building_villa_no + ',');
					$("#c_street_name").html(result.street + ',');
					$("#c_city_name").html(result.city + ',');
					$("#c_country_name").html(result.country);
					$("#c_zip_code").html(result.postal);
					$("#c_reference").html(result.reference + ',');
				}else{
					alert('Data not found');
					$("#c_address_label").html('');
					$("#c_person_name").html('');
					$("#c_contact_number").html('');
					$("#c_email_address").html('');
					$("#c_floor").html('');
					$("#c_street_name").html('');
					$("#c_reference").html('');
					$("#c_city_name").html('');
					$("#c_country_name").html('');
					$("#c_zip_code").html('');
				}
			},
			error: function(data){
				alert(data);
			}
		});
	}
</script>
