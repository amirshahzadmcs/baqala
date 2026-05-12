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
.guarantor-row .remove-btn {
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
				<?php if(!empty($emp_detail['employee_pic']) && $emp_detail['employee_pic'] !== ''){ ?>
					<img src="<?php echo $emp_detail['employee_pic'];?>" class="rounded" width="140">
				<?php }else{ ?>
					<img src="<?php echo base_url('images/user-img.png'); ?>" class="rounded" width="140">
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
						<td>SIM Number</td>
						<td> : </td>
						<td><?php echo (!empty($sim_detail['sim_no'])) ? $sim_detail['sim_no'] : 'NA';?></td>
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
					<tr>
						<td>Vehicle No</td>
						<td> : </td>
						<td><?php if(!empty($vehicle_detail['vehicle_no'])){ echo $vehicle_detail['vehicle_no'];?> / <?php echo $vehicle_detail['vehicle_model'];?> / <?php echo $vehicle_detail['make_name'];?> <?php echo ($vehicle_detail['vehicle_type'] == 'bike') ? '<i class="fas fa-motorcycle"></i>' : '<i class="mdi mdi-car"></i>';}else{ echo 'NA';}?></td>
					</tr>
					<tr>
						<td>GPS Tracking</td>
						<td> : </td>
						<td><?php echo (!empty($vehicle_detail['gps_device_serial'])) ? '<span class="text-success">Yes</span>' : '<span class="text-danger">No</span>';?></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	
	<div class="size-inner-section px-1 py-1 mx-1">
		<div class="card-header">Fill Form Information</div>
		<?php echo form_open("admin/form-center/save", array("id" => "riderProfileForm", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
			<input type="hidden" id="emp_id" name="employee_id" value="<?php echo $emp_detail['id'];?>" required />
			<div class="row p-2">
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<label for="date_of_issue">Date Of Issue <span class="text-danger">*</span></label>
					<input type="date" class="form-control" name="date_of_issue" max="<?php echo date('Y-m-d');?>" id="date_of_issue" required />
				</div>

				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<label for="document_type">Document Type <span class="text-danger">*</span></label>
					<select name="document_type" id="document_type" class="form-select select2" required>
						<option value="">Select Document Type</option>
						<option value="voluntary_resignation">Acknowledgment of Voluntary Resignation</option>
						<option value="uniform_handover">Asset Handover Form</option>
						<option value="atm_handover">ATM Card Handover Form</option>
						<option value="employee_entitlements">Employee Entitlements Schedule</option>
						<option value="probation_extension">Extension of Probation Period</option>
						<?php if($emp_detail['status'] == 'Terminated'){ ?>
						<option value="experience_certificate">Experience Certificate</option>
						<?php } ?>
						<option value="grantor_form">Guarantee the Payment Form</option>
						<option value="pledge_letter">Pledge Letter</option>
						<option value="resignation_letter">Resignation Letter</option>
						<option value="salary_certificate">Salary Certificate</option>
						<option value="sim_cancellation">SIM Card Cancellation Form</option>
						<option value="staff_exit_checklist">Staff Exit Checklist</option>
						<option value="training_form">Training Form</option>
						<option value="voluntary_payroll_deduction">Voluntary Payroll Deduction</option>
						<option value="warning_letter">Warning Letter</option>
					</select>
				</div>
			</div>
			<!-- Extension of Probation Period Form Fields -->
			<div id="probation_fields" class="row p-2 d-none">
				<?php
				if (!empty($emp_detail['work_joining_date'])) {
					$joiningDate = new DateTime($emp_detail['work_joining_date']);
					$startDate = $joiningDate->modify('+90 days')->format('Y-m-d'); // Add 90 days to the joining date to get startDate
					$endDate = (new DateTime($startDate))->modify('+90 days')->format('Y-m-d'); // Add 90 days to startDate to get endDate
				} else {
					$startDate = '';
					$endDate = '';
				}
				?>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<label for="start_date">Probation Start Date <span class="text-danger">*</span></label>
					<input type="date" class="form-control" name="start_date" id="start_date" value="<?php echo $startDate;?>" required readonly />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<label for="end_date">Probation End Date <span class="text-danger">*</span></label>
					<input type="date" class="form-control" name="end_date" id="end_date" value="<?php echo $endDate;?>" required readonly />
				</div>
			</div>
			<!-- ATM Card Handover Form Fields -->
			<div id="atm_fields" class="row p-2 d-none">
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<label for="bank_name">Bank Name <span class="text-danger">*</span></label>
					<input type="text" class="form-control" name="bank_name" id="bank_name" />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<label for="atm_card_no">ATM Card No <span class="text-danger">*</span></label>
					<input type="text" class="form-control" name="atm_card_no" id="atm_card_no" />
				</div>
			</div>
			<!-- SIM Card Cancellation Form Fields -->
			<div id="sim_fields" class="row p-2 d-none">
				<div class="col-md-12 col-sm-12 mb-2 form-group">
					<label for="sim_id">Select Sim To Discontinue <span class="text-danger">*</span></label>
					<select name="sim_id" id="sim_id" class="form-select select2">
						<option value="">Select Sim Card</option>
						<?php if (!empty(corporateAllotedSimsHelper($emp_detail['id']))): ?>
							<?php foreach (corporateAllotedSimsHelper($emp_detail['id']) as $sim): ?>
								<option value="<?= $sim['id']; ?>"><?= $sim['mobile']; ?> - <?= $sim['sim_no']; ?> (<?= $sim['network_name']; ?>)</option>
							<?php endforeach; ?>
						<?php else: ?>
							<option value="">No SIM cards available</option>
						<?php endif; ?>
					</select>
				</div>
				
				<div class="col-md-12 col-sm-12 mb-2 form-group">
					<label for="reason">Reason <span class="text-danger">*</span></label>
					<textarea class="form-control" name="reason" id="reason"></textarea>
				</div>
			</div>

			<!-- ATM Card Handover Form Fields -->
			<div id="warning_letter_fields" class="row p-2 d-none">
				<div class="col-md-12 col-sm-12 mb-2 form-group">
					<label for="letter_type">Letter Type <span class="text-danger">*</span></label>
					<select name="letter_type" id="letter_type" class="form-select select2">
						<option value="">Select Letter Type</option>
						<option value="first">1st Warning Letter</option>
						<option value="second">2nd Warning Letter</option>
						<option value="final">Final Warning Letter</option>
					</select>
				</div>
			</div>

			<!-- Guarantee the Payment Form Fields -->
			<div id="grantor_fields" class="row p-2 d-none">

				<div class="col-md-12 col-sm-12 mb-2 form-group mb-3">
					<label for="due_amount">Due Amount <span class="text-danger">*</span></label>
					<input type="text" class="form-control input-mask text-left" 
						data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" 
						autocomplete="off" id="due_amount" name="due_amount" required />
				</div>

				<!-- Container for guarantor rows -->
				<div id="guarantorContainer" class="col-12"></div>

				<div class="col-12 mt-2">
					<button type="button" id="addGuarantorBtn" class="btn btn-sm btn-primary">+ Add Guarantor</button>
				</div>
			</div>

			<!-- Asset Handover Form Fields -->
			<div id="uniform_fields" class="size-inner-section row p-2 m-2 d-none">
				<div class="card-header mb-3">Asset Handover Items <span class="text-danger">*</span></div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Hunger Station T-shirt" id="hunger_tshirt" class="checkbox align-middle" />
					<label for="hunger_tshirt">Hunger Station T-shirt</label>
					<input type="number" name="uniform_quantities[]" id="hunger_tshirt_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Hunger Station Jacket" id="hunger_jacket" class="checkbox align-middle" />
					<label for="hunger_jacket">Hunger Station Jacket</label>
					<input type="number" name="uniform_quantities[]" id="hunger_jacket_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Hunger Station ID Card" id="hunger_icard" class="checkbox align-middle" />
					<label for="hunger_icard">Hunger Station ID Card</label>
					<input type="number" name="uniform_quantities[]" id="hunger_icard_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Hunger Station Helmet" id="hunger_helmet" class="checkbox align-middle" />
					<label for="hunger_helmet">Hunger Station Helmet</label>
					<input type="number" name="uniform_quantities[]" id="hunger_helmet_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Hunger Station Bag" id="hunger_bag" class="checkbox align-middle" />
					<label for="hunger_bag">Hunger Station Bag</label>
					<input type="number" name="uniform_quantities[]" id="hunger_bag_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<hr>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Jahez T-shirt" id="jahez_tshirt" class="checkbox align-middle" />
					<label for="jahez_tshirt">Jahez T-shirt</label>
					<input type="number" name="uniform_quantities[]" id="jahez_tshirt_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Jahez Jacket" id="jahez_jacket" class="checkbox align-middle" />
					<label for="jahez_jacket">Jahez Jacket</label>
					<input type="number" name="uniform_quantities[]" id="jahez_jacket_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Jahez ID Card" id="jahez_icard" class="checkbox align-middle" />
					<label for="jahez_icard">Jahez ID Card</label>
					<input type="number" name="uniform_quantities[]" id="jahez_icard_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Jahez Helmet" id="jahez_helmet" class="checkbox align-middle" />
					<label for="jahez_helmet">Jahez Helmet</label>
					<input type="number" name="uniform_quantities[]" id="jahez_helmet_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Jahez Bag" id="jahez_bag" class="checkbox align-middle" />
					<label for="jahez_bag">Jahez Bag</label>
					<input type="number" name="uniform_quantities[]" id="jahez_bag_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<hr>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Keeta T-shirt" id="keeta_tshirt" class="checkbox align-middle" />
					<label for="keeta_tshirt">Keeta T-shirt</label>
					<input type="number" name="uniform_quantities[]" id="keeta_tshirt_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Keeta Jacket" id="keeta_jacket" class="checkbox align-middle" />
					<label for="keeta_jacket">Keeta Jacket</label>
					<input type="number" name="uniform_quantities[]" id="keeta_jacket_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Keeta ID Card" id="keeta_icard" class="checkbox align-middle" />
					<label for="keeta_icard">Keeta ID Card</label>
					<input type="number" name="uniform_quantities[]" id="keeta_icard_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Keeta Helmet" id="keeta_helmet" class="checkbox align-middle" />
					<label for="keeta_helmet">Keeta Helmet</label>
					<input type="number" name="uniform_quantities[]" id="keeta_helmet_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Keeta Bag" id="keeta_bag" class="checkbox align-middle" />
					<label for="keeta_bag">Keeta Bag</label>
					<input type="number" name="uniform_quantities[]" id="keeta_bag_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<hr>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Itlubha T-shirt" id="itlubha_tshirt" class="checkbox align-middle" />
					<label for="itlubha_tshirt">Itlubha T-shirt</label>
					<input type="number" name="uniform_quantities[]" id="itlubha_tshirt_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Itlubha Jacket" id="itlubha_jacket" class="checkbox align-middle" />
					<label for="itlubha_jacket">Itlubha Jacket</label>
					<input type="number" name="uniform_quantities[]" id="itlubha_jacket_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Itlubha ID Card" id="itlubha_icard" class="checkbox align-middle" />
					<label for="itlubha_icard">Itlubha ID Card</label>
					<input type="number" name="uniform_quantities[]" id="itlubha_icard_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Itlubha Helmet" id="itlubha_helmet" class="checkbox align-middle" />
					<label for="itlubha_helmet">Itlubha Helmet</label>
					<input type="number" name="uniform_quantities[]" id="itlubha_helmet_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Itlubha Bag" id="itlubha_bag" class="checkbox align-middle" />
					<label for="itlubha_bag">Itlubha Bag</label>
					<input type="number" name="uniform_quantities[]" id="itlubha_bag_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<hr>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Maha Al Fala T-shirt" id="maha_tshirt" class="checkbox align-middle" />
					<label for="maha_tshirt">Maha Al Fala T-shirt</label>
					<input type="number" name="uniform_quantities[]" id="maha_tshirt_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Maha Al Fala Jacket" id="maha_jacket" class="checkbox align-middle" />
					<label for="maha_jacket">Maha Al Fala Jacket</label>
					<input type="number" name="uniform_quantities[]" id="maha_jacket_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Maha Al Fala ID Card" id="maha_icard" class="checkbox align-middle" />
					<label for="maha_icard">Maha Al Fala ID Card</label>
					<input type="number" name="uniform_quantities[]" id="maha_icard_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Maha Al Fala Helmet" id="maha_helmet" class="checkbox align-middle" />
					<label for="maha_helmet">Maha Al Fala Helmet</label>
					<input type="number" name="uniform_quantities[]" id="maha_helmet_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Maha Al Fala Bag" id="maha_bag" class="checkbox align-middle" />
					<label for="maha_bag">Maha Al Fala Bag</label>
					<input type="number" name="uniform_quantities[]" id="maha_bag_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<hr>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Noon T-shirt" id="noon_tshirt" class="checkbox align-middle" />
					<label for="noon_tshirt">Noon T-shirt</label>
					<input type="number" name="uniform_quantities[]" id="noon_tshirt_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Noon Jacket" id="noon_jacket" class="checkbox align-middle" />
					<label for="noon_jacket">Noon Jacket</label>
					<input type="number" name="uniform_quantities[]" id="noon_jacket_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Noon Pant" id="noon_pant" class="checkbox align-middle" />
					<label for="noon_pant">Noon Pant</label>
					<input type="number" name="uniform_quantities[]" id="noon_pant_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Noon ID Card" id="noon_icard" class="checkbox align-middle" />
					<label for="noon_icard">Noon ID Card</label>
					<input type="number" name="uniform_quantities[]" id="noon_icard_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Noon Helmet" id="noon_helmet" class="checkbox align-middle" />
					<label for="noon_helmet">Noon Helmet</label>
					<input type="number" name="uniform_quantities[]" id="noon_helmet_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Noon Bag" id="noon_bag" class="checkbox align-middle" />
					<label for="noon_bag">Noon Bag</label>
					<input type="number" name="uniform_quantities[]" id="noon_bag_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<hr>

				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Pant" id="pant" class="checkbox align-middle" />
					<label for="pant">Black Pant</label>
					<input type="number" name="uniform_quantities[]" id="pant_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Safety Kit" id="safety_kit" class="checkbox align-middle" />
					<label for="safety_kit">Safety Kit</label>
					<input type="number" name="uniform_quantities[]" id="safety_kit_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Safety Shoes" id="safety_shoes" class="checkbox align-middle" />
					<label for="safety_shoes">Safety Shoes</label>
					<input type="number" name="uniform_quantities[]" id="safety_shoes_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Black Shoes" id="black_shoes" class="checkbox align-middle" />
					<label for="black_shoes">Black Shoes</label>
					<input type="number" name="uniform_quantities[]" id="black_shoes_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Delivery Bag" id="delivery_bag" class="checkbox align-middle" />
					<label for="delivery_bag">Delivery Bag</label>
					<input type="number" name="uniform_quantities[]" id="delivery_bag_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Helmet" id="helmet" class="checkbox align-middle" />
					<label for="helmet">Black Helmet</label>
					<input type="number" name="uniform_quantities[]" id="helmet_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Gloves" id="gloves" class="checkbox align-middle" />
					<label for="gloves">Pro Gloves</label>
					<input type="number" name="uniform_quantities[]" id="gloves_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Steelbird Gloves" id="steelbird_gloves" class="checkbox align-middle" />
					<label for="steelbird_gloves">Steelbird Gloves</label>
					<input type="number" name="uniform_quantities[]" id="steelbird_gloves_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Delivery Box" id="delivery_box" class="checkbox align-middle" />
					<label for="delivery_box">Delivery Box</label>
					<input type="number" name="uniform_quantities[]" id="delivery_box_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Uniform Set" id="uniform_set" class="checkbox align-middle" />
					<label for="uniform_set">Uniform Set</label>
					<input type="number" name="uniform_quantities[]" id="uniform_set_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="T-Shirt" id="t_shirt" class="checkbox align-middle" />
					<label for="t_shirt">T-Shirt</label>
					<input type="number" name="uniform_quantities[]" id="t_shirt_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Chest Safety" id="chest_safety" class="checkbox align-middle" />
					<label for="chest_safety">Chest Safety</label>
					<input type="number" name="uniform_quantities[]" id="chest_safety_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Leg Safety Guard" id="leg_safety_guard" class="checkbox align-middle" />
					<label for="leg_safety_guard">Leg Safety Guard</label>
					<input type="number" name="uniform_quantities[]" id="leg_safety_guard_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Hand Safety Guard" id="hand_safety_guard" class="checkbox align-middle" />
					<label for="hand_safety_guard">Hand Safety Guard</label>
					<input type="number" name="uniform_quantities[]" id="hand_safety_guard_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<hr>

				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Mobile Phone Holder - Car" id="mobile_phone_holder" class="checkbox align-middle" />
					<label for="mobile_phone_holder">Mobile Phone Holder - Car</label>
					<input type="number" name="uniform_quantities[]" id="mobile_phone_holder_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Mobile Phone Holder - Bike" id="mobile_phone_holder_bike" class="checkbox align-middle" />
					<label for="mobile_phone_holder_bike">Mobile Phone Holder - Bike</label>
					<input type="number" name="uniform_quantities[]" id="mobile_phone_holder_bike_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Mobile Phone Charger" id="mobile_phone_charger" class="checkbox align-middle" />
					<label for="mobile_phone_charger">Mobile Phone Charger</label>
					<input type="number" name="uniform_quantities[]" id="mobile_phone_charger_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<input type="checkbox" name="uniform_items[]" value="Mobile Phone Charging Cable" id="mobile_phone_charging_cable" class="checkbox align-middle" />
					<label for="mobile_phone_charging_cable">Mobile Phone Charging Cable</label>
					<input type="number" name="uniform_quantities[]" id="mobile_phone_charging_cable_qty" class="form-control d-none my-2" placeholder="Quantity" min="1" disabled />
				</div>
			</div>

			<!-- Acknowledgment of Voluntary Resignation Fields -->
			<div id="resignation_fields" class="row p-2 d-none">
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<label for="clearance_month">Clearance Month <span class="text-danger">*</span></label>
					<input type="month" class="form-control" name="clearance_month" id="clearance_month" required />
				</div>
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<label for="agency_name">Agency Name <span class="text-danger">*</span></label>
					<input type="text" class="form-control" name="agency_name" id="agency_name" />
				</div>
			</div>

			<!-- Resignation Letter Fields -->
			<div id="resignationLetterFields" class="row p-2 d-none">
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<label for="last_working_date">Last Working Date <span class="text-danger">*</span></label>
					<input type="date" class="form-control" name="last_working_date" id="last_working_date" required />
				</div>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>

<script>
	$(document).ready(function() {
		$(".input-mask").inputmask();
		$('.select2').select2({
			allowClear: true
		});
		// Handle document type selection
		$('#document_type').change(function() {
			var docType = $(this).val();
			var empId = $('#emp_id').val();
			var sim_no = "<?php echo (!empty($sim_detail['sim_no'])) ? $sim_detail['sim_no'] : '';?>";
			// Hide all fields initially
			$('#atm_fields, #probation_fields, #sim_fields, #uniform_fields, #resignation_fields, #grantor_fields, #warning_letter_fields, #resignationLetterFields').addClass('d-none');

			// Remove required attributes from all fields
			$('#atm_fields input, #probation_fields input, #sim_fields input, #resignation_fields input, #grantor_fields input, #warning_letter_fields #letter_type, #resignationLetterFields input').removeAttr('required');
			$('#atm_fields textarea, #sim_fields textarea').removeAttr('required');
			$('#grantor_fields select').removeAttr('required');
			$('#uniform_fields input[type="number"]').removeAttr('required'); // Remove required from quantities

			// Show relevant fields based on selected document type
			if (docType === 'atm_handover') {
				$('#atm_fields').removeClass('d-none');
				$('#atm_fields input').attr('required', 'required');
			} else if (docType === 'sim_cancellation') {
				$('#sim_fields').removeClass('d-none');
				if(sim_no == ''){
					$('#sim_fields textarea').remove();
					$('#sim_fields #sim_id').remove();
					$(this).val('');
					$('#sim_fields').html('<p class="text-danger">No sim card alloted, allot first!</p>');
					$('#date_of_issue').val('');
				}else{
					$('#sim_fields #sim_id').attr('required', 'required');
					$('#sim_fields textarea').attr('required', 'required');
				}
			} else if (docType === 'uniform_handover') {
				$('#uniform_fields').removeClass('d-none');
				// No need to set 'required' attribute here for quantities
			} else if (docType === 'voluntary_resignation') {
				$('#resignation_fields').removeClass('d-none');
				$('#resignation_fields input').attr('required', 'required');
			} else if (docType === 'warning_letter') {
				$('#warning_letter_fields').removeClass('d-none');
				$('#warning_letter_fields #letter_type').attr('required', 'required');
			} else if (docType === 'probation_extension') {
				$('#probation_fields').removeClass('d-none');
				$('#probation_fields input').attr('required', 'required');
			} else if (docType === 'grantor_form') {
				$('#grantor_fields').removeClass('d-none');
				$('#grantor_fields input').attr('required', 'required');
				$('#grantor_fields select').attr('required', 'required');
			} else if (docType === 'resignation_letter') {
				$('#resignationLetterFields').removeClass('d-none');
				$('#resignationLetterFields input').attr('required', 'required');
			}
		});

		// Function to check if the previous warning letter has been issued
		$('#letter_type').change(function() {
			var letterType = $(this).val();
			var empId = $('#emp_id').val();
			$.ajax({
				url: '<?php echo base_url('admin/form-center/check-warning-issued');?>',
				type: 'POST',
				data: { employee_id: empId, letter_type: letterType },
				dataType: 'json',
				success: function(response) {
					if (response.type === 'success') {
						
					} else {
						toastr.error(response.message);
						$('#letter_type').val('');
					}
				},
				error: function(xhr, status, error) {
					//console.log('AJAX Error:', status, error);
					toastr.error('An error occurred while checking the previous warning letter.');
				}
			});
		});

		// Handle checkbox change to show/hide quantity input
		$('#uniform_fields input[type="checkbox"]').change(function() {
			var quantityInput = $(this).closest('.form-group').find('input[type="number"]');
			if ($(this).is(':checked')) {
				quantityInput.removeClass('d-none');
				quantityInput.attr('required', 'required');
				quantityInput.prop('disabled', false);
			} else {
				quantityInput.addClass('d-none').val('').removeAttr('required');
				quantityInput.prop('disabled', true);
			}
		});

		// Handle form submission
		$('#riderProfileForm').submit(function(e) {
			e.preventDefault();
			
			// Check if at least one uniform item is selected
			if ($('#document_type').val() === 'uniform_handover') {
				var isChecked = $('input[name="uniform_items[]"]:checked').length > 0;
				if (!isChecked) {
					toastr.error('You must select at least one uniform item.');
					return;
				}
			}

			var formData = new FormData($(this)[0]);
			$.ajax({
				url: '<?php echo base_url('admin/form-center/save');?>',
				type: 'POST',
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				success: function(response) {
					// Handle server response
					if (response.type === 'success') {
						//initializeDataTable();
						toastr.success(response.message);
						$('#formRequestModal').modal('hide');
						resetModalData();
						setTimeout(function() {
							location.reload();
						}, 1000);
					} else {
						toastr.error(response.message);
					}
				},
				error: function() {
					toastr.error('An error occurred. Please try again.');
				}
			});
		});
	});

	$(document).ready(function() {
		// Function to create a guarantor row
		function createGuarantorRow() {
			const employeeOptions = `
				<option value="">Select Guarantor</option>
				<?php if (!empty(employeeListHelper())): ?>
					<?php foreach (employeeListHelper() as $employee): ?>
						<option value="<?= $employee->id; ?>"><?= $employee->emp_no; ?> - <?= $employee->full_name; ?></option>
					<?php endforeach; ?>
				<?php endif; ?>
			`;

			return `
				<div class="guarantor-row">
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
					<div class="col-md-1 col-sm-12 form-group">
						<button type="button" class="remove-btn">&times;</button>
					</div>
				</div>
			`;
		}

		// Initialize first guarantor row (required)
		$('#guarantorContainer').append(createGuarantorRow());
		initSelectAndMask($('#guarantorContainer .guarantor-row').last());

		// Add more guarantor rows
		$('#addGuarantorBtn').on('click', function() {
			const totalRows = $('#guarantorContainer .guarantor-row').length;
			if (totalRows >= 3) {
				alert('Maximum 3 guarantors allowed');
				return;
			}
			const row = $(createGuarantorRow());
			$('#guarantorContainer').append(row);
			initSelectAndMask(row);
		});

		// Remove guarantor row
		$(document).on('click', '.remove-btn', function() {
			$(this).closest('.guarantor-row').remove();
		});

		// Initialize select2 and input mask
		function initSelectAndMask(container) {
			container.find('.select2').select2();
			container.find('.input-mask').inputmask();
		}
	});
</script>
