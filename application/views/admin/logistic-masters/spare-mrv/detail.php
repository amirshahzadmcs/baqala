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
					<h4>SP MRV Master</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/spare-parts/mrv/list');?>">SP MRV Master</a></li>
						<li class="breadcrumb-item active">Detail</li>
					</ol>
				</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-1" title="Back" href="<?php echo base_url('admin/spare-parts/mrv/list');?>"><i class="fa fa-reply"></i> Back</a>
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
						<table class="table" width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size: 14px; line-height: 22px;margin-bottom: 0;">
							<tr>
								<td colspan="2" style="border-bottom: 2px solid #f4c53a;">
									<img src="<?php echo base_url('admin_assets/images/header-top.png');?>" style="width:100%;max-width: 100%;" />
								</td>
							</tr>
							<tr>
								<td align="left" valign="top" style="width: 40%;">
									<strong>SUPPLIER ADDRESS <br /> </strong><?php echo $order->vendor_name; ?><br/>
									Contact No. - <?php echo $order->b_contact; ?><br/>
									Address: <?php echo $order->b_building_no .','; ?> <?php echo $order->b_street_name .','; ?> <?php echo $order->b_district; ?><br />
									<?php echo $order->b_additional_no .','; ?> <?php echo $order->b_unit_no; ?><br/>
									<?php echo $order->billing_city_name .','; ?> <?php echo $order->b_zip_code; ?>
								</td>
								<td valign="top" style="float: right;">
									<table>
										<tr>
											<td><strong>SP P.O. No. </strong></td>
											<td> : <?php echo $order->po_no; ?></td>
										</tr>
										<tr>
											<td><strong>SP P.O. Date </strong></td>
											<td> : <?php echo date("d-m-Y", strtotime($order->po_date)); ?></td>
										</tr>
										<tr>
											<td><strong>Requisition No. </strong></td>
											<td> : <?php echo $order->requisition_no; ?></td>
										</tr>
										<tr>
											<td><strong>Requisition Type. </strong></td>
											<td> : <?php echo $order->requisition_type; ?></td>
										</tr>
										<tr>
											<td><strong>Contact No </strong></td>
											<td> : <?php echo $order->b_contact; ?></td>
										</tr>
										<tr>
											<td><strong>Supp Vat No. </strong></td>
											<td> : <?php echo $order->vat_no; ?></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td valign="top">
									<strong>BILLING ADDRESS</strong><br/><?php echo $this->admin->getWarehouseDetail()->contact_person;?><br/>
									Contact No. - <?php echo $this->admin->getWarehouseDetail()->warehouse_phone;?><br/>
									Address: <?php echo $this->admin->getWarehouseDetail()->complete_address;?>,<br>Kindom of Saudi Arabia.<br>
									VAT No. - 300034911400003
								</td>
							</tr>
							
							<tr>
								<td colspan="3" class="pb-0">
									<table class="table table-striped jambo_table table-bordered mb-0" id="item_table" width="100%" border="1" cellspacing="0" cellpadding="5">
										<thead>
											<tr>
												<td valign="top" bgcolor="#CCCCCC" style="width: 4%;"><strong>#</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 8%;"><strong>Part No.</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 10%;"><strong>Make</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 10%;"><strong>Model</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 26%;"><strong>Particular Name</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 7%;"><strong>Qty</strong></td>
												<?php if($order->requisition_type == 'international'){ ?>
												<td valign="top" bgcolor="#CCCCCC" style="width: 7%;"><strong>FCY</strong></td>
												<?php } ?>
												<td valign="top" bgcolor="#CCCCCC" style="width: 7%;"><strong>SAR</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 7%;"><strong>Total</strong></td>
											</tr>
										</thead>
										<tbody>
											<?php $item_row = 1;if(!empty($items)){ foreach($items as $product){ ?>
											<tr id="item-row<?php echo $item_row;?>">
												<td valign="middle" align="center"><?php echo $item_row;?></td>
												<td valign="middle"><?php echo $product->item_code; ?></td>
												<td valign="middle"><?php echo $product->make_name; ?></td>
												<td valign="middle"><?php echo $product->vehicle_model; ?></td>
												<td valign="middle"><?php echo $product->part_name_en; ?></td>
												<td valign="middle"><?php echo $product->qty; ?></td>
												<?php if($order->requisition_type == 'international'){ ?>
												<td valign="middle"><?php echo $product->fcy; ?></td>
												<?php } ?>
												<td valign="middle"><?php echo $product->price; ?></td>
												<td valign="middle"><?php echo $product->total; ?></td>
											</tr>
											<?php $item_row = $item_row + 1;}}?>
										</tbody>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="3" class="pt-0">
									<table class="table" style="width: 100%; border-spacing: 0px;">
										<tbody>
											<tr>
												<td style="width: 63%;"></td>

												<td style="vertical-align: top; width: 40%;padding: 0;">
													<table class="table table-bordered" id="tab_logic_total" width="100%" cellspacing="0" cellpadding="5" style="border: 1px solid #ddd;">
														<tr>
															<td valign="middle" style="text-align: left;">SUBTOTAL:</td>
															<td valign="middle" class="amount subtotal"><?php echo $order->sub_total;?></td>
														</tr>
														<?php if($order->requisition_type == 'local'){ ?>
														<tr>
															<td valign="middle" style="text-align: left;">TOTAL VAT %:</td>
															<td valign="middle" class="amount">
																<div class="input-group mb-2 mb-sm-0">
																	<?php echo $order->vat_percent;?> %
																</div>
															</td>
														</tr>
														<tr>
															<td valign="middle" style="text-align: left;">TOTAL VAT AMOUNT:</td>
															<td valign="middle" class="amount"><?php echo $order->total_vat_amt;?></td>
														</tr>
														<?php } ?>
														<?php if($order->requisition_type == 'international'){ ?>
														<tr>
															<td style="text-align: left;">TOTAL FCY</td>
															<td class="amount"><?php echo $order->total_fcy;?></td>
														</tr>
														<?php } ?>
														<tr>
															<td valign="middle" style="text-align: left; width: 68%;">TOTAL SAR (VAT INC.):</td>
															<td valign="middle" class="total-amount"><?php echo $order->total_cost;?></td>
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
