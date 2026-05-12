
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
					<h4>Add Holiday</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/attendance/holidays-list'); ?>">Holiday List</a></li>
						<li class="breadcrumb-item active">Create / Edit</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id');?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-2" title="Back" href="<?php echo base_url('admin/attendance/holidays-list'); ?>"><i class="fa fa-reply"></i> Back</a>
					<button onclick="submitButton()" form="holiday_form" type="submit" class="btn btn-sm btn-custom-success pull-right" title="Save"><i class="fa fa-save"></i> Save</button>

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
						<?php echo form_open("admin/attendance/holidays/submit", array("id" => "holiday_form", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
							<input type="hidden" id="id" name="id" value="" />
							
							<!-- Tab panes -->
							<div class="tab-content p-3 text-muted">
								<div class="tab-pane active" id="home1" role="tabpanel">
									<div class="row size-inner-section px-2 py-4">
										<h4 class="header-title">Holiday List Information</h4><hr>
										<div class="col-md-6 col-sm-12 mb-2 form-group">
											<label for="group_title">Name <span class="required-field">*</span></label>
											<input type="text" class="form-control" id="group_title" name="group_title" maxlength="125" onBlur="checkDuplicateName()" required />
											<small class="hint res-msg">Enter Unique Holiday Name</small>
										</div>
										<div class="col-md-6 col-sm-12 mb-2 form-group">
											<label for="group_title_ar">Arabic Name</label>
											<input type="text" class="form-control rtl-input" id="group_title_ar" name="group_title_ar" maxlength="120" />
											<small class="hint">Enter Arabic Holiday Name</small>
										</div>
									</div>

									<div class="row size-inner-section px-2 py-4 family-container">
										<h4 class="header-title">Select Holidays (Days Off):</h4><hr>
										<table id="family_sections" class="table table-striped table-bordered table-hover">
											<thead>
												<tr>
													<td class="text-left" style="width: 10%;">Serial<span class="required-field">*</span></td>
													<td class="text-left" style="width: 25%;">Date <span class="required-field">*</span></td>
													<td class="text-left">English Title<span class="required-field">*</span></td>
													<td class="text-left">Arabic Title</td>
													<td style="width: 5%;"></td>
												</tr>
											</thead>
											<tbody>
												<tr class="family-inner-section">
													<td>1</td>
													<td class="text-left">
														<input type="date" class="form-control" name="date_off[]" required>
													</td>
													<td class="text-left">
														<div class="input-group">
															<input type="text" name="title[]" class="form-control" maxlength="120" required>
														</div>
													</td>
													<td class="text-left">
														<div class="input-group">
															<input type="text" name="title_ar[]" class="form-control rtl-input" maxlength="120">
														</div>
													</td>
													<td class="text-right">
														<a href="javascript:;" class="btn btn-danger btn-sm float-end remove"><i class="fa fa-minus-circle"></i></a>
													</td>
												</tr>
											</tbody>

											<tfoot>
												<tr>
													<td colspan="4" class="text-right">
														<a href="javascript:;" class='btn btn-success btn-sm addsection'><i class="fa fa-plus-circle"></i> Add</a>
													</td>
												</tr>
											</tfoot>
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

<script type="text/javascript">
	
	function submitButton() {
		window.onbeforeunload = null;
	}
	
	$(document).ready(function () {
		$('#holiday_form').data('initial-state', $('#holiday_form').serialize()); // On load save form current state

		// Prevent user from leaving page with inputs with new values
		window.onbeforeunload = function() {
			if ($('#holiday_form').serialize() != $('#holiday_form').data('initial-state')) {
				return 'You have unsaved changes! If you leave this page, your changes will be lost.';
			}
		};
	});

	function checkDuplicateName() {
		var title = $("#group_title").val();
		var id = $("#id").val();
		if (title !== "") {
			$.ajax({
				url: "<?php echo base_url();?>admin/attendance/holidays/check-name",
				type: "GET",
				data: {
					group_title: title,
					id: id,
				},
				dataType: "json",
				success: function (data) {
					if(data.status == 'success'){
						$("#group_title").removeClass('parsley-error');
						$(".res-msg").html(data.msg);
					}else{
						$("#group_title").val('');
						$("#group_title").addClass('parsley-error');
						$(".res-msg").html(data.msg);
						return false;
					}
				},
				error: function () {
					$("#group_title").addClass('parsley-error');
					$("#group_title").val('');
					return false;
				},
			});
		} else {
			$("#group_title").addClass('parsley-error');
			$(".res-msg").html('<span style="color:red;">Name field required</span>');
		}
	}
	
</script>
<script>
    //Add Family
	var template = $("#family_sections .family-inner-section:first").clone();
	//define counter
	var sectionsCount = 1;
	//add new section
	$("body").on("click", ".addsection", function () {
		//increment
		sectionsCount++;

		//loop through each input
		var section = template
			.clone()
			.find(":input").val("")
			.each(function (index) {
				//set id to store the updated section number
				var newId = this.id + sectionsCount;
				//alert(newId);
				$(this).prev().attr("for", newId);
				this.id = newId;
			})
			.end()
			//inject new section
			.appendTo("#family_sections");
			reorder();
			// var siblings = $('#family_sections tbody tr').siblings();
			// siblings.each(function(index) {
			// 	$(this).children('td').first().text(index + 1);
			// });
		return false;
	});

	//remove section
	$("#family_sections").on("click", ".remove", function () {
		//fade out section
		$(this).parent().parent().remove();
		reorder();
		return false;
	});

	function reorder(){
		var i = 1;
		$('#family_sections tbody tr').each(function() {
			$(this).find("td:first").text(i);
			i++;
		});
	}
</script>
