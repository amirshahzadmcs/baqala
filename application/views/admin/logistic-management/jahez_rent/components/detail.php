<style> 
.tab-inner-section {
    box-shadow: 0px 1px 4px #c5c5c5;
    border-radius: 5px;
    margin-bottom: 10px;
}
</style>
<div class="modal-header">
    <h6 class="modal-title mt-0" id="allotModalFullscreenLabel">Jahez Rent Detail</h6>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body px-2" id="allot_body_modal">
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

                        <?php
                        function renderDetailFile($filePath, $label) {

                            echo '<label class="fw-bold mb-1">'.$label.'</label>';

                            if (empty($filePath)) {
                                echo '<p>NA</p>';
                                return;
                            }

                            $url = base_url($filePath);
                            $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                            $isImage = in_array($ext, ['png','jpg','jpeg','gif','webp','svg']);

                            echo '<div class="border p-2 rounded mb-3">';

                            if ($isImage) {
                                // Show image preview
                                echo '
                                    <a href="'.$url.'" target="_blank">
                                        <img src="'.$url.'" class="img-fluid" style="max-height:200px;">
                                    </a>
                                ';
                            } else {
                                // Show file button
                                echo '
                                    <a href="'.$url.'" target="_blank" 
                                        class="btn btn-outline-primary w-100">
                                        📄 View File ('.strtoupper($ext).')
                                    </a>
                                ';
                            }

                            echo '</div>';
                        }
                        ?>

                        <!-- Iqama Copy -->
                        <div class="col-md-6 mb-3">
                            <?php renderDetailFile($rent_detail->iqama_copy ?? '', 'Iqama Copy'); ?>
                        </div>

                        <!-- Driving License Copy -->
                        <div class="col-md-6 mb-3">
                            <?php renderDetailFile($rent_detail->driving_license_copy ?? '', 'Driving License Copy'); ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <div class="row">
        <div class="col-md-12">
            <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-outline-danger btn-md ms-2">Close </button>
        </div>
    </div>
</div>
<script>
$(document).ready(function () {

    // Disable all inputs, selects, textareas inside the modal
    $('.rent-modal').find('input, select, textarea').each(function () {
        $(this).prop('disabled', true);
        $(this).removeAttr('required'); // remove required to avoid validation errors
    });
});
</script>
