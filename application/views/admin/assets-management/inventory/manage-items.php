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

    .plus__btn span.select2.select2-container.select2-container--default {
        width: 96% !important;
    }

    .textbox {
        border: 1px solid #cfcfcf !important;
    }
</style>

<!-- start page title -->
<div class="page-title-box">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-title">
                    <h4>Items</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">List of Items</li>
                    </ol>
                </div>
            </div>
            <?php $admin_id = $this->session->userdata('admin_id'); ?>
            <div class="col-sm-6">
                <div class="float-end d-sm-block">
                    <a href="javascript:;" class="btn btn-custom-danger btn-sm pull-right me-1" onclick="location.reload()"> <i class="fas fa-sync"></i> </a>
                    <?php if (check_action_permission(get_user_role(), 'manage_item', 'print_item')): ?>
                        <a href="<?php echo base_url('admin/asset/inventory/print-item?filterCategory=' . $this->input->get('filterCategory') . '&filterItem=' . $this->input->get('filterItem') . '&filterCode=' . $this->input->get('filterCode') . '&filterSku=' . $this->input->get('filterSku')); ?>" class="btn btn-custom-warning btn-sm pull-right me-1" target="_blank"> <i class="fas fa-print" title="Print"></i> </a>
                    <?php endif;
                    if (check_action_permission(get_user_role(), 'manage_item', 'create_item')): ?>
                        <a href="javascript:;" data-bs-target="#itemModal" data-bs-toggle="modal" class="btn btn-custom-success btn-sm pull-right me-1"> <i class="fa fa-plus"></i> Create</a>
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
                        <form action="<?php echo base_url('admin/asset/inventory/manage-items'); ?>" method="get" id="filter_form">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group mb-2">
                                        <label>Category</label>
                                        <input id="filterCategory" name="filterCategory" type="text" class="form-control easyui-combotree" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group mb-2">
                                        <label>Item Name</label>
                                        <input type="text" class="form-control" name="filterItem" value="<?php echo $this->input->get('filterItem'); ?>">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group mb-2">
                                        <label>Item Code</label>
                                        <input type="text" class="form-control" name="filterCode" value="<?php echo $this->input->get('filterCode'); ?>">
                                    </div>
                                </div>
                            </div>
                            <?php
                            $adv_show = false;
                            if (!empty($this->input->get('filterSku'))) {
                                $adv_show = true;
                            }
                            ?>
                            <div class="collapse <?php if ($adv_show) {
                                                        echo ' show';
                                                    } ?>" id="advanceFilter">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group mb-2">
                                            <label>Item SKU</label>
                                            <input type="text" class="form-control" name="filterSku" value="<?php echo $this->input->get('filterSku'); ?>">
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
                                    <a href="<?php echo base_url('admin/asset/inventory/manage-items'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
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
                            <table id="inventory-table" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
                                <thead>
                                    <tr>
                                        <!-- <th># <input type="checkbox" name="checkAll" class="checkAll checkbox"></th> -->
                                        <th>S.No.</th>
                                        <th>Category</th>
                                        <th>Item Name</th>
                                        <th>Item Name(Ar)</th>
                                        <th>Item Code</th>
                                        <th>SKU</th>
                                        <th>Unit </th>
                                        <th>Image</th>
                                        <th>Description </th>
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

<!-- Item add Modal -->
<div class="modal fade " id="itemModal" role="dialog" aria-labelledby="itemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mt-0">Manage Items</h5>
                </div>
                <div>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">

                <form id="admin_createItem" class="custom-validation" method="post" action="<?php echo base_url('admin/asset/inventory/create-item') ?>" role="form" enctype="multipart/form-data">
                    <input type="hidden" class="itemId" name="item_id">
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Item Code <span class="text-danger">*</span></label>
                            <input name="item_code" type="text" class="form-control item_code" placeholder="Item Code will auto generate" readonly />
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <div class="plus__btn d-flex align-items-center">
                                <input id="itemCategory" name="category" type="text" class="form-control easyui-combotree" />
                                <a href="javascript:;" class="btn btn-outline-secondary btn-custom-light ms-1 pt-2 pb-2 pl-2 pr-2" data-bs-target="#categoryModal" data-bs-toggle="modal"><i class="fas fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Brand <span class="text-danger">*</span></label>
                            <div class="plus__btn d-flex align-items-center">
                                <select id="itemBrand" name="brand" class="form-control select2 item_brand" required data-parsley-errors-container="#brand-errors">
                                    <option value="">Select a Brand</option>
                                </select>
                                <a href="javascript:;" class="btn btn-outline-secondary btn-custom-light ms-1 pt-2 pb-2 pl-2 pr-2" data-bs-target="#brandModal" data-bs-toggle="modal"><i class="fas fa-plus"></i></a>
                            </div>
                            <div id="brand-errors"></div>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">SKU <span class="text-danger">*</span></label>
                            <input name="sku" type="text" class="form-control item_sku" onblur="this.closest('form').id === 'admin_createItem' ? itemSkuCheck(this) : null" required />
                            <span id="itemSkuError" class=""></span>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Item Name <span class="text-danger">*</span></label>
                            <input name="name" type="text" class="form-control item_name" required />
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Item Name Arabic</label>
                            <input name="ar_name" type="text" class="form-control rtl-input item_ar_name" />
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Unit <span class="text-danger">*</span></label>
                            <div class="plus__btn d-flex align-items-center">
                                <select class="form-control select2 item_unit" name="unit" required>
                                    <option value="">Choose ...</option>
                                    <?php foreach ($units as $unit) { ?>
                                        <option value="<?php echo $unit->unit_id ?>"><?php echo $unit->unit_name; ?></option>
                                    <?php } ?>
                                </select>
                                <a href="javascript:;" class="btn btn-outline-secondary btn-custom-light ms-1 pt-2 pb-2 pl-2 pr-2" data-bs-target="#unitModal" data-bs-toggle="modal"><i class="fas fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Description</label>
                            <input type="text" name="description" class="form-control item_description" />
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Image<span class="text-danger ms-3">Image Size(500px * 500px)</span></label>
                            <input type="file" name="image" class="form-control" id="customFile">
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <div class="img_preview">

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="admin_createItem" class="btn btn-success submit_button">Submit</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Item View Modal -->
<div class="modal fade " id="itemViewModal" role="dialog" aria-labelledby="itemViewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mt-0">Manage Items</h5>
                </div>
                <div>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-4 form-group">
                        <label class="form-label">Item Code</label><br>
                        <span class="text-muted item_codeView">4342</span>
                    </div>
                    <div class="col-md-6 mb-4 form-group">
                        <label class="form-label">SKU</label><br>
                        <span class="text-muted item_skuView"></span>
                    </div>

                    <div class="col-md-6 mb-4 form-group">
                        <label class="form-label">Item Name</label><br>
                        <span class="text-muted item_nameView"></span>
                    </div>
                    <div class="col-md-6 mb-4 form-group">
                        <label class="form-label">Item Name Arabic</label><br>
                        <span class="text-muted item_ar_nameView"></span>
                    </div>
                    <div class="col-md-6 mb-4 form-group">
                        <label class="form-label">Category</label><br>
                        <span class="text-muted item_categoryView"></span>
                    </div>
                    <div class="col-md-6 mb-4 form-group">
                        <label class="form-label">Unit</label><br>
                        <span class="text-muted item_unitView"></span>
                    </div>
                    <div class="col-md-6 mb-4 form-group">
                        <label class="form-label">Description</label><br>
                        <span class="text-muted item_descriptionView"></span>
                    </div>
                    <div class="col-md-6 mb-4 form-group">
                        <label class="form-label">Image</label><br>
                        <span class="text-muted item_imagePreview"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<!-- brand add Modal -->
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
        </div>
    </div>
</div>

<!-- category add Modal -->
<div class="modal fade" id="categoryModal" role="dialog" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mt-0">Asset Category</h5>
                </div>
                <div>
                    <a href="<?php echo base_url() ?>admin/application-manage/department-form-builder" class="btn btn-sm"><i class="fas fa-pencil-alt"></i></a>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">

                <form id="addCategoryForm" class="custom-validation" method="post" action="<?php echo base_url('admin/asset/create-category'); ?>" data-toggle="validator" role="form" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Parent Category</label>
                            <p class="mb-0">Select this if the category being added should be a sub-category of the selected category</p>
                            <input class="easyui-combotree form-control" id="parentCategoryId" name="parentCategoryId" style="width:100%;">
                        </div>
                        <input type="hidden" name="category_id" class="category_id" value="">
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Category Name <span class="text-danger">*</span></label>
                            <input id="categoryName" name="categoryName" type="text" class="form-control" data-parsley-error-message="Name Field is Required" required />
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Category Name Arabic</label>
                            <input id="categoryArabicName" name="categoryArabicName" type="text" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Category Code</label>
                            <input id="categoryCode" name="categoryCode" type="text" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label class="control-label" for="address_id" style="width:100%">Default Transfer Duration</label>
                            <p class="mb-0">Value of "Transferred Upto" is pre-filled when transferring assets</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <input id="transferDuration" name="transferDuration" type="text" class="form-control" />
                                </div>
                                <div class="col-md-6">
                                    <select class="form-control select2" name="transferDurationType" id="transferDurationType">
                                        <option>Select</option>
                                        <option value="1">Day(s)</option>
                                        <option value="2">Month(s)</option>
                                        <option value="3">Year(s)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Actual Cost</label>
                            <input id="actualCost" min="0" name="actualCost" type="number" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <div class="d-flex align-items-center">
                                <div>
                                    <label class="control-label" for="address_id" style="width:100%">Cascade</label>
                                    <p class="mb-0">If yes, the same settings will be applied to the child categories as well</p>
                                </div>
                                <div>
                                    <input type="checkbox" id="isCasCade" name="isCasCade" switch="primary" value="1" />
                                    <label for="isCasCade" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <div class="d-flex align-items-center">
                                <div>
                                    <label class="control-label" for="address_id" style="width:100%">Allow Auto Extend</label>
                                    <p class="mb-0">Device validity is automatically extended if the device is scanned within 90 days</p>
                                </div>
                                <div>
                                    <input type="checkbox" id="allowAutoExtend" name="allowAutoExtend" switch="primary" />
                                    <label for="allowAutoExtend" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Billing Cost</label>
                            <input id="billingCost" min="0" name="billingCost" type="number" class="form-control" />
                        </div>
                    </div>

                    <!-- accordien section start here -->
                    <div class="accordion accordion-flush asset_category__main" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="true" aria-controls="flush-collapseOne">
                                    <b>Financial Information</b>
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label class="control-label" for="address_id" style="width:100%">End of Life</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input id="endOfLife" name="endOfLife" type="text" class="form-control" />
                                                </div>
                                                <div class="col-md-6">
                                                    <select class="form-control select2" name="endOfLifeType" id="endOfLifeType">
                                                        <option>Select</option>
                                                        <option value="1">Day(s)</option>
                                                        <option value="2">Month(s)</option>
                                                        <option value="3">Year(s)</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label class="control-label" for="dep" style="width:100%">Depreciation %</label>
                                            <input id="depreciation" name="depreciation" type="number" class="form-control" maxlength="10" min="0" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label class="control-label" for="scrap_value" style="width:100%">Scrap Value</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input id="scrapValue" type="text" name="scrapValue" class="form-control" maxlength="10" />
                                                </div>
                                                <div class="col-md-6">
                                                    <select class="form-control select2" name="scrapValueType" id="scrapValueType">
                                                        <option>Select an option</option>
                                                        <option value="1">Percentage(%)</option>
                                                        <option value="2">Amount</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label class="control-label" for="depreciationTaxPct" style="width:100%">Income Tax Depreciation%</label>
                                            <input id="depreciationTaxPct" name="depreciationTaxPct" type="number" class="form-control" maxlength="10" min="0" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                    <b> Default Activity Schedules For Assets In This Category</b>
                                </button>
                            </h2>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <h5>Details</h5>
                                    <p>Below schedules will be created whenever the assets are added in this category</p>
                                    <div class="row" id="detail">

                                        <div class="col-md-12 detail__inner" id="activityInner">
                                            <?php $dattribute_row = 1; { ?>
                                                <div class="card" id="dattribute-row">
                                                    <div class="card-body cardSection">
                                                        <div class="row assignee_based_on__main">
                                                            <div class="col-md-6 mb-3 form-group">
                                                                <div>
                                                                    <h5 class="font-size-14 mb-2">Assignee Based On</h5>
                                                                    <div class="form-check mb-1">
                                                                        <input class="form-check-input user__involved" onchange="user__involved(this)" type="radio" name="tvpActivity[0][activity_assignee_type]" id="tvpActivity[0][activity_assignee_type]1" value="1">
                                                                        <label class="form-check-label user__involved" for="tvpActivity[0][activity_assignee_type]1">
                                                                            Users Involved
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input user__role" onchange="user__role(this)" type="radio" name="tvpActivity[0][activity_assignee_type]" id="tvpActivity[0][activity_assignee_type]2" value="2">
                                                                        <label class="form-check-label user__role" for="tvpActivity[0][activity_assignee_type]2">
                                                                            User Role
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 mb-3 form-group user_role__hide">
                                                                <label class="control-label" for="address_id" name="tvpActivity[0][activity_user_type]" style="width:100%">User Type</label>
                                                                <select class="form-control select2">
                                                                    <option value="0">Select</option>
                                                                    <option value="1">Created To</option>
                                                                    <option value="2">Alloted To</option>
                                                                    <option value="3">Category Head</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row assignee_based_on__main">
                                                            <div class="row involved__hide">
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="control-label" for="activity_assignee_role" style="width:100%">Assignee Role</label>
                                                                    <select class="form-control select2" name="tvpActivity[0][activity_assignee_role]" onchange="getAssignee(this)">
                                                                        <option value="0">Select an Option</option>
                                                                        <?php foreach ($roles as $role) { ?>
                                                                            <option value="<?php echo $role->id; ?>"><?php echo $role->name; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="control-label" for="activity_assignee" style="width:100%">Assignee</label>
                                                                    <select class="form-control select2 assigneeOption" name="tvpActivity[0][activity_assignee]">
                                                                        <option value="0">Select an Option</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="control-label" for="activity_type_id" style="width:100%">Activity Type</label>
                                                                <select class="form-control select2" name="tvpActivity[0][activity_type_id]">
                                                                    <option value="0">Select an Option</option>
                                                                    <option value="1">Calibration</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="control-label" for="activity_occurs" style="width:100%">Occurs</label>
                                                                <select class="form-control select2" name="tvpActivity[0][activity_occurs]">
                                                                    <option value="0">Select an Option</option>
                                                                    <option value="1">Daily</option>
                                                                    <option value="2">Weekly</option>
                                                                    <option value="3">Mothly</option>
                                                                    <option value="4">Yearly</option>
                                                                    <option value="5">One Time</option>
                                                                    <option value="6">Custom</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="control-label" for="activity_start_after" style="width:100%">Start Schedule After (Days)</label>
                                                                <p style="font-size:13px;">The first activity will be created on these many days after the date in "Schedule based on". Leave blank or 0 to create the first activity on the same date</p>
                                                                <input name="tvpActivity[0][activity_start_after]" type="number" class="form-control" />
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="control-label" for="activity_reminder" style="width:100%">Activity Reminders</label>
                                                                <select class="form-control select2" name="tvpActivity[0][activity_reminder]">
                                                                    <option value="0">Select an Option</option>
                                                                    <option value="1">Same day</option>
                                                                    <option value="2">1 day before</option>
                                                                    <option value="3">2 day before</option>
                                                                    <option value="4">3 day before</option>
                                                                    <option value="5">4 day before</option>
                                                                    <option value="6">5 day before</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="control-label" for="activity_schedule" style="width:100%">Schedule Based On</label>
                                                                <p style="font-size:13px;">Select the date which should be used as the start date of the schedule</p>
                                                                <select class="form-control select2" name="tvpActivity[0][activity_schedule]">
                                                                    <option value="0">Select an Option</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="control-label" for="activity_custom_days" style="width:100%">Custom Days</label>
                                                                <p style="font-size:13px;">Enter the number of days when the schedule should recur. For ex, 15 for fortnightly, 60 for bi-monthly, 180 for half yearly</p>
                                                                <input name="tvpActivity[0][activity_custom_days]" type="number" class="form-control" maxlength="10" min="0" />
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 text-end">
                                                                <hr>
                                                                <button class="btn btn-outline-info btn-custom-light" onclick="adddAttribute(event);"><i class="fas fa-plus"></i></button>
                                                                <button class="btn btn-outline-danger btn-custom-light" onclick="remove_dattribute(<?php echo $dattribute_row; ?>)"><i class="mdi mdi-close-thick"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php $dattribute_row = $dattribute_row + 1;
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                    <b>Deafult Sevice vendor Mapping</b>
                                </button>
                            </h2>
                            <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label class="control-label" for="address_id" style="width:100%">Default Vendor</label>
                                            <select class="form-control select2" name="defaultVendor">
                                                <option>Select an Option</option>
                                                <option value="AMC Vendor">AMC Vendor</option>
                                                <option value="Asset Vendor">Asset Vendor</option>
                                                <option value="Warrenty Vendor">Warrenty Vendor</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label></label>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <label class="control-label" for="autoassigns" style="width:100%">Auto Assign</label>
                                                </div>
                                                <div>
                                                    <input type="checkbox" id="autoassigns" switch="primary" value="1" name="autoAssign" />
                                                    <label for="autoassigns" data-on-label="Yes" data-off-label="No"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- accordien section end here -->

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="addCategoryForm" class="btn btn-success submit_button">Submit</button>
            </div>
        </div>
    </div>
</div>

<!-- unit add Modal -->
<div class="modal fade " id="unitModal" role="dialog" aria-labelledby="unitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mt-0">Add Unit</h5>
                </div>
                <div>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">

                <form id="admin_add_unit" class="custom-validation" method="post" action="<?php echo base_url('admin/asset/inventory/create-unit'); ?>" data-toggle="validator" role="form" enctype="multipart/form-data">
                    <div class="row">
                        <input type="hidden" class="unit_id" name="unit_id" value="">
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input id="unitName" name="unit_name" type="text" class="form-control unit_name" data-parsley-error-message="Name Field is Required" required />
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Arabic Name</label>
                            <input id="unitArName" name="unit_ar_name" type="text" class="form-control unit_ar_name" />
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Description</label>
                            <input id="unitDescription" name="unit_description" type="text" class="form-control unit_description" />
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="admin_add_unit" class="btn btn-success submit_button">Submit</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<?php $this->load->view('admin/home/footer'); ?>
<script type="text/javascript">
    let table;
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
        var table = $('#inventory-table').dataTable({
            "lengthMenu": [
                [25, 50, 100, 500],
                [25, 50, 100, 500]
            ],
            dom: 'Blfrtip',
            buttons: [{
                    extend: "copy",
                    className: "btn-md",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                    }
                },
                {
                    extend: "csv",
                    className: "btn-md",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                    }
                },
                {
                    extend: "excel",
                    className: "btn-md",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],

                    }
                },
                {
                    extend: "pdfHtml5",
                    className: "btn-md",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                    }
                },
                {
                    extend: "print",
                    className: "btn-md",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                    },
                    action: function(e, dt, button, config) {
                        // Custom action to export all data
                        alert('hello data');
                        exportAllData();
                    }
                },
            ],
            processing: true,
            serverSide: true,
            responsive: true,
            fixedHeader: true,
            searching: true,
            ordering: false,
            paging: true,
            ajax: {
                url: "<?php echo base_url('admin/asset/inventory/get-items?filterCategory=' . $this->input->get('filterCategory') . '&filterItem=' . $this->input->get('filterItem') . '&filterCode=' . $this->input->get('filterCode') . '&filterSku=' . $this->input->get('filterSku')); ?>",
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

    function deleteAlert(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: !0,
            confirmButtonColor: "#1cbb8c",
            cancelButtonColor: "#f14e4e",
            confirmButtonText: "Yes, delete it!"
        }).then(function(t) {
            if (t.value) {
                window.location.href = location.href = "admin/asset/inventory/delete-item?id=" + id;
            }
        })
    }
</script>