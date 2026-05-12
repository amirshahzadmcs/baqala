<?php $this->load->view('admin/home/header');?>
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
					<h4>Tax Master</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/tax-setting/list">Tax Master</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			 </div>
			 <?php  $admin_id= $this->session->userdata('admin_id'); ?>
			 <div class="col-sm-6">
				<div class="float-end d-sm-block">
					<button type="button" class="btn btn-custom-danger btn-sm pull-right" onclick="deleteAction()" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					
					&nbsp;
					<a class="btn btn-custom-success btn-sm pull-right me-1" title="Add New Tax" href="<?php echo base_url('admin/tax-setting/add')?>"><i class="fa fa-plus"></i> Add New Tax</a>
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
				<?php } else {?>
				<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					<strong><?php echo $msg_data; ?></strong>
				</div>
				<?php }}
				$this->admin->removeInfo();?>
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
								<table id="taxTable" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
									<thead>
										<tr>
											<th>#</th>
											<th>Tax Name</th>
											<th>Tax Name (AR)</th>
											<th>Tax Value</th>
											<th>Included</th>
											<th>Created</th>
											<th>Updated</th>
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


<?php $this->load->view('admin/home/footer');?>
<script>
$(document).ready(function() {
	$('#taxTable').dataTable({
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
		"ajax":{
			url:"<?php echo base_url();?>admin/tax-setting/ajax-list",
			type:"POST"
		},
		"columnDefs":[
			{
			 "targets":[0,1,2,3,4,5,6,7],
			 "orderable":false
			},
		],
	});
});

function deleteAction() {
	var inputCount = $('[name="checklist[]"]:checked').length;
	if(inputCount > 0){
		if (confirm("Do you want to delete selected item?") == true) {
			changeActionAndSubmit('admin/tax-setting/delete');
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

</script>
