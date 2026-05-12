<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Maha Al Fala Trading Company - Voluntary Payroll Deduction Authorization Form</title>
	<style>
	*{padding:0px;margin:0px;}
	table {border-collapse:collapse; table-layout:fixed;line-height:1.5;}
    table td {word-wrap:break-word;}
	</style>
</head>
<body>
    <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
		<tr>
			<td colspan="2" valign="center" style="text-align: right;font-size: 24px;line-height:0px;"><img src="<?php echo base_url('admin_assets/images/maha-al-fala.jpg');?>" height="50px"></td>
		</tr>
		<tr>
			<td valign="top" style="width:46%;text-align: left;font-size: 17px;line-height:16px;">
				<strong>VOLUNTARY PAYROLL DEDUCTION AUTHORIZATION FORM</strong>
			</td>
			<td valign="center" style="width:54%;">
				<table border="0" cellspacing="0" cellpadding="0" style="width: 100%;font-size: 11px;">
					<tr>
						<td style="border-bottom:1px solid #ddd;"></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="6" style="width: 100%;font-size: 10px;">
		<tr>
			<td colspan="4" valign="center" align="right">Date/التاريخ : <?php echo $data['issue_date']; ?></td>
		</tr>
		<!-- <tr>
			<td colspan="4" valign="center"></td>
		</tr> -->
		<tr>
			<td colspan="4" valign="center" style="text-align: left;border-bottom:1px solid #000;text-transform: uppercase;"><strong>EMPLOYEE NO & NAME / رقم الموظف واسم الموظف :</strong> <?= ($employee_data['emp_detail']['emp_no'] !== '') ? $employee_data['emp_detail']['emp_no'] : 'NA';?> - <?= $employee_data['emp_detail']['full_name'];?></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid #ddd;width:25%;" align="center">Iqama No. / رقم الإقامة <br><strong><?= (trim($employee_data['emp_detail']['iqama_no'])) ? trim($employee_data['emp_detail']['iqama_no']) : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:25%;" align="center">GOSI / التأمينات الاجتماعية <br><strong><?= (trim($employee_data['other_detail']['gosi_id'])) ? trim($employee_data['other_detail']['gosi_id']) : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:25%;" align="center">QIWA Contract / عقد قوى <br><strong><?= (trim($employee_data['other_detail']['qiwa_contract_no'])) ? trim($employee_data['other_detail']['qiwa_contract_no']) : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:25%;" align="center">Joined Date / تاريخ الانضمام <br><strong><?= (trim($employee_data['emp_detail']['work_joining_date'])) ? date('d-m-Y', strtotime($employee_data['emp_detail']['work_joining_date'])) : 'NA';?></strong></td>
		</tr>
		<tr>
            <td style="border-bottom:1px solid #ddd;width:25%;" align="center">Designation / المسمى الوظيفي <br><strong><?= (trim($employee_data['emp_detail']['designation_name'])) ? trim($employee_data['emp_detail']['designation_name']) : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:25%;" align="center">Department / القسم <br><strong><?= (trim($employee_data['emp_detail']['department_name'])) ? trim($employee_data['emp_detail']['department_name']) : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:25%;" align="center">Payment Mode / طريقة الدفع <br><strong><?= (trim($employee_data['emp_detail']['payment_type'])) ? trim($employee_data['emp_detail']['payment_type']) : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:25%;" align="center">
                Bank / IBAN No. / البنك / رقم الآيبان <br>
                <strong>
                    <?php
                    if (!empty($employee_data['emp_detail']['payment_type_detail'])) {
                        $payment = json_decode($employee_data['emp_detail']['payment_type_detail'], true);
                        if ($payment) {
                            echo (!empty($payment['bank_name']) ? $payment['bank_name'] : 'NA') . ' / ' . 
                                (!empty($payment['iban_no']) ? $payment['iban_no'] : 'NA');
                        } else {
                            echo 'NA';
                        }
                    } else {
                        echo 'NA';
                    }
                    ?>
                </strong>
            </td>
		</tr>

        <tr>
			<td colspan="4" valign="center" style="text-align: left;border-bottom:1px solid #000;text-transform: uppercase;"><strong>DEDUCTION DETAILS / تفاصيل الخصم </strong></td>
		</tr>
		<tr>
            <td style="width:10%"></td>
			<td valign="top" style="text-align: left;width:40%;">
                <table cellspacing="0" cellpadding="5">
                    <tr>
                        <td>* Traffic Violations</td>
                    </tr>
                    <tr>
                        <td>* Jahez Cash Shortage</td>
                    </tr>
                    <tr>
                        <td>* Jahez Debits</td>
                    </tr>
                </table>
            </td>
            <td valign="top" style="text-align: left;width:40%;">
                <table cellspacing="0" cellpadding="5">
                    <tr>
                        <td>* Hunger Wallet</td>
                    </tr>
                    <tr>
                        <td>* Mobily SIM Card Bill</td>
                    </tr>
                    <tr>
                        <td>* Any Other Violation Paid on Behalf</td>
                    </tr>
                </table>
            </td>
            <td style="width:10%"></td>
		</tr>
	</table>

    <table border="0" cellspacing="0" cellpadding="3" style="width: 100%;font-size: 10px;">
        <tr><td></td></tr>
    </table>

	<table border="0" cellspacing="0" cellpadding="6" style="width: 100%;font-size: 10px;border:1px solid #000;">
		<tr>
			<td colspan="2" valign="center" style="text-align: center;border-bottom:1px solid #000;"><strong>ACKNOWLEDGMENT OF RECEIPT / إقرار الاستلام </strong></td>
		</tr>
		<tr>
			<td style="text-align: justify;border-right:1px solid #000;"><p>Dear Sir,</p>
				<p>I <?= $employee_data['emp_detail']['full_name'];?> hereby authorize my employer Maha Al Fala Trading Est to make the deductions above from my salary in accordance with the above terms.</p>
				<p>I understand and agree that I am responsible for satisfying the above violations and I understand and agree that any amount that is due and owing at the time of my termination, regardless of whether my termination was voluntary or not, will be deducted from my last paycheck or any other amounts that may be owed to me, which authorizes my employer Maha Al Fala Trading Est. to retain the entire amount of my last paycheck in compliance with the law, and I further understand and agree that deductions will be made after any mandatory taxes as well as for any employer programs in which I have enrolled, for which I am eligible, or to which I have agreed.</p>
			</td>
			<td><p style="text-align: right;font-size: 11px;">السيد المحترم،</p>
                <p style="text-align: right;font-size: 11px;">
                    أنا <?= $employee_data['emp_detail']['employee_arabic_name'];?> أقرّ وأفوّض بموجب هذا صاحب عملي، مؤسسة مها الفلا التجارية، بخصم المبالغ المذكورة أعلاه من راتبي وفقاً للشروط الموضحة أعلاه.
                </p>
                <p style="text-align: right;font-size: 11px;">
                    أقرّ وأوافق على أنني مسؤول عن تسوية المخالفات المذكورة أعلاه، كما أقرّ وأوافق على أنه سيتم خصم أي مبلغ مستحق وواجب السداد في وقت إنهاء خدمتي، سواءً كان إنهاء الخدمة طوعياً أم لا، من راتبي الأخير أو من أي مبالغ أخرى مستحقة لي، ويُخوّل ذلك صاحب عملي، مؤسسة مها الفلا التجارية، بالاحتفاظ بكامل مبلغ راتبي الأخير وفقاً للقانون، كما أقرّ وأوافق على أن تتم الخصومات بعد استقطاع أي ضرائب إلزامية وكذلك مقابل أي برامج يقدمها صاحب العمل والتي أكون مسجلاً بها أو مؤهلاً للاستفادة منها أو وافقت عليها.
                </p>
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

    <table border="0" cellspacing="0" cellpadding="1" style="width: 100%;font-size: 10px;">
		<tr>
			<td></td>
		</tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 9px;text-align:center;">
		<tr>
			<td colspan="4" valign="center" style="text-align: left;border-top:1px solid #000;border-bottom:1px solid #bbb;font-size:10px;"><strong>APPROVED BY / تمت الموافقة من قبل </strong></td>
		</tr>
		<tr>
            <td style="width:25%;text-align:center;border-bottom:1px solid #000;border-right:1px solid #bbb;"><br><br><br><br><br>Supervisor Signature / توقيع المشرف </td>
			<td style="width:25%;text-align:center;border-bottom:1px solid #000;border-right:1px solid #bbb;"><br><br><br><br><br>Operation Head Signature / توقيع رئيس العمليات </td>
			<td style="width:25%;text-align:center;border-bottom:1px solid #000;border-right:1px solid #bbb;"><br><br><br><br><br>Finance Department / قسم المالية </td>
			<td style="width:25%;text-align:center;border-bottom:1px solid #000;"><br><br><br><br><br>HR Signature / توقيع قسم الموارد البشرية </td>
		</tr>
        <tr>
            <td colspan="2" style="text-align:center;border-bottom:1px solid #000;border-right:1px solid #bbb;"><br><br><br><br><br>COO Signature / توقيع مدير العمليات </td>
			<td colspan="2" style="text-align:center;border-bottom:1px solid #000;"><br><br><br><br><br>Deputy CEO Signature / توقيع نائب الرئيس التنفيذي </td>
		</tr>
	</table>
</body>

</html>
