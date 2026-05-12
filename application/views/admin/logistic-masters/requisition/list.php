<?php $this->load->view('admin/home/header'); ?>
<style>
	.dataTables_wrapper::-webkit-scrollbar {
		display: none;
	}

	.nav-md .container.body .right_col {
		padding: 10px 10px 0;
		margin-left: 230px;
	}

	input[type=text],
	input[type=select] {
		height: 38px !important;
	}
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>SP Requisition Master</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/spare-parts/requisition/list'); ?>">Requisition</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if (check_action_permission(get_user_role(), 'sp_requisition_master', 'delete')): ?>
						<button type="button" class="btn btn-custom-danger btn-sm pull-right me-1" onclick="deleteAction()"><i class="fa fa-trash"></i> Delete</button>
					<?php endif;
					if (check_action_permission(get_user_role(), 'sp_requisition_master', 'create_requisition')): ?>
						<button type="button" class="btn btn-custom-success btn-sm pull-right me-1" data-bs-toggle="modal" data-bs-target=".jobcard-modal"><i class="fa fa-plus"></i> ADD Requisition</button>
					<?php endif; ?>
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
					<?php } ?> <?php }
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
						<form action="<?php echo base_url('admin/spare-parts/requisition/list'); ?>" method="get" id="filter_form">
							<div class="row">

								<div class="col-4 px-1">
									<div class="form-group">
										<label>Requisition No</label>
										<input type="text" id="requisition_no" name="requisition_no" value="<?php echo $this->input->get('requisition_no') ? $this->input->get('requisition_no') : ''; ?>" class="form-control" maxlength="6" autocomplete="off">
									</div>
								</div>
								<div class="col-4 px-1">
									<div class="form-group mb-2">
										<label class="d-block">Requisition Type </label>
										<select style="height:410px;" name="requisition_type" class="form-control select2 w-100">
											<option value="">All Type</option>
											<option value="local" <?php if ($this->input->get('requisition_type') == 'local') {
																		echo 'selected';
																	} ?>>Local</option>
											<option value="international" <?php if ($this->input->get('requisition_type') == 'international') {
																				echo 'selected';
																			} ?>>International</option>
										</select>
									</div>
								</div>
								<div class="col-4 px-1">
									<div class="form-group mb-2">
										<label class="d-block">Requisition Status </label>
										<select style="height:410px;" name="status" class="form-control select2 w-100">
											<option value="">All Status</option>
											<option value="1" <?php if ($this->input->get('status') == '1') {
																	echo 'selected';
																} ?>>Open</option>
											<option value="2" <?php if ($this->input->get('status') == '2') {
																	echo 'selected';
																} ?>>Closed</option>
										</select>
									</div>
								</div>
								<?php
								$adv_show = false;
								if (!empty($this->input->get('from')) || !empty($this->input->get('to'))) {
									$adv_show = true;
								}
								?>
								<div class="collapse <?php if ($adv_show) {
															echo ' show';
														} ?>" id="advanceFilter">
									<div class="row">
										<div class="col-md-4 px-1">
											<div class="form-group">
												<label>Date Between (From and To)</label>
												<div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
													<input type="text" class="form-control" id="_from" name="from" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" autocomplete="off" placeholder="Start Date" />
													<input type="text" class="form-control" id="_to" name="to" value="<?php echo $this->input->get('to') ? $this->input->get('to') : ''; ?>" autocomplete="off" placeholder="End Date" />
												</div>
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
									<a href="<?php echo base_url('admin/spare-parts/requisition/list'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div> <!-- end col -->

			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<form id="myform" name="myform" method="post" action="">
							<table id="job-table" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
								<thead>
									<tr>
										<th>#</th>
										<th>Sr. No</th>
										<th>Requisition No</th>
										<th>Date</th>
										<th>Supplier</th>
										<th>Total Items</th>
										<th>Total Qty</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
							</table>
						</form>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>

<!-- Modal -->
<div class="modal fade jobcard-modal" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0">ADD Requisition</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="demo-form2" method="post" action="<?php echo base_url('admin/spare-parts/requisition/create') ?>" data-toggle="validator" role="form">
					<div class="row">
						<div class="col-md-6 mb-3 form-group">
							<label class="control-label" for="requisition_type" style="width:100%">Requisition Type <span class="text-danger">*</span></label>
							<select id="requisition_type" name="requisition_type" class="form-control col-md-12 select2" required>
								<option value="">Select Requisition Type</option>
								<option value="local">Local</option>
								<option value="international">International</option>
							</select>
						</div>

						<div class="col-md-6 mb-3 form-group">
							<label class="control-label" for="supplier_id" style="width:100%">Select Supplier <span class="text-danger">*</span></label>
							<select id="supplier_id" name="supplier_id" class="form-control col-md-12 select2" required>
								<option value="">Select Supplier</option>
							</select>
						</div>

						<div class="col-md-6 mb-3 form-group">
							<label class="control-label" for="requisition_date">Requisition Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control" name="requisition_date" max="<?php echo date('Y-m-d'); ?>" required />
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
				<button type="submit" form="demo-form2" class="btn btn-success">Submit</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this->load->view('admin/home/footer'); ?>
<script>
	$(document).ready(function() {
		$('#job-table').dataTable({
			"lengthMenu": [
				[25, 50, 100, 500],
				[25, 50, 100, 500]
			],
			order: [
				[0, 'asc']
			],
			dom: 'Blfrtip',
			buttons: [{
					extend: "copy",
					className: "btn-md"
				},
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
			"processing": true,
			"serverSide": true,
			fixedHeader: true,
			"order": [],
			"ajax": {
				url: "<?php echo base_url(); ?>admin/spare-parts/requisition/ajax-list?requisition_no=<?php echo $this->input->get('requisition_no'); ?>&requisition_type=<?php echo $this->input->get('requisition_type'); ?>&from=<?php echo $this->input->get('from'); ?>&to=<?php echo $this->input->get('to'); ?>&status=<?php echo $this->input->get('status'); ?>",
				type: "POST",
				error: function(request, error) {
					console.log(" Can't do because: " + JSON.stringify(request));
				},
			},
			"columnDefs": [{
				"targets": [0, 1, 2, 3, 4, 5, 6, 7, 8],
				"orderable": false
			}, ]
		});
	});
	$.fn.dataTable.ext.errMode = function(settings, helpPage, message) {
		console.log(message);
	};

	function deleteAction() {
		var inputCount = $('[name="check_list[]"]:checked').length;
		if (inputCount > 0) {
			if (confirm("Do you want to delete selected items?") == true) {
				changeActionAndSubmit("admin/spare-parts/requisition/delete");
			} else {
				userPreference = "Action Cancelled!";
			}
		} else {
			alert("Plese select check box first");
		}
	}

	function changeActionAndSubmit(action) {
		document.getElementById('myform').action = action;
		document.getElementById('myform').submit();
	}

	/*----- Get Suppliers ----*/
	$(document).ready(function() {
		selectedSupplier();
	});

	$('#requisition_type').change(function() {
		var supplier_type = $(this).find('option:selected').val();
		$.ajax({
			url: "<?php echo base_url('admin/logistic-masters/Requisition/get_spare_suppliers'); ?>",
			data: {
				supplier_type: supplier_type
			},
			dataType: "json",
			type: "post",
			success: function(data) {
				var html = '<option value="">Select Supplier</option>';

				if (Object.keys(data).length > 0) {
					$.each(data, function(index, item) {
						html += '<option value="' + item.id + '" data-id="' + item.id + '">' + item.vendor_name + '</option>';
					});
				} else {
					var html = '<option value="">No Supplier Found</option>';
				}
				$('#supplier_id').html(html);
			}
		});
	});

	function selectedSupplier() {
		var supplier_type = "<?= ($requisition_type == '') ? 'NULL' : $requisition_type; ?>";
		if (supplier_type !== 'NULL') {
			$.ajax({
				url: "<?php echo base_url('admin/logistic-masters/Requisition/get_spare_suppliers'); ?>",
				data: {
					supplier_type: supplier_type
				},
				dataType: "json",
				type: "post",
				success: function(data) {
					var html = '<option value="">Select Supplier</option>';

					if (Object.keys(data).length > 0) {
						$.each(data, function(index, item) {
							var isSelected = (supplier_type == item.id ? 'selected' : '');
							html += '<option value="' + item.id + '" data-id="' + item.id + '" ' + isSelected + '>' + item.vendor_name + '</option>';
						});
					} else {
						var html = '<option value="">No Supplier found</option>';
					}
					$('#supplier_id').html(html);
				}
			});
		}
	}
</script>