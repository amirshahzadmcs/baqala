<?php $this->load->view('admin/home/header'); ?>
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
	.input-group-text {
        padding: 0 0.75rem;
    }
</style>


<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Product Purchases</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/purchase-reports'); ?>">Purchase Report</a></li>
						<li class="breadcrumb-item active">Product Purchases</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<!-- <?php //if($this->customer->userd($admin_id)->role=="Admin" ){
							?>
							<button type="button" class="btn btn-custom-danger btn-sm pull-right" onclick="deleteAction()" title="Delete"><i class="fa fa-trash"></i> Delete</button>
							<?php //} 
							?> -->
					&nbsp;
					<a class="btn btn-custom-danger btn-sm pull-right me-1" title="Purchase Report" href="<?php echo base_url('admin/purchase-reports') ?>"><i class="fa fa-chevron-left me-2"></i> Go back</a>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end page title -->


<div class="container-fluid">
	<div class="page-content-wrapper">
		<div class="row">

			<div class="col-12 mb-3">
				<div class="card">
					<div class="card-body">
						<form action="<?php echo base_url('admin/report/product_purchases') ?>" method="get">
							<div class="row">
								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="supplier">Supplier:</label>
									<select name="supplier" id="supplier" class="form-control select2 w-100" data-placeholder="Choose Supplier...">
										<option value="">Select</option>
										<!-- <option value="1">ALL</option> -->
										<?php foreach($supplier as $item) { ?>
											<option value="<?php echo $item->vendor_name;?>" <?php echo ($item->vendor_name == $this->input->get('supplier')) ? 'selected' : ''; ?>><?php echo $item->vendor_name; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="date_range">Date Range:</label>
									<div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#datepicker6">
										<input type="text" class="form-control" name="start" placeholder="Start Date" value="<?php echo $this->input->get('start'); ?>">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
										<input type="text" class="form-control" name="end" placeholder="End Date" value="<?php echo $this->input->get('end'); ?>">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
									</div>
								</div>
								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="product">Product:</label>
									<select name="product" id="product" class="form-control select2 w-100" data-placeholder="Choose Product...">
										<option value="">Select</option>
										<option value="1">All</option>
									</select>
								</div>
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="group_by">Group By:</label>
									<select name="group_by" class="form-control select2 w-100" data-placeholder="Choose Group By...">
										<option value="">Select</option>
										<option value="Yearly" <?php echo $this->input->get('group_by') == 'Yearly' ? 'selected' : '' ?>>Yearly</option>
										<option value="Monthly" <?php echo $this->input->get('group_by') == 'Monthly' ? 'selected' : '' ?>>Monthly</option>
										<option value="Weekly" <?php echo $this->input->get('group_by') == 'Weekly' ? 'selected' : '' ?>>Weekly</option>
										<option value="Daily" <?php echo $this->input->get('group_by') == 'Daily' ? 'selected' : '' ?>>Daily</option>
										<option value="Product" <?php echo $this->input->get('group_by') == 'Product' ? 'selected' : '' ?>>Product</option>
										<option value="Supplier" <?php echo $this->input->get('group_by') == 'Supplier' ? 'selected' : '' ?>>Supplier</option>
										<option value="Staff" <?php echo $this->input->get('group_by') == 'Staff' ? 'selected' : '' ?>>Staff</option>
									</select>
								</div>
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="currency">Currency:</label>
									<select name="currency" class="form-control select2 w-100" data-placeholder="Choose Currency...">
										<option value="">Select</option>
										<!-- <option value="1">All in SAR</option>
										<option value="2">All Separated</option> -->
										<option value="1" selected>SAR</option>
									</select>
								</div>
								<div class="form-group col-lg-3 col-md-4 col-12 mb-3">
									<label for="order_by">Order By:</label>
									<select name="order_by" class="form-control select2 w-100" data-placeholder="Choose Order By...">
										<option value="">Select</option>
										<option value="dd" <?php echo $this->input->get('order_by') == 'dd' ? 'selected' : '' ?>>Date Descending</option>
										<option value="da" <?php echo $this->input->get('order_by') == 'da' ? 'selected' : '' ?>>Date Ascending</option>
										<option value="nd" <?php echo $this->input->get('order_by') == 'nd' ? 'selected' : '' ?>>Number Descending</option>
										<option value="na" <?php echo $this->input->get('order_by') == 'na' ? 'selected' : '' ?>>Number Ascending</option>
									</select>
								</div>
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="button"></label>
									<input type="submit" value="Show report" class="form-control btn btn-success mt-2" />
								</div>
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="button"></label>
									<a href="<?php echo base_url('admin/report/product_purchases') ?>"class="form-control btn btn-danger mt-2">Reset</a>
									<!-- <input type="submit" value="Show report" class="form-control btn btn-success mt-2" /> -->
								</div>
							</div>
						</form>
					</div>
				</div>
			</div> <!-- end col -->
			
			<?php if(count($purchases) > 0) { ?>
				<div class="col-12 mb-3">
					<div class="row px-5 align-items-center">
						<div class="col-6 text-start">
							<button class="btn btn-secondary btn-sm mb-3"> <i class="fa fa-list me-1"></i> Summary</button>
							<button class="btn btn-secondary btn-sm mb-3"> <i class="fa fa-search me-1"></i> Details</button>
						</div>
						<div class="col-6 text-end">
							<div class="btn-group mb-3" role="group">
								<button id="exportButton" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="fa fa-download me-1"></i> <?php //$this->input->get('client'); 
																		?> Export <i class="mdi mdi-chevron-down"></i>
								</button>
								<div class="dropdown-menu" aria-labelledby="exportButton" style="margin: 0px;">
									<a class="dropdown-item" href="<?php echo base_url('admin/report/revenue') ?>">Export to CSV</a>
									<a class="dropdown-item" href="<?php echo base_url('admin/report/revenue') ?>">Export to Excel</a>
									<a class="dropdown-item" href="<?php echo base_url('admin/report/revenue') ?>">Export to PDF</a>
									<a class="dropdown-item" href="<?php echo base_url('admin/report/revenue') ?>">Export to PDF no graph</a>
								</div>
							</div>
							<button class="btn btn-secondary btn-sm mb-3"> <i class="fa fa-print me-1"></i> Print</button>
							<!-- <button class="btn btn-secondary btn-sm"> <i class="fa fa-download me-1"></i> Export</button> -->
						</div>
					</div>
				</div> <!-- end col -->
				<div class="col-12 mb-3">
					<div class="card">
						<div class="card-body text-center">
							<p class="fs-5 fw-bold mb-1">Product Purchases Report - Group By Product</p>
							<p class="fw-bold mb-1">Time <?php echo date('d/m/Y H:i'); ?></p>
							<?php if(($this->input->get('start')) && ($this->input->get('end'))) { ?>
								<p class="fw-bold mb-1">From <?php echo $this->input->get('start'); ?> To <?php echo $this->input->get('end'); ?></p>
							<?php } else { ?>
								<p class="fw-bold mb-1">From All Data Available</p>
							<?php } ?>
							<p class=""><hr></p>
							<p class="mb-1">Baqala Station</p>
							<p class="mb-1">Riyadh</p>
							<p class="mb-1">Riyadh, MS 12312</p>
						</div>
					</div>
				</div> <!-- end col -->

				<div class="col-12 mb-3">
					<div class="card">
						<div class="card-body">
							<div class="row align-items-center">
								<div class="col-lg-12 col-12 mb-5">
									<h6 class="header-title mb-2">Purchases By Supplier (SAR)</h6>
									<div id="column_chart" class="apex-charts" dir="ltr"></div>
								</div>
								<!-- <div class="col-lg-5 col-12 mb-3">
									<h6 class="header-title">Payments Summary (SAR)</h6>
									<div id="donut_chart" class="apex-charts" dir="ltr"></div>
								</div> -->
							</div>
						</div>
					</div>
				</div> <!-- end col -->

				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<table class="table table-bordered">
								<!-- <thead>
									<tr>
										<th style="width: 46px;">ID</th>
										<th style="width: 101px;">Name</th>
										<th style="width: 101px;">Item</th>
										<th style="width: 86px;">Product Code</th>
										<th style="width: 99px;">Date</th>
										<th style="width: 119px;">Type</th>
										<th style="width: 74px;">Staff</th>
										<th style="width: 166px;">Supplier</th>
										<th style="width: 68px;">Unit Price</th>
										<th style="width: 73px;">Total Taxes</th>
										<th style="width: 77px;">Quantity</th>
										<th style="width: 95px;">Total (SAR)</th>
									</tr>
								</thead> -->
								<tbody>

									<?php 
										$quantity = 0;
										$total_price = 0;
										$i = 1;
										foreach($purchases as $item) { 
									?>
									<tr>
										<td class="" colspan="12">
											<div class="py-1"><?php echo $item->description; ?></div>
										</td>
									</tr>
									<tr>
										<th style="width: 46px;">ID</th>
										<th style="width: 101px;">Name</th>
										<th style="width: 101px;">Item</th>
										<th style="width: 86px;">Product Code</th>
										<th style="width: 99px;">Date</th>
										<th style="width: 119px;">Type</th>
										<th style="width: 74px;">Staff</th>
										<th style="width: 166px;">Supplier</th>
										<th style="width: 68px;">Unit Price</th>
										<th style="width: 73px;">Total Taxes</th>
										<th style="width: 77px;">Quantity</th>
										<th style="width: 95px;">Total (SAR)</th>
									</tr>
									<tr>
										<td>
											<div class="py-1"><?php echo $i; ?></div>
										</td>
										<td>
											<div class="py-1"><?php echo $item->description; ?></div>
										</td>
										<td>
											<div class="py-1"><?php echo $item->description; ?></div>
										</td>
										<td>
											<div class="py-1"><?php echo $item->prod_id; ?></div>
										</td>
										<td>
											<div class="py-1"><?php echo date('d/m/Y', strtotime($item->date)); ?></div>
										</td>
										<td>
											<div class="py-1"><a href="javascript:;">Purchase Invoice# <?php echo $item->po_number; ?></a></div>
										</td>
										<td>
											<div class="py-1">N/A</div>
										</td>
										<td>
											<div class="py-1"><?php echo $item->vendor_name; ?></div>
										</td>
										<td>
											<div class="py-1"><?php echo $item->unit_price; ?></div>
										</td>
										<td>
											<div class="py-1"><span class=""><?php echo $item->vat; ?></span></div>
										</td>
										<td>
											<div class="py-1"><?php echo $item->units; ?></div>
										</td>
										<td>
											<div class="py-1"><span class=""><?php echo $item->total; ?></span></div>
										</td>
									</tr>
									<tr>
										<td colspan="10">Subtotal</td>
										<td>
											<div class="py-1"><?php echo $item->units; ?></div>
										</td>
										<td>
											<div class="py-1">
												<span class=""><?php echo $item->total; ?></span>
											</div>
										</td>
									</tr>
									<?php
										$quantity += $item->units;
										$total_price += $item->total;
									?>
									<tr>
										<td colspan="12">&nbsp;</td>
									</tr>
									<?php $i++; } ?>
									<tr>
										<th colspan="10">Totals</th>
										<th>
											<div class="py-1"><?php echo $quantity; ?></div>
										</th>
										<th>
											<div class="py-1"><span class="">SAR <?php echo $total_price; ?></span></div>
										</th>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div> <!-- end col -->
			<?php } else { ?>
				<div class="col-9 mb-3 mx-auto">
					<div class="card">
						<div class="card-body bg-soft-warning text-center pb-2">
							<p class="fw-bold">No data match the supplied filters</p>
						</div>
					</div>
				</div> <!-- end col -->
			<?php } ?>
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->


<?php $this->load->view('admin/home/footer'); ?>

<script src="<?php echo base_url('admin_assets/libs/apexcharts/apexcharts.min.js'); ?>"></script>
<script>
	options = {
		chart: { height: 350, type: "bar", toolbar: { show: !1 } },
		plotOptions: { bar: { horizontal: !1, columnWidth: "80%",} },
		dataLabels: { enabled: !1 },
		stroke: { show: !0, width: 2, colors: ["transparent"] },
		series: [
			<?php foreach($purchases as $data) { ?>
			{ name: "<?php echo $data->description; ?>", data: ['<?php echo $data->total; ?>'] },
			<?php } ?>
		],
		colors: ["#23c58f"],
		xaxis: { categories: ["Total"], title: { text: "" } },
		yaxis: { title: { text: "" } },
		grid: { borderColor: "#f1f1f1", padding: { bottom: 10 } },
		fill: { opacity: 1 },
		tooltip: {
			y: {
				formatter: function (e) {
					return "SAR " + e + "";
				},
			},
		},
		legend: { offsetY: 7 },
		};
	(chart = new ApexCharts(document.querySelector("#column_chart"), options)).render();
</script>
