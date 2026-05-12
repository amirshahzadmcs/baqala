<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Maha Al Fala Trading Company - Insurance Policies Details</title>
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
			<td valign="top" style="width:32%;text-align: left;font-size: 14px;line-height:15px;">
				<strong>INSURANCE POLICY DETAILS</strong><br><strong> تفاصيل وثائق التأمين </strong>
			</td>
			<td valign="center" style="width:68%;">
				<table border="0" cellspacing="0" cellpadding="0" style="width: 100%;font-size: 11px;">
					<tr>
						<td style="border-bottom:1px solid #ddd;"></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="2" style="width: 100%;font-size: 9px;">
		<tr>
			<td colspan="7"></td>
		</tr>
		<tr style="background-color:#f1f1f1;">
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:10%;">Policy No.</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:10%;">Policy Type</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:10%;">Policy Date</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:40%;">Insurance Company</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:10%;">Total Vehicles</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:10%;">Status</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:10%;">Policy Expiry</td>
		</tr>
		<tr>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:10%;"><?= $detail->policy_number;?></td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:10%;"><?= $detail->policy_type;?></td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:10%;"><?= ($detail->policy_date) ? date('d F Y', strtotime($detail->policy_date)) : 'NA';?></td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:40%;"><?= $detail->company_name;?></td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:10%;"><?= count($allotments_list);?></td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:10%;">
				<?php
					$current_date = strtotime(date('Y-m-d'));
					$expiry_date = strtotime($detail->policy_expiry);
					$policy_status = ($current_date > $expiry_date) ? 'Expired' : 'Valid';
				?>
				<?= $policy_status;?>
			</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:10%;"><?= ($detail->policy_expiry) ? date('d F Y', strtotime($detail->policy_expiry)) : 'NA';?></td>
		</tr>
		<tr>
			<td colspan="7"></td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="2" style="width: 100%;font-size: 9px;">
		<tr style="background-color:#f1f1f1;">
			<td colspan="9" valign="center" style="text-align: left;border-top:1px solid #000;border-bottom:1px solid #000;"><strong>ALLOTMENTS DETAIL</strong></td>
		</tr>
		<tr style="background-color:#f1f1f1;">
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:6%;line-height:10px;">S.No.</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:10%;line-height:10px;">Vehicle No.</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:6%;line-height:10px;">Type</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:12%;line-height:10px;">Vehicle Model</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:10%;line-height:10px;">Vehicle Make</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:10%;line-height:10px;">Sequel No.</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:8%;line-height:10px;">Emp. No.</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:28%;line-height:10px;">Alloted To</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:10%;line-height:10px;">Status</td>
		</tr>
        <?php 
        if(count($allotments_list) > 0){
        $count = 1;
        foreach ($allotments_list as $key => $value) { 
        ?>
        <tr>
			<td align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?php echo $count++;?></td>
			<td align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= (trim($value['vehicle_no']) !== '') ? trim($value['vehicle_no']) : 'NA';?></td>
			<td align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= (trim($value['vehicle_type']) !== '') ? ucfirst($value['vehicle_type']) : 'NA';?></td>
			<td align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= (trim($value['vehicle_model']) !== '') ? trim($value['vehicle_model']) : 'NA';?></td>
			<td align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= (trim($value['make_name']) !== '') ? trim($value['make_name']) : 'NA';?></td>
			<td align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= (trim($value['sequel_no']) !== '') ? trim($value['sequel_no']) : 'NA';?></td>
            <td align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= (trim($value['alloted_employee_no']) !== '') ? $value['alloted_employee_no'] : 'NA';?></td>
            <td style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= (trim($value['alloted_employee']) !== '') ? ucfirst($value['alloted_employee']) : 'NA';?></td>
            <td align="center" style="border-bottom:1px solid #000;"><?= (trim($value['status']) !== '') ? ucfirst($value['status']) : 'NA';?></td>
        </tr>
        <?php }}else{ ?>
            <td colspan="9" align="center" style="border-bottom:1px solid #ddd;">No data found</td>
        <?php } ?>
	</table>

    <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
		<tr>
			<td colspan="9" valign="center"></td>
		</tr>
	</table>
</body>

</html>
