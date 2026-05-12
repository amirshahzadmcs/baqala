
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
					<h4>Attendance Logs</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/attendance-logs/list'); ?>">Attendance</a></li>
						<li class="breadcrumb-item active">Logs</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id');?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if ($this->customer->userd($admin_id)->role == "Admin") {?>
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url('admin/attendance-logs/list'); ?>"><i class="fa fa-reply"></i> Back</a>
					<?php }?>
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
						<table class="table table-bordered">
							<tr>
								<th width="200px">Key</th>
								<th>Value</th>
							</tr>
							<tr>
								<td width="200px">Employee ID</td>
								<td><?php echo $attend_detail->emp_no;?></td>
							</tr>
							<tr>
								<td width="200px">Employee Name</td>
								<td><?php echo ucfirst($attend_detail->full_name);?><br><?php echo $attend_detail->designation_name;?></td>
							</tr>
							<tr>
								<td width="200px">Department</td>
								<td><?php echo $attend_detail->department_name;?></td>
							</tr>
							<tr>
								<td width="200px">Date of Attendance</td>
								<td><?php echo date('d-m-Y', strtotime($attend_detail->attendance_date));?></td>
							</tr>
							<tr>
								<td width="200px">Attendance In</td>
								<td><?php echo (!empty($attend_detail->time_in)) ? date('h:i:s a ', strtotime($attend_detail->time_in)) : "NA";?></td>
							</tr>
							<tr>
								<td width="200px">Attendance Out</td>
								<td><?php echo (!empty($attend_detail->time_out)) ? date('h:i:s a ', strtotime($attend_detail->time_out)) : "NA";?></td>
							</tr>
							<tr>
								<td width="200px">Status</td>
								<td><?php echo ($attend_detail->status == 'in') ? '<span class="badge badge-pill badge-soft-success font-size-13">In</span>' : '<span class="badge badge-pill badge-soft-dark font-size-13">Out</span>';?></td>
							</tr>
							<tr>
								<td width="200px">Cordinates(In)</td>
								<td><?php echo $attend_detail->time_in_lat_long;?> <a class="btn btn-primary btn-sm" href="https://maps.google.com/?q=<?php echo $attend_detail->time_in_lat_long;?>" target="_blank">Check On Map</a></td>
							</tr>
							<tr>
								<td width="200px">Cordinates(Out)</td>
								<td><?php echo $attend_detail->time_out_lat_long;?> <a class="btn btn-primary btn-sm" href="https://maps.google.com/?q=<?php echo $attend_detail->time_out_lat_long;?>" target="_blank">Check On Map</a></td>
							</tr>
							<tr>
								<td width="200px">Device IP</td>
								<td><?php echo $attend_detail->device_ip;?></td>
							</tr>
							<tr>
								<td width="200px">Device ID</td>
								<td><?php echo $attend_detail->device_id;?></td>
							</tr>
							<tr>
								<td width="200px">Device Information</td>
								<td><?php echo $attend_detail->device_detail;?></td>
							</tr>
							<tr>
								<td width="200px">Punch In Selfie</td>
								<td><?php echo (isset($attend_detail->device_detail)) ? '<img src="'. SELFIE_PATH_UPLOAD .$attend_detail->selfie .'" />' : 'NA';?></td>
							</tr>
						</table>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<?php $this->load->view('admin/home/footer');?>

<script type="text/javascript">
	
</script>
