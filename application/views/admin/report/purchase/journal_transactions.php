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
					<h4>Supplier Statements</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/purchase-reports'); ?>">Purchase Report</a></li>
						<li class="breadcrumb-item active">Supplier Statements</li>
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
						<form action="<?php echo base_url('admin/report/journal_transactions') ?>" method="get">
							<div class="row">
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="account">Account:</label>
									<select name="account" id="account" class="form-control select2 w-100" data-placeholder="Choose Account...">
										<option value="">Select</option>
										<option value="1">Default Account</option>
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
									<label for="added_by">Added By:</label>
									<select name="added_by" id="added_by" class="form-control select2 w-100" data-placeholder="Choose Added By...">
										<option value="">Select</option>
										<option value="1">Amanullah Kazi</option>
									</select>
								</div>
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="journal_branch">Journals Branch:</label>
									<select name="journal_branch" id="journal_branch" class="form-control select2 w-100" data-placeholder="Choose Journals Branch...">
										<option value="">Select</option>
										<option value="1">Main Branch</option>
										<option value="2">All Branches</option>
									</select>
								</div>
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="display_account">Display All Account:</label>
									<select name="display_account" class="form-control select2 w-100" data-placeholder="Choose Account...">
										<option value="">Select</option>
										<option value="1">Display Accounts With transactions in the selected Period</option>
										<option value="2" selected>Display All Accounts</option>
										<option value="2">Display All Accounts With transactions</option>
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

			<div class="col-12 mb-3 mx-auto">
				<div class="card">
					<div class="card-body pb-1">
						<div class="col-12 text-end">
							<div class="btn-group mb-3" role="group">
								<button id="exportButton" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="fa fa-download me-1"></i> <?php //$this->input->get('client');
																		?> Export <i class="mdi mdi-chevron-down"></i>
								</button>
								<div class="dropdown-menu" aria-labelledby="exportButton" style="margin: 0px;">
									<a class="dropdown-item" href="<?php echo base_url('admin/report/supplier') ?>">Export to CSV</a>
									<a class="dropdown-item" href="<?php echo base_url('admin/report/supplier') ?>">Export to Excel</a>
									<a class="dropdown-item" href="<?php echo base_url('admin/report/supplier') ?>">Export to PDF</a>
								</div>
							</div>
							<button class="btn btn-secondary btn-sm mb-3"> <i class="fa fa-print me-1"></i> Print</button>
							<!-- <button class="btn btn-secondary btn-sm"> <i class="fa fa-download me-1"></i> Export</button> -->
						</div>
					</div>
				</div>
			</div> <!-- end col -->
			<div class="col-12 mb-3 mx-auto">
				<div class="card">
					<div class="card-body text-center pb-1">
						<div class="col-12 pb-2">
							<p class="fw-bold fs-6 mb-1">Supplier Statement</p>
							<p class="mb-0">From 2023-01-15 To 2023-02-15</p>
							<p class="fw-bold fs-6 mb-1">Baqala Station</p>
							<p class="mb-0">Main Account: Suppliers</p>
							<p class="mb-0">Currency: All (Separated)</p>
						</div>
					</div>
				</div>
			</div> <!-- end col -->
			<div class="col-12 mb-3 mx-auto">
				<div class="card">
					<div class="card-body pb-1">
						<div class="col-12 table-responsive">
							<table style="empty-cells: show" cellspacing="0" cellpadding="4" width="100%" class="table table-bordered">
								<thead>
									<tr>
										<th rowspan="2" class="first-column no-sort" style="width: 91px;">Number</th>
										<th rowspan="2" class="first-column no-sort" style="width: 112px;">Journal ID</th>
										<th rowspan="2" class="first-column no-sort" style="width: 152px;">Transaction ID</th>
										<th rowspan="2" class="no-sort" style="width: 59px;">Date</th>
										<th rowspan="2" class="no-sort" style="width: 62px;">Staff</th>
										<th class="print-sm" rowspan="2" style="width: 123px;"> Description </th>
										<th colspan="2" style="width: 253px;"> Transaction </th>
										<th colspan="2" style="width: 203px;"> Balance </th>
									</tr>
									<tr>
										<td>Debit (SAR)</td>
										<td>Credit (SAR)</td>
										<td>Debit (SAR)</td>
										<td>Credit (SAR)</td>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td colspan="11"> &nbsp; </td>
									</tr>
									<tr>
										<td colspan="11">Western Manufacturing Plant 221101</td>
									</tr>
									<tr class="">
										<td colspan="8">Balance Before</td>
										<td data-currency-code="SAR">0.00</td>
										<td data-currency-code="SAR">0.00</td>
									</tr>
									<tr class="subtotal">
										<td colspan="6">Subtotal</td>
										<td data-currency-code="SAR">0.00</td>
										<td data-currency-code="SAR">0.00</td>
										<td data-currency-code="SAR">0.00</td>
										<td data-currency-code="SAR">0.00</td>
									</tr>
									<tr>
										<td colspan="11">&nbsp;</td>
									</tr>
									<tr>
										<td colspan="11">Aman Al-Masar Trading Company 221102</td>
									</tr>
									<tr class="">
										<td colspan="8">Balance Before</td>
										<td data-currency-code="SAR">0.00</td>
										<td data-currency-code="SAR">0.00</td>
									</tr>
									<tr class="subtotal">
										<td colspan="6">Subtotal</td>
										<td data-currency-code="SAR">0.00</td>
										<td data-currency-code="SAR">0.00</td>
										<td data-currency-code="SAR">0.00</td>
										<td data-currency-code="SAR">0.00</td>
									</tr>
									<tr>
										<td colspan="11">&nbsp;</td>
									</tr>
								</tbody>
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




