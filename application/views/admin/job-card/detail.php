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
					<h4>Job Cards</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/job-card/list');?>">Job Cards</a></li>
						<li class="breadcrumb-item active">Detail</li>
					</ol>
				</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-1" title="Back" href="<?php echo base_url('admin/job-card/list');?>"><i class="fa fa-reply"></i> Back</a>
					<?php if($order->status == 'open'){ ?>
					<a class="btn btn-sm btn-custom pull-right me-1" title="Edit" href="<?php echo base_url().'admin/job-card/add?id='.$order->id;?>"><i class="fa fa-pen"></i> Edit</a>
					<a class="btn btn-sm btn-custom-success pull-right me-1" onclick="return confirm('You will not able to edit after job card locked. Are you sure want to lock?')" title="Lock" href="<?php echo base_url().'admin/job-card/lock-job?id='.$order->id;?>"><i class="fa fa-lock"></i> Lock Job Card</a>
					<?php } ?>
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
									<img src="<?php echo base_url('admin_assets/images/job-card/header-top.jpg');?>" style="width:100%;max-width: 100%;" />
								</td>
							</tr>
							
							<tr>
								<td align="left" valign="top" style="width: 40%;">
									<strong>JOB DETAIL </strong><br /><br/> <strong>Ref. No.</strong> - <?php echo 'JC-'. invoiceNmFormat($order->id); ?><br/>
									<strong>Job Type</strong> - <?php echo $order->job_type; ?><br/>
									<strong>Job Date</strong> - <?php echo date("d-m-Y", strtotime($order->job_date)); ?><br/>
									<strong>Rider Name</strong> - <?php echo $order->rider_name; ?><br/>
									
								</td>
								<td valign="top" style="width: 60%; float: right;text-align: right;">
									<strong>Vehicle Number :</strong> <?php echo $order->bike_no; ?><br/>
									<strong>Purchase Date :</strong> <?php echo date("d-m-Y", strtotime($order->vehicle_p_date)); ?><br/>
									<strong>Vehicle Make:</strong> <?php echo $order->vehicle_make; ?><br />
									<strong>Vehicle Type:</strong> <?php echo $order->vehicle_type; ?><br />
									<strong>Vehicle Color:</strong> <?php echo $order->vehicle_color; ?><br>
									<strong>Vehicle Year:</strong> <?php echo $order->vehicle_year; ?><br>
									<strong>Meter Reading:</strong> <?php echo round($order->meter_reading, 2); ?> KM
								</td>
							</tr>
							
							<tr>
								<td colspan="3" class="pb-0">
									<table class="table table-striped jambo_table table-bordered mb-0" width="100%" border="1" cellspacing="0" cellpadding="0">
									    <thead>
    										<tr>
    											<td valign="top" bgcolor="#CCCCCC" style="width: 5%;"><strong>S. No.</strong></td>
    											<td valign="top" bgcolor="#CCCCCC" style="width: 15%;"><strong>Item Code</strong></td>
    											<td valign="top" bgcolor="#CCCCCC" style="width: 50%;"><strong>Spare Part Name</strong></td>
    											<td valign="top" bgcolor="#CCCCCC" style="width: 10%;"><strong>Qty.</strong></td>
    											<td valign="top" bgcolor="#CCCCCC" style="width: 10%;"><strong>Unit Price</strong></td>
    											<td valign="top" bgcolor="#CCCCCC" style="width: 10%;"><strong>Line Amt.</strong></td>
    										</tr>
    									</tbody>
    									<tbody>
										<?php $item_row = 1;foreach($items as $product){ ?>
										<tr>
											<td valign="top" style="text-align: center;"><?php echo $item_row;?></td>
											<td valign="top"><?php echo strtoupper($product->item_code);?></td>
											<td valign="top"><?php echo $product->spare_part_name;?><br><?php echo $product->spare_part_name_ar;?></td>
											<td valign="top"><?php echo $product->qty;?></td>
											<td valign="top" style="text-align: center;"><?php echo $product->cost;?></td>
											<td valign="top" style="text-align: right;"><?php echo $product->line_amount;?></td>
										</tr>
										<?php $item_row = $item_row + 1;}?>
										</tbody>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="3" class="pt-0">
									<table style="width: 100%; border-spacing: 0px;">
										<tbody>
											<tr>
												<td style="width: 55.8%;" cellspacing="0" cellpadding="5">
													<p>1. Please send two copies of your invoice.</p>
													<p>2. Enter this order in accordance with the prices, terms, delivery method, and specifications listed above.</p>
													<p>3. Please notify us immediately if you are unable to ship as specified.</p>
												</td>

												<td style="vertical-align: top; width: 24.2%;">
													<table class="table" width="100%" cellspacing="0" cellpadding="0" style="border: 1px solid gray; border-top: 0px;">
														<tr>
															<td style="text-align: left; border-bottom: 1px solid gray; border-right: 1px solid gray; width: 67%;">SUBTOTAL EXCL. VAT</td>
															<td style="border-bottom: 1px solid gray;text-align:right;width: 33%;" class="amount subtotal"><?php echo $order->sub_total;?></td>
														</tr>
														<tr>
															<td style="text-align: left; border-bottom: 1px solid gray; border-right: 1px solid gray; width: 67%;">VAT %</td>
															<td style="border-bottom: 1px solid gray;text-align:right;width: 33%;" class="amount"><?php echo $order->sale_tax;?></td>
														</tr>
														<tr>
															<td style="text-align: left; border-bottom: 1px solid gray; border-right: 1px solid gray; width: 67%;">VAT AMOUNT</td>
															<td style="border-bottom: 1px solid gray;text-align:right;width: 33%;" class="amount"><?php echo $order->sale_tax_amt;?></td>
														</tr>
														<tr>
															<td style="text-align: left; border-bottom: 1px solid gray; border-right: 1px solid gray; width: 67%;">SERVICE CHARGE</td>
															<td style="border-bottom: 1px solid gray;text-align:right;width: 33%;" class="amount"><?php echo $order->shipping_handling;?></td>
														</tr>
														<tr>
															<td style="text-align: left; width: 67%; border-right: 1px solid gray;">TOTAL</td>
															<td class="total amount" align="right"><?php echo $order->total;?></td>
														</tr>
													</table>
												</td>
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
