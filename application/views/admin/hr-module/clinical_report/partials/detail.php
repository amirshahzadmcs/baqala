<table id="batchDetailTable" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
	<thead>
		<tr>
			<th>S.No.</th>
			<th>Emp. No.</th>
			<th>Employee Name</th>
			<th>Iqama No.</th>
			<th>Status</th>
			<th>Policy No.</th>
			<th>Insurance Company</th>
			<th>Sign.</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if(count($clinical_detail) > 0){ 
			$count = 1;
			foreach ($clinical_detail as $key => $value) {
		?>
			<tr>
				<td><?php echo $count++;?></td>
				<td><?php echo $value['emp_no'];?></td>
				<td><?php echo $value['employee_name'];?></td>
				<td><?php echo $value['iqama_no'];?></td>
				<td>Approved</td>
				<td><?php echo $value['employee_policy_no'];?></td>
				<td><?php echo $value['policy_company_name'];?></td>
				<td></td>
			</tr>
		<?php 
			}}else{ 
		?>
		<tr>
			<td colspan="15" align="center">Data not available</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
