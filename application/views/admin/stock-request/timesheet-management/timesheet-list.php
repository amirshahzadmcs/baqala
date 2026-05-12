<?php $this->load->view('admin/home/header'); ?>
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
</style>

<!-- start page title -->
<div class="page-title-box">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-title">
                    <h4>Timesheet</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/asset/all-conditions'); ?>">Timesheet</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
            </div>
            <?php $admin_id = $this->session->userdata('admin_id'); ?>

            <div class="col-sm-6">
                <div class="float-end d-sm-block">
                    <a href="javascript:;" class="btn btn-custom-danger btn-sm pull-right me-1" onclick="location.reload()"> <i class="fas fa-sync"></i> </a>
                    <a href="javascript:;" data-bs-target="#monthlyReportViewModal" data-bs-toggle="modal" class="btn btn-custom-warning btn-sm pull-right me-1">Monthly Report</a>
                    <a target="_blank" href="<?php echo base_url('admin/vehicle/print-timesheet?emp=' . $this->input->get('emp') . '&platform=' . $this->input->get('platform') . '&camp=' . $this->input->get('camp') . '&from=' . $this->input->get('from') . '&to=' . $this->input->get('to')); ?>" class="btn btn-custom-success btn-sm pull-right me-1">Print Timesheet</a>
                </div>
                <?php if ($this->admin->getInfo()) {
                    $info = explode("--", $this->admin->getInfo());
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
                    <?php } ?> <?php }
                            $this->admin->removeInfo(); ?>
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
                        <form action="<?php echo base_url('admin/vehicle/get-timesheet'); ?>" method="get" id="filter_form">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group mb-2">
                                        <label>Employee Id</label>
                                        <select class="form-control select2" name="emp" id="">
                                            <option value="">[Any]</option>
                                            <?php foreach ($employees as $emp) { ?>
                                                <option value="<?php echo $emp->id; ?>" <?php echo $this->input->get('emp') == $emp->id ? 'selected' : ''; ?>><?php echo $emp->emp_no; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group mb-2">
                                        <label>Platform</label>
                                        <select class="form-control select2" name="platform" id="">
                                            <option value="">[Any]</option>
                                            <?php foreach ($platforms as $platform) { ?>
                                                <option value="<?php echo $platform->id; ?>" <?php echo $this->input->get('platform') == $platform->id ? 'selected' : ''; ?>><?php echo $platform->company_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group mb-2">
                                        <label>Location</label>
                                        <select class="form-control select2" name="camp" id="">
                                            <option value="">[Any]</option>
                                            <?php foreach ($camps as $camp) { ?>
                                                <option value="<?php echo $camp->id; ?>" <?php echo $this->input->get('camp') == $camp->id ? 'selected' : ''; ?>><?php echo $camp->camp_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $adv_show = false;
                            if (!empty($this->input->get('vat_no'))) {
                                $adv_show = true;
                            }
                            if (!empty($this->input->get('cr_no'))) {
                                $adv_show = true;
                            }
                            if (!empty($this->input->get('from'))) {
                                $adv_show = true;
                            }
                            if (!empty($this->input->get('to'))) {
                                $adv_show = true;
                            }
                            ?>
                            <div class="collapse <?php if ($adv_show) {
                                                        echo ' show';
                                                    } ?>" id="advanceFilter">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group mb-2">
                                            <label>Date Between (From and To)</label>
                                            <div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                                <input type="text" class="form-control" id="_from" name="from" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" autocomplete="off" placeholder="Start Date" />
                                                <input type="text" class="form-control" id="_to" name="to" value="<?php echo $this->input->get('to') ? $this->input->get('to') : ''; ?>" autocomplete="off" placeholder="End Date" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <button class="btn btn-outline-secondary waves-effect waves-light" type="button" data-bs-toggle="collapse" data-bs-target="#advanceFilter" aria-expanded="false" aria-controls="advanceFilter"><i class="fas fa-sliders-h"></i> Advance Search</button>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <button type="submit" class="btn btn-success btn-md float-end ms-2">Apply Filter</button>
                                    <a href="<?php echo base_url('admin/vehicle/get-timesheet'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
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
                                        <th>Working Hours</th>
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
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
</div>

<!-- Vehicle Timesheet add/Edit  Modal -->
<div class="modal fade " id="vehicleModal" data-bs-backdrop="static" role="dialog" aria-labelledby="vehicleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mt-0">Vehicle Timesheet</h5>
                </div>
                <div>
                    <!-- <a href="<?php echo base_url() ?>admin/application-manage/department-form-builder" class="btn btn-sm"><i class="fas fa-pencil-alt"></i></a> -->
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <form id="empCheck" action="<?php echo base_url('admin/vehicle/check_employee'); ?>" method="post" data-parsley-validate>
                    <div class="row justify-content-center">
                        <div class="card bg-light col-md-6">
                            <div class="card-body row" id="empNo">
                                <div class="col-md-8 form-group">
                                    <label class="form-label">Employee Id<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="employee_no" required>
                                </div>
                                <div class="col-md-4 form-group align-content-end">
                                    <button form="empCheck" type="submit" class="btn btn-success submit_button">Submit</button>
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

<!--  Vehichle Timesheet View Modal-->
<div class="modal fade " id="timesheetViewModal" data-bs-backdrop="static" role="dialog" aria-labelledby="timesheetViewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
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
                        <label class="form-label">Check In Km</label><br>
                        <span class="text-muted sheet_view_checkIn_km">Human Resources</span>
                    </div>
                    <div class="col-md-3 mb-4 form-group">
                        <label class="form-label">Check Out Battery(%)</label><br>
                        <span class="text-muted sheet_view_checkOut_battery">Human Resources</span>
                    </div>
                    <div class="col-md-3 mb-4 form-group">
                        <label class="form-label">Check In Battery(%)</label><br>
                        <span class="text-muted sheet_view_checkIn_battery">Human Resources</span>
                    </div>
                    <div class="col-md-3 mb-4 form-group">
                        <label class="form-label">Check Out Time</label><br>
                        <span class="text-muted sheet_view_checkOut_time">Human Resources</span>
                    </div>
                    <div class="col-md-3 mb-4 form-group">
                        <label class="form-label">Check In Time</label><br>
                        <span class="text-muted sheet_view_checkIn_time">Human Resources</span>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!--  Monthly Report Modal-->
<div class="modal fade " id="monthlyReportViewModal" data-bs-backdrop="static" role="dialog" aria-labelledby="monthlyReportViewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mt-0">Monthly Report</h5>
                </div>
                <div>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form id="monthlyReportForm" action="<?php echo base_url('admin/vehicle/print-monthly-report'); ?>" target="_blank" method="post" class="" data-parsley-validate>
                        <div class="mb-4 form-group">
                            <label class="form-label">Emp No</label><br>
                            <select name="emp_id" class="form-control select2" required>
                                <option value="">Select...</option>
                                <?php foreach ($employees as $emp) { ?>
                                    <option value="<?php echo $emp->id; ?>"><?php echo $emp->emp_no; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-4 form-group">
                            <label class="form-label">Month</label><br>
                            <div class="position-relative" id="datepicker4">
                                <input type="text" class="form-control" name="month" data-date-container="#datepicker4" data-provide="datepicker" data-date-format="MM yyyy" data-date-min-view-mode="1" data-date-end-date="-1m" required>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success" form="monthlyReportForm">Submit</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/home/footer'); ?>
<script type="text/javascript">
    $(function() {
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
        $('#timesheet-table').dataTable({
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
                url: "<?php echo base_url('admin/vehicle/get-list?emp=' . $this->input->get('emp') . '&platform=' . $this->input->get('platform') . '&camp=' . $this->input->get('camp') . '&from=' . $this->input->get('from') . '&to=' . $this->input->get('to')); ?>",
                type: "POST",
                error: function(request, error) {
                    console.log(" Can't do because: " + JSON.stringify(request));
                },
            },

            columnDefs: [{
                targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                orderable: false,
            }, ],
        });
    });
</script>