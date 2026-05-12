<?php if(!empty($reports)){ ?>
<table class="table" width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td align="left" valign="top" style="border:0px solid #fff">
			<h6 style="padding-bottom: 0px; margin-bottom: 0px;"><strong>Maha Alfala Trading Est.</strong></h6>
			<h6 style="padding-bottom: 0px; margin-top: 0px;"><strong>Riyadh</strong></h6>
			<p style="padding-bottom: 0px; margin-bottom: 0px;">VAT No: <?php echo COMPANY_VAT_NO ?></p>
		</td>
		<td align="left" valign="top" style="border:0px solid #fff">
			<h6 style="padding-bottom: 0px; margin-bottom: 0px;"><strong>Rider Name : </strong><?php echo $user_info['full_name'];?></h6>
			<p style="padding-bottom: 0px; margin-bottom: 0px;"><strong>Delivery Summary of Period:</strong> &nbsp;<?php echo !empty($search_start_date) ? date("d M Y", strtotime($search_start_date)) : 'NA';?> &nbsp;&nbsp;<strong>To:</strong> &nbsp;<?php echo !empty($search_end_date) ? date("d M Y", strtotime($search_end_date)) : 'NA';?></p>
			<h6 style="padding-bottom: 0px; margin-bottom: 0px;"><strong>Report Of : </strong>Hunger Station</h6><br/>
		</td>
	</tr>
	
	<tr>
		<td colspan="3">
			<table class="table" width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr style="border-top: 2px solid;border-bottom: 2px solid;background: #ffe9a9;">
					<td valign="top" style="width: 7%;text-align:center;"><strong>Sr. No.</strong></td>
					<td valign="top" style="width: 11%;text-align:center;"><strong>Date</strong></td>
					<td valign="top" style="width: 9%;text-align:right;"><strong>Notified Delivery</strong></td>
					<td valign="top" style="width: 9%;text-align:right;"><strong>Completed Delivery</strong></td>
					<td valign="top" style="width: 9%;text-align:right;"><strong>Cancelled Deliveries</strong></td>
					<td valign="top" style="width: 9%;text-align:right;"><strong>Declined Deliveries</strong></td>
					<td valign="top" style="width: 9%;text-align:right;"><strong>Accepted Deliveries</strong></td>
					<td valign="top" style="width: 10%;text-align:right;"><strong>Not Accepted Deliveries</strong></td>
					<td valign="top" style="width: 9%;text-align:right;"><strong>Unattended Deliveries</strong></td>
					<td valign="top" style="width: 9%;text-align:right;"><strong>ID Fine</strong></td>
					<td valign="top" style="width: 9%;text-align:right;"><strong>Online Hours</strong></td>
				</tr>
				<?php
					$sumTotalNotifiedDelv = 0;
					$sumTotalCompleteDelv = 0;
					$sumTotalCancelledDelv = 0;
					$sumTotalDeclinedDelv = 0;
					$sumTotalAcceptDelv = 0;
					$sumTotalAcceptRate = 0;
					$sumTotalNotAcceptDelv = 0;
					$sumTotalIDF = 0;
					$sumTotalOH = 0;
					$sumTotalRiders = 0;
				?>
				
				<?php $i=1;foreach($reports as $report){
					$sumTotalNotifiedDelv += $report['notified_deliveries'];
					$sumTotalCompleteDelv += $report['completed_deliveries'];
					$sumTotalCancelledDelv += $report['cancelled_deliveries'];
					$sumTotalDeclinedDelv += $report['declined_deliveries'];
					$sumTotalNotAcceptDelv += $report['not_accepted_deliveries'];
					$sumTotalAcceptDelv += $report['accepted_deliveries'];
					$sumTotalIDF += $report['fine'];
					$sumTotalOH += $report['working_hours'];
				?>
				<tr class="item-list">
					<td valign="top" style="text-align:center;"><?php echo $i++;?>.</td>
					<td valign="top" style="text-align:center;"><?php echo date('d-m-Y', strtotime($report['date_local']));?></td>
					<td valign="top" style="text-align:right;"><?php echo $report['notified_deliveries'];?></td>
					<td valign="top" style="text-align:right;"><?php echo $report['completed_deliveries'];?></td>
					<td valign="top" style="text-align:right;"><?php echo $report['cancelled_deliveries'];?></td>
					<td valign="top" style="text-align:right;"><?php echo $report['declined_deliveries'];?></td>
					<td valign="top" style="text-align:right;"><?php echo $report['accepted_deliveries'];?></td>
					<td valign="top" style="text-align:right;"><?php echo $report['not_accepted_deliveries'];?></td>
					<td valign="top" style="text-align:right;"><?php echo ($report['cancelled_deliveries'] + $report['declined_deliveries'] + $report['not_accepted_deliveries']);?></td>
					<td valign="top" style="text-align:right;"><?php echo number_format($report['fine'], 2);?></td>
					<td valign="top" style="text-align:right;"><?php echo $report['working_hours'];?></td>
				</tr>
				<?php } ?>
				<tr>
					<td colspan="2" valign="top" style="text-align:right;"></td>
					<td valign="top" style="text-align:right;"><p style="border-top: 2px solid;border-bottom: 2px solid;"><?php echo $sumTotalNotifiedDelv;?></p></td>
					<td valign="top" style="text-align:right;"><p style="border-top: 2px solid;border-bottom: 2px solid;"><?php echo $sumTotalCompleteDelv;?></p></td>
					<td valign="top" style="text-align:right;"><p style="border-top: 2px solid;border-bottom: 2px solid;"><?php echo $sumTotalCancelledDelv;?></p></td>
					<td valign="top" style="text-align:right;"><p style="border-top: 2px solid;border-bottom: 2px solid;"><?php echo $sumTotalDeclinedDelv;?></p></td>
					<td valign="top" style="text-align:right;"><p style="border-top: 2px solid;border-bottom: 2px solid;"><?php echo $sumTotalAcceptDelv;?></p></td>
					<td valign="top" style="text-align:right;"><p style="border-top: 2px solid;border-bottom: 2px solid;"><?php echo $sumTotalNotAcceptDelv;?></p></td>
					<td valign="top" style="text-align:right;"><p style="border-top: 2px solid;border-bottom: 2px solid;"><?php echo ($sumTotalCancelledDelv + $sumTotalDeclinedDelv + $sumTotalNotAcceptDelv);?></p></td>
					<td valign="top" style="text-align:right;"><p style="border-top: 2px solid;border-bottom: 2px solid;"><?php echo number_format($sumTotalIDF, 2);?></p></td>
					<td valign="top" style="text-align:right;"><p style="border-top: 2px solid;border-bottom: 2px solid;"><?php echo number_format($sumTotalOH, 2);?></p></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php }else{ ?>
<div class="card-body">
	<h4><center>No Data Found</center></h4>
</div>
<?php } ?>
