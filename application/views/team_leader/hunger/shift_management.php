<?php $this->load->view('team_leader/layout/header'); ?>
<style>
    .dataTables_wrapper::-webkit-scrollbar {
        display: none;
    }

    .nav-md .container.body .right_col {
        padding: 10px 10px 0;
        margin-left: 230px;
    }

    #messageContainer {
        max-height: 250px;
        overflow: auto;
        margin-bottom: 20px;
    }

    .modal-dialog-aside {
        width: 45%;
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

    .size-inner-section {
        box-shadow: 0px 1px 4px #c5c5c5;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    #responseContainer2 {
        position: absolute;
        width: 94%;
    }

    .find_rider span.select2.select2-container.select2-container--default {
        width: 85% !important;
    }
    @media only screen and (max-width: 600px) {
        .word-1 {
    width: 100%;
}

.find_rider span.select2.select2-container.select2-container--default {
    width: 100% !important;
}
.text-center {
    width: 100%;
    margin-top: 14px;
}



  }
</style>

<!-- start page title -->
<div class="main-content">
    <div class="page-content">
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="page-title">
                            <h4>Scheduled Shift</h4>
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="<?php echo base_url('admin/logistic-management/hunger/team-list'); ?>">Scheduled Shift</a></li>
                                <li class="breadcrumb-item active">List</li>
                            </ol>
                        </div>
                    </div>
                    <?php $admin_id = $this->session->userdata('admin_id'); ?>
                    <div class="col-sm-6 message_place">
                        <div class="float-end d-sm-block">
                            <!-- <button type="button" class="btn btn-custom-danger btn-sm pull-right" title="Delete" data-bs-toggle="modal" data-bs-target="#shiftDailyReportMdal"><i class="fa fa-print me-1"></i> Daily Report</button>
                            <button type="button" class="btn btn-custom-white btn-sm pull-right" title="Delete" data-bs-toggle="modal" data-bs-target="#shiftWeeklyReportMdal"><i class="fa fa-print me-1"></i> Weekly Report</button> -->
                            <button type="button" class="btn btn-custom-success btn-sm pull-right" data-bs-toggle="modal" data-bs-target="#assignShiftModal" title="Create"><i class="fa fa-plus me-1"></i>Assign Shift</button>
                        </div>
                        <?php if ($this->teamleader->getInfo()) {
                            $info = explode("--", $this->teamleader->getInfo());
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
                                <form action="<?php echo base_url('team-leader/hunger/shift'); ?>" method="get" id="filter_form">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="form-group mb-2">
                                                <label>Search by Emp No</label>
                                                <input type="search" id="keyword" name="name" placeholder="Search by Team Name" value="<?php echo $this->input->get('name') ? $this->input->get('name') : ''; ?>" autocomplete="off" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-4 col-12 mb-3">
                                            <label for="date_range">Date Range: </label>
                                            <div class="input-daterange input-group" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#datepicker6">
                                                <input type="text" class="form-control" name="start_date" placeholder="Start Date" value="<?php echo $this->input->get('start_date'); ?>" autocomplete="off">
                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                <input type="text" class="form-control" name="end_date" placeholder="End Date" value="<?php echo $this->input->get('end_date'); ?>" autocomplete="off">
                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-lg-6 col-md-6 col-sm-12">

                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <button type="submit" class="btn btn-success btn-md float-end ms-2">Apply Filter</button>
                                            <a href="<?php echo base_url('team-leader/hunger/shift'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form id="myform" name="myform" method="post" action="">
                                    <table id="scheduledShiftTable" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>Emp No</th>
                                                <th>Emp Name</th>
                                                <th>Team</th>
                                                <th>Date</th>
                                                <th>Shift</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th>Duration</th>
                                                <th>Area</th>
                                                <th>Tools</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- container-fluid -->

<!-- Create Shift -->
<div class="modal fade fixed-left assignShiftModal" id="assignShiftModal" data-bs-backdrop="static" aria-labelledby="#replacementModalModalLabel2" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-aside word-1">
        <div class="modal-content">
            <div class="modal-header justify-content-between">
                <h5 class="modal-title mt-0" id="assignShiftModalLabel">Shift Allotment</h5>
                <button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="responseContainer"></div>
                <div id="searchRider">
                    <div class="size-inner-section px-1 py-1 mx-1" id="alertBox">
                        <?php echo form_open("team-leader/hunger/search-rider", array("id" => "searchRiderForm", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
                        <div class="row p-2">
                            <div class="col-md-12 col-sm-12 mb-2 form-group">
                                <label for="rider">Rider <span class="text-danger"> *</span></label>
                                <div class="input-group find_rider">
                                    <select class="form-control select2 select2-find_rider" name="rider_id" id="rider_id" data-parsley-errors-container="#riderError" required>
                                        <option value="">Choose</option>
                                        <?php foreach ($riders as $rider) : ?>
                                            <option value="<?php echo $rider->id; ?>"><?php echo $rider->full_name; ?> (<?php echo $rider->emp_no; ?>)</option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="text-center">
                                    <button type="submit" class="btn-custom-success btn-sm input-group-append" title="Sreach">Search</button></div>
                                    <div id="riderError"></div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
                <div id="riderDeatil" style="display: none;">

                </div>
            </div>
            <div id="footerArea" style="display:none"></div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Assigned Shift View -->

<div class="modal fade fixed-left viewShiftModal" id="viewShiftModal" data-bs-backdrop="static" aria-labelledby="#replacementModalModalLabel2" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-aside word-1">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="viewShiftModalLabel">Schedule Shift Detail</h5>
                <button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="responseContainer"></div>
                <div id="searchResult2" class="mt-4">
                    <div class="size-inner-section px-1 py-1 mx-1" id="alertBox">
                        <div class="row p-2">
                            <div class="col-md-6 col-sm-12 mb-2 form-group">
                                <label for="rider">Rider</label>
                                <p id="riderView"></p>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2 form-group">
                                <label for="teamName">Shift</label>
                                <p id="shiftView"></p>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2 form-group">
                                <label for="date">Date:</label>
                                <p id="dateView"></p>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2 form-group">
                                <label for="startTime">Time:</label>
                                <p id="timeView"></p>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2 form-group">
                                <label for="endTime">Area:</label>
                                <p id="areaView"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<!-- Shift Weekly Report Modal -->
<div class="modal fade fixed-left shiftWeeklyReportMdal" id="shiftWeeklyReportMdal" data-bs-backdrop="static" aria-labelledby="#replacementModalModalLabel2" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-aside">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="shiftWeeklyReportMdalLabel">Weekly Shift Report</h5>
                <button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="responseContainer"></div>
                <div id="searchResult2" class="mt-4">
                    <div class="size-inner-section px-1 py-1 mx-1" id="alertBox">
                        <!-- <div class="card-header" id="alertBox"></div> -->
                        <?php echo form_open("admin/logistic-management/hunger/print-weekly-shift", array("id" => "weeklyReportForm", "class" => "form-label-left", "data-parsley-validate" => "", "target" => "_blank")); ?>
                        <div class="row p-2 shift_report">
                            <div class="col-md-12 col-sm-12 mb-2 form-group">
                                <label for="rider">Team Leader<span class="text-danger">*</span></label>
                                <select class="form-control select2 team_leader_id" name="team_leaderId" id="team_leaderId" data-parsley-errors-container="#leaderError" required>
                                    <option value="">Select Any</option>
                                    <?php foreach ($team_leaders as $leader) : ?>
                                        <option value="<?php echo $leader->id; ?>"><?php echo $leader->full_name; ?> (<?php echo $leader->emp_no; ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                                <div id="leaderError"></div>
                            </div>
                            <div class="col-md-12 col-sm-12 mb-2 form-group">
                                <label for="riderId">Select Rider<span class="text-danger">*</span></label>
                                <select class="form-control select2 riders rider_id" name="rider_id" id="riderId" data-parsley-errors-container="#rider_Error">
                                    <option value="">------</option>
                                </select>
                                <div id="rider_Error"></div>
                            </div>
                            <h6 class="text-center mt-2">OR</h6>
                            <div class="col-md-12 col-sm-12 mb-2 form-group">
                                <div class="form-check form-check-right mb-3">
                                    <input class="form-check-input check_all_riders" type="radio" name="all_rider" value="1" id="checkAllRiders">
                                    <label class="form-check-label" for="checkAllRiders">
                                        Select For All Riders
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 mb-2 form-group">
                                <label for="Week">Select Week<span class="text-danger">*</span></label>
                                <input type="week" class="form-control" name="week" id="Week" required>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="searchModalFooter2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetModalData()">Cancel</button>
                <button type="submit" form="weeklyReportForm" class="btn btn-custom-success" id="submitBtn">Submit</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<!-- Shift Daily Report Modal -->
<div class="modal fade fixed-left shiftDailyReportMdal" id="shiftDailyReportMdal" data-bs-backdrop="static" aria-labelledby="#replacementModalModalLabel2" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-aside">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="shiftDailyReportMdalLabel">Daily Shift Report</h5>
                <button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="responseContainer"></div>
                <div id="searchResult2" class="mt-4">
                    <div class="size-inner-section px-1 py-1 mx-1" id="alertBox">
                        <!-- <div class="card-header" id="alertBox"></div> -->
                        <?php echo form_open("admin/logistic-management/hunger/print-daily-shift", array("id" => "dailyReportForm", "class" => "form-label-left", "data-parsley-validate" => "", "target" => "_blank")); ?>
                        <div class="row p-2 shift_report">
                            <div class="col-md-12 col-sm-12 mb-2 form-group">
                                <label for="">Team Leader<span class="text-danger">*</span></label>
                                <select class="form-control select2 team_leader_id" name="team_leaderId" id="team_leaderId" data-parsley-errors-container="#dalyleaderError" required>
                                    <option value="">Select Any</option>
                                    <?php foreach ($team_leaders as $leader) : ?>
                                        <option value="<?php echo $leader->id; ?>"><?php echo $leader->full_name; ?> (<?php echo $leader->emp_no; ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                                <div id="dalyleaderError"></div>
                            </div>
                            <div class="col-md-12 col-sm-12 mb-2 form-group">
                                <label for="">Select Rider<span class="text-danger">*</span></label>
                                <select class="form-control select2 riders rider_id" name="rider_id" id="" data-parsley-errors-container="#dailyrider_Error">
                                    <option value="">------</option>
                                </select>
                                <div id="dailyrider_Error"></div>
                            </div>
                            <h6 class="text-center mt-2">OR</h6>
                            <div class="col-md-12 col-sm-12 mb-2 form-group">
                                <div class="form-check form-check-right mb-3">
                                    <input class="form-check-input check_all_riders" type="radio" name="all_rider" value="1" id="">
                                    <label class="form-check-label" for="">
                                        Select For All Riders
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 mb-2 form-group">
                                <label for="Week">Select Date<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="date" id="Date" required>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="searchModalFooter2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetModalData()">Cancel</button>
                <button type="submit" form="dailyReportForm" class="btn btn-custom-success" id="submitBtn">Submit</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php $this->load->view('team_leader/layout/footer'); ?>
<script src="<?php echo base_url('store_assets/js/shift_management.js') ?>"></script>

<script type="text/javascript">
    $(document).ready(function() {
        initializeShiftTable();
    });
</script>