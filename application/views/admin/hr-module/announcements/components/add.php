<style> 
.modal-body {
    padding: 0.4rem;
}
.tab-inner-section {
    box-shadow: 0px 1px 4px #c5c5c5;
    border-radius: 5px;
    margin-bottom: 10px;
}
</style>
<div class="modal-header">
	<h5 class="modal-title mt-0">Add Memo</h5>
	<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body px-2">
	<div>
		<?php echo form_open("admin/hr/announcements/submit", array("id" => "announcementForm", "enctype" => "multipart/form-data", "class" => "needs-validation")); ?>
			<!-- Tab panes -->
			<div id="ajaxRes"></div>
			<div class="row tab-inner-section px-1 py-1 mx-1">
				<div class="card-header mb-2">Basic Detail</div>
				<div class="col-md-12 col-sm-12 mb-2 form-group px-2">
					<label>Employees Group <span class="text-danger">*</span></label>
					<div>
						<?php
						$groups = ['all_employees' => 'All Employees', 'department' => 'By Department', 'specific_employees' => 'Specific Employees'];
						foreach ($groups as $key => $label): ?>
						<div class="form-check form-check-inline mb-1">
							<label class="form-check-label">
								<input type="radio" class="form-check-input employee-group-radio" name="employee_group" value="<?= $key ?>" required> <?= $label ?>
							</label>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="form-group px-2" id="dynamic-fields"></div>
				<div class="col-md-12 col-sm-12 mb-2 form-group px-2">
					<label>Notification Icon <span class="text-danger">*</span></label>
					<div>
						<?php
						$icons = ['info' => 'ℹ️', 'success' => '✅', 'warning' => '⚠️', 'error' => '❌'];
						foreach ($icons as $key => $label): ?>
						<div class="form-check form-check-inline mb-1">
							<label class="form-check-label"><input type="radio" class="form-check-input" name="notification_icon" value="<?= $key ?>" <?= $key === 'info' ? 'checked' : '' ?>> <?= $label ?></label>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
			<div class="row tab-inner-section px-1 py-1 mx-1 description-container">
				<div class="card-header mb-2">Memo Content <span class="text-danger">*</span></div>
				<div class="col-md-6 col-sm-12 form-group mb-2">
					<label for="title_arabic">Title Arabic <span class="text-danger">*</span></label>
					<input type="text" class="form-control rtl-input" id="title_arabic" name="title_arabic" required />
				</div>
				<div class="col-md-6 col-sm-12 form-group mb-2">
					<label for="title_english">Title English <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="title_english" name="title_english" required />
				</div>
				<div class="col-md-12 col-sm-12 form-group mb-2">
					<label for="body_arabic">Body Arabic <span class="text-danger">*</span></label>
					<textarea class="form-control rtl-input" id="body_arabic" name="body_arabic" rows="4" required></textarea>
				</div>
				<div class="col-md-12 col-sm-12 form-group mb-2">
					<label for="body_english">Body English <span class="text-danger">*</span></label>
					<textarea class="form-control" id="body_english" name="body_english" rows="4" required></textarea>
				</div>
				<div class="col-md-12 col-sm-12 form-group mb-3">
					<label for="attachment">Attachment</label>
					<input type="file" name="attachment" id="attachment" class="dropify"
						accept="image/png, image/jpeg, image/jpg, image/gif, image/svg, image/webp"
						data-max-file-size="2M" data-height="100">
				</div>
			</div>
			<div class="row tab-inner-section px-1 py-1 mx-1 description-container">
				<div class="card-header mb-2">Notify Via <span class="text-danger">*</span></div>
				<div class="col-md-12 col-sm-12 form-group mb-2">
					<div class="form-check mb-3">
						<input class="form-check-input" type="checkbox" name="send_via_email" id="send_via_email" value="1">
						<label class="form-check-label" for="send_via_email">
							Send Via Email
						</label>
					</div>
					<div class="form-check mb-3">
						<input class="form-check-input" type="checkbox" name="show_after_login" id="show_after_login" value="1">
						<label class="form-check-label" for="show_after_login">
							Show for employees after login
						</label>
					</div>
					<div class="form-check mb-3">
						<input class="form-check-input" type="checkbox" name="enable_notify_date" id="enable_notify_date" value="1">
						<label class="form-check-label" for="enable_notify_date">
							Enable Notify Date
						</label>
					</div>
					<!-- Date and Time Fields (initially hidden) -->
					<div id="notify_date_section" style="display: none; margin-top: 10px;">
						<label>Notify Date</label>
						<input type="date" name="notify_date_date" class="form-control" min="<?= date('Y-m-d');?>" style="margin-bottom: 10px;">

						<label>Notify Time</label>
						<input type="time" name="notify_date_time" class="form-control">
					</div>
				</div>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button form="announcementForm" type="submit" id="saveAnnouncementBtn" class="btn btn-custom-success">Save</button>
</div>
<script type="text/javascript">
	$(document).ready(function() {
        $('.dropify').dropify();

		function toggleNotifyFields() {
            if ($('#enable_notify_date').is(':checked')) {
                $('#notify_date_section').slideDown();
                $('#notify_date_date').attr('required', true);
                $('#notify_date_time').attr('required', true);
            } else {
                $('#notify_date_section').slideUp();
                $('#notify_date_date').removeAttr('required');
                $('#notify_date_time').removeAttr('required');
            }
        }

        // Initialize on page load
        toggleNotifyFields();

        // Toggle on checkbox change
        $('#enable_notify_date').on('change', toggleNotifyFields);
    });

	$(document).ready(function () {
		$('input[name="employee_group"]').on('change', function () {
			const selected = $(this).val();
			const $container = $('#dynamic-fields');
			$container.empty(); // Clear previous content

			if (selected === 'department') {
				$container.append(`
					<div class="form-group mt-2 mb-3">
						<label>Select Department <span class="text-danger">*</span></label>
						<select class="form-control select2" name="group_detail[]" data-placeholder="Select Department" multiple required>
							<option value="">-- Select Department --</option>
							<?php foreach (masterDepartments() as $d): ?>
								<option value="<?= $d->id ?>"><?= $d->name ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				`);
			}

			if (selected === 'specific_employees') {
				$container.append(`
					<div class="form-group mt-2 mb-3">
						<label>Select Employees <span class="text-danger">*</span></label>
						<select class="form-control select2" name="group_detail[]" data-placeholder="Select Employees" multiple required>
							<option value="">-- Select Employees --</option>
							<?php foreach (employeeListHelper() as $e): ?>
								<option value="<?= $e->id ?>"><?= $e->emp_no .'-'. $e->full_name ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				`);
			}

			// ✅ Initialize Select2 on new selects
			$('.select2').select2({
				width: '100%',
				placeholder: function(){
					return $(this).data('placeholder');
				},
				allowClear: true
			});
		});

		// Initialize Select2 on any default select2 fields on page load
		$('.select2').select2({
			width: '100%',
			placeholder: function(){
				return $(this).data('placeholder');
			},
			allowClear: true
		});
	});

	$(document).ready(function () {
		$("#announcementForm").on("submit", function (e) {
			e.preventDefault();

			// Show loader on Save button click
			$("#ajaxLoader").show();
			$("#saveAnnouncementBtn").prop("disabled", true).text("Saving...");

			var formData = new FormData(this);

			$.ajax({
				url: "<?php echo site_url('admin/hr/announcements/submit'); ?>",
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
					// Hide loader and reset button
					$("#ajaxLoader").hide();
					$("#saveAnnouncementBtn").prop("disabled", false).text("Save");
				}
			});
		});
	});

</script>
