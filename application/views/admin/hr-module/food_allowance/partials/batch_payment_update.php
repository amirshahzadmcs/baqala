<style> 
.list-group-item {
    position: relative;
    display: block;
    padding: 0.75rem 0.75rem;
}
</style>
<?php echo form_open("admin/hr/food-allowance/update-form", array("id" => "updateAllowanceForm", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
<input type="hidden" name="batch_no" value="<?php echo $batch_detail['batch_no'];?>" required />
<div class="row tab-inner-section pb-4">
	<div class="col-md-12 col-sm-12 mb-3">
		<div class="card mb-2">
			<div class="card-header">Batch Information</div>
			<div class="card-body">
				<h6>Batch No. - <?php echo $batch_detail['batch_no'];?></h6>
				<h6>Arrival Date - <?php echo date('d-m-Y', strtotime($batch_detail['arrival_date']));?></h6>
				<h6>Last Payment Date - <?php echo date('d-m-Y', strtotime($batch_detail['last_payment_date']));?></h6>
				<h6>Next Payment Date - <?php echo date('d-m-Y', strtotime($batch_detail['scheduled_payment_date']));?></h6>
			</div>
		</div>
	</div>
    <div class="col-md-12 col-sm-12 form-group">
		<div class="leave-employee-group">
		<div class="card mb-2">
			<div class="card-header">CV List (<?php echo count($allowance_list);?> Cv Selected)</div>
			<div class="card-body p-1">
				<?php if(count($allowance_list) > 0){ ?>
				<div class="my-1 px-2">
					<input class="checkbox" type="checkbox" name="group_type" id="checkAll">
					<label class="form-check-label" for="checkAll" style="vertical-align: top;">Check All</label>
				</div>
				<ul class="list-group mt-1" id="employeeList">
					<?php foreach($allowance_list as $cv){ ?>
					<li class="list-group-item d-flex align-items-center">
						<div style="width:7%;"><input class="checkbox employee-checkbox" type="checkbox" name="selected_cvs[]" value="<?php echo $cv['id']; ?>"></div>
						<?php
							if($cv['slots_paid'] = '1'){
								$last_payment_info = $cv['first_payment'];
							}elseif($cv['slots_paid'] = '2'){
								$last_payment_info = $cv['second_payment'];
							}elseif($cv['slots_paid'] = '3'){
								$last_payment_info = $cv['third_payment'];
							}elseif($cv['slots_paid'] = '4'){
								$last_payment_info = $cv['fourth_payment'];
							}
							$last_payment_date = date('d-m-Y', strtotime(json_decode($last_payment_info)->payment_date));
							$last_payment_amt = json_decode($last_payment_info)->payment_amt;
						?>
						<div style="width:70%;">
							<h6 class="mb-0"><?php echo (($cv['first_name'] !=='') ? $cv['first_name'] : ''). (($cv['middle_name'] !=='') ? ' '.$cv['middle_name'] : ''). (($cv['third_name'] !=='') ? ' '.$cv['third_name'] : ''). (($cv['surname'] !=='') ? ' '.$cv['surname'] : ''); ?></h6>
							<small><?php echo $cv['cv_no']; ?> - <?php echo $cv['candidate_arabic_name']; ?></small><br>
							<small>Last Payment Amt. - <?php echo $last_payment_amt;?> SAR</small>
						</div>
						<?php if(!empty($cv['food_allowance'])){
							$food_allow = $cv['food_allowance'];

							// Prepare date calculations only once
							$nextPaymentDate = date('d-m-Y', strtotime($batch_detail['scheduled_payment_date']));
							$arrival_year = date('Y', strtotime($nextPaymentDate));
							$arrival_month = date('m', strtotime($nextPaymentDate));
							$daysInMonth = 30;
							$arrival_day = date('d', strtotime($nextPaymentDate));
							$remaining_days = $daysInMonth - $arrival_day;
							$current_day = date('j', strtotime($nextPaymentDate));

							$per_day_allowance = $food_allow / $daysInMonth;
							if ($current_day <= 15) {
								$remaining_days_in_period = 15 - $current_day + 1;
							} else {
								$remaining_days_in_period = $daysInMonth - $current_day + 1;
							}
							$remaining_allowance = $per_day_allowance * $remaining_days_in_period;
						}
						?>
						<div style="width:23%;">
							<button type="button" class="btn btn-outline-primary btn-sm" data-emp-id="<?php echo $cv['id']; ?>"><?php echo number_format($remaining_allowance, 2, '.', '');?> SAR</button>
						</div>
					</li>
					<?php } ?>
				</ul>
				<?php } ?>
			</div>
		</div>
    </div>
</div>
<?php echo form_close(); ?>
<script>
	$(document).ready(function() {
		$("#checkAll").click(function() {
			$(".employee-checkbox").prop("checked", this.checked);
		});
		// Handle form submission
		$('#updateAllowanceForm').on('submit', function (e) {
			e.preventDefault();
			var data = new FormData(this);
			var checkBoxChecked = $('#paymentConfirmation').is(':checked') ? 1 : 0;
        	data.append('confirm_payment', checkBoxChecked);
			// Send the AJAX request to save the form
			$.ajax({
				url: $(this).attr('action'),
				method: 'POST',
				data: data,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$("#btnUpload").prop('disabled', true);
					$("#btnUpload").html('<i class="fa fa-spinner fa-spin"></i> <small>Please wait ...</small>');
				}, 
				success: function (response) {
					// Ensure the response is parsed as JSON
					var result;
					try {
						result = typeof response === 'object' ? response : JSON.parse(response);
					} catch (e) {
						console.error('Failed to parse response as JSON:', e);
						toastr.error('Invalid server response. Please try again.');
						return;
					}

					// Handle the success or error message
					if (result.status === 'success') {
						toastr.success(result.message);
						$('#updateAllowanceForm')[0].reset();
						initializeDataTable();
						setTimeout(function() {
							location.reload();
						}, 1000);
					} else {
						toastr.error(result.message);
					}
					$("#btnUpload").prop('disabled', false);
					$("#btnUpload").html('Save');
				},
				error: function (error) {
					toastr.error('Failed to submit form. Please try again.');
					$("#btnUpload").prop('disabled', false);
					$("#btnUpload").html('Save');
					console.error(error);
				}
			});
		});
	});
</script>
