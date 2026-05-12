<div class="modal-header">
    <h5 class="modal-title px-3" id="filtersModalLabel"><?php echo $filter_title;?></h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form action="<?= base_url('admin/logistic-management/new-jahez/print-weekly-performance'); ?>" 
      method="get" id="modalFilterForm" target="_blank">

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group mb-3">
                    <label>Search</label>
                    <input type="search" id="keyword" name="keyword" placeholder="Search by Emp. Name / Emp. ID/ Driver ID etc." value="<?php echo $this->input->get('keyword') ? $this->input->get('keyword') : ''; ?>" autocomplete="off" class="form-control">
                </div>
            </div>
            <div class="form-group col-lg-12 col-md-12 col-12 mb-3">
                <label for="week_date">Select Week (Sunday - Saturday):</label>
                <div class="input-group" id="datepicker2">
                    <input type="text" class="form-control" name="week_date" id="week_date" placeholder="dd-mm-yyyy" data-date-format="dd-mm-yyyy" data-date-container="#datepicker2" data-provide="datepicker" data-date-autoclose="true" autocomplete="off" value="<?php echo $this->input->get('week_date') ? $this->input->get('week_date') : ''; ?>" required>
                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                </div>
                <div id="weekRange" class="mt-2 font-weight-bold"></div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group mb-3">
                    <label>Team</label>
                    <select name="team" id="team" class="form-select">
                        <option value="">[ All Team]</option>
                        <?php foreach ($teams as $mteam) { ?>
                            <option value="<?php echo $mteam->name; ?>" <?php echo ($mteam->name == $this->input->get('team')) ? ' selected ' : ''; ?>><?php echo $mteam->name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group mb-2">
                    <label>Employer</label>
                    <select name="employer" class="form-select">
                        <option value="">[ All Employers]</option>
                        <?php foreach (sponsorsHelper() as $sponsor) { ?>
                            <option value="<?php echo $sponsor['id']; ?>" <?php echo ($sponsor['id'] == $this->input->get('employer')) ? ' selected ' : ''; ?>><?php echo $sponsor['employer_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group mb-3">
                    <label>Vehicle Type</label>
                    <select name="vehicle_type" id="vehicle_type" class="form-select">
                        <option value="">[ All Type ]</option>
                        <option value="bike" <?php echo ('bike' == $this->input->get('vehicle_type')) ? ' selected ' : ''; ?>>Bike</option>
                        <option value="car" <?php echo ('car' == $this->input->get('vehicle_type')) ? ' selected ' : ''; ?>>Car</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group mb-3">
                    <label>Vehicle No</label>
                    <input type="search" name="vehicle_no" id="vehicle_no" placeholder="Search by Vehicle No" value="<?php echo $this->input->get('vehicle_no') ? $this->input->get('vehicle_no') : ''; ?>" autocomplete="off" class="form-control">
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <a href="<?php echo base_url('admin/logistic-management/new-jahez/list'); ?>" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</a>
    <button type="submit" form="modalFilterForm" class="btn btn-custom-success">Print Report</button>
</div>
<script>
    /*---- Week ----*/
	function formatDate(date) {
		const options = { year: 'numeric', month: 'short', day: 'numeric' };
		return date.toLocaleDateString(undefined, options);
	}

	$(document).ready(function () {
		$('#week_date').on('changeDate', function (e) {
			const selected = new Date(e.date);
			const day = selected.getDay(); // 0 = Sunday
			const sunday = new Date(selected);
			sunday.setDate(selected.getDate() - day);

			const saturday = new Date(sunday);
			saturday.setDate(sunday.getDate() + 6);

			const weekText = `${formatDate(sunday)} - ${formatDate(saturday)}`;

			// Show inside the input field
			$('#week_date').val(weekText);

			// Optional: show below as well
			$('#weekRange').html(`Week Range: <strong>${weekText}</strong>`);

			// Optional: store hidden values
			// $('<input>').attr({ type: 'hidden', name: 'from_date', value: sunday.toISOString().slice(0,10) }).appendTo('form');
			// $('<input>').attr({ type: 'hidden', name: 'to_date', value: saturday.toISOString().slice(0,10) }).appendTo('form');
		});

		// Re-trigger if already set
		const preset = $('#week_date').val();
		if (preset && preset.match(/^\d{4}-\d{2}-\d{2}$/)) {
			$('#week_date').datepicker('update', preset);
			$('#week_date').trigger('changeDate');
		}
	});
	/*---- Week ----*/  
</script>