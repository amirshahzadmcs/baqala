<?php $this->load->view('admin/home/header'); ?>
<style>
	.size-inner-section {
		box-shadow: 0px 1px 4px #c5c5c5;
		border-radius: 5px;
		margin-bottom: 10px;
	}
</style>
<div id="wait"><img src="<?= base_url('images/sample-loader.gif'); ?>" /><br>Loading..</div>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Delivery Incentive Slab</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/incentives/list'); ?>">Delivery Incentive Slab</a></li>
						<li class="breadcrumb-item active">Edit</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url('admin/incentives/list'); ?>"><i class="fa fa-reply"></i> Back</a>
					<button form="incentiveForm" type="submit" id="submitBtn" class="btn btn-sm btn-custom-success pull-right ms-2" title="Save"><i class="fa fa-save"></i> Save</button>

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

					<?php } else { ?>
						<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong><?php echo $msg_data; ?></strong>
						</div>
				<?php }
				}
				$this->admin->removeInfo(); ?>
			</div>
		</div>
	</div>
</div>
<!-- end page title -->

<div class="container-fluid">
	<div class="page-content-wrapper">
		<?php echo form_open("admin/incentives/update", array("id" => "incentiveForm", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<input type="hidden" id="id" name="id" value="<?php echo $incentive_info->id; ?>" />
						<div class="row size-inner-section px-2 py-4">
							<h4 class="header-title">Incentive Rule Information </h4>
							<hr>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="incentive_name">Incentive Name  <span class="text-danger">*</span></label>
								<input type="text" class="form-control" id="incentive_name" name="incentive_name" maxlength="150" value="<?php echo $incentive_info->incentive_name;?>" required />
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="incentive_period">Incentive Period <span class="text-danger">*</span></label>
								<select name="incentive_period" id="incentive_period" class="form-select select2" required>
									<option value="">Select Period</option>
									<option value="Monthly" <?php echo ($incentive_info->incentive_period == 'Monthly') ? ' selected' : '' ?>>Monthly</option>
									<option value="Quarterly" <?php echo ($incentive_info->incentive_period == 'Quarterly') ? ' selected' : '' ?>>Quarterly</option>
									<option value="Annual" <?php echo ($incentive_info->incentive_period == 'Annual') ? ' selected' : '' ?>>Annual</option>
								</select>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="target">Monthly Target  <span class="text-danger">*</span></label>
								<input type="text" class="form-control" id="target" name="target" onKeyPress="return numerics(event);" maxlength="10" value="<?php echo $incentive_info->target;?>" required />
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="deduction">Deduction (If delivery is less than target) <span class="text-danger">*</span></label>
								<div class="input-group">
									<input type="text" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" aria-label="Deduction" name="deduction" id="deduction" value="<?php echo $incentive_info->deduction;?>" aria-describedby="basic-addon2" required>
									<!-- <div class="input-group-append">
										<span class="input-group-text" id="basic-addon2" style="border-radius: 0rem 0.25rem 0.25rem 0rem">* No of less delivery</span>
									</div> -->
								</div>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="daily_bonus">Daily Bonus (If delivery is 30+) <span class="text-danger">*</span></label>
								<input type="text" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" id="daily_bonus" name="daily_bonus" value="<?php echo $incentive_info->daily_bonus;?>" required />
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="monthly_bonus">Monthly Bonus (If delivery is 700+) <span class="text-danger">*</span></label>
								<input type="text" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" id="monthly_bonus" name="monthly_bonus" value="<?php echo $incentive_info->monthly_bonus;?>" required />
							</div>

							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="acceptance_penalty_450">Acceptance Rate Penalty (If Achievement <span class="text-success">450</span>) <span class="text-danger">*</span></label>
								<select class="form-select" name="acceptance_penalty_450" id="acceptance_penalty_450" required>
									<option value="">Select Penalty</option>
									<option value="excluded" <?php echo ($incentive_info->acceptance_penalty_450 == 'excluded') ? ' selected' : '' ?>>Excluded</option>
									<option value="deductible" <?php echo ($incentive_info->acceptance_penalty_450 == 'deductible') ? ' selected' : '' ?>>Deductible</option>
								</select>
							</div>

							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="acceptance_penalty_less_450">Acceptance Rate Penalty (If Achievement <span class="text-danger">-450</span>) <span class="text-danger">*</span></label>
								<select class="form-select" name="acceptance_penalty_less_450" id="acceptance_penalty_less_450" required>
									<option value="">Select Penalty</option>
									<option value="excluded" <?php echo ($incentive_info->acceptance_penalty_less_450 == 'excluded') ? ' selected' : '' ?>>Excluded</option>
									<option value="deductible" <?php echo ($incentive_info->acceptance_penalty_less_450 == 'deductible') ? ' selected' : '' ?>>Deductible</option>
								</select>
							</div>

							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="contact_penalty_450">Contact Rate Penalty (If Achievement <span class="text-success">450</span>) <span class="text-danger">*</span></label>
								<select class="form-select" name="contact_penalty_450" id="contact_penalty_450" required>
									<option value="">Select Penalty</option>
									<option value="excluded" <?php echo ($incentive_info->contact_penalty_450 == 'excluded') ? ' selected' : '' ?>>Excluded</option>
									<option value="deductible" <?php echo ($incentive_info->contact_penalty_450 == 'deductible') ? ' selected' : '' ?>>Deductible</option>
								</select>
							</div>

							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="contact_penalty_less_450">Acceptance Rate Penalty (If Achievement <span class="text-danger">-450</span>) <span class="text-danger">*</span></label>
								<select class="form-select" name="contact_penalty_less_450" id="contact_penalty_less_450" required>
									<option value="">Select Penalty</option>
									<option value="excluded" <?php echo ($incentive_info->contact_penalty_less_450 == 'excluded') ? ' selected' : '' ?>>Excluded</option>
									<option value="deductible" <?php echo ($incentive_info->contact_penalty_less_450 == 'deductible') ? ' selected' : '' ?>>Deductible</option>
								</select>
							</div>

							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="decline_penalty">Decline Penalty<span class="text-danger">*</span></label>
								<select class="form-select" name="decline_penalty" id="decline_penalty" required>
									<option value="">Select Penalty</option>
									<option value="excluded" <?php echo ($incentive_info->decline_penalty == 'excluded') ? ' selected' : '' ?>>Excluded</option>
									<option value="deductible" <?php echo ($incentive_info->decline_penalty == 'deductible') ? ' selected' : '' ?>>Deductible</option>
								</select>
							</div>
							
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="incentive_status">Status <span class="text-danger">*</span></label>
								<select class="form-select" name="status" id="incentive_status" required readonly>
									<option value="">Select Status</option>
									<option value="active" <?php echo ($incentive_info->status == 'active') ? ' selected' : '' ?>>Active</option>
									<option value="inactive" <?php echo ($incentive_info->status == 'inactive') ? ' selected' : '' ?>>Inactive</option>
								</select>
							</div>
						</div>
						
						<div class="row size-inner-section px-2 py-4">
							<h4 class="header-title">Incentive Slabs</h4>
							<hr>
							<table id="incentive_sections" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<td class="text-left">Slab <span class="text-danger">*</span></td>
										<td class="text-left">Commission <span class="text-danger">*</span></td>
										<td style="width: 5%;"></td>
									</tr>
								</thead>
								<tbody>
									<?php if(count($incentive_slabs) > 0){ ?>
									<?php foreach($incentive_slabs as $slab){ ?>
									<tr class="incentive-inner-section">
										<td class="text-left" style="width: 50%;">
											<div class="input-group">
												<input type="number" name="slab_start[]" class="form-control" placeholder="Min Value" onKeyPress="return numerics(event);" maxlength="100" value="<?php echo $slab['slab_start']; ?>" required>
												<input type="number" name="slab_end[]" class="form-control" placeholder="Max Value" onKeyPress="return numerics(event);" maxlength="100" value="<?php echo $slab['slab_end']; ?>" required>
											</div>
										</td>
										
										<td class="text-left">
											<div class="form-group">
												<input type="text" name="commission[]" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" maxlength="10" value="<?php echo $slab['commission']; ?>" required>
											</div>
										</td>
										<td class="text-right">
											<a href="javascript:;" class="btn btn-danger btn-sm float-end remove"><i class="fa fa-minus-circle"></i></a>
										</td>
									</tr>
									<?php }}else{ ?>
									<tr class="incentive-inner-section">
										<td class="text-left" style="width: 50%;">
											<div class="input-group">
												<input type="number" name="slab_start[]" class="form-control" placeholder="Min Value" onKeyPress="return numerics(event);" maxlength="100" required>
												<input type="number" name="slab_end[]" class="form-control" placeholder="Max Value" onKeyPress="return numerics(event);" maxlength="100" required>
											</div>
										</td>
										<td class="text-left">
											<div class="form-group">
												<input type="text" name="commission[]" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" maxlength="10" required>
											</div>
										</td>
										<td class="text-right">
											<a href="javascript:;" class="btn btn-danger btn-sm float-end remove"><i class="fa fa-minus-circle"></i></a>
										</td>
									</tr>
									<?php } ?>
								</tbody>

								<tfoot>
									<tr>
										<td colspan="6" class="text-right">
											<a href="javascript:;" class='btn btn-success btn-sm addsection'><i class="fa fa-plus-circle"></i> Add More</a>
										</td>
									</tr>
								</tfoot>
							</table>
						</div>


					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
		<?php echo form_close(); ?>
	</div>
</div>
<!-- container-fluid -->

<?php $this->load->view('admin/home/footer'); ?>

<script type="text/javascript">
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

	//Add Incentive
	var template = $("#incentive_sections .incentive-inner-section:first").clone();
	//define counter
	var sectionsCount = 1;
	//add new section
	$("body").on("click", ".addsection", function() {
		//increment
		sectionsCount++;

		//loop through each input
		var section = template
			.clone()
			.find(":input").val("")
			.each(function() {
				//set id to store the updated section number
				var newId = this.id + sectionsCount;
				//alert(newId);
				$(this).prev().attr("for", newId);
				this.id = newId;
			})
			.end()
			//inject new section
			.appendTo("#incentive_sections");
			section.find(".input-mask").inputmask();
		return false;
	});

	//remove section
	$("#incentive_sections").on("click", ".remove", function() {
		//fade out section
		$(this)
			.parent()
			.fadeOut(300, function() {
				//remove parent element (main section)
				$(this).parent().empty();
				return false;
			});
		return false;
	});
	
	$(document).ready(function() {
		$('form').parsley({
			errorsWrapper: '<div class="invalid-feedback"></div>',
			errorTemplate: '<span></span>',
			classHandler: function(ParsleyField) {
				return ParsleyField.$element.closest('.input-group');
			},
			errorsContainer: function(ParsleyField) {
				return ParsleyField.$element.closest('.input-group');
			}
		});
	});

	$(document).ready(function() {
        $("#incentiveForm").submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: "<?= base_url('admin/incentives/update') ?>",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                beforeSend: function() {
                    $("#submitBtn").prop("disabled", true).text("Saving...");
                },
                success: function(response) {
                    $("#submitBtn").prop("disabled", false).html("<i class='fa fa-save'></i> Save");
                    if (response.status) {
						toastr.success(response.message);
						window.location.href = "<?php echo base_url('admin/incentives/list');?>";
                        //location.reload();
                    } else {
						toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    $("#submitBtn").prop("disabled", false).html("<i class='fa fa-save'></i> Save");
                    console.error(xhr.responseText);
					toastr.error("An error occurred while saving the incentive.");
                }
            });
        });
    });
</script>
