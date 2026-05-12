<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Maha Al Fala Trading Company - Personal Finance Request Form</title>
	<style>
	*{padding:0px;margin:0px;}
	table {border-collapse:collapse; table-layout:fixed;line-height:1.5;}
    table td {word-wrap:break-word;}
	.checkbox-text {
		font-size: 16px;
		line-height: 5px;
		vertical-align: bottom;
	}
	</style>
</head>
<body>
    <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
		<tr>
			<td colspan="2" valign="center" style="text-align: right;font-size: 24px;line-height:0px;"><img src="<?php echo base_url('admin_assets/images/maha-al-fala.jpg');?>" height="50px"></td>
		</tr>
		<tr>
			<td valign="top" style="width:45%;text-align: left;font-size: 16px;line-height:15px;">
				PERSONAL FINANCE REQUEST FORM<br><span style="text-align:right;"> نموذج طلب التمويل الشخصي </span>
			</td>
			<td valign="center" style="width:55%;">
				<table border="0" cellspacing="0" cellpadding="0" style="width: 100%;font-size: 11px;">
					<tr>
						<td style="border-bottom:1px solid #ddd;"></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="6" style="width: 100%;font-size: 9px;">
		<tr>
			<td colspan="4" valign="center" align="right">Printed By : <?= $this->session->userdata('admin_name');?> <br>Date/التاريخ : <?php echo $request_date;?></td>
		</tr>
		<tr>
			<td colspan="4" valign="center"></td>
		</tr>
		<tr>
			<td colspan="4" valign="center" style="text-align: left;border-bottom:1px solid #000;text-transform: uppercase;">EMPLOYEE NO & NAME / رقم الموظف واسم الموظف : <?php echo ($payment->request_for_type == 'employee') ? 'MF'.str_pad($payment->request_for_id, 4, 0, STR_PAD_LEFT).'_'.$payment->request_name : $payment->request_name; ?></td>
		</tr>
		<?php
			$employee_detail = employeeDetailHelper($payment->request_for_id);
		?>
		<tr>
			<td style="border-bottom:1px solid #ddd;width:25%;" align="left">Iqama No. / رقم الإقامة <br><?= (isset($employee_detail)) ? trim($employee_detail->iqama_no) : 'NA';?></td>
			<td style="border-bottom:1px solid #ddd;width:25%;" align="left">GOSI / ﺗﺄﻣﻴﻦﺍﺕ ﺍﺟﺘﻤﺎﻋﻴﺔ <br><?= (isset($employee_detail)) ? trim($employee_detail->gosi_id) : 'NA';?></td>
			<td style="border-bottom:1px solid #ddd;width:23%;" align="left">QIWA Contract / عقد قوى <br><?= (isset($employee_detail)) ? trim($employee_detail->qiwa_contract_no) : 'NA';?></td>
			<td style="border-bottom:1px solid #ddd;width:27%;" align="left">Joined Date / تاريخ الانضمام <br><?= (isset($employee_detail)) ? date('d-m-Y', strtotime($employee_detail->work_joining_date)) : 'NA';?></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid #ddd;width:25%;" align="left">Designation / المسمى الوظيفي <br><?= (isset($employee_detail)) ? trim($employee_detail->designation_name) : 'NA';?></td>
			<td style="border-bottom:1px solid #ddd;width:25%;" align="left">Department / القسم <br><?= (isset($employee_detail)) ? trim($employee_detail->department_name) : 'NA';?></td>
			<td style="border-bottom:1px solid #ddd;width:23%;" align="left">Payment Mode / طريقة الدفع <br><?= ($payment->method_of_payment) ? trim($payment->method_of_payment) : 'NA';?></td>
			<td style="border-bottom:1px solid #ddd;width:27%;" align="left">Bank/IBAN No. / اسم البنك / رقم الآيبان <br><?= ($payment->bank_name) ? trim($payment->bank_name) .' / '. trim($payment->iban_no) : 'NA';?></td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="6" style="width: 100%;font-size: 10px;">
		<tr>
			<td colspan="3" valign="center" style="text-align: left;border-bottom:1px solid #000;">LOAN & PREVIOUS BALANCE / القرض والرصيد السابق </td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid #ddd;width:27%;" align="left">Opening Balance / الرصيد الافتتاحي <br>0</td>
			<td style="border-bottom:1px solid #ddd;width:24%;" align="left">New Loan / قرض جديد <br><?php echo 'SAR '. $payment->amount; ?></td>
			<?php
				$loanDetail = json_decode($payment->request_detail, true);
				$deduction_amount = 0;
				if ($loanDetail['calculation_type'] === 'specified_months') {
					if ((int)$loanDetail['specified_value'] > 0) {
						$deduction_amount = $loanDetail['amount'] / (int)$loanDetail['specified_value'];
					}
				} elseif ($loanDetail['calculation_type'] === 'specified_amount') {
					$deduction_amount = (float)$loanDetail['specified_value'];
				}
			?>
			<td style="border-bottom:1px solid #ddd;width:24%;" align="left">Deduction / الخصم <br><?= 'SAR '. number_format($deduction_amount, 2); ?></td>
			<td style="border-bottom:1px solid #ddd;width:25%;" align="left">Balance Due / الرصيد المستحق <br>0</td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;">
		<tr>
			<td colspan="3" valign="center" style="text-align: left;border-bottom:1px solid #000;">REQUEST LOAN OR ADVANCE / طلب قرض أو سلفة </td>
		</tr>
		<tr>
			<td rowspan="2" style="width:28%;" align="left">Loan Amount / مبلغ القرض <br><?php echo 'SAR '. $payment->amount; ?></td>
			<?php
				$instructions = json_decode($payment->instructions, true);
			?>
			<td style="width:72%;" align="left">Request Reason / سبب الطلب : <?php for ($i = 0; $i < 3; $i++): ?> <?php $i+1; if (isset($instructions[$i])): ?><?php echo htmlspecialchars($instructions[$i]); ?><?php endif; ?> <?php endfor; ?></td>
		</tr>
		<tr>
			<td style="width:72%;" align="left">Amount in Words / المبلغ كتابةً : <?= (trim($payment->amount)) ? convert_sar_to_words($payment->amount) : 'NA';?> </td>
		</tr>
	</table>

    <table border="0" cellspacing="0" cellpadding="3" style="width: 100%;font-size: 10px;">
        <tr><td></td></tr>
    </table>

	<table border="0" cellspacing="0" cellpadding="6" style="width: 100%;font-size: 10px;border:1px solid #bbb;">
		<tr>
			<td colspan="2" valign="center" style="text-align: center;border-bottom:1px solid #bbb;">ACKNOWLEDGMENT OF RECEIPT / إقرار الاستلام </td>
		</tr>
		<tr>
			<td style="text-align: justify;border-right:1px solid #bbb;">
				<p>I, the undersigned, certify that I have received an amount in the amount of: SAR <?php echo $payment->amount; ?> and writing: <?= (trim($payment->amount)) ? convert_sar_to_words($payment->amount) : 'NA';?>
        		as an advance to be paid according to the pledge above or according to the company's by laws and the authorization of the authorized person.</p>
			</td>
			<td>
				<p style="text-align: right;"> أنا الموقع أدناه أقر بأني استلمت مبلغاً قدره: <?php echo $payment->amount; ?> ريال سعودي كدفعة مقدمة يتم سديدها وفقا للتعهد أعلاه أو وفقا للوائح الشركة وبإذن الشخص المخول. </p>
			</td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;border:1px solid #bbb;text-align:center;">
		<tr>
			<td style="border-right:1px solid #bbb;"><br><br><br><br>Employee Signature / توقيع الموظف</td>
			<td><br><br><br><br>Thumb Impression / بصمة الإبهام </td>
		</tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="1" style="width: 100%;font-size: 10px;">
		<tr>
			<td></td>
		</tr>
	</table>
	<table cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;border:1px solid #ddd;">
		<tr>
			<td colspan="4" valign="center" style="text-align: left;border-bottom:1px solid #ddd;"> APPROVALS / الموافقات </td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid #bbb;border-right:1px solid #bbb;text-align:center;"><br><br><br><br>Team Leader Signature <br>  توقيع قائد الفريق </td>
			<td style="border-bottom:1px solid #bbb;border-right:1px solid #bbb;text-align:center;"><br><br><br><br>Supervisor Signature<br> توقيع المشرف </td>
			<td style="border-bottom:1px solid #bbb;border-right:1px solid #bbb;text-align:center;"><br><br><br><br>Operation Head Signature<br> توقيع رئيس العمليات </td>
			<td style="border-bottom:1px solid #bbb;text-align:center;"><br><br><br><br>HR Signature<br> توقيع قسم الموارد البشرية </td>
		</tr>
		<tr>
			<td colspan="2" style="border-bottom:1px solid #bbb;border-right:1px solid #bbb;text-align:center;"><br><br><br><br>COO Signature / توقيع المدير التنفيذي للعمليات </td>
			<td colspan="2" style="border-bottom:1px solid #bbb;text-align:center;"><br><br><br><br>CEO Signature / توقيع الرئيس التنفيذي </td>
		</tr>
	</table>

    <table border="0" cellspacing="0" cellpadding="1" style="width: 100%;font-size: 10px;">
		<tr>
			<td></td>
		</tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 9px;border:1px solid #bbb;text-align:center;">
		<tr>
			<td colspan="3" valign="center" style="text-align: left;border-bottom:1px solid #bbb;font-size:10px;">PAYMENT DETAILS / تفاصيل الدفع </td>
		</tr>
		<tr>
            <td style="text-align:left;"> Bank/البنك &nbsp;&nbsp;&nbsp;<span class="checkbox-text"><?php echo ($payment->finance_Payment_bank == 'Al Rajhi') ? '&#9745;' : '&#9744;'; ?></span> Al Rajhi/مصرف الراجحي &nbsp;&nbsp;</td>
			<td style="text-align:left;"> <span class="checkbox-text"><?php echo ($payment->finance_Payment_bank == 'STC Bank') ? '&#9745;' : '&#9744;'; ?></span> STC Bank/بنك إس تي سي &nbsp;&nbsp; </td>
			<td style="text-align:left;"> <span class="checkbox-text"><?php echo ($payment->finance_Payment_bank == 'Petty Cash') ? '&#9745;' : '&#9744;'; ?></span> Petty Cash/العهدة النقدية </td>
		</tr>
		<tr>
            <td style="text-align:left;"> Bank Ref. No. / رقم مرجع البنك : <?= (trim($payment->finance_bank_ref)) ? trim($payment->finance_bank_ref ) : 'NA';?></td>
			<td style="text-align:left;"> Bank P.D / تاريخ الإيداع البنكي : <?= (trim($payment->finance_payment_date)) ? date('d-m-Y', strtotime($payment->finance_payment_date)) : 'NA';?></td>
			<td style="text-align:left;"> Daftra Ref. / رقم مرجع دفترة : <?= (trim($payment->daftra_reference)) ? trim($payment->daftra_reference) : 'NA';?></td>
		</tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="15" style="width: 100%;font-size: 9px;border:1px solid #bbb;text-align:center;">
		<tr>
			<td style="border-right: 1px solid #bbb;">Finance Department / قسم المالية </td>
			<td></td>
		</tr>
	</table>
</body>

</html>
