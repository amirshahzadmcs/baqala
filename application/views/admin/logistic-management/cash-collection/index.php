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

	#responseContainer {
		position: fixed;
		width: 93%;
		top: 60px;
		z-index: 9;
	}
	.no-action-input{
		cursor: not-allowed;
		background-color: #edf1f5;
	}
	th, td {
		white-space: nowrap;
	}
</style>


<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Riders Cash Collection</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/logistic-management/cash-collection/list'); ?>">Riders Cash Collection</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<?php if (check_action_permission(get_user_role(), 'riders_cash_collection', 'print_cash_report') || check_action_permission(get_user_role(), 'riders_cash_collection', 'print_employewise_summary') || check_action_permission(get_user_role(), 'riders_cash_collection', 'print_collection_wise_summary') || check_action_permission(get_user_role(), 'riders_cash_collection', 'print_pending_collection_report') || check_action_permission(get_user_role(), 'riders_cash_collection', 'print_full_cash_report')): ?>
					<div class="btn-group float-end ms-2">
						<button class="btn btn-custom-white btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="ti-export"></i> Export <i class="mdi mdi-chevron-down"></i>
						</button>
						<div class="dropdown-menu dropdown-menu-end">
							<h6 class="dropdown-header">EXPORT AS</h6>
							<?php if (check_action_permission(get_user_role(), 'riders_cash_collection', 'print_cash_report')): ?>
								<a href="<?php echo base_url(); ?>admin/logistic-management/cash-collection/print-cod-statement?keyword=<?php echo $this->input->get('keyword') ?>&receipt_reason=<?php echo $this->input->get('receipt_reason') ?>&employer=<?php echo $this->input->get('employer') ?>&driver_id=<?php echo $this->input->get('driver_id') ?>&team=<?php echo $this->input->get('team') ?>&order_start_date=<?php echo $this->input->get('order_start_date') ?>&order_end_date=<?php echo $this->input->get('order_end_date') ?>&start_date=<?php echo $this->input->get('start_date') ?>&end_date=<?php echo $this->input->get('end_date') ?>" class="dropdown-item" title="Jahez COD Statement" target="_blank">Jahez COD Statement</a>
								<div class="dropdown-divider"></div>
							<?php endif;
							if (check_action_permission(get_user_role(), 'riders_cash_collection', 'print_employewise_summary')): ?>
								<a href="<?php echo base_url(); ?>admin/logistic-management/cash-collection/print-cod-report?keyword=<?php echo $this->input->get('keyword') ?>&receipt_reason=<?php echo $this->input->get('receipt_reason') ?>&employer=<?php echo $this->input->get('employer') ?>&driver_id=<?php echo $this->input->get('driver_id') ?>&team=<?php echo $this->input->get('team') ?>&order_start_date=<?php echo $this->input->get('order_start_date') ?>&order_end_date=<?php echo $this->input->get('order_end_date') ?>&start_date=<?php echo $this->input->get('start_date') ?>&end_date=<?php echo $this->input->get('end_date') ?>" class="dropdown-item" title="Jahez COD Report" target="_blank">Jahez COD Report</a>
								<div class="dropdown-divider"></div>
							<?php endif; 
							if (check_action_permission(get_user_role(), 'riders_cash_collection', 'print_collection_wise_summary')): ?>
								<a type="button" class="dropdown-item" data-export_modal="collection_report" title="Jahez Collection Report">Jahez Collection Report</a>
								<div class="dropdown-divider"></div>
							<?php endif; 
							if (check_action_permission(get_user_role(), 'riders_cash_collection', 'print_pending_collection_report')): ?>
								<a type="button" class="dropdown-item" data-export_modal="monthly_collection" title="Jahez Pending Report">Jahez Pending Report</a>
							<div class="dropdown-divider"></div>
							<?php endif; ?>
							<?php if (check_action_permission(get_user_role(), 'riders_cash_collection', 'print_full_cash_report')): ?>
								<a type="button" class="dropdown-item" data-export_modal="full_collection_report" title="Jahez Full Cash Report">Jahez Full Cash Report</a>
							<?php endif;?>
						</div>
					</div>
				<?php endif; ?>
				<div class="float-end d-sm-block">
					<?php if (check_action_permission(get_user_role(), 'riders_cash_collection', 'delete')): ?>
						<button type="button" class="btn btn-custom-danger btn-sm pull-right ms-2" onclick="deleteAction()" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					<?php endif;
					if (check_action_permission(get_user_role(), 'riders_cash_collection', 'add')): ?>
						<button class="btn btn-custom-success btn-sm pull-right ms-2" title="Collect Cash" id="load_add_modal"><i class="fa fa-plus"></i> Collect Cash</button>
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
						<form action="<?php echo base_url('admin/logistic-management/cash-collection/list'); ?>" method="get" id="filter_form">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Search by Employee Name or Employee No.</label>
										<select class="form-control" class="form-control" placeholder="Search by Emp. Name or Emp. ID" aria-label="Employee Number" name="keyword" id="filter_keyword" aria-describedby="button-addon2">
											<option value="">Search Employee Name or Emp No...</option>
										</select>
									</div>
								</div>

								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="date_range">COD Date: </label>
									<div class="input-daterange input-group" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#datepicker6">
										<input type="text" class="form-control" name="order_start_date" placeholder="Start Date" value="<?php echo $this->input->get('order_start_date'); ?>" autocomplete="off">
										<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
										<input type="text" class="form-control" name="order_end_date" placeholder="End Date" value="<?php echo $this->input->get('order_end_date'); ?>" autocomplete="off">
										<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
									</div>
								</div>

								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="date_range">Collection Date: </label>
									<div class="input-daterange input-group" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#datepicker6">
										<input type="text" class="form-control" name="start_date" placeholder="Start Date" value="<?php echo $this->input->get('start_date'); ?>" autocomplete="off">
										<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
										<input type="text" class="form-control" name="end_date" placeholder="End Date" value="<?php echo $this->input->get('end_date'); ?>" autocomplete="off">
										<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
									</div>
								</div>
							</div>

							<?php
							$adv_show = false;
							if (!empty($this->input->get('receipt_reason'))) {
								$adv_show = true;
							}
							if (!empty($this->input->get('department'))) {
								$adv_show = true;
							}
							if (!empty($this->input->get('team'))) {
								$adv_show = true;
							}
							if (!empty($this->input->get('employer'))) {
								$adv_show = true;
							}
							if (!empty($this->input->get('driver_id'))) {
								$adv_show = true;
							}
							?>
							<div class="collapse <?php if ($adv_show) {echo ' show';} ?>" id="advanceFilter">
								<div class="row">
									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label>Driver ID</label>
											<input type="search" name="driver_id" class="form-control" value="<?php echo $this->input->get('driver_id'); ?>" placeholder="Driver ID">
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label>Transaction Type</label>
											<select name="receipt_reason" class="form-select">
												<option value="">Select Reason</option>
												<?php
												if (!empty(cashReasonsHelper())) {
													foreach (cashReasonsHelper() as $master_reason) {
												?>
														<option value="<?php echo $master_reason->reason_title_en; ?>" <?php echo ($master_reason->reason_title_en == $this->input->get('receipt_reason')) ? ' selected ' : ''; ?>><?php echo $master_reason->reason_title_en; ?></option>
													<?php }
												} else { ?>
													<option value="" disabled>No reason found, add first!</option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label>Team</label>
											<select name="team" class="form-select">
												<option value="">[ All Team]</option>
												<?php foreach($teams as $mteam) { ?>
													<option value="<?php echo $mteam->name; ?>" <?php echo ($mteam->name == $this->input->get('team')) ? ' selected ' : '';?>><?php echo $mteam->name; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label class="d-block">Employer </label>
											<select name="employer" class="form-select select2">
												<option value="">[All Employer]</option>
												<?php foreach (sponsorsHelper() as $employer) { ?>
													<option value="<?php echo $employer['id']; ?>" <?php echo ($employer['id'] == $this->input->get('employer')) ? ' selected ' : '' ?>><?php echo $employer['employer_name']; ?></option>
												<?php } ?>
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
									<a href="<?php echo base_url('admin/logistic-management/cash-collection/list'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-12">
				<div class="card">
					<div class="card-body" style="overflow: scroll;">
						<form id="myform" name="myform" method="post" action="">
							<table id="cashTable" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
								<thead>
									<tr>
										<th align="center">#</th>
										<th align="center">S.No</th>
										<th align="center">Emp. ID</th>
										<th align="center">Employee Name</th>
										<th align="center">Driver ID</th>
										<th align="center">COD Date</th>
										<th align="center">Delivery Price</th>
										<th align="center">Cash Collection</th>
										<th align="center">Driver Credit</th>
										<th align="center">Driver Debit</th>
										<th align="center">Bonuses</th>
										<th align="center">Tips</th>
										<th align="center">Penalty</th>
										<th align="center">Service Deduction</th>
										<th align="center">Total Amount</th>
										<th align="center">Collected Date</th>
										<th align="center">Collected Amount</th>
										<th align="center">Outstanding Bal.</th>
										<th align="center">Collected By</th>
										<th align="center">Created At</th>
										<th align="center">Updated At</th>
										<th align="center">Tools</th>
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

<div class="modal fade fixed-left" id="filtersModal" tabindex="-1" aria-labelledby="filtersModalLabel" aria-hidden="true">
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
		if ($.fn.DataTable.isDataTable('#cashTable')) {
			$('#cashTable').DataTable().destroy();
		}

		$('#cashTable').dataTable({
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

			"responsive": false,
			"processing": true,
			"serverSide": true,
			"fixedHeader": true,
			"searching": false,
			"ajax": {
				url: "<?php echo base_url(); ?>admin/logistic-management/cash-collection/ajax-list?keyword=<?php echo $this->input->get('keyword') ?>&voucher_no=<?php echo $this->input->get('voucher_no') ?>&receipt_reason=<?php echo $this->input->get('receipt_reason') ?>&employer=<?php echo $this->input->get('employer') ?>&driver_id=<?php echo $this->input->get('driver_id') ?>&team=<?php echo $this->input->get('team') ?>&start_date=<?php echo $this->input->get('start_date') ?>&end_date=<?php echo $this->input->get('end_date') ?>&order_start_date=<?php echo $this->input->get('order_start_date') ?>&order_end_date=<?php echo $this->input->get('order_end_date') ?>",
				type: "POST"
			},
			"columnDefs": [{
				"targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21],
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
				changeActionAndSubmit('admin/logistic-management/cash-collection/delete');
			} else {
				userPreference = "Action Cancelled!";
			}
		} else {
			alert('Please select check box first');
		}
	}

	function changeActionAndSubmit(action) {
		document.getElementById('myform').action = action;
		document.getElementById('myform').submit();
	}

	$(document).ready(function() {
		$('#load_add_modal').click(function() {
			$.ajax({
				url: "<?php echo base_url('admin/logistic-management/cash-collection/add'); ?>",
				type: 'GET',
				success: function(response) {
					$('#addCashModal').modal('show');
					$('#addCashModal .modal-content').html(response);
				},
				error: function(request, error) {
					console.log(" Can't do because: " + JSON.stringify(request));
					alert('Error loading view');
				}
			});
		});
	});

	function editModal(id) {
		$.ajax({
			url: "<?php echo base_url('admin/logistic-management/cash-collection/edit'); ?>",
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
				alert('Error loading view');
			}
		});
	}

	function detailModal(id) {
		$.ajax({
			url: "<?php echo base_url('admin/logistic-management/cash-collection/detail'); ?>",
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
				alert('Error loading view');
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

	$(document).ready(function () {
		$('[data-export_modal]').on('click', function () {
			let modalName = $(this).data('export_modal');

			// Show loading
			$('#filtersModal .modal-content').html('<div class="p-4 text-center">Loading...</div>');

			// Show modal
			$('#filtersModal').modal('show');

			// Fetch modal content via AJAX
			$.ajax({
				url: "<?= base_url('admin/logistic-management/cash-collection/monthly-filter/') ?>" + modalName,
				type: "GET",
				success: function (response) {
					//console.log(response);
					$('#filtersModal .modal-content').html(response);
				},
				error: function () {
					$('#filtersModal .modal-content').html('<div class="p-4 text-danger text-center">Failed to load content.</div>');
				}
			});
		});
	});

	$(document).ready(function () {
		$('#filter_keyword').select2({
			placeholder: 'Search Employee Name or Emp No...',
			allowClear: true,
			minimumInputLength: 3,
			ajax: {
				url: "<?php echo base_url('admin/logistic-management/Cash_collection/search_employee'); ?>",
				type: 'GET',
				dataType: 'json',
				delay: 250,
				data: function(params) {
					return {
						search: params.term
					};
				},
				processResults: function(data) {
					return {
						results: $.map(data, function(item) {
							//console.log(item);
							return {
								id: item.id,
								text: item.emp_no + ' - ' + item.full_name
							};
						})
					};
				},
				error: function(xhr, status, error) {
					console.log(xhr.responseText);
				}
			}
		});

		// Preselect value if already chosen
		var selectedKeyword = "<?php echo $this->input->get('keyword'); ?>";
		if (selectedKeyword) {
			$.ajax({
				url: "<?php echo base_url('admin/logistic-management/Cash_collection/search_employee'); ?>",
				type: "GET",
				data: { search: selectedKeyword },
				dataType: 'json',
				success: function (data) {
					let item = data.find(emp => emp.id === selectedKeyword);
					if (item) {
						var option = new Option(item.emp_no + " - " + item.full_name, item.id, true, true);
						$('#filter_keyword').append(option).trigger('change');
					}
				}
			});
		}
		
	});
</script>
