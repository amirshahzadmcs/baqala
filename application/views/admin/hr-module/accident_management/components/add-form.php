<style> 
#responseContainer{
	position: fixed;
    width: 93%;
    top: 60px;
}
</style>
<div class="modal-header">
	<h5 class="modal-title mt-0" id="addRiderModalLabel">Add Accident Information</h5>
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
	<div id="responseContainer"></div>
	<div class="progress mt-3" style="height: 20px; display: none;" id="uploadProgressContainer">
		<div id="uploadProgress" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;">
			0%
		</div>
	</div>

	<div class="result-container">
		<form id="accident_form" method="post" enctype="multipart/form-data" class="form-label-left" data-parsley-validate="" accept-charset="utf-8">
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
				url: "<?php echo base_url('admin/hr/accident-management/vehicle-list');?>",
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
				url: "<?php echo base_url('admin/hr/accident-management/search-vehicle');?>",
				type: 'POST',
				data: formData,
				dataType: 'json',
				success: function(response) {
					if (response.type === 'success') {
						$('#searchResult').html(response.output_html);
						$('#searchModalFooter').html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetModalData()">Cancel</button>
						<button form="accident_form" type="submit" class="btn btn-custom-success">Save</button>`);
						// Reinitialize Select2
						$('#searchResult select').select2();
						$('#searchNameContainer').addClass('d-none');
						$('#empTitleContainer').removeClass('d-none');
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
						$('#searchResult').html('<div class="alert alert-danger">' + response.message + '</div>');
					}
				},
				error: function() {
					$('#searchResult').html('<div class="alert alert-danger">An error occurred. Please try again.</div>');
				}
			});
		});
	});

	$(document).ready(function () {
		$('#accident_form').submit(function (e) {
			e.preventDefault();
			var formData = new FormData($(this)[0]);

			// Disable buttons
			$('#cancelBtn, #saveBtn').prop('disabled', true);

			// Show progress bar
			$('#uploadProgressContainer').show();
			$('#uploadProgress').css('width', '0%').text('0%');

			$.ajax({
				url: '<?php echo base_url('admin/hr/accident-management/submit'); ?>',
				type: 'POST',
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				xhr: function () {
					var xhr = new window.XMLHttpRequest();
					xhr.upload.addEventListener("progress", function (evt) {
						if (evt.lengthComputable) {
							var percentComplete = Math.round((evt.loaded / evt.total) * 100);
							$('#uploadProgress').css('width', percentComplete + '%').text(percentComplete + '%');
						}
					}, false);
					return xhr;
				},
				success: function (response) {
					if (response.type === 'success') {
						toastr.success(response.message);
						$('#searchResult').html('');
						setTimeout(function () {
							window.location.href = "<?php echo base_url('admin/hr/accident-management'); ?>";
						}, 1000);
					} else {
						toastr.error(response.message);
					}
					// Reset progress & enable buttons
					$('#uploadProgressContainer').hide();
					$('#uploadProgress').css('width', '0%').text('0%');
					$('#cancelBtn, #saveBtn').prop('disabled', false);
				},
				error: function () {
					toastr.error('An error occurred. Please try again.');
					// Reset progress & enable buttons
					$('#uploadProgressContainer').hide();
					$('#uploadProgress').css('width', '0%').text('0%');
					$('#cancelBtn, #saveBtn').prop('disabled', false);
				}
			});
		});
	});

</script>
