<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Baqala Station - Vehicle Handover Form</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
	<style>
	*{padding:0px;margin:0px;}
	.roboto-medium {
		font-family: "Roboto", sans-serif;
		font-weight: 500;
		font-style: normal;
	}
	</style>
</head>
<body>
	<style>
		table {border-collapse:collapse; table-layout:fixed;}
        table td {word-wrap:break-word;}
	</style>
	<table border="0" cellspacing="0" cellpadding="6" style="width: 100%;">
		<tr>
			<td></td>
		</tr>
	</table>
	<table cellspacing="0" cellpadding="5" border="1" style="font-size: 8px;">
		<tr>
			<td valign="middle" style="text-align: left;width:15%;">Emp. No: <strong><?php echo $emp_detail->emp_no;?></strong></td>
			<td valign="middle" style="text-align: left;width:38%;">Emp. Name: <strong><?php echo $emp_detail->full_name;?></strong></td>
			<td valign="middle" style="text-align: left;width:22%;">Vehicle Plate No: <strong><?php echo $vehicle_detail->vehicle_no;?></strong></td>
			<td valign="middle" style="text-align: left;width:25%;">Allotment Date: <?php echo (!empty($vehicle_detail->allotment_date) && $vehicle_detail->allotment_date !== '0000-00-00') ? formatedDate($vehicle_detail->allotment_date) : 'NA';?></td>
		</tr>
	</table>
    <table cellspacing="0" cellpadding="5" border="1">
		<tr>
			<td>
				<img src="<?php echo base_url('admin_assets/samples/dezire.jpg');?>">
			</td>
		</tr>
	</table>

</body>

</html>
