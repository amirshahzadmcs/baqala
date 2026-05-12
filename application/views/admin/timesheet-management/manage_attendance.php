<?php $this->load->view('admin/home/header'); ?>
<style>
	.dataTables_wrapper::-webkit-scrollbar {
		display: none;
	}

	.nav-md .container.body .right_col {
		padding: 10px 10px 0;
		margin-left: 230px;
	}


	.main-body {
		padding: 15px;
	}

	.main-body hr {
		margin: 0.7rem 0;
	}

	.card {
		box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
	}

	.card {
		position: relative;
		display: flex;
		flex-direction: column;
		min-width: 0;
		word-wrap: break-word;
		background-color: #fff;
		background-clip: border-box;
		border: 0 solid rgba(0, 0, 0, .125);
		border-radius: .25rem;
	}

	.card-body {
		flex: 1 1 auto;
		min-height: 1px;
		padding: 1rem;
	}

	.gutters-sm {
		margin-right: -8px;
		margin-left: -8px;
	}

	.gutters-sm>.col,
	.gutters-sm>[class*=col-] {
		padding-right: 8px;
		padding-left: 8px;
	}

	.mb-3,
	.my-3 {
		margin-bottom: 1rem !important;
	}

	.bg-gray-300 {
		background-color: #e2e8f0;
	}

	.h-100 {
		height: 100% !important;
	}

	.shadow-none {
		box-shadow: none !important;
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
		width: 25%;
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
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Manage Attendance</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/asset/all-conditions'); ?>">Manage Attendance</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>

			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a href="javascript:;" class="btn btn-custom-danger btn-sm pull-right me-1" onclick="location.reload()"> <i class="fas fa-sync"></i> </a>
					<button href="javascript:;" class="btn btn-custom-success btn-sm pull-right me-1" id="load_add_modal">Create & Edit</button>
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
						<form action="<?php echo base_url('admin/manage-attendance?emp=' . $this->input->get('emp') . '&from=' . $this->input->get('from') . '&to=' . $this->input->get('to')); ?>" method="get" id="filter_form">
							<div class="row">
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
										<label>Employee Id</label>
										<select class="form-control select2" name="emp" id="">
											<option value="">[Any]</option>
											<?php foreach ($employees as $emp) { ?>
												<option value="<?php echo $emp->id; ?>" <?php echo $this->input->get('emp') == $emp->id ? 'selected' : ''; ?>><?php echo $emp->emp_no; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>

							<div class="row mt-2 justify-content-end">
								<div class="col-lg-6 col-md-6 col-sm-12">
									<button type="submit" class="btn btn-success btn-md float-end ms-2">Apply Filter</button>
									<a href="<?php echo base_url('admin/vehicle/get-timesheet'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
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
							<table id="attendance_table" class="table text-center table-striped table-bordered jambo_table bulk_action" style="width:100%">
								<thead>
									<tr>
										<th>S.No.</th>
										<th>Emp No</th>
										<th>Employee Name</th>
										<th>Date</th>
										<th>New Status</th>
										<th>remark</th>
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

<!-- Attendance Log Model -->
<div class="modal fade staticBackdrop fixed-left addCashModal" id="addCashModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="#addCashModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">

		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php $this->load->view('admin/home/footer'); ?>
<script type="text/javascript">
	$(function() {
		$('.checkAll').click(function() {
			if (this.checked) {
				$(".checkboxesall").prop("checked", true);
			} else {
				$(".checkboxesall").prop("checked", false);
			}
		});

		$(".checkboxesall").click(function() {
			var numberOfCheckboxes = $(".checkboxesall").length;
			var numberOfCheckboxesChecked = $('.checkboxesall:checked').length;
			if (numberOfCheckboxes == numberOfCheckboxesChecked) {
				$(".checkAll").prop("checked", true);
			} else {
				$(".checkAll").prop("checked", false);
			}
		});
	});

	$(document).ready(function() {
		$('#filterModal').on('shown.bs.modal', function() {
			$('#datepicker6_from, #datepicker6_to').datepicker({
				format: "dd M, yyyy",
				autoclose: true,
				container: '#filterModal'
			});
		});
	});

	$(document).ready(function() {
		$('#load_add_modal').click(function() {
			$.ajax({
				url: "<?php echo base_url('admin/manage-attendance/add'); ?>",
				type: 'GET',
				success: function(response) {
					$('#addCashModal').modal('show');
					$('#addCashModal .modal-content').html(response);
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

	$(document).ready(function() {
		initializeDataTable();
	});

	function initializeDataTable() {
		if ($.fn.DataTable.isDataTable('#attendance_table')) {
			$('#attendance_table').DataTable().destroy();
		}
		$('#attendance_table').dataTable({
			"lengthMenu": [
				[25, 50, 100, 500],
				[25, 50, 100, 500]
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
			processing: true,
			serverSide: true,
			responsive: true,
			fixedHeader: true,
			searching: false,
			ajax: {
				url: "<?php echo base_url('admin/manage-attendance/get-list?emp=' . $this->input->get('emp') . '&from=' . $this->input->get('from') . '&to=' . $this->input->get('to')); ?>",
				type: "POST",
				error: function(request, error) {
					console.log(" Can't do because: " + JSON.stringify(request));
				},
			},

			columnDefs: [{
					targets: [0, 1, 2, 3, 4, 5],
					orderable: false,
				},
				{
					targets: [2, 5],
					className: 'text-start'
				}
			],

		});
	}
</script>