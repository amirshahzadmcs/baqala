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
					<h4>Stock Transfer Request</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="javascript: void(0);">Stock Transfer Request</a></li>
						<li class="breadcrumb-item active">Detail</li>
					</ol>
				</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if($this->customer->userd($admin_id)->role=="Admin" ){?>
					<a class="btn btn-custom-white btn-sm" title="Back" href="<?php echo base_url('admin/stockrequest')?>"><i class="fa fa-reply"></i> Back</a> 
					<div class="btn-group pull-right ms-1">
						<button class="btn btn-custom-danger btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Action <i class="mdi mdi-chevron-down"></i>
						</button>
						<div class="dropdown-menu">
							<?php if($order->status < 3){?>
							<a type="button" class="dropdown-item waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".stockModalFullscreen" href="javascript:;">Edit Quantity</a>
							<div class="dropdown-divider"></div>
							<?php } ?>
							<?php if($order->status == "2"){ ?>
							<a class="dropdown-item waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" href="javascript:;">Assign Vehicle</a>
							<div class="dropdown-divider"></div>
							<?php } ?>
							<?php if($order->status >= 3){ ?>
							<a class="dropdown-item waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-status-modal-center" href="javascript:;">Update Status</a>
							<?php } ?>
						</div>
					</div>
					<a class="btn btn-custom-success btn-sm ms-1 pull-right" title="Print" href="<?php echo base_url().'admin/stockrequest/print_invoice?id='.$order->id;?>" target="_blank"><i class="fa fa-print"></i> Print</a>
					<!--
					<button type="button" class="btn btn-danger btn-sm pull-right" onclick="deleteAction()" title="Delete"><i class="fa fa-trash"></i></button>
					-->
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
				<!-- </div> -->
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
								<td colspan="2"><img src="<?php echo base_url('admin_assets/images/header/str-header.jpg');?>" style="max-width: 100%;" /></td>
							</tr>

							<tr>
								<td align="left" valign="top" style="width: 40%;">
									<strong>WAREHOUSE INFORMATION <br /> </strong><?= $warehouse_address->name_english;?><br/>
									Contact No. - <?php echo $warehouse_address->warehouse_phone; ?><br/>
									Address: <?php echo $warehouse_address->complete_address; ?>
								</td>
								<td valign="top" style="width: 60%; float: right;text-align: right;">
									<strong>STR Number :</strong> <?= $order->request_id;?><br/>
									<strong>Request Date :</strong> <?= date("d-m-Y h:i:s", strtotime($order->created_at)); ?><br/>
									<strong>Expected Delivery Date:</strong> <?= date("d-m-Y h:i:s", strtotime($order->expected_date)); ?><br />
									<strong>Delivery Date:</strong> <?php if($order->dispatch_date){ echo date("d-m-Y h:i:s", strtotime($order->dispatch_date));}else{ echo 'N/A';} ?>
								</td>
							</tr>
							<tr>
								<td valign="top">
									<strong>BILLING ADDRESS</strong><br/>
									<?= $order->store_name;?><br>
									<?= $order->store_incharge;?><br>
									<?= $order->contact_number;?><br>
									<?= $order->store_location;?><br>
								</td>
							</tr>
							
							<tr>
								<td colspan="3" class="pb-0">
									<table class="table table-bordered mb-0" width="100%" border="1" cellspacing="0" cellpadding="0" style="border: 1px solid #878787;">
										<tr style="background-color: #eee;">
											<td valign="top" bgcolor="#CCCCCC" style="width: 5%;"><strong>#</strong></td>
											<td valign="top" bgcolor="#CCCCCC" style="width: 9.5%;"><strong>CHILD SKU</strong></td>
											<td valign="top" bgcolor="#CCCCCC" style="width: 13%;"><strong>BARCODE</strong></td>
											<td valign="top" bgcolor="#CCCCCC" style="width: 22%;"><strong>PRODUCT NAME/ DESCRIPTION</strong></td>
											<td valign="top" bgcolor="#CCCCCC" style="width: 5%;"><strong>SIZE</strong></td>
											<td valign="top" bgcolor="#CCCCCC" style="width: 5%;"><strong>REQ. UNIT</strong></td>
											<td valign="top" bgcolor="#CCCCCC" style="width: 5%;"><strong>APPR. UNIT</strong></td>
											<td valign="top" bgcolor="#CCCCCC" style="width: 5%;"><strong>UNIT COST</strong></td>
											<td valign="top" bgcolor="#CCCCCC" style="width: 9%;"><strong>AMT. EXCL. VAT</strong></td>
											<td valign="top" bgcolor="#CCCCCC" style="width: 8.5%;text-align:right"><strong>VAT AMT.</strong></td>
											<td valign="top" bgcolor="#CCCCCC" style="width: 9%;text-align:right"><strong>AMT. INC. VAT</strong></td>
										</tr>
										<?php $item_row = 1;foreach($products as $product){ ?>
										<tr>
											<td class="text-center"><?= $item_row;?></td>
											<td class="text-start"><?= $product->parent_sku;?>-<?= $product->item_sku;?></td>
											<td class="text-start"><?= $product->barcode;?></td>
											<td class="text-start"><?= $product->item_description;?></td>
											<td class="text-center"><?= $product->size;?></td>
											<td class="text-center"><?= $product->item_unit;?></td>
											<td class="text-center"><?= $product->approved_unit;?></td>
											<td class="text-end"><?= $product->unit_price;?></td>
											<td class="text-end"><?= $product->amt_excl_vat;?></td>
											<td class="text-end"><?= $product->vat_amt;?></td>
											<td class="text-end"><?= $product->amt_incl_vat;?></td>
										</tr>
										<?php $item_row = $item_row + 1;}?>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="3" class="pt-0">
									<table style="width: 100%; border-spacing: 0px;">
										<tbody>
											<tr>
												<td style="width: 44.9%" cellspacing="0" cellpadding="5">
													<p>1. Please send two copies of your invoice.</p>
													<p>2. Enter this order in accordance with the prices, terms, delivery method, and specifications listed above.</p>
													<p>3. Please notify us immediately if you are unable to ship as specified.</p>
													<p>4. Send all correspondence to: procurement@ixiana.com</p>
												</td>

												<td style="vertical-align: top; width: 28.2%;">
													<table class="table" width="100%" cellspacing="0" cellpadding="0" style="border: 1px solid gray; border-top: 0px;">
														<tr>
															<td style="text-align: left; border-bottom: 1px solid gray; border-right: 1px solid gray; width: 76%;">TOTAL REQUEST UNIT</td>
															<td style="border-bottom: 1px solid gray;text-align:right" class="amount subtotal"><?= $order->total_qty;?></td>
														</tr>
														<tr>
															<td style="text-align: left; border-bottom: 1px solid gray; border-right: 1px solid gray; width: 76%;">TOTAL APPROVED UNIT</td>
															<td style="border-bottom: 1px solid gray;text-align:right" class="amount subtotal"><?= $order->total_approved_qty;?></td>
														</tr>
														<tr>
															<td style="text-align: left; border-bottom: 1px solid gray; border-right: 1px solid gray; width: 76%;">SUBTOTAL</td>
															<td style="border-bottom: 1px solid gray;text-align:right" class="amount subtotal"><?php echo $order->total_amt_excl_vat;?></td>
														</tr>
														<tr>
															<td style="text-align: left; border-bottom: 1px solid gray; border-right: 1px solid gray; width: 76%;">VAT %</td>
															<td style="border-bottom: 1px solid gray;text-align:right" class="amount">15</td>
														</tr>
														<tr>
															<td style="text-align: left; border-bottom: 1px solid gray; border-right: 1px solid gray; width: 76%;">VAT AMOUNT</td>
															<td style="border-bottom: 1px solid gray;text-align:right" class="amount"><?php echo $order->vat_amt;?></td>
														</tr>
														<tr>
															<td style="text-align: left; border-bottom: 1px solid gray; border-right: 1px solid gray; width: 76%;">SHIPPING &amp; HANDLING</td>
															<td style="border-bottom: 1px solid gray;text-align:right" class="amount">-</td>
														</tr>
														<tr>
															<td style="text-align: left; width: 76%; border-right: 1px solid gray;">TOTAL</td>
															<td class="total amount" align="right"><?= $order->total_tax_inclusive;?></td>
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
<div class="modal fade stockModalFullscreen" tabindex="-1" aria-labelledby="#stockModalFullscreenLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0" id="stockModalFullscreenLabel">Stock Transfer Request - <?= $order->request_id;?></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href='<?php echo base_url(); ?>admin/stockrequest/detail?id=<?php echo $order->id;?>'"></button>
			</div>
			<div class="modal-body">
				<?php echo form_open('admin/stockrequest/approved_request', array("id"=>"approved_form"));?>
					<input type="hidden" name="request_id" value="<?= $order->id;?>" required="required" />
					<div class="row mb-2">
						<div class="col-12">
							<div class="row">
								<div class="col-6">
									<table class="table table-bordered border-gray mb-0">
										<thead>
											<tr>
												<th>STR Number:</th>
												<th>Request Date:</th>
												<th>Delivery Date:</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th><?= $order->request_id;?></th>
												<td><?= date("d-m-Y h:i:s", strtotime($order->created_at)); ?></td>
												<td>N/A</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="col-6 text-end">
									<address>
										<strong>Store Information:</strong><br>
										<?= $order->store_name;?> (<?= $order->storeid;?>)<br>
										<?= $order->store_location;?><br>
									</address>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="panel panel-default">
								<div class="p-2">
									<h4 class="panel-title font-size-20">Product summary</h4>
								</div>
								<div class="">
									<div class="table-responsive">
										<table class="table table-editable table-bordered">
											<thead>
											<tr>
												<td class="text-start"><strong>No.</strong></td>
												<td class="text-start" style="width: 100px;"><strong>SKU</strong></td>
												<td class="text-start"><strong>Barcode</strong></td>
												<td class="text-start"><strong>Item Description</strong></td>
												<td class="text-start"><strong>Size</strong></td>
												<td class="text-start"><strong>Request Unit</strong></td>
												<td class="text-start" style="width: 140px;"><strong>Approved Unit</strong></td>
											</tr>
											</thead>
											<tbody>
											<?php $count=1;foreach ($products as $product){ ?>
											<tr>
												<input type="hidden" name="item_req_id[]" value="<?= $product->id;?>" required="required" />
												<input type="hidden" name="size_id[]" value="<?= $product->size_id;?>" required="required" />
												<td class="text-start"><?= $count++;?></td>
												<td class="text-start"><?= $product->parent_sku;?>-<?= $product->item_sku;?></td>
												<td class="text-start"><?= $product->barcode;?></td>
												<td class="text-start"><?= $product->item_description;?></td>
												<td class="text-start"><?= $product->size;?></td>
												<td class="text-start"><?= $product->item_unit;?></td>
												<td class="text-start"><input type="number" min="0" max="1000" name="approved_unit[]" class="form-control" value="<?= $product->approved_unit;?>" required="required" /></td>
											</tr>
											<?php } ?>
											</tbody>
										</table>
									</div>
									
								</div>
							</div>

						</div>
					</div> <!-- end row -->
				<?php echo form_close(); ?>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="window.location.href='<?php echo base_url(); ?>admin/stockrequest/detail?id=<?php echo $order->id;?>'" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-success waves-effect waves-light" form="approved_form">Approve Quantity</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!---- Assign Vehicle Modal ---->
<div class="modal fade bs-example-modal-center" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0">Assign Vehicle</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href='<?php echo base_url(); ?>admin/stockrequest/detail?id=<?php echo $order->id;?>'">
					
				</button>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url('admin/stockrequest/assign_vehicle'); ?>" method="POST" id="assign_vehicle">
					<input type="hidden" name="request_id" value="<?php echo $order->id;?>" />
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<label class="control-label" for="vehicle_id">Select Driver </label>
								<select style="height:410px;" name="vehicle_id" id="vehicle_id" class="form-control select2" required>
									<option value="">Select Vehicle</option>
									<?php foreach($delv_vehicles as $dvehcile){?>
									<option value="<?php echo $dvehcile->id;?>" <?php echo ($dvehcile->id == $order->vehicle_id) ? "selected":"" ?>><?php echo $dvehcile->name;?>-<?php echo $dvehcile->iqama_no;?></option>
									<?php } ?>
								</select>
							</div>
							<small>Assign driver for stock transfer request</small><br/><br/>
						</div>
						<div class="col-md-12" style="padding-top: 24px;">
							<button type="submit" class="btn btn-success btn-md float-end">Assign</button>
							<button type="button" onclick="window.location.href='<?php echo base_url(); ?>admin/stockrequest/detail?id=<?php echo $order->id;?>'" class="btn btn-outline-danger btn-md float-end me-2">Cancel </button>
						</div>
					</div>
				</form>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--- Change Status Modal ---->
<div class="modal fade bs-status-modal-center" role="dialog" aria-labelledby="myStatusModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0">Update Status</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href='<?php echo base_url(); ?>admin/stockrequest/detail?id=<?php echo $order->id;?>'">
					
				</button>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url('admin/stockrequest/update_status'); ?>" method="POST" id="update_status">
					<input type="hidden" name="request_id" value="<?php echo $order->id;?>" />
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<label class="control-label" for="status">Select Status </label>
								<select style="height:410px;width:100%" name="status" id="status" class="form-control select2" required>
									<option value="">Select Status</option>
									<?php foreach($this->admin->getStatus() as $req_status){?>
									<option value="<?php echo $req_status->id;?>" <?php echo ($req_status->id <= $order->status) ? "disabled":"" ?>><?php echo $req_status->status_name;?></option>
									<?php } ?>
								</select>
							</div>
							<small>Update status for stock transfer request</small><br/><br/>
						</div>
						<div class="col-md-12" style="padding-top: 24px;">
							<button type="submit" class="btn btn-success btn-md float-end">Update</button>
							<button type="button" onclick="window.location.href='<?php echo base_url(); ?>admin/stockrequest/detail?id=<?php echo $order->id;?>'" class="btn btn-outline-danger btn-md float-end me-2">Cancel </button>
						</div>
					</div>
				</form>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php $this->load->view('admin/home/footer');?>

