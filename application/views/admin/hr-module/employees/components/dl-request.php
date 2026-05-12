<style> 
.modal-body {
    padding: 0.4rem;
}
</style>
<div>
	<?php echo form_open("admin/hr/employees/save-dl-request", array("id" => "request_form", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
		<input type="hidden" name="emp_id" value="<?php echo $emp_detail->id;?>" required />
		<input type="hidden" name="request_type" value="DlRequest" required />
		<!-- Tab panes -->
		<div id="ajaxRes"></div>
		<div class="row tab-inner-section m-2 py-2">
			<h4 class="header-title">DL Request Details</h4><hr>
			<div class="col-md-6 col-sm-12 mb-2 form-group px-2">
				<label for="dl_type">Driving License Type</label>
				<select class="form-control form-select" data-parsley-allselected="true" name="dl_type" id="dl_type" required>
					<option value="">Select DL Type</option>
					<option value="bike">Bike</option>
					<option value="car">Car</option>
					<option value="Nakal Khafif">Nakal Khafif</option>
				</select>
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group px-2" id="expensesContainer">
				<label for="dl_request_type">DL Request Type</label>
				<select class="form-control form-select" data-parsley-allselected="true" name="dl_request_type" id="dl_request_type" required>
					<option value="">Select DL Request Type</option>
					<option value="Direct ">Direct</option>
					<option value="Normal">Normal</option>
					<option value="Replacement">Replacement</option>
					<option value="Addition">Addition</option>
				</select>
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group px-2">
                <label for="request_date">Request Date <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="request_date" name="request_date" max="<?php echo date("Y-m-d"); ?>" required />
            </div>
			<div class="col-md-6 col-sm-12 mb-2 form-group px-2">
				<label for="dallah_location">Dallah Location</label>
				<select class="form-control form-select" data-parsley-allselected="true" name="dallah_location" id="dallah_location" required>
					<option value="">Select Dallah Location</option>
					<option value="Al Kharj">Al Kharj</option>
					<option value="Al Qassim">Al Qassim</option>
					<option value="Dammam">Dammam</option>
					<option value="Jeddah">Jeddah</option>
					<option value="Madina">Madina</option>
					<option value="Makkah">Makkah</option>
					<option value="Majma">Majma</option>
					<option value="Muzamiya">Muzamiya</option>
					<option value="Rimal">Rimal</option>
					<option value="Sudair">Sudair</option>
					<option value="Sulai">Sulai</option>
					<option value="Takhassusi">Takhassusi</option>
				</select>
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group px-2">
                <label for="blood_group">Blood Group <span class="text-danger">*</span></label>
                <select name="blood_group" id="blood_group" class="form-select" required data-placeholder="Choose Blood group...">
                    <option value="">Select Blood Group</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
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
	<?php echo form_close(); ?>
</div>
<script type="text/javascript">
	$(document).ready(function() {
        $('.dropify').dropify();
        // Trigger the change event initially to set the default state
        $('#dl_request_type').trigger('change');
        
        $('#dl_request_type').change(function(e) {
            e.preventDefault();
            $(".dl_request_type_child").remove();
            var expenses_type = $(this).find('option:selected').val();
            var addition_input = '';
            if(expenses_type == 'Addition') {
                addition_input = `
                    <div class="col-md-6 col-sm-12 mb-2 px-2 form-group dl_request_type_child">
                        <label for="expiry_date">Expiry Date</label>
                        <div class="position-relative" id="expiry_date">
                            <input type="date" class="form-control" name="expiry_date" id="expiry_date" required>
                        </div>
                    </div>`;
            }
            $("#expensesContainer").after(addition_input);
        });
    });

	$(document).ready(function () {
		$("#request_form").on("submit", function (e) {
			e.preventDefault();
			var formData = new FormData(this); 
			$.ajax({
				url: "<?php echo site_url('admin/hr/employees/save-dl-request'); ?>",
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
