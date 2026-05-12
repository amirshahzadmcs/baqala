<table id="batchDetailTable" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
	<thead>
		<tr>
			<th>S.No.</th>
			<th>Batch No.</th>
			<th>CV No.</th>
			<th>Country</th>
			<th>Hiring Type</th>
			<th>Aggregator</th>
			<th>Pos. Applied for</th>
			<th>Full Name</th>
			<th>Passport No.</th>
			<th>Arrival Date</th>
			<th>Salary Package</th>
			<th>Food Allowance</th>
			<th colspan="2">1st Initial Cash Payment</th>
			<th colspan="2">2nd Payment</th>
			<th colspan="2">3rd Payment</th>
			<th>Tools</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if(count($allowance_list) > 0){ 
			$count = 1;
			foreach ($allowance_list as $key => $value) {
		?>
			<tr>
				<td><?php echo $count++;?></td>
				<td><?php echo $value['batch_no'];?></td>
				<td><?php echo $value['cv_no'];?></td>
				<td><?php echo $value['country_name'];?></td>
				<td><?php echo $value['hiring_type'];?></td>
				<td><?php echo $value['project_name'];?></td>
				<td><?php echo $value['applied_for_job'];?></td>
				<td><?php echo implode(' ', array_filter([$value['first_name'], $value['middle_name'], $value['third_name'], $value['surname']])); ?></td>
				<td><?php echo $value['passport_no'];?></td>
				<td><?php echo date('d-m-Y', strtotime($value['arrival_date']));?></td>
				<td><?php echo $value['salary_package'];?></td>
				<td><?php echo $value['food_allowance'];?> SAR</td>
				<!-- First Payment -->
				<td align="center"><?php echo isset($value['first_payment']) ? date('d-m-Y', strtotime(json_decode($value['first_payment'])->payment_date)) : '-'; ?></td>
				<td align="center"><?php echo isset($value['first_payment']) ? json_decode($value['first_payment'])->payment_amt .' SAR' : '-'; ?></td>

				<!-- Second Payment -->
				<td align="center"><?php echo isset($value['second_payment']) ? date('d-m-Y', strtotime(json_decode($value['second_payment'])->payment_date)) : '-'; ?></td>
				<td align="center"><?php echo isset($value['second_payment']) ? json_decode($value['second_payment'])->payment_amt .' SAR' : '-'; ?></td>

				<!-- Third Payment -->
				<td align="center"><?php echo isset($value['third_payment']) ? date('d-m-Y', strtotime(json_decode($value['third_payment'])->payment_date)) : '-'; ?></td>
				<td align="center"><?php echo isset($value['third_payment']) ? json_decode($value['third_payment'])->payment_amt .' SAR' : '-'; ?></td>
				<td><?php echo (check_action_permission(get_user_role(), 'food_allowance_request', 'print_food_receipt') ? '<a type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Print Food Allowance Receipt" href="'. base_url('admin/hr/food-allowance/print-food-receipt?id='. $value['id']) .'" target="_blank"><i class="mdi mdi-printer-check font-size-18"></i></a>' : '').(check_action_permission(get_user_role(), 'food_allowance_request', 'refresh_user_allowance') ? '<button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Update Food Allowance" onclick="confirmRefreshUserAllowance(\'' . $value['id'] . '\', \'' . $value['batch_no'] . '\')"><i class="mdi mdi-refresh font-size-18"></i></button>' : '');?></td>
			</tr>
		<?php 
			}}else{ 
		?>
		<tr>
			<td colspan="16" align="center">Data not available</td>
		</tr>
		<?php } ?>
	</tbody>
</table>

<script>
	function confirmRefreshUserAllowance(id, batch_no) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This will update latest food allowance detail of selected user, You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, refresh it!'
        }).then((result) => {
            if (result.isConfirmed) {
                refreshUserAllowance(id, batch_no);
            }
        });
    }

    function refreshUserAllowance(id, batch_no) {
        $.ajax({
            url: "<?php echo base_url('admin/hr/food-allowance/refresh-user-allowance'); ?>",
            method: 'POST',
            data: { id: id },
            success: function (response) {
				viewBatchDetail(batch_no);
                Swal.fire(
                    'Updated!',
                    'Food allowance has been updated.',
                    'success'
                );
            },
            error: function (errorResponse) {
                Swal.fire(
                    'Error!',
                    'There was an issue updating the food allowance.',
                    'error'
                );
                console.log(errorResponse);
            }
        });
    }
</script>
