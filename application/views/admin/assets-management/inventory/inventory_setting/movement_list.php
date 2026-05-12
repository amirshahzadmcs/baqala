<?php $this->load->view('admin/home/header'); ?>
<style>
    .dataTables_wrapper::-webkit-scrollbar {
        display: none;
    }

    .nav-md .container.body .right_col {
        padding: 10px 10px 0;
        margin-left: 230px;
    }

    span.textbox.combo {
        width: 100% !important;
    }

    .textbox .textbox-text {
        width: 100% !important;
    }
</style>

<!-- start page title -->
<div class="page-title-box">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-title">
                    <h4>Inventory Movement Status</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/asset/inventory/all-movements'); ?>">Inventory Movement</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
            </div>
            <?php $admin_id = $this->session->userdata('admin_id'); ?>

            <div class="col-sm-6">
                <div class="float-end d-sm-block">
                    <!-- <a href="javascript:;" data-bs-target="#reportwidgetModal" data-bs-toggle="modal" class="btn btn-custom-dark btn-sm pull-right me-1"> <i class="fas fa-file-invoice"></i> </a> -->
                    <!-- <a href="javascript:;" class="btn btn-custom-warning btn-sm pull-right me-1"> <i class="fas fa-download"></i> </a> -->
                    <a href="javascript:;" class="btn btn-custom-danger btn-sm pull-right me-1" onclick="location.reload()"> <i class="fas fa-sync"></i> </a>
                    <!-- <a href="javascript:;" class="btn btn-custom-primary btn-sm pull-right me-1"> <i class="fas fa-sliders-h"></i> </a> -->
                    <a href="javascript:;" data-bs-target="#movementModal" data-bs-toggle="modal" class="btn btn-custom-success btn-sm pull-right me-1"> <i class="fa fa-plus"></i> Create</a>

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
                    <div class="card-body">
                        <form id="myform" name="myform" method="post" action="">
                            <table id="asset-table" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Movement Type</th>
                                        <th>Movement Name</th>
                                        <th>Movement Name(AR)</th>
                                        <th>Created By</th>
                                        <th>Date of Entry</th>
                                        <th>Tools</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($movements as $movement) { ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $movement->movement_type == '1' ? 'Add' : ($movement->movement_type == '2' ? 'Move' : ($movement->movement_type == '3' ? 'Draw' : '')); ?></td>
                                            <td><?php echo $movement->movement_name; ?></td>
                                            <td><?php echo $movement->movement_ar_name; ?></td>
                                            <td><?php echo $movement->movement_created_by; ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($movement->movement_created_at)); ?></td>
                                            <td>
                                                <a class="btn btn-outline-secondary btn-custom-light btn-sm edit admin_edit_movement" title="Edit" href="javascript:void(0)" movement_id="<?php echo $movement->movement_id; ?>" movement_name="<?php echo $movement->movement_name; ?>" movement_ar_name="<?php echo $movement->movement_ar_name; ?>" movement_type="<?php echo $movement->movement_type; ?>">
                                                    <i class="mdi mdi-pencil font-size-18"></i>
                                                </a>
                                                <a class="btn btn-outline-danger btn-custom-light btn-sm edit pt-1 pb-1 pr-2 pl-2" title="Delete" href="<?php echo base_url('admin/asset/inventory/delete-movement?id=' . $movement->movement_id); ?>">
                                                    <i class="fas fa-trash-alt font-size-18"></i>
                                                </a>
                                                <a class="btn btn-outline-info btn-custom-light btn-sm edit admin_view_movement" title="View" href="javascript:void(0)" movement_id="<?php echo $movement->movement_id; ?>" movement_name="<?php echo $movement->movement_name; ?>" movement_type="<?php echo $movement->movement_type; ?>" movement_ar_name="<?php echo $movement->movement_ar_name; ?>" movement_created_by="<?php echo $movement->movement_created_by ?>" movement_created_at="<?php echo date('d-m-Y',strtotime($movement->movement_created_at)); ?>">
                                                    <i class="mdi mdi-eye font-size-18"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
</div>

<!-- movement add Modal -->
<div class="modal fade " id="movementModal" role="dialog" aria-labelledby="movementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mt-0">Add Movement</h5>
                </div>
                <div>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">

                <form id="admin_add_movement" class="custom-validation" method="post" action="<?php echo base_url('admin/asset/inventory/create-movement'); ?>" data-toggle="validator" role="form" enctype="multipart/form-data">
                    <div class="row">
                        <input type="hidden" class="movement_id" name="movement_id" value="">
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Movement Type <span class="text-danger">*</span></label>
                            <select name="movement_type" class="form-select movement_type select2" data-parsley-error-message="Movement Type is Required" required>
                                <option value="">Select an option</option>
                                <option value="1">Add</option>
                                <option value="2">Move</option>
                                <option value="3">Draw</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Movement Name <span class="text-danger">*</span></label>
                            <input id="movementName" name="movement_name" type="text" class="form-control movement_name" data-parsley-error-message="Name Field is Required" required />
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Arabic Name</label>
                            <input id="movementArName" name="movement_ar_name" type="text" class="form-control movement_ar_name" />
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="admin_add_movement" class="btn btn-success submit_button">Submit</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- movement View Modal -->
<div class="modal fade " id="movementViewModal" role="dialog" aria-labelledby="movementsViewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mt-0">Movement Details</h5>
                </div>
                <div>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">

                <form id="demo-form2" method="post" action="" data-toggle="validator" role="form" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-4 form-group">
                            <label class="form-label">Movement Name</label><br>
                            <span class="text-muted movement_view_name">Human Resources</span>
                        </div>
                        <div class="col-md-6 mb-4 form-group">
                            <label class="form-label">Arabic Name</label><br>
                            <span class="text-muted movement_view_ar_name">Human Resources</span>
                        </div>
                        <div class="col-md-6 mb-4 form-group">
                            <label class="form-label">Movement Type</label><br>
                            <span class="text-muted movement_view_type"></span>
                        </div>
                        <div class="col-md-6 mb-4 form-group">
                            <label class="form-label">Date of Entry</label><br>
                            <span class="text-muted movement_view_created_at">25/06/2019 04:54 pm</span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Widget All Edit Modal -->
<div class="modal fade quotation-modal" id="reportwidgetModal" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mt-0">Add Widget</h5>
                </div>
                <div>
                    <button type="button" class="btn btn-sm"><i class="fas fa-pencil-alt"></i></button>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <p class="text-center">Create a custom report, chart or number & percentage widgets here. The charts and widgets created here will be shown in the dashboards. Edit a dashboard and add the widget to be included in the dashboard. The custom reports are available under the Reports menu and then "Custom Reports".</p>
                <form id="demo-form2" method="post" action="" data-toggle="validator" role="form" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Widget Title <span class="text-danger">*</span></label>
                            <input id="instruction" name="instruction" type="text" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label class="control-label" for="customer_id" style="width:100%">Widget Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="" id=""></textarea>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label class="control-label" for="address_id" style="width:100%">Widget Type <span class="text-danger">*</span></label>
                            <select id="address_id" name="address_id" class="form-control select2" required>
                                <option value="">--- Select ---</option>
                                <option value="">Report</option>
                                <option value="">Chart</option>
                                <option value="">Number Widget</option>
                                <option value="">Percentage Widget</option>
                            </select>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="demo-form2" class="btn btn-success">Submit</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->




<?php $this->load->view('admin/home/footer'); ?>


<script>
    $(document).ready(function() {
        $('#asset-table').dataTable({
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
            "responsive": true,
            "serverSide": false,
            fixedHeader: true,
            "ordering": false,
        });

    });
</script>