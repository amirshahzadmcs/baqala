<div>
	<?php echo form_open("admin/hr/employees/add-loan", array("id" => "request_form", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
		<input type="hidden" name="emp_id" value="<?php echo $emp_detail->id;?>" required />
		<!-- Tab panes -->
		<div id="ajaxRes"></div>
		<div class="row tab-inner-section m-2 py-3">
			<h4 class="header-title">Leave Details</h4><hr>
			<div class="col-md-12 col-sm-12 mb-3 form-group">
				<label for="leave_type">Type</label>
				<select class="form-control form-select" data-parsley-allselected="true" name="leave_type" id="leave_type" required>
					<option value="">Select Leave Type</option>
					<option value="Bereavement">Bereavement</option>
					<option value="Unpaid">Unpaid</option>
					<option value="Study">Study</option>
					<option value="Sick">Sick</option>
					<option value="Annual">Annual</option>
					<option value="Sick Leave">Sick Leave</option>
				</select>
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="start_date">Start</label>
				<input type="date" class="form-control" id="_from" name="from" autocomplete="off" placeholder="Start Date" />
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="end_date">End</label>
				<input type="date" class="form-control" id="_to" name="to" autocomplete="off" placeholder="End Date" />
			</div>
		</div>
		<div class="row tab-inner-section m-2 mt-3 py-3">
			<h4 class="header-title">
				Leave Duration
				<div class="float-end">
					4 Days
				</div>
			</h4><hr>
			<div class="col-md-4 col-sm-12 mb-2">
				<div class="card text-dark mb-0" style="background-color:#f9fafb;">
					<div class="card-body">
						<blockquote class="card-bodyquote mb-0">
							<h6>You’ll be off for</h6>
							<h5>4 Days</h5>
						</blockquote>
					</div>
				</div>
			</div>
			<div class="col-md-4 col-sm-12 mb-2">
				<div class="card text-dark mb-0" style="background-color:#fffbfa;">
					<div class="card-body">
						<blockquote class="card-bodyquote mb-0">
							<h6>Days deducted</h6>
							<h5>4 Days</h5>
						</blockquote>
					</div>
				</div>
			</div>
			<div class="col-md-4 col-sm-12 mb-2">
				<div class="card text-dark mb-0" style="background-color:#fffcf5;">
					<div class="card-body">
						<blockquote class="card-bodyquote mb-0">
							<h6>Remaining Balance</h6>
							<h5>4 Days</h5>
						</blockquote>
					</div>
				</div>
			</div>
		</div>
		<div class="row tab-inner-section m-2 mt-3 py-3">
			<h4 class="header-title mb-1">
				<i class="mdi mdi-airplane font-size-18 me-2"></i>Flight Ticket
				<div class="float-end">
					<input type="checkbox" id="leave_auto_upgrade" switch="info" name="leave_auto_upgrade" <?php echo $settings['leave_auto_upgrade'] ? 'checked' : ''; ?>>
					<label for="leave_auto_upgrade" data-on-label="Yes" data-off-label="No"></label>
				</div>
			</h4><hr>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="departure_date">Departure Date</label>
				<input type="date" class="form-control" id="departure_date" name="departure_date" autocomplete="off" placeholder="Departure Date" />
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="return_date">Return Date</label>
				<input type="date" class="form-control" id="return_date" name="return_date" autocomplete="off" placeholder="Return Date" />
			</div>
			<div class="col-md-12 col-sm-12 mb-3 form-group">
				<label for="family_members">Family Members</label>
				<select class="form-control form-select" data-parsley-allselected="true" name="family_members" id="family_members" required>
					<option value="">Select Members</option>
				</select>
			</div>
		</div>
		<div class="row tab-inner-section m-2 mt-3 py-3">
			<h4 class="header-title mb-1">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.9994 5C9.40644 7.768 9.40644 12.232 11.9994 15C14.5924 12.232 14.5924 7.768 11.9994 5Z" stroke="#A5ADBA" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M11.9994 5C9.40644 7.768 9.40644 12.232 11.9994 15C14.5924 12.232 14.5924 7.768 11.9994 5Z" stroke="black" stroke-opacity="0.68" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M12 5C14.768 5 17 7.232 17 10C17 12.768 14.768 15 12 15" stroke="#A5ADBA" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M12 5C14.768 5 17 7.232 17 10C17 12.768 14.768 15 12 15" stroke="black" stroke-opacity="0.68" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M12 15C9.232 15 7 12.768 7 10C7 7.232 9.232 5 12 5" stroke="#A5ADBA" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M12 15C9.232 15 7 12.768 7 10C7 7.232 9.232 5 12 5" stroke="black" stroke-opacity="0.68" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M7 10H17" stroke="#A5ADBA" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M7 10H17" stroke="black" stroke-opacity="0.68" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M17.778 22H6.222C4.995 22 4 21.005 4 19.778V4.222C4 2.995 4.995 2 6.222 2H17.778C19.005 2 20 2.995 20 4.222V19.778C20 21.005 19.005 22 17.778 22Z" stroke="#A5ADBA" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M17.778 22H6.222C4.995 22 4 21.005 4 19.778V4.222C4 2.995 4.995 2 6.222 2H17.778C19.005 2 20 2.995 20 4.222V19.778C20 21.005 19.005 22 17.778 22Z" stroke="black" stroke-opacity="0.68" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M15 18.5H9" stroke="#A5ADBA" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M15 18.5H9" stroke="black" stroke-opacity="0.68" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
				Exit Re-Entry Visa
				<div class="float-end">
					<input type="checkbox" id="leave_auto_upgrade" switch="info" name="leave_auto_upgrade" <?php echo $settings['leave_auto_upgrade'] ? 'checked' : ''; ?>>
					<label for="leave_auto_upgrade" data-on-label="Yes" data-off-label="No"></label>
				</div>
			</h4><hr>
			<div class="col-md-4 col-sm-12 mb-3 form-group pe-1">
				<label for="entry_type">Type</label>
				<select class="form-control form-select" data-parsley-allselected="true" name="entry_type" id="entry_type" required>
					<option value="Single">Single</option>
					<option value="Multiple">Multiple</option>
				</select>
			</div>
			<div class="col-md-4 col-sm-12 mb-3 form-group px-1">
				<label for="period">Visa Period</label>
				<select class="form-control form-select" data-parsley-allselected="true" name="period" id="period" required>
					<option value="2">2 Months</option>
					<option value="3">3 Months</option>
					<option value="4">4 Months</option>
					<option value="5">5 Months</option>
					<option value="6">6 Months</option>
				</select>
			</div>
			<div class="col-md-4 col-sm-12 mb-2 form-group ps-1">
				<label for="exit_reentry_apply_date">Needed before</label>
				<input type="date" class="form-control" id="exit_reentry_apply_date" name="exit_reentry_apply_date" autocomplete="off" placeholder="Select Date" />
			</div>
		</div>
		<div class="row tab-inner-section m-2 mt-3 py-3">
			<h4 class="header-title">Reason</h4><hr>
			<div class="col-md-12 col-sm-12 mb-3 form-group">
				<input type="text" class="form-control" id="loan_reason" name="loan_reason" placeholder="Enter your reason" />
			</div>
			
			<div class="col-md-12 col-sm-12 mb-3 form-group">
				<input type="file" name="attachment" id="attachment" class="dropify"
					accept="image/png, image/jpeg, image/jpg, image/gif, image/svg, image/webp"
					data-max-file-size="2M" data-height="100">
			</div>
		</div>
	<?php echo form_close(); ?>
</div>
<script type="text/javascript">
	$('.dropify').dropify();
	$(document).ready(function() {
        initializeDatePickers('#_from', '#_to', '#error-message1'); // First date picker set
        initializeDatePickers('#departure_date', '#return_date', '#error-message2'); // Second date picker set
    });
</script>
