<?php
$joiningDate = $emp_detail->work_joining_date;

// Set your correct timezone here, for example 'Asia/Riyadh' or 'Asia/Dubai'
$timezone = 'Asia/Riyadh';

$fmt = new IntlDateFormatter(
    'ar_SA', // Arabic locale
    IntlDateFormatter::FULL,
    IntlDateFormatter::NONE,
    $timezone,
    IntlDateFormatter::GREGORIAN,
    'dd MMMM yyyy' // Day Month Year
);
$arabic_joining_date = $fmt->format(strtotime($joiningDate));
$joining_date = date('d-m-Y', strtotime($emp_detail->work_joining_date));
$contractEndDate = !empty($joiningDate) 
    ? (new DateTime($joiningDate))->modify('+2 years')->format('d-m-Y') 
    : null;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Baqala Station - Employment Contract</title>
	<style>
	*{padding:0px;margin:0px;}
	</style>
</head>
<body>
	<style>
		table {border-collapse:collapse; table-layout:fixed;line-height:1.5;}
        table td {word-wrap:break-word;}
	</style>
    <table border="0" cellspacing="0" cellpadding="5" style="width: 100%;">
        <tr>
            <td align="left">
                <h3>Contract <?= $emp_detail->emp_no.'_'.$emp_detail->full_name;?></h3>
            </td>
        </tr>
    </table>
    <table border="1" cellspacing="0" cellpadding="3" style="width: 100%;font-size: 10px;">
        <tr>
            <td align="left">This contract was created electronically under the supervision of the Ministry of Human Resources and Social Development, Kingdom of Saudi Arabia on <?php echo ReturnGreg2Hijri($joiningDate);?> (<?php echo $joining_date;?>), between:</td>
            <td align="right">
                تم إنشاء هذا العقد إلكترونيًا تحت إشراف وزارة الموارد البشرية والتنمية الاجتماعية في المملكة العربية السعودية بتاريخ <?php echo $arabic_joining_date;?>  هـ ( <?php echo $joining_date;?> م) بين:
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
        <tr style="font-weight: bold;background-color:rgb(252, 233, 204);">
            <td align="left"><b>FIRST PARTY:</b></td>
            <td align="right"><b>الطرف الأول:</b></td>
        </tr>
    </table>
    <table border="1" cellspacing="0" cellpadding="3" style="width: 100%;font-size: 10px;">
        <tr>
            <td align="right">Company/Corporation</td>
            <td align="center"><?= !empty($emp_detail->full_name) ? $emp_detail->sponsor_name : '';?></td>
            <td align="left">الشركة/المؤسسة</td>
        </tr>
        <tr>
            <td align="right">National Unified Number</td>
            <td align="center"><?= !empty($emp_detail->full_name) ? $emp_detail->sponsor_employer_id : '';?></td>
            <td align="left">الرقم الموحد الوطني</td>
        </tr>
        <tr>
            <td align="right">Establishment Number</td>
            <td align="center"><?= !empty($emp_detail->full_name) ? $emp_detail->sponsor_mol_id : '';?></td>
            <td align="left">رقم المنشأة</td>
        </tr>
        <tr>
            <td align="right">Commercial Registration</td>
            <td align="center"><?= !empty($emp_detail->full_name) ? $emp_detail->sponsor_cr_no : '';?></td>
            <td align="left">السجل التجاري</td>
        </tr>
        <tr>
            <td align="right">Address</td>
            <td align="center"><?= !empty($emp_detail->full_name) ? $emp_detail->sponsor_address : '';?></td>
            <td align="left">العنوان</td>
        </tr>
        <tr>
            <td align="right">Work Location</td>
            <td align="center"><?= !empty($emp_detail->full_name) ? $emp_detail->sponsor_work_location : '';?></td>
            <td align="left">موقع العمل</td>
        </tr>
        <tr>
            <td align="right">Email Address</td>
            <td align="center"><?= !empty($emp_detail->full_name) ? $emp_detail->sponsor_email : '';?></td>
            <td align="left">البريد الإلكتروني</td>
        </tr>
        <tr>
            <td align="right">Represented by</td>
            <td align="center"><?= !empty($emp_detail->full_name) ? $emp_detail->represented_by : '';?></td>
            <td align="left">يمثلها</td>
        </tr>
        <tr>
            <td align="left"></td>
            <td align="center"></td>
            <td align="right"></td>
        </tr>
    </table>
    <table border="1" cellspacing="0" cellpadding="3" style="width: 100%;font-size: 10px;">
        <tr>
            <td align="left">hereinafter referred to as (First Party),</td>
            <td align="right">ويُشار إليه فيما بعد بـ (الطرف الأول).</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
        <tr style="font-weight: bold;background-color:rgb(252, 233, 204);">
            <td align="left"><b>SECOND PARTY:</b></td>
            <td align="right"><b> الطرف الثاني:</b></td>
        </tr>
    </table>
    <table border="1" cellspacing="0" cellpadding="3" style="width: 100%;font-size: 10px;">
        <tr>
            <td align="right">Name</td>
            <td align="center"><?= !empty($emp_detail->full_name) ? $emp_detail->full_name : '';?></td>
            <td align="left">الاسم</td>
        </tr>
        <tr>
            <td align="right">Profession</td>
            <td align="center"><?= !empty($emp_detail->designation_name) ? $emp_detail->designation_name : '';?></td>
            <td align="left">المهنة</td>
        </tr>
        <tr>
            <td align="right">Employee Number</td>
            <td align="center"><?= !empty($emp_detail->emp_no) ? $emp_detail->emp_no : '';?></td>
            <td align="left">رقم الموظف</td>
        </tr>
        <tr>
            <td align="right">Nationality</td>
            <td align="center"><?= !empty($emp_detail->nationality_name) ? $emp_detail->nationality_name : '';?></td>
            <td align="left">الجنسية</td>
        </tr>
        <tr>
            <td align="right">Passport Number</td>
            <td align="center"><?= !empty($emp_detail->passport_no) ? $emp_detail->passport_no : '';?></td>
            <td align="left">رقم جواز السفر</td>
        </tr>
        <tr>
            <td align="right">Date of Birth</td>
            <td align="center"><?= !empty($emp_detail->dob) ? date('d-m-Y', strtotime($emp_detail->dob)) : '';?></td>
            <td align="left">تاريخ الميلاد</td>
        </tr>
        <tr>
            <td align="right">Identity Number</td>
            <td align="center"><?= !empty($emp_detail->iqama_no) ? $emp_detail->iqama_no : '';?></td>
            <td align="left"> رقم الهوية</td>
        </tr>
        <tr>
            <td align="right">ID Type</td>
            <td align="center">Iqama</td>
            <td align="left">نوع الهوية</td>
        </tr>
        <tr>
            <td align="right">Gender</td>
            <td align="center"><?= ucfirst($emp_detail->gender);?></td>
            <td align="left">الجنس</td>
        </tr>
        <tr>
            <td align="right">Marital Status</td>
            <td align="center"><?= $emp_detail->marital_status;?></td>
            <td align="left">الحالة الاجتماعية</td>
        </tr>
        <tr>
            <td align="right">Education</td>
            <td align="center">NA</td>
            <td align="left"> المؤهل التعليمي </td>
        </tr>
        <?php
            $bank_details = json_decode($emp_detail->payment_type_detail ?? '', true);
            $accountType = $bank_details['account_type'] ?? '';
            $bankName    = $bank_details['bank_name'] ?? '';
            $ibanNo      = $bank_details['iban_no'] ?? '';
        ?>
        <tr>
            <td align="right">IBAN</td>
            <td align="center"><?= $ibanNo;?></td>
            <td align="left">رقم الحساب البنكي (IBAN)</td>
        </tr>
        <tr>
            <td align="right">Bank Name</td>
            <td align="center"><?= $bankName;?></td>
            <td align="left"> اسم البنك</td>
        </tr>
        <tr>
            <td align="right">Email Address</td>
            <td align="center"><?= $emp_detail->email;?></td>
            <td align="left">البريد الإلكتروني</td>
        </tr>
        <tr>
            <td align="right">Mobile Number</td>
            <td align="center"><?= $emp_detail->mobile;?></td>
            <td align="left"> رقم الجوال</td>
        </tr>
        <tr>
            <td align="right">Qiwa Contract No</td>
            <td align="center"><?= !empty($emp_detail->qiwa_contract_no) ? $emp_detail->full_name : 'NA';?></td>
            <td align="left">رقم عقد قوى</td>
        </tr>
    </table>
    <table border="1" cellspacing="0" cellpadding="3" style="width: 100%;font-size: 10px;">
        <tr>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td align="left">hereinafter referred to as (Second Party),</td>
            <td align="right">ويُشار إليه فيما بعد بـ (الطرف الثاني).</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td align="left">The two parties have agreed that the second party will work for the first party under its management and supervision with the job of Delivery Associate - Bike/Car and carry out the work assigned to him/her in proportion to his/her practical, scientific and technical capabilities in accordance with the needs of the work and in a manner that does not conflict with the controls stipulated in Articles (fifty-eight, fifty-nine, sixty) from the Saudi Labor Law.</td>
            <td align="right"> اتفق الطرفان على أن يعمل الطرف الثاني لدى الطرف الأول تحت إدارته وإشرافه في وظيفة مندوب توصيل - دراجة نارية/سيارة، على أن يقوم بتنفيذ الأعمال الموكلة إليه بما يتناسب مع قدراته العملية والعلمية والفنية وفقًا لاحتياجات العمل، وبما لا يتعارض مع الضوابط المنصوص عليها في المواد (58، 59، 60) من نظام العمل السعودي. </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td align="left">The contract's duration is 2 years, starting from <?= $joining_date;?> and ending in <?= $contractEndDate;?>, noted that the date of commencement (joining date) of the second party’s work is <?= $joining_date;?>.</td>
            <td align="right">مدة هذا العقد سنتان، تبدأ من <?= $joining_date;?> وتنتهي في  <?= $contractEndDate;?>، مع الإشارة إلى أن تاريخ مباشرة العمل (تاريخ الانضمام) للطرف الثاني هو  <?= $joining_date;?>.</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>The contract will be renewed for a similar period unless one of the two parties informs the other in writing of his unwillingness to renew the contract 60 days before the contract expires.</td>
            <td align="right">سيتم تجديد العقد لمدة مماثلة ما لم يُبلغ أحد الطرفين الطرف الآخر خطيًا بعدم رغبته في التجديد قبل 60 يومًا من انتهاء العقد.</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>The second party is subject to a trial period of 180 days starting from the date of commencing work, during which Eid al-Fitr and Eid al-Adha holidays and sick leave are not included in the calculation. Only First party has the right to terminate the contract during this period.</td>
            <td align="right">يخضع الطرف الثاني لفترة تجربة مدتها 180 يومًا تبدأ من تاريخ مباشرة العمل، ولا تُحتسب إجازات عيد الفطر وعيد الأضحى والإجازات المرضية ضمن هذه المدة. وللطرف الأول فقط الحق في إنهاء العقد خلال هذه الفترة.</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
        <tr style="font-weight: bold;background-color:rgb(252, 233, 204);">
            <td>Working days and hours</td>
            <td align="right">أيام وساعات العمل</td>
        </tr>
        <tr>
            <td>Normal working days are set as 6 days per week and working hours are set as 8 daily hours. The first party is obliged to pay the second party an additional wage for the overtime hours equal to the hourly wage plus 50% of his basic wage.</td>
            <td align="right">الأيام العادية للعمل هي 6 أيام في الأسبوع، وتُحدد ساعات العمل بـ 8 ساعات يوميًا. <br>
يلتزم الطرف الأول بدفع أجر إضافي عن ساعات العمل الإضافية يعادل الأجر بالساعة مضافًا إليه 50% من الأجر الأساسي.</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>This is a sales target-based job hence the employee must complete the agreed delivery in Annexure A.</td>
            <td align="right">هذا العمل يعتمد على تحقيق الأهداف، لذا يجب على الموظف إكمال عدد التوصيلات المتفق عليها في الملحق (A).</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
        <tr style="font-weight: bold;background-color:rgb(252, 233, 204);">
            <td>The obligations of the first party</td>
            <td align="right"> التزامات الطرف الأول </td>
        </tr>
        <tr>
            <td>The first party pays the second party a basic fee of 500.00<br>Saudi Riyals, which is due at the end of each month.</td>
            <td align="right"> يدفع الطرف الأول للطرف الثاني راتبًا أساسيًا قدره 500.00 ريال سعودي، يستحق في نهاية كل شهر. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right"></td>
        </tr>
        <tr>
            <td>The first party to the second party is also committed to the following:</td>
            <td align="right"> يلتزم الطرف الأول تجاه الطرف الثاني أيضًا بما يلي: </td>
        </tr>
        <tr>
            <td></td>
            <td align="right"></td>
        </tr>
        <tr>
            <td>Provide adequate housing throughout the contract period</td>
            <td align="right"> توفير سكن مناسب طوال مدة العقد. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right"></td>
        </tr>
        <tr>
            <td>Provide an appropriate means of transportation from their residence to the workplace</td>
            <td align="right"> توفير وسيلة نقل مناسبة من السكن إلى مقر العمل. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right"></td>
        </tr>
        <tr>
            <td>Pay 0.00 Saudi Riyals, a Food Allowance payable at the end of each month.</td>
            <td align="right"> دفع 0.00 ريال سعودي كبدل طعام يُصرف في نهاية كل شهر. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>The second party deserves for each year a paid annual leave of 21 days, and the first party determines its dates during the year of entitlement according to work conditions, provided that the leave wage is paid in advance when it is due, and the first party has to postpone the leave after the end of the year of entitlement for a period not exceeding 90days, and with the consent of the party Second, in writing, to postpone it to the end of the year following the year of entitlement, according to the requirements of work conditions.</td>
            <td align="right"> يستحق الطرف الثاني إجازة سنوية مدفوعة الأجر لمدة 21 يومًا عن كل سنة عمل، ويحدد الطرف الأول مواعيدها خلال سنة الاستحقاق وفقًا لظروف العمل، على أن يتم دفع أجر الإجازة مقدمًا عند استحقاقها. كما يحق للطرف الأول تأجيل الإجازة بعد انتهاء سنة الاستحقاق لمدة لا تتجاوز 90 يومًا، وبموافقة خطية من الطرف الثاني، يمكن تأجيلها حتى نهاية السنة التالية لسنة الاستحقاق، وفقًا لمتطلبات ظروف العمل. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>The first party is obligated to provide medical care to the second party with health insurance in accordance with the provisions of the Cooperative Health Insurance Policy</td>
            <td align="right"> يلتزم الطرف الأول بتوفير الرعاية الطبية للطرف الثاني من خلال التأمين الصحي، وذلك وفقًا لأحكام وثيقة التأمين الصحي التعاوني. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>The first party is obligated to pay the contributions of the General Organization for Social Insurance according to its regulations</td>
            <td align="right"> يلتزم الطرف الأول بسداد اشتراكات المؤسسة العامة للتأمينات الاجتماعية وفقًا لأنظمتها ولوائحها. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>The first party bears the fees for the second party’s recruitment/transfer, the residency fee, the work permit and its renewal and any resulting fines, change of occupation, exit and return fees, and the return ticket for the second party to his home by the same means he/she came by after the end of the relationship between the two parties.</td>
            <td align="right"> يتحمل الطرف الأول رسوم استقدام أو نقل الطرف الثاني، ورسوم الإقامة، وتصريح العمل وتجديده، وأي غرامات ناتجة عن ذلك، بالإضافة إلى تكاليف تغيير المهنة، ورسوم الخروج والعودة، وتذكرة العودة إلى موطن الطرف الثاني بنفس الوسيلة التي جاء بها، وذلك بعد انتهاء العلاقة التعاقدية بين الطرفين. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>The first party is obligated to pay the expenses of preparing the body of the second party and transporting it to the party in which the contract was concluded or bringing the employee from it unless he is buried with the consent of his relatives inside the Kingdom, or the General Organization for Social Insurance is obligated to do so.</td>
            <td align="right"> كما يلتزم الطرف الأول بتحمل تكاليف تجهيز جثمان الطرف الثاني ونقله إلى الجهة التي تم التعاقد فيها أو استقدام الموظف منها، ما لم يتم دفنه داخل المملكة بموافقة ذويه، أو تتحمل المؤسسة العامة للتأمينات الاجتماعية هذه المسؤولية. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr style="font-weight: bold;background-color:rgb(252, 233, 204);">
            <td>The obligations of the second party</td>
            <td align="right"> التزامات الطرف الثاني </td>
        </tr>
        <tr>
            <td>To perform the work entrusted to him in accordance with the principles of the profession and according to the instructions of the first party if there is nothing in these instructions that contradicts the contract, order or public morals and there is nothing in their implementation that puts him at risk.</td>
            <td align="right"> القيام بالعمل المكلف به وفقًا لأصول المهنة وتعليمات الطرف الأول، بشرط ألا تتعارض هذه التعليمات مع العقد أو الأنظمة أو الآداب العامة، وألا تعرضه لأي مخاطر أثناء التنفيذ. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>To take adequate care of the tools and tasks assigned to him and the raw materials owned by the first party placed at his disposal or in his custody and to return to the first party the non-expendable materials.</td>
            <td align="right"> المحافظة على الأدوات والمعدات والمواد الخام التي يمتلكها الطرف الأول والتي تم وضعها تحت تصرفه أو في عهدته، مع الالتزام بإعادة المواد غير القابلة للاستهلاك إلى الطرف الأول عند انتهاء استخدامها. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>To help and support without requiring additional pay in cases of dangers threatening the safety of the workplace or the people employed in it.</td>
            <td align="right"> تقديم المساعدة والدعم عند الحاجة، دون المطالبة بأي أجر إضافي، في حالات الطوارئ أو المخاطر التي تهدد سلامة بيئة العمل أو الأشخاص العاملين فيها. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr style="font-weight: bold;background-color:rgb(252, 233, 204);">
            <td>Attendance</td>
            <td align="right"> الحضور والالتزام: </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>The First Party shall have the right to deliver all notices and notify cations to the Second Party during the period of employment, directly by hand or by sending it to the address indicated in this contract or to his email address or by putting them on the noticeboard of the First Party's place of business and where the Second Party works. Such a delivery shall be considered as acknowledgment of receipt of such notices and notifications on the date stated in the notice, and such notices shall be deemed to be delivered by hand. The Second Party shall notify the First Party in writing if it changes its address or e-mail address indicated at the forefront of this contract.</td>
            <td align="right"> يحق للطرف الأول تسليم جميع الإشعارات والإخطارات للطرف الثاني خلال فترة العمل، إما يدويًا بشكل مباشر، أو بإرسالها إلى العنوان الموضح في هذا العقد، أو إلى عنوان بريده الإلكتروني، أو بوضعها على لوحة الإعلانات في مقر عمل الطرف الأول أو في مكان عمل الطرف الثاني. ويُعتبر هذا التسليم بمثابة إقرار باستلام هذه الإشعارات والتبليغات في التاريخ الموضح في الإشعار، وتُعد هذه الإشعارات كما لو تم تسليمها يدًا بيد. ويجب على الطرف الثاني إشعار الطرف الأول كتابيًا في حال تغيّر عنوانه أو بريده الإلكتروني المبيّن في مقدمة هذا العقد. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr style="font-weight: bold;background-color:rgb(252, 233, 204);">
            <td>Probation Period</td>
            <td align="right"> الحضور والالتزام: </td>
        </tr>
        <tr>
            <td>The Second Party shall be subject to a probationary period of (90) ninety days from the date of commencement of work, and this period shall not include Eid Al-Fitr, Eid Al-Adha, National Day and Sick leave days. The First Party shall have the right during the probationary period to terminate this contract without notice, compensation or reward. The trial period can be extended to another ninety (90) days with the written consent of both parties, provided that the extension shall be during the validity of the first trial period.</td>
            <td align="right"> يخضع الطرف الثاني لفترة تجربة مدتها (90) تسعون يومًا تبدأ من تاريخ مباشرة العمل، ولا تُحتسب ضمن هذه الفترة أيام إجازة عيد الفطر، عيد الأضحى، اليوم الوطني، وأيام الإجازات المرضية. ويحق للطرف الأول خلال فترة التجربة إنهاء هذا العقد دون إشعار مسبق، أو تعويض، أو مكافأة. كما يمكن تمديد فترة التجربة لمدة تسعين (90) يومًا إضافية بموافقة كتابية من كلا الطرفين، شريطة أن يتم التمديد خلال سريان الفترة التجريبية الأولى. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr style="font-weight: bold;background-color:rgb(252, 233, 204);">
            <td>Medical Care</td>
            <td align="right"> الحضور والالتزام: </td>
        </tr>
        <tr>
            <td>The First Party shall provide the Second Party with medical care in accordance with the provisions of the Cooperative Health Insurance Law and the Company’s annual medical insurance policy.</td>
            <td align="right"> يلتزم الطرف الأول بتوفير الرعاية الطبية للطرف الثاني وفقًا لأحكام نظام الضمان الصحي التعاوني، وبما يتوافق مع وثيقة التأمين الطبي السنوية الخاصة بالشركة. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr style="font-weight: bold;background-color:rgb(252, 233, 204);">
            <td>Attendance</td>
            <td align="right"> الحضور والالتزام </td>
        </tr>
        <tr>
            <td>The employee must work as per aggregator roaster and shifts.</td>
            <td align="right"> يجب على الموظف الالتزام بالجدول الزمني والشفتات وفقًا لنظام العمل المحدد من قبل المنصة المشغلة. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>Attendance will be calculated as per working days or online days valid from aggregator monthly report.</td>
            <td align="right"> سيتم احتساب الحضور بناءً على أيام العمل الفعلية أو الأيام المتصلة عبر المنصة، وفقًا للتقرير الشهري الصادر عن المشغل. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>The employee is required to work a minimum of 26 days per month and remain online for at least 10 hours daily, including lunch breaks to achieve the sales target.</td>
            <td align="right"> الحد الأدنى للعمل هو 26 يومًا شهريًا، مع ضرورة البقاء متصلاً لمدة لا تقل عن 10 ساعات يوميًا (بما في ذلك استراحة الغداء) لتحقيق الهدف البيعي المحدد. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>Working hours start from the site (Location) allotted or selected in the aggregator roster.</td>
            <td align="right"> تبدأ ساعات العمل من الموقع المحدد أو المختار في جدول التجميع الخاص بالمنصة. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>The employee must work on Thursdays, Fridays, and Saturdays, and coordinate any leaves from Sunday to Wednesday. During the last week of the month, only one day of leave is permitted.</td>
            <td align="right"> يجب على الموظف العمل أيام الخميس والجمعة والسبت، وأي إجازات يجب تنسيقها بين الأحد والأربعاء.   في الأسبوع الأخير من الشهر، يُسمح فقط بيوم إجازة واحد. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>Working Hours: The employee must be online to accept orders during either the lunch break (11:00 AM - 2:59 PM) or the dinner break (7:00 PM - 11:59 PM) for at least a total of 4 hours per day. A penalty of SAR 50 will be imposed for each canceled order by aggregator.</td>
            <td align="right"> ساعات العمل: يجب أن يكون الموظف متصلًا وقادرًا على استقبال الطلبات إما خلال فترة الغداء (من 11:00 صباحًا حتى 2:59 مساءً) أو خلال فترة العشاء (من 7:00 مساءً حتى 11:59 مساءً)، بما لا يقل عن 4 ساعات يوميًا. سيتم فرض غرامة قدرها 50 ريال سعودي على كل طلب يتم إلغاؤه من قبل المشغل. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr style="font-weight: bold;background-color:rgb(252, 233, 204);">
            <td>Target & Achievements</td>
            <td align="right"> الأهداف والإنجازات </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>The second party is obligated to deliver a minimum of 450 orders per month, at an average of 15 orders per day. This clause is considered a fundamental obligation for the second party.</td>
            <td align="right"> يلتزم الطرف الثاني بتوصيل ما لا يقل عن 450 طلبًا شهريًا، بمتوسط 15 طلبًا يوميًا. يُعد هذا الشرط التزامًا أساسيًا على الطرف الثاني. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>Commission and Bonus </td>
            <td align="right"> يتم احتساب العمولات والمكافآت وفقًا للملحق. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>Saudi Riyals 4 will be paid for each order below 401 orders monthly.</td>
            <td align="right"> سيتم صرف 4 ريال سعودي عن كل طلب في حال كان عدد الطلبات الشهري أقل من 401 طلب. </td>
        </tr>
        <tr>
            <td>Saudi Riyals 7 will be paid from 401 order onwards monthly.</td>
            <td align="right"> سيتم صرف 7 ريال سعودي عن كل طلب بدءًا من الطلب رقم 401 فما فوق شهريًا. </td>
        </tr>
        <tr>
            <td>Saudi Riyals 8 will be paid from 501 order onwards monthly.</td>
            <td align="right"> سيتم صرف 8 ريال سعودي عن كل طلب بدءًا من الطلب رقم 501 فما فوق شهريًا. </td>
        </tr>
        <tr>
            <td>Saudi Riyals 9 will be paid from 601 order onwards monthly.</td>
            <td align="right"> سيتم صرف 9 ريال سعودي عن كل طلب بدءًا من الطلب رقم 601 فما فوق شهريًا. </td>
        </tr>
        <tr>
            <td>Saudi Riyals 200 will be paid upon completing 600 order monthly bonus</td>
            <td align="right"> سيتم صرف 200 ريال سعودي كمكافأة شهرية عند إكمال 600 طلب شهريًا. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>The achievement of the monthly goal shall be reviewed on a weekly basis. If the failure to achieve the monthly goal is repeated three times, the contract shall be terminated based on the fourth clause regarding the lack of substantial commitment to the job.</td>
            <td align="right"> سيتم مراجعة تحقيق الهدف الشهري بشكل أسبوعي، وفي حال الفشل في تحقيقه لثلاث مرات متتالية، سيتم إنهاء العقد وفقًا للبند الرابع المتعلق بعدم الالتزام الجوهري بالعمل </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>Delivery Associate will have Target Relaxation for 1st 30 days from the Driving Licenses receiving date.</td>
            <td align="right"> يتم منح الموظف فترة استثناء من تحقيق الهدف لمدة 30 يومًا من تاريخ استلام رخصة القيادة. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>Employees are the only responsible for paying for any penalty occurred/imposed by the Aggregator on the company due to his negligence in work.</td>
            <td align="right"> المندوب مسؤولون بشكل كامل عن دفع أي غرامات تفرضها منصات المشغل على الشركة بسبب إهمالهم أو تقصيرهم في العمل. </td>
        </tr>
        <tr>
            <td>All amounts related to commissions, bonuses, percentages of the sales price, or similar components of the wage that are inherently subject to increase or decrease shall not be included in the remuneration used to calculate the end-of-service gratuity.</td>
            <td align="right"> جميع مبالغ العمولات أو المكافآت أو النسب المئوية من سعر المبيعات وأي عناصر مماثلة للأجر المدفوع للعامل والتي تكون بطبيعتها عرضة للزيادة أو النقصان لا يتم احتسابها ضمن الأجر الذي تسوى على أساسه مكافأة نهاية الخدمة. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr style="font-weight: bold;background-color:rgb(252, 233, 204);">
            <td>Refusal to Work</td>
            <td align="right"> رفض العمل </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>In case of refusal to work by the employee, HR will send 3 notifications by email and WhatsApp as per the Labor Law. After 3 Email notifications the employee does not resume the work, then is considered as the Employee wish to terminate the employment contract.</td>
            <td align="right"> في حالة رفض الموظف العمل، سترسل إدارة الموارد البشرية 3 إشعارات عبر البريد الإلكتروني وواتساب وفقًا لقانون العمل. إذا لم يستأنف الموظف العمل بعد 3 إشعارات بالبريد الإلكتروني، فسيعتبر ذلك رغبة من الموظف في إنهاء عقد العمل. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>Qiwa Agreement will be terminated with immediate effect.</td>
            <td align="right"> سيتم إنهاء اتفاقية "قوى" فورًا دون أي تأخير. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>Final Exit Visa will be issued in such a case without any further notification.</td>
            <td align="right"> في هذه الحالة، سيتم إصدار تأشيرة خروج نهائي دون أي إشعار إضافي. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>Employees must leave the company provided housing within 3 days of Final Exit Visa is issued or else legal action will be taken against the employee, or the employee will be charged with the expenses paid by the company for him.</td>
            <td align="right"> يجب على الموظف مغادرة السكن الذي توفره الشركة خلال 3 أيام من إصدار تأشيرة الخروج النهائي، وإلا سيتم اتخاذ إجراءات قانونية ضده أو تحميله تكاليف السكن التي تكبدتها الشركة. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr style="font-weight: bold;background-color:rgb(252, 233, 204);">
            <td>Cellular Usage Terms;</td>
            <td align="right"> شروط استخدام الهاتف المحمول; </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>The company will provide a sim card with internet data and calling minutes to achieve the monthly sales target.</td>
            <td align="right"> ستوفر الشركة بطاقة تحتوي على بيانات إنترنت ودقائق مكالمات لتحقيق الهدف الشهري للمبيعات. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>Any personal usage will be charged back to the employee directly.</td>
            <td align="right"> أي استخدام شخصي سيتم تحميل تكلفته مباشرة على الموظف. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>Any access usage will be charged back to the employee directly.</td>
            <td align="right"> أي استهلاك زائد للبيانات أو المكالمات سيتم تحميل تكلفته على الموظف مباشرة. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>If the employee resigns or terminates the employment contract within 24 months, then he is responsible for paying the cellular contract termination penalty from the operator.</td>
            <td align="right"> في حال استقال الموظف أو أنهى عقد العمل قبل مرور 24 شهرًا، فإنه يتحمل مسؤولية دفع غرامة إنهاء عقد الهاتف المحمول التي يحددها مزود الخدمة. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>In case of provided data is consumed for personal use, then the employee must pay for the required internet data to perform the duty.</td>
            <td align="right"> في حالة استخدام البيانات المخصصة لأغراض شخصية، يجب على الموظف تحمل تكلفة البيانات الإضافية المطلوبة لأداء مهامه الوظيفية. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr style="font-weight: bold;background-color:rgb(252, 233, 204);">
            <td>Vehicle Usage </td>
            <td align="right"> استخدام المركبة </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>Employees will be responsible for the Vehicle (Car/Motorcycle) damage not covered by insurance agency due to their negligence while driving.</td>
            <td align="right"> يكون الموظف مسؤولًا عن أي ضرر يلحق بالمركبة (السيارة/الدراجة النارية) غير المغطى من قبل شركة التأمين بسبب إهماله أثناء القيادة. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>Surrender of Vehicle is acceptable after damage inspection from Rentel Company only, Rentel Company is authorized to remove the vehicle from Absher.</td>
            <td align="right"> تسليم المركبة مقبول فقط بعد فحص الأضرار من شركة الإيجار، وشركة الإيجار مخولة بإزالة المركبة من نظام أبشر. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>If delivery associate is found misusing the company vehicles in any way and proved in such case termination and penalty both are applicable.</td>
            <td align="right"> في حال ثبوت إساءة استخدام مندوب التوصيل لمركبات الشركة بأي شكل من الأشكال، سيتم تطبيق عقوبات صارمة قد تشمل الفصل والغرامات المالية. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr style="font-weight: bold;background-color:rgb(252, 233, 204);">
            <td>Driving License:</td>
            <td align="right"> رخصة القيادة: </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>The second party is obligated to complete the driving tests, pass them, and obtain a driving license to be able to commence work.</td>
            <td align="right"> يلتزم الطرف الثاني بإجراءات اختبارات القيادة واجتيازها والحصول على رخصة القيادة للتمكن من مباشرة العمل. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>The first party has the right to terminate this contract if the second party is unable to pass and obtain the drivers license test.</td>
            <td align="right"> يحق للطرف الأول إنهاء هذا العقد إذا لم يتمكن الطرف الثاني من اجتياز اختبار القيادة والحصول على الرخصة. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr style="font-weight: bold;background-color:rgb(252, 233, 204);">
            <td>Traffic Violation:</td>
            <td align="right"> مخالفة المرورية: </td>
        </tr>
        <tr>
            <td>In the event of traffic violations incurred by the second party that have not been paid or the second party refuses to pay for any reason, and these violations prevent the first party from completing the residency renewal procedures for the second party, the first party has the legitimate right to pay the traffic violation on behalf of the second party and deduct it from the monthly salary.</td>
            <td align="right"> في حال وجود مخالفات مرورية على الطرف الثاني ولم يتم سدادها أو امتنع عن سدادها لأي سبب، وكانت هذه المخالفات عائقاً أمام استكمال الطرف الأول لإجراءات تجديد الإقامة للطرف الثاني، فإنه يحق للطرف الأول، كسبب مشروع، دفع المخالفة المرورية للطرف الثاني وخصمها من الراتب الشهري. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr style="font-weight: bold;background-color:rgb(252, 233, 204);">
            <td>Accident:</td>
            <td align="right"> الحوادث: </td>
        </tr>
        <tr>
            <td>Employees must notify the Team Leader in case of accident happens.</td>
            <td align="right"> يجب على الموظف إبلاغ قائد الفريق فور وقوع أي حادث. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>Accident to be report to Najam and proper case needs to be filed and report to be obtain, in case the employee leaves or runs away from the accident spot, Hit & Run case may be filed by the front part.</td>
            <td align="right"> يجب الإبلاغ عن الحادث لدى "نجم" وفتح ملف للحالة والحصول على تقرير رسمي. <br>
في حال ترك الموظف موقع الحادث أو هرب، قد يتم تسجيل قضية "هروب بعد الحادث" ضده من قبل الجهة المتضررة. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>Employees will be solely responsible for paying any penalty imposed by the insurance company in such a case.</td>
            <td align="right"> يتحمل الموظف وحده دفع أي غرامات تفرضها شركة التأمين عليه في مثل هذه الحالات. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>In the event of traffic accidents registered against the second party that result in the suspension of the second party services, the first party has the right to suspend the second party from work and terminate this contract.</td>
            <td align="right"> في حال وقوع حوادث مرورية مسجلة على الطرف الثاني وتسببت في إيقاف خدمات الطرف الثاني، يحق للطرف الأول إيقاف الطرف الثاني عن العمل وإنهاء هذا العقد. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr style="font-weight: bold;background-color:rgb(252, 233, 204);">
            <td>Termination:</td>
            <td align="right"> إنهاء العقد: </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>(A) <br>This contract shall expire at the end of its term, or by agreement between the parties to terminate it, provided that the second party agrees in writing.</td>
            <td align="right"> ( أ ) <br> ينتهي هذا العقد بانتهاء مدته، أو باتفاق الطرفين على إنهائه، بشرط أن يوافق الطرف الثاني على ذلك كتابةً. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>(B) <br>The First Party shall have the right to terminate the contract without remuneration, notice or compensation to the Second Party, provided that the Second Party can express the reasons for opposing the termination, in accordance with the cases mentioned in Article (80) of Labor Law.</td>
            <td align="right"> ( ب ) <br> يحق للطرف الأول إنهاء العقد دون مكافأة أو إشعار أو تعويض للطرف الثاني، على أن يكون للطرف الثاني الحق في إبداء أسباب اعتراضه على هذا الإنهاء، وذلك وفقًا للحالات المنصوص عليها في المادة (80) من نظام العمل. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>(C) <br>The Second Party shall have the right to leave work and terminate the contract by notifying the First Party, while retaining the right to receive all issues, in accordance with the cases mentioned in Article (81) of the Labor Law.</td>
            <td align="right"> ( ج )<br>يحق للطرف الثاني ترك العمل وإنهاء العقد مع إشعار الطرف الأول، مع احتفاظه بحقوقه كاملة، وذلك وفقًا للحالات المنصوص عليها في المادة (81) من نظام العمل. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>(D) <br>If the contract is terminated by one of the parties before the expiry of its term without a legitimate reason, the other party shall be entitled to compensation in return for such termination equal to two months’ Basic salaries.</td>
            <td align="right"> ( د ) <br> في حال قام أحد الطرفين بإنهاء العقد قبل انتهاء مدته دون سبب مشروع، يحق للطرف الآخر الحصول على تعويض عن هذا الإنهاء يعادل أجر شهرين من الراتب الأساسي. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>If the contract continues, it is renewed for a similar period unless one of the parties notifies that they do not wish to renew the contract at least (30) days before the contract expiration date.</td>
            <td align="right"> في حال استمرار العقد، فإنه يتم تجديده لفترة مماثلة ما لم يشعر أحد الطرفين بأنه لا يرغب في تجديد العقد قبل (30) يومًا من تاريخ انتهاء العقد. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>This contract shall be terminated in any of the cases stipulated in accordance with Article (74) of Labor Law.</td>
            <td align="right"> يُعتبر هذا العقد منتهيًا في أي من الحالات المنصوص عليها وفقًا للمادة (74) من قانون العمل. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>In the event of the worker resignation, work shall be carried out in accordance with Article (85) of Labor Law.</td>
            <td align="right"> في حال استقالة العامل، يتم العمل وفق المادة (85) من نظام العمل. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>If the Qiwa agreement is not accepted by the employee, then the company has the right to hold the salary.</td>
            <td align="right"> إذا لم يقبل الموظف عقد قوى، فإن للشركة الحق في حجب الراتب. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr style="font-weight: bold;background-color:rgb(252, 233, 204);">
            <td>Understanding Terms of Contract</td>
            <td align="right"> فهم شروط العقد </td>
        </tr>
        <tr>
            <td>( A ) <br>The Second Party acknowledges that it has carefully reviewed this contract and the applicable regulations of the First Party and that it has fully understood all the terms and conditions covered therein and therefore agrees to comply throughout the term of this contract with the policies of the First Party as well as the terms and conditions of this contract and the rules and regulations in force in The Kingdom of Saudi Arabia.</td>
            <td align="right"> ( أ ) <br> يقر الطرف الثاني بأنه قد قام بمراجعة هذا العقد بعناية، واطلع على اللوائح المعمول بها لدى الطرف الأول، وفهم جميع الشروط والأحكام الواردة فيه فهمًا تامًا، وبالتالي يوافق على الالتزام بسياسات الطرف الأول وكافة شروط وأحكام هذا العقد، بالإضافة إلى القوانين والأنظمة المعمول بها في المملكة العربية السعودية طوال مدة سريان هذا العقد. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>( B ) <br>This contract shall only be amended by a written agreement signed by both parties.</td>
            <td align="right"> ( ب ) <br> لا يجوز تعديل هذا العقد إلا بموجب اتفاق كتابي موقع من كلا الطرفين. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr style="font-weight: bold;background-color:rgb(252, 233, 204);">
            <td>Additional Terms:</td>
            <td align="right"> شروط إضافية: </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>The employer has the right to transfer the worker’s workplace from the original location to another location that requires a change in the workers’ residence, as dictated by the needs of the work.</td>
            <td align="right"> يحق لصاحب العمل نقل مكان عمل العامل من المكان الأصلي إلى مكان آخر يقتضي تغيير مقر إقاماته حسب مقتضيات العمل. </td>
        </tr>
        <tr>
            <td></td>
            <td align="right">  </td>
        </tr>
        <tr>
            <td>The employment contract considers the worker as single, and the worker is not permitted to bring their family.</td>
            <td align="right"> عقد العمل يعتبر أعزب وغير مصرح للعامل باستقدام عائلته. </td>
        </tr>
    </table>
    <table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;">
        <tr>
            <td></td>
        </tr>
    </table>
    <table border="1" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;">
        <tr>
            <td align="center"><h3> التوقيع </h3></td>
        </tr>
        <tr>
            <td align="center"><h3> Signature </h3></td>
        </tr>
    </table>
    <table border="1" cellspacing="0" cellpadding="3" style="width: 100%;font-size: 10px;">
        <tr style="font-weight: bold;background-color:rgb(252, 233, 204);">
            <td style="width:25%;">First Party</td>
            <td style="width:50%;"></td>
            <td style="width:25%;" align="left"> الطرف الأول </td>
        </tr>
        <tr>
            <td style="width:25%;">Name</td>
            <td style="width:50%;"></td>
            <td style="width:25%;" align="left"> الإسم </td>
        </tr>
        <tr>
            <td style="width:25%;">Signature</td>
            <td style="width:50%;" rowspan="3"></td>
            <td style="width:25%;" align="left"> التوقيع </td>
        </tr>
        <tr>
            <td style="width:25%;"></td>
            <td style="width:25%;" align="left"></td>
        </tr>
        <tr>
            <td style="width:25%;"></td>
            <td style="width:25%;" align="left"></td>
        </tr>
    </table>
    <table border="1" cellspacing="0" cellpadding="3" style="width: 100%;font-size: 10px;">
        <tr style="font-weight: bold;background-color:rgb(252, 233, 204);">
            <td style="width:25%;">Second Party</td>
            <td style="width:50%;"></td>
            <td style="width:25%;" align="left"> الطرف الأول </td>
        </tr>
        <tr>
            <td style="width:25%;">Name</td>
            <td style="width:50%;"></td>
            <td style="width:25%;" align="left"> الإسم </td>
        </tr>
        <tr>
            <td style="width:25%;">Signature</td>
            <td style="width:50%;" rowspan="3"></td>
            <td style="width:25%;" align="left"> التوقيع </td>
        </tr>
        <tr>
            <td style="width:25%;"></td>
            <td style="width:25%;" align="left"></td>
        </tr>
        <tr>
            <td style="width:25%;"></td>
            <td style="width:25%;" align="left"></td>
        </tr>
    </table>
</body>

</html>
