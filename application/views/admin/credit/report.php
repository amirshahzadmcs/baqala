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
	.table .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
		color:#191818 !important;
	}
	.td-heading{
		display: flex;
	}
	.report-heading{
		text-align: center;
    	margin: 0 auto;
		font-weight: 600;
		word-spacing: 5px;
	}
	.company-logo{
		max-width: 120px;
		position: absolute;
		right: 35px;
	}
	.age-table tbody, .age-table td, .age-table tfoot, .age-table th, .age-table thead, .age-table tr {
		border-width: 1px;
		border-color: #000;
	}
</style>


<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Credit Account Report</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="javascript:;">Reports</a></li>
						<li class="breadcrumb-item active">Credit Report</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<?php
				$date_from = $this->input->get('from');
				$date_to = $this->input->get('to');
				$username = $this->input->get('nameFilter');
			?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-success pull-right me-1" title="Print" href="<?php echo base_url('admin/credit-account/print-report').'?from='.$date_from.'&to='.$date_to.'&nameFilter='.$username;?>" target="_blank"><i class="mdi mdi-printer font-size-12"></i> Print</a>
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url('admin/credit-account/user-report') ?>"><i class="fa fa-reply font-size-12"></i> Back</a>
				</div>
				<?php if($this->admin->getInfo()){
				$info = explode("--", $this->admin->getInfo());
				$info_type = $info[0];
				$msg_data = $info[1];
				if($info_type == 2){
				?>
                <div class="alert alert-danger alert-dismissible fade show"
                    style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong><?php echo $msg_data;?></strong>
                </div>

                <?php } else{?>
                <div class="alert alert-info alert-dismissible fade show"
                    style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong><?php echo $msg_data;?></strong>
                </div>
                <?php } ?> <?php } $this->admin->removeInfo();?>
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
						<form action="<?php echo base_url('admin/credit-account/user-report'); ?>" method="get" id="filter_form" aria-required="required">
							<div class="row">
								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="nameFilter">Customer <span class="text-danger">*</span></label>
									<select name="nameFilter" id="nameFilter" class="form-control select2 w-100" data-placeholder="Choose Customer..." autocomplete="off" required>
										<option value="">Select Customer</option>
										<?php foreach($user_list as $list){ ?>
											<option value="<?php echo $list->id; ?>" <?php if($this->input->get('nameFilter') == $list->id){ echo 'selected'; }?>><?php echo $list->company_name; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="date_range">Date Range</label>
									<div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#datepicker6">
										<input type="text" class="form-control" name="from" placeholder="Start Date" value="<?php echo $this->input->get('from');?>" autocomplete="off">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
										<input type="text" class="form-control" name="to" placeholder="End Date" value="<?php echo $this->input->get('to');?>" autocomplete="off">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
									</div>
								</div>
								<!--
								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="status">Status:</label>
									<select name="status" class="form-control select2 w-100" data-placeholder="Choose Status...">
										<option value="">Select Status</option>
										<option value="1">ALL</option>
										<option value="2">Paid</option>
										<option value="3">Partially Paid</option>
										<option value="3">Unpaid</option>
										<option value="3">Overdue</option>
									</select>
								</div>
								-->
								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="staff">Associate Name </label>
									<select name="staff" class="form-control select2 w-100" data-placeholder="Choose Associate..." autocomplete="off">
										<option value="">Select Associate</option>
									</select>
								</div>
								
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<button type="submit" class="form-control btn btn-success">Show report</button>
								</div>

								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<a href="<?php echo base_url('admin/credit-account/user-report') ?>" class="form-control btn btn-danger">Reset</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div> <!-- end col -->
			<?php if(!empty($user_detail)){ ?>
				<div class="col-12">
					<?php if(!empty($credit_reports)){ ?>
						<div class="card">
							<div class="card-body">
								<table border="0" cellspacing="0" cellpadding="1" style="font-size: 14px; width: 100%;color:#000000;">
									<tr>
										<td align="center" class="td-heading">
											<?php
												if($this->input->get('from') !== '' && $this->input->get('to') !== ''){
													$report_date = date("d-m-Y", strtotime($this->input->get('from'))) .' To '. date("d-m-Y", strtotime($this->input->get('to')));
												}else{
													$report_date = date("d-m-Y", strtotime(date('y-m-d')));
												}
											?>
											<h4 class="report-heading">STATEMENT OF ACCOUNT <br/>OUTSTANDING AS AT <?= $report_date;?></h4>
											<img src="<?php echo base_url('admin_assets/images/logo.png');?>" class="company-logo" />
										</td>
									</tr>
									<tr><td class="pt-4"></td></tr>
									<tr>
										<td>
											<table border="0" cellspacing="0" cellpadding="1" style="font-size: 13px;font-weight: 600;">
												<tr>
													<td valign="top" align="top" style="padding: 10px;width:40%;">
														<table>
															<tr>
																<td><?= $credit_account->account_no;?> - <?php echo strtoupper($user_detail->company_name); ?></td>
															</tr>
															<tr>
																<td><?php echo $user_address->building_no .', '; ?><?php echo $user_address->street_name .', '; ?><?php echo $user_address->district .', '; ?></td>
															</tr>
															<tr>
																<td>Unit No. <?php echo $user_address->unit_no; ?>, <?php echo $user_address->city .' '. $user_address->postal_code .' - '. $user_address->additional_no; ?></td>
															</tr>
															<tr>
																<td><?php echo $user_address->country; ?></td>
															</tr>
															<tr>
																<td>Contact Name : <?php echo $user_detail->name; ?></td>
															</tr>
															<tr>
																<td>Mobile : <?php echo $user_detail->mobile; ?></td>
															</tr>
															<tr>
																<td>E-mail : <?php echo $user_detail->email; ?></td>
															</tr>
														</table>
													</td>
													<td valign="top" align="top" style="width:26.5%"></td>
													<td valign="middle" align="top" style="padding: 10px;width: 1%;">
														<table border="1" cellspacing="0" cellpadding="1">
															<tr><td colspan="2" class="pt-2" style="min-width: 335px;"></td></tr>
															<tr>
																<td class="px-3" style="width:40%">Credit Term</td>
																<td class="px-3">: &nbsp;<?php echo $credit_account->credit_days .' Days'; ?></td>
															</tr>
															<tr>
																<td class="px-3" style="width:40%">Credit Limit</td>
																<td class="px-3">: &nbsp;<?php echo bcdiv($credit_account->max_credit_limit, 1, 2); ?></td>
															</tr>
															<tr>
																<td class="px-3" style="width:40%">Credit Utilized</td>
																<td class="px-3">: &nbsp;<?php echo bcdiv(($credit_account->max_credit_limit - $credit_account->credit_avilable), 1, 2); ?></td>
															</tr>
															<tr>
																<td class="px-3" style="width:40%">Credit Balance</td>
																<td class="px-3">: &nbsp;<?php echo bcdiv($credit_account->credit_avilable, 1, 2); ?></td>
															</tr>
															<tr>
																<td class="px-3" style="width:40%">Sales AM</td>
																<td class="px-3">: &nbsp;N/A</td>
															</tr>
															<tr>
																<td class="px-3" style="width:40%">Sales AM Email</td>
																<td class="px-3">: &nbsp;N/A</td>
															</tr>
															<tr><td colspan="2" class="pt-2" style="min-width: 335px;"></td></tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td align="center" class="py-2"><h6><b>AGING&nbsp; ANALYSIS</b></h6></td>
									</tr>
									<tr>
										<td style="width: 100%;">
											<table class="age-table" width="100%" border="1" cellspacing="0" cellpadding="5" style="font-size: 13px;">
												<tr>
													<td valign="top" bgcolor="#80bffe" style="width: 14.28%; text-align: center;">Balance</td>
													<td valign="top" bgcolor="#80bffe" style="width: 14.28%; text-align: center;">Current</td>
													<td valign="top" bgcolor="#80bffe" style="width: 14.28%; text-align: center;">> 30 Days</td>
													<td valign="top" bgcolor="#80bffe" style="width: 14.28%; text-align: center;">> 90 Days</td>
													<td valign="top" bgcolor="#80bffe" style="width: 14.28%; text-align: center;">> 180 Days</td>
													<td valign="top" bgcolor="#80bffe" style="width: 14.28%; text-align: center;">> 270 Days</td>
													<td valign="top" bgcolor="#80bffe" style="width: 14.28%; text-align: center;">> 365 Days</td>
												</tr>
												<tr align="right">
													<td><b><?= bcdiv($debit_age['balance']->debit_bal, 1, 2);?></b></td>
													<td><b><?= bcdiv($current_debit_balance->current_debit_bal, 1, 2);?></b></td>
													<td><b><?= bcdiv($debit_age['day_30']->total_debit, 1, 2);?></b></td>
													<td><b><?= bcdiv($debit_age['day_90']->total_debit, 1, 2);?></b></td>
													<td><b><?= bcdiv($debit_age['day_180']->total_debit, 1, 2);?></b></td>
													<td><b><?= bcdiv($debit_age['day_270']->total_debit, 1, 2);?></b></td>
													<td><b><?= bcdiv($debit_age['day_365']->total_debit, 1, 2);?></b></td>
												</tr>
											</table>
										</td>
									</tr>
									<tr><td class="pt-4"></td></tr>
									<tr><td align="left">Please find below the Statement of Account as at <?= $report_date;?></td></tr>
									<tr><td class="pb-2"></td></tr>
									<tr>
										<td style="width: 100%;">
											<table class="age-table" width="100%" border="1" cellspacing="0" cellpadding="5" style="font-size: 13px;">
												<tr>
													<td valign="top" bgcolor="#80bffe" style="width: 10%; text-align: center;">Date</td>
													<td valign="top" bgcolor="#80bffe" style="width: 12%; text-align: center;">Invoice Number</td>
													<td valign="top" bgcolor="#80bffe" style="width: 11%; text-align: center;">Reference</td>
													<td valign="top" bgcolor="#80bffe" style="width: 40%; text-align: center;">Description</td>
													<td valign="top" bgcolor="#80bffe" style="width: 9%; text-align: center;">Debit</td>
													<td valign="top" bgcolor="#80bffe" style="width: 9%; text-align: center;">Credit</td>
													<td valign="top" bgcolor="#80bffe" style="width: 9%; text-align: center;">Balance</td>
												</tr>
												<?php 
													$balance = 0;
													if(!empty($debit_reports)){ $i=1;foreach($debit_reports as $report){
													$debit = $report->debit;
													$balance += $debit; 
												?>
												<tr align="right">
													<td align="center"><?php echo formatedDate($report->created_at); ?></td>
													<td align="center"><?php echo 'INV-'.$report->invoice_no; ?></td>
													<td align="center"><?php echo $report->po_no; ?></td>
													<td align="left"><?php echo $report->remarks; ?></td>
													<td style="color: green;"><?php echo bcdiv($debit, 1, 2); ?></td>
													<td><?php echo ($report->credit > 0) ? bcdiv($report->credit, 1, 2) : '0.00'; ?></td>
													<td style="color: green;"><?php echo bcdiv($balance, 1, 2); ?></td>
												</tr>
												<?php } ?>
												<tr align="right">
													<td colspan="4"><b>Total Debit/Credit By Client / Source / Scheme</b></td>
													<td><b><?php echo bcdiv($balance, 1, 2); ?></b></td>
													<td><b><?php echo ($report->credit > 0) ? bcdiv($report->credit, 1, 2) : '0.00'; ?></b></td>
													<td><b><?php echo bcdiv($balance, 1, 2); ?></b></td>
												</tr>
												<tr align="right">
													<td colspan="4"><b>Total Debit/Credit By Client / Source</b></td>
													<td><b><?php echo bcdiv($balance, 1, 2); ?></b></td>
													<td><b><?php echo ($report->credit > 0) ? bcdiv($report->credit, 1, 2) : '0.00'; ?></b></td>
													<td><b><?php echo bcdiv($balance, 1, 2); ?></b></td>
												</tr>
												
												<?php }else{ ?>
													<tr>
														<td colspan="7" align="center">No data found</td>
													</tr>
												<?php } ?>
											</table>
										</td>
									</tr>
								</table>
							</div>
						</div>

						<div class="card">
							<div class="card-body">
								<table border="0" cellspacing="0" cellpadding="1" style="font-size: 14px; width: 100%;color:#000000;">
									<tr>
										<td align="center" class="td-heading">
											<h4 class="report-heading">STATEMENT OF ACCOUNT <br/>OUTSTANDING AS AT <?= $report_date;?></h4>
											<img src="<?php echo base_url('admin_assets/images/logo.png');?>" class="company-logo" />
										</td>
									</tr>
									<tr><td class="pt-4"></td></tr>
									<tr>
										<td>
											<table border="0" cellspacing="0" cellpadding="1" style="font-size: 13px;font-weight: 600;">
												<tr>
													<td valign="top" align="top" style="padding: 10px;width:40%;">
														<table>
															<tr>
																<td><?= $credit_account->account_no;?> - <?php echo strtoupper($user_detail->company_name); ?></td>
															</tr>
															<tr>
																<td><?php echo $user_address->building_no .', '; ?><?php echo $user_address->street_name .', '; ?><?php echo $user_address->district .', '; ?></td>
															</tr>
															<tr>
																<td>Unit No. <?php echo $user_address->unit_no; ?>, <?php echo $user_address->city .' '. $user_address->postal_code .' - '. $user_address->additional_no; ?></td>
															</tr>
															<tr>
																<td><?php echo $user_address->country; ?></td>
															</tr>
															<tr>
																<td>Contact Name : <?php echo $user_detail->name; ?></td>
															</tr>
															<tr>
																<td>Mobile : <?php echo $user_detail->mobile; ?></td>
															</tr>
															<tr>
																<td>E-mail : <?php echo $user_detail->email; ?></td>
															</tr>
														</table>
													</td>
													<td valign="top" align="top" style="width:26.5%"></td>
													<td valign="middle" align="top" style="padding: 10px;width: 1%;">
														<table border="1" cellspacing="0" cellpadding="1">
															<tr><td colspan="2" class="pt-2" style="min-width: 335px;"></td></tr>
															<tr>
																<td class="px-3" style="width:40%">Credit Term</td>
																<td class="px-3">: &nbsp;<?php echo $credit_account->credit_days .' Days'; ?></td>
															</tr>
															<tr>
																<td class="px-3" style="width:40%">Credit Limit</td>
																<td class="px-3">: &nbsp;<?php echo bcdiv($credit_account->max_credit_limit, 1, 2); ?></td>
															</tr>
															<tr>
																<td class="px-3" style="width:40%">Credit Utilized</td>
																<td class="px-3">: &nbsp;<?php echo bcdiv(($credit_account->max_credit_limit - $credit_account->credit_avilable), 1, 2); ?></td>
															</tr>
															<tr>
																<td class="px-3" style="width:40%">Credit Balance</td>
																<td class="px-3">: &nbsp;<?php echo bcdiv($credit_account->credit_avilable, 1, 2); ?></td>
															</tr>
															<tr>
																<td class="px-3" style="width:40%">Sales AM</td>
																<td class="px-3">: &nbsp;N/A</td>
															</tr>
															<tr>
																<td class="px-3" style="width:40%">Sales AM Email</td>
																<td class="px-3">: &nbsp;N/A</td>
															</tr>
															<tr><td colspan="2" class="pt-2" style="min-width: 335px;"></td></tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<!--
									<tr>
										<td align="center"><h6><b>AGING&nbsp; ANALYSIS</b></h6></td>
									</tr>
									<tr>
										<td style="width: 100%;">
											<table class="age-table" width="100%" border="1" cellspacing="0" cellpadding="5" style="font-size: 13px;">
												<tr>
													<td valign="top" bgcolor="#80bffe" style="width: 14.28%; text-align: center;">Balance</td>
													<td valign="top" bgcolor="#80bffe" style="width: 14.28%; text-align: center;">Current</td>
													<td valign="top" bgcolor="#80bffe" style="width: 14.28%; text-align: center;">> 30 Days</td>
													<td valign="top" bgcolor="#80bffe" style="width: 14.28%; text-align: center;">> 90 Days</td>
													<td valign="top" bgcolor="#80bffe" style="width: 14.28%; text-align: center;">> 180 Days</td>
													<td valign="top" bgcolor="#80bffe" style="width: 14.28%; text-align: center;">> 270 Days</td>
													<td valign="top" bgcolor="#80bffe" style="width: 14.28%; text-align: center;">> 365 Days</td>
												</tr>
												<tr align="right">
													<td><b><?= bcdiv($credit_age['balance']->credit_bal, 1, 2);?></b></td>
													<td><b><?= bcdiv($current_credit_balance->current_credit_bal, 1, 2);?></b></td>
													<td><b><?= bcdiv($credit_age['day_30']->total_credit, 1, 2);?></b></td>
													<td><b><?= bcdiv($credit_age['day_90']->total_credit, 1, 2);?></b></td>
													<td><b><?= bcdiv($credit_age['day_180']->total_credit, 1, 2);?></b></td>
													<td><b><?= bcdiv($credit_age['day_270']->total_credit, 1, 2);?></b></td>
													<td><b><?= bcdiv($credit_age['day_365']->total_credit, 1, 2);?></b></td>
												</tr>
											</table>
										</td>
									</tr>
									-->
									<tr><td class="pt-4"></td></tr>
									<tr><td align="left">Please find below the Statement of Account as at <?= $report_date;?></td></tr>
									<tr><td class="pb-2"></td></tr>
									<tr>
										<td style="width: 100%;">
											<table class="age-table" width="100%" border="1" cellspacing="0" cellpadding="5" style="font-size: 13px;">
												<tr>
													<td valign="top" bgcolor="#80bffe" style="width: 10%; text-align: center;">Date</td>
													<td valign="top" bgcolor="#80bffe" style="width: 12%; text-align: center;">Invoice Number</td>
													<td valign="top" bgcolor="#80bffe" style="width: 11%; text-align: center;">Reference</td>
													<td valign="top" bgcolor="#80bffe" style="width: 40%; text-align: center;">Description</td>
													<td valign="top" bgcolor="#80bffe" style="width: 9%; text-align: center;">Debit</td>
													<td valign="top" bgcolor="#80bffe" style="width: 9%; text-align: center;">Credit</td>
													<td valign="top" bgcolor="#80bffe" style="width: 9%; text-align: center;">Balance</td>
												</tr>
												<?php 
													$cbalance = 0;
													if(!empty($credit_reports)){ $i=1;foreach($credit_reports as $report){
													$credit = $report->credit;
													$cbalance += $credit; 
												?>
												<tr align="right">
													<td align="center"><?php echo formatedDate($report->created_at); ?></td>
													<td align="center"><?php echo $report->invoice_no; ?></td>
													<td align="center"><?php echo $report->po_no; ?></td>
													<td align="left"><?php echo $report->remarks; ?></td>
													<td style="color: green;"><?php echo ($report->debit > 0) ? bcdiv($report->debit, 1, 2) : '0.00'; ?></td>
													<td style="color: green;"><?php echo bcdiv($credit, 1, 2); ?></td>
													<td style="color: green;"><?php echo bcdiv((0 - $cbalance), 1, 2); ?></td>
												</tr>
												<?php } ?>
												<tr align="right">
													<td colspan="4"><b>Total Debit/Credit By Client / Source / Scheme</b></td>
													<td><b>0.00</b></td>
													<td><b><?php echo bcdiv($cbalance, 1, 2); ?></b></td>
													<td><b><?php echo bcdiv((0 - $cbalance), 1, 2); ?></b></td>
												</tr>
												<tr align="right">
													<td colspan="4"><b>Total Debit/Credit By Client / Source</b></td>
													<td><b>0.00</b></td>
													<td><b><?php echo bcdiv($cbalance, 1, 2); ?></b></td>
													<td><b><?php echo bcdiv((0 - $cbalance), 1, 2); ?></b></td>
												</tr>
												<tr align="right">
													<td colspan="4"><b>Total Debit/Credit By Client</b></td>
													<td><b><?= $total_debits = bcdiv($debit_age['balance']->debit_bal, 1, 2);?></b></td>
													<td><b><?= $total_credits = bcdiv($credit_age['balance']->credit_bal, 1, 2);?></b></td>
													<td><b><?= bcdiv($total_debits - $total_credits, 1, 2);?></b></td>
												</tr>
												<?php }else{ ?>
													<tr>
														<td colspan="7" align="center">No data found</td>
													</tr>
												<?php } ?>
											</table>
										</td>
									</tr>
								</table>
							</div>
						</div>
					<?php }else{ ?>
						<div class="col-12 mb-3 mx-auto" id="DivIdToPrint">
							<div class="card">
								<div class="card-body bg-soft-warning text-center pb-2">
									<p class="fw-bold">No results found to match these filters</p>
									<p class="fw-bold">Change search filters and try again</p>
								</div>
							</div>
						</div> <!-- end col -->
					<?php } ?>
				</div>
			<?php }else{ ?>
				<div class="col-12 mb-3 mx-auto">
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
