<style> 
.dropify-wrapper .dropify-message span.file-icon {
    font-size: 30px;
    color: #CCC;
}
.dropify-wrapper .dropify-message p {
	margin: 0;
    font-size: 12px;
}
.tab-inner-section {
	box-shadow: 0px 1px 4px #c5c5c5;
	border-radius: 5px;
	margin-bottom: 10px;
}
.correction-comment {
	background-color: #f5f5f5;
    border-color: #f5c6cb;
    padding: 10px;
    position: relative;
    z-index: 1;
    border-radius: 5px;
    margin-bottom: 10px;
}
</style>
<div class="modal-header">
	<h5 class="modal-title mt-0" id="requestDetailModalLabel">Update Loan Request Detail</h5>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body p-0">
    <?php echo form_open("admin/hr-module/requests/update-loan", array("id" => "loan_request_form", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>

    <input type="hidden" name="request_id" value="<?php echo $id; ?>" required />
    <input type="hidden" name="emp_id" value="<?php echo $employee_id; ?>" required />
    <input type="hidden" name="request_type" value="LoanRequest" required />

    <!-- Loan Details Section -->
    <div class="row tab-inner-section m-2 py-2">
        <h4 class="header-title">Loan Details</h4><hr>

        <div class="col-md-6 col-sm-12 form-group">
            <label for="loan_type">Type <?php echo $request_detail['type'] ?? ''; ?></label>
            <select class="form-control form-select" name="loan_type" id="loan_type" required>
                <option value="">Select Loan Type</option>
                <option value="Housing" <?php echo ($request_detail['type'] ?? '') == 'Housing' ? 'selected' : ''; ?>>Housing</option>
                <option value="Insurance Claim Fee" <?php echo ($request_detail['type'] ?? '') == 'Insurance Claim Fee' ? 'selected' : ''; ?>>Insurance Claim Fee</option>
                <option value="License Fees" <?php echo ($request_detail['type'] ?? '') == 'License Fees' ? 'selected' : ''; ?>>License Fees</option>
                <option value="Mobile Loan" <?php echo ($request_detail['type'] ?? '') == 'Mobile Loan' ? 'selected' : ''; ?>>Mobile Loan</option>
                <option value="Personal Cash Advance" <?php echo ($request_detail['type'] ?? '') == 'Personal Cash Advance' ? 'selected' : ''; ?>>Personal Cash Advance</option>
                <option value="Personal Sim Card" <?php echo ($request_detail['type'] ?? '') == 'Personal Sim Card' ? 'selected' : ''; ?>>Personal Sim Card</option>
                <option value="Traffic Violation" <?php echo ($request_detail['type'] ?? '') == 'Traffic Violation' ? 'selected' : ''; ?>>Traffic Violation</option>
                <option value="Urgent" <?php echo ($request_detail['type'] ?? '') == 'Urgent' ? 'selected' : ''; ?>>Urgent</option>
            </select>
        </div>

        <div class="col-md-6 col-sm-12 form-group">
            <label for="loan_amount">Amount</label>
            <div class="input-group mb-3">
                <input type="number" step="1" class="form-control" name="loan_amount" id="loan_amount" 
                value="<?php echo $request_detail['amount'] ?? ''; ?>" required>
                <span class="input-group-text">SAR</span>
            </div>
        </div>

        <div class="col-md-6 col-sm-12 form-group">
            <label for="deduction_start_date">Deduction Starting Month</label>
            <div class="position-relative" id="datepicker4">
                <input type="text" class="form-control" data-date-container='#datepicker4' data-provide="datepicker" name="deduction_start_date" id="deduction_start_date" 
                value="<?php echo !empty($request_detail['deduction_start_date']) 
                            ? date('d F Y', strtotime($request_detail['deduction_start_date'])) 
                            : ''; ?>" 
                data-date-format="d MM yyyy" data-date-autoclose="true" data-date-min-view-mode="1" required>
            </div>
        </div>
    </div>

    <div class="row tab-inner-section m-2 py-2">
        <h4 class="header-title">Installment Calculation</h4><hr>
        <div class="col-md-6 col-sm-12 form-group">
            <select class="form-control form-select" data-parsley-allselected="true" name="calculation_type" id="calculation_type" required>
                <option value="specified_amount" <?php echo ($request_detail['calculation_type'] ?? '') == 'specified_amount' ? 'selected' : ''; ?>>Specified monthly amount</option>
                <option value="specified_months" <?php echo ($request_detail['calculation_type'] ?? '') == 'specified_months' ? 'selected' : ''; ?>>Specified number of months</option>
            </select>
        </div>
        
        <div class="col-md-6 col-sm-12 form-group" id="specified_input">
            <div class="input-group">
                <input type="number" step="1" class="form-control" name="specified_value" id="specified_value" onkeyup="loanCalculation()" min="1" value="<?php echo $request_detail['specified_value'] ?? ''; ?>" required>
                <span class="input-group-text">SAR</span>
            </div>
        </div>
        <div class="col-md-12 mt-2" id="calculation_container"></div>
    </div>

    <!-- Reason Section -->
    <div class="row tab-inner-section m-2 py-2">
        <h4 class="header-title">Comment</h4><hr>
        <div class="col-md-12 col-sm-12 form-group mb-2">
            <div class="correctionList">
                <?php $this->load->view('admin/hr-module/request-approvals/components/correction_comments', ['corrections' => $correction_comments]); ?>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 form-group mb-2">
            <input type="text" class="form-control" id="comment" name="comment" placeholder="Write comment here..." required />
        </div>

        <div class="col-md-12 col-sm-12 form-group">
            <input type="file" name="attachment[]" id="attachment" class="dropify"
                accept="image/png, image/jpeg, image/jpg, image/gif, image/svg, image/webp"
                data-max-file-size="2M" data-height="100">
        </div>
        <div class="col-md-12 col-sm-12 form-group">
            <?php echo $existing_attachments_html; ?>
        </div>
    </div>

    <?php echo form_close(); ?>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="submit" form="loan_request_form" id="submit_btn" class="btn btn-primary">Save changes</button>
</div>

<script>
	function loanCalculation() {
        const showNextValue = (number) => Math.floor(number) + (number % 1 > 0 ? 1 : 0);

        const calculation_type = $('#calculation_type').val();
        const loan_amount = parseFloat($('#loan_amount').val()) || 0;
        const specified_value = parseFloat($('#specified_value').val()) || 1;
        const loan_start_month = $('#deduction_start_date').val();

        let installContainer = '';
        let installPara = '';

        if (calculation_type === 'specified_months') {
            const monthly_amt = loan_amount / specified_value;

            if (loan_start_month) {
                installContainer = `<h4>SAR ${monthly_amt.toFixed(2)}/Month</h4>`;
                const loan_s = new Date(loan_start_month);
                loan_s.setMonth(loan_s.getMonth() + (specified_value - 1));

                const loan_end_month = loan_s.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
                installPara = `<p class="mb-1">${loan_start_month} - ${loan_end_month} (${showNextValue(specified_value)} Months)</p>`;
            }
        } else {
            const monthly_amt = specified_value;

            if (!isNaN(monthly_amt) && loan_start_month) {
                installContainer = `<h4>SAR ${monthly_amt.toFixed(2)}/Month</h4>`;
                const loan_s = new Date(loan_start_month);
                const loan_months = showNextValue(loan_amount / specified_value);

                loan_s.setMonth(loan_s.getMonth() + (loan_months - 1));
                const loan_end_month = loan_s.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });

                installPara = `<p class="mb-1">${loan_start_month} - ${loan_end_month} (${showNextValue(loan_months)} Months)</p>`;
            }
        }

        $("#calculation_container").html(installContainer + installPara);
    }

    $(document).ready(function() {
        $('.dropify').dropify();

        // Trigger calculation on page load if values are available
        loanCalculation();

        $('#loan_request_form').submit(function(e) {
            e.preventDefault();

            const submitBtn = $('#submit_btn'); // Add an ID for your submit button
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Submitting...');

            const formData = new FormData($(this)[0]);

            $.ajax({
                url: '<?php echo base_url('admin/hr-module/requests/update-loan');?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.type === 'success') {
                        toastr.success(response.message);
                        $('#loan_request_form')[0].reset();
                        location.reload();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function() {
                    toastr.error('An error occurred while processing the request.');
                },
                complete: function() {
                    submitBtn.prop('disabled', false).html('Submit'); // Reset button state
                }
            });
        });

        // Fields that trigger recalculation
        $('#loan_amount, #deduction_start_date, #calculation_type, #specified_value').on('change keyup', function() {
            loanCalculation();
        });

        $('#calculation_type').change(function() {
            let calculation_type = $(this).val();
            let specific_input = '';

            if (calculation_type === 'specified_months') {
                specific_input = `
                    <div class="input-group mb-3">
                        <input type="number" step="1" class="form-control" name="specified_value" id="specified_value"
                        min="1" value="<?php echo $request_detail['specified_value'] ?? ''; ?>" required>
                        <span class="input-group-text">Months</span>
                    </div>`;
            } else {
                specific_input = `
                    <div class="input-group mb-3">
                        <input type="number" step="1" class="form-control" name="specified_value" id="specified_value"
                        min="1" value="<?php echo $request_detail['specified_value'] ?? ''; ?>" required>
                        <span class="input-group-text">SAR</span>
                    </div>`;
            }

            $("#specified_input").html(specific_input);
            loanCalculation(); // Trigger calculation after changing input
        });
    });
</script>