<?php $this->load->view('admin/home/header'); ?>
<style>
	.tile-stats .count {
		font-size: 27px;
		font-weight: 700;
		line-height: 1;
	}

	@media only screen and (max-width: 1296px) {
		p.text-primary.fw-bold {
			font-size: 13px !important;
		}
	}

	@media only screen and (max-width: 1252px) {
		p.text-primary.fw-bold {
			font-size: 12px !important;
		}
	}

	.product-desc {
		/*width: 300px;*/
		white-space: break-spaces;
		display: flex;
	}

	.product-desc pre {
		white-space: break-spaces;
		direction: rtl;
	}

	.card.active {
		background-color: currentColor;
	}

	.card.active p {
		color: #fff !important;
	}

	.card.active h5 {
		color: #fdce43;
	}

	.all-checkbox {
		height: 18px;
		width: 18px;
		vertical-align: bottom;
	}
</style>
<style type="text/css">
	.modal .modal-dialog-aside {
		width: 350px;
		max-width: 80%;
		height: 100%;
		margin: 0;
		transform: translate(0);
		transition: transform .2s;
	}


	.modal .modal-dialog-aside .modal-content {
		height: inherit;
		border: 0;
		border-radius: 0;
	}

	.modal .modal-dialog-aside .modal-content .modal-body {
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

<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Product Management</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item active">Product List</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php
					$permissions = [
						'enableStatus' => check_action_permission(get_user_role(), 'manage_product', 'setStatusEnable'),
						'disableStatus' => check_action_permission(get_user_role(), 'manage_product', 'setStatusDisable'),
						'deleteProduct' => check_action_permission(get_user_role(), 'manage_product', 'delete'),
						'addBulk' => check_action_permission(get_user_role(), 'manage_product', 'add_bulk_product'),
					];

					if (array_filter($permissions)): ?>
						<div class="btn-group me-1">
							<button class="btn btn-custom-danger btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Bulk Action <i class="mdi mdi-chevron-down"></i>
							</button>
							<div class="dropdown-menu">
								<?php if ($permissions['deleteProduct']): ?>
									<a class="dropdown-item" onclick="deleteAction()" href="javascript:void(0);">Delete Product</a>
									<div class="dropdown-divider"></div>
								<?php endif; ?>

								<?php if ($permissions['enableStatus']): ?>
									<a class="dropdown-item" onclick="EnableStatus()" href="javascript:void(0);">Enable Product</a>
									<div class="dropdown-divider"></div>
								<?php endif; ?>

								<?php if ($permissions['disableStatus']): ?>
									<a class="dropdown-item" onclick="DisableStatus()" href="javascript:void(0);">Disable Product</a>
									<div class="dropdown-divider"></div>
								<?php endif; ?>

								<?php if ($permissions['addBulk']): ?>
									<a class="dropdown-item" href="<?php echo base_url('admin/product/add_bulk_product'); ?>">Add Bulk Products</a>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>

					<?php if (check_action_permission(get_user_role(), 'manage_product', 'create_product')): ?>
						<a class="btn btn-custom-success btn-sm" title="Add" href="<?php echo base_url('admin/product/create_product'); ?>">
							<i class="fa fa-plus"></i> Add Product
						</a>
					<?php endif; ?>
				</div>

				<?php if ($this->admin->getInfo()) {
					$info = explode("--", $this->admin->getInfo());
					$info_type = $info[0];
					$msg_data = $info[1];
					if ($info_type == 2) { ?>
						<div class="alert alert-danger alert-dismissible fade show" style="position: fixed; z-index: 99; right: 20px; top: 90px; width: 50%;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong><?php echo $msg_data; ?></strong>
						</div>
					<?php } else { ?>
						<div class="alert alert-info alert-dismissible fade show" style="position: fixed; z-index: 99; right: 20px; top: 90px; width: 50%;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong><?php echo $msg_data; ?></strong>
						</div>
					<?php } ?>
				<?php }
				$this->admin->removeInfo(); ?>
			</div>
		</div>
	</div>
</div>


<div class="container-fluid">
	<div class="page-content-wrapper">
		<div class="row">

			<div class="col-xl-2 col-md-4">
				<a href="<?php echo base_url(); ?>admin/product" target="_blank">
					<div class="card <?= ($this->uri->segment(2) == 'product' ? 'active' : ''); ?>">
						<div class="card-body">
							<div class="text-center">
								<p class="text-success fw-bold">Total Products</p>
								<h5 class="font-size-22"><?php echo $total_products[0]['total']; ?></h5>
							</div>
						</div>
					</div>
				</a>
			</div>

			<div class="col-xl-2 col-md-4">
				<a href="<?php echo base_url(); ?>admin/product/filtered_product?keyword=status&value=1" target="_blank">
					<div class="card">
						<div class="card-body">
							<div class="text-center">
								<p class="text-success fw-bold">Active</p>
								<h5 class="font-size-22"><?php echo $active_products[0]['total']; ?></h5>
							</div>
						</div>
					</div>
				</a>
			</div>

			<div class="col-xl-2 col-md-4">
				<a href="<?php echo base_url(); ?>admin/product/filtered_product?keyword=status&value=0" target="_blank">
					<div class="card">
						<div class="card-body">
							<div class="text-center">
								<p class="text-success fw-bold">Disabled</p>
								<h5 class="font-size-22"><?php echo $disable_products[0]['total']; ?></h5>
							</div>
						</div>
					</div>
				</a>
			</div>

			<div class="col-xl-2 col-md-4">
				<a href="<?php echo base_url(); ?>admin/product/filtered_product?keyword=image&value=" target="_blank">
					<div class="card">
						<div class="card-body">
							<div class="text-center">
								<p class="text-success fw-bold">Image Missing</p>
								<h5 class="font-size-22"><?php echo $image_missing[0]['total']; ?></h5>
							</div>
						</div>
					</div>
				</a>
			</div>

			<div class="col-xl-2 col-md-4">
				<a href="<?php echo base_url(); ?>admin/product/filtered_product?keyword=name_ar&value=" target="_blank">
					<div class="card">
						<div class="card-body">
							<div class="text-center">
								<p class="text-success fw-bold">Arabic Missing</p>
								<h5 class="font-size-22"><?php echo $arabic_missing[0]['total']; ?></h5>
							</div>
						</div>
					</div>
				</a>
			</div>

			<div class="col-xl-2 col-md-4">
				<a href="<?php echo base_url(); ?>admin/product/filtered_product?keyword=parent_sku&value=" target="_blank">
					<div class="card">
						<div class="card-body">
							<div class="text-center">
								<p class="text-success fw-bold">SKU Missing</p>
								<h5 class="font-size-22"><?php echo $sku_missing[0]['total']; ?></h5>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h4 class="header-title mb-0">Search</h4>
					</div>
					<div class="card-body">
						<form action="<?php echo base_url(); ?>admin/product" method="get" id="filter_form">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Search Keywords</label>
										<input type="text" id="keyword" name="keyword" placeholder="Enter name or code" value="<?php echo $this->input->get('keyword') ? $this->input->get('keyword') : ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Barcode</label>
										<input type="text" id="barcode" name="barcode" placeholder="Enter product barcode" value="<?php echo $this->input->get('barcode') ? $this->input->get('barcode') : ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Select Category</label>
										<select class="form-control show-tick select2" name="category_id" id="category_id">
											<option value="">[Any Category]</option>
											<?php foreach ($categories as $category) { ?>
												<option value="<?php echo $category['id']; ?>" <?php echo ($this->input->get('category_id') == $category['id']) ? 'selected' : ''; ?>><?php echo $category['name']; ?></option>
												<?php foreach ($category['child'] as $child) { ?>
													<option value="<?php echo $child['id']; ?>" <?php echo ($this->input->get('category_id') == $child['id']) ? 'selected' : ''; ?>><?php echo $category['name'] . " >" . $child['name']; ?></option>
													<?php foreach ($child['child'] as $sub) { ?>
														<option value="<?php echo $sub['id']; ?>" <?php echo ($this->input->get('category_id') == $sub['id']) ? 'selected' : ''; ?>><?php echo $category['name'] . " >" . $child['name'] . " > " . $sub['name']; ?></option>
											<?php }
												}
											} ?>
										</select>
									</div>
								</div>
								<?php
								$adv_show = false;
								if (!empty($this->input->get('brand')) || !empty($this->input->get('from')) || !empty($this->input->get('to')) || !empty($this->input->get('status')) || !empty($this->input->get('cod')) || !empty($this->input->get('btob'))) {
									$adv_show = true;
								}
								?>
								<div class="collapse <?php if ($adv_show) {
															echo ' show';
														} ?>" id="advanceFilter">
									<div class="row">
										<div class="col-lg-4 col-md-4 col-sm-12">
											<div class="form-group mb-2">
												<label class="control-label" for="brand">Select brand </label>
												<select style="height:410px;" name="brand" id="brand" class="form-control select2">
													<option value="">[Any Brand]</option>
													<?php foreach ($brand_list as $brand) { ?>
														<option value="<?php echo $brand->id; ?>" <?php echo ($this->input->get('brand') == $brand->id) ? 'selected' : ''; ?>><?php echo $brand->brand_name; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-12">
											<div class="form-group mb-2">
												<label>Date Between (From and To)</label>
												<div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
													<input type="text" class="form-control" id="_from" name="from" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" autocomplete="off" placeholder="Start Date" />
													<input type="text" class="form-control" id="_to" name="to" value="<?php echo $this->input->get('to') ? $this->input->get('to') : ''; ?>" autocomplete="off" placeholder="End Date" />
												</div>
											</div>
										</div>

										<div class="col-lg-4 col-md-4 col-sm-12">
											<div class="form-group mb-2">
												<label class="d-block">Select Status </label>
												<select style="height:410px;" name="status" class="form-control select2 w-100">
													<option value="">[Any Status]</option>
													<option value="yes" <?php echo ($this->input->get('status') == 'yes') ? 'selected' : ''; ?>>Active</option>
													<option value="no" <?php echo ($this->input->get('status') == 'no') ? 'selected' : ''; ?>>Inactive</option>
												</select>
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-12">
											<div class="form-group mb-2">
												<label>Select COD </label>
												<select style="height:410px;" name="cod" id="cod" class="form-control select2">
													<option value="">Select Availability</option>
													<option value="yes" <?php echo ($this->input->get('cod') == 'yes') ? 'selected' : ''; ?>>Available</option>
													<option value="no" <?php echo ($this->input->get('cod') == 'no') ? 'selected' : ''; ?>>Not available</option>
												</select>
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-12">
											<div class="form-group mb-2">
												<label>Select B2B </label>
												<select style="height:410px;" name="btob" id="btob" class="form-control select2">
													<option value="">Select Availability</option>
													<option value="yes" <?php echo ($this->input->get('btob') == 'yes') ? 'selected' : ''; ?>>Available</option>
													<option value="no" <?php echo ($this->input->get('btob') == 'no') ? 'selected' : ''; ?>>Not available</option>
												</select>
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
									<a href="<?php echo base_url('admin/product'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
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
							<table id="example" class="table table-centered table-nowrap mb-0 table-striped table-bordered jambo_table bulk_action" style="width: 100%;">
								<thead>
									<tr>
										<th style="width:30px">S.No.</th>
										<th style="width:30px"><input type="checkbox" name="selectall" id="selectall" class="all-checkbox" /></th>
										<th>Sku</th>
										<th>Product</th>
										<th>COD</th>
										<th>B2B</th>
										<th>Status</th>
										<th style="width:50px">Tools</th>
									</tr>
								</thead>
								<tbody>

								</tbody>
							</table>
						</form>
					</div>
				</div>
			</div>

		</div>

	</div>
</div>

<div class="modal fade fixed-left exampleModalFullscreen" aria-labelledby="#exampleModalFullscreenLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0" id="exampleModalFullscreenLabel">Advance Filter</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">

			</div>
		</div>

	</div>

</div>


<div class="modal fade stockModalFullscreen" tabindex="-1" aria-labelledby="#stockModalFullscreenLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title mt-0" id="stockModalFullscreenLabel">UPDATE PRODUCT SIZE</h6>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href='<?php echo base_url(); ?>admin/product'"></button>
			</div>
			<div class="modal-body">

			</div>

		</div>
	</div>
</div>
<?php $this->load->view('admin/home/footer'); ?>

<script>
	$(document).ready(function() {
		$("#example").dataTable({
			lengthMenu: [
				[25, 50, 100, 500],
				[25, 50, 100, 500],
			],
			order: [
				[0, "DESC"]
			],
			dom: "Blfrtip",
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

			processing: true,
			serverSide: true,
			responsive: true,
			fixedHeader: true,
			searching: false,
			ajax: {
				url: "<?php echo base_url() ?>admin/product/get_list?keyword=<?php echo $this->input->get('keyword') ?>&barcode=<?php echo $this->input->get('barcode') ?>&category_id=<?php echo $this->input->get('category_id') ?>&brand=<?php echo $this->input->get('brand') ?>&from=<?php echo $this->input->get('from') ?>&to=<?php echo $this->input->get('to') ?>&status=<?php echo $this->input->get('status') ?>&cod=<?php echo $this->input->get('cod') ?>&btob=<?php echo $this->input->get('btob') ?>",
				type: "POST",
				error: function(request, error) {
					console.log(" Can't do because: " + JSON.stringify(request));
				},
			},

			columnDefs: [{
				targets: [0, 1, 2, 3, 4, 5, 6, 7],
				orderable: false,
			}, ],
		});
	});
</script>
<script>
	/*
	$(document).ready(function () {
		$("#parent").on("change", function (e) {
			$("#p_id").val($("#parent").val());
			location.href = "<?php echo base_url(); ?>admin/product?id=" + $("#parent").val();
		});
	});
	*/

	function deleteAction() {
		var inputCount = $('[name="check_list[]"]:checked').length;
		if (inputCount > 0) {
			if (confirm("Do you want to delete selected product?") == true) {
				changeActionAndSubmit("admin/product/soft-delete");
			} else {
				userPreference = "Action Cancelled!";
			}
		} else {
			alert("Plese select check box first");
		}
	}

	$(document).ready(function() {
		$("#selectall").click(function() {
			if (this.checked) {
				$('.checkbox').each(function() {
					$(".checkbox").prop('checked', true);
				})
			} else {
				$('.checkbox').each(function() {
					$(".checkbox").prop('checked', false);
				})
			}
		});
	});

	var switchStatus = false;

	function changeStatus(pid, sid) {
		product_id = pid;
		input_id = 'switchs' + sid;
		//var value = $('#'+input_id).val();
		if ($('#' + input_id).is(':checked')) {
			switchStatus = $('#' + input_id).is(':checked');
		} else {
			switchStatus = $('#' + input_id).is(':checked');
		}
		if (pid !== "" || switchStatus !== "") {
			//alert(switchStatus);
			$.ajax({
				url: "<?php echo base_url(); ?>admin/product/setStatus",
				type: "POST",
				data: {
					"id": product_id,
					"status": switchStatus
				},
				success: function(response) {
					alert(response);
					location.reload();
				},
				error: function(response) {
					alert(response);
					location.reload();
				},
			});
		} else {
			return false;
		}
	}

	var switchCod = false;

	function changeCod(pid, sid) {
		product_id = pid;
		input_id = 'switchc' + sid;
		if ($('#' + input_id).is(':checked')) {
			switchCod = $('#' + input_id).is(':checked');
		} else {
			switchCod = $('#' + input_id).is(':checked');
		}
		if (pid !== "" || switchCod !== "") {
			//alert(switchStatus);
			$.ajax({
				url: "<?php echo base_url(); ?>admin/product/setCod",
				type: "POST",
				data: {
					"id": product_id,
					"cod": switchCod
				},
				success: function(response) {
					alert(response);
					location.reload();
				},
				error: function(response) {
					alert(response);
					location.reload();
				},
			});
		} else {
			return false;
		}
	}

	var switchB2B = false;

	function changeB2b(pid, sid) {
		product_id = pid;
		input_id = 'switchb' + sid;
		if ($('#' + input_id).is(':checked')) {
			switchB2B = $('#' + input_id).is(':checked');
		} else {
			switchB2B = $('#' + input_id).is(':checked');
		}
		if (pid !== "" || switchB2B !== "") {
			//alert(switchStatus);
			$.ajax({
				url: "<?php echo base_url(); ?>admin/product/setB2B",
				type: "POST",
				data: {
					"id": product_id,
					"b2b": switchB2B
				},
				success: function(response) {
					alert(response);
					location.reload();
				},
				error: function(response) {
					alert(response);
					location.reload();
				},
			});
		} else {
			return false;
		}
	}

	var EnableStatus = function() {
		var inputCount = $('[name="check_list[]"]:checked').length;
		if (inputCount > 0) {
			if (confirm("Do you want to enable selected product?") == true) {
				changeActionAndSubmit("admin/product/setStatusEnable");
			} else {
				userPreference = "Action Cancelled!";
			}
		} else {
			alert("Plese select check box first");
		}
	};

	function DisableStatus() {
		var inputCount = $('[name="check_list[]"]:checked').length;
		if (inputCount > 0) {
			if (confirm("Do you want to disable selected product?") == true) {
				changeActionAndSubmit("admin/product/setStatusDisable");
			} else {
				userPreference = "Action Cancelled!";
			}
		} else {
			alert("Plese select check box first");
		}
	}

	function changeActionAndSubmit(action) {
		document.getElementById("myform").action = action;
		document.getElementById("myform").submit();
	}
	/*
	$("#_from").datetimepicker({
		format: "MM/DD/YYYY",
	});
	$("#_to").datetimepicker({
		format: "MM/DD/YYYY",
		useCurrent: false,
	});
	$("#_from").on("dp.change", function (e) {
		$("#_to").data("DateTimePicker").minDate(e.date);
	});
	$("#_to").on("dp.change", function (e) {
		$("#from").data("DateTimePicker").maxDate(e.date);
	});
	*/
</script>
<script>
	function quickView(prod_id) {
		if (prod_id > 0) {
			//alert(req_id);
			$.ajax({
				type: "post",
				url: "<?php echo base_url(); ?>admin/product/quick_view",
				data: {
					'id': prod_id
				},
				//dataType: "json",
				success: function(response) {
					console.log(response);
					$('.stockModalFullscreen .modal-body').html(response);
					$(".stockModalFullscreen").modal('show');
				},
				error: function(request, error) {
					console.log(" Can't do because: " + JSON.stringify(request));
					$('.stockModalFullscreen .modal-body').html(JSON.stringify(request));
					$(".stockModalFullscreen").modal('show');
				},
			});
		} else {
			alert('Invalid product id!');
		}
	}

	/*----------- Rack and Shelf ------------*/
	$(document).ready(function() {
		//getShelf();
	});

	function rackChange(sel) {
		var selectedRack = sel.value;
		var rack_id = $(sel).attr("id");
		//alert( rack_id );
		$.ajax({
			url: "<?php echo base_url() ?>admin/Product/getShelf",
			data: {
				"id": selectedRack
			},
			//dataType:"html",
			type: "post",
			success: function(data) {
				var prod_shelf = rack_id.replace('prod_rack', 'prod_shelf');
				//alert('#'+prod_shelf);
				$('#' + prod_shelf).html(data);
			}
		});
	}
</script>