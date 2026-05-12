<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Maha Al Fala Trading Company - Employee Transfer Detail</title>
	<style>
	*{padding:0px;margin:0px;}
	table {border-collapse:collapse; table-layout:fixed;line-height:1.5;}
    table td {word-wrap:break-word;}
	</style>
</head>
<body>
    <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
		<tr>
			<td colspan="2" valign="center" style="text-align: right;line-height:0px;"><img src="<?php echo base_url('admin_assets/images/maha-al-fala.jpg');?>" height="50px"></td>
		</tr>
		<tr>
			<td valign="top" style="width:39%;text-align: left;font-size: 16px;line-height:15px;">
				<strong>EMPLOYEE TRANSFER DETAIL</strong><br><strong> نموذج تفاصيل نقل الموظف </strong>
			</td>
			<td valign="center" style="width:61%;">
				<table border="0" cellspacing="0" cellpadding="0" style="width: 100%;font-size: 11px;">
					<tr>
						<td style="border-bottom:1px solid #ddd;"></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="6" style="width: 100%;font-size: 10px;">
		<tr>
			<td valign="center" align="right"><b>Date/التاريخ : <?php echo date('d-m-Y', strtotime($transfer_detail['request_date']));?></b></td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="3" style="width: 100%;font-size: 10px;">
        <tr><td></td></tr>
    </table>

	<table border="0" cellspacing="0" cellpadding="6" style="width: 100%;font-size: 10px;border:1px solid #bbb;">
		<tr>
			<td valign="center" style="text-align: left;"><strong>Request Number</strong></td>
		</tr>
		<tr>
			<td style="text-align: left;">
				<h2><?= $transfer_detail['id'];?> - <?= $transfer_detail['batch_no'];?> - <?php echo date('Y', strtotime($transfer_detail['request_date']));?></h2>
			</td>
		</tr>
	</table>

    <table border="0" cellspacing="0" cellpadding="3" style="width: 100%;">
        <tr><td></td></tr>
    </table>

    <table border="0" cellspacing="0" cellpadding="3" style="width: 100%;">
        <tr><td><h2>Request Details</h2></td></tr>
    </table>
    <?php 
        // status mapping with badge classes
        $statuses = [
            1 => ['label' => 'Pending Employee Approval', 'class' => 'badge-soft-warning'],
            2 => ['label' => 'Pending Current Employer Approval', 'class' => 'badge-soft-info'],
            3 => ['label' => 'Completing', 'class' => 'badge-soft-success'],
            4 => ['label' => 'Rejected', 'class' => 'badge-soft-danger']
        ];

        // transfer type mapping
        $transferTypes = [
            1 => 'Transfer Laborer from another Establishment',
            2 => 'Internal Transfer'
        ];
    ?>
    <table border="0" cellspacing="0" cellpadding="6" style="width: 100%;font-size: 12px;border:1px solid #bbb;">
		<tr>
			<td style="text-align: left;border-bottom:1px solid #bbb;width:30%;">Current Employer</td>
			<td style="text-align: left;border-bottom:1px solid #bbb;width:70%;"><?= $transfer_detail['old_employer_name'];?></td>
		</tr>
		<tr>
			<td style="text-align: left;border-bottom:1px solid #bbb;width:30%;">Request Date</td>
			<td style="text-align: left;border-bottom:1px solid #bbb;width:70%;"><?= date('d-m-Y', strtotime($transfer_detail['request_date']));?></td>
		</tr>
		<tr>
			<td style="text-align: left;border-bottom:1px solid #bbb;width:30%;">Transfer Type</td>
			<td style="text-align: left;border-bottom:1px solid #bbb;width:70%;"><?php echo $transferTypes[$transfer_detail['transfer_type']] ?? $transfer_detail['transfer_type']; ?></td>
		</tr>
		<tr>
			<td style="text-align: left;border-bottom:1px solid #bbb;width:30%;">New Employer</td>
			<td style="text-align: left;border-bottom:1px solid #bbb;width:70%;"><?= $transfer_detail['new_employer_name'];?></td>
		</tr>
		<tr>
            <?php
                $status = $statuses[$transfer_detail['status']] ?? ['label' => $transfer_detail['status'], 'class' => 'badge-soft-secondary'];
            ?>
			<td style="text-align: left;border-bottom:1px solid #bbb;width:30%;">Status</td>
			<td style="text-align: left;border-bottom:1px solid #bbb;width:70%;"><?= $status['label']; ?></td>
		</tr>
	</table>

    <table border="0" cellspacing="0" cellpadding="3" style="width: 100%;">
        <tr><td></td></tr>
    </table>

    <table border="0" cellspacing="0" cellpadding="3" style="width: 100%;">
        <tr><td><h2>Contract Details</h2></td></tr>
    </table>

    <table border="0" cellspacing="0" cellpadding="6" style="width: 100%;font-size: 12px;border:1px solid #bbb;">
		<tr>
			<td style="text-align: left;border-bottom:1px solid #bbb;width:30%;">Employee Name</td>
			<td style="text-align: left;border-bottom:1px solid #bbb;width:70%;"><?= $transfer_detail['full_name'];?></td>
		</tr>
		<tr>
			<td style="text-align: left;border-bottom:1px solid #bbb;width:30%;">Contract ID</td>
			<td style="text-align: left;border-bottom:1px solid #bbb;width:70%;"><?= $transfer_detail['contract_id'] ?? 'N/A';?></td>
		</tr>
		<tr>
			<td style="text-align: left;border-bottom:1px solid #bbb;width:30%;">Iqama Number</td>
			<td style="text-align: left;border-bottom:1px solid #bbb;width:70%;"><?= $transfer_detail['iqama_no'] ?? 'N/A';?></td>
		</tr>
	</table>
</body>

</html>
