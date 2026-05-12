<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Apni Kirana | Checkout</title>
<meta name="description" content="Apni Kirana - Guest Checkout" />
<meta name="keywords" content="Apni Kirana - Guest Checkout" />
<base href="<?php echo base_url();?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" media="all" href="css/newcss.css" />
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico"/>
<?php $canonical = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
<link rel="canonical" href="<?php echo $canonical ?>" />
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="css/cartcss.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- End Facebook Pixel Code -->
<script src="js/jquery.min.js"></script>
<script type="text/javascript">jQuery.noConflict(); (function ($) { function readyFn() { $(function() { $('nav#menu').mmenu({ extensions	: [ 'effect-slide-menu', '' ], searchfield:false, counters:true, navbar:{ title:'Shop By Category' }, navbars:[ { position:'top', content :[ 'searchfield'] },{ position:'top', content:[ 'prev', 'title', 'close' ] }, ] }); }); } $(document).ready(readyFn); })(jQuery);</script>

<style>
.head_text{
	font-family: canela wf,sans-serif;
    font-size: 18px;
    line-height: 22px;
    letter-spacing: .02em;
    text-transform: capitalize;
	margin: 30px 0 20px;
	padding-left:15px;
}
span.info_text{
	font-family: verlag wf,sans-serif;
    font-size: 16px;
    line-height: 22px;
    letter-spacing: .02em;
	padding-left:15px;
}
.form-control{
	border-radius:0!important;
}
</style>

</head>

<body class="no-pt transparent-header page-layout-home-page">
<div class="page-wrap">

<div class="header_hading">
<div class="col-sm-5 col-xs-12 heading_had"><a href="cart">&laquo; Back to shopping bag</a></div>
<div class="col-sm-7 col-xs-12"><a class="" href="<?php echo base_url()?>" title="Apni Kirana"><img src="<?php echo base_url()?>images/logo.jpg" alt="Apni Kirana" class="" ></a></div>

</div>
<?php //echo '<pre>';print_r($cod_avl);exit(); ?>
<div class="clearfix"></div>
<div class="">

<div class="container wrappad">
<div class="col-sm-8 wrappad" style="padding-left:0px;">
<div style="font-size:16px;font-weight:700;padding-bottom:10px;">
	<marquee width="100%" direction="left" height="25px" scrolldelay="200">
		<a href="javascript:void(0)">Guaranteed Delivery within 24 hrs.</a>
	</marquee>
</div>
<legend>Checkout</legend>
		
<div class="panel-group" id="accordion">


<div class="panel panel-default active" id="a2">

<div class="panel-heading">
    <h4 class="panel-title">
	<a href="#delivery-address" onclick="trigger_accor('a2')" class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" aria-expanded="false"><strong>STEP 1 : Guest Checkout</strong> <i class="fa fa-caret-down bordernone"></i></a></h4>
 </div>  
  
<div id="delivery-address" class="panel-collapse collapse in">
<div class="panel-body">
	 <?php echo form_open("order/set_guestcheckout", array("id"=>"address_form"));?>
			
		<div class="head_text">Contact Information</div>
		
		<div class="form-group col-sm-12">
			<label>Email</label>
			<input type="email" name="email" maxlength="255" required class="form-control" />
		</div>
		
		<div class="col-sm-12 webcontent">Check out as a guest, or create an account at the end of checkout if you do not already have one.</div>
		<br/><br/>
		<div class="col-sm-12 webcontent">Already have an account? <a href="login?auth=<?php echo md5(time()."jbng5453zfb3z"); ?>&arial_path=checkout">Sign In</a></span>
		
		<div class="head_text">Shipping Address</div>
		<div class="form-group col-sm-6">
			<label>Name</label>
			<input type="text" name="name" maxlength="120" required class="form-control" />
		</div>
		
		<div class="form-group col-sm-6">
			<label>Contact Number</label>
			<input id="number" type="text" name="mobile" minlength="10" maxlength="12"  required class="form-control" />
			<span id="errmsg" style="color: red;font-size: 11px;"></span>
		</div>
		
		
		<div class="form-group col-sm-12">
			<label>Flat, House No., Building, Company, Apartment</label>
			<input type="text" name="address1" required class="form-control" />
		</div>
		
		<div class="form-group col-sm-6">
				<label>Postal Code</label>
				<input type="text" name="postal" id="newpostal" minlength="6" maxlength="6" required class="form-control" />
		</div>
		
		<input type="hidden" name="region" id="new_region" required />
		<input type="hidden" name="area" id="new_area1" required />
		<input type="hidden" name="svc" id="new_svc" required />
		<input type="hidden" name="edp" id="new_edp" required />
		
		<div class="form-group col-sm-6">
			<label>Area, Colony, Street, Sector, Village</label>
			<input type="text" name="address2" required id="new_area" class="form-control" readonly />
		</div>
		<p class="zip-error1" id="zip-error1" style="color:red;padding-left: 20px;"></p>
		<div class="form-group col-sm-6">
			<label>City</label>
			<input type="text" name="city" required id="new_city" class="form-control" readonly />
		</div>
		
		<div class="form-group col-sm-6">
			<label>State</label>				
			<input type="text" name="state" required id="new_state" class="form-control" readonly />
		</div>
		
		<div class="form-group col-sm-6">
			<label>Country</label>
			<select name="country" required class="form-control">
				<option value="91">INDIA</option>
			</select>
		</div>
		
		<div class="col-sm-12">
		    <input class="btn btn-primary" type="submit" id="address_form_submit" value="Continue to Payment" disabled="disabled"/ >
		</div>
		
	<?php echo form_close(); ?>

</div> 
  
  
</div>



</div>


 
<div class="panel panel-default" id="a4">

<div class="panel-heading">
    <h4 class="panel-title">
	<strong>STEP 2: PAYMENT METHOD</strong></h4>
 </div>  
  
<div id="step4" class="panel-collapse collapse">
<div class="panel-body">
<div class="col-sm-12 webcontent">
<!--div class="webcontent"> *For <strong style="color: #D32C84;">International Payments</strong> Please Choose <strong style="color: #D32C84;">PayPal</strong></div>
<hr/-->
<div class="col-sm-12 col-md-4 col-lg-4"><label for="paytm-online"><div class="paymentlogo"><input name="payment" type="radio" value="5" id="paytm-online"> <img src="images/paytm-online.jpg"></div></label></div>
<?php if($cod_avl > 0){ ?>
<div class="col-sm-12 col-md-4 col-lg-4"><label for="cod"><div class="paymentlogo"><input name="payment" type="radio" value="4" id="cod"> <img src="images/cash-on-arrival.jpg"></div></label></div>
<?php } ?>
<!--<div class="col-sm-4"><label for="paytm"><div class="paymentlogo"><input name="payment" type="radio" value="2" id="paytm"> <img src="images/paytm-on-arrival.jpg"></div></label></div>
<div class="col-sm-4"><label for="paypal"><div class="paymentlogo"><input name="payment" type="radio" value="3" id="paypal"><img src="images/paypal-d2112127c6.png"></div></label></div-->
<div class="col-sm-12 col-md-12 col-lg-12" id="place_order" style="padding-top: 12px;"><button class="btn btn-primary btn-md">PLACE ORDER</button></div>
</div>
</div>
</div> 
  
</div>




</div>

</div>				
</div>				
		
					
					
<div class="col-sm-4 none_320 wrappad">
<?php $total = 0;
	foreach($result->result() as $result1){
	$ttot = $result1->price * $result1->quantity;
	$total = $total + $ttot; 
	} 
 
 if($this->session->userdata('promotion_code')){
$promotion_code = $this->session->userdata('promotion_code');
$discount_amount = $promotion_code['discount_amount'];
$code = $promotion_code['code'];
}
else{
$discount_amount = 0;
$code = '';
}
$total_after_promo = $total - $discount_amount;
//$shipping = $total_after_promo >= 1500 ? 0 : 90;
$shipping = 49;
/*
$shipping = $total_after_promo >= 1499 ? 0 : 49;

if($total_after_promo <= 750){
	$shipping = 199;
}elseif($total_after_promo >= 751 && $total_after_promo <= 2500){
	$shipping = 149;
}elseif($total_after_promo >= 2501 && $total_after_promo <= 5000){
	$shipping = 99;
}else{
	$shipping = 49;
}*/
?>
<div class="cart-summary">
<div class="cart-summary-wrap" role="tablist"><h2 class="summary title">Summary</h2> 
<div id="block-shipping" class="block shipping">
<div id="block-summary" class="content">

			</div>
			</div>
			<div id="cart-totals" class="cart-totals">
<div class="table-wrapper">
  <dl class="dl">
<dt>Product Amount</dt>
<dd><?php echo $this->customer->getRealRate($total_after_promo);?></dd>

<?php if($this->session->userdata('promotion_code')){ ?>
<dt>Discount(<?php echo $promotion_code['code']; ?>)</dt>
<dd><?php echo $this->customer->getRealRate($discount_amount);?></dd>
<?php } ?>

<dt>Shipping</dt>
<dd><?php echo $this->customer->getRealRate($shipping);?></dd>

<dt class="total">Grand Total</dt>
<dd class="total"><?php echo $this->customer->getRealRate($total_after_promo + $shipping);?></dd>

  </dl>
</div>
</div> 

</div>





 </div>
 
 
 <div class="cart-summary">
<div class="cart-summary-wrap" role="tablist"><h2 class="summary title">My Cart</h2> 
<div id="block-shipping" class="block shipping">
<div id="block-summary" class="content">

			</div>
			</div>
			<div id="cart-totals" class="cart-totals">
<div class="table-wrapper">
     <table class="right_bag" style="width:100%">
      <?php foreach($result->result() as $result){ ?>
    	<tr>
    	<td width="75%" valign="top" style="padding:7px;">
    	<a href="<?php echo $result->seo;?>"><?php echo $result->name;?></a><br/>
    	Size : <?php echo $result->size;?><br/>
    	<?php echo $result->quantity;?> x <?php echo $result->price;?><td>
    	<td width="20%" valign="top" align="right">
    	<?php echo $this->customer->getRealRate($result->price * $result->quantity);?><td>
    	
    	</tr>
      <?php } ?>
     </table>
</div>
</div> 

</div>

 </div>

</div>

</div>

<script>
jQuery(".zip-error").hide();
jQuery(".zip-error1").hide();

$(document).ready(function(e) {
	
	function is_int(value){ 
	  if ((parseFloat(value) == parseInt(value)) && !isNaN(value)) {
		return true;
	  } else { 
		return false;
	  } 
	}

	$("#newpostal").keyup(function() {
		var el = $(this);
		if ((el.val().length == 6) && (is_int(el.val()))) {
			//alert(el.val());
			$.ajax({
			url: "<?php echo base_url();?>home/check_delivery",
			cache: false,
			dataType: "json",
			type: "POST",
			data: "pin_code=" + el.val(),
			success: function(result, success) {
				//console.log(result.result['area']);
				if(result['success'] > 0){
					$(".zip-error1").hide(); /* In case they failed once before */
					$("#new_area").val(result.result['area_name']);
					$("#new_city").val(result.result['city']);
					$("#new_state").val(result.result['state']);
					$("#new_region").val(result.result['region']);
					$("#new_area1").val(result.result['area']);
					$("#new_svc").val(result.result['svc']);
					$("#new_edp").val(result.result['edp']);
					$('#address_form_submit').removeAttr("disabled");
				}else{
					$("#address_form_submit").prop("disabled", true);
					$(".zip-error1").show();
					$('#zip-error1').html(result['message']);
				}
			},
			error: function(result, success) {
				$("#address_form_submit").prop("disabled", true);
				$(".zip-error1").show();
				$('#zip-error1').html(result['message']);
			}

		});
		}
	});
	
	$("#place_order").on('click', function(){
	    //var orderConfirm = confirm("Want to proceed the order?");
		var paymenttype = $("input[name='payment']:checked").val();
        if(paymenttype > 0) {
    		if(paymenttype == 1){
    			location.href = '<?php echo base_url();?>order/cod_confirm_order?type=Card On Arrival';
    		} else if(paymenttype == 2){
    			location.href = '<?php echo base_url();?>order/cod_confirm_order?type=PayTM On Arrival';
    		} else if(paymenttype == 3){
    			alert("Not Installed");
    			//location.href = '<?php echo base_url();?>paypal/buy';
    		} else if(paymenttype == 4){
    			location.href = '<?php echo base_url();?>order/cod_confirm_order?type=Cash On Arrival';
    		}else if(paymenttype == 5){
    			location.href = '<?php echo base_url();?>paytm/paytm';
    		} else{
    			alert("Not Installed");
    			//location.href = '<?php echo base_url();?>order/pay_confirm_order';
    		}
        }else{
			alert('Please select payment method');
            return false;
        }
	});
	
	$('#address_form').on('submit', (function(e) {
		e.preventDefault();
        $.ajax({
        url: '<?php echo base_url();?>order/set_guestcheckout',
        type: "POST",
        data:  new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success: 
        //showResponse,
         function(data){
        	$('#step4').parent().find('.panel-heading .panel-title').html('<a href="#step4" onclick="trigger_accor(\'a4\')" class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" aria-expanded="false"><strong>STEP 2: Payment Method</strong> <i class="fa fa-caret-down bordernone"></i></a>');
        	$('a[href="#step4"]').trigger('click');
        },
        error: function(){}
        });
    }));
});

var trigger_accor = function(u){
	$(".panel").removeClass('active');
	$("#"+u).addClass('active');
}

$(document).ready(function(){
	$("#number").on("keypress",function(e){
		if($(this).val().length<='12'){
			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				
				$("#errmsg").html("Digits Only").show();
				return false;
			}
		}else{
				$("#errmsg").html("Maximum input 12 Digits Only").show();
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

</script>

</body>
</html>