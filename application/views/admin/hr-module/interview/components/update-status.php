<style>
.size-inner-section {
    box-shadow: 0px 1px 4px #c5c5c5;
    border-radius: 5px;
    margin-bottom: 10px;
}
</style>
<div class="modal-header">
    <h6 class="modal-title mt-0" id="summaryModalFullscreenLabel">Update Interview Status</h6>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="size-inner-section px-1 py-1 mx-1">
        <div class="card-header">Interview Detail</div>
        <div class="d-flex align-items-center employee-detail">
            <div class="p-3 w-100">
                <table>
                    <tr>
                        <td>Interview No</td>
                        <td> : </td>
                        <td><?php echo ucfirst($interview_detail->interview_no); ?></td>
                    </tr>
                    <tr>
                        <td>Interview Date</td>
                        <td> : </td>
                        <td><?php echo $interview_detail->interview_date ? date('d-m-Y', strtotime($interview_detail->interview_date)) : ''; ?></td>
                    </tr>
                    <tr>
                        <td>Applicant Name</td>
                        <td> : </td>
                        <td><?php echo $interview_detail->applicant_name; ?></td>
                    </tr>
                    <tr>
                        <td>Position Applied</td>
                        <td> : </td>
                        <td><?php echo $interview_detail->pos_name; ?></td>
                    </tr>
                    <tr>
                        <td>Preferred City</td>
                        <td> : </td>
                        <td><?php echo $interview_detail->city_name; ?></td>
                    </tr>
                    <tr>
                        <td>Current Status</td>
                        <td> : </td>
                        <td><?php echo ucfirst($interview_detail->status); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="size-inner-section px-1 py-1 mx-1">
        <div class="card-header">Fill Below Detail</div>
        <div id="searchResponse"></div>
        <?php echo form_open("admin/hr/recruitment/interview/status-update", array("id" => "interviewStatusForm", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
        <input type="hidden" id="id" name="id" value="<?php echo $interview_detail->id; ?>" required />
        <div class="row p-2">
            <div class="col-md-12 col-sm-12 mb-3 form-group">
                <label for="status">Interview Status<span class="text-danger">*</span></label>
                <select name="status" id="manage_status" class="form-select" required>
                    <option value="">-- Select Interview Status --</option>
                    <option value="Phone Interview" <?php echo ($interview_detail->status == 'Phone Interview') ? " selected " : "" ?>>Phone Interview</option>
                    <option value="Onsite Interview" <?php echo ($interview_detail->status == 'Onsite Interview') ? " selected " : "" ?>>Onsite Interview</option>
                    <option value="Rejected" <?php echo ($interview_detail->status == 'Rejected') ? " selected " : "" ?>>Rejected</option>
                    <option value="Document Verification" <?php echo ($interview_detail->status == 'Document Verification') ? " selected " : "" ?>>Document Verification</option>
                    <option value="Hold - Need Clarification" <?php echo ($interview_detail->status == 'Hold - Need Clarification') ? " selected " : "" ?>>Hold - Need Clarification</option>
                    <option value="Qiwa Requested" <?php echo ($interview_detail->status == 'Qiwa Requested') ? " selected " : "" ?>>Qiwa Requested</option>
                    <option value="Qiwa Rejected" <?php echo ($interview_detail->status == 'Qiwa Rejected') ? " selected " : "" ?>>Qiwa Rejected</option>
                    <option value="Resend Qiwa" <?php echo ($interview_detail->status == 'Resend Qiwa') ? " selected " : "" ?>>Resend Qiwa</option>
                    <option value="Onboarding" <?php echo ($interview_detail->status == 'Onboarding') ? " selected " : "" ?>>Onboarding</option>
                    <option value="Hired" <?php echo ($interview_detail->status == 'Hired') ? " selected " : "" ?>>Hired</option>
                </select>
            </div>
            <div class="col-md-12 col-sm-12 mb-3 form-group">
                <label for="remarks">Remarks<span class="text-danger">*</span></label>
                <select name="remarks" id="remarks" class="form-select">
                    <option value="">-- Select Remarks --</option>
                    <option value="Salary" <?php echo ($interview_detail->remarks == 'Salary') ? " selected " : "" ?>>Salary</option>
                    <option value="Other" <?php echo ($interview_detail->remarks == 'Other') ? " selected " : "" ?>>Other</option>
                    <option value="Relocation" <?php echo ($interview_detail->remarks == 'Relocation') ? " selected " : "" ?>>Relocation</option>
                    <option value="Employer Rejected" <?php echo ($interview_detail->remarks == 'Employer Rejected') ? " selected " : "" ?>>Employer Rejected</option>
                    <option value="Legal Issue" <?php echo ($interview_detail->remarks == 'Legal Issue') ? " selected " : "" ?>>Legal Issue</option>
                    <option value="Other Offer" <?php echo ($interview_detail->remarks == 'Other Offer') ? " selected " : "" ?>>Other Offer</option>
                    <option value="Expired" <?php echo ($interview_detail->remarks == 'Expired') ? " selected " : "" ?>>Expired</option>
                </select>
            </div>
            <div class="col-md-12 col-sm-12 mb-3 form-group d-none" id="qiwaDateWrapper">
                <label for="qiwa_request_date">Qiwa Requested Date<span class="text-danger">*</span></label>
                <input type="date" name="qiwa_request_date" id="qiwa_request_date" value="<?php echo $interview_detail->qiwa_request_date ?? ''; ?>" class="form-control">
            </div>
            <div class="col-md-12 col-sm-12 mb-3 form-group d-none" id="askDateWrapper">
                <label for="hired_date">Hired Date<span class="text-danger">*</span></label>
                <input type="date" name="hired_date" id="hired_date" value="<?php echo $interview_detail->hired_date ?? ''; ?>" class="form-control">
            </div>
            <div class="col-md-12 col-sm-12 mb-3 form-group d-none" id="askHiredPdfWrapper">
                <label for="hired_doc">Upload PDF<span class="text-danger">*</span></label>
                <input type="file" name="hired_doc" id="hired_doc" class="dropify"
                        accept=".png, .jpeg, .jpg, .gif, .svg, .webp, .pdf, .doc, .docx, .xls, .xlsx"
                        data-max-file-size="5M" data-height="100">
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-success" form="interviewStatusForm">Update Status</button>
</div>
<script>
$(document).ready(function () {
    $('.dropify').dropify();
    // Existing remark from backend (edit case)
    const existingRemark = "<?php echo trim($interview_detail->remarks ?? ''); ?>";

    // Mapping of status → allowed remarks
    const remarkOptions = {
        "Rejected": ["Salary", "Other", "Relocation"],
        "Qiwa Rejected": ["Employer Rejected", "Legal Issue", "Other Offer"],
        "Resend Qiwa": ["Expired"]
    };

    /**
     * Reset Remarks dropdown
     */
    function resetRemarks() {
        $('#remarks')
            .html('<option value="">-- Select Remarks --</option>')
            .prop('required', false)
            .val('');
    }

    /**
     * Handle status change logic
     */
    function handleStatusChange(isInitialLoad = false) {

        const status = $('#manage_status').val();

        // Hide everything by default
        resetRemarks();
        $('#remarks').closest('.form-group').hide();
        $('#askDateWrapper').addClass('d-none');
        $('#hired_date').prop('required', false);
        $('#qiwaDateWrapper').addClass('d-none');
        $('#qiwa_request_date').prop('required', false);

        // ----- Remarks Handling -----
        if (remarkOptions[status]) {

            $('#remarks').closest('.form-group').show();
            $('#remarks').prop('required', true);

            remarkOptions[status].forEach(function (item) {
                const selected = (isInitialLoad && item === existingRemark) ? 'selected' : '';
                $('#remarks').append(
                    `<option value="${item}" ${selected}>${item}</option>`
                );
            });
        }

        // ----- Qiwa Requested Date Handling -----
        if (status === 'Qiwa Requested') {
            $('#qiwaDateWrapper').removeClass('d-none');
            $('#qiwa_request_date').prop('required', true);
        }
        // ----- Hired Date Handling -----
        if (status === 'Hired') {
            $('#askDateWrapper').removeClass('d-none');
            $('#hired_date').prop('required', true);

            $('#askHiredPdfWrapper').removeClass('d-none');
            $('#hired_doc').prop('required', true);
        } else {
            $('#askHiredPdfWrapper').addClass('d-none');
            $('#hired_doc').prop('required', false).val('');
        }

    }

    // Status dropdown change
    $('#manage_status').on('change', function () {
        handleStatusChange(false);
    });

    // Initial load (edit case)
    handleStatusChange(true);

    // -----------------------------
    // AJAX Form Submission
    // -----------------------------
    $('#interviewStatusForm').on('submit', function (e) {
        e.preventDefault();

        const form = this;
        const formData = new FormData(form);

        // Extra safety: enforce file on Hired
        if ($('#manage_status').val() === 'Hired' && !$('#hired_doc').val()) {
            toastr.error('Please upload the hired document.');
            return false;
        }

        $.ajax({
            url: '<?php echo base_url("admin/hr/recruitment/interview/status-update"); ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            processData: false, // REQUIRED
            contentType: false, // REQUIRED
            success: function (response) {
                if (response.type === 'success') {
                    toastr.success(response.message);
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function () {
                toastr.error('An error occurred. Please try again.');
            }
        });
    });
});
</script>

