<div class="modal-header">
	<h5 class="modal-title px-3" id="filtersModalLabel"><?= $filter_title ?></h5>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
	<form action="<?php echo base_url('admin/hr/attendance/print-attendance-report/' . $monthParam); ?>" method="get" id="applyFiltersBtn" target="_blank">
		<div class="row">
			<div class="col-md-12 mb-2">
				<label for="reportrange">Select Date Range</label>
				<div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
					<i class="fa fa-calendar"></i>&nbsp;
					<span></span> <i class="fa fa-caret-down"></i>
				</div>
				<input type="hidden" name="date_from" id="dateFrom" />
				<input type="hidden" name="date_to" id="dateTo" />
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="form-group mb-2">
					<label>Search Employee</label>
					<select class="form-control" class="form-control" placeholder="Search by Emp. Name or Emp. ID" aria-label="Employee Number" name="keyword" id="filter_keyword" aria-describedby="button-addon2">
						<option value="">Search Employee Name or Emp No...</option>
					</select>
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="form-group mb-2">
					<label>Employer</label>
					<select name="employer" id="filter_employer" class="form-select">
						<option value="">[ All Employer ]</option>
						<?php foreach (sponsorsHelper() as $sponsor) { ?>
							<option value="<?php echo $sponsor['id']; ?>" <?php echo ($sponsor['id'] == $this->input->get('employer')) ? ' selected ' : ''; ?>><?php echo $sponsor['employer_name']; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="form-group mb-2">
					<label>Team</label>
					<select name="team" id="filter_team" class="form-select">
						<option value="">[ All Team]</option>
						<?php foreach ($teams as $mteam) { ?>
							<option value="<?php echo $mteam->name; ?>" <?php echo ($mteam->name == $this->input->get('team')) ? ' selected ' : ''; ?>><?php echo $mteam->name; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="form-group mb-2">
					<label>Aggregator</label>
					<select name="platform" id="filter_platform" class="form-select">
						<option value="">[ All Aggregator ]</option>
						<?php foreach (fdCompanyHelper() as $fdcompany) { ?>
							<option value="<?php echo $fdcompany->id; ?>" <?php echo ($fdcompany->id == $this->input->get('platform')) ? ' selected ' : ''; ?>><?php echo $fdcompany->company_name; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="form-group mb-2">
					<label>Vehicle No.</label>
					<input type="search" id="filter_vehicle_no" name="vehicle_no" placeholder="Search by Vehicle No. etc." value="<?php echo $this->input->get('vehicle_no') ? $this->input->get('vehicle_no') : ''; ?>" autocomplete="off" class="form-control">
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="form-group mb-2">
					<label>Vehicle Type</label>
					<select name="vehicle_type" id="filter_vehicle_type" class="form-control select2">
						<option value="">[Any Type]</option>
						<option value="bike" <?php echo ($this->input->get('attendance_type') == 'bike') ? "selected" : ""; ?>>Bike</option>
						<option value="car" <?php echo ($this->input->get('attendance_type') == 'car') ? "selected" : ""; ?>>Car</option>
					</select>
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="form-group mb-2">
					<label>Compliance Wise</label>
					<select name="compliance_wise" id="filter_compliance_wise" class="form-control select2">
						<option value="">[Any Type]</option>
						<option value="1" <?php echo ($this->input->get('compliance_wise') == '1') ? "selected" : ""; ?>>26 Days Present</option>
						<option value="2" <?php echo ($this->input->get('compliance_wise') == '2') ? "selected" : ""; ?>>9+ Hours Present</option>
						<option value="3" <?php echo ($this->input->get('compliance_wise') == '3') ? "selected" : ""; ?>>No Week off (Thursday, Friday & Saturday)</option>
						<option value="4" <?php echo ($this->input->get('compliance_wise') == '4') ? "selected" : ""; ?>>No Off in Last Week</option>
						<option value="5" <?php echo ($this->input->get('compliance_wise') == '5') ? "selected" : ""; ?>>Riders With 450+ Orders</option>
					</select>
				</div>
			</div>
		</div>
	</form>
</div>
<div class="modal-footer">
	<a href="<?php echo base_url('admin/hr/attendance/detail/' . $monthParam); ?>" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</a>
	<button type="submit" form="applyFiltersBtn" class="btn btn-custom-success">Print Report</button>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		// Show reset button if any filter/search is applied
		function checkFilters() {
			const search = $('#filter_keyword').val();
			const attendanceType = $('#filter_attendance_type').val();
			const Platform = $('#filter_platform').val();
			const Employer = $('#filter_employer').val();
			const Team = $('#filter_team').val();
			const vehicleNo = $('#filter_vehicle_no').val();
			const vehicleType = $('#filter_vehicle_type').val();
			const reportRange = $('#reportrange span').html();
			const dateFrom = $('#dateFrom').val();
			const dateTo = $('#dateTo').val();

			if (search || attendanceType || Platform || Employer || Team || vehicleNo || vehicleType || reportRange || dateFrom || dateTo) {
				$('#resetFilters').show();
			} else {
				$('#resetFilters').hide();
			}
		}

		// Initial check
		checkFilters();

		// Run on filter change
		$('#filter_keyword, #filter_attendance_type, #filter_platform, #filter_employer, #filter_team, #filter_vehicle_no, #filter_vehicle_type, #reportrange, #dateFrom, #dateTo').on('input change', function() {
			checkFilters();
		});

		// Reset filters
		$('#resetFilters').click(function() {
			window.location.href = "<?php echo base_url('admin/hr/attendance/detail/' . $monthParam); ?>"
			$(this).hide();
		});
	});

	$(function() {
		var monthParam = "<?php echo trim($monthParam); ?>";
		
		// Normalize monthParam
		var monthMoment = moment(monthParam, ['YYYY-MM', 'YYYY-MM-DD']);
		var monthStart = monthMoment.clone().startOf('month');
		var monthEnd = monthMoment.clone().endOf('month');

		// Initial default
		var start = monthStart.clone();
		var end = monthEnd.clone();

		function cb(start, end) {
			$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
			$('#dateFrom').val(start.format('YYYY-MM-DD'));
			$('#dateTo').val(end.format('YYYY-MM-DD'));
			// ✅ Trigger change event so reset button shows
			$('#dateFrom, #dateTo').trigger('change');
		}

		// Detect current month
		var currentYearMonth = moment().format('YYYY-MM');
		var pageYearMonth = monthMoment.format('YYYY-MM');
		var isCurrentMonth = (pageYearMonth === currentYearMonth);

		// Base configuration
		var config = {
			startDate: start,
			endDate: end,
			minDate: monthStart, // ✅ Limit start
			maxDate: monthEnd,   // ✅ Limit end
			autoUpdateInput: false,
			locale: { cancelLabel: 'Clear' },
			showCustomRangeLabel: true // ✅ Show "Custom Range"
		};

		if (isCurrentMonth) {
			// ✅ Current month: flexible ranges but within month
			config.ranges = {
				'Today': [moment(), moment()],
				'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				'Last 7 Days': [moment().subtract(6, 'days'), moment()],
				'Last 30 Days': [moment().subtract(29, 'days'), moment()],
				'This Month': [monthStart, monthEnd],
			};
		} else {
			// 🧭 Past/Future month: only within that month
			config.ranges = {
				'Full Month': [monthStart, monthEnd],
				'First Half': [monthStart, monthStart.clone().add(14, 'days')],
				'Second Half': [monthStart.clone().add(15, 'days'), monthEnd],
			};
		}

		// Initialize the picker
		$('#reportrange').daterangepicker(config, cb);
		cb(start, end);

		// Clear button
		$('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
			$(this).find('span').html('');
			$('#dateFrom').val('');
			$('#dateTo').val('');
		});
	});

	$(document).ready(function () {
		// =================== Employee Search ===================
		$('#filter_keyword').select2({
			placeholder: 'Search Employee Name or Emp No...',
			allowClear: true,
			minimumInputLength: 3,
			dropdownParent: $('#filtersModal'),
			ajax: {
				url: "<?php echo base_url('admin/logistic-management/Cash_collection/search_employee'); ?>",
				type: 'GET',
				dataType: 'json',
				delay: 250,
				data: function(params) {
					return { search: params.term };
				},
				processResults: function(data) {
					return {
						results: $.map(data, function(item) {
							return {
								id: item.id,
								text: item.emp_no + ' - ' + item.full_name
							};
						})
					};
				}
			}
		});

		// Preselect employee if already chosen
		var selectedEmployee = "<?php echo $this->input->get('keyword'); ?>";
		if (selectedEmployee) {
			$.ajax({
				url: "<?php echo base_url('admin/logistic-management/Cash_collection/search_employee'); ?>",
				type: "GET",
				data: { search: selectedEmployee },
				dataType: 'json',
				success: function (data) {
					let item = data.find(emp => emp.id === selectedEmployee);
					if (item) {
						var option = new Option(item.emp_no + " - " + item.full_name, item.id, true, true);
						$('#filter_keyword').append(option).trigger('change');
					}
				}
			});
		}
	});
</script>