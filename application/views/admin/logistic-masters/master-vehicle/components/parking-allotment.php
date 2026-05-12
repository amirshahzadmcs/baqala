<!-- /.modal-content -->
<div class="modal-header">
    <h6 class="modal-title mt-0" id="allotModalFullscreenLabel">Parking Allotment</h6>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body" id="allot_body_modal">
    <form id="parkingAllotment" action="<?php echo base_url('admin/master-vehicle/save-parking-allotment'); ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="vehicle_id" value="<?php echo $id;?>" required>
        <div class="row tab-inner-section m-2 py-2">
			<h4 class="header-title">Vehicle Information</h4><hr>
			<div class="col-md-6"><h6>Vehicle Number: <span class="text-primary"><?php echo $vehicle_detail->vehicle_no;?></span></h6></div>
			<div class="col-md-6"><h6>Vehicle Type: <span class="text-primary"><?php echo ucfirst($vehicle_detail->vehicle_type);?></span></h6></div>
			<div class="col-md-6"><h6>Vehicle Model: <span class="text-primary"><?php echo $vehicle_detail->vehicle_model;?></span></h6></div>
		</div>
        <div class="row tab-inner-section m-2 py-2">
            <h4 class="header-title">Fill Allotment Detail</h4><hr>
            <div class="col-md-12 col-sm-12 mb-3 form-group">
                <label for="location">Parking Location<span class="text-danger">*</span></label>
                <select name="location" id="location" class="form-select select2" required>
                    <option value="">Select Parking Location</option>
                    <?php if(masterParkingHelper()){ foreach(masterParkingHelper() as $loc_list){ ?>
                    <option value="<?php echo $loc_list->id; ?>"><?php echo $loc_list->parking_name; ?></option>
                    <?php }}else{ echo '<option value="">No parking available, add new parking first</option>';} ?>
                </select>
                <small class="hint">Select parking location of vehicle</small>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <div class="row">
        <div class="col-md-12">
            <button form="parkingAllotment" type="submit" id="submitBtn" class="btn btn-success btn-md">Save</button>
            <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-outline-danger btn-md ms-2">Cancel </button>
        </div>
    </div>
</div>

<script>
    $(".select2").select2();

	$(document).ready(function () {
		$("#parkingAllotment").on("submit", function (e) {
            e.preventDefault();

            var $submitBtn = $("#submitBtn");
            var originalBtnHtml = $submitBtn.html();

            // Disable button and show loader
            $submitBtn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

            var formData = new FormData(this); 
            $.ajax({
                url: "<?php echo site_url('admin/master-vehicle/save-parking-allotment'); ?>",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function (response) {
                    if (response.type === "success") {
                        toastr.success(response.message);
                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                    } else if (response.type === "error") {
                        toastr.error(response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", xhr.responseText, status, error);
                    toastr.error('An unexpected error occurred. Please try again.');
                },
                complete: function () {
                    // Restore button
                    $submitBtn.prop("disabled", false).html(originalBtnHtml);
                }
            });
        });
	});
</script>
