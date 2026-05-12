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

	.table .thead-caption td {
		padding: 0.2rem 0.5rem;
		vertical-align: middle;
		font-weight: 400;
		color: #764444;
	}

	.result-tr td {
		line-height: 15px;
		color: #000000;
	}

	.result-tr .cash-td {
		background-color: #ffffff;
	}

	.table.border-gray {
		border-color: #989898 !important;
	}

	.custom-scroll::-webkit-scrollbar {
		height: 5px;
	}

	.custom-scroll::-webkit-scrollbar-thumb {
		background: #cacaca;
		border-radius: 25px;
	}

	.quick-modal-btn {
		padding: 0;
		margin: 0;
		line-height: 0;
		color: #348734;
		font-weight: 700;
	}

	.quick-modal-btn:focus {
		outline: 0;
		box-shadow: none;
	}

	.summary-detail-modal .table>:not(caption)>*>* {
		padding: 10px 5px;
		vertical-align: middle;
	}
</style>


<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Job Card Report</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/job-card/report'); ?>">Job Report</a></li>
						<li class="breadcrumb-item active">Summary</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-2" title="Back" href="<?php echo base_url('admin/job-card/report') ?>"><i class="fa fa-reply me-2"></i>Back</a>
					<?php if (count($results) > 0) {
						if (check_action_permission(get_user_role(), 'job_cards', 'print_report')): ?>
							<a href="<?php echo base_url('admin/job-card/print-report') . '?vehicle_filter=' . $this->input->get('vehicle_filter') . '&start_filter=' . $this->input->get('start_filter')  . '&end_filter=' . $this->input->get('end_filter') ?>" target="_blank" class="btn btn-sm btn-custom-white float-end">Print Report</a>
					<?php endif;
					} ?>
					<?php if ($this->admin->getInfo()) {
						$info = explode("--", $this->admin->getInfo());
						$info_type = $info[0];
						$msg_data = $info[1];
						if ($info_type == 2) {
					?>
							<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								<strong><?php echo $msg_data; ?></strong>
							</div>
						<?php } else { ?>
							<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								<strong><?php echo $msg_data; ?></strong>
							</div>
						<?php } ?> <?php }
								$this->admin->removeInfo(); ?>
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
						<form action="<?php echo base_url('admin/job-card/report') ?>" method="get">
							<div class="row">
								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="vehicle_filter">Select Vehicle</label>
									<select name="vehicle_filter" id="vehicle_filter" class="form-control select2 w-100" data-placeholder="Choose Vehicle...">
										<option value="">ALL</option>
										<?php foreach ($riders_list as $list) { ?>
											<option value="<?php echo $list->bike_no; ?>" <?php echo ($list->bike_no == $this->input->get('vehicle_filter')) ? 'selected' : ''; ?>><?php echo $list->bike_no . '-' . $list->vehicle_type; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-4 px-1">
									<div class="form-group">
										<label>Job Number</label>
										<div class="input-group">
											<span class="input-group-text">JC-</span>
											<input type="number" id="job_number" name="job_number" value="<?php echo $this->input->get('job_number') ? $this->input->get('job_number') : ''; ?>" autocomplete="off" class="form-control">
										</div>
									</div>
								</div>

								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<div class="form-group">
										<label>Date Between (From and To)</label>
										<div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
											<input type="text" class="form-control" id="_from" name="start_filter" value="<?php echo $this->input->get('start_filter') ? date('d M, Y', strtotime($this->input->get('start_filter'))) : ''; ?>" autocomplete="off" placeholder="Start Date" />
											<input type="text" class="form-control" id="_to" name="end_filter" value="<?php echo $this->input->get('end_filter') ? date('d M, Y', strtotime($this->input->get('end_filter'))) : ''; ?>" autocomplete="off" placeholder="End Date" />
										</div>
									</div>
								</div>
								<div class="form-group col-lg-12 col-md-12 col-12">
									<label for="button"></label>
									<button type="submit" class="btn btn-custom-success mt-1 ms-3 float-end">Apply Filter</button>
									<a href="<?php echo base_url('admin/job-card/report'); ?>" class="btn btn-custom-danger mt-1 float-end">Reset Filter</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div> <!-- end col -->
			<div class="col-12 mb-3 mx-auto">
				<div class="card">
					<?php if (count($results) > 0) { ?>
						<div class="card-body pb-2">
							<div class="col-12 table-responsive custom-scroll">
								<table border="0" cellspacing="0" cellpadding="1" style="font-size: 13px; width: 100%;">
									<tr>
										<td align="left" valign="top" style="width: 50%;border-bottom: 1px solid #000;line-height:1.5;">
											<p></p>
											<strong style="font-size: 14px;">Maha Alfala Trading Est.</strong><br>
											<span>Riyadh, SA</span><br>
											<span></span><br>
											<span>VAT No: <?php echo COMPANY_VAT_NO ?></span><br>
										</td>
										<td align="left" valign="center" style="width: 50%;border-bottom: 1px solid #000;line-height:1.5;">
											<p></p>
											<strong style="font-size: 14px;">Job Summary of Period - <?php echo ($this->input->get('start_filter') !== '') ? $this->input->get('start_filter') : 'NA'; ?> to <?php echo ($this->input->get('end_filter') !== '') ? $this->input->get('end_filter') : 'NA'; ?></strong><br>
											<table>
												<?php if ($this->input->get('vehicle_filter') !== '') { ?>
													<tr>
														<td>Vehicle No </td>
														<td> : <?= $results['job_info']['bike_no']; ?></td>
													</tr>
													<tr>
														<td>Vehicle Make </td>
														<td> : <?= $results['job_info']['vehicle_make']; ?></td>
													</tr>
													<tr>
														<td>Vehicle Type </td>
														<td> : <?= $results['job_info']['vehicle_type']; ?></td>
													</tr>
													<tr>
														<td>Vehicle Color </td>
														<td> : <?= $results['job_info']['vehicle_color']; ?></td>
													</tr>
												<?php } else { ?>
													<tr>
														<td><b>Search for </b></td>
														<td> : All Vehicle</td>
													</tr>
												<?php } ?>
											</table>
										</td>

									</tr>
									<!-- <tr>
									<td align="left" valign="middle" style="font-size: 14px;border-bottom: 1px solid #000;line-height:1.5;">
										Item List
									</td>
								</tr> -->
								</table>

								<table align="left" class="table table-bordered border-dark mt-2">
									<tbody>
										<tr class="thead-caption">
											<td align="center" style="line-height:20px;width:5%;"><b>Sr.No</b></td>
											<td align="center" style="line-height:20px;width:10%;"><b>Job No.</b></td>
											<td align="center" style="line-height:20px;width:11%;"><b>Job Date</b></td>
											<td align="center" style="line-height:20px;width:12%;"><b>Item Code</b></td>
											<td align="center" style="line-height:20px;width:22%;"><b>Spare Part Name</b></td>
											<td align="center" style="line-height:20px;width:8%;"><b>Cost</b></td>
											<td align="center" style="line-height:20px;width:6%;"><b>Qty.</b></td>
											<td align="center" style="line-height:20px;width:10%;"><b>Amt. Excl. VAT</b></td>
											<td align="center" style="line-height:20px;width:7%;"><b>VAT</b></td>
											<td align="center" style="line-height:20px;width:10%;"><b>Amt. Incl. VAT</b></td>
										</tr>
										<?php if (count($results) > 0) { ?>
											<?php
											$total_cost = 0;
											$total_qty = 0;
											$total_line_amount = 0;
											$total_vat_price = 0;
											$total_amt_incl_vat = 0;
											$i = 1;
											foreach ($results['job_cards'] as $jlist) {
												foreach ($jlist['job_items'] as $list) {
													$total_cost += $list['cost'];
													$total_qty += $list['qty'];
													$total_line_amount += $list['line_amount'];
													$total_vat_price += $list['vat_price'];
													$total_amt_incl_vat += $list['amt_incl_vat'];
											?>
													<tr>
														<td align="center"><?= $i++; ?></td>
														<td align="left"><?= 'JC-' . invoiceNmFormat($list['jobcard_id']); ?></td>
														<td align="left"><?= date('d-m-Y', strtotime($jlist['job_date'])); ?></td>
														<td align="left"><?= $list['item_code']; ?></td>
														<td align="left"><?= $list['spare_part_name']; ?></td>
														<td align="right"><?= $list['cost']; ?></td>
														<td align="center"><?= $list['qty']; ?></td>
														<td align="right"><?= $list['line_amount']; ?></td>
														<td align="right"><?= $list['vat_price']; ?></td>
														<td align="right"><?= $list['amt_incl_vat']; ?></td>
													</tr>
											<?php }
											} ?>
											<tr class="thead-caption">
												<td colspan="5" align="right"><b>Total </b></td>
												<td align="right"><b><?= number_format($total_cost, 2); ?></b></td>
												<td align="center"><b><?= $total_qty; ?></b></td>
												<td align="right"><b><?= number_format($total_line_amount, 2); ?></b></td>
												<td align="right"><b><?= number_format($total_vat_price, 2); ?></b></td>
												<td align="right"><b><?= number_format($total_amt_incl_vat, 2); ?></b></td>
											</tr>
										<?php } else { ?>
											<tr class="text-dark h6" style="background-color: #efefefcc!important">
												<td colspan="10" align="center">No data found</td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					<?php } else { ?>
						<div class="card-body pb-2">
							<div class="col-12 text-center py-5">No data found, try other filter!</div>
						</div>
					<?php } ?>
				</div>
			</div> <!-- end col -->


		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->
<?php $this->load->view('admin/home/footer'); ?>
<script>
	$(document).ready(function() {
		$(".max_date_input").datepicker({
			endDate: 'today'
		});
	});
</script>