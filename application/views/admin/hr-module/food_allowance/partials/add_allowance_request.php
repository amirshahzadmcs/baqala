<style> 
.approver-item .select2-container{
	width: 100% !important;
    margin-right: 8px;
}
.select2-container--default .select2-selection--single .select2-selection__clear{
	font-size: 20px;
}
.select2-container .select2-selection--single .select2-selection__rendered{
	padding-right: 30px;
}
/* Styling for the custom footer */
.custom-footer {
	padding: 10px;
	text-align: center;
	cursor: pointer;
	background-color: #f1f1f1;
	border-top: 1px solid #ccc;
}
.custom-footer:hover {
	background-color: #e2e2e2;
}
/* Adds smooth transitions to list items */
#approverList .list-group-item.transition {
    transition: transform 0.2s ease-in-out;
}

/* Style the placeholder to be visible while sorting */
.sortable-placeholder {
    background-color: #f0f0f0;
    height: 65px;
    border: 2px dashed #ccc;
    visibility: visible !important;
}
</style>
<?php echo form_open("admin/hr/food-allowance/save-form", array("id" => "addAllowanceForm", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
<div class="row tab-inner-section pb-4">
    <div class="col-md-12 col-sm-12 mb-3 form-group">
        <label for="arrival_date">Select Arrival Date <span class="text-danger">*</span></label>
        <input type="date" class="form-control" name="arrival_date" id="arrival_date" placeholder="Arrival Date" required />
    </div>
    
    <div class="col-md-12 col-sm-12 mb-3 form-group">
        <div id="addEmployeeContainer">
            
        </div>
    </div>
    
</div>
<?php echo form_close(); ?>

<script>
	$(document).ready(function() {
		$('#arrival_date').on('change', function() {
			const arrivalDate = $(this).val();
			$('#addEmployeeContainer').html('');
			$.ajax({
				url: '<?php echo base_url('admin/hr/food-allowance/get-cv-list'); ?>',
				method: 'GET',
				data: { arrival_date: arrivalDate },
				success: function(responseHtml) {
					$('#addEmployeeContainer').html(responseHtml);
					//initializeEmployeeList();
					var footerHtml = `<div class="row">
							<div class="col-md-12">
								<button form="addAllowanceForm" type="submit" id="btnUpload" class="btn btn-success btn-md">Save</button>
								<button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-outline-danger btn-md ms-2">Cancel </button>
							</div>
						</div>`;
					$('.foodModal .modal-footer').html(footerHtml);
				},
				error: function(errorResponse) {
					toastr.error('Error fetching updated data');
				}
			});
		});

		// Handle form submission
		$('#addAllowanceForm').on('submit', function (e) {
			e.preventDefault();
			var data = new FormData(this);
			// Send the AJAX request to save the form
			$.ajax({
				url: $(this).attr('action'),
				method: 'POST',
				data: data,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$("#btnUpload").prop('disabled', true);
					$("#btnUpload").html('<i class="fa fa-spinner fa-spin"></i> <small>Please wait ...</small>');
				}, 
				success: function (response) {
					// Ensure the response is parsed as JSON
					var result;
					try {
						result = typeof response === 'object' ? response : JSON.parse(response);
					} catch (e) {
						console.error('Failed to parse response as JSON:', e);
						toastr.error('Invalid server response. Please try again.');
						return;
					}

					// Handle the success or error message
					if (result.status === 'success') {
						toastr.success(result.message);
						$('#addAllowanceForm')[0].reset();
						initializeDataTable();
						setTimeout(function() {
							location.reload();
						}, 1000);
					} else {
						toastr.error(result.message);
					}
					$("#btnUpload").prop('disabled', false);
					$("#btnUpload").html('Save');
				},
				error: function (error) {
					toastr.error('Failed to submit form. Please try again.');
					$("#btnUpload").prop('disabled', false);
					$("#btnUpload").html('Save');
					console.error(error);
				}
			});
		});
	});
</script>
