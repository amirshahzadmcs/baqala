<table border="0" cellspacing="0" cellpadding="1" style="font-size: 10px; width: 100%;">
	<tr>
		<td colspan="3"><img src="<?php echo base_url('admin_assets/images/purchase_return/header-top.jpg');?>" style="max-width: 100%;" /></td>
	</tr>
	<tr>
		<td align="left" valign="top" style="width: 40%;">
			<strong>SUPPLIER DETAILS</strong><br/>
			<strong>Company Name:</strong> <?php echo $order->vendor_name; ?><br />
			<strong>Company VAT No:</strong> <?php echo $order->vat_no; ?><br />
			<strong>Contact Person:</strong> <?php echo $order->contact_person_name; ?><br />
			<strong>Address:</strong> <?php echo $order->b_building_no .','; ?> <?php echo $order->b_street_name .','; ?> <?php echo $order->b_district; ?><br />
			Additional No: <?php echo $order->b_additional_no .','; ?> Unit No: <?php echo $order->b_unit_no; ?><br/>
			<?php echo $order->b_city_name .','; ?> <?php echo $order->b_zip_code; ?><br/>
			<?php echo $order->country; ?><br/><br/>
		</td>
		<td valign="top" style="width: 60%; float: right;text-align: right;">
			<strong>PRV No. :</strong> <?php echo 'PR-'.$order->id; ?><br/>
			<strong>PRV Date :</strong> <?php echo date("d-m-Y", strtotime($order->created_at)); ?><br/>
			<strong>GRV No. :</strong> <?php echo $order->grv_no; ?><br/>
			<strong>GRV Date :</strong> <?php echo date("d-m-Y", strtotime($order->grv_date)); ?><br/>
			<strong>P.O No :</strong> <?php echo $order->po_number; ?><br/>
			<strong>P.O Date :</strong> <?php echo date("d-m-Y", strtotime($order->po_date)); ?><br/><br/>
			<!--<strong>SUPP. VAT No.:</strong> <?php echo $order->vat_no; ?>-->
			
			<strong>DELIVER TO <br /> </strong><?php echo $order->delivery_name; ?><br/>
			Contact No. - <?php echo $order->d_contact; ?><br/>
			<?php echo $order->d_building_no .','; ?> <?php echo $order->d_street_name .','; ?> <?php echo $order->d_district; ?><br />
			<?php echo $order->d_additional_no .','; ?> <?php echo $order->d_unit_no; ?><br/>
			<?php echo $order->d_city_name .','; ?> <?php echo $order->d_zip_code; ?>
		</td>
	</tr>
	<tr><td colspan="2"></td></tr>
</table>