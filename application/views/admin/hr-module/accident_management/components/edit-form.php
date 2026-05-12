<style> 
#responseContainer{
	position: fixed;
    width: 93%;
    top: 60px;
}
.najam-relation, .maroor-relation {
    display: none;
}
#accident_form .form-group p{
	background: #ededed;
    padding-top: 10px;
}
.accordion-button:not(.collapsed) {
    color: #052738;
    background-color: #eaedf1;
}
.upload-box {
    width: 70px;
    height: 40px;
    border: 2px dashed #ccc;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    position: relative;
    background-color: #f9f9f9;
}

.upload-box:hover {
    background-color: #e9e9e9;
}

.upload-box span {
    font-size: 28px;
    color: #888;
    font-weight: bold;
}
.hidden-file {
    display: none;
}
</style>
<div class="modal-header">
	<h5 class="modal-title mt-0">Edit Accident Detail</h5>
	<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body px-2">
    <div class="progress mt-3" style="height: 20px; display: none;" id="uploadProgressContainer">
		<div id="uploadProgress" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;">
			0%
		</div>
	</div>
    <form id="accident_form" action="<?php echo base_url('admin/hr/accident-management/update');?>" method="post" enctype="multipart/form-data" class="form-label-left" data-parsley-validate="" accept-charset="utf-8">
        <input type="hidden" id="id" name="id" value="<?php echo $accident_detail['id'];?>" required />
        <input type="hidden" id="emp_id" name="employee_id" value="<?php echo $accident_detail['employee_id'];?>" required />
        <input type="hidden" id="vehicle_id" name="vehicle_id" value="<?php echo $accident_detail['vehicle_id'];?>" required />
        <div class="accordion m-2 rounded-3" id="accidentVehicleAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header m-2 rounded" id="accidentVehicleHeading">
                <button class="accordion-button p-2 border-0 rounded" type="button" data-bs-toggle="collapse" data-bs-target="#accidentVehicleCollapse" aria-expanded="true" aria-controls="accidentVehicleCollapse">
                    Vehicle Information
                </button>
                </h2>
                <div id="accidentVehicleCollapse" class="accordion-collapse border-0 collapse show" aria-labelledby="accidentVehicleHeading" data-bs-parent="#accidentVehicleAccordion">
                    <div class="accordion-body">
                        <div class="row">
                            <?php if(!empty($vehicle_detail)){ ?>
                            <div class="col-md-6 col-sm-12 form-group">
                                <label for="iqama_no">Vehicle Plate No :</label>
                                <p class="form-control"><b><?php echo $vehicle_detail['vehicle_no'];?></b></p>
                            </div>
                            <div class="col-md-6 col-sm-12 form-group">
                                <label for="iqama_name_en">Vehicle Make :</label>
                                <p class="form-control"><b><?php echo $vehicle_detail['make_name'];?></b></p>
                            </div>
                            <div class="col-md-6 col-sm-12 form-group">
                                <label for="iqama_name_ar">Vehicle Model :</label>
                                <p class="form-control"><b><?php echo $vehicle_detail['vehicle_model'];?></b></p>
                            </div>
                            <div class="col-md-6 col-sm-12 form-group">
                                <label for="iqama_issue_date">Vehicle Year :</label>
                                <p class="form-control"><b><?php echo $vehicle_detail['vehicle_year'];?></b></p>
                            </div>
                            <div class="col-md-6 col-sm-12 form-group">
                                <label for="iqama_issue_date">Vehicle Ownership :</label>
                                <p class="form-control"><b><?php echo $vehicle_detail['vehicle_ownership'];?></b></p>
                            </div>
                            <?php }else{ ?>
                                <div class="col-md-12">No vehicle data found.</div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!---- Insurance Detail ----->
        <div class="accordion m-2 rounded-3" id="accidentInsuranceAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header m-2 rounded" id="accidentInsuranceHeading">
                <button class="accordion-button p-2 border-0 rounded" type="button" data-bs-toggle="collapse" data-bs-target="#accidentInsuranceCollapse" aria-expanded="true" aria-controls="accidentInsuranceCollapse">
                    Insurance Details
                </button>
                </h2>
                <div id="accidentInsuranceCollapse" class="accordion-collapse border-0 collapse show" aria-labelledby="accidentInsuranceHeading" data-bs-parent="#accidentInsuranceAccordion">
                    <div class="accordion-body">
                        <div class="row">
                            <?php if(!empty($vehicle_detail)){ ?>
                            <div class="col-md-6 col-sm-12 form-group">
                                <label for="insurance_provider">Insurance Service Provider :</label>
                                <input type="hidden" id="insurance_provider" name="insurance_provider" value="<?php echo $vehicle_detail['insurance_company_name'];?>" />
                                <p class="form-control"><b><?php echo ($vehicle_detail['company_name'] !== '' && $vehicle_detail['company_name'] !== NULL) ? $vehicle_detail['company_name'] : 'NA';?></b></p>
                            </div>

                            <div class="col-md-6 col-sm-12 form-group">
                                <label for="ins_policy_no">Insurance Policy Number :</label>
                                <input type="hidden" id="ins_policy_no" name="ins_policy_no" value="<?php echo $vehicle_detail['insurance_no'];?>" />
                                <p class="form-control"><b><?php echo ($vehicle_detail['policy_number'] !== '' && $vehicle_detail['policy_number'] !== NULL) ? $vehicle_detail['policy_number'] : 'NA';?></b></p>
                            </div>

                            <div class="col-md-6 col-sm-12 form-group">
                                <label for="ins_start_date">Insurance Start Date :</label>
                                <input type="hidden" id="ins_start_date" name="ins_start_date" value="<?php echo $vehicle_detail['insurance_issue_date'];?>" />
                                <p class="form-control"><b><?php echo ($vehicle_detail['insurance_issue_date'] !== '' && $vehicle_detail['insurance_issue_date'] !== '0000-00-00') ? formatedDate($vehicle_detail['insurance_issue_date']) : 'NA';?></b></p>
                            </div>

                            <div class="col-md-6 col-sm-12 form-group">
                                <label for="ins_end_date">Insurance End Date :</label>
                                <input type="hidden" id="ins_end_date" name="ins_end_date" value="<?php echo $vehicle_detail['insurance_expiry'];?>" />
                                <p class="form-control"><b><?php echo ($vehicle_detail['insurance_expiry'] !== NULL && $vehicle_detail['insurance_expiry'] !== '' && $vehicle_detail['insurance_expiry'] !== '0000-00-00') ? formatedDate($vehicle_detail['insurance_expiry']) : 'NA';?></b></p>
                            </div>
                            
                            <div class="col-md-6 col-sm-12 form-group">
                                <label for="ins_status">Insurance Status <span class="required-field">*</span></label>
                                <?php
                                    $ins_end_date = $vehicle_detail['insurance_expiry'];
                                    $date1 = strtotime(date('Y-m-d'));
                                    $date2 = strtotime($ins_end_date);
                                    if($ins_end_date !== '' && $ins_end_date !== '0000-00-00'){
                                        if ($date1 < $date2) {
                                            $ins_stattus = '<input type="hidden" name="ins_status" value="Active" required /><p class="form-control text-success"><b>Active</b></p>';
                                        } else {
                                            $ins_stattus = '<input type="hidden" name="ins_status" value="Expired" required /><p class="form-control text-danger"><b>Expired</b></p>';
                                        }
                                    }else{
                                        $ins_stattus = '<p class="form-control"><b>NA</b></p>';
                                    }
                                    
                                ?>
                                <?php echo $ins_stattus;?>
                            </div>
                            <?php }else{ ?>
                                <div class="col-md-12">No insurance data found.</div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tab panes -->
        <div class="accordion m-2 rounded-3" id="accidentDriverAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header m-2 rounded" id="accidentDriverHeading">
                <button class="accordion-button p-2 border-0 rounded" type="button" data-bs-toggle="collapse" data-bs-target="#accidentDriverCollapse" aria-expanded="true" aria-controls="accidentDriverCollapse">
                    Driver Information
                </button>
                </h2>
                <div id="accidentDriverCollapse" class="accordion-collapse border-0 collapse show" aria-labelledby="accidentDriverHeading" data-bs-parent="#accidentDriverAccordion">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="d-flex align-items-center employee-detail">
                                <div class="image">
                                    <?php if(!empty($emp_detail['employee_pic']) && $emp_detail['employee_pic'] !== ''){ ?>
                                        <img src="<?php echo $emp_detail['employee_pic'];?>" class="rounded" width="100">
                                    <?php }else{ ?>
                                        <img src="<?php echo base_url('images/user-img.png'); ?>" class="rounded" width="100">
                                    <?php } ?>
                                </div>
                                <div class="p-3 w-100">
                                    <h5 class="mb-0 mt-0"> <?php echo $emp_detail['full_name'];?> / <?php echo $emp_detail['employee_arabic_name'];?> </h5>
                                    <span><?php echo $emp_detail['designation_name'];?> | <?php echo $emp_detail['department_name'];?></span>
                                    <hr class="my-1">
                                    <table>
                                        <tr>
                                            <td>Emp No.</td>
                                            <td> : </td>
                                            <td><?php echo $emp_detail['emp_no'];?></td>
                                        </tr>
                                        <tr>
                                            <td>Nationality</td>
                                            <td> : </td>
                                            <td><?php echo $emp_detail['nationality_name'];?></td>
                                        </tr>
                                        <tr>
                                            <td>Flex Number</td>
                                            <td> : </td>
                                            <td><?php echo (!empty($sim_detail['mobile'])) ? $sim_detail['mobile'] : 'NA';?></td>
                                        </tr>
                                        <tr>
                                            <td>Mobile No</td>
                                            <td> : </td>
                                            <td><?php echo $emp_detail['mobile'];?></td>
                                        </tr>
                                        <tr>
                                            <td>DL Number</td>
                                            <td> : </td>
                                            <td><?php if(!empty($other_detail['driving_license_number'])){ echo $other_detail['driving_license_number'];}else{ echo 'NA';}?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="accordion m-2 rounded-3" id="accidentReportAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header m-2 rounded" id="accidentReportHeading">
                <button class="accordion-button p-2 border-0 rounded" type="button" data-bs-toggle="collapse" data-bs-target="#accidentReportCollapse" aria-expanded="true" aria-controls="accidentReportCollapse">
                    Accident Report
                </button>
                </h2>
                <div id="accidentReportCollapse" class="accordion-collapse border-0 collapse show" aria-labelledby="accidentReportHeading" data-bs-parent="#accidentReportAccordion">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 form-group">
                                <label for="accident_date">Accident Date </label>
                                <input type="date" class="form-control" id="accident_date" name="accident_date" value="<?php echo $accident_detail['accident_date'];?>" required />
                            </div>
                            <div class="col-md-6 col-sm-12 form-group mb-2">
                                <label for="accident_time">Accident Time <span class="required-field">*</span></label>
                                <input type="time" class="form-control" id="accident_time" name="accident_time" value="<?php echo ($accident_detail['accident_time'] !== '' && $accident_detail['accident_time'] !== '00:00:00') ? $accident_detail['accident_time'] : '';?>" required />
                            </div>
                            <div class="col-md-6 col-sm-12 form-group mb-2">
                                <label for="accident_location">Accident Location <span class="required-field">*</span></label>
                                <input type="text" class="form-control" id="accident_location" name="accident_location" value="<?php echo ($accident_detail['accident_location'] !== '' && $accident_detail['accident_location'] !== NULL) ? $accident_detail['accident_location'] : '';?>" required />
                            </div>
                            <div class="col-md-6 col-sm-12 form-group">
                                <label for="accident_attended_by">Accident Attended By </label>
                                <select name="accident_attended_by" id="accident_attended_by" class="form-control form-select">
                                    <option value="">Select Iqama Status</option>
                                    <option value="Najam" <?php echo ($accident_detail['accident_attended_by'] == 'Najam') ? 'selected' : '';?>>Najam</option>
                                    <option value="Morror" <?php echo ($accident_detail['accident_attended_by'] == 'Morror') ? 'selected' : '';?>>Morror</option>
                                    <option value="Police" <?php echo ($accident_detail['accident_attended_by'] == 'Police') ? 'selected' : '';?>>Police</option>
                                </select>
                            </div>
                            <div class="col-md-12 col-sm-12 form-group mb-2">
                                <label for="ambulance">Ambulance</label>
                                <input type="text" class="form-control" id="ambulance" name="ambulance" value="<?php echo ($accident_detail['ambulance'] !== '' && $accident_detail['ambulance'] !== NULL) ? $accident_detail['ambulance'] : '';?>" />
                            </div>
                            <div class="col-md-12 col-sm-12 form-group mb-2">
                                <label for="injury_description">Injury Description</label>
                                <textarea id="injury_description" name="injury_description" class="form-control" rows="4" placeholder="Describe the injury in detail..."><?php echo $accident_detail['injury_description'];?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="accordion m-2 rounded-3" id="accidentReportsAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header m-2 rounded" id="accidentReportsHeading">
                <button class="accordion-button p-2 border-0 rounded" type="button" data-bs-toggle="collapse" data-bs-target="#accidentReportsCollapse" aria-expanded="true" aria-controls="accidentReportsCollapse">
                    Reports
                </button>
                </h2>
                <div id="accidentReportsCollapse" class="accordion-collapse border-0 collapse show" aria-labelledby="accidentReportsHeading" data-bs-parent="#accidentReportsAccordion">
                    <div class="accordion-body">
                        <div class="row">
                            <?php if($accident_detail['accident_attended_by'] == 'Najam'){ ?>
                            <div class="col-md-6 col-sm-12 form-group najam-relation">
                                <label for="hhdr_report_no">HHDR Report No </label>
                                <input type="text" class="form-control" id="hhdr_report_no" name="hhdr_report_no" value="<?php echo $accident_detail['hhdr_report_no'];?>" maxlength="25" />
                            </div>
                            <div class="col-md-6 col-sm-12 form-group najam-relation">
                                <label for="hhdr_report_attachment">HHDR Report Attachment</label>
                                <input type="hidden" name="old_hhdr_report_attachment" value="<?php echo $accident_detail['hhdr_report_attachment'];?>" />
                                <input type="file" class="form-control" id="hhdr_report_attachment" name="hhdr_report_attachment" value="" />
                                <?php echo ($accident_detail['hhdr_report_attachment'] !== '' && $accident_detail['hhdr_report_attachment'] !== NULL) ? '<a href="'.$accident_detail['hhdr_report_attachment'].'" target="_blank">View Attach HHDR Report</a>' : 'NA';?>
                            </div>

                            <div class="col-md-6 col-sm-12 form-group najam-relation">
                                <label for="ld_report_no">LD Report Number</label>
                                <input type="text" class="form-control" id="ld_report_no" name="ld_report_no" minlength="12" maxlength="12" value="<?php echo $accident_detail['ld_report_no'];?>" />
                            </div>
                            <div class="col-md-6 col-sm-12 form-group najam-relation">
                                <label for="ld_report_attachment">LD Report Attachment</label>
                                <input type="hidden" name="old_ld_report_attachment" value="<?php echo $accident_detail['ld_report_attachment'];?>" />
                                <input type="file" class="form-control" id="ld_report_attachment" name="ld_report_attachment" value="" />
                                <?php echo ($accident_detail['ld_report_attachment'] !== '' && $accident_detail['ld_report_attachment'] !== NULL) ? '<a href="'.$accident_detail['ld_report_attachment'].'" target="_blank">View Uploaded LD Report</a>' : 'NA';?>
                            </div>
                            <?php } ?>
                            
                            <?php if($accident_detail['accident_attended_by'] == 'Morror'){ ?>
                            <div class="col-md-6 col-sm-12 form-group maroor-relation">
                                <label for="maroor_report_no">Morror Report No </label>
                                <input type="text" class="form-control" id="maroor_report_no" name="maroor_report_no" value="<?php echo $accident_detail['maroor_report_no'];?>" />
                            </div>
                            <div class="col-md-6 col-sm-12 form-group maroor-relation">
                                <label for="attach_maroor_report">Attach Morror Report</label>
                                <input type="hidden" name="old_attach_maroor_report" value="<?php echo $accident_detail['attach_maroor_report'];?>" />
                                <input type="file" class="form-control" id="attach_maroor_report" name="attach_maroor_report" value="" />
                                <?php echo ($accident_detail['attach_maroor_report'] !== '' && $accident_detail['attach_maroor_report'] !== NULL) ? '<a href="'.$accident_detail['attach_maroor_report'].'" target="_blank">View Attach Morror Report</a>' : 'NA';?>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="accordion m-2 rounded-3" id="accidentTaqdeerAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header m-2 rounded" id="accidentTaqdeerHeading">
                <button class="accordion-button p-2 border-0 rounded" type="button" data-bs-toggle="collapse" data-bs-target="#accidentTaqdeerCollapse" aria-expanded="true" aria-controls="accidentTaqdeerCollapse">
                    Taqdeer Information
                </button>
                </h2>
                <div id="accidentTaqdeerCollapse" class="accordion-collapse border-0 collapse show" aria-labelledby="accidentTaqdeerHeading" data-bs-parent="#accidentTaqdeerAccordion">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 form-group mb-2">
                                <label for="taqdeer_inspection_date">Taqdeer Inspection Date </label>
                                <input type="date" class="form-control" id="taqdeer_inspection_date" name="taqdeer_inspection_date" value="<?php echo $accident_detail['taqdeer_inspection_date'];?>" />
                            </div>

                            <div class="col-md-6 col-sm-12 form-group mb-2">
                                <label for="da_final_report_no">DA Final Report No</label>
                                <input type="text" class="form-control" id="da_final_report_no" name="da_final_report_no" minlength="12" maxlength="12" value="<?php echo $accident_detail['da_final_report_no'];?>" />
                            </div>
                            <div class="col-md-6 col-sm-12 form-group mb-2">
                                <label for="attach_da_final_report">Attach DA Final Report</label>
                                <input type="hidden" name="old_attach_da_final_report" value="<?php echo $accident_detail['attach_da_final_report'];?>" />
                                <input type="file" class="form-control" id="attach_da_final_report" name="attach_da_final_report" value="" />
                                <?php echo ($accident_detail['attach_da_final_report'] !== '' && $accident_detail['attach_da_final_report'] !== NULL) ? '<a href="'.$accident_detail['attach_da_final_report'].'" target="_blank">View Uploaded DA Final Report</a>' : 'NA';?>
                            </div>
                            <div class="col-md-6 col-sm-12 form-group mb-2">
                                <label for="da_liability_perc">DA Liability %</label>
                                <input type="text" class="form-control" id="da_liability_perc" name="da_liability_perc" value="<?php echo $accident_detail['da_liability_perc'];?>" />
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
                        
        <div class="accordion m-2 rounded-3" id="accidentFeesAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header m-2 rounded" id="accidentFeesHeading">
                <button class="accordion-button p-2 border-0 rounded" type="button" data-bs-toggle="collapse" data-bs-target="#accidentFeesCollapse" aria-expanded="true" aria-controls="accidentFeesCollapse">
                    Fees & Expenses
                </button>
                </h2>
                <div id="accidentFeesCollapse" class="accordion-collapse border-0 collapse show" aria-labelledby="accidentFeesHeading" data-bs-parent="#accidentFeesAccordion">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 mb-2 form-group">
                                <label for="taqdeer_da_fees">Taqdeer DA Fees </label>
                                <input type="text" class="form-control" id="taqdeer_da_fees" name="taqdeer_da_fees" value="<?php echo $accident_detail['taqdeer_da_fees'];?>" />
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2 form-group">
                                <label for="insurance_claim_fees">Insurance Claim Fees </label>
                                <input type="text" class="form-control" id="insurance_claim_fees" name="insurance_claim_fees" value="<?php echo $accident_detail['insurance_claim_fees'];?>" />
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2 form-group">
                                <label for="other_cost">Other Cost </label>
                                <input type="text" class="form-control" id="other_cost" name="other_cost" value="<?php echo $accident_detail['other_cost'];?>" />
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2 form-group">
                                <label for="final_assessment_cost">Final Assessment Cost </label>
                                <input type="text" class="form-control" id="final_assessment_cost" name="final_assessment_cost" value="<?php echo $accident_detail['final_assessment_cost'];?>" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="accordion m-2 rounded-3" id="accidentAttachmentsAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header m-2 rounded" id="accidentAttachmentsHeading">
                <button class="accordion-button p-2 border-0 rounded" type="button" data-bs-toggle="collapse" data-bs-target="#accidentAttachmentsCollapse" aria-expanded="true" aria-controls="accidentAttachmentsCollapse">
                    Attachments
                </button>
                </h2>
                <div id="accidentAttachmentsCollapse" class="accordion-collapse border-0 collapse show" aria-labelledby="accidentAttachmentsHeading" data-bs-parent="#accidentAttachmentsAccordion">
                    <div class="accordion-body">
                        <div class="row">
                            <table class="table table-bordered" id="attachmentTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Document Name</th>
                                        <th>File</th>
                                        <th><button type="button" class="btn btn-success btn-sm" onclick="addAttachmentRow()">+</button></th>
                                    </tr>
                                </thead>
                                <tbody id="attachmentBody">
                                    <?php if (!empty($accident_attachments)) : ?>
                                        <?php foreach ($accident_attachments as $index => $attachment) : ?>
                                            <tr>
                                                <td class="sr-no"><?= $index + 1 ?></td>
                                                <td>
                                                    <input type="text" name="document_name_existing[]" class="form-control" value="<?= htmlspecialchars($attachment['document_name']) ?>">
                                                    <input type="hidden" name="attachment_id[]" value="<?= $attachment['id'] ?>">
                                                </td>
                                                <td>
                                                    <input type="hidden" name="existing_attachment[]" value="<?= $attachment['attachment'] ?>">
                                                    <?php if (!empty($attachment['attachment'])) : ?>
                                                        <a href="<?= $attachment['attachment'] ?>" target="_blank">
                                                            <div class="upload-box">
                                                                <div class="mt-1"><i class="dripicons-paperclip"></i></div>
                                                            </div>
                                                        </a>
                                                    <?php endif; ?>
                                                </td>

                                                <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">−</button></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td class="sr-no">1</td>
                                            <td><input type="text" name="document_name[]" class="form-control"></td>
                                            <td>
                                                <div class="upload-box" onclick="this.querySelector('input').click()">
                                                    <span><i class="mdi mdi-cloud-upload-outline"></i></span>
                                                    <input type="file" name="document_file_new[]" class="hidden-file">
                                                </div>
                                            </td>
                                            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">−</button></td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetModalData()">Close</button>
    <button form="accident_form" type="submit" class="btn btn-custom-success">Save</button>
</div>

<script>
    $(document).ready(function() {
		showHideAttend();
        // Handler for dropdown change
        $("#accident_attended_by").change(function() {
            var selectedValue = $(this).val();
            var najamShowHide = $(".najam-relation");
            var maroorShowHide = $(".maroor-relation");

            if (selectedValue === "Najam") {
                maroorShowHide.hide();
                najamShowHide.show();
				$('#hhdr_report_no').attr('required', 'required');
				$('#maroor_report_no').removeAttr('required', 'required');
                $('#ld_report_no, #ld_report_attachment').prop('required', false);
            } else {
				najamShowHide.hide();
                maroorShowHide.show();
				$('#maroor_report_no').removeAttr('required', 'required');
				$('#hhdr_report_no').attr('required', 'required');
            }
        });
    });

	function showHideAttend() {
		var selectedValue = '<?php echo $accident_detail['accident_attended_by'];?>';
		var najamShowHide = $(".najam-relation");
		var maroorShowHide = $(".maroor-relation");

		if (selectedValue === "Najam") {
			maroorShowHide.hide();
			najamShowHide.show();
			$('#hhdr_report_no').attr('required', 'required');
			$('#maroor_report_no').removeAttr('required', 'required');
            $('#ld_report_no, #ld_report_attachment').prop('required', false);
		} else {
			najamShowHide.hide();
			maroorShowHide.show();
			$('#maroor_report_no').removeAttr('required', 'required');
			$('#hhdr_report_no').attr('required', 'required');
		}
	}

    function addAttachmentRow() {
        const tbody = document.getElementById("attachmentBody");
        const rowCount = tbody.rows.length;
        const newRow = tbody.insertRow();

        newRow.innerHTML = `
            <td class="sr-no">${rowCount + 1}</td>
            <td><input type="text" name="document_name[]" class="form-control"></td>
            <td><div class="upload-box" onclick="this.querySelector('input').click()"><span><i class="mdi mdi-cloud-upload-outline"></i></span><input type="file" name="document_file_new[]" class="hidden-file"></div></td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">−</button></td>
        `;

        updateSrNo();
    }

    function removeRow(button) {
        const row = button.closest("tr");
        const tbody = row.parentElement;
        tbody.removeChild(row);
        updateSrNo();
    }

    function updateSrNo() {
        const srNoCells = document.querySelectorAll("#attachmentBody .sr-no");
        srNoCells.forEach((cell, index) => {
            cell.textContent = index + 1;
        });
    }

    $(document).ready(function () {
		$('#accident_form').submit(function (e) {
			e.preventDefault();
			var formData = new FormData($(this)[0]);

			// Disable buttons
			$('#cancelBtn, #saveBtn').prop('disabled', true);

			// Show progress bar
			$('#uploadProgressContainer').show();
			$('#uploadProgress').css('width', '0%').text('0%');

			$.ajax({
				url: '<?php echo base_url('admin/hr/accident-management/update'); ?>',
				type: 'POST',
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				xhr: function () {
					var xhr = new window.XMLHttpRequest();
					xhr.upload.addEventListener("progress", function (evt) {
						if (evt.lengthComputable) {
							var percentComplete = Math.round((evt.loaded / evt.total) * 100);
							$('#uploadProgress').css('width', percentComplete + '%').text(percentComplete + '%');
						}
					}, false);
					return xhr;
				},
				success: function (response) {
					if (response.type === 'success') {
						toastr.success(response.message);
						$('#searchResult').html('');
						setTimeout(function () {
							window.location.href = "<?php echo base_url('admin/hr/accident-management'); ?>";
						}, 1000);
					} else {
						toastr.error(response.message);
					}
					// Reset progress & enable buttons
					$('#uploadProgressContainer').hide();
					$('#uploadProgress').css('width', '0%').text('0%');
					$('#cancelBtn, #saveBtn').prop('disabled', false);
				},
				error: function () {
					toastr.error('An error occurred. Please try again.');
					// Reset progress & enable buttons
					$('#uploadProgressContainer').hide();
					$('#uploadProgress').css('width', '0%').text('0%');
					$('#cancelBtn, #saveBtn').prop('disabled', false);
				}
			});
		});
	});
</script>