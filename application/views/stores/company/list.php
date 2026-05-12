<?php $this->load->view('retailer/layout/header');?>
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
							<h4>Firm</h4>
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
								<li class="breadcrumb-item"><a href="javascript: void(0);">Firm</a></li>
								<li class="breadcrumb-item active">Firm List</li>
							</ol>
						</div>
                    </div>
					<div class="col-sm-6">
						<div class="float-end d-none d-sm-block">
							<a href="<?php echo base_url('add-company');?>" class="btn btn-success">Add Firm</a>
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
									<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button></div>
									<?php } else{?>
									<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>
									<?php } echo $msg_data; ?> </div><?php } $this->customer->removeInfo();?>
								</div>
								<table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
									<thead>
										<tr>
											<th>Company Name</th>
											<th>Address</th>
											<th>Email</th>
											<th>Mobile</th>
											<th>Created date</th>
											<th>Last Updated</th>
										</tr>
									</thead>

									<tbody>
										<?php foreach($companies as $company){ ?>
										<tr>
											<td><?php echo $company->company_name;?></td>
											<td><?php echo $company->company_address;?></td>
											<td><?php echo $company->company_email ;?></td>
											<td><?php echo $company->company_mobile;?></td>
											<td><?php echo $company->created_at;?></td>
											<td><?php echo $company->updated_at;?></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>

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

<?php $this->load->view('retailer/layout/footer');?>
<script>
$(document).ready(function() {
    $("#datatable-buttons").DataTable({
        //lengthChange: !1,
        buttons: ["copy", "excel", "pdf", "colvis"]
    }).buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)"), 
	$(".dataTables_length select").addClass("form-select form-select-sm")
});
</script>