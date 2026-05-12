<?php $this->load->view('stores/layout/header');?>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <!-- start page title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="page-title">
                            <h4>Order Detail</h4>
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo base_url('store'); ?>">Home</a></li>
                                <li class="breadcrumb-item"><a href="<?php echo base_url('store/order/new-orders'); ?>">Orders</a></li>
                                <li class="breadcrumb-item active">Detail</li>
                            </ol>
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
								<div class="row">
									<div class="col-12">
										<div class="card m-b-30">
											<div class="card-body">
												<div class="row">
													<div class="col-12">
														<div class="invoice-title">
															<h4 class="float-end font-size-16"><strong>Order # 12345</strong></h4>
															<h3 class="m-t-0">
																<img src="<?php echo base_url('assets/image/logo.png');?>" alt="logo" height="50"/>
															</h3>
														</div>
														<hr>
														<div class="row">
															<div class="col-6">
																<address>
																	<strong>Billed To:</strong><br>
																	Ricky Clemons
																</address>
															</div>
															<div class="col-6 text-end">
																<address>
																	<strong>Order Date:</strong><br>
																	October 7, 2016<br><br>
																</address>
															</div>
														</div>
														<div class="row">
															<div class="col-6 m-t-30">
																<address>
																	<strong>Payment Method:</strong><br>
																	COD
																</address>
															</div>
															<div class="col-6 m-t-30 text-end">
																
															</div>
														</div>
													</div>
												</div>
				
												<div class="row">
													<div class="col-12">
														<div class="panel panel-default">
															<div class="p-2">
																<h3 class="panel-title font-size-18"><strong>Order summary</strong></h3>
															</div>
															<div class="">
																<div class="table-responsive">
																	<table class="table">
																		<thead>
																		<tr>
																			<td valign="top" bgcolor="#CCCCCC" style="width: 5%; text-align: center;"><strong>#</strong></td>
																			<td valign="top" bgcolor="#CCCCCC" style="width: 8%; text-align: center;"><strong>IMAGE</strong></td>
																			<td valign="top" bgcolor="#CCCCCC" style="width: 12%; text-align: center;"><strong>BARCODE</strong></td>
																			<td valign="top" bgcolor="#CCCCCC" style="width: 34%; text-align: center;"><strong>PRODUCT NAME/ DESCRIPTION</strong></td>
																			<td valign="top" bgcolor="#CCCCCC" style="width: 5%; text-align: center;"><strong>Size</strong></td>
																			<td valign="top" bgcolor="#CCCCCC" style="width: 8%; text-align: center;"><strong>PRICE</strong></td>
																			<td valign="top" bgcolor="#CCCCCC" style="width: 6%; text-align: center;"><strong>QTY</strong></td>
																			<td valign="top" bgcolor="#CCCCCC" style="width: 7%; text-align: center;"><strong>TOTAL</strong></td>
																		</tr>
																		</thead>
																		<tbody>
																			<!-- foreach ($order->lineItems as $line) or some such thing here -->
																			<tr>
																				<td class="text-center">1.</td>
																				<td class="text-center"><img class="avatar-sm" src="http://localhost/projects/warehouse6/images/notfound.jpg" width="80px"></td>
																				<td class="text-center">3202212002139</td>
																				<td>Fa Shower Gel And Shampoo Kids Ocean 250ml<br><pre class="text-end">فا شاور جل وشامبو كيدز اوشن 250 مل</pre></span></td>
																				<td class="text-center">250 ml</td>
																				<td class="text-end">100 SAR</td>
																				<td class="text-center">10</td>
																				<td class="text-end">1000 SAR</td>
																			</tr>
																		</tbody>
																	</table>
																</div>
				
																<div class="d-print-none mo-mt-2">
																	<div class="float-end">
																		<a href="javascript:window.print()" class="btn btn-success waves-effect waves-light"><i class="fa fa-print"></i></a>
																		<a href="javascript:;" class="btn btn-primary waves-effect waves-light">Accept Order</a>
																	</div>
																</div>
															</div>
														</div>
				
													</div>
												</div> <!-- end row -->
				
											</div>
										</div>
									</div> <!-- end col -->
								</div> <!-- end row --> 
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
<!-- end page content-->

<?php $this->load->view('stores/layout/footer');?>
<script>
	
</script>
