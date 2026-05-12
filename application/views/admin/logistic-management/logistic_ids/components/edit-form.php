<style> 
#responseContainer{
	position: fixed;
    width: 93%;
    top: 60px;
}
</style>
<div class="modal-header">
	<h5 class="modal-title mt-0" id="addRiderModalLabel">Update Aggregator</h5>
	<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
	<?php echo form_open("admin/logistic-management/platform-id/submit", array("id" => "riderProfileForm", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
		<input type="hidden" name="id" value="<?php echo $id_detail['id'];?>" required />
		<div class="size-inner-section px-1 py-1 mx-1">
			<div class="card-header"><span class="text-danger">*</span> Marked field is required.</div>
			<div class="row p-2">
				<div class="col-md-12 col-sm-12 mb-2 form-group">
					<label for="request_date">Requested Date <span class="text-danger">*</span></label>
					<input type="date" class="form-control" id="request_date" name="request_date" value="<?php echo $id_detail['request_date'];?>" required />
				</div>

				<div class="col-md-12 col-sm-12 mb-2 form-group">
					<label for="platform_id">Aggregator <span class="text-danger">*</span></label>
					<select name="platform_id" id="platform_id" class="form-select" required>
						<option value="">Select Aggregator</option>
						<?php foreach(fdCompanyHelper() as $fdcompany) { ?>
							<option value="<?php echo $fdcompany->id; ?>" data-length="<?php echo $fdcompany->id_length; ?>" data-maxlength="<?php echo $fdcompany->max_id_length; ?>" <?php echo ($fdcompany->id == $id_detail['platform_id']) ? ' selected ' : '';?>><?php echo $fdcompany->company_name; ?></option>
						<?php } ?>
					</select>
				</div>

				<div class="col-md-12 col-sm-12 mb-2 form-group">
					<label for="id_type">ID Type <span class="text-danger">*</span></label>
					<select name="id_type" id="id_type" class="form-select">
						<option value="">Select ID Type</option>
						<option value="Freelancer" <?php echo ($id_detail['id_type'] == 'Freelancer') ? ' selected ' : '';?>>Freelancer</option>
						<option value="Company" <?php echo ($id_detail['id_type'] == 'Company') ? ' selected ' : '';?>>Company</option>
					</select>
				</div>

				<div class="col-md-12 col-sm-12 mb-2 form-group">
					<label for="id_number">ID Number <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="id_number" name="id_number" value="<?php echo $id_detail['id_number'];?>" required readonly />
				</div>
				
				<div class="col-md-12 col-sm-12 mb-2 form-group">
					<label for="owner_id">ID Owner <span class="text-danger">*</span></label>
					<select name="owner_id" id="owner_id" class="form-select select2" required>
						<option value="">Select Owner</option>
						<?php if(!empty(employeeListHelper())){ foreach(employeeListHelper() as $emp_list){ ?>
						<option value="<?php echo $emp_list->id; ?>" <?php echo ($emp_list->id == $id_detail['owner_id']) ? ' selected ' : '';?> data-ownercity="<?= $emp_list->work_city;?>"><?php echo $emp_list->emp_no; ?> - <?php echo $emp_list->full_name; ?> (<?php echo $emp_list->designation_name; ?>)</option>
						<?php }}else{ echo '<option value="">No employee found, add new employee first</option>';} ?>
					</select>
				</div>
				
				<div class="col-md-12 col-sm-12 mb-2 form-group">
					<label for="owner_city">Owner City <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="owner_city" name="owner_city" value="" required disabled />
				</div>

				<div class="col-md-12 col-sm-12 mb-2 form-group">
					<label for="activation_date">Activation Date</label>
					<input type="date" class="form-control" id="activation_date" name="activation_date" value="<?php echo $id_detail['activation_date'];?>" />
				</div>

				<div class="col-md-12 col-sm-12 mb-2 form-group">
					<label for="rider_status">Status <span class="text-danger">*</span></label>
					<select name="status" id="rider_status" class="form-select" required>
						<option value="">Select ID Type</option>
						<option value="active" <?php echo ($id_detail['status'] == 'active') ? ' selected ' : '';?>>Active</option>
						<option value="inactive" <?php echo ($id_detail['status'] == 'inactive') ? ' selected ' : '';?>>Inactive</option>
						<option value="terminated" <?php echo ($id_detail['status'] == 'terminated') ? ' selected ' : '';?>>Terminated</option>
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
		// Function to update maxlength based on selected platform_id
        function updateMaxLength() {
            var selectedOption = $('#platform_id').find(':selected');
            var minLength = selectedOption.data('length');
            var maxLength = selectedOption.data('maxlength');
            if (maxLength) {
				$('#id_number').attr('minlength', minLength);
                $('#id_number').attr('maxlength', maxLength);
            } else {
				$('#id_number').removeAttr('minlength');
                $('#id_number').removeAttr('maxlength');
            }
        }

        // Trigger maxlength update on platform_id change
        $('#platform_id').on('change', function() {
            updateMaxLength();
			$('#id_number').val('');
        });

        // Call the function on page load to handle pre-selected value
        updateMaxLength();

		$('#riderProfileForm').submit(function(e) {
			e.preventDefault();
			// Serialize the form data
			var formData = $('#riderProfileForm').serialize();
			$.ajax({
				url: "<?php echo base_url('admin/logistic-management/platform-id/update');?>",
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

		// Function to update city field based on selected owner
		function updateCityField() {
            var ownerCityId = $('#owner_id').find(':selected').data('ownercity');

            if (ownerCityId) {
                $.ajax({
                    url: '<?= base_url("admin/logistic-management/Logistic_ids/get_city_details"); ?>',
                    type: 'POST',
                    data: { city_id: ownerCityId },
                    success: function (response) {
                        $('#owner_city').val(response);
                    },
                    error: function () {
                        alert('Error fetching city details.');
                    }
                });
            } else {
                $('#owner_city').val('');
            }
        }

        // Auto-set city on page load for edit page
        updateCityField();

        // Update city on owner change
        $('#owner_id').change(function () {
            updateCityField();
        });

		function toggleTerminationReason() {
			if ($('#rider_status').val() === 'terminated') {
				if ($('#terminatedSection').length === 0) {
					// Create the Termination Reason section
					var terminatedSection = `
						<div id="terminatedSection" class="size-inner-section px-1 py-1 mx-1">
							<div class="card-header">Terminate Detail</div>
							<div class="row p-2">
								<div class="col-md-12 col-sm-12 mb-2 form-group">
									<label for="termination_date">Termination Date <span class="text-danger">*</span></label>
									<input type="date" class="form-control" id="termination_date" min="<?= $id_detail['activation_date'];?>" name="termination_date" required />
								</div>
								<div class="col-md-12 col-sm-12 mb-2 form-group">
									<label for="reason">Termination Reason <span class="text-danger">*</span></label>
									<textarea class="form-control" id="reason" name="reason" rows="3" required></textarea>
								</div>
							</div>
						</div>
					`;

					// Append it after .size-inner-section
					$('.size-inner-section').after(terminatedSection);
				}
			} else {
				$('#terminatedSection').remove(); // Remove section if status is changed
			}
		}

		// Call function on page load (for edit pages)
		toggleTerminationReason();

		// Trigger on status change
		$('#rider_status').change(function () {
			toggleTerminationReason();
		});
	});

</script>
