<?php $this->load->view('admin/home/header'); ?>
<style>
	.dataTables_wrapper::-webkit-scrollbar {
		display: none;
	}

	.nav-md .container.body .right_col {
		padding: 10px 10px 0;
		margin-left: 230px;
	}

	.modal-dialog-aside {
		width: 40%;
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

	.size-inner-section {
		box-shadow: 0px 1px 4px #c5c5c5;
		border-radius: 5px;
		margin-bottom: 10px;
	}

	#responseContainer2 {
		position: absolute;
		width: 94%;
	}
	.set-status-modal .modal-dialog-aside {
    	width: 30%;
	}
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Sim Card Management</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item active">Sim Card List</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if (check_action_permission(get_user_role(), 'sim_card', 'delete')): ?>
						<button type="button" class="btn btn-custom-danger btn-sm" onclick="deleteAction()" title="Delete">
							<i class="fa fa-trash"></i> Delete
						</button>
					<?php endif; ?>

					<?php
					$exportPdf = check_action_permission(get_user_role(), 'sim_card', 'print_sim_list');
					$exportExcel = check_action_permission(get_user_role(), 'sim_card', 'allSimExcel');

					if ($exportPdf || $exportExcel): ?>
						<div class="btn-group me-1">
							<button class="btn btn-custom-white btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Exports <i class="mdi mdi-chevron-down"></i>
							</button>
							<div class="dropdown-menu">
								<?php if ($exportPdf): ?>
									<a class="dropdown-item" href="<?= base_url("admin/Sim_card/print_sim_list") ?>?network=<?= $this->input->get('network') ?>&plan=<?= $this->input->get('plan') ?>&status=<?= $this->input->get('status') ?>&sim_type=<?= $this->input->get('sim_type') ?>&allot_status=<?= $this->input->get('allot_status') ?>&is_gps_sim=<?= $this->input->get('is_gps_sim') ?>&keyword=<?= $this->input->get('keyword') ?>&from=<?= $this->input->get('from') ?>&to=<?= $this->input->get('to') ?>&user=<?= $this->input->get('user') ?>&sim_no=<?= $this->input->get('sim_no') ?>" target="_blank">Export PDF</a>
								<?php endif; ?>

								<?php if ($exportPdf && $exportExcel): ?>
									<div class="dropdown-divider"></div>
								<?php endif; ?>

								<?php if ($exportExcel): ?>
									<a class="dropdown-item" href="<?= base_url("admin/sim/export-excel") ?>?network=<?= $this->input->get('network') ?>&plan=<?= $this->input->get('plan') ?>&status=<?= $this->input->get('status') ?>&sim_type=<?= $this->input->get('sim_type') ?>&allot_status=<?= $this->input->get('allot_status') ?>&is_gps_sim=<?= $this->input->get('is_gps_sim') ?>&keyword=<?= $this->input->get('keyword') ?>&from=<?= $this->input->get('from') ?>&to=<?= $this->input->get('to') ?>&user=<?= $this->input->get('user') ?>&sim_no=<?= $this->input->get('sim_no') ?>" target="_blank">Export Excel</a>
								<?php endif; ?>
							</div>
						</div>
					<?php endif;
					if (check_action_permission(get_user_role(), 'sim_card', 'add_sim')): ?>
						<a class="btn btn-custom-success btn-sm me-1" title="Add Sim Card" href="<?= base_url('admin/sim/add') ?>">
							<i class="fa fa-plus"></i> Add Sim Card
						</a>
					<?php endif; ?>
				</div>
				<?php if ($this->admin->getInfo()) {
					$info = explode("--", $this->admin->getInfo());
					$info_type = $info[0];
					$msg_data = $info[1];
					if ($info_type == 1) {
				?>
					<div class="alert alert-success alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<strong><?php echo $msg_data; ?></strong>
					</div>
					<?php } else { ?>
						<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong><?php echo $msg_data; ?></strong>
						</div>
				<?php }
				}
				$this->admin->removeInfo(); ?>
				<?php if ($this->input->get('msg')) { ?>
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<strong><?php echo $this->input->get('msg'); ?></strong>
					</div>
				<?php } ?>
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
						<form method="get">
							<div class="row align-items-center">
								<div class="form-group col-lg-4 col-sm-6 mb-3">
									<label>Search By Owner Name/ID or Mobile No.</label>
									<input type="text" id="keyword" name="keyword" placeholder="Enter owner name/owner id or mobile no." value="<?php echo $this->input->get('keyword') ? $this->input->get('keyword') : ''; ?>" autocomplete="off" class="form-control">
								</div>
								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="network">Select Network:</label>
									<select name="network" id="network" class="form-control select2 w-100">
										<option value="">[Any Network]</option>
										<?php foreach ($networks as $network) { ?>
											<option value="<?php echo $network->id; ?>" <?php echo ($network->id == $this->input->get('network')) ? 'selected' : ''; ?>><?php echo $network->network_name; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group col-lg-4 col-sm-6 mb-3">
									<label for="sim_type">Sim Type</label>
									<select name="sim_type" class="form-control select2 w-100">
										<option value="">[Any Sim Type]</option>
										<option value="postpaid" <?php echo $this->input->get('sim_type') == 'postpaid' ? 'selected' : '' ?>>Postpaid</option>
										<option value="prepaid" <?php echo $this->input->get('sim_type') == 'prepaid' ? 'selected' : '' ?>>Prepaid</option>
										<option value="Postpaid - Data SIM" <?php echo $this->input->get('sim_type') == 'Postpaid - Data SIM' ? 'selected' : '' ?>>Postpaid - Data SIM</option>
									</select>
								</div>
								<?php
								$adv_show = false;
								if (!empty($this->input->get('plan')) || !empty($this->input->get('sim_no')) || !empty($this->input->get('status')) || !empty($this->input->get('allot_status')) || !empty($this->input->get('is_gps_sim')) || !empty($this->input->get('user')) || !empty($this->input->get('from')) || !empty($this->input->get('to'))) {
									$adv_show = true;
								}
								?>
								<div class="collapse <?php if ($adv_show) {
															echo ' show';
														} ?>" id="advanceFilter">
									<div class="row">
										<div class="form-group col-lg-4 col-sm-6 mb-3">
											<label>Search By Sim No.</label>
											<input type="text" name="sim_no" placeholder="Enter sim no." value="<?php echo $this->input->get('sim_no') ? $this->input->get('sim_no') : ''; ?>" autocomplete="off" class="form-control">
										</div>
										<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
											<label for="plan">Select Plan:</label>
											<select name="plan" id="plan" class="form-control select2 w-100">
												<option value="">[Any Plan]</option>
												<?php foreach ($plans as $plan) { ?>
													<option value="<?php echo $plan->id; ?>" <?php echo ($plan->id == $this->input->get('plan')) ? 'selected' : ''; ?>><?php echo $plan->plan_name; ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
											<label for="user">Select User:</label>
											<select name="user" id="user" class="form-control select2 w-100">
												<option value="">[Any User]</option>
												<?php foreach (employeeListHelper() as $emp_list) { ?>
													<option value="<?php echo $emp_list->id; ?>" <?php echo ($emp_list->id == $this->input->get('user')) ? 'selected' : ''; ?>><?php echo $emp_list->emp_no .' - '. $emp_list->full_name; ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="form-group col-lg-4 col-sm-6 mb-3">
											<label for="status">Sim Status</label>
											<select name="status" class="form-control select2">
												<option value="">[Any Sim Status]</option>
												<option value="new" <?php echo $this->input->get('status') == 'new' ? 'selected' : '' ?>>New</option>
												<option value="active" <?php echo $this->input->get('status') == 'active' ? 'selected' : '' ?>>Active</option>
												<option value="discontinued" <?php echo $this->input->get('status') == 'discontinued' ? 'selected' : '' ?>>Discontinued</option>
												<option value="port" <?php echo $this->input->get('status') == 'port' ? 'selected' : '' ?>>Port</option>
											</select>
										</div>
										<div class="form-group col-lg-4 col-sm-6 mb-3">
											<label for="allot_status">Allotment Status</label>
											<select name="allot_status" class="form-control select2">
												<option value="">[Any Allotment Status]</option>
												<option value="new" <?php echo $this->input->get('allot_status') == 'new' ? 'selected' : '' ?>>New</option>
												<option value="alloted" <?php echo $this->input->get('allot_status') == 'alloted' ? 'selected' : '' ?>>Alloted</option>
												<option value="unalloted" <?php echo $this->input->get('allot_status') == 'unalloted' ? 'selected' : '' ?>>Unalloted</option>
											</select>
										</div>
										<div class="form-group col-lg-4 col-sm-6 mb-3">
											<label for="is_gps_sim">GPS Sim</label>
											<select name="is_gps_sim" class="form-control select2">
												<option value="">[Any]</option>
												<option value="on" <?php echo $this->input->get('is_gps_sim') == 'on' ? 'selected' : '' ?>>Yes</option>
												<option value="off" <?php echo $this->input->get('is_gps_sim') == 'off' ? 'selected' : '' ?>>No</option>
											</select>
										</div>
										<div class="form-group col-lg-4 col-sm-6 mb-3">
											<label>Activation Date Between (From and To)</label>
											<div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
												<input type="text" class="form-control" id="_from" name="from" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" autocomplete="off" placeholder="Start Date" />
												<input type="text" class="form-control" id="_to" name="to" value="<?php echo $this->input->get('to') ? $this->input->get('to') : ''; ?>" autocomplete="off" placeholder="End Date" />
											</div>
										</div>
									</div>
								</div>
								<div class="row mt-2">
									<div class="col-lg-6 col-md-6 col-sm-12">
										<button class="btn btn-outline-secondary waves-effect waves-light" type="button" data-bs-toggle="collapse" data-bs-target="#advanceFilter" aria-expanded="false" aria-controls="advanceFilter"><i class="fas fa-sliders-h"></i> Advance Search</button>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12">
										<button type="submit" class="btn btn-success btn-md float-end ms-2">Apply Filter</button>
										<a href="<?php echo base_url('admin/sim/list'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<form id="myform" name="myform" method="post" action="">
							<table id="simTable" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
								<thead>
									<tr>
										<th>#</th>
										<th>Sr. No.</th>
										<th>Addition Date</th>
										<th>Owner Type</th>
										<th>Owner ID</th>
										<th>Owner Name</th>
										<th>Mobile No</th>
										<th>Sim Card No</th>
										<th>Date of purchase</th>
										<th>Sim Type</th>
										<th>Is GPS Sim</th>
										<th>Network Provider</th>
										<th>Active Plan</th>
										<th>Emp. ID</th>
										<th>Current User</th>
										<th>Sim Status</th>
										<th>Allotment Status</th>
										<th>Tools</th>
									</tr>
								</thead>
								<tbody>

								</tbody>
							</table>
						</form>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<div class="modal fade allotment-modal" role="dialog" aria-labelledby="ModalFullscreenLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title mt-0" id="summaryModalFullscreenLabel">Sim Allotment</h6>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" id="summary_body_modal">

			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade fixed-left replacementModal2" id="replacementModal2" aria-labelledby="#replacementModalModalLabel2" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0" id="replacementModalModalLabel2">Replace Sim Card</h5>
				<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="responseContainer2"></div>
				<div id="searchResult2" class="mt-4">

				</div>
			</div>
			<div class="modal-footer" id="searchModalFooter2">

			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade fixed-left set-status-modal" role="dialog" aria-labelledby="ModalFullscreenLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">

		</div>
	</div>
</div>
<!-- /.modal -->
<?php $this->load->view('admin/home/footer'); ?>

<script>
	$(document).ready(function() {
		$('#simTable').dataTable({
			"lengthMenu": [
				[25, 50, 100, 500],
				[25, 50, 100, 500]
			],
			order: [
				[0, 'asc']
			],
			/*
			dom: 'Blfrtip',
			buttons: [
				{
					extend: "csv",
					className: "btn-md"
				},
				{
					extend: "excel",
					className: "btn-md"
				},
				{
					extend: "pdfHtml5",
					className: "btn-md"
				},
				{
					extend: "print",
					className: "btn-md"
				},
			],
			*/
			"responsive": true,
			"processing": true,
			"serverSide": true,
			"fixedHeader": true,
			searching: false,
			"ajax": {
				url: "<?php echo base_url(); ?>admin/Sim_card/get_list?network=<?php echo $this->input->get('network') ?>&plan=<?php echo $this->input->get('plan') ?>&sim_no=<?php echo $this->input->get('sim_no') ?>&status=<?php echo $this->input->get('status') ?>&sim_type=<?php echo $this->input->get('sim_type') ?>&allot_status=<?php echo $this->input->get('allot_status') ?>&is_gps_sim=<?php echo $this->input->get('is_gps_sim') ?>&keyword=<?php echo $this->input->get('keyword') ?>&from=<?php echo $this->input->get('from'); ?>&to=<?php echo $this->input->get('to'); ?>&user=<?php echo $this->input->get('user'); ?>",
				type: "POST",
				error: function(request, error) {
					console.log(" Can't do because: " + JSON.stringify(request));
				},
			},
			"columnDefs": [{
				"targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17],
				"orderable": false
			}, ],
		});
	});

	function deleteAction() {
		var inputCount = $('[name="checklist[]"]:checked').length;
		if (inputCount > 0) {
			if (confirm("Do you want to delete selected sim cards?") == true) {
				changeActionAndSubmit('admin/sim/delete');
			} else {
				userPreference = "Action Cancelled!";
			}
		} else {
			alert('Plese select check box first');
		}
	}

	function changeActionAndSubmit(action) {
		document.getElementById('myform').action = action;
		document.getElementById('myform').submit();
	}

	function allotmentPopup(identifier) {
		let id = $(identifier).data('id');
		let type = $(identifier).data('type');
		if (id > 0) {
			$.ajax({
				type: "post",
				url: "<?php echo base_url('admin/sim/allotment-form'); ?>",
				data: {
					'id': id,
					'type': type
				},
				//dataType: "json",
				success: function(response) {
					console.log(response);
					$('.allotment-modal').modal('show');
					$('#summary_body_modal').html(response);
					$('#summaryModalFullscreenLabel').html('SIM ' + type.toUpperCase());
				},
				error: function(request, error) {
					console.log(" Can't do because: " + JSON.stringify(request));
					$('#summary_body_modal').after(JSON.stringify(request));
				},
			});
		} else {
			alert('Invalid request id!');
		}
	}

	function replacePopup(identifier) {
		let id = $(identifier).data('id');
		let type = $(identifier).data('type');
		if (id > 0) {
			$.ajax({
				url: "<?php echo base_url('admin/sim/replace-form'); ?>",
				type: 'POST',
				data: {
					'id': id,
					'type': type
				},
				dataType: 'json',
				success: function(response) {
					console.log(response);
					if (response.type === 'success') {
						$('.replacementModal2').modal('show');
						$('#responseContainer2').html('<p class="text-success mb-0 mt-2">' + response.message + '</p>');
						$('#searchResult2').html(response.output_html);
						$('#searchModalFooter2').html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetModalData()">Cancel</button>
			<button type="submit" form="simReplaceForm" class="btn btn-custom-success">Submit</button>`);
				} else {
					console.log(response);
					$('#responseContainer2').html('<p class="text-danger mb-0 mt-2">' + response.message + '</p>');
				}
				},
				error: function(error) {
					console.log(error);
					$('#responseContainer2').html('<p class="text-danger mb-0 mt-2">An error occurred. Please try again.</p>');
				}
			});
		} else {
			$('#responseContainer2').html('<p class="text-danger mb-0 mt-2">Invalid request id!</p>');
		}
	}

	function changeStatusPopup(identifier) {
		let id = $(identifier).data('id');
		let type = $(identifier).data('type');
		if (id > 0) {
			$.ajax({
				url: "<?php echo base_url('admin/sim/change-status-form'); ?>",
				type: 'POST',
				data: {
					'id': id,
					'type': type
				},
				dataType: 'json',
				success: function(response) {
					//console.log(response);
					if (response.type === 'success') {
						$('.set-status-modal').modal('show');
						toastr.success(response.message);
						$('.set-status-modal .modal-content').html(response.output_html);
					} else {
						//console.log(response);
						toastr.error(response.message);
					}
				},
				error: function(error) {
					//console.log(error);
					toastr.error('An error occurred. Please try again.');
				}
			});
		} else {
			toastr.error('Invalid request id!');
		}
	}
</script>
