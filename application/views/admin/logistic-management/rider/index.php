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
		width: 40%;
		max-width: 80%;
		height: 100%;
		margin: 0;
		transform: translate(0);
		transition: transform .2s;
	}

	.filtersModal .modal-dialog-aside {
		width: 30%;
		max-width: 100%;
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
	.select2-container .select2-selection--single .select2-selection__rendered {
    	padding-right: 35px;
	}
</style>


<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Logistic Management</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/logistic-management/rider/list'); ?>">Rider Profile</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if(check_action_permission(get_user_role(),'rider_profile','delete')):?>
					<button type="button" class="btn btn-custom-danger btn-sm pull-right me-2" onclick="deleteAction()" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					<?php endif; if(check_action_permission(get_user_role(),'rider_profile','add')):?>
					<button class="btn btn-custom-success btn-sm pull-right me-2" title="New Employee" id="load_add_modal"><i class="fa fa-plus"></i> New Profile</button>
					<?php endif; if(check_action_permission(get_user_role(),'rider_profile','riderExport')):?>
						<div class="btn-group ms-2 float-end">
							<button class="btn btn-custom-white btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="ti-export"></i> Export <i class="mdi mdi-chevron-down"></i>
							</button>
							<div class="dropdown-menu dropdown-menu-end">
								<h6 class="dropdown-header">EXPORT AS</h6>
								<a class="dropdown-item" href="<?php echo base_url();?>admin/logistic-management/rider/export-excel?keyword=<?php echo $this->input->get('keyword')?>&vehicle_no=<?php echo $this->input->get('vehicle_no')?>&id_number=<?php echo $this->input->get('id_number')?>&from=<?php echo $this->input->get('from')?>&to=<?php echo $this->input->get('to')?>&rider_status=<?php echo $this->input->get('rider_status')?>&platform=<?php echo $this->input->get('platform')?>&housing=<?php echo $this->input->get('housing')?>&team=<?php echo $this->input->get('team')?>" class="btn btn-custom-white btn-sm pull-right me-2" target="_blank" title="Export Rider Excel">Export Riders</a>
								<div class="dropdown-divider"></div>
								<a type="button" class="dropdown-item" data-export_modal="delivery_report" data-bs-toggle="modal" data-bs-target=".filtersModal" title="Delivery Report">Delivery Report</a>
							</div>
						</div>
					<?php endif;?>
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
						<form action="<?php echo base_url('admin/logistic-management/rider/list'); ?>" method="get" id="filter_form">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Search by Employee Name or Employee No.</label>
										<input type="search" id="keyword" name="keyword" placeholder="Search by Employee Name or Employee No." value="<?php echo $this->input->get('keyword') ? $this->input->get('keyword') : ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>
								
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>ID Number</label>
										<input type="search" name="id_number" placeholder="Search ID Number" value="<?php echo $this->input->get('id_number') ? $this->input->get('id_number') : ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>
									
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Vehicle Number</label>
										<input type="search" id="vehicle_no" name="vehicle_no" placeholder="Search Vehicle Number" value="<?php echo $this->input->get('vehicle_no') ? $this->input->get('vehicle_no') : ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>
							</div>
							<?php
								$adv_show = false;
								if(!empty($this->input->get('id_number'))){
									$adv_show = true;
								}
								if(!empty($this->input->get('rider_status'))){
									$adv_show = true;
								}
								if(!empty($this->input->get('platform'))){
									$adv_show = true;
								}
								if(!empty($this->input->get('housing'))){
									$adv_show = true;
								}
								if(!empty($this->input->get('team'))){
									$adv_show = true;
								}
								if(!empty($this->input->get('from'))){
									$adv_show = true;
								}
								if(!empty($this->input->get('to'))){
									$adv_show = true;
								}
								if(!empty($this->input->get('employer'))){
									$adv_show = true;
								}
							?>
							<div class="collapse <?php if($adv_show){ echo ' show';}?>" id="advanceFilter">
								<div class="row">
									
									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label>Status</label>
											<select name="rider_status" class="form-select">
												<option value="">[ All Status]</option>
												<option value="active" <?php echo ($this->input->get('rider_status') == 'active') ? ' selected ' : '';?>>Active</option>
												<option value="inactive" <?php echo ($this->input->get('rider_status') == 'inactive') ? ' selected ' : '';?>>Inactive</option>
												<option value="requested" <?php echo ($this->input->get('rider_status') == 'requested') ? ' selected ' : '';?>>Requested</option>
												<option value="suspend" <?php echo ($this->input->get('rider_status') == 'suspend') ? ' selected ' : '';?>>Suspend</option>
											</select>
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
									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label>Platform</label>
											<select name="platform" class="form-select">
												<option value="">[ All Platform]</option>
												<?php foreach(fdCompanyHelper() as $fdcompany) { ?>
													<option value="<?php echo $fdcompany->id; ?>" <?php echo ($fdcompany->id == $this->input->get('platform')) ? ' selected ' : '';?>><?php echo $fdcompany->company_name; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label>Employer</label>
											<select name="employer" class="form-select">
												<option value="">[ All Employer]</option>
												<?php foreach(sponsorsHelper() as $employer) { ?>
													<option value="<?php echo $employer['id']; ?>" <?php echo ($employer['id'] == $this->input->get('employer')) ? ' selected ' : '';?>><?php echo $employer['employer_name']; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label>Housing</label>
											<select name="housing" class="form-select">
												<option value="">[ All Housing Status]</option>
												<?php foreach(masterCampHelper() as $mcamp) { ?>
													<option value="<?php echo $mcamp->id; ?>" <?php echo ($mcamp->id == $this->input->get('housing')) ? ' selected ' : '';?>><?php echo $mcamp->camp_name; ?></option>
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
								</div>
							</div>
							
							<div class="row mt-2">
								<div class="col-lg-6 col-md-6 col-sm-12">
									<button class="btn btn-outline-secondary waves-effect waves-light" type="button" data-bs-toggle="collapse" data-bs-target="#advanceFilter" aria-expanded="false" aria-controls="advanceFilter"><i class="fas fa-sliders-h"></i> Advance Search</button>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12">
									<button type="submit" class="btn btn-success btn-md float-end ms-2">Apply Filter</button>
									<a href="<?php echo base_url('admin/logistic-management/rider/list'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
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
										<th>Emp No.</th>
										<th>Employee Name</th>
										<th>Flex No</th>
										<th style="width: 95px;">Vehicle_No</th>
										<th>Team Name</th>
										<th>Platform</th>
										<th>ID Type</th>
										<th>ID Number</th>
										<th>Housing</th>
										<th>Target</th>
										<th>Status</th>
										<th>Allotment Status</th>
										<th>Allotment Date</th>
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

<div class="modal fade staticBackdrop fixed-left filtersModal" id="filtersModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="#filtersModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title px-3" id="filtersModalLabel">Delivery Report</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="<?= base_url('admin/logistic-management/rider/print-overall-deliv-report'); ?>" method="get" id="applyFiltersBtn" target="_blank">
					<div class="row">
						<div class="col-md-12 mb-3">
							<label for="reportrange">Select Date Range</label>
							<div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
								<i class="fa fa-calendar"></i>&nbsp;
								<span></span> <i class="fa fa-caret-down"></i>
							</div>

							<!-- Hidden inputs to submit selected range -->
							<input type="hidden" name="date_from" id="dateFrom" required>
							<input type="hidden" name="date_to" id="dateTo" required>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-3">
								<label>Search by Emp. Name or Emp. No.</label>
								<select class="form-control" class="form-control" placeholder="Search by Emp. Name or Emp. ID" aria-label="Employee Number" name="search_employee" id="search_employee" aria-describedby="button-addon2">
									<option value="">Search...</option>
								</select>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<a href="<?php echo base_url('admin/logistic-management/rider/list'); ?>" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</a>
				<button type="submit" form="applyFiltersBtn" class="btn btn-custom-success">Print Report</button>
			</div>
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
			url:"<?php echo base_url();?>admin/logistic-management/rider/ajax-list?keyword=<?php echo $this->input->get('keyword')?>&vehicle_no=<?php echo $this->input->get('vehicle_no')?>&id_number=<?php echo $this->input->get('id_number')?>&from=<?php echo $this->input->get('from')?>&to=<?php echo $this->input->get('to')?>&rider_status=<?php echo $this->input->get('rider_status')?>&platform=<?php echo $this->input->get('platform')?>&employer=<?php echo $this->input->get('employer')?>&housing=<?php echo $this->input->get('housing')?>&team=<?php echo $this->input->get('team')?>",
			type:"POST"
		},
		"columnDefs":[
			{
			 "targets":[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16],
			 "orderable":false
			},
		],
		"createdRow": function (row, data, dataIndex) {
            var status = data[12]; // Adjust index as needed

            if (status === 'Terminated' || status === 'Resigned' || status === 'Absconded' || status === 'Final Exit') {
                $(row).css('opacity', '0.5'); // Set opacity to 50%

                // Create and append status overlay
                var statusOverlay = $('<div class="status-overlay">Status: ' + status + '</div>');
                $(row).append(statusOverlay);

                // Add class to disable row interaction
                $(row).addClass('disabled-row');
            }
        }
	});
}

$(document).ready(function() {
	initializeDataTable();
	
	$('#search_employee').select2({
		placeholder: 'Search...',
		allowClear: true,
		minimumInputLength: 3,
		ajax: {
			url: "<?php echo base_url('admin/logistic-management/cash-collection/emp-list'); ?>",
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
});

function deleteAction() {
	var inputCount = $('[name="checklist[]"]:checked').length;
	if(inputCount > 0){
		if (confirm("Do you want to delete selected rider?") == true) {
			changeActionAndSubmit('admin/logistic-management/rider/delete');
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
			url: '<?php echo base_url('admin/logistic-management/rider/add'); ?>',
			type: 'GET',
			success: function(response) {
				$('#addRiderModal').modal('show');
				$('#addRiderModal .modal-content').html(response);
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
		url: '<?php echo base_url('admin/logistic-management/rider/edit'); ?>',
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
			alert('Error loading view');
		}
	});
}

function detailModal(id) {
	$.ajax({
		url: '<?php echo base_url('admin/logistic-management/rider/detail'); ?>',
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
			alert('Error loading view');
		}
	});
}

function transferModal(id) {
	$.ajax({
		url: '<?php echo base_url('admin/logistic-management/rider/transfer'); ?>',
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
			alert('Error loading view');
		}
	});
}

function suspendModal(id) {
	$.ajax({
		url: '<?php echo base_url('admin/logistic-management/rider/suspend'); ?>',
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
			alert('Error loading view');
		}
	});
}

function swapModal(id) {
	$.ajax({
		url: '<?php echo base_url('admin/logistic-management/rider/unallot'); ?>',
		type: 'POST',
		data: {'id':id},
		dataType: 'json',
		success: function(response) {
			//console.log(response);
			$('#addRiderModal').modal('show');
			$('#addRiderModal .modal-content').html(response.output_html);
			$('#swap_rider').select2({
				width: '100%',
				placeholder: 'Select Rider',
				allowClear: true
			});
		},
		error: function(request, error) {
			console.log(" Can't do because: " + JSON.stringify(request));
			alert('Error loading view');
		}
	});
}

function allotModal(id) {
	$.ajax({
		url: '<?php echo base_url('admin/logistic-management/rider/allot'); ?>',
		type: 'POST',
		data: {'id':id},
		dataType: 'json',
		success: function(response) {
			//console.log(response);
			$('#addRiderModal').modal('show');
			$('#addRiderModal .modal-content').html(response.output_html);
			$('#swap_rider').select2({
				width: '100%',
				placeholder: 'Select Rider',
				allowClear: true
			});
		},
		error: function(request, error) {
			console.log(" Can't do because: " + JSON.stringify(request));
			alert('Error loading view');
		}
	});
}

$(".modal-close").click(function(){
	resetModalData();
});

function resetModalData(){
	$('#searchResult').html('');
	$('#searchModalFooter').html('');
	$('#searchResponse').html('');
	$('#responseContainer').html('');
}
</script>
<script type="text/javascript">
$(function() {
    // Default: last 30 days
    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        // Show the range in the UI
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

        // Set hidden input values for form submission
        $('#dateFrom').val(start.format('YYYY-MM-DD'));
        $('#dateTo').val(end.format('YYYY-MM-DD'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        autoUpdateInput: false, // we handle it manually in cb
        locale: {
            cancelLabel: 'Clear'
        },
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

    // Optional: Clear date range
    $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
        $(this).find('span').html('');
        $('#dateFrom').val('');
        $('#dateTo').val('');
    });
});
</script>
