
<?php $this->load->view('admin/home/header');?>

<style>
	.required-field{
		color:#f00;
	}
	.size-inner-section {
		box-shadow: 0px 1px 4px #c5c5c5;
		border-radius: 5px;
		margin-bottom: 10px;
	}
	.form-control-plaintext {
		padding: 10px;
		line-height: 1.5;
		border: 1px dotted #ededed;
		border-width: 1px;
	}
	.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
		color: #176a1a;
		background-color: #fff;
		border-color: #4CAF50 #4caf50 #fff;
		font-weight: 600;
		box-shadow: 1px -2px 8px -4px #6c6b6b;
	}
	table.jambo_table thead {
		background: #d9d9d9;
		color: #000000;
		font-size: 13px;
	}
</style>
<div id="wait"><i class="fa fa-spinner fa-spin"></i><br>Updating..</div>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Property Detail</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/facility-management/property/list'); ?>">Facility Management</a></li>
						<li class="breadcrumb-item active">Property Detail</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id');?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-2" title="Back" href="<?php echo base_url('admin/facility-management/property/list'); ?>"><i class="fa fa-reply"></i> Back</a>
				</div>
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
				<?php } else {?>
				<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<strong><?php echo $msg_data; ?></strong>
				</div>
				<?php }}
				$this->admin->removeInfo();?>
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
						
						<div class="row size-inner-section mx-1 px-2 py-4">
							<h4 class="header-title">Property Details</h4><hr>
							<div class="col-md-4 mb-2">
								<label class="form-label">Property Number</label>
								<p class="form-control-plaintext"><?= htmlspecialchars($property['property_number']) ?></p>
							</div>
							<div class="col-md-4 mb-2">
								<label class="form-label">Property Name</label>
								<p class="form-control-plaintext"><?= htmlspecialchars($property['property_name']) ?></p>
							</div>
							<div class="col-md-4 mb-2">
								<label class="form-label">Property Type</label>
								<p class="form-control-plaintext"><?= htmlspecialchars($property['property_type']) ?></p>
							</div>
							<div class="col-md-4 mb-2">
								<label class="form-label">City</label>
								<p class="form-control-plaintext">
									<?= htmlspecialchars(array_column($cities, 'city_name', 'id')[$property['property_city']] ?? '') ?>
								</p>
							</div>
							<div class="col-md-4 mb-2">
								<label class="form-label">Property Status</label>
								<p class="form-control-plaintext text-capitalize"><?= htmlspecialchars($property['property_status']) ?></p>
							</div>
						</div>

						<!-- Tenant Data -->
						<div class="row size-inner-section mx-1 px-2 py-4">
							<h4 class="header-title">Tenant Data</h4><hr>
							<div class="col-md-4 mb-2">
								<label class="form-label">Company Name/Founder</label>
								<p class="form-control-plaintext">
									<?php 
									foreach (sponsorsHelper() as $sponsor) {
										if ($sponsor['id'] == $property['tenant_company_id']) {
											echo htmlspecialchars($sponsor['employer_id'] .' - '. $sponsor['employer_name']);
											break;
										}
									}
									?>
								</p>
							</div>
							<div class="col-md-4 mb-2">
								<label class="form-label">Unified Number</label>
								<p class="form-control-plaintext"><?= htmlspecialchars($property['tenant_unified_number']) ?></p>
							</div>
							<div class="col-md-4 mb-2">
								<label class="form-label">CR Number</label>
								<p class="form-control-plaintext"><?= htmlspecialchars($property['tenant_cr_no']) ?></p>
							</div>
						</div>

						<!-- Brokerage Entity -->
						<div class="row size-inner-section mx-1 px-2 py-4">
							<h4 class="header-title">Brokerage Entity and Broker Details</h4><hr>
							<?php 
							$fields = [
								'brokerage_entity_name', 'brokerage_entity_address', 'brokerage_landline_no', 'brokerage_cr_no',
								'brokerage_vat_no', 'broker_name', 'broker_id_no', 'broker_person', 'broker_mobile_no', 'broker_email_id'
							];
							foreach ($fields as $field): ?>
								<div class="col-md-4 mb-2">
									<label class="form-label"><?= ucwords(str_replace('_', ' ', $field)) ?></label>
									<p class="form-control-plaintext"><?= htmlspecialchars($property[$field]) ?></p>
								</div>
							<?php endforeach; ?>
							<div class="col-md-4 mb-2">
								<label class="form-label">Nationality</label>
								<p class="form-control-plaintext">
									<?= htmlspecialchars(array_column(nationalityList(), 'name', 'id')[$property['broker_nationality']] ?? '') ?>
								</p>
							</div>
						</div>

						<!-- Bank Details -->
						<div class="row size-inner-section mx-1 px-2 py-4">
							<h4 class="header-title">Bank Details</h4><hr>
							<div class="col-md-4 mb-2">
								<label class="form-label">Account Name</label>
								<p class="form-control-plaintext"><?= htmlspecialchars($property['account_name']) ?></p>
							</div>
							<div class="col-md-4 mb-2">
								<label class="form-label">Bank Name</label>
								<p class="form-control-plaintext">
									<?= htmlspecialchars(array_column($banks, 'bank_name', 'id')[$property['bank_name']] ?? '') ?>
								</p>
							</div>
							<div class="col-md-4 mb-2">
								<label class="form-label">IBAN</label>
								<p class="form-control-plaintext"><?= htmlspecialchars($property['iban']) ?></p>
							</div>
						</div>

						<!-- Rent Details -->
						<div class="row size-inner-section mx-1 px-2 py-4">
							<h4 class="header-title">Rent Details</h4><hr>
							<div class="col-md-4 mb-2">
								<label class="form-label">Ejar Contract Number</label>
								<p class="form-control-plaintext"><?= htmlspecialchars($property['ejar_contract_number']) ?></p>
							</div>
							<div class="col-md-4 mb-2">
								<label class="form-label">Ejar Contract Start Date</label>
								<p class="form-control-plaintext"><?= date('d-m-Y', strtotime($property['ejar_contract_start_date'])) ?></p>
							</div>
							<div class="col-md-4 mb-2">
								<label class="form-label">Ejar Contract End Date</label>
								<p class="form-control-plaintext"><?= date('d-m-Y', strtotime($property['ejar_contract_end_date'])) ?></p>
							</div>
							<div class="col-md-4 mb-2">
								<label class="form-label">Created At</label>
								<p class="form-control-plaintext"><?= date('d-m-Y', strtotime($property['created_at'])) ?></p>
							</div>
							<div class="col-md-4 mb-2">
								<label class="form-label">Updated At</label>
								<p class="form-control-plaintext"><?= date('d-m-Y', strtotime($property['updated_at'])) ?></p>
							</div>
							<div class="col-md-4 mb-2">
								<label class="form-label">Ejar Contract Document</label>
								<?php if (!empty($property['attach_ejar_contract'])): ?>
									<a href="<?= base_url($property['attach_ejar_contract']) ?>" target="_blank" class="d-block">
										<?= basename($property['attach_ejar_contract']) ?>
									</a>
								<?php else: ?>
									<p class="form-control-plaintext">No document uploaded</p>
								<?php endif; ?>
							</div>
						</div>

						<!-- Property Details -->
						<div class="row size-inner-section mx-1 px-2 py-4">
							<h4 class="header-title">Rent Payment Schedule</h4>
							<div class="p-2 table-rep-plugin">
								<div class="table-responsive mb-0" data-pattern="priority-columns">
									<table id="rentTable" class="table table-striped bulk_action jambo_table" style="width:100%">
										<thead>
											<tr>
												<th class="text-center">No</th>
												<th class="text-center">Rent Value</th>
												<th class="text-center">VAT</th>
												<th class="text-center">Services</th>
												<th class="text-center">Total Value</th>
												<th class="text-center">Issued Date(AD)</th>
												<th class="text-center">Due Date(AD)</th>
												<th class="text-center">Issued Date(AH)</th>
												<th class="text-center">Due Date(AH)</th>
											</tr>
										</thead>
										<tbody>
											<?php if (!empty($rent_payments['schedule'])): ?>
												<?php $scount=1; foreach ($rent_payments['schedule'] as $index => $schedule): ?>
													<tr>
														<td class="text-center"><?= $scount++; ?></td>
														<td class="text-center"><?= $schedule['rent_value']; ?></td>
														<td class="text-center"><?= $schedule['vat']; ?></td>
														<td class="text-center"><?= $schedule['service']; ?></td>
														<td class="text-center"><?= $schedule['total_value']; ?></td>
														<td class="text-center"><?= $schedule['issue_date_g']; ?></td>
														<td class="text-center"><?= $schedule['due_date_g']; ?></td>
														<td class="text-center"><?= $schedule['issue_date_h']; ?></td>
														<td class="text-center"><?= $schedule['due_date_h']; ?></td>
													</tr>
												<?php endforeach; ?>
											<?php else: ?>
												<tr>
													<td colspan="9" class="text-center">No Data Found</td>
												</tr>
											<?php endif; ?>
										</tbody>
									</table>

								</div>
							</div>
						</div>

						<div class="row size-inner-section mx-1 px-2 py-4">
							<h4 class="header-title">Utility Bill Details</h4>
							<div class="p-2">
								<div id="utility-section">
									<div class="table-rep-plugin px-0">
										<div class="table-responsive mb-0" data-pattern="priority-columns">
											<table id="utilityTable" class="table table-striped bulk_action jambo_table" style="width:100%">
												<thead>
													<tr>
														<th class="text-center">No</th>
														<th class="text-center">Water Bill Saddad Number</th>
														<th class="text-center">Electricity Bill Saddad Number</th>
													</tr>
												</thead>
												<tbody>
													<?php if (!empty($rent_payments['utilities'])): ?>
														<?php $ucount=1;foreach ($rent_payments['utilities'] as $index => $utility): ?>
															<tr>
																<td class="text-center"><?= $ucount++;?></td>
																<td class="text-center"><?= $utility['water'] ?? '' ?></td>
																<td class="text-center"><?= $utility['electricity'] ?? '' ?></td>
															</tr>
														<?php endforeach; ?>
													<?php else: ?>
													<tr>
														<td colspan="9" class="text-center">No Data Found</td>
													</tr>
													<?php endif; ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="row size-inner-section mx-1 px-2 py-4">
							<h4 class="header-title">Facility Details</h4>
							<div class="p-2">
								<div id="facility-section">
									<div class="table-rep-plugin px-0">
										<div class="table-responsive mb-0" data-pattern="priority-columns">
											<table id="facilityTable" class="table table-striped bulk_action jambo_table" style="width:100%">
												<thead>
													<tr>
														<th class="text-center">No</th>
														<th class="text-center">Floors</th>
														<th class="text-center">Rooms</th>
														<th class="text-center">Kitchens</th>
														<th class="text-center">Parking</th>
														<th class="text-center">Elevators</th>
													</tr>
												</thead>
												<tbody>
													<?php if (!empty($rent_payments['facilities'])): ?>
														<?php $fcount=1;foreach ($rent_payments['facilities'] as $index => $facility): ?>
															<tr>
																<td class="text-center"><?= $fcount++;?></td>
																<td class="text-center"><?= $facility['floors'] ?? '' ?></td>
																<td class="text-center"><?= $facility['rooms'] ?? '' ?></td>
																<td class="text-center"><?= $facility['kitchen'] ?? '' ?></td>
																<td class="text-center"><?= $facility['parking'] ?? '' ?></td>
																<td class="text-center"><?= $facility['elevators'] ?? '' ?></td>
															</tr>
														<?php endforeach; ?>
													<?php else: ?>
													<tr>
														<td colspan="9" class="text-center">No Data Found</td>
													</tr>
													<?php endif; ?>
												</tbody>
											</table>
										</div>
									</div>
									
								</div>
							</div>
						</div>
					</div>

				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<?php $this->load->view('admin/home/footer');?>

<script type="text/javascript">
	$('.dropify').dropify();

	function Alpha(evt) {
		var keyCode = (evt.which) ? evt.which : evt.keyCode
		if ((keyCode < 65 || keyCode > 90) && (keyCode < 97 || keyCode > 123) && keyCode != 32)

			return false;
		return true;
	}

	function numerics(key) {
		//getting key code of pressed key
		// alert($(this).val());
		var keycode = (key.which) ? key.which : key.keyCode;
		//comparing pressed keycodes

		if (keycode > 31 && (keycode < 48 || keycode > 57)) {
			toastr.error('You can enter only characters 0 to 9.');
			return false;
		} else return true;
	}

	$("select[name='tenant_company_id']").on('change',function(){
		var tenant_company_id = $(this).val();
		var tenant_cr_no = $("select[name='tenant_company_id'] option:selected").data('tenant_cr_no');
		$('#cr_number').val(tenant_cr_no);
	});
</script>
<script>
$(document).ready(function() {
    $('#propertyForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        // Validate contract dates
        let start = $('#ejar_contract_start_date').val();
        let end = $('#ejar_contract_end_date').val();
        if (start && end && end < start) {
            toastr.error('End date must be after start date.');
            return false;
        }

        $.ajax({
            url: '<?= base_url("admin/facility-management/property/update") ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status === 'success') {
                    toastr.success(response.message);
                    $('#propertyForm')[0].reset();
					setTimeout(function() {
						window.location.href = '<?= base_url("admin/facility-management/property/list") ?>';
					}, 1000);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function() {
                toastr.error('Something went wrong.');
            }
        });
    });
});
</script>

