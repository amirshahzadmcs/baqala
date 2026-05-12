<table border="0" cellspacing="0" cellpadding="1" style="font-size: 10px; width: 100%;">
	<tr>
		<td colspan="2" style="border-top:30px solid #35aa59"></td>
	</tr>
	<tr>
		<td colspan="2"></td>
	</tr>
	<tr>
		<td colspan="2"><img src="<?php echo base_url('admin_assets/images/delivery-note.jpg');?>" style="max-width: 100%;" /></td>
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
						<h4 style="font-size: 13px;"><strong>Customer Details</strong></h4>
						<?php if(!empty($result['order']['c_company'])) { ?>
						<?php echo $result['order']['c_company'];?><br />
						<?php } ?>
						<?php echo $result['order']['name'];?><br />
						<?php echo $result['order']['building_no'];?> <?php echo $result['order']['street_name'];?> - <?php echo $result['order']['district_name'];?><br/>
						<?php echo $result['order']['unit_no'];?>,
						<?php echo $result['order']['sel_city_name'];?> <?php echo $result['order']['zip_code'];?> - <?php echo $result['order']['additional_no'];?><br/>
						<?php echo $result['order']['country'];?><br/><br/>
					</td>
					<td align="left" valign="top" style="width: 30%;">
						<h4 style="font-size: 13px;"><strong>Delivery Address</strong></h4>
						<?php if(!empty($result['order']['c_company'])) { ?>
						<?php echo $result['order']['c_company'];?><br />
						<?php } ?>
						<?php echo $result['order']['shipping_person_name'];?><br/>
						<?php echo $result['order']['villa_building'];?>-<?php echo $result['order']['shipping_house_no'];?>, <?php echo $result['order']['shipping_street'];?><br/>
						<?php echo $result['order']['shipping_city'];?> <?php echo $result['order']['shipping_postcode'];?><br/>
						<?php echo $result['order']['shipping_country'];?>
					</td>
					<td valign="top" style="width: 30%;text-align: left;">
						<h4 style="font-size: 13px;"><strong>Delivery Note Information</strong></h4>
						<table>
							<tr>
								<td>Delivery Note No</td>
								<td>: <?php echo 'DLN-'. $result['order']['order_no'];?></td>
							</tr>
							<tr>
								<td>Delivery Date</td>
								<td>: <?php if(!empty($result['order']['delivery_date'])){ echo date('d-m-Y', strtotime($result['order']['delivery_date'])); }else{ echo date('d-m-Y', strtotime($result['order']['shipping_date_slot']));} ?></td>
							</tr>
							<?php if(!empty($result['order']['po_number'])){?>
							<tr>
								<td>Customer P.O No</td>
								<td>: <?php echo $result['order']['po_number'];?></td>
							</tr>
							<?php } ?>
							<?php if(!empty($result['order']['po_date'])){?>
							<tr>
								<td>P.O Date</td>
								<td>: <?php echo date('d-m-Y', strtotime($result['order']['po_date'])); ?></td>
							</tr>
							<?php } ?>
							<tr>
								<td>Order Number</td>
								<td>: <?php echo $result['order']['invoice_prefix'] .'-'. $result['order']['order_no'];?></td>
							</tr>
							<?php if(!empty($result['order']['quotation_no'])){?>
							<tr>
								<td>Quotation Number</td>
								<td>: <?php echo 'QTN-'. $this->customer->invoiceNmFormat($result['order']['quotation_no']);?></td>
							</tr>
							<?php } ?>
						</table>
					</td>
					<td style="width: 5%;"></td>
				</tr>
				
				<tr>
					<td style="width: 5%;"></td>
					<td colspan="3" style="border-top:1px solid #e0b500;border-bottom:1px solid #e0b500;width: 90%;line-height:20px;"><h4 style="font-size: 13px;padding:5px;">Delivery Note Details</h4></td>
					<td style="width: 5%;"></td>
				</tr>
			</table>
		</td>
	</tr>
	
</table>
