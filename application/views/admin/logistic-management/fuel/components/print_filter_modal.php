<div class="modal-header">
	<h5 class="modal-title px-3" id="vehicleFormModalLabel">Apply Filters</h5>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
	<form action="<?php echo base_url('admin/logistic-management/fuel-management/daily-consumption-report'); ?>" method="get" id="applyPrintFilters" target="_blank">
		<div class="row">
			<div class="col-md-12 mb-2">
				<label for="printrange">Select Date Range:</label>
				<div id="printrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
					<i class="fa fa-calendar"></i>&nbsp;
					<span></span> <i class="fa fa-caret-down"></i>
				</div>
				<!-- Hidden inputs to submit selected range -->
				<input type="hidden" name="start_date" id="print_start_date" value="<?php echo $this->input->get('start_date');?>" required>
				<input type="hidden" name="end_date" id="print_end_date" value="<?php echo $this->input->get('end_date');?>" required>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="form-group mb-2">
					<label>Search by Emp. Name or Emp. No.</label>
					<select class="form-control" class="form-control" placeholder="Search by Emp. Name or Emp. ID" aria-label="Employee Number" name="keyword" id="filter_keyword_print" aria-describedby="button-addon2">
						<option value="">Search...</option>
					</select>
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="form-group mb-2">
					<label>Team</label>
					<select name="team" class="form-select">
						<option value="">[ All Team ]</option>
						<?php foreach ($teams as $mteam) { ?>
							<option value="<?php echo $mteam->name; ?>" <?php echo ($mteam->name == $this->input->get('team')) ? ' selected ' : ''; ?>><?php echo $mteam->name; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="form-group mb-2">
					<label>Vehicle No.</label>
					<input type="search" name="vehicle_no" placeholder="Search by Vehicle No. etc." value="<?php echo $this->input->get('vehicle_no') ? $this->input->get('vehicle_no') : ''; ?>" autocomplete="off" class="form-control">
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="form-group mb-2">
					<label>Vehicle Type</label>
					<select name="vehicle_type" class="form-control select2">
						<option value="">[Any Type]</option>
						<option value="bike" <?php echo ($this->input->get('vehicle_type') == 'bike') ? "selected" : ""; ?>>Bike</option>
						<option value="car" <?php echo ($this->input->get('vehicle_type') == 'car') ? "selected" : ""; ?>>Car</option>
					</select>
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="form-group mb-3">
					<label>Vehicle Category</label>
					<select name="vehicle_category" class="form-control select2">
						<option value="">[Any Category]</option>
						<option value="Staff" <?php echo ($this->input->get('vehicle_category') == 'Staff') ? "selected" : ""; ?>>Staff</option>
						<option value="TGA" <?php echo ($this->input->get('vehicle_category') == 'TGA') ? "selected" : ""; ?>>TGA</option>
						<option value="Route" <?php echo ($this->input->get('vehicle_category') == 'Route') ? "selected" : ""; ?>>Route</option>
					</select>
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="form-check mb-2">
					<input class="form-check-input" type="checkbox" value="1" id="exclude_zero_consumption" name="exclude_zero_consumption" <?php echo $this->input->get('exclude_zero_consumption') ? 'checked' : ''; ?> style="transform: scale(1.5);">
					<label class="form-check-label ms-1" for="exclude_zero_consumption" style="vertical-align: text-top;">
						Exclude 0 Consumption Records
					</label>
				</div>
			</div>
		</div>
	</form>
</div>
<div class="modal-footer">
	<a href="<?php echo base_url('admin/logistic-management/fuel-management/list'); ?>" type="button" class="btn btn-secondary">Cancel</a>
	<button type="submit" form="applyPrintFilters" class="btn btn-custom-success">Print Report</button>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		$('#filter_keyword_print').select2({
			placeholder: 'Search...',
			allowClear: true,
			minimumInputLength: 3,
			ajax: {
				url: "<?php echo base_url('admin/logistic-management/fuel/search-emp-list'); ?>",
				type: 'GET',
				dataType: 'json',
				delay: 250,
				data: function(params) {
					return {
						search: params.term
					};
				},
				processResults: function(data) {
					return {
						results: $.map(data, function(item) {
							//console.log(item);
							return {
								id: item.emp_no,
								text: item.emp_no + ' - ' + item.full_name
							};
						})
					};
				},
				error: function(xhr, status, error) {
					console.log(xhr.responseText);
				}
			}
		});
	});

	$(function() {
		// Get PHP values from GET parameters
		var start = "<?php echo $this->input->get('start_date'); ?>";
		var end   = "<?php echo $this->input->get('end_date'); ?>";

		function cb(start, end) {
			// Update text display
			$('#printrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
			// Update hidden inputs for form
			$('#print_start_date').val(start.format('YYYY-MM-DD'));
			$('#print_end_date').val(end.format('YYYY-MM-DD'));
		}

		$('#printrange').daterangepicker({
			autoUpdateInput: false,
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

		// If user had already selected a range, display it
		if (start && end) {
			$('#printrange').data('daterangepicker').setStartDate(moment(start));
			$('#printrange').data('daterangepicker').setEndDate(moment(end));
			cb(moment(start), moment(end));
		} else {
			// No previous filter — clear text and hidden inputs
			$('#printrange span').html('No date selected');
			$('#print_start_date').val('');
			$('#print_end_date').val('');
		}

		// When user clears selection
		$('#printrange').on('cancel.daterangepicker', function(ev, picker) {
			$(this).find('span').html('No date selected');
			$('#print_start_date').val('');
			$('#print_end_date').val('');
		});
	});
</script>