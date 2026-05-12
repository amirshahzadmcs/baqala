<style> 
.najam-relation, .maroor-relation {
    display: none;
}
.size-inner-section .form-group p{
	background: #ededed;
    padding-top: 10px;
}
</style>
<div>
    <input type="hidden" id="emp_id" name="employee_id" value="<?php echo $emp_detail['id'];?>" required />
    <input type="hidden" id="vehicle_id" name="vehicle_id" value="<?php echo $vehicle_detail['id'];?>" required />
    <!-- Tab panes -->
    <div class="row size-inner-section px-2 py-4 mx-2">
        <h4 class="header-title">Employee Details</h4><hr>
        <div class="col-md-3 col-sm-12 mb-2 form-group">
            <label for="emp_no">Employee ID :</label>
            <p class="form-control"><b><?php echo $emp_detail['emp_no'];?></b></p>
        </div>
        <div class="col-md-3 col-sm-12 mb-2 form-group">
            <label for="full_name">Full Name :</label>
            <p class="form-control"><b><?php echo $emp_detail['full_name'];?></b></p>
        </div>
        <div class="col-md-3 col-sm-12 mb-2 form-group">
            <label for="employee_arabic_name">ID/ Iqama Number :</label>
            <p class="form-control"><b><?php echo $emp_detail['iqama_no'];?></b></p>
        </div>
        <div class="col-md-3 col-sm-12 mb-2 form-group">
            <label for="dob">Employee Nationality :</label>
            <p class="form-control"><b><?php echo $emp_detail['nationality_name'];?></b></p>
        </div>
    </div>

    <!---- Vehicle Detail ----->
    <div class="row size-inner-section px-2 py-4 mx-2">
        <h4 class="header-title">Vehicle Details</h4><hr>
		<?php if(!empty($vehicle_detail)){ ?>
        <div class="col-md-3 col-sm-12 mb-2 form-group">
            <label for="iqama_no">Bike Plate No :</label>
            <p class="form-control"><b><?php echo $vehicle_detail['vehicle_no'];?></b></p>
        </div>
        <div class="col-md-3 col-sm-12 mb-2 form-group">
            <label for="iqama_name_en">Make :</label>
            <p class="form-control"><b><?php echo $vehicle_detail['make_name'];?></b></p>
        </div>
        <div class="col-md-3 col-sm-12 mb-2 form-group">
            <label for="iqama_name_ar">Model :</label>
            <p class="form-control"><b><?php echo $vehicle_detail['vehicle_model'];?></b></p>
        </div>
        
        <div class="col-md-3 col-sm-12 mb-2 form-group">
            <label for="iqama_issue_date">Year :</label>
            <p class="form-control"><b><?php echo $vehicle_detail['vehicle_year'];?></b></p>
        </div>
		<?php }else{ ?>
			<div class="col-md-12">No vehicle data found.</div>
		<?php } ?>
    </div>

    <!---- Insurance Detail ----->
    <div class="row size-inner-section px-2 py-4 mx-2">
        <h4 class="header-title">Insurance Details</h4><hr>
		<?php if(!empty($insurance_detail)){ ?>
        <div class="col-md-3 col-sm-12 mb-2 form-group">
            <label for="insurance_provider">Insurance Service Provider :</label>
			<input type="hidden" id="insurance_provider" name="insurance_provider" value="<?php echo $insurance_detail['insurance_company'];?>" required />
            <p class="form-control"><b><?php echo ($insurance_detail['insurance_company'] !== '' && $insurance_detail['insurance_company'] !== NULL) ? $insurance_detail['insurance_company'] : 'NA';?></b></p>
        </div>

        <div class="col-md-3 col-sm-12 mb-2 form-group">
            <label for="ins_policy_no">Insurance Policy Number :</label>
			<input type="hidden" id="ins_policy_no" name="ins_policy_no" value="<?php echo $insurance_detail['insurance_policy_no'];?>" />
            <p class="form-control"><b><?php echo ($insurance_detail['insurance_policy_no'] !== '' && $insurance_detail['insurance_policy_no'] !== NULL) ? $insurance_detail['insurance_policy_no'] : 'NA';?></b></p>
        </div>

        <div class="col-md-3 col-sm-12 mb-2 form-group">
            <label for="ins_start_date">Insurance Start Date :</label>
			<input type="hidden" id="ins_start_date" name="ins_start_date" value="<?php echo $insurance_detail['insurance_issue_date'];?>" />
            <p class="form-control"><b><?php echo ($insurance_detail['insurance_issue_date'] !== '' && $insurance_detail['insurance_issue_date'] !== '0000-00-00') ? formatedDate($insurance_detail['insurance_issue_date']) : 'NA';?></b></p>
        </div>

        <div class="col-md-3 col-sm-12 mb-2 form-group">
            <label for="ins_end_date">Insurance End Date :</label>
			<input type="hidden" id="ins_end_date" name="ins_end_date" value="<?php echo $insurance_detail['insurance_end_date'];?>" />
            <p class="form-control"><b><?php echo ($insurance_detail['insurance_end_date'] !== NULL && $insurance_detail['insurance_end_date'] !== '' && $insurance_detail['insurance_end_date'] !== '0000-00-00') ? formatedDate($insurance_detail['insurance_end_date']) : 'NA';?></b></p>
        </div>
        
        <div class="col-md-3 col-sm-12 mb-2 form-group">
            <label for="ins_status">Insurance Status <span class="required-field">*</span></label>
			<?php
				$ins_end_date = $insurance_detail['insurance_end_date'];
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
        <h4 class="header-title">Accident Details</h4><hr>
		<div class="col-md-4 col-sm-12 mb-2 form-group">
            <label for="accident_date">Accident Date <span class="required-field">*</span></label>
            <input type="date" class="form-control" id="accident_date" name="accident_date" required />
        </div>

		<div class="col-md-4 col-sm-12 mb-2 form-group">
			<label for="accident_attended_by">Accident Attended By <span class="required-field">*</span></label>
			<select name="accident_attended_by" id="accident_attended_by" class="form-select" required>
				<option value="">Select Iqama Status</option>
				<option value="Najam">Najam</option>
				<option value="Morror">Morror</option>
			</select>
		</div>
		
        <div class="col-md-4 col-sm-12 mb-2 form-group najam-relation">
            <label for="hhdr_report_no">HHDR Report No <span class="required-field">*</span></label>
            <input type="text" class="form-control" id="hhdr_report_no" name="hhdr_report_no" maxlength="25" />
        </div>
        <div class="col-md-4 col-sm-12 mb-2 form-group najam-relation">
            <label for="attach_hhdr_report">Attach HHDR Report</label>
            <input type="file" class="form-control" id="attach_hhdr_report" name="attach_hhdr_report" />
        </div>
		<div class="col-md-4 col-sm-12 mb-2 form-group najam-relation">
            <label for="ld_report_no">LD Report Number</label>
            <input type="text" class="form-control" id="ld_report_no" name="ld_report_no" maxlength="25" />
        </div>
        <div class="col-md-4 col-sm-12 mb-2 form-group najam-relation">
            <label for="ld_final_report">Attach LD Report</label>
            <input type="file" class="form-control" id="ld_final_report" name="ld_final_report" />
        </div>
		<div class="col-md-4 col-sm-12 mb-2 form-group maroor-relation">
            <label for="maroor_report_no">Morror Report No <span class="required-field">*</span></label>
            <input type="text" class="form-control" id="maroor_report_no" name="maroor_report_no" />
        </div>
		<div class="col-md-4 col-sm-12 mb-2 form-group maroor-relation">
            <label for="attach_maroor_report">Attach Morror Report</label>
            <input type="file" class="form-control" id="attach_maroor_report" name="attach_maroor_report" />
        </div>
		
		<div class="col-md-4 col-sm-12 mb-2 form-group">
            <label for="employee_liability_perc">Employee Liability %</label>
            <input type="text" class="form-control" id="employee_liability_perc" name="employee_liability_perc" />
        </div>
    </div>

	<div class="row size-inner-section px-2 py-4 mx-2">
        <h4 class="header-title">Taqdeer Information</h4><hr>
		<div class="col-md-4 col-sm-12 mb-2 form-group">
            <label for="taqdeer_inspection_date">Taqdeer Inspection Date</label>
            <input type="date" class="form-control" id="taqdeer_inspection_date" name="taqdeer_inspection_date" />
        </div>

        <div class="col-md-4 col-sm-12 mb-2 form-group">
            <label for="da_final_report_no">DA Final Report No</label>
            <input type="text" class="form-control" id="da_final_report_no" name="da_final_report_no" minlength="12" maxlength="12" />
        </div>
        <div class="col-md-4 col-sm-12 mb-2 form-group">
            <label for="attach_da_final_report">Attach DA Final Report</label>
            <input type="file" class="form-control" id="attach_da_final_report" name="attach_da_final_report" />
        </div>
		
    </div>
	
	<div class="row size-inner-section px-2 py-4 mx-2">
        <h4 class="header-title">Fees & Expenses</h4><hr>
		<div class="col-md-4 col-sm-12 mb-2 form-group">
            <label for="taqdeer_da_fees">Taqdeer DA Fees</label>
            <input type="text" class="form-control" id="taqdeer_da_fees" name="taqdeer_da_fees" />
        </div>
		<div class="col-md-4 col-sm-12 mb-2 form-group">
            <label for="insurance_claim_fees">Insurance Claim Fees</label>
            <input type="text" class="form-control" id="insurance_claim_fees" name="insurance_claim_fees" />
        </div>
		<div class="col-md-4 col-sm-12 mb-2 form-group">
            <label for="other_cost">Other Cost</label>
            <input type="text" class="form-control" id="other_cost" name="other_cost" />
        </div>
		<div class="col-md-4 col-sm-12 mb-2 form-group">
            <label for="final_assessment_cost">Final Assessment Cost</label>
            <input type="text" class="form-control" id="final_assessment_cost" name="final_assessment_cost" />
        </div>
	</div>

    <div class="twitter-bs-wizard">
        <ul class="pager wizard twitter-bs-wizard-pager-link">
            <li class="next"><button form="accident_form" type="submit" class="btn btn-custom-success">Save Accident Data</button></li>
        </ul>
    </div>
</div>

<script>
	$(document).ready(function() {
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
            } else {
				najamShowHide.hide();
                maroorShowHide.show();
				$('#maroor_report_no').removeAttr('required', 'required');
				$('#hhdr_report_no').attr('required', 'required');
            }
        });
    });
</script>
