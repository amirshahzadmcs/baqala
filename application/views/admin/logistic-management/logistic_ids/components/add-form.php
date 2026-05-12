<style> 
#responseContainer{
	position: fixed;
    width: 93%;
    top: 60px;
}
</style>
<div class="modal-header">
	<h5 class="modal-title mt-0" id="addRiderModalLabel">Add Aggregator</h5>
	<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
	<?php echo form_open("admin/logistic-management/platform-id/submit", array("id" => "riderProfileForm", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
		<div class="size-inner-section px-1 py-1 mx-1">
			<div class="card-header">Fill Detail To Add New Aggregator</div>
			<div class="row p-2">
				<div class="col-md-12 col-sm-12 mb-2 form-group">
					<label for="request_date">Requested Date <span class="text-danger">*</span></label>
					<input type="date" class="form-control" id="request_date" name="request_date" required />
				</div>

				<div class="col-md-12 col-sm-12 mb-2 form-group">
					<label for="platform_id">Aggregator <span class="text-danger">*</span></label>
					<select name="platform_id" id="platform_id" class="form-select" required>
						<option value="">Select Aggregator</option>
						<?php foreach(fdCompanyHelper() as $fdcompany) { ?>
							<option value="<?php echo $fdcompany->id; ?>" data-length="<?php echo $fdcompany->id_length; ?>" data-maxlength="<?php echo $fdcompany->max_id_length; ?>"><?php echo $fdcompany->company_name; ?></option>
						<?php } ?>
					</select>
				</div>

				<div class="col-md-12 col-sm-12 mb-2 form-group">
					<label for="id_type">ID Type <span class="text-danger">*</span></label>
					<select name="id_type" id="id_type" class="form-select">
						<option value="">Select ID Type</option>
						<option value="Freelancer">Freelancer</option>
						<option value="Company">Company</option>
					</select>
				</div>

				<div class="col-md-12 col-sm-12 mb-2 form-group">
					<label for="id_number">ID Number <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="id_number" name="id_number" minlength="1" required />
				</div>
				
				<div class="col-md-12 col-sm-12 mb-2 form-group">
					<label for="owner_id">ID Owner <span class="text-danger">*</span></label>
					<select name="owner_id" id="owner_id" class="form-select select2" required>
						<option value="">Select Owner</option>
						<?php if(!empty(employeeListHelper())){ foreach(employeeListHelper() as $emp_list){ ?>
						<option value="<?php echo $emp_list->id; ?>" data-ownercity="<?= $emp_list->work_city;?>"><?php echo $emp_list->emp_no; ?> - <?php echo $emp_list->full_name; ?> (<?php echo $emp_list->designation_name; ?>)</option>
						<?php }}else{ echo '<option value="">No employee found, add new employee first</option>';} ?>
					</select>
				</div>

				<div class="col-md-12 col-sm-12 mb-2 form-group">
					<label for="owner_city">Owner City <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="owner_city" name="owner_city" value="" required disabled />
				</div>

				<div class="col-md-12 col-sm-12 mb-2 form-group">
					<label for="activation_date">Activation Date</label>
					<input type="date" class="form-control" id="activation_date" name="activation_date" />
				</div>

				<div class="col-md-12 col-sm-12 mb-2 form-group">
					<label for="rider_status">Status <span class="text-danger">*</span></label>
					<select name="status" id="rider_status" class="form-select" required>
						<option value="">Select ID Type</option>
						<option value="active">Active</option>
						<option value="inactive">Inactive</option>
					</select>
				</div>
				
			</div>
		</div>
	<?php echo form_close(); ?>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetModalData()">Cancel</button>
	<button type="submit" form="riderProfileForm" class="btn btn-custom-success formSaveBtn">Submit</button>
</div>

<script>
	$(document).ready(function() {

		// Update maxlength of id_number based on selected platform_id
        $('#platform_id').on('change', function() {
            var selectedOption = $(this).find(':selected');
            var minLength = selectedOption.data('length');
            var maxLength = selectedOption.data('maxlength');
			$('#id_number').val('');
            if (maxLength) {
                $('#id_number').attr('minlength', minLength);
                $('#id_number').attr('maxlength', maxLength);
            } else {
                $('#id_number').removeAttr('minlength');
                $('#id_number').removeAttr('maxlength');
            }
        });

		$('#owner_id').change(function () {
            var selectedOption = $(this).find(':selected');
            var ownerCityId = selectedOption.data('ownercity');
            if (ownerCityId) {
                $.ajax({
                    url: '<?= base_url("admin/logistic-management/Logistic_ids/get_city_details"); ?>',
                    type: 'POST',
                    data: { city_id: ownerCityId },
                    success: function (response) {
						console.log(response);
                        $('#owner_city').val(response);
                    },
                    error: function () {
                        alert('Error fetching city details.');
                    }
                });
            } else {
                $('#owner_city').val('');
            }
        });

		$('#riderProfileForm').submit(function(e) {
			e.preventDefault();
			// Serialize the form data
			var formData = $('#riderProfileForm').serialize();
			$.ajax({
				url: "<?php echo base_url('admin/logistic-management/platform-id/submit');?>",
				type: 'POST',
				data: formData,
				dataType: 'json',
				success: function(response) {
					if (response.type === 'success') {
						$('.formSaveBtn').attr('disabled', true);
						toastr.success(response.message);
						setTimeout(function() {
							window.location.href = "<?php echo base_url('admin/logistic-management/platform-id/list');?>";
						}, 2000);
					} else {
						toastr.error(response.message);
					}
				},
				error: function() {
					toastr.error('An error occurred. Please try again.');
				}
			});
		});

	});

</script>
