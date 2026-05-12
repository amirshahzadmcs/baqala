<?php $this->load->view('admin/home/header');?>
<style>
.dataTables_wrapper::-webkit-scrollbar {
  display: none;
}
.nav-md .container.body .right_col {
    padding: 10px 10px 0;
    margin-left: 230px;
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
				<h4>DL Transaction</h4>
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
					<li class="breadcrumb-item active">List</li>
				</ol>
			</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if(check_action_permission(get_user_role(), 'dl_transactions', 'delete')):?>
					<button type="button" class="btn btn-custom-danger btn-sm pull-right mr-2" onclick="deleteAction()" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					<?php endif; ?>
				</div>
				<?php if($this->admin->getInfo()){
				$info = explode("--", $this->admin->getInfo());
				$info_type = $info[0];
				$msg_data = $info[1];
				if($info_type == 1){
				?>
				<div class="alert alert-success alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					<strong><?php echo $msg_data; ?></strong>
				</div>
				
				<?php } else{?>
				<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					<strong><?php echo $msg_data;?></strong>
				</div>
				<?php }} $this->admin->removeInfo();  ?>
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
						<form action="<?php echo base_url('admin/dl-transaction/list'); ?>" method="get" id="filter_form">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Employee No. / Request No. / Trans ID</label>
										<input type="search" id="keyword" name="keyword" placeholder="Search by Employee Name or Employee No." value="<?php echo $this->input->get('keyword') ? $this->input->get('keyword') : ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>
								
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label for="trans_type">Transaction Type</label>
										<select name="trans_type" id="trans_type" class="form-select">
											<option value="">Select Appointment Type</option>
											<option value="0" <?php echo ($this->input->get('trans_type') == '0') ? ' selected ' : '';?>>DL Appointment</option>
											<option value="1" <?php echo ($this->input->get('trans_type') == '1') ? ' selected ' : '';?>>DL File</option>
											<option value="2" <?php echo ($this->input->get('trans_type') == '2') ? ' selected ' : '';?>>DL Class 1</option>
											<option value="3" <?php echo ($this->input->get('trans_type') == '3') ? ' selected ' : '';?>>DL Class 2</option>
											<option value="4" <?php echo ($this->input->get('trans_type') == '4') ? ' selected ' : '';?>>DL Computer Exam</option>
											<option value="5" <?php echo ($this->input->get('trans_type') == '5') ? ' selected ' : '';?>>DL Final Test</option>
											<option value="6" <?php echo ($this->input->get('trans_type') == '6') ? ' selected ' : '';?>>DL Repeat Exam</option>
											<option value="7" <?php echo ($this->input->get('trans_type') == '7') ? ' selected ' : '';?>>DL Medical</option>
											<option value="8" <?php echo ($this->input->get('trans_type') == '8') ? ' selected ' : '';?>>DL Basma</option>
											<option value="9" <?php echo ($this->input->get('trans_type') == '9') ? ' selected ' : '';?>>DL Issued</option>
										</select>
									</div>
								</div>

								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Request Date Between (From and To)</label>
										<div class="input-daterange input-group" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
											<input type="text" class="form-control" id="req_from" name="req_from" value="<?php echo $this->input->get('req_from') ? $this->input->get('req_from') : ''; ?>" autocomplete="off" placeholder="Start Date" />
											<input type="text" class="form-control" id="req_to" name="req_to" value="<?php echo $this->input->get('req_to') ? $this->input->get('req_to') : ''; ?>" autocomplete="off" placeholder="End Date" />
										</div>
									</div>
								</div>

								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Transaction Date Between (From and To)</label>
										<div class="input-daterange input-group" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
											<input type="text" class="form-control" id="from" name="from" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" autocomplete="off" placeholder="Start Date" />
											<input type="text" class="form-control" id="to" name="to" value="<?php echo $this->input->get('to') ? $this->input->get('to') : ''; ?>" autocomplete="off" placeholder="End Date" />
										</div>
									</div>
								</div>
							</div>
							
							<div class="row mt-2">
								<div class="col-lg-6 col-md-6 col-sm-12"></div>
								<div class="col-lg-6 col-md-6 col-sm-12">
									<button type="submit" class="btn btn-success btn-md float-end ms-2">Apply Filter</button>
									<a href="<?php echo base_url('admin/dl-transaction/list'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
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
							<table id="dlTable" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
								<thead>
									<tr>
										<th>#</th>
										<th>S.No.</th>
										<th>Trans ID</th>
										<th>Request No.</th>
										<th>Emp. No</th>
										<th>Emp. Name</th>
										<th>DL Type</th>
										<th>Trans Type</th>
										<th>Cost Involve</th>
										<th>Trans Amt.</th>
										<th>Request Date</th>
										<th>Trans Date</th>
										<th>Created At</th>
										<th>Action</th>
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

<div class="modal fade fixed-left form-center-modal" id="formRequestModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
			
		</div>
	</div>
</div>

<?php $this->load->view('admin/home/footer');?>
<script>
$(document).ready(function() {
	$('#dlTable').dataTable({
		"lengthMenu": [[25, 50, 100, 500], [25, 50, 100, 500]],
		//order: [[0, 'asc']],
		dom: 'Blfrtip',
		buttons: [
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
		"processing":true,
		"serverSide":true,
		"fixedHeader": true,
		"searching": false,
		"ajax":{
			url:"<?php echo base_url();?>admin/dl-transaction/ajax-list?keyword=<?php echo $this->input->get('keyword')?>&trans_type=<?php echo $this->input->get('trans_type')?>&req_from=<?php echo $this->input->get('req_from')?>&req_to=<?php echo $this->input->get('req_to')?>&from=<?php echo $this->input->get('from')?>&to=<?php echo $this->input->get('to')?>",
			type:"POST"
		},
		"columnDefs":[
			{
			 "targets":[0,1,2,3,4,5,6,7,8,9,10,11,12,13],
			 "orderable":false
			},
		],
	});
	
});


function deleteAction() {
	var inputCount = $('[name="checklist[]"]:checked').length;
	if(inputCount > 0){
		if (confirm("Do you want to delete selected transaction?") == true) {
			changeActionAndSubmit('admin/dl-transaction/delete');
		} else {
			userPreference = "Action Cancelled!";
		}
	}else{
		alert('Plese select check box first');
	}
}

function changeActionAndSubmit(action) {
	document.getElementById('myform').action = action;
	document.getElementById('myform').submit();
}

$(document).on('click', '.load_edit_modal', function() {
	let id = $(this).data('id');
	$.ajax({
		url: "<?php echo base_url('admin/dl-transaction/edit/'); ?>" + id,
		type: 'GET',
		dataType: 'json',
		success: function(response) {
			if (response.type === 'success') {
				$('#formRequestModal').modal('show');
				$('#formRequestModal .modal-content').html(response.output_html);
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
