<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Maha Al Fala Trading Company - Employee Transfer Detail</title>
	<style>
	*{padding:0px;margin:0px;}
	table {border-collapse:collapse; table-layout:fixed;line-height:1.5;}
    table td {word-wrap:break-word;}
	</style>
</head>
<body>
    <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
		<tr>
			<td></td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="0" style="font-size: 11px; width: 100%;">
		<tr>
			<td colspan="3">
				<table border="0" cellspacing="0" cellpadding="20" style="width: 100%;">
					<tr>
						<td></td>
					</tr>
				</table>
				<table width="100%" border="0" cellspacing="0" cellpadding="2">
                    <tr>
						<td valign="middle" height="10px" style="text-align: left;">Date: <?php echo $profession_detail['request_date'];?></td>
						<td valign="middle" height="10px" style="text-align: right;"><span style="direction: rtl;"> التاريخ : <?php echo $profession_detail['request_date'];?></span> </td>
					</tr>
				</table>
				<table width="100%" border="1" cellspacing="0" cellpadding="2">
                    <tr>
						<td colspan="2" valign="middle" style="text-align: center;"><strong> نموذج موافقة على تغيير المهنة </strong></td>
					</tr>
					<tr>
						<td colspan="2" valign="middle" style="text-align: center;"><strong> Change Profession Approval Form </strong></td>
					</tr>
                    <tr>
						<td valign="middle" style="text-align: left;">Employee Details</td>
						<td valign="middle" style="text-align: right;"><span style="direction: rtl;"> تفاصيل الموظف </span> </td>
					</tr>
				</table>
				<table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
					<tr>
						<td></td>
					</tr>
				</table>
				<table width="100%" border="1" cellspacing="0" cellpadding="2">
					<tr>
						<td valign="middle" style="text-align: left;">Employee ID</td>
						<td valign="middle" style="text-align: center;"><?php echo htmlspecialchars($profession_detail['emp_no'] ?? ''); ?> </td>
						<td valign="middle" style="text-align: right;"><span style="direction: rtl;"> رقم الموظف </span></td>
					</tr>

					<tr>
						<td valign="middle" style="text-align: left;">Employee Name</td>
						<td valign="middle" style="text-align: center;"><?php echo htmlspecialchars($profession_detail['full_name'] ?? ''); ?> </td>
						<td valign="middle" style="text-align: right;"><span style="direction: rtl;"> اسم الموظف </span></td>
					</tr>

					<tr>
						<td valign="middle" style="text-align: left;">Iqama Number</td>
						<td valign="middle" style="text-align: center;"><?php echo htmlspecialchars($profession_detail['iqama_no'] ?? ''); ?> </td>
						<td valign="middle" style="text-align: right;"><span style="direction: rtl;"> رقم الإقامة </span></td>
					</tr>

					<tr>
						<td valign="middle" style="text-align: left;">Current Profession</td>
						<td valign="middle" style="text-align: center;"><?php echo htmlspecialchars($profession_detail['old_profession_name'] ?? ''); ?> </td>
						<td valign="middle" style="text-align: right;"><span style="direction: rtl;"> المهنة الحالية </span></td>
					</tr>

					<tr>
						<td valign="middle" style="text-align: left;">New Profession</td>
						<td valign="middle" style="text-align: center;"><?php echo htmlspecialchars($profession_detail['new_profession_name'] ?? ''); ?> </td>
						<td valign="middle" style="text-align: right;"><span style="direction: rtl;"> المهنة الجديدة </span></td>
					</tr>

					<tr>
						<td valign="middle" style="text-align: left;">Fees</td>
						<td valign="middle" style="text-align: center;">SAR <?php echo number_format($profession_detail['fee_amount'], 2); ?> </td>
						<td valign="middle" style="text-align: right;"><span style="direction: rtl;"> الرسوم </span></td>
					</tr>

					<tr>
						<td valign="middle" style="text-align: left;">Debit Cost To</td>
						<td valign="middle" style="text-align: center;">
							<?php echo ($profession_detail['debit_cost_to'] == 'employee') ? 'Employee' : 'Company'; ?>
							<!-- <table>
								<tr>
									<td style="border:1px solid #000;width:18px;height:18px;text-align:center"><?= ($profession_detail['debit_cost_to'] == 'employee') ? '✔' : ''; ?></td>
									<td style="border:1px solid #000;width:18px;height:18px;text-align:center"><?= ($profession_detail['debit_cost_to'] == 'company') ? '✔' : ''; ?></td>
								</tr>
							</table> -->
						</td>
						<td valign="middle" style="text-align: right;"><span style="direction: rtl;"> تحميل التكلفة إلى </span></td>
					</tr>
				</table>
                <table><tr><td></td></tr></table>

                <table width="100%" cellspacing="0" cellpadding="5" border="1" style="font-size: 11px;">
					<tr>
						<td style="text-align:left;">I agreed to change my profession to the one mentioned above.</td>
                        <td style="text-align:right;"><span style="direction: rtl;"> أوافق على تغيير مهنتي إلى المهنة المذكورة أعلاه. </span></td>
                    </tr>
                </table>

				<table width="100%" cellspacing="0" cellpadding="5" border="1" style="font-size: 11px;">
					<tr>
						<td style="text-align:left;"><br><br>Signature & Thumb<br></td>
						<td style="text-align:center;"></td>
                        <td style="text-align:right;"><span style="direction: rtl;"><br> التوقيع والبصمة <br></span></td>
                    </tr>
					<tr>
						<td style="text-align:left;">Date</td>
						<td style="text-align:center;"></td>
                        <td style="text-align:right;"><span style="direction: rtl;"> التاريخ </span></td>
                    </tr>
                </table>
				<table><tr><td></td></tr></table>

                <table width="100%" cellspacing="0" cellpadding="5" border="1" style="font-size: 11px;">
					<tr>
						<td style="text-align:left;">Iqama Copy</td>
                        <td style="text-align:right;"><span style="direction: rtl;"> صورة الإقامة </span></td>
                    </tr>
					<tr>
						<td valign="middle" colspan="2" style="text-align:center;height:350px;">
							<?php if (!empty($profession_detail['iqama_copy'])): ?>
								<img src="<?php echo base_url($profession_detail['iqama_copy']); ?>" alt="Iqama Copy" width="300" />
							<?php else: ?>
								No Iqama Copy Available
							<?php endif; ?>
						</td>
					</tr>
                </table>
			</td>
		</tr>

	</table>
</body>

</html>
