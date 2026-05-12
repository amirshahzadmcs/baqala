<?php $this->load->view('admin/home/header'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
	/* Hide the delete icon by default */
	.delete-icon {
		display: none;
	}

	/* Show the delete icon when hovering over the row */
	.table-hover tbody tr:hover .delete-icon {
		display: inline;
	}
	.delete-icon button:hover{
		text-decoration: none;
	}
	.delete-icon button{
		padding: 0px;
    	line-height: 0px;
	}
	.header-title {
		color: #364152;
		font-size: 17px;
	}
	.card-title-desc {
		color: #364152;
	}
	.bg-info-light{
		background-color: #f4f6fe;
		color: #000;
	}
	.card-bodyquote p{
		margin-left: 22px;
    	margin-bottom: 0px;
	}
	#toast-container > div{
		width: 320px;
	}
	.swal2-icon .swal2-icon-content {
		display: flex;
		align-items: center;
		font-size: 1.75em;
	}
	.swal2-icon {
		width: 3em;
		height: 3em;
	}
	/*---- Sidebar ----*/
	.modal .modal-dialog-aside{
		width: 40%;
		max-width:80%; height: 100%; margin:0;
		transform: translate(0); transition: transform .2s;
	}


	.modal .modal-dialog-aside .modal-content{  height: inherit; border:0; border-radius: 0;}
	.modal .modal-dialog-aside .modal-content .modal-body{ overflow-y: auto }
	.modal.fixed-left .modal-dialog-aside{ margin-left:auto;  transform: translateX(100%); }
	.modal.fixed-right .modal-dialog-aside{ margin-right:auto; transform: translateX(-100%); }

	.modal.show .modal-dialog-aside{ transform: translateX(0);  }

	/*----- End ------*/
	.leave-employee-group .list-group .list-group-item{
		border-bottom: 1px solid #edf1f5 !important;
	}
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Leave Types</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/hr-module/leave-types'); ?>">Leave Types</a></li>
						<li class="breadcrumb-item active">Annual Leave</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					
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
						<!-- Nav tabs -->
						<ul class="nav nav-tabs nav-tabs-custom nav-justified">
							<li class="nav-item">
								<a class="nav-link active disable-right-click" href="<?php echo base_url('admin/hr-module/leave-types/annual-leave');?>">
									<span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
									<span class="d-none d-sm-block">Annual Leave</span> 
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link disable-right-click" href="<?php echo base_url('admin/hr-module/leave-types/labour-law');?>">
									<span class="d-block d-sm-none"><i class="far fa-user"></i></span>
									<span class="d-none d-sm-block">Labor Law Leaves</span> 
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link disable-right-click" href="<?php echo base_url('admin/hr-module/leave-types/custom-leaves');?>">
									<span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
									<span class="d-none d-sm-block">Custom Leaves</span>   
								</a>
							</li>
						</ul>
						<div class="row">
							<div class="col-md-12">
								<p class="card-title-desc mt-3">You will be able to select the annual entitlement for each employee only from the listed entitlement days</p>
							</div>
							<div class="col-12">
								<div class="card border">
									<div class="card-header">
										<h4 class="header-title mb-0">Annual leave entitlement</h4>
									</div>
									<div class="card-body p-0">
										<div class="table-responsive">
											<table class="table table-hover mb-0" id="leave-table">
												<thead>
													<tr style="background: #fbfbfb;">
														<th width="80%">Days per year</th>
														<th width="20%" style="text-align: right;">Action</th>
													</tr>
												</thead>
												<tbody id="leave-table-body">
												<?php
													// Decode the JSON data
													$entitlements = json_decode($settings['annual_leave_entitlement'], true);

													// Check if decoding was successful and the data is an array
													if (is_array($entitlements)) {
														foreach ($entitlements as $edays) {
															// Ensure $edays is correctly used here
															// For simple values in the array, $edays should be a string or number directly
															?>
															<tr>
																<td>Days <?php echo htmlspecialchars($edays); ?></td>
																<td align="right">
																	<span class="delete-icon">
																		<button class="btn btn-link text-danger delete-btn2"
																				data-setting-id="<?php echo htmlspecialchars($settings['id']); ?>"
																				data-day="<?php echo htmlspecialchars($edays); ?>">
																			<i class="dripicons-trash"></i>
																		</button>
																	</span>
																</td>
															</tr>
															<?php
														}
													} else {
														echo '<tr><td colspan="2">No entitlements found</td></tr>';
													}
												?>
												</tbody>
											</table>
										</div>
									</div>
									<div class="card-footer bg-light border-top">
										<button type="button" class="btn btn-link p-0" id="add-type-btn"><i class="fa fa-plus"></i> Add Type</button>
									</div>
								</div>
							</div>

							<div class="col-12">
								<?php
									$current_leave_calculation = $settings['annual_leave_calculation'];
								?>
								<div class="card border">
									<div class="card-body">
										<h4 class="header-title">Annual Leave Calculation</h4>
										<p class="card-title-desc">Business or calendar days will change employees balance deduction method, any changes will also reflect on their current balances</p>

										<div class="card text-dark bg-info-light">
											<div class="card-body">
												<blockquote class="card-bodyquote mb-0">
													<div class="d-flex">
														<div class="form-check mb-1">
															<input class="form-check-input" type="radio" name="leaveCalculation" id="calendar" value="Calendar" <?php echo $current_leave_calculation == 'Calendar' ? ' checked ' : ''; ?>>
															<label class="form-check-label" for="calendar">Calendar</label>
														</div>
													</div>
													<p>Count every day as leave regardless of weekend or not. (except for public holidays)</p>
												</blockquote>
											</div>
										</div>

										<div class="card text-dark bg-light">
											<div class="card-body">
												<blockquote class="card-bodyquote mb-0">
													<div class="d-flex">
														<div class="form-check mb-1">
															<input class="form-check-input" type="radio" name="leaveCalculation" id="business" value="Business" <?php echo $current_leave_calculation == 'Business' ? ' checked ' : ''; ?>>
															<label class="form-check-label" for="business">Business Days</label>
														</div>
													</div>
													<p>Only count working days in leaves. Example: When an employee applies for a 7 days leave (from 1st Oct to 7th Oct, it will be counted as 5 days leave because it contains 2 weekend days).</p>
												</blockquote>
											</div>
										</div>
									</div>
									<div class="card-footer bg-light border-top">
										<div class="form-check my-1">
											<input class="form-check-input" type="checkbox" id="enableHalfDay" <?php echo $settings['enable_half_day_leave'] == 'yes' ? ' checked ' : ''; ?>>
											<label class="form-check-label" for="enableHalfDay">Enable half day leave</label>
										</div>
									</div>
								</div>
							</div>


							<div class="col-12">
								<div class="card border">
									<div class="card-body">
										<h4 class="header-title">Starting Balance</h4>
										<p class="card-title-desc">You can select how the starting balance for annual leave will be to your employees.</p>

										<div class="card text-dark bg-info-light">
											<div class="card-body">
												<blockquote class="card-bodyquote mb-0">
													<div class="d-flex">
														<div class="form-check mb-1">
															<input class="form-check-input" type="radio" name="starting_balance" id="full_balance" value="full_balance" <?php echo $settings['starting_balance'] == 'full_balance' ? ' checked ' : ''; ?>>
															<label class="form-check-label" for="full_balance">
																Full Balance
															</label>
														</div>
													</div>
													<p>The expected year end balance will be available to the employee from the first day.</p>
												</blockquote>
											</div>
										</div>

										<div class="card text-dark bg-light">
											<div class="card-body">
												<blockquote class="card-bodyquote mb-0">
													<div class="d-flex">
														<div class="form-check mb-1">
															<input class="form-check-input" type="radio" name="starting_balance" id="accumulative_balance" value="accumulative_balance" <?php echo $settings['starting_balance'] == 'accumulative_balance' ? ' checked ' : ''; ?>>
															<label class="form-check-label" for="accumulative_balance">
																Accumulative Balance
															</label>
														</div>
													</div>
													<p>Balance will be increased daily for each employee based on their annual entitlement.</p>
												</blockquote>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-12">
								<div class="card border">
									<div class="card-body">
										<div class="row justify-content-between border-bottom">
											<div class="col-md-6">
												<h4 class="header-title">Annual Leave Auto-upgrade <span class="badge rounded-pill badge-soft-success px-3 py-2" id="leaveUpgradeStatus"><?php echo $settings['leave_auto_upgrade'] ? 'Active' : 'Inactive'; ?></span></h4>
											</div>
											<div class="col-md-6">
												<div class="float-end">
													<input type="checkbox" id="leave_auto_upgrade" switch="info" name="leave_auto_upgrade" <?php echo $settings['leave_auto_upgrade'] ? 'checked' : ''; ?>>
													<label for="leave_auto_upgrade" data-on-label="Yes" data-off-label="No"></label>
												</div>
											</div>
											<div class="col-md-12">
												<p class="card-title-desc">When an employee completes a number of years in your organization, the annual leave balance will automatically increase to the defined value. Unless the employee already has more than it.</p>
											</div>
										</div>
										<div class="row pt-3 auto-upgrade-settings">
											<div class="col-md-4">
												<div class="mb-3" data-select2-id="10">
													<label class="form-label">When an employee completes</label>
													<div class="input-group mb-3">
														<input type="text" class="form-control" name="when_employee_completes_year" placeholder="Minimum 1" aria-label="Minimum 1" aria-describedby="addon001" value="<?php echo $settings['when_employee_completes_year'];?>">
														<div class="input-group-append">
															<span class="input-group-text" id="basic-addon001">Years</span>
														</div>
													</div>
												</div>

												<div class="mb-3" data-select2-id="10">
													<label class="form-label">Increase the balance to</label>
													<div class="input-group mb-3">
														<input type="text" class="form-control" name="increase_balance_to" placeholder="Minimum 1" aria-label="Minimum 1" aria-describedby="basic-addon002" value="<?php echo $settings['increase_balance_to'];?>">
														<div class="input-group-append">
															<span class="input-group-text" id="basic-addon002">Days</span>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-12">
												<div class="card text-dark bg-info-light">
													<div class="card-body">
														<blockquote class="card-bodyquote mb-0">
															<div class="d-flex">
																<div class="form-check mb-1">
																	<input class="form-check-input" type="radio" name="is_all_employee_selected" value="yes" id="is_all_employee_selected1" <?php echo $settings['is_all_employee_selected'] == 'yes' ? ' checked ' : ''; ?>>
																	<label class="form-check-label" for="is_all_employee_selected1">
																		All employees
																	</label>
																</div>
															</div>
														</blockquote>
													</div>
												</div>

												<div class="card text-dark bg-light">
													<div class="card-body">
														<blockquote class="card-bodyquote mb-0">
															<div class="d-flex">
																<div class="form-check mb-1">
																	<input class="form-check-input" type="radio" name="is_all_employee_selected" value="no" id="is_all_employee_selected2" <?php echo $settings['is_all_employee_selected'] == 'no' ? ' checked ' : ''; ?>>
																	<label class="form-check-label" for="is_all_employee_selected2">
																		By Employees
																	</label>
																</div>
															</div>
															<div id="addEmployeeContainer" style="display: <?php echo $settings['is_all_employee_selected'] == 'no' ? 'block' : 'none'; ?>;">
																<span><i class="mdi mdi-account-multiple-outline font-size-20" style="vertical-align: middle;"></i> <span id="employeeCount" class="text-primary ms-2"><?php echo count(json_decode($settings['employee_ids'], true)); ?></span><span class="text-primary ms-2">Employees</span></span>
																<a type="button" id="employeeSelectionButton" class="text-primary ms-3"><i class="dripicons-plus font-size-20 text-primary" style="vertical-align: middle;"></i> Add Employees</a>
															</div>
														</blockquote>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="card-footer bg-light border-top auto-upgrade-settings">
										<div class="my-1">
											<button type="button" id="LeaveAutoUpgrade" class="btn btn-primary btn-md float-end">Save</button>
										</div>
									</div>
								</div>
							</div>


							<div class="col-12">
								<form id="returnConfirmationForm">
									<div class="card border">
										<div class="card-body">
											<h4 class="header-title">Return confirmation</h4>
											<p class="card-title-desc">You can use return confirmation to ensure the employee has returned from the annual leave. In all cases, Maha Alfala will record attendance for all employees</p>

											<div class="card text-dark bg-info-light">
												<div class="card-body">
													<blockquote class="card-bodyquote mb-0">
														<div class="d-flex">
															<div class="form-check mb-1">
																<input class="form-check-input" type="radio" name="require_return_confirmation" id="return_confirmation1" value="yes" <?php echo ($settings['require_return_confirmation'] == 'yes') ? ' checked' : ''; ?>>
																<label class="form-check-label" for="return_confirmation1">
																	Require return confirmation from annual leave
																</label>
															</div>
														</div>
														<p>All employees are required to confirm their return through Maha Alfala. If the employee had advanced vacation salary and didn't confirm their return, they will not be included in the payroll until the return is confirmed.</p>
													</blockquote>
												</div>
											</div>

											<div class="card text-dark bg-light">
												<div class="card-body">
													<blockquote class="card-bodyquote mb-2">
														<div class="d-flex">
															<div class="form-check mb-1">
																<input class="form-check-input" type="radio" name="require_return_confirmation" id="return_confirmation2" value="no" <?php echo ($settings['require_return_confirmation'] == 'no') ? ' checked' : ''; ?>>
																<label class="form-check-label" for="return_confirmation2">
																	Do not require return confirmation from annual leave
																</label>
															</div>
														</div>
														<p>No confirmation is required, the employee return date will be the first working day after the annual leave.</p>
													</blockquote>
													<div id="returnDateGroup" style="display: none;">
														<label class="form-label">Action period</label>
														<div class="input-group mb-3">
															<input type="text" class="form-control" id="returnDateInput" name="resumption_period" aria-describedby="returnDateAddon" placeholder="Enter days" value="<?php echo $settings['resumption_period']; ?>" style="max-width: 125px;">
															<span class="input-group-text" id="returnDateAddon">Days</span>
														</div>
														<div id="returnDateError" class="text-danger" style="display: none;">Resumption period is required.</div>
													</div>
												</div>
											</div>

										</div>
										<div class="card-footer bg-light border-top auto-upgrade-settings">
											<div class="my-1">
												<button type="button" id="returnConfirmation" class="btn btn-primary btn-md float-end">Save</button>
											</div>
										</div>
									</div>
								</form>
							</div>


							<div class="col-12">
								<form id="remainingBalanceForm">
									<div class="card border">
										<div class="card-body">
											<h4 class="header-title">Remaining Balance</h4>
											<p class="card-title-desc">You can set how the remaining balance will be treated If an employee ended the year without using all annual leave balance, using the following options</p>

											<div class="card text-dark bg-light">
												<div class="card-body">
													<blockquote class="card-bodyquote mb-0">
														<div class="d-flex">
															<div class="form-check mb-1">
																<input class="form-check-input" type="radio" name="remaining_balance" id="remainingBalance1" value="No carry" <?php echo ($settings['remaining_balance'] == 'No carry') ? ' checked' : ''; ?>>
																<label class="form-check-label" for="remainingBalance1">
																	Reset Balance
																</label>
															</div>
														</div>
														<p>Transferring balance is not allowed, employee balance will reset each year.</p>
													</blockquote>
												</div>
											</div>

											<div class="card text-dark bg-info-light">
												<div class="card-body">
													<blockquote class="card-bodyquote mb-0">
														<div class="d-flex">
															<div class="form-check mb-1">
																<input class="form-check-input" type="radio" name="remaining_balance" id="remainingBalance2" value="Carry all" <?php echo ($settings['remaining_balance'] == 'Carry all') ? ' checked' : ''; ?>>
																<label class="form-check-label" for="remainingBalance2">
																	Carry Forward All Balance
																</label>
															</div>
														</div>
														<p>All remaining balance will be transferred at the end of the year to the new year’s balance.</p>
													</blockquote>
												</div>
											</div>

											<div class="card text-dark bg-light">
												<div class="card-body">
													<blockquote class="card-bodyquote mb-2">
														<div class="d-flex">
															<div class="form-check mb-1">
																<input class="form-check-input" type="radio" name="remaining_balance" id="remainingBalance3" value="Limited carry" <?php echo ($settings['remaining_balance'] == 'Limited carry') ? ' checked' : ''; ?>>
																<label class="form-check-label" for="remainingBalance3">
																	Limited Carry Forward
																</label>
															</div>
														</div>
														<p>Set a maximum number of days that can be transferred to the new year’s balance.</p>
													</blockquote>
													<div id="numberOfDaysGroup" style="display: none;">
														<label class="form-label">Number of days</label>
														<div class="input-group mb-3">
															<input type="text" class="form-control" id="numberOfDays" name="number_of_days" aria-describedby="numberOfDaysAddon" placeholder="Enter days" value="<?php echo $settings['number_of_days']; ?>" style="max-width: 125px;">
															<span class="input-group-text" id="numberOfDaysAddon">Days</span>
														</div>
														<div id="numberOfDaysError" class="text-danger" style="display: none;">No. of days required.</div>
													</div>
												</div>
											</div>
										</div>
										<div class="card-footer bg-light border-top auto-upgrade-settings">
											<div class="my-1">
												<button type="button" id="saveRemainingBalance" class="btn btn-primary btn-md float-end">Save</button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<div class="modal fade fixed-left employeeSelectionModal" aria-labelledby="#selectEmployeeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="selectEmployeeModalLabel">Annual Leave</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
				<?php echo form_open("admin/hr-module/leave-types/add-selected-employees", array("id" => "addEmployeeForm", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
					<div class="employee-selection-body">

					</div>
				<?php echo form_close(); ?>
            </div>
			<div class="modal-footer">
				<div class="row">
					<div class="col-md-12">
						<button form="addEmployeeForm" type="submit" class="btn btn-success btn-md">Save</button>
						<button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-outline-danger btn-md ms-2">Cancel </button>
					</div>
				</div>
			</div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php $this->load->view('admin/home/footer'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const links = document.querySelectorAll('.disable-right-click');
    
    links.forEach(link => {
        link.addEventListener('contextmenu', function(event) {
            event.preventDefault(); // Prevent the default right-click menu
            //alert('Right-click is disabled on this link.'); // Optional: Add a custom message
        });
    });
});
</script>
<script>
	var settingId = 1;
	$(document).ready(function() {
        $('#add-type-btn').click(function() {
            var newRow = `
                <tr>
                    <td>
						<label for="new-days-input">Add new annual leave</label>
                        <input type="number" class="form-control" placeholder="Enter day number" id="new-days-input" style="max-width: 250px;">
                    </td>
                    <td align="center">
                        <button class="btn btn-outline-primary btn-sm save-btn float-end" style="margin-top: 33px;"><i class="fa fa-save"></i> Save</button>
                        <button class="btn btn-outline-danger btn-sm cancel-btn float-end me-2" style="margin-top: 33px;"><i class="fa fa-times"></i> Cancel</button>
                    </td>
                </tr>
            `;
            $('#leave-table tbody').append(newRow);
        });

		$(document).on('click', '.save-btn', function() {
            var $input = $(this).closest('tr').find('#new-days-input');
            var days = $input.val();
			if (days) {
				var setting_id = 1;
				$.ajax({
					url: '<?php echo base_url('admin/hr-module/leave-types/save-entitlement-days');?>', // Change this to your controller's method URL
					method: 'POST',
					data: { setting_id: setting_id, days: days}, // Send an array of new days
					dataType: 'json',
					success: function(response) {
						//console.log(response);
						if (response.status == 'success') {
							// var $row = $(this).closest('tr');
							// $row.html(`
							// 	<td>Days ${days}</td>
							// 	<td align="right"><span class="delete-icon"><button class="btn btn-link text-danger"><i class="dripicons-trash"></i></button></span></td>
							// `);
							toastr.success('Days per year created successfully.');
							$.ajax({
								url: '<?php echo base_url('admin/hr-module/leave-types/get-entitlements'); ?>',
								method: 'GET',
								success: function(tableHtml) {
									$('#leave-table-body').html(tableHtml);
								},
								error: function() {
									toastr.error('Error fetching updated data');
								}
							});
						} else {
							toastr.error("Error saving data: " + response.message);
						}
					}.bind(this),
					error: function(errorRes) {
						toastr.error("Error connecting to server");
					}
				});
			} else {
				toastr.error("Please enter a valid number of days");
			}
        });

        $(document).on('click', '.cancel-btn', function() {
            $(this).closest('tr').remove();
        });

        $(document).on('click', '.delete-btn', function() {
            $(this).closest('tr').remove();
        });
    });

	$(document).on('click', '.delete-btn2', function() {
		var settingId = $(this).data('setting-id');
		var dayToDelete = $(this).data('day');
		var $button = $(this);
		// Show SweetAlert confirmation dialog
		Swal.fire({
			title: 'Are you sure?',
			text: "You won't be able to recover this record!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: '<?php echo base_url('admin/hr-module/leave-types/delete-entitlement'); ?>',
					method: 'POST',
					data: { setting_id: settingId, day_to_delete: dayToDelete },
					dataType: 'json',
					success: function(response) {
						if (response.status === 'success') {
							toastr.success(response.message);
							$.ajax({
								url: '<?php echo base_url('admin/hr-module/leave-types/get-entitlements'); ?>',
								method: 'GET',
								success: function(tableHtml) {
									$('#leave-table-body').html(tableHtml);
								},
								error: function() {
									toastr.error('Error fetching updated data');
								}
							});
						} else {
							toastr.error(response.message);
						}
					}.bind(this),
					error: function() {
						toastr.error('Error connecting to server');
					}
				});
			}
		});
	});

	$(document).ready(function() {
		var calculationCheckedValue = $('input[name="leaveCalculation"]:checked').val();
        $('input[name="leaveCalculation"]').on('change', function() {
            var selectedValue = $(this).val();
            var settingId = 1; // Replace with the actual setting ID
            Swal.fire({
                title: 'Confirm Changes',
                html: "Changing annual leave calculation configuration will affect the calculation for open and upcoming annual leave requests only. Are you sure to change the leave calculation method to " + selectedValue + "?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, change it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?php echo base_url('admin/hr-module/leave-types/update-leave-calculation'); ?>',
                        method: 'POST',
                        data: { setting_id: settingId, leave_calculation: selectedValue },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                toastr.success(response.message);
								// Update the radio button selection
								$('input[name="leaveCalculation"]').prop('checked', false);
                            	$('input[name="leaveCalculation"][value="' + response.current_value + '"]').prop('checked', true);
                            } else {
                                toastr.error(response.message);
								$('input[name="leaveCalculation"][value="' + calculationCheckedValue + '"]').prop('checked', true);
                            }
                        },
                        error: function() {
                            toastr.error('Error connecting to server');
							$('input[name="leaveCalculation"][value="' + calculationCheckedValue + '"]').prop('checked', true);
                        }
                    });
                } else {
                    // Revert the radio button selection if the user cancels the confirmation
                    $('input[name="leaveCalculation"]').prop('checked', false);
                    $('input[name="leaveCalculation"][value="' + calculationCheckedValue + '"]').prop('checked', true);
                }
            });
        });

        $('#enableHalfDay').on('change', function() {
            var isChecked = $(this).is(':checked');
            var settingId = 1; // Replace with the actual setting ID

            $.ajax({
                url: '<?php echo base_url('admin/hr-module/leave-types/update-half-day'); ?>',
                method: 'POST',
                data: { setting_id: settingId, enable_half_day: isChecked },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function() {
                    toastr.error('Error connecting to server');
                }
            });
        });
    });

	$(document).ready(function() {
		// Store the initial checked value when the page loads
		var startingBalanceCheckedValue = $('input[name="starting_balance"]:checked').val();

		$('input[name="starting_balance"]').on('change', function() {
			var selectedValue = $(this).val();
			var settingId = 1; // Replace with the actual setting ID

			Swal.fire({
				title: 'Confirm Changes',
				html: "All pending Requests related to this configuration will not be valid. please, Notify the employees to reapply the request. -All Approved Requests that related to this configuration will applied as previous configuration.",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, change it!'
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						url: '<?php echo base_url('admin/hr-module/leave-types/update-starting-balance'); ?>',
						method: 'POST',
						data: { setting_id: settingId, starting_balance: selectedValue },
						dataType: 'json',
						success: function(response) {
							if (response.status === 'success') {
								toastr.success(response.message);
								// Update the initial checked value to the new one
								startingBalanceCheckedValue = selectedValue;
							} else {
								toastr.error(response.message);
								// Revert the radio button selection
								$('input[name="starting_balance"][value="' + startingBalanceCheckedValue + '"]').prop('checked', true);
							}
						},
						error: function() {
							toastr.error('Error connecting to server');
							// Revert the radio button selection
							$('input[name="starting_balance"][value="' + startingBalanceCheckedValue + '"]').prop('checked', true);
						}
					});
				} else {
					// Revert the radio button selection if the user cancels the confirmation
					$('input[name="starting_balance"][value="' + startingBalanceCheckedValue + '"]').prop('checked', true);
				}
			});
		});

		// Function to toggle the visibility of the form fields based on the checkbox state
		function toggleAutoUpgradeSettings(isChecked) {
			if (isChecked) {
				$('.auto-upgrade-settings').show();
				$('#leaveUpgradeStatus').removeClass('badge-soft-danger').addClass('badge-soft-success').text('Active');
			} else {
				$('.auto-upgrade-settings').hide();
				$('#leaveUpgradeStatus').removeClass('badge-soft-success').addClass('badge-soft-danger').text('Inactive');
			}
		}

		// Initial call to set the visibility on page load
		toggleAutoUpgradeSettings($('#leave_auto_upgrade').is(':checked'));
		
		// Handle the leave auto-upgrade checkbox
		$('#leave_auto_upgrade').on('change', function() {
			var isChecked = $(this).is(':checked');
			var settingId = 1;
			Swal.fire({
				title: 'Confirm Changes',
				html: "Do you want to change the annual leave auto-upgrade to " + (isChecked ? 'enabled' : 'disabled') + "?",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, change it!'
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						url: '<?php echo base_url('admin/hr-module/leave-types/update-leave-auto-upgrade'); ?>',
						method: 'POST',
						data: { setting_id: settingId, leave_auto_upgrade: isChecked },
						dataType: 'json',
						success: function(response) {
							if (response.status === 'success') {
								toastr.success(response.message);
								toggleAutoUpgradeSettings(isChecked);
							} else {
								toastr.error(response.message);
								$('#leave_auto_upgrade').prop('checked', !isChecked);
							}
						},
						error: function() {
							toastr.error('Error connecting to server');
							$('#leave_auto_upgrade').prop('checked', !isChecked);
						}
					});
				} else {
					$('#leave_auto_upgrade').prop('checked', !isChecked);
				}
			});
		});

	});

	$(document).ready(function() {
		// Add custom CSS rules with !important
		$('<style>')
        .prop('type', 'text/css')
        .html(`
            .show-important {
                display: flex !important;
            }
            .hide-important {
                display: none !important;
            }
        `)
        .appendTo('head');
		var selectedEmployees = <?php echo json_encode(json_decode($settings['employee_ids'], true)); ?> || [];
		
		// Handle the radio button change for employee selection
		$('input[name="is_all_employee_selected"]').on('change', function() {
			var selectedValue = $(this).val();

			if (selectedValue === 'no') {
				$('#addEmployeeContainer').show();
			} else {
				$('#addEmployeeContainer').hide();
				$('#employeeCount').text(selectedEmployees.length);
			}
		});

		// Show modal and load employee list via AJAX
		$('#employeeSelectionButton').on('click', function() {
			$.ajax({
				url: '<?php echo base_url('admin/hr-module/leave-types/get-employee-list'); ?>',
				method: 'GET',
				success: function(responseHtml) {
					$('.employee-selection-body').html(responseHtml);
					$('.employeeSelectionModal').modal('show');
					initializeEmployeeList();
				},
				error: function(errorResponse) {
					console.log(errorResponse);
					toastr.error('Error fetching updated data');
				}
			});
		});

		// Handle form submission
		$('#addEmployeeForm').on('submit', function(e) {
			e.preventDefault();

			// Ensure selectedEmployees is updated
			var currentSelectedEmployees = [...selectedEmployees];

			$.ajax({
				url: $(this).attr('action'),
				method: 'POST',
				data: {
					setting_id: settingId,
					selected_employees: currentSelectedEmployees,
				},
				success: function(response) {
					//console.log(response);
					if (response.status === 'success') {
						toastr.success(response.message);
						$('.employeeSelectionModal').modal('hide');

						// Update the employee count on the page
						$('#employeeCount').text(selectedEmployees.length);
					} else {
						toastr.error(response.message);
					}
				},
				error: function() {
					toastr.error('Error connecting to server');
				}
			});
		});

		// Initialize the employee list and button states
		function initializeEmployeeList() {
			$('#employeeList').on('click', '.addEmployee', function() {
				var empId = $(this).data('emp-id').toString();
				var button = $(this);
				if (selectedEmployees.includes(empId)) {
					// Remove employee
					selectedEmployees = selectedEmployees.filter(id => id !== empId);
					button.text('+ Add').removeClass('btn-outline-danger').addClass('btn-outline-primary');
				} else {
					// Add employee
					selectedEmployees.push(empId);
					button.text('- Remove').removeClass('btn-outline-primary').addClass('btn-outline-danger');
				}
				updateEmployeeCount();
			});

			// Handle search functionality
			$('#searchEmployees').on('keyup', function() {
				var searchQuery = $(this).val().toLowerCase();
				console.log('Search Query:', searchQuery); // Log search query
				$('#employeeList .list-group-item').each(function() {
					var employeeName = $(this).find('h6.mb-0').text().toLowerCase();
					var employeeID = $(this).find('small').text().toLowerCase();
					console.log('Employee Name:', employeeName); // Log employee name
					console.log('Employee ID:', employeeID); // Log employee ID
					var isVisible = employeeName.includes(searchQuery) || employeeID.includes(searchQuery);
					console.log('Item Visible:', isVisible); // Log whether the item will be visible
					
					if (isVisible) {
						$(this).addClass('show-important').removeClass('hide-important'); // Show item
					} else {
						$(this).addClass('hide-important').removeClass('show-important'); // Hide item
					}
				});
			});

			// Update employee count display
			function updateEmployeeCount() {
				$('#employeeCountInModal').text(selectedEmployees.length + ' Employees');
			}

			// Update the employee list to reflect the selected employees
			$('#employeeList .list-group-item').each(function() {
				var empId = $(this).find('.addEmployee').data('emp-id').toString();
				var button = $(this).find('.addEmployee');
				if (selectedEmployees.includes(empId)) {
					button.text('- Remove').removeClass('btn-outline-primary').addClass('btn-outline-danger');
				} else {
					button.text('+ Add').removeClass('btn-outline-danger').addClass('btn-outline-primary');
				}
			});

			updateEmployeeCount(); // Initial count update
		}
	});

	/*----- Employee Add -----*/
	

	// Handle the form submission
    $('#LeaveAutoUpgrade').on('click', function(e) {
        e.preventDefault();

        var whenEmployeeCompletesYear = $('input[name="when_employee_completes_year"]').val();
        var increaseBalanceTo = $('input[name="increase_balance_to"]').val();
        var leaveAutoUpgrade = $('#leave_auto_upgrade').is(':checked');
        var isAllEmployeeSelected = $('input[name="is_all_employee_selected"]:checked').val();

        $.ajax({
            url: '<?php echo base_url('admin/hr-module/leave-types/save-auto-upgrade-settings'); ?>',
            method: 'POST',
            data: {
                setting_id: settingId,
                when_employee_completes_year: whenEmployeeCompletesYear,
                increase_balance_to: increaseBalanceTo,
                leave_auto_upgrade: leaveAutoUpgrade,
                is_all_employee_selected: isAllEmployeeSelected
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function() {
                toastr.error('Error connecting to server');
            }
        });
    });

	$(document).ready(function() {
        $('input[name="require_return_confirmation"]').on('change', function() {
            if ($('#return_confirmation2').is(':checked')) {
                $('#returnDateGroup').show();
            } else {
                $('#returnDateGroup').hide();
				$('#returnDateError').hide();
            }
        });

		// Trigger change event on page load to set the initial state
		$('input[name="require_return_confirmation"]:checked').trigger('change');

		$('#returnConfirmation').on('click', function(e) {
			e.preventDefault();
			var requireReturnConfirmation = $('input[name="require_return_confirmation"]:checked').val();
			var resumptionPeriod = $('#returnDateInput').val();
			var isValid = true;

			if (requireReturnConfirmation == "no" && !resumptionPeriod) {
				$('#returnDateError').show();
				isValid = false;
			} else {
				$('#returnDateError').hide();
			}

			if (isValid) {
				$.ajax({
					url: '<?php echo base_url('admin/hr-module/leave-types/save-return-confirmation'); ?>',
					method: 'POST',
					data: $('#returnConfirmationForm').serialize(),
					dataType: 'json',
					success: function(response) {
						if (response.status === 'success') {
							toastr.success(response.message);
						} else {
							toastr.error(response.message);
						}
					},
					error: function() {
						toastr.error('Error connecting to server');
					}
				});
			}
		});
    });

	$(document).ready(function() {
		$('input[name="remaining_balance"]').on('change', function() {
			if ($('#remainingBalance3').is(':checked')) {
				$('#numberOfDaysGroup').show();
			} else {
				$('#numberOfDaysGroup').hide();
				$('#numberOfDaysError').hide();
			}
		});

		// Trigger change event on page load to set the initial state
		$('input[name="remaining_balance"]:checked').trigger('change');

		$('#saveRemainingBalance').on('click', function(e) {
			e.preventDefault();
			var selectedOption = $('input[name="remaining_balance"]:checked').val();
			var numberOfDays = $('#numberOfDays').val();
			var isValid = true;

			if (selectedOption == "Limited carry" && !numberOfDays) {
				$('#numberOfDaysError').show();
				isValid = false;
			} else {
				$('#numberOfDaysError').hide();
			}

			if (isValid) {
				$.ajax({
					url: '<?php echo base_url('admin/hr-module/leave-types/save-remaining-balance'); ?>',
					method: 'POST',
					data: $('#remainingBalanceForm').serialize(),
					dataType: 'json',
					success: function(response) {
						if (response.status === 'success') {
							toastr.success(response.message);
						} else {
							toastr.error(response.message);
						}
					},
					error: function() {
						toastr.error('Error connecting to server');
					}
				});
			}
		});
	});

</script>
