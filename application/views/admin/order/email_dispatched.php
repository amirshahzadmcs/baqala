<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Baqala Station</title>
</head>

<body>
<?php
$method = $result['order']['payment_method'];
?>


<div style="width:100%; max-width:700px; margin:auto; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style=" text-align:center; padding:20px 0px;"><img src="<?php echo base_url();?>images/logo-white.jpg" /></td>
  </tr>
  <tr>
    <td style="padding:15px 0px; font-size:24px; font-weight:bold; color:#666666;">ORDER SHIPPED</td>
  </tr>
  <tr>
    <td style="font-size:18px; padding-bottom:15px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>Your Order - #<?php echo $result['order']['invoice_prefix'] .'-'. $result['order']['id'];?></td>
        <td align="right"><?php echo date("M d,Y", strtotime($result['order']['date_added']));?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td style="background:#000; height:1px;"></td>
  </tr>
  <tr>
    <td style="font-size:15px; padding:20px 0px; line-height:24px;">Dear <strong><?php echo $result['order']['name'];?>,</strong><br />
Your Order is on its way and your order details are shown below for your reference :</td>
  </tr>

  <tr>
    <td style="border:1px solid #D9D9D9;"><table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr>
        <td colspan="5" align="center" style="font-size:18px; font-weight:bold; padding:15px 0px;">ORDER SUMMARY</td>
        </tr>
   <tr style="font-size:14px; font-weight:bold;">
        <td style="border-top:1px solid #D9D9D9;">S.No.</td>
        <td style="border-top:1px solid #D9D9D9;">Name</td>
        <td style="border-top:1px solid #D9D9D9;">Price</td>
        <td style="border-top:1px solid #D9D9D9;">Qty</td>
        <td style="border-top:1px solid #D9D9D9;">Value</td>
        <td style="border-top:1px solid #D9D9D9;">Net</td>
        <td style="border-top:1px solid #D9D9D9;">VAT</td>
        <td style="border-top:1px solid #D9D9D9;">VAT %</td>
        <td style="border-top:1px solid #D9D9D9;">Total (SAR)</td>
      </tr>
      
	  <?php
		$total_qty =0;$i = 1;$amt_exl_vat = 0;$total_vat = 0;$saving = 0;$ptotal = 0;
		foreach($result['product'] as $product){
		$total_qty += $product['quantity'];
		$total_vat += $product['vat_price'];
		//$mrp += $product['real_price'] * $product['quantity'];
		$amt_exl_vat += $product['order_price'] * $product['quantity'];
	?>
	  <tr>
        <td valign="top" style="border-top:1px solid #D9D9D9;"><?php echo $i++;?></td>
        <td valign="top" style="border-top:1px solid #D9D9D9;">
			<?php echo $product['product_name']; ?><br />
			<span style="display: block; text-align: right;"><?php echo $product['arabic_name']; ?> </span>
		</td>
        <td valign="top" style="border-top:1px solid #D9D9D9;"><?php echo sprintf("%.2f",$product['order_price']);?></td>
        <td valign="top" style="border-top:1px solid #D9D9D9;"><?php echo round($product['quantity']);?></td>
		<td valign="top" style="border-top:1px solid #D9D9D9;"><?php echo sprintf("%.2f",$product['order_price'] * $product['quantity']) ; ?></td>
        <td valign="top" style="border-top:1px solid #D9D9D9;"><?php  $net_value=($product['order_price']-$product['vat_price']) * $product['quantity']; echo sprintf("%.2f",$net_value);?></td>
        <td valign="top" style="border-top:1px solid #D9D9D9;"><?php echo sprintf("%.2f",$product['vat_price']); ?></td>
        <td valign="top" style="border-top:1px solid #D9D9D9;"><?php echo $product['gst_rate']; ?></td>
        <td valign="top" style="border-top:1px solid #D9D9D9;"><?php $pTotal = $product['order_price'] * $product['quantity']; echo sprintf("%.2f",$pTotal); ?></td>
      </tr>
	  <?php } ?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="36%" valign="top" style="background:#F2F2F2; padding:15px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="font-size:18px; padding-bottom:10px;">Shipping Address</td>
          </tr>
          <tr>
            <td style="line-height:24px;"><?php echo $result['order']['shipping_firstname'] . "<br/>" . $result['order']['shipping_mobile'] . "<br/>". $result['order']['shipping_complete_address']; ?></td>
          </tr>
        </table></td>
        <td width="4%" align="left" valign="top">&nbsp;</td>
        <td width="60%" align="left" valign="top" style="background:#F2F2F2; padding:15px;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
            <td valign="top" style="font-size:15px; padding-bottom:10px;">Total Items</td>
            <td align="right" valign="top" style="font-size:15px;"><?php echo count($result['product']); ?></td>
          </tr>
          <tr>
            <td valign="top" style="font-size:15px; padding-bottom:10px;">Total Excluding VAT </td>
            <td align="right" valign="top" style="font-size:15px;"><?php echo sprintf("%.2f",$amt_exl_vat);?></td>
          </tr>
		  <tr>
		  <tr>
            <td valign="top" style="font-size:15px; padding-bottom:10px;">Total Qty. </td>
            <td align="right" valign="top" style="font-size:15px;"><?php echo $total_qty; ?></td>
          </tr>
		  <tr>
            <td valign="top" style="font-size:15px; padding-bottom:10px;">Discount</td>
            <td align="right" valign="top" style="font-size:15px;">-</td>
          </tr>
          <tr>
            <td valign="top" style="font-size:15px; padding-bottom:15px;">VAT </td>
            <td align="right" valign="top" style="font-size:15px;"><?php echo sprintf("%.2f",$total_vat); ?></td>
          </tr>
          <tr>
            <td valign="top" style="font-size:15px; padding-bottom:20px;">Delivery Charge</td>
            <td align="right" valign="top" style="font-size:15px;"><?php echo round($result['order']['shipping_charge']);?></td>
          </tr>
          <tr>
            <td valign="top" style="font-size:18px; border-top:1px solid #999999; padding-top:15px;">Net Amount </td>
            <td align="right" valign="top" style="font-size:18px; border-top:1px solid #999999; padding-top:15px;"><?php $net_amt = $amt_exl_vat + $result['order']['shipping_charge']; echo sprintf("%.2f",$net_amt); ?> SAR</td>
          </tr>
		  
		  <tr>
            <td valign="top" style="font-size:16px; border-top:1px solid #999999; padding-top:15px;">Payment Method</td>
            <td align="right" valign="top" style="font-size:16px; border-top:1px solid #999999; padding-top:15px;"><?php echo $method;?></td>
          </tr>
		  
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="background:#000; height:2px"></td>
  </tr>
  <tr>
    <td style="padding:15px 0px; font-size:16px; line-height:25px;">NOTE : We have dispatched your Order, you will receive it within 3-4 Business Days at your Door step. <br/> Some Shipping Areas may up to 7 Business Days. <br/>For More Visit your <a href="http://www.baqalastation.com/">Baqala Station</a>
      </td>
  </tr>
  <tr>
    <td style="background:#000; height:2px"></td>
  </tr>
  <tr>
    <td>
	<a href="#"><img src="<?php echo base_url();?>images/email/i.jpg" /></a> &nbsp; 
	<a href="#"><img src="<?php echo base_url();?>images/email/f.jpg" /></a> &nbsp; 
	<a href="#"><img src="<?php echo base_url();?>images/email/y.jpg" /></a> &nbsp; 
	<a href="#"><img src="<?php echo base_url();?>images/email/t.jpg" /></a> &nbsp; </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="background:#F1F1F1; padding:10px; text-align:center; font-size:16px;">Call on +966 59 393 5577 &nbsp; | &nbsp; info@baqalastation.com &nbsp; | &nbsp; www.baqalastation.com</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

</div>
</body>
</html>
