<?php $this->load->view('team_leader/layout/header'); ?>
<style>
    .dataTables_wrapper::-webkit-scrollbar {
        display: none;
    }

    .nav-md .container.body .right_col {
        padding: 10px 10px 0;
        margin-left: 230px;
    }


    .main-body {
        padding: 15px;
    }

    .main-body hr {
        margin: 0.7rem 0;
    }

    .card {
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
    }

    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 0 solid rgba(0, 0, 0, .125);
        border-radius: .25rem;
    }

    .card-body {
        flex: 1 1 auto;
        min-height: 1px;
        padding: 1rem;
    }

    .gutters-sm {
        margin-right: -8px;
        margin-left: -8px;
    }

    .gutters-sm>.col,
    .gutters-sm>[class*=col-] {
        padding-right: 8px;
        padding-left: 8px;
    }

    .mb-3,
    .my-3 {
        margin-bottom: 1rem !important;
    }

    .bg-gray-300 {
        background-color: #e2e8f0;
    }

    .h-100 {
        height: 100% !important;
    }

    .shadow-none {
        box-shadow: none !important;
    }

    .modal-dialog-aside {
        width: 40%;
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
</style>

<!-- start page title -->
<div class="main-content">
    <div class="page-content">
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="page-title">
                            <h4>Attendance</h4>
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo base_url('team-leader'); ?>">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="<?php echo base_url('team-leader/asset/all-conditions'); ?>">Attendance</a></li>
                                <li class="breadcrumb-item active">List</li>
                            </ol>
                        </div>
                    </div>
                    <?php $team_leader_id = $this->session->userdata('team_leader_id'); ?>

                    <div class="col-sm-6">
                        <div class="float-end d-sm-block">
                            <a href="javascript:;" class="btn btn-custom-danger btn-sm pull-right me-1" onclick="location.reload()"> <i class="fas fa-sync"></i> </a>
                            <a target="_blank" href="<?php echo base_url('team-leader/vehicle/print-timesheet?emp=' . $this->input->get('emp') . '&platform=' . $this->input->get('platform') . '&camp=' . $this->input->get('camp') . '&from=' . $this->input->get('from') . '&to=' . $this->input->get('to')); ?>" class="btn btn-custom-success btn-sm pull-right me-1">Print Attendance</a>
                            <a href="javascript:;" class="btn btn-custom2 btn-sm pull-right me-1" data-bs-target="#vehicleModal" data-bs-toggle="modal"><i class="fas fa-plus"></i> Create</a>
                        </div>
                        <?php if ($this->teamleader->getInfo()) {
                            $info = explode("--", $this->teamleader->getInfo());
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
                            <?php } ?> <?php }; ?>
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
                                <form action="<?php echo base_url('team-leader/vehicle/get-timesheet'); ?>" method="get" id="filter_form">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="form-group mb-2">
                                                <label>Employee</label>
                                                <select class="form-control select2" name="emp" id="">
                                                    <option value="">[Any]</option>
                                                    <?php foreach ($employees as $emp) { ?>
                                                        <option value="<?php echo $emp->id; ?>" <?php echo $this->input->get('emp') == $emp->id ? 'selected' : ''; ?>> <?php echo $emp->full_name; ?> (<?php echo $emp->emp_no; ?>)</option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="form-group mb-2">
												<label>Date Between (From and To)</label>
												<div class="input-daterange input-group" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
													<input type="text" class="form-control" id="_from" name="from" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" autocomplete="off" placeholder="Start Date (dd-mm-yyyy)" />
													<input type="text" class="form-control" id="_to" name="to" value="<?php echo $this->input->get('to') ? $this->input->get('to') : ''; ?>" autocomplete="off" placeholder="End Date (dd-mm-yyyy)" />
												</div>
											</div>

                                        </div>
                                    </div>
                                    <div class="row mt-2 justify-content-end">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <button type="submit" class="btn btn-success btn-md float-end ms-2">Apply Filter</button>
                                            <a href="<?php echo base_url('team-leader/vehicle/get-timesheet'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
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
                                    <table id="timesheet-table" class="table text-center table-striped table-bordered jambo_table bulk_action" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>Emp No</th>
                                                <th>Employee Name</th>
                                                <th>Vehicle No</th>
                                                <th>Platform</th>
                                                <th>Out Time</th>
                                                <th>Km</th>
                                                <th>Battery(%)</th>
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

<div class="modal fade fixed-left" id="vehicleModal" data-bs-backdrop="static" role="dialog" aria-labelledby="vehicleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-aside">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mt-0">Rider Attendance</h5>
                </div>
                <div>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <form id="empCheck" action="<?php echo base_url('team-leader/vehicle/check_employee'); ?>" method="post" data-parsley-validate>
                    <div class="row justify-content-center px-2">
                        <div class="card bg-light col-md-12">
                            <div class="card-body row" id="empNo">
                                <div class="col-md-8 form-group">
                                    <label class="form-label">Employee Id<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="employee_no" required>
                                </div>
                                <div class="col-md-4 form-group align-content-end">
                                    <button form="empCheck" type="submit" class="btn btn-success submit_button mt-2">Submit</button>
                                </div>
                                <p id="empCheckMsg" class="mt-1"></p>
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="col-md-12 mb-3" id="empDetails" style="display:none;">

                </div>

            </div>
        </div>
    </div>
</div>



<?php $this->load->view('team_leader/layout/footer'); ?>
<div class="modal fade fixed-left " id="timesheetViewModal" data-bs-backdrop="static" role="dialog" aria-labelledby="timesheetViewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-aside">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mt-0">Detail</h5>
                </div>
                <div>
                    <!-- <button type="button" class="btn btn-sm"><i class="fas fa-pencil-alt"></i></button> -->
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3 mb-4 form-group">
                        <label class="form-label">Vehicle No</label><br>
                        <span class="text-muted sheet_view_vehicle_no">Emp No</span>
                    </div>
                    <div class="col-md-3 mb-4 form-group">
                        <label class="form-label">Emp No</label><br>
                        <span class="text-muted sheet_view_emp_no">Human Resources</span>
                    </div>
                    <div class="col-md-3 mb-4 form-group">
                        <label class="form-label">Emp Name</label><br>
                        <span class="text-muted sheet_view_name">Human Resources</span>
                    </div>
                    <div class="col-md-3 mb-4 form-group">
                        <label class="form-label">Check Out Km</label><br>
                        <span class="text-muted sheet_view_checkOut_km">Human Resources</span>
                    </div>

                    <div class="col-md-3 mb-4 form-group">
                        <label class="form-label">Check Out Battery(%)</label><br>
                        <span class="text-muted sheet_view_checkOut_battery">Human Resources</span>
                    </div>
                    <div class="col-md-3 mb-4 form-group">
                        <label class="form-label">Check Out Time</label><br>
                        <span class="text-muted sheet_view_checkOut_time">Human Resources</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<?php $this->load->view('team_leader/layout/mobile_header') ?>
<?php if ($this->teamleader->getInfo()) {
    $info = explode("--", $this->teamleader->getInfo());
    $info_type = $info[0];
    $msg_data = $info[1];
    if ($info_type == 1) {
?>
        <script>
            toastr.success("<?php echo $msg_data; ?>");
        </script>

    <?php } else { ?>
        <script>
            toastr.error("<?php echo $msg_data; ?>");
        </script>
    <?php } ?> <?php $this->teamleader->removeInfo();
            }
                ?>
<div class="header-part">
    <div class="d-flex justify-content-between align-items-center">
        <div class="title-part">
            <h2>
                <b>BS</b> Team Leader
            </h2>
            <p>Attendance</p>
        </div>
        <div class="dropdown d-inline-block">
            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="18" cy="15" r="4.5" fill="#35B366"></circle>
                    <circle cx="18" cy="18" r="13.5" stroke="#FFCD02" stroke-width="1.2"></circle>
                    <path
                        d="M26.8078 28.2124C26.9233 28.1202 26.9699 27.9654 26.9178 27.827C26.354 26.3277 25.2201 25.0059 23.6721 24.0499C22.0449 23.0448 20.0511 22.5 18 22.5C15.9489 22.5 13.9551 23.0448 12.3279 24.0498C10.7799 25.0059 9.64599 26.3277 9.08216 27.827C9.03013 27.9654 9.07672 28.1202 9.1922 28.2124C14.3429 32.3279 21.6571 32.3279 26.8078 28.2124Z"
                        fill="white" stroke="#35B366" stroke-width="1.2" stroke-linecap="round"></path>
                </svg>
                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <!-- item-->
                <a class="dropdown-item" href="javascript:void(0)">
                    <i class="mdi mdi-account-circle-outline font-size-16 align-middle me-1"></i> Profile </a>
                <a class="dropdown-item d-block" href="javascript:void(0)">
                    <i class="mdi mdi-cog-outline font-size-16 align-middle me-1"></i> Change Password </a>
                <!--<a class="dropdown-item" href="javascript: void(0);"><i class="mdi mdi-lock-open-outline font-size-16 align-middle me-1"></i> Lock screen</a>-->
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" href="<?php echo base_url('gate-keeper/logout');?>">
                    <i class="mdi mdi-power font-size-16 align-middle me-1 text-danger"></i> Logout </a>
            </div>
        </div>
    </div>
</div>
<div class="container mt-3">
    <div class="row">
        <div class="col-sm-12  p-1">
            <div class="newbtn text-right mb-3">
                <a href="<?php echo base_url('team-leader/vehicle/print-timesheet?emp=' . $this->input->get('emp') . '&platform=' . $this->input->get('platform') . '&camp=' . $this->input->get('camp') . '&from=' . $this->input->get('from') . '&to=' . $this->input->get('to')); ?>" class="card-link theme-btn-small" target="_blank">
                    Print Attendance</a>
                <a href="javascript:void(0)" class="card-link theme-btn-small" data-bs-toggle="modal" data-bs-target="#attendanceFormModal">
                   <i class="fa fa-plus"></i> Attendance</a>
            </div>
            <div class="card form-card-new">
                <div class="card-body">
                    <h5 class="card-title">Search</h5>
                    <form action="<?php echo base_url('team-leader/vehicle/get-timesheet'); ?>" method="get" id="filterForm">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Employee</label>
                            <select class="form-control select2" name="emp" id="">
                                <option value="">[Any]</option>
                                <?php foreach ($employees as $emp) { ?>
                                    <option value="<?php echo $emp->id; ?>" <?php echo $this->input->get('emp') == $emp->id ? 'selected' : ''; ?>> <?php echo $emp->full_name; ?> (<?php echo $emp->emp_no; ?>)</option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="exampleFormControlTextarea1" class="form-label">Date Range:</label>
                                    <div class="input-daterange input-group" id="datepicker5" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker5'>
                                        <input type="text" class="form-control" id="_from" name="from" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" autocomplete="off" placeholder="Start Date" max="<?php echo date('Y-m-d'); ?>" />
                                        <input type="text" class="form-control" id="_to" name="to" value="<?php echo $this->input->get('to') ? $this->input->get('to') : ''; ?>" autocomplete="off" placeholder="End Date" max="<?php echo date('Y-m-d'); ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="button-set">
                            <a href="<?php echo base_url('team-leader/vehicle/get-timesheet'); ?>" class="card-link danger-red">Reset Filter</a>
                            <button type="submit" class="card-link theme-btn-small">Apply Filter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card card-shift">
                <div class="card-body">
                    <div id="scheduledShiftTable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="teamMembers-new new-table table-responsive">
                            <table id="timesheeTableMobile" class="table table-striped table-bordered jambo_table bulk_action dataTable no-footer dtr-inline collapsed" style="width: 100%;" role="grid" aria-describedby="scheduledShiftTable_info">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" rowspan="1" colspan="1" aria-label="S.No.">S.No.</th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Emp Name">Emp No</th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Emp No">Employee Name</th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Emp Name">Vehicle No</th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="display: none;" aria-label="Team">
                                            Platform</th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="display: none;" aria-label="Date">
                                            Out Time</th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="display: none;"
                                            aria-label="Shift">Km</th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="display: none;"
                                            aria-label="Start Time">Battery(%)</th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="display: none;"
                                            aria-label="End Time">Tools</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="attendanceFormModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="attendanceFormModalLabel" aria-hidden="true">
    <div class="modal-dialog team-leader">
        <div class="modal-content custom-content">
            <div class="modal-header shift-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M4 12L3.29289 11.2929L2.58579 12L3.29289 12.7071L4 12ZM19 13C19.5523 13 20 12.5523 20 12C20 11.4477 19.5523 11 19 11V13ZM9.29289 5.29289L3.29289 11.2929L4.70711 12.7071L10.7071 6.70711L9.29289 5.29289ZM3.29289 12.7071L9.29289 18.7071L10.7071 17.2929L4.70711 11.2929L3.29289 12.7071ZM4 13H19V11H4V13Z"
                            fill="#33363F"></path>
                    </svg>
                </button>
                <h5 class="modal-title custom-header-title" id="attendanceFormModalLabel">Rider Attendance</h5>
            </div>
            <div class="modal-body new-shift">
                <div class="mt-4" id="viewTeamLeaderInformation">
                    <form id="empCheckMobile" class="search-demo" action="<?php echo base_url('team-leader/vehicle/check_employee'); ?>" method="post" data-parsley-validate>
                        <label for="exampleFormControlInput1" class="form-label">Employee Id</label>
                        <input class="form-control" type="text" name="employee_no" required>
                        <p id="empCheckMsgMobile" class="mt-1"></p>
                        <div class="btn-high  text-center mt-2">
                            <button class="btn btn-success samll-theme" type="submit">Search</button>
                        </div>
                    </form>
                    <div class="mt-5" id="empDetailsMobile">
                        <!-- Employee Data For Attendance -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('team_leader/layout/mobile_footer') ?>
<script type="text/javascript">
    $(function() {
        var today = new Date();
        $('.input-daterange').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            endDate: "today",
            maxDate: today
        }).on('changeDate', function(ev) {
            $(this).datepicker('hide');
        });

        $('.checkAll').click(function() {
            if (this.checked) {
                $(".checkboxesall").prop("checked", true);
            } else {
                $(".checkboxesall").prop("checked", false);
            }
        });

        $(".checkboxesall").click(function() {
            var numberOfCheckboxes = $(".checkboxesall").length;
            var numberOfCheckboxesChecked = $('.checkboxesall:checked').length;
            if (numberOfCheckboxes == numberOfCheckboxesChecked) {
                $(".checkAll").prop("checked", true);
            } else {
                $(".checkAll").prop("checked", false);
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#timesheet-table,#timesheeTableMobile').dataTable({
            "lengthMenu": [
                [25, 50, 100, 500],
                [25, 50, 100, 500]
            ],
            dom: 'Blfrtip',
            buttons: [{
                    extend: "copy",
                    className: "btn-md"
                },
                {
                    extend: "csv",
                    className: "btn-md"
                },
                {
                    extend: "excel",
                    className: "btn-md"
                },
                {
                    extend: "pdfHtml5",
                    className: "btn-md"
                },
                {
                    extend: "print",
                    className: "btn-md"
                },
            ],
            processing: true,
            serverSide: true,
            responsive: true,
            fixedHeader: true,
            searching: false,
            ajax: {
                url: "<?php echo base_url('team-leader/vehicle/get-list?emp=' . $this->input->get('emp') . '&from=' . $this->input->get('from') . '&to=' . $this->input->get('to')); ?>",
                type: "POST",
                error: function(request, error) {
                    console.log(" Can't do because: " + JSON.stringify(request));
                },
            },

            columnDefs: [{
                targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, ],
                orderable: false,
            }, ],
        });
    });
</script>