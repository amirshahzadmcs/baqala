<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Maha Al Fala Trading Company - Vehicle Handover</title>
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
			<td valign="top" style="width:27%;text-align: left;font-size: 14px;line-height:15px;">
				VEHICLE HANDOVER<br><span style="text-align:right;"> نموذج تسليم المركبة </span>
			</td>
			<td valign="center" style="width:73%;">
				<table border="0" cellspacing="0" cellpadding="0" style="width: 100%;font-size: 11px;">
					<tr>
						<td style="border-bottom:1px solid #ddd;"></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="6" style="width: 100%;font-size: 8px;">
		<tr>
			<td colspan="3" valign="center" align="right">Date/التاريخ : <?php echo (!empty($vehicle_detail->allotment_date) && $vehicle_detail->allotment_date !== '0000-00-00') ? formatedDate($vehicle_detail->allotment_date) : 'NA'; ?></td>
		</tr>
		<tr>
			<td colspan="3" valign="center" style="text-align: left;border-bottom:1px solid #000;text-transform: uppercase;">EMPLOYEE NO & NAME / رقم الموظف واسم الموظف : <?php echo $emp_detail->emp_no . ' - ' . $emp_detail->full_name; ?></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid #ddd;" align="left">Iqama No. / رقم الإقامة <br><?= (!empty($emp_detail)) ? trim($emp_detail->iqama_no) : 'NA'; ?></td>
			<td style="border-bottom:1px solid #ddd;" align="left">Joined Date / تاريخ الانضمام <br><?= (!empty($emp_detail)) ? date('d-m-Y', strtotime($emp_detail->work_joining_date)) : 'NA'; ?></td>
			<td style="border-bottom:1px solid #ddd;" align="left">Designation / المسمى الوظيفي <br><?= (!empty($emp_detail)) ? trim($emp_detail->designation_name) : 'NA'; ?></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid #ddd;" align="left">Department / القسم <br><?= (!empty($emp_detail)) ? trim($emp_detail->department_name) : 'NA'; ?></td>
			<td style="border-bottom:1px solid #ddd;" align="left">DL No. / رقم رخصة القيادة <br><?= ($emp_detail->driving_license_number) ? trim($emp_detail->driving_license_number) : 'NA'; ?></td>
			<td style="border-bottom:1px solid #ddd;" align="left">DL Issue Date / تاريخ إصدار رخصة القيادة <br><?= (!empty($emp_detail->driving_license_issue_date) && $emp_detail->driving_license_issue_date !== '0000-00-00') ? date('d-m-Y', strtotime($emp_detail->driving_license_issue_date)) : 'NA'; ?></td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="6" style="width: 100%;font-size: 8px;">
		<tr>
			<td colspan="3" valign="center" style="text-align: left;border-bottom:1px solid #000;">VEHICLE DETAILS / تفاصيل المركبة </td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid #ddd;" align="left">Vehicle Type / نوع السيارة <br> <?php echo ucfirst($vehicle_detail->vehicle_type); ?> </td>
			<td style="border-bottom:1px solid #ddd;" align="left">Model No. / رقم الطراز <br> <?php echo $vehicle_detail->vehicle_model; ?> </td>
			<td style="border-bottom:1px solid #ddd;" align="left">Plate Number / رقم اللوحة <br> <?php echo $vehicle_detail->vehicle_no; ?> </td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 8px;">
		<tr>
			<td valign="center" style="text-align: left;border-bottom:1px solid #000;border-right:1px solid #000;">ACCESSORIES PROVIDED / الملحقات المقدمة </td>
			<td valign="center" style="text-align: left;border-bottom:1px solid #000;">Conditions at the Time of Handover / الحالة عند وقت التسليم </td>
		</tr>
		<tr>
			<td style="border-right:1px solid #000;">
				<table class="table table-bordered mt-2">
					<tbody>
						<tr>
							<td style="line-height: 27px;width:22%;">Istemara Copy</td>
							<td style="width:28%;">
								<table align="center" cellspacing="5">
									<tbody>
										<tr>
											<td>
												<table border="1" cellspacing="0" cellpadding="1" style="width: 100%;font-size: 8px;">
													<tbody>
														<tr>
															<td></td>
															<td>Y</td>
														</tr>
													</tbody>
												</table>
											</td>
											<td>
												<table border="1" cellspacing="0" cellpadding="1" style="width: 100%;font-size: 8px;">
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
							<td style="line-height: 27px;width:22%;">Tool Kit</td>
							<td style="width:28%;">
								<table align="center" cellspacing="5">
									<tbody>
										<tr>
											<td>
												<table border="1" cellspacing="0" cellpadding="1" style="width: 100%;font-size: 8px;">
													<tbody>
														<tr>
															<td></td>
															<td>Y</td>
														</tr>
													</tbody>
												</table>
											</td>
											<td>
												<table border="1" cellspacing="0" cellpadding="1" style="width: 100%;font-size: 8px;">
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
						</tr>
						<tr>
							<td style="line-height: 27px;width:22%;">Mobile Holder</td>
							<td style="width:28%;">
								<table align="center" cellspacing="5">
									<tbody>
										<tr>
											<td>
												<table border="1" cellspacing="0" cellpadding="1" style="width: 100%;font-size: 8px;">
													<tbody>
														<tr>
															<td></td>
															<td>Y</td>
														</tr>
													</tbody>
												</table>
											</td>
											<td>
												<table border="1" cellspacing="0" cellpadding="1" style="width: 100%;font-size: 8px;">
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
							<td style="line-height: 27px;width:22%;">Mobile Charger</td>
							<td style="width:28%;">
								<table align="center" cellspacing="5">
									<tbody>
										<tr>
											<td>
												<table border="1" cellspacing="0" cellpadding="1" style="width: 100%;font-size: 8px;">
													<tbody>
														<tr>
															<td></td>
															<td>Y</td>
														</tr>
													</tbody>
												</table>
											</td>
											<td>
												<table border="1" cellspacing="0" cellpadding="1" style="width: 100%;font-size: 8px;">
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
						</tr>
						<tr>
							<td style="line-height: 27px;width:22%;">Charging Cable</td>
							<td style="width:28%;">
								<table align="center" cellspacing="5">
									<tbody>
										<tr>
											<td>
												<table border="1" cellspacing="0" cellpadding="1" style="width: 100%;font-size: 8px;">
													<tbody>
														<tr>
															<td></td>
															<td>Y</td>
														</tr>
													</tbody>
												</table>
											</td>
											<td>
												<table border="1" cellspacing="0" cellpadding="1" style="width: 100%;font-size: 8px;">
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
							<td style="line-height: 27px;width:15%;">Others</td>
							<td style="line-height: 32px;width:35%;">........................................</td>
						</tr>
					</tbody>
				</table>
			</td>
			<td>
				<table class="table table-bordered mt-2">
					<tbody>
						<tr>
							<td style="line-height: 27px;width:25%;">Fuel Level:</td>
							<td style="width:75%;">
								<table align="center" cellspacing="5">
									<tbody>
										<tr>
											<td style="width:15px;">
												<table border="1" cellspacing="0" cellpadding="1" style="width: 100%;font-size: 8px;">
													<tbody>
														<tr>
															<td></td>
														</tr>
													</tbody>
												</table>
											</td>
											<td style="width:30px;text-align: left;">
												Full
											</td>

											<td style="width:15px;">
												<table border="1" cellspacing="0" cellpadding="1" style="width: 100%;font-size: 8px;">
													<tbody>
														<tr>
															<td></td>
														</tr>
													</tbody>
												</table>
											</td>
											<td style="width:40px;text-align: left;">
												Half
											</td>

											<td style="width:15px;">
												<table border="1" cellspacing="0" cellpadding="1" style="width: 100%;font-size: 8px;">
													<tbody>
														<tr>
															<td></td>
														</tr>
													</tbody>
												</table>
											</td>
											<td style="width:80px;text-align: left;">
												Low
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td style="line-height: 27px;width:25%;">Vehicle Condition:</td>
							<td style="width:75%;">
								<table align="center" cellspacing="5">
									<tbody>
										<tr>
											<td style="width:15px;">
												<table border="1" cellspacing="0" cellpadding="1" style="width: 100%;font-size: 8px;">
													<tbody>
														<tr>
															<td></td>
														</tr>
													</tbody>
												</table>
											</td>
											<td style="width:30px;text-align: left;">
												Good
											</td>

											<td style="width:15px;">
												<table border="1" cellspacing="0" cellpadding="1" style="width: 100%;font-size: 8px;">
													<tbody>
														<tr>
															<td></td>
														</tr>
													</tbody>
												</table>
											</td>
											<td style="width:40px;text-align: left;">
												Average
											</td>

											<td style="width:15px;">
												<table border="1" cellspacing="0" cellpadding="1" style="width: 100%;font-size: 8px;">
													<tbody>
														<tr>
															<td></td>
														</tr>
													</tbody>
												</table>
											</td>
											<td style="width:80px;text-align: left;">
												Needs Attention
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td style="line-height: 27px;width:25%;">Remarks:</td>
							<td style="line-height: 30px;width:75%;">.......................................................................................</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2" valign="center" style="border-top:1px solid #000;"></td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="3" style="width: 100%;font-size: 8px;">
		<tr>
			<td></td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="6" style="width: 100%;font-size: 8px;border:1px solid #bbb;">
		<tr>
			<td colspan="2" valign="center" style="text-align: center;border-bottom:1px solid #bbb;">EMPOLYEE ACKNOWLEDGMENT / إقرار الموظف </td>
		</tr>
		<tr>
			<td style="text-align: justify;border-right:1px solid #bbb;">
				<p>I, <u><?php echo $emp_detail->full_name;?></u> undersigned, confirm that I have received the vehicle and listed accessories in good condition. I understand that I am responsible for the proper usage and safety of the vehicle. I agree to follow company policies and traffic rules.</p>
			</td>
			<td>
				<p style="text-align: right;"> أنا، <u><?php echo $emp_detail->employee_arabic_name;?></u> الموقع أدناه، أؤكد استلامي للمركبة وملحقاتها المذكورة بحالة جيدة. أقر بمسؤوليتي عن الاستخدام السليم وسلامة المركبة. كما أوافق على الالتزام بسياسات الشركة وقواعد المرور. </p>
			</td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 8px;border:1px solid #bbb;text-align:center;">
		<tr>
			<td style="border-right:1px solid #bbb;"><br><br><br>...............................................................<br>Vehicle Receiving Date / تاريخ استلام المركبة</td>
			<td style="border-right:1px solid #bbb;"><br><br><br><br>Employee Signature / توقيع الموظف</td>
			<td><br><br><br><br>Thumb Impression / بصمة الإبهام </td>
		</tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="1" style="width: 100%;font-size: 8px;">
		<tr>
			<td></td>
		</tr>
	</table>
	<table cellspacing="0" cellpadding="5" style="width: 100%;font-size: 8px;border:1px solid #ddd;">
		<tr>
			<td colspan="2" valign="center" style="text-align: left;border-bottom:1px solid #ddd;"><strong>Vehicle Handover Authorised Person / الشخص المخول بتسليم المركبة </strong></td>
		</tr>
		<tr>
			<td style="width:70%;border-bottom:1px solid #bbb;text-align:center;"><br><br><br>---------------------------------------------------------------------------------- <br>Adnan Giri (Operation Supervisor) / عدنان جيري (مشرف العمليات) </td>
			<td style="width:30%;border-bottom:1px solid #bbb;text-align:center;"><br><br><br>----------------------------------------- <br>Date/التاريخ </td>
		</tr>
	</table>

    <table border="0" cellspacing="0" cellpadding="1" style="width: 100%;font-size: 8px;">
		<tr>
			<td></td>
		</tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 8px;border:1px solid #bbb;text-align:center;">
		<tr>
			<td colspan="4" valign="center" style="text-align: left;border-bottom:1px solid #bbb;font-size:8px;"><strong>APPROVED BY / تمت الموافقة من قبل </strong></td>
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