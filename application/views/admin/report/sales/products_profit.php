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
					<h4>Product Sales Profit</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/sales-report'); ?>">Sales Report</a></li>
						<li class="breadcrumb-item active">Product Sales Profit</li>
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
					<div class="card-header d-flex align-items-center">
						<p class="fw-bold mb-0">Search</p> <span></span>
					</div>
					<div class="card-body">
						<form action="<?php echo base_url('admin/report/products_profit') ?>" method="get">
							<div class="row">
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="category">Category:</label>
									<select name="category" id="category" class="form-control select2 w-100" data-placeholder="Choose Client...">
										<option value="">Select</option>
										<option value="1">ALL</option>
										<option value="2">ABC</option>
										<option value="3">XYZ</option>
									</select>
								</div>
								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="date_range">Date Range:</label>
									<div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#datepicker6">
										<input type="text" class="form-control" name="start" placeholder="Start Date">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
										<input type="text" class="form-control" name="end" placeholder="End Date">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
									</div>
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
							</div>
						</form>
					</div>
				</div>
			</div> <!-- end col -->

			<div class="col-12 mb-3">
				<div class="card">
					<div class="card-header">
						<p class="mb-0 fw-bold">Results</p>
					</div>
					<div class="card-body text-center">
						<p class="fs-5 fw-bold mb-1">Product Sales Profit - Client</p>
						<p class="fw-bold mb-1">10/02/2023 13:50</p>
						<p class="mb-1">Baqala Station</p>
						<p class="mb-1">Riyadh</p>
						<p class="mb-1">Riyadh, MS 12312</p>
					</div>
				</div>
			</div> <!-- end col -->


			<div class="col-12 mb-3">
				<div class="row px-5 align-items-center">
					<div class="col-6 text-start">
						<!-- <button class="btn btn-secondary btn-sm mb-3"> <i class="fa fa-list me-1"></i> Summary</button>
						<button class="btn btn-secondary btn-sm mb-3"> <i class="fa fa-search me-1"></i> Details</button> -->
						<div class="btn-group mb-3" role="group">
							<button id="btnGroupVerticalDrop1" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<?php //$this->input->get('client'); 
								?> Client <i class="mdi mdi-chevron-down"></i>
							</button>
							<div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" style="margin: 0px;">
								<a class="dropdown-item" href="<?php echo base_url('admin/report/products_profit') ?>">Product</a>
								<a class="dropdown-item" href="<?php echo base_url('admin/report/products_profit') ?>" selected>Client</a>
								<a class="dropdown-item" href="<?php echo base_url('admin/report/products_profit') ?>">Staff</a>
								<a class="dropdown-item" href="<?php echo base_url('admin/report/products_profit') ?>">Sales Person</a>
							</div>
						</div>
					</div>
					<div class="col-6 text-end">
						<div class="btn-group mb-3" role="group">
							<button id="exportButton" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fa fa-download me-1"></i> <?php //$this->input->get('client'); 
																	?> Export <i class="mdi mdi-chevron-down"></i>
							</button>
							<div class="dropdown-menu" aria-labelledby="exportButton" style="margin: 0px;">
								<a class="dropdown-item" href="<?php echo base_url('admin/report/products_profit') ?>">Export to PDF</a>
							</div>
						</div>
						<button class="btn btn-secondary btn-sm mb-3"> <i class="fa fa-print me-1"></i> Print</button>
						<!-- <button class="btn btn-secondary btn-sm"> <i class="fa fa-download me-1"></i> Export</button> -->
					</div>
				</div>
			</div> <!-- end col -->

			<!-- <div class="col-12 mb-3">
				<div class="card">
					<div class="card-body">
						<div class="row align-items-center">
							<div class="col-lg-7 col-12 mb-5">
								<h6 class="header-title mb-2">Revenue By Client (SAR)</h6>
								<div id="column_chart" class="apex-charts" dir="ltr"></div>
							</div>
							<div class="col-lg-5 col-12 mb-3">
								<h6 class="header-title">Payments Summary (SAR)</h6>
								<div id="donut_chart" class="apex-charts" dir="ltr"></div>
							</div>
						</div>
					</div>
				</div>
			</div>  --> <!-- end col -->

			<div class="col-12 mb-3">
				<div class="card">
					<div class="card-body pt-4" style="overflow-x: scroll;">
						<div class="table-responsive">
							<table class="table table-bordered dataTable" style="width: 100%;">
								<thead>
									<tr role="row">
										<th rowspan="2" tabindex="0" colspan="1" style="width: 64px;">Client name</th>
										<th colspan="2" rowspan="1" style="width: 141px;">Sales</th>
										<th colspan="2" rowspan="1" style="width: 141px;">Refunds</th>
										<th colspan="2" rowspan="1" style="width: 141px;">Net Sales</th>
										<th rowspan="2" tabindex="0"colspan="1" style="width: 60px;">Total Cost</th>
										<th colspan="2" rowspan="1" style="width: 159px;">Profit</th>
										<th colspan="2" rowspan="1" style="width: 128px;">Profit percentage</th>
									</tr>
									<tr class="active" role="row">
										<th tabindex="0" rowspan="1" colspan="1" style="width: 54px;">Quantity</th>
										<th tabindex="0" rowspan="1" colspan="1" style="width: 50px;">Value</th>
										<th tabindex="0" rowspan="1" colspan="1" style="width: 54px;">Quantity</th>
										<th tabindex="0" rowspan="1" colspan="1" style="width: 50px;">Value</th>
										<th tabindex="0" rowspan="1" colspan="1" style="width: 54px;">Quantity</th>
										<th tabindex="0" rowspan="1" colspan="1" style="width: 50px;">Value</th>
										<th tabindex="0" rowspan="1" colspan="1" style="width: 50px;">Value</th>
										<th tabindex="0" rowspan="1" colspan="1" style="width: 72px;">Percentage</th>
										<th tabindex="0" rowspan="1" colspan="1" style="width: 49px;">To Sales</th>
										<th tabindex="0" rowspan="1" colspan="1" style="width: 43px;">To Cost</th>
									</tr>
								</thead>
								<tbody>
									<tr class="odd">
										<td valign="top" colspan="12" class="dataTables_empty">No data available in table</td>
									</tr>
								</tbody>
								<tfoot>
									<tr>
										<th rowspan="1" colspan="1">Total</th>
										<th rowspan="1" colspan="1">0</th>
										<th rowspan="1" colspan="1">0.00&nbsp;SR</th>
										<th rowspan="1" colspan="1">0</th>
										<th rowspan="1" colspan="1">0.00&nbsp;SR</th>
										<th rowspan="1" colspan="1">0</th>
										<th rowspan="1" colspan="1">0.00&nbsp;SR</th>
										<th rowspan="1" colspan="1">0.00&nbsp;SR</th>
										<th rowspan="1" colspan="1">0.00&nbsp;SR</th>
										<th rowspan="1" colspan="1">0%
										</th>
										<th rowspan="1" colspan="1">0%
										</th>
										<th rowspan="1" colspan="1">0%

										</th>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div> <!-- end col -->

		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->


<?php $this->load->view('admin/home/footer'); ?>

<script src="<?php echo base_url('admin_assets/libs/apexcharts/apexcharts.min.js'); ?>"></script>
<script src="<?php echo base_url('admin_assets/js/pages/apexcharts.init.js'); ?>"></script>
