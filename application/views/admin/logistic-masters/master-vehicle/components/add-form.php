<div class="modal-header">
    <h6 class="modal-title mt-0" id="allotModalFullscreenLabel">Add Vehicle</h6>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body px-2" id="allot_body_modal">
    <?php echo form_open("admin/master-vehicle/submit", array("id" => "addVehicleForm", "enctype" => "multipart/form-data", "class" => "form-horizontal form-label-left")); ?>
        <div class="accordion accordion-flush border-0" id="accordionFlushExample">
            <div class="accordion-item tab-inner-section m-2 py-2">
                <h2 class="accordion-header mx-2" id="flush-headingOne">
                    <button class="accordion-button py-2 border-0 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        Ownership
                    </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 mb-3 form-group">
                                <label for="vehicle_ownership">Vehicle Ownership<span class="required-field text-danger">*</span></label>
                                <select name="vehicle_ownership" id="vehicle_ownership" class="form-select">
                                    <option value="">Select Vehicle Ownership</option>
                                    <option value="Lease">Lease</option>
                                    <option value="Owned">Owned</option>
                                </select>
                            </div>

                            <div class="col-md-12 col-sm-12 mb-3 form-group">
                                <label for="owner_name_select">Vehicle Owner <span class="text-danger">*</span></label>
                                <select class="form-select" id="owner_name_select" name="owner_name_select">
                                    <option value="">Select Vehicle Owner</option>
                                    <?php foreach ($sponsors as $sponsor) : ?>
                                        <option value="<?= $sponsor->employer_name ?>" 
                                            data-cr_no="<?= $sponsor->employer_cr_no; ?>">
                                            <?= $sponsor->employer_name ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item tab-inner-section m-2 py-2">
                <h2 class="accordion-header mx-2" id="flush-headingTwo">
                    <button class="accordion-button py-2 border-0 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                        Vehicle Details
                    </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label for="vehicle_type">Vehicle Type<span class="required-field text-danger">*</span></label>
                                <select name="vehicle_type" id="vehicle_type" class="form-control select2">
                                    <option value="">Select Vehicle</option>
                                    <option value="bike">Bike</option>
                                    <option value="car">Car</option>
                                    <option value="van">Van</option>
                                </select>
                            </div>

                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label for="purchase_date">Vehicle Purchase Date</label>
                                <input type="date" class="form-control" id="purchase_date" name="purchase_date" max="<?php echo date("Y-m-d"); ?>" />
                            </div>

                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label for="vehicle_no">Vehicle Plate Number <span class="text-danger">*</span></label>
                                <input type="text" id="vehicle_no" name="vehicle_no" minlength="6" maxlength="7" class="form-control">
                            </div>

                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label for="chassis_no">Vehicle chassis Number</label>
                                <input type="text" id="chassis_no" name="chassis_no" maxlength="35" class="form-control">
                            </div>

                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label for="vehicle_expiry">Vehicle Expiry Date <span class="required-field text-danger">*</span></label>
                                <input type="date" class="form-control" id="vehicle_expiry" name="vehicle_expiry" min="<?php echo date("Y-m-d"); ?>" />
                            </div>

                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label for="vehicle_year">Vehicle Year <span class="text-danger">*</span></label>
                                <select style="height:410px;" name="vehicle_year" id="vehicle_year" class="form-control select2">
                                    <option value="">Select Vehicle Year</option>
                                    <?php 
                                        //$year_start  = 2001;
                                        $year_start  = (date('Y') - 6);
                                        $year_end = date('Y'); // current Year
                                    
                                        for ($i_year = $year_end; $i_year >= $year_start; $i_year--) {
                                            echo '<option value="'.$i_year.'">'.$i_year.'</option>'."\n";
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label for="vehicle_make">Vehicle Make <span class="text-danger">*</span></label>
                                <select style="height:410px;" name="vehicle_make" id="vehicle_make" class="form-control select2">
                                    <option value="">Select Service Type First</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label for="vehicle_model">Vehicle Model <span class="text-danger">*</span></label>
                                <select style="height:410px;" name="vehicle_model" id="vehicle_model" class="form-control select2">
                                    <option value="">Select Vehicle Make First</option>
                                </select>
                            </div>

                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label for="vehicle_color">Vehicle Color <span class="text-danger">*</span></label>
                                <select style="height:410px;" name="vehicle_color" id="vehicle_color" class="form-control select2">
                                    <option value="">Select Vehicle Color</option>
                                    <?php foreach(colorList() as $color){?>
                                    <option value="<?php echo $color->id;?>"><?php echo $color->color_name;?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label for="vehicle_category">Category<span class="required-field text-danger">*</span></label>
                                <select name="vehicle_category" id="vehicle_category" class="form-control select2">
                                    <option value="">Select Category</option>
                                    <option value="Staff">Staff</option>
                                    <option value="TGA">TGA</option>
                                    <option value="Route">Route</option>
                                </select>
                            </div>

                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label for="sequel_no">Vehicle Sequel Number</label>
                                <input type="text" id="sequel_no" name="sequel_no" maxlength="35" class="form-control">
                            </div>
							
							<div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label for="custom_card_no">Custom Card No</label>
                                <input type="text" id="custom_card_no" name="custom_card_no" maxlength="30" class="form-control">
                            </div>
							
							<div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label for="city_of_operation">City of Operation <span class="text-danger">*</span></label>
                                <select name="city_of_operation" id="city_of_operation" class="form-control select2" required>
                                    <option value="">Select City of Operation</option>
                                    <?php foreach(selectedCitiesHelp(6) as $city){?>
                                    <option value="<?php echo $city->id;?>"><?php echo $city->city_name;?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label class="d-block">Gasoline Chip</label>
                                <input type="checkbox" id="switch4" switch="bool" name="gasoline_chip_status" />
                                <label for="switch4" data-on-label="Yes" data-off-label="No"></label>
                            </div>
							
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item tab-inner-section m-2 py-2">
                <h2 class="accordion-header mx-2" id="flush-headingThree">
                    <button class="accordion-button py-2 border-0 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                        Insurance Details
                    </button>
                </h2>
                <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label for="insurance_no">Select Insurance Policy No</label>
                                <select class="form-select select2" data-parsley-allselected="true" name="insurance_no" id="insurance_no">
                                    <option value="">Select Policy No.</option>
                                    <?php foreach(vehiclePolicyList() as $insPolicy) { ?>
                                        <option value="<?php echo $insPolicy->id; ?>"><?php echo $insPolicy->policy_number; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label for="insurance_company_name">Insurance Company Name</label>
                                <select class="form-control" data-parsley-allselected="true" name="insurance_company_name" id="insurance_company_name" readonly style="pointer-events: none;">
                                    <option value="">Select Policy No. First</option>
                                    <?php foreach(insuCompanyHelper() as $insCompany) { ?>
                                        <option value="<?php echo $insCompany->id; ?>"><?php echo $insCompany->company_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-6 col-sm-12 mb-2 form-group">
                                <label for="insurance_class">Policy Class</label>
                                <select class="form-select" data-parsley-allselected="true" name="insurance_class" id="insurance_class">
                                    <option value="">Select Policy No. First</option>
                                </select>
                            </div>

                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label for="insurance_issue_date">Insurance Issue Date</label>
                                <input type="date" class="form-control" id="insurance_issue_date" name="insurance_issue_date" readonly />
                            </div>

                            <div class="col-md-6 col-sm-12 mb-2 form-group">
                                <label for="insurance_expiry">Insurance End Date</label>
                                <input type="date" class="form-control" id="insurance_expiry" name="insurance_expiry" min="" readonly />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item tab-inner-section m-2 py-2">
                <h2 class="accordion-header mx-2" id="flush-headingFour">
                    <button class="accordion-button py-2 border-0 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                        GPS Details
                    </button>
                </h2>
                <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 form-group">
                                <label class="d-block">GPS Installed</label>
                                <input type="checkbox" id="gps_installed" switch="bool" name="gps_installed" />
                                <label for="gps_installed" data-on-label="Yes" data-off-label="No"></label>
                            </div>
                        </div>

                        <div class="row gps-fields">
                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label for="gps_device_serial">GPS Tracking IMEI Number</label>
                                <input type="text" id="gps_device_serial" name="gps_device_serial" maxlength="55" class="form-control">
                            </div>

                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label for="gps_installation_date">GPS Tracking Installation Date</label>
                                <input type="date" class="form-control" id="gps_installation_date" name="gps_installation_date" max="<?php echo date('Y-m-d');?>" />
                            </div>

                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label for="gps_expiry_date">GPS Tracking Expiry Date</label>
                                <input type="date" class="form-control" id="gps_expiry_date" name="gps_expiry_date" readonly />
                            </div>

                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label for="gsp_mobile_no">GPS Mobile No</label>
                                <input type="text" id="gsp_mobile_no" name="gsp_mobile_no" maxlength="15" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item tab-inner-section m-2 py-2">
                <h2 class="accordion-header mx-2" id="flush-headingFive">
                    <button class="accordion-button py-2 border-0 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
                        Operating Card Details
                    </button>
                </h2>
                <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label for="operation_card_no">Operation Card No</label>
                                <input type="text" id="operation_card_no" name="operation_card_no" maxlength="30" class="form-control">
                            </div>
                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label for="operation_card_issue_date">Operation Card Issue Date</label>
                                <input type="date" class="form-control" id="operation_card_issue_date" name="operation_card_issue_date" />
                            </div>
                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label for="operation_card_expiry_date">Operation Card Expiry Date</label>
                                <input type="date" class="form-control" id="operation_card_expiry_date" name="operation_card_expiry_date" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item tab-inner-section m-2 py-2">
                <h2 class="accordion-header mx-2" id="flush-headingSix">
                    <button class="accordion-button py-2 border-0 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSix" aria-expanded="false" aria-controls="flush-collapseSix">
                        Documents (Attachments)
                    </button>
                </h2>
                <div id="flush-collapseSix" class="accordion-collapse collapse" aria-labelledby="flush-headingSix" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label for="registration_certificate">Registration Certificate</label>
                                <input type="file" name="registration_certificate" id="registration_certificate" class="dropify"
                                        accept=".png, .jpeg, .jpg, .gif, .svg, .webp, .pdf, .doc, .docx, .xls, .xlsx"
                                        data-max-file-size="2M" data-height="100">
                            </div>

                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                <label for="insurance_certificate">Insurance Certificate</label>
                                <input type="file" name="insurance_certificate" id="insurance_certificate" class="dropify"
                                        accept=".png, .jpeg, .jpg, .gif, .svg, .webp, .pdf, .doc, .docx, .xls, .xlsx"
                                        data-max-file-size="2M" data-height="100">
                            </div>

                            <div class="col-md-12 col-sm-12 mb-3 form-group">
                                <label for="attached_file">Vehicle Operation Card</label>
                                <input type="file" name="attached_file" id="attached_file" class="dropify"
                                        accept=".png, .jpeg, .jpg, .gif, .svg, .webp, .pdf, .doc, .docx, .xls, .xlsx"
                                        data-max-file-size="2M" data-height="100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item tab-inner-section m-2 py-2">
                <h2 class="accordion-header mx-2" id="flush-headingSeven">
                    <button class="accordion-button py-2 border-0 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSeven" aria-expanded="false" aria-controls="flush-collapseSeven">
                        Status
                    </button>
                </h2>
                <div id="flush-collapseSeven" class="accordion-collapse border-0 collapse" aria-labelledby="flush-headingSeven" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 mb-3 form-group">
                                <label class="control-label" for="status">Vehicle Status <span class="text-danger">*</span></label>
                                <select name="status" id="vehicle_status" class="form-select">
                                    <option value="">Select Status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="discontinued">Discontinued</option>
                                    <option value="workshop">Workshop</option>
                                </select>
                            </div>

                            <!-- Conditional Reason + Date -->
                            <div class="row reason-date-fields m-0 p-0" style="display: none;">
                                <div class="col-md-12 col-sm-12 mb-3 form-group">
                                    <label for="status_reason">Reason <span class="text-danger">*</span></label>
                                    <select name="status_reason" id="status_reason" class="form-select">
                                        <option value="">Select Reason</option>
                                        <?php foreach (masterReasons('vehicle_reason') as $mreason) { ?>
                                            <option value="<?php echo $mreason->id;?>"><?php echo $mreason->reason_title_en;?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-12 col-sm-12 mb-3 form-group">
                                    <label for="status_date">Date <span class="text-danger">*</span></label>
                                    <input type="date" id="status_date" name="status_date" class="form-control" max="<?= date('Y-m-d'); ?>">
                                </div>
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
            <button form="addVehicleForm" type="submit" id="submitBtn" class="btn btn-success btn-md">Save</button>
            <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-outline-danger btn-md ms-2">Cancel </button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.dropify').dropify();
    });

    $(document).ready(function() {
        var $ownerSelect = $('#owner_name_select');

        // Backup all sponsor options (except the placeholder)
        var sponsorOptions = $ownerSelect.find('option').not(':first').clone();

        function updateOwnerOptions() {
            var ownership = $('#vehicle_ownership').val();
            var selectedOwner = "<?= $vehicle_details['owner_name'] ?? '' ?>";

            $ownerSelect.empty(); // clear all
            $ownerSelect.append('<option value="">Select Vehicle Owner</option>'); // default

            if (ownership === 'Lease') {
                var theebOption = sponsorOptions.filter(function () {
                    return $(this).val().trim() === 'Theeb Rent a Car';
                });

                if (theebOption.length > 0) {
                    var cloned = theebOption.clone();
                    $ownerSelect.append(cloned);
                    $ownerSelect.val('Theeb Rent a Car');
                    $ownerSelect.prop('readonly', true);
                } else {
                    $ownerSelect.append('<option value="Theeb Rent a Car" selected>Theeb Rent a Car</option>');
                    $ownerSelect.prop('readonly', true);
                }
            } else if (ownership === 'Owned') {
                var opts = sponsorOptions.clone();
                $ownerSelect.append(opts);
                $ownerSelect.val(selectedOwner);
                $ownerSelect.prop('readonly', false);
            } else {
                $ownerSelect.prop('readonly', true);
            }
        }

        // Bind on change
        $('#vehicle_ownership').on('change', updateOwnerOptions);

        // Run once on page load
        updateOwnerOptions();
    });

    $(document).ready(function() {
        $(document).ajaxStart(function() {
            $("#wait").css("display", "block");
        });
        $(document).ajaxComplete(function() {
            $("#wait").css("display", "none");
        });
        $(document).ajaxError(function() {
            $("#wait").css("display", "none");
        });
    });

    function validateInsDates() {
        $('#insurance_expiry').val('');
        var startDate = $('#insurance_issue_date').val();
        var endDateInput = document.getElementById("insurance_expiry");
        endDateInput.min = startDate;
        return true;
    }

    $('#vehicle_type').change(function() {
        var service_id = $(this).find('option:selected').val();
        if (service_id == 'bike') {
            $("#vehicle_no").attr("maxlength", "6");
            $("#vehicle_no").attr("minlength", "5");
            $(".vehicle-type").html("Bike");
        } else {
            $("#vehicle_no").attr("maxlength", "7");
            $("#vehicle_no").attr("minlength", "6");
            $(".vehicle-type").html("Car");
        }
        $.ajax({
            url: "<?php echo base_url(); ?>admin/deliveryvehicle/vehicle_make_list",
            data: {
                service_id: service_id
            },
            dataType: "json",
            type: "post",
            success: function(data) {
                var html = '<option value="">Select Vehicle Make</option>';

                if (Object.keys(data).length > 0) {
                    $.each(data, function(index, item) {
                        html += '<option value="' + item.id + '" data-id="' + item.id + '">' + item.make_name + '</option>';
                    });
                } else {
                    var html = '<option value="">No vehicle make found</option>';
                }
                $('#vehicle_make').html(html);
            }
        });
    });

    $('#vehicle_make').change(function() {
        var make_id = $(this).find('option:selected').val();
        $.ajax({
            url: "<?php echo base_url(); ?>admin/deliveryvehicle/get_vehicle_type",
            data: {
                make_id: make_id
            },
            dataType: "json",
            type: "post",
            success: function(data) {
                var html = '<option value="">Select Vehicle Type</option>';

                if (Object.keys(data).length > 0) {
                    $.each(data, function(index, item) {
                        html += '<option value="' + item.vehicle_type + '" data-id="' + item.id + '">' + item.vehicle_type + '</option>';
                    });
                } else {
                    var html = '<option value="">No vehicle type found</option>';
                }
                $('#vehicle_model').html(html);
            }
        });
    });

    $('#vehicle_status').change(function() {
        vehicleReason();
    });

    function vehicleReason() {
        var vehicle_status = $('#vehicle_status').find('option:selected').val();
        //alert(vehicle_status);
        if (vehicle_status == 'inactive') {
            //$("#inactive_reason").attr("required", "true");
            $(".inactive-reason").removeClass("d-none");
        } else {
            //$("#inactive_reason").attr("required", "false");
            $(".inactive-reason").addClass("d-none");
        }
    }

    $('#insurance_no').change(function() {
        getInsuranceDetail();
    });

    function getInsuranceDetail() {
        var policy_id = $('#insurance_no').find('option:selected').val();
        var policy_type = '0';
        $('#insurance_company_name').html('<option value="">Select Policy No. First</option>');
        $('#insurance_issue_date').val('');
        $('#insurance_expiry').val('');
        $('#insurance_class').html('<option value="">Select Policy Class</option>');
        if (policy_id > 0) {
            $.ajax({
                url: "<?php echo base_url(); ?>admin/logistic-masters/Master_vehicle/getPolicyDetail",
                data: {
                    policy_id: policy_id
                },
                dataType: "json",
                type: "POST",
                success: function(data) {
                    console.log(data);

                    // Update company name
                    var company_input = '<option value="' + data.id + '">' + data.company_name + '</option>';
                    $('#insurance_company_name').html(company_input);

                    // Update policy dates
                    $('#insurance_issue_date').val(data.policy_date);
                    $('#insurance_expiry').val(data.policy_expiry);

                    // Update policy class dropdown
                    var classSelectContainer = '<option value="">Select Policy Class</option>';
                    if (data.insurance_type_details && data.insurance_type_details.length > 0) {
                        $.each(data.insurance_type_details, function(index, insuranceType) {
                            var isSelected = (insuranceType.id == policy_type) ? 'selected' : '';
                            classSelectContainer += '<option value="' + insuranceType.id + '" ' + isSelected + '>' + insuranceType.insurance_type + '</option>';
                        });
                    }
                    $('#insurance_class').html(classSelectContainer);
                },
                error: function(request, error) {
                    console.log(" Can't do because: " + JSON.stringify(request));
                },
            });
        }
    }

    $(document).ready(function() {
        $('#gps_installation_date').on('change', function() {
            var installDate = new Date($(this).val());
            if (installDate instanceof Date && !isNaN(installDate)) {
                var expiryDate = new Date(installDate);
                expiryDate.setFullYear(installDate.getFullYear() + 1);
                var yyyy = expiryDate.getFullYear();
                var mm = String(expiryDate.getMonth() + 1).padStart(2, '0'); // Months are zero-based
                var dd = String(expiryDate.getDate()).padStart(2, '0');
                $('#gps_expiry_date').val(`${yyyy}-${mm}-${dd}`);
            } else {
                $('#gps_expiry_date').val(''); // Clear the expiry date if the installation date is invalid
            }
        });
    });

    $(document).ready(function() {
        function toggleGpsFields() {
            if ($('#gps_installed').is(':checked')) {
                $('.gps-fields').show();
                $('.gps-fields input').prop('disabled', false);
            } else {
                $('.gps-fields').hide();
                $('.gps-fields input').prop('disabled', true);
            }
        }

        // Initial check on page load
        toggleGpsFields();

        // On toggle change
        $('#gps_installed').on('change', toggleGpsFields);
    });

    $(document).ready(function() {
        function toggleStatusFields() {
            var selectedStatus = $('#vehicle_status').val();

            if (selectedStatus === 'discontinued' || selectedStatus === 'inactive' || selectedStatus === 'workshop') {
                $('.reason-date-fields').show();
                //$('#status_reason, #status_date').prop('required', true);
            } else {
                $('.reason-date-fields').hide();
                //$('#status_reason, #status_date').prop('required', false).val('');
            }
        }

        // On page load
        toggleStatusFields();

        // On change
        $('#vehicle_status').on('change', toggleStatusFields);
    });

    $("#addVehicleForm").on("submit", function(e) {
        e.preventDefault();

        var $submitBtn = $("#submitBtn");
        var originalBtnHtml = $submitBtn.html();

        // Disable button and show loader
        $submitBtn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

        var formData = new FormData(this);
        $.ajax({
            url: "<?php echo site_url('admin/master-vehicle/submit'); ?>",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(response) {
                if (response.type === "success") {
                    toastr.success(response.message);
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else if (response.type === "error") {
                    toastr.error(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", xhr.responseText, status, error);
                toastr.error('An unexpected error occurred. Please try again.');
            },
            complete: function() {
                // Restore button
                $submitBtn.prop("disabled", false).html(originalBtnHtml);
            }
        });
    });
</script>