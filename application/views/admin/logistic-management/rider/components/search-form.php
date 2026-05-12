<style> 
#responseContainer{
	position: fixed;
    width: 93%;
    top: 60px;
}
</style>
<div class="modal-header">
	<h5 class="modal-title mt-0" id="addRiderModalLabel">Add Rider Profile</h5>
	<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
	<div class="row size-inner-section px-2 py-4 mx-1">
		<form id="searchForm">
			<div class="form-group">
				<label for="password">Search by Employee ID <span class="text-danger">*</span></label>
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Employee ID" aria-label="Employee Number" name="search_employee" id="search_employee" aria-describedby="button-addon2">
					<button class="btn btn-success border-success" form="searchForm" type="submit" id="">Search</button>
					<!-- <button class="btn btn-danger border-danger reset-button" type="reset" id="">Reset</button> -->
				</div>
			</div>
		</form>
		<div id="searchResponse"></div>
	</div>
	<div id="responseContainer"></div>
	<div id="searchResult" class="mt-4">

	</div>
</div>
<div class="modal-footer" id="searchModalFooter">
	
</div>

<script>
	$(document).ready(function() {
		$('#searchForm').submit(function(e) {
			e.preventDefault();
			// Serialize the form data
			$('#responseContainer').html('');
			resetModalData();
			var formData = $('#searchForm').serialize();
			$.ajax({
				url: "<?php echo base_url('admin/logistic-management/rider/search-emp');?>",
				type: 'POST',
				data: formData,
				dataType: 'json',
				success: function(response) {
					if (response.type === 'success') {
						$('#searchResponse').html('<div><p class="text-success mb-0 mt-2">' + response.message + '</p></div>');
						$('#searchResult').html(response.output_html);
						$('#searchModalFooter').html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetModalData()">Cancel</button>
						<button type="submit" form="riderProfileForm" class="btn btn-custom-success">Submit</button>`);
					} else {
						$('#searchResponse').html('<div><p class="text-danger mb-0 mt-2">' + response.message + '</p></div>');
					}
				},
				error: function() {
					$('#searchResponse').html('<div><p class="text-danger mb-0 mt-2">An error occurred. Please try again.</p></div>');
				}
			});
		});

	});

</script>
