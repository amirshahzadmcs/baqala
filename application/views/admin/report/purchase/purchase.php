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
					<h4>Detailed Purchases by Supplier</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/purchase-reports'); ?>">Purchase Report</a></li>
						<li class="breadcrumb-item active">Detailed Purchases by Supplier</li>
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
						<form action="<?php echo base_url('admin/report/purchases') ?>" method="get">
							<div class="row">
								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="supplier">Supplier:</label>
									<select name="supplier" id="supplier" class="form-control select2 w-100" data-placeholder="Choose Supplier...">
										<option value="">Select</option>
										<option value="">ALL</option>
										<?php foreach($supplier as $item) { ?>
											<option value="<?php echo $item->vendor_name;?>" <?php echo ($item->vendor_name == $this->input->get('supplier')) ? 'selected' : ''; ?>><?php echo $item->vendor_name; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="status">Status:</label>
									<select name="status" class="form-control select2 w-100" data-placeholder="Choose Status...">
										<option value="">Select</option>
										<option value="1">ALL</option>
										<option value="2">Paid</option>
										<option value="3">Partially Paid</option>
										<option value="3">Unpaid</option>
										<option value="3">Overdue</option>
									</select>
								</div>
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="staff">Staff:</label>
									<select name="staff" class="form-control select2 w-100" data-placeholder="Choose Staff...">
										<option value="">Select</option>
										<option value="2">Amanullah Kazi</option>
									</select>
								</div>
								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="date_range">Date Range:</label>
									<div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#datepicker6">
										<input type="text" class="form-control" name="start" placeholder="Start Date" value="<?php echo $this->input->get('start');?>">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
										<input type="text" class="form-control" name="end" placeholder="End Date" value="<?php echo $this->input->get('end');?>">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
									</div>
								</div>
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="work_order">Work Order:</label>
									<select name="work_order" id="work_order" class="form-control select2" data-placeholder="Choose Work Order...">
										<option value="">Select</option>
										<option value="1">Select</option>
									</select>
								</div>
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="branch">Branch:</label>
									<select name="branch" id="branch" class="form-control select2 w-100" data-placeholder="Choose Branch...">
										<option value="">Select</option>
										<option value="1">Main Branch</option>
									</select>
								</div>
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="button"></label>
									<input type="submit" value="Show report" class="form-control btn btn-success mt-2" />
								</div>
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="button"></label>
									<a href="<?php echo base_url('admin/report/purchases') ?>"class="form-control btn btn-danger mt-2">Reset</a>
									<!-- <input type="submit" value="Show report" class="form-control btn btn-success mt-2" /> -->
								</div>
							</div>
						</form>
					</div>
				</div>
			</div> <!-- end col -->
			<?php if((count($grv) > 0) && ($grv != NULL)) { ?>
				<div class="col-12 mb-3">
					<div class="row px-5 align-items-center">
						<div class="col-6 text-start">
							<button class="btn btn-secondary btn-sm mb-3"> <i class="fa fa-list me-1"></i> Summary</button>
							<button class="btn btn-secondary btn-sm mb-3"> <i class="fa fa-search me-1"></i> Details</button>
							<div class="btn-group mb-3" role="group">
								<?php
									$start_date = date('Y-m-d');
									$startDate = date('d M, Y');
									$daily = date('d M, Y');
									$weekly = date('d M, Y', strtotime($start_date.'-7 days'));
									$monthly = date('d M, Y', strtotime($start_date.'-31 days'));
									$yearly = date('d M, Y', strtotime($start_date.'-1 year'));
									$supplier = !empty($this->input->get('supplier')) ? $this->input->get('supplier') : '' ;
								?>
								<button id="btnGroupVerticalDrop1" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<?php
										if(($this->input->get('start') == $daily) && ($this->input->get('end') == $startDate) ) {
											echo 'Daily';
										} 
										else if(($this->input->get('start') == $weekly) && ($this->input->get('end') == $startDate)) {
											echo 'Weekly';
										}
										else if(($this->input->get('start') == $monthly) && ($this->input->get('end') == $startDate)) {
											echo 'Monthly';
										}
										else if(($this->input->get('start') == $yearly) && ($this->input->get('end') == $startDate)) {
											echo 'Yearly';
										}
										else {
											echo 'Client';
										}
									?> <i class="mdi mdi-chevron-down"></i>
								</button>
								<div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" style="margin: 0px;">
									<a class="dropdown-item" href="<?php echo base_url('admin/report/purchases?supplier='.$supplier.'&start='.$daily.'&end='.$startDate.'') ?>">Daily</a>
									<a class="dropdown-item" href="<?php echo base_url('admin/report/purchases?supplier='.$supplier.'&start='.$weekly.'&end='.$startDate.'') ?>">Weekly</a>
									<a class="dropdown-item" href="<?php echo base_url('admin/report/purchases?supplier='.$supplier.'&start='.$monthly.'&end='.$startDate.'') ?>">Monthly</a>
									<a class="dropdown-item" href="<?php echo base_url('admin/report/purchases?supplier='.$supplier.'&start='.$yearly.'&end='.$startDate.'') ?>">Yearly</a>
									<a class="dropdown-item" href="<?php echo base_url('admin/report/purchases') ?>">Staff</a>
									<a class="dropdown-item" href="<?php echo base_url('admin/report/purchases') ?>">Sales Person</a>
									<a class="dropdown-item" href="<?php echo base_url('admin/report/purchases') ?>" selected>Client</a>
								</div>
							</div>
						</div>
						<div class="col-6 text-end">
							<div class="btn-group mb-3" role="group">
							<?php
								$start = $this->input->get('start');
								$end = $this->input->get('end');
								$supplier = $this->input->get('supplier');
								$page = 'Detailed%20Purchases%20by%20Supplier';
							?>
								<button id="exportButton" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="fa fa-download me-1"></i> <?php //$this->input->get('client'); 
																		?> Export <i class="mdi mdi-chevron-down"></i>
								</button>
								<div class="dropdown-menu" aria-labelledby="exportButton" style="margin: 0px;">
									<a class="dropdown-item" href="<?php echo base_url('admin/report/purchases') ?>">Export to CSV</a>
									<a class="dropdown-item" href="<?php echo base_url('admin/report/purchases') ?>">Export to Excel</a>
									<a class="dropdown-item" href="<?php echo base_url('admin/purchase/print_report?supplier='.$supplier.'&status=&staff=&start='.$start.'&end='.$end.'&work_order=&branch=&page='.$page.'&by=Amanullah%20Kazi') ?>" target="_blank">Export to PDF</a>
									<a class="dropdown-item" href="<?php echo base_url('admin/report/purchases') ?>">Export to PDF no graph</a>
								</div>
							</div>
							<a class="btn btn-secondary btn-sm mb-3" href="<?php echo base_url('admin/purchase/print_report?supplier='.$supplier.'&status=&staff=&start='.$start.'&end='.$end.'&work_order=&branch=&page='.$page.'&by=Amanullah%20Kazi') ?>" target="_blank"> <i class="fa fa-print me-1"></i> Print</a>
							<!-- <button class="btn btn-secondary btn-sm"> <i class="fa fa-download me-1"></i> Export</button> -->
						</div>
					</div>
				</div> <!-- end col -->
				<div class="col-12 mb-3">
					<div class="card">
						<div class="card-body text-center">
							<p class="fs-5 fw-bold mb-1">Detailed Purchases by Supplier</p>
							<?php if(($this->input->get('start')) && ($this->input->get('end'))) { ?>
								<p class="fw-bold mb-1">From <?php echo $this->input->get('start'); ?> To <?php echo $this->input->get('end'); ?></p>
							<?php } else { ?>
								<p class="fw-bold mb-1">From All Data Available</p>
							<?php } ?>
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
								<div class="col-lg-7 col-12 mb-5">
									<h6 class="header-title mb-2">Purchases By Supplier (SAR)</h6>
									<div id="column_chart" class="apex-charts" dir="ltr"></div>
								</div>
								<div class="col-lg-5 col-12 mb-3">
									<h6 class="header-title">Payments Summary (SAR)</h6>
									<div id="donut_chart" class="apex-charts" dir="ltr"></div>
								</div>
							</div>
						</div>
					</div>
				</div> <!-- end col -->
				
				<div class="col-12 mb-3 mx-auto">
					<div class="card">
						<div class="card-body pb-2">
							<div class="col-12 table-responsive">
								<table cellspacing="0" cellpadding="4" width="100%" class="table table-bordered">
									<!-- <thead>
										<tr>
											<th style="width: 11%;">NO</th>
											<th style="width: 11%;">Date</th>
											<th style="width: 11%;">Staff</th>
											<th style="width: 11%;">Paid (SAR)</th>
											<th style="width: 11%;">Unpaid (SAR)</th>
											<th style="width: 11%;">Refund (SAR)</th>
											<th style="width: 12%;">Total (SAR)</th>
										</tr>
									</thead> -->
									<tbody>
										<?php $sub_total = 0; $total = 0; $unpaid = 0; $refund = 0; ?>
										<?php foreach($grv as $item){ ?>
										<tr>
											<td colspan="8"><?php echo $item->vendor; ?> <br> <span><strong>VAT No: </strong><?php echo isset($item->vat_no) ? $item->vat_no : 'N/A'; ?></span></td>
										</tr>
										<tr>
											<th style="width: 11%;">PO NO</th>
											<th style="width: 11%;">Date</th>
											<th style="width: 11%;">Staff</th>
											<th style="width: 11%;">Paid (SAR)</th>
											<th style="width: 11%;">Unpaid (SAR)</th>
											<th style="width: 11%;">Refund (SAR)</th>
											<th style="width: 12%;">Total (SAR)</th>
										</tr>
										<tr class="subtotal">
											<td><?php echo $item->po_no; ?></td>
											<td><?php echo date('d-M-Y',strtotime($item->invoice_date)); ?></td>
											<td><?php echo 'N/A'; ?></td>
											<td><?php echo number_format($item->grv_value,2); ?></td>
											<td><?php echo number_format($unpaid,2); ?></td>
											<td><?php echo number_format($refund,2); ?></td>
											<td><?php echo number_format($item->grv_value,2); ?></td>
											<?php 
												$sub_total += $item->grv_value;
												$total += $item->grv_value;
											?>
										</tr>
										<tr>
											<td colspan="8"> &nbsp; </td>
										</tr>
										<?php } ?>
									</tbody>
									<tfoot>
										<tr>
											<th colspan="3">NET (SAR)</th>
											<th><?php echo number_format($sub_total,2); ?></th>
											<th><?php echo number_format($unpaid,2); ?></th>
											<th><?php echo number_format($refund,2); ?></th>
											<th><?php echo number_format($total,2); ?></th>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				</div> <!-- end col -->
				
			<?php } else { ?>

				<div class="col-9 mb-3 mx-auto">
					<div class="card">
						<div class="card-body bg-soft-warning text-center pb-2">
							<p class="fw-bold">No results found to match these filters</p>
							<p class="fw-bold">Change search filters and try again</p>
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
		plotOptions: { bar: { horizontal: !1, columnWidth: "100%",} },
		dataLabels: { enabled: !1 },
		stroke: { show: !0, width: 2, colors: ["transparent"] },
		series: [
			{ name: "Total", data: [<?php echo $total ?>,'','',''] },
			{ name: "Refund", data: ['',<?php echo $refund ?>,'',''] },
			{ name: "Paid", data: [,'','',<?php echo $total ?>,''] },
			{ name: "Unpaid", data: [,'','','',<?php echo $unpaid ?>] },
		],
		colors: ["#23c58f", "#525ce5", "#23c58f", "#f14e4e"],
		xaxis: { categories: [""], title: { text: "Test" } },
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

	options = {
	chart: { height: 260, type: "donut" },
	series: [<?php echo $refund ?>, <?php echo $total ?>, <?php echo $unpaid ?>],
	labels: ["Refund", "Paid", "Unpaid"],
	colors: ["#525ce5", "#23c58f", "#f14e4e"],
	legend: { show: !0, position: "bottom", horizontalAlign: "center", verticalAlign: "middle", floating: !1, fontSize: "14px", offsetX: 0, offsetY: 5 },
	responsive: [{ breakpoint: 600, options: { chart: { height: 240 }, legend: { show: !1 } } }],
	};
	(chart = new ApexCharts(document.querySelector("#donut_chart"), options)).render();
</script>
<!-- <script src="<?php //echo base_url('admin_assets/js/pages/apexcharts.init.js'); ?>"></script> -->
