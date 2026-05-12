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

</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Delivery VAN</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="javascript:;">Delivery VAN</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if($this->customer->userd($admin_id)->role=="Admin" ){?>
					<button class="btn btn-custom-danger btn-sm pull-right me-2" onclick="confirm('Really want to delete this van?') ? $('#delete_form').submit() : false;" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					<a href="<?php echo base_url('admin/in-house-vehicle/form');?>" type="button" class="btn btn-custom-success btn-sm pull-right" title="Add"><i class="fa fa-plus"></i> Add VAN</a>
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
						<?php echo form_open("admin/in-house-vehicle/delete", array("id"=>"delete_form"));?>
		 					<table id="van-table" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
		 						<thead>
		 							<tr>					  
										<th>#</th>
										<th>Driver ID</th>				  
										<th>Driver Name</th>
										<th>Van No</th>
										<th>Iqama No.</th>  					  
										<th>DL No.</th>  					  
										<th>Last Online</th>		  					  
										<th>Reg. Date</th>	  					  
										<th>Status</th>			  					  
										<th>Appl. Status</th>			  					  
										<th>Tools</th>
									</tr>
		 						</thead>
		 					</table>
		 				<?php echo form_close();?>
 					</div>
 				</div>
 			</div> <!-- end col -->
 		</div> <!-- end row -->
 	</div>
</div>

<?php $this->load->view('admin/home/footer');?>
<script>
$(document).ready(function() {
	$('#van-table').dataTable({
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
		"fixedHeader": true,
		"order":[],
		"ajax":{
			url:"<?php echo base_url();?>admin/in-house-vehicle/list-ajax",
			type:"POST",
			error: function (request, error) {
				console.log(" Can't do because: " + JSON.stringify(request));
			},
		},
		"columnDefs":[
			{
			 "targets":[0,1,2,3,4,5,6,7,8,9,10],
			 "orderable":false
			},
		]
	});
});
$.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) { 
	console.log(message);
};

</script>
