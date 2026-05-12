<style> 
#responseContainer{
	position: fixed;
    width: 93%;
    top: 60px;
}
</style>
<div class="modal-header">
	<h5 class="modal-title mt-0" id="addRiderModalLabel">Cash Collection Voucher</h5>
	<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
	<div class="row size-inner-section px-2 py-4 mx-1">
		<form id="searchForm">
			<div class="form-group">
				<label for="search_employee">Search by Emp. ID / Name <span class="text-danger">*</span></label>
				<select class="form-control" class="form-control" placeholder="Search by Emp. Name or Emp. ID" aria-label="Employee Number" name="search_employee" id="search_employee" aria-describedby="button-addon2" required>
					<option value="">Search...</option>
				</select>
			</div>
		</form>
		<div id="searchResponse"></div>
	</div>
	<div id="responseContainer"></div>
	<div id="searchResult" class="mt-4">

	</div>
</div>

<script>
	$(document).ready(function() {
		$('#search_employee').select2({
			placeholder: 'Search...',
			allowClear: true,
			minimumInputLength: 1,
			ajax: {
				url: "<?php echo base_url('admin/logistic-management/cash-collection/emp-list'); ?>",
				type: 'GET',
				dataType: 'json',
				delay: 250,
				data: function(params) {
					return {
						search: params.term
					};
				},
				processResults: function(data) {
					return {
						results: $.map(data, function(item) {
							//console.log(item);
							return {
								id: item.emp_no,
								text: item.emp_no + ' - ' + item.full_name
							};
						})
					};
				},
				error: function(xhr, status, error) {
					console.log(xhr.responseText);
				}
			}
		});

		// Trigger on dropdown change
		$('#search_employee').on('change', function () {
			$('#responseContainer').html('');
			resetModalData();

			let formData = $('#searchForm').serialize();

			$.ajax({
				url: "<?php echo base_url('admin/logistic-management/cash-collection/search-emp');?>",
				type: 'POST',
				data: formData,
				dataType: 'json',
				success: function(response) {
					if (response.type === 'success') {
						$('#searchResponse').html('<div><p class="text-success mb-0 mt-2">' + response.message + '</p></div>');
						$('#searchResult').html(response.output_html);
						$('#searchModalFooter').html(`
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetModalData()">Cancel</button>
							<button type="button" onclick="generateOtpButton()" class="btn btn-custom-success">Send OTP</button>
						`);
					} else {
						$('#searchResponse').html('<div><p class="text-danger mb-0 mt-2">' + response.message + '</p></div>');
						$('#searchResult').html('');
						$('#searchModalFooter').html('');
					}
				},
				error: function() {
					$('#searchResponse').html('<div><p class="text-danger mb-0 mt-2">An error occurred. Please try again.</p></div>');
				}
			});
		});
	});

</script>
