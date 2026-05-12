<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Job Offer Letter - Car Driver</title>
	<style>
	*{padding:0px;margin:0px;}
	ul {
    margin: 0;
		padding-left: 0;
	}
	</style>
</head>
<body>
	<style>
		table {border-collapse:collapse; table-layout:fixed;line-height:1.5;}
        table td {word-wrap:break-word;}
	</style>
    <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
		<tr>
			<td valign="middle" align="right" style="width: 100%;"><img src="<?php echo base_url('admin_assets/images/header/offer-header.png');?>"></td>
		</tr>
	</table>
    <table border="0" cellspacing="0" cellpadding="0" style="font-size: 10px; width: 100%;">
		<tr>
			<td colspan="3">
				<table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size: 10px;">
                    <tr>
						<td valign="middle" height="10px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" height="10px" width="100%" style="text-align: left;">Date: <?php echo $data['issue_date'];?></td>
								</tr>
							</table>
						</td>
						<td valign="middle" height="10px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" height="10px" width="100%" style="text-align: right;"><span style="direction: rtl;"> التاريخ : <?php echo $data['issue_date'];?></span> </td>
								</tr>
							</table>
						</td>
					</tr>
                    <tr>
						<td valign="middle" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 14px;">
								<tr>
									<td valign="middle" width="100%" style="text-align: center;"><strong> <u>Job Offer</u> </strong></td>
								</tr>
							</table>
						</td>
						<td valign="middle" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 14px;">
								<tr>
									<td valign="middle" width="100%" style="text-align: center;"><span style="direction: rtl;"><strong><u> عرض الوظيف </u></strong></span> </td>
								</tr>
							</table>
						</td>
					</tr>
                    <tr>
						<td valign="middle" height="10px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" height="10px" width="100%" style="text-align: left;"></td>
								</tr>
							</table>
						</td>
						<td valign="middle" height="10px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" height="10px" width="100%" style="text-align: right;"><span style="direction: rtl;"></span> </td>
								</tr>
							</table>
						</td>
					</tr>
					
					<tr>
						<td valign="middle" height="10px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" height="10px" width="30%" style="text-align: left;">Name</td>
									<td valign="middle" height="10px" width="70%" style="text-align: left;"><?php echo htmlspecialchars($interview_detail->applicant_name ?? ''); ?></td>
								</tr>
							</table>
						</td>
						<td valign="middle" height="10px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" height="10px" width="70%" style="text-align: right;"><?php echo htmlspecialchars($interview_detail->applicant_name ?? ''); ?> </td>
									<td valign="middle" height="10px" width="30%" style="text-align: right;"><span style="direction: rtl;"> الاسم </span></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="middle" height="10px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" height="10px" width="30%" style="text-align: left;">Iqama No</td>
									<td valign="middle" height="10px" width="70%" style="text-align: left;"><?= $interview_detail->iqama_number ?? 'NA'; ?></td>
								</tr>
							</table>
						</td>
						<td valign="middle" height="10px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" height="10px" width="70%" style="text-align: right;"> <?= $interview_detail->iqama_number ?? 'NA'; ?> </td>
									<td valign="middle" height="10px" width="30%" style="text-align: right;"><span style="direction: rtl;"> رقم الهوية / الإقامة </span></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="middle" height="10px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" height="10px" width="30%" style="text-align: left;">Nationality</td>
									<td valign="middle" height="10px" width="70%" style="text-align: left;"><?php echo htmlspecialchars($interview_detail->nationality_name ?? ''); ?></td>
								</tr>
							</table>
						</td>
						<td valign="middle" height="10px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" height="10px" width="70%" style="text-align: right;"><span style="direction: rtl;"><?php echo htmlspecialchars($interview_detail->nationality_arabic_name ?? ''); ?></span> </td>
									<td valign="middle" height="10px" width="30%" style="text-align: right;"><span style="direction: rtl;"> الجنسية </span></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="middle" height="10px" style="text-align: left;">
							
						</td>
						<td valign="middle" height="10px" style="text-align: left;">
							
						</td>
					</tr>
					<tr>
						<td valign="middle" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" height="20px" style="text-align: left;">We are pleased to offer you an appointment with our organization as <?php echo htmlspecialchars($interview_detail->pos_name ?? ''); ?>, you will be based in our Riyadh office.</td>
								</tr>
							</table>
						</td>
						<td valign="middle" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" height="20px" style="text-align: right;"> يسعدنا أن نعرض عليك عرض وظيفة ضمن شركتنا بمسمى "<?php echo htmlspecialchars($interview_detail->arabic_pos_name ?? ''); ?>". وستكون مكان عملك في شركتنا بمدينة الرياض. </td>
								</tr>
							</table>
						</td>
					</tr>
					
					<tr>
						<td valign="middle" height="10px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" height="10px" width="50%" style="text-align: left;">Job Title</td>
									<td valign="middle" height="10px" width="50%" style="text-align: left;"><?php echo htmlspecialchars($interview_detail->pos_name ?? ''); ?></td>
								</tr>
							</table>
						</td>
						<td valign="middle" height="10px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" height="10px" width="50%" style="text-align: right;"> <?php echo htmlspecialchars($interview_detail->arabic_pos_name ?? ''); ?> </td>
									<td valign="middle" height="10px" width="50%" style="text-align: right;"><span style="direction: rtl;"> المسمى الوظيفي </span></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="middle" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" height="20px" width="50%" style="text-align: left;">Housing</td>
									<td valign="middle" height="20px" width="50%" style="text-align: left;">Provided by Company</td>
								</tr>
							</table>
						</td>
						<td valign="middle" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" height="20px" width="50%" style="text-align: right;"> يتم توفيره من قبل الشركة </td>
									<td valign="middle" height="20px" width="50%" style="text-align: right;"> السكن </td>
								</tr>
							</table>
						</td>
					</tr>
                    <tr>
						<td valign="middle" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" height="20px" width="50%" style="text-align: left;">Transportation</td>
									<td valign="middle" height="20px" width="50%" style="text-align: left;">Provided by Company</td>
								</tr>
							</table>
						</td>
						<td valign="middle" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" height="20px" width="50%" style="text-align: right;">يتم توفيره من قبل الشركة</td>
									<td valign="middle" height="20px" width="50%" style="text-align: right;"> النقل </td>
								</tr>
							</table>
						</td>
					</tr>
                    <tr>
						<td valign="middle" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" height="20px" width="50%" style="text-align: left;">Monthly Target</td>
									<td valign="middle" height="20px" width="50%" style="text-align: left;">450 Delivery Monthly</td>
								</tr>
							</table>
						</td>
						<td valign="middle" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" height="20px" width="50%" style="text-align: right;"> 450 توصيل شهرياً </td>
									<td valign="middle" height="20px" width="50%" style="text-align: right;"> الهدف الشهري </td>
								</tr>
							</table>
						</td>
					</tr>
                    <tr>
						<td valign="middle" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" height="20px" width="50%" style="text-align: left;">Total Package</td>
									<td valign="middle" height="20px" width="50%" style="text-align: left;">SAR <?php if($interview_detail->has_driving_license == 'yes' && $interview_detail->driving_license_type == 'Light Transport'){ echo '2,025.00'; } else { echo '1,800.00'; } ?></td>
								</tr>
							</table>
						</td>
						<td valign="middle" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" height="20px" width="50%" style="text-align: right;"> <?php if($interview_detail->has_driving_license == 'yes' && $interview_detail->driving_license_type == 'Light Transport'){ echo '2,025.00'; } else { echo '1,800.00'; } ?> ر س  </td>
									<td valign="middle" height="20px" width="50%" style="text-align: right;"> إجمالي حزمة الراتب </td>
								</tr>
							</table>
						</td>
					</tr>
                    <tr>
						<td valign="middle" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" height="20px" width="50%" style="text-align: left;">Medical Insurance</td>
									<td valign="middle" height="20px" width="50%" style="text-align: left;">Provided by Company</td>
								</tr>
							</table>
						</td>
						<td valign="middle" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" height="20px" width="50%" style="text-align: right;"> يتم توفيره من قبل الشركة </td>
									<td valign="middle" height="20px" width="50%" style="text-align: right;"> تأمين طبي </td>
								</tr>
							</table>
						</td>
					</tr>
                    <tr>
						<td valign="middle" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" height="20px" width="50%" style="text-align: left;">Car</td>
									<td valign="middle" height="20px" width="50%" style="text-align: left;">Provided by Company</td>
								</tr>
							</table>
						</td>
						<td valign="middle" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" height="20px" width="50%" style="text-align: right;"> يتم توفيره من قبل الشركة </td>
									<td valign="middle" height="20px" width="50%" style="text-align: right;"> دراجة </td>
								</tr>
							</table>
						</td>
					</tr>
                    <tr>
						<td valign="middle" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" height="20px" width="50%" style="text-align: left;">Fuel/Petrol</td>
									<td valign="middle" height="20px" width="50%" style="text-align: left;">Provided by Company</td>
								</tr>
							</table>
						</td>
						<td valign="middle" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" height="20px" width="50%" style="text-align: right;"> يتم توفيره من قبل الشركة </td>
									<td valign="middle" height="20px" width="50%" style="text-align: right;"> وقود/بنزين </td>
								</tr>
							</table>
						</td>
					</tr>
                    <tr>
						<td valign="middle" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" height="20px" width="50%" style="text-align: left;">Internet SIM</td>
									<td valign="middle" height="20px" width="50%" style="text-align: left;">Provided by Company</td>
								</tr>
							</table>
						</td>
						<td valign="middle" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" height="20px" width="50%" style="text-align: right;"> يتم توفيره من قبل الشركة </td>
									<td valign="middle" height="20px" width="50%" style="text-align: right;"> بطاقة الاتصال بالانترنت  </td>
								</tr>
							</table>
						</td>
					</tr>
                    <tr>
						<td valign="middle" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" height="20px" width="50%" style="text-align: left;">Working Hours (Excl Lunch)</td>
									<td valign="middle" height="20px" width="50%" style="text-align: left;">10 hours Online per day</td>
								</tr>
							</table>
						</td>
						<td valign="middle" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" height="20px" width="50%" style="text-align: right;">10 ساعات في اليوم </td>
									<td valign="middle" height="20px" width="50%" style="text-align: right;"> ساعات العمل (باستثناء فترة الغداء) </td>
								</tr>
							</table>
						</td>
					</tr>
                    <tr>
						<td valign="middle" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" height="20px" width="50%" style="text-align: left;">AVG Rider Acceptance Rate</td>
									<td valign="middle" height="20px" width="50%" style="text-align: left;">100%</td>
								</tr>
							</table>
						</td>
						<td valign="middle" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" height="20px" width="50%" style="text-align: right;">100%</td>
									<td valign="middle" height="20px" width="50%" style="text-align: right;"> متوسط معدل قبول السائقين </td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
					<?php if($interview_detail->has_driving_license == 'yes' && $interview_detail->driving_license_type == 'Light Transport'){ ?>
                    <tr>
                        <td valign="middle" style="text-align: left;width: 20%"><br><br> Target & Incentive</td>
                        <td valign="middle" style="text-align: left;width: 60%">
                            &nbsp;&nbsp;• 0 to 449 SAR 4 each order<br>
                            &nbsp;&nbsp;• 0 to 450 SAR 4.5 each order<br>
                            &nbsp;&nbsp;• 451 to 500 onwards SAR 7 each order<br>
                            &nbsp;&nbsp;• 500 onwards SAR 8 each order
                        </td>
                        <td valign="middle" style="text-align: right;width: 20%"><br><br>  الهدف والحافز  </td>
                    </tr>
					<?php }else{ ?>
					<tr>
					    <td valign="middle" style="text-align: left;width: 20%"><br>Target & Incentive</td>
                        <td valign="middle" style="text-align: left;width: 60%">
					&nbsp;&nbsp;• 0 to 450 SAR 4 each order<br>&nbsp;&nbsp;• 450 onwards SAR 7 each order
						</td>
						<td valign="middle" style="text-align: right;width: 20%"><br>  الهدف والحافز  </td>
					</tr>
					<?php } ?>
                </table>
                <table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
                    <tr>
                        <td valign="middle" style="text-align: left;width: 20%"><br><br><br> Compliance*</td>
                        <td valign="middle" colspan="2" style="text-align: left;width: 60%">
                            &nbsp;&nbsp;✔ 26 Days to be Present<br>
                            &nbsp;&nbsp;✔ 10 hours to be Online Daily<br>
                            &nbsp;&nbsp;✔ Penalty SR 50 upon rejection<br>
                            &nbsp;&nbsp;✔ No Off on Weekends (Thursday/Friday/ Saturday)<br>
                            &nbsp;&nbsp;✔ No Absent in Last week<br>
                            &nbsp;&nbsp;✔ Non-Compliance Penalty SAR 1,000/-
                        </td>
                        <td valign="middle" style="text-align: right;width: 20%"><br><br><br>  ملاحظات*  </td>
                    </tr>
                    <tr>
                        <td valign="middle" style="text-align: left;width: 20%"> Contract Period </td>
                        <td valign="middle" style="text-align: left;width: 30%"> 2 Years (Transfer not Allowed)</td>
                        <td valign="middle" style="text-align: right;width: 30%">  2 سنوات (لايوجد نقل كفالة)  </td>
                        <td valign="middle" style="text-align: right;width: 20%">  مدة العقد  </td>
                    </tr>
                </table>
                <table><tr><td></td></tr></table>
                <table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size: 10px;">
                    <tr>
						<td valign="middle" style="text-align: center;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" width="100%" style="text-align: center;"><strong> All drivers should be able to use Google MAP </strong></td>
								</tr>
							</table>
						</td>
						<td valign="middle" style="text-align: center;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" width="100%" style="text-align: center;"><span style="direction: rtl;"><strong> يجب أن يكون جميع السائقين قادرون على استخدام خرائط جوجل </strong></span> </td>
								</tr>
							</table>
						</td>
					</tr>
                </table>
                <table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size: 10px;">
                    <tr>
						<td valign="middle" style="text-align: center;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" width="100%" style="text-align: center;"><span><strong> All drivers must bring 5G Mobile with 8GB RAM 256GB <br></strong></span></td>
								</tr>
							</table>
						</td>
						<td valign="middle" style="text-align: center;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="middle" width="100%" style="text-align: center;"><span style="direction: rtl;"><strong> جميع دراجين يكون لدي 5G هاتف مع ذاكرة عشوائي (Ram) 8 GB و ذاكرة جوال 256GB </strong></span> </td>
								</tr>
							</table>
						</td>
					</tr>
                </table>
                <table><tr><td></td></tr></table>
                <table><tr><td></td></tr></table>
                <table><tr><td></td></tr></table>
                <table width="100%" cellspacing="0" cellpadding="5" border="0" style="font-size: 10px;">
                    <tr>
                        <td style="text-align:center;"></td>
                        <td style="text-align:center;"><strong>___________________________ <br>HR Manager</strong></td>
                        <td style="text-align:center;"></td>
                    </tr>
                </table>
                <table><tr><td></td></tr></table>

                <table width="50%" cellspacing="0" cellpadding="5" border="0" style="font-size: 10px;">
					<tr>
						<td style="text-align:left;width: 40%">Offer Accepted: </td>
                        <td style="text-align:left;width: 60%"></td>
                    </tr>
                    <tr>
                        <td style="text-align:left;width: 40%">Signature with date: </td>
                        <td style="text-align:left;width: 60%"></td>
                    </tr>
                </table>
			</td>
		</tr>

	</table>
    <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
        <tr>
            <td valign="middle" align="right" style="width: 100%;"><img src="<?php echo base_url('admin_assets/images/header/offer-footer.png');?>"></td>
        </tr>
    </table>
</body>

</html>
