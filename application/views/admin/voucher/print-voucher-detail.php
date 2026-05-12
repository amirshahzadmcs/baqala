<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Baqala Station - Recharge Voucher Detail</title>
	<style>
	*{padding:0px;margin:0px}
	</style>
</head>
<body>
	<table border="0" cellspacing="0" cellpadding="1" style="font-size: 10px; width: 100%;">
		<tr>
			<td colspan="2" style="border-top:20px solid #35aa59"></td>
		</tr>
		<tr>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td colspan="2"><img src="<?php echo base_url('admin_assets/images/header-top.png');?>" style="max-width: 100%;" /></td>
		</tr>
		<tr>
			<td colspan="2">
				<table border="0" cellspacing="0" cellpadding="1" style="font-size: 10px; width: 100%;margin:0 auto;">
					<tr>
						<td style="width: 5%;"></td>
						<td colspan="3" style="border-top:1px solid #e0b500;width: 90%;"></td>
						<td style="width: 5%;"></td>
					</tr>
					<tr>
						<td style="width: 5%;"></td>
						<td align="left" valign="top" style="width: 40%;">
							<h4 style="font-size: 13px;"><strong>Voucher Details</strong></h4>
							<table>
								<tr>
									<td>Date Of Purchase</td>
									<td>: <?php echo date('d-m-Y', strtotime($voucher_detail->purchase_date));?></td>
								</tr>
								<tr>
									<td>Service Provider</td>
									<td>: <?php echo $voucher_detail->network_name;?></td>
								</tr>
								<tr>
									<td>Total Vouchers Purchased</td>
									<td>: <?php echo $voucher_detail->total_vouchers;?></td>
								</tr>
								<tr>
									<td>Expiry Date</td>
									<td>: <?php echo date('d-m-Y', strtotime($voucher_detail->expiry_date));?></td>
								</tr>
								<tr>
									<td></td>
									<td></td>
								</tr>
							</table>
						</td>
						<td align="left" valign="top" style="width: 20%;">
							
						</td>
						<td valign="top" style="width: 30%;text-align: left;">
							<h4 style="font-size: 13px;"><strong></strong></h4>
							<table>
								<tr>
									<td>Voucher Price</td>
									<td>: <?php echo $voucher_detail->voucher_value;?></td>
								</tr>
								<tr>
									<td>VAT</td>
									<td>: <?php echo $voucher_detail->voucher_vat;?></td>
								</tr>
								<tr>
									<td>Voucher Price (inc Vat)</td>
									<td>: <?php echo $voucher_detail->voucher_total;?></td>
								</tr>
								<tr>
									<td></td>
									<td></td>
								</tr>
							</table>
						</td>
						<td style="width: 5%;"></td>
					</tr>
					
					<tr>
						<td style="width: 5%;"></td>
						<td colspan="3" style="border-top:1px solid #e0b500;border-bottom:1px solid #e0b500;width: 90%;line-height:20px;"><h4 style="font-size: 13px;padding:5px;">Item Details</h4></td>
						<td style="width: 5%;"></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</table>
			</td>
		</tr>
		
	</table>

    <table border="0" cellspacing="0" cellpadding="0" style="font-size: 10px; width: 100%;">
		<tr>
			<td style="width: 5%;"></td>
			<td colspan="3" style="width: 90%;">
				<table width="100%" border="1" cellspacing="0" cellpadding="5">
					<tr>
						<td valign="top" bgcolor="#c6efce" style="width: 7%;"><strong>S. No.</strong></td>
						<td valign="top" bgcolor="#c6efce" style="width: 19%;"><strong>Voucher Serial Number</strong></td>
						<td valign="top" bgcolor="#c6efce" style="width: 11%;"><strong>Usage Date</strong></td>
						<td valign="top" bgcolor="#c6efce" style="width: 12%;"><strong>Mobile Number</strong></td>
						<td valign="top" bgcolor="#c6efce" style="width: 13%;"><strong>Vehicle Number</strong></td>
						<td valign="top" bgcolor="#c6efce" style="width: 11%;"><strong>Employee ID</strong></td>
						<td valign="top" bgcolor="#c6efce" style="width: 19%;"><strong>User Name</strong></td>
						<td valign="top" bgcolor="#c6efce" style="width: 8%;"><strong>Status</strong></td>
					</tr>
					<?php 
					$s_no = 1;foreach($voucher_list->result_array() as $v_array){
					?>
					<tr>
						<td valign="middle"><?php echo $s_no;?></td>
						<td valign="middle"><?php echo $v_array['serial_no'];?></td>
						<td valign="middle"><?php echo (isset($v_array['used_date'])) ? date('d-m-Y', strtotime($v_array['used_date'])) : 'NA';?></td>
						<td valign="middle"><?php echo (isset($v_array['mobile_no'])) ? $v_array['mobile_no'] : 'NA';?></td>
						<td valign="middle"><?php echo (isset($v_array['vehicle_no'])) ? $v_array['vehicle_no'] : 'NA';?></td>
						<td valign="middle"><?php echo (isset($v_array['emp_no'])) ? $v_array['emp_no'] : 'NA';?></td>
						<td valign="middle"><?php echo (isset($v_array['emp_full_name'])) ? $v_array['emp_full_name'] : 'NA';?></td>
						<td valign="middle">
							<?php 
								if($v_array['status'] == '0'){
									$status = '<span class="badge badge-pill badge-soft-primary font-size-13">New</span>';
								}
								if($v_array['status'] == '1'){
									$status = '<span class="badge badge-pill badge-soft-success font-size-13">Used</span>';
								}
								if($v_array['status'] == '2'){
									$status = '<span class="badge badge-pill badge-soft-danger font-size-13">Expired</span>';
								}
							?>
							<?php echo $status;?>
						</td>
					</tr>
					<?php $s_no++;} ?>
				</table>
			</td>
			<td style="width: 5%;"></td>
		</tr>
		
	</table>

</body>

</html>
