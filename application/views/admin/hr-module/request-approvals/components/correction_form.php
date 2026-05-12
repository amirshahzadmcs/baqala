<?php echo form_open("admin/hr-module/requests/save-correction", array("id" => "correctionForm", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
	<input type="hidden" name="request_id" value="<?= $request_info['id']; ?>">
	<div class="font-size-12 mb-3">
		<div class="form-group mb-2">
			<label for="textarea" class="form-label">Return for correction reason</label>
			<textarea id="textarea" class="form-control" name="comment" maxlength="225" rows="3" placeholder="Enter the return for correction reason" required></textarea>
		</div>
		<div class="form-group mb-2">
			<button type="submit" form="correctionForm" class="btn btn-info btn-sm me-1">Confirm</button>
			<button type="button" id="correctionCancel" class="btn btn-outline-secondary btn-sm">Cancel</button>
		</div>
	</div>
<?php echo form_close(); ?>
<script>
    $(document).ready(function () {
		$('#textarea').maxlength({
			alwaysShow: true,
			threshold: 10,
			warningClass: "badge bg-success",
			limitReachedClass: "badge bg-danger",
			placement: "bottom-right-inside"
		});

        $('#correctionCancel').click(function() {
			$('#correctionForm').trigger('reset');
			$('#detailModalFooter').show();
			$('#correctionSection').html('');
		});

        $('#correctionForm').submit(function(e) {
			e.preventDefault();
			var formData = new FormData($(this)[0]);
			$.ajax({
				url: '<?php echo base_url('admin/hr-module/requests/save-correction');?>',
				type: 'POST',
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				success: function(response) {
					// Handle server response
					if (response.type === 'success') {
						toastr.success(response.message);
                        $('#correctionSection').html('');
						// Clear the form
						$('#correctionForm').trigger('reset');
						// Refresh the comments section
						refreshCorrections();
						location.reload();
					} else {
						toastr.error(response.message);
					}
				},
				error: function() {
					toastr.error(response.message);
				}
			});
		});

        // Function to refresh the comments section
		function refreshCorrections() {
			var requestId = $('input[name="request_id"]').val();
			$.ajax({
				url: '<?php echo base_url('admin/hr-module/requests/get-correction'); ?>',
				type: 'GET',
				data: { request_id: requestId },
				success: function (html) {
					$('.correctionList').html(html);
				},
				error: function () {
					toastr.error("Failed to refresh comments.");
				}
			});
		}
	});
</script>