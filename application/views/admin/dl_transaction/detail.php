
<?php $this->load->view('admin/home/header');?>

<style>
	input, textarea, select, .select2{
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
					<h4>DL Request</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/dl-request/list'); ?>">DL Request</a></li>
						<li class="breadcrumb-item active">Detail</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id');?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url('admin/dl-request/list'); ?>"><i class="fa fa-reply"></i> Back</a>
					
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
						<div class="row">
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="emp_id">Select Employee <span class="text-danger">*</span></label>
								<select name="emp_id" id="emp_id" class="form-control select2" required data-placeholder="Choose Employee...">
									<option value="">Select Employee</option>
									<?php foreach(employeeListHelper() as $emp) { ?>
										<option value="<?php echo $emp->id; ?>" <?php echo ($dl_detail->emp_id == $emp->id) ? ' selected ' : '' ?>><?php echo $emp->emp_no; ?> - <?php echo $emp->full_name; ?> (<?php echo $emp->designation_name; ?>)</option>
									<?php } ?>
								</select>
								<small class="hint res-msg">Select Employee</small>
							</div>

							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="dl_type">DL Type <span class="text-danger">*</span></label>
								<select name="dl_type" id="dl_type" class="form-control select2" required data-placeholder="Choose DL Type...">
									<option value="bike" <?php echo ($dl_detail->dl_type == 'bike') ? ' selected ' : '' ?>>Bike</option>
									<option value="car" <?php echo ($dl_detail->dl_type == 'car') ? ' selected ' : '' ?>>Car</option>
								</select>
								<small class="hint">Select DL Type</small>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="blood_group">Blood Group <span class="text-danger">*</span></label>
								<select name="blood_group" id="blood_group" class="form-control select2" required data-placeholder="Choose Blood group...">
									<option value="A positive" <?php echo ($dl_detail->blood_group == 'A positive') ? ' selected ' : '' ?>>A positive</option>
									<option value="A negative" <?php echo ($dl_detail->blood_group == 'A negative') ? ' selected ' : '' ?>>A negative</option>
									<option value="B positive" <?php echo ($dl_detail->blood_group == 'B positive') ? ' selected ' : '' ?>>B positive</option>
									<option value="B negative" <?php echo ($dl_detail->blood_group == 'B negative') ? ' selected ' : '' ?>>B negative</option>
									<option value="AB positive" <?php echo ($dl_detail->blood_group == 'AB positive') ? ' selected ' : '' ?>>AB positive</option>
									<option value="AB negative" <?php echo ($dl_detail->blood_group == 'AB negative') ? ' selected ' : '' ?>>AB negative</option>
									<option value="O positive" <?php echo ($dl_detail->blood_group == 'O positive') ? ' selected ' : '' ?>>O positive</option>
									<option value="O negative" <?php echo ($dl_detail->blood_group == 'O negative') ? ' selected ' : '' ?>>O negative</option>
								</select>
								<small class="hint">Select Blood Group</small>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="dl_status">Status <span class="text-danger">*</span></label>
								<select name="status" id="dl_status" class="form-control select2" required data-placeholder="Choose Status...">
									<option value="Pending" <?php echo ($dl_detail->dl_status == 'Pending') ? ' selected ' : '' ?>>Pending</option>
									<option value="In Process" <?php echo ($dl_detail->dl_status == 'In Process') ? ' selected ' : '' ?>>In Process</option>
									<option value="Completed" <?php echo ($dl_detail->dl_status == 'Completed') ? ' selected ' : '' ?>>Completed</option>
								</select>
								<small class="hint">Select Status Type</small>
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

