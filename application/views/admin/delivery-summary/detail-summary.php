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
	.table .thead-caption {
		font-weight: 300;
		color: #000000;
		background: #fdce43ad;
	}
	.table .thead-caption td{
		padding: 0.2rem 0.5rem;
		vertical-align: middle;
		font-weight: 400;
		color: #764444;
	}
	.result-tr td{
		line-height: 15px;
		color: #000000;
	}
	.result-tr .cash-td{
		background-color: #cfffd5;
	}
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Add Daily Delivery Summary</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/daily-delivery-summary/list'); ?>">Daily Delivery Summary</a></li>
						<li class="breadcrumb-item active">Add</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url('admin/daily-delivery-summary/list') ?>"><i class="fa fa-reply me-2"></i>Back</a>
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
						<form action="<?php echo base_url('admin/daily-delivery-summary/summary') ?>" method="get">
							<div class="row">
								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="dboy">Select Riders/Drivers<span class="text-danger">*</span></label>
									<select name="dboy" id="dboy" class="form-control select2 w-100" data-placeholder="Choose Delivery Boy..." required>
										<option value="">ALL</option>
										<?php foreach(inhouseDeliveryBoy() as $list) { ?>
											<option value="<?php echo $list->id;?>"><?php echo $list->name; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="company_id">Select Company<span class="text-danger">*</span></label>
									<select name="company_id" id="company_id" class="form-control select2 w-100" data-placeholder="Choose Delivery Company..." required>
										<option value="">ALL</option>
										<?php foreach(fdCompanyHelper() as $clist) { ?>
											<option value="<?php echo $clist->id;?>"><?php echo $clist->company_name; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="delivery_date">Delivery Date<span class="text-danger">*</span></label>
									<input type="date" class="form-control" name="delivery_date" placeholder="Delivery Date" autocomplete="off" required>
								</div>
								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="orders">Total Delivery<span class="text-danger">*</span></label>
									<input type="number" class="form-control" name="orders" placeholder="Total Today's Delivery" autocomplete="off" required>
								</div>
                                <div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="cash_received">Cash Received<span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="cash_received" placeholder="Total Today's Cah" autocomplete="off" required>
								</div>
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="button"></label>
									<input type="submit" value="Save" class="form-control btn btn-custom-success mt-2" />
								</div>
							</div>
						</form>
					</div>
				</div>
			</div> <!-- end col -->
			<div class="col-12 mb-3 mx-auto">
				<div class="card">
					<div class="card-body pb-2">
						<div class="col-12 table-responsive">
							<table align="left" class="table table-bordered border-dark mb-0">
								<tr class="text-white h6" style="background-color: #026902cc!important"><td align="center">Today's Summary</td></tr>
							</table>
							<table align="left" class="table table-bordered border-dark">
								<?php
									$count_company = count(fdCompanyHelper());
								?>
								<tbody>
									<tr class="thead-caption">
										<td rowspan="2" align="center" style="line-height:20px;"><b>Sr. No</b></td>
										<td rowspan="2" align="left" style="line-height:20px;"><b>EMP ID</b></td>
										<td rowspan="2" align="left" style="line-height:20px;"><b>Name</b></td>
										<td rowspan="2" align="right" style="line-height:20px;"><b>Del.</b></td>
										<td rowspan="2" align="right" style="line-height:20px;"><b>Cash</b></td>
										<?php foreach(fdCompanyHelper() as $company){ ?>
										<td colspan="2" align="center" style="line-height:20px;"><b><?= $company->company_name;?></b></td>
										<?php } ?>
									</tr>
									<tr class="thead-caption">
									<?php for ($i=0; $i < $count_company; $i++) { 
										echo '<td align="right" style="line-height:20px;"><b>Delivery</b></td><td align="right" style="line-height:20px;"><b>Cash</b></td>';
									}
									?>
									</tr>
									<tr class="result-tr">
										<td align="center">1</td>
										<td align="left">BSEP23012</td>
										<td align="left">Shariek Khalid</td>
										<td align="right">9</td>
										<td align="right">113</td>
										<?php for ($i=0; $i < $count_company; $i++) {?>
										<td align="right"></td>
										<td align="right" class="cash-td"></td>
										<?php } ?>
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