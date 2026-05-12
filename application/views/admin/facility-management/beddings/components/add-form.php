<style> 
#responseContainer{
	position: fixed;
    width: 93%;
    top: 60px;
}
</style>
<div class="modal-header">
	<h5 class="modal-title mt-0" id="addRiderModalLabel">Add Room & Bedding</h5>
	<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body px-1">
	<form id="beddingForm">
		<div class="row m-1">
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="property_id">Select Property <span class="text-danger">*</span></label>
				<select name="property_id" id="property_id" class="form-select" required>
					<option value="">Select Property</option>
					<?php foreach ($properties as $property): ?>
						<option value="<?php echo $property['id']; ?>"><?php echo $property['property_name']; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="floor">Select Floor <span class="text-danger">*</span></label>
				<select name="floor" id="floor" class="form-select" required>
					<option value="">Select Floor</option>
					
				</select>
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="unit_type">Select Units <span class="text-danger">*</span></label>
				<select name="unit_type" id="unit_type" class="form-select" required>
					<option value="">Select Units</option>

				</select>
			</div>
			<div class="col-md-6 col-sm-12 mb-3 form-group">
				<label for="unit_room_no">Unit Room No <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="unit_room_no" name="unit_room_no" required />
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="bed_type">Select Bed Type <span class="text-danger">*</span></label>
				<select name="bed_type" id="bed_type" class="form-select" required>
					<option value="">Select Bed Type</option>
					<option value="Single">Single</option>
					<option value="Bunker">Bunker</option>
				</select>
			</div>
			<div class="col-md-6 col-sm-12 mb-3 form-group">
				<label for="bed_capacity">Bed Capacity <span class="text-danger">*</span></label>
				<input type="number" class="form-control" id="bed_capacity" min="1" name="bed_capacity" required />
			</div>
			<div class="col-md-6 col-sm-12 mb-3 form-group">
				<label for="labour_capacity">Labour Capacity <span class="text-danger">*</span></label>
				<input type="number" class="form-control" id="labour_capacity" min="1" name="labour_capacity" required />
			</div>
		</div>
	</form>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetModalData()">Cancel</button>
	<button type="submit" form="beddingForm" id="submitBeddingForm" class="btn btn-custom-success">Save</button>
</div>

<script>
	$(document).ready(function() {
		$('#beddingForm').submit(function(e) {
			e.preventDefault();
			var $submitBtn = $('#submitBeddingForm');
			$submitBtn.prop('disabled', true).text('Submitting...');
			var formData = $(this).serialize();
			$.ajax({
				url: "<?php echo base_url('admin/facility-management/bedding/store');?>",
				type: 'POST',
				data: formData,
				dataType: 'json',
				success: function(response) {
					if (response.type === 'success') {
						toastr.success(response.message);
						setTimeout(function() {
							location.reload(); // ✅ Reload page after success
						}, 1000);
					} else {
						toastr.error(response.message);
					}
				},
				error: function() {
					toastr.error('An error occurred. Please try again.');
				},
				complete: function() {
					// Re-enable button & reset text
					$submitBtn.prop('disabled', false).text('Save');
				}
			});
		});
		
		$("#property_id").change(function () {
			var property_id = $(this).val();
			if (property_id != "") {
				$.ajax({
					url: "<?php echo base_url('admin/facility-management/Property/get_floors_by_property'); ?>",
					type: "POST",
					data: {property_id: property_id},
					success: function (data) {
						$("#floor").html(data);
					}
				});
			} else {
				$("#floor").html('<option value="">Select Floor</option>');
			}
		});

		$('#floor').change(function() {
			var property_id = $('#property_id').val();
			var floor = $(this).val();

			if (floor !== "") {
				$.ajax({
					url: "<?php echo base_url('admin/facility-management/Property/get_units_by_floor'); ?>",
					type: "POST",
					data: {property_id: property_id, floor: floor},
					success: function(data) {
						$('#unit_type').html(data);
					}
				});
			} else {
				$('#unit_type').html('<option value="">Select Units</option>');
			}
		});
	});

</script>
