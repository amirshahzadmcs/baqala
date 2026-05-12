<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ae">
    <head>
        <meta charset="UTF-8" />
        <meta content="" name="description" />
        <meta content="IE=edge" http-equiv="X-UA-Compatible" />
        <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport" />
        <title>Retailer Invoice - Baqala Station</title>
        <style>
            body {
                font-size: 8px;
            }
            hr {
                border-top: 5px solid #000000 !important;
            }
        </style>
    </head>

    <body>
    <div>
        <table>
            <tr>
                <td>
                    <?php $this->load->helper('text'); ?>
                    <img src="<?= base_url('admin_assets/images/invoice/retailer/header-top.png');?>" style="100%" />
        
                    <table style="width: 100%; font-size: 8px;">
                            <tr style="text-align: center;">
                                <td style="margin: 0px; font-size: 12px;border-top:1px solid #000;border-bottom:1px solid #000">TAX INVOICE</td>
                            </tr>
                    </table>
                    
                    <table style="width: 100%; font-size: 10px;">
                            <tr>
                                <td><b style="font-weight:bold">Slip No :</b> <?php echo $result['order']['invoice_prefix'] .'-'. $result['order']['order_no'];?></td>
                            </tr>
                            <tr>
                                <td><b>Staff :</b> <?php $admin_id= $this->session->userdata('admin_id'); echo $this->admin->adminName($admin_id)->name;?></td>
                            </tr>
                            <tr>
                                <td><b>Date :</b> <?php if(!empty($result['order']['date_modified'])){ echo date('d-m-Y H:i:s', strtotime($result['order']['date_modified'])); }else{ echo 'N/A'; } ?></td>
                            </tr>
                    </table>
                    
                    <table width="100%" cellspacing="0" cellpadding="2" style="margin: 5px 0; font-size: 8px;">
                            <tr>
                                <td valign="top" style="width: 56%; font-size: 10px; font-weight: bold;border-top:1px solid #000;border-bottom:1px solid #000">Items </td>
                                <td valign="top" style="width: 10%; text-align: center; font-size: 10px; font-weight: bold;border-top:1px solid #000;border-bottom:1px solid #000"><b>Qty</b></td>
                                <td valign="top" style="width: 14%; text-align: center;font-size:10px font-weight: bold;border-top:1px solid #000;border-bottom:1px solid #000 "><b>Price</b></td>
                                <td valign="top" style="width: 19%; text-align: right; font-size: 10px; font-weight: bold;border-top:1px solid #000;border-bottom:1px solid #000"><strong>Amount</strong></td>
                            </tr>
                            
                            <?php 
                    			$total_qty =0;$i = 1;$amt_exl_vat = 0;$amt_incl_vat = 0;$total_vat = 0;$saving = 0;$ptotal = 0;$mrp = 0;$real_price = 0;$savings =0;
                    			foreach($result['product'] as $product){
                    			$real_price = $product['real_price']; 
                    			$p_price = ($product['discounted_price'] == 0) ? $product['real_price'] : $product['discounted_price'];
                    			//$vat_initial = ($product['gst_rate'] / 100) * $p_price;
                    			$initial_price = $product['order_price'] - $product['vat_price'];
                    			$total_qty += $product['quantity'];
                    			$total_vat += $product['vat_price'];
                    			$mrp += $real_price;
                    			$savings += ($real_price - $p_price)*$product['quantity'];
                    			$amt_exl_vat += $product['order_price'] - $product['vat_price'];
                    			$amt_incl_vat += $product['order_price'];
                    		?>
                            <tr>
                                <td valign="top" style="text-align: left;"><?php if(!empty($product['barcode'])){ echo $product['barcode']; ?>
                                <br /><?php } ?><?php echo $product['product_name'];?>
                                <br /><?php echo $product['arabic_name'];?>
                                </td>
                                <td valign="top" style="text-align: center;"><?php echo $product['quantity'];?></td>
                                <td valign="top" style="text-align: center;"><?php echo sprintf("%.2f",$p_price); ?></td>
                                <td valign="top" style="text-align: right;"><?php echo sprintf("%.2f", $product['order_price']); ?></td>
                            </tr>
                            <?php $i++;} ?>
                    </table>
        
                    <table width="100%" cellspacing="0" cellpadding="2" style="font-size: 10px;border-top:1px solid #000;border-bottom:1px solid #000">
                        
                            <!--
        			<tr style="text-align: center;">
        			<td style="width: 50%; text-align: left;"><h2 style="margin:0px; font-size: 9px"> Total Items  : </h2></td>
        			<td style="width: 50%; text-align: left;"><h2 style="margin:0px; font-size: 9px"><?php //echo count($result['product']); ?></h2></td>
        			</tr>
        			-->
                            <tr>
                                <td style="width: 50%; text-align: left; font-size: 10px;">Number of Items :</td>
                                <td style="width: 50%; text-align: right; font-size: 10px;"><?php echo $total_qty; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 50%; text-align: left; font-size: 10px;">Total Amount :</td>
                                <td style="width: 50%; text-align: right; font-size: 10px;"><?php echo sprintf("%.2f", $amt_incl_vat); ?></td>
                            </tr>
                            <!--
        			<tr style="text-align: center;">
        			<td style="width: 50%; text-align: left;"><h2 style="margin:0px; font-size: 9px"> Price  : </h2></td>
        			<td style="width: 50%; text-align: left;"><h2 style="margin:0px; font-size: 9px"><?php //echo sprintf("%.2f",$amt_exl_vat); ?> SAR</h2></td>
        			</tr>
        			<tr  style="text-align: center;">
        			<td style="width: 50%; text-align: left;"><h2 style="margin:0px; font-size: 9px"> Vat (15%)  : </h2></td>
        			<td style="width: 50%; text-align: left;"><h2 style="margin:0px; font-size: 9px"><?php //echo sprintf("%.2f",$total_vat); ?>  SAR</h2></td>
        			</tr>
        			
        			<tr style="text-align: center;">
        			<td style="width: 50%; text-align: left; "><h2 style="margin:0px; font-size: 9px"> Shipping : </h2></td>
        			<td style="width: 50%; text-align: left;"><h2 style="margin:0px; font-size: 9px"><?php //echo $result['order']['shipping_charge']; ?> SAR</h2></td>
        			</tr>
        			
        			<?php if($result['order']['promo_code_price'] > 0){ ?>
        			<tr style="text-align: center;">
        				<td style="width: 50%; text-align: left; "><h2 style="margin:0px; font-size: 9px"> Discount : </h2></td>
        				<td style="width: 50%; text-align: left;"><h2 style="margin:0px; font-size: 9px"><?php echo $result['order']['promo_code_price']; ?> SAR</h2></td>
        			</tr>
        			<?php } ?>
        			<?php if($result['order']['cashback_applied'] > 0){ ?>
        			<tr style="text-align: center;">
        				<td style="width: 50%; text-align: left; "><h2 style="margin:0px; font-size: 9px"> Rewards Applied : </h2></td>
        				<td style="width: 50%; text-align: left;"><h2 style="margin:0px; font-size: 9px"><?php echo $result['order']['cashback_applied']; ?> SAR</h2></td>
        			</tr>
        			<?php } ?>
        			<?php if($result['order']['wallet_applied'] > 0){ ?>
        			<tr style="text-align: center;">
        				<td style="width: 50%; text-align: left; "><h2 style="margin:0px; font-size: 9px"> Wallet Applied : </h2></td>
        				<td style="width: 50%; text-align: left;"><h2 style="margin:0px; font-size: 9px"><?php echo $result['order']['wallet_applied']; ?> SAR</h2></td>
        			</tr>
        			<?php } ?>
        			-->
                    </table>
                    
                    <table width="100%" cellspacing="0" cellpadding="2" style="font-size: 10px;border-top:1px solid #000;border-bottom:1px solid #000">
                        <tr>
                            <td valign="top" style="width: 25%; text-align: center; font-size: 10px;"><strong>VAT% </strong></td>
                            <td valign="top" style="width: 25%; text-align: right; font-size: 10px;"><strong> Net. Amt</strong></td>
                            <td valign="top" style="width: 25%; text-align: right; font-size: 10px;"><strong>VAT</strong></td>
                            <td valign="top" style="width: 25%; text-align: right; font-size: 10px;"><strong>Amount</strong></td>
                        </tr>
                        <tr>
                            <td style="text-align: center; font-size: 10px;">15</td>
                            <td style="text-align: right; font-size: 10px;"><?php echo sprintf("%.2f",$amt_exl_vat); ?></td>
                            <td style="text-align: right; font-size: 10px;"><?php echo sprintf("%.2f",$total_vat); ?></td>
                            <td style="text-align: right; font-size: 10px;"><?php echo sprintf("%.2f", $amt_incl_vat); ?></td>
                        </tr>
                    </table>
                    
                    <table>
                        <tr style="text-align: center;">
                            <td style="width: 100%; text-align: center; font-size: 10px;">Thank You For Shopping With Us</td>
                        </tr>
                    </table>
                    <!--
                    	<table style="width: 100%;">
                    		<tbody>
                    		    <tr><td></td><td></td></tr>
                    			<tr style="text-align: center;">
                    				<td style="width: 50%; text-align: left;"><h2 style="margin:0px; font-size: 10px">PAYABLE AMOUNT  : </h2></td>
                    				<td style="width: 50%; text-align: left;"><h2 style="margin:0px; font-size: 10px"> <?php $net_amt = $result['order']['order_total']; echo sprintf("%.2f",$net_amt);?> SAR</h2></td>
                    			</tr>
                    			<tr><td></td><td></td></tr>
                    		</tbody>
                    	</table>
                    	
                    	<hr><br/>
                    	
                    	<table style="width: 100%; padding-bottom: 20px;">
                    		<tbody>
                    			<tr style="text-align: center;">
                    				<td style="width: 100%; text-align: left;"><p style="margin:0px; font-size: 10px">Net Payable Amount : <?php $net_payble_amt = $result['order']['net_payble_amt']; echo sprintf("%.2f",$net_payble_amt);?> SAR</p></td>
                    			</tr>
                    		</tbody>
                    	</table>
                    	-->
                    <table>
                        <tr style="text-align: center;">
                            <td style="width: 65%; text-align: left;"><img src="<?= base_url('admin_assets/images/invoice/retailer/footer-1.png');?>" /></td>
                            <td style="width: 35%; text-align: right;">
                                <?php if(!empty($result['order']['delivery_date']) || $result['order']['order_status_id'] == '6'){ ?>
                    			<?php $qrimg = base_url().'uploads/qrcodes/'.$result['order']['trans_id'].'-Qrcode.png'; ?>
                    			<img width='50px' src="<?php echo $qrimg;?>">
                    			<?php } ?>
                            </td>
                        </tr>
                    </table>
                    
                </td>
            </tr>
        </table>
    </div>
    </body>
</html>
