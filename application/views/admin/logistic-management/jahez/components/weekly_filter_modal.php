<div class="modal-header">
    <h5 class="modal-title mt-0" id="weeklyReportLabel">Print Weekly Summary</h5>
    <button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form action="<?php echo base_url('admin/logistic-management/jahez/print-weekly-summary'); ?>" target="_blank" method="get" id="weeklyReportForm">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group mb-3">
                    <label>Search by Employee Name/Number</label>
                    <input type="search" name="filter_keyword" placeholder="Search by Employee Name" value="<?php echo $this->input->get('keyword') ? $this->input->get('keyword') : ''; ?>" autocomplete="off" class="form-control">
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group mb-3">
                    <label>Driver Id</label>
                    <input type="search" name="filter_rider_id" placeholder="Search Driver ID" value="<?php echo $this->input->get('rider_id') ? $this->input->get('rider_id') : ''; ?>" autocomplete="off" class="form-control">
                </div>
            </div>

            <div class="form-group col-lg-12 col-md-12 col-12 mb-3">
                <label for="date_range">Select Week: </label>
                <div class="position-relative" id="datepicker4">
                    <input type="week" id="week" name="week" class="form-control" value="<?php echo $this->input->get('week') ? $this->input->get('week') : ''; ?>" required>
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group mb-2">
                    <label>Team</label>
                    <select name="team" class="form-select">
                        <option value="">[ All Team]</option>
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
    <button type="submit" form="weeklyReportForm" class="btn btn-custom-success">Print Weekly Summary</button>
</div>