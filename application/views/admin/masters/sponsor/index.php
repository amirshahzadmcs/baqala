<?php $this->load->view('admin/home/header'); ?>
<style>
	@media only screen and (max-width: 600px) {
		.modal .modal-dialog-aside {
			width: 100% !important;
			max-width: 100% !important;
		}
	}

	.modal .modal-dialog-aside {
		width: 30%;
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
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Sponsors</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/master/sponsors'); ?>">Sponsors</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-none d-sm-block">
					<?php if (check_action_permission(get_user_role(), 'sponsors', 'delete')): ?>
						<button class="btn btn-custom-danger btn-sm pull-right" onclick="confirm('Really want to delete this item?') ? $('#delete_form').submit() : false;" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					<?php endif;
					if (check_action_permission(get_user_role(), 'sponsors', 'add')): ?>
						<button class="btn btn-custom-success btn-sm pull-right ms-2" title="Add New Sponsors" id="addSponsorsBtn"><i class="fa fa-plus"></i> Add New Sponsor</button>
					<?php endif; ?>
				</div>

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
						<?php echo form_open('admin/master/sponsors/delete', array("id" => "delete_form")); ?>
						<table id="datatableSponsor" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
							<thead>
								<tr>
									<th>#</th>
									<th>Employer ID</th>
									<th>Employer Name (EN)</th>
									<th>Employer Name (AR)</th>
									<th>CR No</th>
									<th>MOL ID</th>
									<th>Total Employees</th>
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

<!-- Modal -->
<div class="modal fade fixed-left sponsor-modal" id="rightFixedModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade fixed-left emp-list-modal" aria-labelledby="#empModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="empModalLabel">Sponsor Rider List</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="sponsorEmpList">
				
            </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
		if ($.fn.DataTable.isDataTable('#datatableSponsor')) {
			$('#datatableSponsor').DataTable().destroy();
		}

		$('#datatableSponsor').dataTable({
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
				url: "<?php echo base_url('admin/master/sponsors/get-list'); ?>",
				type: "POST"
			},
			"columnDefs": [{
				"targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
				"orderable": false
			}, ]
		});

		$.fn.dataTable.ext.errMode = function(settings, helpPage, message) {
			console.log(message);
		};
	}

	$(document).ready(function() {
		initializeDataTable();
	});

	$(document).ready(function() {
		$("#addSponsorsBtn").click(function() {
			$.ajax({
				type: "GET",
				url: "<?php echo base_url('admin/master/sponsors/add'); ?>",
				success: function(response) {
					var data = JSON.parse(response);
					if (data.type === 'success') {
						$('.sponsor-modal').modal('show');
						$('.sponsor-modal .modal-content').html(data.output_html);
					} else {
						toastr.error(data.message);
					}
				},
				error: function(request, error) {
					console.log(" Can't do because: " + JSON.stringify(request));
					toastr.error('Unable to load view file.');
				},
			});
		});
	});

	function editSponsorsBtn(id) {
		if (id > 0) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('admin/master/sponsors/edit'); ?>",
				data: {
					'id': id,
				},
				success: function(response) {
					var data = JSON.parse(response);
					if (data.type === 'success') {
						$('.sponsor-modal').modal('show');
						$('.sponsor-modal .modal-content').html(data.output_html);
					} else {
						toastr.error(data.message);
					}
				},
				error: function(request, error) {
					console.log(" Can't do because: " + JSON.stringify(request));
					toastr.error('Unable to load view file.');
				},
			});
		} else {
			alert('Invalid request id!');
		}
	}

	$(document).on('click', '.view-sponsor-employees', function() {
		var id = $(this).data('sponsorid'); // Get sponsor ID from clicked button
		if (!id) {
			toastr.error('Invalid Sponsor ID');
			return;
		}

		$.ajax({
			url: '<?php echo base_url();?>admin/masters/sponsors/sponsorsEmployees',
			method: 'POST',
			data: { id: id },
			dataType: 'json', // Expect JSON response

			beforeSend: function() {
				// Show loading Toastr message before the request starts
				toastr.info('Loading data, please wait...', '', { 
					timeOut: 0, 
					extendedTimeOut: 0, 
					closeButton: false, 
					tapToDismiss: false,
					progressBar: true
				});
			},

			success: function(response) {
				if (response.type === 'success') {
					$('#sponsorEmpList').html(response.output_html);
					$('.emp-list-modal').modal('show');
					toastr.success('Data loaded successfully.');
				} else {
					toastr.error(response.message);
				}
			},

			error: function() {
				toastr.error('Error fetching data, Try again!');
			},

			complete: function() {
				// Clear all Toastr messages when request completes
				toastr.clear();
			}
		});
	});
</script>
