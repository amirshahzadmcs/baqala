<?php $this->load->view('admin/home/header'); ?>
<style>
	.dataTables_wrapper::-webkit-scrollbar {
		display: none;
	}

	.nav-md .container.body .right_col {
		padding: 10px 10px 0;
		margin-left: 230px;
	}

	#order_info p {
		margin-top: 0;
		font-size: 13px;
		margin-bottom: 0rem;
		font-weight: 200;
	}

	#disp_info p {
		margin-top: 0;
		font-size: 13px;
		margin-bottom: 0rem;
		font-weight: 200;
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

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Dispute Management</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/disputes/list'); ?>">Disputes</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if (check_action_permission(get_user_role(), 'dispute_list', 'delete')): ?>
						<button type="button" class="btn btn-custom-danger btn-sm pull-right mr-2" onclick="deleteAction()" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					<?php endif;
					if (check_action_permission(get_user_role(), 'dispute_list', 'add_dispute')): ?>
						<button class="btn btn-custom-success btn-sm pull-right ms-2" title="Add New Disputes" data-bs-toggle="modal" data-bs-target=".add-invoice-modal"><i class="fa fa-plus"></i> Add New Dispute</button>
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
						<form action="<?php echo base_url('admin/disputes/list'); ?>" method="get" id="filter_form">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Search by Driver's ID or Driver Name</label>
										<input type="search" id="keyword" name="keyword" placeholder="Search by Driver’s ID or Driver Name" value="<?php echo $this->input->get('keyword') ? $this->input->get('keyword') : ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Reference Number</label>
										<input type="search" id="ref_no" name="ref_no" placeholder="Search Reference Number" value="<?php echo $this->input->get('ref_no') ? $this->input->get('ref_no') : ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>
								<div class="form-group col-lg-4 col-sm-6 mb-3">
									<label for="status">Status</label>
									<select name="status" class="form-control select2">
										<option value="">[Any]</option>
										<option value="0" <?php echo $this->input->get('status') == '0' ? ' selected ' : '' ?>>Open</option>
										<option value="1" <?php echo $this->input->get('status') == '1' ? ' selected ' : '' ?>>Resolved & Refunded</option>
										<option value="2" <?php echo $this->input->get('status') == '2' ? ' selected ' : '' ?>>Resolved with Penalty</option>
									</select>
								</div>
							</div>

							<?php
							$adv_show = false;
							if (!empty($this->input->get('period_start')) || !empty($this->input->get('period_end'))) {
								$adv_show = true;
							}
							?>
							<div class="collapse <?php if ($adv_show) {
														echo ' show';
													} ?>" id="advanceFilter">
								<div class="row">
									<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
										<label for="date_range">Dispute Between Date: <span class="text-danger">*</span></label>
										<div class="input-daterange input-group" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#datepicker6">
											<input type="text" class="form-control" name="start_date" placeholder="Start Date" value="<?php echo $this->input->get('period_start'); ?>" autocomplete="off">
											<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
											<input type="text" class="form-control" name="end_date" placeholder="End Date" value="<?php echo $this->input->get('period_end'); ?>" autocomplete="off">
											<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
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
									<a href="<?php echo base_url('admin/disputes/list'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
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
							<table id="disputeTable" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
								<thead>
									<tr>
										<th>#</th>
										<th>S.No.</th>
										<th>Driver’s ID</th>
										<th>Driver's Username</th>
										<th>Reference ID</th>
										<th>Rider Name</th>
										<th>Dispute Type</th>
										<th>Dispatch Time</th>
										<th>Debit Amount</th>
										<th>Status</th>
										<th>Approver Status</th>
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

<!-- Modal -->
<div class="modal fade staticBackdrop fixed-left add-invoice-modal" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0">Add New Disputes</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<?php echo form_open("admin/disputes/add", array("id" => "disputeForm", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
				<input type="hidden" id="id" name="id" value="" />

				<div class="row">
					<div class="col-md-12 col-sm-12 mb-3 form-group">
						<label for="ref_id">Reference ID <span class="text-danger">*</span></label>
						<select name="ref_id" id="ref_id" class="form-control select2" required="required">
							<option value="">Search Reference ID</option>
						</select>
						<small class="hint ref-msg"></small>
					</div>
					<div class="col-md-12 col-sm-12 mb-3 form-group">
						<label for="dispute_type">Dispute Type <span class="text-danger">*</span></label>
						<select name="dispute_type" class="form-select select2" id="dispute_type" required>
							<option value=""> Select Dispute Type </option>
							<?php foreach ($dispute_types as $dtype) { ?>
								<option value="<?php echo $dtype->id; ?>"><?php echo $dtype->dispute_type_en; ?></option>
							<?php } ?>
						</select>
					</div>

					<!-- <div class="col-md-6 col-sm-12 mb-3 form-group">
						<label for="debit_amount">Driver Debit Amount</label>
						<input id="debit_amount" name="debit_amount" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" inputmode="numeric" style="text-align: right;">
						</div> -->
					<div class="col-md-12 col-sm-12 mb-3 form-group">
						<label for="attachment">Attach File</label>
						<input type="file" class="form-control" id="attachment" name="attachment" />
					</div>
					<div class="col-md-12 col-sm-12 mb-3 form-group">
						<label for="explanations">Explanations <span class="text-danger">*</span></label>
						<textarea id="explanations" name="explanations" class="form-control" rows="6" required></textarea>
					</div>
				</div>
				<?php echo form_close(); ?>
				<div class="row modal-info d-none">
					<hr>
					<div class="col-md-12" id="order_info"></div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" id="cancelBtn" class="btn-close" data-bs-dismiss="modal">Close</button>
				<button type="submit" form="disputeForm" id="disputeSubmit" class="btn btn-success" disabled>Submit</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade staticBackdrop fixed-left dispute-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0">Update Status</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<?php echo form_open("admin/disputes/update-status", array("id" => "statusForm", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
					<input type="hidden" id="dispute_id" name="dispute_id" value="" required />
					<div class="row">
						<div id="disp_info">

						</div>
						<div>
							<div class="card-header pb-1"><h6>Fill detail below:</h6></div>
							<div class="size-inner-section card-body">
								<div class="col-md-12 col-sm-12 mb-3">
									<div class="form-group">
										<label for="status_updated_date">Date <span class="text-danger">*</span></label>
										<input type="date" class="form-control" name="status_updated_date" id="status_updated_date" value="<?php echo date('Y-m-d'); ?>" required>
									</div>
								</div>

								<div class="col-md-12 col-sm-12 mb-3">
									<div class="form-group">
										<label for="dispute_status">Dispute Status <span class="text-danger">*</span></label>
										<select name="dispute_status" class="form-select" id="dispute_status" required>
											<option value=""> Select Dispute Status </option>
											<option value="1">Approved</option>
											<option value="2">Rejected</option>
											<option value="3">Partial Approved</option>
										</select>
									</div>
								</div>

								<div class="col-md-12 col-sm-12 mb-3" id="approved_amount_container" style="display:none;">
									<div class="form-group">
										<label for="approved_amount">Approved Amount <span class="text-danger">*</span></label>
										<input type="number" class="form-control" name="approved_amount" id="approved_amount" min="0" step="0.01">
									</div>
								</div>

							</div>
						</div>
					</div>
				<?php echo form_close(); ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" id="statusCancel" class="btn-close" data-bs-dismiss="modal">Close</button>
				<button type="submit" form="statusForm" id="statusSubmit" class="btn btn-success" disabled>Submit for Approval</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this->load->view('admin/home/footer'); ?>
<script>
	$(document).ready(function() {
		$('#disputeTable').dataTable({
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
			"searching": false,
			"fixedHeader": true,
			"ajax": {
				url: "<?php echo base_url(); ?>admin/disputes/ajax-list?keyword=<?php echo $this->input->get('keyword') ?>&ref_no=<?php echo $this->input->get('ref_no') ?>&status=<?php echo $this->input->get('status') ?>&period_start=<?php echo $this->input->get('period_start') ?>&period_end=<?php echo $this->input->get('period_end') ?>",
				type: "POST"
			},
			"columnDefs": [{
				"targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
				"orderable": false
			}, ],
		});
	});

	function deleteAction() {
		var inputCount = $('[name="checklist[]"]:checked').length;
		if (inputCount > 0) {
			if (confirm("Do you want to delete selected disputes?") == true) {
				changeActionAndSubmit('admin/disputes/delete');
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

	$(document).ready(function() {
		$('#ref_id').select2({
			placeholder: 'Search Reference ID',
			minimumInputLength: 2,
			ajax: {
				url: "<?php echo base_url('admin/Disputes/reference_list');?>",
				type: 'POST',
				dataType: 'json',
				delay: 250,
				data: function (params) {
					return {
						search: params.term
					};
				},
				processResults: function (data) {
					return {
						results: $.map(data, function (item) {
							return {
								id: item.ref_id,
								text: item.ref_id + ' - ' + item.employee_name
							};
						})
					};
				},
				cache: true
			}
		});
	});

	$(document).ready(function () {
		$('#disputeForm').submit(function (e) {
			e.preventDefault();
			var formData = new FormData($(this)[0]);

			// Disable buttons
			$('#cancelBtn, #disputeSubmit').prop('disabled', true);
			$.ajax({
				url: '<?php echo base_url('admin/disputes/add'); ?>',
				type: 'POST',
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				success: function (response) {
					if (response.type === 'success') {
						toastr.success(response.message);
						setTimeout(function () {
							window.location.href = "<?php echo base_url('admin/disputes/list'); ?>";
						}, 1000);
					} else {
						toastr.error(response.message);
					}
					$('#cancelBtn, #disputeSubmit').prop('disabled', false);
				},
				error: function () {
					toastr.error('An error occurred. Please try again.');
					$('#cancelBtn, #disputeSubmit').prop('disabled', false);
				}
			});
		});
	});

	$('#ref_id').change(function() {
		var ref_id = $('#ref_id').val();
		
		$.ajax({
			url: "<?php echo base_url('admin/Disputes/get_summary_detail');?>",
			type: 'POST',
			data: {
				id: ref_id,
			},
			dataType: 'json',
			success: function(data) {
				//console.log(data.msg);
				$('.modal-info').removeClass('d-none');
				if (data.status == 'success') {
					$('#disputeSubmit').prop('disabled', false);
					$("#order_info").html('<div class="size-inner-section"><div class="card-header pb-1"><h6>Order Detail:</h6></div><div class="card-body"><p>' + data.msg + '<p><strong>Driver’s ID : </strong>' + data.order_detail.driver_id + '</p><p><strong>Drivers User Name : </strong>' + data.order_detail.driver_username + '</p><p><strong>Reference ID : </strong>' + data.order_detail.ref_id + '</p><p><strong>Dispatch Time : </strong>' + data.order_detail.dispatch_time + '</p><p><strong>Drivers Debit Amount : </strong>' + data.order_detail.driver_debit_amt + '</p></div></div><div class="size-inner-section"><div class="card-header pb-1"><h6>Rider Details:</h6></div><div class="card-body"><p><strong>Emp No. : </strong>' + data.order_detail.emp_no + '</p><p><strong>Rider Name : </strong>' + data.order_detail.employee_name + '</p><p><strong>Rider Mobile : </strong>' + data.order_detail.mobile + '</p><p><strong>Rider Iqama No : </strong>' + data.order_detail.iqama_no + '</p><p><strong>Vehicle No : </strong>' + data.order_detail.vehicle_no +'('+ data.order_detail.vehicle_type +')' + '</p></div></div>');
				} else {

					$("#order_info").html(data.msg);
					return false;
				}
			},
			error: function(response) {
				//console.log(response);
				$("#order_info").html(data.msg);
				return false;
			},
		});
	});

	function statusPopup(identifier) {
		let dispute_id = $(identifier).data('id');
		let base_url = '<?php echo base_url();?>';
		$('.dispute-modal #dispute_id').val('');
		$('.dispute-modal #disp_info').html('<p>Loading...</p>');

		if (dispute_id > 0) {
			$.ajax({
				url: "<?php echo base_url('admin/Disputes/disputeDetail/');?>" + dispute_id,
				method: "GET",
				dataType: "json",
				success: function (response) {
					if (response.status === 'success') {
						let d = response.order_detail;
						$('#dispute_id').val(d.id);
						$('.dispute-modal #disp_info').html(
							'<div class="size-inner-section"><div class="card-header pb-1"><h6>Order Detail:</h6></div><div class="card-body">' +
							'<p><strong>Driver’s ID:</strong> ' + d.driver_id + '</p>' +
							'<p><strong>Driver Username:</strong> ' + d.driver_username + '</p>' +
							'<p><strong>Reference ID:</strong> ' + d.ref_id + '</p>' +
							'<p><strong>Dispatch Date:</strong> ' + d.dispatch_date + '</p>' +
							'<p><strong>Dispute Type:</strong> ' + d.dispute_type_en + '</p>' +
							'<p><strong>Driver Debit Amount:</strong> ' + d.debit_amount + '</p>' +
							'<p><strong>Explanation:</strong> ' + d.explanations + '</p>' +
							(d.attach_file 
								? '<p><strong>Attachment:</strong> <a href="' + base_url + d.attach_file + '" target="_blank">View File</a></p>'
								: ''
							) +
							'</div></div><div class="size-inner-section"><div class="card-header pb-1"><h6>Rider Details:</h6></div><div class="card-body">' +
							'<p><strong>Emp No.:</strong> ' + d.emp_no + '</p>' +
							'<p><strong>Rider Name:</strong> ' + d.employee_name + '</p>' +
							'<p><strong>Rider Mobile:</strong> ' + d.mobile + '</p>' +
							'<p><strong>Rider Iqama No.:</strong> ' + d.iqama_no + '</p>' +
							'<p><strong>Vehicle No.:</strong> ' + d.vehicle_no +'('+ d.vehicle_type +')</p></div></div>'
						);
					} else {
						$('.dispute-modal #disp_info').html(`<p style="color:red;">${response.msg}</p>`);
					}
				},
				error: function () {
					$('.dispute-modal #disp_info').html('<p style="color:red;">Failed to load data.</p>');
				}
			});

			$('.dispute-modal').modal('show');
		} else {
			alert('Invalid request id!');
		}
	}

	$(document).ready(function () {
		$('#dispute_status').on('change', function () {
			const status = $(this).val();
			$('#statusSubmit').prop('disabled', false);
			if (status === '3') {
				$('#approved_amount_container').slideDown();
				$('#approved_amount').attr('required', true);
			} else {
				$('#approved_amount_container').slideUp();
				$('#approved_amount').removeAttr('required').val('');
			}
		});
	});

	$(document).ready(function () {
		$('#statusForm').submit(function (e) {
			e.preventDefault();
			var formData = new FormData($(this)[0]);

			// Disable buttons
			$('#statusCancel, #statusSubmit').prop('disabled', true);
			$.ajax({
				url: '<?php echo base_url('admin/disputes/update-status'); ?>',
				type: 'POST',
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				success: function (response) {
					if (response.type === 'success') {
						toastr.success(response.message);
						setTimeout(function () {
							window.location.href = "<?php echo base_url('admin/disputes/list'); ?>";
						}, 1000);
					} else {
						toastr.error(response.message);
					}
					$('#statusCancel, #statusSubmit').prop('disabled', false);
				},
				error: function () {
					toastr.error('An error occurred. Please try again.');
					$('#statusCancel, #statusSubmit').prop('disabled', false);
				}
			});
		});
	});
</script>
