<div class="size-inner-section px-1 py-1 mx-1">
    <div class="card-header"> Vehicle Detail</div>
    <div class="d-flex align-items-center vehicle-detail">
        <div class="p-3 w-100">
            <table>
                <tr>
                    <td>Vehicle No.</td>
                    <td>&nbsp; : &nbsp;</td>
                    <td><?php echo $vehicle_detail['vehicle_no'];?> - <?php echo ucfirst($vehicle_detail['vehicle_type']);?></td>
                </tr>
                <tr>
                    <td>Vehicle Model</td>
                    <td>&nbsp; : &nbsp;</td>
                    <td><?php echo $vehicle_detail['vehicle_model'];?> / <?php echo $vehicle_detail['make_name'];?> / <?php echo ucfirst($vehicle_detail['color_name']);?></td>
                </tr>
                <tr>
                    <td>Chassis Number</td>
                    <td>&nbsp; : &nbsp;</td>
                    <td><?php echo (!empty($vehicle_detail['chassis_no'])) ? $vehicle_detail['chassis_no'] : 'NA';?></td>
                </tr>
                <tr>
                    <td>Sequel No</td>
                    <td>&nbsp; : &nbsp;</td>
                    <td><?php echo $vehicle_detail['sequel_no'];?></td>
                </tr>
                <tr>
                    <td>Vehicle Ownership</td>
                    <td>&nbsp; : &nbsp;</td>
                    <td><?php if(!empty($vehicle_detail['vehicle_ownership'])){ echo $vehicle_detail['vehicle_ownership'];}else{ echo 'NA';}?></td>
                </tr>
                <tr>
                    <td>Owner Name</td>
                    <td>&nbsp; : &nbsp;</td>
                    <td><?php if(!empty($vehicle_detail['owner_name_select'])){ echo $vehicle_detail['owner_name_select'];}else{ echo 'NA';}?></td>
                </tr>
                <tr>
                    <td>Gasoline Chip</td>
                    <td>&nbsp; : &nbsp;</td>
                    <td><?php if(($vehicle_detail['gasoline_chip_status'] == 'on')){ echo 'Yes'; }else{ echo 'No'; }?></td>
                </tr>
                <tr>
                    <td>GPS Tracking</td>
                    <td>&nbsp; : &nbsp;</td>
                    <td><?php echo (!empty($vehicle_detail['gps_device_serial'])) ? '<span class="text-success">Yes</span>' : '<span class="text-danger">No</span>';?></td>
                </tr>
                <tr>
                    <td>Last Meter Reading</td>
                    <td>&nbsp; : &nbsp;</td>
                    <td><?php if(!empty($last_meter_reading['meter_reading'])){ echo $last_meter_reading['meter_reading'];}else{ echo 'NA';}?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<?php
    $vehicle_gasoline_chip_status = ($vehicle_detail['gasoline_chip_status'] == 'on') ? true : false;
    $vehicle_insurance_status = ($vehicle_detail['insurance_no'] == NULL || $vehicle_detail['insurance_no'] == '') ? false : true;
    $vehicle_registration_status = ($vehicle_detail['registration_certificate'] == '' || $vehicle_detail['registration_certificate'] == NULL) ? false : true;
?>
<?php if($vehicle_gasoline_chip_status == true && $vehicle_insurance_status == true && $vehicle_registration_status == true){ ?>
<div class="row tab-inner-section m-2 py-2">
    <h4 class="header-title">Vehicle Allotment Details</h4><hr>
    <div class="col-md-6 col-sm-12 mb-2 form-group">
        <label for="request_date">Request Date<span class="text-danger">*</span></label>
        <input type="date" class="form-control" id="request_date" name="request_date" max="<?php echo date('Y-m-d'); ?>" required />
    </div>
    <div class="col-md-6 col-sm-12 mb-2 form-group">
        <label for="meter_reading">Meter Reading<span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="meter_reading" name="meter_reading" required />
        <input type="hidden" id="previous_meter" value="<?= $last_meter_reading['meter_reading'] ?? 0 ?>">
    </div>
</div>
<div class="row tab-inner-section m-2 py-2">
    <h4 class="header-title">Uploads Documents</h4><hr>
    <div class="col-md-12 col-sm-12 form-group mb-2">
        <label for="vehicle_front_photo">Upload Vehicle Front Photo</label>
        <input type="file" name="vehicle_front_photo" id="vehicle_front_photo" class="dropify"
            accept=".png, .jpeg, .jpg, .gif, .svg, .webp, .pdf, .doc, .docx, .xls, .xlsx"
            data-max-file-size="2M" data-height="100">
    </div>
    <div class="col-md-12 col-sm-12 form-group mb-2">
        <label for="vehicle_back_photo">Upload Vehicle Back Photo</label>
        <input type="file" name="vehicle_back_photo" id="vehicle_back_photo" class="dropify"
            accept=".png, .jpeg, .jpg, .gif, .svg, .webp, .pdf, .doc, .docx, .xls, .xlsx"
            data-max-file-size="2M" data-height="100">
    </div>
    <div class="col-md-12 col-sm-12 form-group mb-2">
        <label for="vehicle_right_photo">Upload Vehicle Right Photo</label>
        <input type="file" name="vehicle_right_photo" id="vehicle_right_photo" class="dropify"
            accept=".png, .jpeg, .jpg, .gif, .svg, .webp, .pdf, .doc, .docx, .xls, .xlsx"
            data-max-file-size="2M" data-height="100">
    </div>
    <div class="col-md-12 col-sm-12 form-group mb-2">
        <label for="vehicle_left_photo">Upload Vehicle Left Photo</label>
        <input type="file" name="vehicle_left_photo" id="vehicle_left_photo" class="dropify"
            accept=".png, .jpeg, .jpg, .gif, .svg, .webp, .pdf, .doc, .docx, .xls, .xlsx"
            data-max-file-size="2M" data-height="100">
    </div>
    <div class="col-md-12 col-sm-12 form-group mb-2">
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

<script> 
$(document).on('blur', '#meter_reading', function () {
    let previous = parseFloat($('#previous_meter').val());
    let current = parseFloat($(this).val());

    if (current < previous) {
        toastr.error('Meter reading must be greater than or equal to the previous meter reading.');
    }
});

$(document).ready(function () {
	$('.dropify').dropify();
	function checkRequiredInputs() {
		let allFilled = true;
		
		// Check all required inputs except OTP
		$('#request_form [required]').not('#otp').each(function () {
			if (!$(this).val().trim()) {
				allFilled = false;
				return false; // Exit loop early if any field is empty
			}
		});

		// Enable or disable the OTP buttons based on input validation
		$('#send_otp').prop('disabled', !allFilled);
	}

	// Run validation check on input change
	$('#request_form input, #request_form select').on('input change', checkRequiredInputs);

	// Initial check in case some fields are pre-filled
	checkRequiredInputs();
});

let otpSent = false;
let resendTimeout;

function sendOtp() {
	if (!otpSent) {
		let selectedEmployeeId = $('#allotment_employee_id').val();
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
	let selectedEmployeeId = $('#allotment_employee_id').val();
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
	let selectedEmployeeId = $('#allotment_employee_id').val();
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
    <div class="row tab-inner-section m-2 py-2">
        <?php if($vehicle_gasoline_chip_status == false){ ?>
        <div class="col-md-12 col-sm-12 mb-2 form-group px-2">
            <div class="alert alert-warning mb-0" role="alert">
                <strong>Warning!</strong> Gasoline chip is not available for this vehicle.
            </div>
        </div>
        <?php } ?>
        <?php if($vehicle_insurance_status == false){ ?>
            <div class="col-md-12 col-sm-12 mb-2 form-group px-2">
                <div class="alert alert-warning mb-0" role="alert">
                    <strong>Warning!</strong> Insurance detail is not available for this vehicle.
                </div>
            </div>
        <?php } ?>
        <?php if($vehicle_registration_status == false){ ?>
            <div class="col-md-12 col-sm-12 mb-2 form-group px-2">
                <div class="alert alert-warning mb-0" role="alert">
                    <strong>Warning!</strong> Registration certificate is not available for this vehicle.
                </div>
            </div>
        <?php } ?>

        <p class="text-danger"><i><b>*Please update the missing detail to proceed with vehicle allotment.</b></i></p>
    </div>
<?php } ?>