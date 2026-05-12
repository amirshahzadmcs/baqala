<?php $this->load->view('admin/home/header');?>
<style>
.dataTables_wrapper::-webkit-scrollbar {
  display: none;
}
.nav-md .container.body .right_col {
    padding: 10px 10px 0;
    margin-left: 230px;
}

.roundCircle {
	/* background-color: rgba(35,197,143,.25)!important; */
	border-radius: 50%;
    width: 50px;
    height: 50px;
    padding: 12px 14px;
}

</style>


<!-- start page title -->
<div class="page-title-box">
		<div class="container-fluid">
		 <div class="row align-items-center">
				 <div class="col-sm-6">
					<div class="page-title">
						<h4>Purchases Report</h4>
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
							<li class="breadcrumb-item active">Purchases Report</li>
						</ol>
					</div>
				 </div>
				 <?php  $admin_id= $this->session->userdata('admin_id'); ?>
				 <div class="col-sm-6">
						<!-- <div class="float-end d-sm-block">
							<?php if($this->customer->userd($admin_id)->role=="Admin" ){?>
							<button type="button" class="btn btn-custom-danger btn-sm pull-right" onclick="deleteAction()" title="Delete"><i class="fa fa-trash"></i> Delete</button>
							<?php } ?>
							&nbsp;
							<a class="btn btn-custom-success btn-sm pull-right me-1" title="Own Store" href="<?php echo base_url('admin/sim/add')?>"><i class="fa fa-plus"></i> Add Sim Card</a>
						</div> -->
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
			<div class="col-md-6 col-12">
				<div class="card">
					<div class="card-header d-flex align-items-center">	
						<h6 class="mb-0"><i class="fas fa-file-contract font-size-18 me-3"></i>Purchases Segmented Reports</h6>
					</div>
					<div class="card-body">
						<div class="row border mb-2 align-items-center">
							<div class="col-xl-6 col-lg-12 col-md-12 my-2 col-sm-12 d-flex align-items-center">
								<i class="fas fa-user-tie roundCircle bg-soft-success me-3" style="font-size: 25px;"></i> Purchases By Supplier
							</div>
							<div class="col-xl-6 col-lg-12 col-md-12 my-2 col-sm-12 d-none d-xl-flex flex-row">
								<div class="me-3 d-flex"><a href="<?php echo base_url('admin/report/purchases');?>" class="btn d-flex pb-1"><i class="fas fa-file-alt font-size-18 me-2"></i> Details</a></div>
								<div class="d-flex"><a href="<?php echo base_url('admin/report/purchases');?>" class="btn d-flex pb-1"><i class="fas fa-clipboard font-size-18 me-2"></i> Summary</a></div>
							</div>
						</div>
						<div class="row border mb-2 align-items-center">
							<div class="col-xl-6 col-lg-12 col-md-12 my-2 col-sm-12 d-flex align-items-center">
								<i class="fas fa-user-alt roundCircle bg-soft-info me-3" style="font-size: 25px;"></i> Purchases By Staff
							</div>
							<div class="col-xl-6 col-lg-12 col-md-12 my-2 col-sm-12 d-none d-xl-flex flex-row">
								<div class="me-3 d-flex"><a href="<?php echo base_url('admin/report/purchases');?>" class="btn d-flex pb-1"><i class="fas fa-file-alt font-size-18 me-2"></i> Details</a></div>
								<div class="d-flex"><a href="<?php echo base_url('admin/report/purchases');?>" class="btn d-flex pb-1"><i class="fas fa-clipboard font-size-18 me-2"></i> Summary</a></div>
							</div>
						</div>
					</div>
				</div>
			</div> <!-- end col -->
			<div class="col-md-6 col-12">
				<div class="card">
					<div class="card-header d-flex align-items-center">	
						<h6 class="mb-0"><i class="fas fa-file-contract font-size-18 me-3"></i>Suppliers Reports</h6>
					</div>
					<div class="card-body">
						<div class="row border mb-2 align-items-center">
							<div class="col-xl-6 col-lg-12 col-md-12 my-2 col-sm-12 d-flex align-items-center">
								<i class="fas fa-users roundCircle bg-soft-success me-3" style="font-size: 25px;padding-left:0.7rem!important;"></i> Supplier List
							</div>
							<div class="col-xl-6 col-lg-12 col-md-12 my-2 col-sm-12 d-none d-xl-flex flex-row">
								<div class="me-3 d-flex"><a href="<?php echo base_url('admin/report/supplier');?>" class="btn d-flex pb-1"><i class="fas fa-eye font-size-18 me-2"></i> View</a></div>
								<!-- <div class="d-flex ms-auto"><a href="" class="btn d-flex pb-1"><i class="fas fa-clipboard font-size-18 me-2"></i> Summary</a></div> -->
							</div>
						</div>
						<div class="row border mb-2 align-items-center">
							<div class="col-xl-6 col-lg-12 col-md-12 my-2 col-sm-12 d-flex align-items-center">
								<i class="fas fa-dollar-sign roundCircle bg-soft-info me-3" style="font-size: 25px;padding-left:20px;"></i> Supplier Balance
							</div>
							<div class="col-xl-6 col-lg-12 col-md-12 my-2 col-sm-12 d-none d-xl-flex flex-row">
								<div class="me-3 d-flex"><a href="<?php echo base_url('admin/report/supplier_balance');?>" class="btn d-flex pb-1"><i class="fas fa-eye font-size-18 me-2"></i> View</a></div>
								<div class="d-flex"><a href="<?php echo base_url('admin/report/supplier_balance');?>" class="btn d-flex pb-1"><i class="fas fa-clipboard font-size-18 me-2"></i> Summary</a></div>
							</div>
						</div>
						<div class="row border mb-2 align-items-center">
							<div class="col-xl-6 col-lg-12 col-md-12 my-2 col-sm-12 d-flex align-items-center">
								<i class="fas fa-truck roundCircle bg-soft-secondary me-3" style="font-size: 25px;"></i> Supplier Purchase Invoices
							</div>
							<div class="col-xl-6 col-lg-12 col-md-12 my-2 col-sm-12 d-none d-xl-flex flex-row">
								<div class="me-3 d-flex"><a href="<?php echo base_url('admin/report/purchase');?>" class="btn d-flex pb-1"><i class="fas fa-eye font-size-18 me-2"></i> View</a></div>
								<!-- <div class="d-flex ms-auto"><a href="" class="btn d-flex pb-1"><i class="fas fa-clipboard font-size-18 me-2"></i> Summary</a></div> -->
							</div>
						</div>
						<div class="row border mb-2 align-items-center">
							<div class="col-xl-6 col-lg-12 col-md-12 my-2 col-sm-12 d-flex align-items-center">
								<i class="fas fa-truck roundCircle bg-soft-warning me-3" style="font-size: 25px;"></i> Supplier Payments
							</div>
							<div class="col-xl-6 col-lg-12 col-md-12 my-2 col-sm-12 d-none d-xl-flex flex-row">
								<div class="me-3 d-flex"><a href="<?php echo base_url('admin/report/paid_purchases');?>" class="btn d-flex pb-1"><i class="fas fa-eye font-size-18 me-2"></i> View</a></div>
								<!-- <div class="d-flex ms-auto"><a href="" class="btn d-flex pb-1"><i class="fas fa-clipboard font-size-18 me-2"></i> Summary</a></div> -->
							</div>
						</div>
						<div class="row border mb-2 align-items-center">
							<div class="col-xl-6 col-lg-12 col-md-12 my-2 col-sm-12 d-flex align-items-center">
								<i class="fas fa-truck roundCircle bg-soft-warning me-3" style="font-size: 25px;"></i> Supplier Statement
							</div>
							<div class="col-xl-6 col-lg-12 col-md-12 my-2 col-sm-12 d-none d-xl-flex flex-row">
								<div class="me-3 d-flex"><a href="<?php echo base_url('admin/report/journal_transactions') ?>" class="btn d-flex pb-1"><i class="fas fa-eye font-size-18 me-2"></i> View</a></div>
								<!-- <div class="d-flex ms-auto"><a href="" class="btn d-flex pb-1"><i class="fas fa-clipboard font-size-18 me-2"></i> Summary</a></div> -->
							</div>
						</div>
					</div>
				</div>
			</div> <!-- end col -->
			<div class="col-md-6 col-12">
				<div class="card">
					<div class="card-header d-flex align-items-center">	
						<h6 class="mb-0"><i class="fas fa-file-contract font-size-18 me-3"></i>Product Purchases Report</h6>
					</div>
					<div class="card-body">
						<div class="row border mb-2 align-items-center">
							<div class="col-xl-6 col-lg-12 col-md-12 my-2 col-sm-12 d-flex align-items-center">
								<i class="fas fa-box-open roundCircle bg-soft-success me-3" style="font-size: 25px;padding-left: 10px;"></i> Product Purchases Report - by Product
							</div>
							<div class="col-xl-6 col-lg-12 col-md-12 my-2 col-sm-12 d-none d-xl-flex flex-row">
								<div class="me-3 d-flex"><a href="<?php echo base_url('admin/report/product_purchases') ?>" class="btn d-flex pb-1"><i class="fas fa-file-alt font-size-18 me-2"></i> Details</a></div>
								<div class="d-flex"><a href="<?php echo base_url('admin/report/product_purchases') ?>" class="btn d-flex pb-1"><i class="fas fa-clipboard font-size-18 me-2"></i> Summary</a></div>
							</div>
						</div>
						<div class="row border mb-2 align-items-center">
							<div class="col-xl-6 col-lg-12 col-md-12 my-2 col-sm-12 d-flex align-items-center">
								<i class="fas fa-user-tie roundCircle bg-soft-info me-3" style="font-size: 25px;"></i> Product Purchases Report - by Supplier
							</div>
							<div class="col-xl-6 col-lg-12 col-md-12 my-2 col-sm-12 d-none d-xl-flex flex-row">
								<div class="me-3 d-flex"><a href="<?php echo base_url('admin/report/product_purchases') ?>" class="btn d-flex pb-1"><i class="fas fa-file-alt font-size-18 me-2"></i> Details</a></div>
								<div class="d-flex"><a href="<?php echo base_url('admin/report/product_purchases') ?>" class="btn d-flex pb-1"><i class="fas fa-clipboard font-size-18 me-2"></i> Summary</a></div>
							</div>
						</div>
						<div class="row border mb-2 align-items-center">
							<div class="col-xl-6 col-lg-12 col-md-12 my-2 col-sm-12 d-flex align-items-center">
								<i class="fas fa-user-alt roundCircle bg-soft-secondary me-3" style="font-size: 25px;"></i> Product Purchases Report - by Staff
							</div>
							<div class="col-xl-6 col-lg-12 col-md-12 my-2 col-sm-12 d-none d-xl-flex flex-row">
								<div class="me-3 d-flex"><a href="<?php echo base_url('admin/report/product_purchases') ?>" class="btn d-flex pb-1"><i class="fas fa-file-alt font-size-18 me-2"></i> Details</a></div>
								<div class="d-flex"><a href="<?php echo base_url('admin/report/product_purchases') ?>" class="btn d-flex pb-1"><i class="fas fa-clipboard font-size-18 me-2"></i> Summary</a></div>
							</div>
						</div>
					</div>
				</div>
			</div> <!-- end col -->
			<div class="col-md-6 col-12">
				<div class="card">
					<div class="card-header d-flex align-items-center">	
						<h6 class="mb-0"><i class="fas fa-file-contract font-size-18 me-3"></i>Payments Periodic Reports</h6>
					</div>
					<div class="card-body">
						<div class="row border mb-2 align-items-center">
							<div class="col-xl-6 col-lg-12 col-md-12 my-2 col-sm-12 d-flex align-items-center">
								<i class="fas fa-calendar-day roundCircle bg-soft-success me-3" style="font-size: 25px;"></i> Daily Payments
							</div>
							<div class="col-xl-6 col-lg-12 col-md-12 my-2 col-sm-12 d-none d-xl-flex flex-row">
								<div class="me-3 d-flex"><a href="<?php echo base_url('admin/report/popayments') ?>" class="btn d-flex pb-1"><i class="fas fa-file-alt font-size-18 me-2"></i> Details</a></div>
								<div class="d-flex"><a href="<?php echo base_url('admin/report/popayments') ?>" class="btn d-flex pb-1"><i class="fas fa-clipboard font-size-18 me-2"></i> Summary</a></div>
							</div>
						</div>
						<div class="row border mb-2 align-items-center">
							<div class="col-xl-6 col-lg-12 col-md-12 my-2 col-sm-12 d-flex align-items-center">
								<i class="fas fa-calendar-week roundCircle bg-soft-info me-3" style="font-size: 25px;"></i> Weekly Payments
							</div>
							<div class="col-xl-6 col-lg-12 col-md-12 my-2 col-sm-12 d-none d-xl-flex flex-row">
								<div class="me-3 d-flex"><a href="<?php echo base_url('admin/report/popayments') ?>" class="btn d-flex pb-1"><i class="fas fa-file-alt font-size-18 me-2"></i> Details</a></div>
								<div class="d-flex"><a href="<?php echo base_url('admin/report/popayments') ?>" class="btn d-flex pb-1"><i class="fas fa-clipboard font-size-18 me-2"></i> Summary</a></div>
							</div>
						</div>
						<div class="row border mb-2 align-items-center">
							<div class="col-xl-6 col-lg-12 col-md-12 my-2 col-sm-12 d-flex align-items-center">
								<i class="fas fa-calendar-alt roundCircle bg-soft-secondary me-3" style="font-size: 25px;"></i> Monthly Payments
							</div>
							<div class="col-xl-6 col-lg-12 col-md-12 my-2 col-sm-12 d-none d-xl-flex flex-row">
								<div class="me-3 d-flex"><a href="<?php echo base_url('admin/report/popayments') ?>" class="btn d-flex pb-1"><i class="fas fa-file-alt font-size-18 me-2"></i> Details</a></div>
								<div class="d-flex"><a href="<?php echo base_url('admin/report/popayments') ?>" class="btn d-flex pb-1"><i class="fas fa-clipboard font-size-18 me-2"></i> Summary</a></div>
							</div>
						</div>
						<div class="row border mb-2 align-items-center">
							<div class="col-xl-6 col-lg-12 col-md-12 my-2 col-sm-12 d-flex align-items-center">
								<i class="fas fa-calendar roundCircle bg-soft-warning me-3" style="font-size: 25px;"></i> Yearly Payments
							</div>
							<div class="col-xl-6 col-lg-12 col-md-12 my-2 col-sm-12 d-none d-xl-flex flex-row">
								<div class="me-3 d-flex"><a href="<?php echo base_url('admin/report/popayments') ?>" class="btn d-flex pb-1"><i class="fas fa-file-alt font-size-18 me-2"></i> Details</a></div>
								<div class="d-flex"><a href="<?php echo base_url('admin/report/popayments') ?>" class="btn d-flex pb-1"><i class="fas fa-clipboard font-size-18 me-2"></i> Summary</a></div>
							</div>
						</div>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
 </div>
 <!-- container-fluid -->


<?php $this->load->view('admin/home/footer');?>
