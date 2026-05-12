<style> 
.tab-inner-section {
    box-shadow: 0px 1px 4px #c5c5c5;
    border-radius: 5px;
    margin-bottom: 10px;
}
</style>
<div class="modal-header">
    <h6 class="modal-title mt-0" id="allotModalFullscreenLabel">Add Jahez Rent</h6>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body px-2" id="allot_body_modal">
    <?php echo form_open("admin/logistic-management/jahez-rent/submit", array("id" => "addRentForm", "enctype" => "multipart/form-data", "class" => "form-horizontal form-label-left", "novalidate" => "novalidate")); ?>
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
                                <?php 
                                    $agreement_no = ''; 
                                    if (!empty($agreement_id)) {
                                        $agreement_no = date("Ym") . str_pad($agreement_id->id + 1, 4, 0, STR_PAD_LEFT);
                                    } else {
                                        $agreement_no = date("Ym") . '0001';
                                    }
                                ?>
                                <input type="text" class="form-control" id="agreement_no" name="agreement_no" value="<?php echo $agreement_no; ?>" required readonly />
                            </div>

                            <div class="col-md-6 col-sm-12 form-group">
                                <label for="agreement_date">Agreement Date <span class="required-field text-danger">*</span></label>
                                <input type="date" class="form-control" id="agreement_date" name="agreement_date" min="<?php echo date("Y-m-d"); ?>" required />
                            </div>

                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label for="name">Name<span class="required-field text-danger">*</span></label>
                                <input type="text" name="name" placeholder="Name" class="form-control" id="name" maxlength="150" required />
                            </div>

                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label for="iqama_no">Iqama Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="iqama_no" name="iqama_no" minlength="<?= ICAMA_LENGTH ;?>" maxlength="<?= ICAMA_LENGTH ;?>" required />
                            </div>

                            <div class="col-md-6 col-sm-12 form-group">
                                <label for="city">City <span class="text-danger">*</span></label>
                                <select name="city" id="city" class="form-control select2" required>
                                    <option value="">Select City</option>
                                    <?php foreach(selectedCitiesHelp(6) as $city){?>
                                    <option value="<?php echo $city->id;?>"><?php echo $city->city_name;?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label for="mobile_no">Mobile Number <span class="text-danger">*</span></label>
                                <input type="text" id="mobile_no" name="mobile_no" minlength="<?= MOB_LENGTH ;?>" maxlength="<?= MOB_LENGTH ;?>" class="form-control" required>
                            </div>

                            <div class="col-md-12 col-sm-12 mb-3 form-group">
                                <label for="email_id">Email ID <span class="text-danger">*</span></label>
                                <input type="email" id="email_id" name="email_id" maxlength="150" class="form-control" required>
                            </div>
                        </div>
						<div class="row">
                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label for="iqama_copy">Iqama Copy</label>
                                <input type="file" name="iqama_copy" id="iqama_copy" class="dropify"
                                        accept=".png, .jpeg, .jpg, .gif, .svg, .webp, .pdf, .doc, .docx, .xls, .xlsx"
                                        data-max-file-size="5M" data-height="100">
                            </div>

                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label for="driving_license_copy">Driving License</label>
                                <input type="file" name="driving_license_copy" id="driving_license_copy" class="dropify"
                                        accept=".png, .jpeg, .jpg, .gif, .svg, .webp, .pdf, .doc, .docx, .xls, .xlsx"
                                        data-max-file-size="5M" data-height="100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <div class="row">
        <div class="col-md-12">
            <button form="addRentForm" type="submit" id="submitBtn" class="btn btn-success btn-md">Save</button>
            <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-outline-danger btn-md ms-2">Cancel </button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.dropify').dropify();
    });

    $(document).ready(function () {

        $("#addRentForm").on("submit", function (e) {
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

</script>