<style> 
.modal-body {
    padding: 0.4rem;
}
</style>
<div>
	<?php echo form_open("admin/hr/employees/save-transfer-request", array("id" => "request_form", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
		<input type="hidden" name="emp_id" value="<?php echo $emp_detail->id;?>" required />
		<input type="hidden" name="request_type" value="TransferRequest" required />
		<!-- Tab panes -->
		<div id="ajaxRes"></div>
		<div class="row tab-inner-section m-2 py-2">
			<h4 class="header-title">Fill Request Details</h4><hr>

            <div class="col-md-12 col-sm-12 mb-3 form-group px-2">
                <label for="current_employer">Current Employer</label>
                <input type="hidden" id="current_employer" name="current_employer" value="<?php echo $emp_detail->sponsor_id;?>" />
                <?php
                    $currentEmployerId = $current_employer['employer_id'] ?? '';
                    $currentEmployerName = $current_employer['employer_name'] ?? '';
                ?>
				<input type="text" class="form-control" value="<?php echo $currentEmployerId . ' - ' . $currentEmployerName;?>" disabled />
			</div>

            <div class="col-md-12 col-sm-12 mb-3 form-group px-2">
                <label for="request_date">Request Date <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="request_date" name="request_date" max="<?php echo date("Y-m-d"); ?>" required />
            </div>

			<div class="col-md-12 col-sm-12 mb-3 form-group px-2">
				<label for="transfer_type">Transfer Type</label>
				<select class="form-control form-select" data-parsley-allselected="true" name="transfer_type" id="transfer_type" required>
					<option value="">Select Transfer Type</option>
					<option value="1">Transfer Laborer from another Establishment</option>
					<option value="2">Internal Transfer</option>
				</select>
			</div>
			<div class="col-md-12 col-sm-12 mb-3 form-group px-2" id="expensesContainer">
				<label for="new_employer">New Employer</label>
				<select class="form-control form-select" data-parsley-allselected="true" name="new_employer" id="new_employer" required>
					<option value="">Select New Employer</option>
                    <?php foreach (sponsorsHelper() as $sponsor): ?>
					<option value="<?php echo $sponsor['id']; ?>"><?php echo $sponsor['employer_id'] . ' - ' . $sponsor['employer_name']; ?></option>
                    <?php endforeach; ?>
				</select>
			</div>
			
			<div class="col-md-12 col-sm-12 mb-3 form-group px-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="update_joining_date" id="updateJoiningDate">
                    <label class="form-check-label" for="updateJoiningDate">
                        Update Joining Date in HR System
                    </label>
                </div>
            </div>

			<div class="col-md-12 col-sm-12 mb-3 form-group px-2">
                <label for="request_date">Reason (If any)</label>
                <input type="text" class="form-control" id="reason" name="reason" />
            </div>
		</div>
		<div class="row tab-inner-section m-2 py-2">
			<h4 class="header-title">Contract Detail</h4><hr>
			<div class="col-md-6 col-sm-12 form-group mb-2">
				<label for="contract_id">Contract ID</label>
				<input type="text" class="form-control" id="contract_id" name="contract_id" />
			</div>
			<div class="col-md-6 col-sm-12 form-group mb-2">
				<label for="contract_period">Period</label>
				<input type="text" class="form-control" id="contract_period" name="contract_period" />
			</div>
			<div class="col-md-6 col-sm-12 form-group mb-2">
				<label for="contract_start_date">Contract Start Date</label>
				<input type="date" class="form-control" id="contract_start_date" name="contract_start_date" />
			</div>
			<div class="col-md-6 col-sm-12 form-group mb-2">
				<label for="contract_end_date">Contract End Date</label>
				<input type="date" class="form-control" id="contract_end_date" name="contract_end_date" />
			</div>
		</div>
	<?php echo form_close(); ?>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('#new_employer').on('change', function() {
			let currentEmployerId = $('#current_employer').val();
			let selectedNewEmployer = $(this).val();

			if (selectedNewEmployer === currentEmployerId) {
				toastr.error('New employer cannot be the same as current employer.', 'Error');
				$(this).val(''); // reset selection
			}
		});
	});

	$(document).ready(function () {
		$("#request_form").on("submit", function (e) {
			e.preventDefault();

			var $btn = $("#save_request_btn");
			$btn.prop("disabled", true).text("Saving..."); // change text + disable

			var formData = new FormData(this); 
			$.ajax({
				url: "<?php echo site_url('admin/hr/employees/save-transfer-request'); ?>",
				type: "POST",
				data: formData,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function (response) {
					if (response.type === "success") {
						toastr.success(response.message);
						setTimeout(function () {
							location.reload();
						}, 2000);
					} else if (response.type === "error") {
						toastr.error(response.message);
					}
				},
				error: function (xhr, status, error) {
					console.error("AJAX Error:", xhr.responseText, status, error);
					toastr.error('An unexpected error occurred. Please try again.');
				},
				complete: function () {
					// reset button
					$btn.prop("disabled", false).text("Save");
				}
			});
		});
	});
</script>
