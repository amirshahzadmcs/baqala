<style> 
.modal-body {
    padding: 0.4rem;
}
</style>
<div>
	<?php echo form_open("admin/hr/employees/save-profession-request", array("id" => "request_form", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
		<input type="hidden" name="emp_id" value="<?php echo $emp_detail->id;?>" required />
		<input type="hidden" name="request_type" value="ChangeProfessionRequest" required />
		<!-- Tab panes -->
		<div id="ajaxRes"></div>
		<div class="row tab-inner-section m-2 py-2">
			<h4 class="header-title">Fill Request Details</h4><hr>

			<div class="col-md-12 col-sm-12 mb-3 form-group px-2">
                <label for="request_date">Request Date <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="request_date" name="request_date" max="<?php echo date("Y-m-d"); ?>" required />
            </div>

            <div class="col-md-12 col-sm-12 mb-3 form-group px-2">
                <label for="current_profession">Current Profession <span class="text-danger">*</span></label>
                <input type="hidden" id="current_profession" name="current_profession" value="<?php echo $emp_detail->iqama_profession;?>" />
                <input type="text" class="form-control" value="<?php echo $emp_detail->profession_name;?>" disabled />
			</div>

			<div class="col-md-12 col-sm-12 mb-3 form-group px-2" id="expensesContainer">
				<label for="new_profession">New Profession <span class="text-danger">*</span></label>
				<select class="form-control form-select" data-parsley-allselected="true" name="new_profession" id="new_profession" required>
					<option value="">Select New Profession</option>
					<?php foreach (professionList() as $profession): ?>
					<option value="<?php echo $profession->id; ?>"><?php echo $profession->profession_name; ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="col-md-12 col-sm-12 mb-3 form-group px-2">
				<label for="debit_cost_to">Debit Cost to <span class="text-danger">*</span></label>
				<select class="form-control form-select" data-parsley-allselected="true" name="debit_cost_to" id="debit_cost_to" required>
					<option value="">Select Debit Cost to</option>
					<option value="company">Company</option>
					<option value="employee">Employee</option>
				</select>
			</div>
		</div>
	<?php echo form_close(); ?>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$("#request_form").on("submit", function (e) {
			e.preventDefault();

			var $btn = $("#save_request_btn");
			$btn.prop("disabled", true).text("Saving..."); // change text + disable

			var formData = new FormData(this); 
			$.ajax({
				url: "<?php echo site_url('admin/hr/employees/save-profession-request'); ?>",
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
