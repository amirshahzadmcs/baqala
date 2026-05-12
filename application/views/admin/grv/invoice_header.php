<table border="0" cellspacing="0" cellpadding="1" style="font-size: 10px; width: 100%;">
	<tr>
		<td colspan="3"><img src="<?php echo base_url('admin_assets/images/purchase_order/grv-header.jpg');?>" style="max-width: 100%;" /></td>
	</tr>
	<tr>
		<td align="left" valign="top" style="width: 40%;">
			<strong>SUPPLIER ADDRESS</strong><br/>
			<strong>Company Name:</strong> <?php echo $order->vendor_name; ?><br />
			<strong>Company VAT No:</strong> <?php echo $order->vat_no; ?><br />
			<strong>Contact Person:</strong> <?php echo $order->contact_person_name; ?><br />
			<strong>Address:</strong> <?php echo $order->b_building_no .','; ?> <?php echo $order->b_street_name .','; ?> <?php echo $order->b_district; ?><br />
			Additional No: <?php echo $order->b_additional_no .','; ?> Unit No: <?php echo $order->b_unit_no; ?><br/>
			<?php echo $order->b_city_name .','; ?> <?php echo $order->b_zip_code; ?><br/>
			<?php echo $order->country; ?><br/><br/>
		</td>
		<td valign="top" style="width: 20%;"></td>
		<td valign="top" style="width: 40%; float: right;text-align: right;">
			<strong>GRV Number :</strong> <?php echo $grv->invoice_prefix .'-'. $grv->grv_no; ?><br/>
			<strong>P.O. Number :</strong> <?php echo $grv->po_no; ?><br/>
			<strong>Date:</strong> <?php echo date("d-m-Y", strtotime($grv->created_at)); ?><br />
			<strong>Total Value:</strong> <?php echo $grv->grv_value .' SAR'; ?><br />
			<!--<strong>Status:</strong> <?php //echo ($grv->grv_status == 'open') ? 'Open' : (($grv->grv_status == 'closed') ? 'Closed' : (($grv->grv_status == 'rejected') ? 'Rejected' : '<span class="label label-warning">NULL</span>')); ?><br/>-->
			<strong>Contact:</strong> <?php echo $order->po_contact; ?><br/><br/>
			<strong>BILLING ADDRESS</strong>
			<div style="width: 50%"><?= $this->admin->getWarehouseDetail()->complete_address;?></div>
		</td>
	</tr>
	<tr><td colspan="2"></td></tr>
</table>
