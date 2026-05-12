<div class="modal-header">
	<h5 class="modal-title mt-0" id="addRiderModalLabel">Room & Bedding Detail</h5>
	<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body px-1">
	<div class="row m-1">
		<div class="col-md-6 col-sm-12 mb-2 form-group">
			<label for="property_id">Select Property</label>
			<select name="property_id" id="property_id" class="form-select" disabled>
				<option value="">Select Property</option>
				<?php foreach ($properties as $property): ?>
					<option value="<?php echo $property['id']; ?>" 
						<?php echo ($property['id'] == $bedding['property_id']) ? 'selected' : ''; ?>>
						<?php echo $property['property_name']; ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>

		<div class="col-md-6 col-sm-12 mb-2 form-group">
			<label for="floor">Select Floor</label>
			<select name="floor" id="floor" class="form-select" disabled>
				<option value="<?php echo $bedding['floor']; ?>"><?php echo $bedding['floor']; ?></option>
			</select>
		</div>

		<div class="col-md-6 col-sm-12 mb-2 form-group">
			<label for="unit_type">Select Units</label>
			<select name="unit_type" id="unit_type" class="form-select" disabled>
				<option value="<?php echo $bedding['unit_type']; ?>"><?php echo ucfirst($bedding['unit_type']); ?></option>
			</select>
		</div>

		<div class="col-md-6 col-sm-12 mb-3 form-group">
			<label for="unit_room_no">Unit Room No</label>
			<input type="text" class="form-control" id="unit_room_no" name="unit_room_no" 
				value="<?php echo $bedding['unit_room_no']; ?>" disabled />
		</div>

		<div class="col-md-6 col-sm-12 mb-2 form-group">
			<label for="bed_type">Select Bed Type</label>
			<select name="bed_type" id="bed_type" class="form-select" disabled>
				<option value="Single" <?php echo ($bedding['bed_type'] == 'Single') ? 'selected' : ''; ?>>Single</option>
				<option value="Bunker" <?php echo ($bedding['bed_type'] == 'Bunker') ? 'selected' : ''; ?>>Bunker</option>
			</select>
		</div>

		<div class="col-md-6 col-sm-12 mb-3 form-group">
			<label for="bed_capacity">Bed Capacity</label>
			<input type="number" class="form-control" id="bed_capacity" min="1" name="bed_capacity" 
				value="<?php echo $bedding['bed_capacity']; ?>" disabled />
		</div>

		<div class="col-md-6 col-sm-12 mb-3 form-group">
			<label for="labour_capacity">Labour Capacity</label>
			<input type="number" class="form-control" id="labour_capacity" min="1" name="labour_capacity" 
				value="<?php echo $bedding['labour_capacity']; ?>" disabled />
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
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
