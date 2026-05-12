<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Maha Al Fala Trading Company - Staff Exit Checklist</title>
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
			<td valign="top" style="width:32%;text-align: left;font-size: 18px;line-height:15px;">
				<strong>STAFF EXIT CHECKLIST</strong><br><strong> قائمة التحقق لخروج الموظف </strong>
			</td>
			<td valign="center" style="width:78%;">
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
			<td colspan="4" valign="center"><h3>Acknowledgement of Receipt of Company Property and Financial Obligation:</h3></td>
		</tr>
		<tr>
			<td colspan="4" valign="center" style="text-align: left;border-bottom:1px solid #000;text-transform: uppercase;"><strong>EMPLOYEE NO & NAME / رقم الموظف واسم الموظف :</strong> <?= ($employee_data['emp_detail']['emp_no'] !== '') ? $employee_data['emp_detail']['emp_no'] : 'NA';?> - <?= $employee_data['emp_detail']['full_name'];?></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid #ddd;width:20%;" align="center">Iqama No. / رقم الإقامة <br><strong><?= (trim($employee_data['emp_detail']['iqama_no'])) ? trim($employee_data['emp_detail']['iqama_no']) : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:20%;" align="center">Joined Date / تاريخ الانضمام <br><strong><?= (trim($employee_data['emp_detail']['work_joining_date'])) ? date('d-m-Y', strtotime($employee_data['emp_detail']['work_joining_date'])) : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:20%;" align="center">Designation / المسمى الوظيفي <br><strong><?= (trim($employee_data['emp_detail']['designation_name'])) ? trim($employee_data['emp_detail']['designation_name']) : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:20%;" align="center">Department / القسم <br><strong><?= (trim($employee_data['emp_detail']['department_name'])) ? trim($employee_data['emp_detail']['department_name']) : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:20%;" align="center">Nationality / الجنسية <br><strong><?= (trim($employee_data['emp_detail']['nationality_name'])) ? trim($employee_data['emp_detail']['nationality_name']) : 'NA';?></strong></td>
		</tr>
        <tr>
			<td colspan="5" valign="center" style="text-align: left;border-bottom:1px solid #000;text-transform: uppercase;">
                <strong>LAST WORKING DATE / تاريخ آخر يوم عمل :</strong>
                <?php
                    $date = $employee_data['emp_detail']['last_working_date'];
                    echo (!empty($date) && $date !== '0000-00-00' && $date !== '0000:00:00')
                        ? date('d-m-Y', strtotime($date))
                        : 'NA';
                ?>
            </td>
		</tr>
	</table>
    <table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;">
		<tr>
			<td colspan="3" valign="center" style="text-align: left;border-bottom:1px solid #000;"><strong>DETAILS OF ASSETS RETURNED / تفاصيل الأصول المعادة </strong></td>
		</tr>
		<tr style="background-color:#f2f2f2;">
			<td style="border-bottom:1px solid #000;border-right:1px solid #ddd;width:30%;text-align: center;">TYPE OF COMPANY ASSETS <br> نوع الأصول المملوكة للشركة </td>
			<td style="border-bottom:1px solid #000;border-right:1px solid #ddd;width:8%;text-align: center;">NA <br> غير متوفر </td>
			<td style="border-bottom:1px solid #000;border-right:1px solid #ddd;width:11%;text-align: center;">Not Returned <br> غير متوفر </td>
			<td style="border-bottom:1px solid #000;border-right:1px solid #ddd;width:13%;text-align: center;">Returned Date <br> تاريخ الإرجاع </td>
			<td style="border-bottom:1px solid #000;width:26%;text-align: center;">Remarks <br> ملاحظات </td>
			<td style="border-bottom:1px solid #000;width:12%;text-align: center;">Receiver's Sign <br> توقيع المستلم </td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: left;"><strong>Motor Vehicle<br><small style="font-size:9px;">Keys - Fuel Card - Others</small></strong></td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: left;">
                <table border="0" style="text-align: center;width: 100%;" valign="middle" cellspacing="5" cellpadding="0">
                    <tr>
                        <td align="center" style="width:20px;height:20px;border:1px solid #000;"></td>
                    </tr>
                </table>
            </td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: left;">
                <table border="0" style="text-align: center;width: 100%;" valign="middle" cellspacing="5" cellpadding="0">
                    <tr>
                        <td align="center" style="width:20px;height:20px;border:1px solid #000;"></td>
                    </tr>
                </table>
            </td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: center;"><strong></strong></td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: left;"><strong></strong></td>
			<td style="border-bottom:1px solid #ddd;text-align: left;"><strong></strong></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: left;"><strong>IT Assets and Accessories<br><small style="font-size:9px;">Laptop & Tab and Charger</small></strong></td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: left;">
                <table border="0" style="text-align: center;" cellspacing="5" cellpadding="0">
                    <tr>
                        <td style="width:20px;height:20px;border:1px solid #000;"></td>
                    </tr>
                </table>
            </td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: left;">
                <table border="0" style="text-align: center;" cellspacing="5" cellpadding="0">
                    <tr>
                        <td style="width:20px;height:20px;border:1px solid #000;"></td>
                    </tr>
                </table>
            </td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: center;"><strong></strong></td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: left;"><strong></strong></td>
			<td style="border-bottom:1px solid #ddd;text-align: left;"><strong></strong></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: left;"><strong>Keys<br><small style="font-size:9px;">Office/Building - Filing Cabinets - Petty Cash</small></strong></td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: left;">
                <table border="0" style="text-align: center;" cellspacing="5" cellpadding="0">
                    <tr>
                        <td style="width:20px;height:20px;border:1px solid #000;"></td>
                    </tr>
                </table>
            </td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: left;">
                <table border="0" style="text-align: center;" cellspacing="5" cellpadding="0">
                    <tr>
                        <td style="width:20px;height:20px;border:1px solid #000;"></td>
                    </tr>
                </table>
            </td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: center;"><strong></strong></td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: left;"><strong></strong></td>
			<td style="border-bottom:1px solid #ddd;text-align: left;"><strong></strong></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: left;"><strong>Mobile Phone<br><small style="font-size:9px;">SIM Card - Charger - Other accessories</small></strong></td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: left;">
                <table border="0" style="text-align: center;" cellspacing="5" cellpadding="0">
                    <tr>
                        <td style="width:20px;height:20px;border:1px solid #000;"></td>
                    </tr>
                </table>
            </td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: left;">
                <table border="0" style="text-align: center;" cellspacing="5" cellpadding="0">
                    <tr>
                        <td style="width:20px;height:20px;border:1px solid #000;"></td>
                    </tr>
                </table>
            </td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: center;"><strong></strong></td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: left;"><strong></strong></td>
			<td style="border-bottom:1px solid #ddd;text-align: left;"><strong></strong></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: left;"><strong>Documents: <small style="font-size:9px;">Hard Copy files | electronic files | resources work in progress business cards</small></strong></td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: left;">
                <table border="0" style="text-align: center;" cellspacing="5" cellpadding="0">
                    <tr>
                        <td style="width:20px;height:20px;border:1px solid #000;"></td>
                    </tr>
                </table>
            </td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: left;">
                <table border="0" style="text-align: center;" cellspacing="5" cellpadding="0">
                    <tr>
                        <td style="width:20px;height:20px;border:1px solid #000;"></td>
                    </tr>
                </table>
            </td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: center;"><strong></strong></td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: left;"><strong></strong></td>
			<td style="border-bottom:1px solid #ddd;text-align: left;"><strong></strong></td>
		</tr>
        <tr>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: left;"><strong>Passwords/codes<br><small style="font-size:9px;">Laptop - Network and other IT Systems</small></strong></td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: left;">
                <table border="0" style="text-align: center;" cellspacing="5" cellpadding="0">
                    <tr>
                        <td style="width:20px;height:20px;border:1px solid #000;"></td>
                    </tr>
                </table>
            </td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: left;">
                <table border="0" style="text-align: center;" cellspacing="5" cellpadding="0">
                    <tr>
                        <td style="width:20px;height:20px;border:1px solid #000;"></td>
                    </tr>
                </table>
            </td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: center;"><strong></strong></td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: left;"><strong></strong></td>
			<td style="border-bottom:1px solid #ddd;text-align: left;"><strong></strong></td>
		</tr>
        <tr>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: left;"><strong>Financial<br><small style="font-size:9px;">Cash Balance or Loan Credit</small></strong></td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: left;">
                <table border="0" style="text-align: center;" cellspacing="5" cellpadding="0">
                    <tr>
                        <td style="width:20px;height:20px;border:1px solid #000;"></td>
                    </tr>
                </table>
            </td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: left;">
                <table border="0" style="text-align: center;" cellspacing="5" cellpadding="0">
                    <tr>
                        <td style="width:20px;height:20px;border:1px solid #000;"></td>
                    </tr>
                </table>
            </td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: center;"><strong></strong></td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: left;"><strong></strong></td>
			<td style="border-bottom:1px solid #ddd;text-align: left;"><strong></strong></td>
		</tr>
        <tr>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: left;"><strong>Others</strong></td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: left;">
                <table border="0" style="text-align: center;" cellspacing="5" cellpadding="0">
                    <tr>
                        <td style="width:20px;height:20px;border:1px solid #000;"></td>
                    </tr>
                </table>
            </td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: left;">
                <table border="0" style="text-align: center;" cellspacing="5" cellpadding="0">
                    <tr>
                        <td style="width:20px;height:20px;border:1px solid #000;"></td>
                    </tr>
                </table>
            </td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: center;"><strong></strong></td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;text-align: left;"><strong></strong></td>
			<td style="border-bottom:1px solid #ddd;text-align: left;"><strong></strong></td>
		</tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="3" style="width: 100%;font-size: 10px;">
        <tr><td></td></tr>
    </table>

	<table border="0" cellspacing="0" cellpadding="6" style="width: 100%;font-size: 10px;border:1px solid #bbb;">
		<tr>
			<td colspan="2" valign="center" style="text-align: center;border-bottom:1px solid #bbb;"><strong>EMPLOYEE ACKNOWLEDGMENT / إقرار الموظف </strong></td>
		</tr>
		<tr>
			<td style="text-align: justify;border-right:1px solid #bbb;">
				<p>All items have been returned in proper working condition, and to the designated department or responsible authority as instructed.</p>
			</td>
			<td>
				<p style="text-align: right;"> لقد تم إرجاع جميع العناصر في حالة صالحة للعمل، وتم تسليمها إلى القسم المعين أو السلطة المسؤولة حسب التعليمات. </p>
			</td>
		</tr>
	</table>
    <table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;border:1px solid #bbb;text-align:center;">
		<tr>
			<td style="border-right:1px solid #bbb;"><br><br><br>-----------------------------------------------------<br>Assets Submitted Date / تاريخ تقديم الأصول </td>
			<td style="border-right:1px solid #bbb;"><br><br><br>-----------------------------------------------------<br>Employee Signature / توقيع الموظف </td>
			<td style="border-right:1px solid #bbb;"><br><br><br>-----------------------------------------------------<br>Thumb Impression / بصمة الإبهام </td>
		</tr>
	</table>
    <table border="0" cellspacing="0" cellpadding="3" style="width: 100%;font-size: 10px;">
        <tr><td></td></tr>
    </table>
    <table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;border:1px solid #bbb;text-align:center;">
		<tr>
			<td style="border-right:1px solid #bbb;"><br><br><br><br>Operation Head Signature <br> توقيع رئيس العمليات </td>
			<td style="border-right:1px solid #bbb;"><br><br><br><br>Finance Department <br> قسم المالية </td>
			<td style="border-right:1px solid #bbb;"><br><br><br><br>HR Signature <br> توقيع قسم الموارد البشرية </td>
			<td style="border-right:1px solid #bbb;"><br><br><br><br>Authorised Signature <br> توقيع المفوض </td>
		</tr>
	</table>
</body>

</html>
