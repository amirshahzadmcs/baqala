<table border="0" cellspacing="0" cellpadding="1" style="font-size: 10px; width: 100%;">
	<!-- <tr>
		<td colspan="2"><img src="<?php //echo base_url('admin_assets/images/quotation/header-top.jpg');?>" style="max-width: 100%;" /></td>
	</tr> -->
	<tr>
		<td align="left" valign="top" style="width: 40%;"><strong>CUSTOMER DETAILS</strong><br/>
			<?php if(!empty($result['order']['c_company'])) { ?>
			Company Name: <?php echo $result['order']['c_company'];?><br />
			<?php } ?>
			<?php if($result['order']['c_role'] == 2){ echo 'Company VAT No: ' .$result['order']['c_vat'];  ?><br/><?php } ?>
			Contact Person: <?php echo $result['order']['name'];?><br />
			Address: <?php echo $result['order']['building_no'];?> <?php echo $result['order']['street_name'];?> - <?php echo $result['order']['district_name'];?><br/>
			Unit No - <?php echo $result['order']['unit_no'];?>,
			<?php echo $result['order']['sel_city_name'];?> <?php echo $result['order']['zip_code'];?> - <?php echo $result['order']['additional_no'];?><br/>
			<?php echo $result['order']['country'];?><br/><br/>
		</td>
		<td valign="top" style="width: 60%; float: right;text-align: right;">
			<?php if(!empty($result['order']['payment_code'])){?>
			<strong>TransRef ID :</strong> <?php echo $result['order']['payment_code']; ?><br/>
			<?php } ?>
			<strong>Quotation Number :</strong> #<?php echo $result['order']['invoice_prefix'] .'-'. $result['order']['quotation_no'];?><br/>
			<strong>Associate Name:</strong> <?php echo $result['order']['associate_name'];?><br />
			<strong>Payment type:</strong> <?php echo $result['order']['payment_method']; ?><br />
			<strong>Quotation Date:</strong> <?php $qdate=$result['order']['date_added']; echo date('d-m-Y', strtotime($qdate)); ?><br/>
			<strong>Quotation Valid Till:</strong> <?php echo date('d-m-Y', strtotime($result['order']['quotation_expiry_date'])); ?><br/>
		</td>
	</tr>
</table>
