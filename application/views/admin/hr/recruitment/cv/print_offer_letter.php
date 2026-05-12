<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Baqala Station - Job Offer Letter</title>
	<style>
	*{padding:0px;margin:0px;}
	
	</style>
</head>
<body>
	<style>
		table {border-collapse:collapse; table-layout:fixed;}
        table td {word-wrap:break-word;}
	</style>
    <table border="0" cellspacing="0" cellpadding="0" style="font-size: 10px; width: 100%;">

		<tr>
			<td colspan="3" style="padding-top:18px;">
				<table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-size: 10px;margin-top:15px;">
					
					<tr>
						<td valign="top" height="18px" colspan="3" style="background-color: #000;color:#fff;font-size: 12px;"><strong>Letter of Job Offer - <?php echo $cv_detail->cv_no;?></strong></td>
					</tr>
					<tr>
						<td valign="top" height="18px" style="text-align: left;width:30%;">Name</td>
						<td valign="top" height="18px" style="text-align: center;width:40%;"><strong><?php echo (($cv_detail->first_name !=='') ? $cv_detail->first_name : ''). (($cv_detail->middle_name !=='') ? ' '.$cv_detail->middle_name : ''). (($cv_detail->third_name !=='') ? ' '.$cv_detail->third_name : ''). (($cv_detail->surname !=='') ? ' '.$cv_detail->surname : '');?></strong></td>
						<td valign="top" height="18px" style="text-align: right;width:30%;">الاسم</td>
					</tr>
					<tr>
						<td valign="top" height="18px" style="text-align: left;width:30%;">Date</td>
						<td valign="top" height="18px" style="text-align: center;width:40%;"><strong><?php echo date('d M Y');?></strong></td>
						<td valign="top" height="18px" style="text-align: right;width:30%;">التاريخ</td>
					</tr>
					<tr>
						<td valign="top" height="18px" colspan="3" style="background-color: #000;color:#fff;font-size: 12px;"><strong>Position & Work Details</strong></td>
					</tr>
					<tr>
						<td valign="top" height="18px" style="text-align: left;width:30%;">Position Title</td>
						<td valign="top" height="18px" style="text-align: center;width:40%;"><strong><?php echo $cv_detail->pos_name;?></strong></td>
						<td valign="top" height="18px" style="text-align: right;width:30%;">المسمى الوظيفي </td>
					</tr>
					<tr>
						<td valign="top" height="18px" style="text-align: left;width:30%;">Passport Number</td>
						<td valign="top" height="18px" style="text-align: center;width:40%;"><strong><?php echo $cv_detail->passport_no;?></strong></td>
						<td valign="top" height="18px" style="text-align: right;width:30%;">رقم الجواز</td>
					</tr>
					<tr>
						<td valign="top" height="18px" style="text-align: left;width:30%;">Nationality</td>
						<td valign="top" height="18px" style="text-align: center;width:40%;"><strong><?php echo $cv_detail->nationality;?></strong></td>
						<td valign="top" height="18px" style="text-align: right;width:30%;">الجنسية </td>
					</tr>
					<!--
					<tr>
						<td valign="top" height="18px" style="text-align: left;width:30%;">Project Code</td>
						<td valign="top" height="18px" style="text-align: center;width:40%;"><strong><?php echo $package_detail->project_code;?></strong></td>
						<td valign="top" height="18px" style="text-align: right;width:30%;"> رقم المشروع </td>
					</tr>
					<tr>
						<td valign="top" height="18px" style="text-align: left;width:30%;">Project Name</td>
						<td valign="top" height="18px" style="text-align: center;width:40%;"><strong><?php echo $package_detail->project_name;?></strong></td>
						<td valign="top" height="18px" style="text-align: right;width:30%;"> اسم المشروع</td>
					</tr>
					<tr>
						<td valign="top" height="18px" style="text-align: left;width:30%;">Reporting To</td>
						<td valign="top" height="18px" style="text-align: center;width:40%;"><strong><?php echo ($package_detail->reporting_to !=='') ? designationInfo($package_detail->reporting_to)->name : 'N/A';?></strong></td>
						<td valign="top" height="18px" style="text-align: right;width:30%;"> تقديم التقارير إلى </td>
					</tr>
					-->
					<tr>
						<td valign="top" height="18px" style="text-align: left;width:30%;">Department</td>
						<td valign="top" height="18px" style="text-align: center;width:40%;"><strong><?php echo $package_detail->department_name;?></strong></td>
						<td valign="top" height="18px" style="text-align: right;width:30%;"> القسم</td>
					</tr>
					<tr>
						<td valign="top" height="18px" style="text-align: left;width:30%;">Work Location</td>
						<td valign="top" height="18px" style="text-align: center;width:40%;"><strong><?php echo $package_detail->work_location;?></strong></td>
						<td valign="top" height="18px" style="text-align: right;width:30%;"> مقر العمل</td>
					</tr>
					<tr>
						<td valign="top" height="18px" style="text-align: left;width:30%;">Woking Hours</td>
						<td valign="top" height="18px" style="text-align: center;width:40%;"><strong><?php echo $package_detail->working_hrs;?></strong></td>
						<td valign="top" height="18px" style="text-align: right;width:30%;">ساعات العمل</td>
					</tr>
					<tr>
						<td valign="top" height="18px" style="text-align: left;width:30%;">Probation Period</td>
						<td valign="top" height="18px" style="text-align: center;width:40%;"><strong><?php echo $package_detail->probation_period;?></strong></td>
						<td valign="top" height="18px" style="text-align: right;width:30%;">فترة التجربه</td>
					</tr>
					<tr>
						<td valign="top" height="18px" style="text-align: left;width:30%;">Contract Period</td>
						<td valign="top" height="18px" style="text-align: center;width:40%;"><strong><?php echo $package_detail->contract_period;?></strong></td>
						<td valign="top" height="18px" style="text-align: right;width:30%;">مدة العقد</td>
					</tr>
					<tr>
						<td valign="top" height="18px" colspan="3" style="background-color: #000;color:#fff;font-size: 12px;"><strong>Compensation & Benefits</strong></td>
					</tr>
					<tr>
						<td valign="top" height="18px" style="text-align: left;width:30%;">Basic Salary</td>
						<td valign="top" height="18px" style="text-align: center;width:40%;"><strong><?php echo $package_detail->basic_salary;?></strong></td>
						<td valign="top" height="18px" style="text-align: right;width:30%;">الراتب الاساسي</td>
					</tr>
					<tr>
						<td valign="top" height="18px" style="text-align: left;width:30%;">Housing</td>
						<td valign="top" height="18px" style="text-align: center;width:40%;"><strong><?php echo $package_detail->housing_allow;?></strong></td>
						<td valign="top" height="18px" style="text-align: right;width:30%;">السكن</td>
					</tr>
					<tr>
						<td valign="top" height="18px" style="text-align: left;width:30%;">Transportation Allowance</td>
						<td valign="top" height="18px" style="text-align: center;width:40%;"><strong><?php echo $package_detail->transportation_allow;?></strong></td>
						<td valign="top" height="18px" style="text-align: right;width:30%;">بدل النقل</td>
					</tr>
					<tr>
						<td valign="top" height="18px" style="text-align: left;width:30%;">Other Allowances</td>
						<td valign="top" height="18px" style="text-align: center;width:40%;"><strong><?php echo $package_detail->order_allowance;?></strong></td>
						<td valign="top" height="18px" style="text-align: right;width:30%;">البدلات الأخرى</td>
					</tr>
					<tr>
						<td valign="top" height="18px" style="text-align: left;width:30%;">Food Allowances</td>
						<td valign="top" height="18px" style="text-align: center;width:40%;"><strong><?php echo $package_detail->food_allow;?></strong></td>
						<td valign="top" height="18px" style="text-align: right;width:30%;">بدلات الغذاء</td>
					</tr>
					<tr>
						<td valign="top" height="18px" style="text-align: left;width:30%;">Orders</td>
						<td valign="top" height="18px" style="text-align: center;width:40%;"><strong><?php echo $package_detail->no_of_orders;?></strong></td>
						<td valign="top" height="18px" style="text-align: right;width:30%;"> الطلبات</td>
					</tr>
					<tr>
						<td valign="top" height="18px" style="text-align: left;width:30%;">Total Package</td>
						<td valign="top" height="18px" style="text-align: center;width:40%;"><strong><?php echo $package_detail->total_package;?></strong></td>
						<td valign="top" height="18px" style="text-align: right;width:30%;">الراتب الاجمالي</td>
					</tr>
					<tr>
						<td valign="top" height="18px" style="text-align: left;width:30%;">Vacation</td>
						<td valign="top" height="18px" style="text-align: center;width:40%;"><strong><?php echo $package_detail->vacations;?></strong></td>
						<td valign="top" height="18px" style="text-align: right;width:30%;">الاجازات</td>
					</tr>
					<tr>
						<td valign="top" height="18px" style="text-align: left;width:30%;">Medical Insurance </td>
						<td valign="top" height="18px" style="text-align: center;width:40%;"><strong>
							<?php 
							$medi_ins_array = explode(',', $package_detail->medical_insurance);
							foreach($medi_ins_array as $medi_ins)
							{
								echo '<strong style="display:block;">'.$medi_ins.'</strong>';
							}
							?>
						</strong></td>
						<td valign="top" height="18px" style="text-align: right;width:30%;"> التامين الطبي</td>
					</tr>
					<tr>
						<td valign="top" height="18px" style="text-align: left;width:30%;">Offer Validity</td>
						<td valign="top" height="18px" style="text-align: center;width:40%;"><strong><?php echo $package_detail->offer_validity;?></strong></td>
						<td valign="top" height="18px" style="text-align: right;width:30%;"> صالح لمدة</td>
					</tr>
					<tr>
						<td colspan="3" valign="top" style="text-align: center;width:100%;">
							<table width="100%" border="0" cellspacing="0" cellpadding="1">
								<tr>
									<td><strong style="color:red;">Remarks / ملاحطات</strong></td>
								</tr>
								<?php 
									$remarks_array = explode(',', $package_detail->remarks);
									foreach($remarks_array as $remark)
									{
										echo '<tr><td>'.$remark.'</td></tr>';
									}
									?>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="top" height="18px" colspan="3" style="background-color: #000;color:#fff;font-size: 12px;"><strong>Acceptance & Approval</strong></td>
					</tr>
					<tr>
						<td valign="top" height="40px" style="text-align: left;width:30%;">COO Approval</td>
						<td valign="top" height="40px" style="text-align: center;width:40%;"><strong></strong></td>
						<td valign="top" height="40px" style="text-align: right;width:30%;"> توقيع الرئيس التفيذي للعمليات</td>
					</tr>
					<tr>
						<td valign="top" height="40px" style="text-align: left;width:30%;">CEO Approval</td>
						<td valign="top" height="40px" style="text-align: center;width:40%;"><strong></strong></td>
						<td valign="top" height="40px" style="text-align: right;width:30%;">توقيع الزئيس التنفيذي</td>
					</tr>
				</table>
				<table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size: 10px;margin-top:15px;">
					<tr>
						<td valign="top" height="18px" colspan="3" style="background-color: #000;color:#fff;font-size: 12px;"><strong> Acceptance of the Candidate </strong></td>
					</tr>
					<tr>
						<td colspan="3" valign="top" height="18px" style="text-align: left;">
							<table border="1" cellspacing="0" cellpadding="5">
								<tr>
									<td valign="top" height="18px" style="text-align: left;">I hereby accept the Job Offer and I Promise to provide correct information to fulfill the employer’s requirements</td>
									<td valign="top" height="18px" style="text-align: right;">  أوافق بموجب هذا على عرض الوظيفة وأتعهد بتقديم المعلومات الصحيحة لتلبية متطلبات صاحب العمل</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-size: 10px;margin-top:15px;">
					
					<tr>
						<td valign="top" height="18px" style="text-align: left;width:30%;">Name</td>
						<td valign="top" height="18px" style="text-align: center;width:40%;"><strong></strong></td>
						<td valign="top" height="18px" style="text-align: right;width:30%;">الاسم</td>
					</tr>
					<tr>
						<td valign="top" height="30px" style="text-align: left;width:30%;">Signature</td>
						<td valign="top" height="30px" style="text-align: center;width:40%;"><strong></strong></td>
						<td valign="top" height="30px" style="text-align: right;width:30%;">التوقيع</td>
					</tr>
					<tr>
						<td valign="top" height="18px" style="text-align: left;width:30%;">Date</td>
						<td valign="top" height="18px" style="text-align: center;width:40%;"><strong></strong></td>
						<td valign="top" height="18px" style="text-align: right;width:30%;">التاريخ</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

</body>

</html>