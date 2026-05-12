<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Maha Al Fala Trading Company - Payslip</title>
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
			<td colspan="2" valign="center" height="50px" style="text-align: right;font-size: 24px;line-height:0px;"></td>
		</tr>
		<tr>
			<td valign="top" style="width:30%;text-align: left;font-size: 20px;line-height:15px;">
				<strong>PAYSLIP</strong> <?php echo strtoupper(date('M Y', strtotime($payslip_detail['payroll_month'])));?><br><strong>بيان راتب</strong>
			</td>
			<td valign="center" style="width:70%;">
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
			<td colspan="4" valign="center"></td>
		</tr>
		<tr>
			<td colspan="4" valign="center" style="text-align: left;border-bottom:1px solid #000;text-transform: uppercase;"><strong>EMPLOYEE NO & NAME / رقم الموظف واسم الموظف :</strong> <?= ($payslip_detail['emp_id'] !== '') ? $payslip_detail['emp_id'] : 'NA';?> - <?= $payslip_detail['employee_name'];?></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid #ddd;width:20%;">Iqama No. / رقم الهوية الإقامة <br><strong><?= (trim($payslip_detail['iqama_no']) !== '') ? trim($payslip_detail['iqama_no']) : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:18%;">GOSI / التأمينات الاجتماعية <br><strong><?= (trim($payslip_detail['gosi_id'])) ? trim($payslip_detail['gosi_id']) : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:20%;">QIWA Contract / رقم عقد قوى <br><strong><?= (trim($payslip_detail['qiwa_contract_no'])) ? $payslip_detail['qiwa_contract_no'] : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:19%;">Joined Date / تاريخ الانضمام <br><strong><?= ($payslip_detail['joining_date']) ? date('d F Y', strtotime($payslip_detail['joining_date'])) : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:23%;">Qiwa Expiry Date / تاريخ انتهاء العقد <br><strong><?= ($payslip_detail['qiwa_contract_end_date'] && $payslip_detail['qiwa_contract_end_date'] !== '0000-00-00' && $payslip_detail['qiwa_contract_end_date'] !== '1970-01-01' && $payslip_detail['qiwa_contract_end_date'] !== null) ? date('d F Y', strtotime($payslip_detail['qiwa_contract_end_date'])) : 'NA';?></strong></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid #ddd;width:20%;">Designation / المسمى الوظيفي <br><strong><?= ($payslip_detail['designation'] !== '') ? $payslip_detail['designation'] : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:18%;">Department / القسم <br><strong><?= (trim($payslip_detail['department']) !== '') ? trim($payslip_detail['department']) : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:20%;">Payment Mode / طريقة الدفع <br><strong><?= (trim($payslip_detail['payment_mode'])) ? trim($payslip_detail['payment_mode']) : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:42%;">Bank/IBAN No / البنك / رقم الأيبان <br><strong><?= ($payslip_detail['bank_name']) ? trim($payslip_detail['bank_name']) .' / '. trim($payslip_detail['bank_iban_no']) : 'NA';?></strong></td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;">
		<tr>
			<td colspan="4" valign="center" style="text-align: left;border-bottom:1px solid #000;"><strong>AGGREGATOR TARGET DETAILS / تفاصيل أهداف المنصة </strong></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid #ddd;width:36%;">Aggregator Name & ID No / اسم المنصة ورقم الحساب <br><strong><?= ($payslip_detail['aggregator_name'] !== '') ? $payslip_detail['aggregator_name'] .' - '. $payslip_detail['aggregator_id'] : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:20%;">Monthly Target / الهدف الشهري <br><strong><?= ($payslip_detail['monthly_target'] !== '') ? $payslip_detail['monthly_target'] : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:22%;">Target Achieve / الهدف المحقق <br><strong><?= (trim($payslip_detail['target_achieve']) !== '') ? trim($payslip_detail['target_achieve']) : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:22%;">Progress / مستوى التقدم <br><strong><?= (trim($payslip_detail['progress'] !== '')) ? $payslip_detail['progress'] : (($payslip_detail['monthly_target'] !== '' && trim($payslip_detail['target_achieve'])) ? ($payslip_detail['monthly_target'] - trim($payslip_detail['target_achieve'])) : '0');?></strong></td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;">
		<tr>
			<td colspan="4" valign="center" style="text-align: left;border-bottom:1px solid #000;"><strong>ATTENDANCE DETAILS / تفاصيل الراتب </strong></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid #ddd;">Actual Payable Days / أيام الدفع الفعلية <br><strong><?= ($payslip_detail['actual_payable_days'] !== '') ? $payslip_detail['actual_payable_days'] : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;">Total Working Days / إجمالي أيام العمل <br><strong><?= (trim($payslip_detail['total_working_days']) !== '') ? trim($payslip_detail['total_working_days']) : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;">Loss of Pay Days / أيام خصم الراتب <br><strong><?= (trim($payslip_detail['loss_of_pay_days'])) ? trim($payslip_detail['loss_of_pay_days']) : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;">Payable Date / تاريخ الاستحقاق <br><strong><?= ($payslip_detail['payable_date']) ? date('d F Y', strtotime($payslip_detail['payable_date'])) : 'NA';?></strong></td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;">
		<tr>
			<td colspan="5" valign="center" style="text-align: left;border-bottom:1px solid #000;"><strong>LOAN & ADVANCES /  القروض والسلف </strong></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid #ddd;width:23%;">Opening Balance / الرصيد الافتتاحي <br><strong><?= ($payslip_detail['opening_balance'] !== '') ? $payslip_detail['opening_balance'] : '0.00';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:15%;">New Loan / قرض جديد <br><strong><?= (trim($payslip_detail['new_loan']) !== '') ? trim($payslip_detail['new_loan']) : '0.00';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:15%;">Deduction / الخصم <br><strong><?= (trim($payslip_detail['deduction'])) ? trim($payslip_detail['deduction']) : '0.00';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:22%;">Balance Due / الرصيد المستحق <br><strong><?= ($payslip_detail['balance_due']) ? trim($payslip_detail['balance_due']) : '0.00';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:25%;">Carry Forward Salary / ترحيل الراتب <br><strong><?= (trim($payslip_detail['carry_forward_salary'])) ? trim($payslip_detail['carry_forward_salary']) : '0.00';?></strong></td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;">
		<tr>
			<td style="border-right: 1px solid #ddd;border-bottom: 1px solid #ddd;">
				<table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;">
					<tr>
						<td colspan="2" style="font-size: 11px;"><strong>1. EARNINGS / الأجور </strong></td>
					</tr>
					<tr>
						<td style="line-height:7px;width: 80%;">Basic Salary / الراتب الأساسي </td>
						<td style="line-height:7px;width: 20%;text-align: right;"><?= (trim($payslip_detail['basic_salary'])) ? trim($payslip_detail['basic_salary']) : '0.00';?></td>
					</tr>
					<tr>
						<td style="line-height:7px;width: 80%;">Food Allowance / بدل الطعام</td>
						<td style="line-height:7px;width: 20%;text-align: right;"><?= (trim($payslip_detail['food'])) ? trim($payslip_detail['food']) : '0.00';?></td>
					</tr>
					<tr>
						<td style="line-height:7px;width: 80%;">Housing Allowance / بدل السكن </td>
						<td style="line-height:7px;width: 20%;text-align: right;"><?= (trim($payslip_detail['housing'])) ? trim($payslip_detail['housing']) : '0.00';?></td>
					</tr>
					<tr>
						<td style="line-height:7px;width: 80%;">Transportation Allowance / يدل النقل </td>
						<td style="line-height:7px;width: 20%;text-align: right;"><?= (trim($payslip_detail['transportation'])) ? trim($payslip_detail['transportation']) : '0.00';?></td>
					</tr>
					<tr>
						<td style="line-height:7px;width: 80%;">Other Allowances / بدلات أخرى </td>
						<td style="line-height:7px;width: 20%;text-align: right;"><?= (trim($payslip_detail['other'])) ? trim($payslip_detail['other']) : '0.00';?></td>
					</tr>
				</table>
			</td>
			<td style="border-bottom: 1px solid #ddd;">
				<table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;">
					<tr>
						<td colspan="2" style="font-size: 11px;"><strong>2. CONTRIBUTIONS / الاشتراكات </strong></td>
					</tr>
					<tr>
						<td style="line-height:7px;width: 80%;">GOSI Employee / تأمينات اجتماعية </td>
						<td style="line-height:7px;width: 20%;text-align: right;"><?= (trim($payslip_detail['gosi_employee'])) ? trim($payslip_detail['gosi_employee']) : '0.00';?></td>
					</tr>
					<tr>
						<td style="line-height:7px;width: 80%;"></td>
						<td style="line-height:7px;width: 20%;text-align: right;"></td>
					</tr>
					<tr>
						<td style="line-height:7px;width: 80%;"></td>
						<td style="line-height:7px;width: 20%;text-align: right;"></td>
					</tr>
					<tr>
						<td style="line-height:7px;width: 80%;"></td>
						<td style="line-height:7px;width: 20%;text-align: right;"></td>
					</tr>
					<tr>
						<td style="line-height:7px;width: 80%;"><strong>Total Contribution / جمالي الاشتراكات (B)</strong></td>
						<td style="line-height:7px;width: 20%;text-align: right;"><strong><?= (trim($payslip_detail['total_contribution'])) ? trim($payslip_detail['total_contribution']) : '0.00';?></strong></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 11px;">
		<tr>
			<td style="border-right: 1px solid #ddd;height:350px;">
				<table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;">
					<tr>
						<td colspan="2" style="font-size: 11px;"><strong>COMMISSION & INCENTIVE / العمولات والحوافز </strong></td>
					</tr>
					<?php if(trim($payslip_detail['adjustment_commission']) !== '' && $payslip_detail['adjustment_commission'] > 0) { ?>
					<tr>
						<td style="line-height:7px;width: 80%;">Adjustments / التعديلات </td>
						<td style="line-height:7px;width: 20%;text-align: right;"><?= (trim($payslip_detail['adjustment_commission'])) ? trim($payslip_detail['adjustment_commission']) : '0.00';?></td>
					</tr>
					<?php } ?>
					<?php if(trim($payslip_detail['hunger_adjustment']) !== '' && $payslip_detail['hunger_adjustment'] > 0) { ?>
					<tr>
						<td style="line-height:7px;width: 80%;">Hunger Adjustment / تعديل الجوع</td>
						<td style="line-height:7px;width: 20%;text-align: right;"><?= (trim($payslip_detail['hunger_adjustment'])) ? trim($payslip_detail['hunger_adjustment']) : '0.00';?></td>
					</tr>
					<?php } ?>
					<?php if(trim($payslip_detail['online_hours_incentive']) !== '' && $payslip_detail['online_hours_incentive'] > 0) { ?>
					<tr>
						<td style="line-height:7px;width: 80%;">Online Hours Incentive / الحافز بساعات العمل الأونلاين </td>
						<td style="line-height:7px;width: 20%;text-align: right;"><?= (trim($payslip_detail['online_hours_incentive'])) ? trim($payslip_detail['online_hours_incentive']) : '0.00';?></td>
					</tr>
					<?php } ?>
					<?php if(trim($payslip_detail['reimbursements']) !== '' && $payslip_detail['reimbursements'] > 0) { ?>
					<tr>
						<td style="line-height:7px;width: 80%;">Reimbursements / التعويضات </td>
						<td style="line-height:7px;width: 20%;text-align: right;"><?= (trim($payslip_detail['reimbursements'])) ? trim($payslip_detail['reimbursements']) : '0.00';?></td>
					</tr>
					<?php } ?>
					<?php if(trim($payslip_detail['target_based_commission']) !== '' && $payslip_detail['target_based_commission'] > 0) { ?>
					<tr>
						<td style="line-height:7px;width: 80%;">Target Based Commission / العمولة بناء على الهدف </td>
						<td style="line-height:7px;width: 20%;text-align: right;"><?= (trim($payslip_detail['target_based_commission'])) ? trim($payslip_detail['target_based_commission']) : '0.00';?></td>
					</tr>
					<?php } ?>
					<?php if(trim($payslip_detail['tips']) !== '' && $payslip_detail['tips'] > 0) { ?>
					<tr>
						<td style="line-height:7px;width: 80%;">Tips / إكرامية </td>
						<td style="line-height:7px;width: 20%;text-align: right;"><?= (trim($payslip_detail['tips'])) ? trim($payslip_detail['tips']) : '0.00';?></td>
					</tr>
					<?php } ?>
				</table>
			</td>
			<td>
				<table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;">
					<tr>
						<td colspan="2" style="font-size: 11px;"><strong>DEDUCTIONS / والخصومات </strong></td>
					</tr>
					<?php if(trim($payslip_detail['accident_claim']) !== '' && $payslip_detail['accident_claim'] > 0) { ?>
					<tr>
						<td style="line-height:7px;width: 80%;">Accident Claim Fee / رسوم مطالبات الحوادث </td>
						<td style="line-height:7px;width: 20%;text-align: right;">
							<?= (trim($payslip_detail['accident_claim'])) ? trim($payslip_detail['accident_claim']) : '0.00'; ?>
						</td>
					</tr>
					<?php } ?>
					<?php if(trim($payslip_detail['acceptance_contact_penalty']) !== '' && $payslip_detail['acceptance_contact_penalty'] > 0) { ?>
					<tr>
						<td style="line-height:7px;width: 80%;">Acceptance Penalties / عقوبات القبول </td>
						<td style="line-height:7px;width: 20%;text-align: right;">
							<?= (trim($payslip_detail['acceptance_contact_penalty'])) ? trim($payslip_detail['acceptance_contact_penalty']) : '0.00'; ?>
						</td>
					</tr>
					<?php } ?>
					<?php if(trim($payslip_detail['adjustments']) !== '' && $payslip_detail['adjustments'] > 0) { ?>
					<tr>
						<td style="line-height:7px;width: 80%;">Adjustments / التعديلات </td>
						<td style="line-height:7px;width: 20%;text-align: right;">
							<?= (trim($payslip_detail['adjustments'])) ? trim($payslip_detail['adjustments']) : '0.00'; ?>
						</td>
					</tr>
					<?php } ?>
					<?php if(trim($payslip_detail['aggregator_penalty']) !== '' && $payslip_detail['aggregator_penalty'] > 0) { ?>
					<tr>
						<td style="line-height:7px;width: 80%;">Aggregator Penalty / غرامات المنصة </td>
						<td style="line-height:7px;width: 20%;text-align: right;">
							<?= (trim($payslip_detail['aggregator_penalty'])) ? trim($payslip_detail['aggregator_penalty']) : '0.00'; ?>
						</td>
					</tr>
					<?php } ?>
					<?php if(trim($payslip_detail['basic_paid']) !== '' && $payslip_detail['basic_paid'] > 0) { ?>
					<tr>
						<td style="line-height:7px;width: 80%;">Basic Paid / الأساسي المدفوع </td>
						<td style="line-height:7px;width: 20%;text-align: right;">
							<?= (trim($payslip_detail['basic_paid'])) ? trim($payslip_detail['basic_paid']) : '0.00'; ?>
						</td>
					</tr>
					<?php } ?>
					<?php if(trim($payslip_detail['bike_spare_parts']) !== '' && $payslip_detail['bike_spare_parts'] > 0) { ?>
					<tr>
						<td style="line-height:7px;width: 80%;">Bike Spare Parts / قطع غيار الدراجة </td>
						<td style="line-height:7px;width: 20%;text-align: right;">
							<?= (trim($payslip_detail['bike_spare_parts'])) ? trim($payslip_detail['bike_spare_parts']) : '0.00'; ?>
						</td>
					</tr>
					<?php } ?>
					<?php if(trim($payslip_detail['cash_advance']) !== '' && $payslip_detail['cash_advance'] > 0) { ?>
					<tr>
						<td style="line-height:7px;width: 80%;">Cash Advance / السلف النقدية </td>
						<td style="line-height:7px;width: 20%;text-align: right;">
							<?= (trim($payslip_detail['cash_advance'])) ? trim($payslip_detail['cash_advance']) : '0.00'; ?>
						</td>
					</tr>
					<?php } ?>
					<?php if(trim($payslip_detail['compliance_penalty']) !== '' && $payslip_detail['compliance_penalty'] > 0) { ?>
					<tr>
						<td style="line-height:7px;width: 80%;">Compliance Penalty / غرامة الامتثال </td>
						<td style="line-height:7px;width: 20%;text-align: right;"><?= (trim($payslip_detail['compliance_penalty'])) ? trim($payslip_detail['compliance_penalty']) : '0.00';?></td>
					</tr>
					<?php } ?>
					<?php if(trim($payslip_detail['contact_penalties']) !== '' && $payslip_detail['contact_penalties'] > 0) { ?>
					<tr>
						<td style="line-height:7px;width: 80%;">Contact Penalties / عقوبات الاتصال </td>
						<td style="line-height:7px;width: 20%;text-align: right;">
							<?= (trim($payslip_detail['contact_penalties'])) ? trim($payslip_detail['contact_penalties']) : '0.00'; ?>
						</td>
					</tr>
					<?php } ?>
					
					<?php if(trim($payslip_detail['days_deduction']) !== '' && $payslip_detail['days_deduction'] > 0) { ?>
					<tr>
						<td style="line-height:7px;width: 80%;">Days Deduction / خصم الأيام </td>
						<td style="line-height:7px;width: 20%;text-align: right;">
							<?= (trim($payslip_detail['days_deduction'])) ? trim($payslip_detail['days_deduction']) : '0.00'; ?>
						</td>
					</tr>
					<?php } ?>
					<?php if(trim($payslip_detail['declined_penalties']) !== '' && $payslip_detail['declined_penalties'] > 0) { ?>
					<tr>
						<td style="line-height:7px;width: 80%;">Declined Penalties / العقوبات المرفوضة </td>
						<td style="line-height:7px;width: 20%;text-align: right;">
							<?= (trim($payslip_detail['declined_penalties'])) ? trim($payslip_detail['declined_penalties']) : '0.00'; ?>
						</td>
					</tr>
					<?php } ?>
					<?php if(trim($payslip_detail['id_suspension_penalty']) !== '' && $payslip_detail['id_suspension_penalty'] > 0) { ?>
					<tr>
						<td style="line-height:7px;width: 80%;">ID Suspension Penalty / غرامة تعليق الهوية </td>
						<td style="line-height:7px;width: 20%;text-align: right;">
							<?= (trim($payslip_detail['id_suspension_penalty'])) ? trim($payslip_detail['id_suspension_penalty']) : '0.00'; ?>
						</td>
					</tr>
					<?php } ?>
					<?php if(trim($payslip_detail['jahez_cash_shortage']) !== '' && $payslip_detail['jahez_cash_shortage'] > 0) { ?>
					<tr>
						<td style="line-height:7px;width: 80%;">Jahez Cash Shortage / نقص كاش جاهز </td>
						<td style="line-height:7px;width: 20%;text-align: right;">
							<?= (trim($payslip_detail['jahez_cash_shortage'])) ? trim($payslip_detail['jahez_cash_shortage']) : '0.00'; ?>
						</td>
					</tr>
					<?php } ?>
					<?php if(trim($payslip_detail['jahez_debit']) !== '' && $payslip_detail['jahez_debit'] > 0) { ?>
					<tr>
						<td style="line-height:7px;width: 80%;">Jahez Debit / خصم جاهز </td>
						<td style="line-height:7px;width: 20%;text-align: right;"><?= (trim($payslip_detail['jahez_debit'])) ? trim($payslip_detail['jahez_debit']) : '0.00';?></td>
					</tr>
					<?php } ?>
					<?php if(trim($payslip_detail['noon_cash_shortage']) !== '' && $payslip_detail['noon_cash_shortage'] > 0) { ?>
					<tr>
						<td style="line-height:7px;width: 80%;">Noon Cash Shortage / عجز نقدي في نون </td>
						<td style="line-height:7px;width: 20%;text-align: right;">
							<?= (trim($payslip_detail['noon_cash_shortage'])) ? trim($payslip_detail['noon_cash_shortage']) : '0.00'; ?>
						</td>
					</tr>
					<?php } ?>
					<?php if(trim($payslip_detail['license_deduction']) !== '' && $payslip_detail['license_deduction'] > 0) { ?>
					<tr>
						<td style="line-height:7px;width: 80%;">Licenses Deduction / خصم التراخيص </td>
						<td style="line-height:7px;width: 20%;text-align: right;">
							<?= (trim($payslip_detail['license_deduction'])) ? trim($payslip_detail['license_deduction']) : '0.00'; ?>
						</td>
					</tr>
					<?php } ?>
					<?php if(trim($payslip_detail['mobile_deduction']) !== '' && $payslip_detail['mobile_deduction'] > 0) { ?>
					<tr>
						<td style="line-height:7px;width: 80%;">Mobile Deduction / خصم الهاتف المحمول </td>
						<td style="line-height:7px;width: 20%;text-align: right;">
							<?= (trim($payslip_detail['mobile_deduction'])) ? trim($payslip_detail['mobile_deduction']) : '0.00'; ?>
						</td>
					</tr>
					<?php } ?>
					<?php if(trim($payslip_detail['online_hours_incentive_deduction']) !== '' && $payslip_detail['online_hours_incentive_deduction'] > 0) { ?>
					<tr>
						<td style="line-height:7px;width: 80%;">Online Hours Deduction / خصم الحافز بساعات العمل الأوتلايت </td>
						<td style="line-height:7px;width: 20%;text-align: right;">
							<?= (trim($payslip_detail['online_hours_incentive_deduction'])) ? trim($payslip_detail['online_hours_incentive_deduction']) : '0.00'; ?>
						</td>
					</tr>
					<?php } ?>
					<?php if(trim($payslip_detail['personal_sim_card']) !== '' && $payslip_detail['personal_sim_card'] > 0) { ?>
					<tr>
						<td style="line-height:7px;width: 80%;">Personal Sim Card / شريحة الاتصال الشخصي </td>
						<td style="line-height:7px;width: 20%;text-align: right;">
							<?= (trim($payslip_detail['personal_sim_card'])) ? trim($payslip_detail['personal_sim_card']) : '0.00'; ?>
						</td>
					</tr>
					<?php } ?>
					<?php if(trim($payslip_detail['target_based_deduction']) !== '' && $payslip_detail['target_based_deduction'] > 0) { ?>
					<tr>
						<td style="line-height:7px;width: 80%;">Target Based Deduction / الخصم بناء على الهدف </td>
						<td style="line-height:7px;width: 20%;text-align: right;">
							<?= (trim($payslip_detail['target_based_deduction'])) ? trim($payslip_detail['target_based_deduction']) : '0.00'; ?>
						</td>
					</tr>
					<?php } ?>
					<?php if(trim($payslip_detail['traffic_violation']) !== '' && $payslip_detail['traffic_violation'] > 0) { ?>
					<tr>
						<td style="line-height:7px;width: 80%;">Traffic Violation / مخالفات مرورية </td>
						<td style="line-height:7px;width: 20%;text-align: right;">
							<?= (trim($payslip_detail['traffic_violation'])) ? trim($payslip_detail['traffic_violation']) : '0.00'; ?>
						</td>
					</tr>
					<?php } ?>
					<?php if(trim($payslip_detail['unpaid_leave']) !== '' && $payslip_detail['unpaid_leave'] > 0) { ?>
					<tr>
						<td style="line-height:7px;width: 80%;">Unpaid Leave / إجازة بدون أجر </td>
						<td style="line-height:7px;width: 20%;text-align: right;">
							<?= (trim($payslip_detail['unpaid_leave'])) ? trim($payslip_detail['unpaid_leave']) : '0.00'; ?>
						</td>
					</tr>
					<?php } ?>
					<?php if(trim($payslip_detail['wallet_adjustment']) !== '' && $payslip_detail['wallet_adjustment'] > 0) { ?>
					<tr>
						<td style="line-height:7px;width: 80%;">Wallet Adjustment / تعديل المحفظة </td>
						<td style="line-height:7px;width: 20%;text-align: right;">
							<?= (trim($payslip_detail['wallet_adjustment'])) ? trim($payslip_detail['wallet_adjustment']) : '0.00'; ?>
						</td>
					</tr>
					<?php } ?>
					<?php if(trim($payslip_detail['wallet_balance']) !== '' && $payslip_detail['wallet_balance'] > 0) { ?>
					<tr>
						<td style="line-height:7px;width: 80%;">Wallet Balance / رصيد المحفظة </td>
						<td style="line-height:7px;width: 20%;text-align: right;">
							<?= (trim($payslip_detail['wallet_balance'])) ? trim($payslip_detail['wallet_balance']) : '0.00'; ?>
						</td>
					</tr>
					<?php } ?>
				</table>
			</td>
		</tr>
		<tr>
			<td style="border-right: 1px solid #ddd;border-bottom: 1px solid #ddd;">
				<table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;">
					<tr>
						<td style="line-height:7px;width: 80%;"><strong>Total Earnings / إجمالي الأجر (A)</strong></td>
						<td style="line-height:7px;width: 20%;text-align: right;"><strong><?= (trim($payslip_detail['total_earnings'])) ? trim($payslip_detail['total_earnings']) : '0.00';?></strong></td>
					</tr>
				</table>
			</td>
			<td style="border-bottom: 1px solid #ddd;">
				<table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;">
					<tr>
						<td style="line-height:7px;width: 80%;"><strong>Total Deductions / إجمالي الخصومات (C)</strong></td>
						<td style="line-height:7px;width: 20%;text-align: right;"><strong><?= (trim($payslip_detail['total_deduction'])) ? trim($payslip_detail['total_deduction']) : '0.00';?></strong></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="8" style="width: 100%;background-color: #f4fdff;">
		<tr>
			<td valign="center" style="text-align: left;font-size: 11px;line-height:5px;"><strong>NET SALARY PAYABLE / (A+B+C) :</strong></td>
			<td valign="center" style="text-align: center;font-size: 11px;line-height:5px;"> 
				<?php 
				$netPay = trim($payslip_detail['net_pay']);
				//$payslip_detail['wallet_adjustment']; 
				echo (trim($payslip_detail['net_pay'])) ? number_format($netPay, 2, '.', '') : '0.00';
				?>
			</td>
			<td valign="center" style="text-align: right;font-size: 11px;line-height:5px;"><strong>الراتب الصافي المستحق / (C+B+A) :</strong></td>
		</tr>
		<tr>
			<td valign="center" style="text-align: left;font-size: 11px;border-bottom:1px solid #ddd;"><strong>NET SALARY IN WORDS :</strong></td>
			<td valign="center" style="text-align: center;font-size: 11px;border-bottom:1px solid #ddd;"><?php echo convert_sar_to_words($netPay);?></td>
			<td valign="center" style="text-align: right;font-size: 11px;border-bottom:1px solid #ddd;"><strong> الراتب الصافي بالكلمات :</strong></td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="2" style="width: 100%;">
		<tr>
			<td valign="center" style="text-align: left;font-size: 10px;color:#5c5b5b"> **<strong>Note:</strong> All amounts displayed in this payslip are in SAR</td>
			<td valign="center" style="text-align: right;font-size: 10px;color:#5c5b5b"> جميع المبالغ المعروضة في هذه البيان الراتب هي بالريال السعودي <strong>** ملاحظة :</strong></td>
		</tr>
		<tr>
			<td valign="center" style="text-align: left;font-size: 9px;color:#5c5b5b"> *This is a system generated salary slip and does not require signature.</td>
			<td valign="center" style="text-align: right;font-size: 9px;color:#5c5b5b"> هذه بيان الراتب مصدرة من النظام ولا تتطلب توقيعاً <strong>*</strong></td>
		</tr>
	</table>
</body>

</html>
