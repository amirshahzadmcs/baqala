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
					<h4>Offers Management</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/app-setting/dasboard');?>">App Setting</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/app/offers/list');?>">Offers</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<button class="btn btn-custom-danger btn-sm pull-right me-2" onclick="confirm('Really want to delete this item?') ? $('#delete_form').submit() : false;" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					<a href="<?php echo base_url('admin/app/offers/add');?>" type="button" class="btn btn-custom-success btn-sm pull-right" title="Add"><i class="fa fa-plus"></i> Add New Offer</a>
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
						<?php echo form_open("admin/app/offers/delete", array("id"=>"delete_form"));?>
		 					<table id="bannerTable" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
		 						<thead>
		 							<tr>					  
										<th>#</th>
										<th>#</th>					  
										<th>Title</th>						  
										<th>Coupon Code</th>					  
										<th>Expiry Date</th>					  
										<th>Sort Order</th>					  
										<th>Status</th>  					  
										<th>Created</th>
										<th>Updated</th>		  					  
										<th>Tools</th>
									</tr>
		 						</thead>
								<tbody>
									<?php 
									if($results->num_rows() > 0){ 
									$i=1;foreach($results->result() as $item){
									?>
									<tr>
										<td><input type="checkbox" value="<?php echo $item->id;?>" name="check_list[]" /></td>
										<td><?php echo $i++;?></td>
										<td><?php echo $item->offer_title;?><br><p class="mb-1 text-end"><?php echo $item->offer_title_ar;?></p></td>
										<td><?php echo $item->coupon_code;?></td>
										<td><?php echo date("d-m-y h:i:s A", strtotime($item->offer_ends_on));?></td>
										<td><?php echo $item->sort_order;?></td>
										<td><?php echo $item->status == 'active' ? '<div class="badge badge-pill badge-soft-success font-size-13">Active</div>':'<div class="badge badge-pill badge-soft-danger font-size-13">Inactive</div>';?></td>
										<td><?php echo date("d-m-y h:i A", strtotime($item->created_at));?></td>
										<td><?php echo (!empty($item->updated_at)) ? date("d-m-y h:i A", strtotime($item->updated_at)) : 'NA';?></td>
										<td><?php echo '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" href="'.base_url().'admin/app/offers/edit?id='.$item->id.'"><i class="mdi mdi-pencil font-size-18"></i></a>';?></td>
									</tr>
									<?php }} ?>
								</tbody>
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

        $('#bannerTable').dataTable({
            "lengthMenu": [
                [25, 50, 100, 500],
                [25, 50, 100, 500]
            ],
            order: [
                [0, 'DESC']
            ],
            dom: 'Blfrtip',
            buttons: [{
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
            fixedHeader: true,
        });
    });
</script>
