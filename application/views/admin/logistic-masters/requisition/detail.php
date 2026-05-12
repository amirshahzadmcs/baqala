<?php $this->load->view('admin/home/header');?>
<style>
.dataTables_wrapper::-webkit-scrollbar {
  display: none;
}
.nav-md .container.body .right_col {
    padding: 10px 10px 0;
    margin-left: 230px;
}
.table>:not(caption)>*>* {
    border-bottom-width: 0;
    border-top-width: 0px;
	padding: 0.35rem 0.35rem;
}

</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>SP Requisition Master</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/spare-parts/requisition/list');?>">Requisition</a></li>
						<li class="breadcrumb-item active">Detail</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-1" title="Back" href="<?php echo base_url('admin/spare-parts/requisition/list');?>"><i class="fa fa-reply"></i> Back</a>
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
						<table class="table" width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; line-height: 22px;margin-bottom: 0;">
							<tr>
								<td colspan="2" style="border-bottom: 2px solid #f4c53a;">
									<img src="<?php echo base_url('admin_assets/images/header-top.png');?>" style="width:100%;max-width: 100%;" />
								</td>
							</tr>
							
							<tr>
								<td align="left" valign="top" style="width: 40%;">
									<strong>Requisition Detail </strong><br /><br/>Requisition No. : <?php echo $order->requisition_no; ?><br/>
									Requisition Type : <?php echo ucfirst($order->requisition_type); ?><br/>
									Requisition Date : <?php echo date("d-m-Y", strtotime($order->requisition_date)); ?><br/>
									
								</td>
								<td valign="top" style="width: 60%; float: right;text-align: right;">
									<strong>Supplier Detail </strong><br /><br/><strong>Supplier Name :</strong> <?php echo $order->vendor_name; ?> <?php echo ($order->vendor_arabic_name !== '') ? '/ '. $order->vendor_arabic_name : ''; ?><br/>
									<strong>Contact Person :</strong> <?php echo $order->contact_person_name; ?><br/>
									<strong>CR No.:</strong> <?php echo $order->cr_no; ?><br />
									<strong>VAT No.:</strong> <?php echo $order->vat_no; ?><br />
								</td>
							</tr>
							
							<tr>
								<td colspan="3" class="pb-0">
									<table class="table table-striped jambo_table table-bordered mb-0" width="100%" border="1" cellspacing="0" cellpadding="0">
									    <thead>
    										<tr>
												<td valign="top" bgcolor="#CCCCCC" style="width: 10%;text-align: center;"><strong>Sr.No.</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 15%;"><strong>Part No.</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 10%;"><strong>Make</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 10%;"><strong>Model</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 45%;"><strong>Particular Name</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 10%;text-align: center;"><strong>Qty.</strong></td>
											</tr>
    									</tbody>
    									<tbody>
										<?php $item_row = 1;if(!empty($items)){ foreach($items as $product){ ?>
										<tr>
											<td valign="top" style="text-align: center;"><?php echo $item_row;?></td>
											<td valign="top"><?php echo strtoupper($product->item_code);?></td>
											<td valign="top"><?php echo strtoupper($product->make_name);?></td>
											<td valign="top"><?php echo strtoupper($product->vehicle_model);?></td>
											<td valign="top"><?php echo $product->part_name_en;?><br><span style="float: right;direction: rtl;"><?php echo $product->part_name_ar;?></span></td>
											<td valign="top" style="text-align: center;"><?php echo $product->quantity;?></td>
										</tr>
										<?php $item_row = $item_row + 1;}}?>
										<tr>
											<td colspan="5" cellspacing="0" cellpadding="5"><strong>Total Items: </strong> <?php echo $order->total_item; ?> <span style="float: right;"><strong>Total QTY: </strong></span></td>
											<td colspan="1" cellspacing="0" cellpadding="5" style="text-align: center;"><?php echo $order->total_qty; ?></td>
										</tr>
										</tbody>
									</table>
								</td>
							</tr>
							
						</table>
 					</div>
 				</div>
 			</div> <!-- end col -->
 		</div> <!-- end row -->
 	</div>
 </div>

<?php $this->load->view('admin/home/footer');?>
