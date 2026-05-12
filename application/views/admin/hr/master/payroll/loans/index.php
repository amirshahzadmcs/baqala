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
						<h4>Loans </h4>
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
							<li class="breadcrumb-item active">Loans List</li>
						</ol>
					</div>
				 </div>
				 <?php  $admin_id= $this->session->userdata('admin_id'); ?>
				 <div class="col-sm-6">
						<div class="float-end d-sm-block">
							<?php if($this->customer->userd($admin_id)->role=="Admin" ){?>
							<button type="button" class="btn btn-custom-danger btn-sm pull-right" onclick="deleteAction()" title="Delete"><i class="fa fa-trash"></i> Delete</button>
							<?php } ?>
							&nbsp;
							<a class="btn btn-custom-success btn-sm pull-right me-1" title="Own Store" href="<?php echo base_url('admin/hr/payroll/loan/add');?>"><i class="fa fa-plus"></i> Add Loan</a>
						</div>
						<?php if($this->admin->getInfo()){
						$info = explode("--", $this->admin->getInfo());
						$info_type = $info[0];
						$msg_data = $info[1];
						if($info_type == 1){
						?>
						<div class="alert alert-success alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								<strong><?php echo $msg_data; ?></strong>
						</div>
						<!-- <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button></div> -->
						<?php } else{?>
						<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								<strong><?php echo $msg_data;?></strong>
						</div>
						<!-- <div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button></div> -->
						<?php }} $this->admin->removeInfo();  ?>
						<?php if($this->input->get('msg')){ ?>
							<div class="alert alert-success alert-dismissible fade show" role="alert">
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
									<strong><?php echo $this->input->get('msg'); ?></strong>
							</div>
						<?php }?>
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
							<form id="myform" name="myform" method="post" action="">
								<table id="store-table" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
									<thead>
										<tr>
											<th>#</th>
											<th>Emoloyee</th>
											<th>Application Date</th>
											<th>Amount</th>
											<th>Installment Amount</th>
											<th>Period Of Installment</th>
											<th>Installment Start date</th>
											<th>Created At</th>
											<th>Tools</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											
											<td>this</td>
											<td>this</td>
											<td>this</td>
											<td>this</td>
											<td>this</td>
											<td>this</td>
											<td>this</td>
											<td>this</td>
											<td>this</td>
										</tr>

									</tbody>
								</table>
							</form>
			 			</div>
			 		</div>
			 	</div> <!-- end col -->
			 </div> <!-- end row -->
 		</div>
 </div>
 <!-- container-fluid -->


<?php $this->load->view('admin/home/footer');?>
