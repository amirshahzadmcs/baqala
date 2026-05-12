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
					<h4>Supplier Management</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item active">Supplier List</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if (check_action_permission(get_user_role(), 'manage_suppliers', 'delete')): ?>
						<button type="button" class="btn btn-custom-danger btn-sm pull-right me-1" onclick="deleteAction()" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					<?php endif;
					if (check_action_permission(get_user_role(), 'manage_suppliers', 'setStatusEnable')): ?>
						<button type="button" class="btn btn-custom-success btn-sm pull-right me-1" onclick="EnableStatus()" title="Enable"><i class="fa fa-eye"></i> Enable</button>
					<?php endif;
					if (check_action_permission(get_user_role(), 'manage_suppliers', 'setStatusDisable')): ?>
						<button type="button" class="btn btn-custom-danger btn-sm pull-right me-1" onclick="DisableStatus()" title="Disable"><i class="fa fa-ban"></i> Disable</button>
					<?php endif;
					if (check_action_permission(get_user_role(), 'manage_suppliers', 'add')): ?>
						<a class="btn btn-custom-success btn-sm pull-right me-1" title="Add" href="<?php echo base_url() ?>admin/vendor/add"><i class="fa fa-plus"></i> Add Supplier</a>
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
						<form id="myform" name="myform" method="post" action="">
							<table id="vendor-table" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
								<thead>
									<tr>
										<th>#</th>
										<th>#</th>
										<th>Company Name</th>
										<th>Contact_Person</th>
										<th>Email ID</th>
										<th>Tel No.</th>
										<th>IBAN No.</th>
										<th>Orders</th>
										<th>Value</th>
										<th>Agreement_Exp.</th>
										<th>Credit</th>
										<th>Available</th>
										<th>Status</th>
										<th>Address</th>
										<th>Created</th>
										<th>Tools</th>
									</tr>
								</thead>
							</table>
						</form>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>

<?php $this->load->view('admin/home/footer'); ?>
<script>
	$(document).ready(function() {
		$('#vendor-table').dataTable({
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
			fixedHeader: true,
			"order": [],
			"ajax": {
				url: "<?php echo base_url(); ?>admin/vendor/get_list",
				type: "POST"
			},
			"columnDefs": [{
				"targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15],
				"orderable": false
			}, ]
		});
	});

	function deleteAction() {
		var inputCount = $('[name="checklist[]"]:checked').length;
		if (inputCount > 0) {
			if (confirm("Do you want to delete selected vendor?") == true) {
				changeActionAndSubmit('admin/vendor/delete');
			} else {
				userPreference = "Action Cancelled!";
			}
		} else {
			alert('Plese select check box first');
		}
	}

	var EnableStatus = function() {
		var inputCount = $('[name="checklist[]"]:checked').length;
		if (inputCount > 0) {
			if (confirm("Do you want to enable selected vendor?") == true) {
				changeActionAndSubmit('admin/vendor/setStatusEnable');
			} else {
				userPreference = "Action Cancelled!";
			}
		} else {
			alert('Plese select check box first');
		}
	}

	function DisableStatus() {
		var inputCount = $('[name="checklist[]"]:checked').length;
		if (inputCount > 0) {
			if (confirm("Do you want to disable selected vendor?") == true) {
				changeActionAndSubmit('admin/vendor/setStatusDisable');
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