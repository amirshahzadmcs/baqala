<?php
$group_detail = isset($announcement_detail['group_detail']) ? json_decode($announcement_detail['group_detail'], true) : [];
?>
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
	<h5 class="modal-title mt-0">Edit Memo</h5>
	<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body px-2">
	<div>
		<?php echo form_open("admin/hr/announcements/update", array("id" => "announcementForm", "enctype" => "multipart/form-data", "class" => "needs-validation")); ?>
            <input type="hidden" name="id" value="<?= $announcement_detail['id'] ?? '' ?>">
			<!-- Tab panes -->
			<div id="ajaxRes"></div>
			<div class="row tab-inner-section px-1 py-1 mx-1">
				<div class="card-header mb-2">Basic Detail</div>
				<div class="col-md-12 mb-2 form-group px-2">
					<label>Employees Group <span class="text-danger">*</span></label>
					<div>
						<?php
						$groups = ['all_employees' => 'All Employees', 'department' => 'By Department', 'specific_employees' => 'Specific Employees'];
						foreach ($groups as $key => $label): ?>
							<div class="form-check form-check-inline mb-1">
								<label class="form-check-label">
									<input type="radio" class="form-check-input employee-group-radio" name="employee_group" value="<?= $key ?>" <?= ($announcement_detail['employee_group'] ?? '') === $key ? 'checked' : '' ?>> <?= $label ?>
								</label>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="form-group px-2" id="dynamic-fields"></div>
				<div class="col-md-12 mb-2 form-group px-2">
                    <label>Notification Icon <span class="text-danger">*</span></label>
                    <div>
                        <?php
                        $icons = ['info' => 'ℹ️', 'success' => '✅', 'warning' => '⚠️', 'error' => '❌'];
                        foreach ($icons as $key => $label): ?>
                        <div class="form-check form-check-inline mb-1">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input"
                                    name="notification_icon" value="<?= $key ?>"
                                    <?= (isset($announcement_detail) && $announcement_detail['notification_icon'] === $key) || (!isset($announcement_detail) && $key === 'info') ? 'checked' : '' ?>> <?= $label ?>
                            </label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
			</div>
			<div class="row tab-inner-section px-1 py-1 mx-1 description-container">
                <div class="card-header mb-2">Memo Content <span class="text-danger">*</span></div>

                <div class="col-md-6 form-group mb-2">
                    <label for="title_arabic">Title Arabic <span class="text-danger">*</span></label>
                    <input type="text" class="form-control rtl-input" name="title_arabic"
                        value="<?= $announcement_detail['title_arabic'] ?? '' ?>" required>
                </div>

                <div class="col-md-6 form-group mb-2">
                    <label for="title_english">Title English <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="title_english"
                        value="<?= $announcement_detail['title_english'] ?? '' ?>" required>
                </div>

                <div class="col-md-12 form-group mb-2">
                    <label for="body_arabic">Body Arabic <span class="text-danger">*</span></label>
                    <textarea class="form-control rtl-input" name="body_arabic" rows="4" required><?= $announcement_detail['body_arabic'] ?? '' ?></textarea>
                </div>

                <div class="col-md-12 form-group mb-2">
                    <label for="body_english">Body English <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="body_english" rows="4" required><?= $announcement_detail['body_english'] ?? '' ?></textarea>
                </div>

                <div class="col-md-12 form-group mb-3">
                    <label for="attachment">Attachment</label>
                    <input type="file" name="attachment" id="attachment" class="dropify"
                        data-default-file="<?= isset($announcement_detail['file_path']) ? base_url($announcement_detail['file_path']) : '' ?>"
                        accept="image/png,image/jpeg,image/jpg,image/gif,image/svg,image/webp"
                        data-max-file-size="2M" data-height="100">
                </div>
            </div>
			<!-- Notify Via Section -->
            <div class="row tab-inner-section px-1 py-1 mx-1 description-container">
                <div class="card-header mb-2">Notify Via <span class="text-danger">*</span></div>

                <div class="col-md-12 form-group mb-2">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="send_via_email" value="1"
                            <?= !empty($announcement_detail['send_via_email']) ? 'checked' : '' ?>>
                        <label class="form-check-label">Send Via Email</label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="show_after_login" value="1"
                            <?= !empty($announcement_detail['show_after_login']) ? 'checked' : '' ?>>
                        <label class="form-check-label">Show for employees after login</label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="enable_notify_date" name="enable_notify_date" value="1"
                            <?= !empty($announcement_detail['notify_date']) ? 'checked' : '' ?>>
                        <label class="form-check-label">Enable Notify Date</label>
                    </div>

                    <div id="notify_date_section" style="<?= !empty($announcement_detail['notify_date']) ? '' : 'display:none;' ?>; margin-top:10px;">
                        <label>Notify Date</label>
                        <input type="date" name="notify_date_date" class="form-control mb-2"
                            value="<?= isset($announcement_detail['notify_date']) ? $announcement_detail['notify_date'] : '' ?>" min="<?= date('Y-m-d'); ?>">
                        <label>Notify Time</label>
                        <input type="time" name="notify_date_time" class="form-control"
                            value="<?= isset($announcement_detail['notify_time']) ? $announcement_detail['notify_time'] : '' ?>">
                    </div>
                </div>
            </div>
		<?php echo form_close(); ?>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button form="announcementForm" type="submit" class="btn btn-custom-success">Save</button>
</div>
<script>
$(document).ready(function () {
	$('.dropify').dropify();

	const groupDetail = <?= json_encode($group_detail ?? []) ?>;
	const selectedGroup = "<?= $announcement_detail['employee_group'] ?? '' ?>";

	function loadGroupDetailFields(group) {
		const $container = $('#dynamic-fields').empty();

		if (group === 'department') {
			$container.html(`
				<div class="form-group mt-2 mb-3">
					<label>Select Department <span class="text-danger">*</span></label>
					<select class="form-control select2" id="groupDetailSelect" name="group_detail[]" multiple required>
						<?php foreach (masterDepartments() as $d): ?>
							<option value="<?= $d->id ?>"><?= $d->name ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			`);
		} else if (group === 'specific_employees') {
			$container.html(`
				<div class="form-group mt-2 mb-3">
					<label>Select Employees <span class="text-danger">*</span></label>
					<select class="form-control select2" id="groupDetailSelect" name="group_detail[]" multiple required>
						<?php foreach (employeeListHelper() as $e): ?>
							<option value="<?= $e->id ?>"><?= $e->emp_no . ' - ' . $e->full_name ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			`);
		}

		$('.select2').select2({ width: '100%', allowClear: true });

		setTimeout(() => {
			$('#groupDetailSelect').val(groupDetail).trigger('change');
		}, 200);
	}

	// Event on radio change
	$('input[name="employee_group"]').on('change', function () {
		loadGroupDetailFields($(this).val());
	});

	// Load existing data on edit
	if (selectedGroup) {
		$(`input[name="employee_group"][value="${selectedGroup}"]`).prop('checked', true).trigger('change');
	}

	// Toggle notify fields
	function toggleNotifyFields() {
		if ($('#enable_notify_date').is(':checked')) {
			$('#notify_date_section').slideDown();
			$('#notify_date_date, #notify_date_time').attr('required', true);
		} else {
			$('#notify_date_section').slideUp();
			$('#notify_date_date, #notify_date_time').removeAttr('required');
		}
	}

	toggleNotifyFields();
	$('#enable_notify_date').on('change', toggleNotifyFields);

	// AJAX submit
	$("#announcementForm").on("submit", function (e) {
		e.preventDefault();
		var formData = new FormData(this);
		$.ajax({
			url: "<?php echo site_url('admin/hr/announcements/update'); ?>",
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function (response) {
				if (response.type === "success") {
					toastr.success(response.message);
					setTimeout(() => location.reload(), 2000);
				} else {
					toastr.error(response.message);
				}
			},
			error: function (xhr) {
				console.error("AJAX Error:", xhr.responseText);
				toastr.error('An unexpected error occurred. Please try again.');
			}
		});
	});
});
</script>
