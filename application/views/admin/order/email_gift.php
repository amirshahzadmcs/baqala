<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Baqala Station</title>
</head>

<body>
<div style="width:100%; max-width:700px; margin:auto; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000;border:2px solid #28a745!important; padding: 0px 40px">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style=" text-align:center; padding:20px 0px;"><img src="<?php echo base_url();?>images/logo-white.jpg" /></td>
  </tr>
  <tr>
    <td style="padding:15px 0px; font-size:22px; font-weight:bold; color:#666666;text-align:center;">GIFT CARD RECEIVED</td>
  </tr>
  <tr>
    <td style="font-size:18px; padding-bottom:15px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>Your Order - #<?php echo 'BS-'. $order_id;?></td>
        <td align="right"><?php echo date("M d,Y", strtotime($date_added));?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td style="background:#000; height:1px;"></td>
  </tr>
  <tr>
    <td style="font-size:15px; padding:20px 0px; line-height:24px;">Dear <strong><?php echo $to_name;?>,</strong><br />
<?php echo $from_name;?> sent you a gift card, you can redeemed gift card voucher through baqala station app. Thank You</td>
  </tr>
  <tr><td>Your Gift Card Code: <b><?php echo strtoupper($gift_code);?></b></td></tr>
  <tr><td>Message : <b><?php echo $gift_message;?></b></td></tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="background:#000; height:2px"></td>
  </tr>
  <tr>
    <td style="background:#000; height:2px"></td>
  </tr>
  <tr>
    <td style="padding:15px 0px 5px 0px; font-size:14px; font-weight:bold;">For our Latest Collection, follow us -</td>
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
