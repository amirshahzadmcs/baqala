<?php $this->load->view('admin/home/header');?>
<style>
.table th, .table td {
    vertical-align: middle;
	padding: 6px 10px;
}
</style>

<!-- start page title -->
<div class="page-title-box">
		<div class="container-fluid">
		 <div class="row align-items-center">
				 <div class="col-sm-6">
					 <div class="page-title">
							 <h4>Warehouse management</h4>
									 <ol class="breadcrumb m-0">
											<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
											<li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/warehouse">Warehouse List</a></li>
											<li class="breadcrumb-item active">Vendor's Detail</li>
									 </ol>
					 </div>
				 </div>
				 <div class="col-sm-6">
						<div class="float-end d-sm-block">
							<a class="btn btn-sm btn-danger pull-right" title="Back" href="<?php echo base_url();?>admin/warehouse"><i class="fa fa-reply"></i> Back</a>
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
								<table id="example" class="table table-bordered">
									<thead>
										<tr><th>Warehouse ID</th><td><?php echo $result->id;?></td></tr>
										<tr><th>Display Name (English)</th><td><?php echo $result->name_english;?></td></tr>
										<tr><th>Display Name (Arabic)</th><td><?php echo $result->name_arabic;?></td></tr>
										<tr><th>Contact Person Name</th><td><?php echo $result->contact_person;?></td></tr>
										<tr><th>Conatct Number</th><td><?php echo $result->warehouse_phone;?></td></tr>
										<tr><th>Email ID</th><td><?php echo $result->warehouse_email;?></td></tr>
										<tr><th>Partner Code</th><td><?php echo $result->partner_code;?></td></tr>
										<tr><th>Processing Time</th><td><?php echo $result->processing_time;?></td></tr>
										<tr><th>Warehouse Complete Address</th><td><?php echo $result->complete_address;?></td></tr>
										<tr><th>Warehouse Status</th><td><?php echo $result->status == 1 ? '<div class="label label-success">Active</div>':'<div class="label label-danger">Deactive</div>';?></td></tr>
										<tr><th>Created On</th><td><?php echo $result->created_at;?></td></tr>
										<tr><th>Updated On</th><td><?php echo $result->updated_at;?></td></tr>
										<tr>
											<th style="vertical-align: inherit;">Warehouse Map IFrame</th>
											<td>
												<?php echo $result->warehouse_map;?>
											</td>
										</tr>
									</thead>
								</table>
  			 			</div>
  			 		</div>
  			 	</div> <!-- end col -->
  			 </div> <!-- end row -->
   		</div>
   </div>
   <!-- container-fluid -->


<?php $this->load->view('admin/home/footer');?>
