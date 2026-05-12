<style> 
#responseContainer{
	position: fixed;
    width: 93%;
    top: 60px;
}
</style>
<div class="modal-header">
	<h5 class="modal-title mt-0" id="addRiderModalLabel">Add Vehicle Information</h5>
	<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body px-2">
	<div class="row size-inner-section px-2 mx-1">
		<form id="searchForm">
			<div class="row pt-2 justify-content-center">
				<div class="form-group col-lg-12 col-md-12 col-12 mb-3">
					<label for="search_vehicle">Search for Vehicles <span class="text-danger">*</span></label>
					<select name="search_vehicle" id="search_vehicle" class="form-control select2 w-100">
						<option value="">Search Vehicle</option>
					</select>
				</div>
			</div>
		</form>
	</div>

	<div class="result-container">
		<form id="vehicle_form" method="post" enctype="multipart/form-data" class="form-label-left" data-parsley-validate="" accept-charset="utf-8">
			<div id="searchResult" class="mt-3">

			</div>
		</form>
	</div>
</div>
<div class="modal-footer" id="searchModalFooter">
	
</div>

<script>
	
	$(document).ready(function() {
		$('#search_vehicle').select2({
			placeholder: 'Search Vehicle',
			minimumInputLength: 2,
			ajax: {
				url: "<?php echo base_url('admin/logistic-management/fuel-management/search-vehicle');?>",
				type: 'POST',
				dataType: 'json',
				delay: 250,
				data: function (params) {
					return {
						search: params.term
					};
				},
				processResults: function (data) {
					return {
						results: $.map(data, function (item) {
							let icon = item.vehicle_type === 'bike' ? '🛵' : '🚗';
							return {
								id: item.id,
								text: icon + ' ' + item.vehicle_no + ' - ' + item.vehicle_model
							};
						})
					};
				},
				cache: true
			}
		});

		$('#search_vehicle').change(function() {
			// Serialize the form data
			var formData = $('#searchForm').serialize();
			
			$.ajax({
				url: "<?php echo base_url('admin/logistic-management/fuel-management/vehicle-detail');?>",
				type: 'POST',
				data: formData,
				dataType: 'json',
				success: function(response) {
					if (response.type === 'success') {
						$('#searchResult').html(response.output_html);
						$('#searchModalFooter').html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
						<button form="vehicle_form" type="submit" class="btn btn-custom-success">Save</button>`);
						// Reinitialize Select2
						$('#searchResult select').select2();
						// Update employee name and profile picture if available
						if (response.vehicle_no) {
							let vehicle_type = response.vehicle_type;
							if(vehicle_type == 'bike') {
								vehicle_no = '🛵 '+ response.vehicle_no;
							}
							else
							{
								vehicle_no = '🚗 '+ response.vehicle_no;
							}
							$('#employeeName').html(vehicle_no + ' - ' + response.vehicle_model);
						}
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

	$(document).ready(function () {
		$('#vehicle_form').submit(function (e) {
			e.preventDefault();
			var formData = new FormData($(this)[0]);
			// Disable buttons
			$('#cancelBtn, #saveBtn').prop('disabled', true);
			$.ajax({
				url: '<?php echo base_url('admin/logistic-management/fuel-management/submit-vehicle'); ?>',
				type: 'POST',
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				success: function (response) {
					if (response.type === 'success') {
						toastr.success(response.message);
						$('#searchResult').html('');
						setTimeout(function () {
							window.location.href = "<?php echo base_url('admin/logistic-management/fuel-management/list'); ?>";
						}, 1000);
					} else {
						toastr.error(response.message);
					}
					$('#cancelBtn, #saveBtn').prop('disabled', false);
				},
				error: function () {
					toastr.error('An error occurred. Please try again.');
					$('#cancelBtn, #saveBtn').prop('disabled', false);
				}
			});
		});
	});

</script>
