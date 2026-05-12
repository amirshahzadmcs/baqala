<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Baqala Station - Marshalling Sheet</title>
<style>
*{padding:0px;margin:0px}
td {
	font-size: 12px;
}
</style>
</head>
<body>
    <table border="0" cellspacing="0" cellpadding="10" style="font-size: 14px; line-height: 22px;width:100%">
		<tr>
			<td valign="center" colspan="2" align="center"><img src="build/images/marshalling/header-top.jpg" alt="logo" /></td>
		</tr>

		<tr>
			<td valign="center" colspan="2" align="center">
				<h2><u>Marshaling Sheet</u></h2>
			</td>
		</tr>

		<tr style="border-bottom: 2px solid#000;">
			<td valign="top">
				<b>Consignment No : <?php echo $m_details->id;?> </b><br />
				<b>Total Shipment box : <?php echo $total_boxes[0]->total_packets; ?></b><br />
				<b>Delivery Executive : <?php echo $m_details->delivery_executive;?></b>
			</td>
			<td align="right" valign="top">
				<b>Date : <?php echo $m_details->created_at;?></b><br />
				<b>VAN No. : <?php echo $m_details->van_no;?></b>
			</td>
		</tr>

		<tr>
			<td colspan="2">
				<table width="100%" border="1" cellspacing="0" cellpadding="5">
					<tr>
						<td valign="top" bgcolor="#CCCCCC" style="width: 5%; padding: 10px 15px;"><strong>#</strong></td>
						<td valign="top" bgcolor="#CCCCCC" style="width: 10%; padding: 10px 15px;"><strong>Order ID </strong></td>
						<td valign="top" bgcolor="#CCCCCC" style="width: 10%; padding: 10px 15px;"><strong>Box No #</strong></td>
						<td valign="top" bgcolor="#CCCCCC" style="width: 12%; padding: 10px 15px;"><strong>Time Slot</strong></td>
						<td valign="top" bgcolor="#CCCCCC" style="width: 10%; padding: 10px 15px;"><strong>Payment Terms</strong></td>
						<td valign="top" bgcolor="#CCCCCC" style="width: 10%; padding: 10px 15px;"><strong>Amount in SAR</strong></td>
						<td valign="top" bgcolor="#CCCCCC" style="width: 13%; padding: 10px 15px;"><strong>Area</strong></td>
						<td valign="top" bgcolor="#CCCCCC" style="width: 30%; padding: 10px 15px;"><strong>Address</strong></td>
					</tr>
					<?php $sno = 1;foreach($results as $result){ ?>
					<tr>
						<td valign="top" style="padding: 10px 15px;"><?php echo $sno++;?></td>
						<td valign="top" style="padding: 10px 15px;"><?php echo $result->invoice_prefix .'-'. $result->id; ?></td>
						<td valign="top" style="padding: 10px 15px;">
							<?php $total_count = (int)$result->packets;?>
							<?php for($i = 1; $i <= $total_count; $i++){ ?>
								<?php echo $result->invoice_prefix .'-'. $result->id .'-'. $i;?><br/>
							<?php } ?>
						</td>
						<td valign="top" style="padding: 10px 15px;">
							<?php if($result->shipping_type == '1'){ echo 'ED'; }else{ echo $result->shipping_type;}?><br/>
							<?php $timeslot = explode('-', $result->shipping_time_slot); echo $timeslot[1]; ?>
						</td>
						<td valign="top" style="padding: 10px 15px;">
							<?php if($result->payment_method == ''){ ?>
								PENDING
							<?php }elseif($result->payment_method == 'Cash On Arrival'){ ?>
								COD
							<?php }else{ ?>
								PAID
							<?php } ?>
						</td>
						<td valign="top" style="padding: 10px 15px;"><?php echo $result->order_total;?></td>
						<td valign="top" style="padding: 10px 15px;"><?php echo $result->shipping_sector;?></td>
						<td valign="top" style="padding: 10px 15px;"><?php echo $result->shipping_complete_address;?></td>
					</tr>
					<?php } ?>
					<table style="width: 100%; border: 2px solid #000; margin-top: 10px; padding: 0 10px; border-left: none; border-right: none;">
						<tbody>
							<tr style="text-align: center;">
								<td style="width: 50%; text-align: left; font-size: 14px; font-weight: bold;">Total Orders: <?php echo count($results); ?></td>
								<td style="width: 50%; text-align: left; font-size: 14px; font-weight: bold;"></td>
							</tr>
						</tbody>
					</table>
					<br />
					<br />
					<br />

					<table width="100%" cellspacing="0" cellpadding="10">
						<tbody>
							<tr>
								<td valign="left" style="width: 50%; font-size: 14px; font-weight: bold; margin: 5px; display: inline-block; border: 1px solid #000; padding: 10px; height: 150px;">Marshller Comments:</td>
								<td valign="top" style="width: 50%; text-align: center; font-size: 14px; font-weight: bold;">
									<div style="border-top: 1px solid#000;">
									<p>Marshller Signature</p>
									</div>
									<br />
									<div style="border-top: 1px solid#000;">
									<p>Store Supervisor Signature</p>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</table>
			</td>
		</tr>
	</table>
</body>

</html>