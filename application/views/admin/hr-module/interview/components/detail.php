<style> 
.tab-inner-section {
    box-shadow: 0px 1px 4px #c5c5c5;
    border-radius: 5px;
    margin-bottom: 10px;
}
</style>
<div class="modal-header">
    <h6 class="modal-title mt-0" id="allotModalFullscreenLabel">Interview Form Detail</h6>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body px-2" id="allot_body_modal">
    <div class="accordion accordion-flush border-0" id="accordionFlushExample">
        <div class="accordion-item tab-inner-section m-2 py-2">
            <h2 class="accordion-header mx-2" id="flush-headingOne">
                <button class="accordion-button py-2 border-0 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                    Interview Detail
                </button>
            </h2>
            <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 mb-3 form-group">
                            <label for="interview_no">Interview Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="interview_no" name="interview_no" value="<?php echo $interview_detail->interview_no; ?>" required disabled />
                        </div>

                        <div class="col-md-6 col-sm-12 form-group">
                            <label for="interview_date">Interview Date <span class="required-field text-danger">*</span></label>
                            <input type="date" class="form-control" id="interview_date" name="interview_date" value="<?php echo $interview_detail->interview_date; ?>" required />
                        </div>

                        <div class="col-md-6 col-sm-12 form-group">
                            <label for="position_applied">Position Applied <span class="text-danger">*</span></label>
                            <select name="position_applied" id="position_applied" class="form-control select2" required>
                                <option value="">Select Position</option>
                                <?php foreach ($positions as $pos) { ?>
                                    <option value="<?php echo $pos->id; ?>" <?php echo ($interview_detail->position_applied == $pos->id) ? 'selected' : ''; ?>><?php echo $pos->name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item tab-inner-section m-2 py-2">
            <h2 class="accordion-header mx-2" id="flush-headingTwo">
                <button class="accordion-button py-2 border-0 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                    General Information
                </button>
            </h2>
            <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 mb-3 form-group">
                            <label for="applicant_name">Applicant Name<span class="required-field text-danger">*</span></label>
                            <input type="text" name="applicant_name" placeholder="Applicant Name" class="form-control" id="applicant_name" value="<?php echo $interview_detail->applicant_name; ?>" maxlength="100" required />
                        </div>

                        <div class="col-md-6 col-sm-12 mb-3 form-group">
                            <label for="date_of_birth">Date of Birth <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="<?php echo $interview_detail->date_of_birth; ?>" required />
                        </div>

                        <div class="col-md-6 col-sm-12 mb-3 form-group">
                            <label for="mobile_number">Mobile Number <span class="text-danger">*</span></label>
                            <input type="text" id="mobile_number" name="mobile_number" minlength="<?= MOB_LENGTH ;?>" maxlength="<?= MOB_LENGTH ;?>" class="form-control" value="<?php echo $interview_detail->mobile_number; ?>" required>
                        </div>

                        <div class="col-md-6 col-sm-12 mb-3 form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" id="email" name="email" maxlength="150" class="form-control" value="<?php echo $interview_detail->email; ?>" required>
                        </div>
						
						<div class="col-md-6 col-sm-12 mb-3 form-group">
							<label for="nationality">Nationality <span class="text-danger">*</span></label>
							<select name="nationality" id="nationality" class="form-control select2" required>
								<option value="">Select Nationality</option>
								<?php foreach(nationalityList() as $nationality){?>
								<option value="<?php echo $nationality->id;?>" <?php echo ($interview_detail->nationality == $nationality->id) ? 'selected' : ''; ?>><?php echo $nationality->name;?></option>
								<?php } ?>
							</select>
						</div>

                        <div class="col-md-6 col-sm-12 form-group">
                            <label for="preferred_city">Preferred City <span class="text-danger">*</span></label>
                            <select name="preferred_city" id="preferred_city" class="form-control select2" required>
                                <option value="">Select Preferred City</option>
                                <?php foreach(selectedCitiesHelp(6) as $city){?>
                                <option value="<?php echo $city->id;?>" <?php echo ($interview_detail->preferred_city == $city->id) ? 'selected' : ''; ?>><?php echo $city->city_name;?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-6 col-sm-12 mb-3 form-group">
                            <label for="iban_number">IBAN Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="iban_number" name="iban_number" minlength="<?= IBAN_LENGTH ;?>" maxlength="<?= IBAN_LENGTH ;?>" value="<?php echo $interview_detail->iban_number; ?>" required />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item tab-inner-section m-2 py-2">
            <h2 class="accordion-header mx-2" id="flush-headingThree">
                <button class="accordion-button py-2 border-0 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                    Iqama Details
                </button>
            </h2>
            <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 mb-3 form-group">
                            <label for="iqama_number">Iqama Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="iqama_number" name="iqama_number" minlength="<?= ICAMA_LENGTH ;?>" maxlength="<?= ICAMA_LENGTH ;?>" value="<?php echo $interview_detail->iqama_number; ?>" required />
                        </div>

                        <div class="col-md-6 col-sm-12 mb-3 form-group">
                            <label for="iqama_expiry">Expiry Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="iqama_expiry" name="iqama_expiry" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $interview_detail->iqama_expiry; ?>" required />
                        </div>

                        <div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label for="iqama_profession">Iqama Profession <span class="text-danger">*</span></label>
                                <select class="form-control form-select select2" data-parsley-allselected="true" name="iqama_profession" id="iqama_profession" required>
                                    <option value="">Select Iqama Profession</option>
                                    <?php foreach (professionList() as $profession) { ?>
                                        <option value="<?php echo $profession->id; ?>" <?php echo ($interview_detail->iqama_profession == $profession->id) ? 'selected' : ''; ?>><?php echo $profession->profession_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                        <div class="col-md-6 col-sm-12 mb-3 form-group">
                            <label for="huroob_status">Huroob Status <span class="text-danger">*</span></label>
                            <select class="form-control" data-parsley-allselected="true" name="huroob_status" id="huroob_status" required>
                                <option value="">Select Huroob Status</option>
                                <option value="yes" <?php echo ($interview_detail->huroob_status == 'yes') ? 'selected' : ''; ?>>Yes</option>
                                <option value="no" <?php echo ($interview_detail->huroob_status == 'no') ? 'selected' : ''; ?>>No</option>
                            </select>
                        </div>

                        <div class="col-md-6 col-sm-12 form-group">
                            <label for="no">No of Transfer</label>
                            <select class="form-control form-select" data-parsley-allselected="true" name="no_of_transfer" id="no_of_transfer" required>
                                <option value="">Select No of Transfer</option>
                                <option value="1st - 2000" <?php echo ($interview_detail->no_of_transfer == '1st - 2000') ? 'selected' : ''; ?>>1st - 2000</option>
                                <option value="2nd - 4000" <?php echo ($interview_detail->no_of_transfer == '2nd - 4000') ? 'selected' : ''; ?>>2nd - 4000</option>
                                <option value="3rd - 6000" <?php echo ($interview_detail->no_of_transfer == '3rd - 6000') ? 'selected' : ''; ?>>3rd - 6000</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item tab-inner-section m-2 py-2">
            <h2 class="accordion-header mx-2" id="flush-headingFour">
                <button class="accordion-button py-2 border-0 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                    Driving License Details
                </button>
            </h2>
            <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 mb-3 form-group">
                            <label for="has_driving_license">Does he have Driving License <span class="text-danger">*</span></label>
                            <select class="form-control" data-parsley-allselected="true" name="has_driving_license" id="has_driving_license" required>
                                <option value="">Select Driving License Status</option>
                                <option value="yes" <?php echo ($interview_detail->has_driving_license == 'yes') ? 'selected' : ''; ?>>Yes</option>
                                <option value="no" <?php echo ($interview_detail->has_driving_license == 'no') ? 'selected' : ''; ?>>No</option>
                                <option value="home_land" <?= ($interview_detail->has_driving_license == 'home_land') ? 'selected' : ''; ?>>Home Land</option>
                            </select>
                        </div>
                    </div>

                    <div class="row driving-license-fields">
                        <div class="col-md-6 col-sm-12 mb-3 form-group dl-fields">
                            <label>Driving License Number <span class="text-danger">*</span></label>
                            <input type="text" id="driving_license_number"
                                name="driving_license_number"
                                value="<?= $interview_detail->driving_license_number; ?>"
                                class="form-control">
                        </div>

                        <div class="col-md-6 col-sm-12 mb-3 form-group dl-fields">
                            <label>Driving License Type <span class="text-danger">*</span></label>
                            <select class="form-control" name="driving_license_type" id="driving_license_type">
                                <option value="">Select DL Type</option>
                                <option value="Bike" <?= ($interview_detail->driving_license_type=='Bike')?'selected':''; ?>>Bike</option>
                                <option value="Car" <?= ($interview_detail->driving_license_type=='Car')?'selected':''; ?>>Car</option>
                                <option value="Light Transport" <?= ($interview_detail->driving_license_type=='Light Transport')?'selected':''; ?>>Light Transport</option>
                            </select>
                        </div>

                        <div class="col-md-6 col-sm-12 form-group dl-fields">
                            <label>Driving License Expiry Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control"
                                id="driving_license_expiry"
                                name="driving_license_expiry"
                                value="<?= $interview_detail->driving_license_expiry; ?>">
                        </div>

                        <div class="col-md-12 col-sm-12 form-group arrival-field">
                            <label>Arrival Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control"
                                id="arrival_date"
                                name="arrival_date"
                                value="<?= $interview_detail->arrival_date ?? ''; ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item tab-inner-section m-2 py-2">
            <h2 class="accordion-header mx-2" id="flush-headingFive">
                <button class="accordion-button py-2 border-0 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
                    Work Experience Details
                </button>
            </h2>
            <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 form-group">
                            <label for="aggregator">Aggregator</label>
                        </div>
                        <div class="col-md-5 col-sm-4 form-group">
                            <label><input type="checkbox" class="checkbox align-middle" name="has_hunger_station" <?php echo ($interview_detail->has_hunger_station == '1') ? 'checked' : ''; ?>> Hunger Station</label>
                        </div>
                        <div class="col-md-3 col-sm-4 form-group">
                            <label><input type="checkbox" class="checkbox align-middle" name="has_jahez" <?php echo ($interview_detail->has_jahez == '1') ? 'checked' : ''; ?>> Jahez</label>
                        </div>
                        <div class="col-md-4 col-sm-4 form-group">
                            <label><input type="checkbox" class="checkbox align-middle" name="has_keeta" <?php echo ($interview_detail->has_keeta == '1') ? 'checked' : ''; ?>> Keeta</label>
                        </div>
                        <div class="col-md-5 col-sm-4 form-group">
                            <label><input type="checkbox" class="checkbox align-middle" name="has_noon" <?php echo ($interview_detail->has_noon == '1') ? 'checked' : ''; ?>> Noon</label>
                        </div>
                        <div class="col-md-3 col-sm-4 form-group">
                            <label><input type="checkbox" class="checkbox align-middle" name="has_toyou" <?php echo ($interview_detail->has_toyou == '1') ? 'checked' : ''; ?>> ToYou</label>
                        </div>
                        <div class="col-md-4 col-sm-4 form-group">
                            <label><input type="checkbox" class="checkbox align-middle" name="has_marsool" <?php echo ($interview_detail->has_marsool == '1') ? 'checked' : ''; ?>> Marsool</label>
                        </div>
                        <div class="col-md-4 col-sm-4 mb-3 form-group">
                            <label><input type="checkbox" class="checkbox align-middle" name="has_chefz" <?php echo ($interview_detail->has_chefz == '1') ? 'checked' : ''; ?>> Chefz</label>
                        </div>
                        <div class="col-md-12 col-sm-12 mb-3 form-group">
                            <label for="long_term_relation">Is the Applicant expected to have long term relation with company.</label>
                            <select class="form-control" data-parsley-allselected="true" name="long_term_relation" id="long_term_relation">
                                <option value="yes" <?php echo ($interview_detail->long_term_relation == 'yes') ? 'selected' : ''; ?>>Yes</option>
                                <option value="no" <?php echo ($interview_detail->long_term_relation == 'no') ? 'selected' : ''; ?>>No</option>
                            </select>
                        </div>
                        <div class="col-md-12 col-sm-12 mb-3 form-group">
                            <label for="transfer_sponsorship">Is the Applicant willing to transfer the sponsorship to company.</label>
                            <select class="form-control" data-parsley-allselected="true" name="transfer_sponsorship" id="transfer_sponsorship">
                                <option value="yes" <?php echo ($interview_detail->transfer_sponsorship == 'yes') ? 'selected' : ''; ?>>Yes</option>
                                <option value="no" <?php echo ($interview_detail->transfer_sponsorship == 'no') ? 'selected' : ''; ?>>No</option>
                            </select>
                        </div>
                        <div class="col-md-12 col-sm-12 mb-3 form-group">
                            <label for="recommendation">Recommendation for Hiring</label>
                            <select class="form-control" data-parsley-allselected="true" name="recommendation" id="recommendation">
                                <option value="yes" <?php echo ($interview_detail->recommendation == 'yes') ? 'selected' : ''; ?>>Yes</option>
                                <option value="no" <?php echo ($interview_detail->recommendation == 'no') ? 'selected' : ''; ?>>No</option>
                            </select>
                        </div>
                        <div class="col-md-12 col-sm-12 form-group">
                            <label for="remarks">Remarks</label>
                            <textarea name="remarks" id="remarks" class="form-control" rows="4" placeholder="Remarks"><?php echo htmlspecialchars($interview_detail->remarks); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item tab-inner-section m-2 py-2">
            <h2 class="accordion-header mx-2" id="flush-headingSix">
                <button class="accordion-button py-2 border-0 collapsed" type="button"
                        data-bs-toggle="collapse" data-bs-target="#flush-collapseSix"
                        aria-expanded="false" aria-controls="flush-collapseSix">
                    Documents (Attachments)
                </button>
            </h2>

            <div id="flush-collapseSix" class="accordion-collapse collapse"
                aria-labelledby="flush-headingSix" data-bs-parent="#accordionFlushExample">

                <div class="accordion-body">
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
                            <?php renderDetailFile($interview_detail->iqama_copy ?? '', 'Iqama Copy'); ?>
                        </div>

                        <!-- Driving License Copy -->
                        <div class="col-md-6 mb-3">
                            <?php renderDetailFile($interview_detail->driving_license_copy ?? '', 'Driving License Copy'); ?>
                        </div>

                        <!-- IBAN Certificate -->
                        <div class="col-md-12 mb-3">
                            <?php renderDetailFile($interview_detail->iban_certificate ?? '', 'IBAN Certificate'); ?>
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
    $('.interview-modal').find('input, select, textarea').each(function () {
        $(this).prop('disabled', true);
        $(this).removeAttr('required'); // remove required to avoid validation errors
    });

    // IMPORTANT: Still keep driving license fields logic (view-only)
    $(document).ready(function () {
        function toggleDrivingLicenseFields() {
            const value = $('#has_driving_license').val();

            // Reset everything
            $('.driving-license-fields').hide();
            // YES → Full DL
            if (value === 'yes') {

                $('.driving-license-fields').show();

                $('.dl-fields')
                    .show();
                $('.arrival-field').hide();
            }

            // HOME LAND → Arrival Date only
            else if (value === 'home_land') {

                $('.driving-license-fields').show();
                $('.dl-fields').hide();
                $('.arrival-field')
                    .show();
            }
        }
        // IMPORTANT: run on edit-load
        toggleDrivingLicenseFields();
    });
});
</script>
