<table border="0" cellspacing="0" cellpadding="1" style="font-size: 10px; width: 100%;">
	<tr>
		<td colspan="2" style="border-top:30px solid #35aa59"></td>
	</tr>
	<tr>
		<td colspan="2"></td>
	</tr>
	<tr>
		<td colspan="2"><img src="admin_assets/images/invoice/corporate/header-top.jpg" style="max-width: 100%;" /></td>
	</tr>
	<tr>
		<td style="width: 3%;"></td>
		<td colspan="3" style="border-top:1px solid #e0b500;width: 95%;"></td>
		<td style="width: 2%;"></td>
	</tr>
	<tr>
	    <td style="width: 20%;">
			<?php if(!empty($result['order']['delivery_date']) || $result['order']['order_status_id'] == '6'){ ?>
			<?php $qrimg = base_url().'uploads/qrcodes/'.$result['order']['trans_id'].'-Qrcode.png'; ?>
			<img width='100px' src="<?php echo $qrimg;?>">
			<?php } ?>
		</td>
		<td style="width: 80%;">
			<table cellspacing="0" cellpadding="3" style="font-size: 10px; width: 100%;">
				<tr>
				    <td align="right" valign="top" style="width: 25%;"><?php if(!empty($result['order']['payment_code'])){?> <?php echo $result['order']['payment_code']; ?> <b> رقم المرجع العابر :</b><br/><?php } ?>
						<?php if($result['order']['order_status_id'] == '6'){?>
						<?php echo $result['order']['invoice_prefix'] .'-'. $result['order']['order_no'];?> <b> رقم الفاتورة :</b><br/>
						<?php if(!empty($result['order']['delivery_date'])){ echo date('d-m-Y', strtotime($result['order']['delivery_date'])); }else{ echo date('d-m-Y', strtotime($result['order']['shipping_date_slot']));} ?> <b> تاريخ الفاتورة :</b> <br/>
						<?php }else{ ?>
						N/A <b> رقم الفاتورة :</b><br/>
						N/A <b> تاريخ الفاتورة :</b><br/>
						<?php } ?>
						<?php echo $result['order']['order_no'];?> <b> رقم مذكرة تسليم :</b> <br/>
						<?php if(!empty($result['order']['delivery_date'])){ echo date('d-m-Y', strtotime($result['order']['delivery_date'])); }else{ echo date('d-m-Y', strtotime($result['order']['shipping_date_slot']));} ?> <b> تاريخ التسليم :</b> <br/>
						<?php if(!empty($result['order']['po_number'])){?>
						<?php echo $result['order']['po_number'];?> <b> رقم طلب الشراء :</b> <br/>
						<?php } ?>
						<?php if(!empty($result['order']['po_date'])){?>
						<?php echo date('d-m-Y', strtotime($result['order']['po_date'])); ?> <b> تاريخ طلب الشراء :</b> <br/>
						<?php } ?>
						<?php echo $result['order']['invoice_prefix'] .'-'. $result['order']['order_no'];?> <b> رقم الطلب :</b> <br/>
						<?php if(!empty($result['order']['quotation_no'])){?>
						<?php echo 'QTN-'.str_pad($result['order']['quotation_no'], 6, 0, STR_PAD_LEFT);?> <b> رقم التسعيرة :</b> <br/>
						<?php } ?>
						<?php echo $result['order']['payment_method']; ?> <b> طريقة الدفع :</b> 
					</td>
					<td valign="top" style="width: 25%;"></td>
					<td valign="top" style="width: 50%; float: right;text-align:right;"><strong> تفاصيل العميل :</strong><br/>
					<?php if(!empty($result['order']['c_company'])) { ?>
					<?php echo $result['order']['c_company'];?> <b> اسم الشركة :</b> <br />
					<?php } ?>
					<?php if($result['order']['c_role'] == 2){ echo $result['order']['c_vat'] .  '<b>رقم ضريبة الشركة : </b> ';  ?><br/><?php } ?>
					<?php echo $result['order']['name'];?> <strong> جهة الأتصال :</strong> <br />
					<?php echo $result['order']['building_no'];?> <?php echo $result['order']['street_name'];?> - <?php echo $result['order']['district_name'];?> <strong> العنوان :</strong> <br/>
					رقم الوحدة : <?php echo $result['order']['unit_no'];?><br/>
					<?php echo $result['order']['city_name'];?> <?php echo $result['order']['zip_code'];?> - <?php echo $result['order']['additional_no'];?><br/>
					<?php echo $result['order']['country'];?><br/><br/>
					
					<b> عنوان الشحن :</b><br />
					<?php echo $result['order']['shipping_person_name'];?> / <?= $result['order']['c_company']; ?><br/>
					<?php echo $result['order']['shipping_mobile'];?>, <?php echo $result['order']['shipping_email'];?><br/>
					<?php echo $result['order']['villa_building'];?>-<?php echo $result['order']['shipping_house_no'];?>, <?php echo $result['order']['shipping_street'];?><br/>
					<?php echo $result['order']['shipping_city'];?> <?php echo $result['order']['shipping_postcode'];?><br/>
					<?php echo $result['order']['shipping_country'];?>
					</td>
					
				</tr>
				
			</table>
		</td>
	</tr>
	<tr>
	<td style="width: 3%;"></td>
		<td colspan="3" style="border-top:1px solid #e0b500;border-bottom:1px solid #e0b500;width: 95%;line-height:20px;"><h4 style="font-size: 13px;padding:5px;">Invoice Detail</h4></td>
		<td style="width: 2%;"></td>
	</tr>
</table>