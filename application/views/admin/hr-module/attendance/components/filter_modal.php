<div class="modal-header">
	<h5 class="modal-title px-3" id="filtersModalLabel"><?= $filter_title ?></h5>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
	<form action="<?php echo base_url('admin/hr/attendance/detail/' . $monthParam); ?>" method="get" id="applyFiltersBtn">
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
					<label>Attendance Type</label>
					<select name="attendance_type" id="filter_attendance_type" class="form-control select2">
						<option value="">[Any Type]</option>
						<option value="A" <?php echo ($this->input->get('attendance_type') == 'A') ? 'selected' : ''; ?>>A - Absent</option>
						<option value="L" <?php echo ($this->input->get('attendance_type') == 'L') ? 'selected' : ''; ?>>L - Leave</option>
						<option value="P" <?php echo ($this->input->get('attendance_type') == 'P') ? 'selected' : ''; ?>>P - Present</option>
						<option value="AC" <?php echo ($this->input->get('attendance_type') == 'AC') ? 'selected' : ''; ?>>AC - Accident</option>
						<option value="AL" <?php echo ($this->input->get('attendance_type') == 'AL') ? 'selected' : ''; ?>>AL - Annual Leave</option>
						<option value="BT" <?php echo ($this->input->get('attendance_type') == 'BT') ? 'selected' : ''; ?>>BT - Business Trip</option>
						<option value="CL" <?php echo ($this->input->get('attendance_type') == 'CL') ? 'selected' : ''; ?>>CL - Casual Leave</option>
						<option value="COL" <?php echo ($this->input->get('attendance_type') == 'COL') ? 'selected' : ''; ?>>COL - Compassionate Leave</option>
						<option value="HI" <?php echo ($this->input->get('attendance_type') == 'HI') ? 'selected' : ''; ?>>HI - Health Issue</option>
						<option value="ID" <?php echo ($this->input->get('attendance_type') == 'ID') ? 'selected' : ''; ?>>ID - ID Issue</option>
						<option value="IQ" <?php echo ($this->input->get('attendance_type') == 'IQ') ? 'selected' : ''; ?>>IQ - Iqama Issue</option>
						<option value="MAR" <?php echo ($this->input->get('attendance_type') == 'MAR') ? 'selected' : ''; ?>>MAR - Marriage Leave</option>
						<option value="MI" <?php echo ($this->input->get('attendance_type') == 'MI') ? 'selected' : ''; ?>>MI - Mobile Issue</option>
						<option value="ML" <?php echo ($this->input->get('attendance_type') == 'ML') ? 'selected' : ''; ?>>ML - Maternity Leave</option>
						<option value="PL" <?php echo ($this->input->get('attendance_type') == 'PL') ? 'selected' : ''; ?>>PL - Paternity Leave</option>
						<option value="SI" <?php echo ($this->input->get('attendance_type') == 'SI') ? 'selected' : ''; ?>>SI - Sponsorship Issue</option>
						<option value="SL" <?php echo ($this->input->get('attendance_type') == 'SL') ? 'selected' : ''; ?>>SL - Sick Leave</option>
						<option value="UL" <?php echo ($this->input->get('attendance_type') == 'UL') ? 'selected' : ''; ?>>UL - Unpaid Leave</option>
						<option value="WL" <?php echo ($this->input->get('attendance_type') == 'WL') ? 'selected' : ''; ?>>WL - Widow Leave</option>
						<option value="WO" <?php echo ($this->input->get('attendance_type') == 'WO') ? 'selected' : ''; ?>>WO - Week Off</option>
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
			
		</div>
	</form>
</div>
<div class="modal-footer">
	<a href="<?php echo base_url('admin/hr/attendance/detail/' . $monthParam); ?>" type="button" class="btn btn-secondary">Rest and Close</a>
	<button type="submit" form="applyFiltersBtn" class="btn btn-custom-success">Apply Filters</button>
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

	$(function () {
        var monthParam = "<?php echo trim($monthParam); ?>";
        var monthMoment = moment(monthParam, ['YYYY-MM', 'YYYY-MM-DD']);
        var monthStart = monthMoment.clone().startOf('month');
        var monthEnd = monthMoment.clone().endOf('month');

        // Read URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const dateFromParam = urlParams.get('date_from');
        const dateToParam = urlParams.get('date_to');
        const selectedEmployee = urlParams.get('keyword');

        // Default: full month
        var start = dateFromParam ? moment(dateFromParam) : monthStart.clone();
        var end = dateToParam ? moment(dateToParam) : monthEnd.clone();

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            $('#dateFrom').val(start.format('YYYY-MM-DD'));
            $('#dateTo').val(end.format('YYYY-MM-DD'));
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
            minDate: monthStart,
            maxDate: monthEnd,
            autoUpdateInput: false,
            locale: { cancelLabel: 'Clear' },
            showCustomRangeLabel: true
        };

        if (isCurrentMonth) {
            config.ranges = {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [monthStart, monthEnd],
            };
        } else {
            config.ranges = {
                'Full Month': [monthStart, monthEnd],
                'First Half': [monthStart, monthStart.clone().add(14, 'days')],
                'Second Half': [monthStart.clone().add(15, 'days'), monthEnd],
            };
        }

        // Initialize daterangepicker
        $('#reportrange').daterangepicker(config, cb);
        cb(start, end);

        // Clear button
        $('#reportrange').on('cancel.daterangepicker', function (ev, picker) {
            $(this).find('span').html('');
            $('#dateFrom').val('');
            $('#dateTo').val('');
            $('#dateFrom, #dateTo').trigger('change');
        });

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
                data: function (params) {
                    return { search: params.term };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id: item.id,
                                text: item.emp_no + ' - ' + item.full_name
                            };
                        })
                    };
                }
            }
        });

        // ✅ Preselect employee if already chosen in URL
        if (selectedEmployee) {
            $.ajax({
                url: "<?php echo base_url('admin/logistic-management/Cash_collection/search_employee'); ?>",
                type: "GET",
                data: { search: selectedEmployee },
                dataType: 'json',
                success: function (data) {
                    let item = data.find(emp => emp.id == selectedEmployee);
                    if (item) {
                        let option = new Option(item.emp_no + " - " + item.full_name, item.id, true, true);
                        $('#filter_keyword').append(option).trigger('change');
                    }
                }
            });
        }
    });

</script>