<?php $this->load->view('admin/home/header'); ?>
<style>
    .dataTables_wrapper::-webkit-scrollbar {
        display: none;
    }

    .nav-md .container.body .right_col {
        padding: 10px 10px 0;
        margin-left: 230px;
    }

    .plus__btn span.select2.select2-container.select2-container--default {
        width: 96% !important;
    }
</style>

<!-- start page title -->
<div class="page-title-box">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-title">
                    <h4>Model</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/asset/all-models'); ?>">Model</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
            </div>
            <?php $admin_id = $this->session->userdata('admin_id'); ?>

            <div class="col-sm-6">
                <div class="float-end d-sm-block">
                    <a href="javascript:;" class="btn btn-custom-danger btn-sm pull-right me-1" onclick="location.reload()"> <i class="fas fa-sync"></i> </a>
                    <?php if (check_action_permission(get_user_role(), 'model', 'create_model')): ?>
                        <a href="javascript:;" data-bs-target="#modelModal" data-bs-toggle="modal" class="btn btn-custom-success btn-sm pull-right me-1"> <i class="fa fa-plus"></i> Create</a>
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
                    <div class="card-body">
                        <form id="myform" name="myform" method="post" action="">
                            <table id="asset-table" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Model Name</th>
                                        <th>Model Name(AR)</th>
                                        <th>Created By</th>
                                        <th>Brand</th>
                                        <th>Date of Entry</th>
                                        <th>Tools</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($models as $model) { ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $model->model_name; ?></td>
                                            <td><?php echo $model->model_ar_name; ?></td>
                                            <td><?php echo $model->model_created_by; ?></td>
                                            <td><?php echo $model->brand_name; ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($model->model_created_at)); ?></td>
                                            <td>
                                                <?php if (check_action_permission(get_user_role(), 'model', 'update_model')): ?>
                                                    <a class="btn btn-outline-secondary btn-custom-light btn-sm edit admin_edit_asset_model" title="Edit" href="javascript:void(0)" <?php echo 'model_id=' . $model->model_id . ' model_brand_id=' . $model->model_brand_id; ?> model_name="<?php echo $model->model_name; ?>" model_ar_name="<?php echo $model->model_ar_name; ?>">
                                                        <i class="mdi mdi-pencil font-size-18"></i>
                                                    </a>
                                                <?php endif;
                                                if (check_action_permission(get_user_role(), 'model', 'delete_model')): ?>
                                                    <a class="btn btn-outline-danger btn-custom-light btn-sm edit pt-1 pb-1 pr-2 pl-2" title="Delete" href="admin/asset/delete-model?id=<?php echo $model->model_id; ?>">
                                                        <i class="fas fa-trash-alt font-size-18"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <a class="btn btn-outline-info btn-custom-light btn-sm edit admin_view_model" title="View" href="javascript:void(0)" model_brand_name="<?php echo $model->brand_name; ?>" model_name="<?php echo $model->model_name; ?>" model_ar_name="<?php echo $model->model_ar_name; ?>">
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

<!-- department add Modal -->
<div class="modal fade " id="modelModal" role="dialog" aria-labelledby="modelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mt-0">Add Model</h5>
                </div>
                <div>
                    <!-- <a href="#" class="btn btn-sm" ><i class="fas fa-pencil-alt"></i></a> -->
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">

                <form id="admin_add_model" method="post" action="<?php echo base_url('admin/asset/create-model') ?>" data-toggle="validator" role="form" enctype="multipart/form-data">
                    <div class="row">
                        <input type="hidden" class="model_id" name="model_id" value="">
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Model Name</label>
                            <input id="instruction" name="model_name" type="text" class="form-control model_name" />
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Model Name Arabic</label>
                            <input id="instruction" name="model_ar_name" type="text" class="form-control model_ar_name" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group">
                            <div class="brand__main__option">
                                <div class="mt-3">
                                    <label class="form-label">Brand</label>
                                    <div class="plus__btn d-flex align-items-center">
                                        <select class="form-control select2 model_brand_id" name="model_brand_id">
                                            <option value="">Select an Option</option>
                                            <?php foreach ($brands as $brand) { ?>
                                                <option value="<?php echo $brand->brand_id; ?>"><?php echo $brand->brand_name; ?></option>
                                            <?php } ?>
                                        </select>
                                        <a href="javascript:;" class="btn btn-outline-secondary btn-custom-light btn-sm pt-2 pb-2 pl-2 pr-2" data-bs-target="#brandModal" data-bs-toggle="modal"><i class="fas fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="admin_add_model" class="btn btn-success submit_button">Submit</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Model View Modal -->
<div class="modal fade " id="modelViewModal" role="dialog" aria-labelledby="modelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mt-0">Model Details</h5>
                </div>
                <div>
                    <!-- <button type="button" class="btn btn-sm" ><i class="fas fa-pencil-alt"></i></button> -->
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-4 form-group">
                        <label class="form-label">Model Name</label><br>
                        <span class="text-muted model_view_name">Human Resources</span>
                    </div>
                    <div class="col-md-6 mb-4 form-group">
                        <label class="form-label">Model Name Arabic</label><br>
                        <span class="text-muted model_view_ar_name">Human Resources</span>
                    </div>
                    <div class="col-md-6 mb-4 form-group">
                        <label class="form-label">Brand</label><br>
                        <span class="text-muted model_view_brand"></span>
                    </div>
                </div>
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
                    <!-- <button type="button" class="btn btn-sm" ><i class="fas fa-pencil-alt"></i></button> -->
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

<!-- brand add Modal -->
<div class="modal fade " id="brandModal" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mt-0">Add Brand</h5>
                </div>
                <div>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">

                <form id="demo-form2" method="post" action="" data-toggle="validator" role="form" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Brand Name <span class="text-danger">*</span></label>
                            <input id="instruction" name="" type="text" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Brand Name Arabic <span class="text-danger">*</span></label>
                            <input id="instruction" name="" type="text" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Applicable to categories <span class="text-danger">*</span></label>
                            <p>The brand will be visible when adding an asset under these categories only. Leave blank to show this brand for all categories</p>
                            <input name="category" type="text" class="form-control easyui-combotree" data-options="url:'<?php echo base_url("admin/asset/get-category"); ?>',method:'get',labelPosition:'top',collapsible:true,multiple:true" />
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
<div class="modal fade " id="updatebrandModal" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mt-0">Update Brand</h5>
                </div>
                <div>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">

                <form id="demo-form2" method="post" action="" data-toggle="validator" role="form" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Brand Name <span class="text-danger">*</span></label>
                            <input id="instruction" name="" type="text" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Brand Name Arabic <span class="text-danger">*</span></label>
                            <input id="instruction" name="" type="text" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Applicable to categories <span class="text-danger">*</span></label>
                            <p>The brand will be visible when adding an asset under these categories only. Leave blank to show this brand for all categories</p>
                            <input id="instruction" name="" type="text" class="form-control" />
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