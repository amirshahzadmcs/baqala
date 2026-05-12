<table border="0" cellspacing="0" cellpadding="1" style="font-size: 10px; width: 100%;">
	<tr>
		<td colspan="2" style="border-top:30px solid #35aa59"></td>
	</tr>
	<tr>
		<td colspan="2"></td>
	</tr>
	<tr>
		<td colspan="2"><img src="<?php echo base_url('admin_assets/images/quotation/header-top.jpg');?>" style="max-width: 100%;" /></td>
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
						<?php echo $result['order']['sel_city_name'];?> <?php echo $result['order']['zip_code'];?> - <?php echo $result['order']['additional_no'];?><br/>
						<?php echo $result['order']['country'];?><br/><br/>
					</td>
					<td align="left" valign="top" style="width: 30%;">
						<h4 style="font-size: 13px;"><strong>Delivery Address</strong></h4>
						<?php if(!empty($result['order']['c_company'])) { ?>
						<?php echo $result['order']['c_company'];?><br />
						<?php } ?>
						<?php echo $result['order']['s_person_name'];?><br/>
						<?php echo $result['order']['s_address_type'];?>-<?php echo $result['order']['s_building_villa_no'];?>, <?php echo $result['order']['s_street'];?><br/>
						<?php echo $result['order']['s_city'];?> <?php echo $result['order']['s_postal'];?><br/>
						<?php echo $result['order']['s_country'];?>
					</td>
					<td valign="top" style="width: 30%;text-align: left;">
						<h4 style="font-size: 13px;"><strong>Quotation Information</strong></h4>
						<table>
							<tr>
								<td>Quotation Number</td>
								<td>: <?php echo $result['order']['invoice_prefix'] .'-'. $result['order']['quotation_no'];?></td>
							</tr>
							<tr>
								<td>Quotation Date</td>
								<td>: <?php $qdate=$result['order']['date_added']; echo date('d-m-Y', strtotime($qdate)); ?></td>
							</tr>
							<tr>
								<td>Quotation Validaty</td>
								<td>: <?php echo date('d-m-Y', strtotime($result['order']['quotation_expiry_date'])); ?></td>
							</tr>
							<tr>
								<td>Associate Name</td>
								<td>: <?php if($result['order']['associate_name'] !== ''){ echo $result['order']['associate_name'];}else{ echo 'N/A';}?></td>
							</tr>
							<tr>
								<td>Payment Term</td>
								<td>: <?php echo $result['order']['payment_method']; ?></td>
							</tr>
						</table>
					</td>
					<td style="width: 5%;"></td>
				</tr>
				
				<tr>
					<td style="width: 5%;"></td>
					<td colspan="3" style="border-top:1px solid #e0b500;border-bottom:1px solid #e0b500;width: 90%;line-height:20px;"><h4 style="font-size: 13px;padding:5px;">Quotation Details</h4></td>
					<td style="width: 5%;"></td>
				</tr>
			</table>
		</td>
	</tr>
	
</table>
