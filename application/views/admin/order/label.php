<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="UTF-8">
		<meta content="" name="description">
		<meta content="IE=edge" http-equiv="X-UA-Compatible">
		<meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
		<title>Baqala Station | Label</title>
	</head>
    <body>
	<?php $print = 1;$total_count = (int)$result['order']['packets'];?>
	<?php for($print = 1; $print <= $total_count; $print++){ ?>
	<div>
		<table width="360px" height="280px" border="1" align="left" cellpadding="0" cellspacing="0">
			<tr style="border-bottom: 1px solid#000; padding: 8px 0px;">
				<td>
					<table width="100%" border="0" align="left" cellpadding="1" cellspacing="0">
						<tr>
							<td width="50%" align="left" valign="left">
								<table width="100%" align="left" cellpadding="5" cellspacing="0">
									<tr>
										<td valign="left">
											<img src="<?php echo base_url('admin_assets/images/label/logo.png');?>" width="60" />
										</td>
									</tr>
								</table>
							</td>
							<td width="50%" align="right">
								<table width="100%" border="0" align="left" cellpadding="1" cellspacing="0">
									<tr>
										<td width="30%" align="right" valign="middle">
											<?php if($result['order']['shipping_type'] !== '1'){ ?>
												<table width="100%" align="center" cellpadding="1" cellspacing="6">
													<tr>
														<td border="1" valign="middle"><b style="font-size: 18px; font-weight: 600;"><?php echo $result['order']['shipping_type'];?></b></td>
													</tr>
												</table>
											<?php } ?>
										</td>
										<td width="70%" align="right" valign="middle">
											<table width="100%" align="center" cellpadding="0" cellspacing="0">
												<tr>
													<td>
														<b style="font-size: 18px; font-weight: 700;">
														<?php if($result['order']['payment_method'] == ''){ ?>
															PENDING
														<?php }elseif($result['order']['payment_method'] == 'COD'){ ?>
															COD
														<?php }elseif($result['order']['payment_method'] == 'Credit'){ ?>
															CR
														<?php }elseif($result['order']['payment_method'] == 'Cash Advance'){ ?>
															CA
														<?php }else{ ?>
															PAID
														<?php } ?>
														</b>
													</td>
												</tr>
												<?php if($result['order']['shipping_type'] == '1'){ ?>
												<tr><td><b>ED</b></td></tr>
												<?php } ?>
												
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr style="border-bottom: 1px solid #000;">
				<td>
					<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
						<tr>
							<td width="58%" align="left" valign="left" style="border-right: 1px solid #000">
								<table width="100%" align="left" cellpadding="5" border="0" cellspacing="0">
									<tr>
										<td valign="left" style="font-size:11px;height:30px;">
											<b>Customer Name</b>:<br/> <?php echo $result['order']['name'];?>
										</td>
									</tr>
									<tr>
										<td valign="left" style="font-size:11px;height:70px;">
											<b>Full Address : (<?php echo $result['order']['shipping_addrstype'];?>)</b><br/>
											<?php echo $result['order']['villa_building'];?>, <?php echo $result['order']['shipping_complete_address'];?>
										</td>
									</tr>
									<tr>
										<td valign="left" style="border-bottom: 1px solid #000;">
											<p>CZ:<b> SA-RUH-<?php echo strtoupper($result['order']['shipping_street']);?></b></p>
										</td>
									</tr>
									<tr>
										<td>
											<table width="100%" cellpadding="0" border="0" cellspacing="0">
												<tr>
													<td align="left" valign="top" style="height:10px">HUB:</td>
													<td align="right" style="font-size: 12px; font-weight: bold;height:10px"><?php echo $this->admin->getWarehouseDetail()->partner_code;?></td>
												</tr>
											</table>
										</td>
									</tr>
									<!--
									<tr>
										<td style="font-size: 15px; font-weight: bold;">RUH - 01 <span style="float: right;"></span></td>
									</tr>
									-->
								</table>
							</td>
							<td width="42%" align="left" valign="left">
								<table width="100%" align="left" cellpadding="1" border="0" cellspacing="0">
									<tr>
										<td valign="middle" align="center">
										    <?php //if(!empty($result['order']['delivery_date']) || $result['order']['order_status_id'] == '6'){ ?>
                                			<?php $qrimg = base_url().'uploads/qrcodes/'.$result['order']['trans_id'].'-Qrcode.png'; ?>
                                			<img width="100px" style="text-align: center;display: table;" src="<?php echo $qrimg;?>" alt="qr-code"><br/>
                                			<?php //} ?>
											<b><?php echo $result['order']['invoice_prefix'] .'-'. $result['order']['order_no'] .'-'. $print;?></b>
										</td>
									</tr>
									<tr>
										<td>
											<table width="100%" align="left" cellpadding="2" border="0" cellspacing="0">
												<tr>
													<td align="left" style="font-size:10px;">ORDER ID:</td>
													<td align="right" style="font-size:10px;"><b><?php echo $result['order']['invoice_prefix'] .'-'. $result['order']['order_no']; ?></b></td>
												</tr>
												<tr>
													<td align="left" style="width:50%;font-size:10px;"><?php if(!empty($result['order']['delivery_date'])){ echo date('M d, Y', strtotime($result['order']['delivery_date'])); }else{ echo date('M d, Y', strtotime($result['order']['shipping_date_slot']));} ?></td>
													<td align="right" style="font-size:10px;"><b><?php $timeslot = explode('-', $result['order']['shipping_time_slot']); echo $timeslot[1]; ?></b></td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>	
	<?php } ?>
	</body>
</html>