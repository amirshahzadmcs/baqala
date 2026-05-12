<table border="0" cellspacing="0" cellpadding="1" style="font-size: 10px; width: 100%;">
	<tr>
		<td colspan="2" style="border-top:30px solid #35aa59"></td>
	</tr>
	<tr>
		<td colspan="2"></td>
	</tr>
	<tr>
		<td colspan="2"><img src="<?php echo base_url('admin_assets/images/job-card/header-top.jpg');?>" style="max-width: 100%;" /></td>
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
					<td align="left" valign="top" style="width: 40%;">
						<h4 style="font-size: 13px;"><strong>Job Card Information</strong></h4>
						<table>
							<tr>
								<td>Ref. No.</td>
								<td>: <?php echo 'JC-'. invoiceNmFormat($order->id); ?></td>
							</tr>
							<tr>
								<td>Job Type</td>
								<td>: <?php echo $order->job_type; ?></td>
							</tr>
							<tr>
								<td>Job Date</td>
								<td>: <?php echo date("d-m-Y", strtotime($order->job_date)); ?></td>
							</tr>
							<tr>
								<td>Rider Name</td>
								<td>: <?php echo $order->rider_name; ?></td>
							</tr>
						</table>
					</td>
					<td align="left" valign="top" style="width: 20%;">
						
					</td>
					<td valign="top" style="width: 30%;text-align: left;">
						<h4 style="font-size: 13px;"><strong>Vehicle Information</strong></h4>
						<table>
							<tr>
								<td>Vehicle Number</td>
								<td>: <?php echo $order->bike_no; ?></td>
							</tr>
							<tr>
								<td>Purchase Date</td>
								<td>: <?php echo date("d-m-Y", strtotime($order->vehicle_p_date)); ?></td>
							</tr>
							<tr>
								<td>Vehicle Make</td>
								<td>: <?php echo $order->vehicle_make; ?></td>
							</tr>
							<tr>
								<td>Vehicle Type</td>
								<td>: <?php echo $order->vehicle_type; ?></td>
							</tr>
							<tr>
								<td>Vehicle Color</td>
								<td>: <?php echo $order->vehicle_color; ?></td>
							</tr>
							<tr>
								<td>Vehicle Year</td>
								<td>: <?php echo $order->vehicle_year; ?></td>
							</tr>
							<tr>
								<td>Meter Reading</td>
								<td>: <?php echo round($order->meter_reading, 2); ?> KM</td>
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
