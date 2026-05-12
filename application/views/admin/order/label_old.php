<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Shuddh Desi Organic</title>
</head>
    <body>
<table width="700px" height="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td>
	<table width="50%" border="0" align="left" cellpadding="5" cellspacing="0">
      <tr>
        <td style="background-color: #f3f3f3;"><strong>Payment - <?php echo $result['order']['payment_method']; ?></strong></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="50%" valign="top"><strong>DELIVERY ADDRESS:</strong>
			<br /><?php echo $result['order']['shipping_firstname'];?>, 
			<br /><?php echo $result['order']['shipping_mobile'];?>, 
			<br /><?php echo $result['order']['shipping_address1'];?>, 
			<br /><?php echo $result['order']['shipping_address2'];?>, 
			<br /><?php echo $result['order']['shipping_city'] . ", " . $result['order']['shipping_state'] . ' - ' . $result['order']['shipping_postcode'] . ', IN';?>, 
			</td>
            <td width="50%" align="right" valign="top"><img src="<?php echo base_url();?>images/logo.png" width="100" /></td>
          </tr>
        </table>
		</td>
      </tr>
      <tr>
        <td style="background-color: #f3f3f3;"><strong>Courier Name : </strong><br />
          <strong>Courier AWB No. :</strong> </td>
      </tr>
      <tr>
        <td><strong>Sold By :</strong><br/>
        <strong>Suddh Desi Organic</strong><br/>
		Contact Number: +91-8890405026<br/>
		Email: order@shuddhdesiorganic.com</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
     
      <tr>
        <td style="padding-top:20px; border-top:1px solid #CCCCCC"><strong>Order ID:</strong> <?php echo $result['order']['id'];?></td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td style="border-top:2px dashed #CCCCCC;">&nbsp;</td>
  </tr>
  <tr>
    <td style="font-size:10px;">&nbsp;</td>
  </tr>
    <!---- Problem above --->
  <tr>
    <td style="font-size:10px;">
	<table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td valign="top" style="font-size:14px"><strong>Invoice</strong></td>
        <td valign="top">Order ID: <strong>#00<?php echo $result['order']['id'];?><br />
        </strong>Order Date :<strong> <?php echo date("d-m-Y", strtotime($result['order']['date_added']));?></strong></td>
        <td valign="top">Invoice No : <strong>#00<?php echo $result['order']['id'];?></strong><br />
          Invoice Date : <strong><?php echo date("d-m-Y", strtotime($result['order']['date_added']));?></strong></td>
        <td valign="top"></td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td style="font-size:10px;"><table width="100%" border="0" cellspacing="5" cellpadding="5">
      <tr>
        <td valign="top"><strong>Sold By</strong><br />
          Shuddh Desi Organic<br />
          Contact Number: +91-8890405026<br />
          Email: order@shuddhdesiorganic.com<br /></td>
        <td valign="top"><strong>Shipping ADDRESS</strong><br />
          <?php echo $result['order']['shipping_firstname'];?><br />
          <?php echo $result['order']['shipping_address1'];?><br/>
		  <?php echo $result['order']['shipping_address2'];?><br/>
		  <?php echo $result['order']['shipping_city'] . ", " . $result['order']['shipping_state'] . ' - ' . $result['order']['shipping_postcode'] . ', IN';?>
		  </td>
        <td valign="top"><strong>Billing Address</strong><br />

		<?php echo $result['order']['shipping_firstname'];?><br />
		<?php echo $result['order']['payment_address1'];?><br />
		<?php echo $result['order']['payment_address2'];?><br/>
		<?php echo $result['order']['payment_city'] . ", " . $result['order']['payment_state'] . ' - ' . $result['order']['payment_postcode'] . ', IN';?></td>
      </tr>
    </table></td>
  </tr>

  <tr>
    <td style="font-size:10px;">&nbsp;</td>
  </tr>
  <tr>
    <td style="font-size:10px;">
    <table width="100%" border="1" cellspacing="0" cellpadding="5">
      <tr>
        <td align="center"><strong>S.No.</strong></td>
        <td align="center"><strong>Name</strong></td>
		<td align="center"><strong>Size</strong></td>
        <td align="center"><strong>MRP</strong></td>
        <td align="center"><strong>Qty</strong></td>
        <td align="center"><strong>Unit Price</strong></td>
        <td align="center"><strong>Total (Rs.)</strong></td>
        <td align="center"><strong>Saving (Rs.)</strong></td>
      </tr>
      
	  <?php $total_qty =0;$i = 1;
			$mrp = 0;
			$saving = 0;
			$ptotal = 0;
	  foreach($result['product'] as $product){
		  $total_qty += $product['quantity'];
		  $mrp += $product['real_price'] * $product['quantity'];
		  ?>
	  <tr>
        <td valign="top"><?php echo $i++;?></td>
        <td valign="top"><strong><?php echo $product['product_name']; ?></strong></td>
        <td align="center" valign="top"><?php echo $product['size'];?></td>
        <td align="center" valign="top"><?php echo round($product['real_price']);?></td>
        <td align="center" valign="top"><?php echo $product['quantity'];?></td>
        <td align="center" valign="top"><?php echo ($product['discounted_price'] > 0) ? number_format($product['discounted_price'], 2):number_format($product['real_price'], 2);?></td>
       <td align="center" valign="top"><?php echo round($product['order_price']);?></td>
       <td align="center" valign="top"><?php $ptotal += $product['order_price']; $saving += ($product['real_price'] * $product['quantity']) - $product['order_price']; echo number_format(($product['real_price'] * $product['quantity']) - $product['order_price'], 2);?></td>
      </tr>
	  <?php } ?>
	  
	  <tr>
        <td colspan="5" valign="top">Product MRP</td>
        <td colspan="3" align="right"><?php echo round($mrp);?></td>
      </tr>
	  <tr>
        <td colspan="5" valign="top">Total Saving</td>
        <td colspan="3" align="right"><?php echo round($saving);?></td>
      </tr>
	  <tr>
        <td colspan="5" valign="top">Product Amount</td>
        <td colspan="3" align="right"><?php echo round($ptotal);?></td>
      </tr>
      <tr>
        <td colspan="5" valign="top">Discount</td>
        <td colspan="3" align="right"><?php echo round($result['order']['promo_code_price']);?></td>
      </tr>
	  <tr>
        <td colspan="5" valign="top">Delivery</td>
        <td colspan="3" align="right"><?php echo round($result['order']['shipping_charge']);?></td>
      </tr>
      <tr>
        <td colspan="5" valign="top"><strong>TOTAL QTY: <?php echo $total_qty;?> </strong></td>
        <td colspan="3" align="right" valign="top"><strong style="font-size:12px">TOTAL PRICE : <?php echo round($result['order']['order_total']); ?></strong><br />
          ALL VALUES ARE IN INR</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td style="font-size:10px;">&nbsp;</td>
  </tr>
  <tr>
    <td style="font-size:10px;">Sold By : Shuddh Desi Organic,<br />
      Contact Number: +91-8890405026<br />
        Email: order@shuddhdesiorganic.com<br />
      <strong>Declaration</strong><br />
      The goods sold are intended for end user consumption and not for resale</td>
  </tr>
</table>
</body></html>