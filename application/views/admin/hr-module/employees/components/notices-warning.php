<style> 
.modal-body {
    padding: 0.4rem;
}
</style>
<div>
	<?php echo form_open("admin/hr/employees/save-warning-request", array("id" => "request_form", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
		<input type="hidden" name="emp_id" value="<?php echo $emp_detail->id;?>" required />
		<input type="hidden" name="request_type" value="NoticesAndWarning" required />
		<!-- Tab panes -->
		<div id="ajaxRes"></div>
		<div class="row tab-inner-section m-2 py-2">
			<h4 class="header-title">Basic Detail</h4><hr>
            <div class="col-md-6 col-sm-12 mb-2 form-group px-2">
				<label for="warning_type">Type <span class="text-danger">*</span></label>
				<select class="form-control form-select" data-parsley-allselected="true" name="warning_type" id="warning_type" required>
					<option value="">Select Type</option>
					<option value="Absconded">Absconded</option>
					<option value="Notices">Notices</option>
					<option value="Warnings">Warnings</option>
					<option value="Refusal to Work">Refusal to Work</option>
				</select>
			</div>
            <div class="col-md-6 col-sm-12 mb-2 form-group px-2">
                <label for="request_date">Date <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="request_date" name="request_date" min="<?php echo date("Y-m-d"); ?>" required />
            </div>
		</div>
		<div class="row tab-inner-section m-2 py-2 description-container">
			<h4 class="header-title">Notices/Warning Content <span class="text-danger">*</span></h4><hr>
			<div class="col-md-6 col-sm-12 form-group mb-2">
                <label for="title_arabic">Title Arabic <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="title_arabic" name="title_arabic" required />
			</div>
            <div class="col-md-6 col-sm-12 form-group mb-2">
                <label for="title_english">Title English <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="title_english" name="title_english" required />
            </div>
            <div class="col-md-12 col-sm-12 form-group mb-2">
                <label for="description_arabic">Body Arabic <span class="text-danger">*</span></label>
                <textarea class="form-control" id="description_arabic" name="description_arabic" rows="4" required></textarea>
            </div>
            <div class="col-md-12 col-sm-12 form-group mb-2">
                <label for="description_english">Body English <span class="text-danger">*</span></label>
                <textarea class="form-control" id="description_english" name="description_english" rows="4" required></textarea>
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
        //$requestDateInput.attr('max', formatDate(threeDaysLater));
    });

	$(document).ready(function() {
		function toggleDescriptionContainer() {
			var selectedType = $('#warning_type').val();
			if (selectedType === 'Absconded') {
				$('.description-container').hide();
				// Remove 'required' from all inputs and textareas in description-container
				$('.description-container input, .description-container textarea').removeAttr('required');
			} else {
				$('.description-container').show();
				// Add 'required' back
				$('#title_arabic, #title_english, #description_arabic, #description_english').attr('required', 'required');
			}
		}

		// Initial check on page load
		toggleDescriptionContainer();

		// On change event
		$('#warning_type').change(function() {
			toggleDescriptionContainer();
		});
	});

	$(document).ready(function () {
		$("#request_form").on("submit", function (e) {
			e.preventDefault();
			var formData = new FormData(this); 
			$.ajax({
				url: "<?php echo site_url('admin/hr/employees/save-warning-request'); ?>",
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
