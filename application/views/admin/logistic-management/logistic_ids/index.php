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
		.modal-dialog-aside{
			width: 100% !important;
			max-width: 100% !important;
		}
		.employee-detail{
			display: block !important;
		}
		.employee-detail .image{
			text-align: center;
			margin-top: 10px;
		}
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
	#responseContainer{
		position: fixed;
		width: 93%;
		top: 60px;
	}
	/* Overlay style */
	.status-overlay {
		position: absolute;
		background-color: rgb(255 255 255) !important;
		color: #000;
		padding: 5px !important;
		border: 1px solid #666;
		border-radius: 3px;
		font-size: 16px;
		z-index: 10;
		font-weight: bold;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		pointer-events: none;
	}

	/* Disabled row style */
	.disabled-row {
		pointer-events: none; /* Disable interactions */
		position: relative; /* Ensure the overlay is positioned relative to the row */
	}

	/* Ensure rows have relative positioning for the overlay to position correctly */
	table tbody tr {
		position: relative;
	}
</style>


<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Aggregator</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/logistic-management/platform-id/list'); ?>">Aggregator</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if(check_action_permission(get_user_role(),'aggregator_id','delete')):?>
					<button type="button" class="btn btn-custom-danger btn-sm pull-right me-2" onclick="deleteAction()" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					<?php endif; if(check_action_permission(get_user_role(),'aggregator_id','aggregatorDetailExport')):?>
					<a href="<?php echo base_url();?>admin/logistic-management/platform-id/export-excel?alloted_to=<?php echo $this->input->get('alloted_to')?>&owner=<?php echo $this->input->get('owner')?>&r_from=<?php echo $this->input->get('r_from')?>&from=<?php echo $this->input->get('from')?>&to=<?php echo $this->input->get('to')?>&id_number=<?php echo $this->input->get('id_number')?>&platform=<?php echo $this->input->get('platform')?>&status=<?php echo $this->input->get('status')?>&id_type=<?php echo $this->input->get('id_type')?>" class="btn btn-custom-white btn-sm pull-right me-2" target="_blank" title="Export Aggregators Excel"><i class="fas fa-file-export"></i> Export Aggregators</a>
					<?php endif; if(check_action_permission(get_user_role(),'aggregator_id','add')):?>
					<button class="btn btn-custom-success btn-sm pull-right me-2" title="New Platform" id="load_add_modal"><i class="fa fa-plus"></i> New Aggregator</button>
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
						<form action="<?php echo base_url('admin/logistic-management/platform-id/list'); ?>" method="get" id="filter_form">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>ID Number</label>
										<select name="id_number" class="form-control select2 select2-ajax" placeholder="Search ID Number" data-filter-type="id_number" data-selected="<?php echo $this->input->get('id_number'); ?>">
											<option value="">[Any ID No.]</option>
											<?php if ($this->input->get('id_number')) { ?>
												<option value="<?php echo $this->input->get('id_number'); ?>" selected>
													<?php echo $this->input->get('id_number'); ?>
												</option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Owner Name</label>
										<select name="owner" class="form-select select2 select2-ajax" data-filter-type="owner" data-selected="<?php echo $this->input->get('owner'); ?>">
											<option value="">[Any Owner]</option>
											<?php if ($this->input->get('owner')) { 
												$ownerUserId = $this->input->get('owner');
												$ownerUserName = employeeDetailHelper($ownerUserId);
											?>
											<option value="<?php echo $ownerUserId; ?>" selected>
												<?php echo $ownerUserName->full_name; ?>
											</option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Alloted To</label>
										<select name="alloted_to" class="form-select select2 select2-ajax" data-filter-type="alloted_to" data-selected="<?php echo $this->input->get('alloted_to'); ?>">
											<option value="">[Any Alloted]</option>
											<?php if ($this->input->get('alloted_to')) { 
												$allotedUserId = $this->input->get('alloted_to');
												$allotedUserName = employeeDetailHelper($allotedUserId);
											?>
											<option value="<?php echo $allotedUserId; ?>" selected>
												<?php echo $allotedUserName->full_name; ?>
											</option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<?php
								$adv_show = false;
								if(!empty($this->input->get('id_number'))){
									$adv_show = true;
								}
								if(!empty($this->input->get('status'))){
									$adv_show = true;
								}
								if(!empty($this->input->get('platform'))){
									$adv_show = true;
								}
								if(!empty($this->input->get('id_type'))){
									$adv_show = true;
								}
								if(!empty($this->input->get('from'))){
									$adv_show = true;
								}
								if(!empty($this->input->get('to'))){
									$adv_show = true;
								}
								if(!empty($this->input->get('allotment_status'))){
									$adv_show = true;
								}
							?>
							<div class="collapse <?php if($adv_show){ echo ' show';}?>" id="advanceFilter">
								<div class="row">
									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label>ID Type</label>
											<select name="id_type" class="form-select">
												<option value="">[ All ID Type ]</option>
												<option value="Company" <?php echo ($this->input->get('id_type') == 'Company') ? ' selected ' : '';?>>Company</option>
												<option value="Freelancer" <?php echo ($this->input->get('id_type') == 'Freelancer') ? ' selected ' : '';?>>Freelancer</option>
											</select>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label>Aggregator</label>
											<select name="platform" class="form-select">
												<option value="">[ All Aggregator ]</option>
												<?php foreach(fdCompanyHelper() as $fdcompany) { ?>
													<option value="<?php echo $fdcompany->id; ?>" <?php echo ($fdcompany->id == $this->input->get('platform')) ? ' selected ' : '';?>><?php echo $fdcompany->company_name; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label>Status</label>
											<select name="status" class="form-select">
												<option value="">[ All Status ]</option>
												<option value="active" <?php echo ($this->input->get('rider_status') == 'active') ? ' selected ' : '';?>>Active</option>
												<option value="inactive" <?php echo ($this->input->get('rider_status') == 'inactive') ? ' selected ' : '';?>>Inactive</option>
												<option value="requested" <?php echo ($this->input->get('rider_status') == 'requested') ? ' selected ' : '';?>>Requested</option>
												<option value="terminated" <?php echo ($this->input->get('rider_status') == 'terminated') ? ' selected ' : '';?>>Terminated</option>
											</select>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label>Allotment Status</label>
											<select name="allotment_status" class="form-select">
												<option value="">[ All Allotment Status ]</option>
												<option value="alloted" <?php echo ($this->input->get('allotment_status') == 'alloted') ? ' selected ' : '';?>>Alloted</option>
												<option value="not_alloted" <?php echo ($this->input->get('allotment_status') == 'not_alloted') ? ' selected ' : '';?>>Not Alloted</option>
											</select>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label>Request Between (From and To)</label>
											<div class="input-daterange input-group" id="datepicker6" data-date-format="dd-m-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
												<input type="text" class="form-control" id="_from" name="from" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" autocomplete="off" placeholder="Start Date" />
												<input type="text" class="form-control" id="_to" name="to" value="<?php echo $this->input->get('to') ? $this->input->get('to') : ''; ?>" autocomplete="off" placeholder="End Date" />
											</div>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label>Activation Between (From and To)</label>
											<div class="input-daterange input-group" id="datepicker6" data-date-format="dd-m-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
												<input type="text" class="form-control" id="_from" name="from" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" autocomplete="off" placeholder="Start Date" />
												<input type="text" class="form-control" id="_to" name="to" value="<?php echo $this->input->get('to') ? $this->input->get('to') : ''; ?>" autocomplete="off" placeholder="End Date" />
											</div>
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
									<a href="<?php echo base_url('admin/logistic-management/platform-id/list'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
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
							<table id="empTable" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
								<thead>
									<tr>
										<th>#</th>
										<th>S.No.</th>
										<th>Owner Emp No.</th>
										<th>Owner Emp Name</th>
										<th>Aggregator</th>
										<th>Aggregator ID</th>
										<!-- <th>ID Type</th> -->
										<th>Owner Flex No</th>
										<!-- <th>Request Date</th> -->
										<th>Activation Date</th>
										<th>Status</th>
										<th>Alloted To</th>
										<th>Allotment Status</th>
										<th>Created At</th>
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

<div class="modal fade staticBackdrop fixed-left addRiderModal" id="addRiderModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="#addRiderModalLabel" style="display: none;" aria-hidden="true">
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
	if ($.fn.DataTable.isDataTable('#empTable')) {
		$('#empTable').DataTable().destroy();
	}

	$('#empTable').dataTable({
		"lengthMenu": [[25, 50, 100, 500], [25, 50, 100, 500]],
		//order: [[0, 'asc']],
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

		"responsive": true,
		"processing":true,
		"searching":false,
		"serverSide":true,
		"fixedHeader": true,
		"ajax":{
			url:"<?php echo base_url();?>admin/logistic-management/platform/ajax-list?alloted_to=<?php echo $this->input->get('alloted_to')?>&owner=<?php echo $this->input->get('owner')?>&r_from=<?php echo $this->input->get('r_from')?>&from=<?php echo $this->input->get('from')?>&to=<?php echo $this->input->get('to')?>&id_number=<?php echo $this->input->get('id_number')?>&platform=<?php echo $this->input->get('platform')?>&status=<?php echo $this->input->get('status')?>&allotment_status=<?php echo $this->input->get('allotment_status')?>&id_type=<?php echo $this->input->get('id_type')?>",
			type:"POST"
		},
		"columnDefs":[
			{
				"targets":[0,1,2,3,4,5,6,7,8,9,10,11,12],
				"orderable":false
			},
		],
	});
}

$(document).ready(function() {
	initializeDataTable();
});

function deleteAction() {
	var inputCount = $('[name="checklist[]"]:checked').length;
	if(inputCount > 0){
		if (confirm("Do you want to delete selected id(s)?") == true) {
			changeActionAndSubmit('admin/logistic-management/platform-id/delete');
		} else {
			userPreference = "Action Cancelled!";
		}
	}else{
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
			url: '<?php echo base_url('admin/logistic-management/platform-id/add'); ?>',
			type: 'GET',
			success: function(response) {
				$('#addRiderModal').modal('show');
				$('#addRiderModal .modal-content').html(response);
				// Reinitialize Select2 after content is loaded
					$('#addRiderModal .select2').select2({
						width: '100%',
						dropdownParent: $('#addRiderModal')
					});
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
		url: '<?php echo base_url('admin/logistic-management/platform-id/edit'); ?>',
		type: 'POST',
		data: {'id':id},
		dataType: 'json',
		success: function(response) {
			//console.log(response);
			$('#addRiderModal').modal('show');
			$('#addRiderModal .modal-content').html(response.output_html);
			$('#addRiderModal .select2').select2({
				width: '100%',
				dropdownParent: $('#addRiderModal')
			});
		},
		error: function(request, error) {
			console.log(" Can't do because: " + JSON.stringify(request));
			toastr.error('Error loading view.');
		}
	});
}

function detailModal(id) {
	$.ajax({
		url: '<?php echo base_url('admin/logistic-management/platform-id/detail'); ?>',
		type: 'POST',
		data: {'id':id},
		dataType: 'json',
		success: function(response) {
			//console.log(response);
			$('#addRiderModal').modal('show');
			$('#addRiderModal .modal-content').html(response.output_html);
		},
		error: function(request, error) {
			console.log(" Can't do because: " + JSON.stringify(request));
			toastr.error('Error loading view.');
		}
	});
}
</script>
<!-- Global AJAX Function for all filters -->
<script type="text/javascript">
	$('.select2-ajax').each(function() {
		var $this = $(this);
		var filterType = $this.data('filter-type');
		var selectedValue = $this.data('selected'); // Get selected value from data attribute

		$this.select2({
			placeholder: '[Any ' + filterType.charAt(0).toUpperCase() + filterType.slice(1) + ']',
			minimumInputLength: 2,
			ajax: {
				url: '<?php echo base_url('admin/logistic-management/platform-id/fetch-filter-data'); ?>',
				dataType: 'json',
				delay: 250,
				data: function(params) {
					return {
						query: params.term,
						filter_type: filterType
					};
				},
				processResults: function(data) {
					var results = $.map(data, function(item) {
						var textField = '';

						// Map the correct field based on filter type
						if (filterType === 'id_number') {
							textField = item.id_number;
						} else if (filterType === 'owner') {
							textField = item.full_name;
						} else if (filterType === 'alloted_to') {
							textField = item.full_name;
						}
						return {
							id: item.key_value,
							text: textField
						};
					});
					return {
						results: results
					};
				},
				cache: true
			}
		});

		// Ensure the selected value is retained after refresh
		var selectedValue = $this.data('selected');
		if (selectedValue) {
			$this.val(selectedValue).trigger('change');
		}
	});
</script>
