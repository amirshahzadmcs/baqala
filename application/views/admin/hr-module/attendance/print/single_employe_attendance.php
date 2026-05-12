<?php
$total_present = 0;
$total_absent = 0;

if (!empty($attenance_list)) {
    foreach ($attenance_list as $value) {
        if (isset($value['attend_type'])) {
            if ($value['attend_type'] == 'P') {
                $total_present++;
            } elseif ($value['attend_type'] == 'A') {
                $total_absent++;
            }
        }
    }
}
?>
<?php
	$attendance_types = [
		'A'   => 'Absent',
		'L'   => 'Leave',
		'P'   => 'Present',
		'AC'  => 'Accident',
		'AL'  => 'Annual Leave',
		'BT'  => 'Business Trip',
		'CL'  => 'Casual Leave',
		'COL' => 'Compassionate Leave',
		'HI'  => 'Health Issue',
		'ID'  => 'ID Issue',
		'IQ'  => 'Iqama Issue',
		'MAR' => 'Marriage Leave',
		'MI'  => 'Mobile Issue',
		'ML'  => 'Maternity Leave',
		'PL'  => 'Paternity Leave',
		'SI'  => 'Sponsorship Issue',
		'SL'  => 'Sick Leave',
		'UL'  => 'Unpaid Leave',
		'WL'  => 'Widow Leave',
		'WO'  => 'Week Off'
	];
?>
<?php
// Initialize all types with zero
$type_counts = [
    'WO' => 0, // Week Off
    'A'  => 0, // Absent
    'ID' => 0, // ID Issue
    'HI' => 0, // Health Issue
    'MI' => 0, // Mobile Issue
    'SI' => 0, // Sponsorship Issue
    'IQ' => 0,  // Iqama Issue
];

if (!empty($attenance_list)) {
    foreach ($attenance_list as $value) {
        $type = $value['attend_type'] ?? '';
        if (isset($type_counts[$type])) {
            $type_counts[$type]++; // Increment corresponding type
        }
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Maha Al Fala Trading Company - Attendance Sheet</title>
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
			<td valign="top" style="width:25%;text-align: left;font-size: 16px;line-height:15px;">
				<strong>ATTENDANCE SHEET</strong><br><strong> نموذج سجل الحضور </strong>
			</td>
			<td valign="center" style="width:75%;">
				<table border="0" cellspacing="0" cellpadding="0" style="width: 100%;font-size: 11px;">
					<tr>
						<td style="border-bottom:1px solid #ddd;"></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td align="right" colspan="2" style="font-size: 10px;">Month of: <?= date('F Y', strtotime($month_of)); ?></td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;">
		<tr>
			<td colspan="4" valign="center"></td>
		</tr>
		<tr>
			<td colspan="4" valign="center" style="text-align: left;border-bottom:1px solid #000;text-transform: uppercase;"><strong>EMPLOYEE NO & NAME / رقم الموظف واسم الموظف :</strong> <?= ($emp_detail->emp_no !== '') ? $emp_detail->emp_no : 'NA';?> - <?= $emp_detail->full_name;?></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid #ddd;width:25%;">Iqama No. / رقم الهوية الإقامة <br><strong><?= (trim($emp_detail->iqama_no) !== '') ? trim($emp_detail->iqama_no) : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:25%;">Joined Date / تاريخ الانضمام <br><strong><?= ($emp_detail->work_joining_date) ? date('d F Y', strtotime($emp_detail->work_joining_date)) : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:25%;">Designation / المسمى الوظيفي <br><strong><?= ($emp_detail->designation_name !== '') ? $emp_detail->designation_name : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:25%;">Department / القسم <br><strong><?= (trim($emp_detail->department_name) !== '') ? trim($emp_detail->department_name) : 'NA';?></strong></td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;">
		<tr>
			<td colspan="3" valign="center" style="text-align: left;border-bottom:1px solid #000;"><strong>PRESENT / حاضر </strong></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid #ddd;width:33%;">Work Days / أيام العمل<br><strong><?= $total_present; ?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:34%;">Week Off / عطلة أسبوعية<br><strong>00</strong></td>
			<td style="border-bottom:1px solid #ddd;width:33%;">Paid Leave / إجازة مدفوعة الأجر<br><strong>00</strong></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid #ddd;width:33%;">Medical Leave / إجازة مرضية<br><strong>00</strong></td>
			<td style="border-bottom:1px solid #ddd;width:34%;">Accident Leave / إجازة حادث<br><strong>00</strong></td>
			<td style="border-bottom:1px solid #ddd;width:33%;">Annual Leave / إجازة سنوية<br><strong>00</strong></td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;">
		
		<tr>
			<td colspan="6" valign="center" style="text-align: left;border-bottom:1px solid #000;"><strong>ABSENT / غائب</strong></td>
		</tr>
		<!-- 
		<tr>
			<td style="border-bottom:1px solid #ddd;width:20%;">No Show / لم يحضر<br><strong></strong></td>
			<td style="border-bottom:1px solid #ddd;width:34%;">Weekend No Show / لم يحضر في عطلة نهاية الأسبوع<br><strong>00</strong></td>
			<td style="border-bottom:1px solid #ddd;width:23%;">ID Suspend / تعليق الهوية<br><strong>00</strong></td>
			<td style="border-bottom:1px solid #ddd;width:23%;">Unpaid Leave / إجازة بدون أجر<br><strong>00</strong></td>
		</tr> -->
		<tr>
		<?php 
		$printed = false; // track if any TD printed
		?>

		<?php if ($type_counts['WO'] > 0): $printed = true; ?>
			<td style="border-bottom:1px solid #000;width:15%;">Week Off<br><strong><?= $type_counts['WO']; ?></strong></td>
		<?php endif; ?>

		<?php if ($type_counts['A'] > 0): $printed = true; ?>
			<td style="border-bottom:1px solid #000;width:15%;">Absent<br><strong><?= $type_counts['A']; ?></strong></td>
		<?php endif; ?>

		<?php if ($type_counts['ID'] > 0): $printed = true; ?>
			<td style="border-bottom:1px solid #000;width:16%;">ID Issue<br><strong><?= $type_counts['ID']; ?></strong></td>
		<?php endif; ?>

		<?php if ($type_counts['IQ'] > 0): $printed = true; ?>
			<td style="border-bottom:1px solid #000;width:16%;">Iqama Issue<br><strong><?= $type_counts['IQ']; ?></strong></td>
		<?php endif; ?>

		<?php if ($type_counts['HI'] > 0): $printed = true; ?>
			<td style="border-bottom:1px solid #000;width:17%;">Health Issue<br><strong><?= $type_counts['HI']; ?></strong></td>
		<?php endif; ?>

		<?php if ($type_counts['MI'] > 0): $printed = true; ?>
			<td style="border-bottom:1px solid #000;width:17%;">Mobile Issue<br><strong><?= $type_counts['MI']; ?></strong></td>
		<?php endif; ?>

		<?php if ($type_counts['SI'] > 0): $printed = true; ?>
			<td style="border-bottom:1px solid #000;width:20%;">Sponsorship Issue<br><strong><?= $type_counts['SI']; ?></strong></td>
		<?php endif; ?>

		<?php if (!$printed): ?>
			<td style="border-bottom:1px solid #000;width:15%;"></td>
		<?php endif; ?>
	</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="3" style="width: 100%;font-size: 9px;">
		<tr style="background-color:#f1f1f1;">
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:7%;line-height:10px;">S.No./فرز</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:10%;line-height:10px;">Date / التاريخ</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:10%;line-height:10px;">Day / اليوم</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:12%;line-height:10px;">Attendance / الحالة</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:11%;line-height:10px;">Delivery / التسليم</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:17%;line-height:10px;">Working Hours / ساعات العمل</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:18%;line-height:10px;">Remarks / الملاحظات</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:15%;line-height:10px;">Source / المصدر</td>
		</tr>
		<?php 
		if(count($attenance_list) > 0){
			$count = 1;
			foreach ($attenance_list as $key => $value) { 

				// Determine day
				$day_name = (trim($value['date_of_attend']) !== '') ? date('l', strtotime($value['date_of_attend'])) : '';

				// Highlight Thu / Fri / Sat
				$lightGrayDays = ['Thursday','Friday','Saturday'];
				$row_bg = in_array($day_name, $lightGrayDays) ? 'background-color:#dddddd;' : '';

				// Red color if Absent
				$row_color = ($value['attend_type'] == 'A') ? 'color:red;' : '';

		?>
		<tr style="<?= $row_bg . $row_color; ?>">
			<td align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= $count++;?></td>

			<td align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;">
				<?= (trim($value['date_of_attend']) !== '') ? date('d-M-Y', strtotime($value['date_of_attend'])) : 'NA';?>
			</td>

			<td align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;">
				<?= $day_name ?: 'NA'; ?>
			</td>

			<td align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= (trim($value['attend_type']) !== '') ? trim($value['attend_type']) : 'NA';?></td>

			<td align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= (trim($value['total_deliveries']) !== '') ? trim($value['total_deliveries']) : 'NA';?></td>
			<td 
				align="center" 
				style="
					border-bottom:1px solid #000;
					border-right:1px solid #000;
					<?= ($value['working_hours'] !== '' && $value['working_hours'] !== null && $value['working_hours'] < 9)
						? 'color:red;font-weight:bold;'
						: ''; ?>
				"
			>
				<?= ($value['working_hours'] !== '' && $value['working_hours'] !== null)
					? decimalToHours($value['working_hours'])
					: '00:00'; ?>
			</td>
			<td align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= isset($attendance_types[$value['attend_type']]) ? $attendance_types[$value['attend_type']] : 'NA'; ?></td>

			<td align="center" style="border-bottom:1px solid #000;"><?= (trim($value['remarks']) !== '') ? trim($value['remarks']) : 'NA';?></td>
		</tr>
		<?php }} else { ?>
			<td colspan="6" align="center" style="border-bottom:1px solid #ddd;">No data found</td>
		<?php } ?>
	</table>

    <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
		<tr><td colspan="6" valign="center"></td></tr>
		<tr>
			<td colspan="6" valign="center" style="color: #999;"><small>*This is a system-generated attendance sheet and does not require a signature.</small></td>
		</tr>
	</table>
</body>

</html>
