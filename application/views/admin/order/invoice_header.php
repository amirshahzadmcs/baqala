<table border="0" cellspacing="0" cellpadding="1" style="font-size: 10px; width: 100%;">
	<tr>
		<td colspan="2" style="border-top:30px solid #35aa59"></td>
	</tr>
	<tr>
		<td colspan="2"></td>
	</tr>
	<tr>
		<td colspan="2"><img src="<?php echo base_url('admin_assets/images/invoice/corporate/header-top.jpg');?>" style="max-width: 100%;" /></td>
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
						<h4 style="font-size: 13px;"><strong>Billing Address</strong></h4>
						<?php if(!empty($result['order']['c_company'])) { ?>
						<?php echo $result['order']['c_company'];?><br />
						<?php } ?>
						<?php echo $result['order']['name'];?><br />
						<?php echo $result['order']['building_no'];?> <?php echo $result['order']['street_name'];?> - <?php echo $result['order']['district_name'];?><br/>
						<?php echo $result['order']['unit_no'];?>,
						<?php echo $result['order']['city_name'];?> <?php echo $result['order']['zip_code'];?> - <?php echo $result['order']['additional_no'];?><br/>
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
						<h4 style="font-size: 13px;"><strong>Invoice Information</strong></h4>
						<table>
							<tr>
								<td>Tax Invoice Number</td>
								<?php if($result['order']['order_status_id'] == '6'){?>
								<td>: <?php echo 'INV-'. $result['order']['order_no'];?></td>
								<?php }else{ ?>
								<td>: N/A</td>
								<?php } ?>
							</tr>
							<tr>
								<td>Tax Invoice Issue Date</td>
								<td>: <?php $qdate=$result['order']['date_added']; echo date('d-m-Y', strtotime($qdate)); ?></td>
							</tr>
							<tr>
								<td>P. O. Number</td>
								<td>: <?php echo $result['order']['po_number']; ?></td>
							</tr>
							<tr>
								<td>Payment Term</td>
								<td>: <?php echo $result['order']['payment_method']; ?></td>
							</tr>
							<tr>
								<td>Customer VAT No</td>
								<td>: <?php if($result['order']['c_vat'] !== ''){ echo $result['order']['c_vat'];}else{ echo 'N/A';}?></td>
							</tr>
						</table>
					</td>
					<td style="width: 5%;"></td>
				</tr>
				
				<tr>
					<td style="width: 5%;"></td>
					<td colspan="3" style="border-top:1px solid #e0b500;border-bottom:1px solid #e0b500;width: 90%;line-height:20px;"><h4 style="font-size: 13px;padding:5px;">Invoice Detail</h4></td>
					<td style="width: 5%;"></td>
				</tr>
			</table>
		</td>
	</tr>
	
</table>
