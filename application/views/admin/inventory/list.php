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
					<h4>Purchase Return List</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/pr/list');?>">Purchase Return</a></li>
						<li class="breadcrumb-item active">Purchase Return List</li>
					</ol>
				</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<button type="button" class="btn btn-custom-success btn-sm pull-right me-1" data-bs-toggle="modal" data-bs-target=".purchase-modal"><i class="fa fa-plus"></i> Add Purchase Return</button>
				</div>
				<?php if($this->admin->getInfo()){
				$info = explode("--", $this->admin->getInfo());
				$info_type = $info[0];
				$msg_data = $info[1];
				if($info_type == 2){
				?>
				<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				<strong><?php echo $msg_data;?></strong>
				</div>

				<?php } else{?>
				<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					<strong><?php echo $msg_data;?></strong>
				</div>
				<?php } ?> <?php } $this->admin->removeInfo();?>
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
		 					<table id="pr-table" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
		 						<thead>
									<tr>
										<th width="42px">Sr. No</th>
										<th width="65px">P.O Return No.</th>				  
										<th width="45px">P.O No.</th>				  
										<th width="45px">Vendor</th>				  
										<th width="55px">P.O Date</th>				  
										<th width="55px">P.O Value</th>				  
										<th width="50px">P.O Term</th>				  
										<th width="50px">Status</th>
										<th width="50px">Created </th>							
										<th width="50px">Updated </th>							
										<th width="75px">Action</th>
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

<!-- Modal -->
<div class="modal fade purchase-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0">Purchase Return</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url('admin/pr/form'); ?>" method="get" id="return_form">
					<div class="col-md-12" style="padding: 13px;margin: 10px 0px;">
						<div class="form-group">
							<label for="po_id" class="col-form-label">SEARCH PO TO RETURN: </label>
							<select class="form-control" id="po_id" name="po_id" required>
								<option value="">--- Select PO Number ---</option>
								<?php foreach($grv_list as $po_no){ ?>
								<option value="<?php echo $po_no->po_id; ?>"><?php echo $po_no->po_no; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
                <button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="return_form" class="btn btn-success">Search</button>
            </div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php $this->load->view('admin/home/footer');?>
<script>
$(document).ready(function() {
	$('#pr-table').dataTable({
		"lengthMenu": [[25, 50, 100, 500], [25, 50, 100, 500]],
		order: [[0, 'asc']],
		dom: 'Blfrtip',
		buttons: [
			{
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
		"processing":true,
		"serverSide":true,
		fixedHeader: true,
		"order":[],
		"ajax":{
				url:"<?php echo base_url();?>admin/purchase_return/get_list",
				type:"POST"
			},
			"columnDefs":[
			{
			 "targets":[0,1,2,3,4,5,6,7,8,9,10],
			 "orderable":false
			},
		]
	});
});

function changeActionAndSubmit(action) {
	document.getElementById('myform').action = action;
	document.getElementById('myform').submit();
}

</script>
