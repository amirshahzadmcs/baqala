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

	.dl-progress {
		margin: 0px auto;
		padding: 0;
		width: 100%;
		height: 14px;
		overflow: hidden;
		background: #e5e5e5;
		border-radius: 25px;
		cursor: pointer;
	}

	.dl-progress .bar {
		position: relative;
		float: left;
		min-width: 1%;
		height: 100%;
		background: cornflowerblue;
	}

	.dl-progress .percent {
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		margin: 0;
		font-size: 10px;
		color: white;
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

	.transaction-modal .modal-dialog-aside {
		width: 40%;
		max-width: 80%;
		height: 100%;
		margin: 0;
		transform: translate(0);
		transition: transform .2s;
	}

	.transaction-modal .modal-dialog-aside .modal-content {
		height: inherit;
		border: 0;
		border-radius: 0;
	}

	.transaction-modal .modal-dialog-aside .modal-content .modal-body {
		overflow-y: auto
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
</style>
<?php
	$keyword = $this->input->get('keyword');
	$from = $this->input->get('from');
	$to = $this->input->get('to');
	$transaction_from = $this->input->get('transaction_from');
	$transaction_to = $this->input->get('transaction_to');
	$trans_type = $this->input->get('trans_type');

	$query = "?keyword=" . urlencode($keyword)
		. "&from=" . urlencode($from)
		. "&to=" . urlencode($to)
		. "&transaction_from=" . urlencode($transaction_from)
		. "&transaction_to=" . urlencode($transaction_to);

	if (!empty($trans_type) && is_array($trans_type)) {
		foreach ($trans_type as $type) {
			$query .= "&trans_type[]=" . urlencode($type);
		}
	}
?>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>DL Request</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if(check_action_permission(get_user_role(), 'dl_request', 'delete')):?>
					<button type="button" class="btn btn-custom-danger btn-sm pull-right mr-2" onclick="deleteAction()" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					<?php endif; if(check_action_permission(get_user_role(), 'dl_request', 'save')):?>
					<!--
					<button class="btn btn-custom-success btn-sm pull-right ms-2" title="Add DL Request" data-bs-toggle="modal" data-bs-target="#dlRequestModal"><i class="fa fa-plus"></i> Add DL Request</button>
					-->
					<div class="btn-group ms-2 float-end">
						<button class="btn btn-custom-white btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fas fa-file-excel"></i> Export to Excel <i class="mdi mdi-chevron-down"></i>
						</button>
						<div class="dropdown-menu dropdown-menu-end" style="margin: 0px;">
							<a class="dropdown-item" title="Export All" href="<?php echo base_url('admin/dl-request/export-excel' . $query); ?>" target="_blank">
								<i class="ti-import me-2"></i> Export All
							</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" type="button" title="Export Selected" onclick="exportSelected()">
								<i class="fa fa-check-square me-2"></i> Export Selected
							</a>
						</div>
					</div>
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
						<form action="<?php echo base_url('admin/dl-request/list'); ?>" method="get" id="filter_form">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Search by Employee Name or Employee No.</label>
										<input type="search" id="keyword" name="keyword" placeholder="Search by Employee Name or Employee No." value="<?php echo $this->input->get('keyword') ? $this->input->get('keyword') : ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>

								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label for="trans_type">Appointment Type</label>
										<?php 
										$selected_types = (array) $this->input->get('trans_type'); 
										?>
										<select name="trans_type[]" id="trans_type" class="form-select select2" multiple="true" data-placeholder="[ All Type ]">
											<option value="">[ All Type ]</option>
											<option value="10" <?php echo in_array('10', $selected_types) ? 'selected' : ''; ?>>DL Requested</option>
											<option value="0"  <?php echo in_array('0', $selected_types)  ? 'selected' : ''; ?>>DL Appointment</option>
											<option value="1"  <?php echo in_array('1', $selected_types)  ? 'selected' : ''; ?>>DL File</option>
											<option value="2"  <?php echo in_array('2', $selected_types)  ? 'selected' : ''; ?>>DL Class 1</option>
											<option value="3"  <?php echo in_array('3', $selected_types)  ? 'selected' : ''; ?>>DL Class 2</option>
											<option value="4"  <?php echo in_array('4', $selected_types)  ? 'selected' : ''; ?>>DL Computer Exam</option>
											<option value="5"  <?php echo in_array('5', $selected_types)  ? 'selected' : ''; ?>>DL Final Test</option>
											<option value="6"  <?php echo in_array('6', $selected_types)  ? 'selected' : ''; ?>>DL Repeat Exam</option>
											<option value="7"  <?php echo in_array('7', $selected_types)  ? 'selected' : ''; ?>>DL Medical</option>
											<option value="8"  <?php echo in_array('8', $selected_types)  ? 'selected' : ''; ?>>DL Basma</option>
											<option value="9"  <?php echo in_array('9', $selected_types)  ? 'selected' : ''; ?>>DL Issued</option>
										</select>
									</div>
								</div>

								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Transaction Date Between (From and To)</label>
										<div class="input-daterange input-group" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
											<input type="text" class="form-control" id="transaction_from" name="transaction_from" value="<?php echo $this->input->get('transaction_from') ? $this->input->get('transaction_from') : ''; ?>" autocomplete="off" placeholder="Start Date" />
											<input type="text" class="form-control" id="transaction_to" name="transaction_to" value="<?php echo $this->input->get('transaction_to') ? $this->input->get('transaction_to') : ''; ?>" autocomplete="off" placeholder="End Date" />
										</div>
									</div>
								</div>
							</div>
							<?php
								$adv_show = false;
								if(!empty($this->input->get('from'))){
									$adv_show = true;
								}
								if(!empty($this->input->get('to'))){
									$adv_show = true;
								}
							?>
							<div class="collapse <?php if($adv_show){ echo ' show';}?>" id="advanceFilter">
								<div class="row">
									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label>Request Date Between (From and To)</label>
											<div class="input-daterange input-group" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
												<input type="text" class="form-control" id="from" name="from" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" autocomplete="off" placeholder="Start Date" />
												<input type="text" class="form-control" id="to" name="to" value="<?php echo $this->input->get('to') ? $this->input->get('to') : ''; ?>" autocomplete="off" placeholder="End Date" />
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
									<a href="<?php echo base_url('admin/dl-request/list'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
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
							<table id="dlTable" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%;white-space: nowrap;">
								<thead>
									<tr>
										<th>#</th>
										<th>S.No.</th>
										<th>Req. No.</th>
										<th>Emp ID</th>
										<th>Emp Name</th>
										<th>Iqama No</th>
										<th>Profession</th>
										<th>Mobile No</th>
										<th>DL Type</th>
										<th>DL Trans. Status</th>
										<th>DL Trans. Date</th>
										<th>Employer</th>
										<th>Blood Group</th>
										<th>Request Date</th>
										<!-- <th>Nationality</th>
										<th>Department</th>
										<th>Created At</th> -->
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

<?php $this->load->view('admin/home/footer'); ?>

<!-- Modal -->
<div class="modal fade fixed-left transaction-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0">Appointment Status</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="statusResponse"></div>
			</div>
			<div class="modal-footer" id="statusModalFooter">
				
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade fixed-left dlRequestModal" id="dlRequestModal" aria-labelledby="#dlRequestModalModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0" id="dlRequestModalModalLabel">Add DL Request</h5>
				<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row size-inner-section px-2 py-4 mx-1">
					<form id="searchForm">
						<div class="form-group">
							<label for="password">Search by Employee ID <span class="text-danger">*</span></label>
							<div class="input-group">
								<input type="text" class="form-control" placeholder="Employee ID" aria-label="Employee Number" name="search_employee" id="search_employee" aria-describedby="button-addon2">
								<button class="btn btn-success border-success" form="searchForm" type="submit" id="">Search</button>
								<!-- <button class="btn btn-danger border-danger reset-button" type="reset" id="">Reset</button> -->
							</div>
						</div>
					</form>
					<div id="searchResponse"></div>
				</div>
				<div id="responseContainer"></div>
				<div id="searchResult" class="mt-4">

				</div>
			</div>
			<div class="modal-footer" id="searchModalFooter">
				
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade fixed-left dlRequestModal2" id="dlRequestModal2" aria-labelledby="#dlRequestModalModalLabel2" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0" id="dlRequestModalModalLabel2">Edit DL Request</h5>
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

<?php
$base_url = base_url('admin/dl-request/ajax-list');
?>

<script>
	$(document).ready(function() {
		$('.dropify').dropify();

		function initializeDataTable() {
			if ($.fn.DataTable.isDataTable('#dlTable')) {
				$('#dlTable').DataTable().destroy();
			}

			$('#dlTable').dataTable({
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
				"searching": false,
				"ajax": {
					url: "<?php echo $base_url . $query; ?>",
					type: "POST"
				},
				"columnDefs": [{
					"targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
					"orderable": false
				}, ],
			});
		}

		$(document).ready(function() {
			initializeDataTable();
		});
	});

	function deleteAction() {
		var inputCount = $('[name="checklist[]"]:checked').length;
		if (inputCount > 0) {
			if (confirm("Do you want to delete selected DL request?") == true) {
				changeActionAndSubmit('admin/dl-request/delete');
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

	function updateStatus(req_id) {
		if (req_id > 0) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('admin/dl-request/transaction-form'); ?>",
				data: {
					'request_id': req_id,
				},
				dataType: "json",
				success: function(response) {
					if (response.type === 'success') {
						$('.transaction-modal').modal('show');
						$('.transaction-modal .modal-body').html(response.output_html);
						$('#statusModalFooter').html(`<button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button><button type="submit" form="dl_form" class="btn btn-success">Save</button>`);
					} else {
						$('#statusResponse').html('<p class="text-danger mb-0 mt-2">' + response.message + '</p>');
					}
				},
				error: function(request, error) {
					console.log(" Can't do because: " + JSON.stringify(request));
					$('.transaction-modal .modal-body').after(JSON.stringify(request));
				},
			});
		} else {
			$('#statusResponse').html('<p class="text-danger mb-0 mt-2">Invalid request id!</p>');
		}
	}

	function editRequest(req_id) {
		if (req_id > 0) {
			$.ajax({
				url: "<?php echo base_url('admin/dl-request/edit');?>",
				type: 'POST',
				data: {
					'id': req_id,
				},
				dataType: 'json',
				success: function(response) {
					if (response.type === 'success') {
						$('.dlRequestModal2').modal('show');
						$('#responseContainer2').html('<p class="text-success mb-0 mt-2">' + response.message + '</p>');
						$('#searchResult2').html(response.output_html);
						$('#searchModalFooter2').html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetModalData()">Cancel</button>
				<button type="submit" form="dlRequestForm" class="btn btn-custom-success">Submit</button>`);
					} else {
						$('#responseContainer2').html('<p class="text-danger mb-0 mt-2">' + response.message + '</p>');
					}
				},
				error: function() {
					$('#responseContainer2').html('<p class="text-danger mb-0 mt-2">An error occurred. Please try again.</p>');
				}
			});
		} else {
			$('#responseContainer2').html('<p class="text-danger mb-0 mt-2">Invalid request id!</p>');
		}
	}
	
	function editTransaction(req_id) {
		if (req_id > 0) {
			$.ajax({
				url: "<?php echo base_url('admin/dl-request/edit-transaction');?>",
				type: 'POST',
				data: {
					'request_id': req_id,
				},
				dataType: 'json',
				success: function(response) {
					if (response.type === 'success') {
						$('#dlRequestModalModalLabel2').html('Update Transaction Amount');
						$('.dlRequestModal2').modal('show');
						toastr.success(response.message);
						$('#searchResult2').html(response.output_html);
					} else {
						toastr.error(response.message);
					}
				},
				error: function() {
					toastr.error('An error occurred. Please try again.');
				}
			});
		} else {
			toastr.error('Invalid request id!');
		}
	}

	$(document).ready(function() {
		$('#searchForm').submit(function(e) {
			e.preventDefault();
			// Serialize the form data
			$('#responseContainer').html('');
			var formData = $('#searchForm').serialize();
			$.ajax({
				url: "<?php echo base_url('admin/dl-request/search');?>",
				type: 'POST',
				data: formData,
				dataType: 'json',
				success: function(response) {
					if (response.type === 'success') {
						$('#searchResponse').html('<p class="text-success mb-0 mt-2">' + response.message + '</p>');
						$('#searchResult').html(response.output_html);
						$('#searchModalFooter').html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetModalData()">Cancel</button>
				<button type="submit" form="dlRequestForm" class="btn btn-custom-success">Submit</button>`);
					} else {
						$('#searchResponse').html('<p class="text-danger mb-0 mt-2">' + response.message + '</p>');
					}
				},
				error: function() {
					$('#searchResponse').html('<p class="text-danger mb-0 mt-2">An error occurred. Please try again.</p>');
				}
			});
		});
	});

	$(".modal-close").click(function(){
		resetModalData();
    });
	
	function resetModalData(){
		$('#searchResult').html('');
		$('#searchModalFooter').html('');
		$('#searchResponse').html('');
		$('#responseContainer').html('');
	}
	
	function exportSelected() {
		var selected = [];
		$('input[name="checklist[]"]:checked').each(function () {
			selected.push($(this).val());
		});

		if (selected.length === 0) {
			alert("Please select at least one record to export.");
			return;
		}

		// Get current filters from the search form
		var filters = $('#filter_form').serialize();

		// Build query string
		var query = filters + '&selected_ids=' + selected.join(',');

		// Redirect to export with filters + selected IDs
		window.open('<?php echo base_url('admin/dl-request/export-excel'); ?>?' + query, '_blank');
	}
	
</script>
