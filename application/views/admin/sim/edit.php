<?php $this->load->view('admin/home/header'); ?>
<style>
	.size-inner-section {
		box-shadow: 0px 1px 4px #c5c5c5;
		border-radius: 5px;
		margin-bottom: 10px;
	}

	.modal-dialog-aside {
		width: 30%;
		max-width: 80%;
		height: 100%;
		margin: 0;
		transform: translate(0);
		transition: transform .2s;
	}

	.modal-dialog-aside .modal-content {
		height: inherit;
		border: 0;
		border-radius: 0;
	}

	.modal-dialog-aside .modal-content .modal-body {
		overflow-y: auto
	}

	.modal.fixed-left .modal-dialog-aside {
		margin-left: auto;
		transform: translateX(100%);
	}

	.modal.fixed-right .modal-dialog-aside {
		margin-right: auto;
		transform: translateX(-100%);
	}

	.modal.show .modal-dialog-aside {
		transform: translateX(0);
	}
</style>
<div id="wait"><i class="fa fa-spinner fa-spin"></i><br>Loading..</div>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Sim Card management</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/sim/list">Sim Cards</a></li>
						<li class="breadcrumb-item active">Edit</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right ms-2" title="Back" href="<?php echo base_url(); ?>admin/sim/list"><i class="fa fa-reply"></i> Back</a>
					<?php if (check_action_permission(get_user_role(), 'sim_card', 'print_handover_form')): ?>
						<?php if ($allotment !== '' && $allotment > 0) { ?>
							<a href="<?php echo base_url('admin/sim/print-handover-form?id=' . $id); ?>" class="btn btn-sm btn-custom-danger pull-right ms-2" title="Print Handover Form" target="_blank"><i class="ti-printer"></i> Hanover Form</a>
						<?php }
					endif;
					if (check_action_permission(get_user_role(), 'sim_card', 'update_status')): ?>
						<button type="button" class="btn btn-sm btn-custom-danger pull-right ms-2" title="Update Status" data-bs-toggle="modal" data-bs-target=".set-status-modal"><i class="mdi mdi-account-reactivate"></i> Change Status</button>
					<?php endif; ?>
					<button form="demo-form2" type="submit" class="btn btn-sm btn-custom-success pull-right ms-2" title="Save"><i class="fa fa-save"></i> Save</button>

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
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<?php echo form_open("admin/sim/update", array("id" => "demo-form2", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
						<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />

						<!-- Nav tabs -->
						<ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab">
									<span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
									<span class="d-none d-sm-block">Sim Card Details</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-bs-toggle="tab" href="#profile2" role="tab">
									<span class="d-block d-sm-none"><i class="fas fa-history"></i></span>
									<span class="d-none d-sm-block">History</span>
								</a>
							</li>
						</ul>

						<!-- Tab panes -->
						<div class="tab-content p-3 text-muted">
							<div class="tab-pane active" id="home1" role="tabpanel">
								<div class="row size-inner-section px-2 py-4">
									<h4 class="header-title">SIM Ownership</h4>
									<hr>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="ownership_type">Ownership Type<span class="text-danger">*</span></label>
										<select name="ownership_type" id="ownership_type" class="form-select" required>
											<option value="">Select Ownership</option>
											<option value="corporate" <?php echo ($ownership_type == 'corporate') ? "selected" : "" ?>>Corporate</option>
											<option value="individual" <?php echo ($ownership_type == 'individual') ? "selected" : "" ?>>Individual</option>
										</select>
										<p class="hint">Select sim ownership type</p>
									</div>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="owner_name">Owner Name <span class="text-danger">*</span></label>
										<!-- Text Input for Individual -->
										<input type="text" class="form-control" id="owner_name_input" name="owner_name_text" maxlength="150"
											value="<?php echo ($ownership_type == 'individual') ? $owner_name : ''; ?>" 
											style="<?php echo ($ownership_type == 'corporate') ? 'display:none;' : ''; ?>" <?php echo ($ownership_type == 'individual') ? ' required ' : ''; ?> />

										<!-- Dropdown for Corporate -->
										<select class="form-select" id="owner_name_select" name="owner_name_dropdown"
											style="<?php echo ($ownership_type == 'corporate') ? '' : 'display:none;'; ?>" <?php echo ($ownership_type == 'corporate') ? ' required ' : ''; ?> >
											<option value="">Select Sponsor</option>
											<?php foreach ($sponsors as $sponsor) : ?>
												<option value="<?= $sponsor->employer_name ?>" data-cr_no="<?= $sponsor->employer_cr_no; ?>"  <?= ($ownership_type == 'corporate' && $owner_name == $sponsor->employer_name) ? 'selected' : '' ?>>
													<?= $sponsor->employer_name ?>
												</option>
											<?php endforeach; ?>
										</select>

										<p class="hint">Enter or select owner name of SIM card</p>
									</div>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="owner_id">Owner I'd <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="owner_id" name="owner_id" maxlength="10" value="<?php echo $owner_id; ?>" required />
										<p class="hint">Enter owner i'd for sim card</p>
									</div>
									
								</div>
								<div class="row size-inner-section px-2 py-4">
									<h4 class="header-title">Sim Information</h4>
									<hr>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="date_of_purchase">Date Of Purchase <span class="text-danger">*</span></label>
										<input type="date" class="form-control" id="date_of_purchase" name="date_of_purchase" maxlength="150" value="<?php echo $date_of_purchase; ?>" required />
										<p class="hint">Enter date of purchase of sim</p>
									</div>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="network">Service Provider <span class="text-danger">*</span></label>
										<select name="network" class="form-control select2" id="network" data-placeholder="Choose Network..." required>
											<option value="">-- select --</option>
											<?php if (!empty($networks)) {
												foreach ($networks as $key => $item) { ?>
													<option value="<?php echo $networks[$key]->id; ?>" <?php echo ($networks[$key]->id == $network) ? 'selected' : ''; ?>><?php echo $networks[$key]->network_name; ?></option>
												<?php }
											} else { ?>
												<option value="" disabled>Add Service Provider</option>
											<?php } ?>
										</select>
										<p class="hint">Select Service Provider</p>
									</div>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="sim_type">Service Type<span class="text-danger">*</span></label>
										<select name="sim_type" id="sim_type" class="form-select" required>
											<option value="prepaid" <?php echo ($sim_type == 'prepaid') ? "selected" : "" ?>>Prepaid</option>
											<option value="postpaid" <?php echo ($sim_type == 'postpaid') ? "selected" : "" ?>>Postpaid</option>
											<option value="Postpaid - Data SIM" <?php echo ($sim_type == 'Postpaid - Data SIM') ? "selected" : "" ?>>Postpaid - Data SIM</option>
										</select>
										<p class="hint">Select Service Type</p>
									</div>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="plan">Plan <span class="text-danger">*</span></label>
										<input type="hidden" name="plan_id" id="plan_id" value="<?php echo $plan_id; ?>">
										<select name="plan" class="form-control select2" id="plan" data-placeholder="Choose Plan...">
											<option value="">-- select --</option>

										</select>
										<p class="hint">Select plan for sim card</p>
									</div>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="internet_data">Internet Data</label>
										<select name="internet_data" id="internet_data" class="form-select">
											<option value="">-- Select Internet Data --</option>
											<option value="15 GB" <?php echo ($internet_data == '15 GB') ? "selected" : "" ?>>15 GB</option>
											<option value="25 GB" <?php echo ($internet_data == '25 GB') ? "selected" : "" ?>>25 GB</option>
										</select>
										<p class="hint">Select Service Type</p>
									</div>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label class="d-block">Is GPS Sim (for Postpaid Sim)</label>
										<input type="checkbox" id="switch3" switch="bool" name="is_gps_sim" <?php echo ($is_gps_sim == 'on') ? "checked" : "" ?> />
										<label for="switch3" data-on-label="Yes" data-off-label="No"></label>
										<p class="hint">Switch Yes, If sim is GPS sim</p>
									</div>
									<div class="col-md-4 col-sm-12 mb-3 form-group d-none" id="gps_vehicle">
										<label for="gps_installed_vehicle">Select Vehicle</label>
										<select name="gps_installed_vehicle" class="form-control select2" id="gps_installed_vehicle">
											<option value="">-- Select Vehicle --</option>
											<?php if (!empty($unalloted_vehicle)) {
												foreach ($unalloted_vehicle as $key => $item) { ?>
													<option value="<?php echo $item['id']; ?>" <?php echo ($item['id'] == $gps_installed_vehicle) ? 'selected' : ''; ?>><?php echo $item['vehicle_no'] . ' - ' . ucfirst($item['vehicle_type']); ?></option>
												<?php }
											} else { ?>
												<option value="" disabled>No Unalloted Vehicle Found</option>
											<?php } ?>
										</select>
										<p class="hint">Select vehicle in which GPS installed</p>
									</div>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="mobile">Mobile No <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="mobile" name="mobile" onKeyPress="return numerics(event);" onBlur="checkDuplicateMob()" minlength="<?php echo ($sim_type == 'Postpaid - Data SIM') ? "12" : MOB_LENGTH ?>" maxlength="<?php echo ($sim_type == 'Postpaid - Data SIM') ? "12" : MOB_LENGTH ?>" value="<?php echo $mobile; ?>" required />
										<p class="hint res-msg">Enter mobile number</p>
									</div>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="sim_no">Sim Card No <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="sim_no" name="sim_no" onKeyPress="return numerics(event);" onBlur="checkDuplicateSim()" minlength="<?php echo ($sim_type == 'Postpaid - Data SIM' || $network == '5') ? "19" : SIM_LENGTH ?>" maxlength="<?php echo ($sim_type == 'Postpaid - Data SIM' || $network == '5') ? "19" : SIM_LENGTH ?>" value="<?php echo $sim_no; ?>" required />
										<p class="hint res-msg-sim">Enter sim card number</p>
									</div>

									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label>Sim Status</label>
										<select class="form-select" disabled readonly>
											<option value="">-- Select Sim Status --</option>
											<?php if ($status == '' || $status == '0') { ?>
												<option value="0" <?php echo ($status == '0') ? " selected" : "" ?>>New</option>
											<?php } ?>
											<option value="1" <?php echo ($status == '1') ? " selected " : "" ?>>Active</option>
											<option value="2" <?php echo ($status == '2') ? " selected " : "" ?>>Discontinued</option>
										</select>
									</div>

								</div>
							</div>

							<div class="tab-pane" id="profile2" role="tabpanel">
								<div class="row">
									<div class="col-md-12 col-sm-12 mb-3">
										<table id="regionTable" class="table table-bordered jambo_table bulk_action" style="width:100%">
											<thead>
												<tr>
													<th>#</th>
													<th>Mobile Number</th>
													<th>Allotment Date</th>
													<th>User Name</th>
													<th>Status</th>
													<th>Last Updated</th>
												</tr>
											</thead>
											<tbody>
												<?php if (isset($logs) && !empty($logs)) {
													$i = 1;
													foreach ($logs as $key => $item) { ?>
														<tr>
															<td><?php echo $i; ?></td>
															<td><?php echo $item->mobile; ?></td>
															<td><?php echo date('d M, Y', strtotime($item->status_date)); ?></td>
															<td><?php echo $item->full_name; ?></td>
															<td>
																<?php
																echo ($item->status == 1 ? '<span class="badge bg-soft-success text-dark p-2">Alloted</span>' : ($item->status == 2 ? '<span class="badge bg-soft-danger text-dark p-2">Unalloted</span>' : ($item->status == 3 ? '<span class="badge bg-soft-warning text-dark p-2">Port</span>' : ($item->status == 4 ? '<span class="badge bg-soft-primary text-dark p-2">Active</span>' : ($item->status == 5 ? '<span class="badge bg-soft-secondary text-dark p-2">Discontinue</span>' :
																					'<span class="badge bg-soft-default text-dark p-2">Unknown</span>')))));
																?>
															</td>
															<td><?php echo date('d M, Y h:i A', strtotime($item->updated_at)); ?></td>
														</tr>
												<?php $i++;
													}
												} ?>

											</tbody>
										</table>
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

<?php $this->load->view('admin/home/footer'); ?>

<script type="text/javascript">
	$(document).ready(function() {
		$('#sim_type').change(function() {
			var mobileNumberInput = $('#mobile');
			var simNumberInput = $('#sim_no');
			var simNetwork = $('#network option:selected').val();
			mobileNumberInput.val('');
			if ($(this).val() === 'Postpaid - Data SIM') {
				mobileNumberInput.attr('minlength', '12');
				mobileNumberInput.attr('maxlength', '12');
				simNumberInput.attr('minlength', '19');
				simNumberInput.attr('maxlength', '19');
			} else {
				mobileNumberInput.attr('minlength', '10');
				mobileNumberInput.attr('maxlength', '10');
				if (simNetwork == '5') {
					simNumberInput.attr('minlength', '19');
					simNumberInput.attr('maxlength', '19');
				} else {
					simNumberInput.attr('minlength', '18');
					simNumberInput.attr('maxlength', '18');
				}
			}
		});
	});

	function checkDuplicateMob() {
		var mobile = $("#mobile").val();
		var id = $("#id").val();
		if (mobile !== "") {
			$.ajax({
				url: "<?php echo base_url(); ?>admin/sim/check-duplicate-mob",
				type: "GET",
				data: {
					mobile: mobile,
					id: id,
				},
				dataType: "json",
				success: function(data) {
					if (data.status == 'success') {
						$("#mobile").removeClass('parsley-error');
						$(".res-msg").html(data.msg);
					} else {
						$("#mobile").val('');
						$("#mobile").addClass('parsley-error');
						$(".res-msg").html(data.msg);
						return false;
					}
				},
				error: function() {
					$("#mobile").val('');
					$("#mobile").addClass('parsley-error');
					$(".res-msg").html('<span class="text-danger">Some error occured, refresh page.</span>');
					return false;
				},
			});
		} else {
			$("#mobile").addClass('parsley-error');
			$(".res-msg").html('<span class="text-danger">Enter mobile number.</span>');
		}
	}

	function checkDuplicateSim() {
		var sim_no = $("#sim_no").val();
		var id = $("#id").val();
		if (sim_no !== "") {
			$.ajax({
				url: "<?php echo base_url(); ?>admin/sim/check-duplicate-sim",
				type: "GET",
				data: {
					sim_no: sim_no,
					id: id,
				},
				dataType: "json",
				success: function(data) {
					if (data.status == 'success') {
						$("#sim_no").removeClass('parsley-error');
						$(".res-msg-sim").html(data.msg);
					} else {
						$("#sim_no").val('');
						$("#sim_no").addClass('parsley-error');
						$(".res-msg-sim").html(data.msg);
						return false;
					}
				},
				error: function() {
					$("#sim_no").val('');
					$("#sim_no").addClass('parsley-error');
					$(".res-msg-sim").html('<span class="text-danger">Some error occured, refresh page.</span>');
					return false;
				},
			});
		} else {
			$("#sim_no").addClass('parsley-error');
			$(".res-msg-sim").html('<span class="text-danger">Enter sim number.</span>');
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

	$(function() {

		$('#network').on('change', function() {
			$('#sim_type').val('');
			$('#plan').val(null).trigger('change');
			$('#plan').html('<option value="">-- Select Plan --</option>');
		});

		$('#sim_type').on('change', function() {
			var network = $('#network option:selected').val();
			var sim_type = $('#sim_type option:selected').val();
			//alert(network);
			$.ajax({
				url: "<?php echo base_url() ?>admin/Sim_card/getPlans",
				data: {
					"id": network,
					"sim_type": sim_type
				},
				//dataType:"html",
				type: "get",
				success: function(data) {
					$('#plan').html(data);
				},
				error: function(data) {
					console.log(data);
				}
			});
		});

		$('input[type=checkbox][name=is_gps_sim]').change(function() {
			if ($(this).prop("checked") == true) {
				$('#gps_vehicle').removeClass('d-none');
			} else {
				$('#gps_vehicle').addClass('d-none');
			}
		});

		function toggleOwnerField() {
			var selectedType = $('#ownership_type').val();

			if (selectedType === 'corporate') {
				$('#owner_name_input').hide().prop('required', false);
				$('#owner_name_select').show().prop('required', true);
			} else {
				$('#owner_name_select').hide().prop('required', false);
				$('#owner_name_input').show().prop('required', true);
			}
		}

		// Run on page load (to set correct field)
		toggleOwnerField();

		// Run when ownership type changes
		$('#ownership_type').change(function() {
			$("#owner_id").val('');
			toggleOwnerField();
		});
		
		$('#owner_name_select').change(function() {
			var ownership_type = $('#ownership_type option:selected').val();
			var cr_no = $('#owner_name_select option:selected').data('cr_no');
			if (ownership_type === 'corporate') {
				$("#owner_id").val(cr_no);
			}else{
				$("#owner_id").val('');
			}
		});

	});

	function showVehicleSelect() {
		if ($('input[type=checkbox][name=is_gps_sim]').prop("checked") == true) {
			$('#gps_vehicle').removeClass('d-none');
		} else {
			$('#gps_vehicle').addClass('d-none');
		}
	}

	$(document).ready(function() {
		selectedPlan();
		showVehicleSelect();
	});

	function selectedPlan() {
		var id = $('#id').val();
		if (id != '') {
			var network = $('#network option:selected').val();
			var sim_type = $('#sim_type option:selected').val();
			var plan_id = $('#plan_id').val();
			// alert(plan_id);
			$.ajax({
				url: "<?php echo base_url() ?>admin/Sim_card/getPlans",
				data: {
					"id": network,
					"plan_id": plan_id,
					"sim_type": sim_type
				},
				//dataType:"html",
				type: "get",
				success: function(data) {
					$('#plan').html(data);
				},
				error: function(data) {
					console.log(data);
				}
			});
		}
	}

	$(document).ready(function() {
		$('#regionTable').dataTable({
			"lengthMenu": [
				[25, 50, 100, 500],
				[25, 50, 100, 500]
			],
			order: [
				[0, 'asc']
			],
			"responsive": true,
			fixedHeader: true,
		});

	});
</script>