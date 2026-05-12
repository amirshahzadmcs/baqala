<?php $this->load->view('admin/home/header');?>
<style>
.table th, .table td {
    vertical-align: middle;
	padding: 6px 10px;
}
.nav-pills .nav-link.active, .nav-pills .show>.nav-link {
	color: #fff !important;
	background-color: #005500!important;
}
.nav-tabs-custom .nav-item .nav-link::after {
	content: "";
	background: #005500;
}
.nav-tabs-custom .nav-item .nav-link {
	background: #eee;
}
input, textarea, select, select.select2{
    pointer-events: none;
}
.modal input, .modal textarea, .modal select, .modal select.select2{
    pointer-events: auto;
}
span.required{
	color:red;
}
.size-inner-section {
	box-shadow: 0px 1px 4px #c5c5c5;
	border-radius: 5px;
	margin-bottom: 10px;
}
.cv-documents{
	border: 1px dashed #a9a9a9;
	padding: 6px;
	width: 130px;
	height: 130px;
	margin-top: -9px;
}
.image-container {
	position: relative;
	display: inline-block;
}
.image-container .overlay{
	opacity: 0;
}
.image-container:hover .overlay{
	background: #0006;
	opacity: .9;
	position: absolute;
	top: -9px;
	bottom: 0;
	width: 130px;
	height: 130px;
}
.image-container:hover .edit {
	display: block;
}
.image-container .edit {
	padding-top: 7px;	
	padding-right: 7px;
	position: absolute;
	right: 0;
	left: 0;
	top: 20%;
	display: none;
}
</style>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>CV Master</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/hr/recruitment/cv">CV</a></li>
						<li class="breadcrumb-item active">Detail</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url();?>admin/hr/recruitment/cv"><i class="fa fa-reply"></i> Back</a>
					<?php if($cv_detail->interview_status == 'selected'){ ?>
					<div class="btn-group ms-2">
						<button class="btn btn-custom-success btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="mdi mdi-printer"></i> Print Letters <i class="mdi mdi-chevron-down"></i>
						</button>
						<div class="dropdown-menu dropdown-menu-end">
							<?php if($cv_detail->hiring_type == 'Rider'){ ?>
							<a class="dropdown-item" href="<?php echo base_url('admin/hr/recruitment/cv/print-offer-letter?id='.$cv_detail->id); ?>" target="_blank"> Offer Letter</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo base_url('admin/hr/recruitment/cv/contract-form?id='.$cv_detail->id); ?>" target="_blank"> Mofa Contract</a>
							<?php }else{ ?>
								<a class="dropdown-item" href="<?php echo base_url('admin/hr/recruitment/cv/print-backoffice-offer?id='.$cv_detail->id); ?>" target="_blank"> Offer Letter</a>
							<?php } ?>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo base_url('admin/hr/recruitment/cv/print-promissory-note?id='.$cv_detail->id); ?>" target="_blank"> Promissory Note</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo base_url('admin/hr/recruitment/cv/food-req-form?id='.$cv_detail->id); ?>" target="_blank"> Food Advance Form</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo base_url('admin/hr/recruitment/cv/print-security-letter?id='.$cv_detail->id); ?>" target="_blank"> Security Deposit Letter</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo base_url('admin/hr/recruitment/cv/print-dl-expenses-letter?id='.$cv_detail->id); ?>" target="_blank"> Saudi DL Expenses Letter</a>
						</div>
					</div>
					<?php } ?>
				</div>

				<?php if($this->admin->getInfo()){
				$info = explode("--", $this->admin->getInfo());
				$info_type = $info[0];
				$msg_data = $info[1];
				if($info_type == 2){
				?>
					<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<strong><?php echo $msg_data;?></strong>
					</div>
					<?php } else{?>
					<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<strong><?php echo $msg_data;?></strong>
					</div>
				<?php } ?> <?php } $this->admin->removeInfo();?>

			</div>
		</div>
	</div>
 </div>
 <!-- end page title -->

<div class="container-fluid">
	<div class="page-content-wrapper">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<div class="row size-inner-section px-2 py-4">
							<h4 class="header-title">General Information</h4>
							<hr>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="cv_no">CV Number <span class="required-field">*</span></label>
								<input type="text" class="form-control" id="cv_no" name="cv_no" maxlength="150" required value="<?php echo $cv_detail->cv_no; ?>" readonly />
								<small class="hint">CV Number</small>
							</div>

							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="applicant_country">Country <span class="required-field">*</span></label>
								<select class="form-select" name="applicant_country" id="applicant_country" required>
									<option value="">Select Country</option>
									<?php foreach (masterCountries() as $country_list) { ?>
										<option value="<?php echo $country_list->id; ?>" data-id="<?php echo $country_list->id; ?>" <?php echo ($country_list->id == $cv_detail->applicant_country) ? ' selected ' : '' ?>><?php echo $country_list->name; ?></option>
									<?php } ?>
								</select>
								<small class="hint">Select Country</small>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group" id="agency-container">
								<label for="agency_name">Agency Name</label>
								<select name="agency_name" id="agency_name" class="form-control" data-placeholder="Choose Agency...">
									<option value="">Select Agency</option>
									<?php foreach (agencyCountrywiseHelper($cv_detail->applicant_country) as $key => $value) { ?>
										<option value="<?php echo $value->id; ?>" <?php echo ($cv_detail->agency_name == $value->id) ? ' selected ' : '' ?>><?php echo $value->agency_name; ?></option>
									<?php } ?>
								</select>
								<p class="hint">Choose Agency Name</p>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="hiring_type">Hiring Type <span class="required-field">*</span></label>
								<select name="hiring_type" id="hiring_type" class="form-select" required>
									<option value="">Select Hiring Type</option>
									<option value="Rider" <?php echo ($cv_detail->hiring_type == 'Rider') ? ' selected ' : '' ?>>Rider</option>
									<option value="Back Office" <?php echo ($cv_detail->hiring_type == 'Back Office') ? ' selected ' : '' ?>>General Staff</option>
								</select>
								<small class="hint">Select hiring type</small>
							</div>
							
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="applicant_type">Applicant Type <span class="required-field">*</span></label>
								<select class="form-select" name="applicant_type" id="applicant_type" required>
									<option value="">Select Type</option>
									<option value="Fresher" <?php echo ($cv_detail->applicant_type == 'Fresher') ? ' selected ' : '' ?>>Fresher</option>
									<option value="Saudi Return" <?php echo ($cv_detail->applicant_type == 'Saudi Return') ? ' selected ' : '' ?>>Saudi Return</option>
									<option value="GCC Return" <?php echo ($cv_detail->applicant_type == 'GCC Return') ? ' selected ' : '' ?>>GCC Return</option>
									<option value="Local Transfer" <?php echo ($cv_detail->applicant_type == 'Local Transfer') ? ' selected ' : '' ?>>Local Transfer</option>
								</select>
								<small class="hint">Select Applicant Type</small>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="applied_for">Position Applied For <span class="required-field">*</span></label>
								<select name="applied_for" id="applied_for" class="form-select" required data-placeholder="Choose Position...">
									<option value="">Select Position</option>
									<?php foreach ($positions as $pos) { ?>
										<option value="<?php echo $pos->id; ?>" <?php echo ($pos->id == $cv_detail->applied_for) ? ' selected ' : '' ?>><?php echo $pos->name; ?></option>
									<?php } ?>
								</select>
								<small class="hint">Select Applied For</small>
							</div>
						</div>
						<div class="row size-inner-section px-2 py-4">
							<h4 class="header-title">Candidate Profile</h4>
							<hr>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="first_name">First Name <span class="required-field">*</span></label>
								<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="first_name" name="first_name" maxlength="150" value="<?php echo $cv_detail->first_name; ?>" required />
								<small class="hint">Enter Candidate First Name</small>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="middle_name">Middle Name</label>
								<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="middle_name" name="middle_name" maxlength="150" value="<?php echo $cv_detail->middle_name; ?>" />
								<small class="hint">Enter Candidate Middle Name</small>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="third_name">Third Name</label>
								<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="third_name" name="third_name" maxlength="150" value="<?php echo $cv_detail->third_name; ?>" />
								<small class="hint">Enter Candidate Third Name</small>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="surname">Last Name</label>
								<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="surname" name="surname" maxlength="150" value="<?php echo $cv_detail->surname; ?>" />
								<small class="hint">Enter Candidate Last Name</small>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="candidate_arabic_name">Candidate Full Name in Arabic<span class="required-field">*</span></label>
								<input type="text" class="form-control rtl-input" id="candidate_arabic_name" name="candidate_arabic_name" maxlength="150" value="<?php echo $cv_detail->candidate_arabic_name; ?>" required />
								<small class="hint">Enter Candidate Name in Arabic</small>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="dob">Date of Birth <span class="required-field">*</span></label>
								<input type="date" class="form-control" id="dob" name="dob" value="<?php echo $cv_detail->dob; ?>" max="<?php echo date("Y-m-d"); ?>" required />
								<small class="hint">Enter Date of Birth</small>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="age">Age <small class="required-field">*</small></label>
								<input type="number" class="form-control" id="age" name="age" value="<?php echo $cv_detail->age; ?>" required readonly />
								<small class="hint">Candidate age</small>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="gender">Gender <span class="required-field">*</span></label>
								<select name="gender" id="gender" class="form-select" required data-placeholder="Choose Gender...">
									<option value="">Select</option>
									<option value="male" <?php echo ($cv_detail->gender == 'male') ? ' selected ' : '' ?>>Male</option>
									<option value="female" <?php echo ($cv_detail->gender == 'female') ? ' selected ' : '' ?>>Female</option>
									<option value="other" <?php echo ($cv_detail->gender == 'other') ? ' selected ' : '' ?>>Other</option>
								</select>
								<small class="hint">Select Gender</small>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="marital_status">Marital Status <span class="required-field">*</span></label>
								<select name="marital_status" id="marital_status" class="form-select" required data-placeholder="Choose Marital Status...">
									<option value="">Select</option>
									<option value="Single" <?php echo ($cv_detail->marital_status == 'Single') ? ' selected ' : '' ?>>Single</option>
									<option value="Married" <?php echo ($cv_detail->marital_status == 'Married') ? ' selected ' : '' ?>>Married</option>
									<option value="Divorced" <?php echo ($cv_detail->marital_status == 'Divorced') ? ' selected ' : '' ?>>Divorced</option>
								</select>
								<small class="hint">Select Marital Status</small>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="nationality">Nationality <span class="required-field">*</span></label>
								<select class="form-select" name="nationality" id="nationality" required>
									<option value="">Select Nationality</option>
									<?php foreach ($nationalities as $nation) { ?>
										<option value="<?php echo $nation->name; ?>" data-id="<?php echo $nation->id; ?>" <?php echo ($nation->name == $cv_detail->nationality) ? ' selected ' : '' ?>><?php echo $nation->name; ?></option>
									<?php } ?>
								</select>
								<small class="hint">Select Nationality</small>
							</div>
						</div>
						<div class="row size-inner-section px-2 py-4">
							<h4 class="header-title">Homeland Contact Details</h4>
							<hr>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="mobile">Mobile No. <span class="required-field">*</span></label>
								<input type="text" onKeyPress="return numerics(event);" class="form-control" id="mobile" name="mobile" value="<?php echo $cv_detail->mobile; ?>" minlength="<?= MOB_LENGTH; ?>" maxlength="<?= MOB_LENGTH; ?>" required />
								<small class="hint">Enter Mobile Number</small>
							</div>

							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="imo_available">IMO Available <span class="required-field">*</span></label>
								<select name="imo_available" id="imo_available" class="form-select" required>
									<option value="">Select</option>
									<option value="yes" <?php echo ($cv_detail->imo_available == 'yes') ? ' selected ' : '' ?>>Yes</option>
									<option value="no" <?php echo ($cv_detail->imo_available == 'no') ? ' selected ' : '' ?>>No</option>
								</select>
								<small class="hint">Select 'Yes' if you are on IMO app.</small>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="email">Personal Email ID</label>
								<input type="email" class="form-control" id="email" name="email" value="<?php echo $cv_detail->email; ?>" />
								<small class="hint">Enter Email</small>
							</div>
						</div>

						<div class="row size-inner-section px-2 py-4">
							<h4 class="header-title">Homeland Emergency Contact Details</h4>
							<hr>
							<table id="family_sections" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<td class="text-left">Contact Person Name <span class="required-field">*</span></td>
										<td class="text-left">Contact Person Relationship <span class="required-field">*</span></td>
										<td class="text-left">Contact Person Mobile <span class="required-field">*</span></td>
										<td style="width: 5%;"></td>
									</tr>
								</thead>
								<tbody>
									<?php if(count($families) > 0){ ?>
									<?php foreach($families as $fmembers){ ?>
									<tr class="family-inner-section">
										<td class="text-left">
											<div class="input-group">
												<input type="text" name="person_name[]" class="form-control" value="<?php echo $fmembers['person_name'];?>" maxlength="100">
											</div>
										</td>
										<td class="text-left" style="width: 30%;">
											<select name="relationship[]" class="form-select">
												<option value="">Select Relationship</option>
												<option value="Aunt" <?php echo ($fmembers['relationship'] == 'Aunt') ? ' selected' : '' ?>>Aunt</option>
												<option value="Brother" <?php echo ($fmembers['relationship'] == 'Brother') ? ' selected' : '' ?>>Brother</option>
												<option value="Daughter" <?php echo ($fmembers['relationship'] == 'Daughter') ? ' selected' : '' ?>>Daughter</option>
												<option value="Father" <?php echo ($fmembers['relationship'] == 'Father') ? ' selected' : '' ?>>Father</option>
												<option value="Father in Law" <?php echo ($fmembers['relationship'] == 'Father in Law') ? ' selected' : '' ?>>Father in Law</option>
												<option value="Mother" <?php echo ($fmembers['relationship'] == 'Mother') ? ' selected' : '' ?>>Mother</option>
												<option value="Mother in Law" <?php echo ($fmembers['relationship'] == 'Mother in Law') ? ' selected' : '' ?>>Mother in Law</option>
												<option value="Sister" <?php echo ($fmembers['relationship'] == 'Sister') ? ' selected' : '' ?>>Sister</option>
												<option value="Son" <?php echo ($fmembers['relationship'] == 'Son') ? ' selected' : '' ?>>Son</option>
												<option value="Uncle" <?php echo ($fmembers['relationship'] == 'Uncle') ? ' selected' : '' ?>>Uncle</option>
												<option value="Wife" <?php echo ($fmembers['relationship'] == 'Wife') ? ' selected' : '' ?>>Wife</option>
											</select>
										</td>
										<td class="text-left">
											<div class="input-group">
												<input type="text" name="contact_no[]" class="form-control" value="<?php echo $fmembers['contact_no'];?>" maxlength="120">
											</div>
										</td>
										<td class="text-right">
											<a href="javascript:;" class="btn btn-danger btn-sm float-end remove"><i class="fa fa-minus-circle"></i></a>
										</td>
									</tr>
									<?php }}else{ ?>
									<tr class="family-inner-section">
										<td class="text-left">
											<div class="input-group">
												<input type="text" name="person_name[]" class="form-control" maxlength="100">
											</div>
										</td>
										<td class="text-left" style="width: 30%;">
											<select name="relationship[]" class="form-select">
												<option value="">Select Relationship</option>
												<option value="Son">Son</option>
												<option value="Wife">Wife</option>
												<option value="Daughter">Daughter</option>
												<option value="Mother">Mother</option>
												<option value="Brother">Brother</option>
												<option value="Sister">Sister</option>
												<option value="Mother in Law">Mother in Law</option>
												<option value="Father in Law">Father in Law</option>
												<option value="Uncle">Uncle</option>
												<option value="Aunt">Aunt</option>
											</select>
										</td>
										<td class="text-left">
											<div class="input-group">
												<input type="text" name="contact_no[]" class="form-control" maxlength="120">
											</div>
										</td>
										<td class="text-right">
											<a href="javascript:;" class="btn btn-danger btn-sm float-end remove"><i class="fa fa-minus-circle"></i></a>
										</td>
									</tr>
									<?php } ?>
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
								<label for="passport_no">Passport Number <span class="required-field">*</span></label>
								<input type="text" class="form-control" id="passport_no" name="passport_no" minlength="8" maxlength="<?= PASSPORT_LENGTH; ?>" value="<?php echo $cv_detail->passport_no; ?>" onBlur="checkDuplicatePassport()" required />
								<small class="hint passport-info">Enter Passport Number</small>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="passport_exp">Passport Expiry Date <span class="required-field">*</span></label>
								<input type="date" class="form-control" id="passport_exp" name="passport_exp" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $cv_detail->passport_exp; ?>" required />
								<small class="hint">Enter Passport Expiry Date</small>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="passport_issue_country">Passport Issuing Country <span class="required-field">*</span></label>
								<select name="passport_issue_country" id="passport_issue_country" class="form-select" data-placeholder="Choose Passport Issue Country..." required>
									<option value="">Select Country</option>
									<?php foreach (masterCountries() as $nation) { ?>
										<option value="<?php echo $nation->id; ?>" <?php echo ($nation->id == $cv_detail->passport_issue_country) ? ' selected ' : '' ?>><?php echo $nation->name; ?></option>
									<?php } ?>
								</select>
								<small class="hint">Select Country</small>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="passport_issue_city">Passport Issuing City <span class="required-field">*</span></label>
								<input type="text" class="form-control" id="passport_issue_city" name="passport_issue_city" maxlength="100" value="<?php echo $cv_detail->passport_issue_city; ?>" required />
								<small class="hint">Enter passport issue city</small>
							</div>

							<div class="col-md-12 col-sm-12 mb-2 form-group">
								<input class="checkbox" type="checkbox" id="dl_available" name="dl_available" <?php echo ($cv_detail->dl_available == 'on') ? ' checked ' : '' ?> style="vertical-align: sub;margin-right: 10px;">
								<label class="form-check-label" for="dl_available">
									Do you have Homeland Driving License
								</label>
								<small class="hint"> (Check if you have driving License.)</small>
							</div>
							<div id="dl-container" class="row d-none">
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="dl_no">Driving License No</label>
									<input type="text" class="form-control" id="dl_no" name="dl_no" minlength="<?= DL_LENGTH; ?>" maxlength="<?= DL_LENGTH; ?>" value="<?= $cv_detail->dl_no; ?>" />
									<small class="hint">Enter driving license no</small>
									<span id="errmsgadhar" class="err-msg"></span>
								</div>

								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="dl_expiry">Driving License Expiry</label>
									<input type="date" class="form-control" id="dl_expiry" name="dl_expiry" min="<?php echo date("Y-m-d"); ?>" value="<?= $cv_detail->dl_expiry; ?>" />
									<small class="hint">Enter driving license expiry date</small>
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="dl_documents">Upload DL Documents</label>
									<input type="file" class="form-control" id="dl_documents" name="dl_documents[]" multiple />
									<div class="col-md-12 mt-2">
										<?php
										if (count($documents) > 0) {
											foreach ($documents as $cv_doc) {
												if ($cv_doc['doc_type'] == 'dl') {
													$file_extension = pathinfo($cv_doc['document'], PATHINFO_EXTENSION);
										?>
													<div class="float-start text-center image-container mt-2 me-2" id="img_<?php echo $cv_doc['id']; ?>">
														<img src="<?php echo ($file_extension == 'doc' || $file_extension == 'docx' || $file_extension == 'pdf') ? base_url('images/attached-file.png') : base_url($cv_doc['document']); ?>" class="cv-documents" />
														<div class="overlay"></div>
														<div class="edit"><a href="<?php echo base_url($cv_doc['document']); ?>" class="btn btn-primary btn-sm" target="_blank" title="View"><i class="fa fa-eye"></i></a> <a type="button" class="btn btn-danger btn-sm remove-cv-image" data-id="<?php echo $cv_doc['id']; ?>" title="Delete"><i class="fa fa-trash"></i></a></div>
													</div>
										<?php }
											}
										} ?>
									</div>
								</div>
							</div>

							<div class="col-md-12 col-sm-12 mb-2 form-group">
								<input class="checkbox" type="checkbox" id="saudi_dl_available" name="saudi_dl_available" <?php echo ($cv_detail->saudi_dl_available == 'on') ? 'checked' : '' ?> style="vertical-align: sub;margin-right: 10px;">
								<label class="form-check-label" for="saudi_dl_available">
									Do you have Saudi/GCC Driving License
								</label>
								<small class="hint"> (Check if you have Saudi driving License.)</small>
							</div>
							<div id="saudi-dl-container" class="row d-none">
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="dl_type">Driving License Type</label>
									<select name="dl_type" id="dl_type" class="form-select">
										<option value="">Select Type</option>
										<option value="Saudi" <?php echo ($cv_detail->dl_type == 'Saudi') ? ' selected ' : '' ?>>Saudi</option>
										<option value="GCC" <?php echo ($cv_detail->dl_type == 'GCC') ? ' selected ' : '' ?>>GCC</option>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="current_dl">Driving License No</label>
									<input type="text" class="form-control" id="current_dl" name="current_dl" minlength="<?= DL_LENGTH; ?>" maxlength="<?= DL_LENGTH; ?>" value="<?= $cv_detail->current_dl; ?>" />
									<small class="hint">Enter saudi driving license no</small>
									<span id="errmsgadhar" class="err-msg"></span>
								</div>

								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="current_dl_expiry">Driving License Expiry</label>
									<input type="date" class="form-control" id="current_dl_expiry" name="current_dl_expiry" min="<?php echo date("Y-m-d"); ?>" value="<?= $cv_detail->current_dl_expiry; ?>" />
									<small class="hint">Enter saudi driving license expiry date</small>
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="saudi_dl_documents">Upload Saudi DL Documents</label>
									<input type="file" class="form-control" id="saudi_dl_documents" name="saudi_dl_documents[]" multiple />
									<div class="col-md-12 mt-2">
										<?php
										if (count($documents) > 0) {
											foreach ($documents as $cv_doc) {
												if ($cv_doc['doc_type'] == 'saudi_dl') {
													$file_extension = pathinfo($cv_doc['document'], PATHINFO_EXTENSION);
										?>
													<div class="float-start text-center image-container mt-2 me-2" id="img_<?php echo $cv_doc['id']; ?>">
														<img src="<?php echo ($file_extension == 'doc' || $file_extension == 'docx' || $file_extension == 'pdf') ? base_url('images/attached-file.png') : base_url($cv_doc['document']); ?>" class="cv-documents" />
														<div class="overlay"></div>
														<div class="edit"><a href="<?php echo base_url($cv_doc['document']); ?>" class="btn btn-primary btn-sm" target="_blank" title="View"><i class="fa fa-eye"></i></a> <a type="button" class="btn btn-danger btn-sm remove-cv-image" data-id="<?php echo $cv_doc['id']; ?>" title="Delete"><i class="fa fa-trash"></i></a></div>
													</div>
										<?php }
											}
										} ?>
									</div>
								</div>
							</div>
						</div>

						<div class="row size-inner-section px-2 py-4">
							<h4 class="header-title">CV Status</h4>
							<hr>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="cv_status">Candidate Status <span class="required-field">*</span></label>
								<select name="cv_status" id="cv_status" class="form-select" required>
									<option value="new" <?php echo ($cv_detail->cv_status == 'new') ? ' selected ' : '' ?>>New</option>
									<option value="shortlisted" <?php echo ($cv_detail->cv_status == 'shortlisted') ? ' selected ' : '' ?>>Shortlisted</option>
									<option value="not_qualified" <?php echo ($cv_detail->cv_status == 'not_qualified') ? ' selected ' : '' ?>>Not Qualified</option>
								</select>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="interviewer">Interviewer Name <span class="required-field">*</span></label>
								<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="interviewer" name="interviewer" value="<?php echo $cv_detail->interviewer; ?>" />
								<small class="hint">Enter Interviewer's Name</small>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="interview_date">Interview Date <span class="required-field">*</span></label>
								<input type="date" class="form-control" id="interview_date" name="interview_date" value="<?php echo $cv_detail->interview_date; ?>" />
								<small class="hint">Enter Interview Date Date</small>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="interview_status">Interview Status<span class="required-field">*</span></label>
								<select name="interview_status" id="interview_status" class="form-select">
									<option value="">Select Status</option>
									<option value="none" <?php echo ($cv_detail->interview_status == 'none') ? ' selected ' : '' ?>>None</option>
									<option value="selected" <?php echo ($cv_detail->interview_status == 'selected') ? ' selected ' : '' ?>>Selected</option>
									<option value="rejected" <?php echo ($cv_detail->interview_status == 'rejected') ? ' selected ' : '' ?>>Rejected</option>
								</select>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group" id="rejection_container">
								<label for="rejection_reason">Reason for rejection (if rejected)<span class="required-field">*</span></label>
								<input type="text" class="form-control" id="rejection_reason" name="rejection_reason" value="<?php echo $cv_detail->rejection_reason; ?>" />
								<small class="hint">Write rejection's reason</small>
							</div>
						</div>

						<div class="row size-inner-section px-2 py-4">
							<h4 class="header-title">Offer Letter Package</h4>
							<hr>
							<div class="col-md-4 col-sm-12 mb-2 form-group <?php echo ($cv_detail->hiring_type == 'Rider') ? '' : 'd-none';?>" id="riderPackage">
								<label for="rider_package_id">Select Salary Package<span class="required-field">*</span></label>
								<select name="rider_package_id" id="rider_package_id" class="form-select" data-placeholder="Choose Package..." >
									<option value="">Select Package</option>
									<?php foreach (salaryPackage() as $salary_package) { ?>
										<option value="<?php echo $salary_package->id; ?>" <?php echo ($cv_detail->rider_package_id == $salary_package->id) ? ' selected ' : '' ?>><?php echo $salary_package->package_name; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="offer_letter_status">Offer Letter Status<span class="required-field">*</span></label>
								<select name="offer_letter_status" id="offer_letter_status" class="form-select">
									<option value="">Select Status</option>
									<option value="accepted" <?php echo ($cv_detail->offer_letter_status == 'accepted') ? ' selected ' : '' ?>>Accepted</option>
									<option value="rejected" <?php echo ($cv_detail->offer_letter_status == 'rejected') ? ' selected ' : '' ?>>Rejected</option>
								</select>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group d-none" id="deploymentStatus">
								<label for="deployment_status">Deployment Status<span class="required-field">*</span></label>
								<select name="deployment_status" id="deployment_status" class="form-select">
									<option value="">Select Status</option>
									<option value="arrived" <?php echo ($cv_detail->deployment_status == 'arrived') ? ' selected ' : '' ?>>Arrived</option>
									<option value="cancelled" <?php echo ($cv_detail->deployment_status == 'cancelled') ? ' selected ' : '' ?>>Cancelled</option>
								</select>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group d-none" id="rejectReason">
								<label for="offer_reject_reason">Reject Reason<span class="required-field">*</span></label>
								<select name="offer_reject_reason" id="offer_reject_reason" class="form-select">
									<option value="">Select Reason</option>
									<option value="Medical Unfit" <?php echo ($cv_detail->offer_reject_reason == 'Medical Unfit') ? ' selected ' : '' ?>>Medical Unfit</option>
									<option value="Offer Rejected" <?php echo ($cv_detail->offer_reject_reason == 'Offer Rejected') ? ' selected ' : '' ?>>Offer Rejected</option>
								</select>
							</div>
							<table class="table border <?php echo ($cv_detail->hiring_type == 'Rider') ? 'd-none' : '';?>" id="packageTable">
								<thead style="background-color: #ffd04542!important;">
									<tr>
										<th class="text-center" style="width: 50%;">English</th>
										<th class="text-center">Arabic</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<label for="total_salary_en">Total Salary</label>
											<input type="text" class="form-control" id="total_salary_en" name="total_salary_en" value="<?php echo $backoffice_package['total_salary_en'];?>" />
										</td>
										<td>
											<label for="total_salary_ar" style="float: right;">Total Salary</label>
											<input type="text" class="form-control rtl-input" id="total_salary_ar" name="total_salary_ar" value="<?php echo $backoffice_package['total_salary_ar'];?>" />
										</td>
									</tr>
									<tr>
										<td>
											<label for="basic_salary_en">Basic Salary</label>
											<input type="text" class="form-control" id="basic_salary_en" name="basic_salary_en" value="<?php echo $backoffice_package['basic_salary_en'];?>" />
										</td>
										<td>
											<label for="basic_salary_ar" style="float: right;">Basic Salary</label>
											<input type="text" class="form-control rtl-input" id="basic_salary_ar" name="basic_salary_ar" value="<?php echo $backoffice_package['basic_salary_ar'];?>" />
										</td>
									</tr>
									<tr>
										<td>
											<label for="housing_allowance_en">Housing Allowance</label>
											<input type="text" class="form-control" id="housing_allowance_en" name="housing_allowance_en" value="<?php echo $backoffice_package['housing_allowance_en'];?>" />
										</td>
										<td>
											<label for="housing_allowance_ar" style="float: right;">Housing Allowance</label>
											<input type="text" class="form-control rtl-input" id="housing_allowance_ar" name="housing_allowance_ar" value="<?php echo $backoffice_package['housing_allowance_ar'];?>" />
										</td>
									</tr>
									<tr>
										<td>
											<label for="transport_allowance_en">Transportation Allowance</label>
											<input type="text" class="form-control" id="transport_allowance_en" name="transport_allowance_en" value="<?php echo $backoffice_package['transport_allowance_en'];?>" />
										</td>
										<td>
											<label for="transport_allowance_ar" style="float: right;">Transportation Allowance</label>
											<input type="text" class="form-control rtl-input" id="transport_allowance_ar" name="transport_allowance_ar" value="<?php echo $backoffice_package['transport_allowance_ar'];?>" />
										</td>
									</tr>
									<tr>
										<td>
											<label for="order_allowance_en">Food Allowance</label>
											<input type="text" class="form-control" id="order_allowance_en" name="order_allowance_en" value="<?php echo $backoffice_package['order_allowance_en'];?>" />
										</td>
										<td>
											<label for="order_allowance_ar" style="float: right;">Food Allowance</label>
											<input type="text" class="form-control rtl-input" id="order_allowance_ar" name="order_allowance_ar" value="<?php echo $backoffice_package['order_allowance_ar'];?>" />
										</td>
									</tr>
									<tr>
										<td>
											<label for="other_en">Other</label>
											<input type="text" class="form-control" id="other_en" name="other_en" value="<?php echo $backoffice_package['other_en'];?>" />
										</td>
										<td>
											<label for="other_ar" style="float: right;">Other</label>
											<input type="text" class="form-control rtl-input" id="other_ar" name="other_ar" value="<?php echo $backoffice_package['other_ar'];?>" />
										</td>
									</tr>
									<tr>
										<td>
											<label for="annual_vacation_en">Annual Vacation</label>
											<input type="text" class="form-control" id="annual_vacation_en" name="annual_vacation_en" value="<?php echo $backoffice_package['annual_vacation_en'];?>" />
										</td>
										<td>
											<label for="annual_vacation_ar" style="float: right;">Annual Vacation</label>
											<input type="text" class="form-control rtl-input" id="annual_vacation_ar" name="annual_vacation_ar" value="<?php echo $backoffice_package['annual_vacation_ar'];?>" />
										</td>
									</tr>
									<tr>
										<td>
											<label for="medical_insurance_en">Medical Insurance (Use comma ',' for line break)</label>
											<input type="text" class="form-control" id="medical_insurance_en" name="medical_insurance_en" value="<?php echo $backoffice_package['medical_insurance_en'];?>" />
										</td>
										<td>
											<label for="medical_insurance_ar" style="float: right;">Medical Insurance (Use comma ',' for line break)</label>
											<input type="text" class="form-control rtl-input" id="medical_insurance_ar" name="medical_insurance_ar" value="<?php echo $backoffice_package['medical_insurance_ar'];?>" />
										</td>
									</tr>
									<tr>
										<td>
											<label for="contract_period_en">Contract Period</label>
											<input type="text" class="form-control" id="contract_period_en" name="contract_period_en" value="<?php echo $backoffice_package['contract_period_en'];?>" />
										</td>
										<td>
											<label for="contract_period_ar" style="float: right;">Contract Period</label>
											<input type="text" class="form-control rtl-input" id="contract_period_ar" name="contract_period_ar" value="<?php echo $backoffice_package['contract_period_ar'];?>" />
										</td>
									</tr>
								</tbody>
							</table>

						</div>

						<div class="row size-inner-section px-2 py-4 deployment-status-depend">
							<h4 class="header-title">Arrival Status</h4>
							<hr>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="arrival_date">Arrival Date</label>
								<input type="date" class="form-control" id="arrival_date" name="arrival_date" value="<?php echo $cv_detail->arrival_date; ?>" />
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="border_entry_no">Border Entry No.</label>
								<input type="text" class="form-control" id="border_entry_no" name="border_entry_no" value="<?php echo $cv_detail->border_entry_no; ?>" />
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="sponsor_id">Sponsor ID</label>
								<input type="text" class="form-control" id="sponsor_id" name="sponsor_id" maxlength="30" value="<?php echo $cv_detail->sponsor_id; ?>" />
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="sponsor_name">Sponsor Name</label>
								<input type="text" class="form-control" id="sponsor_name" name="sponsor_name" maxlength="120" value="<?php echo $cv_detail->sponsor_name; ?>" />
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="visa_no">Visa No.</label>
								<input type="text" class="form-control" id="visa_no" name="visa_no" maxlength="30" value="<?php echo $cv_detail->visa_no; ?>" />
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="visa_entry_date">Visa Entry Date</label>
								<input type="date" class="form-control" id="visa_entry_date" name="visa_entry_date" max="<?php echo date("Y-m-d"); ?>" value="<?php echo $cv_detail->visa_entry_date; ?>" />
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="visa_expiry">Visa Expiry Date</label>
								<input type="date" class="form-control" id="visa_expiry" name="visa_expiry" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $cv_detail->visa_expiry; ?>" />
							</div>
							
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="blood_group">Blood Group</label>
								<select name="blood_group" id="blood_group" class="form-select">
									<option value="">Select Blood Group</option>
									<option value="A+" <?php echo ($cv_detail->blood_group == 'A+') ? ' selected ' : '' ?>>A+</option>
									<option value="A-" <?php echo ($cv_detail->blood_group == 'A-') ? ' selected ' : '' ?>>A-</option>
									<option value="B+" <?php echo ($cv_detail->blood_group == 'B+') ? ' selected ' : '' ?>>B+</option>
									<option value="B-" <?php echo ($cv_detail->blood_group == 'B-') ? ' selected ' : '' ?>>B-</option>
									<option value="AB+" <?php echo ($cv_detail->blood_group == 'AB+') ? ' selected ' : '' ?>>AB+</option>
									<option value="AB-" <?php echo ($cv_detail->blood_group == 'AB-') ? ' selected ' : '' ?>>AB-</option>
									<option value="O+" <?php echo ($cv_detail->blood_group == 'O+') ? ' selected ' : '' ?>>O+</option>
									<option value="O-" <?php echo ($cv_detail->blood_group == 'O-') ? ' selected ' : '' ?>>O-</option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<div class="modal fade bs-offer-modal" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0">Offer Letter Data</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body cred-modal-body">
				<?php echo form_open("admin/hr/recruitment/cv/print-offer-letter", array("id"=>"cv_print_form", "class"=>"form-label-left", "target"=>"_blank", "data-parsley-validate"=> "")); ?>
					<input type="hidden" id="id" name="id" value="<?php echo $id;?>" />
					<div class="row">
						<div class="col-md-6 col-sm-12 mb-3 form-group">
							<label for="project_code">Project Code <span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="project_code" name="project_code" value="FDHS" required />
						</div>
						<div class="col-md-6 col-sm-12 mb-3 form-group">
							<label for="project_name">Project Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="project_name" name="project_name" value="Food Delivery – Hunger Station" required />
						</div>
						<div class="col-md-6 col-sm-12 mb-3 form-group">
							<label for="reporting_to">Reporting to <span class="text-danger">*</span></label>
							<select name="reporting_to" id="reporting_to" class="form-select" required data-placeholder="Choose Reporting to">
								<option value="">Select Designation</option>
								<?php foreach($positions as $pos) { ?>
									<option value="<?php echo $pos->name; ?>" <?php echo ($pos->name == $reporting_to) ? ' selected ' : '' ?>><?php echo $pos->name; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-md-6 col-sm-12 mb-2 form-group">
							<label for="department">Department <span class="text-danger">*</span></label>
							<select name="department" id="department" class="form-select" required data-placeholder="Choose Department...">
								<option value="">Select Department</option>
								<?php foreach($departments as $department) { ?>
									<option value="<?php echo $department->name; ?>" <?php echo ($department->name == $department) ? ' selected ' : '' ?>><?php echo $department->name; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-md-6 col-sm-12 mb-3 form-group">
							<label for="work_location">Work Location <span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="work_location" name="work_location" value="Riyadh" required />
						</div>
						<div class="col-md-6 col-sm-12 mb-3 form-group">
							<label for="working_hrs">Woking Hours <span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="working_hrs" name="working_hrs" value="Flexible – 6 Days" required />
						</div>
						<div class="col-md-6 col-sm-12 mb-3 form-group">
							<label for="probation_period">Probation Period <span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="probation_period" name="probation_period" value="90 Days" required />
						</div>
						<div class="col-md-6 col-sm-12 mb-3 form-group">
							<label for="contract_period">Contract Period <span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="contract_period" name="contract_period" value="Two (2) Years" required />
						</div>
						<div class="col-md-6 col-sm-12 mb-2 form-group">
							<label for="package_id">Select Salary Package <span class="text-danger">*</span></label>
							<select name="package_id" id="package_id" class="form-select" required>
								<option value="">Select Package</option>
								<?php foreach(salaryPackage() as $salary_package) { ?>
									<option value="<?php echo $salary_package->id; ?>" <?php echo ($salary_package->id == $package_id) ? ' selected ' : '' ?>><?php echo $salary_package->package_name; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-md-12 col-sm-12 mb-3 form-group">
							<button type="submit" class="btn btn-custom-success float-end">Print Offer Letter</button>
						</div>
					</div>
				<?php form_close();?>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this->load->view('admin/home/footer');?>

<div class="modal fade show-image-modal" role="dialog" aria-labelledby="ModalFullscreenLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title mt-0" id="summaryModalFullscreenLabel">Show</h6>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" id="summary_body_modal">
                
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
	$("select[name='hiring_type']").on('change', function() {
		var value = $("select[name='hiring_type'] option:selected").val();
		if (value == 'Rider') {
			$('#riderPackage').removeClass('d-none');
			$('#riderPackage').attr('required',true);
			$('#packageTable').addClass('d-none');
		} else {
			$('#riderPackage').addClass('d-none');
			$('#riderPackage').attr('required',false);
			$('#packageTable').removeClass('d-none');
		}
	});

	$("select[name='employee_mode']").on('change',function(){
		var value = $("select[name='employee_mode'] option:selected").val();
		$('.access-checked input').val('');
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
		$("#send_credential").val('');
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
		hideAccessCont();
		showHideOfferStatus();
		showHideArrivalStatus();
	});

	function hideAccessCont() { 
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
	}

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
	
	$('#offer_letter_status').change(function() {
		showHideOfferStatus();
	});

	function showHideOfferStatus() {
		$('#deploymentStatus, #rejectReason').addClass('d-none');
		$('#deployment_status, #offer_reject_reason').attr('required', false);
		var offer_status = $('#offer_letter_status').find('option:selected').val();
		if (offer_status == 'accepted') {
			$('#deploymentStatus').removeClass('d-none');
			$('#deployment_status').attr('required', true);
		} else if(offer_status == 'rejected') {
			$('#rejectReason').removeClass('d-none');
			$('#offer_reject_reason').attr('required', true);
		}
	}

	$('#deployment_status').change(function() {
		showHideArrivalStatus();
	});

	function showHideArrivalStatus() {
		var deployment_status = $('#deployment_status').find('option:selected').val();
		if (deployment_status == 'arrived') {
			$('.deployment-status-depend').removeClass('d-none');
		} else if(deployment_status == 'cancelled') {
			$('.deployment-status-depend').addClass('d-none');
		}else{
			$('.deployment-status-depend').addClass('d-none');
		}
	}

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
				//console.log(data);
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
	
	$(document).ready(function() {
        $('#dob').on('change', function() {
            calculateAge('#dob', '#age');
        });

        if ($('#dob').val()) {
            calculateAge('#dob', '#age');
        }
    });
</script>
