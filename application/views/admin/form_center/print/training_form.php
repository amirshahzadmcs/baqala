<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Baqala Station - Training Form</title>
	<style>
		*{padding:0px;margin:0px;}
	</style>
</head>
<body>
	<?php
		$checked = base_url('admin_assets/icons/checkbox-checked.jpg');
		$unchecked = base_url('admin_assets/icons/checkbox-uncheck.jpg');
	?>
    <table cellpadding="2" cellspacing="0" border="0">
		<tr>
			<td style="width:37%"></td>
			<td align="center" style="border:1px solid #000;width:26%;">
				<h1>TRAINING FORM</h1>
			</td>
			<td style="width:37%"></td>
		</tr>
		<tr><td style="line-height: 10px;"></td></tr>
	</table>
	<table cellpadding="5" cellspacing="0" style="border:1px solid #ddd;">
		<tr><td style="border-bottom:1px solid #ddd;"><h4>Employee Details</h4></td></tr>
		<tr>
			<td style="width: 55%;">
				<table cellpadding="3" cellspacing="0" style="font-size: 10px;">
					<tr>
						<td style="width: 30%;">Employee Name</td>
						<td style="width: 5%;">:</td>
						<td style="width: 65%;"><?php echo (($employee_data['emp_detail']['full_name'] !=='') ? $employee_data['emp_detail']['full_name'] : 'NA');?></td>
					</tr>
					<tr>
						<td style="width: 30%;">Employee ID</td>
						<td style="width: 5%;">:</td>
						<td style="width: 65%;"><?php echo (($employee_data['emp_detail']['emp_no'] !=='') ? $employee_data['emp_detail']['emp_no'] : 'NA');?></td>
					</tr>
					<tr>
						<td style="width: 30%;">Iqaama Number</td>
						<td style="width: 5%;">:</td>
						<td style="width: 65%;"><?php echo (($employee_data['emp_detail']['iqama_no'] !=='') ? $employee_data['emp_detail']['iqama_no'] : 'NA');?></td>
					</tr>
					<tr>
						<td style="width: 30%;">Mobile No.</td>
						<td style="width: 5%;">:</td>
						<td style="width: 65%;"><?php echo (($employee_data['emp_detail']['mobile'] !=='') ? $employee_data['emp_detail']['mobile'] : 'NA');?></td>
					</tr>
					<tr>
						<td style="width: 30%;">Position</td>
						<td style="width: 5%;">:</td>
						<td style="width: 65%;"><?php echo (($employee_data['emp_detail']['designation_name'] !=='') ? $employee_data['emp_detail']['designation_name'] : 'NA');?></td>
					</tr>
					<tr>
						<td style="width: 30%;">DL Number</td>
						<td style="width: 5%;">:</td>
						<td style="width: 65%;"><?php echo (($employee_data['other_detail']['driving_license_number'] !=='') ? $employee_data['other_detail']['driving_license_number'] : 'NA');?></td>
					</tr>
					<tr>
						<td style="width: 30%;">DL Issue Date</td>
						<td style="width: 5%;">:</td>
						<td style="width: 65%;"><?php echo (($employee_data['other_detail']['driving_license_issue_date'] !=='') ? formatedDate($employee_data['other_detail']['driving_license_issue_date']) : 'NA');?></td>
					</tr>
				</table>
			</td>
			<td style="width: 45%;">
				<table cellpadding="5" cellspacing="0" style="border:1px solid #000;">
					<tr>
						<td style="width:25%;"></td>
						<td style="width:50%;background-color:#000;color:#fff;text-align:center;"><b>Admin Check List</b></td>
						<td style="width:25%;"></td>
					</tr>
					<tr>
						<td colspan="3">
							<table cellpadding="3" cellspacing="0" style="font-size: 10px;">
								<tr>
									<td>
										<img src="<?= $unchecked; ?>" width="12px">&nbsp; <span>Uniform Form</span>
									</td>
									<td>
										<img src="<?= $unchecked; ?>" width="12px">&nbsp; <span>Safety Gear Form</span>
									</td>
								</tr>
								<tr>
									<td>
										<img src="<?= $unchecked; ?>" width="12px">&nbsp; <span>Bike Handover Form</span>
									</td>
									<td>
										<img src="<?= $unchecked; ?>" width="12px">&nbsp; <span>Sim Handover Form</span>
									</td>
								</tr>
								<tr>
									<td>
										<img src="<?= $unchecked; ?>" width="12px">&nbsp; <span>Employee ID Card</span>
									</td>
									<td>
										<img src="<?= $unchecked; ?>" width="12px">&nbsp; <span>TAMM Registration Form</span>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<table cellpadding="8" cellspacing="0" border="1" style="font-size: 10px;">
					<tr>
						<td>Aggregator:</td>
						<td>Aggregator ID:</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<table cellpadding="0" cellspacing="0">
		<tr><td></td></tr>
	</table>
	<table border="1" cellpadding="5" cellspacing="0" style="font-size: 10px;">
		<tr>
			<td width="7%" style="background-color:#000;color:#fff;text-align:center;border-right:1px solid #fff;font-size: 11px;"><b>S.No.</b></td>
			<td width="18%" style="background-color:#000;color:#fff;text-align:center;border-right:1px solid #fff;font-size: 11px;"><b>Particulars</b></td>
			<td width="55%" style="background-color:#000;color:#fff;text-align:center;border-right:1px solid #fff;font-size: 11px;"><b>Remarks</b></td>
			<td width="10%" style="background-color:#000;color:#fff;text-align:center;border-right:1px solid #fff;font-size: 11px;"><b>Date</b></td>
			<td width="10%" style="background-color:#000;color:#fff;text-align:center;border:1px solid #000;font-size: 11px;"><b>Sign.</b></td>
		</tr>
		<tr>
			<td align="center">1.</td>
			<td>Team Name</td>
			<td><?php echo (($team_detail['name'] !=='') ? $team_detail['name'] : 'NA');?></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center">2.</td>
			<td>Trainer Name</td>
			<td><?php echo (($team_detail['leader_full_name'] !=='') ? $team_detail['leader_full_name'] .'('. $team_detail['leader_emp_no'] .')' : 'NA');?></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center">3.</td>
			<td>Training Start Date</td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center">4.</td>
			<td>Audio/Video Session Date</td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center">5.</td>
			<td>Application Training</td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center">6.</td>
			<td>Field Training Start Date</td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center">7.</td>
			<td>Traffic Violation</td>
			<td>
				<table cellpadding="2" cellspacing="0" border="0" style="font-size: 8px;">
					<tr>
						<td><img src="<?= base_url('admin_assets/icons/checkbox-uncheck.jpg'); ?>" width="10px">&nbsp; <span>Red Light Cross: SAR 3000/- to 6000/-</span></td>
						<td><img src="<?= base_url('admin_assets/icons/checkbox-uncheck.jpg'); ?>" width="10px">&nbsp; <span>Going One Way: SAR 3000/- to 6000/-</span></td>
					</tr>
					<tr>
						<td><img src="<?= base_url('admin_assets/icons/checkbox-uncheck.jpg'); ?>" width="10px">&nbsp; <span>Driving Without Safety Kit: SAR 500/- to 1000/-</span></td>
						<td><img src="<?= base_url('admin_assets/icons/checkbox-uncheck.jpg'); ?>" width="10px">&nbsp; <span>Driving Without Helmet: SAR 500/- to 1000/-</span></td>
					</tr>
					<tr>
						<td><img src="<?= base_url('admin_assets/icons/checkbox-uncheck.jpg'); ?>" width="10px">&nbsp; <span>Company Penalty on Violation: SAR 500/-</span></td>
					</tr>
				</table>
			</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center">8.</td>
			<td>Mobile Data Misuse</td>
			<td>
				<table cellpadding="3" cellspacing="0" border="0" style="font-size: 10px;">
					<tr>
						<td><img src="<?= base_url('admin_assets/icons/checkbox-uncheck.jpg'); ?>" width="10px">&nbsp; <span>Full Bill Payment + Penalty SAR 250/-</span></td>
					</tr>
				</table>
			</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center">9.</td>
			<td>Accident (If Any)</td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center">10.</td>
			<td>Field Training End Date</td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
	</table>
	<table border="1" cellpadding="10" cellspacing="0" style="font-size: 10px;">
		<tr>
			<td><b>Trainer Signature: </b></td>
			<td><b>Employee Signature: </b></td>
		</tr>
	</table>
	<table cellpadding="0" cellspacing="0">
		<tr><td></td></tr>
	</table>
	<table cellpadding="5" cellspacing="0" style="border:1px solid #ddd;">
		<tr><td style="border-bottom:1px solid #ddd;"><h4>Transfer To Team</h4></td></tr>
		<tr>
			<td>
				<table cellpadding="3" cellspacing="0" style="font-size: 10px;">
					<tr>
						<td style="width: 30%;">Team:</td>
						<td style="width: 40%;">Team Leader Name:</td>
						<td style="width: 30%;">On Boarding Date: </td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<table cellpadding="10" cellspacing="0" style="font-size: 10px;border:1px solid #ddd;">
		<tr>
			<td style="border-right:1px solid #ddd;"><b>TL Signature: </b></td>
			<td><b>Employee Signature: </b></td>
		</tr>
	</table>
	<table cellpadding="0" cellspacing="0">
		<tr><td></td></tr>
	</table>
	<table cellpadding="5" cellspacing="0" style="border:1px solid #ddd;">
		<tr>
			<td style="border-bottom:1px solid #ddd;"><h4>HR Records</h4></td>
		</tr>
	</table>
	<table cellpadding="5" cellspacing="0" border="0" style="font-size: 10px; border-collapse: collapse;">
		<tr>
			<td colspan="2" style="border: 1px solid #ddd;">
				<table style="width: 100%;">
					<tr><td style="height: 10px;"></td></tr>
					<tr>
						<td>Salary Start Date: 
							<b><?php 
							echo (($employee_data['other_detail']['driving_license_issue_date'] !== '') 
								? date('d-M-Y', strtotime(date('Y-m-d', strtotime($employee_data['other_detail']['driving_license_issue_date'] . ' +1 day')))) 
								: 'NA');
							?></b>
						</td>
					</tr>
					<tr><td style="height: 10px;"></td></tr>
				</table>
			</td>
			<td align="center" style="vertical-align: top; border: 1px solid #ddd;"><u>Employee Signature</u></td>
			<td align="center" style="border: 1px solid #ddd;"><u>TL Signature</u></td>
		</tr>
		<tr>
			<td align="center" style="border: 1px solid #ddd;"><u>Supervisor Signature</u><br><br></td>
			<td align="center" style="border: 1px solid #ddd;"><u>Operation Head Signature</u><br><br></td>
			<td align="center" style="border: 1px solid #ddd;"><u>HR Signature</u><br><br></td>
			<td align="center" style="border: 1px solid #ddd;"><u>COO Signature</u><br><br></td>
		</tr>
	</table>
	<table cellpadding="0" cellspacing="0">
		<tr><td></td></tr>
	</table>
	<table cellpadding="5" cellspacing="0" style="border:1px solid #ddd;">
		<tr>
			<td style="border-bottom:1px solid #ddd;"><h4>Document Audit</h4></td>
		</tr>
	</table>
	<table cellpadding="5" cellspacing="0" border="0" style="font-size: 10px; border:1px solid #ddd;">
		<tr>
			<td><img src="<?= base_url('admin_assets/icons/checkbox-uncheck.jpg'); ?>" width="10px">&nbsp; <span>Visa Copy</span></td>
			<td><img src="<?= base_url('admin_assets/icons/checkbox-uncheck.jpg'); ?>" width="10px">&nbsp; <span>Passport Copy</span></td>
			<td><img src="<?= base_url('admin_assets/icons/checkbox-uncheck.jpg'); ?>" width="10px">&nbsp; <span>Offer Letter</span></td>
			<td><img src="<?= base_url('admin_assets/icons/checkbox-uncheck.jpg'); ?>" width="10px">&nbsp; <span>Employment Contract</span></td>
			<td><img src="<?= base_url('admin_assets/icons/checkbox-uncheck.jpg'); ?>" width="10px">&nbsp; <span>DL Fees Letter</span></td>
		</tr>
		<tr>
			<td><img src="<?= base_url('admin_assets/icons/checkbox-uncheck.jpg'); ?>" width="10px">&nbsp; <span>Promissory Letter</span></td>
			<td><img src="<?= base_url('admin_assets/icons/checkbox-uncheck.jpg'); ?>" width="10px">&nbsp; <span>Qiwa Copy</span></td>
			<td><img src="<?= base_url('admin_assets/icons/checkbox-uncheck.jpg'); ?>" width="10px">&nbsp; <span>Iqama Copy</span></td>
			<td><img src="<?= base_url('admin_assets/icons/checkbox-uncheck.jpg'); ?>" width="10px">&nbsp; <span>IBAN Certificate</span></td>
			<td><img src="<?= base_url('admin_assets/icons/checkbox-uncheck.jpg'); ?>" width="10px">&nbsp; <span>Driving License</span></td>
		</tr>
		<tr>
			<td><img src="<?= base_url('admin_assets/icons/checkbox-uncheck.jpg'); ?>" width="10px">&nbsp; <span>Driving License Scan</span></td>
		</tr>
	</table>
</body>

</html>
