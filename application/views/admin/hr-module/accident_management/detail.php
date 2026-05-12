
<?php $this->load->view('admin/home/header');?>

<style>
.size-inner-section {
	box-shadow: 0px 1px 4px #c5c5c5;
	border-radius: 5px;
	margin-bottom: 10px;
}
.size-inner-section .form-group p{
	background: #ededed;
    padding-top: 10px;
}
</style>
<div id="wait"><i class="fa fa-spinner fa-spin"></i><br>Updating..</div>
<!-- start page title -->
<div class="page-title-box">
<div class="container-fluid">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<div class="page-title">
				<h4>Accident Management</h4>
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="<?php echo base_url('admin/hr/accident-management'); ?>">Accident Management</a></li>
					<li class="breadcrumb-item active">Detail</li>
				</ol>
			</div>
		</div>
		<?php $admin_id = $this->session->userdata('admin_id');?>
		
		<div class="col-sm-6">
			<div class="float-end d-sm-block">
				<a class="btn btn-sm btn-custom-white pull-right me-2" title="Back" href="<?php echo base_url('admin/hr/accident-management'); ?>"><i class="fa fa-reply"></i> Back</a>
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
					<div class="employee-profile-pic text-center">
						<div id="empNameContainer" class="pt-2">
							<h5 id="employeeName" class="mb-0">
								<?php 
									if($vehicle_detail['vehicle_type'] == 'bike') {
										$vehicle_no = '🛵 '. $vehicle_detail['vehicle_no'];
									}
									else
									{
										$vehicle_no = '🚗 '. $vehicle_detail['vehicle_no'];
									}
								?>
								Vehicle : <?= $vehicle_no .' - '. $vehicle_detail['vehicle_model']; ?>
							</h5>
						</div>
					</div>
					<div class="pt-3">
						<div class="row size-inner-section px-2 py-4 mx-2">
							<h4 class="header-title">Vehicles Information</h4><hr>
							<?php if(!empty($vehicle_detail)){ ?>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="iqama_no">Vehicle Plate No :</label>
								<p class="form-control"><b><?php echo $vehicle_detail['vehicle_no'];?></b></p>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="iqama_name_en">Vehicle Make :</label>
								<p class="form-control"><b><?php echo $vehicle_detail['make_name'];?></b></p>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="iqama_name_ar">Vehicle Model :</label>
								<p class="form-control"><b><?php echo $vehicle_detail['vehicle_model'];?></b></p>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="iqama_issue_date">Vehicle Year :</label>
								<p class="form-control"><b><?php echo $vehicle_detail['vehicle_year'];?></b></p>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
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
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="insurance_provider">Insurance Service Provider :</label>
								<input type="hidden" id="insurance_provider" name="insurance_provider" value="<?php echo $vehicle_detail['insurance_company_name'];?>" required />
								<p class="form-control"><b><?php echo ($vehicle_detail['company_name'] !== '' && $vehicle_detail['company_name'] !== NULL) ? $vehicle_detail['company_name'] : 'NA';?></b></p>
							</div>

							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="ins_policy_no">Insurance Policy Number :</label>
								<input type="hidden" id="ins_policy_no" name="ins_policy_no" value="<?php echo $vehicle_detail['insurance_no'];?>" />
								<p class="form-control"><b><?php echo ($vehicle_detail['policy_number'] !== '' && $vehicle_detail['policy_number'] !== NULL) ? $vehicle_detail['policy_number'] : 'NA';?></b></p>
							</div>

							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="ins_start_date">Insurance Start Date :</label>
								<input type="hidden" id="ins_start_date" name="ins_start_date" value="<?php echo $vehicle_detail['insurance_issue_date'];?>" />
								<p class="form-control"><b><?php echo ($vehicle_detail['insurance_issue_date'] !== '' && $vehicle_detail['insurance_issue_date'] !== '0000-00-00') ? formatedDate($vehicle_detail['insurance_issue_date']) : 'NA';?></b></p>
							</div>

							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="ins_end_date">Insurance End Date :</label>
								<input type="hidden" id="ins_end_date" name="ins_end_date" value="<?php echo $vehicle_detail['insurance_expiry'];?>" />
								<p class="form-control"><b><?php echo ($vehicle_detail['insurance_expiry'] !== NULL && $vehicle_detail['insurance_expiry'] !== '' && $vehicle_detail['insurance_expiry'] !== '0000-00-00') ? formatedDate($vehicle_detail['insurance_expiry']) : 'NA';?></b></p>
							</div>
							
							<div class="col-md-4 col-sm-12 mb-2 form-group">
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
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="accident_date">Accident Date </label>
								<p class="form-control"><b><?php echo ($accident_detail['accident_date'] !== '' && $accident_detail['accident_date'] !== '0000-00-00') ? formatedDate($accident_detail['accident_date']) : 'NA';?></b></p>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="accident_time">Accident Time <span class="required-field">*</span></label>
								<p class="form-control"><b><?php echo ($accident_detail['accident_time'] !== '' && $accident_detail['accident_time'] !== '00:00:00') ? $accident_detail['accident_time'] : 'NA';?></b></p>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="accident_location">Accident Location <span class="required-field">*</span></label>
								<p class="form-control"><b><?php echo ($accident_detail['accident_location'] !== '' && $accident_detail['accident_location'] !== NULL) ? $accident_detail['accident_location'] : 'NA';?></b></p>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="accident_attended_by">Accident Attended By </label>
								<select name="accident_attended_by" id="accident_attended_by" class="form-control" disabled>
									<option value="">Select Iqama Status</option>
									<option value="Najam" <?php echo ($accident_detail['accident_attended_by'] == 'Najam') ? 'selected' : '';?>>Najam</option>
									<option value="Morror" <?php echo ($accident_detail['accident_attended_by'] == 'Morror') ? 'selected' : '';?>>Morror</option>
								</select>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="ambulance">Ambulance</label>
								<p class="form-control"><b><?php echo ($accident_detail['ambulance'] !== '' && $accident_detail['ambulance'] !== NULL) ? $accident_detail['ambulance'] : 'NA';?></b></p>
							</div>
							
						</div>

						<div class="row size-inner-section px-2 py-4 mx-2">
							<h4 class="header-title">Reports</h4><hr>
							<?php if($accident_detail['accident_attended_by'] == 'Najam'){ ?>
							<div class="col-md-4 col-sm-12 mb-2 form-group najam-relation">
								<label for="hhdr_report_no">HHDR Report No </label>
								<input type="text" class="form-control" id="hhdr_report_no" name="hhdr_report_no" value="<?php echo $accident_detail['hhdr_report_no'];?>" maxlength="25" disabled />
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group najam-relation">
								<label for="hhdr_report_attachment">HHDR Report Attachment</label>
								<p class="form-control"><b><?php echo ($accident_detail['hhdr_report_attachment'] !== '' && $accident_detail['hhdr_report_attachment'] !== NULL) ? '<a href="'.$accident_detail['hhdr_report_attachment'].'" target="_blank">View Attachment</a>' : 'NA';?></b></p>
							</div>

							<div class="col-md-4 col-sm-12 mb-2 form-group najam-relation">
								<label for="ld_report_no">LD Report Number</label>
								<p class="form-control"><b><?php echo ($accident_detail['ld_report_no'] !== '' && $accident_detail['ld_report_no'] !== NULL) ? $accident_detail['ld_report_no'] : 'NA';?></b></p>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group najam-relation">
								<label for="ld_report_attachment">LD Report Attachment</label>
								<p class="form-control"><b><?php echo ($accident_detail['ld_report_attachment'] !== '' && $accident_detail['ld_report_attachment'] !== NULL) ? '<a href="'.$accident_detail['ld_report_attachment'].'" target="_blank">View Attachment</a>' : 'NA';?></b></p>
							</div>
							<?php } ?>
							
							<?php if($accident_detail['accident_attended_by'] == 'Morror'){ ?>
							<div class="col-md-4 col-sm-12 mb-2 form-group maroor-relation">
								<label for="maroor_report_no">Morror Report No </label>
								<input type="text" class="form-control" id="maroor_report_no" name="maroor_report_no" value="<?php echo $accident_detail['maroor_report_no'];?>" disabled />
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group maroor-relation">
								<label for="attach_maroor_report">Attach Morror Report</label>
								<p class="form-control"><b><?php echo ($accident_detail['attach_maroor_report'] !== '' && $accident_detail['attach_maroor_report'] !== NULL) ? '<a href="'.$accident_detail['attach_maroor_report'].'" target="_blank">View Attachment</a>' : 'NA';?></b></p>
							</div>
							<?php } ?>
						</div>

						<div class="row size-inner-section px-2 py-4 mx-2">
							<h4 class="header-title">Taqdeer Information</h4><hr>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="taqdeer_inspection_date">Taqdeer Inspection Date </label>
								<p class="form-control"><b><?php echo ($accident_detail['taqdeer_inspection_date'] !== '' && $accident_detail['taqdeer_inspection_date'] !== '0000-00-00') ? formatedDate($accident_detail['taqdeer_inspection_date']) : 'NA';?></b></p>
							</div>

							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="da_final_report_no">DA Final Report No</label>
								<input type="text" class="form-control" id="da_final_report_no" name="da_final_report_no" minlength="12" value="<?php echo $accident_detail['da_final_report_no'];?>" maxlength="12" disabled />
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="attach_da_final_report">Attach DA Final Report</label>
								<p class="form-control"><b><?php echo ($accident_detail['attach_da_final_report'] !== '' && $accident_detail['attach_da_final_report'] !== NULL) ? '<a href="'.$accident_detail['attach_da_final_report'].'" target="_blank">View Attachment</a>' : 'NA';?></b></p>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="da_liability_perc">DA Liability %</label>
								<input type="text" class="form-control" id="da_liability_perc" name="da_liability_perc" value="<?php echo $accident_detail['da_liability_perc'];?>" disabled />
							</div>
							
						</div>
						
						<div class="row size-inner-section px-2 py-4 mx-2">
							<h4 class="header-title">Fees & Expenses</h4><hr>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="taqdeer_da_fees">Taqdeer DA Fees </label>
								<input type="text" class="form-control" id="taqdeer_da_fees" name="taqdeer_da_fees" value="<?php echo $accident_detail['taqdeer_da_fees'];?>" disabled />
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="insurance_claim_fees">Insurance Claim Fees </label>
								<input type="text" class="form-control" id="insurance_claim_fees" name="insurance_claim_fees" value="<?php echo $accident_detail['insurance_claim_fees'];?>" disabled />
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="other_cost">Other Cost </label>
								<input type="text" class="form-control" id="other_cost" name="other_cost" value="<?php echo $accident_detail['other_cost'];?>" disabled />
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="final_assessment_cost">Final Assessment Cost </label>
								<input type="text" class="form-control" id="final_assessment_cost" name="final_assessment_cost" value="<?php echo $accident_detail['final_assessment_cost'];?>" disabled />
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="created_at">Created At </label>
								<p class="form-control"><b><?php echo ($accident_detail['created_at'] !== '' && $accident_detail['created_at'] !== '0000-00-00') ? formatedDateTime($accident_detail['created_at']) : 'NA';?></b></p>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="updated_at">Last Updated </label>
								<p class="form-control"><b><?php echo ($accident_detail['updated_at'] !== '' && $accident_detail['updated_at'] !== '0000-00-00') ? formatedDateTime($accident_detail['updated_at']) : 'NA';?></b></p>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div> <!-- end col -->
	</div> <!-- end row -->
</div>
</div>
<!-- container-fluid -->

<?php $this->load->view('admin/home/footer');?>
