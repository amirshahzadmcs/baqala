<?php $this->load->view('admin/home/header'); ?>
<style>
	.dataTables_wrapper::-webkit-scrollbar {
		display: none;
	}

	.nav-md .container.body .right_col {
		padding: 10px 10px 0;
		margin-left: 230px;
	}

	#iqamaListTable thead tr th,
	#iqamaListTable tbody tr td {
		white-space: nowrap;
	}

	::-webkit-scrollbar {
		width: 5px;
	}
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Iqama Renewal List</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/hr-module/iqama-renewal-list'); ?>">Iqama Renewal </a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<div class="btn-group ms-2 float-end">
						<button class="btn btn-custom-white btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="ti-import me-2"></i> Bulk Update <i class="mdi mdi-chevron-down"></i>
						</button>
						<div class="dropdown-menu dropdown-menu-end">
							<h6 class="dropdown-header">UPDATE AS</h6>
							<?php if (check_action_permission(get_user_role(), 'iqama_renewal_list', 'bulkUpdateIqamaRenewal')): ?>
								<a type="button" class="dropdown-item" title="Bulk Iqama Renewal" data-bs-toggle="modal" data-bs-target=".bulkImportModal">Bulk Iqama Renewal</a>
								<div class="dropdown-divider"></div>
							<?php endif; ?>
							<?php if (check_action_permission(get_user_role(), 'iqama_renewal_list', 'bulkProfessionUpdateModal')): ?>
								<a type="button" class="dropdown-item" title="Bulk Profession Update" data-bs-toggle="modal" data-bs-target=".professionUpdateModal">Bulk Profession Update</a>
								<div class="dropdown-divider"></div>
							<?php endif; ?>
							<?php if (check_action_permission(get_user_role(), 'iqama_renewal_list', 'bulkDriverCardUpdateModal')): ?>
								<a type="button" class="dropdown-item" title="Bulk Driver Card Update" data-bs-toggle="modal" data-bs-target=".driverCardUpdateModal">Bulk Driver Card Update</a>
							<?php endif; ?>
						</div>
					</div>
					<?php if (check_action_permission(get_user_role(), 'iqama_renewal_list', 'print_iqama_insurance_status') || check_action_permission(get_user_role(), 'iqama_renewal_list', 'exportIqamaToExcel')): ?>
						<div class="btn-group ms-2 float-end">
							<button class="btn btn-custom-white btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="ti-export me-2"></i> Export <i class="mdi mdi-chevron-down"></i>
							</button>
							<div class="dropdown-menu dropdown-menu-end">
								<h6 class="dropdown-header">EXPORT AS</h6>
								<?php if (check_action_permission(get_user_role(), 'iqama_renewal_list', 'print_iqama_insurance_status')): ?>
									<a type="button" class="dropdown-item" title="Performance Report" id="exportPdfBtn">PDF</a>
									<div class="dropdown-divider"></div>
								<?php endif; ?>
								<?php if (check_action_permission(get_user_role(), 'iqama_renewal_list', 'exportIqamaToExcel')): ?>
									<a type="button" class="dropdown-item" title="Performance Report" id="exportExcelBtn">Excel</a>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
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
					<div class="card-header">
						<h4 class="header-title mb-0">Search</h4>
					</div>
					<div class="card-body">
						<form action="<?php echo base_url('admin/hr-module/iqama-renewal-list'); ?>" method="get" id="filter_form">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Search by Emp. No. / Exmployee Name</label>
										<input type="search" name="keyword" placeholder="Search Emp. Nor or Exmployee Name" value="<?php echo $this->input->get('keyword') ?: ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>
								<!-- Batch No -->
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Iqama No.</label>
										<input type="search" name="iqama_no" placeholder="Search Iqama Number" value="<?php echo $this->input->get('iqama_no') ?: ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>

								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="date_range">Iqama Expiry Date Between:</label>
									<div class="input-daterange input-group" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#datepicker6">
										<input type="text" class="form-control" name="start_date" placeholder="Start Date" value="<?php echo $this->input->get('start_date'); ?>" autocomplete="off">
										<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
										<input type="text" class="form-control" name="end_date" placeholder="End Date" value="<?php echo $this->input->get('end_date'); ?>" autocomplete="off">
									</div>
								</div>
							</div>

							<?php
							$adv_show = !empty($this->input->get('employeer_id')) || !empty($this->input->get('iqama_status')) || !empty($this->input->get('nationality')) || !empty($this->input->get('designation'));
							?>

							<!-- Advanced Filter Section -->
							<div class="collapse <?php echo $adv_show ? 'show' : ''; ?>" id="advanceFilter">
								<div class="row">
									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label>Employeer ID</label>
											<select class="form-select select2" name="employeer_id" id="employeer_id">
												<option value="">Select Employer</option>
												<?php
												$selected_employeer = $this->input->get('employeer_id');
												if (count(sponsorsHelper()) > 0) {
													foreach (sponsorsHelper() as $sponsor) {
												?>
														<option value="<?php echo $sponsor['id']; ?>" data-id="<?php echo $sponsor['id']; ?>" <?php echo ($sponsor['id'] !== null && $sponsor['id'] == $selected_employeer) ? 'selected' : ''; ?>><?php echo $sponsor['employer_id'] . ' - ' . $sponsor['employer_name']; ?></option>
													<?php }
												} else { ?>
													<option value="" disabled>No Employer Found</option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label for="iqama_status">Iqama Status</label>
											<select name="iqama_status" class="form-control select2">
												<option value="">[Any Status]</option>
												<?php $iqama_status = trim($this->input->get('iqama_status')); ?>
												<option value="Expired" <?php echo ($iqama_status === 'Expired') ? 'selected' : ''; ?>>Expired</option>
												<option value="Expiring Soon" <?php echo ($iqama_status === 'Expiring Soon') ? 'selected' : ''; ?>>Expiring Soon</option>
												<option value="Valid" <?php echo ($iqama_status === 'Valid') ? 'selected' : ''; ?>>Valid</option>
											</select>
										</div>
									</div>
									<!-- Nationality -->
									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label for="nationality">Nationality</label>
											<select name="nationality" class="form-control select2">
												<option value="">[Any Nationality]</option>
												<?php $selected_nationality = $this->input->get('nationality'); ?>
												<?php foreach (nationalityList() as $mnationality): ?>
													<option value="<?php echo $mnationality->id; ?>"
														<?php echo ($selected_nationality !== null && $mnationality->id == $selected_nationality) ? 'selected' : ''; ?>>
														<?php echo $mnationality->name; ?>
													</option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>

									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label for="designation">Job Title</label>
											<select name="designation" class="form-control select2">
												<option value="">[Any Job Title]</option>
												<?php $selected_designation = $this->input->get('designation'); ?>
												<?php foreach (allDesignation() as $mjobtitle): ?>
													<option value="<?php echo $mjobtitle->id; ?>"
														<?php echo ($selected_designation !== null && $mjobtitle->id == $selected_designation) ? 'selected' : ''; ?>>
														<?php echo $mjobtitle->name; ?>
													</option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>

								</div>
							</div>

							<!-- Filter Buttons -->
							<div class="row mt-2">
								<div class="col-lg-6 col-md-6 col-sm-12">
									<button class="btn btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#advanceFilter" aria-expanded="false" aria-controls="advanceFilter">
										<i class="fas fa-sliders-h"></i> Advanced Search
									</button>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12">
									<button type="submit" class="btn btn-success float-end ms-2">Apply Filter</button>
									<a href="<?php echo base_url('admin/hr-module/iqama-renewal-list'); ?>" class="btn btn-danger float-end">Reset Filter</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<table id="iqamaListTable" class="table jambo_table bulk_action" style="width:100%">
							<thead>
								<tr>
									<th>#</th>
									<th>EMP No.</th>
									<th>Employee Name</th>
									<th>Job Title</th>
									<th>Profession</th>
									<th>Iqama No.</th>
									<th>Nationality</th>
									<th>Employeer ID</th>
									<th>Iqama Expiry Date</th>
									<th>Iqama Status</th>
									<th>Policy Expiry Date</th>
									<th>Policy Status</th>
									<th>DL Status</th>
									<th>Driver Card No.</th>
									<th>Driver Card Type</th>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<!-- Modal -->
<div class="modal fade bulkImportModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="bulkImportModalLabel">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title px-3" id="bulkImportModalLabel">Iqama Renewal</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="messageContainer" class="px-3"></div>
				<form id="delivery_bulk_form" method="post" enctype="multipart/form-data" autocomplete="off">
					<div class="row px-3">
						<div class="col-md-12 col-sm-12 mb-3 form-group">
							<label for="attachment">Excel File <span class="text-secondary">(Supported file format is: .xls .xlsx)</span></label>
							<input type="file" name="file" id="attachment" class="dropify" accept=".xls,.xlsx,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" data-max-file-size="2M" data-height="100" required>
						</div>
						<div class="col-md-12">
							<p class="text-secondary">Upload the same file format in (.xls) provided from Baqala Station to avoid any errors while importing your data.</p>
							<p style="text-align: center;"><a type="button" href="<?php echo base_url('admin_assets/samples/Iqama_Expiry_Bulk_Upload_Sample.xlsx'); ?>" class="btn bt btn-link text-success" target="_blank" download>Download sample file</a></p>
						</div>
						<div class="col-md-12 mb-3">
							<button type="save" id="btnUpload" class="btn btn-custom-success btn-md w-100">Import</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade professionUpdateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="professionUpdateModalLabel">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title px-3" id="professionUpdateModalLabel">Bulk Update Profession and Designation</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="messageProfessionContainer" class="px-3"></div>
				<form id="bulk_profession_form" method="post" enctype="multipart/form-data" autocomplete="off">
					<div class="row px-3">
						<div class="col-md-12 col-sm-12 mb-3 form-group">
							<label for="profession_attachment">Excel File <span class="text-secondary">(Supported file format is: .xls .xlsx)</span></label>
							<input type="file" name="file" id="profession_attachment" class="dropify" accept=".xls,.xlsx,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" data-max-file-size="2M" data-height="100" required>
						</div>
						<div class="col-md-12">
							<p class="text-secondary">Upload the same file format in (.xls) provided from Baqala Station to avoid any errors while importing your data.</p>
							<p style="text-align: center;"><a type="button" href="<?php echo base_url('admin_assets/samples/Profession_Bulk_Update_Sample.xlsx'); ?>" class="btn bt btn-link text-success" target="_blank" download>Download sample file</a></p>
						</div>
						<div class="col-md-12 mb-3">
							<button type="save" id="btnProfessionUpload" class="btn btn-custom-success btn-md w-100">Import</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<div class="modal fade driverCardUpdateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="driverCardUpdateModalLabel">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title px-3" id="driverCardUpdateModalLabel">Bulk Update Driver Card</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="messageDriverCardContainer" class="px-3"></div>
				<form id="bulk_driver_card_form" method="post" enctype="multipart/form-data" autocomplete="off">
					<div class="row px-3">
						<div class="col-md-12 col-sm-12 mb-3 form-group">
							<label for="driver_card_attachment">Excel File <span class="text-secondary">(Supported file format is: .xls .xlsx)</span></label>
							<input type="file" name="file" id="driver_card_attachment" class="dropify" accept=".xls,.xlsx,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" data-max-file-size="2M" data-height="100" required>
						</div>
						<div class="col-md-12">
							<p class="text-secondary">Upload the same file format in (.xls) provided from Baqala Station to avoid any errors while importing your data.</p>
							<p style="text-align: center;"><a type="button" href="<?php echo base_url('admin_assets/samples/Driver_Card_Bulk_Update_Sample.xlsx'); ?>" class="btn bt btn-link text-success" target="_blank" download>Download sample file</a></p>
						</div>
						<div class="col-md-12 mb-3">
							<button type="save" id="btnDriverCardUpload" class="btn btn-custom-success btn-md w-100">Import</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('admin/home/footer'); ?>
<script>
	function initializeDataTable(urlParams) {
		if ($.fn.DataTable.isDataTable('#iqamaListTable')) {
			$('#iqamaListTable').DataTable().destroy();
		}

		$('#iqamaListTable').DataTable({
			lengthMenu: [
				[25, 50, 100, 500],
				[25, 50, 100, 500]
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
			responsive: true,
			processing: true,
			searching: false,
			serverSide: true,
			fixedHeader: true,
			ajax: {
				url: "<?php echo base_url(); ?>admin/hr-module/iqama-renewal-list-ajax",
				type: "POST",
				data: function(d) {
					// Append GET parameters from URL
					d.keyword = urlParams.get('keyword');
					d.iqama_no = urlParams.get('iqama_no');
					d.start_date = urlParams.get('start_date');
					d.end_date = urlParams.get('end_date');
					d.employeer_id = urlParams.get('employeer_id');
					d.iqama_status = urlParams.get('iqama_status');
					d.nationality = urlParams.get('nationality');
					d.designation = urlParams.get('designation');
				}
			},
			columnDefs: [{
				targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
				orderable: false
			}, ],
			rowCallback: function(row, data, index) {
				const status = data[9] || ''; // prevent undefined

				if (status === 'Expired') {
					$(row).css('background-color', '#f8d7da');
				} else if (status === 'Expiring Soon') {
					$(row).css('background-color', '#ffe8bd');
				} else if (status.includes('Valid')) {
					$(row).css('background-color', '#d4edda');
				}
			}
		});
	}

	$(document).ready(function() {
		const urlParams = new URLSearchParams(window.location.search);
		initializeDataTable(urlParams);
	});

	$('#exportPdfBtn').click(function() {
		var params = new URLSearchParams(window.location.search);
		var form = $('<form>', {
			action: "<?php echo base_url('admin/hr-module/print-iqama-renewal-list'); ?>",
			method: 'POST',
			target: '_blank'
		});

		// Dynamic filters append करें
		form.append($('<input>').attr('type', 'hidden').attr('name', 'keyword').val(params.get('keyword')));
		form.append($('<input>').attr('type', 'hidden').attr('name', 'start_date').val(params.get('start_date')));
		form.append($('<input>').attr('type', 'hidden').attr('name', 'end_date').val(params.get('end_date')));
		form.append($('<input>').attr('type', 'hidden').attr('name', 'iqama_status').val(params.get('iqama_status')));
		form.append($('<input>').attr('type', 'hidden').attr('name', 'employeer_id').val(params.get('employeer_id')));
		form.append($('<input>').attr('type', 'hidden').attr('name', 'nationality').val(params.get('nationality')));
		form.append($('<input>').attr('type', 'hidden').attr('name', 'designation').val(params.get('designation')));

		$('body').append(form);
		form.submit();
		form.remove();
	});

	$('#exportExcelBtn').click(function() {
		var params = new URLSearchParams(window.location.search);
		var form = $('<form>', {
			action: "<?php echo base_url('admin/hr-module/export-iqama-renewal-list'); ?>",
			method: 'POST',
			target: '_blank'
		});

		// Dynamic filters append
		form.append($('<input>').attr('type', 'hidden').attr('name', 'keyword').val(params.get('keyword')));
		form.append($('<input>').attr('type', 'hidden').attr('name', 'start_date').val(params.get('start_date')));
		form.append($('<input>').attr('type', 'hidden').attr('name', 'end_date').val(params.get('end_date')));
		form.append($('<input>').attr('type', 'hidden').attr('name', 'iqama_status').val(params.get('iqama_status')));
		form.append($('<input>').attr('type', 'hidden').attr('name', 'employeer_id').val(params.get('employeer_id')));
		form.append($('<input>').attr('type', 'hidden').attr('name', 'nationality').val(params.get('nationality')));
		form.append($('<input>').attr('type', 'hidden').attr('name', 'designation').val(params.get('designation')));

		$('body').append(form);
		form.submit();
		form.remove();
	});
	
	$('.dropify').dropify();

	$(document).ready(function() {
		$("body").on("submit", "#delivery_bulk_form", function(e) {
			e.preventDefault();
			var data = new FormData(this);
			$.ajax({
				type: 'POST',
				url: "<?php echo base_url('admin/hr-module/bulk-update-iqama-renewal') ?>",
				data: data,
				//dataType: 'json',
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function() {
					$("#btnUpload").prop('disabled', true);
					$("#btnUpload").html('<i class="fa fa-spinner fa-spin"></i> <small>Please wait ...</small>');
				},
				success: function(response) {
					//console.log(response);
					$("#btnUpload").prop('disabled', false);
					$("#btnUpload").html('Import');
					$("#attachment").val('');
					var jsonResponse = JSON.parse(response);
					if (jsonResponse.error_message) {
						$('#messageContainer').html('<p style="color: red;">Error: ' + jsonResponse.error_message + '</p>');
					} else if (jsonResponse.success_message) {
						$('#messageContainer').html('<p style="color: green;">Success: ' + jsonResponse.success_message + '</p>');
						setTimeout(function() {
							location.reload();
						}, 1000);
					} else {
						$('#messageContainer').html('<p style="color: red;">Error: Something went wrong, Try again!</p>');
					}
					//initializeDataTable();
				},
				error: function(xhr, status, error) {
					//console.log(error);
					$("#btnUpload").prop('disabled', false);
					$("#btnUpload").html('Import');
					$('#messageContainer').html('<p style="color: red;">Error: ' + error + '</p>');
				}
			});
		});

		$("body").on("submit", "#bulk_profession_form", function(e) {
			e.preventDefault();
			var data = new FormData(this);
			$.ajax({
				type: 'POST',
				url: "<?php echo base_url('admin/hr-module/bulk-update-profession') ?>",
				data: data,
				//dataType: 'json',
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function() {
					$("#btnProfessionUpload").prop('disabled', true);
					$("#btnProfessionUpload").html('<i class="fa fa-spinner fa-spin"></i> <small>Please wait ...</small>');
				},
				success: function(response) {
					//console.log(response);
					$("#btnProfessionUpload").prop('disabled', false);
					$("#btnProfessionUpload").html('Import');
					$("#attachment").val('');
					var jsonResponse = JSON.parse(response);
					if (jsonResponse.error_message) {
						$('#messageProfessionContainer').html('<p style="color: red;">Error: ' + jsonResponse.error_message + '</p>');
					} else if (jsonResponse.success_message) {
						$('#messageProfessionContainer').html('<p style="color: green;">Success: ' + jsonResponse.success_message + '</p>');
						setTimeout(function() {
							location.reload();
						}, 1000);
					} else {
						$('#messageProfessionContainer').html('<p style="color: red;">Error: Something went wrong, Try again!</p>');
					}
					//initializeDataTable();
				},
				error: function(xhr, status, error) {
					//console.log(error);
					$("#btnProfessionUpload").prop('disabled', false);
					$("#btnProfessionUpload").html('Import');
					$('#messageProfessionContainer').html('<p style="color: red;">Error: ' + error + '</p>');
				}
			});
		});
		
				$("body").on("submit", "#bulk_driver_card_form", function(e) {
			e.preventDefault();
			var data = new FormData(this);
			$.ajax({
				type: 'POST',
				url: "<?php echo base_url('admin/hr-module/bulk-update-driver-card') ?>",
				data: data,
				//dataType: 'json',
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function() {
					$("#btnDriverCardUpload").prop('disabled', true);
					$("#btnDriverCardUpload").html('<i class="fa fa-spinner fa-spin"></i> <small>Please wait ...</small>');
				},
				success: function(response) {
					//console.log(response);
					$("#btnDriverCardUpload").prop('disabled', false);
					$("#btnDriverCardUpload").html('Import');
					$("#attachment").val('');
					var jsonResponse = JSON.parse(response);
					if (jsonResponse.error_message) {
						$('#messageDriverCardContainer').html('<p style="color: red;">Error: ' + jsonResponse.error_message + '</p>');
					} else if (jsonResponse.success_message) {
						$('#messageDriverCardContainer').html('<p style="color: green;">Success: ' + jsonResponse.success_message + '</p>');
						setTimeout(function() {
							location.reload();
						}, 1000);
					} else {
						$('#messageDriverCardContainer').html('<p style="color: red;">Error: Something went wrong, Try again!</p>');
					}
					//initializeDataTable();
				},
				error: function(xhr, status, error) {
					//console.log(error);
					$("#btnDriverCardUpload").prop('disabled', false);
					$("#btnDriverCardUpload").html('Import');
					$('#messageDriverCardContainer').html('<p style="color: red;">Error: ' + error + '</p>');
				}
			});
		});
	});
</script>