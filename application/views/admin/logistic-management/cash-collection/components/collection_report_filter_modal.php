<div class="modal-header">
    <h5 class="modal-title px-3" id="filtersModalLabel"><?php echo $filter_title;?></h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form action="<?= base_url('admin/logistic-management/cash-collection/print-collection-report'); ?>" method="get" id="modalFilterForm" target="_blank">
        <div class="row">
            <!-- your employee & team leader selects -->
			<div class="form-group col-lg-12 col-md-12 col-12 mb-2">
				<label for="reportrange">Select COD Date Range:</label>
				<div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
					<i class="fa fa-calendar"></i>&nbsp;
					<span></span> <i class="fa fa-caret-down"></i>
				</div>
                <!-- Hidden inputs to submit selected range -->
                <input type="hidden" name="order_start_date" id="cod_start_date" required>
                <input type="hidden" name="order_end_date" id="cod_end_date" required>
			</div>

            <div class="col-lg-12 col-md-12 col-12 mb-2">
                <label for="date_range">Collection Date Range: </label>
                <div class="input-daterange input-group" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#datepicker6">
                    <input type="text" class="form-control" name="start_date" placeholder="Start Date" value="<?php echo $this->input->get('start_date'); ?>" autocomplete="off">
                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                    <input type="text" class="form-control" name="end_date" placeholder="End Date" value="<?php echo $this->input->get('end_date'); ?>" autocomplete="off">
                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group mb-2">
                    <label>Search Employee</label>
                    <select class="form-control" class="form-control" placeholder="Search by Emp. Name or Emp. ID" aria-label="Employee Number" name="keyword" id="monthly_filter_keyword" aria-describedby="button-addon2">
                        <option value="">Search Employee Name or Emp No...</option>
                    </select>
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group mb-2">
                    <label>Transaction Type</label>
                    <select name="receipt_reason" class="form-select">
                        <option value="">Select Reason</option>
                        <?php
                        if (!empty(cashReasonsHelper())) {
                            foreach (cashReasonsHelper() as $master_reason) {
                        ?>
                                <option value="<?php echo $master_reason->reason_title_en; ?>" <?php echo ($master_reason->reason_title_en == $this->input->get('receipt_reason')) ? ' selected ' : ''; ?>><?php echo $master_reason->reason_title_en; ?></option>
                            <?php }
                        } else { ?>
                            <option value="" disabled>No reason found, add first!</option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group mb-2">
                    <label>Team</label>
                    <select name="team" class="form-select">
                        <option value="">[ All Team]</option>
                        <?php foreach($teams as $mteam) { ?>
                            <option value="<?php echo $mteam->name; ?>" <?php echo ($mteam->name == $this->input->get('team')) ? ' selected ' : '';?>><?php echo $mteam->name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="form-group mb-2">
					<label>Driver ID</label>
					<input type="search" name="driver_id" class="form-control" value="<?php echo $this->input->get('driver_id'); ?>" placeholder="Driver ID">
				</div>
			</div>

            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group mb-2">
                    <label class="d-block">Employer </label>
                    <select name="employer" class="form-select select2">
                        <option value="">[All Employer]</option>
                        <?php foreach (sponsorsHelper() as $employer) { ?>
                            <option value="<?php echo $employer['id']; ?>" <?php echo ($employer['id'] == $this->input->get('employer')) ? ' selected ' : '' ?>><?php echo $employer['employer_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <a href="<?php echo base_url('admin/logistic-management/cash-collection/list'); ?>" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</a>
    <button type="submit" form="modalFilterForm" class="btn btn-custom-success">Print Report</button>
</div>
<script>
    function initializeDatePickers(container = 'body') {
        $(container).find('.input-daterange').each(function () {
            $(this).datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                container: container
            });
        });
    }

	$(document).ready(function () {
		// =================== Employee Search ===================
		$('#monthly_filter_keyword').select2({
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
						$('#monthly_filter_keyword').append(option).trigger('change');
					}
				}
			});
		}

		// =================== Team Leader Search ===================
		$('#monthly_filter_team_leader').select2({
			placeholder: 'Search Team Leader Name or Emp No...',
			allowClear: true,
			minimumInputLength: 3,
            dropdownParent: $('#filtersModal'),
			ajax: {
				url: "<?php echo base_url('admin/logistic-management/Cash_collection/search_team_leader'); ?>",
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

		// Preselect team leader if already chosen
		var selectedTeamLeader = "<?php echo $this->input->get('team_leader'); ?>";
		if (selectedTeamLeader) {
			$.ajax({
				url: "<?php echo base_url('admin/logistic-management/Cash_collection/search_team_leader'); ?>",
				type: "GET",
				data: { search: selectedTeamLeader },
				dataType: 'json',
				success: function (data) {
					let item = data.find(emp => emp.id === selectedTeamLeader);
					if (item) {
						var option = new Option(item.emp_no + " - " + item.full_name, item.id, true, true);
						$('#monthly_filter_team_leader').append(option).trigger('change');
					}
				}
			});
		}
	});
</script>

<script type="text/javascript">
$(function() {
    // Default: last 30 days
    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        // Show the range in the UI
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

        // Set hidden input values for form submission
        $('#cod_start_date').val(start.format('YYYY-MM-DD'));
        $('#cod_end_date').val(end.format('YYYY-MM-DD'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        autoUpdateInput: false, // we handle it manually in cb
        locale: {
            cancelLabel: 'Clear'
        },
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

    // Optional: Clear date range
    $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
        $(this).find('span').html('');
        $('#cod_start_date').val('');
        $('#cod_end_date').val('');
    });
});
</script>
