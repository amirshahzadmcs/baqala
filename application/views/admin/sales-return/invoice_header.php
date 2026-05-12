<table border="0" cellspacing="0" cellpadding="1" style="font-size: 10px; width: 100%;">
	<tr>
		<td colspan="3"><img src="build/images/sales_return/header-top.jpg" style="max-width: 100%;" /></td>
	</tr>
	<tr>
		<td align="left" valign="top" style="width: 40%;"><strong>CUSTOMER DETAILS</strong><br/>
			<?php if(!empty($result['order']['c_company'])) { ?>
			<b>Company Name:</b> <?php echo $result['order']['c_company'];?><br />
			<?php } ?>
			<?php if($result['order']['c_role'] == 2){ echo '<b>Company VAT No:</b> ' .$result['order']['c_vat'];  ?><br/><?php } ?>
			<strong>Contact Person:</strong> <?php echo $result['order']['name'];?><br />
			<strong>Address:</strong> <?php echo $result['order']['building_no'];?> <?php echo $result['order']['street_name'];?> - <?php echo $result['order']['district_name'];?><br/>
			Unit No <?php echo $result['order']['unit_no'];?><br/>
			<?php echo $result['order']['city_name'];?> <?php echo $result['order']['zip_code'];?> - <?php echo $result['order']['additional_no'];?><br/>
			<?php echo $result['order']['country'];?><br/>
		</td>
		<td valign="top" style="width: 60%; float: right;text-align: right;">
			<strong>Sales Return No :</strong> #<?php echo 'SR-'. $result['order']['id'];?><br/>
			<strong>Sales Return Date:</strong> <?php $qdate=$result['order']['updated_at']; echo date('d-m-Y', strtotime($qdate)); ?><br/>
			<strong>Invoice Number:</strong> #<?php echo $result['order']['invoice_prefix'] .'-'. $result['order']['id'];?><br />
			<strong>Invoice Date:</strong> <?php $order_date=$result['order']['date_added']; echo date('d-m-Y', strtotime($order_date)); ?><br/>
			<strong>Payment Term:</strong> <?php echo $result['order']['payment_method']; ?><br />
			<?php if(!empty($result['order']['payment_code'])){?>
			<strong>TransRef ID :</strong> <?php echo $result['order']['payment_code']; ?>
			<?php } ?>
			<br/>
			<strong>SHIPPING ADDRESS <br /></strong><?php echo $result['order']['shipping_firstname'];?> / <?php echo $result['order']['shipping_mobile'];?><br/>
			<?php echo $result['order']['shipping_house_no'];?> <?php echo $result['order']['shipping_street'];?> <?php echo $result['order']['shipping_sector'];?> - <?php echo $result['order']['shipping_locality'];?><br/>
			<?php echo $result['order']['shipping_city'];?> <?php echo $result['order']['shipping_postcode'];?><br/>
			<?php echo $result['order']['shipping_country'];?>
		</td>
	</tr>
</table>