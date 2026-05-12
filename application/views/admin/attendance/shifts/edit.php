
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
</style>
<div id="wait"><i class="fa fa-spinner fa-spin"></i><br>Updating..</div>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Edit Shift</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/attendance/shift-list'); ?>">Shift List</a></li>
						<li class="breadcrumb-item active">Edit</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id');?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-2" title="Back" href="<?php echo base_url('admin/attendance/shift-list'); ?>"><i class="fa fa-reply"></i> Back</a>
					<button onclick="submitButton()" form="shift_form" type="submit" class="btn btn-sm btn-custom-success pull-right" title="Save"><i class="fa fa-save"></i> Save</button>

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
						<?php echo form_open("admin/attendance/shift/submit", array("id" => "shift_form", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
							<input type="hidden" id="id" name="id" value="<?php echo $shifts->id;?>" />
							
							<!-- Tab panes -->
							<div class="tab-content p-3 text-muted">
								<div class="tab-pane active" id="home1" role="tabpanel">
									<div class="row size-inner-section px-2 py-4">
										<h4 class="header-title">Shift Information</h4><hr>
										<div class="col-md-4 col-sm-12 mb-2 form-group">
											<label for="name">Name <span class="required-field">*</span></label>
											<input type="text" class="form-control" id="name" name="name" maxlength="120" value="<?php echo $shifts->name;?>" onBlur="checkDuplicateName()" required />
											<small class="hint res-msg">Enter Unique Shift Name</small>
										</div>
										<div class="col-md-4 col-sm-12 mb-2 form-group">
											<label for="name_ar">Arabic Name</label>
											<input type="text" class="form-control rtl-input" id="name_ar" name="name_ar" maxlength="120" value="<?php echo $shifts->name_ar;?>" />
											<small class="hint">Enter Arabic Shift Name</small>
										</div>
										<div class="col-md-4 col-sm-12 mb-2 form-group">
											<label for="type">Type <span class="required-field">*</span></label>
											<select name="type" id="type" class="form-select" required>
												<option value="standard" <?php echo ($shifts->type == 'standard') ? ' selected' : '' ?>>Standard</option>
												<!-- <option value="advanced">Advanced</option> -->
											</select>
											<small class="hint">Select Shift Type</small>
										</div>
									</div>
									<div class="row size-inner-section px-2 py-4">
										<h4 class="header-title">Week Days:</h4><hr>
										<table class="table table-striped table-bordered table-hover">
											<thead>
												<tr>
													<td class="text-left">Day<span class="required-field">*</span></td>
													<td class="text-left">Work Day <span class="required-field">*</span></td>
												</tr>
											</thead>
											<tbody>
												<?php $week_array = explode(', ', $shifts->week_days);?>
												<tr>
													<td>Sunday</td>
													<td class="text-left">
														<input type="checkbox" switch="bool" name="week_days[sunday]" id="sunday" <?php echo (in_array('sunday', $week_array)) ? ' checked' : '' ?> />
														<label for="sunday" data-on-label="Yes" data-off-label="No"></label>
													</td>
												</tr>
												<tr>
													<td>Monday</td>
													<td class="text-left">
														<input type="checkbox" switch="bool" name="week_days[monday]" id="monday" <?php echo (in_array('monday', $week_array)) ? ' checked' : '' ?> />
														<label for="monday" data-on-label="Yes" data-off-label="No"></label>
													</td>
												</tr>
												<tr>
													<td>Tuesday</td>
													<td class="text-left">
														<input type="checkbox" switch="bool" name="week_days[tuesday]" id="tuesday" <?php echo (in_array('tuesday', $week_array)) ? ' checked' : '' ?> />
														<label for="tuesday" data-on-label="Yes" data-off-label="No"></label>
													</td>
												</tr>
												<tr>
													<td>Wednesday</td>
													<td class="text-left">
														<input type="checkbox" switch="bool" name="week_days[wednesday]" id="wednesday" <?php echo (in_array('wednesday', $week_array)) ? ' checked' : '' ?> />
														<label for="wednesday" data-on-label="Yes" data-off-label="No"></label>
													</td>
												</tr>
												<tr>
													<td>Thursday</td>
													<td class="text-left">
														<input type="checkbox" switch="bool" name="week_days[thursday]" id="thursday" <?php echo (in_array('thursday', $week_array)) ? ' checked' : '' ?> />
														<label for="thursday" data-on-label="Yes" data-off-label="No"></label>
													</td>
												</tr>
												<tr>
													<td>Friday</td>
													<td class="text-left">
														<input type="checkbox" switch="bool" name="week_days[friday]" id="friday" <?php echo (in_array('friday', $week_array)) ? ' checked' : '' ?> />
														<label for="friday" data-on-label="Yes" data-off-label="No"></label>
													</td>
												</tr>
												<tr>
													<td>Saturday</td>
													<td class="text-left">
														<input type="checkbox" switch="bool" name="week_days[saturday]" id="saturday" <?php echo (in_array('saturday', $week_array)) ? ' checked' : '' ?> />
														<label for="saturday" data-on-label="Yes" data-off-label="No"></label>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
									<div class="row size-inner-section px-2 py-4">
										<h4 class="header-title">Attendance Details</h4><hr>
										<div class="col-md-6 col-sm-12 mb-2 form-group">
											<label for="from_time">On Duty Time: <span class="required-field">*</span></label>
											<input type="time" class="form-control" id="from_time" name="from_time" value="<?php echo $shifts->from_time;?>" required />
										</div>
										<div class="col-md-6 col-sm-12 mb-2 form-group">
											<label for="to_time">Off Duty Time: <span class="required-field">*</span></label>
											<input type="time" class="form-control" id="to_time" name="to_time" value="<?php echo $shifts->to_time;?>" required />
										</div>
										<div class="col-md-6 col-sm-12 mb-2 form-group">
											<label for="beginning_in">Beginning In: <span class="required-field">*</span></label>
											<input type="time" class="form-control" id="beginning_in" name="beginning_in" value="<?php echo $shifts->beginning_in;?>" required />
										</div>
										<div class="col-md-6 col-sm-12 mb-2 form-group">
											<label for="ending_in">Ending In: <span class="required-field">*</span></label>
											<input type="time" class="form-control" id="ending_in" name="ending_in" value="<?php echo $shifts->ending_in;?>" required />
										</div>
										<div class="col-md-6 col-sm-12 mb-2 form-group">
											<label for="beginning_out">Beginning Out: <span class="required-field">*</span></label>
											<input type="time" class="form-control" id="beginning_out" name="beginning_out" value="<?php echo $shifts->beginning_out;?>" required />
										</div>
										<div class="col-md-6 col-sm-12 mb-2 form-group">
											<label for="ending_out">Ending Out: <span class="required-field">*</span></label>
											<input type="time" class="form-control" id="ending_out" name="ending_out" value="<?php echo $shifts->ending_out;?>" required />
										</div>
										<div class="col-md-6 col-sm-12 mb-2 form-group">
											<label for="late_time">Late Time:</label>
											<div class="input-group" id="datepicker1">
												<span class="input-group-text"><i class="mdi mdi-clock"></i></span>
												<input type="number" class="form-control" id="late_time" name="late_time" value="<?php echo $shifts->late_time;?>" />
												<span class="input-group-text">Minutes</span>
											</div>
										</div>
										<div class="col-md-6 col-sm-12 mb-2 form-group">
											<label for="start_late_time_from_on_duty" class="d-block">Start late time from on duty:</label>
											<input class="checkbox" type="checkbox" id="start_late_time_from_on_duty" name="start_late_time_from_on_duty" <?php echo ($shifts->start_late_time_from_on_duty == 'on') ? ' checked ' : '' ?> style="margin-right: 10px;height: 36px;width: 36px;">
											<small class="hint" style="vertical-align: super;"> (Check if you want to start late time from on duty.)</small>
										</div>
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

<script type="text/javascript">
	
	function submitButton() {
		window.onbeforeunload = null;
	}
	
	$(document).ready(function () {
		$('#shift_form').data('initial-state', $('#shift_form').serialize()); // On load save form current state

		// Prevent user from leaving page with inputs with new values
		window.onbeforeunload = function() {
			if ($('#shift_form').serialize() != $('#shift_form').data('initial-state')) {
				return 'You have unsaved changes! If you leave this page, your changes will be lost.';
			}
		};
	});

	function checkDuplicateName() {
		var name = $("#name").val();
		var id = $("#id").val();
		if (name !== "") {
			$.ajax({
				url: "<?php echo base_url();?>admin/attendance/shift/check-name",
				type: "GET",
				data: {
					name: name,
					id: id,
				},
				dataType: "json",
				success: function (data) {
					if(data.status == 'success'){
						$("#name").removeClass('parsley-error');
						$(".res-msg").html(data.msg);
					}else{
						$("#name").val('');
						$("#name").addClass('parsley-error');
						$(".res-msg").html(data.msg);
						return false;
					}
				},
				error: function () {
					$("#name").addClass('parsley-error');
					$("#name").val('');
					return false;
				},
			});
		} else {
			$("#name").addClass('parsley-error');
			$(".res-msg").html('<span style="color:red;">Name field required</span>');
		}
	}
	
</script>

