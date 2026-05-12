<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Baqala Station - Credit Application </title>
	<style>
	*{padding:0px;margin:0px;}
	
	</style>
</head>
<body>
	<style>
		table {border-collapse:collapse; table-layout:fixed;line-height:1.5;}
        table td {word-wrap:break-word;}
		.box{ border: 1px thin #000; width: 10px; }
	</style>
    <table border="0" cellspacing="0" cellpadding="0" style="font-size: 10px; width: 100%;">
		<tr>
			<td width="2%"></td>
			<td width="96%" align="center" style="font-size: 14px;">
				<strong>طلب الحصول على تسهيلات</strong>
				<br>
				<strong>Application for Credit Facility</strong>
			</td>
			<td width="2%"></td>
		</tr>
		<tr>
			<td width="2%"></td>
			<td width="96%" align="center" style="font-size: 12px;">
				<strong>أنا / نحن هنا نتقدم اليكم بطلب فتح حساب باسمي / باسمنا للحصول على تسهيلات ائتمانية للمشتريات بالأجل.</strong>
				<br>
				<strong>I/we hereby request you to open account in my/our name for the facility of Credit purchases</strong>
			</td>
			<td width="2%"></td>
		</tr>
		<tr><td colspan="3"><br></td></tr>
		<tr>
			<td width="2%"></td>
			<td width="96%" colspan="3" align="center" style="font-size: 12px;">
				<table border="1" cellspacing="0" cellpadding="5" style="font-size: 10px; width: 100%;">
					
					<tr>
						<td align="left" width="30%">Full Name of the Company</td>
						<td align="center" width="40%"><?= $user->company_name;?></td>
						<td align="right" width="30%">اسم الشركة</td>
					</tr>
					<tr>
						<td align="left" width="30%">CR No</td>
						<td align="center" width="40%"><?= $user->cr_no;?></td>
						<td align="right" width="30%">رقم السجل التجاري</td>
					</tr>
					<tr>
						<td align="left" width="30%">VAT No</td>
						<td align="center" width="40%"><?= $user->vat_no;?></td>
						<td align="right" width="30%">الرقم الضريبي</td>
					</tr>
					<tr>
						<td align="left" width="30%">Nature of Business</td>
						<td align="center" width="40%"><?= $user->business_nature;?></td>
						<td align="right" width="30%">نطاق العمل</td>
					</tr>
					<tr>
						<td align="left" width="30%">Type of Company</td>
						<td align="center" width="40%"><?= $user->company_type;?></td>
						<td align="right" width="30%">نوع الشركة</td>
					</tr>
					<tr>
						<td align="left" width="30%">Tel No</td>
						<td align="center" width="40%"><?= $user->client_telephone;?></td>
						<td align="right" width="30%">رقم الهاتف</td>
					</tr>
					<tr>
						<td align="left" width="30%">Fax No</td>
						<td align="center" width="40%"><?= $user->client_fax;?></td>
						<td align="right" width="30%">رقم الفاكس</td>
					</tr>
					<tr>
						<td colspan="2" height="20px" align="center" width="50%" style="background-color: #eeeeee;">National Address</td>
						<td colspan="1" height="20px" align="center" width="50%" style="background-color: #eeeeee;">العنوان الوطني</td>
					</tr>
					<tr>
						<td align="left" width="30%">Building Number</td>
						<td align="center" width="40%"><?= (!empty($user_info->building_no)) ? $user_info->building_no : '';?></td>
						<td align="right" width="30%">رقم المبنى</td>
					</tr>
					<tr>
						<td align="left" width="30%">Street Name</td>
						<td align="center" width="40%"><?= (!empty($user_info->street_name)) ? $user_info->street_name : '';?></td>
						<td align="right" width="30%">اسم الشارع</td>
					</tr>
					<tr>
						<td align="left" width="30%">District Name</td>
						<td align="center" width="40%"><?= (!empty($user_info->district)) ? $user_info->district : '';?></td>
						<td align="right" width="30%">الحي</td>
					</tr>
					<tr>
						<td align="left" width="30%">Additional No</td>
						<td align="center" width="40%"><?= (!empty($user_info->additional_no)) ? $user_info->additional_no : '';?></td>
						<td align="right" width="30%">الرقم الإضافي</td>
					</tr>
					<tr>
						<td align="left" width="30%">Unit No</td>
						<td align="center" width="40%"><?= (!empty($user_info->unit_no)) ? $user_info->unit_no : '';?></td>
						<td align="right" width="30%">رقم الوحدة</td>
					</tr>
					<tr>
						<td align="left" width="30%">City</td>
						<td align="center" width="40%"><?= (!empty($user_info->city_name)) ? $user_info->city_name : '';?></td>
						<td align="right" width="30%">المدينة</td>
					</tr>
					<tr>
						<td align="left" width="30%">Pin Code</td>
						<td align="center" width="40%"><?= (!empty($user_info->postal_code)) ? $user_info->postal_code : '';?></td>
						<td align="right" width="30%">رقم التعريف</td>
					</tr>
					<tr>
						<td colspan="2" height="20px" width="50%" align="center" style="background-color: #eeeeee;">Contact Information</td>
						<td colspan="1" height="20px" width="50%" align="center" style="background-color: #eeeeee;">معلومات التواصل</td>
					</tr>
					<tr>
						<td align="left" width="30%">Name of the Owner/Director 1</td>
						<td align="center" width="40%"><?= (!empty($user_info->director_name1)) ? $user_info->director_name1 : '';?></td>
						<td align="right" width="30%">اسم المالك\المدير 1</td>
					</tr>
					<tr>
						<td align="left" width="30%">ID No of the Owner/Director 1</td>
						<td align="center" width="40%"><?= (!empty($user_info->director_id_no1)) ? $user_info->director_id_no1 : '';?></td>
						<td align="right" width="30%">رقم احوال المالك\المدير 1</td>
					</tr>
					<tr>
						<td align="left" width="30%">Mobile No</td>
						<td align="center" width="40%"><?= (!empty($user_info->director_mobile1)) ? $user_info->director_mobile1 : '';?></td>
						<td align="right" width="30%">رقم الجوال</td>
					</tr>
					<tr>
						<td align="left" width="30%">Email ID</td>
						<td align="center" width="40%"><?= (!empty($user_info->director_email1)) ? $user_info->director_email1 : '';?></td>
						<td align="right" width="30%">البريد الألكتروني</td>
					</tr>
					<tr>
						<td align="left" width="30%">Name of the Owner/Director 2</td>
						<td align="center" width="40%"><?= (!empty($user_info->director_name2)) ? $user_info->director_name2 : '';?></td>
						<td align="right" width="30%">اسم المالك\المدير 2</td>
					</tr>
					<tr>
						<td align="left" width="30%">ID No of the Owner/Director 2</td>
						<td align="center" width="40%"><?= (!empty($user_info->director_id_no2)) ? $user_info->director_id_no2 : '';?></td>
						<td align="right" width="30%">رقم احوال المالك\المدير 2</td>
					</tr>
					<tr>
						<td align="left" width="30%">Mobile No</td>
						<td align="center" width="40%"><?= (!empty($user_info->director_mobile2)) ? $user_info->director_mobile2 : '';?></td>
						<td align="right" width="30%">رقم الجوال</td>
					</tr>
					<tr>
						<td align="left" width="30%">Email ID</td>
						<td align="center" width="40%"><?= (!empty($user_info->director_email2)) ? $user_info->director_email2 : '';?></td>
						<td align="right" width="30%">البريد الألكتروني</td>
					</tr>
					<tr>
						<td align="left" width="30%">Finance Manager Name</td>
						<td align="center" width="40%"><?= (!empty($user_info->finance_name)) ? $user_info->finance_name : '';?></td>
						<td align="right" width="30%">اسم المدير المالي</td>
					</tr>
					<tr>
						<td align="left" width="30%">Mobile No</td>
						<td align="center" width="40%"><?= (!empty($user_info->finance_mobile)) ? $user_info->finance_mobile : '';?></td>
						<td align="right" width="30%">رقم الجوال</td>
					</tr>
					<tr>
						<td align="left" width="30%">Email ID</td>
						<td align="center" width="40%"><?= (!empty($user_info->finance_email)) ? $user_info->finance_email : '';?></td>
						<td align="right" width="30%">البريد الألكتروني</td>
					</tr>
					<tr>
						<td align="left" width="30%">Procurement Manager Name</td>
						<td align="center" width="40%"><?= (!empty($user_info->other_name)) ? $user_info->other_name : '';?></td>
						<td align="right" width="30%">اسم مدير المشتريات</td>
					</tr>
					<tr>
						<td align="left" width="30%">Mobile No</td>
						<td align="center" width="40%"><?= (!empty($user_info->other_mobile)) ? $user_info->other_mobile : '';?></td>
						<td align="right" width="30%">رقم الجوال</td>
					</tr>
					<tr>
						<td align="left" width="30%">Email ID</td>
						<td align="center" width="40%"><?= (!empty($user_info->other_email)) ? $user_info->other_email : '';?></td>
						<td align="right" width="30%">البريد الألكتروني</td>
					</tr>
				</table>
				<table border="0" cellspacing="0" cellpadding="5" style="font-size: 10px; width: 100%;">
				    <tr>
						<td colspan="3"></td>
					</tr>
				</table>
				<table border="1" cellspacing="0" cellpadding="5" style="font-size: 10px; width: 100%;">
					<?php
						$authSignIds = explode(',',$user_info->authorize_ids);
						$count_id = count($authSignIds);
						
						$authSign['nameP0'] = '';
						$authSign['mobileP0'] = '';
						$authSign['emailP0'] = '';

						$authSign['nameP1'] = '';
						$authSign['mobileP1'] = '';
						$authSign['emailP1'] = '';
						
						for ($i=0; $i < $count_id; $i++) { 
							if($authSignIds[$i] == 'director1'){
								$authSign['nameP'.$i] = $user_info->director_name1;
								$authSign['mobileP'.$i] = $user_info->director_mobile1;
								$authSign['emailP'.$i] = $user_info->director_email1;
							}elseif ($authSignIds[$i] == 'director2') {
								$authSign['nameP'.$i] = $user_info->director_name1;
								$authSign['mobileP'.$i] = $user_info->director_mobile2;
								$authSign['emailP'.$i] = $user_info->director_email2;
							}elseif ($authSignIds[$i] == 'finance') {
								$authSign['nameP'.$i] = $user_info->finance_name;
								$authSign['mobileP'.$i] = $user_info->finance_mobile;
								$authSign['emailP'.$i] = $user_info->finance_email;
							}elseif ($authSignIds[$i] == 'procurement') {
								$authSign['nameP'.$i] = $user_info->other_name;
								$authSign['mobileP'.$i] = $user_info->other_mobile;
								$authSign['emailP'.$i] = $user_info->other_email;
							}else {
								$authSign['nameP'.$i] = 'N/A';
								$authSign['mobileP'.$i] = 'N/A';
								$authSign['emailP'.$i] = 'N/A';
							}
						}
					?>
				    <tr>
						<td align="left" width="30%">Person Authorized 1 to Sign PO</td>
						<td align="center" width="40%"><?= $authSign['nameP0']; ?></td>
						<td align="right" width="30%">اسم المفوض لتوقيع طلبات الشراء 1</td>
					</tr>
					<tr>
						<td align="left" width="30%">Mobile No</td>
						<td align="center" width="40%"><?= $authSign['mobileP0']; ?></td>
						<td align="right" width="30%">رقم الجوال</td>
					</tr>
					<tr>
						<td align="left" width="30%">Email ID</td>
						<td align="center" width="40%"><?= $authSign['emailP0']; ?></td>
						<td align="right" width="30%">البريد الألكتروني</td>
					</tr>
				    <tr>
						<td align="left" width="30%">Person Authorized 2 to Sign PO</td>
						<td align="center" width="40%"><?= $authSign['nameP1']; ?></td>
						<td align="right" width="30%">اسم المفوض لتوقيع طلبات الشراء 2</td>
					</tr>
					<tr>
						<td align="left" width="30%">Mobile No</td>
						<td align="center" width="40%"><?= $authSign['mobileP1']; ?></td>
						<td align="right" width="30%">رقم الجوال</td>
					</tr>
					<tr>
						<td align="left" width="30%">Email ID</td>
						<td align="center" width="40%"><?= $authSign['emailP1']; ?></td>
						<td align="right" width="30%">البريد الألكتروني</td>
					</tr>
					<tr>
						<td colspan="2" width="50%" height="20px" align="center" style="background-color: #eeeeee;">Bank Information</td>
						<td colspan="1" width="50%" height="20px" align="center" style="background-color: #eeeeee;">معلومات البنك</td>
					</tr>
					<tr>
						<td align="left" width="30%">Name of the Bank</td>
						<td align="center" width="40%"><?= (!empty($bank_info->bank_name)) ? $bank_info->bank_name : 'N/A';?></td>
						<td align="right" width="30%">اسم البنك</td>
					</tr>
					<tr>
						<td align="left" width="30%">Branch of the Bank</td>
						<td align="center" width="40%"><?= (!empty($bank_info->bank_name)) ? $bank_info->branch_name : 'N/A';?></td>
						<td align="right" width="30%">فرع البنك</td>
					</tr>
					<tr>
						<td align="left" width="30%">Bank Account No</td>
						<td align="center" width="40%"><?= (!empty($bank_info->bank_account_no)) ? $bank_info->bank_account_no : 'N/A';?></td>
						<td align="right" width="30%">رقم الحساب البنكي</td>
					</tr>
					<tr>
						<td align="left" width="30%">Bank IBAN</td>
						<td align="center" width="40%"><?= (!empty($bank_info->iban_number)) ? $bank_info->iban_number : 'N/A';?></td>
						<td align="right" width="30%">رقم الآيبان</td>
					</tr>
					<tr>
						<td align="left" width="30%"></td>
						<td align="center" width="40%"></td>
						<td align="right" width="30%"></td>
					</tr>
					<tr>
						<td colspan="2" align="center" width="50%"><strong>Credit Terms & Conditions</strong></td>
						<td align="center" width="50%">شروط وأحكام الائتمان</td>
					</tr>
					<tr>
						<td colspan="2" align="left" width="50%">Account must be settled within the period approved. Failure to do so may result in suspension or cancellation od said facilities</td>
						<td align="right" width="50%">يجب تسوية الحساب خلال الفترة المعتمدة. وقد يؤدي عدم القيام بذلك إلى تعليق او إلغاء الاتفاق <br> المذكور.</td>
					</tr>
					<tr>
						<td colspan="2" align="left" width="50%">Goods returned on the day of delivery may be accepted at the discretion of the management, provided that they are returned in good condition.</td>
						<td align="right" width="50%">ويجوز قبول البضائع التي يتم إرجاعها في يوم التسليم وفقا لتقديرها، بشرط أن تعاد في حالة جيدة.</td>
					</tr>
					<tr>
						<td colspan="2" align="left" width="50%">Claims for Shortage must be lodged at the time of collection or delivery, prior to signature of the delivery note or receipt</td>
						<td align="right" width="50%">ويجب تقديم المطالبات المتعلقة بالنقص في وقت تحصيلها أو تسليمها، قبل التوقيع على اذن التسليم <br> أو الاستلام.</td>
					</tr>
					<tr>
						<td colspan="2" align="left" width="50%">All goods/works supplied must be accompanied by local purchase order. If the local purchase order is not received then the invoice will be raised according to our debit memos/ delivery notes</td>
						<td align="right" width="50%">جميع السلع / الأعمال المقدمة يجب ان تكون مصحوبة بأمر الشراء محلي. إذا لم يتم استلام أمر الشراء المحلي سوف يتم رفع الفاتورة وفقا لما لدينا من أذن الخصم / أذن التسليم.</td>
					</tr>
				</table>
			</td>
			<td width="2%"></td>
		</tr>
		<tr><td colspan="5"><br></td></tr>
		<tr>
			<td width="2%"></td>
			<td width="96%" align="right" height="40px" style="font-size: 10px;">
			أنا / نحن ............................ أتعهد / نتعهد بموجب الدفع لمؤسسة مها الفلا للتجارة مبالغ قيمة السلع / الخدمات خلال فترة الائتمان المتفق عليها وأوافق / نوافق كذلك على أنه إذا لم يتم تقديم أي استفسار من قبلي / قبلنا كتابيا خلال أسبوعين، فسيتم التعامل مع كشف الحساب المستلم من مؤسسة مها الفلا للتجارة على انه صحيح.
			</td>
			<td width="2%"></td>
		</tr>
		<tr>
			<td width="2%"></td>
			<td width="96%" align="left" height="40px" style="font-size: 10px;"><br>
				I/We ............................ hereby undertake to pay Maha Al Fala Trading Est. amount for goods / services may be supplied, within the agreed credit period. It is further agreed that if no query raised by you in writing within 2 weeks, then a statement of account received from Maha Al Fala Trading Est treated as correct.
			</td>
			<td width="2%"></td>
		</tr>
		<tr><td colspan="3"><br></td></tr>
		<tr>
			<td width="2%"></td>
			<td width="96%" colspan="3" align="center" style="font-size: 12px;">
				<table border="1" cellspacing="0" cellpadding="5" style="font-size: 10px; width: 100%;">
					<tr>
						<td colspan="2" align="center" width="50%"><strong>Authorized Signatory in CoC</strong></td>
						<td align="center" width="50%">المفوض بالتوقيع بالغرفة التجارية</td>
					</tr>
					<tr>
						<td align="left" width="30%">Name</td>
						<td align="center" width="40%"></td>
						<td align="right" width="30%">الأسم</td>
					</tr>
					<tr>
						<td height="40" align="left" width="30%">Signature</td>
						<td height="40" align="center" width="40%"></td>
						<td height="40" align="right" width="30%">التوقيع</td>
					</tr>
					<tr>
						<td height="40" align="left" width="30%">Attestation from Chamber of Commerce</td>
						<td height="40" align="center" width="40%"></td>
						<td height="40" align="right" width="30%">تصديق الغرفة التجارية</td>
					</tr>
				</table>
			</td>
			<td width="2%"></td>
		</tr>
		<tr><td colspan="5"><br></td></tr>
		
		<!-- <tr>
			<td width="2%"></td>
			<td width="96%" colspan="3" align="center" style="font-size: 12px;">
				<table border="1" cellspacing="0" cellpadding="5" style="font-size: 10px; width: 100%;">
					<tr>
						<td align="left" width="30%">For official us of BS only</td>
						<td align="center" width="40%"></td>
						<td align="right" width="30%">للإستخدام الرسمي لبقالة ستيشن فقط</td>
					</tr>
					<tr>
						<td align="left" width="30%">Request Credit Limit & Days</td>
						<td align="center" width="40%"></td>
						<td align="right" width="30%">طلب الحد الائتماني و الأيام</td>
					</tr>
					<tr>
						<td align="left" width="30%">Approved Credit Limit & Days</td>
						<td align="center" width="40%"></td>
						<td align="right" width="30%">الحد الأئتماني والأيام المعتمدة</td>
					</tr>
					<tr>
						<td height="40" style="text-decoration:underline;vertical-align:bottom;text-align:center;" width="25%"><br><br>Account RM Name <br> اسم مدير العلاقات</td>
						<td height="40" style="text-decoration:underline;vertical-align:bottom;text-align:center;" width="25%"><br><br>Sales Manager <br> مدير المبيعات</td>
						<td height="40" style="text-decoration:underline;vertical-align:bottom;text-align:center;" width="25%"><br><br>Finance Manager <br> مدير المالية</td>
						<td height="40" style="text-decoration:underline;vertical-align:bottom;text-align:center;" width="25%"><br><br>Chairman <br> الرئيس</td>
					</tr>
				</table>
			</td>
			<td width="2%"></td>
		</tr> -->
	</table>

</body>

</html>
