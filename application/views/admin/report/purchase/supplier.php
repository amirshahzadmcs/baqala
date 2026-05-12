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
					<h4>Supplier</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/purchase-reports'); ?>">Purchase Report</a></li>
						<li class="breadcrumb-item active">Supplier</li>
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

			<div class="col-12 mb-1">
				<div class="card">
					<div class="card-body">
						<form action="<?php echo base_url('admin/report/supplier') ?>" method="get">
							<div class="row">
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="city">City:</label>
									<!-- <input type="text"name="city" id="city" class="form-control w-100" placeholder="Supplier City..."> -->
									<select name="city" id="city" class="form-control select2" data-placeholder="Choose City...">
										<option value="">-- Select --</option>
										<?php foreach($city as $city) { ?>
											<option value="<?php echo $city->id;?>" <?php echo ($city->id == $this->input->get('city')) ? 'selected' : ''; ?>><?php echo $city->city_name;?></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="country">Country:</label>
									<select name="country" id="country" class="form-control select2" data-placeholder="Choose City...">
										<option value="">-- Select --</option>
										<option value="Saudi Arabia" <?php echo ($this->input->get('country') == 'Saudi Arabia') ? 'selected' : ''; ?>>Saudi Arabia</option>
									</select>
									<!-- <input type="text"name="country" id="country" class="form-control w-100" placeholder="Supplier Country..."> -->
								</div>
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="branch">Branch:</label>
									<select name="branch" id="branch" class="form-control select2 w-100" data-placeholder="Choose Branch...">
										<option value="">Select</option>
										<option value="1">Main Branch</option>
									</select>
								</div>
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="group_by">Group By:</label>
									<select name="group_by" class="form-control select2 w-100" data-placeholder="Choose Group By...">
										<option value="">Select</option>
										<option value="1">Supplier</option>
										<option value="2">Branch</option>
									</select>
								</div>
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="button"></label>
									<input type="submit" value="Show report" class="form-control btn btn-success mt-2" />
								</div>
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="button"></label>
									<a href="<?php echo base_url('admin/report/supplier') ?>"class="form-control btn btn-danger mt-2">Reset</a>
									<!-- <input type="submit" value="Show report" class="form-control btn btn-success mt-2" /> -->
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
									<i class="fa fa-download me-1"></i> <?php //$this->input->get('client');?> Export <i class="mdi mdi-chevron-down"></i>
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
						<div class="col-12 border-bottom pb-2">
							<p class="fw-bold fs-6 mb-1">Suppliers List - Group By Supplier</p>
							<p class="mb-0">Time: <?php echo date('d/m/Y H:i') ?></p>
						</div>
						<div class="col-12 py-2">
							<p class="fw-bold fs-6 mb-1">Baqala Station</p>
							<p class="mb-0">Riyadh</p>
							<p class="mb-0">Riyadh, MS 12312</p>
						</div>
					</div>
				</div>
			</div> <!-- end col -->
			<div class="col-12 mb-3 mx-auto">
				<div class="card">
					<div class="card-body pb-1">
						<div class="col-12 table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>Code</th>
										<th>Name</th>
										<th>Address</th>
										<th>Phone</th>
										<th>Mobile</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($supplier as $item) { ?>
										<tr>
											<td style="width: 5%;">
												<div class="py-1"><a class="link-style" title="" href="javascript:;"><?php echo $item->id; ?></a></div>
											</td>
											<td style="width: 40%;">
												<div class="py-1"><a class="link-style" title="" href="javascript:;"><?php echo $item->vendor_name; ?></a></div>
											</td>
											<td style="width: 20%;">
												<div class="py-1">
													<?php if((!empty($item->building_no)) || (!empty($item->street_name)) || (!empty($item->district)) || (!empty($item->country)) || (!empty($item->postal_code))) { ?>
														<?php echo $item->building_no; ?> <?php echo $item->street_name; ?> <?php echo $item->district; ?> <?php echo $item->country; ?> <?php echo $item->postal_code; ?>
													<?php } else {
														echo 'N/A';
													 } ?>
												</div>
											</td>
											<td style="width: 15%;">
												<div class="py-1"><?php echo !empty($item->telephone) ? $item->telephone : 'N/A'; ?></div>
											</td>
											<td style="width: 20%;">
												<div class="py-1">
													<?php if((!empty($item->sales_mobile)) || (!empty($item->finance_mobile)) || (!empty($item->legal_mobile)) || (!empty($item->other_mobile))) {?>
														<?php if(!empty($item->sales_mobile)) {?>
															<strong>Sales: </strong> <?php echo $item->sales_mobile; ?>
														<?php } ?>
														<?php if(!empty($item->finance_mobile)) {?>
															<strong>Finance: </strong> <?php echo $item->finance_mobile; ?>
														<?php } ?>
														<?php if(!empty($item->legal_mobile)) {?>
															<strong>Legal: </strong> <?php echo $item->legal_mobile; ?>
														<?php } ?>
														<?php if(!empty($item->other_mobile)) {?>
															<strong>Other: </strong> <?php echo $item->other_mobile; ?>
														<?php } ?>
													<?php } else { ?>
														N/A
													<?php } ?>
												</div>
											</td>
										</tr>
									<?php } ?>
									
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
