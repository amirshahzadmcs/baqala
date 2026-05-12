
<?php $this->load->view('admin/home/header');?>
<style>
	.required-field{
		color:#f00;
	}
	.size-inner-section {
		box-shadow: 0px 1px 4px #c5c5c5;
		border-radius: 5px;
		margin-bottom: 10px;
	}
	input, textarea, select, select.select2{
		pointer-events: none;
	}
	input[type=checkbox] +label {
		pointer-events: none;
	}
</style>
<div id="wait"><i class="fa fa-spinner fa-spin"></i><br>Updating..</div>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Add Leave Policy</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/attendance/leave-policy'); ?>">Leave Policies</a></li>
						<li class="breadcrumb-item active">Add</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id');?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-2" title="Back" href="<?php echo base_url('admin/attendance/leave-policy'); ?>"><i class="fa fa-reply"></i> Back</a>
					<button onclick="submitButton()" form="policy_form" type="submit" class="btn btn-sm btn-custom-success pull-right" title="Save"><i class="fa fa-save"></i> Save</button>

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
						<?php echo form_open("admin/attendance/leave-policy/submit", array("id" => "policy_form", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
							<input type="hidden" id="id" name="id" value="<?php echo $policies->id;?>" required />
							
							<!-- Tab panes -->
							<div class="tab-content p-3 text-muted">
								<div class="tab-pane active" id="home1" role="tabpanel">
									<div class="row size-inner-section px-2 py-4">
										<h4 class="header-title">Leave Policy</h4><hr>
										<div class="col-md-4 col-sm-12 mb-2 form-group">
											<label for="name">Name <span class="required-field">*</span></label>
											<input type="text" class="form-control" id="name" name="name" maxlength="125" value="<?php echo $policies->name;?>" onBlur="checkDuplicateName()" required />
											<small class="hint res-msg">Enter Unique Policy Name</small>
										</div>
										<div class="col-md-4 col-sm-12 mb-2 form-group">
											<label for="name_ar">Arabic Name</label>
											<input type="text" class="form-control rtl-input" id="name_ar" name="name_ar" maxlength="120" value="<?php echo $policies->name_ar;?>" />
											<small class="hint">Enter Arabic Name</small>
										</div>
										<div class="col-md-4 col-sm-12 mb-2 form-group">
											<label for="policy_status">Type <span class="required-field">*</span></label>
											<select name="status" id="policy_status" class="form-select" required>
												<option value="active" <?php echo ($policies->status == 'active') ? ' selected' : '';?>>Active</option>
												<option value="inactive" <?php echo ($policies->status == 'inactive') ? ' selected' : '';?>>Inactive</option>
											</select>
											<small class="hint">Select policy Status</small>
										</div>
										<div class="col-md-6 col-sm-12 mb-2 form-group">
											<label for="description">Description</label>
											<textarea id="description" class="form-control" rows="2" autoresize="" name="description" cols="50" style="height: 68px;"><?php echo $policies->description;?></textarea>
										</div>
										<div class="col-md-6 col-sm-12 mb-2 form-group">
											<label for="description_ar">Description Arabic</label>
											<textarea id="description_ar" class="form-control rtl-input" rows="2" autoresize="" name="description_ar" cols="50" style="height: 68px;"><?php echo $policies->description_ar;?></textarea>
										</div>
									</div>
									<div class="row size-inner-section px-2 py-4 family-container">
										<h4 class="header-title">Allocations:</h4><hr>
										<table id="family_sections" class="table table-striped table-bordered table-hover">
											<thead>
												<tr>
													<td class="text-left" style="width: 10%;">Serial</td>
													<td class="text-left" style="width: 25%;">Leave Type <span class="required-field">*</span></td>
													
												</tr>
											</thead>
											<tbody>
												<?php $leave_types_array = explode(', ', $policies->leave_types);
												if(count($leave_types_array) > 0){ ?>
												<?php $count_type = 1;foreach($leave_types_array as $l_type){ ?>
												<tr class="family-inner-section">
													<td><?php echo $count_type++;?></td>
													<td class="text-left">
														<select name="leave_types[]" class="form-select" required>
															<option value="">Select Leave Type</option>
															<?php 
															if(count($leave_types) > 0){ 
															foreach($leave_types as $lt){
															?>
															<option value="<?php echo $lt['id']; ?>" <?php echo ($lt['id'] == $l_type) ? ' selected' : '' ?>><?php echo $lt['name']; ?></option>
															<?php }}else{ ?>
															<option value="">No Leave Type Found</option>
															<?php } ?>
														</select>
													</td>
												</tr>
												<?php }}?>
											</tbody>

										</table>
									</div>
								</div>
							</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<?php $this->load->view('admin/home/footer');?>
