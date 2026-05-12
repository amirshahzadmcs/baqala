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
                    <h4>Brand</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="<?php echo base_url('admin/asset/all-brands'); ?>"></a>Brand</li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
            </div>
            <?php $admin_id = $this->session->userdata('admin_id'); ?>

            <div class="col-sm-6">
                <div class="float-end d-sm-block">
                    <a href="javascript:;" class="btn btn-custom-danger btn-sm pull-right me-1" onclick="location.reload()"> <i class="fas fa-sync"></i> </a>
                    <?php if (check_action_permission(get_user_role(), 'brand', 'create_brand')): ?>
                        <a href="javascript:;" data-bs-target="#brandModal" data-bs-toggle="modal" class="btn btn-custom-success btn-sm pull-right me-1"> <i class="fa fa-plus"></i> Create</a>
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
                                        <th>Brand Name</th>
                                        <th>Brand Name(AR)</th>
                                        <th>Applicable to categories</th>
                                        <th>Date of Entry</th>
                                        <th>Tools</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($brands as $brand) { ?>
                                        <?php $category = array_column(categoryName(json_decode($brand->brand_category_ids)), 'categoryName'); ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $brand->brand_name; ?></td>
                                            <td><?php echo $brand->brand_ar_name; ?></td>
                                            <td><?php echo $brand->categoryNames;
                                                ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($brand->brand_created_at)); ?></td>
                                            <td>
                                                <?php if (check_action_permission(get_user_role(), 'brand', 'update_brand')): ?>
                                                    <a class="btn btn-outline-secondary btn-custom-light btn-sm edit admin_edit_asset_brand" title="Edit" href="javascript:void(0)" brand_id="<?php echo $brand->brand_id; ?>" brand_name="<?php echo $brand->brand_name; ?>" brand_ar_name="<?php echo $brand->brand_ar_name; ?>" brand_category_ids="<?php echo json_encode(array_map('intval', json_decode($brand->brand_category_ids))); ?>">
                                                        <i class="mdi mdi-pencil font-size-18"></i>
                                                    </a>
                                                <?php endif;
                                                if (check_action_permission(get_user_role(), 'brand', 'delete_brand')): ?>
                                                    <a class="btn btn-outline-danger btn-custom-light btn-sm edit pt-1 pb-1 pr-2 pl-2" title="Delete" href="<?php echo base_url('admin/asset/delete-brand?id=' . $brand->brand_id); ?>">
                                                        <i class="fas fa-trash-alt font-size-18"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <a class="btn btn-outline-info btn-custom-light btn-sm edit admin_view_brand" title="View" href="javascript:void(0)" brand_name="<?php echo $brand->brand_name; ?>" brand_ar_name="<?php echo $brand->brand_ar_name; ?>" brand_category_name="<?php echo implode(', ', $category); ?>" brand_created_by="<?php echo $brand->brand_created_by; ?>" brand_created_at="<?php echo date('d-m-Y H:i A', strtotime($brand->brand_created_at)) ?>">
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

<!-- Brand add Modal -->
<div class="modal fade " id="brandModal" role="dialog" aria-labelledby="brandModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mt-0">Add Brand</h5>
                </div>
                <div>
                    <!-- <a href="#" class="btn btn-sm" ><i class="fas fa-pencil-alt"></i></a> -->
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">

                <form id="admin_add_brand" method="post" action="<?php echo base_url('admin/asset/create-brand'); ?>" data-toggle="validator" role="form" enctype="multipart/form-data">
                    <div class="row">
                        <input type="hidden" class="brand_id" name="brand_id" value="">
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Brand Name <span class="text-danger">*</span></label>
                            <input id="instruction" name="brand_name" type="text" class="form-control brand_name" />
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Brand Arabic Name</label>
                            <input id="instruction" name="brand_ar_name" type="text" class="form-control brand_ar_name" />
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Applicable to categories</label>
                            <p>The brand will be visible when adding an asset under these categories only. Leave blank to show this brand for all categories</p>
                            <input id="brandCategory" class="easyui-combotree brand_category_ids" name="brand_category_ids[]" style="width:100%">
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="admin_add_brand" class="btn btn-success submit_button">Submit</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Brand View Modal -->
<div class="modal fade " id="brandViewModal" role="dialog" aria-labelledby="brandViewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mt-0">Brand Details</h5>
                </div>
                <div>
                    <button type="button" class="btn btn-sm"><i class="fas fa-pencil-alt"></i></button>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">

                <form id="demo-form2" method="post" action="" data-toggle="validator" role="form" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-4 form-group">
                            <label class="form-label">Brand Name</label><br>
                            <span class="text-muted brand_view_name">Human Resources</span>
                        </div>
                        <div class="col-md-6 mb-4 form-group">
                            <label class="form-label">Brand Arabic Name</label><br>
                            <span class="text-muted brand_view_ar_name">Human Resources</span>
                        </div>
                        <div class="col-md-6 mb-4 form-group">
                            <label class="form-label">Applicable to categories</label><br>
                            <span class="text-muted brand_view_category"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4 form-group">
                            <label class="form-label">Created By</label><br>
                            <span class="text-muted brand_view_created_by">Support</span>
                        </div>
                        <div class="col-md-6 mb-4 form-group">
                            <label class="form-label">Date of Entry</label><br>
                            <span class="text-muted brand_view_created_at">25/06/2019 04:54 pm</span>
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