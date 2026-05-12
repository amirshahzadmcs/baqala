<div>
	<?php echo form_open("admin/hr/employees/save-loan-request", array("id" => "request_form", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
		<input type="hidden" name="emp_id" value="<?php echo $emp_detail->id;?>" required />
		<input type="hidden" name="request_type" value="LoanRequest" required />
		<!-- Tab panes -->
		<div id="ajaxRes"></div>
		<div class="row tab-inner-section m-2 py-2">
			<h4 class="header-title">Loan Details</h4><hr>
			<div class="col-md-6 col-sm-12 form-group">
				<label for="loan_type">Type</label>
				<select class="form-control form-select" data-parsley-allselected="true" name="loan_type" id="loan_type" required>
					<option value="">Select Loan Type</option>
					<option value="Housing">Housing</option>
					<option value="Insurance Claim Fee">Insurance Claim Fee</option>
					<option value="License Fees">License Fees</option>
					<option value="Mobile Loan">Mobile Loan</option>
					<option value="Personal Cash Advance">Personal Cash Advance</option>
					<option value="Personal Sim Card">Personal Sim Card</option>
					<option value="Traffic Violation">Traffic Violation</option>
					<option value="Urgent">Urgent</option>
				</select>
			</div>
			<div class="col-md-6 col-sm-12 form-group">
				<label for="loan_amount">Amount</label>
				<div class="input-group mb-3">
					<input type="number" step="1" class="form-control" name="loan_amount" min="1" id="loan_amount" required>
					<span class="input-group-text">SAR</span>
				</div>
			</div>
			<div class="col-md-6 col-sm-12 form-group">
				<label for="deduction_start_date">Deduction Starting Month</label>
				<div class="position-relative" id="datepicker4">
					<input type="text" class="form-control" data-date-container='#datepicker4' data-provide="datepicker" name="deduction_start_date" id="deduction_start_date" 
					data-date-format="d MM yyyy" data-date-autoclose="true" data-date-min-view-mode="1" required>
				</div>
			</div>
		</div>
		<div class="row tab-inner-section m-2 py-2">
			<h4 class="header-title">Installment Calculation</h4><hr>
			<div class="col-md-6 col-sm-12 form-group">
				<select class="form-control form-select" data-parsley-allselected="true" name="calculation_type" id="calculation_type" required>
					<option value="specified_amount">Specified monthly amount</option>
					<option value="specified_months">Specified number of months</option>
				</select>
			</div>
			
			<div class="col-md-6 col-sm-12 form-group" id="specified_input">
				<div class="input-group">
					<input type="number" step="1" class="form-control" name="specified_value" id="specified_value" onkeyup="loanCalculation()" min="1" required>
					<span class="input-group-text">SAR</span>
				</div>
			</div>
			<div class="col-md-12 mt-2" id="calculation_container"></div>
		</div>
		<div class="row tab-inner-section m-2 py-2">
			<h4 class="header-title">Reason</h4><hr>
			<div class="col-md-12 col-sm-12 form-group mb-2">
				<input type="text" class="form-control" id="reason" name="reason" />
			</div>
			
			<div class="col-md-12 col-sm-12 form-group">
				<input type="file" name="attachment[]" id="attachment" class="dropify"
					accept="image/png, image/jpeg, image/jpg, image/gif, image/svg, image/webp"
					data-max-file-size="2M" data-height="100">
			</div>
		</div>
	<?php echo form_close(); ?>
</div>
<script type="text/javascript">
	$('.dropify').dropify();

	$('#calculation_type').change(function(e) {
		e.preventDefault();
		var calculation_type = $(this).find('option:selected').val();
		var specific_input = '';
		if(calculation_type == 'specified_months'){
			specific_input = `<div class="input-group mb-3">
					<input type="number" step="1" class="form-control specified-month-value" name="specified_value" id="specified_value" onkeyup="loanCalculation()" min="1" max="3" required>
					<span class="input-group-text">Months</span>
				</div>`;
		}else{
			specific_input = `<div class="input-group mb-3">
					<input type="number" step="1" class="form-control" name="specified_value" id="specified_value" onkeyup="loanCalculation()" min="1" required>
					<span class="input-group-text">SAR</span>
				</div>`;
		}
		$("#specified_input").html(specific_input);
		$("#calculation_container").html('');
	});

	$(document).on("input", ".specified-month-value", function () {
		toastr.clear();
		var value = parseInt($(this).val()) || 0;
		var min = 1;
		var max = 3;
		
		if (value < min || value > max) {
			$(this).val("");
			toastr.error("Please enter a month between 1 and 3");
		}
	});


	$('#loan_amount').change(function(e) {
		e.preventDefault();
		loanCalculation();
	});

	function loanCalculation() {
		const showNextValue = number  => Math.floor(number ) + (number  % 1 > 0 ? 1 : 0);
		var calculation_type = $('#calculation_type').find('option:selected').val();
		var loan_amount = $('#loan_amount').val();
		var specified_value = $('#specified_value').val();
		var loan_start_month = $('#deduction_start_date').val();
		var loan_end_month = '';
		var monthly_amt = 0;
		var installContainer = '';
		var installPara = '';
		if(calculation_type == 'specified_months'){
			monthly_amt = loan_amount / specified_value;
			if(loan_start_month !== ''){
				installContainer = `<h4>SAR `+ monthly_amt.toFixed(2) +`/Month</h4>`;
				var loan_s = new Date(loan_start_month);
				var loan_months = (parseInt(specified_value) - 1);
				loan_s.setMonth(loan_s.getMonth() + loan_months);
				loan_end_month = loan_s.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });

				var loan_e = new Date(loan_start_month);
				loan_e.toISOString().slice(0,10);
				var loan_s_fromated = loan_e.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
				if(loan_months > 0){
					installPara = `<p class="mb-1">`+ loan_s_fromated +` - `+ loan_end_month +` (`+ showNextValue(loan_months + 1) +` Months)</p>`;
				}else{
					installPara = `<p class="mb-1">`+ loan_s_fromated +` (1 Month)</p>`;
				}
			}
		}else{
			monthly_amt = parseFloat(specified_value);
			if(!isNaN(monthly_amt) && loan_start_month !== ''){
				
				//alert(monthly_amt);
				installContainer = `<h4>SAR `+ monthly_amt.toFixed(2) +`/Month</h4>`;
				var loan_s = new Date(loan_start_month);
				var loan_months = showNextValue(loan_amount / specified_value);
				loan_s.setMonth(loan_s.getMonth()+(loan_months-1));
				loan_s.toISOString().slice(0,10);
				loan_end_month = loan_s.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });

				var loan_e = new Date(loan_start_month);
				loan_e.toISOString().slice(0,10);
				var loan_s_fromated = loan_e.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
				if(loan_months > 1){
					installPara = `<p class="mb-1">`+ loan_s_fromated +` - `+ loan_end_month +` (`+ showNextValue(loan_months) +` Months)</p>`;
				}else{
					installPara = `<p class="mb-1">`+ loan_s_fromated +` (1 Month)</p>`;
				}
			}
		}
		$("#calculation_container").html(installContainer + installPara);
	}

	$(document).ready(function () {
		$("#request_form").on("submit", function (e) {
			e.preventDefault();
			var formData = new FormData(this); 
			$.ajax({
				url: "<?php echo site_url('admin/hr/employees/save-loan-request'); ?>",
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
			});
		});
	});
</script>
