<div>
	<table class="table" style="border: 1px solid #ddd;">
		<tr>
			<td>Mobile No.</td>
			<td width="15" align="center">:</td>
			<td><?php echo $recharge_detail->mobile;?></td>
		</tr>
		<tr>
			<td>Service Provider</td>
			<td width="15" align="center">:</td>
			<td><?php echo $recharge_detail->network_name;?></td>
		</tr>
		<tr>
			<td>Plan</td>
			<td width="15" align="center">:</td>
			<td><?php echo $recharge_detail->plan_name;?></td>
		</tr>
		<tr>
			<td>Employee ID</td>
			<td width="15" align="center">:</td>
			<td><?php echo $recharge_detail->emp_no;?></td>
		</tr>
		<tr>
			<td>Employee Name</td>
			<td width="15" align="center">:</td>
			<td><?php echo $recharge_detail->full_name;?></td>
		</tr>
		<tr>
			<td>Recharge Date</td>
			<td width="15" align="center">:</td>
			<td><?php echo date('d-m-Y', strtotime($recharge_detail->recharge_date));?></td>
		</tr>
		<tr>
			<td>Recharge Card Value</td>
			<td width="15" align="center">:</td>
			<td><?php echo $recharge_detail->voucher_value;?></td>
		</tr>
		<tr>
			<td>Recharge Card VAT</td>
			<td width="15" align="center">:</td>
			<td><?php echo $recharge_detail->voucher_vat;?></td>
		</tr>
		<tr>
			<td>Total Amount</td>
			<td width="15" align="center">:</td>
			<td><?php echo $recharge_detail->total_amount;?></td>
		</tr>
		<tr>
			<td>Recharge Card Sr No</td>
			<td width="15" align="center">:</td>
			<td><?php echo $recharge_detail->serial_no;?></td>
		</tr>
		<tr>
			<td>Payment Source</td>
			<td width="15" align="center">:</td>
			<td><?php echo $recharge_detail->payment_source;?></td>
		</tr>
		<tr>
			<td>Created At</td>
			<td width="15" align="center">:</td>
			<td><?php echo date('d-m-Y', strtotime($recharge_detail->created_at));?></td>
		</tr>
	</table>
</div>