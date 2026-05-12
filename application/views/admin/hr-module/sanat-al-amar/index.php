<?php $this->load->view('admin/home/header'); ?>
<style>
	.dataTables_wrapper::-webkit-scrollbar {
		display: none;
	}

	.nav-md .container.body .right_col {
		padding: 10px 10px 0;
		margin-left: 230px;
	}

	.size-inner-section {
		box-shadow: 0px 1px 4px #c5c5c5;
		border-radius: 5px;
		margin-bottom: 10px;
	}

	@media only screen and (max-width: 600px) {
		.modal-dialog-aside {
			width: 100% !important;
			max-width: 100% !important;
		}

		.employee-detail {
			display: block !important;
		}

		.employee-detail .image {
			text-align: center;
			margin-top: 10px;
		}
	}

	.modal-dialog-aside {
		width: 35%;
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

	#responseContainer {
		position: fixed;
		width: 93%;
		top: 60px;
		z-index: 9;
	}
</style>


<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Sanat Al Amar</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/hr-module/sanat-al-amar/list'); ?>">Sanat Al Amar</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if (check_action_permission(get_user_role(), 'sanat_al_amar', 'delete')): ?>
						<button type="button" class="btn btn-custom-danger btn-sm pull-right me-2" onclick="deleteAction()" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					<?php endif;
					if (check_action_permission(get_user_role(), 'sanat_al_amar', 'add')): ?>
						<button class="btn btn-custom-success btn-sm pull-right me-2" title="Sanat Al Amar" id="load_add_modal"><i class="fa fa-plus"></i> Add Sanat Al Amar</button>
					<?php endif; ?>
					<a href="<?php echo base_url('admin/hr-module/sanat-al-amar/print-list');?>?keyword=<?php echo $this->input->get('keyword') ?>&iqama_no=<?php echo $this->input->get('iqama_no') ?>&sanat_no=<?php echo $this->input->get('sanat_no') ?>&sanat_owner=<?php echo $this->input->get('sanat_owner') ?>&start_date=<?php echo $this->input->get('start_date') ?>&end_date=<?php echo $this->input->get('end_date');?>" class="btn btn-custom-white btn-sm pull-right me-2" title="Print Sanat Al Amar" target="_blank"><i class="mdi mdi-file-pdf"></i> Export PDF</a>
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
				$this->admin->removeInfo();  ?>
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
						<h4 class="header-title mb-0">Search</h4>
					</div>
					<div class="card-body">
						<form action="<?php echo base_url('admin/hr-module/sanat-al-amar/list'); ?>" method="get" id="filter_form">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Search by Employee Name or Employee No.</label>
										<input type="search" id="keyword" name="keyword" placeholder="Search by Emp Name or Emp No." value="<?php echo $this->input->get('keyword') ? $this->input->get('keyword') : ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Iqama Number</label>
										<input type="search" id="iqama_no" name="iqama_no" placeholder="Search Iqama Number" value="<?php echo $this->input->get('iqama_no') ? $this->input->get('iqama_no') : ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Sanat Number</label>
										<input type="search" id="sanat_no" name="sanat_no" placeholder="Search Sanat Number" value="<?php echo $this->input->get('sanat_no') ? $this->input->get('sanat_no') : ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>
							</div>

							<?php
							$adv_show = false;
							if (!empty($this->input->get('start_date'))) {
								$adv_show = true;
							}
							if (!empty($this->input->get('end_date'))) {
								$adv_show = true;
							}
							if (!empty($this->input->get('sanat_owner'))) {
								$adv_show = true;
							}
							if (!empty($this->input->get('status'))) {
								$adv_show = true;
							}
							?>
							<div class="collapse <?php if ($adv_show) {
														echo ' show';
													} ?>" id="advanceFilter">
								<div class="row">
									<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
										<label for="date_range">Date Range: </label>
										<div class="input-daterange input-group" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#datepicker6">
											<input type="text" class="form-control" name="start_date" placeholder="Start Date" value="<?php echo $this->input->get('start_date'); ?>" autocomplete="off">
											<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
											<input type="text" class="form-control" name="end_date" placeholder="End Date" value="<?php echo $this->input->get('end_date'); ?>" autocomplete="off">
											<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label>Sanat Owner</label>
											<select name="sanat_owner" class="form-select">
												<option value="">Select Owner</option>
												<option value="Abdulaziz Al Dhoheyan" <?php echo ($this->input->get('sanat_owner') == 'Abdulaziz Al Dhoheyan') ? ' selected ' : '';?>>Abdulaziz Al Dhoheyan</option>
												<option value="Itlubha International Company" <?php echo ($this->input->get('sanat_owner') == 'Itlubha International Company') ? ' selected ' : '';?>>Itlubha International Company</option>
											</select>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label>Status</label>
											<select name="status" class="form-select">
												<option value="">Select Status</option>
												<option value="open" <?php echo ($this->input->get('status') == 'open') ? ' selected ' : '';?>>Open</option>
												<option value="activated" <?php echo ($this->input->get('status') == 'activated') ? ' selected ' : '';?>>Activated</option>
												<option value="cancelled" <?php echo ($this->input->get('status') == 'cancelled') ? ' selected ' : '';?>>Cancelled</option>
											</select>
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
									<a href="<?php echo base_url('admin/hr-module/sanat-al-amar/list'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
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
							<table id="sanatTable" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
								<thead>
									<tr>
										<th>#</th>
										<th>S.No.</th>
										<th>Sanat No.</th>
										<th>Emp No.</th>
										<th>Employee Name</th>
										<th>Iqama No.</th>
										<th>Sanat Date</th>
										<th>Sanat Amount</th>
										<th>Sanat Owner</th>
										<th>Status</th>
										<th>Created At</th>
										<th>Updated At</th>
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

<div class="modal fade staticBackdrop fixed-left addCashModal" id="addCashModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="#addCashModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">

		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php $this->load->view('admin/home/footer'); ?>
<script>
	function initializeDataTable() {
		if ($.fn.DataTable.isDataTable('#sanatTable')) {
			$('#sanatTable').DataTable().destroy();
		}

		$('#sanatTable').dataTable({
			"lengthMenu": [
				[25, 50, 100, 500],
				[25, 50, 100, 500]
			],
			//order: [[0, 'asc']],
			dom: 'Blfrtip',
			buttons: [{
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

			"responsive": true,
			"processing": true,
			"serverSide": true,
			"fixedHeader": true,
			"ajax": {
				url: "<?php echo base_url(); ?>admin/hr-module/sanat-al-amar/ajax-list?keyword=<?php echo $this->input->get('keyword') ?>&iqama_no=<?php echo $this->input->get('iqama_no') ?>&sanat_no=<?php echo $this->input->get('sanat_no') ?>&sanat_owner=<?php echo $this->input->get('sanat_owner') ?>&start_date=<?php echo $this->input->get('start_date') ?>&end_date=<?php echo $this->input->get('end_date') ?>&status=<?php echo $this->input->get('status') ?>",
				type: "POST"
			},
			"columnDefs": [{
				"targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
				"orderable": false
			}, ],
		});
	}

	$(document).ready(function() {
		initializeDataTable();
	});

	function deleteAction() {
		var inputCount = $('[name="checklist[]"]:checked').length;
		if (inputCount > 0) {
			if (confirm("Do you want to delete selected item?") == true) {
				changeActionAndSubmit('admin/hr-module/sanat-al-amar/delete');
			} else {
				userPreference = "Action Cancelled!";
			}
		} else {
			toastr.error('Please select check box first.');
		}
	}

	function changeActionAndSubmit(action) {
		document.getElementById('myform').action = action;
		document.getElementById('myform').submit();
	}

	$(document).ready(function() {
		$('#load_add_modal').click(function() {
			$.ajax({
				url: "<?php echo base_url('admin/hr-module/sanat-al-amar/add'); ?>",
				type: 'GET',
				success: function(response) {
					$('#addCashModal').modal('show');
					$('#addCashModal .modal-content').html(response);
				},
				error: function(request, error) {
					console.log(" Can't do because: " + JSON.stringify(request));
					toastr.error('Error loading view.');
				}
			});
		});
	});

	function editModal(id) {
		$.ajax({
			url: "<?php echo base_url('admin/hr-module/sanat-al-amar/edit'); ?>",
			type: 'POST',
			data: {
				'id': id
			},
			dataType: 'json',
			success: function(response) {
				//console.log(response);
				$('#addCashModal').modal('show');
				$('#addCashModal .modal-content').html(response.output_html);
			},
			error: function(request, error) {
				console.log(" Can't do because: " + JSON.stringify(request));
				toastr.error('Error loading view.');
			}
		});
	}

	function detailModal(id) {
		$.ajax({
			url: "<?php echo base_url('admin/hr-module/sanat-al-amar/detail'); ?>",
			type: 'POST',
			data: {
				'id': id
			},
			dataType: 'json',
			success: function(response) {
				//console.log(response);
				$('#addCashModal').modal('show');
				$('#addCashModal .modal-content').html(response.output_html);
			},
			error: function(request, error) {
				console.log(" Can't do because: " + JSON.stringify(request));
				toastr.error('Error loading view.');
			}
		});
	}

	$(".modal-close").click(function() {
		resetModalData();
	});

	function resetModalData() {
		$('#searchResult').html('');
		$('#searchModalFooter').html('');
		$('#searchResponse').html('');
		$('#responseContainer').html('');
	}

	$(document).ready(function() {
		var today = new Date();
		$('#datepicker6').datepicker({
			endDate: today
		});
	});
</script>