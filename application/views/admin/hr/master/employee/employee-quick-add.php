<div class="row size-inner-section px-2 py-4">
    <h4 class="header-title">General Information</h4>
    <hr>
    <div class="col-md-4 col-sm-12 mb-2 form-group">
        <label for="hiring_type">Hiring Type <span class="required-field">*</span></label>
        <select name="hiring_type" id="hiring_type" class="form-select select2" required data-placeholder="Choose Hiring Type...">
            <option value="Local - Saudi" <?php echo ($hiring_type == 'Local - Saudi') ? 'selected' : '' ?>>Local - Saudi</option>
            <option value="Local - Non-Saudi" <?php echo ($hiring_type == 'Local - Non-Saudi') ? 'selected' : '' ?>>Local - Non-Saudi</option>
            <option value="Foreign" <?php echo ($hiring_type == 'Foreign') ? 'selected' : '' ?>>Foreign</option>
        </select>
        <small class="hint">Select hiring type</small>
    </div>
    <div class="col-md-4 col-sm-12 mb-2 form-group">
        <label for="applicant_country">Country <span class="required-field">*</span></label>
        <select class="form-select" name="applicant_country" id="applicant_country" required>
            <option value="">Select Country</option>
            <?php foreach($nationalities as $nation) { ?>
            <option value="<?php echo $nation->name; ?>" data-id="<?php echo $nation->id; ?>" <?php echo ($nation->name == $applicant_country) ? 'selected' : '' ?>><?php echo $nation->name; ?></option>
            <?php } ?>
        </select>
        <small class="hint">Select Country</small>
    </div>
    <div class="col-md-4 col-sm-12 mb-2 form-group <?php echo ($hiring_type == 'local') ? 'd-none' : '';?>" id="agency-container">
        <label for="agency_name">Agency Name</label>
        <select name="agency_name" id="agency_name" class="form-control select2" data-placeholder="Choose Agency...">
            <option value="">Select Agency</option>
            <?php foreach (agencyCountrywiseHelper($applicant_country) as $key => $value) { ?>
                <option value="<?php echo $value->id;?>" <?php echo ($agency_name == $value->id) ? 'selected' : '' ?>><?php echo $value->agency_name;?></option>
            <?php } ?>
        </select>
        <small class="hint">Choose Agency Name</small>
    </div>
    <div class="col-md-4 col-sm-12 mb-2 form-group">
        <label for="applicant_type">Applicant Type <span class="required-field">*</span></label>
        <select class="form-select" name="applicant_type" id="applicant_type" required>
            <option value="">Select Type</option>
            <option value="Fresher" <?php echo ($applicant_type == 'Fresher') ? 'selected' : '' ?>>Fresher</option>
            <option value="Saudi Return" <?php echo ($applicant_type == 'Saudi Return') ? 'selected' : '' ?>>Saudi Return</option>
            <option value="GCC Return" <?php echo ($applicant_type == 'GCC Return') ? 'selected' : '' ?>>GCC Return</option>
        </select>
        <small class="hint">Select Applicant Type</small>
    </div>
	<div class="col-md-4 col-sm-12 mb-2 form-group">
		<label for="line_manager">Line Manager</label>
		<select name="line_manager" id="line_manager" class="form-control select2">
			<option value="">Select Line Manager</option>
			<?php foreach(employeeListHelper() as $emp_list) { ?>
				<option value="<?php echo $emp_list->id; ?>"><?php echo $emp_list->full_name; ?> (<?php echo $emp_list->designation_name; ?>) - <?php echo $emp_list->emp_no; ?></option>
			<?php } ?>
		</select>
		<small class="hint">Select Line Manager</small>
	</div>
</div>
<div class="row size-inner-section px-2 py-4">
    <h4 class="header-title">Personal Information</h4>
    <hr>
    <div class="col-md-4 col-sm-12 mb-2 form-group">
        <label for="first_name">First Name <span class="required-field">*</span></label>
        <input type="text" class="form-control" onKeyPress="return Alpha(event);" id="first_name" name="first_name" maxlength="150" value="<?php echo $first_name; ?>" required />
        <small class="hint">Enter Person First Name</small>
    </div>
    <div class="col-md-4 col-sm-12 mb-2 form-group">
        <label for="middle_name">Middle Name</label>
        <input type="text" class="form-control" onKeyPress="return Alpha(event);" id="middle_name" name="middle_name" maxlength="150" value="<?php echo $middle_name; ?>" />
        <small class="hint">Enter Person Middle Name</small>
    </div>
    <div class="col-md-4 col-sm-12 mb-2 form-group">
        <label for="third_name">Third Name</label>
        <input type="text" class="form-control" onKeyPress="return Alpha(event);" id="third_name" name="third_name" maxlength="150" value="<?php echo $third_name; ?>" />
        <small class="hint">Enter Person Third Name</small>
    </div>
    <div class="col-md-4 col-sm-12 mb-2 form-group">
        <label for="surname">Surname</label>
        <input type="text" class="form-control" onKeyPress="return Alpha(event);" id="surname" name="surname" maxlength="150" value="<?php echo $surname; ?>" />
        <small class="hint">Enter Person Surname</small>
    </div>
    <div class="col-md-4 col-sm-12 mb-2 form-group">
		<label for="employee_arabic_name">Employee Arabic Name <span class="required-field">*</span></label>
		<input type="text" class="form-control rtl-input" id="employee_arabic_name" name="employee_arabic_name" maxlength="150" value="<?php echo $candidate_arabic_name; ?>" required />
		<small class="hint">Enter Employee Arabic Name</small>
	</div>
    <div class="col-md-4 col-sm-12 mb-2 form-group">
        <label for="dob">Date of Birth <span class="required-field">*</span></label>
        <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $dob; ?>" max="<?php echo date("Y-m-d"); ?>" required />
        <small class="hint">Enter Date Of Birth</small>
    </div>
    <div class="col-md-4 col-sm-12 mb-2 form-group">
        <label for="age">Age <small class="required-field">(above 35 not accepted) *</small></label>
        <input type="number" class="form-control" id="age" name="age" value="<?php echo $age; ?>" required />
        <small class="hint">Write remarks if age is above 35.</small>
    </div>
    <div class="col-md-4 col-sm-12 mb-2 form-group">
        <label for="gender">Gender <span class="required-field">*</span></label>
        <select name="gender" id="gender" class="form-select select2" required data-placeholder="Choose Gender...">
            <option value="">Select</option>
            <option value="male" <?php echo ($gender == 'male') ? 'selected' : '' ?>>Male</option>
            <option value="female" <?php echo ($gender == 'female') ? 'selected' : '' ?>>Female</option>
            <option value="other" <?php echo ($gender == 'other') ? 'selected' : '' ?>>Other</option>
        </select>
        <small class="hint">Select Gender</small>
    </div>
    <div class="col-md-4 col-sm-12 mb-2 form-group">
        <label for="marital_status">Marital Status <span class="required-field">*</span></label>
        <select name="marital_status" id="marital_status" class="form-select select2" required data-placeholder="Choose Marital Status...">
            <option value="">Select</option>
            <option value="Single" <?php echo ($marital_status == 'Single') ? 'selected' : '' ?>>Single</option>
            <option value="Married" <?php echo ($marital_status == 'Married') ? 'selected' : '' ?>>Married</option>
            <option value="Divorced" <?php echo ($marital_status == 'Divorced') ? 'selected' : '' ?>>Divorced</option>
        </select>
        <small class="hint">Select Marital Status</small>
    </div>
    <div class="col-md-4 col-sm-12 mb-2 form-group">
        <label for="age_remarks">Remarks</label>
        <input type="text" class="form-control" id="age_remarks" name="age_remarks" maxlength="250" value="<?php echo $age_remarks; ?>" />
        <small class="hint">Write remarks if age is above 35.</small>
    </div>
    <div class="col-md-4 col-sm-12 mb-2 form-group">
		<label for="nationality">Nationality <span class="required-field">*</span></label>
		<select class="form-select" name="nationality" id="nationality" required>
			<option value="">Select Nationality</option>
			<?php foreach($nationalities as $nation) { ?>
			<option value="<?php echo $nation->name; ?>" data-id="<?php echo $nation->id; ?>" <?php echo ($nation->name == $nationality) ? ' selected ' : '' ?>><?php echo $nation->name; ?></option>
			<?php } ?>
		</select>
		<small class="hint">Select Nationality</small>
	</div>
	<div class="col-md-4 col-sm-12 mb-2 form-group">
        <label for="mobile">Mobile No.</label>
        <input type="text" onKeyPress="return numerics(event);" class="form-control" id="mobile" name="mobile" value="<?php echo $mobile; ?>" minlength="<?= MOB_LENGTH ;?>" maxlength="<?= MOB_LENGTH ;?>" />
        <small class="hint">Enter Mobile Number</small>
    </div>
    
    <div class="col-md-4 col-sm-12 mb-2 form-group">
        <label for="email">Email ID <span class="required-field">*</span></label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" onBlur="checkDuplicateEmail()" required />
        <small class="hint res-email">Enter Email</small>
    </div>
	<div class="col-md-4 col-sm-12 mb-2 form-group">
        <label for="status">Status <span class="required-field">*</span></label>
        <select name="status" id="emp_status" class="form-select" required>
            <option value="">Select</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
        <small class="hint">Select status for employee.</small>
    </div>
	<div class="col-md-4 col-sm-12 mb-2 form-group">
        <label for="employee_mode">Employee Mode</label>
		<select name="employee_mode" id="employee_mode" class="form-select" required data-placeholder="Employee Mode...">
            <option value="">Select Mode</option>
            <option value="employee">Employee</option>
            <option value="user">User</option>
        </select>
        <small class="hint">Enter Employee Mode</small>
    </div>
	<div class="col-md-6 col-sm-12 mb-2 form-group">
        <input class="checkbox" type="checkbox" id="allow_access" name="allow_access" disabled style="vertical-align: sub;margin-right: 10px;">
        <label class="form-check-label" for="allow_access">
        Allow access to the system
        </label>
        <small class="hint"> (Check if allow access to the system.)</small>
    </div>
	<div class="col-md-6 col-sm-12 access-checked d-none">
		<div class="form-group mb-2">
			<input class="checkbox" type="checkbox" id="send_credential" name="send_credential" style="vertical-align: sub;margin-right: 10px;">
			<label class="form-check-label" for="send_credential">
			Send credentials to user on email
			</label>
		</div>
        <small class="hint"> (Check if you want to send credential.)</small>
    </div>
    <div class="row access-checked d-none">
		<div class="col-md-4 col-sm-12 mb-2 form-group">
			<label for="display_language">Display Language <span class="required-field">*</span></label>
			<select name="display_language" id="display_language" class="form-select">
				<option value="">Select Language</option>
				<option value="1">Arabic</option>
				<option value="2">English</option>
			</select>
			<small class="hint">Select Display Language</small>
		</div>
		<div class="col-md-4 col-sm-12 mb-2 form-group">
			<label for="employee_role">Role <span class="required-field">*</span></label>
			<select name="employee_role" id="employee_role" class="form-select select2" data-placeholder="Employee Role...">
				<option value="">Select Role</option>
				<?php foreach(rolesList() as $roles){ ?>
				<option value="<?php echo $roles->id; ?>"><?php echo $roles->name; ?></option>
				<?php } ?>
			</select>
			<small class="hint">Select Employee Role</small>
		</div>
		<div class="col-md-4 col-sm-12 mb-2 form-group">
			<label for="branches">Accessible Branches <span class="required-field">*</span></label>
			<select name="branches" id="branches" class="form-select select2" data-placeholder="Employee Accessible Branches...">
				<option value="">Select Accessible Branches</option>
				<?php foreach(branchHelper() as $mbranch) { ?>
					<option value="<?php echo $mbranch->id; ?>"><?php echo $mbranch->branch_name; ?></option>
				<?php } ?>
			</select>
			<small class="hint">Select Accessible Branches</small>
		</div>
	</div>
</div>
<div class="row size-inner-section px-2 py-4">
    <h4 class="header-title">Iqama & DL Details</h4>
    <hr>
	<div class="col-md-4 col-sm-12 mb-2 form-group">
        <label for="iqama_no">Iqama Number</label>
        <input type="text" class="form-control" id="iqama_no" name="iqama_no" minlength="<?= ICAMA_LENGTH ;?>" maxlength="<?= ICAMA_LENGTH ;?>" />
        <small class="hint">Enter Iqama Number</small>
    </div>
    <div class="col-md-4 col-sm-12 mb-2 form-group">
        <label for="iqama_exp">Iqama Expiry Date</label>
        <input type="date" class="form-control" id="iqama_exp" name="iqama_exp" min="<?php echo date("Y-m-d"); ?>" />
        <small class="hint">Enter Iqama Expiry Date</small>
    </div>
    
	<div class="col-md-4 col-sm-12 mb-2 form-group">
		<label for="iqama_issue_city">City of Issue</label>
		<input type="text" class="form-control" id="iqama_issue_city" name="iqama_issue_city" maxlength="100" />
		<small class="hint">Select City of Issue</small>
	</div>
	
	<div class="col-md-4 col-sm-12 mb-2 form-group">
		<label for="iqama_issue_country">Country</label>
		<select name="iqama_issue_country" id="iqama_issue_country" class="form-control select2" data-placeholder="Choose Country..." required>
			<option value="">Select</option>
			<?php foreach($nationalities as $nation) { ?>
				<option value="<?php echo $nation->name; ?>" <?php echo ($nation->name == 'Saudi Arabia') ? 'selected' : '' ?>><?php echo $nation->name; ?></option>
			<?php } ?>
		</select>
		<small class="hint">Select Country</small>
	</div>

	<div class="col-md-4 col-sm-12 mb-2 form-group">
        <label class="form-check-label mb-3 d-block" for="saudi_dl_available">Do you have Saudi/GCC Driving License</label>
		<input class="checkbox" type="checkbox" id="saudi_dl_available" name="saudi_dl_available"<?php echo ($saudi_dl_available == 'on') ? 'checked' : '' ?> style="vertical-align: sub;margin-right: 10px;">
        <small class="hint"> (Check if you have Saudi driving License.)</small>
    </div>

    
    <div id="saudi-dl-container" class="row">
		<div class="col-md-4 col-sm-12 mb-2 form-group">
			<label for="dl_issuing_authority">Driving License Issuing Authority</label>
			<select name="dl_issuing_authority" id="dl_issuing_authority" class="form-select select2">
				<option value="">Select Type</option>
				<option value="Saudi" <?php echo ($dl_type == 'Saudi') ? 'selected' : '' ?>>Saudi</option>
                <option value="GCC" <?php echo ($dl_type == 'GCC') ? 'selected' : '' ?>>GCC</option>
			</select>
		</div>
        <div class="col-md-4 col-sm-12 mb-2 form-group">
            <label for="dl_type">Driving License Type</label>
            <select name="dl_type" id="dl_type" class="form-select select2">
                <option value="">Select Type</option>
                <option value="Bike">Bike</option>
				<option value="Car">Car</option>
				<option value="Truck">Truck</option>
            </select>
        </div>
        <div class="col-md-4 col-sm-12 mb-3 form-group">
            <label for="current_dl">Driving License No</label>
            <input type="text" class="form-control" id="current_dl" name="current_dl" minlength="<?= DL_LENGTH ;?>" maxlength="<?= DL_LENGTH ;?>" value="<?= $current_dl; ?>" />
            <small class="hint">Enter saudi driving license no</small>
            <span id="errmsgadhar" class="err-msg"></span>
        </div>
        
        <div class="col-md-4 col-sm-12 mb-3 form-group">
            <label for="current_dl_expiry">Driving License Expiry</label>
            <input type="date" class="form-control" id="current_dl_expiry" name="current_dl_expiry" min="<?php echo date("Y-m-d"); ?>" value="<?= $current_dl_expiry; ?>" />
            <small class="hint">Enter saudi driving license expiry date</small>
        </div>
		
    </div>
    
</div>
<div class="row size-inner-section px-2 py-4">
    <h4 class="header-title">Work Information</h4>
    <hr>
    <div class="col-md-4 col-sm-12 mb-2 form-group">
        <label for="designation">Designation <span class="required-field">*</span></label>
        <select name="designation" id="designation" class="form-select select2" required data-placeholder="Choose Designation...">
            <option value="">Select Designation</option>
            <?php foreach($positions as $pos) { ?>
                <option value="<?php echo $pos->id; ?>" <?php echo ($pos->id == $applied_for) ? ' selected ' : '' ?>><?php echo $pos->name; ?></option>
            <?php } ?>
        </select>
        <small class="hint">Select employee designation</small>
    </div>
    <div class="col-md-4 col-sm-12 mb-2 form-group">
        <label for="department">Department <span class="required-field">*</span></label>
        <select name="department" id="department" class="form-select select2" required data-placeholder="Choose Department...">
            <option value="">Select Department</option>
            <?php foreach($departments as $department) { ?>
                <option value="<?php echo $department->id; ?>" <?php echo ($pos->id == $department) ? ' selected ' : '' ?>><?php echo $department->name; ?></option>
            <?php } ?>
        </select>
        <small class="hint">Select employee department</small>
    </div>
	
	<div class="col-md-4 col-sm-12 mb-2 form-group">
        <label for="joining_date">Joining Date <span class="required-field">*</span></label>
        <input type="date" class="form-control" id="joining_date" name="joining_date" max="<?php echo date("Y-m-d"); ?>" required />
        <small class="hint">Enter Joinning Date</small>
    </div>
	<div class="col-md-4 col-sm-12 mb-2 form-group">
        <label for="branch">Branch <span class="required-field">*</span></label>
        <select name="branch" id="branch" class="form-select select2" required data-placeholder="Choose Branch...">
            <option value="">Select Branch</option>
            <?php foreach(branchHelper() as $mbranch) { ?>
                <option value="<?php echo $mbranch->id; ?>"><?php echo $mbranch->branch_name; ?></option>
            <?php } ?>
        </select>
        <small class="hint">Select branch</small>
    </div>
    <div class="col-md-4 col-sm-12 mb-2 form-group">
        <label for="work_type">Work Type <span class="required-field">*</span></label>
        <select name="work_type" id="work_type" class="form-select select2" required data-placeholder="Choose Work Type...">
            <option value="">Select Work Type</option>
            <option value="Full Time">Full Time</option>
            <option value="Part Time">Part Time</option>
        </select>
        <small class="hint">Select Work Type</small>
    </div>
	<div class="col-md-4 col-sm-12 mb-2 form-group">
        <label for="insurance_number">Insurance Number</label>
        <input type="text" class="form-control" id="insurance_number" name="insurance_number" maxlength="50" />
        <small class="hint">Enter Insurance Number</small>
    </div>
    <div class="col-md-4 col-sm-12 mb-2 form-group">
        <label for="insurance_expiry">Insurance Expiry Date</label>
        <input type="date" class="form-control" id="insurance_expiry" name="insurance_expiry" min="<?php echo date("Y-m-d"); ?>" />
        <small class="hint">Enter Insurance Expiry Date</small>
    </div>
</div>

<div class="row size-inner-section px-2 py-4">
    <h4 class="header-title">Attendance Information</h4>
    <hr>
    <div class="col-md-4 col-sm-12 mb-2 form-group">
        <label for="attendance_shift">Attendance Shift</label>
        <select name="attendance_shift" id="attendance_shift" class="form-select select2" data-placeholder="Choose Attendance Shift...">
            <option value="">Select Attendance Shift</option>
			<?php
			foreach (getAddtendaceShift() as $key => $value) {
				echo '<option value="'. $value['id'] .'">'. $value['name'] .'</option>';
			}?>
        </select>
        <small class="hint">Select employee attendance shift</small>
    </div>
    <div class="col-md-4 col-sm-12 mb-2 form-group">
        <label for="leave_policy">Leave Policy</label>
        <select name="leave_policy" id="leave_policy" class="form-select select2" data-placeholder="Choose Leave Policy...">
            <option value="">Select Leave Policy</option>
			<?php
			foreach (getLeavePolicy() as $key => $value) {
				echo '<option value="'. $value['id'] .'">'. $value['name'] .'</option>';
			}?>
        </select>
        <small class="hint">Select employee leave policy</small>
    </div>
	<div class="col-md-4 col-sm-12 mb-2 form-group">
        <label for="holiday_list">Holiday List</label>
        <select name="holiday_list" id="holiday_list" class="form-select select2" data-placeholder="Choose Holiday List...">
            <option value="">Select Holiday List</option>
			<?php
			foreach (getHolidayList() as $key => $value) {
				echo '<option value="'. $value['id'] .'">'. $value['group_title'] .'</option>';
			}?>
        </select>
        <small class="hint">Select employee holiday list</small>
    </div>
	<div class="col-md-4 col-sm-12 mb-2 form-group">
        <label for="attendance_restriction">Attendance Restriction</label>
        <select name="attendance_restriction" id="attendance_restriction" class="form-select select2" data-placeholder="Choose Attendance Restriction...">
            <option value="">Select Attendance Restriction</option>
			<?php
			foreach (getAttendanceRestriction() as $key => $value) {
				echo '<option value="'. $value['id'] .'">'. $value['name'] .'</option>';
			}?>
        </select>
        <small class="hint">Select attendance restriction</small>
    </div>
</div>

<div class="row size-inner-section p-2">
	<h4 class="header-title">Fill your required bank information</h4>

	<div class="col-md-4 col-sm-12 mb-3 form-group">
		<label for="bank_name">Bank Name</label>
		<select style="height:410px;" name="bank_name" id="bank_name" class="form-control select2">
			<option value="">Select Bank</option>
			<?php foreach(bankList() as $banks){?>
			<option value="<?php echo $banks->id;?>"><?php echo $banks->bank_name;?></option>
			<?php } ?>
		</select>
		<small class="hint">Select bank name</small>
	</div>
	
	<div class="col-md-4 col-sm-12 mb-3 form-group" id="iban_cont">
		<label for="iban">IBAN No</label>
		<input type="text" class="form-control" id="iban" name="iban" minlength="<?= IBAN_LENGTH ;?>" maxlength="<?= IBAN_LENGTH ;?>" />
		<small class="hint">Enter IBAN No of Employee</small>
	</div>
	
	
	<div class="col-md-4 col-sm-12 mb-3 form-group" id="iban_cont">
		<label for="stc_pay_no">STC Pay No</label>
		<input type="text" class="form-control" id="stc_pay_no" name="stc_pay_no" minlength="<?= STC_PAY_LENGTH ;?>" maxlength="<?= STC_PAY_LENGTH ;?>" />
		<small class="hint">Enter STC No of Employee</small>
	</div>
</div>

<div class="row size-inner-section px-2 py-4">
	<h4 class="header-title">Family Information</h4><hr>
    <table id="family_sections" class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<td class="text-left">Iqama/ID No <span class="required-field">*</span></td>
				<td class="text-left">Name <span class="required-field">*</span></td>
				<td class="text-left">Relationship <span class="required-field">*</span></td>
				<td class="text-left">Date of Birth <span class="required-field">*</span></td>
				<td class="text-left">Medical Insurance <span class="required-field">*</span></td>
				<td style="width: 5%;"></td>
			</tr>
		</thead>
		<tbody>
			<tr class="family-inner-section">
				<td class="text-left" style="width: 15%;">
					<input type="text" name="family_iqama[]" class="form-control" minlength="<?= ICAMA_LENGTH ;?>" maxlength="<?= ICAMA_LENGTH ;?>">
				</td>
				<td class="text-left">
					<div class="input-group">
						<input type="text" name="family_name[]" class="form-control" maxlength="100">
					</div>
				</td>
				<td class="text-left" style="width: 20%;">
					<select name="family_relation[]" class="form-select">
						<option value="">Select Relationship</option>
						<option value="Son">Son</option>
						<option value="Wife">Wife</option>
						<option value="Daughter">Daughter</option>
						<option value="Mother">Mother</option>
						<option value="Mother in Law">Mother in Law</option>
						<option value="Father in Law">Father in Law</option>
					</select>
				</td>
				<td class="text-left" style="width: 15%;">
					<div class="input-group">
						<input type="date" name="family_dob[]" class="form-control" max="<?php echo date("Y-m-d"); ?>">
					</div>
				</td>
				<td class="text-left">
					<div class="input-group">
						<input type="text" name="family_insurance[]" class="form-control" maxlength="120">
					</div>
				</td>
				<td class="text-right">
					<a href="javascript:;" class="btn btn-danger btn-sm float-end remove"><i class="fa fa-minus-circle"></i></a>
				</td>
			</tr>
		</tbody>

		<tfoot>
			<tr>
				<td colspan="6" class="text-right">
					<a href="javascript:;" class='btn btn-success btn-sm addsection'><i class="fa fa-plus-circle"></i> Add More</a>
				</td>
			</tr>
		</tfoot>
	</table>
</div>

<div class="row size-inner-section px-2 py-4">
    <h4 class="header-title">Passport & DL Details</h4>
    <hr>
	
    <div class="col-md-4 col-sm-12 mb-2 form-group">
        <label for="passport_issue_country">Passport Issue Country <span class="required-field">*</span></label>
        <select name="passport_issue_country" id="passport_issue_country" class="form-select select2" data-placeholder="Choose Passport Issue Country..." required>
            <option value="">Select Country</option>
            <?php foreach($nationalities as $nation) { ?>
                <option value="<?php echo $nation->name; ?>" <?php echo ($nation->name == $passport_issue_country) ? 'selected' : '' ?>><?php echo $nation->name; ?></option>
            <?php } ?>
        </select>
        <small class="hint">Select Country</small>
    </div>
    <div class="col-md-4 col-sm-12 mb-2 form-group">
        <label for="passport_issue_city">Passport Issue City <span class="required-field">*</span></label>
        <input type="text" class="form-control" id="passport_issue_city" name="passport_issue_city" value="<?php echo $passport_issue_city; ?>" maxlength="100" required />
        <small class="hint">Enter passport issue city</small>
    </div>
    <div class="col-md-4 col-sm-12 mb-2 form-group">
        <label for="passport_no">Passport Number <span class="required-field">*</span></label>
        <input type="text" class="form-control" id="passport_no" name="passport_no" minlength="8" maxlength="<?= PASSPORT_LENGTH;?>" value="<?php echo $passport_no; ?>" required />
        <small class="hint">Enter Passport Number</small>
    </div>
    <div class="col-md-4 col-sm-12 mb-2 form-group">
        <label for="passport_exp">Passport Expiry Date <span class="required-field">*</span></label>
        <input type="date" class="form-control" id="passport_exp" name="passport_exp" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $passport_exp; ?>" required />
        <small class="hint">Enter Passport Expiry Date</small>
    </div>
    <div class="col-md-12 col-sm-12 mb-2 form-group">
        <input class="checkbox" type="checkbox" id="dl_available" name="dl_available" <?php echo ($dl_available == 'on') ? 'checked' : '' ?> style="vertical-align: sub;margin-right: 10px;">
        <label class="form-check-label" for="dl_available">
        Do you have Homeland Driving License
        </label>
        <small class="hint"> (Check if you have driving License.)</small>
    </div>
    
    <div id="dl-container" class="row">
        <div class="col-md-4 col-sm-12 mb-3 form-group">
            <label for="dl_no">Driving License No</label>
            <input type="text" class="form-control" id="dl_no" name="dl_no" minlength="<?= DL_LENGTH ;?>" maxlength="<?= DL_LENGTH ;?>" value="<?= $dl_no; ?>" />
            <small class="hint">Enter driving license no</small>
            <span id="errmsgadhar" class="err-msg"></span>
        </div>
        
        <div class="col-md-4 col-sm-12 mb-3 form-group">
            <label for="dl_expiry">Driving License Expiry</label>
            <input type="date" class="form-control" id="dl_expiry" name="dl_expiry" min="<?php echo date("Y-m-d"); ?>" value="<?= $dl_expiry; ?>" />
            <small class="hint">Enter driving license expiry date</small>
        </div>

    </div>
</div>

<script>
	$(".select2").select2();

	$("select[name='hiring_type']").on('change',function(){
		var value = $("select[name='hiring_type'] option:selected").val();
		if (value == 'Foreign') {
			$('#applicant_country').val('');
			$('#country').val('');
			$('#applicant_country option').removeAttr('selected').filter('[value="Saudi Arabia"]').attr('disabled', true);
			$('#country option').removeAttr('selected').filter('[value="Saudi Arabia"]').attr('disabled', true);
			$('#agency-container').removeClass('d-none');
			//$('#agency_name').attr('required',true);
		} else {
			$('#applicant_country option').removeAttr('disabled');
			$('#country option').removeAttr('disabled');
			$('#applicant_country').val('Saudi Arabia');
			$('#country').val('Saudi Arabia');
			$('#applicant_country option').removeAttr('selected').filter('[value="Saudi Arabia"]').attr('selected', true);
			$('#country option').removeAttr('selected').filter('[value="Saudi Arabia"]').attr('selected', true);
			$('#agency-container').addClass('d-none');
			//$('#agency_name').attr('required',false);
			$('#agency_name').val('');
		}
	});

	$("select[name='employee_mode']").on('change',function(){
		var value = $("select[name='employee_mode'] option:selected").val();
		//$('.access-checked input').val('');
		$('.access-checked input[type="checkbox"]:checked').prop('checked',false);
		$(".access-checked select").val(null).trigger("change");
		if (value == 'user') {
			$('#allow_access').prop('disabled', false);
		} else {
			$('#allow_access').prop('disabled', true);
			$('#allow_access').prop('checked', false);
		}
	});
	
	$('#allow_access').on('click', function() {
		$(".access-checked select").val(null).trigger("change");
		$('.access-checked input[type="checkbox"]:checked').prop('checked',false);
		//$("#send_credential").val('');
		if($("#allow_access").is(":checked")) {
			$('.access-checked').removeClass('d-none');
			$('#display_language').prop('required',true);
			$('#employee_role').prop('required',true);
			$('#branches').prop('required',true);
		}else{
			$('.access-checked').addClass('d-none');
			$('#display_language').prop('required',false);
			$('#employee_role').prop('required',false);
			$('#branches').prop('required',false);
		}    
	});

	$('#extra_members').on('click', function() {
		$(".family-inner-section input").val('');
		if($("#extra_members").is(":checked")) {
			$('.family-container').removeClass('d-none');
			$('#family_iqama').prop('required',true);
			$('#family_name').prop('required',true);
			$('#family_relation').prop('required',true);
			$('#family_dob').prop('required',true);
			$('#family_insurance').prop('required',true);
		}else{
			$('.family-container').addClass('d-none');
			$('#family_iqama').prop('required',false);
			$('#family_name').prop('required',false);
			$('#family_relation').prop('required',false);
			$('#family_dob').prop('required',false);
			$('#family_insurance').prop('required',false);
		}    
	});
	
	$(document).ready( function () {
		hideShowDl();
		hideShowSaudiDl();
		rejecteReason();
		showHideInterview();
	});

	$('#dl_available').click(function() {
		hideShowDl()
	});

	function hideShowDl() { 
		if($("#dl_available").is(':checked')){
			$('#dl-container').removeClass('d-none');
			//$('#dl_no').attr('required',true);
		}else{
			$('#dl-container').addClass('d-none');
			//$('#dl_no').attr('required',false);
		}
	}
	
	$('#saudi_dl_available').click(function() {
		hideShowSaudiDl()
	});

	function hideShowSaudiDl() { 
		if($("#saudi_dl_available").is(':checked')){
			$('#saudi-dl-container').removeClass('d-none');
		}else{
			$('#saudi-dl-container').addClass('d-none');
		}
	}
	
	$('#interview_status').change(function() {
		rejecteReason();
	});

	function rejecteReason() { 
		var interview_status = $('#interview_status').find('option:selected').val();
		if(interview_status == 'rejected'){
			$('#rejection_container').removeClass('d-none');
			$('#interview_status').attr('required',true);
		}else{
			$('#rejection_container').addClass('d-none');
			$('#interview_status').attr('required',false);
		}
	}

	$('#cv_status').change(function() {
		showHideInterview();
	});

	function showHideInterview() { 
		var cv_status = $('#cv_status').find('option:selected').val();
		if(cv_status !== 'new'){
			$('.interview-container').removeClass('d-none');
		}else{
			$('.interview-container').addClass('d-none');
		}
	}

	$('#marital_status').change(function() {
		var marital_status = $(this).find('option:selected').val();
		if(marital_status == 'Single'){
			$('.spouse_field').addClass('d-none');
		}else{
			$('.spouse_field').removeClass('d-none');
		}
	});
	
	$('#applicant_country').change(function() {
		var country_id = $(this).find('option:selected').val();
		$.ajax({
			url: "<?php echo base_url(); ?>admin/Cv_controller/getAgency",
			data: {
				country_id: country_id
			},
			dataType: "json",
			type: "POST",
			success: function(data) {
				console.log(data);
				var html = '<option value="">Select Agency</option>';
				if (Object.keys(data).length > 0) {
					$.each(data, function(index, item) {
						html += '<option value="' + item.id + '" data-id="' + item.id + '">' + item.agency_name + '</option>';
					});
				} else {
					var html = '<option value="">No agency found</option>';
				}
				$('#agency_name').html(html);
			}
		});
	});

	$('.remove-cv-image').click(function() {
		var img_id = $(this).data('id');
		var cv_id = "<?php echo $this->input->get('id');?>";
		//alert(size_id);
		if(confirm('Are you sure want to delete?')) {
			if(img_id > 0){
				$.ajax({
					url: "<?php echo base_url('hiring-agency/cv/delete-image');?>",
					type: "POST",
					data: {
						img_id: img_id,
						cv_id: cv_id,
					},
					dataType: "json",
					success: function (data) {
						if(data.type == 'success'){
							$('#img_'+img_id).remove();
							Swal.fire({
								icon: 'success',
								title: 'Success',
								text: data.message,
								timer: 1500
							});
						}else{
							Swal.fire({
								icon: 'error',
								title: 'Error',
								text: data.message,
								timer: 1500
							});
						}
					},
					error: function (data) {
						console.log(data);
					},
				});
			}else{
				return false;
			}
		}else{
			return false;
		}
		return false;
	});

	function viewCertificate(identifier) {
		let doc = $(identifier).data('doc');
		let type = $(identifier).data('type');
		if(doc !== ''){
			$('.show-image-modal').modal('show');
			$('#summary_body_modal').html('<object data="'+doc+'#view=Fit" width="100%" height="600px" style="object-fit: scale-down;"><p>It appears your Web browser is not configured to display PDF files. No worries, just <a href="your_file.pdf">click here to download the PDF file.</a></p></object>');
			$('#summaryModalFullscreenLabel').html(type.toUpperCase());
		}else{
			alert('Invalid document type!');
		}
	}

	function checkDuplicateEmail() {
		var email_id = $("#email").val();
		var id = $("#id").val();
		if (email_id !== "") {
			$.ajax({
				url: "<?php echo base_url();?>admin/hr/master/employee/check-email",
				type: "GET",
				data: {
					email: email_id,
					id: id,
				},
				dataType: "json",
				success: function (data) {
					if(data.status == 'success'){
						$(".res-email").html(data.msg);
						$("#email").removeClass('parsley-error');
					}else{
						$("#email").val('');
						$("#email").addClass('parsley-error');
						$(".res-email").html(data.msg);
						return false;
					}
				},
				error: function () {
					$("#email").val('');
					$("#email").addClass('parsley-error');
					return false;
				},
			});
		} else {
			$("#email").addClass('parsley-error');
		}
	}
	
</script>
<script>
    //Add Family
	var template = $("#family_sections .family-inner-section:first").clone();
	//define counter
	var sectionsCount = 1;
	//add new section
	$("body").on("click", ".addsection", function () {
		//increment
		sectionsCount++;

		//loop through each input
		var section = template
			.clone()
			.find(":input").val("")
			.each(function () {
				//set id to store the updated section number
				var newId = this.id + sectionsCount;
				//alert(newId);
				$(this).prev().attr("for", newId);
				this.id = newId;
			})
			.end()
			//inject new section
			.appendTo("#family_sections");
		return false;
	});

	//remove section
	$("#family_sections").on("click", ".remove", function () {
		//fade out section
		$(this)
			.parent()
			.fadeOut(300, function () {
				//remove parent element (main section)
				$(this).parent().empty();
				return false;
			});
		return false;
	});
</script>
