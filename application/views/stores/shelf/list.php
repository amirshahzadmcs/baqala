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
							<h4>Manage Shelf</h4>
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
								<li class="breadcrumb-item"><a href="javascript: void(0);">Shelf</a></li>
								<li class="breadcrumb-item active">List</li>
							</ol>
						</div>
                    </div>
					<div class="col-sm-6">
						<div class="float-end d-none d-sm-block">
							<button class="btn btn-danger btn-sm pull-right" onclick="confirm('Really want to delete this shelf?') ? $('#delete_form').submit() : false;" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>
						</div>
					</div>
                </div>
            </div>
        </div>
        <!-- end page title -->
		
        <div class="container-fluid">
            <div class="page-content-wrapper">
				<div class="row">
					<div class="col-4">
						<div class="card">
							<div class="card-body">
								<form class="needs-validation" method="POST" action="<?php echo base_url('store/shelf/submit');?>" novalidate>
									<div class="row">
										<div class="col-md-12">
											<div class="mb-3">
												<label for="rack_id" class="form-label">Select Rack</label>
												<select class="form-select" name="rack_id" id="rack_id" required>
													<option value="">--- Select Rack ---</option>
													<?php 
													foreach($racks as $rack){?>
													<option value="<?php echo $rack->id;?>"><?php echo $rack->rack_name;?></option>
													<?php } ?>
												</select>
												<div class="invalid-feedback">
													Please select a rack.
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="mb-3">
												<label for="shelf_name" class="form-label">Shelf Name</label>
												<input type="text" class="form-control" id="shelf_name" placeholder="Shelf Name" name="shelf_name" required>
												<div class="invalid-feedback">
													Please provide a shelf name.
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="mb-3">
												<label for="status-select" class="form-label">Status</label>
												<select class="form-select" name="status" id="status-select" required>
													<option value="">--- Select Status ---</option>
													<option value="1">Active</option>
													<option value="0">Deactive</option>
												</select>
												<div class="invalid-feedback">
													Please provide a status.
												</div>
											</div>
										</div>
									</div>
									
									<div>
										<button class="btn btn-primary" type="submit">Submit form</button>
									</div>
								</form>

							</div>
						</div>
					</div>
					<div class="col-8">
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
								<?php echo form_open('store/shelf/delete', array("id"=>"delete_form"));?>
								<table id="datatableShelf" class="table table-striped table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
									<thead>
										<tr>					  
											<th>#</th>
											<th>Rack ID</th>
											<th>Rack Name</th>
											<th>shelf Name</th>
											<th>shelf ID</th>
											<th>Created On</th>
											<th>Updated On</th>
											<th>Status</th>
											<th>Tools</th>
										</tr>
									</thead>

									<tbody>
										
									</tbody>
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
	$('#datatableShelf').dataTable({
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
			url:"<?php echo base_url();?>store/shelf/ajaxlist",
			type:"POST"
		},
		"columnDefs":[
			{
			 "targets":[0,1,2,3,4,5,6,7],
			 "orderable":false
			},
		]
	});
});
$.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) { 
	console.log(message);
};	
</script>
