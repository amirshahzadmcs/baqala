<div class="modal-header">
    <h5 class="modal-title px-3" id="filtersModalLabel"><?php echo $filter_title;?></h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form action="<?= base_url('admin/logistic-management/new-jahez/print-daily-performance'); ?>" 
      method="get" id="modalFilterForm" target="_blank">

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group mb-3">
                    <label>Search</label>
                    <input type="search" id="keyword" name="keyword" placeholder="Search by Emp. Name / Emp. ID/ DA ID etc." value="<?php echo $this->input->get('keyword') ? $this->input->get('keyword') : ''; ?>" autocomplete="off" class="form-control">
                </div>
            </div>
            <div class="col-md-12 mb-3">
                <label for="date_from">Select Date Range</label>
                <div class="input-daterange input-group" id="datepicker_filter_modal"
                    data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#datepicker_filter_modal">
                    <input type="text" class="form-control" name="date_from" id="modalDateFrom" placeholder="Start Date" autocomplete="off">
                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                    <input type="text" class="form-control" name="date_to" id="modalDateTo" placeholder="End Date" autocomplete="off">
                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                </div>
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
    function initializeDatePickers(container = 'body') {
        $(container).find('.input-daterange').each(function () {
            $(this).datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                container: container
            });
        });
    }
</script>