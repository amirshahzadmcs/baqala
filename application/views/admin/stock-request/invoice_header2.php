<table border="0" cellspacing="0" cellpadding="1" style="font-size: 10px; width: 100%;">
	<tr>
		<td colspan="3"><img src="<?php echo base_url('admin_assets/images/header/str-header.jpg');?>" style="max-width: 100%;" /></td>
	</tr>
	<tr>
		<td align="left" valign="top" style="width: 40%;">
			<strong>WAREHOUSE INFORMATION</strong><br/>
			<strong>Name:</strong> <?= $warehouse_address->name_english;?><br />
			<strong>Contact No:</strong> <?php echo $warehouse_address->warehouse_phone; ?><br />
			<strong>Address:</strong> <?php echo $warehouse_address->complete_address; ?><br/><br/>
		</td>
		<td valign="top" style="width: 20%;"></td>
		<td valign="top" style="width: 40%; float: right;text-align: right;">
			<strong>STR Number :</strong> <?= $order->request_id;?><br/>
			<strong>Request Date :</strong> <?= date("d-m-Y h:i:s", strtotime($order->created_at)); ?><br/>
			<strong>Expected Delivery Date:</strong> <?= date("d-m-Y h:i:s", strtotime($order->expected_date)); ?><br />
			<strong>Delivery Date:</strong> <?php if($order->dispatch_date){ echo date("d-m-Y h:i:s", strtotime($order->dispatch_date));}else{ echo 'N/A';} ?><br><br>
			
			<strong>BILLING INFORMATION</strong>
			<div style="width: 50%">
			<?= $order->store_name;?><br>
			<?= $order->store_incharge;?><br>
			<?= $order->contact_number;?><br>
			<?= $order->store_location;?>
			</div>
		</td>
	</tr>
	<tr><td colspan="2"></td></tr>
</table>
