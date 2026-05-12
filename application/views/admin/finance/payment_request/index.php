<?php $this->load->view('admin/home/header'); ?>
<style>
	#responseContainer {
		position: fixed;
		width: 93%;
		top: 60px;
	}

	.size-inner-section {
		box-shadow: 0px 1px 4px #c5c5c5;
		border-radius: 5px;
		margin-bottom: 10px;
	}

	@media only screen and (max-width: 600px) {
		.modal-dialog-aside {
			width: 100% !important;
			max-width: 100% !important;
		}
	}

	.modal-dialog-aside {
		width: 40%;
		max-width: 80%;
		height: 100%;
		margin: 0;
		transform: translate(0);
		transition: transform .2s;
	}

	.modal-dialog-aside .modal-content {
		height: inherit;
		border: 0;
		border-radius: 0;
	}

	.modal-dialog-aside .modal-content .modal-body {
		overflow-y: auto
	}

	.modal-dialog-aside {
		width: 35%;
		max-width: 80%;
		height: 100%;
		margin: 0;
		transform: translate(0);
		transition: transform .2s;
	}

	.modal-dialog-aside .modal-content {
		height: inherit;
		border: 0;
		border-radius: 0;
	}

	.modal-dialog-aside .modal-content .modal-body {
		overflow-y: auto
	}

	.modal.fixed-left .modal-dialog-aside {
		margin-left: auto;
		transform: translateX(100%);
	}

	.modal.fixed-right .modal-dialog-aside {
		margin-right: auto;
		transform: translateX(-100%);
	}

	.modal.show .modal-dialog-aside {
		transform: translateX(0);
	}
</style>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Payment Request Form</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/finance/payment-request'); ?>">Payment Request</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if (check_action_permission(get_user_role(), 'payment_request_form', 'delete')): ?>
						<button class="btn btn-custom-danger btn-sm pull-right me-2" onclick="confirm('Really want to delete this item?') ? $('#delete_form').submit() : false;" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					<?php endif;
					if (check_action_permission(get_user_role(), 'payment_request_form', 'create')): ?>
						<a class="btn btn-custom-success btn-sm pull-right" title="Add" href="<?php echo base_url('admin/finance/payment-request/add'); ?>"><i class="fa fa-plus"></i> Add New Payment</a>
					<?php endif; ?>
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
					<!-- </div> -->
				</div>
			</div>
		</div>
	</div>
	<!-- end page title -->
</div>
	<div class="container-fluid">
		<div class="page-content-wrapper">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h4 class="header-title mb-0">Search</h4>
						</div>
						<div class="card-body">
							<form action="<?php echo base_url('admin/finance/payment-request'); ?>" method="get" id="filter_form">
								<div class="row">
									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label>Documnet No.</label>
											<select name="document_no" class="form-control select2 select2-ajax" data-filter-type="document_no" data-selected="<?php echo $this->input->get('document_no'); ?>">
												<option value="">[Any Documnet No.]</option>
												<?php if ($this->input->get('document_no')) { ?>
													<option value="<?php echo $this->input->get('document_no'); ?>" selected>
														<?php echo $this->input->get('document_no'); ?>
													</option>
												<?php } ?>
											</select>
										</div>
									</div>

									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label>Type (Vendor/Employee/Saddad)</label>
											<select name="request_for_type" class="form-control select2">
												<option value="">[Any Type]</option>
												<option value="employee" <?php echo ($this->input->get('request_for_type') == 'employee') ? "selected" : ""; ?>>Employee</option>
												<option value="saddad" <?php echo ($this->input->get('request_for_type') == 'saddad') ? "selected" : ""; ?>>Saddad</option>
												<option value="vendor" <?php echo ($this->input->get('request_for_type') == 'vendor') ? "selected" : ""; ?>>Vendor</option>
											</select>
										</div>
									</div>

									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label>Request For</label>
											<select name="request_for_id" id="request_for_ids" class="form-select select2">
												<option value="">[Any Request]</option>

											</select>
										</div>
									</div>

									<?php
									$adv_show = false;
									if (!empty($this->input->get('from')) || !empty($this->input->get('to')) || !empty($this->input->get('method_of_payment')) || !empty($this->input->get('requester_id')) || !empty($this->input->get('type_of_payment')) || !empty($this->input->get('currency')) || !empty($this->input->get('p_from')) || !empty($this->input->get('p_to')) || !empty($this->input->get('status')) || !empty($this->input->get('comments'))) {
										$adv_show = true;
									}
									?>
									<div class="collapse <?php if ($adv_show) {
																echo ' show';
															} ?>" id="advanceFilter">
										<div class="row">
											<div class="col-lg-4 col-md-4 col-sm-12">
												<div class="form-group mb-2">
													<label>Requested By</label>
													<select name="requester_id" class="form-select select2 select2-ajax" data-filter-type="requester_id" data-selected="<?php echo $this->input->get('requester_id'); ?>">
														<option value="">[Any Request By]</option>
														<?php if ($this->input->get('requester_id')) {
															$RequesterUserId = $this->input->get('requester_id');
															$RequesterUserName = employeeDetailHelper($RequesterUserId);
														?>
															<option value="<?php echo $RequesterUserId; ?>" selected>
																<?php echo $RequesterUserName->full_name; ?>
															</option>
														<?php } ?>
													</select>
												</div>
											</div>

											<div class="col-lg-4 col-md-4 col-sm-12">
												<div class="form-group mb-2">
													<label>Method of Payment</label>
													<select name="method_of_payment" class="form-control select2">
														<option value="">[Any Method]</option>
														<option value="Cash" <?php echo ($this->input->get('method_of_payment') == 'Cash') ? 'selected' : ''; ?>>Cash</option>
														<option value="Wire Transfer" <?php echo ($this->input->get('method_of_payment') == 'Wire Transfer') ? 'selected' : ''; ?>>Wire Transfer</option>
														<option value="Cheque" <?php echo ($this->input->get('method_of_payment') == 'Cheque') ? 'selected' : ''; ?>>Cheque</option>
													</select>
												</div>
											</div>

											<div class="col-lg-4 col-md-4 col-sm-12">
												<div class="form-group mb-2">
													<label>Type of Payment</label>
													<select name="type_of_payment" class="form-control select2">
														<option value="">[Any Method]</option>
														<option value="Advance Payment" <?php echo ($this->input->get('type_of_payment') == 'Advance Payment') ? 'selected' : ''; ?>>Advance Payment</option>
														<option value="Reimbursement" <?php echo ($this->input->get('type_of_payment') == 'Reimbursement') ? 'selected' : ''; ?>>Reimbursement</option>
														<option value="Invoice Due" <?php echo ($this->input->get('type_of_payment') == 'Invoice Due') ? 'selected' : ''; ?>>Invoice Due</option>
														<option value="Saddad Payment" <?php echo ($this->input->get('type_of_payment') == 'Saddad Payment') ? 'selected' : ''; ?>>Saddad Payment</option>
														<option value="Full" <?php echo ($this->input->get('type_of_payment') == 'Full') ? 'selected' : ''; ?>>Full</option>
														<option value="Partial" <?php echo ($this->input->get('type_of_payment') == 'Partial') ? 'selected' : ''; ?>>Partial</option>
														<option value="Local" <?php echo ($this->input->get('type_of_payment') == 'Local') ? 'selected' : ''; ?>>Local</option>
														<option value="International" <?php echo ($this->input->get('type_of_payment') == 'International') ? 'selected' : ''; ?>>International</option>
													</select>
												</div>
											</div>

											<div class="col-lg-4 col-md-4 col-sm-12">
												<div class="form-group mb-2">
													<label>Currency</label>
													<select name="currency" class="form-control select2">
														<option value="">[Any Currency]</option>
														<option value="sar" <?php echo ($this->input->get('currency') == 'sar') ? 'selected' : ''; ?>>SAR</option>
														<option value="usd" <?php echo ($this->input->get('currency') == 'usd') ? 'selected' : ''; ?>>USD</option>
														<option value="inr" <?php echo ($this->input->get('currency') == 'inr') ? 'selected' : ''; ?>>INR</option>
													</select>
												</div>
											</div>

											<div class="col-lg-4 col-md-4 col-sm-12">
												<div class="form-group mb-2">
													<label>Request Date (From and To)</label>
													<div class="input-daterange input-group" id="datepicker6" data-date-format="dd-m-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
														<input type="text" class="form-control" name="from" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" autocomplete="off" placeholder="Start Date" />
														<input type="text" class="form-control" name="to" value="<?php echo $this->input->get('to') ? $this->input->get('to') : ''; ?>" autocomplete="off" placeholder="End Date" />
													</div>
												</div>
											</div>

											<div class="col-lg-4 col-md-4 col-sm-12">
												<div class="form-group mb-2">
													<label>Bank Payment Date (From and To)</label>
													<div class="input-daterange input-group" id="datepicker7" data-date-format="dd-m-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker7'>
														<input type="text" class="form-control" name="p_from" value="<?php echo $this->input->get('p_from') ? $this->input->get('p_from') : ''; ?>" autocomplete="off" placeholder="Start Date" />
														<input type="text" class="form-control" name="p_to" value="<?php echo $this->input->get('p_to') ? $this->input->get('p_to') : ''; ?>" autocomplete="off" placeholder="End Date" />
													</div>
												</div>
											</div>

											<div class="col-lg-4 col-md-4 col-sm-12">
												<div class="form-group mb-2">
													<label>Status</label>
													<select name="status" class="form-select select2">
														<option value="">[Any Status]</option>
														<option value="open" <?php echo ($this->input->get('status') == 'open') ? "selected" : ""; ?>>Open</option>
														<option value="paid" <?php echo ($this->input->get('status') == 'paid') ? 'selected' : ''; ?>>Paid</option>
														<option value="cancelled" <?php echo ($this->input->get('status') == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
													</select>
												</div>
											</div>
											
											<div class="col-lg-4 col-md-4 col-sm-12">
												<div class="form-group mb-2">
													<label>Search in Comments</label>
													<input type="text" class="form-control" name="comments" value="<?php echo $this->input->get('comments') ? $this->input->get('comments') : ''; ?>" autocomplete="off" placeholder="Comments" />
												</div>
											</div>

										</div>
									</div>
								</div>

								<div class="row mt-2">
									<div class="col-lg-6 col-md-6 col-sm-12">
										<button class="btn btn-outline-secondary waves-effect waves-light" type="button" data-bs-toggle="collapse" data-bs-target="#advanceFilter" aria-expanded="false" aria-controls="advanceFilter"><i class="fas fa-sliders-h"></i> Advance Search</button>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12">
										<button type="submit" class="btn btn-success btn-md float-end ms-2">Apply Filter</button>
										<a href="<?php echo base_url('admin/finance/payment-request'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>

				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<?php echo form_open('admin/form-center/delete', array("id" => "delete_form")); ?>
							<table id="itemTable" class="table table-striped table-bordered jambo_table bulk_action" style="width: 100%;">
								<thead>
									<tr>
										<th>#</th>
										<th>S.No.</th>
										<th>Doc. No.</th>
										<th>Vendor/Employee</th>
										<th>EMP ID</th>
										<th>Full Name</th>
										<th>Requester By</th>
										<th>Method of Payment</th>
										<th>Type of Payment</th>
										<th>Bank Name</th>
										<th>IBAN Number</th>
										<th>Currency</th>
										<th>Amount</th>
										<th>Request Date</th>
										<th>Bank Payment Date</th>
										<th>Status</th>
										<th>Created At</th>
										<th>Tools</th>
									</tr>
								</thead>

							</table>
							<?php echo form_close(); ?>
						</div>
					</div>
				</div> <!-- end col -->
			</div> <!-- end row -->
		</div>
	</div>
	<!-- container-fluid -->
	<!-- Modal -->
	<div class="modal fade fixed-left form-center-modal" id="formRequestModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
		<div class="modal-dialog modal-dialog-aside">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title mt-0">Update Payment Detail</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div id="searchResult">

					</div>
				</div>
				<div class="modal-footer" id="searchModalFooter">

				</div>
			</div>
		</div>
	</div>

	<?php $this->load->view('admin/home/footer'); ?>

	<script>
		function initializeDataTable() {
			if ($.fn.DataTable.isDataTable('#itemTable')) {
				$('#itemTable').DataTable().destroy();
			}

			$('#itemTable').DataTable({
				"lengthMenu": [
					[25, 50, 100, 500],
					[25, 50, 100, 500]
				],
				order: [
					[0, 'DESC']
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
				"serverSide": true,
				fixedHeader: true,
				"ajax": {
					url: "<?php echo base_url('admin/finance/payment-request/list-ajax?document_no=' . $this->input->get('document_no') . '&request_for_type=' . $this->input->get('request_for_type') . '&request_for_id=' . $this->input->get('request_for_id') . '&from=' . $this->input->get('from') . '&to=' . $this->input->get('to') . '&p_from=' . $this->input->get('p_from') . '&p_to=' . $this->input->get('p_to') . '&requester_id=' .  $this->input->get('requester_id') . '&method_of_payment=' . $this->input->get('method_of_payment') . '&type_of_payment=' . $this->input->get('type_of_payment') . '&currency=' . $this->input->get('currency') . '&status=' . $this->input->get('status') . '&comments=' . $this->input->get('comments')); ?>",
					type: "POST",
					error: function(request, error) {
						console.log(" Can't do because: " + JSON.stringify(request));
					},
				},
				"columnDefs": [{
					"targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17],
					"orderable": false
				}]
			});
		}

		$(document).ready(function() {
			initializeDataTable();
			updateRequestForIdOptions();

			$('select[name="request_for_type"]').on('change', updateRequestForIdOptions);
		});

		$(document).ready(function() {
			$(document).on('click', '.payment-update-btn', function() {
				var id = $(this).data('id');
				if (id > 0) {
					$.ajax({
						url: "<?php echo base_url('admin/finance/payment-request/payment-update-form'); ?>",
						type: 'POST',
						data: {
							id: id
						},
						dataType: 'json',
						success: function(response) {
							if (response.type === 'success') {
								$('#formRequestModal').modal('show');
								$('#searchResult').html(response.output_html);
								$('#searchModalFooter').html(`
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetModalData()">Cancel</button>
								<button type="submit" form="editPaymentForm" class="btn btn-custom-success">Submit</button>
							`);
							} else {
								toastr.error(response.message);
							}
						},
						error: function(xhr, status, error) {
							toastr.error('An error in fetching payment detail. Please try again.');
						}
					});
				}
			});
		});

		function resetModalData() {
			$('#searchResult form input').val('');
		}
	</script>
	<!-- Global AJAX Function for all filters -->
	<script type="text/javascript">
		$('.select2-ajax').each(function() {
			var $this = $(this);
			var filterType = $this.data('filter-type');
			var selectedValue = $this.data('selected'); // Get selected value from data attribute

			$this.select2({
				placeholder: '[Any ' + filterType.charAt(0).toUpperCase() + filterType.slice(1) + ']',
				minimumInputLength: 2,
				ajax: {
					url: '<?php echo base_url('admin/finance/payment-request/fetch-filter-data'); ?>',
					dataType: 'json',
					delay: 250,
					data: function(params) {
						return {
							query: params.term,
							filter_type: filterType
						};
					},
					processResults: function(data) {
						var results = $.map(data, function(item) {
							var textField = '';

							// Map the correct field based on filter type
							if (filterType === 'document_no') {
								textField = item.document_no;
							} else if (filterType === 'requester_id') {
								textField = item.full_name;
							}

							return {
								id: item.key_value,
								text: textField
							};
						});
						return {
							results: results
						};
					},
					cache: true
				}
			});

			// Ensure the selected value is retained after refresh
			var selectedValue = $this.data('selected');
			if (selectedValue) {
				$this.val(selectedValue).trigger('change');
			}
		});

		// AJAX for fetching employee/vendor list
		function updateRequestForIdOptions() {
			var selectedType = $('select[name="request_for_type"]').val();
			console.log(selectedType);
			var selectedUser = '<?php echo $this->input->get('request_for_id'); ?>';
			$.ajax({
				url: "<?php echo base_url('admin/finance/payment-request/get-employees-vendor'); ?>",
				type: 'POST',
				data: {
					request_for_type: selectedType
				},
				dataType: 'json',
				success: function(response) {
					console.log(response);
					var $select = $('#request_for_ids');
					$select.empty();

					if (selectedType === 'employee') {
						$select.append('<option value="">Select Employee</option>');
						$.each(response, function(index, employee) {
							var isSelected = (selectedUser === employee.id) ? ' selected="selected"' : '';
							$select.append('<option value="' + employee.id + '" data-department_id="' + employee.department + '" data-department="' + employee.department_name + '"' + isSelected + '>' + employee.emp_no + ' - ' + employee.full_name + ' [' + employee.designation_name + ']</option>');
						});
					} else if (selectedType === 'vendor' || selectedType === 'saddad') {
						$select.append('<option value="">Select Vendor</option>');
						$.each(response, function(index, vendor) {
							var isSelected = (selectedUser === vendor.id) ? ' selected="selected"' : '';
							$select.append('<option value="' + vendor.id + '"' + isSelected + '>' + vendor.vendor_name + '</option>');
						});
					} else {
						$select.append('<option value="">[Select Type First]</option>');
					}
				},
				error: function() {
					toastr.error('An error occurred while fetching data.');
				}
			});
		}
	</script>