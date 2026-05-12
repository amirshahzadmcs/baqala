<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Maha Al Fala Trading Company - Uniform Handover Form</title>
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
			<td valign="top" style="width:38%;text-align: left;font-size: 18px;line-height:15px;">
				<strong>UNIFORM HANDOVER FORM</strong><br><strong> نموذج تسليم الزي الرسمي </strong>
			</td>
			<td valign="center" style="width:62%;">
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
		<tr>
			<td colspan="4" valign="center"></td>
		</tr>
		<tr>
			<td colspan="4" valign="center" style="text-align: left;border-bottom:1px solid #000;text-transform: uppercase;"><strong>EMPLOYEE NO & NAME / رقم الموظف واسم الموظف :</strong> <?= ($employee_data['emp_detail']['emp_no'] !== '') ? $employee_data['emp_detail']['emp_no'] : 'NA';?> - <?= $employee_data['emp_detail']['full_name'];?></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid #ddd;width:20%;" align="center">Iqama No. / رقم الإقامة <br><strong><?= (trim($employee_data['emp_detail']['iqama_no'])) ? trim($employee_data['emp_detail']['iqama_no']) : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:32%;" align="center">Joined Date / تاريخ الانضمام <br><strong><?= (trim($employee_data['emp_detail']['work_joining_date'])) ? date('d-m-Y', strtotime($employee_data['emp_detail']['work_joining_date'])) : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:26%;" align="center">Designation / المسمى الوظيفي <br><strong><?= (trim($employee_data['emp_detail']['designation_name'])) ? trim($employee_data['emp_detail']['designation_name']) : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:22%;" align="center">Department / القسم <br><strong><?= (trim($employee_data['emp_detail']['department_name'])) ? trim($employee_data['emp_detail']['department_name']) : 'NA';?></strong></td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;">
		<tr>
			<td colspan="3" valign="center" style="text-align: left;border-bottom:1px solid #000;"><strong>UNIFORM DETAILS / تفاصيل الزي الرسمي </strong></td>
		</tr>
		<tr style="background-color:#f2f2f2;">
			<td style="border-bottom:1px solid #000;border-right:1px solid #ddd;width:4%;text-align: center;"></td>
			<td style="border-bottom:1px solid #000;border-right:1px solid #ddd;width:28%;text-align: center;">Particulars / تفاصيل </td>
			<td style="border-bottom:1px solid #000;border-right:1px solid #ddd;width:10%;text-align: center;">Size / مقاس </td>
			<td style="border-bottom:1px solid #000;border-right:1px solid #ddd;width:10%;text-align: center;">Qty. / كمية </td>
			<td style="border-bottom:1px solid #000;border-right:1px solid #ddd;width:18%;text-align: center;">Assets Cost / تكلفة الأصول </td>
			<td style="border-bottom:1px solid #000;width:30%;text-align: center;">Remarks & Serial No. / ملاحظات ورقم التسلسل </td>
		</tr>
        <?php
            $uniformItemsJson = $form_center['uniform_items'];
            $uniformItems = json_decode($uniformItemsJson, true);
        ?>
        <?php foreach($uniformItems as $index => $uniform){ ?>
		<tr>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: center;"><strong><?php echo $index + 1; ?>.</strong></td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: left;"><strong><?php echo htmlspecialchars($uniform['item_name']); ?></strong></td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: left;"><strong></strong></td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: center;"><strong><?php echo htmlspecialchars($uniform['quantity']); ?></strong></td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: left;"><strong></strong></td>
			<td style="border-bottom:1px solid #ddd;text-align: left;"><strong></strong></td>
		</tr>
        <?php } ?>
        <tr>
            <td colspan="2" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #ddd;text-align: left;">Total Item : <?= count($uniformItems);?> <br> إجمالي السلعة </td>
            <td colspan="3" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #ddd;text-align: center;">Total Cost :<br> التكلفة الإجمالية </td>
            <td colspan="" style="border-top:1px solid #000;border-bottom:1px solid #000;"></td>
        </tr>
	</table>

    <table border="0" cellspacing="0" cellpadding="3" style="width: 100%;font-size: 10px;">
        <tr><td></td></tr>
    </table>

	<table border="0" cellspacing="0" cellpadding="6" style="width: 100%;font-size: 10px;border:1px solid #bbb;">
		<tr>
			<td colspan="2" valign="center" style="text-align: center;border-bottom:1px solid #bbb;"><strong>ACKNOWLEDGMENT OF RECEIPT / إقرار الاستلام </strong></td>
		</tr>
		<tr>
			<td style="text-align: justify;border-right:1px solid #bbb;">
				<p>Ms/Mr. <?= $employee_data['emp_detail']['full_name'];?> hereby acknowledges that I have received the above-mentioned assets.</p>
				<p>I understand that this asset belongs to Maha Al Fala Trading Company and is under my possession for carrying out my office work.</p>
			</td>
			<td>
				<p style="text-align: right;"> السيدة/السيد <?= $employee_data['emp_detail']['employee_arabic_name'];?> تقر بموجب هذا بأنني قد استلمت الأصول المذكورة أعلاه. </p>
				<p style="text-align: right;"> أفهم أن هذه الأصول مملوكة لشركة مها الفلاح التجارية وهي تحت حيازتي لاستخدامها في أداء مهام عملي. </p>
			</td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;border:1px solid #bbb;text-align:center;">
		<tr>
			<td style="border-right:1px solid #bbb;"><br><br><br>----------------------------------------<br>Receiving Date / تاريخ الاستلام </td>
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
			<td colspan="2" valign="center" style="text-align: left;border-bottom:1px solid #ddd;"><strong>Uniform Handover Authorised Person / الشخص المخوّل بتسليم الزي الرسمي </strong></td>
		</tr>
		<tr>
			<td style="width:70%;border-bottom:1px solid #bbb;text-align:center;"><br><br><br>---------------------------------------------------------------------------------- <br>Storekeeper / أمين المستودع </td>
			<td style="width:30%;border-bottom:1px solid #bbb;text-align:center;"><br><br><br>----------------------------------------- <br>Date/التاريخ </td>
		</tr>
	</table>

    <table border="0" cellspacing="0" cellpadding="1" style="width: 100%;font-size: 10px;">
		<tr>
			<td></td>
		</tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 9px;border:1px solid #bbb;text-align:center;">
		<tr>
			<td colspan="4" valign="center" style="text-align: left;border-bottom:1px solid #bbb;font-size:10px;"><strong>APPROVED BY / تمت الموافقة من قبل </strong></td>
		</tr>
		<tr>
            <td style="width:16.6%;text-align:center;"><br><br><br>------------------------------<br>Supervisor Signature <br> توقيع المشرف </td>
			<td style="width:18%;text-align:center;"><br><br><br>------------------------------<br>Operation Head Signature <br> توقيع رئيس العمليات </td>
			<td style="width:16%;text-align:center;"><br><br><br>------------------------------<br>Finance Department <br> قسم المالية </td>
			<td style="width:16.6%;text-align:center;"><br><br><br>------------------------------<br>HR Signature <br> توقيع قسم الموارد البشرية </td>
			<td style="width:16.6%;text-align:center;"><br><br><br>------------------------------<br>COO Signature <br> توقيع المدير التنفيذي للعمليات </td>
			<td style="width:16%;text-align:center;"><br><br><br>------------------------------<br>CEO Signature <br> توقيع الرئيس التنفيذي </td>
		</tr>
	</table>
</body>

</html>
