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
					<h4>Revenue by Client</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/sales-report'); ?>">Sales Report</a></li>
						<li class="breadcrumb-item active">Revenue by Client</li>
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
					<a class="btn btn-custom-danger btn-sm pull-right me-1" title="Sales Report" href="<?php echo base_url('admin/sales-report') ?>"><i class="fa fa-chevron-left me-2"></i> Go back</a>
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
						<form action="<?php echo base_url('admin/report/revenue') ?>" method="get">
							<div class="row">
								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="client">Client:</label>
									<select name="client" id="client" class="form-control select2 w-100" data-placeholder="Choose Client...">
										<option value="">Select</option>
										<?php foreach($clients as $item) { ?>
											<option value="<?php echo $item->id;?>" <?php echo ($item->id == $this->input->get('client')) ? 'selected' : ''; ?>><?php echo $item->name. ' (' . $item->company_name .')'; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="invoice_by">Invoiced By:</label>
									<select name="invoice_by" id="invoice_by" class="form-control select2 w-100" data-placeholder="Choose Invoiced By...">
										<option value="">Select</option>
										<option value="1" <?php echo ($this->input->get('invoice_by') == '1') ? 'selected' : '' ?>>Amanullah Kazi</option>
									</select>
								</div>
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="status">Status:</label>
									<select name="status" class="form-control select2 w-100" data-placeholder="Choose Status...">
										<option value="">Select</option>
										<option value="1" <?php echo ($this->input->get('status') == '1') ? 'selected' : '' ?>>Paid</option>
										<option value="2" <?php echo ($this->input->get('status') == '2') ? 'selected' : '' ?>>Partially Paid</option>
										<option value="3" <?php echo ($this->input->get('status') == '3') ? 'selected' : '' ?>>Unpaid</option>
										<option value="4" <?php echo ($this->input->get('status') == '4') ? 'selected' : '' ?>>Overdue</option>
										<option value="5" <?php echo ($this->input->get('status') == '5') ? 'selected' : '' ?>>Refund Receipt</option>
									</select>
								</div>
								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="date_range">Date Range:</label>
									<div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#datepicker6">
										<!--<div class="input-group" id="datepicker1">-->
                                            <input type="text" class="form-control" name="start" placeholder="Start Date" value="<?php echo $this->input->get('start') ?>">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        <!--</div>-->
										<!--<div class="input-group" id="datepicker1">-->
                                            <input type="text" class="form-control" name="end" placeholder="End Date" value="<?php echo $this->input->get('end') ?>">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        <!--</div>-->
									</div>
								</div>
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="branch">Branch:</label>
									<select name="branch" id="branch" class="form-control select2 w-100" data-placeholder="Choose Branch...">
										<option value="">Select</option>
										<option value="1" <?php echo ($this->input->get('branch') == '1') ? 'selected' : '' ?>>Main Branch</option>
									</select>
								</div>
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="work_order">Work Order:</label>
									<select name="work_order" id="work_order" class="form-control select2" data-placeholder="Choose Work Order...">
										<option value="">Select</option>
									</select>
								</div>
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="button"></label>
									<input type="submit" value="Show report" class="form-control btn btn-success mt-2" />
								</div>
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="button"></label>
									<a href="<?php echo base_url('admin/report/revenue') ?>"class="form-control btn btn-danger mt-2">Reset</a>
									<!-- <input type="submit" value="Show report" class="form-control btn btn-success mt-2" /> -->
								</div>
							</div>
						</form>
					</div>
				</div>
			</div> <!-- end col -->

			<?php if(count($orders) > 0) { ?>
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
									$supplier = !empty($this->input->get('client')) ? $this->input->get('client') : '' ;
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
									<a class="dropdown-item" href="<?php echo base_url('admin/report/revenue?client='.$supplier.'&start='.$daily.'&end='.$startDate.'') ?>">Daily</a>
									<a class="dropdown-item" href="<?php echo base_url('admin/report/revenue?client='.$supplier.'&start='.$weekly.'&end='.$startDate.'') ?>">Weekly</a>
									<a class="dropdown-item" href="<?php echo base_url('admin/report/revenue?client='.$supplier.'&start='.$monthly.'&end='.$startDate.'') ?>">Monthly</a>
									<a class="dropdown-item" href="<?php echo base_url('admin/report/revenue?client='.$supplier.'&start='.$yearly.'&end='.$startDate.'') ?>">Yearly</a>
									<a class="dropdown-item" href="<?php echo base_url('admin/report/revenue') ?>">Staff</a>
									<a class="dropdown-item" href="<?php echo base_url('admin/report/revenue') ?>">Sales Person</a>
									<a class="dropdown-item" href="<?php echo base_url('admin/report/revenue') ?>" selected>Client</a>
								</div>
							</div>
						</div>
						<div class="col-6 text-end">
							<div class="btn-group mb-3" role="group">
								<?php
									$start = $this->input->get('start');
									$end = $this->input->get('end');
									$supplier = $this->input->get('client');
									$page = 'Detailed%20Revenue%20by%20Client';
								?>
								<button id="exportButton" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="fa fa-download me-1"></i> <?php //$this->input->get('client'); 
																		?> Export <i class="mdi mdi-chevron-down"></i>
								</button>
								<div class="dropdown-menu" aria-labelledby="exportButton" style="margin: 0px;">
									<a class="dropdown-item" href="<?php echo base_url('admin/report/revenue') ?>">Export to CSV</a>
									<a class="dropdown-item" href="<?php echo base_url('admin/report/revenue') ?>">Export to Excel</a>
									<a class="dropdown-item" href="<?php echo base_url('admin/report/print_report?client='.$supplier.'&invoice_by=&status=&start='.$start.'&end='.$end.'&page='.$page.'&branch=&work_order=&by=Amanullah%20Kazi') ?>" target="_blank">Export to PDF</a>
									<a class="dropdown-item" href="<?php echo base_url('admin/report/revenue') ?>">Export to PDF no graph</a>
								</div>
							</div>
							<a class="btn btn-secondary btn-sm mb-3" href="<?php echo base_url('admin/report/print_report?client='.$supplier.'&invoice_by=&status=&start='.$start.'&end='.$end.'&page='.$page.'&branch=&work_order=&by=Amanullah%20Kazi') ?>" target="_blank"> <i class="fa fa-print me-1"></i> Print</a>
							<!-- <button class="btn btn-secondary btn-sm"> <i class="fa fa-download me-1"></i> Export</button> -->
						</div>
					</div>
				</div> <!-- end col -->

				<div class="col-12 mb-3">
					<div class="card">
						<div class="card-body text-center">
							<p class="fs-5 fw-bold mb-1">Detailed Revenue by Client</p>
							<p class="fw-bold mb-1">
								<?php if($this->input->get('start') && $this->input->get('end')) { ?>
									From <?php echo $this->input->get('start'); ?> To <?php echo $this->input->get('end'); ?>
								<?php } else { ?>
									From All Data Available
								<?php } ?>
							</p>
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
									<h6 class="header-title mb-2">Revenue By Client (SAR)</h6>
									<!-- <p class="card-title-desc">Example of bar chart chart js.</p> -->
									<!-- <canvas id="barChart"></canvas> -->
									<div id="column_chart" class="apex-charts" dir="ltr"></div>
								</div>
								<div class="col-lg-5 col-12 mb-3">
									<h6 class="header-title">Payments Summary (SAR)</h6>
									<!-- <canvas id="donutChart"></canvas> -->
									<div id="donut_chart" class="apex-charts" dir="ltr"></div>
								</div>
							</div>
						</div>
					</div>
				</div> <!-- end col -->

				<div class="col-12 mb-3">
					<div class="card">
						<div class="card-body table-responsive pt-4" style="overflow-x: scroll;">
							<table cellspacing="0" cellpadding="4" width="100%" class="table table-bordered mb-0">
								<!-- <thead>
									<tr>
										<th>No.</th>
										<th>Date</th>
										<th>Staff</th>
										<th>Paid (SAR)</th>
										<th>Unpaid (SAR)</th>
										<th>Refund (SAR)</th>
										<th>Total (SAR)</th>
									</tr>
								</thead> -->
								<tbody>
									<?php 
										$total = 0; $refund = 0; $unpaid = 0; $paid = 0;
										foreach($orders as $item) { 
									?>
										<tr>
											<th>No.</th>
											<th>Date</th>
											<th>Staff</th>
											<th>Paid (SAR)</th>
											<th>Unpaid (SAR)</th>
											<th>Refund (SAR)</th>
											<th>Total (SAR)</th>
										</tr>
										<tr>
											<td colspan="6"><?php echo $item->c_company; ?></td>
										</tr>
										<tr>
											<td><?php echo $item->invoice_prefix.'-'.$item->id; ?></td>
											<td><?php echo date('d/m/Y', strtotime($item->date_added)); ?></td>
											<td>Amanullah Kazi</td>
											<td><?php echo number_format($item->net_payble_amt, '2'); ?></td>
											<td><?php echo number_format($unpaid, '2'); ?></td>
											<td><?php echo number_format($refund, '2'); ?></td>
											<td><?php echo number_format($item->net_payble_amt, '2'); ?></td>
										</tr>
										<tr>
											<td colspan="3">Subtotal</td>
											<td><?php echo number_format($item->net_payble_amt, '2'); ?></td>
											<td><?php echo number_format($unpaid, '2'); ?></td>
											<td><?php echo number_format($refund, '2'); ?></td>
											<td><?php echo number_format($item->net_payble_amt, '2'); ?></td>
										</tr>
											<?php
												$paid += $item->net_payble_amt;
												$total += $item->net_payble_amt;
												$unpaid += $unpaid;
												$refund += $refund;
											?>
										<tr>
											<td colspan="6">&nbsp;</td>
										</tr>
									<?php } ?>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="3">NET (SAR)</td>
										<td><?php echo number_format($paid, '2'); ?> SR</td>
										<td><?php echo number_format($unpaid, '2'); ?> SR</td>
										<td><?php echo number_format($refund, '2'); ?> SR</td>
										<td><?php echo number_format($total, '2'); ?> SR</td>
									</tr>
								</tfoot>
							</table>
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
		xaxis: { categories: [""], title: { text: "Detailed Revenue by Client" } },
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
