
<?php $this->load->view('admin/home/header');?>

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
						<li class="breadcrumb-item active">Add</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id');?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url('admin/dl-request/list'); ?>"><i class="fa fa-reply"></i> Back</a>
					&nbsp;
					<button onclick="submitButton()" form="dl_form" type="submit" class="btn btn-sm btn-custom-success pull-right" title="Save"><i class="fa fa-save"></i> Save</button>

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
						<?php echo form_open("admin/dl-request/submit", array("id" => "dl_form", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
							<input type="hidden" id="id" name="id" value="" />
							<div class="row">
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="emp_id">Select Employee <span class="text-danger">*</span></label>
									<select name="emp_id" id="emp_id" class="form-control select2" required data-placeholder="Choose Employee...">
										<option value="">Select Employee</option>
										<?php foreach(employeeListHelper() as $emp) { ?>
											<option value="<?php echo $emp->id; ?>"><?php echo $emp->emp_no; ?> - <?php echo $emp->full_name; ?> (<?php echo $emp->designation_name; ?>)</option>
										<?php } ?>
									</select>
									<small class="hint res-msg">Select Employee</small>
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="dl_type">DL Type <span class="text-danger">*</span></label>
									<select name="dl_type" id="dl_type" class="form-control select2" required data-placeholder="Choose DL Type...">
										<option value="bike">Bike</option>
										<option value="car">Car</option>
									</select>
									<small class="hint">Select DL Type</small>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="blood_group">Blood Group <span class="text-danger">*</span></label>
									<select name="blood_group" id="blood_group" class="form-control select2" required data-placeholder="Choose Blood group...">
										<option value="A positive">A positive</option>
										<option value="A negative">A negative</option>
										<option value="B positive">B positive</option>
										<option value="B negative">B negative</option>
										<option value="AB positive">AB positive</option>
										<option value="AB negative">AB negative</option>
										<option value="O positive">O positive</option>
										<option value="O negative">O negative</option>
									</select>
									<small class="hint">Select Blood Group</small>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="dl_status">Status <span class="text-danger">*</span></label>
									<select name="status" id="dl_status" class="form-control select2" required data-placeholder="Choose Status...">
										<option value="Pending">Pending</option>
										<option value="In Process">In Process</option>
										<option value="Completed">Completed</option>
									</select>
									<small class="hint">Select Status Type</small>
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
		$('#dl_form').data('initial-state', $('#dl_form').serialize()); // On load save form current state

		// Prevent user from leaving page with inputs with new values
		window.onbeforeunload = function() {
			if ($('#dl_form').serialize() != $('#dl_form').data('initial-state')) {
				return 'You have unsaved changes! If you leave this page, your changes will be lost.';
			}
		};
	});

	$('#emp_id').on('change', function(e){
		e.preventDefault();
		var emp_id = $('#emp_id option:selected').val();
		if (emp_id !== "") {
			$.ajax({
				url: "<?php echo base_url();?>admin/dl-request/check-empid",
				type: "GET",
				data: "emp_id=" + $("#emp_id").val(),
				dataType: "json",
				success: function (data) {
					if(data.status == 'success'){
						$(".res-msg").html(data.msg);
					}else{
						$("#emp_id").val('');
						$(".res-msg").html(data.msg);
						return false;
					}
				},
				error: function () {
					$("#emp_no").val('');
					return false;
				},
			});
		} else {
			checkField("emp_no");
		}
	});

	function checkField(u){
		var id = $("#"+u).val();
		if(id == ""){
			$("#"+u).addClass("alert_text");
		}
		else{
			$("#"+u).removeClass("alert_text");
		}
	}
	
	function Alpha(evt) {
		var keyCode = (evt.which) ? evt.which : evt.keyCode
		if ((keyCode < 65 || keyCode > 90) && (keyCode < 97 || keyCode > 123) && keyCode != 32)

			return false;
		return true;
	}

	function numerics(key) {
		//getting key code of pressed key
		// alert($(this).val());
		var keycode = (key.which) ? key.which : key.keyCode;
		//comparing pressed keycodes

		if (keycode > 31 && (keycode < 48 || keycode > 57)) {
			alert("You can enter only characters 0 to 9 ");
			return false;
		} else return true;
	}
</script>
