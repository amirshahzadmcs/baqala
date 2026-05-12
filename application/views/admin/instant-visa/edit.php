<?php $this->load->view('admin/home/header');?>
<style>
.size-inner-section {
	box-shadow: 0px 1px 4px #c5c5c5;
	border-radius: 5px;
	margin-bottom: 10px;
}
</style>
<div id="wait"><i class="fa fa-spinner fa-spin"></i><br>Loading..</div>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Visa Assurance</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/talent-aquisition/visa'); ?>">Visa Assurance</a></li>
						<li class="breadcrumb-item active">Edit</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id');?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
				    <a class="btn btn-sm btn-custom-white pull-right ms-2" title="Back" href="<?php echo base_url('admin/talent-aquisition/visa'); ?>"><i class="fa fa-reply"></i> Back</a>
					<button form="demo-form2" type="submit" class="btn btn-sm btn-custom-success pull-right ms-2" title="Save"><i class="fa fa-save"></i> Save</button>

				</div>
				<?php if ($this->admin->getInfo()) {
				$info = explode("--", $this->admin->getInfo());
				$info_type = $info[0];
				$msg_data = $info[1];
				if ($info_type == 2) {
				?>
				<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<strong><?php echo $msg_data; ?></strong>
				</div>
				<?php } else {?>
				<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<strong><?php echo $msg_data; ?></strong>
				</div>
				<?php }}
				$this->admin->removeInfo();?>
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
						<div class="card">
							<div class="card-body">
								<div class="row">
									<div class="col-md-12"><h5 class="text-dark">Visa Details <a href="javscript:;" class="float-end" data-bs-toggle="modal" data-bs-target=".add-visa-modal"><i class="mdi mdi-pencil font-size-18"></i></a></h5><hr></div>
									<div class="col-md-4">
										<table>
											<tr>
												<td><strong>Date Of Issue</strong></td>
												<td width="20" align="center">:</td>
												<td><?php echo date('d-m-Y', strtotime($visa_detail->visa_issue_date));?></td>
											</tr>
											<tr>
												<td><strong>Unified No</strong></td>
												<td width="20" align="center">:</td>
												<td><?php echo $visa_detail->unified_no;?></td>
											</tr>
											<tr>
												<td><strong>Establishment Name (AR)</strong></td>
												<td width="20" align="center">:</td>
												<td><?php echo $visa_detail->establishment_name;?></td>
											</tr>
											<tr>
												<td><strong>Sponsor Name (EN)</strong></td>
												<td width="20" align="center">:</td>
												<td><?php echo $visa_detail->sponsor_name;?></td>
											</tr>
											<tr>
												<td><strong>Agency</strong></td>
												<td width="20" align="center">:</td>
												<td><?php echo $visa_detail->agency_name;?></td>
											</tr>
										</table>
									</div>
									<div class="col-md-4">
										<table>
											<tr>
												<td><strong>Establishment Number</strong></td>
												<td width="20" align="center">:</td>
												<td><?php echo $visa_detail->establishment_no;?></td>
											</tr>
											<tr>
												<td><strong>Visa Issue No.</strong></td>
												<td width="20" align="center">:</td>
												<td><?php echo $visa_detail->visa_issue_no;?></td>
											</tr>
											<tr>
												<td><strong>No. Of Visa</strong></td>
												<td width="20" align="center">:</td>
												<td><?php echo $visa_detail->used_border_entries;?>/<?php echo $visa_detail->no_of_visa;?></td>
											</tr>
											<tr>
												<td><strong>Request No</strong></td>
												<td width="20" align="center">:</td>
												<td><?php echo $visa_detail->request_no;?></td>
											</tr>
											<tr>
												<td><strong>Nationality</strong></td>
												<td width="20" align="center">:</td>
												<td><?php echo $visa_detail->nationality_name;?></td>
											</tr>
											<tr>
												<td><strong>Status</strong></td>
												<td width="20" align="center">:</td>
												<td>
													<?php
														if($visa_detail->vstatus == '0'){
															$visa_status = '<span class="badge badge-pill badge-soft-info font-size-13">New</span>';
														}elseif($visa_detail->vstatus == '1'){
															$visa_status = '<span class="badge badge-pill badge-soft-success font-size-13">Wakala Issued</span>';
														}elseif($visa_detail->vstatus == '2'){
															$visa_status = '<span class="badge badge-pill badge-soft-danger font-size-13">Cancelled</span>';
														}else{
															$visa_status = '<span class="badge badge-pill badge-soft-dark font-size-13">NA</span>';
														}
													?>
													<?php echo $visa_status;?>
												</td>
											</tr>
										</table>
									</div>
									<div class="col-md-4">
										<table>
											<tr>
												<td><strong>Occupation</strong></td>
												<td width="20" align="center">:</td>
												<td><?php echo $visa_detail->profession_name;?></td>
											</tr>
											<tr>
												<td><strong>Embassy</strong></td>
												<td width="20" align="center">:</td>
												<td><?php echo $visa_detail->embassy;?></td>
											</tr>
											<tr>
												<td><strong>Gender</strong></td>
												<td width="20" align="center">:</td>
												<td><?php echo ucfirst($visa_detail->gender);?></td>
											</tr>
											<tr>
												<td><strong>Religion</strong></td>
												<td width="20" align="center">:</td>
												<td><?php echo $visa_detail->religion;?></td>
											</tr>
											<tr>
												<td><strong>CR Number</strong></td>
												<td width="20" align="center">:</td>
												<td><?php echo $visa_detail->cr_no;?></td>
											</tr>
											<tr>
												<td><strong>Attachment</strong></td>
												<td width="20" align="center">:</td>
												<td><?php if($visa_detail->attachment){ ?><a href="<?php echo $visa_detail->attachment;?>" target="_blank">View File</a><?php }else{ echo 'NA';} ?></td>
											</tr>
										</table>
									</div>
								</div>
							</div>
						</div>
						<?php if($visa_list->num_rows() > 0){ ?>
						<div class="card">
							<div class="card-header">Update Border Numbers</div>
							<div class="card-body">
								<?php echo form_open("admin/talent-aquisition/visa/update-visa", array("id" => "demo-form2", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
									<input type="hidden" name="visa_id" value="<?php echo $visa_detail->id;?>" required />
									<?php 
										function get_results($val, $qt){
											$division = intdiv($val, $qt); // PHP <7: $division = ($val - ($val % $qt)) / $qt;
											$ret = array_fill(0, $qt, $division); // fill array with $qt equal values
											if($division != $val / $qt){ // if not whole division, add remaning to lsat element
												$ret[count($ret)-1] = $ret[0] + ($val % $qt);
											}
											return $ret;
										}
										$total = $visa_list->num_rows();
										$visa_array = get_results($total, 2);
										$visa_in_group = $visa_list->result_array();
									?>
									<div class="row">
										<?php $s_no = 0;foreach($visa_array as $v_array){ ?>
										<div class="col-md-6">
											<table class="table table-striped jambo_table table-bordered mb-0" id="item_table" width="100%" border="1" cellspacing="0" cellpadding="5">
												<thead>
													<tr>
														<td valign="top" bgcolor="#CCCCCC" style="width: 14%;"><strong>S. No.</strong></td>
														
														<td valign="top" bgcolor="#CCCCCC" style="width: 43%;"><strong>Border Number</strong></td>
													</tr>
												</thead>
												<tbody>
													<?php 
													for($i=1;$i <= $v_array; $i++){ 
													?>
													<tr>
														<td valign="top"><?php echo $s_no+1;?><input type="hidden" name="id[]" value="<?php echo $visa_in_group[$s_no]['id'];?>" required /></td>
														<td valign="top"><input type="text" name="border_nos[]" value="<?php echo $visa_in_group[$s_no]['border_nos'];?>" class="form-control" required="required" /></td>
													</tr>
													<?php $s_no = $s_no+1;} ?>
												</tbody>
											</table>
										</div>
										<?php } ?>
									</div>
								<?php echo form_close(); ?>
							</div>
						</div>
						<?php }else{ ?>
						<div class="card">
							<div class="card-header">Add Border Numbers</div>
							<div class="card-body">
								<?php echo form_open("admin/talent-aquisition/visa/save-visa", array("id" => "demo-form2", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
									<input type="hidden" name="visa_id" value="<?php echo $visa_detail->id;?>" required />
									<?php 
										function get_results($val, $qt){
											$division = intdiv($val, $qt); // PHP <7: $division = ($val - ($val % $qt)) / $qt;
											$ret = array_fill(0, $qt, $division); // fill array with $qt equal values
											if($division != $val / $qt){ // if not whole division, add remaning to lsat element
												$ret[count($ret)-1] = $ret[0] + ($val % $qt);
											}
											return $ret;
										}
										$total = $visa_detail->no_of_visa;
										$visa_array = get_results($total, 2);
									?>
									<div class="row">
										<?php $s_no = 1;foreach($visa_array as $v_array){ ?>
										<div class="col-md-6">
											<table class="table table-striped jambo_table table-bordered mb-0" id="item_table" width="100%" border="1" cellspacing="0" cellpadding="5">
												<thead>
													<tr>
														<td valign="top" bgcolor="#CCCCCC" style="width: 14%;"><strong>S. No.</strong></td>
														
														<td valign="top" bgcolor="#CCCCCC" style="width: 43%;"><strong>Border Number</strong></td>
													</tr>
												</thead>
												<tbody>
													<?php
													for($i=1;$i <= $v_array; $i++){ 
													?>
													<tr>
														<td valign="top"><?php echo $s_no;?></td>
														
														<td valign="top"><input type="text" name="border_nos[]" value="" class="form-control" required="required" /></td>
													</tr>
													<?php $s_no = $s_no+1;} ?>
												</tbody>
											</table>
										</div>
										<?php } ?>
									</div>
								<?php echo form_close(); ?>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<!-- Modal -->
 <div class="modal fade add-visa-modal" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0">Update Visa Information</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<?php echo form_open("admin/talent-aquisition/visas/update", array("id" => "visForm", "class" => "form-label-left", "data-parsley-validate" => "", "enctype" => "multipart/form-data")); ?>
					<input type="hidden" id="id" name="id" value="<?php echo $visa_detail->id;?>" required />
					<div class="row">
						<div class="col-md-4 col-sm-12 mb-3 form-group">
							<label for="visa_issue_date">Visa Issue Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control" id="visa_issue_date" name="visa_issue_date" value="<?php echo $visa_detail->visa_issue_date;?>" required />
						</div>
						<div class="col-md-4 col-sm-12 mb-3 form-group">
							<label for="unified_no">Unified No. <span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="unified_no" name="unified_no" value="<?php echo $visa_detail->unified_no;?>" maxlength="25" required />
						</div>
						<div class="col-md-4 col-sm-12 mb-3 form-group">
							<label for="establishment_name">Establishment Name (AR) <span class="text-danger">*</span></label>
							<input type="text" class="form-control rtl-input" id="establishment_name" name="establishment_name" maxlength="100" value="<?php echo $visa_detail->establishment_name;?>" required />
						</div>
						<div class="col-md-4 col-sm-12 mb-3 form-group">
							<label for="sponsor_name">Sponsor Name (EN) <span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="sponsor_name" name="sponsor_name" maxlength="100" value="<?php echo $visa_detail->sponsor_name;?>" required />
						</div>
						<div class="col-md-4 col-sm-12 mb-3 form-group">
							<label for="cr_no">CR Number <span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="cr_no" name="cr_no" maxlength="<?php echo CR_LENGTH;?>" value="<?php echo $visa_detail->cr_no;?>" required />
						</div>
						<div class="col-md-4 col-sm-12 mb-3 form-group">
							<label for="establishment_no">Establishment Number <span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="establishment_no" name="establishment_no" minlength="8" maxlength="9" value="<?php echo $visa_detail->establishment_no;?>" required />
						</div>
						<div class="col-md-4 col-sm-12 mb-3 form-group">
							<label for="visa_issue_no">Visa Issue Number <span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="visa_issue_no" name="visa_issue_no" maxlength="50" value="<?php echo $visa_detail->visa_issue_no;?>" required />
						</div>
						<div class="col-md-4 col-sm-12 mb-3 form-group">
							<label for="request_no">Request No <span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="request_no" name="request_no" maxlength="50" value="<?php echo $visa_detail->request_no;?>" required />
						</div>
						
						<div class="col-md-4 col-sm-12 mb-3 form-group">
							<label for="no_of_visa">No. of Visa <span class="text-danger">*</span></label>
							<input type="number" class="form-control" id="no_of_visa" name="no_of_visa" maxlength="5" value="<?php echo $visa_detail->no_of_visa;?>" readonly required />
						</div>
						
						<div class="col-md-4 col-sm-12 mb-3 form-group">
							<label for="occupation">Occupation <span class="text-danger">*</span></label>
							<select class="form-select select2" data-parsley-allselected="true" name="occupation" id="occupation" required>
								<option value="">Select Occupation</option>
								<?php foreach(professionList() as $profession) { ?>
								<option value="<?php echo $profession->id; ?>" data-id="<?php echo $profession->id; ?>" <?php echo ($profession->id == $visa_detail->occupation) ? ' selected ' : '' ?>><?php echo $profession->profession_name; ?> <?php echo (isset($profession->arabic_name)) ? '/ '.$profession->arabic_name : ''; ?></option>
								<?php } ?>
							</select>
						</div>
						
						<div class="col-md-4 col-sm-12 mb-3 form-group">
							<label for="gender">Gender <span class="text-danger">*</span></label>
							<select name="gender" id="gender" class="form-select" required>
								<option value="">Select Gender</option>
								<option value="male" <?php echo ($visa_detail->gender == 'male') ? ' selected ' : '' ?>>Male</option>
								<option value="female" <?php echo ($visa_detail->gender == 'female') ? ' selected ' : '' ?>>Female</option>
								<option value="other" <?php echo ($visa_detail->gender == 'other') ? ' selected ' : '' ?>>Other</option>
							</select>
						</div>
						<div class="col-md-4 col-sm-12 mb-3 form-group">
							<label for="religion">Religion <span class="text-danger">*</span></label>
							<select name="religion" id="religion" class="form-select" required>
								<option value="">Select Religion</option>
								<option value="Islam" <?php echo ($visa_detail->religion == 'Islam') ? ' selected ' : '' ?>>Islam</option>
								<option value="Non Islam" <?php echo ($visa_detail->religion == 'Non Islam') ? ' selected ' : '' ?>>Non Islam</option>
							</select>
						</div>

						<div class="col-md-4 col-sm-12 mb-2 form-group">
							<label for="visa_country">Country <span class="text-danger">*</span></label>
							<select class="form-select" name="visa_country" id="visa_country" required>
								<option value="">Select Country</option>
								<?php foreach (masterCountries() as $country_list) { ?>
									<option value="<?php echo $country_list->id; ?>" data-id="<?php echo $country_list->id; ?>" <?php echo ($visa_detail->visa_country == $country_list->id) ? ' selected ' : '' ?>><?php echo $country_list->name; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-md-4 col-sm-12 mb-3 form-group">
							<label for="nationality">Nationality <span class="text-danger">*</span></label>
							<select class="form-select select2" data-parsley-allselected="true" name="nationality" id="nationality" required>
								<option value="">Select Nationality</option>
								<?php foreach(nationalityList() as $nation) { ?>
								<option value="<?php echo $nation->id; ?>" data-id="<?php echo $nation->id; ?>" data-name="<?php echo $nation->name; ?>" <?php echo ($nation->id == $visa_detail->nationality) ? ' selected ' : '' ?>><?php echo $nation->name; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-md-4 col-sm-12 mb-3 form-group">
							<label for="embassy">Embassy <span class="text-danger">*</span></label>
							<select class="form-select select2" data-parsley-allselected="true" name="embassy" id="embassy" required>
								<option value="">Select Embassy</option>
								
							</select>
						</div>
						<div class="col-md-4 col-sm-12 mb-2 form-group" id="agency-container">
							<label for="agency">Agency Name <span class="text-danger">*</span></label>
							<select name="agency" id="agency" class="form-control select2" required>
								<option value="">Select Agency</option>
								<?php foreach (agencyCountrywiseHelper($visa_detail->visa_country) as $key => $value) { ?>
									<option value="<?php echo $value->id; ?>" <?php echo ($visa_detail->agency == $value->id) ? ' selected ' : '' ?>><?php echo $value->agency_name; ?></option>
								<?php } ?>
							</select>
						</div>
						
						<div class="col-md-4 col-sm-12 mb-3 form-group">
							<label for="vstatus">Status <span class="text-danger">*</span></label>
							<select name="vstatus" id="vstatus" class="form-select" required>
								<option value="">Select Status</option>
								<option value="0" <?php echo ($visa_detail->vstatus == '0') ? ' selected ' : '' ?>>New</option>
								<option value="1" <?php echo ($visa_detail->vstatus == '1') ? ' selected ' : '' ?>>Wakala Issued</option>
								<option value="2" <?php echo ($visa_detail->vstatus == '2') ? ' selected ' : '' ?>>Cancelled</option>
							</select>
						</div>
						<div class="col-md-4 col-sm-12 mb-3 form-group">
							<label for="attachment">Attachment</label>
							<input type="hidden" class="form-control" name="attachment_old" value="<?php echo $visa_detail->attachment;?>" />
							<input type="file" class="form-control" id="attachment" name="attachment" />
						</div>
						<div class="col-md-4 col-sm-12 mb-3 form-group">
							<?php if($visa_detail->attachment){ ?><p style="margin-top: 37px;"><a href="<?php echo $visa_detail->attachment;?>" target="_blank">View File</a></p><?php }else{ echo '';} ?>
						</div>
					</div>
				<?php echo form_close(); ?>
			</div>
			<div class="modal-footer">
                <button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="visForm" class="btn btn-success">Submit</button>
            </div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php $this->load->view('admin/home/footer');?>
<script>
	const embassyList = {
		"Indian": ["Mumbai", "Delhi"],
		"Pakistani": ["Karachi", "Islamabad", "Lahore"],
		"Bangladeshi": ["Dhaka"],
		"Nepali": ["Kathmandu"],
		"Yemani": ["Sana`a", "Aden"],
		"Saudi Arabian": ["Riyadh", "Jeddah"]
	};
	
	$(document).ready(function() {
		// Function to populate embassy dropdown based on selected nationality
		function populateEmbassies(nationality) {
			var embassies = embassyList[nationality] || [];
			
			// Clear previous embassy options
			$('#embassy').empty();
			$('#embassy').append('<option value="">Select Embassy</option>'); // Default option
			
			// Populate the embassy dropdown with new options
			$.each(embassies, function(index, embassy) {
				$('#embassy').append('<option value="' + embassy + '">' + embassy + '</option>');
			});

			// Set the selected embassy if one was already selected during edit
			var selectedEmbassy = "<?php echo $visa_detail->embassy;?>";
			if (selectedEmbassy) {
				$('#embassy').val(selectedEmbassy);  // Set it as selected in the dropdown
			}
		}

		// Event listener for nationality dropdown change
		$('#nationality').change(function() {
			var selectedOption = $('#nationality option:selected');  // Get the selected option
			var selectedNationality = selectedOption.data('name');   // Get the data-name attribute
			populateEmbassies(selectedNationality);                  // Populate embassy based on nationality
		});

		// When the modal is opened, populate the embassy dropdown for the already selected nationality
		$('.add-visa-modal').on('show.bs.modal', function() {
			var selectedNationality = $('#nationality option:selected').data('name');
			populateEmbassies(selectedNationality); // Populate embassy dropdown on modal open
		});

		// Set the selected embassy value from the PHP side when editing
		$('#embassy').data('selected', '<?php echo $visa_detail->embassy; ?>'); // Inject the selected embassy value
	});

	$('#visa_country').change(function() {
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
				$('#agency').html(html);
			}
		});
	});
</script>

