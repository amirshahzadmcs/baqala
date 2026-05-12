<?php $this->load->view('admin/home/header'); ?>
<style>
	.dataTables_wrapper::-webkit-scrollbar {
		display: none;
	}

	.nav-md .container.body .right_col {
		padding: 10px 10px 0;
		margin-left: 230px;
	}
</style>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Purchase Orders</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item active">Purchase Orders List</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<?php if (check_action_permission(get_user_role(), 'purchase_order_invoice', 'create_order')): ?>
					<div class="float-end d-sm-block">
						<button type="button" class="btn btn-custom-success btn-sm pull-right me-1" data-bs-toggle="modal" data-bs-target=".purchase-modal"><i class="fa fa-plus"></i> Add Purchase Orders</button>
					</div>
				<?php endif; ?>
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
						<form action="<?php echo base_url('admin/purchase/list'); ?>" method="get" id="filter_form">
							<div class="row p-2">
								<div class="col-4 px-1">
									<div class="form-group mb-2">
										<label class="control-label" for="supplier" style="width:100%">Select Supplier</label>
										<select id="supplier" name="supplier" class="form-control col-md-12 select2">
											<option value="">---- All Supplier ----</option>
											<?php foreach ($vendor_list as $supplier) { ?>
												<option value="<?php echo $supplier->id; ?>" <?php if ($this->input->get('supplier') == $supplier->id) {
																									echo 'selected';
																								} ?>><?php echo $supplier->vendor_name; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>

								<div class="col-4 px-1">
									<div class="form-group">
										<label>PO Number</label>
										<div class="input-group">
											<span class="input-group-text">PON-</span>
											<input type="number" id="_po_number" name="po_number" value="<?php echo $this->input->get('po_number') ? $this->input->get('po_number') : ''; ?>" autocomplete="off" class="form-control">
										</div>
									</div>
								</div>
								<div class="col-4 px-1">
									<div class="form-group mb-2">
										<label class="d-block">Select Status </label>
										<select style="height:410px;" name="status" class="form-control select2 w-100">
											<option value="">All Status</option>
											<option value="1" <?php if ($this->input->get('status') == '1') {
																	echo 'selected';
																} ?>>Pending</option>
											<option value="2" <?php if ($this->input->get('status') == '2') {
																	echo 'selected';
																} ?>>Accepted</option>
											<option value="3" <?php if ($this->input->get('status') == '3') {
																	echo 'selected';
																} ?>>Approved</option>
											<option value="4" <?php if ($this->input->get('status') == '4') {
																	echo 'selected';
																} ?>>Rejected</option>
										</select>
									</div>
								</div>
								<?php
								$adv_show = false;
								if (!empty($this->input->get('min_price')) || !empty($this->input->get('max_price')) || !empty($this->input->get('from')) || !empty($this->input->get('to'))) {
									$adv_show = true;
								}
								?>
								<div class="collapse <?php if ($adv_show) {
															echo ' show';
														} ?>" id="advanceFilter">
									<div class="row">
										<div class="col-md-4 px-1">
											<div class="form-group">
												<label>Total Price Between (Min and Max)</label>
												<div class="input-group">
													<input type="number" id="_more_than" name="min_price" min="0" placeholder="Min Price" value="<?php echo $this->input->get('min_price') ? $this->input->get('min_price') : ''; ?>" autocomplete="off" class="form-control">
													<input type="number" id="_less_than" name="max_price" min="1" placeholder="Max Price" value="<?php echo $this->input->get('max_price') ? $this->input->get('max_price') : ''; ?>" autocomplete="off" class="form-control">
												</div>
											</div>
										</div>
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
									<a href="<?php echo base_url('admin/purchase/list'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
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
							<table id="purchase-table" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
								<thead>
									<tr>
										<th style="width:15px;">#</th>
										<th style="width:90px;">PO NUMBER</th>
										<th style="width:90px;">REFERENCE NO.</th>
										<th style="width:88px;">ORDER DATE</th>
										<th style="width:80px;">DELIVERY DATE</th>
										<th style="width:250px;">SUPPLIER</th>
										<th style="width:65px;">TOTAL COST</th>
										<th style="width:70px;">STATUS</th>
										<th style="width:40px;">CREATED BY</th>
										<th style="width:80px;">ACTION</th>
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
<div class="modal fade purchase-modal" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0">Create Purchase Order</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="demo-form2" method="post" action="<?php echo base_url() ?>admin/purchase/create-purchase" data-toggle="validator" role="form" enctype="multipart/form-data">
					<div class="row">
						<div class="col-md-6 mb-3 form-group">
							<label class="control-label" for="vendor_id" style="width:100%">Select Vendor*</label>
							<select id="vendor_id" name="vendor_id" class="form-control col-md-12 select2" required>
								<option value="">Select Vendor</option>
								<?php foreach ($vendor_list as $vendor) { ?>
									<option value="<?php echo $vendor->id; ?>"><?php echo $vendor->vendor_name; ?> - <?php echo $vendor->telephone; ?></option>
								<?php } ?>
							</select>
						</div>

						<div class="col-md-6 mb-3 form-group">
							<label class="control-label" for="image">Upload Attachment</label>
							<input type="file" class="form-control" placeholder="Upload Image" name="image" />
						</div>

						<div class="col-md-6 mb-3 form-group">
							<label class="control-label" for="po_date">PO Date*</label>
							<input type="date" class="form-control" name="po_date" required />
						</div>

						<div class="col-md-6 mb-3 form-group">
							<label class="control-label" for="reference">Reference (if any)</label>
							<input type="text" class="form-control" maxlength="100" name="reference" />
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 mb-3 form-group">
							<label for="address1">Billing Address:</label><br>
							<span id="vendor_name"></span><br />
							<span id="vendor_contact"></span><br />
							<span id="building_no"></span> <span id="street_name"></span> <span id="district_name"></span><br />
							<span id="additional_no"></span>
							<span id="unit_no"></span><br>
							<span id="city_name"></span>
							<span id="zip_code"></span>
						</div>

						<div class="col-md-6 mb-3 form-group">
							<label for="address2">Deliver To:</label><br>
							<p>Maha Al Fala Trading Company<br />
								2751 Prince Sultan bin Abdulaziz Street<br>
								Sultan Business Center, Riyadh 12312<br>
								Kingdom of Saudi Arabia</p>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger" class="btn-close" data-bs-dismiss="modal">Close</button>
				<button type="submit" form="demo-form2" id="purchaseCreateBtn" class="btn btn-success">Submit</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this->load->view('admin/home/footer'); ?>
<script>
	$(document).ready(function() {
		$('#purchase-table').dataTable({
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
				url: "<?php echo base_url(); ?>admin/purchase/purchase-list?supplier=<?php echo $this->input->get('supplier'); ?>&po_number=<?php echo $this->input->get('po_number'); ?>&status=<?php echo $this->input->get('status'); ?>&min_price=<?php echo $this->input->get('min_price'); ?>&max_price=<?php echo $this->input->get('max_price'); ?>&from=<?php echo $this->input->get('from'); ?>&to=<?php echo $this->input->get('to'); ?>",
				type: "POST"
			},
			"columnDefs": [{
				"targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
				"orderable": false
			}, ]
		});

		$("#demo-form2").on("submit", function() {
			$('#purchaseCreateBtn').attr('disabled', 'disabled');
			$('#purchaseCreateBtn').html('<i class="fa fa-spinner spin"></i> Submitting');
		}); //submit
	});

	function changeActionAndSubmit(action) {
		document.getElementById('myform').action = action;
		document.getElementById('myform').submit();
	}

	$('#vendor_id').on('change', function() {
		var clientid = $("#vendor_id option:selected").attr("value");
		//alert(clientid);
		get_vendor_detail(clientid);
	});

	function get_vendor_detail(u) {
		$.ajax({
			url: '<?php echo base_url(); ?>admin/purchase_order/vendor_detail',
			type: "GET",
			data: {
				'id': u
			},
			success: function(data) {
				var result = JSON.parse(data);
				//alert(result.vendor_name);
				if (result) {
					$("#vendor_name").html(result.vendor_name);
					$("#vendor_contact").html(result.telephone);
					$("#building_no").html(result.building_no);
					$("#street_name").html(result.street_name);
					$("#district_name").html(result.district);
					$("#additional_no").html(result.additional_no + ',');
					$("#unit_no").html(result.unit_no);
					$("#city_name").html(result.city_name + ',');
					$("#zip_code").html(result.postal_code);

				} else {
					alert('Data not found');
					$("#vendor_name").html('');
					$("#vendor_contact").html('');
					$("#building_no").html('');
					$("#street_name").html('');
					$("#district_name").html('');
					$("#additional_no").html('');
					$("#unit_no").html('');
					$("#city_name").html('');
					$("#zip_code").html('');
				}

			},
			error: function(data) {
				alert(data);
			}
		});
	}
</script>