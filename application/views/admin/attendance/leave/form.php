
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
					<h4>Add Leave Type</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/attendance/leave-list'); ?>">Leave Types</a></li>
						<li class="breadcrumb-item active">Add</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id');?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-2" title="Back" href="<?php echo base_url('admin/attendance/leave-list'); ?>"><i class="fa fa-reply"></i> Back</a>
					<button onclick="submitButton()" form="leave_form" type="submit" class="btn btn-sm btn-custom-success pull-right" title="Save"><i class="fa fa-save"></i> Save</button>

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
						<?php echo form_open("admin/attendance/leave/submit", array("id" => "leave_form", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
							<input type="hidden" id="id" name="id" value="" />
							
							<!-- Tab panes -->
							<div class="tab-content p-3 text-muted">
								<div class="tab-pane active" id="home1" role="tabpanel">
									<div class="row size-inner-section px-2 py-4">
										<h4 class="header-title">Leave Type Information</h4><hr>
										<div class="col-md-4 col-sm-12 mb-2 form-group">
											<label for="name">Name <span class="required-field">*</span></label>
											<input type="text" class="form-control" id="name" name="name" maxlength="125" onBlur="checkDuplicateName()" required />
											<small class="hint res-msg">Enter Unique Leave Type Name</small>
										</div>
										<div class="col-md-4 col-sm-12 mb-2 form-group">
											<label for="name_ar">Arabic Name</label>
											<input type="text" class="form-control rtl-input" id="name_ar" name="name_ar" maxlength="120" />
											<small class="hint">Enter Arabic Name</small>
										</div>
										<div class="col-md-4 col-sm-12 mb-2 form-group">
											<label for="colorpicker-showpaletteonly">Color <span class="required-field">*</span></label>
											<input type="text" class="form-control" id="colorpicker-showpaletteonly" name="color_code" readonly value="#34c38f">
											<small class="hint">Select color to indicate leave type</small>
										</div>
										<div class="col-md-6 col-sm-12 mb-2 form-group">
											<label for="description">Description English</label>
											<textarea id="description" class="form-control" rows="2" autoresize="" name="description" cols="50" style="height: 68px;"></textarea>
										</div>
										<div class="col-md-6 col-sm-12 mb-2 form-group">
											<label for="description_ar">Description Arabic</label>
											<textarea id="description_ar" class="form-control rtl-input" rows="2" autoresize="" name="description_ar" cols="50" style="height: 68px;"></textarea>
										</div>
										<div class="col-md-6 col-sm-12 mb-2 form-group">
											<label for="days_allowed_per_year">Max Days Allowed Per Year <span class="required-field">*</span></label>
											<input type="number" class="form-control" id="days_allowed_per_year" name="days_allowed_per_year" min="0" max="355" required />
										</div>
										<div class="col-md-6 col-sm-12 mb-2 form-group">
											<label for="continuous_days_applicable">Maximum Continuous Days Applicable</label>
											<input type="number" class="form-control" id="continuous_days_applicable" name="continuous_days_applicable" min="0" max="355" />
										</div>
										<div class="col-md-6 col-sm-12 mb-2 form-group">
											<label for="applicable_after">Applicable After</label>
											<input type="number" class="form-control" id="applicable_after" name="applicable_after" min="0" max="365" />
											<small class="hint">The number of days that the leave type will be applicable for the employee to take it and it will be calculated from the joining date of the employee</small>
										</div>
										<div class="col-md-6 col-sm-12 mb-2 form-group">
											<label for="need_permission" class="d-block">Need Permission</label>
											<input class="checkbox" type="checkbox" id="need_permission" name="need_permission" style="margin-right: 10px;height: 36px;width: 36px;">
											<small class="hint" style="vertical-align: super;"> (Check if Need Permission for leave.)</small>
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
		$('#leave_form').data('initial-state', $('#leave_form').serialize()); // On load save form current state

		// Prevent user from leaving page with inputs with new values
		window.onbeforeunload = function() {
			if ($('#leave_form').serialize() != $('#leave_form').data('initial-state')) {
				return 'You have unsaved changes! If you leave this page, your changes will be lost.';
			}
		};
	});

	function checkDuplicateName() {
		var name = $("#name").val();
		var id = $("#id").val();
		if (name !== "") {
			$.ajax({
				url: "<?php echo base_url();?>admin/attendance/leave/check-name",
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
