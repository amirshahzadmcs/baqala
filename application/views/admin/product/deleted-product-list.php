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
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Deleted Product</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item active">Deleted Product List</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<?php if (check_action_permission(get_user_role(), 'deleted_product', 'restore_product')): ?>
					<div class="float-end d-sm-block">
						<a class="btn btn-custom-success btn-sm pull-right" title="Restore" onclick="restoreProduct()" href="javascript:;"><i class="fa fa-replay"></i> Restore Product</a>
					</div>
				<?php endif; ?>
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
<!-- end page title -->

<div class="container-fluid">
	<div class="page-content-wrapper">
		<div class="row">
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
									</tr>
								</thead>
								<tbody>
									<?php $i = 1;
									foreach ($products as $product) {
										$pro_id = $product->id; ?>
										<tr>
											<td><?php echo $i++; ?></td>
											<td><?php echo '<input type="checkbox" name="check_list[]" id="checkbox" class="checkbox" value="' . $product->id . '" />'; ?></td>
											<td><?php echo $product->parent_sku; ?></td>
											<td><?php echo !empty($product->image) ? '<div class="product-desc"><img class="avatar-sm" src="' . base_url() . $product->image . '" width="80px" /> <span class="ms-2">' . $product->name . '<br><pre>' . $product->name_ar . '</pre>' . '</span></div>' : '<div class="product-desc"><img class="avatar-sm" src="' . base_url() . 'images/notfound.jpg" width="80px" /> <span class="ms-2">' . $product->name . '<br><pre>' . $product->name_ar . '</pre></span></div>'; ?></td>
											<td><?php echo ($product->cod_available) == '1' ? "Yes" : "No"; ?></td>
											<td><?php echo ($product->b2b_availability) == 'yes' ? "Yes" : "No"; ?></td>
											<td><?php echo ($product->status) == '1' ? "Active" : "Inactive"; ?></td>
											</td>
										<?php } ?>
								</tbody>
							</table>
						</form>
					</div>
				</div>
			</div>
			<!-- end col -->
		</div>
		<!-- end row -->
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
			responsive: true,
			fixedHeader: true,

			columnDefs: [{
				targets: [0, 1, 2, 3, 4, 5, 6],
				orderable: false,
			}, ],
		});
	});
</script>
<script>
	function restoreProduct() {
		var inputCount = $('[name="check_list[]"]:checked').length;
		if (inputCount > 0) {
			if (confirm("Do you want to restore selected product?") == true) {
				changeActionAndSubmit("admin/product/restore-deleted");
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
</script>