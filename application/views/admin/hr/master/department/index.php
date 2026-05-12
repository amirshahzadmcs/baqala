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
		.modal-dialog-aside{
			width: 100% !important;
			max-width: 100% !important;
		}
	}

	.department-modal .modal-dialog-aside {
		width: 30%;
		max-width: 80%;
		height: 100%;
		margin: 0;
		transform: translate(0);
		transition: transform .2s;
	}

	.department-modal .modal-dialog-aside .modal-content {
		height: inherit;
		border: 0;
		border-radius: 0;
	}

	.department-modal .modal-dialog-aside .modal-content .modal-body {
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
					<h4>Department Master</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item active">Department List</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if (check_action_permission(get_user_role(), 'departments', 'delete')): ?>
						<button type="button" class="btn btn-custom-danger btn-sm pull-right" onclick="deleteAction()" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					<?php endif;
					if (check_action_permission(get_user_role(), 'departments', 'add')): ?>
						&nbsp;
						<a class="btn btn-custom-success btn-sm pull-right me-1" title="Own Store" href="<?php echo base_url('admin/hr/master/department/add') ?>"><i class="fa fa-plus"></i> Add Department</a>
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
						<form action="<?php echo base_url('admin/hr/master/department'); ?>" method="get" id="filter_form">
							<div class="row p-2">
								<div class="col-6 px-1">
									<div class="form-group">
										<label>Search by Department Name or Abbreviation</label>
										<input type="text" id="title" name="title" value="<?php echo $this->input->get('title') ? $this->input->get('title') : ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>
								<div class="col-6 px-1">
									<div class="form-group mb-2">
										<label class="d-block">Select Status </label>
										<select name="status" class="form-select">
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

								<div class="col-md-12 px-1" style="padding-top: 10px;">
									<button type="submit" class="btn btn-custom-success btn-sm ms-2 float-end">Apply Filter</button>
									<a href="<?php echo base_url('admin/hr/master/department'); ?>" class="btn btn-custom-danger btn-sm float-end me-2">Clear Filter</a>
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
							<table id="store-table" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
								<thead>
									<tr>
										<th>#</th>
										<th>ID</th>
										<th>Name</th>
										<th>Arabic Name</th>
										<th>Abbreviation</th>
										<th>Manager Name</th>
										<th>Employees Count</th>
										<th>Status</th>
										<th>Created At</th>
										<th>Updated At</th>
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

<!-- Modal -->
<div class="modal fade fixed-left department-modal" id="departmentModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
			
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this->load->view('admin/home/footer'); ?>
<script>
	$(document).ready(function() {
		$('#store-table').dataTable({
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
			searching: false,
			"ajax": {
				url: "<?php echo base_url(); ?>admin/hr/master/Department/get_list?title=<?php echo $this->input->get('title'); ?>&status=<?php echo $this->input->get('status'); ?>",
				type: "POST"
			},
			"columnDefs": [{
				"targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
				"orderable": false
			}, ],
		});
	});

	function deleteAction() {
		var inputCount = $('[name="checklist[]"]:checked').length;
		if (inputCount > 0) {
			if (confirm("Do you want to delete selected department?") == true) {
				changeActionAndSubmit('admin/hr/master/department/delete');
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

	function viewAllotments(id){
		$.ajax({
			type: "POST",
			url: "<?php echo base_url('admin/hr/master/department/employee-list'); ?>",
			data: {
				'id': id
			},
			dataType: "json",
			success: function(response) {
				if (response.type === 'success') {
					$('.department-modal').modal('show');
					$('.department-modal .modal-content').html(response.output_html);
				} else {
					toastr.error(response.message);
				}
			},
			error: function(request, error) {
				console.log(" Can't do because: " + JSON.stringify(request));
				toastr.error(JSON.stringify(request));
			},
		});
	}
</script>