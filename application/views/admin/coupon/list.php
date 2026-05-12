<?php $this->load->view('admin/home/header');?>

	<!-- start page title -->
	<div class="page-title-box">
		<div class="container-fluid">
			 <div class="row align-items-center">
				 <div class="col-sm-6">
					 <div class="page-title">
						 <h4>Coupon Management</h4>
						 <ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
							<li class="breadcrumb-item active">Coupon List</li>
						 </ol>
					 </div>
				 </div>
				 <?php  $admin_id= $this->session->userdata('admin_id'); ?>
				 <div class="col-sm-6">
						<div class="float-end d-sm-block">
							<button class="btn btn-custom-danger btn-sm pull-right me-2" onclick="confirm('Really want to delete these items?') ? $('#delete_form').submit() : false;" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i> Delete</button>
							<a class="btn btn-custom-success btn-sm pull-right" title="Add" href="<?php echo base_url('admin/coupon/form')?>"><i class="fa fa-plus"></i> Add New Coupon</a>
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
							<?php echo form_open("admin/coupon/delete", array("id"=>"delete_form"));?>
								<table id="couponTable" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
									<thead>
										<tr>
											<th>#</th>
											<th>S. No.</th>
											<th>Coupon Title</th>
											<th>Coupon Code</th>
											<th>Discount Type</th>
											<th>Discount</th>
											<th>Max. Disc.</th>
											<th>Start Date</th>
											<th>End Date</th>
											<th>Total Coupons</th>
											<th>Used Coupons</th>
											<th>Status</th>
											<th>Created</th>
											<th>Tools</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$i = 1; foreach($results as $result){
										?>
										<tr>
											<th scope="row"><input type="checkbox" name="check_list[]" value="<?php echo $result['id'];?>"></th>
											<td><?php echo $i++;?></td>
											<td><?php echo $result['name'];?></td>
											<td><?php echo $result['code'];?></td>
											<td><?php echo ($result['discount_type'] == '1') ? 'Flat':'Percentage';?></td>
											<td><?php echo $result['discount'] .' '. (($result['discount_type'] == '1') ? 'SAR':'%');?></td>
											<td><?php echo $result['max_discount'];?></td>
											<td><?php echo date('d-m-Y', strtotime($result['date_start']));?></td>
											<td><?php echo date('d-m-Y', strtotime($result['date_end']));?></td>
											<td><?php echo $result['total_coupons'];?></td>
											<td><?php echo $result['used_coupons'];?></td>
											<td><?php echo ($result['status'] == '1') ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>':'<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';?></td>
											<td><?php echo date('d-m-Y', strtotime($result['created_at']));?></td>
											<td><a class="btn btn-outline-secondary btn-custom-light btn-sm edit" href="<?php echo base_url()?>admin/coupon/form?id=<?php echo $result['id'];?>"><i class="mdi mdi-pencil font-size-18"></i></a></td>
										</tr>
										<?php } ?>
										
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
<?php $this->load->view('admin/home/footer');?>
<script>
$(document).ready(function() {
	$('#couponTable').dataTable({
		"lengthMenu": [[25, 50, 100, 500], [25, 50, 100, 500]],
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
	});
});

</script>
