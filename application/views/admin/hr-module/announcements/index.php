<?php $this->load->view('admin/home/header'); ?>
<style>
	.dataTables_wrapper::-webkit-scrollbar {
		display: none;
	}

	.nav-md .container.body .right_col {
		padding: 10px 10px 0;
		margin-left: 230px;
	}

	.bulkImportModal tbody td,
	.bulkImportModal tbody th,
	.bulkImportModal tbody tr {
		border-color: inherit;
		border-style: solid;
		border-width: 1px;
		padding: 3px 5px !important;
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
		width: 35%;
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

	#responseContainer {
		position: fixed;
		width: 93%;
		top: 60px;
		z-index: 9;
	}
</style>


<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Memos</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/hr/accident-management'); ?>">Memos</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if (check_action_permission(get_user_role(), 'memos_list', 'delete')): ?>
						<button type="button" class="btn btn-custom-danger btn-sm pull-right me-2" onclick="deleteAction()" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					<?php endif;
					if (check_action_permission(get_user_role(), 'memos_list', 'add')): ?>
						<button type="button" class="btn btn-custom-success btn-sm pull-right me-2" title="Add Memo" id="load_add_modal"><i class="fa fa-plus"></i> Add Memo</button>
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
					<div class="card-body">
						<form id="myform" name="myform" method="post" action="">
							<table id="announcementTable" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
								<thead>
									<tr>
										<th>#</th>
										<th>Employee Group</th>
										<th>Notification Type</th>
										<th>Title</th>
										<th>Send Via Email</th>
										<th>Employee After Login</th>
										<th>Notify</th>
										<th>Notify Date</th>
										<th>Created Date</th>
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

<div class="modal fade staticBackdrop fixed-left announcement-form-modal" id="announcementFormModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="#announcementFormModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">

		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php $this->load->view('admin/home/footer'); ?>
<script>
	$(document).ready(function() {
		$('#announcementTable').dataTable({
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
			"ajax": {
				url: "<?php echo base_url(); ?>admin/hr/announcements/ajax-list",
				type: "POST"
			},
			"columnDefs": [{
				"targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
				"orderable": false
			}, ],
		});

	});

	function deleteAction() {
		var inputCount = $('[name="checklist[]"]:checked').length;
		if (inputCount > 0) {
			if (confirm("Do you want to delete selected announcement's?") == true) {
				changeActionAndSubmit('admin/hr/announcements/delete');
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
		$('#load_add_modal').click(function() {
			$.ajax({
				url: "<?php echo base_url('admin/hr/announcements/add'); ?>",
				type: 'GET',
				success: function(response) {
					$('#announcementFormModal').modal('show');
					$('#announcementFormModal .modal-content').html(response);
					$('.select2').select2();
				},
				error: function(request, error) {
					console.log(" Can't do because: " + JSON.stringify(request));
					toastr.error('Error loading view.');
				}
			});
		});
	});

	$(".modal-close").click(function() {
		resetModalData();
	});

	function resetModalData() {
		$('#searchResult').html('');
		$('#searchModalFooter').html('');
		$('#searchResponse').html('');
		$('#responseContainer').html('');
	}

	$(document).on('click', '.load_detail_modal', function() {
		let id = $(this).data('id');
		$.ajax({
			url: "<?php echo base_url('admin/hr/announcements/detail/'); ?>" + id,
			type: 'GET',
			dataType: 'json',
			success: function(response) {
				if (response.type === 'success') {
					$('#announcementFormModal').modal('show');
					$('#announcementFormModal .modal-content').html(response.output_html);
				} else {
					toastr.error(response.message);
				}
			},
			error: function(request, error) {
				console.log("Can't do because: " + JSON.stringify(request));
				toastr.error('Error loading view.');
			}
		});
	});

	$(document).on('click', '.load_edit_modal', function() {
		let id = $(this).data('id');
		$.ajax({
			url: "<?php echo base_url('admin/hr/announcements/edit/'); ?>" + id,
			type: 'GET',
			dataType: 'json',
			success: function(response) {
				if (response.type === 'success') {
					$('#announcementFormModal').modal('show');
					$('#announcementFormModal .modal-content').html(response.output_html);
				} else {
					toastr.error(response.message);
				}
			},
			error: function(request, error) {
				console.log("Can't do because: " + JSON.stringify(request));
				toastr.error('Error loading view.');
			}
		});
	});
</script>