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
					<h4>Employee Level</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item active">Employee Level</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if ($this->customer->userd($admin_id)->role == "Admin") { ?>
						<button type="button" class="btn btn-custom-danger btn-sm pull-right" onclick="deleteAction()" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					<?php } ?>
					&nbsp;
					<a class="btn btn-custom-success btn-sm pull-right me-1" title="Own Store" href="<?php echo base_url('admin/hr/master/employee-level/add') ?>"><i class="fa fa-plus"></i> Add Employee Level</a>
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
				<?php if ($this->input->get('msg')) { ?>
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<strong><?php echo $this->input->get('msg'); ?></strong>
					</div>
				<?php } ?>
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
						<form action="<?php echo base_url('admin/hr/master/employee-level'); ?>" method="get" id="filter_form">
							<div class="row p-2">
								<div class="col-6 px-1">
									<div class="form-group">
										<label>Search by Employee Level</label>
										<input type="text" id="title" name="title" value="<?php echo $this->input->get('title') ? $this->input->get('title') : ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>
								<div class="col-6 px-1">
									<div class="form-group mb-2">
										<label class="d-block">Select Status </label>
										<select name="status" class="form-select">
											<option value="">All Status</option>
											<option value="active" <?php if ($this->input->get('status') == 'active') { echo 'selected'; } ?>>Active</option>
											<option value="inactive" <?php if ($this->input->get('status') == 'inactive') { echo 'selected'; } ?>>Inactive</option>
										</select>
									</div>
								</div>
								
								<div class="col-md-12 px-1" style="padding-top: 10px;">
									<button type="submit" class="btn btn-custom-success btn-sm ms-2 float-end">Apply Filter</button>
									<a href="<?php echo base_url('admin/hr/master/employee-level'); ?>" class="btn btn-custom-danger btn-sm float-end me-2">Clear Filter</a>
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
										<th>Name</th>
										<th>Arabic Name</th>
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
				url: "<?php echo base_url(); ?>admin/hr/master/employee_level/list?title=<?php echo $this->input->get('title');?>&status=<?php echo $this->input->get('status');?>",
				type: "POST"
			},
			"columnDefs": [{
				"targets": [0, 1, 2, 3, 4, 5, 6],
				"orderable": false
			}, ],
		});
	});

	function deleteAction() {
		var inputCount = $('[name="checklist[]"]:checked').length;
		if (inputCount > 0) {
			if (confirm("Do you want to delete selected item?") == true) {
				changeActionAndSubmit('admin/hr/master/employee-level/delete');
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
</script>
