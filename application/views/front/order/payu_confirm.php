<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<html lang="en" class="loading">
    <head>
        <meta charset="utf-8">
        <link rel="icon" href="favicon.png">
        <title>Payumoney Codeigniter</title>   
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
         
    </head>
    <body>
        <div class="container">
            <div class="row" style="text-align:center;">
				<h2>You are redirecting to pay u money..</h2>
                <div class="col-md-2"></div>  
                <div class="col-md-8">
                	  <form action="<?= $action; ?>/_payment" method="post" id="payuForm" name="payuForm" style="display:none;">
                        <input type="text" name="key" value="<?= $mkey ?>" />
                        <input type="text" name="hash" value="<?= $hash ?>"/>
                        <input type="text" name="txnid" value="<?= $tid ?>" />
                        <input type="text" name="abc" value="<?= $abc ?>" />
      
                        <div class="form-group">
                            <label class="control-label">Total Payable Amount</label>
                            <input class="form-control" name="amount" value="<?= $amount ?>"  readonly/>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Your Name</label>
                            <input class="form-control" name="firstname" id="firstname" value="<?= $name ?>" readonly/>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <input class="form-control" name="email" id="email" value="<?= $mailid ?>" readonly/>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Phone</label>
                            <input class="form-control" name="phone" value="<?= $phoneno ?>" readonly />
                        </div>
                        <div class="form-group">
                            <label class="control-label"> Booking Info</label>
                            <textarea class="form-control" name="productinfo" readonly><?= $productinfo ?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Address</label>
                            <input class="form-control" name="address1" value="<?= $address ?>" readonly/>     
                        </div>
                        <div class="form-group">
                            <input name="surl" value="<?= $sucess ?>" size="64" type="hidden" />
                            <input name="furl" value="<?= $failure ?>" size="64" type="hidden" />                             
                            <input type="hidden" name="service_provider" value="<?= $service_provider ?>" size="64" /> 
                            <input name="curl" value="<?= $cancel ?> " type="hidden" />
                        </div>
                        <div class="form-group text-center">
                        <input type="submit" value="Pay Now" class="btn btn-success" /></td>
                        </div>
                    </form>                                  
                </div>
                <div class="col-md-2"></div>
            </div>
        </div> 
	<script>
	window.onload = function(){
		document.forms['payuForm'].submit();
	}
	</script>
		
    </body>
</html>    
