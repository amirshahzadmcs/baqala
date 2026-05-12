<?php $this->load->view('admin/home/header'); ?>
<style>
	.dataTables_wrapper::-webkit-scrollbar {
		display: none;
	}

	.nav-md .container.body .right_col {
		padding: 10px 10px 0;
		margin-left: 230px;
	}

	@media only screen and (max-width: 600px) {
		.modal-dialog-aside {
			width: 100% !important;
			max-width: 100% !important;
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
					<h4>Delivery Incentive Slab</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/incentives/list'); ?>">Delivery Incentive Slab</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if (check_action_permission(get_user_role(), 'delivery_target_and_incentive', 'delete')): ?>
						<button class="btn btn-custom-danger btn-sm pull-right me-2" onclick="confirm('Really want to delete this incentive(s)?') ? $('#delete_form').submit() : false;" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					<?php endif;
					if (check_action_permission(get_user_role(), 'delivery_target_and_incentive', 'add')): ?>
						<a href="<?php echo base_url('admin/incentives/add'); ?>" type="button" class="btn btn-custom-success btn-sm pull-right me-2" title="Add"><i class="fa fa-plus"></i> Add New Slab</a>
					<?php endif;
					if (check_action_permission(get_user_role(), 'delivery_target_and_incentive', 'Export_pdf_all')): ?>
						<button type="button" class="btn btn-custom-white btn-sm" id="exportPdfBtn">
							<i class="mdi mdi-file-pdf"></i> Export PDF
						</button>
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
					<div class="card-body">
						<?php echo form_open("admin/incentives/delete", array("id" => "delete_form")); ?>
						<table id="incentiveTable" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
							<thead>
								<tr>
									<th>#</th>
									<th>#</th>
									<th>Incentive ID</th>
									<th>Incentive Name</th>
									<th>Incentive Period </th>
									<th>Target </th>
									<th>Deduction </th>
									<th>Daily Bonus </th>
									<th>Monthly Bonus </th>
									<th>No. of Riders </th>
									<th>Status</th>
									<th>Created</th>
									<th>Updated</th>
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

<div class="modal fade fixed-left emp-list-modal" aria-labelledby="#empModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0" id="empModalLabel">Incentive Rider List</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" id="incentiveEmpList">

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
	$(document).ready(function() {
		$('#incentiveTable').dataTable({
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
			"fixedHeader": true,
			"order": [],
			"ajax": {
				url: "<?php echo base_url(); ?>admin/incentives/ajax-list",
				type: "POST",
				error: function(request, error) {
					console.log(" Can't do because: " + JSON.stringify(request));
				},
			},
			"columnDefs": [{
				"targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
				"orderable": false
			}, ]
		});
	});
	$.fn.dataTable.ext.errMode = function(settings, helpPage, message) {
		console.log(message);
	};

	$(document).on('click', '.view-incentive-employees', function() {
		var id = $(this).data('incentiveid'); // Get incentive ID from clicked button
		if (!id) {
			toastr.error('Invalid Incentive ID');
			return;
		}

		$.ajax({
			url: '<?php echo base_url(); ?>admin/incentives/incentiveEmployees',
			method: 'POST',
			data: {
				id: id
			},
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
					$('#incentiveEmpList').html(response.output_html);
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


	$('#exportPdfBtn').click(function() {
		var params = new URLSearchParams(window.location.search);
		var form = $('<form>', {
			action: "<?php echo base_url('admin/incentives/export-data-pdf'); ?>",
			method: 'POST',
			target: '_blank'
		});
		form.append($('<input>').attr('type', 'hidden').attr('name', 'keyword').val(params.get('keyword')));
		$('body').append(form);
		form.submit();
		form.remove();
	});

	$(document).on('click', '.update-status', function () {
		var incentiveId = $(this).data('id');
		var currentStatus = $(this).data('status');
		var newStatus = (currentStatus === 'active') ? 'inactive' : 'active';
		var showCheckbox = (newStatus === 'inactive');

		let htmlContent = `<p>Are you sure you want to change status to <b>${newStatus.toUpperCase()}</b>?</p>`;
		if (showCheckbox) {
			htmlContent += `<div style="margin-top:10px;text-align:left">
				<label>
					<input type="checkbox" class="checkbox" id="unassignEmployees" style="vertical-align: bottom;"> Unassign all employees from this incentive
				</label>
			</div>`;
		}

		Swal.fire({
			title: 'Confirm Status Update',
			html: htmlContent,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Yes, Update',
			cancelButtonText: 'Cancel',
			preConfirm: () => {
				return {
					unassign: $('#unassignEmployees').is(':checked')
				};
			}
		}).then((result) => {
			if (result.isConfirmed) {
				var unassign = result.value ? result.value.unassign : false;
				$.ajax({
					url: "<?php echo base_url('admin/incentives/update-status'); ?>",
					type: 'POST',
					data: {
						id: incentiveId,
						status: newStatus,
						unassign: unassign
					},
					success: function (response) {
						Swal.fire('Updated!', 'Incentive status has been updated.', 'success');
						setTimeout(function(){ location.reload(); }, 1000);
					},
					error: function () {
						Swal.fire('Error!', 'Something went wrong while updating.', 'error');
					}
				});
			}
		});
	});

</script>