<div class="modal-header">
	<h5 class="modal-title mt-0" id="filterModalLabel">Print Day Wise Report</h5>
	<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
	<form action="<?php echo base_url('admin/logistic-management/jahez/print-daywise-summary'); ?>" target="_blank" method="get" id="filterForm">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="form-group mb-3">
					<label>Search by Employee Name/Number</label>
					<input type="search" name="filter_keyword" placeholder="Search by Employee Name/No." value="<?php echo $this->input->get('filter_keyword') ? $this->input->get('filter_keyword') : ''; ?>" autocomplete="off" class="form-control">
				</div>
			</div>

			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="form-group mb-3">
					<label>Driver Id</label>
					<input type="search" name="filter_rider_id" placeholder="Search Driver ID" value="<?php echo $this->input->get('filter_rider_id') ? $this->input->get('filter_rider_id') : ''; ?>" autocomplete="off" class="form-control">
				</div>
			</div>

			<div class="form-group col-lg-12 col-md-12 col-12 mb-3">
				<label for="date_range">Select Month: </label>
				<div class="position-relative" id="datepicker4">
					<input type="text" class="form-control" data-date-container='#datepicker4' data-provide="datepicker"
						data-date-format="MM yyyy" data-date-min-view-mode="1" name="month_of" id="month_of" autocomplete="off" value="<?php echo $this->input->get('month_of'); ?>" required>
				</div>
			</div>

			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="form-group mb-2">
					<label>Team</label>
					<select name="team" class="form-select">
						<option value="">[All Team]</option>
						<?php foreach (teamList() as $mteam) { ?>
							<option value="<?php echo $mteam->name; ?>" <?php echo ($mteam->name == $this->input->get('team')) ? ' selected ' : ''; ?>><?php echo $mteam->name; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
	</form>
</div>
<div class="modal-footer">
	<button type="submit" form="filterForm" class="btn btn-custom-success">Print Summary</button>
</div>