<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Baqala Station - Instant Visa Report</title>
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
		<tr><td></td></tr>
	</table>
    <table cellpadding="1" cellspacing="0" border="0">
		<tr>
			<td align="left">
				<h2>INSTANT VISA REPORT</h2>
			</td>
		</tr>
		<tr>
			<td align="left">
				<p>Visa Issue No: <?php echo $visa_detail->visa_issue_no;?></p>
			</td>
		</tr>
		<tr><td></td></tr>
	</table>
	<table border="1" cellpadding="5" cellspacing="0" style="width: 100%;">
		<tr>
			<td style="width: 17%;"><strong>Date Of Issue</strong></td>
			<td style="width: 21%;"><?php echo date('d-m-Y', strtotime($visa_detail->visa_issue_date));?></td>
			<td style="width: 13%;"><strong>Establishment No.</strong></td>
			<td style="width: 15%;"><?php echo $visa_detail->establishment_no;?></td>
			<td style="width: 13%;"><strong>Occupation</strong></td>
			<td style="width: 21%;"><?php echo $visa_detail->profession_name;?></td>
		</tr>
		<tr>
			<td style="width: 17%;"><strong>Unified No</strong></td>
			<td style="width: 21%;"><?php echo $visa_detail->unified_no;?></td>
			<td style="width: 13%;"><strong>Visa Issue No.</strong></td>
			<td style="width: 15%;"><?php echo $visa_detail->visa_issue_no;?></td>
			<td style="width: 13%;"><strong>Embassy</strong></td>
			<td style="width: 21%;"><?php echo $visa_detail->embassy;?></td>
		</tr>
		<tr>
			<td style="width: 17%;"><strong>Establishment Name (AR)</strong></td>
			<td style="width: 21%;"><?php echo $visa_detail->establishment_name;?></td>
			<td style="width: 13%;"><strong>No. Of Visa</strong></td>
			<td style="width: 15%;"><?php echo $visa_detail->no_of_visa - $visa_list->num_rows();?>/<?php echo $visa_detail->no_of_visa;?></td>
			<td style="width: 13%;"><strong>Gender</strong></td>
			<td style="width: 21%;"><?php echo ucfirst($visa_detail->gender);?></td>
		</tr>
		<tr>
			<td style="width: 17%;"><strong>Sponsor Name (EN)</strong></td>
			<td style="width: 21%;"><?php echo $visa_detail->sponsor_name;?></td>
			<td style="width: 13%;"><strong>Request No</strong></td>
			<td style="width: 15%;"><?php echo $visa_detail->request_no;?></td>
			<td style="width: 13%;"><strong>Religion</strong></td>
			<td style="width: 21%;"><?php echo $visa_detail->religion;?></td>
		</tr>
		<tr>
			<td style="width: 17%;"><strong>CR Number</strong></td>
			<td style="width: 21%;"><?php echo $visa_detail->cr_no;?></td>
			<td style="width: 13%;"><strong>Nationality</strong></td>
			<td style="width: 15%;"><?php echo $visa_detail->nationality_name;?></td>
			<td style="width: 13%;"><strong>Agency Name</strong></td>
			<td style="width: 21%;"><?php echo $visa_detail->agency_name;?></td>
		</tr>
	</table>
	<table cellpadding="1" cellspacing="0" border="0">
		<tr><td></td></tr>
		<tr><td><u><strong>Visa Numbers</strong></u></td></tr>
		<tr><td></td></tr>
	</table>
	<table border="1" cellpadding="4" cellspacing="0" style="width: 100%;">
		<tr>
			<td style="width: 4%;background-color:#000;color:#fff;text-align:center;"><strong>S.No.</strong></td>
			<td style="width: 8%;background-color:#000;color:#fff;text-align:center;"><strong>Border No.</strong></td>
			<td style="width: 8%;background-color:#000;color:#fff;text-align:center;"><strong>Nationality</strong></td>
			<td style="width: 15%;background-color:#000;color:#fff;text-align:center;"><strong>Occupation</strong></td>
			<td style="width: 10%;background-color:#000;color:#fff;text-align:center;"><strong>Embassy Name</strong></td>
			<td style="width: 7%;background-color:#000;color:#fff;text-align:center;"><strong>Gender</strong></td>
			<td style="width: 7%;background-color:#000;color:#fff;text-align:center;"><strong>Religion</strong></td>
			<td style="width: 8%;background-color:#000;color:#fff;text-align:center;"><strong>Passport No</strong></td>
			<td style="width: 25%;background-color:#000;color:#fff;text-align:center;"><strong>Candidate Name</strong></td>
			<td style="width: 8%;background-color:#000;color:#fff;text-align:center;"><strong>Visa Status</strong></td>
		</tr>
		<?php 
			if($visa_list->num_rows() > 0){ 
			$s_no = 1;foreach($visa_list->result_array() as $v_array){
		?>
		<tr>
			<td align="center"><?php echo $s_no;?>.</td>
			<td align="center"><?php echo $v_array['border_nos'];?></td>
			<td align="center"><?php echo (isset($visa_detail->nationality_name)) ? $visa_detail->nationality_name : 'NA';?></td>
			<td><?php echo (isset($visa_detail->profession_name)) ? $visa_detail->profession_name : 'NA';?></td>
			<td align="center"><?php echo (isset($visa_detail->embassy)) ? $visa_detail->embassy : 'NA';?></td>
			<td align="center"><?php echo (isset($visa_detail->gender)) ? ucfirst($visa_detail->gender) : 'NA';?></td>
			<td align="center"><?php echo (isset($visa_detail->religion)) ? $visa_detail->religion : 'NA';?></td>
			<td align="center"><?php echo (isset($v_array['passport_no'])) ? $v_array['passport_no'] : 'NA';?></td>
			<td><?php echo (isset($v_array['full_name'])) ? $v_array['full_name'] : 'NA';?></td>
			<td align="center">
				<?php 
					if($v_array['visa_status'] == '0'){
						$status = 'Pending';
					}
					if($v_array['visa_status'] == '1'){
						$status = 'Active';
					}
					if($v_array['visa_status'] == '2'){
						$status = 'Expired';
					}
				?>
				<?php echo $status;?>
			</td>
		</tr>
		<?php $s_no++;}} else{ ?>
		<tr>
			<td colspan="10" align="center">No Visa Found</td>
		</tr>
		<?php } ?>
	</table>
	
</body>

</html>
