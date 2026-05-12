<?php echo form_open("admin/hr-module/requests/update-request-status", array("id" => "commentForm2", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
	<input type="hidden" name="request_id" value="<?= $request_info['id']; ?>">
	<div class="font-size-12 mb-3">
		<div class="form-group mb-2">
			<label for="textarea" class="form-label">Comment</label>
			<textarea id="textarea" class="form-control" name="comment" maxlength="225" rows="3" placeholder="Enter rejection reason" required></textarea>
		</div>
		<div class="form-group mb-2">
			<button type="submit" form="commentForm2" class="btn btn-info btn-sm me-1">Confirm</button>
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

        $('#commentForm2').submit(function(e) {
			e.preventDefault();
			var formData = new FormData($(this)[0]);
			$.ajax({
				url: '<?php echo base_url('admin/hr-module/requests/update-request-status');?>',
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
						$('#commentForm2').trigger('reset');
						// Refresh the comments section
						refreshComments();
						if (response.reload) {
							setTimeout(function() {
								location.reload();
							}, 1000);
						}
					} else {
						toastr.error(response.message);
					}
				},
				error: function() {
					toastr.error(response.message);
				}
			});
		});
	});
</script>