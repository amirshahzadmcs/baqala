<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Maha Al Fala Trading Company - Injury Description form</title>
	<style>
		* {
			padding: 0px;
			margin: 0px;
		}

		table {
			border-collapse: collapse;
			table-layout: fixed;
		}
	</style>
</head>

<body>
	<table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
		<tr>
			<td colspan="2" valign="center" style="text-align: right;font-size: 24px;line-height:0px;"><img src="<?php echo base_url('admin_assets/images/maha-al-fala.jpg'); ?>" height="40px"></td>
		</tr>
		<tr>
			<td valign="top" style="width:36%;text-align: left;font-size: 17px;line-height:15px;">
				INJURY DESCRIPTION FORM<br><span style="text-align:right;"> نموذج وصف الإصابة </span>
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

	<table border="0" cellspacing="0" cellpadding="7" style="width: 100%;font-size: 10px;">
		<tr>
			<td colspan="4" valign="center" align="right">Date/التاريخ : <?php echo (!empty($accident_detail['accident_date']) && $accident_detail['accident_date'] !== '0000-00-00') ? formatedDate($accident_detail['accident_date']) : 'NA'; ?></td>
		</tr>
		<tr>
			<td colspan="4" valign="center" style="text-align: left;border-bottom:1px solid #000;text-transform: uppercase;">EMPLOYEE NO & NAME / رقم الموظف واسم الموظف : <?php echo $emp_detail['emp_no'] . ' - ' . $emp_detail['full_name']; ?></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid #ddd;" align="left">Iqama No. / رقم الإقامة <br><?= (!empty($emp_detail)) ? trim($emp_detail['iqama_no']) : 'NA'; ?></td>
			<td style="border-bottom:1px solid #ddd;" align="left">Joined Date / تاريخ الانضمام <br><?= (!empty($emp_detail)) ? date('d-m-Y', strtotime($emp_detail['work_joining_date'])) : 'NA'; ?></td>
			<td style="border-bottom:1px solid #ddd;" align="left">Designation / المسمى الوظيفي <br><?= (!empty($emp_detail)) ? trim($emp_detail['designation_name']) : 'NA'; ?></td>
			<td style="border-bottom:1px solid #ddd;" align="left">Department / القسم <br><?= (!empty($emp_detail)) ? trim($emp_detail['department_name']) : 'NA'; ?></td>
		</tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="7" style="width: 100%;font-size: 10px;">
		<tr>
			<td style="border-bottom:1px solid #ddd;" align="left">Employer Name / اسم صاحب العمل <br><?= (!empty($emp_detail)) ? trim($emp_detail['employer_name']) : 'NA'; ?></td>
			<td style="border-bottom:1px solid #ddd;" align="left">Employer ID / رقم هوية صاحب العمل <br><?= ($emp_detail['employer_id']) ? trim($emp_detail['employer_id']) : 'NA'; ?></td>
			<td style="border-bottom:1px solid #ddd;" align="left">GOSI Contract No / رقم عقد التأمينات الاجتماعية <br><?= ($emp_detail['gosi_id']) ? trim($emp_detail['gosi_id']) : 'NA'; ?></td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="7" style="width: 100%;font-size: 10px;">
		<tr>
			<td valign="center" style="text-align: left;border-bottom:1px solid #000;">INJURY DESCRIPTION / وصف تفصيلي للإصابة مع تحديد العضو المصاب والمهام التي كان يعمل عليها وقت وقوع الإصابة </td>
		</tr>
		<?php if(!empty($accident_detail['injury_description'])){ ?>
		<tr>
			<td style="border-bottom:1px dashed #ddd;" align="left"><?= ($accident_detail['injury_description']) ? trim($accident_detail['injury_description']) : 'NA'; ?></td>
		</tr>
		<?php }else{ ?>
		<tr>
			<td style="border-bottom:1px dashed #ddd;" align="left"></td>
		</tr>
		<tr>
			<td style="border-bottom:1px dashed #ddd;" align="left"></td>
		</tr>
		<?php } ?>
	</table>

	<table border="0" cellspacing="0" cellpadding="1" style="width: 100%;font-size: 10px;">
		<tr>
			<td></td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="10" style="width: 100%;font-size: 10px;">
		<tr style="background-color:#f1f1f1;">
			<td valign="center" style="text-align: center;border-top:1px solid #000;border-bottom:1px solid #ddd;"><strong>City Name <br> اسم المدينة </strong></td>
			<td valign="center" style="text-align: center;border-top:1px solid #000;border-bottom:1px solid #ddd;"><strong>Task During Injury <br> المهمة أثناء الإصابة </strong></td>
			<td valign="center" style="text-align: center;border-top:1px solid #000;border-bottom:1px solid #ddd;"><strong>Place of Injury (Name) <br> مكان الإصابة (الاسم) </strong></td>
		</tr>
		<tr>
			<td valign="center" style="text-align: center;border-right:1px solid #ddd;border-bottom:1px solid #000;"><?php echo ($accident_detail['accident_location'] !== '' && $accident_detail['accident_location'] !== NULL) ? $accident_detail['accident_location'] : 'NA';?></td>
			<td valign="center" style="text-align: center;border-right:1px solid #ddd;border-bottom:1px solid #000;"></td>
			<td valign="center" style="text-align: center;border-bottom:1px solid #000;"><?php echo ($accident_detail['accident_location'] !== '' && $accident_detail['accident_location'] !== NULL) ? $accident_detail['accident_location'] : 'NA';?></td>
		</tr>
		<tr style="background-color:#f1f1f1;">
			<td valign="center" style="text-align: center;border-top:1px solid #000;border-bottom:1px solid #ddd;"><strong>Date & Time of Injury <br> تاريخ ووقت الإصابة </strong></td>
			<td valign="center" style="text-align: center;border-top:1px solid #000;border-bottom:1px solid #ddd;"><strong>Date Stop of Work <br> تاريخ التوقف عن العمل </strong></td>
			<td valign="center" style="text-align: center;border-top:1px solid #000;border-bottom:1px solid #ddd;"><strong>Date of Inform Maha Al Fala Trading Co. <br> تاريخ إبلاغ شركة مها الفلاح التجارية </strong></td>
		</tr>
		<tr>
			<td valign="center" style="text-align: center;border-right:1px solid #ddd;border-bottom:1px solid #000;"><?php echo (!empty($accident_detail['accident_date']) && $accident_detail['accident_date'] !== '0000-00-00') ? formatedDate($accident_detail['accident_date']) : 'NA'; ?> - <?php echo ($accident_detail['accident_time'] !== '' && $accident_detail['accident_time'] !== '00:00:00') ? $accident_detail['accident_time'] : 'NA';?></td>
			<td valign="center" style="text-align: center;border-right:1px solid #ddd;border-bottom:1px solid #000;"></td>
			<td valign="center" style="text-align: center;border-bottom:1px solid #000;"></td>
		</tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="7" style="width: 100%;font-size: 10px;">
		<tr>
			<td colspan="2" valign="center" style="text-align: left;border-bottom:1px solid #ddd;">PLACE OF INJURY / مكان الإصابة </td>
		</tr>
		<tr>
			<td>
				<table align="center" cellspacing="5">
					<tbody>
						<tr>
							<td style="width:12px;height:15px;text-align: center;">
								<table border="1" cellspacing="0" cellpadding="1" style="font-size: 8px;">
									<tbody>
										<tr>
											<td></td>
										</tr>
									</tbody>
								</table>
							</td>
							<td style="text-align: left;">
								Road Street / شارع الطريق
							</td>
						</tr>
					</tbody>
				</table>
			</td>
			<td>
				<table align="center" cellspacing="5">
					<tbody>
						<tr>
							<td style="width:12px;height:15px;text-align: center;">
								<table border="1" cellspacing="0" cellpadding="1" style="font-size: 8px;">
									<tbody>
										<tr>
											<td></td>
										</tr>
									</tbody>
								</table>
							</td>
							<td style="text-align: left;">
								Housing / السكن
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>

		<tr>
			<td colspan="2" valign="center" style="text-align: left;border-top:1px solid #000;border-bottom:1px solid #ddd;">TYPE/REASON OF ACCIDENT / نوع / سبب الحادث </td>
		</tr>
		<tr>
			<td>
				<table align="center" cellspacing="5">
					<tbody>
						<tr>
							<td style="width:12px;height:15px;text-align: center;">
								<table border="1" cellspacing="0" cellpadding="1" style="font-size: 8px;">
									<tbody>
										<tr>
											<td></td>
										</tr>
									</tbody>
								</table>
							</td>
							<td style="text-align: left;">
								Road Accident / حادث مروري
							</td>
						</tr>
					</tbody>
				</table>
			</td>
			<td>
				<table align="center" cellspacing="5">
					<tbody>
						<tr>
							<td style="width:12px;height:15px;text-align: center;">
								<table border="1" cellspacing="0" cellpadding="1" style="font-size: 8px;">
									<tbody>
										<tr>
											<td></td>
										</tr>
									</tbody>
								</table>
							</td>
							<td style="text-align: left;">
								Hit & Run / صدم وهرب
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table align="center" cellspacing="5">
					<tbody>
						<tr>
							<td style="width:12px;height:15px;text-align: center;">
								<table border="1" cellspacing="0" cellpadding="1" style="font-size: 8px;">
									<tbody>
										<tr>
											<td></td>
										</tr>
									</tbody>
								</table>
							</td>
							<td style="text-align: left;">
								Dis Balance / فقدان التوازن
							</td>
						</tr>
					</tbody>
				</table>
			</td>
			<td></td>
		</tr>

		<tr>
			<td colspan="2" valign="center" style="text-align: left;border-top:1px solid #000;border-bottom:1px solid #ddd;">RESOURCE/CAUSE OF INJURY / مصدر / سبب الإصابة </td>
		</tr>
		<tr>
			<td>
				<table align="center" cellspacing="5">
					<tbody>
						<tr>
							<td style="width:12px;height:15px;text-align: center;">
								<table border="1" cellspacing="0" cellpadding="1" style="font-size: 8px;">
									<tbody>
										<tr>
											<td></td>
										</tr>
									</tbody>
								</table>
							</td>
							<td style="text-align: left;">
								Car / سيارة
							</td>
						</tr>
					</tbody>
				</table>
			</td>
			<td>
				<table align="center" cellspacing="5">
					<tbody>
						<tr>
							<td style="width:12px;height:15px;text-align: center;">
								<table border="1" cellspacing="0" cellpadding="1" style="font-size: 8px;">
									<tbody>
										<tr>
											<td></td>
										</tr>
									</tbody>
								</table>
							</td>
							<td style="text-align: left;">
								Bike / دراجة
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>

		<tr>
			<td colspan="2" valign="center" style="text-align: left;border-top:1px solid #000;border-bottom:1px solid #ddd;">ACCIDENT DETAILS / تفاصيل الحادث </td>
		</tr>
		<tr>
			<td>
				<table align="center" cellspacing="5">
					<tbody>
						<tr>
							<td style="width:12px;height:15px;text-align: center;">
								<table border="1" cellspacing="0" cellpadding="1" style="font-size: 8px;">
									<tbody>
										<tr>
											<td></td>
										</tr>
									</tbody>
								</table>
							</td>
							<td style="text-align: left;width:50%;">Attending By / تم الحضور بواسطة</td>
							<td style="width: 45px;text-align: center;">
								<table border="1" cellspacing="0" cellpadding="4" style="width: 100%;font-size: 8px;">
									<tbody>
										<tr>
											<td></td>
											<td>M</td>
										</tr>
									</tbody>
								</table>
							</td>
							<td style="width: 45px;">
								<table border="1" cellspacing="0" cellpadding="4" style="width: 100%;font-size: 8px;">
									<tbody>
										<tr>
											<td></td>
											<td>N</td>
										</tr>
									</tbody>
								</table>
							</td>
							<td style="width: 45px;">
								<table border="1" cellspacing="0" cellpadding="4" style="width: 100%;font-size: 8px;">
									<tbody>
										<tr>
											<td></td>
											<td>S</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
			<td>
				<table align="center" cellspacing="5">
					<tbody>
						<tr>
							<td style="width:12px;height:15px;text-align: center;">
								<table border="1" cellspacing="0" cellpadding="1" style="font-size: 8px;">
									<tbody>
										<tr>
											<td></td>
										</tr>
									</tbody>
								</table>
							</td>
							<td style="text-align: left;">HDD Report No. / رقم تقرير HDD</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table align="center" cellspacing="5">
					<tbody>
						<tr>
							<td style="width:12px;height:15px;text-align: center;">
								<table border="1" cellspacing="0" cellpadding="1" style="font-size: 8px;">
									<tbody>
										<tr>
											<td></td>
										</tr>
									</tbody>
								</table>
							</td>
							<td style="text-align: left;width:66.5%;">Ambulance Required / هل يتطلب إسعاف</td>
							<td style="width: 45px;text-align: center;">
								<table border="1" cellspacing="0" cellpadding="4" style="width: 100%;font-size: 8px;">
									<tbody>
										<tr>
											<td></td>
											<td>Y</td>
										</tr>
									</tbody>
								</table>
							</td>
							<td style="width: 45px;">
								<table border="1" cellspacing="0" cellpadding="4" style="width: 100%;font-size: 8px;">
									<tbody>
										<tr>
											<td></td>
											<td>N</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
			<td>
				<table align="center" cellspacing="5">
					<tbody>
						<tr>
							<td style="width:12px;height:15px;text-align: center;">
								<table border="1" cellspacing="0" cellpadding="1" style="font-size: 8px;">
									<tbody>
										<tr>
											<td></td>
										</tr>
									</tbody>
								</table>
							</td>
							<td style="text-align: left;">
								LD Report No. / رقم تقرير LD
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</table>

    <table border="0" cellspacing="0" cellpadding="1" style="width: 100%;font-size: 10px;border-top:1px solid #000;">
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