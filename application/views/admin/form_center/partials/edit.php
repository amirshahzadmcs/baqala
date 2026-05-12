<style> 
.select2-container {
	width: 100% !important;
}
.guarantor-row {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
	margin-bottom: 10px;
	align-items: flex-end;
}
.guarantor-row .remove_guarantor_btn {
	background: red;
	color: #fff;
	border: none;
	padding: 0 8px;
	border-radius: 4px;
	height: 38px;
}
</style>
<div class="mt-2">
    <div class="size-inner-section px-1 py-1 mx-1">
        <div class="card-header">Basic Detail</div>
        <div class="d-flex align-items-center employee-detail">
            <div class="image">
                <?php if(!empty($employee_data['emp_detail']['employee_pic']) && $employee_data['emp_detail']['employee_pic'] !== ''){ ?>
                    <img src="<?php echo $employee_data['emp_detail']['employee_pic'];?>" class="rounded" width="140">
                <?php }else{ ?>
                    <img src="<?php echo base_url('images/user-img.png'); ?>" class="rounded" width="140">
                <?php } ?>
            </div>
            <div class="p-3 w-100">
                <h5 class="mb-0 mt-0"> <?php echo $employee_data['emp_detail']['full_name'];?> / <?php echo $employee_data['emp_detail']['employee_arabic_name'];?> </h5>
                <span><?php echo $employee_data['emp_detail']['designation_name'];?> | <?php echo $employee_data['emp_detail']['department_name'];?></span>
                <hr class="my-1">
                <table>
                    <tr>
                        <td>Emp No.</td>
                        <td> : </td>
                        <td><?php echo $employee_data['emp_detail']['emp_no'];?></td>
                    </tr>
                    <tr>
                        <td>Nationality</td>
                        <td> : </td>
                        <td><?php echo $employee_data['emp_detail']['nationality_name'];?></td>
                    </tr>
                    <tr>
                        <td>Flex Number</td>
                        <td> : </td>
                        <td><?php echo (!empty($employee_data['sim_detail']['mobile'])) ? $employee_data['sim_detail']['mobile'] : 'NA';?></td>
                    </tr>
					<tr>
						<td>SIM Number</td>
						<td> : </td>
						<td><?php echo (!empty($employee_data['sim_detail']['sim_no'])) ? $employee_data['sim_detail']['sim_no'] : 'NA';?></td>
					</tr>
                    <tr>
                        <td>Mobile No</td>
                        <td> : </td>
                        <td><?php echo $employee_data['emp_detail']['mobile'];?></td>
                    </tr>
                    <tr>
                        <td>DL Number</td>
                        <td> : </td>
                        <td><?php if(!empty($employee_data['other_detail']['driving_license_number'])){ echo $employee_data['other_detail']['driving_license_number'];}else{ echo 'NA';}?></td>
                    </tr>
                    <tr>
                        <td>Vehicle No</td>
                        <td> : </td>
                        <td><?php if(!empty($employee_data['vehicle_detail']['vehicle_no'])){ echo $employee_data['vehicle_detail']['vehicle_no'];?> / <?php echo $employee_data['vehicle_detail']['vehicle_model'];?> / <?php echo $employee_data['vehicle_detail']['make_name'];?> <?php echo ($employee_data['vehicle_detail']['vehicle_type'] == 'bike') ? '<i class="fas fa-motorcycle"></i>' : '<i class="mdi mdi-car"></i>';}else{ echo 'NA';}?></td>
                    </tr>
                    <tr>
                        <td>GPS Tracking</td>
                        <td> : </td>
                        <td><?php echo (!empty($employee_data['vehicle_detail']['gps_device_serial'])) ? '<span class="text-success">Yes</span>' : '<span class="text-danger">No</span>';?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="size-inner-section px-1 py-1 mx-1">
        <div class="card-header">Fill Form Information</div>
        <?php echo form_open("admin/form-center/update", array("id" => "editProfileForm", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
            <input type="hidden" id="emp_id" name="employee_id" value="<?php echo $employee_data['emp_detail']['id'];?>" required />
            <input type="hidden" id="id" name="id" value="<?php echo $form_center['id'];?>" required />
            <div class="row p-2">
                <div class="col-md-6 col-sm-12 mb-2 form-group">
                    <label for="date_of_issue">Date Of Issue <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="date_of_issue" id="date_of_issue" max="<?php echo date('Y-m-d');?>" value="<?php echo $form_center['date_of_issue'];?>" required />
                </div>

                <div class="col-md-6 col-sm-12 mb-2 form-group">
                    <label for="document_type">Document Type <span class="text-danger">*</span></label>
                    <select name="document_type" id="document_type" class="form-select select2" required readonly>
						<option value="">Select Document Type</option>
						<option value="voluntary_resignation" <?php echo ($form_center['document_type'] == 'voluntary_resignation') ? ' selected ' : '';?>>Acknowledgment of Voluntary Resignation</option>
						<option value="atm_handover" <?php echo ($form_center['document_type'] == 'atm_handover') ? ' selected ' : '';?>>ATM Card Handover Form</option>
						<option value="employee_entitlements" <?php echo ($form_center['document_type'] == 'employee_entitlements') ? ' selected ' : '';?>>Employee Entitlements Schedule</option>
						<?php if($employee_data['emp_detail']['status'] == 'Terminated'){ ?>
						<option value="experience_certificate" <?php echo ($form_center['document_type'] == 'experience_certificate') ? ' selected ' : '';?>>Experience Certificate</option>
						<?php } ?>
						<option value="grantor_form" <?php echo ($form_center['document_type'] == 'grantor_form') ? ' selected ' : '';?>>Guarantee the Payment Form</option>
						<option value="probation_extension" <?php echo ($form_center['document_type'] == 'probation_extension') ? ' selected ' : '';?>>Extension of Probation Period</option>
						<option value="pledge_letter" <?php echo ($form_center['document_type'] == 'pledge_letter') ? ' selected ' : '';?>>Pledge Letter</option>
						<option value="resignation_letter" <?php echo ($form_center['document_type'] == 'resignation_letter') ? ' selected ' : '';?>>Resignation Letter</option>
						<option value="salary_certificate" <?php echo ($form_center['document_type'] == 'salary_certificate') ? ' selected ' : '';?>>Salary Certificate</option>
						<option value="sim_cancellation" <?php echo ($form_center['document_type'] == 'sim_cancellation') ? ' selected ' : '';?>>SIM Card Cancellation Form</option>
						<option value="staff_exit_checklist" <?php echo ($form_center['document_type'] == 'staff_exit_checklist') ? ' selected ' : '';?>>Staff Exit Checklist</option>
						<option value="training_form" <?php echo ($form_center['document_type'] == 'training_form') ? ' selected ' : '';?>>Training Form</option>
						<option value="uniform_handover" <?php echo ($form_center['document_type'] == 'uniform_handover') ? ' selected ' : '';?>>Asset Handover Form</option>
						<option value="voluntary_payroll_deduction" <?php echo ($form_center['document_type'] == 'voluntary_payroll_deduction') ? ' selected ' : '';?>>Voluntary Payroll Deduction</option>
						<option value="warning_letter" <?php echo ($form_center['document_type'] == 'warning_letter') ? ' selected ' : '';?>>Warning Letter</option>
					</select>
                </div>
            </div>
			<!-- Extension of Probation Period Form Fields -->
			<div id="probation_fields" class="d-none">
				<?php
					if (!empty($form_center['other_details'])) {
						$otherDetail = json_decode($form_center['other_details']);
						$startDate = $otherDetail->start_date ?? '';
						$endDate = $otherDetail->end_date ?? '';
					} else {
						$startDate = '';
						$endDate = '';
					}
				?>
				<div class="row">
					<div class="col-md-6 col-sm-12 mb-2 form-group">
						<label for="start_date">Probation Start Date <span class="text-danger">*</span></label>
						<input type="date" class="form-control" name="start_date" id="start_date" value="<?php echo $startDate;?>" readonly />
					</div>
					<div class="col-md-6 col-sm-12 mb-2 form-group">
						<label for="end_date">Probation End Date <span class="text-danger">*</span></label>
						<input type="date" class="form-control" name="end_date" id="end_date" value="<?php echo $endDate;?>" readonly />
					</div>
				</div>
			</div>
            <!-- Asset Handover Form Fields -->
			<div id="uniform_fields" class="size-inner-section row p-2 m-2 d-none">
				<div class="card-header mb-3">Asset Handover Items <span class="text-danger">*</span></div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Hunger Station T-shirt" id="hunger_tshirt" class="checkbox align-middle" />
					<label for="hunger_tshirt">Hunger Station T-shirt</label>
					<input type="number" name="uniform_quantities[]" id="hunger_tshirt_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Hunger Station Jacket" id="hunger_jacket" class="checkbox align-middle" />
					<label for="hunger_jacket">Hunger Station Jacket</label>
					<input type="number" name="uniform_quantities[]" id="hunger_jacket_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Hunger Station ID Card" id="hunger_icard" class="checkbox align-middle" />
					<label for="hunger_icard">Hunger Station ID Card</label>
					<input type="number" name="uniform_quantities[]" id="hunger_icard_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Hunger Station Helmet" id="hunger_helmet" class="checkbox align-middle" />
					<label for="hunger_helmet">Hunger Station Helmet</label>
					<input type="number" name="uniform_quantities[]" id="hunger_helmet_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Hunger Station Bag" id="hunger_bag" class="checkbox align-middle" />
					<label for="hunger_bag">Hunger Station Bag</label>
					<input type="number" name="uniform_quantities[]" id="hunger_bag_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<hr>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Jahez T-shirt" id="jahez_tshirt" class="checkbox align-middle" />
					<label for="jahez_tshirt">Jahez T-shirt</label>
					<input type="number" name="uniform_quantities[]" id="jahez_tshirt_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Jahez Jacket" id="jahez_jacket" class="checkbox align-middle" />
					<label for="jahez_jacket">Jahez Jacket</label>
					<input type="number" name="uniform_quantities[]" id="jahez_jacket_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Jahez ID Card" id="jahez_icard" class="checkbox align-middle" />
					<label for="jahez_icard">Jahez ID Card</label>
					<input type="number" name="uniform_quantities[]" id="jahez_icard_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Jahez Helmet" id="jahez_helmet" class="checkbox align-middle" />
					<label for="jahez_helmet">Jahez Helmet</label>
					<input type="number" name="uniform_quantities[]" id="jahez_helmet_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Jahez Bag" id="jahez_bag" class="checkbox align-middle" />
					<label for="jahez_bag">Jahez Bag</label>
					<input type="number" name="uniform_quantities[]" id="jahez_bag_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<hr>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Keeta T-shirt" id="keeta_tshirt" class="checkbox align-middle" />
					<label for="keeta_tshirt">Keeta T-shirt</label>
					<input type="number" name="uniform_quantities[]" id="keeta_tshirt_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Keeta Jacket" id="keeta_jacket" class="checkbox align-middle" />
					<label for="keeta_jacket">Keeta Jacket</label>
					<input type="number" name="uniform_quantities[]" id="keeta_jacket_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Keeta ID Card" id="keeta_icard" class="checkbox align-middle" />
					<label for="keeta_icard">Keeta ID Card</label>
					<input type="number" name="uniform_quantities[]" id="keeta_icard_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Keeta Helmet" id="keeta_helmet" class="checkbox align-middle" />
					<label for="keeta_helmet">Keeta Helmet</label>
					<input type="number" name="uniform_quantities[]" id="keeta_helmet_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Keeta Bag" id="keeta_bag" class="checkbox align-middle" />
					<label for="keeta_bag">Keeta Bag</label>
					<input type="number" name="uniform_quantities[]" id="keeta_bag_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<hr>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Itlubha T-shirt" id="itlubha_tshirt" class="checkbox align-middle" />
					<label for="itlubha_tshirt">Itlubha T-shirt</label>
					<input type="number" name="uniform_quantities[]" id="itlubha_tshirt_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Itlubha Jacket" id="itlubha_jacket" class="checkbox align-middle" />
					<label for="itlubha_jacket">Itlubha Jacket</label>
					<input type="number" name="uniform_quantities[]" id="itlubha_jacket_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Itlubha ID Card" id="itlubha_icard" class="checkbox align-middle" />
					<label for="itlubha_icard">Itlubha ID Card</label>
					<input type="number" name="uniform_quantities[]" id="itlubha_icard_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Itlubha Helmet" id="itlubha_helmet" class="checkbox align-middle" />
					<label for="itlubha_helmet">Itlubha Helmet</label>
					<input type="number" name="uniform_quantities[]" id="itlubha_helmet_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Itlubha Bag" id="itlubha_bag" class="checkbox align-middle" />
					<label for="itlubha_bag">Itlubha Bag</label>
					<input type="number" name="uniform_quantities[]" id="itlubha_bag_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<hr>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Maha Al Fala T-shirt" id="maha_tshirt" class="checkbox align-middle" />
					<label for="maha_tshirt">Maha Al Fala T-shirt</label>
					<input type="number" name="uniform_quantities[]" id="maha_tshirt_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Maha Al Fala Jacket" id="maha_jacket" class="checkbox align-middle" />
					<label for="maha_jacket">Maha Al Fala Jacket</label>
					<input type="number" name="uniform_quantities[]" id="maha_jacket_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Maha Al Fala ID Card" id="maha_icard" class="checkbox align-middle" />
					<label for="maha_icard">Maha Al Fala ID Card</label>
					<input type="number" name="uniform_quantities[]" id="maha_icard_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Maha Al Fala Helmet" id="maha_helmet" class="checkbox align-middle" />
					<label for="maha_helmet">Maha Al Fala Helmet</label>
					<input type="number" name="uniform_quantities[]" id="maha_helmet_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Maha Al Fala Bag" id="maha_bag" class="checkbox align-middle" />
					<label for="maha_bag">Maha Al Fala Bag</label>
					<input type="number" name="uniform_quantities[]" id="maha_bag_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<hr>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Noon T-shirt" id="noon_tshirt" class="checkbox align-middle" />
					<label for="noon_tshirt">Noon T-shirt</label>
					<input type="number" name="uniform_quantities[]" id="noon_tshirt_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Noon Jacket" id="noon_jacket" class="checkbox align-middle" />
					<label for="noon_jacket">Noon Jacket</label>
					<input type="number" name="uniform_quantities[]" id="noon_jacket_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Noon Pant" id="noon_pant" class="checkbox align-middle" />
					<label for="noon_pant">Noon Pant</label>
					<input type="number" name="uniform_quantities[]" id="noon_pant_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Noon ID Card" id="noon_icard" class="checkbox align-middle" />
					<label for="noon_icard">Noon ID Card</label>
					<input type="number" name="uniform_quantities[]" id="noon_icard_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Noon Helmet" id="noon_helmet" class="checkbox align-middle" />
					<label for="noon_helmet">Noon Helmet</label>
					<input type="number" name="uniform_quantities[]" id="noon_helmet_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Noon Bag" id="noon_bag" class="checkbox align-middle" />
					<label for="noon_bag">Noon Bag</label>
					<input type="number" name="uniform_quantities[]" id="noon_bag_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<hr>

				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Pant" id="pant" class="checkbox align-middle" />
					<label for="pant">Black Pant</label>
					<input type="number" name="uniform_quantities[]" id="pant_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Safety Kit" id="safety_kit" class="checkbox align-middle" />
					<label for="safety_kit">Safety Kit</label>
					<input type="number" name="uniform_quantities[]" id="safety_kit_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Safety Shoes" id="safety_shoes" class="checkbox align-middle" />
					<label for="safety_shoes">Safety Shoes</label>
					<input type="number" name="uniform_quantities[]" id="safety_shoes_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Black Shoes" id="black_shoes" class="checkbox align-middle" />
					<label for="black_shoes">Black Shoes</label>
					<input type="number" name="uniform_quantities[]" id="black_shoes_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Delivery Bag" id="delivery_bag" class="checkbox align-middle" />
					<label for="delivery_bag">Delivery Bag</label>
					<input type="number" name="uniform_quantities[]" id="delivery_bag_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Helmet" id="helmet" class="checkbox align-middle" />
					<label for="helmet">Black Helmet</label>
					<input type="number" name="uniform_quantities[]" id="helmet_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Gloves" id="gloves" class="checkbox align-middle" />
					<label for="gloves">Pro Gloves</label>
					<input type="number" name="uniform_quantities[]" id="gloves_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Steelbird Gloves" id="steelbird_gloves" class="checkbox align-middle" />
					<label for="steelbird_gloves">Steelbird Gloves</label>
					<input type="number" name="uniform_quantities[]" id="steelbird_gloves_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Delivery Box" id="delivery_box" class="checkbox align-middle" />
					<label for="delivery_box">Delivery Box</label>
					<input type="number" name="uniform_quantities[]" id="delivery_box_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Uniform Set" id="uniform_set" class="checkbox align-middle" />
					<label for="uniform_set">Uniform Set</label>
					<input type="number" name="uniform_quantities[]" id="uniform_set_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="T-Shirt" id="t_shirt" class="checkbox align-middle" />
					<label for="t_shirt">T-Shirt</label>
					<input type="number" name="uniform_quantities[]" id="t_shirt_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>

				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Chest Safety" id="chest_safety" class="checkbox align-middle" />
					<label for="chest_safety">Chest Safety</label>
					<input type="number" name="uniform_quantities[]" id="chest_safety_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Leg Safety Guard" id="leg_safety_guard" class="checkbox align-middle" />
					<label for="leg_safety_guard">Leg Safety Guard</label>
					<input type="number" name="uniform_quantities[]" id="leg_safety_guard_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Hand Safety Guard" id="hand_safety_guard" class="checkbox align-middle" />
					<label for="hand_safety_guard">Hand Safety Guard</label>
					<input type="number" name="uniform_quantities[]" id="hand_safety_guard_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>

				<hr>

				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Mobile Phone Holder - Car" id="mobile_phone_holder" class="checkbox align-middle" />
					<label for="mobile_phone_holder">Mobile Phone Holder - Car</label>
					<input type="number" name="uniform_quantities[]" id="mobile_phone_holder_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Mobile Phone Holder - Bike" id="mobile_phone_holder_bike" class="checkbox align-middle" />
					<label for="mobile_phone_holder_bike">Mobile Phone Holder - Bike</label>
					<input type="number" name="uniform_quantities[]" id="mobile_phone_holder_bike_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Mobile Phone Charger" id="mobile_phone_charger" class="checkbox align-middle" />
					<label for="mobile_phone_charger">Mobile Phone Charger</label>
					<input type="number" name="uniform_quantities[]" id="mobile_phone_charger_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Mobile Phone Charging Cable" id="mobile_phone_charging_cable" class="checkbox align-middle" />
					<label for="mobile_phone_charging_cable">Mobile Phone Charging Cable</label>
					<input type="number" name="uniform_quantities[]" id="mobile_phone_charging_cable_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" />
				</div>
			</div>

            <!-- Additional fields for ATM Card Handover Form -->
            <div id="atmFields" class="d-none">
                <div class="row p-2">
                    <div class="col-md-6 col-sm-12 mb-2 form-group">
                        <label for="bank_name">Bank Name</label>
                        <input type="text" class="form-control" name="bank_name" id="bank_name" value="<?php echo $form_center['bank_name'];?>" />
                    </div>
                    <div class="col-md-6 col-sm-12 mb-2 form-group">
                        <label for="atm_card_no">ATM Card No</label>
                        <input type="text" class="form-control" name="atm_card_no" id="atm_card_no" value="<?php echo $form_center['atm_card_no'];?>" />
                    </div>
                </div>
            </div>
			
			<!-- Warning Letter Form Fields -->
			<div id="warning_letter_fields" class="row p-2 d-none">
				<div class="col-md-12 col-sm-12 mb-2 form-group">
					<label for="letter_type">Letter Type <span class="text-danger">*</span></label>
					<select name="letter_type" id="letter_type" class="form-select select2">
						<option value="">Select Letter Type</option>
						<option value="first" <?php echo ($form_center['letter_type'] == 'first') ? ' selected ' : '';?>>1st Warning Letter</option>
						<option value="second" <?php echo ($form_center['letter_type'] == 'second') ? ' selected ' : '';?>>2nd Warning Letter</option>
						<option value="final" <?php echo ($form_center['letter_type'] == 'final') ? ' selected ' : '';?>>Final Warning Letter</option>
					</select>
				</div>
			</div>

            <!-- Additional fields for SIM Card Cancellation Form -->
            <div id="simFields" class="d-none">
                <div class="row p-2">
					<div class="col-md-12 col-sm-12 mb-2 form-group">
						<label for="sim_id">Select Sim To Discontinue <span class="text-danger">*</span></label>
						<select name="sim_id" id="sim_id" class="form-select select2">
							<option value="">Select Sim Card</option>
							<?php if (!empty(corporateAllotedSimsHelper($employee_data['emp_detail']['id']))): ?>
								<?php foreach (corporateAllotedSimsHelper($employee_data['emp_detail']['id']) as $sim): ?>
									<option value="<?= $sim['id']; ?>" <?php echo ($sim['id'] == $form_center['sim_id']) ? ' selected ' : '';?>><?= $sim['mobile']; ?> - <?= $sim['sim_no']; ?> (<?= $sim['network_name']; ?>)</option>
								<?php endforeach; ?>
							<?php else: ?>
								<option value="">No SIM cards available</option>
							<?php endif; ?>
						</select>
					</div>
                    <div class="col-md-12 mb-2 form-group">
                        <label for="reason">Reason</label>
                        <textarea class="form-control" name="reason" id="reason"><?php echo $form_center['reason'];?></textarea>
                    </div>
                </div>
            </div>

            <!-- Additional fields for Acknowledgment of Voluntary Resignation -->
            <div id="resignationFields" class="d-none">
                <div class="row p-2">
					<div class="col-md-6 col-sm-12 mb-2 form-group">
						<label for="clearance_month">Clearance Month <span class="text-danger">*</span></label>
						<input type="month" class="form-control" name="clearance_month" id="clearance_month" value="<?php echo $form_center['clearance_month'] ? date('Y-m', strtotime($form_center['clearance_month'])) : ''; ?>" />
					</div>
                    <div class="col-md-6 mb-2 form-group">
                        <label for="agency_name">Agency Name</label>
                        <input type="text" class="form-control" name="agency_name" id="agency_name" value="<?php echo $form_center['agency_name'];?>" />
                    </div>
                </div>
            </div>

			<!-- Guarantor Section -->
			<?php
				// Decode guarantor data from other_details
				$guarantorData = [];
				$dueAmount = '';
				if (!empty($form_center['other_details'])) {
					$decoded = json_decode($form_center['other_details'], true);
					if (isset($decoded['guarantors']) && is_array($decoded['guarantors'])) {
						$guarantorData = $decoded['guarantors'];
					}
					if (isset($decoded['due_amount'])) {
						$dueAmount = $decoded['due_amount'];
					}
				}
			?>
			<!-- Guarantee the Payment Form Fields -->
			<div id="grantor_fields" class="row p-2 <?= ($form_center['document_type'] == 'grantor_form') ? '' : 'd-none' ?>">

				<div class="col-md-12 col-sm-12 mb-2 form-group mb-3">
					<label for="due_amount">Due Amount <span class="text-danger">*</span></label>
					<input type="text" class="form-control input-mask text-left"
						data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'"
						autocomplete="off" id="due_amount" name="due_amount"
						value="<?= htmlspecialchars($dueAmount) ?>" />
				</div>

				<!-- Container for guarantor rows -->
				<div id="guarantorContainer" class="col-12">
					<?php if (!empty($guarantorData)): ?>
						<?php foreach ($guarantorData as $g): ?>
							<div class="guarantor-row row mb-2">
								<div class="col-md-6 col-sm-12 form-group">
									<label>Select Guarantor <span class="text-danger">*</span></label>
									<select name="guarantor_name[]" class="form-select select2">
										<option value="">Select Guarantor</option>
										<?php foreach (employeeListHelper() as $emp): ?>
											<option value="<?= $emp->id ?>"
												<?= ($emp->id == $g['guarantor_id']) ? 'selected' : '' ?>>
												<?= $emp->emp_no ?> - <?= $emp->full_name ?>
											</option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 form-group">
									<label>Add Amount <span class="text-danger">*</span></label>
									<input type="text" name="amount[]" class="form-control input-mask text-left"
										data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'"
										required autocomplete="off" value="<?= htmlspecialchars($g['amount']) ?>">
								</div>
								<div class="col-md-1 col-sm-12 d-flex align-items-end">
									<button type="button" class="btn btn-danger btn-sm remove-btn">&times;</button>
								</div>
							</div>
						<?php endforeach; ?>
					<?php else: ?>
						<!-- Default empty row -->
						<div class="guarantor-row row mb-2">
							<div class="col-md-6 col-sm-12 form-group">
								<label>Select Guarantor <span class="text-danger">*</span></label>
								<select name="guarantor_name[]" class="form-select select2">
									<option value="">Select Guarantor</option>
									<?php foreach (employeeListHelper() as $emp): ?>
										<option value="<?= $emp->id ?>"><?= $emp->emp_no ?> - <?= $emp->full_name ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="col-md-4 col-sm-12 form-group">
								<label>Add Amount <span class="text-danger">*</span></label>
								<input type="text" name="amount[]" class="form-control input-mask text-left"
									data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'"
									autocomplete="off">
							</div>
							<div class="col-md-1 col-sm-12 d-flex align-items-end">
								<button type="button" class="btn btn-danger btn-sm remove-btn">&times;</button>
							</div>
						</div>
					<?php endif; ?>
				</div>

				<div class="col-12 mt-2">
					<button type="button" id="addGuarantorBtn" class="btn btn-sm btn-primary">+ Add Guarantor</button>
				</div>
			</div>

			<!-- Resignation Letter Fields -->
			<div id="resignationLetterFields" class="row p-2 d-none">
				<?php
					if (!empty($form_center['other_details'])) {
						$otherDetail = json_decode($form_center['other_details']);
						$last_working_date = $otherDetail->last_working_date ?? '';
					} else {
						$last_working_date = '';
					}
				?>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<label for="last_working_date">Last Working Date <span class="text-danger">*</span></label>
					<input type="date" class="form-control" name="last_working_date" id="last_working_date" value="<?= $last_working_date ?>" />
				</div>
			</div>

        <?php echo form_close(); ?>
    </div>
</div>
<script>
	
	function initializeFields() {
		var docType = $('#document_type').val();
		$('#uniform_fields').addClass('d-none'); // Initially hide the field
		$('#atmFields').addClass('d-none');
		$('#simFields').addClass('d-none');
		$('#resignationFields').addClass('d-none');
		$('#probation_fields').addClass('d-none');
		$('#grantor_fields').addClass('d-none');
		$('#warning_letter_fields').addClass('d-none');
		$('#resignationLetterFields').addClass('d-none');

		if (docType === 'uniform_handover') {
			$('#uniform_fields').removeClass('d-none');

			// Retrieve uniformItems as a JSON string from PHP
			var uniformItemsJson = <?php echo json_encode($form_center['uniform_items'], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
			var uniformItems;
			try {
				uniformItems = JSON.parse(uniformItemsJson);
			} catch (e) {
				uniformItems = [];
			}
			// Reset all checkboxes and quantities
			$('.checkbox').prop('checked', false);
			$('input[name="uniform_quantities[]"]').addClass('d-none').val('');

			// Populate the form with the previous data
			uniformItems.forEach(function(item) {
				var itemName = item.item_name;
				var itemQty = item.quantity;

				// Find the corresponding checkbox and quantity field
				var checkbox = $('input[name="uniform_items[]"][value="' + itemName + '"]');
				var quantityField = $('#' + checkbox.attr('id') + '_qty');

				// Check the checkbox and set the quantity
				checkbox.prop('checked', true);
				quantityField.val(itemQty).removeClass('d-none');
			});
		} else if (docType === 'atm_handover') {
            $('#atmFields').removeClass('d-none');
        } else if (docType === 'sim_cancellation') {
            $('#simFields').removeClass('d-none');
        } else if (docType === 'voluntary_resignation') {
            $('#resignationFields').removeClass('d-none');
        } else if (docType === 'warning_letter') {
            $('#warning_letter_fields').removeClass('d-none');
        } else if (docType === 'probation_extension') {
			$('#probation_fields').removeClass('d-none');
		} else if (docType === 'grantor_form') {
			$('#grantor_fields').removeClass('d-none');
		} else if (docType === 'resignation_letter') {
			$('#resignationLetterFields').removeClass('d-none');
		}
	}

	$(document).ready(function() {
		$(".input-mask").inputmask();
		$('.select2').select2({
			allowClear: true
		});
		initializeFields();

		$('#document_type').change(function() {
			initializeFields();
		});
		
		// Handle form submission
		$('#editProfileForm').submit(function(e) {
			e.preventDefault();

			// Ensure all quantities are included in the form data
			$('input[name="uniform_quantities[]"]').each(function() {
				if ($(this).val() === '') {
					$(this).remove();
				}
			});

			var formData = new FormData($(this)[0]);
			$.ajax({
				url: '<?php echo base_url('admin/form-center/update');?>',
				type: 'POST',
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				success: function(response) {
					if (response.type === 'success') {
						//initializeDataTable();
						toastr.success(response.message);
						$('#formRequestModal').modal('hide');
						resetModalData();
						setTimeout(function() {
							location.reload();
						}, 1000);
					} else {
						//console.log("Error:", response.message);
						toastr.error(response.message);
					}
				},
				error: function() {
					toastr.error('An error occurred. Please try again.');
				}
			});
		});

		// Show or hide quantity field based on checkbox status
		$('.checkbox').change(function() {
			var qtyField = $('#' + $(this).attr('id') + '_qty');
			if ($(this).is(':checked')) {
				qtyField.removeClass('d-none');
			} else {
				qtyField.addClass('d-none').val('');
			}
		});
	});

	$(document).ready(function () {
		function createGuarantorRow() {
			const employeeOptions = `
				<option value="">Select Guarantor</option>
				<?php foreach (employeeListHelper() as $emp): ?>
					<option value="<?= $emp->id ?>"><?= $emp->emp_no ?> - <?= $emp->full_name ?></option>
				<?php endforeach; ?>
			`;

			return `
				<div class="guarantor-row row mb-2">
					<div class="col-md-6 col-sm-12 form-group">
						<label>Select Guarantor <span class="text-danger">*</span></label>
						<select name="guarantor_name[]" class="form-select select2" required>
							${employeeOptions}
						</select>
					</div>
					<div class="col-md-4 col-sm-12 form-group">
						<label>Add Amount <span class="text-danger">*</span></label>
						<input type="text" name="amount[]" class="form-control input-mask text-left"
							data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'"
							required autocomplete="off">
					</div>
					<div class="col-md-1 col-sm-12 d-flex align-items-end">
						<button type="button" class="btn btn-danger btn-sm remove-btn">&times;</button>
					</div>
				</div>
			`;
		}

		// Initialize select2 and inputmask
		function initSelectAndMask(container) {
			container.find('.select2').select2();
			container.find('.input-mask').inputmask();
		}

		initSelectAndMask($('#guarantorContainer'));

		// Add new guarantor row
		$('#addGuarantorBtn').on('click', function () {
			const totalRows = $('#guarantorContainer .guarantor-row').length;
			if (totalRows >= 3) {
				alert('Maximum 3 guarantors allowed');
				return;
			}
			const newRow = $(createGuarantorRow());
			$('#guarantorContainer').append(newRow);
			initSelectAndMask(newRow);
		});

		// Remove row
		$(document).on('click', '.remove-btn', function () {
			$(this).closest('.guarantor-row').remove();
		});
	});
</script>
