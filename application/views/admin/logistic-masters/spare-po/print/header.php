<table border="0" cellspacing="0" cellpadding="1" style="font-size: 10px; width: 100%;">
	<tr>
		<td colspan="2" style="border-top:30px solid #35aa59"></td>
	</tr>
	<tr>
		<td colspan="2"></td>
	</tr>
	<tr>
		<td colspan="2"><img src="<?php echo base_url('admin_assets/images/header-top.png');?>" style="max-width: 100%;" /></td>
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
						<h4 style="font-size: 13px;"><strong>SP Requisition Information</strong></h4>
						<table>
							<tr>
								<td>Requisition No.</td>
								<td>: <?php echo $order->requisition_no; ?></td>
							</tr>
							<tr>
								<td>Requisition Type</td>
								<td>: <?php echo $order->requisition_type; ?></td>
							</tr>
							<tr>
								<td>Requisition Date</td>
								<td>: <?php echo date("d-m-Y", strtotime($order->requisition_date)); ?></td>
							</tr>
						</table>
					</td>
					<td align="left" valign="top" style="width: 30%;">
						
					</td>
					<td valign="top" style="width: 30%;text-align: left;">
						<h4 style="font-size: 13px;"><strong>Supplier Information</strong></h4>
						<table>
							<tr>
								<td>Supplier Name</td>
								<td>: <?php echo $order->vendor_name; ?> <?php echo ($order->vendor_arabic_name !== '') ? '/ '. $order->vendor_arabic_name : ''; ?></td>
							</tr>
							<tr>
								<td>Contact Person</td>
								<td>: <?php echo $order->contact_person_name; ?></td>
							</tr>
							<tr>
								<td>CR No.</td>
								<td>: <?php echo $order->cr_no; ?></td>
							</tr>
							<tr>
								<td>VAT No.</td>
								<td>: <?php echo $order->vat_no; ?></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
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
