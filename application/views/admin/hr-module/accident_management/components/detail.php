<style> 
#responseContainer{
	position: fixed;
    width: 93%;
    top: 60px;
}
.size-inner-section .form-group p{
	background: #ededed;
    padding-top: 10px;
}
</style>
<div class="modal-header">
	<h5 class="modal-title mt-0">Accident Detail</h5>
	<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body px-2">
	<div class="row size-inner-section px-2 py-4 mx-2">
        <h4 class="header-title">Vehicles Information</h4><hr>
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
    <!-- Tab panes -->
    <div class="row size-inner-section px-2 py-4 mx-2">
        <h4 class="header-title">Driver Information</h4><hr>
        <div class="size-inner-section px-1 py-1 mx-1">
            <div class="card-header">Driver Detail</div>
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

    <!---- Insurance Detail ----->
    <div class="row size-inner-section px-2 py-4 mx-2">
        <h4 class="header-title">Insurance Details</h4><hr>
        <?php if(!empty($vehicle_detail)){ ?>
        <div class="col-md-6 col-sm-12 form-group">
            <label for="insurance_provider">Insurance Service Provider :</label>
            <input type="hidden" id="insurance_provider" name="insurance_provider" value="<?php echo $vehicle_detail['insurance_company_name'];?>" required />
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

    <div class="row size-inner-section px-2 py-4 mx-2">
        <h4 class="header-title">Accident Report</h4><hr>
        <div class="col-md-6 col-sm-12 form-group">
            <label for="accident_date">Accident Date </label>
            <p class="form-control"><b><?php echo ($accident_detail['accident_date'] !== '' && $accident_detail['accident_date'] !== '0000-00-00') ? formatedDate($accident_detail['accident_date']) : 'NA';?></b></p>
        </div>
        <div class="col-md-6 col-sm-12 form-group">
            <label for="accident_time">Accident Time <span class="required-field">*</span></label>
            <p class="form-control"><b><?php echo ($accident_detail['accident_time'] !== '' && $accident_detail['accident_time'] !== '00:00:00') ? $accident_detail['accident_time'] : 'NA';?></b></p>
        </div>
        <div class="col-md-6 col-sm-12 form-group">
            <label for="accident_location">Accident Location <span class="required-field">*</span></label>
            <p class="form-control"><b><?php echo ($accident_detail['accident_location'] !== '' && $accident_detail['accident_location'] !== NULL) ? $accident_detail['accident_location'] : 'NA';?></b></p>
        </div>
        <div class="col-md-6 col-sm-12 form-group">
            <label for="accident_attended_by">Accident Attended By </label>
            <select name="accident_attended_by" id="accident_attended_by" class="form-control" disabled>
                <option value="">Select Iqama Status</option>
                <option value="Najam" <?php echo ($accident_detail['accident_attended_by'] == 'Najam') ? 'selected' : '';?>>Najam</option>
                <option value="Morror" <?php echo ($accident_detail['accident_attended_by'] == 'Morror') ? 'selected' : '';?>>Morror</option>
            </select>
        </div>
        <div class="col-md-12 col-sm-12 form-group">
            <label for="ambulance">Ambulance</label>
            <p class="form-control"><b><?php echo ($accident_detail['ambulance'] !== '' && $accident_detail['ambulance'] !== NULL) ? $accident_detail['ambulance'] : 'NA';?></b></p>
        </div>
        <div class="col-md-12 col-sm-12 form-group">
            <label for="injury_description">Injury Description</label>
            <p class="form-control"><b><?php echo ($accident_detail['injury_description'] !== '' && $accident_detail['injury_description'] !== NULL) ? $accident_detail['injury_description'] : 'NA';?></b></p>
        </div>
        
    </div>

    <div class="row size-inner-section px-2 py-4 mx-2">
        <h4 class="header-title">Reports</h4><hr>
        <?php if($accident_detail['accident_attended_by'] == 'Najam'){ ?>
        <div class="col-md-6 col-sm-12 form-group najam-relation">
            <label for="hhdr_report_no">HHDR Report No </label>
            <input type="text" class="form-control" id="hhdr_report_no" name="hhdr_report_no" value="<?php echo $accident_detail['hhdr_report_no'];?>" maxlength="25" disabled />
        </div>
        <div class="col-md-6 col-sm-12 form-group najam-relation">
            <label for="hhdr_report_attachment">HHDR Report Attachment</label>
            <p class="form-control"><b><?php echo ($accident_detail['hhdr_report_attachment'] !== '' && $accident_detail['hhdr_report_attachment'] !== NULL) ? '<a href="'.$accident_detail['hhdr_report_attachment'].'" target="_blank">View Attachment</a>' : 'NA';?></b></p>
        </div>

        <div class="col-md-6 col-sm-12 form-group najam-relation">
            <label for="ld_report_no">LD Report Number</label>
            <p class="form-control"><b><?php echo ($accident_detail['ld_report_no'] !== '' && $accident_detail['ld_report_no'] !== NULL) ? $accident_detail['ld_report_no'] : 'NA';?></b></p>
        </div>
        <div class="col-md-6 col-sm-12 form-group najam-relation">
            <label for="ld_report_attachment">LD Report Attachment</label>
            <p class="form-control"><b><?php echo ($accident_detail['ld_report_attachment'] !== '' && $accident_detail['ld_report_attachment'] !== NULL) ? '<a href="'.$accident_detail['ld_report_attachment'].'" target="_blank">View Attachment</a>' : 'NA';?></b></p>
        </div>
        <?php } ?>
        
        <?php if($accident_detail['accident_attended_by'] == 'Morror'){ ?>
        <div class="col-md-6 col-sm-12 form-group maroor-relation">
            <label for="maroor_report_no">Morror Report No </label>
            <input type="text" class="form-control" id="maroor_report_no" name="maroor_report_no" value="<?php echo $accident_detail['maroor_report_no'];?>" disabled />
        </div>
        <div class="col-md-6 col-sm-12 form-group maroor-relation">
            <label for="attach_maroor_report">Attach Morror Report</label>
            <p class="form-control"><b><?php echo ($accident_detail['attach_maroor_report'] !== '' && $accident_detail['attach_maroor_report'] !== NULL) ? '<a href="'.$accident_detail['attach_maroor_report'].'" target="_blank">View Attachment</a>' : 'NA';?></b></p>
        </div>
        <?php } ?>
    </div>

    <div class="row size-inner-section px-2 py-4 mx-2">
        <h4 class="header-title">Taqdeer Information</h4><hr>
        <div class="col-md-6 col-sm-12 form-group">
            <label for="taqdeer_inspection_date">Taqdeer Inspection Date </label>
            <p class="form-control"><b><?php echo ($accident_detail['taqdeer_inspection_date'] !== '' && $accident_detail['taqdeer_inspection_date'] !== '0000-00-00') ? formatedDate($accident_detail['taqdeer_inspection_date']) : 'NA';?></b></p>
        </div>

        <div class="col-md-6 col-sm-12 form-group">
            <label for="da_final_report_no">DA Final Report No</label>
            <input type="text" class="form-control" id="da_final_report_no" name="da_final_report_no" minlength="12" value="<?php echo $accident_detail['da_final_report_no'];?>" maxlength="12" disabled />
        </div>
        <div class="col-md-6 col-sm-12 form-group">
            <label for="attach_da_final_report">Attach DA Final Report</label>
            <p class="form-control"><b><?php echo ($accident_detail['attach_da_final_report'] !== '' && $accident_detail['attach_da_final_report'] !== NULL) ? '<a href="'.$accident_detail['attach_da_final_report'].'" target="_blank">View Attachment</a>' : 'NA';?></b></p>
        </div>
        <div class="col-md-6 col-sm-12 form-group">
            <label for="da_liability_perc">DA Liability %</label>
            <input type="text" class="form-control" id="da_liability_perc" name="da_liability_perc" value="<?php echo $accident_detail['da_liability_perc'];?>" disabled />
        </div>
        
    </div>
    
    <div class="row size-inner-section px-2 py-4 mx-2">
        <h4 class="header-title">Fees & Expenses</h4><hr>
        <div class="col-md-6 col-sm-12 mb-2 form-group">
            <label for="taqdeer_da_fees">Taqdeer DA Fees </label>
            <input type="text" class="form-control" id="taqdeer_da_fees" name="taqdeer_da_fees" value="<?php echo $accident_detail['taqdeer_da_fees'];?>" disabled />
        </div>
        <div class="col-md-6 col-sm-12 mb-2 form-group">
            <label for="insurance_claim_fees">Insurance Claim Fees </label>
            <input type="text" class="form-control" id="insurance_claim_fees" name="insurance_claim_fees" value="<?php echo $accident_detail['insurance_claim_fees'];?>" disabled />
        </div>
        <div class="col-md-6 col-sm-12 mb-2 form-group">
            <label for="other_cost">Other Cost </label>
            <input type="text" class="form-control" id="other_cost" name="other_cost" value="<?php echo $accident_detail['other_cost'];?>" disabled />
        </div>
        <div class="col-md-6 col-sm-12 mb-2 form-group">
            <label for="final_assessment_cost">Final Assessment Cost </label>
            <input type="text" class="form-control" id="final_assessment_cost" name="final_assessment_cost" value="<?php echo $accident_detail['final_assessment_cost'];?>" disabled />
        </div>
        <div class="col-md-6 col-sm-12 mb-2 form-group">
            <label for="created_at">Created At </label>
            <p class="form-control"><b><?php echo ($accident_detail['created_at'] !== '' && $accident_detail['created_at'] !== '0000-00-00') ? formatedDateTime($accident_detail['created_at']) : 'NA';?></b></p>
        </div>
        <div class="col-md-6 col-sm-12 mb-2 form-group">
            <label for="updated_at">Last Updated </label>
            <p class="form-control"><b><?php echo ($accident_detail['updated_at'] !== '' && $accident_detail['updated_at'] !== '0000-00-00' && $accident_detail['updated_at'] !== NULL) ? formatedDateTime($accident_detail['updated_at']) : 'NA';?></b></p>
        </div>
    </div>

    <div class="row size-inner-section px-2 py-4 mx-2">
        <table class="table table-bordered" id="attachmentTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Document Name</th>
                    <th>File</th>
                </tr>
            </thead>
            <tbody id="attachmentBody">
                <?php if (!empty($accident_attachments)) : ?>
                    <?php foreach ($accident_attachments as $index => $attachment) : ?>
                        <tr>
                            <td class="sr-no"><?= $index + 1 ?></td>
                            <td>
                                <input type="text" name="document_name_existing[]" class="form-control" value="<?= htmlspecialchars($attachment['document_name']) ?>" disabled>
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
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>

        </table>
    </div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetModalData()">Close</button>
</div>

