<div class="modal-header">
    <h6 class="modal-title mt-0" id="summaryModalFullscreenLabel">Update Sim Status</h6>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="size-inner-section px-1 py-1 mx-1">
        <div class="card-header">Sim Detail</div>
        <div class="d-flex align-items-center employee-detail">
            <div class="p-3 w-100">
                <table>
                    <tr>
                        <td>Owner Type</td>
                        <td> : </td>
                        <td><?php echo ucfirst($sim_detail->ownership_type); ?></td>
                    </tr>
                    <tr>
                        <td>Owner ID</td>
                        <td> : </td>
                        <td><?php echo $sim_detail->owner_id; ?></td>
                    </tr>
                    <tr>
                        <td>Owner Name</td>
                        <td> : </td>
                        <td><?php echo $sim_detail->owner_name; ?></td>
                    </tr>
                    <tr>
                        <td>Mobile No / Type</td>
                        <td> : </td>
                        <td><?php echo $sim_detail->mobile; ?> / <?php echo $sim_detail->sim_type; ?></td>
                    </tr>
                    <tr>
                        <td>Sim Card No / Provider</td>
                        <td> : </td>
                        <td><?php echo $sim_detail->sim_no; ?></td>
                    </tr>
                    <tr>
                        <td>Date of purchase</td>
                        <td> : </td>
                        <td><?php echo $sim_detail->date_of_purchase ? date('d-m-Y', strtotime($sim_detail->date_of_purchase)) : ''; ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="size-inner-section px-1 py-1 mx-1">
        <div class="card-header">Fill Sim Replacement Detail</div>
        <div id="searchResponse"></div>
        <?php echo form_open("admin/sim/status-update", array("id" => "simStatusForm", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
        <input type="hidden" id="id" name="id" value="<?php echo $sim_detail->id; ?>" required />
        <div class="row p-2">
            <div class="col-md-6 col-sm-12 mb-3 form-group">
                <label for="status">Sim Status<span class="text-danger">*</span></label>
                <select name="status" id="manage_status" class="form-select" required>
                    <option value="">-- Select Sim Status --</option>
                    <?php if ($sim_detail->status == '' || $sim_detail->status == '0') { ?>
                        <option value="0" <?php echo ($sim_detail->status == '0') ? " selected" : "" ?>>New</option>
                    <?php } ?>
                    <option value="1" <?php echo ($sim_detail->status == '1') ? " selected " : "" ?>>Active</option>
                    <option value="2" <?php echo ($sim_detail->status == '2') ? " selected " : "" ?>>Discontinued</option>
                </select>
            </div>

            <div class="col-md-6 col-sm-12 mb-3">
                <div class="discont-field form-group d-none">
                    <label for="date_of_discontinued">Discontinue Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="date_of_discontinued" name="date_of_discontinued" value="<?php echo (($sim_detail->date_of_discontinued !== '') ? $sim_detail->date_of_discontinued : ''); ?>" />
                </div>
            </div>

            <div class="col-md-12 col-sm-12 mb-3 form-group d-none" id="rejection_container">
                <label for="discontinue_reason">Reason for Discontinue <span class="text-danger">*</span></label>
                <textarea class="form-control" rows="2" id="discontinue_reason" name="discontinue_reason"><?php echo $sim_detail->discontinue_reason; ?></textarea>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-success" form="simStatusForm">Save changes</button>
</div>
<script>
    discontinueStatus();

	$('#manage_status').on('change', function() {
		discontinueStatus();
	});
	
	function discontinueStatus() {
		var status_val = $('#manage_status option:selected').val();
		if (status_val == '2') {
			$(".discont-field").removeClass('d-none');
			$("#date_of_discontinued").prop('required', true);
			$('#rejection_container').removeClass('d-none');
			$('#discontinue_reason').prop('required', true);
		} else {
			$(".discont-field").addClass('d-none');
			$("#date_of_discontinued").prop('required', false);
			$('#rejection_container').addClass('d-none');
			$('#discontinue_reason').prop('required', false);
		}

	}

    $(document).ready(function() {
        // AJAX form submission
		$('#simStatusForm').on('submit', function(e) {
			e.preventDefault();
			var formData = $(this).serialize();
			$.ajax({
				url: '<?php echo base_url("admin/sim/status-update"); ?>',
				type: 'POST',
				data: formData,
				dataType: 'json',
				success: function(response) {
					if (response.type === 'success') {
						toastr.success(response.message);
						setTimeout(function() {
							location.reload();
						}, 1000);
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

</script>
