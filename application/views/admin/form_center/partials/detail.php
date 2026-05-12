<div class="mt-2">
	<style> 
		#editProfileForm input, #editProfileForm select, #editProfileForm textarea{
			pointer-events: none;
			background: #f5f5f5;
		}
	</style>
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
        <div class="card-header">Form Information</div>
        <div id="editProfileForm">
            <input type="hidden" id="emp_id" name="employee_id" value="<?php echo $employee_data['emp_detail']['id'];?>" required />
            <input type="hidden" id="id" name="id" value="<?php echo $form_center['id'];?>" required />
            <div class="row p-2">
                <div class="col-md-6 col-sm-12 mb-2 form-group">
                    <label for="date_of_issue">Date Of Issue <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="date_of_issue" id="date_of_issue" value="<?php echo $form_center['date_of_issue'];?>" required />
                </div>

                <div class="col-md-6 col-sm-12 mb-2 form-group">
                    <label for="document_type">Document Type <span class="text-danger">*</span></label>
                    <select name="document_type" id="document_type" class="form-select select2" required>
                        <option value="">Select Document Type</option>
                        <option value="atm_handover" <?php echo ($form_center['document_type'] == 'atm_handover') ? ' selected ' : '';?>>ATM Card Handover Form</option>
						<option value="salary_certificate" <?php echo ($form_center['document_type'] == 'salary_certificate') ? ' selected ' : '';?>>Salary Certificate</option>
                        <option value="sim_cancellation" <?php echo ($form_center['document_type'] == 'sim_cancellation') ? ' selected ' : '';?>>SIM Card Cancellation Form</option>
						<option value="staff_exit_checklist" <?php echo ($form_center['document_type'] == 'staff_exit_checklist') ? ' selected ' : '';?>>Staff Exit Checklist</option>
                        <option value="uniform_handover" <?php echo ($form_center['document_type'] == 'uniform_handover') ? ' selected ' : '';?>>Asset Handover Form</option>
                        <option value="voluntary_resignation" <?php echo ($form_center['document_type'] == 'voluntary_resignation') ? ' selected ' : '';?>>Acknowledgment of Voluntary Resignation</option>
						<option value="probation_extension" <?php echo ($form_center['document_type'] == 'probation_extension') ? ' selected ' : '';?>>Extension of Probation Period</option>
						<option value="pledge_letter" <?php echo ($form_center['document_type'] == 'pledge_letter') ? ' selected ' : '';?>>Pledge Letter</option>
						<option value="training_form" <?php echo ($form_center['document_type'] == 'training_form') ? ' selected ' : '';?>>Training Form</option>
						<option value="employee_entitlements" <?php echo ($form_center['document_type'] == 'employee_entitlements') ? ' selected ' : '';?>>Employee Entitlements Schedule</option>
						<option value="experience_certificate" <?php echo ($form_center['document_type'] == 'experience_certificate') ? ' selected ' : '';?>>Experience Certificate</option>
						<option value="warning_letter" <?php echo ($form_center['document_type'] == 'warning_letter') ? ' selected ' : '';?>>Warning Letter</option>
						<option value="voluntary_payroll_deduction" <?php echo ($form_center['document_type'] == 'voluntary_payroll_deduction') ? ' selected ' : '';?>>Voluntary Payroll Deduction</option>
                        <option value="grantor_form" <?php echo ($form_center['document_type'] == 'grantor_form') ? ' selected ' : '';?>>Guarantee the Payment Form</option>
                        <option value="resignation_letter" <?php echo ($form_center['document_type'] == 'resignation_letter') ? ' selected ' : '';?>>Resignation Letter</option>
                    </select>
                </div>
            </div>
			<!-- Extension of Probation Period Form Fields -->
			<div id="probation_fields" style="display: none;">
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
						<input type="date" class="form-control" name="start_date" id="start_date" value="<?php echo $startDate;?>" required />
					</div>
					<div class="col-md-6 col-sm-12 mb-2 form-group">
						<label for="end_date">Probation End Date <span class="text-danger">*</span></label>
						<input type="date" class="form-control" name="end_date" id="end_date" value="<?php echo $endDate;?>" required />
					</div>
				</div>
			</div>
            <div id="uniformFields" style="display: none;">
                <div class="row p-2">
                    <div class="col-md-12 mb-2 form-group">
                        <label>Asset Handover Items</label>
                        <div id="uniformItemsContainer">
                            <!-- Asset items will be dynamically added here -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional fields for ATM Card Handover Form -->
            <div id="atmFields" style="display: none;">
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

            <!-- Additional fields for SIM Card Cancellation Form -->
            <div id="simFields" style="display: none;">
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
            <div id="resignationFields" style="display: none;">
                <div class="row p-2">
                    <div class="col-md-6 col-sm-12 mb-2 form-group">
						<label for="clearance_month">Clearance Month</label>
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
						value="<?= htmlspecialchars($dueAmount) ?>" required />
				</div>

				<!-- Container for guarantor rows -->
				<div id="guarantorContainer" class="col-12">
					<?php if (!empty($guarantorData)): ?>
						<?php foreach ($guarantorData as $g): ?>
							<div class="guarantor-row row mb-2">
								<div class="col-md-8 col-sm-12 form-group">
									<label>Select Guarantor <span class="text-danger">*</span></label>
									<select name="guarantor_name[]" class="form-select select2" required>
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
							</div>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>
            <!-- Resignation Letter Fields -->
            <div id="resignationLetterFields" class="row p-2 <?= ($form_center['document_type'] == 'resignation_letter') ? '' : 'd-none' ?>">
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
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    function initializeFields() {
        var docType = $('#document_type').val();
        $('#uniformFields, #atmFields, #simFields, #resignationFields, #probation_fields, #grantor_fields, #warning_letter_fields, #resignationLetterFields').hide(); // Hide all sections

        // Show fields based on the selected document type
        if (docType === 'uniform_handover') {
            $('#uniformFields').show();

            // Load existing uniform items into the form
            var uniformItemsJson = <?php echo json_encode($form_center['uniform_items'], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
			//console.log("Uniform Items JSON:", uniformItemsJson); // Debug log

			// Parse the JSON string into an array
			var uniformItems;
			try {
				uniformItems = JSON.parse(uniformItemsJson);
				//console.log("Parsed Uniform Items:", uniformItems); // Debug log
			} catch (e) {
				//console.error("Failed to parse JSON:", e);
				uniformItems = [];
			}
            var container = $('#uniformItemsContainer');
            container.empty();

            if (Array.isArray(uniformItems)) {
                uniformItems.forEach(function(item) {
                    container.append(
                        '<div class="row mb-2">' +
                        '<div class="col-md-6 col-sm-12">' +
                        '<input type="text" class="form-control" name="uniform_items[]" value="' + item.item_name + '" required />' +
                        '</div>' +
                        '<div class="col-md-6 col-sm-12">' +
                        '<input type="number" class="form-control" name="uniform_quantities[]" value="' + item.quantity + '" required />' +
                        '</div>' +
                        '</div>'
                    );
                });
            } else {
                //console.error('Expected uniformItems to be an array but got:', uniformItems);
            }
        } else if (docType === 'atm_handover') {
            $('#atmFields').show();
        } else if (docType === 'sim_cancellation') {
            $('#simFields').show();
        } else if (docType === 'voluntary_resignation') {
            $('#resignationFields').show();
        } else if (docType === 'probation_extension') {
			$('#probation_fields').show();
		} else if (docType === 'grantor_form') {
			$('#grantor_fields').show();
		} else if (docType === 'resignation_letter') {
			$('#resignationLetterFields').show();
		}
    }

    // Initialize fields on page load
    initializeFields();

    // Update fields when document type changes
    $('#document_type').change(function() {
        initializeFields();
    });

});
</script>



