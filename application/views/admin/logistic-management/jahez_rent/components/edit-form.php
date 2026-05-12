<style> 
.tab-inner-section {
    box-shadow: 0px 1px 4px #c5c5c5;
    border-radius: 5px;
    margin-bottom: 10px;
}
</style>
<div class="modal-header">
    <h6 class="modal-title mt-0" id="allotModalFullscreenLabel">Edit Rent Detail</h6>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body px-2" id="allot_body_modal">
    <?php echo form_open("admin/logistic-management/jahez-rent/update", array("id" => "editRentForm", "enctype" => "multipart/form-data", "class" => "form-horizontal form-label-left", "novalidate" => "novalidate")); ?>
        <input type="hidden" name="id" value="<?php echo $rent_detail->id; ?>">
        <div class="accordion accordion-flush border-0" id="accordionFlushExample">
            <div class="accordion-item tab-inner-section m-2 py-2">
                <h2 class="accordion-header mx-2" id="flush-headingOne">
                    <button class="accordion-button py-2 border-0 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        Rent Detail
                    </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label for="agreement_no">Agreement Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="agreement_no" name="agreement_no" value="<?php echo $rent_detail->agreement_no; ?>" required disabled />
                            </div>

                            <div class="col-md-6 col-sm-12 form-group">
                                <label for="agreement_date">Agreement Date <span class="required-field text-danger">*</span></label>
                                <input type="date" class="form-control" id="agreement_date" name="agreement_date" value="<?php echo $rent_detail->agreement_date; ?>" required />
                            </div>

                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label for="name">Name<span class="required-field text-danger">*</span></label>
                                <input type="text" name="name" placeholder="Name" class="form-control" id="name" value="<?php echo $rent_detail->name; ?>" maxlength="150" required />
                            </div>

                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label for="iqama_no">Iqama Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="iqama_no" name="iqama_no" minlength="<?= ICAMA_LENGTH ;?>" maxlength="<?= ICAMA_LENGTH ;?>" value="<?php echo $rent_detail->iqama_no; ?>" required />
                            </div>

                            <div class="col-md-6 col-sm-12 form-group">
                                <label for="city">City <span class="text-danger">*</span></label>
                                <select name="city" id="city" class="form-control select2" required>
                                    <option value="">Select City</option>
                                    <?php foreach(selectedCitiesHelp(6) as $city){?>
                                    <option value="<?php echo $city->id;?>" <?php echo ($rent_detail->city == $city->id) ? 'selected' : ''; ?>><?php echo $city->city_name;?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label for="mobile_no">Mobile Number <span class="text-danger">*</span></label>
                                <input type="text" id="mobile_no" name="mobile_no" minlength="<?= MOB_LENGTH ;?>" maxlength="<?= MOB_LENGTH ;?>" value="<?php echo $rent_detail->mobile_no; ?>" class="form-control" required>
                            </div>

                            <div class="col-md-12 col-sm-12 mb-3 form-group">
                                <label for="email_id">Email ID <span class="text-danger">*</span></label>
                                <input type="email" id="email_id" name="email_id" maxlength="150" value="<?php echo $rent_detail->email_id; ?>" class="form-control" required>
                            </div>
                        </div>
						<div class="row">
                            <!-- Helper function to preview image or document -->
                            <?php
                            function renderFilePreview($filePath, $label, $docField, $id) {

                                if (empty($filePath)) {
                                    // When no file exists
                                    return '
                                        <label class="fw-bold">'.$label.'</label>
                                        <input type="file" name="'.$docField.'" id="'.$docField.'" 
                                            class="dropify" data-height="100"
                                            accept=".png,.jpeg,.jpg,.gif,.svg,.webp,.pdf,.doc,.docx,.xls,.xlsx">
                                    ';
                                }

                                $url = base_url($filePath);
                                $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                                $isImage = in_array($ext, ['png','jpg','jpeg','gif','webp','svg']);

                                $html = '<label class="fw-bold">'.$label.'</label>
                                        <div class="border p-2 rounded mb-3">';

                                if ($isImage) {
                                    // Show image preview
                                    $html .= '
                                        <a href="'.$url.'" target="_blank">
                                            <img src="'.$url.'" class="img-fluid" style="max-height:200px;">
                                        </a>
                                    ';
                                } else {
                                    // Show file button
                                    $html .= '
                                        <a href="'.$url.'" target="_blank" 
                                            class="btn btn-outline-primary w-100 mb-2">
                                            📄 View File ('.strtoupper($ext).')
                                        </a>
                                    ';
                                }

                                // Delete button
                                $html .= '
                                    <button type="button" class="btn btn-sm btn-danger w-100 mt-1 delete-doc"
                                            data-doc="'.$docField.'" data-id="'.$id.'">
                                        Delete File
                                    </button>
                                </div>';

                                return $html;
                            }
                            ?>

                            <!-- Iqama Copy -->
                            <div class="col-md-6 mb-3">
                                <?= renderFilePreview(
                                    $rent_detail->iqama_copy ?? '',
                                    'Iqama Copy',
                                    'iqama_copy',
                                    $rent_detail->id
                                ); ?>
                            </div>

                            <!-- Driving License Copy -->
                            <div class="col-md-6 mb-3">
                                <?= renderFilePreview(
                                    $rent_detail->driving_license_copy ?? '',
                                    'Driving License Copy',
                                    'driving_license_copy',
                                    $rent_detail->id
                                ); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php echo form_close(); ?>
</div>
<div class="modal-footer">
    <div class="row">
        <div class="col-md-12">
            <button form="editRentForm" type="submit" id="submitBtn" class="btn btn-success btn-md">Save</button>
            <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-outline-danger btn-md ms-2">Cancel </button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.dropify').dropify();
    });

    $(document).ready(function () {

        $("#editRentForm").on("submit", function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: $(this).attr("action"),
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",

                success: function (res) {
                    // -------------------------
                    // ❌ VALIDATION FAILED
                    // -------------------------
                    if (res.status === "error") {
                        toastr.error(res.msg, "Validation Error");
                        return;
                    }
                    // -------------------------
                    // ✅ SUCCESS
                    // -------------------------
                    toastr.success(res.msg, "Success");

                    setTimeout(() => {
                        location.reload();
                    }, 1200);
                },

                error: function () {
                    toastr.error("Something went wrong!", "Error");
                }

            });
        });

    });
	
	$(document).on("click", ".delete-doc", function () {
        let $btn = $(this);
        let docField = $btn.data("doc");
        let id = $btn.data("id");
        let $container = $btn.closest('.col-md-6, .col-md-12'); // The wrapper div
        let labelText = $container.find('label').text(); // Keep the original label

        Swal.fire({
            title: "Are you sure?",
            text: "This file will be deleted permanently.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= base_url('admin/logistic-management/jahez-rent/delete-image'); ?>",
                    type: "POST",
                    data: { id: id, field: docField },
                    dataType: "json",

                    success: function (res) {
                        if (res.status === "success") {
                            Swal.fire({
                                icon: "success",
                                title: "Deleted!",
                                text: res.msg,
                                timer: 1500,
                                showConfirmButton: false
                            });

                            // Replace preview with fresh file input
                            $container.html(`
                                <label class="fw-bold">${labelText}</label>
                                <input type="file" name="${docField}" id="${docField}" 
                                    class="dropify" data-height="100"
                                    accept=".png,.jpeg,.jpg,.gif,.svg,.webp,.pdf,.doc,.docx,.xls,.xlsx">
                            `);

                            // Re-initialize Dropify
                            $container.find('.dropify').dropify();

                        } else {
                            Swal.fire("Error", res.msg, "error");
                        }
                    },

                    error: function () {
                        Swal.fire("Error", "Something went wrong!", "error");
                    }
                });
            }
        });
    });

</script>