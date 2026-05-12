<table border="0" cellspacing="0" cellpadding="1" style="font-size: 10px; width: 100%;">
	<tr>
		<td colspan="2" style="border-top:30px solid #35aa59"></td>
	</tr>
	<tr>
		<td colspan="2"></td>
	</tr>
	<tr>
		<td colspan="2"><img src="<?php echo base_url('admin_assets/images/purchase_order/header-top.jpg');?>" style="max-width: 100%;" /></td>
	</tr>
	<tr>
		<td colspan="2">
			<table border="0" cellspacing="0" cellpadding="1" style="font-size: 10px; width: 100%;margin:0 auto;">
				<tr>
					<td style="width: 5%;"></td>
					<td colspan="3" style="border-top:1px solid #e0b500;width: 90%;"></td>
					<td style="width: 5%;"></td>
				</tr>
				<tr>
					<td style="width: 5%;"></td>
					<td align="left" valign="top" style="width: 30%;">
						<h4 style="font-size: 13px;"><strong>Supplier Information</strong></h4>
						<?php echo $order->vendor_name; ?><br />
						<?php echo $order->contact_person_name; ?><br />
						<?php echo $order->b_building_no .','; ?> <?php echo $order->b_street_name .','; ?> <?php echo $order->b_district; ?><br />
						<?php echo $order->b_additional_no .','; ?> Unit No: <?php echo $order->b_unit_no; ?><br/>
						<?php echo $order->b_city_name .','; ?> <?php echo $order->b_zip_code; ?><br/>
						<?php echo $order->country; ?><br/><br/>
					</td>
					<td align="left" valign="top" style="width: 30%;">
						<h4 style="font-size: 13px;"><strong>Delivery Address</strong></h4>
						<?= $this->admin->getWarehouseDetail()->complete_address;?>
					</td>
					<td valign="top" style="width: 30%;text-align: left;">
						<h4 style="font-size: 13px;"><strong>PO Information</strong></h4>
						<table>
							<tr>
								<td>P. O. Number</td>
								<td>: <?php echo $order->invoice_prefix .'-'. $order->po_number; ?></td>
							</tr>
							<tr>
								<td>P. O. Issue Date</td>
								<td>: <?php echo date("d-m-Y", strtotime($order->po_date)); ?></td>
							</tr>
							<tr>
								<td>Payment Terms</td>
								<td>: <?php echo $order->po_terms; ?></td>
							</tr>
							<tr>
								<td>Supplier VAT No</td>
								<td>: <?php echo $order->vat_no; ?></td>
							</tr>
						</table>
					</td>
					<td style="width: 5%;"></td>
				</tr>
				
				<tr>
					<td style="width: 5%;"></td>
					<td colspan="3" style="border-top:1px solid #e0b500;border-bottom:1px solid #e0b500;width: 90%;line-height:20px;"><h4 style="font-size: 13px;padding:5px;">Item Details</h4></td>
					<td style="width: 5%;"></td>
				</tr>
			</table>
		</td>
	</tr>
	
</table>
