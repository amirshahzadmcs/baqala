<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Baqala Station - Employee Attendance Logs</title>
	<style>
	*{padding:0px;margin:0px;}
	
	</style>
</head>
<body>
	<style>
		table {border-collapse:collapse; table-layout:fixed;}
        table td {word-wrap:break-word;}
	</style>
    <table border="0" cellspacing="0" cellpadding="0" style="font-size: 10px; width: 100%;">

		<tr>
			<td colspan="3" style="padding-top:20px;">
				<table width="100%" border="0" cellspacing="0" cellpadding="5" style="font-size: 8px;margin-top:25px;border-bottom:1px solid #000;">
					
					<tr>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:6%;font-size: 10px;">S.No.</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:8%;font-size: 10px;">Emp. ID</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:30%;font-size: 10px;">Employee Name</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:16%;font-size: 10px;">Department</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:10%;font-size: 10px;">Date</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:10%;font-size: 10px;">Sign In</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:10%;font-size: 10px;">Sign Out</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:10%;font-size: 10px;">Status</td>
					</tr>
					<?php $i=1;foreach($attendance_logs as $item) { ?>
					<tr>
						<td valign="top" height="20px" style="text-align: left;"><?php echo $i++; ?></td>
						<td valign="top" height="20px" style="text-align: left;"><?php echo $item->emp_no; ?></td>
						<td valign="top" height="20px" style="text-align: left;"><?php echo ucfirst($item->full_name) .'<br>#'. $item->designation_name; ?></td>
						<td valign="top" height="20px" style="text-align: left;"><?php echo $item->department_name; ?></td>
						<td valign="top" height="20px" style="text-align: left;"><?php echo date('d-m-Y', strtotime($item->attendance_date)); ?></td>
						<td valign="top" height="20px" style="text-align: left;"><?php echo (!empty($item->time_in)) ? date('h:i:s a ', strtotime($item->time_in)) : ""; ?></td>
						<td valign="top" height="20px" style="text-align: left;"><?php echo (!empty($item->time_out)) ? date('h:i:s a ', strtotime($item->time_out)) : ""; ?></td>
						<td valign="top" height="20px" style="text-align: left;"><?php echo ($item->status == 'in') ? 'In' : 'Out'; ?></td>
					</tr>
					<tr>
						<td colspan="14" style="border-bottom:1px dashed #ddd;line-height:0px"></td>
					</tr>
					<?php } ?>
				</table>
			</td>
		</tr>
	</table>

</body>

</html>
