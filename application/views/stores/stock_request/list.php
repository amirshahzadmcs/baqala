<?php $this->load->view('stores/layout/header');?>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <!-- start page title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="page-title">
							<h4>Stock Transfer Request</h4>
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
								<li class="breadcrumb-item"><a href="javascript: void(0);">Stock Transfer Request</a></li>
								<li class="breadcrumb-item active">List</li>
							</ol>
						</div>
                    </div>
					<div class="col-sm-6">
						<div class="float-end d-none d-sm-block">
							<!--
							<button class="btn btn-danger btn-sm pull-right" onclick="confirm('Really want to delete this request?') ? $('#delete_form').submit() : false;" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>
							-->
							<a class="btn btn-custom-white btn-sm pull-right" title="Add" href="<?php echo base_url('store/warehouse/stock-form');?>"><i class="fa fa-plus"></i> Create Request</a>
						</div>
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
								<div>
									<?php if($this->customer->getInfo()){ 
									$info = explode("--", $this->customer->getInfo());
									$info_type = $info[0];
									$msg_data = $info[1];
									if($info_type == 2){
									?>  
									<div class="alert alert-danger alert-dismissible fade show" role="alert">
										<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										<strong>Error!</strong>  <?php echo $msg_data; ?>
									</div>
									<?php } else{?>
									<div class="alert alert-success alert-dismissible fade show" role="alert">
										<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										<strong>Success!</strong>  <?php echo $msg_data; ?>
									</div>
									<?php } } $this->customer->removeInfo();?>
								</div>
								<?php echo form_open('store/stock_request/delete', array("id"=>"delete_form"));?>
									<table id="request_table" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
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
								<?php echo form_close(); ?>
							</div>
						</div>
					</div> <!-- end col -->
				</div> <!-- end row -->
            </div>
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
<!-- end page content-->

<?php $this->load->view('stores/layout/footer');?>
<script>
$(document).ready(function() {
	$('#request_table').dataTable({
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
			url:"<?php echo base_url();?>store/stockrequest/request_list",
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
</script>
