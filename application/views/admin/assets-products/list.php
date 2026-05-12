<?php $this->load->view('admin/home/header'); ?>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Assets Products</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/assets/product/list'); ?>">Products</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-none d-sm-block">
					<?php if (check_action_permission(get_user_role(), 'fixed_assets', 'delete')): ?>
						<button class="btn btn-custom-danger btn-sm pull-right" onclick="confirm('Really want to delete this item?') ? $('#delete_form').submit() : false;" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					<?php endif;
					if (check_action_permission(get_user_role(), 'fixed_assets', 'add')): ?>
						<a class="btn btn-custom-success btn-sm pull-right ms-2" title="Add" href="<?php echo base_url() ?>admin/assets/product/edit"><i class="fa fa-plus"></i> Add</a>
					<?php endif; ?>
				</div>
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
						<div>
							<?php if ($this->admin->getInfo()) {
								$info = explode("--", $this->admin->getInfo());
								$info_type = $info[0];
								$msg_data = $info[1];
								if ($info_type == 2) {
							?>
									<div class="alert alert-danger alert-dismissible fade show" role="alert">
										<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										<strong>Error!</strong> <?php echo $msg_data; ?>
									</div>
								<?php } else { ?>
									<div class="alert alert-success alert-dismissible fade show" role="alert">
										<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										<strong>Success!</strong> <?php echo $msg_data; ?>
									</div>
							<?php }
							}
							$this->admin->removeInfo(); ?>
						</div>
						<?php echo form_open('admin/assets/product/delete', array("id" => "delete_form")); ?>
						<table id="datatable-rack" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
							<thead>
								<tr>
									<th>#</th>
									<th>Prod. Code</th>
									<th>Product Name</th>
									<th>Category</th>
									<th>Sub Category</th>
									<th>Prod.sr. no</th>
									<th>Model no</th>
									<th>PO Date</th>
									<th>Warranty Exp.</th>
									<th>Price</th>
									<th>Condition</th>
									<th>Unit Value</th>
									<th>Qty</th>
									<th>Value</th>
									<th>Allotment</th>
									<th>Status</th>
									<th>Created On</th>
									<th>Updated On</th>
									<th>Tools</th>
								</tr>
							</thead>

							<tbody>

							</tbody>
						</table>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<div class="modal fade allotment-modal" role="dialog" aria-labelledby="ModalFullscreenLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title mt-0" id="summaryModalFullscreenLabel">Allotment Form</h6>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" id="summary_body_modal">
				<div class="alert_msg"></div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this->load->view('admin/home/footer'); ?>

<script>
	$(document).ready(function() {
		$('#datatable-rack').dataTable({
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
			],
			"responsive": true,
			"processing": true,
			"serverSide": true,
			fixedHeader: true,
			"order": [],
			"ajax": {
				url: "<?php echo base_url(); ?>admin/assets/product/ajax-list",
				type: "POST"
			},
			"columnDefs": [{
				"targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18],
				"orderable": false
			}, ]
		});
	});
	$.fn.dataTable.ext.errMode = function(settings, helpPage, message) {
		console.log(message);
	};

	function allot(prod_id) {
		if (prod_id > 0) {
			$.ajax({
				type: "post",
				url: "<?php echo base_url('admin/assets/product/allot'); ?>",
				data: {
					'prod_id': prod_id
				},
				//dataType: "json",
				success: function(response) {
					//console.log(response);
					$('.allotment-modal').modal('show');
					$('.allotment-modal .modal-dialog').removeClass('modal-xl');
					$('.allotment-modal .modal-dialog').addClass('modal-md');
					$('#summary_body_modal').html(response);
				},
				error: function(request, error) {
					//console.log(" Can't do because: " + JSON.stringify(request));
					$('#summary_body_modal').after(JSON.stringify(request));
				},
			});
		} else {
			alert('Invalid request id!');
		}
	}

	function unallot(prod_id) {
		if (prod_id > 0) {
			$.ajax({
				type: "post",
				url: "<?php echo base_url('admin/assets/product/unallot'); ?>",
				data: {
					'prod_id': prod_id
				},
				//dataType: "json",
				success: function(response) {
					//console.log(response);
					$('.allotment-modal').modal('show');
					$('.allotment-modal .modal-dialog').removeClass('modal-xl');
					$('.allotment-modal .modal-dialog').addClass('modal-md');
					$('#summaryModalFullscreenLabel').html('Unallotment Form');
					$('#summary_body_modal').html(response);
				},
				error: function(request, error) {
					//console.log(" Can't do because: " + JSON.stringify(request));
					$('#summary_body_modal').after(JSON.stringify(request));
				},
			});
		} else {
			alert('Invalid request id!');
		}
	}

	function asset_log(prod_id) {
		if (prod_id > 0) {
			$.ajax({
				type: "post",
				url: "<?php echo base_url('admin/assets/product/asset-log'); ?>",
				data: {
					'prod_id': prod_id
				},
				//dataType: "json",
				success: function(response) {
					//console.log(response);
					$('.allotment-modal').modal('show');
					$('#summaryModalFullscreenLabel').html('Assets Log');
					$('.allotment-modal .modal-dialog').removeClass('modal-md');
					$('.allotment-modal .modal-dialog').addClass('modal-xl');
					$('#summary_body_modal').html(response);
				},
				error: function(request, error) {
					//console.log(" Can't do because: " + JSON.stringify(request));
					$('#summary_body_modal').after(JSON.stringify(request));
				},
			});
		} else {
			alert('Invalid request id!');
		}
	}
</script>