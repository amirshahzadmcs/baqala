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
	
	.searchResults {
		list-style: none;
		position: absolute;
		left: 13px;
		width: 94%;
		cursor: pointer;
		overflow-y: auto;
		max-height: 330px;
		box-sizing: border-box;
		z-index: 99;
		padding: 12px;
		background-color: #fff;
		box-shadow: 1px 2px 5px #484848;
	}

	.searchResults .item-list {
		display: flex;
		align-items: center;
		padding: 10px 0px;
		border-bottom: 1px solid #ddd;
	}

	.searchResults .item-name {
		line-height: 21px !important;
	}

	.searchResults button {
		float: left;
		margin-top: 6px;
		margin-right: 15px;
		height: 30px;
		width: 30px;
	}

	#tableOrder tbody tr td {
		font-size: 12px;
		font-weight: 600;
	}

	#status_text i {
		border-radius: 50%;
		padding: 10px;
	}
</style>


<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Item Sales by Item</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/sales-report'); ?>">Sales Report</a></li>
						<li class="breadcrumb-item active">Item Sales by Item</li>
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
						<form action="<?php echo base_url('admin/report/products') ?>" method="get">
							<div class="row">
								<div class="form-group col-lg-3 col-md-4 col-12 mb-3">
									<label for="item">Item:</label>
									<?php if(($this->input->get('term') != '') && ($this->input->get('item') != '')) { ?>
										<input type="hidden" name="item" id="item" value="<?php echo $this->input->get('item') ?>">
										<div class="input-group" style="border: 1px solid #ddd;">
											<input class="form-control" type="text" name="term" id="term" value="<?php echo $this->input->get('term') ?>">
											<span class="input-group-text bg-primary text-dark border-0" id="reset_search"><i class="mdi mdi-undo"></i> Clear</span>
										</div>
										
									<?php } else { ?>
										<input type="hidden" name="item" value="" id="item_name">
										<div class="input-group" style="border: 1px solid #ddd;">
											<input type="search" name="term" id="search_input" class="form-control txt_search_po" placeholder="Search by Product SKU or Name" style="border: none;">
											<span class="input-group-text bg-primary text-dark border-0" id="reset_btn"><i class="mdi mdi-undo"></i> Clear</span>
										</div>
										<div class="search-result-container">
											<div id="result_box" class="searchResults d-none"></div>
										</div>
									<?php } ?>
								</div>

								<div class="form-group col-lg-3 col-md-4 col-12 mb-3">
									<label for="invoice">Invoice:</label>
									<select name="invoice" id="invoice" class="form-control select2 w-100" data-placeholder="Choose Invoice...">
										<option value="">Select</option>
										<option value="1" <?php echo ($this->input->get('invoice') == '1') ? 'selected' : '' ?>>ALL</option>
										<option value="2" <?php echo ($this->input->get('invoice') == '1') ? 'selected' : '' ?>>Invoice</option>
										<option value="3" <?php echo ($this->input->get('invoice') == '1') ? 'selected' : '' ?>>Refund Receipt</option>
									</select>
								</div>
								<div class="form-group col-lg-3 col-md-4 col-12 mb-3">
									<label for="status">Invoice Status:</label>
									<select name="status" class="form-control select2 w-100" data-placeholder="Choose Status...">
										<option value="">Select</option>
										<option value="1" <?php echo ($this->input->get('status') == '1') ? 'selected' : '' ?>>All</option>
									</select>
								</div>
								<div class="form-group col-lg-3 col-md-4 col-12 mb-3">
									<label for="category">Category:</label>
									<select name="category" class="form-control select2 w-100" data-placeholder="Choose Category...">
										<option value="">Select</option>
										<?php foreach ($parent as $category) { ?>
											<option value="<?php echo $category['id']; ?>" <?php echo ($category['id'] == $this->input->get('category')) ? "selected" : "" ?>><?php echo $category['name']; ?></option>
											<?php foreach ($category['child'] as $child) { ?>
												<option value="<?php echo $child['id']; ?>" <?php echo ($child['id'] == $this->input->get('category')) ? "selected" : "" ?>><?php echo $category['name'] . " > " . $child['name']; ?></option>
										<?php }
										} ?>
										<option value="1" <?php echo ($this->input->get('category') == '1') ? 'selected' : '' ?>>All</option>
									</select>
								</div>
								<div class="form-group col-lg-3 col-md-4 col-12 mb-3">
									<label for="store">Store:</label>
									<select name="store" class="form-control select2 w-100" data-placeholder="Choose Store...">
										<option value="">Select</option>
										<option value="1" <?php echo ($this->input->get('store') == '1') ? 'selected' : '' ?>>Primary Warehouse</option>
									</select>
								</div>
								<div class="form-group col-lg-3 col-md-4 col-12 mb-3 d-flex align-items-center">
									<label for="draft"> </label>
									<div class="form-check form-switch" dir="ltr">
										<input type="checkbox" class="form-check-input" id="draft" name="draft" <?php echo ($this->input->get('draft') == 'on') ? 'checked' : ''; ?>>
										<label class="form-check-label" for="draft">Show Draft Items</label>
									</div>
								</div>
								<div class="form-group col-lg-3 col-md-4 col-12 mb-3">
									<label for="brand">Brand:</label>
									<select name="brand" id="brand" class="form-control select2 w-100" data-placeholder="Choose Brand...">
										<option value="">Select</option>
										<?php foreach ($brands as $brand) { ?>
											<option value="<?php echo $brand->id ?>" <?php echo ($brand->id == $this->input->get('brand')) ? 'selected' : '' ?>><?php echo $brand->brand_name . ' (' . $brand->brand_name_ar . ')' ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group col-lg-3 col-md-4 col-12 mb-3">
									<label for="client">Client:</label>
									<select name="client" id="client" class="form-control select2 w-100" data-placeholder="Choose Client...">
										<option value="">Select</option>
										<?php foreach ($clients as $item) { ?>
											<option value="<?php echo $item->id ?>" <?php echo ($item->id == $this->input->get('client')) ? 'selected' : '' ?>><?php echo $item->name; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="staff">Staff:</label>
									<select name="staff" class="form-control select2 w-100" data-placeholder="Choose Staff...">
										<option value="">Select</option>
										<option value="1" <?php echo ($this->input->get('staff') == '1') ? 'selected' : '' ?>>Amanullah Kazi</option>
									</select>
								</div>
								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="date_range">Date Range:</label>
									<div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#datepicker6">
										<input type="text" class="form-control" name="start" placeholder="Start Date" value="<?php echo $this->input->get('start') ?>">
										<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
										<input type="text" class="form-control" name="end" placeholder="End Date" value="<?php echo $this->input->get('end') ?>">
										<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
									</div>
								</div>
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="currency">Currency:</label>
									<select name="currency" id="currency" class="form-control select2" data-placeholder="Choose Currency...">
										<option value="">Select</option>
										<option value="1" <?php echo ($this->input->get('currency') == '1') ? 'selected' : '' ?>>ALL (In SAR)</option>
										<!-- <option value="2" <?php //echo ($this->input->get('currency') == '2') ? 'selected' : '' ?>>ALL (In Saperated)</option> -->
									</select>
								</div>
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="button"></label>
									<input type="submit" value="Show report" class="form-control btn btn-success mt-2" />
								</div>
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="button"></label>
									<a href="<?php echo base_url('admin/report/products') ?>" class="form-control btn btn-danger mt-2">Reset</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div> <!-- end col -->
			<?php if (count($sales) > 0) { ?>
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
									$product = !empty($this->input->get('term')) ? $this->input->get('term') : '' ;
									$code = !empty($this->input->get('item')) ? $this->input->get('item') : '' ;
									$invoice = !empty($this->input->get('invoice')) ? $this->input->get('invoice') : '' ;
									$status = !empty($this->input->get('status')) ? $this->input->get('status') : '' ;
									$category = !empty($this->input->get('category')) ? $this->input->get('category') : '' ;
									$store = !empty($this->input->get('store')) ? $this->input->get('store') : '' ;
									$brand = !empty($this->input->get('brand')) ? $this->input->get('brand') : '' ;
									$staff = !empty($this->input->get('staff')) ? $this->input->get('staff') : '' ;
									$currency = !empty($this->input->get('currency')) ? $this->input->get('currency') : '' ;
									$filterEnd = !empty($this->input->get('end')) ? date('d M, Y', strtotime($this->input->get('end'))) : '' ;
									$filterStart = !empty($this->input->get('start')) ? date('d M, Y', strtotime($this->input->get('start'))) : '' ;
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
										else if($this->input->get('client') != '' && $this->input->get('item') == '' && $this->input->get('term') == '') {
											echo 'Client';
										}
										else if($this->input->get('category') != '' && $this->input->get('item') == '' && $this->input->get('term') == '') {
											echo 'Category';
										}
										else if($this->input->get('brand') != '' && $this->input->get('item') == '' && $this->input->get('term') == '') {
											echo 'Brand';
										}
										else if($this->input->get('client') == '' && $this->input->get('item') != '' && $this->input->get('term') != '') {
											echo 'Item';
										} else {
											echo 'Item';
										}
									?> <i class="mdi mdi-chevron-down"></i>
								</button>
								<div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" style="margin: 0px;">
									<a class="dropdown-item" href="<?php echo base_url('admin/report/products?item='.$code.'&term='.$product.'&invoice='.$invoice.'&status='.$status.'&category='.$category.'&store='.$store.'&brand='.$brand.'&client='.$supplier.'&staff='.$staff.'&start='.$daily.'&end='.$startDate.'&currency='.$currency.''); ?>">Daily</a>
									<a class="dropdown-item" href="<?php echo base_url('admin/report/products?item='.$code.'&term='.$product.'&invoice='.$invoice.'&status='.$status.'&category='.$category.'&store='.$store.'&brand='.$brand.'&client='.$supplier.'&staff='.$staff.'&start='.$weekly.'&end='.$startDate.'&currency='.$currency.''); ?>">Weekly</a>
									<a class="dropdown-item" href="<?php echo base_url('admin/report/products?item='.$code.'&term='.$product.'&invoice='.$invoice.'&status='.$status.'&category='.$category.'&store='.$store.'&brand='.$brand.'&client='.$supplier.'&staff='.$staff.'&start='.$monthly.'&end='.$startDate.'&currency='.$currency.''); ?>">Monthly</a>
									<a class="dropdown-item" href="<?php echo base_url('admin/report/products?item='.$code.'&term='.$product.'&invoice='.$invoice.'&status='.$status.'&category='.$category.'&store='.$store.'&brand='.$brand.'&client='.$supplier.'&staff='.$staff.'&start='.$yearly.'&end='.$startDate.'&currency='.$currency.''); ?>">Yearly</a>
									<a class="dropdown-item" href="<?php echo base_url('admin/report/products?item='.$code.'&term='.$product.'&invoice='.$invoice.'&status='.$status.'&category=&store='.$store.'&brand=&client=&staff='.$staff.'&start='.$filterStart.'&end='.$filterEnd.'&currency='.$currency.''); ?>">Item</a>
									<a class="dropdown-item" href="<?php echo base_url('admin/report/products?item=&term=&invoice='.$invoice.'&status='.$status.'&category='.$category.'&store='.$store.'&brand=&client=&staff='.$staff.'&start='.$filterStart.'&end='.$filterEnd.'&currency='.$currency.''); ?>">Category</a>
									<a class="dropdown-item" href="<?php echo base_url('admin/report/products?item=&term=&invoice='.$invoice.'&status='.$status.'&category=&store='.$store.'&brand='.$brand.'&client=&staff='.$staff.'&start='.$filterStart.'&end='.$filterEnd.'&currency='.$currency.''); ?>">Brand</a>
									<a class="dropdown-item" href="<?php echo base_url('admin/report/products?item=&term=&invoice='.$invoice.'&status='.$status.'&category=&store='.$store.'&brand=&client='.$supplier.'&staff='.$staff.'&start='.$filterStart.'&end='.$filterEnd.'&currency='.$currency.''); ?>">Client</a>
									<a class="dropdown-item" href="<?php echo base_url('admin/report/products?item='.$code.'&term='.$product.'&invoice='.$invoice.'&status='.$status.'&category='.$category.'&store='.$store.'&brand='.$brand.'&client='.$supplier.'&staff='.$staff.'&start='.$filterStart.'&end='.$filterEnd.'&currency='.$currency.''); ?>">Staff</a>
									<a class="dropdown-item" href="<?php echo base_url('admin/report/products?item='.$code.'&term='.$product.'&invoice='.$invoice.'&status='.$status.'&category='.$category.'&store='.$store.'&brand='.$brand.'&client='.$supplier.'&staff='.$staff.'&start='.$filterStart.'&end='.$filterEnd.'&currency='.$currency.''); ?>">Sales Person</a>
								</div>
							</div>
						</div>
						<div class="col-6 text-end">
							<div class="btn-group mb-3" role="group">
								<?php
									$start = $this->input->get('start');
									$item = $this->input->get('item');
									$term = $this->input->get('term');
									$end = $this->input->get('end');
									$client = $this->input->get('client');
									if (($code != '' && $product != '') && ($category == '' && $brand == '')) {
										$page = 'Item%20Sales%20by%20Item';
									} else if(($code == '' && $product == '') && ($category != '' && $brand == '')) {
										$page = 'Item%20Sales%20by%20Category';
									} else if(($code == '' && $product == '') && ($category == '' && $brand != '')) {
										$page = 'Item%20Sales%20by%20Brand';
									} else {
										$page = 'Item%20Sales%20by%20Item';
									}
									
									
								?>
								<button id="exportButton" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="fa fa-download me-1"></i> <?php //$this->input->get('client'); ?> Export <i class="mdi mdi-chevron-down"></i>
								</button>
								<div class="dropdown-menu" aria-labelledby="exportButton" style="margin: 0px;">
									<a class="dropdown-item" href="<?php echo base_url('admin/report/products') ?>">Export to CSV</a>
									<a class="dropdown-item" href="<?php echo base_url('admin/report/products') ?>">Export to Excel</a>
									<a class="dropdown-item" href="<?php echo base_url('admin/report/print_report?item='.$code.'&term='.$product.'&invoice='.$invoice.'&status='.$status.'&category='.$category.'&store='.$store.'&brand='.$brand.'&client='.$supplier.'&staff='.$staff.'&start='.$filterStart.'&end='.$filterEnd.'&currency='.$currency.'&page='.$page.'&branch=&work_order=&by=Amanullah%20Kazi'); ?>" target="_blank">Export to PDF</a>
									<a class="dropdown-item" href="<?php echo base_url('admin/report/print_report?item='.$code.'&term='.$product.'&invoice='.$invoice.'&status='.$status.'&category='.$category.'&store='.$store.'&brand='.$brand.'&client='.$supplier.'&staff='.$staff.'&start='.$filterStart.'&end='.$filterEnd.'&currency='.$currency.'&page='.$page.'&branch=&work_order=&by=Amanullah%20Kazi'); ?>" target="_blank">Export to PDF no graph</a>
								</div>
							</div>
							<a class="btn btn-secondary btn-sm mb-3" href="<?php echo base_url('admin/report/print_report?item='.$code.'&term='.$product.'&invoice='.$invoice.'&status='.$status.'&category='.$category.'&store='.$store.'&brand='.$brand.'&client='.$supplier.'&staff='.$staff.'&start='.$filterStart.'&end='.$filterEnd.'&currency='.$currency.'&page='.$page.'&branch=&work_order=&by=Amanullah%20Kazi') ?>" target="_blank"> <i class="fa fa-print me-1"></i> Print</a>
						</div>
					</div>
				</div> <!-- end col -->

				<div class="col-12 mb-3">
					<div class="card">
						<div class="card-body text-center">
							<p class="fs-5 fw-bold mb-1">Item Sales by Item</p>
							<p class="fw-bold mb-1">From - <?php echo ($this->input->get('start') && $this->input->get('end')) ? date('d/m/Y', strtotime($this->input->get('start'))) . ' to ' . date('d/m/Y', strtotime($this->input->get('end'))) : 'All Dates Available'; ?></p>
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
									<h6 class="header-title mb-2">Item Sales by Item (SAR)</h6>
									<div id="column_chart" class="apex-charts" dir="ltr"></div>
								</div>
							</div>
						</div>
					</div>
				</div> <!-- end col -->

				<div class="col-12 mb-3">
					<div class="card">
						<div class="card-body table-responsive pt-4" style="overflow-x: scroll;">
							<table cellspacing="0" cellpadding="4" width="100%" class="table table-bordered fixed-table-head">
								<thead>

								</thead>
								<tbody>
									<tr class="report-results-head">
										<th style="width: 35px;">ID</th>
										<!-- <th style="width: 175px;">Name</th> -->
										<th style="width: 102px;">Product Code</th>

										<th style="width: 90px;">Date</th>
										<th style="width: 113px;">Staff</th>
										<th style="width: 176px;">Order No</th>
										<th style="width: 147px;">Client</th>


										<th style="width: 76px;">Unit Price </th>
										<th style="width: 67px;">Quantity </th>
										<th style="width: 70px;">Discount </th>
										<th style="width: 53px;">Total </th>
									</tr>
									<?php
									$i = 1;
									$quantity = 0;
									$discount = 0;
									$total = 0;
									foreach ($sales as $item) { ?>

										<tr>
											<td colspan="10">&nbsp;</td>
										</tr>
										<tr>
											<td colspan="10"><?php echo $item->product_name; ?></td>
										</tr>
										<tr>
											<td><?php echo $i; ?></td>
											<!-- <td><?php echo $item->product_name; ?></td> -->
											<td><?php echo $item->product_sku; ?></td>
											<td><?php echo !empty($item->delivery_date) ? date('d/m/Y', strtotime($item->delivery_date)) : 'NA' ?></td>
											<td>Amanullah Kazi</td>

											<td><a href="<?php echo base_url('admin/report/products') ?>"><?php echo $item->invoice_prefix . $item->order_no; ?></a>&nbsp;</td>
											<td><a href="<?php echo base_url('admin/report/products') ?>"><?php echo $item->cus_name; ?></a>&nbsp;</td>
											<td><?php echo number_format($item->real_price, '2'); ?></td>
											<td><?php echo $item->quantity; ?></td>
											<td>0.00</td>
											<td><?php echo number_format($item->order_price, '2'); ?></td>
										</tr>
										<!-- <tr class="indent-td">
											<td>1</td>
											<td>Al Osra Fine Sugar - 10kg</td>
											<td>000001</td>
											<td>27/01/2023</td>
											<td>Amanullah Kazi</td>

											<td><a href="<?php echo base_url('admin/report/products') ?>">Refund Receipt #000001</a>&nbsp;</td>
											<td><a href="<?php echo base_url('admin/report/products') ?>">POS Client #000001</a>&nbsp;</td>
											<td>30.43</td>
											<td>-1</td>
											<td>0.00</td>
											<td>-30.43 </td>
										</tr> -->
										<tr>
											<td colspan="7">Subtotal</td>
											<td class=""><?php echo $item->quantity; ?></td>
											<td class="">0.00</td>
											<td class=""><?php echo number_format($item->order_price, '2'); ?></td>
										</tr>

									<?php
										$quantity += $item->quantity;
										$total += number_format($item->order_price, '2');
										$itemPrice[] = $item->real_price;
										$all[] = $item->order_price;
										$discountss[] = 0;
										$products[] = $item->product_sku;
										$i++;
									}
									?>

									<tr>
										<td colspan="10">&nbsp;</td>
									</tr>
									<tr>
										<td colspan="7">Total</td>
										<td><?php echo $quantity; ?></td>
										<td>0.00</td>
										<td><?php echo number_format($total, '2'); ?></td>
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
		chart: {
			height: 350,
			type: "bar",
			toolbar: {
				show: !1
			}
		},
		plotOptions: {
			bar: {
				horizontal: !1,
				columnWidth: "40%",
				endingShape: "flat"
			}
		},
		dataLabels: {
			enabled: !1
		},
		stroke: {
			show: !0,
			width: 2,
			colors: ["transparent"]
		},
		series: [{
			name: "Item Price",
			data: [<?php echo isset($itemPrice) ? implode(', ', $itemPrice) : ''; ?>]
		}, 
		// {
		// 	name: "Discount",
		// 	data: [<?php //echo implode(', ', $discountss); ?>]
		// }, 
		{
			name: "Total Price",
			data: [<?php echo isset($all) ? implode(', ', $all) : ''; ?>]
		}],
		colors: ["#23c58f", "#f14e4e"],
		// "#525ce5",
		xaxis: {
			categories: [<?php echo isset($products) ? "'" . implode("', '", $products) . "'" : ''; ?>]
		},
		yaxis: {
			title: {
				text: "SAR"
			}
		},
		grid: {
			borderColor: "#f1f1f1",
			padding: {
				bottom: 10
			}
		},
		fill: {
			opacity: 1
		},
		tooltip: {
			y: {
				formatter: function(e) {
					return "SAR " + e + ""
				}
			}
		},
		legend: {
			offsetY: 7
		}
	};
	(chart = new ApexCharts(document.querySelector("#column_chart"), options)).render();
</script>
<script>
	$(document).ready(function() {
		$('.txt_search_po').on('search', function(evt) {
			$(".searchResults").html('');
		});

		$(".txt_search_po").keyup(function() {
			var search = $(this).val();
			if (search.length > 2) {
				$("#result_box").removeClass("d-none");
				$.ajax({
					url: '<?php echo base_url(); ?>admin/quotation/get_search_list',
					type: 'get',
					data: {
						term: search
					},
					dataType: 'json',
					success: function(response) {
						var len = response['result'].length;
						//console.log(response);
						//alert(response);
						$(".searchResults").empty();
						if (len > 0) {
							for (var i = 0; i < len; i++) {

								var id = response['result'][i]['id'];
								var name = response['result'][i]['name'];
								var arabic_name = response['result'][i]['name_arabic'];
								var sku = response['result'][i]['sku'];
								$('.searchResults').append('<div class="item-list"><button type="button" data-name="' + name + '" data-arabic="' + arabic_name + '" data-id="' + id + '" class="item-button btn btn-primary btn-sm">+</button><span class="item-name">' + name + '<br/>SKU - <span>' + sku + '</span></span></div>');

							}
							$('.item-list').on('click', '.item-button', function() {
								var p_name = $(this).data('name');
								var p_id = $(this).data('id');
								// var arabic_name = $(this).data('arabic');
								addItem(p_id, p_name);
								$(this).prop('disabled', true);
							});
						} else {
							$('.searchResults').append('<a class="text-dark"><div class="d-flex align-items-center border-bottom p-3"><span class="font-weight-bold">No search result found. Try another keyword.</span></div></a>');
						}
					},
					error: function(data) {
						alert(JSON.stringify(data));
					}
				});
			} else {
				$(".searchResults").html('');
				$("#result_box").addClass("d-none");
			}
		});
	});

	$("#reset_btn").click(function() {
		$(".searchFormPo").html('');
		$(".searchResults").html('');
		$("#result_box").addClass("d-none");
	});

	$("#reset_search").click(function() {
		$("#item").val('');
		$("#term").val('');
		// $("#result_box").addClass("d-none");
	});
	
	function addItem(p_id, p_name) {
		$("#item_name").val(p_id);
		$("#search_input").val(p_name);
		$("#result_box").addClass("d-none");
	}
</script>
