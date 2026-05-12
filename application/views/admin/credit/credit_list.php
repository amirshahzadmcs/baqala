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
					<h4>Credit Account</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item active">Credit Account</li>
					</ol>
				</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					
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
					<div class="card-header">
						<h4 class="header-title mb-0">Search</h4>
					</div>
					<div class="card-body">
						<form action="<?php echo base_url('admin/credit-account/list'); ?>" method="get" id="filter_form">
							<div class="row">
								<div class="col-lg-5 col-md-5 col-sm-12">
									<div class="form-group mb-2">
										<label>Search by Company Name or Account Number</label>
										<input type="search" id="keyword" name="keyword" placeholder="Search by Company Name or Account Number" value="<?php echo $this->input->get('keyword') ? $this->input->get('keyword') : ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>
								
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label class="d-block">Select Status </label>
										<select name="status" class="form-select">
											<option value="">[All Status]</option>
											<option value="notopen" <?php echo ($this->input->get('status') == 'notopen') ? ' selected' : '' ?>>Not Open</option>
											<option value="active" <?php echo ($this->input->get('status') == 'active') ? ' selected' : '' ?>>Active</option>
											<option value="inactive" <?php echo ($this->input->get('status') == 'inactive') ? ' selected' : '' ?>>Inactive</option>
											<option value="suspended" <?php echo ($this->input->get('status') == 'suspended') ? ' selected' : '' ?>>Suspended</option>
										</select>
									</div>
								</div>
								
								<div class="col-lg-3 col-md-3 col-sm-12 mt-4">
									<a href="<?php echo base_url('admin/credit-account/list'); ?>" class="btn btn-danger btn-md">Reset Filter</a>
									<button type="submit" class="btn btn-success btn-md ms-2">Apply Filter</button>
								</div>
							</div>
							
						</form>
					</div>
				</div>
			</div>
 			 <div class="col-12">
 				 <div class="card">
 					 <div class="card-body">
						<table id="creditTable" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
							<thead>
								<tr>
									<th>#</th>				  
									<th>Name</th>		
									<th>Account No.</th>		  
									<th>Company Name</th>						  
									<!--<th>Mobile</th>-->	  
									<th>Max Limit</th>					  
									<th>Avl. Credits</th>				  
									<th>Created</th>				  
									<th>Updated</th>					  					  
									<th>Status</th>					  					  
									<th>Tools</th>
								</tr>
							</thead>
						</table>
 					</div>
 				</div>
 			</div> <!-- end col -->
 		</div> <!-- end row -->
 	</div>
 </div>

<?php $this->load->view('admin/home/footer');?>
<script>
$(document).ready(function() {
	$('#creditTable').dataTable({
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
				url:"<?php echo base_url();?>admin/credit_account/get_list?keyword=<?php echo $this->input->get('keyword')?>&status=<?php echo $this->input->get('status')?>",
				type:"POST"
			},
			"columnDefs":[
			{
			 "targets":[0,1,2,3,4,5,6,7,8,9],
			 "orderable":false
			},
		]
	});
});

</script>
