<style> 
.modal-body {
    padding: 0.4rem;
}
.modal-footer{
    display: none;
}
</style>
<div>
	<?php echo form_open("admin/hr/employees/save-clinical-request", array("id" => "request_form", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
		<input type="hidden" name="emp_id" value="<?php echo $emp_detail->id;?>" required />
		<input type="hidden" name="request_type" value="ClinicalVisitRequest" required />
		<!-- Tab panes -->
		<div id="ajaxRes"></div>
		<div class="row tab-inner-section m-2 py-2">
			<h4 class="header-title">Fill Visit Detail</h4><hr>
            <div class="col-md-6 col-sm-12 mb-2 form-group px-2">
                <label for="request_date">Clinical Visit Date <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="request_date" name="request_date" max="<?php echo date("Y-m-d"); ?>" required />
            </div>
			<div class="col-md-6 col-sm-12 mb-2 form-group px-2">
				<label for="visit_type">Type of Visit <span class="text-danger">*</span></label>
				<select class="form-control form-select" data-parsley-allselected="true" name="visit_type" id="visit_type" required>
					<option value="">Select Visit Type</option>
					<option value="Accident Follow-up">Accident Follow-up</option>
					<option value="Emergency">Emergency</option>
					<option value="Sickness">Sickness</option>
				</select>
			</div>
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
		<div class="row tab-inner-section m-2 py-2">
			<h4 class="header-title">Request Verification</h4><hr>
			<!-- OTP Section -->
            <div class="col-md-12 col-sm-12 form-group mb-2">
                <div class="input-group">
                    <input type="text" class="form-control" id="otp" name="otp" placeholder="Enter OTP" aria-label="Enter OTP" maxlength="6" required />
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary" type="button" id="send_otp" onclick="sendOtp()" disabled>Send OTP</button>
                        <button class="btn btn-outline-secondary" type="button" id="resend_otp" onclick="resendOtp()" disabled>Resend OTP</button>
                    </div>
                </div>
            </div>
		</div>
	<?php echo form_close(); ?>
</div>
<script type="text/javascript">
	$(document).ready(function() {
        $('.dropify').dropify();
        const $requestDateInput = $('#request_date');

        // Get today's date
        const today = new Date();
        const tomorrow = new Date(today);
        const twoDaysLater = new Date(today);
        const threeDaysLater = new Date(today);

        // Increment dates
        tomorrow.setDate(today.getDate() + 1);
        twoDaysLater.setDate(today.getDate() + 2);
        threeDaysLater.setDate(today.getDate() + 3);

        // Format dates as YYYY-MM-DD
        function formatDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        // Set min and max attributes dynamically
        $requestDateInput.attr('min', formatDate(tomorrow));
        $requestDateInput.attr('max', formatDate(threeDaysLater));
    });

    $('#request_date').on('change', function () {
        const selectedDate = $(this).val();

        if (!selectedDate) {
            toastr.error('Please select a valid date.');
            return;
        }

        // AJAX request to check slot availability
        $.ajax({
            url: "<?php echo base_url('admin/hr/employees/check-slot-availability'); ?>",
            type: "POST",
            data: { request_date: selectedDate },
            dataType: "json",
            success: function (response) {
                if (response.type === "error") {
                    toastr.error(response.message);
                    // Disable the submit button to prevent form submission
                    $('#send_otp').prop('disabled', true);
                    $('#resend_otp').prop('disabled', true);
                    $('#request_form button[type="submit"]').prop('disabled', true);
                } else if (response.type === "success") {
                    toastr.success(response.message);
                    // Enable the submit button if slots are available
                    $('#send_otp').prop('disabled', false);
                    $('#resend_otp').prop('disabled', false);
                    $('#request_form button[type="submit"]').prop('disabled', false);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", xhr.responseText, status, error);
                toastr.error('An unexpected error occurred. Please try again.');
            },
        });
    });

	$(document).ready(function () {
		$("#request_form").on("submit", function (e) {
			e.preventDefault();
			var formData = new FormData(this); 
			$.ajax({
				url: "<?php echo site_url('admin/hr/employees/save-clinical-request'); ?>",
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
<script>
    let otpSent = false;
    let resendTimeout;

    function sendOtp() {
        if (!otpSent) {
            $.ajax({
                url: "<?php echo base_url('admin/hr/employees/clinical-request/send-otp'); ?>",
                method: "POST",
                data: { emp_id: "<?php echo $emp_detail->id; ?>" },
                success: function(response) {
                    try {
                        if (typeof response === "string") {
                            response = JSON.parse(response);
                        }

                        if (response.type === 'success') {
                            toastr.success(response.message);
                            otpSent = true;

                            // Replace "Send OTP" button with "Verify OTP" button
                            $('#send_otp')
                                .text("Verify OTP")
                                .removeClass("btn-outline-primary")
                                .addClass("btn-outline-success")
                                .attr("onclick", "verifyOtp()");

                            $('#resend_otp').prop('disabled', false);
                            startResendCooldown();
                        } else {
                            toastr.error(response.message || 'Unable to send OTP.');
                        }
                    } catch (error) {
                        console.error('Error parsing response:', error);
                        toastr.error('Invalid server response.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    toastr.error('Failed to send OTP. Please try again.');
                }
            });
        }
    }

    function resendOtp() {
        if (otpSent) {
            $.ajax({
                url: "<?php echo base_url('admin/hr/employees/clinical-request/resend-otp'); ?>",
                method: "POST",
                data: { emp_id: "<?php echo $emp_detail->id; ?>" },
                success: function(response) {
                    try {
                        if (typeof response === "string") {
                            response = JSON.parse(response);
                        }

                        if (response.type === 'success') {
                            toastr.success(response.message);
                            startResendCooldown();
                        } else {
                            toastr.error(response.message || 'Unable to fetch details.');
                        }
                    } catch (error) {
                        console.error('Error parsing response:', error);
                        toastr.error('Invalid server response.');
                    }
                },
                error: function() {
                    toastr.error('Failed to resend OTP. Please try again.');
                }
            });
        }
    }

    function verifyOtp() {
        const otp = $('#otp').val();
        if (!otp) {
            toastr.error('Please enter the OTP.');
            return;
        }
        $.ajax({
            url: "<?php echo base_url('admin/hr/employees/clinical-request/verify-otp'); ?>",
            method: "POST",
            data: { otp: otp },
            success: function(response) {
                try {
                    if (typeof response === "string") {
                        response = JSON.parse(response);
                    }

                    if (response.type === 'success') {
                        $('#otp').attr('readonly', true);
                        toastr.success(response.message);
                        $('.modal-footer').show();
                        $('#send_otp').prop('disabled', true);
                        $('#resend_otp').prop('disabled', true);
                    } else {
                        toastr.error(response.message || 'Unable to fetch details.');
                    }
                } catch (error) {
                    console.error('Error parsing response:', error);
                    toastr.error('Invalid server response.');
                }
            },
            error: function() {
                alert("Failed to verify OTP. Please try again.");
            }
        });
    }

    function startResendCooldown() {
        // Disable resend button for 30 seconds
        $('#resend_otp').prop('disabled', true);
        let timer = 30;
        resendTimeout = setInterval(() => {
            if (timer <= 0) {
                clearInterval(resendTimeout);
                $('#resend_otp').prop('disabled', false);
                $('#resend_otp').text("Resend OTP");
            } else {
                $('#resend_otp').text(`Resend OTP (${timer}s)`);
                timer--;
            }
        }, 1000);
    }
    
</script>