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

	.result-tr .rider-name {
		border-bottom: 1px dashed #348734;
	}

	.summary-detail-popup table tr,
	.summary-detail-popup table tr td {
		color: #000;
	}

	.summary-detail-popup table {
		padding: 5px 0px;
		vertical-align: middle;
	}

	.summary-detail-popup .table>:not(caption)>*>* {
		padding: 8px 5px;
		vertical-align: middle;
	}

	/* .inner-table-1{
		width: 21%;
    	float: left;
	}
	.inner-table-2{
		width: 79%;
		min-height: 461px;
	} */
	tr.sub-heading {
		background: #d6ffa6;
	}

	tr.sub-heading-inner {
		background: #efefef;
	}

	@media (min-width: 1200px) {
		.modal-xl {
			max-width: 1250px;
		}
	}

	#wait {
		display: none;
		width: 100%;
		height: 100%;
		position: absolute;
		padding: 2px;
		z-index: 9;
		background: #ffffff96;
		text-align: center;
		padding-top: 17%;
		font-size: 30px;
	}

	td.pinkbg {
		background-color: #ffc9d3;
		color: #a70000 !important;
	}
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Daily Delivery Summary</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/daily-delivery-summary/list'); ?>">Daily Delivery</a></li>
						<li class="breadcrumb-item active">Summary</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if (check_action_permission(get_user_role(), 'delivery_summary', 'add')): ?>
						<button type="button" class="btn btn-custom-success btn-sm pull-right me-2" title="Add" data-bs-toggle="modal" data-bs-target=".summary-modal"><i class="fa fa-plus"></i> Add New Entry</button>
					<?php endif; ?>
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url('admin/daily-delivery-summary/list') ?>"><i class="fa fa-reply me-2"></i>Back</a>

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
						<form action="<?php echo base_url('admin/daily-delivery-summary/list') ?>" method="get">
							<div class="row">
								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="dboy">Riders/Drivers:</label>
									<select name="rider_filter" id="dboy" class="form-control select2 w-100">
										<option value="">[ANY]</option>
										<?php foreach (inhouseDeliveryBoy() as $list) { ?>
											<option value="<?php echo $list->id; ?>" <?php echo ($list->id == $this->input->get('rider_filter')) ? 'selected' : ''; ?>><?php echo $list->name; ?></option>
										<?php } ?>
									</select>
								</div>

								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="date_range">Date Range: <span class="text-danger">*</span></label>
									<div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#datepicker6">
										<input type="text" class="form-control" name="start_filter" placeholder="Start Date" value="<?php echo $this->input->get('start_filter'); ?>" autocomplete="off" required>
										<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
										<input type="text" class="form-control" name="end_filter" placeholder="End Date" value="<?php echo $this->input->get('end_filter'); ?>" autocomplete="off" required>
										<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
									</div>
								</div>

								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="button"></label>
									<input type="submit" value="Show Summary" class="form-control btn btn-custom-success mt-2" />
								</div>
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="button"></label>
									<a href="<?php echo base_url('admin/daily-delivery-summary/list'); ?>" class="form-control btn btn-custom-danger mt-2">Reset</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div> <!-- end col -->
			<div class="col-12 mb-3 mx-auto">
				<div class="card">
					<div class="card-body pb-2">
						<?php if (check_action_permission(get_user_role(), 'delivery_summary', 'print_summary')): ?>
							<div class="col-md-12 mb-5">
								<a href="<?php echo base_url('admin/daily-delivery-summary/print-summary') . '?rider_filter=' . $this->input->get('rider_filter') . '&start_filter=' . $this->input->get('start_filter')  . '&end_filter=' . $this->input->get('end_filter') ?>" target="_blank" class="btn btn-custom-white float-end">Print Summary</a>
							</div>
						<?php endif; ?>
						<div class="col-12 table-responsive custom-scroll">
							<table align="left" class="table table-bordered border-gray">
								<?php
								$count_company = count(fdCompanyHelper());
								?>
								<thead>
									<tr class="text-white h6" style="background-color: #026902cc!important">
										<td colspan="<?php echo (8 + ($count_company * 8)); ?>" align="center">Date From: <?php echo $this->input->get('start_filter'); ?> - Date To: <?php echo $this->input->get('end_filter'); ?></td>
									</tr>
								</thead>
								<tbody>
									<tr class="thead-caption">
										<td rowspan="2" align="center" style="line-height:20px;"><b>Sr.No</b></td>
										<td rowspan="2" align="center" style="line-height:20px;"><b>Emp No.</b></td>
										<td rowspan="2" align="center" style="line-height:20px;"><b>Name</b></td>
										<td rowspan="2" align="center" style="line-height:20px;"><b>T. Del.</b></td>
										<td rowspan="2" align="center" style="line-height:20px;"><b>Earning</b></td>
										<td rowspan="2" align="center" style="line-height:20px;"><b>Cash Collected</b></td>
										<td rowspan="2" align="center" style="line-height:20px;"><b>Traffic Fine</b></td>
										<td rowspan="2" align="center" style="line-height:20px;"><b>ID Fine</b></td>
										<td rowspan="2" align="center" style="line-height:20px;"><b>Topup</b></td>
										<td rowspan="2" align="center" style="line-height:20px;"><b>Online Hours</b></td>
										<?php
										$c_counter = 1;
										foreach (fdCompanyHelper() as $company) {
											$bgclass = "";
											if ($c_counter % 2 == 0) {
												$bgclass = "pinkbg";
											}
										?>
											<td colspan="6" align="center" class="<?php echo $bgclass; ?>" style="line-height:20px;"><b><?= $company->company_name; ?></b></td>
										<?php $c_counter++;
										} ?>
									</tr>
									<tr class="thead-caption">
										<?php for ($i = 0; $i < $count_company; $i++) { ?>
											<td align="center" style="line-height:20px;">Delivery</td>
											<td align="center" style="line-height:20px;">Cash</td>
											<td align="center" style="line-height:20px;">Wallet</td>
											<td align="center" style="line-height:20px;">STC_P</td>
											<td align="center" style="line-height:20px;">STC_M</td>
											<td align="center" style="line-height:20px;">POS</td>
										<?php } ?>
									</tr>
									<?php
									if (count($results) > 0) {
										$total_main_del = 0;
										$total_main_amt = 0;
										$total_cash_amt = 0;
										$total_traffic_amt = 0;
										$total_idfine_amt = 0;
										$total_hunger_topup_amt = 0;
										$totaltime = 0;
										$total_summary = 0;
										for ($ci = 0; $ci < ($count_company); $ci++) {
											$child['total_orders'][$ci] = 0;
											$child['total_cash'][$ci] = 0;
											$child['total_wallet'][$ci] = 0;
											$child['total_stc'][$ci] = 0;
											$child['total_stcpaym'][$ci] = 0;
											$child['total_pos'][$ci] = 0;
										}
									?>
										<?php $result_count = 1;
										foreach ($results as $summary) { ?>
											<?php
											$total_main_del += $summary['total_orders'];
											$total_main_amt += $summary['total_earnings'];
											$total_cash_amt += $summary['total_cash'];
											$total_traffic_amt += $summary['total_traffic_fine'];
											$total_idfine_amt += $summary['total_id_fine'];
											$total_hunger_topup_amt += $summary['total_hunger_topup'];
											$totaltime += $summary['total_working_hrs'];
											$total_summary = count($summary['order_info']);
											?>
											<tr class="result-tr">
												<td align="center"><?= $result_count++; ?></td>
												<td align="left">
													<div style="width: 60px;"><?= $summary['emp_id']; ?></div>
												</td>
												<td align="left">
													<div style="width: 180px;"><a type="button" class="rider-name" onclick="quickViewSingle('<?= $summary['rider_id']; ?>')"><?= $summary['rider_name']; ?></a></div>
												</td>
												<td align="right">
													<div style="width: 40px;"><?= $summary['total_orders']; ?></div>
												</td>
												<td align="right"><?= number_format($summary['total_earnings'], 2); ?></td>
												<td align="right">
													<div style="width: 120px;"><?= number_format($summary['total_cash'], 2); ?></div>
												</td>
												<td align="right">
													<div style="width: 77px;"><?= number_format($summary['total_traffic_fine'], 2); ?></div>
												</td>
												<td align="right">
													<div style="width: 75px;"><?= number_format($summary['total_id_fine'], 2); ?></div>
												</td>
												<td align="right">
													<div style="width: 75px;"><?= number_format($summary['total_hunger_topup'], 2); ?></div>
												</td>
												<td align="right">
													<div style="width: 75px;"><?php echo ($summary['total_working_hrs'] > 0) ? convertSecToHrs($summary['total_working_hrs']) : 'NA'; ?></div>
												</td>
												<?php $o_count = 0;
												foreach ($summary['order_info'] as $o_info) { ?>
													<?php
													$child['total_orders'][$o_count] += $o_info['total_orders'];
													$child['total_cash'][$o_count] += $o_info['total_cash'];
													$child['total_wallet'][$o_count] += $o_info['total_wallet'];
													$child['total_stc'][$o_count] += $o_info['total_stc'];
													$child['total_stcpaym'][$o_count] += $o_info['total_stcpaym'];
													$child['total_pos'][$o_count] += $o_info['total_pos'];
													?>
													<td align="right"><button type="link" class="btn btn-link quick-modal-btn" onclick="quickView('<?= $o_info['id']; ?>')"><?= ($o_info['total_orders'] > 0) ? $o_info['total_orders'] : '0'; ?></button></td>
													<td align="right" class="cash-td"><?= ($o_info['total_cash'] !== '') ? $o_info['total_cash'] : ''; ?></td>
													<td align="right" class="cash-td"><?= ($o_info['total_wallet'] !== '') ? $o_info['total_wallet'] : ''; ?></td>
													<td align="right" class="cash-td"><?= ($o_info['total_stc'] !== '') ? $o_info['total_stc'] : ''; ?></td>
													<td align="right" class="cash-td"><?= ($o_info['total_stcpaym'] !== '') ? $o_info['total_stcpaym'] : ''; ?></td>
													<td align="right" class="cash-td"><?= ($o_info['total_pos'] !== '') ? $o_info['total_pos'] : ''; ?></td>
												<?php $o_count++;
												} ?>
											</tr>
										<?php } ?>
										<tr>
											<td colspan="3" align="right"><b>Total</b></td>
											<td align="right"><b><?= $total_main_del; ?></b></td>
											<td align="right"><b><?= $total_main_amt; ?></b></td>
											<td align="right"><b><?= $total_cash_amt; ?></b></td>
											<td align="right"><b><?= $total_traffic_amt; ?></b></td>
											<td align="right"><b><?= $total_idfine_amt; ?></b></td>
											<td align="right"><b><?= $total_hunger_topup_amt; ?></b></td>
											<td align="right"><b><?php echo ($totaltime > 0) ? convertSecToHrs($totaltime) : 'NA'; ?></b></td>
											<?php for ($i = 0; $i < $total_summary; $i++) {
												echo '<td align="right"><b>' . $child['total_orders'][$i] . '</b></td>';
												echo '<td align="right"><b>' . number_format($child['total_cash'][$i], 2) . '</b></td>';
												echo '<td align="right"><b>' . number_format($child['total_wallet'][$i], 2) . '</b></td>';
												echo '<td align="right"><b>' . number_format($child['total_stc'][$i], 2) . '</b></td>';
												echo '<td align="right"><b>' . number_format($child['total_stcpaym'][$i], 2) . '</b></td>';
												echo '<td align="right"><b>' . number_format($child['total_pos'][$i], 2) . '</b></td>';
											} ?>
										</tr>
									<?php } else { ?>
										<tr class="text-dark h6" style="background-color: #efefefcc!important">
											<td colspan="<?php echo (8 + ($count_company * 8)); ?>" align="center">No data found</td>
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
<!-- Modal -->
<div class="modal fade summary-modal" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0">Add Daily Delivery Summary</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url('admin/daily-delivery-summary/submit') ?>" method="POST">
					<div class="row">
						<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
							<label for="delivery_date">Delivery Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control" name="delivery_date" placeholder="Delivery Date" min="<?php //echo date('Y-m-d', strtotime(' - 1 day')); 
																															?>" max="<?php echo date('Y-m-d'); ?>" autocomplete="off" required>
						</div>

						<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
							<label for="company_id">Select Company <span class="text-danger">*</span></label>
							<select name="company_id" id="company_id" class="form-control select2 w-100" data-placeholder="Choose Delivery Company..." required>
								<option value="">ALL</option>
								<?php foreach (fdCompanyHelper() as $clist) { ?>
									<option value="<?php echo $clist->id; ?>"><?php echo $clist->company_name; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
							<label for="rider_id">Select Riders/Drivers <span class="text-danger">*</span></label>
							<select name="rider_id" id="rider_id" class="form-control select2 w-100" data-placeholder="Choose Delivery Boy..." required>
								<option value="">ALL</option>
								<?php foreach (inhouseDeliveryBoy() as $list) { ?>
									<option value="<?php echo $list->id; ?>"><?php echo $list->name; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
							<label for="orders">Total Delivery <span class="text-danger">*</span></label>
							<input type="number" min="1" max="100" class="form-control" name="orders" placeholder="Total Today's Delivery" autocomplete="off" required>
						</div>
						<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
							<label for="total_earning">Total Earning <span class="text-danger">*</span></label>
							<input id="total_earning" name="total_earning" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" required>
						</div>
						<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
							<label for="traffic_fine">Traffic Fine <span class="text-danger">*</span></label>
							<input id="traffic_fine" name="traffic_fine" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" required>
						</div>
						<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
							<label for="id_fine">ID Fine <span class="text-danger">*</span></label>
							<input id="id_fine" name="id_fine" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" required>
						</div>
						<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
							<label for="cash_received">Cash <span class="text-danger">*</span></label>
							<input id="cash_received" name="cash_received" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" required>
						</div>
						<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
							<label for="wallet_received">Wallet <span class="text-danger">*</span></label>
							<input id="wallet_received" name="wallet_received" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" required>
						</div>
						<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
							<label for="stcpay">STCPay P <span class="text-danger">*</span></label>
							<input id="stcpay" name="stcpay" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" required>
						</div>
						<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
							<label for="stcpaym">STCPay M <span class="text-danger">*</span></label>
							<input id="stcpaym" name="stcpaym" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" required>
						</div>
						<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
							<label for="pos_received">POS <span class="text-danger">*</span></label>
							<input id="pos_received" name="pos_received" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" required>
						</div>
						<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
							<label for="fuel_topup">Fuel <span class="text-danger">*</span></label>
							<input id="fuel_topup" name="fuel_topup" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" required>
						</div>
						<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
							<label for="hunger_topup">Hunger Topup <span class="text-danger">*</span></label>
							<input id="hunger_topup" name="hunger_topup" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" required>
						</div>
						<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
							<label for="online_hrs">Online Hours <span class="text-danger">* (Hrs and Min)</span></label>
							<div class="input-group">
								<input type="number" name="online_hrs" min="0" max="23" aria-label="Hours" placeholder="Hours" value="00" class="form-control" required>
								<input type="number" name="online_min" min="0" max="59" aria-label="Minutes" placeholder="Minutes" value="00" class="form-control" required>
							</div>
						</div>
						<div class="form-group col-lg-12 col-md-12 col-12 mb-3">
							<input type="submit" id="submit" value="Save Summary" class="btn btn-custom-success float-end" />
						</div>
					</div>
				</form>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade summary-detail-modal" role="dialog" aria-labelledby="ModalFullscreenLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title mt-0" id="summaryModalFullscreenLabel">Update Summary Detail</h6>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" id="summary_body_modal">

			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php $this->load->view('admin/home/footer'); ?>

<script>
	$(document).ready(function() {
		$(document).ajaxStart(function() {
			$("#wait").css("display", "block");
		});
		$(document).ajaxComplete(function() {
			$("#wait").css("display", "none");
		});
		$(document).ajaxError(function() {
			$("#wait").css("display", "none");
		});
	});

	function quickView(fdco_id) {
		if (fdco_id > 0) {
			$('#summaryModalFullscreenLabel').html('Update Summary Detail');
			var f_date = '<?php echo $this->input->get('start_filter'); ?>';
			var s_date = '<?php echo $this->input->get('end_filter'); ?>';
			$.ajax({
				type: "post",
				url: "<?php echo base_url('admin/daily-delivery-summary/quick-view'); ?>",
				data: {
					'fdco_id': fdco_id,
					'entry_date': f_date,
					'exit_date': s_date
				},
				//dataType: "json",
				success: function(response) {
					//console.log(response);
					$('.summary-detail-modal').modal('show');
					$('#summary_body_modal').html(response);
				},
				error: function(request, error) {
					//console.log(" Can't do because: " + JSON.stringify(request));
					$('#summary_body_modal').after(JSON.stringify(request));
				},
			});
		} else {
			alert('Invalid request id!');
		}
	}

	function quickViewSingle(rider_id) {
		if (rider_id > 0) {
			$('#summaryModalFullscreenLabel').html('Delivery Summary Detail');
			var f_date = '<?php echo $this->input->get('start_filter'); ?>';
			var s_date = '<?php echo $this->input->get('end_filter'); ?>';
			$.ajax({
				type: "post",
				url: "<?php echo base_url('admin/daily-delivery-summary/quick-view-userwise'); ?>",
				data: {
					'rider_id': rider_id,
					'start_date': f_date,
					'end_date': s_date
				},
				//dataType: "json",
				success: function(response) {
					console.log(response);
					$('.summary-detail-modal').modal('show');
					$('#summary_body_modal').html(response);
				},
				error: function(request, error) {
					console.log(" Can't do because: " + JSON.stringify(request));
					$('#summary_body_modal').after(JSON.stringify(request));
				},
			});
		} else {
			alert('Invalid request id!');
		}
	}
</script>