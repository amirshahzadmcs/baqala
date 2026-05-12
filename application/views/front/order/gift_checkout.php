<?php $this->load->view("front/common/header");?>
<style>
.custom-checkbox .custom-control-input:indeterminate~.custom-control-label::before {
    border-color: #2dab48;
    background-color: #ffffff;
}
.custom-control-label::before {
    position: absolute;
    top: 0rem !important;
    left: -1.3rem !important;
}
.custom-control-label::after {
    position: absolute;
    top: 0rem !important;
    left: -1.3rem !important;
}
.custom-checkbox .custom-control-label::before {
    border-radius: 50%;
}
</style>
<div class="osahan-payment">
    <div class="p-3 border-bottom fixed-top" style="background-color:#f0f2f5">
        <div class="d-flex align-items-center">
            <a class="font-weight-bold text-success text-decoration-none" onclick="goBack()" href="javascript:void(0)"> <i class="icofont-rounded-left back-page"></i></a>
            <h6 class="font-weight-bold m-0 ml-3">Checkout</h6>
            <a class="toggle ml-auto" href="#"><i class="icofont-navigation-menu"></i></a>
        </div>
    </div>
	<div class="address px-2 pt-2 pb-0" style="margin-top:3.5rem">
		<div class="bg-white p-3">
			<p class="m-0 text-dark d-flex align-items-center">Hello, <strong> &nbsp;<?php echo $personal->name;?></strong></p>
		</div>
	</div>
	<div class="address px-2 pt-2 pb-0">
		<div class="bg-white p-3">
			<div class="d-flex align-items-center">
				<p class="mb-2 font-weight-bold">Recipient Detail:</p>
			</div>
			<p class="small text-muted m-0"><b>Name: <?php echo $recipient_name; ?></b></p>
			<p class="small text-muted m-0">Email: <?php echo $g_to; ?></p>
			<p class="small text-muted m-0">Message: <?php echo $g_message; ?></p>
			<p class="small text-muted m-0">Sender Name: <?php echo $g_from; ?></p>
		</div>
	</div>
	<div class="address px-2 pt-2 pb-0">
		<div class="bg-white p-3">
			<div class="cart-items bg-white position-relative border-bottom w-100">
				<div class="d-flex align-items-center p-1">
					<a href="product/<?php echo $prod_detail->seo;?>"><img src="<?php echo ($prod_detail->image == "" OR !file_exists($prod_detail->image)) ? 'images/notfound.jpg':$prod_detail->image;?>" class="img-fluid" /></a>
					<a class="ml-3 text-dark text-decoration-none w-100">
						<p class="mb-1"><?php echo $prod_detail->name;?> / <?php echo $prod_detail->name_hindi;?></p>
						<p class="text-muted mb-2">
							<span class="text-success mr-1">
								<del><?php echo $prod_detail->real_price;?> </del> &nbsp;&nbsp;
								<span class="text-success"><?php echo $prod_detail->price;?> SAR /<?php echo $prod_detail->size; ?></span>
							</span>
						</p>
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="pt-3 px-3">
		<h6 class="font-weight-bold">Select Payment Method</h6>
	</div>
	<div class="address px-2 pb-0">
		<div class="osahan-card rounded shadow-sm bg-white mb-2">
			<div class="osahan-card rounded shadow-sm bg-white mb-2">
			   <div class="osahan-card-header" id="headingWallet">
				  <h2 class="mb-0">
					 <button class="d-flex p-3 align-items-center btn text-decoration-none text-success w-100" type="button" data-toggle="collapse" data-target="#collapseWallet" aria-expanded="false" aria-controls="collapseWallet">
					 <i class="icofont-wallet mr-3"></i> Use Wallet
					 <i class="icofont-rounded-down ml-auto"></i>
					 </button>
				  </h2>
			   </div>
			   
			   <div id="collapseWallet" class="collapse show" aria-labelledby="headingWallet" data-parent="#accordionExample">
				  <div class="border-top">
					 <div class="card-body">
						<div style="margin-bottom: 15px;font-size: 20px;">
							<strong><i class="icofont-wallet text-info" style="font-size: 25px;"></i> &nbsp;&nbsp; <?php echo $personal->wallet;?> SAR</strong>
						</div>
						<?php if($personal->wallet > 0){?>
						<div>
							<label class="form-label" for="wallet_checkbox">
								<input name="wallet" type="checkbox" value="<?php echo $personal->wallet; ?>" id="wallet_checkbox" style="width: 20px;height: 17px;vertical-align: sub;"> 
								<strong>&nbsp;&nbsp;&nbsp;Use wallet money</strong>
							</label>
						</div>
						<div id="walletmsg" class="text-danger"></div>
						<?php } ?>
					 </div>
				  </div>
			   </div>
			</div>
		</div>
		
	</div>
	<!--
    <div class="payment px-2 pt-0 other-payment-method">
        <div class="accordion" id="accordionExample">
            <div class="osahan-card rounded shadow-sm bg-white mb-2">
                <div class="osahan-card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button
                            class="d-flex p-3 align-items-center border-0 btn btn-outline-success bg-white text-decoration-none text-success w-100"
                            type="button"
                            data-toggle="collapse"
                            data-target="#collapseOne"
                            aria-expanded="true"
                            aria-controls="collapseOne"
                        >
                            <i class="icofont-credit-card mr-3"></i> Credit/Debit Card/Online Banking
                            <i class="icofont-rounded-down ml-auto"></i>
                        </button>
                    </h2>
                </div>
                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="osahan-card-body p-3 border-top">
						<div class="mr-sm-2">
							<label for="online-payment">
								<input name="payment" type="checkbox" value="1" id="online-payment" style="width: 20px;height: 17px;vertical-align: sub;">
								<b>Pay Online</b><br>
								<img src="images/payumoney.png" alt="Telr Payment" class="my-2">
								<p class="small text-muted m-0">WE ACCEPT <span class="osahan-card ml-1 font-weight-bold">( Master Card / Visa Card / Rupay )</span></p>
							</label>
						</div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    -->
</div>
<!-- continue -->
<div class="fixed-bottom">
    <button type="submit" id="place_order" class="btn btn-success btn-block">Continue</button>
</div>

<?php $this->load->view("front/common/footer");?>
<script>
$(".zip-error").hide();
$(".zip-error1").hide();

$(document).ready(function(e) {
	
	function is_int(value){ 
	  if ((parseFloat(value) == parseInt(value)) && !isNaN(value)) {
		return true;
	  } else { 
		return false;
	  } 
	}
	
	$(document).on('change', '#wallet_checkbox', function(){
		if ($('#wallet_checkbox').prop('checked')==true){
			var product_price = <?php echo $prod_detail->price; ?>;
			var wallet_bal = <?php echo $personal->wallet; ?>;
			if(product_price > wallet_bal){
				$("#walletmsg").html("Insufficient balance in your wallet, select another payment also.").show();
				$('.other-payment-method').show();
			}else{
				$('.other-payment-method').hide();
			}
		}else{
			$('.other-payment-method').show();
		}
	});
	
	$(document).on('change', '#online-payment', function(){
		var selected_payment = $("input[name='payment']:checked").val();
		$("#walletmsg").html("").hide();
		if(selected_payment == 6){
			$("input[name='wallet']").prop('checked', false);
			$('#collapseWallet').hide();
		}else{
			//$("input[name='wallet']").prop('checked', false);
			$('#collapseWallet').show();
		}
	});
	
	$("#place_order").on('click', function(){
		var product_price = <?php echo $prod_detail->price; ?>;
		var wallet_bal = <?php echo $personal->wallet; ?>;
		var iswallcheck = 0;
		var paymenttype = $("input[name='payment']:checked").val();
		if ($('#wallet_checkbox').prop('checked')==true){
			var iswallcheck = 1;
		}
		//alert(paymenttype);
		if(iswallcheck > 0){
			if(product_price <= wallet_bal){
				if(wallet_bal > 0){
					location.href = '<?php echo base_url();?>Wallet/gift_buy?wallet='+iswallcheck;
				}else{
					alert('Please select payment method');
					return false;
				}
			}else{
				if(paymenttype > 0){
					if(paymenttype == 1){
						location.href = '<?php echo base_url();?>Telr2/buy?wallet='+iswallcheck;
					}else{
						alert("Not Installed");
					}
				}else{
					alert('Please select payment method');
					return false;
				}
			}
		}else{
			if(paymenttype > 0){
				if(paymenttype == 1){
					location.href = '<?php echo base_url();?>Telr2/buy?wallet='+iswallcheck;
				}else{
					alert("Not Installed");
				}
			}else{
				alert('Please select payment method');
				return false;
			}
		}
	});
	

	$("#number").on("keypress",function(e){
		if($(this).val().length<='12'){
			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				
				$("#errmsg").html("Digits Only").show();
				return false;
			}
		}else{
			$("#errmsg").html("Input  14 Digits Only").show();
			return false;
		}
	});
	
	$("#form_mobile").on("keypress",function(e){
		if($(this).val().length<='12'){
			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				
				$("#errmsg1").html("Digits Only").show();
				return false;
			}
		}else{
			$("#errmsg1").html("Maximum input 12 Digits Only").show();
			return false;
		}
	});
	
	$("#postal").on("keypress",function(e){
		if($(this).val().length<='6'){
			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				
				$("#errpost").html("Digits Only").show();
				return false;
			}
		}else{
				$("#errpost").html("Maximum input 6 Digits Only").show();
				return false;
		}
	});
});

var get_address_ajax = function(){
	$.ajax({
	url: '<?php echo base_url();?>order/get_address_ajax',
	type: "GET",
	success: 
	 function(data){
		 $('#address_checkout_ajax').html(data);
		 },
	error: function(){}
	});
}

var trigger_accor = function(u){
	$(".panel").removeClass('active');
	$("#"+u).addClass('active');
}

var set_delievery = function(shipping){
	$.ajax({
	url: '<?php echo base_url();?>order/set_delievery_address',
	type: "POST",
	data: {'id':shipping},
	success: 
	//showResponse,
	 function(data){
		get_address_ajax();
		$('#step4').parent().find('.panel-heading .panel-title').html('<a href="#step4" onclick="trigger_accor(\'a4\')" class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" aria-expanded="false"><strong>STEP 4: Payment Method</strong> <i class="fa fa-caret-down bordernone"></i></a>');
			$('a[href="#step4"]').trigger('click');
	},
	error: function(){}
	});
}

var edit_address = function(u){
	$.ajax({
	url: '<?php echo base_url();?>account/get_address',
	type: "POST",
	data: {'id':u},
	success: function(data){ 
		var result = JSON.parse(data);
		$("#form_id").val(result['id']);
		$("#form_name").val(result['name']);
		$("#form_mobile").val(result['mobile']);
		$("#form_address1").val(result['address1']);
		$("#form_address2").val(result['address2']);
		$("#form_city").val(result['city']);
		$("#form_state").val(result['state']);
		$("#form_postal").val(result['postal']);
		$("#addressModal").modal("show");
	},
	error: function(){}
	});
}

var delete_address = function(u){
	$.ajax({
		url: '<?php echo base_url();?>account/delete_address',
		type: "POST",
		data: {'id':u},
		success: function(data){ 
			location.reload();
		},
		error: function(){}
	});
	 
}
function goBack() {
	window.history.back();
}

</script>