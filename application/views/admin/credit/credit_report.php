<?php $this->load->view('admin/home/header'); ?>
<style>
	.dataTables_wrapper::-webkit-scrollbar {
		display: none;
	}

	.nav-md .container.body .right_col {
		padding: 10px 10px 0;
		margin-left: 230px;
	}
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Credit Account Detail</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item active">Credit Account Detail</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url('admin/credit-account/list'); ?>"><i class="fa fa-reply"></i> Back</a>
					<!--
					<a class="btn btn-primary btn-sm pull-right" title="Print" href="<?php echo base_url() . 'admin/credit_account/print_statement?id=' . $this->input->get('id'); ?>" target="_blank"><i class="fa fa-print"></i></a>
					-->
				</div>
				<?php if ($this->admin->getInfo()) {
					$info = explode("--", $this->admin->getInfo());
					$info_type = $info[0];
					$msg_data = $info[1];
					if ($info_type == 2) {
				?>
						<div class="alert alert-danger alert-dismissible fade show"
							style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong><?php echo $msg_data; ?></strong>
						</div>

					<?php } else { ?>
						<div class="alert alert-info alert-dismissible fade show"
							style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong><?php echo $msg_data; ?></strong>
						</div>
					<?php } ?> <?php }
							$this->admin->removeInfo(); ?>
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
						<div class="row border m-1 py-3 mb-3">
							<div class="col-md-6">
								<p class="mb-1"><b>Account Holder Name:</b> <?php echo $user->name; ?></p>
								<p class="mb-1"><b>Overdue Days:</b> <?php echo $credit_account->credit_days; ?> Days</p>
								<p class="mb-1"><b>Company Name:</b> <?php echo $user->company_name; ?></p>
								<p class="mb-1"><b>Mobile Number:</b> <?php echo $user->mobile; ?></p>
							</div>
							<div class="col-md-6">
								<p class="mb-1"><b>Account No:</b> <span class=""><?php echo $credit_account->account_no; ?></span></p>
								<p class="mb-1"><b>Available Bal:</b> SAR <span class="text-danger"> <?php echo $credit_account->credit_avilable; ?></span></p>
								<p class="mb-1"><b>Max Limit:</b> SAR <span class="text-success"> <?php echo $credit_account->max_credit_limit; ?></span><?php echo check_action_permission(get_user_role(), 'manage_credit_accounts', 'update_credits') ? '<span class="ms-2"><a href="javascript:;" data-bs-toggle="modal" data-bs-target=".creditModal"><i class="mdi mdi-pencil font-size-16 text-danger"></i></a></span>' : ''; ?></p>
							</div>
						</div>

						<table id="debitReports" class="table table-striped table-bordered jambo_table mt-3" style="width:100%">
							<thead>
								<tr>
									<th colspan="11" style="background: #ffdbdbf7;"><span class="text-danger">Debit Report</span></th>
								</tr>
								<tr>
									<th>#</th>
									<th>Order No.</th>
									<th>Debits</th>
									<th>Credit</th>
									<th>Avl. Bal</th>
									<th>Remarks</th>
									<th>Order Date</th>
									<th>Payment On</th>
									<th>Due Date</th>
									<th>Status</th>
									<th>Tools</th>
								</tr>
							</thead>
							<tbody>
								<?php
								function dateDifference($start_date, $end_date)
								{
									// calulating the difference in timestamps 
									$diff = strtotime($start_date) - strtotime($end_date); //strtotime('+30 days',strtotime($start_date))
									// 1 day = 24 hours 
									// 24 * 60 * 60 = 86400 seconds
									return ceil(abs($diff / 86400));
								}
								?>
								<?php if (!empty($debit_reports)) {
									$i = 1;
									foreach ($debit_reports as $report) {

										// start date 
										$start_date = date("d-m-Y", strtotime(date('y-m-d')));
										// end date 
										//$end_date = (($report->payment_date == '') ? date("d-m-Y") : date("d-m-Y", strtotime($report->payment_date)));
										$end_date = date("d-m-Y", strtotime($report->overdue_date));
										// call dateDifference() function to find the number of days between two dates
										$dateDiff = dateDifference($start_date, $end_date);
									?>
										<tr>
											<td><?php echo $i++; ?></td>
											<td><?php echo 'ORN-' . invoiceNmFormat($report->order_id); ?></td>
											<td class="text-danger"><b><?php echo $report->debit; ?></b></td>
											<td class="text-success"><b><?php echo $report->credit; ?></b></td>
											<td class="text-primary"><b><?php echo $report->avl_bal; ?></b></td>
											<td><?php echo $report->remarks; ?></td>
											<td><?php echo formatedDateTime($report->created_at); ?></td>
											<td><?php echo (!empty($report->payment_date)) ? formatedDateTime($report->payment_date) : 'N/A'; ?></td>
											<td><?php if ($report->status == '6') {
													echo formatedDate($report->overdue_date) . '<br>' . ((strtotime($end_date) > strtotime($start_date)) ? $dateDiff . " Days Left" : 'Overdue');
												} elseif (!empty($report->overdue_date)) {
													echo formatedDate($report->overdue_date);
												} else {
													echo 'N/A';
												} ?></td>
											<?php
											if ($report->status == '0') {
												$status = '<span class="badge badge-pill badge-soft-danger font-size-13">Due</span>';
											} elseif ($report->status == '1') {
												$status = '<span class="badge badge-pill badge-soft-success font-size-13">Paid</span>';
											} elseif ($report->status == '2') {
												$status = '<span class="badge badge-pill badge-soft-primary font-size-13">Refund</span>';
											} elseif ($report->status == '3') {
												$status = '<span class="badge badge-pill badge-soft-warning font-size-13">Partially</span>';
											}
											?>
											<td><?php echo $status; ?></td>
											<td><?php echo (($report->status == '0' || $report->status == '3') ? '<button type="button" class="btn btn-danger btn-sm ml-auto" onclick="update_report(' . $report->id . ')">Settle</button>' : '<button type="button" class="btn btn-success btn-sm ml-auto" title="Already updated">Updated</button>'); ?>
											</td>
										</tr>
									<?php }
								} else { ?>
									<tr>
										<td colspan="11" align="center">No data found</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						<table id="creditReports" class="table table-striped table-bordered jambo_table mt-5" style="width:100%">
							<thead>
								<tr>
									<th colspan="11" style="background: #ccebb5!important;"><span class="text-primary">Credit Report</span></th>
								</tr>
								<tr>
									<th>#</th>
									<th>Order No.</th>
									<th>Debits</th>
									<th>Credit</th>
									<th>Avl. Bal</th>
									<th>Remarks</th>
									<th>Order Date</th>
									<th>Payment On</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>

								<?php if (!empty($credit_reports)) {
									$j = 1;
									foreach ($credit_reports as $report) { ?>

										<tr>
											<td><?php echo $j++; ?></td>
											<td><?php echo 'ORN-' . invoiceNmFormat($report->order_id); ?></td>
											<td class="text-danger"><b><?php echo $report->debit; ?></b></td>
											<td class="text-success"><b><?php echo $report->credit; ?></b></td>
											<td class="text-primary"><b><?php echo $report->avl_bal; ?></b></td>
											<td><?php echo $report->remarks; ?></td>
											<td><?php echo formatedDateTime($report->created_at); ?></td>
											<td><?php echo ($report->payment_date !== '') ? formatedDateTime($report->payment_date) : 'N/A'; ?></td>
											<?php
											if ($report->status == '0') {
												$status = '<span class="badge badge-pill badge-soft-danger font-size-13">Due</span>';
											} elseif ($report->status == '1') {
												$status = '<span class="badge badge-pill badge-soft-success font-size-13">Paid</span>';
											} elseif ($report->status == '2') {
												$status = '<span class="badge badge-pill badge-soft-primary font-size-13">Refund</span>';
											} elseif ($report->status == '3') {
												$status = '<span class="badge badge-pill badge-soft-warning font-size-13">Partially</span>';
											}
											?>
											<td><?php echo $status; ?></td>
										</tr>
									<?php }
								} else { ?>
									<tr>
										<td colspan="10" align="center">No data found</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>

<div class="modal fade reportModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0">Settle Balance</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="errmsg1"></div>
				<div class="card"
					style="box-shadow: 1px 0px 6px #a5a5a5;border-radius: 5px;margin-bottom: 14px;">
					<div class="card-body">
						<h6 class="card-title">Invoice No: <b><span id="id1"></span></b></h6>
						<h6 class="card-title">Total Amount: <b><span id="id2"></span></b></h6>
						<h6 class="card-title">Remaining Amount: <b><span id="id4"></span></b></h6>
						<h6 class="card-title">Current Status: <b><span id="id3"></span></b></h6>
					</div>
				</div>

				<?php echo form_open("admin/Credit_account/update_credits_report", array("id" => "submit_form")); ?>
				<input type="hidden" id="id" name="id" value="" required>
				<input type="hidden" id="uid" name="user_id" value="" required>
				<input type="hidden" id="report_date" name="report_date" value="" required>
				<div class="form-group">
					<label for="status">Status <span class="text-danger">*</span></label>
					<select name="status" class="form-control" required="required">
						<option value="">Select Status</option>
						<option value="1">Fully Paid</option>
						<option value="3">Partially Paid</option>
					</select>
				</div>
				<div class="form-group pt-2">
					<label for="amount">Amount (To be paid)<span class="text-danger">*</span></label>
					<input type="text" class="form-control" minimum="1" id="amount" name="credit" maxlength="10"
						placeholder="Enter amount here." required />
				</div>
				<div class="form-group pt-2">
					<label for="remarks">Remarks<span class="text-danger">*</span></label>
					<textarea class="form-control" rows="3" id="remarks" name="remarks" maxlength="250" placeholder="Write remarks here..." required></textarea>
				</div>
				<div class="form-group pt-2">
					<label for="payment_date">Payment Date <span class="text-danger">*</span></label>
					<input type="date" id="payment_date" name="payment_date" class="form-control" required />
				</div>
				<p class="pt-2"><i class="fa fa-warning text-warning"></i> By submitting this form you'll settle the balance of this order.</p>
				<div class="col-md-12" style="margin-top: 23px;">
					<button type="submit" class="btn btn-success btn-md btn-block float-end">Save</button>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade creditModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0">Update Credit Limits</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="errmsg1"></div>
				<?php echo form_open("admin/Credit_account/update_limit", array("id" => "submit_form")); ?>
				<input type="hidden" id="id" name="id" value="<?php echo $credit_account->id ?>" required>
				<input type="hidden" id="uname" name="name" value="<?php echo $user->name ?>" required>
				<input type="hidden" name="old_credit_limit" value="<?php echo $credit_account->max_credit_limit ?>" required>
				<div class="form-group col-md-12">
					<label for="max_credit_limit">Max Credit Limit <span class="text-danger">*</span></label>
					<input type="text" id="max_credit_limit" min="1" name="max_credit_limit" class="form-control" placeholder="Max Credit Limit" value="<?php echo $credit_account->max_credit_limit ?>" required />
				</div>
				<div class="col-md-12" style="margin-top: 23px;">
					<button type="submit" class="btn btn-success btn-md btn-block float-end">Update Limit</button>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this->load->view('admin/home/footer'); ?>

<script>
	$(document).ready(function() {
		$('#creditReports').dataTable({
			"lengthMenu": [
				[25, 50, 100, 500],
				[25, 50, 100, 500]
			],
			order: [
				[0, 'asc']
			],
			dom: 'Blfrtip',
			buttons: [{
					extend: "csv",
					className: "btn-md"
				},
				{
					extend: "excel",
					className: "btn-md"
				},
				{
					extend: "pdfHtml5",
					className: "btn-md"
				},
				{
					extend: "print",
					className: "btn-md"
				},
			],
			"responsive": true,
			"processing": true,
			"columnDefs": [{
				"targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
				"orderable": false
			}, ]
		});

		$('#debitReports').dataTable({
			"lengthMenu": [
				[25, 50, 100, 500],
				[25, 50, 100, 500]
			],
			order: [
				[0, 'asc']
			],
			dom: 'Blfrtip',
			buttons: [{
					extend: "csv",
					className: "btn-md"
				},
				{
					extend: "excel",
					className: "btn-md"
				},
				{
					extend: "pdfHtml5",
					className: "btn-md"
				},
				{
					extend: "print",
					className: "btn-md"
				},
			],
			"responsive": true,
			"processing": true,
			"columnDefs": [{
				"targets": [0, 1, 2, 3, 4, 5, 6, 7],
				"orderable": false
			}, ]
		});
	});

	var update_report = function(u) {
		$.ajax({
			url: '<?php echo base_url(); ?>admin/Credit_account/reportSearch',
			type: "GET",
			data: {
				'id': u
			},
			success: function(data) {
				//alert(data);
				var result = JSON.parse(data);
				//alert(result['id']);
				var rem_amt = (result['debit'] - result['running_bal']);
				$("#id").val(result['id']);
				$("#uid").val(result['user_id']);
				$("#amount").val(rem_amt);
				$("#report_date").val(result['created_at']);
				$("#id1").html(result['invoice_no']);
				$("#id2").html(result['debit']);
				$("#id4").html(rem_amt);
				if (result['status'] == '0') {
					$status = '<span class="badge badge-pill badge-soft-danger font-size-13">Due</span>';
				} else if (result['status'] == '1') {
					$status = '<span class="badge badge-pill badge-soft-success font-size-13">Paid</span>';
				} else if (result['status'] == '2') {
					$status = '<span class="badge badge-pill badge-soft-warning font-size-13">Refund</span>';
				} else if (result['status'] == '3') {
					$status = '<span class="badge badge-pill badge-soft-secondary font-size-13">Partially</span>';
				}
				$("#id3").html($status);

				$(".reportModal").modal("show");
			},
			error: function(data) {
				//alert(json.Stringfy(data));
				console.log(data);
			}
		});
	}
</script>