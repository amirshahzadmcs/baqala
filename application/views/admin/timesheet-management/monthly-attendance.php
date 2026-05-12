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

    @media only screen and (max-width: 600px) {
        .modal-dialog-aside {
            width: 100% !important;
            max-width: 100% !important;
        }

        .employee-detail {
            display: block !important;
        }

        .employee-detail .image {
            text-align: center;
            margin-top: 10px;
        }
    }

    .modal-dialog-aside {
        width: 25%;
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
<div class="page-title-box">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-title">
                    <h4>Daily Timesheet Summary</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/vehicle/get-daily-timesheet'); ?>">Daily Timesheet Summary</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="float-end d-sm-block">
                    <?php if (check_action_permission(get_user_role(), 'attendance_report', 'print_attendance_summary')): ?>
                        <a type="button" data-bs-toggle="modal" data-bs-target="#filterModal" class="btn btn-custom-success btn-sm pull-right me-1">Print Timesheet</a>
                    <?php endif; ?>
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
                        <form action="<?php echo base_url('admin/vehicle/get-daily-timesheet'); ?>" method="get" id="filter_form">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group mb-2">
                                        <label>Employee Id</label>
                                        <select class="form-control select2" name="emp">
                                            <option value="">[Any]</option>
                                            <?php foreach ($employees as $emp) { ?>
                                                <option value="<?php echo $emp->id; ?>" <?php echo $this->input->get('emp') == $emp->id ? 'selected' : ''; ?>><?php echo $emp->emp_no; ?> - <?php echo $emp->full_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group mb-2">
                                        <label>Platform</label>
                                        <select class="form-control select2" name="platform">
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
                                        <select class="form-control select2" name="camp">
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
                            if (!empty($this->input->get('from'))) {
                                $adv_show = true;
                            }
                            if (!empty($this->input->get('to'))) {
                                $adv_show = true;
                            }
                            if (!empty($this->input->get('attendance_status'))) {
                                $adv_show = true;
                            }
                            ?>
                            <div class="collapse <?php if ($adv_show) {
                                                        echo ' show';
                                                    } ?>" id="advanceFilter">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group mb-2">
                                            <label>Date of</label>
                                            <div class="input-group" id="datepicker2">
                                                <input type="text" class="form-control" name="from" placeholder="dd M, yyyy"
                                                    data-date-format="dd M, yyyy" data-date-container='#datepicker2' data-provide="datepicker"
                                                    data-date-autoclose="true" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group mb-2">
                                            <label>Attendance Status</label>
                                            <select class="form-control select2" name="attendance_status">
                                                <option value="">[Any]</option>
                                                <option value="P" <?php echo $this->input->get('attendance_status') == 'P' ? 'selected' : ''; ?>>Present</option>
                                                <option value="A" <?php echo $this->input->get('attendance_status') == 'A' ? 'selected' : ''; ?>>Absent</option>
                                            </select>
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
                                    <a href="<?php echo base_url('admin/vehicle/get-daily-timesheet'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row px-2 mb-1">
                            <?php
                            $total_row = 0;
                            $present_row = 0;
                            $absent_row = 0;
                            foreach ($timesheet as $data) {
                                $total_row++;
                                (!empty($data->out_time)) ? $present_row++ : $absent_row++;
                            }
                            ?>
                            <div class="col color-box bg-secondary p-2 rounded m-1">
                                <h6 class="my-1 text-white text-center">Date</h6>
                                <h5 class="my-1 text-white text-center"><?php echo date('d-m-Y', strtotime($start_date)); ?></h5>
                            </div>
                            <div class="col color-box bg-info p-2 rounded m-1">
                                <h6 class="my-1 text-white text-center">Total</h6>
                                <h5 class="my-1 text-white text-center"><?php echo $total_row; ?></h5>
                            </div>
                            <div class="col color-box bg-success p-2 rounded m-1">
                                <h6 class="my-1 text-white text-center">Present</h6>
                                <h5 class="my-1 text-white text-center"><?php echo $present_row; ?></h5>
                            </div>
                            <div class="col color-box bg-warning p-2 rounded m-1">
                                <h6 class="my-1 text-white text-center">Absent</h6>
                                <h5 class="my-1 text-white text-center"><?php echo $absent_row; ?></h5>
                            </div>
                        </div>
                        <form id="myform" name="myform" method="post" action="">
                            <table id="timesheet-table" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
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
                                        <th>Working Hours</th>
                                        <th>Final Delivery</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $item_row = 1;
                                    foreach ($timesheet as $data) { ?>
                                        <tr class="<?php echo (!empty($data->out_time)) ? 'text-normal' : 'text-danger'; ?>">
                                            <td valign="top" style="text-align: center;"><?php echo $item_row; ?></td>
                                            <td valign="top" style="text-align: left;"><?php echo $data->emp_no; ?></td>
                                            <td valign="top" style="text-align: left;"><?php echo $data->employee_name; ?></td>
                                            <td valign="top" style="text-align: center;"><?php echo strtoupper($data->vehicle_no); ?></td>
                                            <td valign="top" style="text-align: center;"><?php echo $data->company_name; ?></td>
                                            <td valign="top" style="text-align: center;"><?php echo (!empty($data->out_time)) ? date('d-m-Y', strtotime($data->out_time)) : date('d-m-Y', strtotime($start_date)); ?></td>
                                            <td valign="top" style="text-align: center;"><?php echo (int)$data->out_km; ?></td>
                                            <td valign="top" style="text-align: center;"><?php echo $data->out_battery; ?></td>
                                            <td valign="top" style="text-align: center;"><?php echo $data->working_hours; ?></td>
                                            <td valign="top" style="text-align: center;"><?php echo $data->completed_deliveries; ?></td>
                                        </tr>
                                    <?php $item_row = $item_row + 1;
                                    } ?>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
</div>

<div class="modal fade staticBackdrop fixed-left filterModal" id="filterModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="#filterModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-aside">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="filterModalLabel">Print Attendance Summary</h5>
                <button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('admin/vehicle/print-daily-attendance'); ?>" target="_blank" method="get" id="filterForm">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group mb-2">
                                <label>Employee Id</label>
                                <select class="form-control select2" name="emp">
                                    <option value="">[Any]</option>
                                    <?php foreach ($employees as $emp) { ?>
                                        <option value="<?php echo $emp->id; ?>" <?php echo $this->input->get('emp') == $emp->id ? 'selected' : ''; ?>><?php echo $emp->emp_no; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group mb-2">
                                <label>Platform</label>
                                <select class="form-control select2" name="platform">
                                    <option value="">[Any]</option>
                                    <?php foreach ($platforms as $platform) { ?>
                                        <option value="<?php echo $platform->id; ?>" <?php echo $this->input->get('platform') == $platform->id ? 'selected' : ''; ?>><?php echo $platform->company_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group mb-2">
                                <label>Location</label>
                                <select class="form-control select2" name="camp">
                                    <option value="">[Any]</option>
                                    <?php foreach ($camps as $camp) { ?>
                                        <option value="<?php echo $camp->id; ?>" <?php echo $this->input->get('camp') == $camp->id ? 'selected' : ''; ?>><?php echo $camp->camp_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group mb-2">
                                <label>Date of<span class="text-danger">*</span></label>
                                <div class="input-group" id="datepicker2_1">
                                    <input type="text" class="form-control" name="from" placeholder="dd M, yyyy"
                                        data-date-format="dd M, yyyy" data-date-container='#datepicker2_1' data-provide="datepicker"
                                        data-date-autoclose="true" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group mb-2">
                                <label>Attendance Status</label>
                                <select class="form-control select2" name="attendance_status">
                                    <option value="">[Any]</option>
                                    <option value="P" <?php echo $this->input->get('attendance_status') == 'P' ? 'selected' : ''; ?>>Present</option>
                                    <option value="A" <?php echo $this->input->get('attendance_status') == 'A' ? 'selected' : ''; ?>>Absent</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="filterForm" class="btn btn-custom-success">Print Summary</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

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
    // $(document).ready(function() {
    // 	$('#filterModal').on('shown.bs.modal', function () {
    // 		$('#datepicker2_1').datepicker({
    // 			format: "dd M, yyyy",
    // 			autoclose: true,
    // 			container: '#filterModal'
    // 		});
    // 	});
    // });
    /*
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
                url: "<?php echo base_url('admin/vehicle/get-daily-ajax-list?emp=' . $this->input->get('emp') . '&platform=' . $this->input->get('platform') . '&camp=' . $this->input->get('camp') . '&from=' . $this->input->get('from') . '&to=' . $this->input->get('to') . '&attendance_status=' . $this->input->get('attendance_status')); ?>",
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
    });*/
</script>