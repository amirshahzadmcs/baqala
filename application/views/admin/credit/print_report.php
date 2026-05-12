<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Baqala Station - Credit Account Report</title>
		<style>
		*{padding:0px;margin:0px}
		</style>
	</head>
	<body>
		<table border="0" cellspacing="0" cellpadding="5" style="font-size: 11px; line-height: 12px; width: 100%;">
			<tr><td></td></tr>
			<tr><td></td></tr>
			<?php
				if($this->input->get('from') !== '' && $this->input->get('to') !== ''){
					$report_date = date("d-m-Y", strtotime($this->input->get('from'))) .' To '. date("d-m-Y", strtotime($this->input->get('to')));
				}else{
					$report_date = date("d-m-Y", strtotime(date('y-m-d')));
				}
			?>
			<tr>
				<td>
					<table border="0" cellspacing="0" cellpadding="1" style="font-size: 12px;font-weight: 600;">
						<tr>
							<td valign="top" align="top" style="padding: 10px;width:40%;">
								<table>
									<tr>
										<td><?= $credit_account->account_no;?> - <?php echo strtoupper($user_detail->company_name); ?></td>
									</tr>
									<tr>
										<td><?php echo $user_address->building_no .', '; ?><?php echo $user_address->street_name .', '; ?><?php echo $user_address->district .', '; ?></td>
									</tr>
									<tr>
										<td>Unit No. <?php echo $user_address->unit_no; ?>, <?php echo $user_address->city .' '. $user_address->postal_code .' - '. $user_address->additional_no; ?></td>
									</tr>
									<tr>
										<td><?php echo $user_address->country; ?></td>
									</tr>
									<tr>
										<td>Contact Name : <?php echo $user_detail->name; ?></td>
									</tr>
									<tr>
										<td>Mobile : <?php echo $user_detail->mobile; ?></td>
									</tr>
									<tr>
										<td>E-mail : <?php echo $user_detail->email; ?></td>
									</tr>
								</table>
							</td>
							<td valign="top" align="top" style="width:26.5%"></td>
							<td valign="middle" align="top" style="padding: 10px;border:1px solid #000;">
								<table border="0" cellspacing="0" cellpadding="1">
									<tr><td style="line-height: 5px;"></td></tr>
									<tr>
										<td class="px-3" style="width:40%">&nbsp;&nbsp;Credit Term</td>
										<td class="px-3">: &nbsp;<?php echo $credit_account->credit_days .' Days'; ?></td>
									</tr>
									<tr>
										<td class="px-3" style="width:40%">&nbsp;&nbsp;Credit Limit</td>
										<td class="px-3">: &nbsp;<?php echo bcdiv($credit_account->max_credit_limit, 1, 2); ?></td>
									</tr>
									<tr>
										<td class="px-3" style="width:40%">&nbsp;&nbsp;Credit Utilized</td>
										<td class="px-3">: &nbsp;<?php echo bcdiv(($credit_account->max_credit_limit - $credit_account->credit_avilable), 1, 2); ?></td>
									</tr>
									<tr>
										<td class="px-3" style="width:40%">&nbsp;&nbsp;Credit Balance</td>
										<td class="px-3">: &nbsp;<?php echo bcdiv($credit_account->credit_avilable, 1, 2); ?></td>
									</tr>
									<tr>
										<td class="px-3" style="width:40%">&nbsp;&nbsp;Sales AM</td>
										<td class="px-3">: &nbsp;N/A</td>
									</tr>
									<tr>
										<td class="px-3" style="width:40%">&nbsp;&nbsp;Sales AM Email</td>
										<td class="px-3">: &nbsp;N/A</td>
									</tr>
									<tr><td style="line-height: 5px;"></td></tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td align="center"><h3><b>AGING&nbsp; ANALYSIS</b></h3></td>
			</tr>
			<tr>
				<td style="width: 100%;">
					<table class="age-table" width="100%" border="1" cellspacing="0" cellpadding="5" style="font-size: 11px;">
						<tr>
							<td valign="top" bgcolor="#80bffe" style="width: 14.28%; text-align: center;">Balance</td>
							<td valign="top" bgcolor="#80bffe" style="width: 14.28%; text-align: center;">Current</td>
							<td valign="top" bgcolor="#80bffe" style="width: 14.28%; text-align: center;">> 30 Days</td>
							<td valign="top" bgcolor="#80bffe" style="width: 14.28%; text-align: center;">> 90 Days</td>
							<td valign="top" bgcolor="#80bffe" style="width: 14.28%; text-align: center;">> 180 Days</td>
							<td valign="top" bgcolor="#80bffe" style="width: 14.28%; text-align: center;">> 270 Days</td>
							<td valign="top" bgcolor="#80bffe" style="width: 14.28%; text-align: center;">> 365 Days</td>
						</tr>
						<tr align="right">
						<td><b><?= bcdiv($debit_age['balance']->debit_bal, 1, 2);?></b></td>
						<td><b><?= bcdiv($current_debit_balance->current_debit_bal, 1, 2);?></b></td>
						<td><b><?= bcdiv($debit_age['day_30']->total_debit, 1, 2);?></b></td>
						<td><b><?= bcdiv($debit_age['day_90']->total_debit, 1, 2);?></b></td>
						<td><b><?= bcdiv($debit_age['day_180']->total_debit, 1, 2);?></b></td>
						<td><b><?= bcdiv($debit_age['day_270']->total_debit, 1, 2);?></b></td>
						<td><b><?= bcdiv($debit_age['day_365']->total_debit, 1, 2);?></b></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr><td align="left">Please find below the Statement of Account as at <?= $report_date;?></td></tr>
			
			<tr>
				<td style="width: 100%;">
					<table class="age-table" width="100%" border="1" cellspacing="0" cellpadding="5" style="font-size: 11px;">
						<tr>
							<td valign="top" bgcolor="#80bffe" style="width: 10%; text-align: center;">Date</td>
							<td valign="top" bgcolor="#80bffe" style="width: 14%; text-align: center;">Invoice Number</td>
							<td valign="top" bgcolor="#80bffe" style="width: 11%; text-align: center;">Reference</td>
							<td valign="top" bgcolor="#80bffe" style="width: 38%; text-align: center;">Description</td>
							<td valign="top" bgcolor="#80bffe" style="width: 9%; text-align: center;">Debit</td>
							<td valign="top" bgcolor="#80bffe" style="width: 9%; text-align: center;">Credit</td>
							<td valign="top" bgcolor="#80bffe" style="width: 9%; text-align: center;">Balance</td>
						</tr>
						<?php 
							$balance = 0;
							if(!empty($debit_reports)){ $i=1;foreach($debit_reports as $report){
							$debit = $report->debit;
							$balance += $debit; 
						?>
						<tr align="right">
							<td align="center"><?php echo formatedDate($report->created_at); ?></td>
							<td align="center"><?php echo 'INV-'.$report->invoice_no; ?></td>
							<td align="center"><?php echo $report->po_no; ?></td>
							<td align="left"><?php echo $report->remarks; ?></td>
							<td style="color: green;"><?php echo bcdiv($debit, 1, 2); ?></td>
							<td><?php echo ($report->credit > 0) ? bcdiv($report->credit, 1, 2) : '0.00'; ?></td>
							<td style="color: green;"><?php echo bcdiv($balance, 1, 2); ?></td>
						</tr>
						<?php } ?>
						<tr align="right">
							<td colspan="4"><b>Total Debit/Credit By Client / Source / Scheme</b></td>
							<td><b><?php echo bcdiv($balance, 1, 2); ?></b></td>
							<td><b><?php echo ($report->credit > 0) ? bcdiv($report->credit, 1, 2) : '0.00'; ?></b></td>
							<td><b><?php echo bcdiv($balance, 1, 2); ?></b></td>
						</tr>
						<tr align="right">
							<td colspan="4"><b>Total Debit/Credit By Client / Source</b></td>
							<td><b><?php echo bcdiv($balance, 1, 2); ?></b></td>
							<td><b><?php echo ($report->credit > 0) ? bcdiv($report->credit, 1, 2) : '0.00'; ?></b></td>
							<td><b><?php echo bcdiv($balance, 1, 2); ?></b></td>
						</tr>
						
						<?php }else{ ?>
							<tr>
								<td colspan="7" align="center">No data found</td>
							</tr>
						<?php } ?>
					</table>
				</td>
			</tr>

			<!---- Credit ------>
			<br pagebreak="true" />
			<tr><td></td></tr>
			<tr>
				<td>
					<table border="0" cellspacing="0" cellpadding="1" style="font-size: 12px;font-weight: 600;">
						<tr>
							<td valign="top" align="top" style="padding: 10px;width:40%;">
								<table>
									<tr>
										<td><?= $credit_account->account_no;?> - <?php echo strtoupper($user_detail->company_name); ?></td>
									</tr>
									<tr>
										<td><?php echo $user_address->building_no .', '; ?><?php echo $user_address->street_name .', '; ?><?php echo $user_address->district .', '; ?></td>
									</tr>
									<tr>
										<td>Unit No. <?php echo $user_address->unit_no; ?>, <?php echo $user_address->city .' '. $user_address->postal_code .' - '. $user_address->additional_no; ?></td>
									</tr>
									<tr>
										<td><?php echo $user_address->country; ?></td>
									</tr>
									<tr>
										<td>Contact Name : <?php echo $user_detail->name; ?></td>
									</tr>
									<tr>
										<td>Mobile : <?php echo $user_detail->mobile; ?></td>
									</tr>
									<tr>
										<td>E-mail : <?php echo $user_detail->email; ?></td>
									</tr>
								</table>
							</td>
							<td valign="top" align="top" style="width:26.5%"></td>
							<td valign="middle" align="top" style="padding: 10px;border:1px solid #000;">
							<table border="0" cellspacing="0" cellpadding="1">
									<tr><td style="line-height: 5px;"></td></tr>
									<tr>
										<td class="px-3" style="width:40%">&nbsp;&nbsp;Credit Term</td>
										<td class="px-3">: &nbsp;<?php echo $credit_account->credit_days .' Days'; ?></td>
									</tr>
									<tr>
										<td class="px-3" style="width:40%">&nbsp;&nbsp;Credit Limit</td>
										<td class="px-3">: &nbsp;<?php echo bcdiv($credit_account->max_credit_limit, 1, 2); ?></td>
									</tr>
									<tr>
										<td class="px-3" style="width:40%">&nbsp;&nbsp;Credit Utilized</td>
										<td class="px-3">: &nbsp;<?php echo bcdiv(($credit_account->max_credit_limit - $credit_account->credit_avilable), 1, 2); ?></td>
									</tr>
									<tr>
										<td class="px-3" style="width:40%">&nbsp;&nbsp;Credit Balance</td>
										<td class="px-3">: &nbsp;<?php echo bcdiv($credit_account->credit_avilable, 1, 2); ?></td>
									</tr>
									<tr>
										<td class="px-3" style="width:40%">&nbsp;&nbsp;Sales AM</td>
										<td class="px-3">: &nbsp;N/A</td>
									</tr>
									<tr>
										<td class="px-3" style="width:40%">&nbsp;&nbsp;Sales AM Email</td>
										<td class="px-3">: &nbsp;N/A</td>
									</tr>
									<tr><td style="line-height: 5px;"></td></tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<!--
			<tr>
				<td align="center"><h3><b>AGING&nbsp; ANALYSIS</b></h3></td>
			</tr>
			<tr>
				<td style="width: 100%;">
					<table class="age-table" width="100%" border="1" cellspacing="0" cellpadding="5" style="font-size: 11px;">
						<tr>
							<td valign="top" bgcolor="#80bffe" style="width: 14.28%; text-align: center;">Balance</td>
							<td valign="top" bgcolor="#80bffe" style="width: 14.28%; text-align: center;">Current</td>
							<td valign="top" bgcolor="#80bffe" style="width: 14.28%; text-align: center;">> 30 Days</td>
							<td valign="top" bgcolor="#80bffe" style="width: 14.28%; text-align: center;">> 90 Days</td>
							<td valign="top" bgcolor="#80bffe" style="width: 14.28%; text-align: center;">> 180 Days</td>
							<td valign="top" bgcolor="#80bffe" style="width: 14.28%; text-align: center;">> 270 Days</td>
							<td valign="top" bgcolor="#80bffe" style="width: 14.28%; text-align: center;">> 365 Days</td>
						</tr>
						<tr align="right">
							<td><b><?= bcdiv($credit_age['balance']->credit_bal, 1, 2);?></b></td>
							<td><b><?= bcdiv($current_credit_balance->current_credit_bal, 1, 2);?></b></td>
							<td><b><?= bcdiv($credit_age['day_30']->total_credit, 1, 2);?></b></td>
							<td><b><?= bcdiv($credit_age['day_90']->total_credit, 1, 2);?></b></td>
							<td><b><?= bcdiv($credit_age['day_180']->total_credit, 1, 2);?></b></td>
							<td><b><?= bcdiv($credit_age['day_270']->total_credit, 1, 2);?></b></td>
							<td><b><?= bcdiv($credit_age['day_365']->total_credit, 1, 2);?></b></td>
						</tr>
					</table>
				</td>
			</tr>
			-->
			<tr><td align="left">Please find below the Statement of Account as at <?= $report_date;?></td></tr>
			
			<tr>
				<td style="width: 100%;">
					<table class="age-table" width="100%" border="1" cellspacing="0" cellpadding="5" style="font-size: 11px;">
						<tr>
							<td valign="top" bgcolor="#80bffe" style="width: 10%; text-align: center;">Date</td>
							<td valign="top" bgcolor="#80bffe" style="width: 14%; text-align: center;">Invoice Number</td>
							<td valign="top" bgcolor="#80bffe" style="width: 11%; text-align: center;">Reference</td>
							<td valign="top" bgcolor="#80bffe" style="width: 38%; text-align: center;">Description</td>
							<td valign="top" bgcolor="#80bffe" style="width: 9%; text-align: center;">Debit</td>
							<td valign="top" bgcolor="#80bffe" style="width: 9%; text-align: center;">Credit</td>
							<td valign="top" bgcolor="#80bffe" style="width: 9%; text-align: center;">Balance</td>
						</tr>
						<?php 
							$cbalance = 0;
							if(!empty($credit_reports)){ $i=1;foreach($credit_reports as $report){
							$credit = $report->credit;
							$cbalance += $credit; 
						?>
						<tr align="right">
							<td align="center"><?php echo formatedDate($report->created_at); ?></td>
							<td align="center"><?php echo $report->invoice_no; ?></td>
							<td align="center"><?php echo 'INV-'.$report->po_no; ?></td>
							<td align="left"><?php echo $report->remarks; ?></td>
							<td><?php echo ($report->debit > 0) ? bcdiv($report->debit, 1, 2) : '0.00'; ?></td>
							<td style="color: green;"><?php echo bcdiv($credit, 1, 2); ?></td>
							<td style="color: green;"><?php echo bcdiv((0 - $cbalance), 1, 2); ?></td>
						</tr>
						<?php } ?>
						<tr align="right">
							<td colspan="4"><b>Total Debit/Credit By Client / Source / Scheme</b></td>
							<td><b>0.00</b></td>
							<td><b><?php echo bcdiv($cbalance, 1, 2); ?></b></td>
							<td><b><?php echo bcdiv((0 - $cbalance), 1, 2); ?></b></td>
						</tr>
						<tr align="right">
							<td colspan="4"><b>Total Debit/Credit By Client / Source</b></td>
							<td><b>0.00</b></td>
							<td><b><?php echo bcdiv($cbalance, 1, 2); ?></b></td>
							<td><b><?php echo bcdiv((0 - $cbalance), 1, 2); ?></b></td>
						</tr>
						<tr align="right">
							<td colspan="4"><b>Total Debit/Credit By Client</b></td>
							<td><b><?= $total_debits = bcdiv($debit_age['balance']->debit_bal, 1, 2);?></b></td>
							<td><b><?= $total_credits = bcdiv($credit_age['balance']->credit_bal, 1, 2);?></b></td>
							<td><b><?= bcdiv($total_debits - $total_credits, 1, 2);?></b></td>
						</tr>
						<?php }else{ ?>
							<tr>
								<td colspan="7" align="center">No data found</td>
							</tr>
						<?php } ?>
					</table>
				</td>
			</tr>
		</table>

	</body>
</html>
