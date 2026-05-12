<?php $this->load->view('admin/home/header'); ?>
<style>
	#spareTable tr td {
		vertical-align: middle;
	}

	.log-button {
		vertical-align: initial;
	}

	a.cccc2 {
		border: 1px solid #ddd;
		background-color: none;
		padding: 2px 5px;
	}

	.cccc2.active {
		background-color: #c3c3c3;
	}
</style>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Spare Part Master</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/spare-parts/list'); ?>">Spare Part Master</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if (check_action_permission(get_user_role(), 'vehicle_spare_parts', 'delete')): ?>
						<button class="btn btn-custom-danger btn-sm pull-right me-2" onclick="confirm('Really want to delete this item?') ? $('#delete_form').submit() : false;" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					<?php endif;
					if (check_action_permission(get_user_role(), 'vehicle_spare_parts', 'add')): ?>
						<a class="btn btn-custom-success btn-sm pull-right" title="Add" href="<?php echo base_url('admin/spare-parts/add') ?>"><i class="fa fa-plus"></i> Add Spare Part</a>
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
				<!-- </div> -->
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
						<!-- <a href="javascript:;" class="cccc2">ABC</a> <a href="javascript:;" class="cccc2">XYZ</a> -->
						<form action="<?php echo base_url('admin/spare-parts/list'); ?>" method="get" id="filter_form">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Search by Item Code/Parts Name</label>
										<input type="search" id="keyword" name="keyword" placeholder="Search by Item Code/Parts Name" value="<?php echo ($this->input->get('keyword') !== '') ? $this->input->get('keyword') : ''; ?>" autocomplete="off" class="form-control">
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
								<div class="col-4 px-1">
									<div class="form-group mb-2">
										<label class="d-block">Status </label>
										<select style="height:410px;" name="status" class="form-control select2 w-100">
											<option value="">All Status</option>
											<option value="active" <?php if ($this->input->get('status') == 'active') {
																		echo 'selected';
																	} ?>>Active</option>
											<option value="inactive" <?php if ($this->input->get('status') == 'inactive') {
																			echo 'selected';
																		} ?>>Inactive</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row mt-2">
								<div class="col-lg-12 col-md-12 col-sm-12">
									<button type="submit" class="btn btn-success btn-md float-end ms-2">Apply Filter</button>
									<a href="<?php echo base_url('admin/spare-parts/list'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div> <!-- end col -->
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<?php echo form_open('admin/spare-parts/delete', array("id" => "delete_form")); ?>
						<table id="spareTable" class="table table-striped table-bordered jambo_table bulk_action">
							<thead>
								<tr>
									<th>#</th>
									<th>S.No.</th>
									<th>Make</th>
									<th>Model</th>
									<th>Item Code</th>
									<th>Part Name</th>
									<th>Status</th>
									<th>Created On</th>
									<th>Updated On</th>
									<th>Tools</th>
								</tr>
							</thead>

						</table>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<div class="modal fade stock-detail-modal" role="dialog" aria-labelledby="ModalFullscreenLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title mt-0" id="ModalFullscreenLabel">Spare Parts Inventory Log</h6>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" id="summary_body_modal">

			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this->load->view('admin/home/footer'); ?>

<script>
	$(document).ready(function() {

		$('#spareTable').dataTable({
			"lengthMenu": [
				[25, 50, 100, 500],
				[25, 50, 100, 500]
			],
			order: [
				[0, 'DESC']
			],
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
			fixedHeader: true,
			"order": [],
			"ajax": {
				url: "<?php echo base_url(); ?>admin/spare-parts/ajax-list?keyword=<?php echo $this->input->get('keyword'); ?>&from=<?php echo $this->input->get('from'); ?>&to=<?php echo $this->input->get('to'); ?>&status=<?php echo $this->input->get('status'); ?>",
				type: "POST"
			},
			"columnDefs": [{
				"targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
				"orderable": false
			}, ]
		});
	});

	function stockUpdate(prod_id) {
		if (prod_id > 0) {
			$('#item_id').val(prod_id);
			$('.stock-update-modal').modal('show');
		} else {
			alert('Invalid request id!');
		}
	}

	function quickView(prod_id) {
		if (prod_id > 0) {
			$.ajax({
				type: "post",
				url: "<?php echo base_url('admin/spare-parts/inventory-log'); ?>",
				data: {
					'prod_id': prod_id
				},
				//dataType: "json",
				success: function(response) {
					//console.log(response);
					$('.stock-detail-modal').modal('show');
					$('#ModalFullscreenLabel').html('Spare Parts Inventory Log');
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

	function quickViewJob(id) {
		if (id > 0) {
			$.ajax({
				type: "post",
				url: "<?php echo base_url(); ?>admin/spare-parts/stock-out-log",
				data: {
					'prod_id': id
				},
				//dataType: "json",
				success: function(response) {
					console.log(response);
					$('.stock-detail-modal').modal('show');
					$('#ModalFullscreenLabel').html('Spare Parts Stock Out');
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

	// $('.cccc2').bind('click', function() {
	// 	if($(this).hasClass('active')){
	// 		$(this).removeClass('active');
	// 	}else{
	// 		$(this).addClass('active');
	// 	}
	// });
</script>