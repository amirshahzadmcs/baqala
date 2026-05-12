<table border="0" cellspacing="0" cellpadding="1" style="font-size: 10px; width: 100%;">
	<tr>
		<td colspan="2"><img src="admin_assets/images/delivery-note.jpg" style="max-width: 100%;" /></td>
	</tr>
	<tr>
		<td style="width: 100%;">
			<table cellspacing="0" cellpadding="5" style="font-size: 10px; width: 100%;">
				<tr>
    				<td align="left" valign="top" style="width: 50%;"><strong>CUSTOMER DETAILS</strong><br/>
						<?php if(!empty($result['order']['c_company'])) { ?>
						<b>Company Name:</b> <?php echo $result['order']['c_company'];?><br />
						<?php } ?>
						<?php if($result['order']['c_role'] == 2){ echo '<b>Company VAT No:</b> ' .$result['order']['c_vat'];  ?><br/><?php } ?>
						<strong>Contact Person:</strong> <?php echo $result['order']['name'];?><br />
						<strong>Address:</strong> <?php echo $result['order']['building_no'];?> <?php echo $result['order']['street_name'];?> - <?php echo $result['order']['district_name'];?><br/>
						Unit No <?php echo $result['order']['unit_no'];?><br/>
						<?php echo $result['order']['city_name'];?> <?php echo $result['order']['zip_code'];?> - <?php echo $result['order']['additional_no'];?><br/>
						<?php echo $result['order']['country'];?><?php if($result['order']['shipping_instruction'] !== '') echo '<br>Delivery Instruction: '.$result['order']['shipping_instruction'];?>
					</td>
    				<td valign="top" style="width: 50%; float: right;text-align:right;"><b>Delivery Note No:</b> <?php echo 'DLN-'. $result['order']['order_no'];?><br/>
						<b>Delivery Date :</b> <?php if(!empty($result['order']['delivery_date'])){ echo date('d-m-Y', strtotime($result['order']['delivery_date'])); }else{ echo date('d-m-Y', strtotime($result['order']['shipping_date_slot']));} ?><br/>
						<?php if(!empty($result['order']['po_number'])){?>
						<b>Customer P.O No :</b> <?php echo $result['order']['po_number'];?><br/>
						<?php } ?>
						<?php if(!empty($result['order']['po_date'])){?>
						<b>P.O Date :</b> <?php echo date('d-m-Y', strtotime($result['order']['po_date'])); ?><br/>
						<?php } ?>
						<b>Order Number :</b> <?php echo $result['order']['invoice_prefix'] .'-'. $result['order']['order_no'];?><br/>
						<?php if(!empty($result['order']['quotation_no'])){?>
						<b>Quotation No :</b> <?php echo 'QTN-'. $this->customer->invoiceNmFormat($result['order']['quotation_no']);?><br/>
						<?php } ?>
					</td>
    			</tr>
				<tr><td colspan="2" style="width: 100%;border-bottom:1px solid #aaa"></td></tr>
			</table>
		</td>
	</tr>
</table>