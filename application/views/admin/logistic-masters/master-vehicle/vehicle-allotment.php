<!-- /.modal-content -->

<?php if($type == 'alloted'){ ?>
	<style> 
		.modal-body {
			padding: 0.4rem;
		}
		.modal-footer{
			display: none;
		}
        .select2-container--disabled .select2-selection {
            background-color: #e9ecef !important; /* Grey background */
            cursor: not-allowed !important;
        }
	</style>
	<div class="modal-header">
		<h6 class="modal-title mt-0" id="allotModalFullscreenLabel">Vehicle Allotment</h6>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	</div>
	<div class="modal-body" id="allot_body_modal">
		<div class="row tab-inner-section m-2 py-2">
			<h4 class="header-title">Vehicle Information</h4><hr>
			<div class="col-md-6"><h6>Vehicle Number: <span class="text-primary"><?php echo $vehicle_detail->vehicle_no;?></span></h6></div>
			<div class="col-md-6"><h6>Vehicle Type: <span class="text-primary"><?php echo ucfirst($vehicle_detail->vehicle_type);?></span></h6></div>
			<div class="col-md-6"><h6>Vehicle Model: <span class="text-primary"><?php echo $vehicle_detail->vehicle_model;?></span></h6></div>
		</div>
		<form id="allotment_form" action="<?php echo base_url('admin/master-vehicle/save-allotment'); ?>" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="vehicle_id" value="<?php echo $id;?>" required>
			<input type="hidden" name="type" value="<?php echo $type;?>" required>
			<input type="hidden" name="allotment_status" value="<?php echo $type;?>" required>
			<div class="row tab-inner-section m-2 py-2">
				<h4 class="header-title">Fill Allotment Detail</h4><hr>
				<div class="form-group col-lg-12 col-sm-6 mb-3">
					<label for="alloted_user">Select Rider/Driver<span class="text-danger">*</span></label>
					<select name="alloted_user" id="alloted_user" class="form-select select2" required>
						<option value="">Select Rider/Driver</option>
						<?php if(count($employee_list) > 0){ foreach($employee_list as $emp_list){ ?>
						<option value="<?php echo $emp_list['id']; ?>"><?php echo $emp_list['emp_no']; ?> - <?php echo $emp_list['full_name']; ?> (<?php echo $emp_list['pos_name']; ?>)</option>
						<?php }}else{ echo '<option value="">No unalloted employee, add new employee first</option>';} ?>
					</select>
				</div>
				<div class="col-md-12 col-sm-12 mb-3 form-group">
					<label for="status_date">Date of <?php echo ucfirst($type);?><span class="text-danger">*</span></label>
					<input type="date" class="form-control" id="status_date" name="status_date" max="<?php echo date('Y-m-d'); ?>" required />
					<small class="hint">Enter date of <?php echo $type;?> of vehicle</small>
				</div>
				<div class="col-md-12 col-sm-12 mb-3 form-group">
					<label for="meter_reading">Meter Reading<span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="meter_reading" name="meter_reading" required />
					<small class="hint">Enter meter reading of vehicle</small>
				</div>
                
				<div class="col-md-12 col-sm-12 mb-3 form-group">
					<label for="remarks">Remarks (If any)</label>
					<input type="text" class="form-control" id="remarks" name="remarks" />
					<small class="hint">Enter remarks</small>
				</div>
                <div class="col-md-12 col-sm-12 form-group mb-3">
                    <label for="tamm_attachment">Tamm Authorization</label>
                    <input type="file" name="tamm_attachment" id="tamm_attachment" class="dropify"
                        accept=".png, .jpeg, .jpg, .gif, .svg, .webp, .pdf, .doc, .docx, .xls, .xlsx"
                        data-max-file-size="2M" data-height="100">
                </div>
			</div>

			<div class="row tab-inner-section m-2 py-2">
				<h4 class="header-title">Allotment Verification</h4><hr>
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
		</form>
	</div>
	<div class="modal-footer">
		<div class="row">
			<div class="col-md-12">
				<button form="allotment_form" type="submit" class="btn btn-success btn-md">Save</button>
				<button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-outline-danger btn-md ms-2">Cancel </button>
			</div>
		</div>
	</div>

    <script> 
        $(document).ready(function () {
            $('.dropify').dropify();
            function checkRequiredInputs() {
                let allFilled = true;
                
                // Check all required inputs except OTP
                $('#allotment_form [required]').not('#otp').each(function () {
                    if (!$(this).val().trim()) {
                        allFilled = false;
                        return false; // Exit loop early if any field is empty
                    }
                });

                // Enable or disable the OTP buttons based on input validation
                $('#send_otp, #resend_otp').prop('disabled', !allFilled);
            }

            // Run validation check on input change
            $('#allotment_form input, #allotment_form select').on('input change', checkRequiredInputs);

            // Initial check in case some fields are pre-filled
            checkRequiredInputs();
        });

        let otpSent = false;
        let resendTimeout;

        function sendOtp() {
            if (!otpSent) {
                let selectedEmployeeId = $('#alloted_user').val();
                if (!selectedEmployeeId) {
                    toastr.error('Please select an employee.');
                    return;
                }

                // Show loader & disable button
                $('#send_otp')
                    .prop('disabled', true)
                    .html('<span class="spinner-border spinner-border-sm"></span> Sending OTP...');

                $.ajax({
                    url: "<?php echo base_url('admin/master-vehicle/send-otp'); ?>",
                    method: "POST",
                    data: { emp_id: selectedEmployeeId },
                    success: function(response) {
                        try {
                            if (typeof response === "string") {
                                response = JSON.parse(response);
                            }

                            if (response.type === 'success') {
                                toastr.success(response.message);
                                otpSent = true;

                                // Prevent changing the select2 field
                                $('#alloted_user').on('select2:opening', function (e) {
                                    e.preventDefault();
                                });

                                // Replace "Send OTP" button with "Verify OTP" button
                                $('#send_otp')
                                    .text("Verify OTP")
                                    .removeClass("btn-outline-primary")
                                    .addClass("btn-outline-success")
                                    .attr("onclick", "verifyOtp()")
                                    .prop('disabled', false);

                                $('#resend_otp').prop('disabled', false);
                                startResendCooldown();
                            } else {
                                toastr.error(response.message || 'Unable to send OTP.');
                                $('#send_otp').text("Send OTP").prop('disabled', false);
                            }
                        } catch (error) {
                            console.error('Error parsing response:', error);
                            toastr.error('Invalid server response.');
                            $('#send_otp').text("Send OTP").prop('disabled', false);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                        toastr.error('Failed to send OTP. Please try again.');
                        $('#send_otp').text("Send OTP").prop('disabled', false);
                    }
                });
            }
        }

        function resendOtp() {
            let selectedEmployeeId = $('#alloted_user').val();
            if (!selectedEmployeeId) {
                toastr.error('Please select an employee.');
                return;
            }
            if (otpSent) {
                $.ajax({
                    url: "<?php echo base_url('admin/master-vehicle/re-send-otp'); ?>",
                    method: "POST",
                    data: { emp_id: selectedEmployeeId },
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
            let selectedEmployeeId = $('#alloted_user').val();
            if (!selectedEmployeeId) {
                toastr.error('Please select an employee.');
                return;
            }

            // Show loader & disable button
            $('#send_otp')
                .prop('disabled', true)
                .html('<span class="spinner-border spinner-border-sm"></span> Verifying...');

            $.ajax({
                url: "<?php echo base_url('admin/master-vehicle/verify-otp'); ?>",
                method: "POST",
                data: { 
                    otp: otp,
                    emp_id: selectedEmployeeId
                },
                success: function(response) {
                    try {
                        if (typeof response === "string") {
                            response = JSON.parse(response);
                        }

                        if (response.type === 'success') {
                            $('#otp').attr('readonly', true);
                            toastr.success(response.message);
                            $('.modal-footer').show();
                            $('#send_otp').prop('disabled', true).text("OTP Verified");
                            $('#resend_otp').prop('disabled', true);

                            // Disable select2 dropdown to prevent changes
                            $('#alloted_user').on('select2:opening', function (e) {
                                e.preventDefault();
                            });
                        } else {
                            toastr.error(response.message || 'Unable to verify OTP.');
                            $('#send_otp').text("Verify OTP").prop('disabled', false);
                        }
                    } catch (error) {
                        console.error('Error parsing response:', error);
                        toastr.error('Invalid server response.');
                        $('#send_otp').text("Verify OTP").prop('disabled', false);
                    }
                },
                error: function() {
                    alert("Failed to verify OTP. Please try again.");
                    $('#send_otp').text("Verify OTP").prop('disabled', false);
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
<?php }else{ ?>
	<div class="modal-header">
		<h6 class="modal-title mt-0" id="allotModalFullscreenLabel">Vehicle <?= ($type == 'return') ? 'Return' : 'Un-Allotment';?></h6>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	</div>
	<div class="modal-body" id="allot_body_modal">
		<form id="allotment_form" action="<?php echo base_url('admin/master-vehicle/save-allotment'); ?>" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="vehicle_id" value="<?php echo $id;?>" required>
			<input type="hidden" name="type" value="<?php echo $type;?>" required>
			<input type="hidden" name="allotment_status" value="<?php echo $type;?>" required>
			<input type="hidden" name="alloted_user" value="<?php echo $vehicle_detail->alloted_user;?>" required>
			<div class="row tab-inner-section m-2 py-2">
				<h4 class="header-title">Fill <?= ($type == 'return') ? 'Return' : 'Un-Allotment';?> Detail</h4><hr>
				<div class="col-md-12 col-sm-12 mb-3 form-group">
					<label for="status_date">Date of <?php echo ucfirst($type);?><span class="text-danger">*</span></label>
					<input type="date" class="form-control" id="status_date" name="status_date" max="<?php echo date('Y-m-d'); ?>" required />
					<small class="hint">Enter date of <?php echo $type;?> of vehicle</small>
				</div>
				<div class="col-md-12 col-sm-12 mb-3 form-group">
					<label for="meter_reading">Meter Reading<span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="meter_reading" name="meter_reading" required />
					<small class="hint">Enter meter reading of vehicle</small>
				</div>
				<?php if($type == 'return'){ ?>
                <div class="col-md-12 col-sm-12 mb-3 form-group">
					<label for="location">Parking Location<span class="text-danger">*</span></label>
                    <select name="location" id="location" class="form-select select2" required>
						<option value="">Select Parking Location</option>
						<?php if(masterParkingHelper()){ foreach(masterParkingHelper() as $loc_list){ ?>
						<option value="<?php echo $loc_list->id; ?>"><?php echo $loc_list->parking_name; ?></option>
						<?php }}else{ echo '<option value="">No parking available, add new parking first</option>';} ?>
					</select>
					<small class="hint">Select parking location of vehicle</small>
				</div>
                <?php } ?>
                <div class="col-md-12 col-sm-12 form-group mb-3">
                    <label for="tamm_attachment">Tamm Cancelled Authorization</label>
                    <input type="file" name="tamm_attachment" id="tamm_attachment" class="dropify"
                        accept=".png, .jpeg, .jpg, .gif, .svg, .webp, .pdf, .doc, .docx, .xls, .xlsx"
                        data-max-file-size="2M" data-height="100">
                </div>
				<div class="col-md-12 col-sm-12 mb-3 form-group">
					<label for="remarks">Remarks (If any)</label>
					<input type="text" class="form-control" id="remarks" name="remarks" />
					<small class="hint">Enter remarks</small>
				</div>
			</div>
		</form>
	</div>
	<div class="modal-footer">
		<div class="row">
			<div class="col-md-12">
				<button form="allotment_form" type="submit" id="submitBtn" class="btn btn-success btn-md">Save</button>
				<button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-outline-danger btn-md ms-2">Cancel </button>
			</div>
		</div>
	</div>
<?php } ?>
<script>
    $(".select2").select2();

	$(document).ready(function () {
        $('.dropify').dropify();
		$("#allotment_form").on("submit", function (e) {
            e.preventDefault();

            var $submitBtn = $("#submitBtn");
            var originalBtnHtml = $submitBtn.html();

            // Disable button and show loader
            $submitBtn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

            var formData = new FormData(this); 
            $.ajax({
                url: "<?php echo site_url('admin/master-vehicle/save-allotment'); ?>",
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
                        }, 1500);
                    } else if (response.type === "error") {
                        toastr.error(response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", xhr.responseText, status, error);
                    toastr.error('An unexpected error occurred. Please try again.');
                },
                complete: function () {
                    // Restore button
                    $submitBtn.prop("disabled", false).html(originalBtnHtml);
                }
            });
        });
	});
</script>
