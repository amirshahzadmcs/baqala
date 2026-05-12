<?php $this->load->view('admin/home/header'); ?>
<style> 
@media only screen and (max-width: 600px) {
    .modal-dialog-aside {
        width: 100% !important;
        max-width: 100% !important;
    }

    .employee-detail {
        display: block !important;
    }

    .employee-detail .image {
        text-align: center;
        margin-top: 10px;
    }
}

.modal-dialog-aside {
    width: 30%;
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
#vehicleLogTable thead tr th, #vehicleLogTable tbody tr td {
    white-space: nowrap;
}
.dropdown-item.active, .dropdown-item:active {
    color: #16181b;
    text-decoration: none;
    background-color: #f3f3f3;
}
a.dt-button.dropdown-item.buttons-columnVisibility.active:after {
    position: absolute;
    margin-top: 0px;
    right: 0.5em;
    display: inline-block;
    content: "\2713";
    color: inherit;
}
</style>
<!-- start page title -->
<div class="page-title-box">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-title">
                    <h4>Master Vehicle Log</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/master-vehicle/list'); ?>">Master Vehicle</a></li>
                        <li class="breadcrumb-item active">Logs</li>
                    </ol>
                </div>
            </div>
            <?php $admin_id = $this->session->userdata('admin_id'); ?>
            <div class="col-sm-6">
                <div class="float-end d-sm-block">
                    <a class="btn btn-sm btn-custom-white pull-right me-2" title="Back" href="<?php echo base_url();?>admin/master-vehicle/list"><i class="fa fa-reply"></i> Back</a>
                    <button type="button" class="btn btn-sm btn-custom-white pull-right me-2" title="Export" id="exportExcelBtn"><i class="fa fa-file-excel"></i> Export Excel</button>
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
                    <?php } else { ?>
                        <div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <strong><?php echo $msg_data; ?></strong>
                        </div>
                    <?php } ?> <?php } $this->admin->removeInfo(); ?>
                <!-- </div> -->
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
                    <div class="card-body" style="overflow-x: scroll;">
                        <div class="d-flex align-items-center justify-content-between position-relative float-end mb-2" style="max-width: 480px;">
							<button class="btn btn-secondary btn-sm ms-2 font-size-15" id="btnSearch" type="button" style="height: 30px;line-height: 15px;" data-bs-toggle="modal" data-bs-target="#filtersModal">
								<i class="mdi mdi-filter-variant font-size-18"></i> Filters
							</button>
							<button id="resetFilters" class="btn btn-outline-danger btn-sm ms-2 font-size-15 resetFilters" style="height: 30px;line-height: 15px; display: none;">
								<i class="mdi mdi-filter-remove-outline font-size-18"></i> Reset
							</button>
						</div>
                        <table id="vehicleLogTable" class="table table-striped table-bordered jambo_table bulk_action">
							<thead>
								<tr>
									<th>Sr. No</th>
									<th>EMP ID</th>
									<th>EMP Name</th>
									<th>Iqama / ID No</th>
									<th>Designation Name</th>
									<th>Department</th>
									<th>Vehicle Type</th>
									<th>Vehicle No.</th>
									<th>Vehicle Make</th>
									<th>Vehicle Model</th>
									<th>Vehicle Color</th>
									<th>Vehicle Chassis No.</th>
									<th>Vehicle Sequel No.</th>
									<th>Vehicle Year</th>
									<th>Vehicle Status</th>
									<th>Status Date</th>
									<th>Log Status</th>
									<th>Ownership Type</th>
									<th>Tamm Auth./Cancl.</th>
								</tr>
							</thead>
							<tbody>
								<!-- Data will be populated by DataTables -->

							</tbody>
						</table>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
</div>
<!-- container-fluid -->

<div class="modal fade staticBackdrop fixed-left filtersModal" id="filtersModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="#filtersModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title px-3" id="filtersModalLabel">Filters</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url('admin/master-vehicle/all-logs'); ?>" method="get" id="applyFiltersBtn">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-2">
								<label>Vehicle No.</label>
                                <select name="vehicle_no" id="filter_vehicle_no" class="form-control select2 select2-ajax" data-filter-type="vehicle_no" data-selected="<?php echo $this->input->get('vehicle_no'); ?>">
                                    <option value="">[Any Vehicle No.]</option>
                                    <?php if ($this->input->get('vehicle_no')) { ?>
                                        <option value="<?php echo $this->input->get('vehicle_no'); ?>" selected>
                                            <?php echo $this->input->get('vehicle_no'); ?>
                                        </option>
                                    <?php } ?>
                                </select>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-2">
								<label>Sequel No.</label>
                                <select name="sequel_no" id="filter_sequel_no" class="form-control select2 select2-ajax" data-filter-type="sequel_no" data-selected="<?php echo $this->input->get('sequel_no'); ?>">
                                    <option value="">[Any Sequel No.]</option>
                                    <?php if ($this->input->get('sequel_no')) { ?>
                                        <option value="<?php echo $this->input->get('sequel_no'); ?>" selected>
                                            <?php echo $this->input->get('sequel_no'); ?>
                                        </option>
                                    <?php } ?>
                                </select>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-2">
								<label>Type</label>
                                <select name="vehicle_type" id="filter_vehicle_type" class="form-control select2">
                                    <option value="">[Any Vehicle Type]</option>
                                    <option value="bike" <?php echo ($this->input->get('vehicle_type') == 'bike') ? "selected" : ""; ?>>Bike</option>
                                    <option value="car" <?php echo ($this->input->get('vehicle_type') == 'car') ? "selected" : ""; ?>>Car</option>
                                </select>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-2">
								<label>Make</label>
                                <select name="vehicle_make" id="filter_vehicle_make" class="form-control select2">
                                    <option value="">[Any Make]</option>
                                    <?php foreach (makeList() as $vmake) { ?>
                                        <option value="<?php echo $vmake->id; ?>" <?php echo ($this->input->get('vehicle_make') == $vmake->id) ? "selected" : ""; ?>><?php echo $vmake->make_name; ?></option>
                                    <?php } ?>
                                </select>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-2">
								<label>Model</label>
                                <select name="vehicle_model" id="filter_vehicle_model" class="form-control select2 select2-ajax" data-filter-type="vehicle_model" data-selected="<?php echo $this->input->get('vehicle_model'); ?>">
                                    <option value="">[Any Model]</option>
                                    <?php if ($this->input->get('vehicle_model')) { ?>
                                        <option value="<?php echo $this->input->get('vehicle_model'); ?>" selected>
                                            <?php echo $this->input->get('vehicle_model'); ?>
                                        </option>
                                    <?php } ?>
                                </select>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-2">
								<label class="control-label" for="vehicle_color">Color </label>
                                <select name="vehicle_color" id="filter_vehicle_color" class="form-control select2">
                                    <option value="">[Any Color]</option>
                                    <?php foreach (colorList() as $color) { ?>
                                        <option value="<?php echo $color->id; ?>" <?php echo ($this->input->get('vehicle_color') == $color->id) ? "selected" : ""; ?>><?php echo $color->color_name; ?></option>
                                    <?php } ?>
                                </select>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group mb-2">
                                <label class="control-label" for="vehicle_year">Year </label>
								<select name="vehicle_year" id="filter_vehicle_year" class="form-control select2">
                                    <option value="">[Any Year]</option>
                                    <?php
                                    //$year_start  = 2001;
                                    $year_start  = (date('Y') - 20);
                                    $year_end = date('Y'); // current Year
                                    $vehicle_year = $this->input->get('vehicle_year'); // user selected date

                                    for ($i_year = $year_end; $i_year >= $year_start; $i_year--) {
                                        $selected = ($vehicle_year == $i_year ? ' selected' : '');
                                        echo '<option value="' . $i_year . '"' . $selected . '>' . $i_year . '</option>' . "\n";
                                    }
                                    ?>
                                </select>
							</div>
						</div>
						<div class="col-md-12 mb-3">
							<label>Status</label>
                            <select name="status" id="filter_status" class="form-select select2">
                                <option value="">[Any Status]</option>
                                <option value="alloted" <?php echo ($this->input->get('status') == 'alloted') ? "selected" : ""; ?>>Alloted</option>
                                <option value="unalloted" <?php echo ($this->input->get('status') == 'unalloted') ? "selected" : ""; ?>>Unalloted</option>
                                <option value="return" <?php echo ($this->input->get('status') == 'return') ? "selected" : ""; ?>>Return</option>
                            </select>
						</div>

						<div class="col-md-12 mb-3">
							<label>Alloted To</label>
                            <select name="alloted_user" id="filter_alloted_user" class="form-select select2 select2-ajax" data-filter-type="alloted_user" data-selected="<?php echo $this->input->get('alloted_user'); ?>">
                                <option value="">[Any Alloted]</option>
                                <?php if ($this->input->get('alloted_user')) {
                                    $allotedUserId = $this->input->get('alloted_user');
                                    $allotedUserName = employeeDetailHelper($allotedUserId);
                                ?>
                                    <option value="<?php echo $allotedUserId; ?>" selected>
                                        <?php echo $allotedUserName->full_name; ?>
                                    </option>
                                <?php } ?>
                            </select>
						</div>
						<div class="col-md-12 mb-3">
							<label>Vehicle Ownership</label>
                            <select name="vehicle_ownership" id="filter_vehicle_ownership" class="form-control select2">
                                <option value="">[Any Ownership]</option>
                                <option value="Owned" <?php echo ($this->input->get('vehicle_ownership') == 'Owned') ? "selected" : ""; ?>>Owned</option>
                                <option value="Lease" <?php echo ($this->input->get('vehicle_ownership') == 'Lease') ? "selected" : ""; ?>>Lease</option>
                            </select>
						</div>
						<div class="col-md-12 mb-3">
							<label>Added Date (From and To)</label>
                            <div class="input-daterange input-group" id="datepicker6" data-date-format="dd-m-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                <input type="text" class="form-control" id="_from" name="from" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" autocomplete="off" placeholder="Start Date" />
                                <input type="text" class="form-control" id="_to" name="to" value="<?php echo $this->input->get('to') ? $this->input->get('to') : ''; ?>" autocomplete="off" placeholder="End Date" />
                            </div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary resetFilters" data-bs-dismiss="modal">Cancel</button>
				<button type="submit" form="applyFiltersBtn" class="btn btn-custom-success">Apply Filters</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php $this->load->view('admin/home/footer'); ?>

<script>
    $(document).ready(function () {
		var table = $('#vehicleLogTable').DataTable({
			"lengthMenu": [
				[25, 50, 100, 500],
				[25, 50, 100, 500]
			],
			dom: 'Blfrtip',
			buttons: [
				{ extend: "csv", className: "btn-md" },
				{ extend: "excel", className: "btn-md" },
				{ extend: "pdfHtml5", className: "btn-md" },
				//{ extend: "colvis", className: "btn-md" }
			],
			"processing": true,
			"serverSide": true,
			"ajax": {
				url: "<?php echo base_url(); ?>admin/master-vehicle/log-list?vehicle_no=<?php echo $this->input->get('vehicle_no'); ?>&sequel_no=<?php echo $this->input->get('sequel_no'); ?>&vehicle_type=<?php echo $this->input->get('vehicle_type'); ?>&vehicle_make=<?php echo $this->input->get('vehicle_make'); ?>&vehicle_model=<?php echo $this->input->get('vehicle_model'); ?>&vehicle_color=<?php echo $this->input->get('vehicle_color'); ?>&vehicle_year=<?php echo $this->input->get('vehicle_year'); ?>&status=<?php echo $this->input->get('status'); ?>&alloted_user=<?php echo $this->input->get('alloted_user'); ?>&vehicle_ownership=<?php echo $this->input->get('vehicle_ownership'); ?>&from=<?php echo $this->input->get('from'); ?>&to=<?php echo $this->input->get('to'); ?>",
				type: "POST"
			},
			"responsive": false,
			"fixedHeader": true,
			"order": [],
			"columnDefs": [
				{ "targets": [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18], "orderable": false }
			]
		});
		/*
		// Load visibility state from localStorage
		var colState = localStorage.getItem('vehicleLog_columns');
		if (colState) {
			var visibility = JSON.parse(colState);
			table.columns().every(function (index) {
				this.visible(visibility[index] !== false);
			});
		}

		// Save visibility when user toggles columns
		table.on('column-visibility.dt', function () {
			var visArray = [];
			table.columns().every(function (index) {
				visArray[index] = this.visible();
			});
			localStorage.setItem('vehicleLog_columns', JSON.stringify(visArray));
		});
		*/
	});


    $(document).ready(function() {
		// Show reset button if any filter/search is applied
		function checkFilters() {
			const vehicleNo = $('#filter_vehicle_no').val();
			const sequelNo = $('#filter_sequel_no').val();
			const vehicleType = $('#filter_vehicle_type').val();
			const vehicleMake = $('#filter_vehicle_make').val();
			const vehicleModel = $('#filter_vehicle_model').val();
			const vehicleColor = $('#filter_vehicle_color').val();
			const vehicleYear = $('#filter_vehicle_year').val();
			const status = $('#filter_status').val();
			const allotedUser = $('#filter_alloted_user').val();
			const vehicleOwnership = $('#filter_vehicle_ownership').val();
			const dateFrom = $('#_from').val();
			const dateTo = $('#_to').val();

			if (vehicleNo || sequelNo || vehicleType || vehicleMake || vehicleModel || vehicleColor || vehicleYear || status || allotedUser || vehicleOwnership || dateFrom || dateTo) {
				$('#resetFilters').show();
			} else {
				$('#resetFilters').hide();
			}
		}

		// Initial check
		checkFilters();

		// Run on filter change
		$('#filter_vehicle_no, #filter_sequel_no, #filter_vehicle_type, #filter_vehicle_make, #filter_vehicle_model, #filter_vehicle_color, #filter_vehicle_year, #filter_status, #filter_alloted_user, #filter_vehicle_ownership, #_from, #_to').on('input change', function() {
			checkFilters();
		});

		// Reset filters
		$('.resetFilters').click(function() {
			window.location.href = "<?php echo base_url('admin/master-vehicle/all-logs'); ?>"
			$(this).hide();
		});
	});

    // <!-- Global AJAX Function for all filters -->
	$('.select2-ajax').each(function() {
		var $this = $(this);
		var filterType = $this.data('filter-type');
		var selectedValue = $this.data('selected'); // Get selected value from data attribute

		$this.select2({
			placeholder: '[Any ' + filterType.charAt(0).toUpperCase() + filterType.slice(1) + ']',
			minimumInputLength: 2,
			ajax: {
				url: '<?php echo base_url('admin/master-vehicle/fetch-filter-data'); ?>',
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
						if (filterType === 'vehicle_no') {
							textField = item.vehicle_no;
						} else if (filterType === 'sequel_no') {
							textField = item.sequel_no;
						} else if (filterType === 'vehicle_model') {
							textField = item.vehicle_model;
						} else if (filterType === 'vehicle_year') {
							textField = item.year_name;
						} else if (filterType === 'alloted_user') {
							textField = item.full_name;
						}

						return {
							id: item.key_value, // Use key_value or actual ID field from DB
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

	$(document).ready(function () {
		$('#exportExcelBtn').on('click', function (e) {
			e.preventDefault();

			// Build query string from filter IDs (same as reset script)
			let params = {
				vehicle_no: $('#filter_vehicle_no').val(),
				sequel_no: $('#filter_sequel_no').val(),
				vehicle_type: $('#filter_vehicle_type').val(),
				vehicle_make: $('#filter_vehicle_make').val(),
				vehicle_model: $('#filter_vehicle_model').val(),
				vehicle_color: $('#filter_vehicle_color').val(),
				vehicle_year: $('#filter_vehicle_year').val(),
				status: $('#filter_status').val(),
				alloted_user: $('#filter_alloted_user').val(),
				vehicle_ownership: $('#filter_vehicle_ownership').val(),
				from: $('#_from').val(),
				to: $('#_to').val()
			};

			// Convert params to query string
			let queryString = $.param(params);

			// Redirect to export URL with query params
			let exportUrl = "<?php echo base_url('admin/master-vehicle/export-logs'); ?>?" + queryString;
			window.open(exportUrl, '_blank');
		});
	});

	$(document).ready(function() {
		var $ownerSelect = $('select[name="owner_select"]');
		var $vehicleOwnership = $('select[name="vehicle_ownership"]');

		// Backup all sponsor options (except the placeholder)
		var sponsorOptions = $ownerSelect.find('option').not(':first').clone();

		// Get owner from PHP GET for pre-selection
		var selectedOwner = "<?php echo $this->input->get('owner_select', true); ?>";

		function updateOwnerOptions() {
			var ownership = $vehicleOwnership.val();

			$ownerSelect.empty();
			$ownerSelect.append('<option value="">Any Owner</option>');

			if (ownership === 'Lease') {
				var theebOption = sponsorOptions.filter(function() {
					return $(this).val().trim() === 'Theeb Rent a Car';
				});

				if (theebOption.length > 0) {
					var cloned = theebOption.clone();
					$ownerSelect.append(cloned);
				} else {
					$ownerSelect.append('<option value="Theeb Rent a Car">Theeb Rent a Car</option>');
				}

				$ownerSelect.val('Theeb Rent a Car');
				$ownerSelect.prop('readonly', true);

			} else if (ownership === 'Owned') {
				$ownerSelect.append(sponsorOptions.clone());
				
				if (selectedOwner !== '') {
					$ownerSelect.val(selectedOwner);
				}

				$ownerSelect.prop('readonly', false);

			} else {
				// No ownership selected or unhandled type
				$ownerSelect.prop('readonly', true);
			}
		}

		// Trigger update when vehicle ownership changes
		$vehicleOwnership.on('change', function() {
			updateOwnerOptions();
		});

		// Run once on page load
		updateOwnerOptions();
	});
</script>
