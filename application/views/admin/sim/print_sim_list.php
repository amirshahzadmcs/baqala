<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Baqala Station - Sim Card List</title>
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
				<table width="100%" border="0" cellspacing="0" cellpadding="2" style="font-size: 8px;margin-top:15px;border-bottom:1px solid #000;">
					
					<tr>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:4%;font-size: 10px;">S.No.</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:5%;font-size: 10px;">Addition Date</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:6%;font-size: 10px;">Owner ID</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:7%;font-size: 10px;">Owner Name</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:6%;font-size: 10px;">Mobile No</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:9%;font-size: 10px;">Sim Card No</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:5%;font-size: 10px;">Date of purchase</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:6%;font-size: 10px;">Activation date</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:5%;font-size: 10px;">Sim Type</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:4%;font-size: 10px;">Is GPS</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:6%;font-size: 10px;">Network Provider</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:9%;font-size: 10px;">Active Plan</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:5%;font-size: 10px;">Emp. ID</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:11%;font-size: 10px;">Current User</td>
						<td valign="top" height="20px" style="text-align: center;border-bottom:1px solid #000;width:6%;font-size: 10px;">Sim Status</td>
						<td valign="top" height="20px" style="text-align: center;border-bottom:1px solid #000;width:6%;font-size: 10px;">Allotment Status</td>
					</tr>
					<?php $i=1;foreach($invoice as $item) { ?>
					<tr>
						<td valign="middle" style="text-align: left;line-height:10px;border-bottom:1px dashed #ddd;"><?php echo $i++; ?></td>
						<td valign="middle" style="text-align: left;line-height:10px;border-bottom:1px dashed #ddd;"><?php echo date('d-m-Y', strtotime($item->created_at)); ?></td>
						<td valign="middle" style="text-align: left;line-height:10px;border-bottom:1px dashed #ddd;"><?php echo $item->owner_id; ?></td>
						<td valign="middle" style="text-align: left;line-height:10px;border-bottom:1px dashed #ddd;"><?php echo $item->owner_name; ?></td>
						<td valign="middle" style="text-align: left;line-height:10px;border-bottom:1px dashed #ddd;"><?php echo $item->mobile; ?></td>
						<td valign="middle" style="text-align: left;line-height:10px;border-bottom:1px dashed #ddd;"><?php echo ucfirst($item->sim_no); ?></td>
						<td valign="middle" style="text-align: left;line-height:10px;border-bottom:1px dashed #ddd;"><?php echo date('d-m-Y', strtotime($item->date_of_purchase)); ?></td>
						<td valign="middle" style="text-align: left;line-height:10px;border-bottom:1px dashed #ddd;"><?php echo ($item->activation_date !== '' && $item->activation_date !== '0000-00-00') ? date('d-m-Y', strtotime($item->activation_date)) : 'NA'; ?></td>
						<td valign="middle" style="text-align: left;line-height:10px;border-bottom:1px dashed #ddd;"><?php echo ucfirst($item->sim_type); ?></td>
						<td valign="middle" style="text-align: left;line-height:10px;border-bottom:1px dashed #ddd;"><?php echo (($item->is_gps_sim == 'on') ? '<span class="badge badge-pill badge-soft-success font-size-13">Yes</span><br>' : '<span class="badge badge-pill badge-soft-dark font-size-13">No</span>') .'<br>'. (($item->gps_installed_vehicle !== '') ? vehicleDetailHelper($item->gps_installed_vehicle)->vehicle_no .' '. vehicleDetailHelper($item->gps_installed_vehicle)->vehicle_type : ''); ?></td>
						<td valign="middle" style="text-align: left;line-height:10px;border-bottom:1px dashed #ddd;"><?php echo $item->network_name; ?></td>
						<td valign="middle" style="text-align: left;line-height:10px;border-bottom:1px dashed #ddd;"><?php echo $item->plan_name; ?></td>
						<td valign="middle" style="text-align: left;line-height:10px;border-bottom:1px dashed #ddd;"><?php echo $item->emp_no; ?></td>
						<td valign="middle" style="text-align: left;line-height:10px;border-bottom:1px dashed #ddd;"><?php echo ($item->alloted_user !== '') ? employeeDetailHelper($item->alloted_user)->full_name : 'NA'; ?></td>
						<?php
						if($item->status == '0'){
							$status = '<span class="badge badge-pill badge-soft-primary font-size-13">New</span>';
						}
						if($item->status == '1'){
							$status = '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>';
						}
						if($item->status == '2'){
							$status = '<span class="badge badge-pill badge-soft-warning font-size-13">Discontinued</span>';
						}
						if($item->status == '3'){
							$status = '<span class="badge badge-pill badge-soft-danger font-size-13">Blocked</span>';
						}
						if($item->status == '4'){
							$status = '<span class="badge badge-pill badge-soft-info font-size-13">Suspended</span>';
						}
						if($item->status == '5'){
							$status = '<span class="badge badge-pill badge-soft-dark font-size-13">Free</span>';
						}
						?>
						<td valign="middle" style="text-align: center;line-height:10px;border-bottom:1px dashed #ddd;"><?php echo $status; ?></td>
						<?php
						if($item->allotment == '0'){
							$allotment_status = '<span class="badge badge-pill badge-soft-primary font-size-13">New</span>';
						}
						if($item->allotment == '1'){
							$allotment_status = '<span class="badge badge-pill badge-soft-success font-size-13">Alloted</span>';
						}
						if($item->allotment == '2'){
							$allotment_status = '<span class="badge badge-pill badge-soft-danger font-size-13">Unalloted</span>';
						}
						?>
						<td valign="middle" style="text-align: right;line-height:10px;border-bottom:1px dashed #ddd;"><?php echo $allotment_status; ?></td>
					</tr>
					<?php } ?>
				</table>
			</td>
		</tr>
	</table>

</body>

</html>
