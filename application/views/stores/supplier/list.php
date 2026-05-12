<?php $this->load->view('company/layout/header');?>
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
							<h4>Supplier</h4>
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
								<li class="breadcrumb-item"><a href="javascript: void(0);">Supplier</a></li>
								<li class="breadcrumb-item active">Supplier List</li>
							</ol>
						</div>
                    </div>
					<div class="col-sm-6">
						<div class="float-end d-none d-sm-block">
							<a href="<?php echo base_url('add-supplier');?>" class="btn btn-sm btn-primary">Add Supplier</a>
							<button class="btn btn-danger btn-sm pull-right" onclick="confirm('Really want to delete selected supplier?') ? $('#delete_form').submit() : false;" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>
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
								<?php echo form_open("delete-supplier", array("id"=>"delete_form"));?>
									<table id="datatable-buttons" class="table dataTable table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
										<thead>
											<tr>
												<th>S No.</th>
												<th>#</th>
												<th>Name</th>
												<th>Email</th>
												<th>Mobile</th>
												<th>Address</th>
												<th>VAT No</th>
												<th>CR No.</th>
												<th>Status</th>
												<th>Created On</th>
												<th>Tools</th>
											</tr>
										</thead>
										<tbody>
											
										</tbody>
									</table>
								<?php echo form_close();?>
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

<?php $this->load->view('company/layout/footer');?>
<script>
	$(document).ready(function() {
		$('#datatable-buttons').dataTable({
			"lengthMenu": [[25, 50, 100, 500], [25, 50, 100, 500]],
			order: [[0, 'asc']],
			dom: 'Blfrtip',
			"buttons": ["copy", "excel", "pdf"],
			"responsive": true,
			"autoWidth": true,
			"processing":true,  
			"serverSide":true,
			"fixedHeader": false,
			"keys": true,	  
			"order":[],  
			"ajax":{  
					url:"<?php echo base_url();?>company/supplier/get_list",  
					type:"POST"
				},  
				"columnDefs":[  
				{  
				 "targets":[0,1],  
				 "orderable":false
				},  
			]
		})
	});
</script>