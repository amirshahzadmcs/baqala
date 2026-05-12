<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Maha Al Fala Trading Company - Driving Licence Request Form</title>
	<style>
	*{padding:0px;margin:0px;}
	
	</style>
</head>
<body>
	<style>
		table {border-collapse:collapse; table-layout:fixed;line-height:1.5;}
        table td {word-wrap:break-word;}
	</style>

    <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
		<tr>
			<td colspan="2" valign="center" height="50px" style="text-align: right;font-size: 24px;line-height:0px;"></td>
		</tr>
		<tr>
			<td valign="top" style="width:36%;text-align: left;font-size: 18px;line-height:15px;">
				<strong>Driving Licence Request Form</strong><br><strong> نموذج طلب رخصة قيادة </strong>
			</td>
			<td valign="center" style="width:64%;">
				<table border="0" cellspacing="0" cellpadding="0" style="width: 100%;font-size: 11px;">
					<tr>
						<td style="border-bottom:1px solid #ddd;"></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 9px;">
		<tr>
			<td colspan="4" valign="center"></td>
		</tr>
		<tr>
			<td colspan="4" valign="center" style="text-align: left;border-bottom:1px solid #000;text-transform: uppercase;"><strong>EMPLOYEE NO & NAME / رقم الموظف واسم الموظف :</strong> <?= ($request_detail['emp_no'] !== '') ? $request_detail['emp_no'] : 'NA';?> - <?= $request_detail['full_name'];?></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid #ddd;width:20%;">Iqama No. / رقم الهوية الإقامة <br><strong><?= (trim($request_detail['iqama_no']) !== '') ? trim($request_detail['iqama_no']) : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:18%;">GOSI / التأمينات الاجتماعية <br><strong><?= (trim($request_detail['gosi_id'])) ? trim($request_detail['gosi_id']) : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:24%;">QIWA Contract / رقم عقد قوى <br><strong><?= (trim($request_detail['qiwa_contract_no'])) ? $request_detail['qiwa_contract_no'] : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:38%;">Joined Date / تاريخ الانضمام <br><strong><?= ($request_detail['work_joining_date']) ? date('d/m/Y', strtotime($request_detail['work_joining_date'])) : 'NA';?></strong></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid #ddd;width:20%;">Designation / المسمى الوظيفي <br><strong><?= ($request_detail['designation'] !== '') ? $request_detail['designation_name'] : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:18%;">Department / القسم <br><strong><?= (trim($request_detail['department']) !== '') ? trim($request_detail['department_name']) : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:24%;">Payment Mode / طريقة الدفع <br><strong>NA</strong></td>
			<td style="border-bottom:1px solid #ddd;width:38%;">Bank/IBAN No / البنك / رقم الأيبان <br><strong>NA</strong></td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 9px;">
		<tr>
			<td colspan="5" valign="center" style="text-align: left;border-bottom:1px solid #000;"><strong>DL APPLY DETAILS / تفاصيل التقديم لرخصة القيادة </strong></td>
		</tr>
        <?php
            $dl_file_date = null;
            $dl_issued_date = null;
            
            foreach ($dl_transactions as $transaction) {
                if ($transaction['transaction_type'] == "1") {
                    $dl_file_date = $transaction['trans_date'];
                }
                if ($transaction['transaction_type'] == "9") {
                    $dl_issued_date = $transaction['trans_date'];
                }
            }
            
            // Calculate the difference in days if both dates exist
            $actual_processing_days = "N/A";
            if (!empty($dl_file_date) && !empty($dl_issued_date)) {
                $date1 = new DateTime($dl_file_date);
                $date2 = new DateTime($dl_issued_date);
                $actual_processing_days = $date1->diff($date2)->days; 
            }
        ?>
		<tr>
			<td style="border-bottom:1px solid #ddd;">Request Date / تاريخ الطلب <br><strong><?= ($request_detail['request_date']) ? date('d/m/Y', strtotime($request_detail['request_date'])) : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;">Request Type / نوع الطلب <br><strong><?= (trim($request_detail['dl_request_type'])) ? ucfirst($request_detail['dl_request_type']) : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;">DL Type / نوع رخصة القيادة <br><strong><?= (trim($request_detail['dl_type'])) ? ucfirst($request_detail['dl_type']) : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;">DL No / رقم رخصة القيادة <br><strong><?= ($request_detail['driving_license_number']) ? trim($request_detail['driving_license_number']) : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd; width:145px;">DL Issue Date / تاريخ إصدار رخصة القيادة <br><strong><?= (!empty($dl_issued_date)) ? date('d/m/Y', strtotime($dl_issued_date)) : 'NA';?></strong></td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 9px;">
        <tr>
            <td colspan="5" valign="center" style="text-align: left;border-bottom:1px solid #000;">
                <strong>PAYMENT FOR DRIVING LICENCE FEES / دفع رسوم رخصة القيادة</strong>
            </td>
        </tr>
        <tr>
            <td style="width: 4%;border-bottom:1px solid #ddd;"></td>
            <td style="border-right:1px solid #ddd;border-bottom:1px solid #ddd;width: 24%;text-align:center;">Transaction Date / تاريخ المعاملة</td>
            <td style="border-right:1px solid #ddd;border-bottom:1px solid #ddd;width: 24%;text-align:center;">Transaction ID / معرّف المعاملة</td>
            <td style="border-right:1px solid #ddd;border-bottom:1px solid #ddd;width: 24%;text-align:center;">Transaction Type / نوع المعاملة</td>
            <td style="width: 24%;text-align:center;border-bottom:1px solid #ddd;">Transaction Amount / مبلغ المعاملة</td>
        </tr>

        <?php 
        $transaction_types = [
            "0" => "DL Appointment",
            "1" => "DL File",
            "2" => "DL Class 1",
            "3" => "DL Class 2",
            "4" => "DL Computer Exam",
            "5" => "DL Final Test",
            "6" => "DL Repeat Exam",
            "7" => "DL Medical",
            "8" => "DL Basma",
            "9" => "DL Issued",
			"10" => "DL Requested"
        ];
        
        $total_amount = 0;
        $total_days = count($dl_transactions); // Number of transactions processed
        
        if (!empty($dl_transactions)) {
            foreach ($dl_transactions as $key => $transaction) {
                $total_amount += $transaction['trans_amount']; // Calculate total amount
        ?>
            <tr>
                <td rowspan="2" style="border-right:1px solid #ddd;border-bottom:1px solid #ddd;width: 4%;text-align:center;line-height:5px;">
                    <?= $key + 1; ?>.
                </td>
                <td style="width: 24%;text-align:left;line-height:5px;">
                    <?= !empty($transaction['trans_date']) ? date('d/m/Y', strtotime($transaction['trans_date'])) : 'N/A'; ?>
                </td>
                <td style="width: 24%;text-align:center;line-height:5px;">
                    <?= $transaction['trans_id']; ?>
                </td>
                <td style="width: 24%;text-align:center;line-height:5px;">
                    <?= $transaction_types[$transaction['transaction_type']] ?? "Unknown"; ?>
                </td>
                <td style="width: 24%;text-align:center;line-height:5px;">
                    <?= number_format($transaction['trans_amount'], 2); ?> /-
                </td>
            </tr>
            <tr>
                <td colspan="4" style="border-bottom:1px solid #ddd;width: 96%;text-align:left;">
                    Remarks/ملاحظات : ............................................................................................................................................................................................................................
                </td>
            </tr>
        <?php 
            }
        } else { 
        ?>
            <tr>
                <td colspan="5" style="text-align: center; padding: 10px; border-bottom:1px solid #ddd;">
                    No transactions found / لا توجد معاملات
                </td>
            </tr>
        <?php } ?>

        <tr>
            <td rowspan="2" colspan="1" style="border-bottom:1px solid #ddd;width: 4%;text-align:center;"></td>
            <td colspan="2" style="border-right:1px solid #ddd;border-bottom:1px solid #ddd;text-align:left;">
                Total DL Proceed Days : <?= $actual_processing_days; ?> <br> إجمالي أيام معالجة رخصة القيادة 
            </td>
            <td colspan="2" style="text-align:center;border-bottom:1px solid #ddd;">
                Total Amount : <?= number_format($total_amount, 2); ?> /- <br> إجمالي المبلغ 
            </td>
        </tr>
    </table>

    <table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 8px;">
		<tr>
			<td colspan="4" valign="center" style="text-align: left;border:1px solid #ddd;font-size: 10px;"><strong>HR Records / سجلات الموارد البشرية </strong></td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: center;border:1px solid #ddd;">
                <?= (!empty($dl_issued_date)) ? date('d/m/Y', strtotime($dl_issued_date)) : 'NA';?><br>-----------------<br>DL Received Date/تاريخ استلام رخصة القيادة
            </td>
			<td style="text-align: center;border:1px solid #ddd;">
                <br><br><br>
                Employee Signature/توقيع الموظف
            </td>
			<td style="text-align: center;border:1px solid #ddd;">
                <br><br><br>
                TL Signature/توقيع قائد الفريق
            </td>
		</tr>
        <tr>
			<td style="text-align: center;border:1px solid #ddd;">
                <br><br><br>
                Supervisor Signature/توقيع المشرف
            </td>
			<td style="text-align: center;border:1px solid #ddd;">
                <br><br><br>
                Operation Head Signature/توقيع رئيس العمليات
            </td>
			<td style="text-align: center;border:1px solid #ddd;">
                <br><br><br>
                HR Signature/توقيع الموارد البشرية
            </td>
			<td style="text-align: center;border:1px solid #ddd;">
                <br><br><br>
                COO Signature/توقيع المدير التنفيذي للعمليات
            </td>
		</tr>
	</table>
	
</body>

</html>
