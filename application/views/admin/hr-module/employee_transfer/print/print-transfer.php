<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Baqala Station - Employee Transfer</title>
	<style>
	*{padding:0px;margin:0px;}
	table {border-collapse:collapse; table-layout:fixed;}
	table td {word-wrap:break-word;}
	.checkbox-text {
		font-size: 16px;
		line-height: 5px;
		vertical-align: bottom;
	}
	</style>
</head>
<body>
	<table cellpadding="1" cellspacing="0" border="0">
		<tr>
			<td align="left">
				<h2>EMPLOYEE TRANSFER LIST</h2>
			</td>
		</tr>
		<tr>
			<td align="left">
				<p style="font-size:10px;"><strong>Batch No: <?php echo $batch_list['batch_no'];?></strong></p>
			</td>
		</tr>
		<tr><td></td></tr>
	</table>
	<table border="1" cellpadding="5" cellspacing="0" style="width: 100%;">
		<tr>
			<td style="width: 17%;"><strong>Request Date</strong></td>
			<td style="width: 21%;"><?php echo date('d-m-Y', strtotime($batch_list['request_date']));?></td>
			<td style="width: 13%;"><strong>Batch No.</strong></td>
			<td style="width: 15%;"><?php echo $batch_list['batch_no'];?></td>
			<td style="width: 13%;"><strong>Total Employees</strong></td>
			<td style="width: 21%;"><?php echo $batch_list['total_employees'];?></td>
		</tr>
	</table>
	<table cellpadding="1" cellspacing="0" border="0">
		<tr><td></td></tr>
		<tr><td><u><strong>Employee List</strong></u></td></tr>
		<tr><td></td></tr>
	</table>
	<table border="1" cellpadding="4" cellspacing="0" style="width: 100%;font-size:8px;">
		<tr>
			<th style="width: 3%;background-color:#000;color:#fff;text-align:center;">S.No.</th>
			<th style="width: 4%;background-color:#000;color:#fff;text-align:center;">Emp No.</th>
			<th style="width: 12%;background-color:#000;color:#fff;text-align:center;">Employee Name</th>
			<th style="width: 9%;background-color:#000;color:#fff;text-align:center;">Designation</th>
			<th style="width: 6%;background-color:#000;color:#fff;text-align:center;">Iqama No.</th>
			<th style="width: 9%;background-color:#000;color:#fff;text-align:center;">Old Employer</th>
			<th style="width: 9%;background-color:#000;color:#fff;text-align:center;">New Employer</th>
			<th style="width: 9%;background-color:#000;color:#fff;text-align:center;">Transfer Type</th>
			<th style="width: 6%;background-color:#000;color:#fff;text-align:center;">Request Date</th>
			<th style="width: 5%;background-color:#000;color:#fff;text-align:center;">Update Joining</th>
			<th style="width: 6%;background-color:#000;color:#fff;text-align:center;">Contract ID</th>
			<th style="width: 5%;background-color:#000;color:#fff;text-align:center;">Contract Period</th>
			<th style="width: 6%;background-color:#000;color:#fff;text-align:center;">Contract Start Date</th>
			<th style="width: 6%;background-color:#000;color:#fff;text-align:center;">Contract End Date</th>
			<th style="width: 6%;background-color:#000;color:#fff;text-align:center;">Status</th>
		</tr>
		<?php 
			if(count($batch_detail) > 0){ 
				$count = 1;

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

				foreach ($batch_detail as $key => $value) {
			?>
			<tr>
				<td align="center"><?php echo $count++;?></td>
				<td align="center"><?php echo $value['emp_no'];?></td>
				<td><?php echo $value['full_name'];?></td>
				<td><?php echo $value['designation_name'];?></td>
				<td align="center"><?php echo $value['iqama_no'];?></td>
				<td><?php echo $value['old_employer_id'] .' - '. $value['old_employer_name'];?></td>
				<td><?php echo $value['new_employer_id'] .' - '. $value['new_employer_name'];?></td>

				<!-- Transfer Type -->
				<td>
					<?php echo $transferTypes[$value['transfer_type']] ?? $value['transfer_type']; ?>
				</td>

				<td align="center"><?php echo date('d-m-Y', strtotime($value['request_date']));?></td>
				<td align="center"><?php echo ucfirst($value['update_joining_date']);?></td>
				<td align="center"><?php echo $value['contract_id'] ?? 'NA';?></td>
				<td align="center"><?php echo $value['contract_period'] ?? 'NA';?></td>
				<td align="center"><?php echo $value['contract_start_date'] ? date('d-m-Y', strtotime($value['contract_start_date'])) : 'NA';?></td>
				<td align="center"><?php echo $value['contract_end_date'] ? date('d-m-Y', strtotime($value['contract_end_date'])) : 'NA';?></td>
				<!-- Status with badge -->
				<td align="center">
					<?php 
						$status = $statuses[$value['status']] ?? ['label' => $value['status'], 'class' => 'badge-soft-secondary'];
						echo '<span class="badge rounded-pill '.$status['class'].' px-2 py-1 font-size-12">'.$status['label'].'</span>';
					?>
				</td>
			</tr>
		<?php 
			}
		?>
		<?php }else{ ?>
		<tr>
			<td colspan="15" align="center">Data not available</td>
		</tr>
		<?php } ?>
	</table>
</body>

</html>
