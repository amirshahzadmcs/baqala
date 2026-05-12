<div class="size-inner-section px-1 py-1 mx-1">
    <div class="card-header">Rider Detail</div>
    <div class="d-flex align-items-center employee-detail">
        <div class="image">
			<?php if(!empty($emp_detail['employee_pic']) && $emp_detail['employee_pic'] !== ''){ ?>
				<img src="<?php echo $emp_detail['employee_pic'];?>" class="rounded" width="140">
			<?php }else{ ?>
				<img src="<?php echo base_url('images/user-img.png'); ?>" class="rounded" width="140">
			<?php } ?>
        </div>
        <div class="p-3 w-100">
            <h5 class="mb-0 mt-0"> <?php echo $emp_detail['full_name'];?> / <?php echo $emp_detail['employee_arabic_name'];?> </h5>
            <span><?php echo $emp_detail['designation_name'];?> | <?php echo $emp_detail['department_name'];?></span>
            <hr class="my-1">
            <table>
                <tr>
                    <td>Emp No.</td>
                    <td> : </td>
                    <td><?php echo $emp_detail['emp_no'];?></td>
                </tr>
				<tr>
                    <td>Nationality</td>
                    <td> : </td>
                    <td><?php echo $emp_detail['nationality_name'];?></td>
                </tr>
                <tr>
                    <td>Flex Number</td>
                    <td> : </td>
                    <td><?php echo (!empty($sim_detail['mobile'])) ? $sim_detail['mobile'] : 'NA';?></td>
                </tr>
                <tr>
                    <td>Mobile No</td>
                    <td> : </td>
                    <td><?php echo $emp_detail['mobile'];?></td>
                </tr>
				<tr>
                    <td>DL Number</td>
                    <td> : </td>
                    <td><?php if(!empty($other_detail['driving_license_number'])){ echo $other_detail['driving_license_number'];}else{ echo 'NA';}?></td>
                </tr>
                <tr>
                    <td>Vehicle No</td>
                    <td> : </td>
                    <td><?php if(!empty($vehicle_detail['vehicle_no'])){ echo $vehicle_detail['vehicle_no'];?> / <?php echo $vehicle_detail['vehicle_model'];?> / <?php echo $vehicle_detail['make_name'];?> <?php echo ($vehicle_detail['vehicle_type'] == 'bike') ? '<i class="fas fa-motorcycle"></i>' : '<i class="mdi mdi-car"></i>';}else{ echo 'NA';}?></td>
                </tr>
				<tr>
                    <td>GPS Tracking</td>
                    <td> : </td>
                    <td><?php echo (!empty($vehicle_detail['gps_device_serial'])) ? '<span class="text-success">Yes</span>' : '<span class="text-danger">No</span>';?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="row p-2">
    <?php if(!empty($total_outstanding)): ?>
        <?php foreach($total_outstanding as $record): ?>
            <div class="col-md-12">
				<?php echo form_open("admin/logistic-management/cash-collection/submit", array("id" => "cashCollectionForm_" . $record->id, "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
					<div class="card border border-secondary shadow-md">
						<div class="card-header">
							COD Date: <?= date('d-m-Y', strtotime($record->order_date)) ?>
						</div>
						<div class="card-body p-3">
							<input type="hidden" name="record_id" value="<?= $record->id ?>" required />
							<input type="hidden" name="rider_id" value="<?php echo $emp_detail['id'];?>" required />
							<input type="hidden" name="employee_id" value="<?php echo $emp_detail['employee_id'];?>" required />
							<input type="hidden" name="vehicle_id" value="<?php echo $vehicle_detail['id'];?>" required />
							<input type="hidden" name="due_amount" value="<?= number_format($record->cash_collection, 2) ?>" required />
							<input type="hidden" name="transaction_date" value="<?= date('Y-m-d') ?>" required />
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Jahez ID</label>
										<p class="form-control no-action-input"><?= $record->driver_id ?></p>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>COD Amount</label>
										<p class="form-control no-action-input"><?= number_format($record->cash_collection, 2) ?></p>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="amount_collected">Amount Collected <span class="text-danger">*</span></label>
										<input type="text" class="form-control input-mask text-left amount_collected" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" name="amount_collected" data-cod="<?= $record->cash_collection ?>" required />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="outstanding_amount">Outstanding Amount</label>
										<input type="text" class="form-control input-mask text-left outstanding_amount" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" name="outstanding_amount" readonly />
									</div>
								</div>
								<div id="otpContainer"></div>
							</div>
						</div>
						<div class="card-footer text-end">
							<button type="button" class="btn btn-custom-success btn-sm generateOtpBtn" onclick="generateOtpButton('cashCollectionForm_<?= $record->id ?>')" disabled>Generate OTP</button>
						</div>
					</div>
				<?php echo form_close(); ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12 text-center">
            <p class="text-muted">No pending cash collection found.</p>
        </div>
    <?php endif; ?>
</div>

<script>
	$(document).ready(function(){
		$('.dropify').dropify();
		$(".input-mask").inputmask();
		$(document).on("input", ".amount_collected", function () {
			let $this = $(this);
			let collected = parseFloat($this.val()) || 0;
			let cod = parseFloat($this.data("cod")) || 0;
			let outstanding = cod - collected;

			// Remove old warning if exists
			$this.siblings(".warning-text").remove();

			let btn = $this.closest(".card").find(".generateOtpBtn");

			if (collected > cod) {
				// Show red warning
				$this.after('<small class="text-danger warning-text">Collected amount cannot be greater than COD (' + cod.toFixed(2) + ')</small>');

				// Disable OTP button
				btn.prop("disabled", true);

				// Set outstanding to 0 for now
				$this.closest(".card-body")
					.find(".outstanding_amount")
					.val('0.00');

			} else if (collected > 0 && collected <= cod) {
				// Valid input
				$this.closest(".card-body")
					.find(".outstanding_amount")
					.val(outstanding.toFixed(2));

				btn.prop("disabled", false);
			} else {
				// Empty or zero
				$this.closest(".card-body")
					.find(".outstanding_amount")
					.val(cod.toFixed(2));
				btn.prop("disabled", true);
			}
		});

	});

	function generateOtpButton(formId) {
		var formData = new FormData(document.getElementById(formId));

		$.ajax({
			url: '<?php echo site_url('admin/logistic-management/cash-collection/generate-otp'); ?>',
			type: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			dataType: 'json',
			success: function(response) {
				if (response.type === 'success') {
					$('#responseContainer').html(`
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							${response.message}
						</div>
					`);

					// OTP field goes inside the same card-body
					$('#' + formId + ' #otpContainer').html(`
						<div class="row mt-2">
							<div class="form-group">
								<label for="otp">Enter OTP <span class="text-danger">*</span></label>
								<input type="text" class="form-control" id="otp_${formId}" name="otp" maxlength="6" required />
							</div>
						</div>
					`);

					// ✅ Replace Generate OTP button with Submit button in card-footer
					$('#' + formId + ' .card-footer').html(`
						<button type="submit" form="${formId}" class="btn btn-custom-success btn-sm">Submit</button>
					`);

				} else {
					$('#responseContainer').html(`
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							${response.message}
						</div>
					`);
				}
			},
			error: function(xhr, status, error) {
				$('#responseContainer').html(`
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						An error occurred: ${error}
					</div>
				`);
			}
		});
	}

	$(document).ready(function() {
		// Attach submit handler to all cashCollectionForm_* forms
		$(document).on("submit", "form[id^='cashCollectionForm_']", function(e) {
			e.preventDefault();

			let $form = $(this);
			let formData = new FormData(this);

			// Find the submit button inside this form's card-footer
			let $submitBtn = $form.find("button[type='submit']");

			// Disable button and show 'Saving...'
			$submitBtn.prop("disabled", true).text("Saving...");

			$.ajax({
				url: '<?php echo base_url('admin/logistic-management/cash-collection/submit');?>',
				type: 'POST',
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				success: function(response) {
					if (response.type === 'success') {
						$('#responseContainer').html(
							'<div class="alert alert-success alert-dismissible fade show" role="alert">' +
							'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
							response.message +
							'</div>'
						);

						// Reset that specific form
						$form[0].reset();

						// Re-initialize DataTable or reload data
						initializeDataTable();

						// Close modal if required
						$('#addCashModal').modal('hide');
					} else {
						$('#responseContainer').html(
							'<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
							'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
							response.message +
							'</div>'
						);
					}
				},
				error: function() {
					$('#responseContainer').html(
						'<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
						'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
						'An error occurred. Please try again.' +
						'</div>'
					);
				},
				complete: function() {
					// Re-enable button and restore text
					$submitBtn.prop("disabled", false).text("Submit");
				}
			});
		});
	});


</script>
