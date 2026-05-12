<?php $this->load->view('admin/home/header'); ?>
<style>
	.dataTables_wrapper::-webkit-scrollbar {
		display: none;
	}

	.nav-md .container.body .right_col {
		padding: 10px 10px 0;
		margin-left: 230px;
	}

	th {
		white-space: nowrap;
	}

	.payrollTable {
		width: 100%;
		border-collapse: collapse;
		font-size: 14px;
		text-align: left;
	}

	.payrollTable th,
	table td {
		border: 1px solid #ddd;
		padding: 8px;
	}

	.payrollTable th {
		background-color: #f2f2f2;
		text-align: center;
	}

	.payrollTable .totals-row td {
		font-weight: bold;
		background-color: #f9f9f9;
	}

	.table-container {
		overflow-x: scroll;
		padding: 0px;
		border: 1px solid #ddd;
		margin-top: 20px;
		max-height: 600px;
	}

	/* Make the first column sticky */
	.table-container table th:first-child,
	.table-container table td:first-child {
		/* position: sticky;
		left: 0px;
		z-index: 1; */
		text-align: left;
		min-width: 325px;
		/* box-shadow: 1px -3px 2px 3px #ddd; */
	}

	.table-container table th.mainHeaderRow th:first-child,
	.table-container table th.subHeaderRow th:first-child {
		background-color: #f8f9fa;
		text-align: left;
		min-width: 325px;
	}

	.dark-purple {
		background-color: #f3eeff !important;
	}

	.dark-red {
		background-color: #fdece9 !important;
	}

	.purple-light {
		background-color: #fbf9ff !important;
	}

	.sky-light {
		background-color: #f2fdff !important;
	}

	.red-light {
		background-color: #fef7f6 !important;
	}

	/* .mainHeaderRow th:first-child{
		width: 300px;
	} */
	.payrollTable thead {
		position: sticky;
		z-index: 2;
		top: -1px;
	}

	.mainHeaderRow {
		box-shadow: 1px -3px 2px 3px #ddd;
	}

	.subHeaderRow {
		box-shadow: 0px 0px 0px 1px #ddd;
	}

	.subHeaderRow th {
		text-align: center;
	}

	tfoot .totals-row td {
		white-space: nowrap;
	}

	.table-container tfoot {
		position: sticky;
		z-index: 2;
		bottom: 2px;
		box-shadow: 0px 0px 0px 2px #ddd;
	}

	.payslipDropdown {
		margin-top: -15px;
	}

	.step-connector {
		flex: 1;
		height: 2px;
		background-color: #e9ecef;
		margin: 0 10px;
		width: 70px;
	}

	.step-connector.completed {
		background-color: #198754;
	}

	.step {
		display: flex;
		align-items: center;
		color: #6c757d;
	}

	.step.completed {
		color: #198754;
	}

	.step.active {
		color: #198754;
		font-weight: 500;
	}

	.step-icon {
		width: 24px;
		height: 24px;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		margin-right: 4px;
	}
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Employees Payroll Detail</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/hr/payslip/list'); ?>">Employee Payroll</a></li>
						<li class="breadcrumb-item active">Detail</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url('admin/hr/payslip/list'); ?>"><i class="fa fa-reply"></i> Back</a>
					<!-- <button type="button" class="btn btn-custom-white btn-sm pull-right me-2" title="Export"><i class="fas fa-file-excel me-2"></i>Export</button> -->
				</div>
				<?php if ($this->admin->getInfo()) {
					$info = explode("--", $this->admin->getInfo());
					$info_type = $info[0];
					$msg_data = $info[1];
					if ($info_type == 1) {
				?>
						<div class="alert alert-success alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong><?php echo $msg_data; ?></strong>
						</div>

					<?php } else { ?>
						<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong><?php echo $msg_data; ?></strong>
						</div>
				<?php }
				}
				$this->admin->removeInfo();  ?>
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
						<?php
						$statusMapping = [
							1 => ['label' => 'Review'],
							2 => ['label' => 'Confirmed'],
							3 => ['label' => 'Paid'],
						];
						$currentStatus = $payrollData['status'];
						$nextStatus = $currentStatus < count($statusMapping) ? $statusMapping[$currentStatus + 1]['label'] : null;
						?>
						<div class="row">
							<div class="col-md-6">
								<h4><b><?= ((isset($payrollData['payroll_month'])) ? date('F Y', strtotime($payrollData['payroll_month'])) : ''); ?> Payroll</b></h4>
								<p class="mb-0">
									<?= ((isset($payrollData['payroll_month'])) ? date('F Y', strtotime($payrollData['payroll_month'])) : ''); ?>,
									<?= ((isset($payrollData['from_date'])) ? date('M d', strtotime($payrollData['from_date'])) : ''); ?>
									to
									<?= ((isset($payrollData['to_date'])) ? date('M d', strtotime($payrollData['to_date'])) : ''); ?>
								</p>
							</div>
							<div class="col-md-6">
								<?php if ($nextStatus && check_action_permission(get_user_role(), 'employees_payslip', 'update_status')): ?>
									<button type="button" class="btn btn-outline-primary btn-sm edit float-end" data-toggle="tooltip" title="Update Status" onclick="confirmStatusUpdate(<?php echo $payrollData['id']; ?>)">
										Proceed to <?php echo $nextStatus; ?> <i class="mdi mdi-arrow-right font-size-18"></i>
									</button>
								<?php endif; ?>
							</div>
							<div class="col-md-12">
								<hr>
							</div>
							<div class="col-md-12">
								<div class="d-flex align-items-center justify-content-between position-relative float-start" style="max-width: 480px;">
									<?php foreach ($statusMapping as $key => $status): ?>
										<?php
										// Determine class based on status
										$stepClass = $key <= $currentStatus ? 'completed' : ($key === $currentStatus ? 'active' : '');
										?>
										<div class="step <?= $stepClass ?>">
											<div class="step-icon">
												<i class="mdi <?= $key <= $currentStatus ? 'mdi-check-circle-outline' : 'mdi-checkbox-blank-circle-outline' ?> font-size-22"></i>
											</div>
											<span><?= $status['label'] ?></span>
										</div>

										<?php if ($key < count($statusMapping)): ?>
											<div class="step-connector <?= $key < $currentStatus ? 'completed' : '' ?>"></div>
										<?php endif; ?>
									<?php endforeach; ?>
								</div>
								<div class="float-end ms-4">
									<span class="badge rounded-pill badge-soft-success px-2 py-2 font-size-14">
										<?= $statusMapping[$currentStatus]['label'] ?> <i class="mdi mdi-cursor-default-click-outline"></i>
									</span>
								</div>
							</div>
							<div class="col-md-12">
								<hr>
								<h4 class="header-title">Payroll Summary</h4>
							</div>
							<div class="col-md-3">
								<div class="card border border-secondary">
									<div class="card-body">
										<div class="text-left">
											<p class="font-size-16">Total Salary Earned</p>
											<h5 class="font-size-22 mb-0"><?= $summaryData['total_salaries']; ?> SAR</h5>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="card border border-secondary">
									<div class="card-body">
										<div class="text-left">
											<p class="font-size-16">Total Additions</p>
											<h5 class="font-size-22 mb-0 text-success"><?= $summaryData['total_additions']; ?> SAR</h5>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="card border border-secondary">
									<div class="card-body">
										<div class="text-left">
											<p class="font-size-16">Total Deductions</p>
											<h5 class="font-size-22 mb-0 text-danger"><?= $summaryData['total_deductions']; ?> SAR</h5>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="card border border-secondary">
									<div class="card-body">
										<div class="text-left">
											<p class="font-size-16">Total Net Salaries</p>
											<h5 class="font-size-22 mb-0"><?= $summaryData['net_salaries']; ?> SAR</h5>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="mb-3">
							<label>Search by Employee Name</label>
							<input type="search" id="searchBar" class="form-control" placeholder="Search by Employee Name">
						</div>
						<div class="col-md-12">
							<h4 class="header-title">Additions & Deductions</h4>
						</div>

						<div class="table-container">
							<?php
							// Initialize totals
							$totals = [
								'basic_salary' => 0,
								'food' => 0,
								'housing' => 0,
								'transportation' => 0,
								'other' => 0,
								'salary_earned' => 0,
								'adjustment_commission' => 0,
								'hunger_adjustment' => 0,
								'online_hours_incentive' => 0,
								'reimbursements' => 0,
								'target_based_commission' => 0,
								'tips' => 0,
								'wallet_cash' => 0,
								'total_earnings' => 0,
								'gosi_employee' => 0,
								'total_contribution' => 0,
								'acceptance_contact_penalty' => 0,
								'accident_claim' => 0,
								'aggregator_penalty' => 0,
								'compliance_penalty' => 0,
								'jahez_debit' => 0,
								'bike_spare_parts' => 0,
								'carry_forward_salary' => 0,
								'basic_paid' => 0,
								'cash_advance' => 0,
								'contact_penalties' => 0,
								'days_deduction' => 0,
								'declined_penalties' => 0,
								'hunger_cash_shortage' => 0,
								'id_suspension_penalty' => 0,
								'jahez_cash_shortage' => 0,
								'license_deduction' => 0,
								'medical_expenses' => 0,
								'mobile_deduction' => 0,
								'noon_cash_shortage' => 0,
								'personal_sim_card' => 0,
								'target_deduction' => 0,
								'traffic_violation' => 0,
								'unpaid_leave' => 0,
								'wallet_adjustment' => 0,
								'company_penalty' => 0,
								'total_deduction' => 0,
								'net_pay' => 0,
							];

							// Accumulate totals
							foreach ($payrollDetails as $pdetail) {
								foreach ($totals as $key => $value) {
									$totals[$key] += $pdetail[$key];
								}
							}
							?>

							<table class="payrollTable" id="payrollTable">
								<thead>
									<tr class="mainHeaderRow">
										<th>Employee Information</th>
										<th colspan="14" class="dark-purple">Earnings</th>
										<th colspan="2" class="dark-purple">Contributions</th>
										<th colspan="24" class="dark-red">Deductions</th>
										<th colspan="3">Payment Information</th>
									</tr>
									<tr class="subHeaderRow">
										<!-- Headers -->
										<th class="text-center bg-white">Name</th>
										<th class="purple-light">Basic Salary</th>
										<th class="purple-light">Food Allowance</th>
										<th class="purple-light">Housing Allowance</th>
										<th class="purple-light">Transportation Allowance</th>
										<th class="purple-light">Other Allowance</th>
										<th class="purple-light">Salary Earned</th>
										<th class="purple-light">Adjustments</th>
										<th class="purple-light">Hunger Adjustment</th>
										<th class="purple-light">Online Hours Incentive</th>
										<th class="purple-light">Reimbursements</th>
										<th class="purple-light">Target Based Commission</th>
										<th class="purple-light">Tips</th>
										<th class="purple-light">Wallet Cash</th>
										<th class="purple-light">Total Earnings</th>
										<th class="sky-light">GOSI Employee</th>
										<th class="sky-light">Total Contribution</th>
										<th class="red-light">Acceptance Penalties</th>
										<th class="red-light">Accident Claim</th>
										<th class="red-light">Aggregator Penalty</th>
										<th class="red-light">Compliance Penalty</th>
										<th class="red-light">Jahez Debit</th>
										<th class="red-light">Bike Spare Parts</th>
										<th class="red-light">Carry Forward Salary</th>
										<th class="red-light">Basic Paid</th>
										<th class="red-light">Cash Advance</th>
										<th class="red-light">Contact Penalties</th>
										<th class="red-light">Days Deduction</th>
										<th class="red-light">Declined Penalties</th>
										<th class="red-light">Hunger Cash Shortage</th>
										<th class="red-light">ID Suspension Penalty</th>
										<th class="red-light">Jahez Cash Shortage</th>
										<th class="red-light">License Deduction</th>
										<th class="red-light">Medical Expenses</th>
										<th class="red-light">Mobile Deduction</th>
										<th class="red-light">Noon Cash Shortage</th>
										<th class="red-light">Personal Sim Card</th>
										<th class="red-light">Target Based Deduction</th>
										<th class="red-light">Traffic Violation</th>
										<th class="red-light">Unpaid Leave</th>
										<th class="red-light">Wallet Balance</th>
										<th class="red-light">Company Penalty</th>
										<th class="red-light">Total Deductions</th>
										<th class="text-center">Net Salary</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($payrollDetails as $pdetail) { ?>
										<tr>
											<td class="bg-white" data-name="<?= strtolower($pdetail['employee_name']); ?>" data-id="<?= $pdetail['emp_id']; ?>">
												<?= $pdetail['employee_name']; ?><br><small>#<?= $pdetail['emp_id']; ?></small>
												<?php if (check_action_permission(get_user_role(), 'employees_payslip', 'print_payslip')): ?>
													<div class="btn-group ms-2 float-end payslipDropdown">
														<button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															<i class="mdi mdi-dots-vertical font-size-18"></i>
														</button>
														<div class="dropdown-menu dropdown-menu-end">
															<!-- <div class="dropdown-divider"></div> -->
															<a href="<?php echo base_url('admin/hr/payslip/print?id=' . $pdetail['id']); ?>" class="dropdown-item btn" target="_blank">
																<i class="fas fa-file-pdf me-2"></i> Print Payslip
															</a>
														</div>
													</div>
												<?php endif; ?>
											</td>
											<td class="purple-light text-center"><?= $pdetail['basic_salary']; ?></td>
											<td class="purple-light text-center"><?= $pdetail['food']; ?></td>
											<td class="purple-light text-center"><?= $pdetail['housing']; ?></td>
											<td class="purple-light text-center"><?= $pdetail['transportation']; ?></td>
											<td class="purple-light text-center"><?= $pdetail['other']; ?></td>
											<td class="purple-light text-center"><?= $pdetail['salary_earned']; ?></td>
											<td class="purple-light text-center"><?= $pdetail['adjustment_commission']; ?></td>
											<td class="purple-light text-center"><?= $pdetail['hunger_adjustment']; ?></td>
											<td class="purple-light text-center"><?= $pdetail['online_hours_incentive']; ?></td>
											<td class="purple-light text-center"><?= $pdetail['reimbursements']; ?></td>
											<td class="purple-light text-center"><?= $pdetail['target_based_commission']; ?></td>
											<td class="purple-light text-center"><?= $pdetail['tips']; ?></td>
											<td class="purple-light text-center"><?= $pdetail['wallet_cash']; ?></td>
											<td class="purple-light text-center"><?= $pdetail['total_earnings']; ?></td>
											<td class="sky-light text-center"><?= $pdetail['gosi_employee']; ?></td>
											<td class="sky-light text-center"><?= $pdetail['total_contribution']; ?></td>
											<td class="red-light text-center"><?= $pdetail['acceptance_contact_penalty']; ?></td>
											<td class="red-light text-center"><?= $pdetail['accident_claim']; ?></td>
											<td class="red-light text-center"><?= $pdetail['aggregator_penalty']; ?></td>
											<td class="red-light text-center"><?= $pdetail['aggregator_penalty']; ?></td>
											<td class="red-light text-center"><?= $pdetail['jahez_debit']; ?></td>
											<td class="red-light text-center"><?= $pdetail['bike_spare_parts']; ?></td>
											<td class="red-light text-center"><?= $pdetail['carry_forward_salary']; ?></td>
											<td class="red-light text-center"><?= $pdetail['basic_paid']; ?></td>
											<td class="red-light text-center"><?= $pdetail['cash_advance']; ?></td>
											<td class="red-light text-center"><?= $pdetail['contact_penalties']; ?></td>
											<td class="red-light text-center"><?= $pdetail['days_deduction']; ?></td>
											<td class="red-light text-center"><?= $pdetail['declined_penalties']; ?></td>
											<td class="red-light text-center"><?= $pdetail['hunger_cash_shortage']; ?></td>
											<td class="red-light text-center"><?= $pdetail['id_suspension_penalty']; ?></td>
											<td class="red-light text-center"><?= $pdetail['jahez_cash_shortage']; ?></td>
											<td class="red-light text-center"><?= $pdetail['license_deduction']; ?></td>
											<td class="red-light text-center"><?= $pdetail['medical_expenses']; ?></td>
											<td class="red-light text-center"><?= $pdetail['mobile_deduction']; ?></td>
											<td class="red-light text-center"><?= $pdetail['noon_cash_shortage']; ?></td>
											<td class="red-light text-center"><?= $pdetail['personal_sim_card']; ?></td>
											<td class="red-light text-center"><?= $pdetail['target_deduction']; ?></td>
											<td class="red-light text-center"><?= $pdetail['traffic_violation']; ?></td>
											<td class="red-light text-center"><?= $pdetail['unpaid_leave']; ?></td>
											<td class="red-light text-center"><?= $pdetail['wallet_adjustment']; ?></td>
											<td class="red-light text-center"><?= $pdetail['company_penalty']; ?></td>
											<td class="red-light text-center"><?= $pdetail['total_deduction']; ?></td>
											<td class="text-center"><?= $pdetail['net_pay']; ?></td>
										</tr>
									<?php } ?>
								</tbody>
								<tfoot>
									<tr class="totals-row">
										<td>Total (<?= count($payrollDetails); ?> Employees)</td>
										<?php foreach ($totals as $total) { ?>
											<td class="text-center"><?= $total; ?></td>
										<?php } ?>
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
<script>
	function confirmStatusUpdate(id) {
		var nextStatus = '<?php echo $nextStatus; ?>';
		if (nextStatus) {
			Swal.fire({
				title: 'Are you sure?',
				text: "This will update status of payroll, You won't be able to revert this!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, update it!'
			}).then((result) => {
				if (result.isConfirmed) {
					updatePayrollStatus(id);
				}
			});
		} else {
			toastr.error('Already updated.');
		}
	}

	function updatePayrollStatus(id) {
		var statusToUpdate = '<?php echo $currentStatus + 1; ?>';
		$.ajax({
			url: "<?php echo base_url('admin/hr/payslip/update-status'); ?>",
			method: 'POST',
			data: {
				id: id,
				status: statusToUpdate
			},
			success: function(response) {
				Swal.fire(
					'Updated!',
					'Payroll status has been updated.',
					'success'
				);
				setTimeout(function() {
					location.reload();
				}, 1000);
			},
			error: function(errorResponse) {
				Swal.fire(
					'Error!',
					'There was an issue updating the payroll status.',
					'error'
				);
				console.log(errorResponse);
			}
		});
	}
</script>
<script>
    document.getElementById('searchBar').addEventListener('input', function () {
        const query = this.value.toLowerCase();
        const rows = document.querySelectorAll('#payrollTable tbody tr');
        
        rows.forEach(row => {
            const name = row.querySelector('td[data-name]').getAttribute('data-name');
            const id = row.querySelector('td[data-id]').getAttribute('data-id');
            
            if (name.includes(query) || id.includes(query)) {
                row.style.display = ''; // Show row
            } else {
                row.style.display = 'none'; // Hide row
            }
        });
    });
</script>