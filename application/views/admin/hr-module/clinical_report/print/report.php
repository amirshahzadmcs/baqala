<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Maha Al Fala Trading Company - Medical Visit Details</title>
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
			<td colspan="2" valign="center" style="text-align: right;font-size: 24px;line-height:0px;"><img src="<?php echo base_url('admin_assets/images/maha-al-fala.jpg');?>" height="50px"></td>
		</tr>
		<tr>
			<td valign="top" style="width:33%;text-align: left;font-size: 16px;line-height:15px;">
				<strong>DAILY MEDICAL VISIT FORM</strong><br><strong> نموذج الزيارة الطبية اليومية </strong>
			</td>
			<td valign="center" style="width:67%;">
				<table border="0" cellspacing="0" cellpadding="0" style="width: 100%;font-size: 11px;">
					<tr>
						<td style="border-bottom:1px solid #ddd;"></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;">
		<tr>
			<td colspan="2" valign="center"></td>
		</tr>
		<tr>
			<td colspan="2" valign="center"></td>
		</tr>
		<tr>
			<td colspan="2" valign="center" style="text-align: left;text-transform: uppercase;"><strong>VISIT DATE / تاريخ الزيارة :</strong> <?= ($request_date) ? date('d F Y', strtotime($request_date)) : 'NA';?></td>
		</tr>
		<tr>
			<td style="width:50%;"><strong>VEHICLE NO. / رقم المركبة : 9121 ERA</strong></td>
			<td style="width:50%;"><strong>DRIVER NAME / اسم السائق : Mohammad Wasim</strong></td>
		</tr>
        <tr>
			<td colspan="2" valign="center"></td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="7" style="width: 100%;font-size: 9px;">
		<tr style="background-color:#f1f1f1;">
			<td colspan="8" valign="center" style="text-align: left;border-top:1px solid #000;border-bottom:1px solid #000;"><strong>MEDICAL VISIT DETAILS / تفاصيل الزيارة الطبية </strong></td>
		</tr>
		<tr style="background-color:#f1f1f1;">
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:6%;line-height:10px;">S.No.<br>فرز</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:10%;line-height:10px;">Emp. No.<br>رقم الموظف</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:24%;line-height:10px;">Employee Name<br>اسم الموظف</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:10%;line-height:10px;">Iqama No.<br>رقم الإقامة</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:10%;line-height:10px;">Status<br>الحالة</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:10%;line-height:10px;">Policy No.<br>رقم الوثيقة</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:20%;line-height:10px;">Insurance Company<br>شركة التأمين</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:10%;line-height:10px;">Sign.<br>التوقيع</td>
		</tr>
        <?php 
        if(count($clinical_detail) > 0){
        $count = 1;
        foreach ($clinical_detail as $key => $value) { 
        ?>
        <tr>
			<td align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?php echo $count++;?></td>
			<td align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= (trim($value['emp_no']) !== '') ? trim($value['emp_no']) : 'NA';?></td>
			<td style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= (trim($value['employee_name']) !== '') ? trim($value['employee_name']) : 'NA';?></td>
			<td align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= (trim($value['iqama_no']) !== '') ? trim($value['iqama_no']) : 'NA';?></td>
			<td align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;">Approved</td>
			<td align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= (trim($value['employee_policy_no']) !== '') ? trim($value['employee_policy_no']) : 'NA';?></td>
			<td style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= (trim($value['policy_company_name']) !== '') ? trim($value['policy_company_name']) : 'NA';?></td>
			<td style="border-bottom:1px solid #000;"></td>
        </tr>
        <?php }}else{ ?>
            <td colspan="8" align="center" style="border-bottom:1px solid #ddd;">No data found</td>
        <?php } ?>
	</table>

    <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
		<tr>
			<td colspan="8" valign="center"></td>
		</tr>
	</table>

	<table cellspacing="2" cellpadding="5" style="width: 100%;font-size: 10px;border:1px solid #000;">
		<tr>
			<td style="border-bottom:1px solid #ddd;">Approved/Authorised Signature/ التوقيع الموافق عليه / المعتمد</td>
		</tr>
        <tr><td></td></tr>
        <tr><td></td></tr>
        <tr>
            <td>
                <table cellspacing="0" cellpadding="5" style="width: 100%;font-size: 8px;">
                    <tr>
                        <td align="center" style="line-height:0px;color:#bbb;">-------------------------------</td>
                        <td align="center" style="line-height:0px;color:#bbb;">-------------------------------</td>
                        <td align="center" style="line-height:0px;color:#bbb;">-------------------------------</td>
                        <td align="center" style="line-height:0px;color:#bbb;">-------------------------------</td>
                        <td align="center" style="line-height:0px;color:#bbb;">-------------------------------</td>
                        <td align="center" style="line-height:0px;color:#bbb;">-------------------------------</td>
                    </tr>
                    <tr>
                        <td align="center" style="line-height:10px;">TL Signature<br>توقيع قائد الفريق</td>
                        <td align="center" style="line-height:10px;">Supervisor Signature<br>توقيع المشرف</td>
                        <td align="center" style="line-height:10px;">Operation Head Signature<br>توقيع رئيس العمليات</td>
                        <td align="center" style="line-height:10px;">HR Signature<br>توقيع الموارد البشرية</td>
                        <td align="center" style="line-height:10px;">COO Signature<br>توقيع الرئيس التنفيذي للعمليات</td>
                        <td align="center" style="line-height:10px;">CEO Signature<br>توقيع الرئيس التنفيذي</td>
                    </tr>
                </table>
            </td>
        </tr>
	</table>

</body>

</html>
