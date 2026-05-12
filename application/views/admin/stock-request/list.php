<?php $this->load->view('admin/home/header');?>
<style>
.dataTables_wrapper::-webkit-scrollbar {
  display: none;
}
.nav-md .container.body .right_col {
    padding: 10px 10px 0;
    margin-left: 230px;
}

.modal .modal-dialog-aside{
	width: 350px;
	max-width:80%; height: 100%; margin:0;
	transform: translate(0); transition: transform .2s;
}


.modal .modal-dialog-aside .modal-content{  height: inherit; border:0; border-radius: 0;}
.modal .modal-dialog-aside .modal-content .modal-body{ overflow-y: auto }
.modal.fixed-left .modal-dialog-aside{ margin-left:auto;  transform: translateX(100%); }
.modal.fixed-right .modal-dialog-aside{ margin-right:auto; transform: translateX(-100%); }

.modal.show .modal-dialog-aside{ transform: translateX(0);  }

.stockModalFullscreen .table thead tr{
	background: #c8f5c9;
    color: #000;
    font-size: 11px;
    font-weight: 600;
}
.stockModalFullscreen .table>:not(caption)>*>* {
    padding: 0.4rem 0.5rem;
	font-size: 13px;
}
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Stock Transfer Request</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="javascript:;">Stock Transfer Request</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if($this->customer->userd($admin_id)->role=="Admin" ){?>
					<!--
					<button type="button" class="btn btn-danger btn-sm pull-right" onclick="deleteAction()" title="Delete"><i class="fa fa-trash"></i></button>
					-->
					<?php } ?>
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
				<!-- <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button> -->
						<?php } else{?>
							<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								<strong><?php echo $msg_data;?></strong>
							</div>
						 <!-- <div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button> -->
						<?php } ?> <?php } $this->admin->removeInfo();?>
				<!-- </div> -->
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
						<h4 class="header-title">Advance Filter</h4>
						<form action="<?php echo base_url(); ?>admin/stockrequest" method="get" id="filter_form">
							<div class="row">
								<div class="col-4">
									<div class="form-group mb-2">
										<label>Select Store</label>
										<select class="form-control show-tick select2" name="store_id" data-placeholder="Choose Store...">
											<option value="">Select</option>
											<?php foreach($stores as $store){?>
											<option value="<?php echo $store->id;?>" <?php echo ($this->input->get('store_id') == $store->id) ? 'selected':'';?>><?php echo $store->store_name;?></option>
											<?php }?>
										</select>
									</div>
								</div>
								
								<div class="col-3">
									<div class="form-group mb-2">
										<label>Date From</label>
										<input type="date" id="_from" name="from" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" autocomplete="off" class="form-control col-md-7 col-xs-12" />
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-2">
										<label>Date To</label>
										<input type="date" id="_to" name="to" value="<?php echo $this->input->get('to') ? $this->input->get('to') : ''; ?>" autocomplete="off" class="form-control col-md-7 col-xs-12" />
									</div>
								</div>
								<div class="col-2">
									<div class="form-group mb-2">
										<label class="d-block">Select Status </label>
										<select style="height:410px;" name="status" class="form-control select2 w-100">
											<option value="">Select Status</option>
											<option value="1" <?php echo ($this->input->get('status') == 1) ? 'selected':'';?>>Pending</option>
											<option value="2" <?php echo ($this->input->get('status') == 2) ? 'selected':'';?>>Accepted</option>
											<option value="3" <?php echo ($this->input->get('status') == 3) ? 'selected':'';?>>Approved</option>
											<option value="4" <?php echo ($this->input->get('status') == 4) ? 'selected':'';?>>Rejected</option>
										</select>
									</div>
								</div>
								<div class="col-md-12" style="padding-top: 6px;">
									<a href="<?php echo base_url('admin/stockrequest'); ?>" class="btn btn-custom-danger btn-sm">Clear Filter</a>
									<button type="submit" class="btn btn-custom-success btn-sm">Apply Filter</button>
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
		 					<table id="vendor-table" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
		 						<thead>
		 							<tr>					  
									 	<th>#</th>
										<th>ID</th>			  
										<th>Source Store</th>			  
										<th>Target Store</th>			  
										<th>Created At</th>				  
										<th>Exp Delivery Date</th>				  
										<th>Status</th>
										<th>No. of SKUs</th>							
										<th>Total Units</th>
										<th>Reason</th>
										<th>Created by</th>
										<th>Action</th>
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

<div class="modal fade stockModalFullscreen" tabindex="-1" aria-labelledby="#stockModalFullscreenLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title mt-0" id="stockModalFullscreenLabel">STOCK TRANSFER REQUEST</h6>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href='<?php echo base_url(); ?>admin/stockrequest'"></button>
			</div>
			<div class="modal-body">
				
			</div>
			<div class="modal-footer">
				<button type="button" onclick="window.location.href='<?php echo base_url(); ?>admin/stockrequest'" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this->load->view('admin/home/footer');?>
<script>
$(document).ready(function() {
	$('#vendor-table').dataTable({
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
			/*
			{
				extend: "pdfHtml5",
				className: "btn-md"
			},
			{
				extend: "print",
				className: "btn-md"
			},*/
		],
		"responsive": true,
		"processing":true,
		"serverSide":true,
		fixedHeader: true,
		"order":[],
		"ajax":{
				url:"<?php echo base_url();?>admin/stockrequest/get_list",
				type:"POST"
			},
			"columnDefs":[
			{
			"targets":[0,1,2,3,4,5,6,7,8,9,10,11],
			"orderable":false
			},
		]
	});
});
$.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) { 
	console.log(message);
};

function quickView(req_id){
	if(req_id > 0){
		//alert(req_id);
		$.ajax({
			type: "post",
			url: "<?php echo base_url();?>admin/stockrequest/quick_view",
			data: {'id': req_id},
			//dataType: "json",
			success: function (response) {
				//console.log(response);
				$('.stockModalFullscreen .modal-body').html(response);
				$(".stockModalFullscreen").modal('show');
			},
			error: function (request, error) {
				//console.log(" Can't do because: " + JSON.stringify(request));
				$('.stockModalFullscreen .modal-body').html(JSON.stringify(request));
				$(".stockModalFullscreen").modal('show');
			},
		});
	}else{
		alert('Invalid request id!');
	}
}
</script>
