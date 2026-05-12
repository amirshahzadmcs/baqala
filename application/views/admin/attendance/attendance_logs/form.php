
<?php $this->load->view('admin/home/header');?>

<style>
	.required-field{
		color:#f00;
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
	.size-inner-section {
		box-shadow: 0px 1px 4px #c5c5c5;
		border-radius: 5px;
		margin-bottom: 10px;
	}
	
</style>
<div id="wait"><i class="fa fa-spinner fa-spin"></i><br>Updating..</div>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Attendance Logs</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/attendance-logs/list'); ?>">Attendance</a></li>
						<li class="breadcrumb-item active">Add</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id');?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if ($this->customer->userd($admin_id)->role == "Admin") {?>
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url('admin/attendance-logs/list'); ?>"><i class="fa fa-reply"></i> Back</a>
					<?php }?>
					&nbsp;
					<button onclick="submitButton()" form="employee_form" type="submit" class="btn btn-sm btn-custom-success pull-right" title="Save"><i class="fa fa-save"></i> Save</button>

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
					<div class="card-header">
							<h6>Attendance Information</h6>
					</div>
					<div class="card-body">
						<div class="col-lg-12">
							<div class="row">
								<div class="col-lg-4">
									<label for="date" class="control-label">Attendance Date</label>
									<div class="input-group" id="datepicker2">
										<input type="text" class="form-control" placeholder="dd-m-yyyy"data-date-format="dd-m-yyyy" data-date-container='#datepicker2' data-provide="datepicker" data-date-autoclose="true">
        								 <span class="input-group-text"><i class="mdi mdi-calendar"></i></span></div>
								</div>
								<div class="col-lg-4">
									<div class="mb-3">
										<label class="form-label">Employee Name</label>
										<select class="form-control select2">
											<option>Select</option>
										</select>
									</div>
								</div>
								<hr>
								<div class="col-lg-12">
									<span style="float:left"><b>Status</b></span>
								</div>
								<div class="col-lg-4">
									<div class=" p-1" style="background-color: #e9ebef!important;">
										<input  type="radio" id="presentattendance" name="present" checked="" style="margin-right: 10px;height: 25px;width: 25px;">
										<span style="vertical-align: super;">Present</span>
									</div>
								</div>
								<div class="col-lg-4">
									<div class=" p-1" style="background-color: #e9ebef!important;">
										<input  type="radio" id="Absentattendance" name="absent" checked="" style="margin-right: 10px;height: 25px;width: 25px;">
										<span style="vertical-align: super;">Absent</span>
									</div>
								</div>
								<div class="col-lg-4">
									<div class=" p-1" style="background-color: #e9ebef!important;">
										<input  type="radio" id="leaveattendance" name="leave" checked="" style="margin-right: 10px;height: 25px;width: 25px;">
										<span style="vertical-align: super;">On Leave</span>
									</div>
								</div>
								<div class="col-lg-4 mt-5">
									<div class="mb-3">
										<label class="form-label">Leave Type <span class="required">*</span></label>
										<select class="form-control select2">
											<option>Select</option>
										</select>
									</div>
								</div>
								<div class="col-md-12">
									<div class="mb-2">
										<button type="button" class="btn px-0 font-weight-bold text-muted collapsed"   id="advancedbtn">Advanced <i class="fas fa-caret-down"></i></button>
										<span class="tip-circle tip tooltipstered non observed" data-title="You can record the leaves beginning balance for the employees in easy manner by enter the count of the leaves."><i class="fas fa-question-circle"></i></span>
									</div>
									<div class="collapse" id="advancedOptions2" style="">
										<div class="row">
											<div class="col-md-6 form-group  input-error-target">
												<label for="leave_count" class="control-label">Leave Count <span class="required">*</span>
												</label>
												<input id="leave_count" class="form-control" allowminus="" placeholder="Leave Count" required="required" step="0.01" lang="en" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : ((event.charCode >= 48 &amp;&amp; event.charCode <= 57) || event.charCode == 46 || event.charCode == 45)" name="leave_count" type="number" value="1">
												<div class="invalid-message filled backend-error">
												<span></span>
												</div>
											</div>
											<div class="col-md-12">
												<hr class="mb-4 mt-3">
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-12">
                                    <hr class="mb-4 mt-3">
                                </div>
								<div class="col-md-6 form-group  input-error-target">
									<label for="notes" class="control-label">Notes
									</label>
									<textarea id="notes" class="form-control" rows="5" autoresize="" style="height: 131px;" name="notes" cols="50"></textarea>
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
<script type="text/javascript">
$(document).ready(function(){
 $('#advancedbtn').click(function () {
    if ($('#advancedOptions2').is(':hidden')) {
        $('#advancedOptions2').show();
    } else {
        $('#advancedOptions2').hide();
    }
  }); 
});
</script>


