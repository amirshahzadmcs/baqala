<?php $this->load->view('admin/home/header'); ?>

<div id="wait"><i class="fa fa-spinner fa-spin"></i><br>Loading..</div>
<style>
    input[type="date"] {
        position: relative;
    }

    input[type="date"]::-webkit-calendar-picker-indicator {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: auto;
        height: auto;
        color: transparent;
        background: transparent;
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
                    <h4>Asset Management</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/sim/list">Asset</a></li>
                        <li class="breadcrumb-item active">Add</li>
                    </ol>
                </div>
            </div>
            <?php $admin_id = $this->session->userdata('admin_id'); ?>
            <div class="col-sm-6">
                <div class="float-end d-sm-block">
                    <a class="btn btn-sm btn-custom-white pull-right ms-2" title="Back" href="<?php echo base_url('admin/asset-manage/all-assets'); ?>"><i class="fa fa-reply"></i> Back</a>

                    <button form="demo-form2" type="submit" class="btn btn-sm btn-custom-success pull-right ms-2" title="Save"><i class="fa fa-save"></i> Save</button>

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
                <?php }
                }
                $this->admin->removeInfo(); ?>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->

<!-- main content -->

<div class="container-fluid">
    <div class="page-content-wrapper">
        <div class="row">
            <div class="panel-body">
                <div class="col-md-8" id="treeview_json">
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="javascript:void(0)"></form>
                        <input type="hidden" id="id" name="id" value="" />

                        <div class="row size-inner-section px-2 py-4">
                            <h4 class="header-title">Add Asset</h4>
                            <hr>
                            <div class="col-md-4 col-4 col-sm-12 mb-3 form-group">
                                <label for="assetName">Asset Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="assetName" name="assetName" required />
                            </div>
                            <div class="col-md-4 col-4 col-sm-12 mb-3 form-group">
                                <label for="assetCode">Asset Code</label>
                                <input type="text" class="form-control" id="assetCode" name="assetCode" maxlength="10" />
                            </div>
                            <div class="col-md-4 col-4 col-sm-12 mb-3 form-group">
                                <label for="assetImage">Asset Image</label>
                                <div class="custom-file">
                                    <input type="file" class="form-control custom-file-input" id="assetImage" name="assetImage">
                                </div>
                            </div>

                            <div class="col-md-4 col-4 col-sm-12 mb-3" style="min-height: 140px;">
                                <div class="form-group">
                                    <label class="control-label" for="categoryId">Category <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input class="form-control easyui-combotree" name="categoryId" data-options="url:'<?php echo base_url("admin/asset/get-category"); ?>',method:'get',labelPosition:'top',collapsible:true" style="width:100%">

                                        <span class="input-group-btn-vertical ms-1">
                                            <button class="btn bg-body input-group-text" type="button"><i class="fas fa-times fa-solid" style="color:red;"></i></button>
                                            <button class="btn bg-body" data-bs-target="#categoryModal" data-bs-toggle="modal" type="button"><i class="fas fa-solid fa-plus" style="color: #63E6BE;"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-4 col-sm-12 mb-3" style="min-height: 140px;">
                                <label class="control-label" for="locationId">Location<span class="text-danger">*</span></label>
                                <div class="input-group d-flex">
                                    <input class="easyui-combotree form-control" name="locationId" data-options="url:'<?php echo base_url("admin/asset/get-locations"); ?>',method:'get',labelPosition:'top',Collapse:true" style="width:100%">
                                    <span class="input-group-btn-vertical ms-1">
                                        <button class="btn bg-body" type="button"><i class="fas fa-times fa-solid" style="color:red;"></i></button>
                                        <button class="btn bg-body" data-bs-target="#locationModal" data-bs-toggle="modal" type="button"><i class="fas fa-solid fa-plus" style="color: #63E6BE;"></i></button>
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12 mb-3" style="min-height: 140px;">
                                <label class="control-label" for="statusId">Status<span class="text-danger">*</span></label>
                                <div class="input-group  bootstrap-touchspin bootstrap-touchspin-injected">
                                    <select class="form-control select2" name="statusId" required>
                                        <option value=""></option>
                                        <?php foreach ($status as $sts) { ?>
                                            <option value="<?php echo $sts->status_id; ?>"><?php echo $sts->status_name; ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="input-group-btn-vertical ms-1">
                                        <button class="btn bg-body" data-bs-target="#statusModal" data-bs-toggle="modal" type="button"><i class="fas fa-solid fa-plus" style="color: #63E6BE;"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div id="accordion" class="custom-accordion">
                            <div class="card mb-1 shadow-none">
                                <a href="#collapseOne" class="text-dark" data-bs-toggle="collapse" aria-expanded="true" aria-controls="collapseOne">
                                    <div class="card-header" id="headingOne">
                                        <h6 class="m-0">
                                            Additional Information
                                            <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                        </h6>
                                    </div>
                                </a>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-bs-parent="#accordion">
                                    <div class="card-body">
                                        <div class="row size-inner-section px-2 py-4">
                                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                <label for="conditionId">Condition</label>
                                                <select class="form-control select2" name="conditionId">
                                                    <option value="">Select an option</option>
                                                    <?php foreach ($conditions as $condition) { ?>
                                                        <option value="<?php echo $condition->condition_id; ?>"><?php echo $condition->condition_name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                <label for="brandId">Brand</label>
                                                <select class="form-control select2" name="brand">
                                                    <option value="">Select an option</option>
                                                    <?php foreach ($brands as $brand) { ?>
                                                        <option value="<?php echo $brand->brand_id ?>"><?php echo $brand->brand_name; ?></option>
                                                    <?php } ?>
                                                </select>

                                            </div>
                                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                <label for="modelId">Model</label>
                                                <select class="form-control select2" name="model">
                                                    <option value="">Select an option</option>
                                                    <?php foreach ($models as $model) { ?>
                                                        <option value="<?php echo $model->model_id ?>"><?php echo $model->model_name; ?></option>
                                                    <?php } ?>
                                                </select>

                                            </div>
                                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                <label for="parentId">Linke Asset</label>
                                                <select class="form-control select2" name="parentId[]" multiple>
                                                    <option value="">Select one or more option(s)</option>
                                                    <?php foreach ($assets as $asset) { ?>
                                                        <option value="<?php echo $asset->asset_id; ?>"><?php echo $asset->asset_name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                <label for="assDescription">Description</label>
                                                <input type="text" class="form-control" id="assDescription" name="assDescription" />

                                            </div>
                                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                <label for="serialNo">Serial No</label>
                                                <input type="text" class="form-control" id="serialNo" name="asset_serial_no" />

                                            </div>
                                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                <label for="fileAttachment">Attach Files</label>
                                                <div class="custom-file">
                                                    <input type="file" class="form-control custom-file-input" name="fileAttachment" id="fileAttachment" required>
                                                    <p class="hint">Additional Documents (For Insurance / Maintenance / Replacements, etc.)</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-1 shadow-none">
                                <a href="#collapseTwo" class="text-dark collapsed" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseTwo">
                                    <div class="card-header" id="headingTwo">
                                        <h6 class="m-0">
                                            Purchase Information
                                            <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                        </h6>
                                    </div>
                                </a>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-bs-parent="#accordion">
                                    <div class="card-body">
                                        <div class="row size-inner-section px-2 py-4">
                                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                <label for="venderId">Vendor Name</label>
                                                <select class="form-control select2" name="venderId">
                                                    <option value="AK" data-select2-id="111">Alaska</option>
                                                    <option value="HI" data-select2-id="112">Hawaii</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                <label for="poNumber">PO Number</label>
                                                <input type="text" class="form-control" id="poNumber" name="poNumber" />
                                            </div>
                                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                <label for="invoiceDate">Invoice Date</label>
                                                <input type="date" class="form-control" id="invoiceDate" name="invoiceDate" />

                                            </div>
                                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                <label for="invoiceNo">Invoice No</label>
                                                <input type="text" class="form-control" id="invoiceNo" name="invoiceNo" />

                                            </div>
                                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                <label for="purchaseDate">Purchase Date</label>
                                                <input type="date" class="form-control" id="purchaseDate" name="purchaseDate" />
                                            </div>
                                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                <label for="purchasePrice">Purchase Price</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text">SAR</span></div>
                                                    <input type="number" class="form-control" id="purchasePrice" name="purchasePrice" maxlength="10" min="0" step="0.01" />
                                                </div>

                                            </div>
                                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                <label for="isPartner">Self Owned / Partner</label>
                                                <div class="input-group">
                                                    <div class="col-md-10">
                                                        <p class="hint">Yes, if the asset is owned by a vendor or customer. Partner owned assets are not shown in depreciation reports</p>

                                                    </div>
                                                    <div class="col-md-2 align-content-center form-check form-switch mb-3" dir="ltr">
                                                        <input type="checkbox" id="isPartner" class="isPartner" data-on="true" data-off="false" switch="bool" name="isPartner"><label for="isPartner" data-on-label="Yes" data-off-label="No"></label>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-0 shadow-none">
                                <a href="#collapseThree" class="text-dark collapsed" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseThree">
                                    <div class="card-header" id="headingThree">
                                        <h6 class="m-0">
                                            Financial Information
                                            <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                        </h6>
                                    </div>
                                </a>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-bs-parent="#accordion">
                                    <div class="card-body">
                                        <div class="row size-inner-section px-2 py-4">
                                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                <label for="capitalizationPrice">Capitalization Price</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text">SAR</span></div>
                                                    <input type="number" class="form-control" id="capitalizationPrice" name="capitalizationPrice" maxlength="10" min="0" step="0.01" />
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                <label for="endofLife">End Of Life</label>
                                                <input type="date" class="form-control" id="endofLife" name="endofLife" />

                                            </div>
                                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                <label for="capitalizationDate">Capitalization Date</label>
                                                <input type="date" class="form-control" id="capitalizationDate" name="capitalizationDate" />

                                            </div>
                                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                <label for="deprecationPct">Depreciation%</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" id="deprecationPct" name="deprecationPct" maxlength="10" min="0" />
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                <label for="accumulatedDepreciation">Accumulated Depreciation</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text">SAR</span></div>
                                                    <input type="number" class="form-control" id="accumulatedDepreciation" name="accumulatedDepreciation" maxlength="10" min="0" step="0.01" />
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                <label for="depreciationTaxPct">Income Tax Depreciation%</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text">SAR</span></div>
                                                    <input type="number" class="form-control" id="depreciationTaxPct" name="depreciationTaxPct" maxlength="10" min="0" step="0.01" />
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                <label for="scrapValue">Scrap Value</label>
                                                <input type="text" class="form-control" id="scrapValue" name="scrapValue" maxlength="10" />

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-0 shadow-none">
                                <a href="#collapseFour" class="text-dark collapsed" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseFour">
                                    <div class="card-header" id="headingThree">
                                        <h6 class="m-0">
                                            Allotted Information
                                            <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                        </h6>
                                    </div>
                                </a>
                                <div id="collapseFour" class="collapse" aria-labelledby="headingThree" data-bs-parent="#accordion">
                                    <div class="card-body">
                                        <div class="row size-inner-section px-2 py-4">
                                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                <label for="departmentId">Department</label>
                                                <select class="form-control select2" name="departmentId">
                                                    <option data-select2-id="3">Select an Department</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                <label for="remarks">Remark</label>
                                                <input type="text" class="form-control" id="remarks" name="remarks" maxlength="10" />

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-0 shadow-none">
                                <a href="#collapseFive" class="text-dark collapsed" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseFive">
                                    <div class="card-header" id="headingThree">
                                        <h6 class="m-0">
                                            Warranty Information
                                            <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                        </h6>
                                    </div>
                                </a>
                                <div id="collapseFive" class="collapse" aria-labelledby="headingThree" data-bs-parent="#accordion">
                                    <div class="card-body">
                                        <div class="row size-inner-section px-2 py-4">
                                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                <label for="amcVendorId">Amc Vendor</label>
                                                <select class="form-control select2" name="amcVendorId">
                                                    <option value="">Select an option</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                <label for="warrantyVendorId">Warranty Vendor</label>
                                                <select class="form-control select2" name="warrantyVendorId">
                                                    <option value="">Select an option</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                <label for="insuranceStartDate">Insurance Start Date</label>
                                                <input type="date" class="form-control" id="insuranceStartDate" name="insuranceStartDate" maxlength="10" />

                                            </div>
                                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                <label for="insuranceEndDate">Insurance End Date</label>
                                                <input type="date" class="form-control" id="insuranceEndDate" name="insuranceEndDate" maxlength="10" />

                                            </div>
                                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                <label for="amcStartDate">AMC Start Date</label>
                                                <input type="date" class="form-control" id="amcStartDate" name="amcStartDate" maxlength="10" />

                                            </div>
                                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                <label for="amcEndDate">AMC End Date</label>
                                                <input type="date" class="form-control" id="amcEndDate" name="amcEndDate" maxlength="10" />

                                            </div>
                                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                <label for="warrantyStartDate">Warranty Start Date</label>
                                                <input type="date" class="form-control" id="warrantyStartDate" name="warrantyStartDate" maxlength="10" />

                                            </div>
                                            <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                <label for="warrantyEndDate">Warranty End Date</label>
                                                <div class="input-group">
                                                    <input type="date" class="form-control" id="warrantyEndDate" placeholder="" name="owner_id" maxlength="10" autocomplete="off" />
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <?php echo form_close(); ?>

                    </div>
                </div>
            </div>
        </div> <!-- end row -->
    </div>
</div>


<!-- Model for Category -->

<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg">Large modal</button> -->

<div class="modal fade" role="dialog" id="categoryModal" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Asset Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form" id="categoryForm" action="<?php echo base_url('admin/add/asset-category'); ?>" method="post" novalidate>
                    <div class="row size-inner-section px-2 py-4">
                        <div class="col-md-6 col-sm-12 mb-3 form-group">
                            <label for="owner_id">Parent Category</label>
                            <p class="hint">Select this if the category being added should be a sub-category of the selected category</p>
                            <input class="easyui-combotree form-control" name="parentCategoryId" data-options="url:'<?php echo base_url("admin/asset/get-category"); ?>',method:'get',labelPosition:'top'" style="width:100%;">
                        </div>
                        <div class="col-md-6 col-sm-12 mb-3 form-group">
                            <label for="categoryName">Category Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="categoryName" name="categoryName" />

                            <label for="categoryName">Category Arabic Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="categoryArabicName" />

                        </div>
                        <div class="col-md-6 col-sm-12 mb-3 form-group">
                            <label for="categoryCode">Category Code</label>
                            <input type="text" class="form-control" id="categoryCode" name="categoryCode" />

                        </div>
                        <div class="col-md-6 col-sm-12 mb-3 form-group">
                            <label for="transferDuration">Default Transfer Duration</label>
                            <p class="hint">Value of "Transferred Upto" is pre-filled when transferring assets</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="transferDuration" name="transferDuration" maxlength="10" />
                                </div>
                                <div class="col-md-6">
                                    <select class="select2 form-control select2-multiple select2-hidden-accessible" name="transferDurationType" data-placeholder="Select one or more option(s)" data-select2-id="4" tabindex="-1" aria-hidden="true">
                                        <option value="">Select one or more option(s)</option>
                                        <option value="1" data-select2-id="31">Day(s)</option>
                                        <option value="2" data-select2-id="32">Month(s)</option>
                                        <option value="3" data-select2-id="32">Year(s)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12 mb-3 form-group">
                            <label for="owner_id">Cascade</label>
                            <div class="input-group">
                                <div class="col-md-10">
                                    <p class="hint">If yes, the same settings will be applied to the child categories as well</p>
                                </div>
                                <div class="col-md-2 align-content-center form-check form-switch mb-3" dir="ltr">
                                    <input type="checkbox" id="switchs1" class="setStatus" value="1" switch="bool" name="isCasCade"><label for="switchs1" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6 col-sm-12 mb-3 form-group">
                            <label for="owner_id">Allow Auto Extend</label>
                            <div class="input-group">
                                <div class="col-md-10">
                                    <p class="hint">Device validity is automatically extended if the device is scanned within 90 days</p>

                                </div>
                                <div class="col-md-2 align-content-center form-check form-switch mb-3" dir="ltr">
                                    <input type="checkbox" id="switchs2" class="setStatus" value="1" switch="bool" name="allowAutoExtend"><label for="switchs2" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div id="accordion" class="custom-accordion">
                        <div class="card mb-1 shadow-none">
                            <a href="#collapseOne" class="text-dark" data-bs-toggle="collapse" aria-expanded="true" aria-controls="collapseOne">
                                <div class="card-header" id="headingOne">
                                    <h6 class="m-0">
                                        Financial Information
                                        <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                    </h6>
                                </div>
                            </a>

                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-bs-parent="#accordion">
                                <div class="card-body">
                                    <div class="row size-inner-section px-2 py-4">
                                        <div class="col-md-6 col-sm-12 mb-3 form-group">
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                    <label for="endOfLife">End of Life</label>
                                                    <input type="text" class="form-control" id="endOfLife" name="endOfLife" maxlength="10" />

                                                </div>
                                                <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                    <label for="endOfLifeType"></label>
                                                    <select class="form-control select2 select2-hidden-accessible" name="endOfLifeType" placeholder="select an option" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                                        <option value="">Select one or more option(s)</option>
                                                        <option value="1" data-select2-id="31">Day(s)</option>
                                                        <option value="2" data-select2-id="32">Month(s)</option>
                                                        <option value="3" data-select2-id="32">Year(s)</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-6 col-sm-12 mb-3 form-group">
                                            <label for="depreciation">Depreciation%</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="depreciation" name="depreciation" maxlength="10" min="0" />
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-12 mb-3 form-group">
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                    <label for="scrapValue">Scrap Value</label>
                                                    <input type="text" class="form-control" id="scrapValue" name="scrapValue" maxlength="10" />

                                                </div>
                                                <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                    <label for="scrapValueType"></label>
                                                    <select class="form-control select2 select2-hidden-accessible" name="scrapValueType" placeholder="select an option" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                                        <option data-select2-id="3">Select an option</option>
                                                        <option value="AK" data-select2-id="111">Percentage(%)</option>
                                                        <option value="HI" data-select2-id="112">Amount</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-6 col-sm-12 mb-3 form-group">
                                            <label for="depreciationTaxPct">Income Tax Depreciation%</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="depreciationTaxPct" name="depreciationTaxPct" maxlength="10" min="0" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-1 shadow-none">
                            <a href="#collapseTwo" class="text-dark collapsed" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseTwo">
                                <div class="card-header" id="headingTwo">
                                    <h6 class="m-0">
                                        Default Activity Schedules For Assets In This Category
                                        <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                    </h6>
                                </div>
                            </a>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-bs-parent="#accordion">
                                <div class="card-body">
                                    <div class="row size-inner-section px-2 py-4">
                                        <label for="">Details</label>
                                        <p class="hint mb-2">Below schedules will be created whenever the assets are added in this category</p>
                                        <div class="col-12" id="DefaultAcitvityData">
                                            <div class="row mt-2 addDefaultActiveity" data-count="0">
                                                <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                    <label for="">Assignee Based On</label>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="radio" name="tvpActivity[0][assigneeType]" id="" onchange="selectUserType(this)" value="1" checked="">
                                                        <label class="form-check-label" for="assigneeType">
                                                            Users Involved
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="tvpActivity[0][assigneeType]" onchange="selectUserType(this)" id="formRadios2" value="2">
                                                        <label class="form-check-label" for="formRadios2">
                                                            User Role
                                                        </label>
                                                    </div>

                                                </div>
                                                <div class="col-md-6 col-sm-12 mb-3 form-group userType">
                                                    <label for="owner_id">User Type</label>
                                                    <select class="form-control select2" name="tvpActivity[0][transactionTypeId]" placeholder="select an option">
                                                        <option data-select2-id="3">Select an option</option>
                                                        <option value="created by">Created By</option>
                                                        <option value="alloted to">Alloted TO</option>
                                                    </select>
                                                </div>
                                                <div class="row userRole m-0 p-0 d-none">
                                                    <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                        <label for="owner_id">Assignee Role</label>
                                                        <select class="form-control select2 select2-hidden-accessible" name="tvpActivity[0][assigneeRole]" placeholder="select an option" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                                            <option value="">Select an option</option>
                                                            <option value="AK">Owner</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                        <label for="owner_id">Assignee</label>
                                                        <select class="form-control select2 select2-hidden-accessible" name="tvpActivity[0][assignee]" placeholder="select an option" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                                            <option>Select an option</option>
                                                            <option value="James Smith">James Smith</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                    <label for="owner_id">Activity Type</label>
                                                    <select class="form-control select2" name="tvpActivity[0][activityTypeId]" placeholder="select an option">
                                                        <option value="">Select an option</option>
                                                        <option value="1">Callibraion</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                    <label for="owner_id">Occurs</label>
                                                    <select class="form-control select2" name="tvpActivity[0][occurs]" placeholder="select an option">
                                                        <option data-select2-id="3">Select an option</option>
                                                        <option value="2">Daily</option>
                                                        <option value="3">Weekly</option>
                                                        <option value="4">Monthly</option>
                                                        <option value="5">Yearly</option>
                                                        <option value="6">One TIme</option>
                                                        <option value="7">Custom</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                    <label for="startAfter">Start Schedule After (Days)</label>
                                                    <p class="hint">The first activity will be created on these many days after the date in "Schedule based on". Leave blank or 0 to create the first activity on the same date</p>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" id="startAfter" name="tvpActivity[0][startAfter]" maxlength="10" min="0" />
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                    <label for="activityReminderId">Activity Reminders</label>
                                                    <select class="form-control select2" name="tvpActivity[0][activityReminderId]" placeholder="select an option">
                                                        <option value="">Select an option</option>
                                                        <option value="0">Same day</option>
                                                        <option value="1">1 day before</option>
                                                        <option value="2">2 day before</option>
                                                        <option value="3">3 day before</option>
                                                        <option value="4">4 day before</option>
                                                        <option value="5">5 day before</option>
                                                        <option value="6">6 day before</option>
                                                        <option value="7">7 day before</option>
                                                        <option value="8">8 day before</option>
                                                        <option value="9">9 day before</option>
                                                        <option value="10">10 day before</option>
                                                        <option value="11">11 day before</option>
                                                        <option value="12">12 day before</option>
                                                        <option value="13">13 day before</option>
                                                        <option value="14">14 day before</option>
                                                        <option value="15">15 day before</option>
                                                        <option value="16">16 day before</option>
                                                        <option value="17">17 day before</option>
                                                        <option value="18">18 day before</option>
                                                        <option value="19">19 day before</option>
                                                        <option value="20">20 day before</option>
                                                        <option value="21">21 day before</option>
                                                        <option value="22">22 day before</option>
                                                        <option value="23">23 day before</option>
                                                        <option value="24">24 day before</option>
                                                        <option value="25">25 day before</option>
                                                        <option value="26">26 day before</option>
                                                        <option value="27">27 day before</option>
                                                        <option value="28">28 day before</option>
                                                        <option value="29">29 day before</option>
                                                        <option value="30">30 day before</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                    <label for="scheduleBasedOnColumnControlId">Schedule Based On</label>
                                                    <p class="hint">Select the date which should be used as the start date of the schedule</p>
                                                    <select class="form-control select2" name="tvpActivity[0][scheduleBasedOnColumnControlId]">
                                                        <option value="">Select an option</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                    <label for="customDays">Custom Days</label>
                                                    <p class="hint">Enter the number of days when the schedule should recur. For ex, 15 for fortnightly, 60 for bi-monthly, 180 for half yearly</p>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" id="customDays" name="tvpActivity[0][customDays]" maxlength="10" min="0" />
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-end"><span class="input-group-btn-vertical">
                                                        <button class="btn bg-body" onclick="addMoreDefaultActivity(this)" type="button"><i class="fas fa-solid fa-plus" style="color: #63E6BE;"></i></button>
                                                        <button class="btn bg-body" type="button"><i class="fas fa-times fa-solid" style="color:red;"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-0 shadow-none">
                            <a href="#collapseThree" class="text-dark collapsed" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseThree">
                                <div class="card-header" id="headingThree">
                                    <h6 class="m-0">
                                        Deafult Sevice vendor Mapping
                                        <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                    </h6>
                                </div>
                            </a>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-bs-parent="#accordion">
                                <div class="card-body">
                                    <div class="row size-inner-section px-2 py-4">
                                        <div class="col-md-6 col-sm-12 mb-3 form-group">
                                            <label for="owner_id">Default Vendor</label>
                                            <select class="form-control select2 select2-hidden-accessible" name="defaultVendor" placeholder="select an option" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                                <option data-select2-id="3">Select an option</option>
                                                <option value="AMC Vendor">AMC Vendor</option>
                                                <option value="Asset Vendor">Asset Vendor</option>
                                                <option value="Warrenty Vendor">Warrenty Vendor</option>
                                                </optgroup>
                                            </select>
                                        </div>

                                        <div class="col-md-6 col-sm-12 mb-3 form-group align-self-sm-end">
                                            <div class="input-group">
                                                <div class="col-md-10">
                                                    <label for="owner_id">Auto Assign</label>

                                                </div>
                                                <div class="col-md-2 align-content-center form-check form-switch mb-3" dir="ltr">
                                                    <input type="checkbox" id="switchs3" class="setStatus" value="1" switch="bool" name="autoAssign"><label for="switchs3" data-on-label="Yes" data-off-label="No"></label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center validation-message mt-2"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
                        <button type="submit" form="categoryForm" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<!--Model For Location-->

<div class="modal fade" id="locationModal" role="dialog" aria-labelledby="locationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Locations</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="loacationForm" class="form modal-form" action="<?php echo base_url('admin/asset/add-location'); ?>" method="post">
                    <div class="row size-inner-section px-2 py-4">
                        <div class="col-md-6 col-sm-12 mb-3 form-group">
                            <label for="owner_id">Parent Location Name</label>
                            <p class="hint">Select this if the location being added should be a sub-location of the selected location</p>
                            <input class="easyui-combotree form-control" name="parentLocationId" data-options="url:'<?php echo base_url("admin/asset/get-locations"); ?>',method:'get',labelPosition:'top',collapsible:true," style="width:100%">
                        </div>
                        <div class="col-md-6 col-sm-12 mb-3 form-group">
                        </div>
                        <div class="col-md-6 col-sm-12 mb-3 form-group">
                            <label for="locationName">Location<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="locationName" name="locationName" required />
                        </div>
                        <div class="col-md-6 col-sm-12 mb-3 form-group">

                            <label for="locationArabicName">Location Arabic Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="locationArabicName" name="locationArabicName" required />
                        </div>
                        <div class="col-md-6 col-sm-12 mb-3 form-group">
                            <label for="locationCode">Location Code</label>
                            <input type="text" class="form-control" id="locationCode" name="locationCode" maxlength="10" required />

                        </div>
                        <div class="col-md-6 col-sm-12 mb-3 form-group">
                            <label for="owner_id">Inventory Location</label>
                            <div class="input-group">
                                <div class="col-md-10">
                                    <p class="hint">If yes, the location is displayed in inventory as well</p>

                                </div>
                                <div class="col-md-2 align-content-center form-check form-switch mb-3" dir="ltr">
                                    <input type="checkbox" id="switchs5" switch="bool" name="isInventoryLocation" value="true"><label for="switchs5" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-6 col-sm-12 mb-3 form-group">
                            <label for="location">Default Coordinates</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Latitude" name="locationLatitude" required />
                                <input type="text" class="form-control" placeholder="Longitude" name="locationLongitude" required />
                            </div>
                        </div>



                        <div class="col-md-6 col-sm-12 mb-3 form-group">
                            <label for="locationDescription">Description<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="locationDescription" name="locationDescription" required />

                        </div>

                        <div class="header">
                            <label for="">Additional Info</label>
                            <p class="hint">Location wise department and category heads can be defined here. These can be selected in configuring the approval workflows</p>
                        </div>

                        <div class="container-fluid" id="loactionAditionalInfo">
                            <div class="col-md-6 col-sm-12" id="locationDepartment">
                                <div class="row align-items-center addLocationDepartment" data-count="0">
                                    <span class="col-md-1 mt-1">
                                        <button class="btn bg-body" type="button" onclick="addLocationDeparment(this)"><i class="fas fa-solid fa-plus" style="color: #63E6BE;"></i></button>
                                    </span>
                                    <span class="col-md-1 mt-1">
                                        <button class="btn bg-body" type="button"><i class="fas fa-times fa-solid" style="color:red;"></i></button>
                                    </span>
                                    <div class="col-md-5 col-sm-12 mb-3 form-group">
                                        <label for="owner_id">Department</label>
                                        <select class="form-control select2" name="additionaltvp[0][locationId]" placeholder="select an option">
                                            <option value="">Select an option</option>
                                            <?php foreach ($departments as $department) { ?>
                                                <option value="<?php echo $department->id; ?>"><?php echo $department->name; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>

                                    <div class="col-md-5 col-sm-12 mb-3 form-group">
                                        <label for="owner_id">Users</label>
                                        <select class="form-control select2" name="additionaltvp[0][userId]" placeholder="select an option">
                                            <option data-select2-id="3">Select an option</option>
                                            <?php foreach ($users as $user) { ?>
                                                <option value="<?php echo $user->id; ?>"><?php echo $user->name; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="loacationForm" class="btn btn-success">Submit</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- Model For Status -->

<div class="modal fade" role="dialog" id="statusModal" aria-labelledby="statuslModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">New Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="statusForm" class="form modal-form" action="<?php echo base_url('admin/asset/add-status'); ?>" method="post">
                    <div class="row size-inner-section px-2 py-4">
                        <div class="col-md-6 col-sm-12 mb-3 form-group">
                            <label for="owner_id">Status Type</label>
                            <p class="hint">All allotted type status make the "Transferred To" field mandatory in
                                the asset details. Unallotted type status do not need any user assigned to the
                                asset. Discarded type status are shown as "Reason" while discarding an asset</p>
                            <select class="form-control select2 statusType" name="status_type" onchange="statusType(this)">
                                <option value="0">Select an option</option>
                                <option value="1">Allotted Assets</option>
                                <option value="2">Unallotted Assets</option>
                                <option value="3">Discarded Assets</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-12 mb-3 form-group">
                            <label for="statusName">Status Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="statusName" name="statusName" />

                        </div>
                        <div class="col-md-6 col-sm-12 mb-3 form-group">
                            <label for="nextStatusIds">Next Status</label>
                            <p class="hint">Select the next possible status of the assets. This is useful in
                                ensuring asset status change according to a pre-defined status workflow. Leave blank
                                to allow all status to be available when updating an asset</p>

                            <select class="select2 form-control nextStatusIds" multiple="" name="nextStatusIds[]">
                            </select>
                        </div>

                        <div class="col-md-6 col-sm-12 mb-3 form-group">
                            <label for="categoryIds">Only visible for categories</label>
                            <p class="hint">Select the categories where the status will be applicable. It won't show
                                when updating assets of other categories. Leave blank to show this status in all
                                categories</p>
                            <input class="form-control easyui-combotree" name="categoryIds[]" data-options="url:'<?php echo base_url("admin/asset/get-category"); ?>',method:'get',labelPosition:'top',collapsible:true,multiple:true" style="width:100%">
                        </div>
                        <div class="col-md-6 col-sm-12 mb-3 form-group align-self-sm-end">
                            <div class="input-group">
                                <div class="col-md-10">
                                    <label for="isHoldActivity">Hold/Pause Activity</label>

                                </div>
                                <div class="col-md-2 align-content-center form-check form-switch mb-3" dir="ltr">
                                    <input type="checkbox" class="setStatus" switch="bool" name="isHoldActivity" id="isHoldActivity" value="true"><label for="isHoldActivity" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="statusForm" class="btn btn-success">Submit</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
</div>

<?php $this->load->view('admin/home/footer'); ?>
<script>
    const users = <?php echo json_encode($users); ?>
</script>
<script>
    function addMoreDefaultActivity(input) {
        var counter = $(input).closest('.addDefaultActiveity').attr('data-count');
        var key = ++counter;
        $('#DefaultAcitvityData').append(`<div class="row mt-2 addDefaultActiveity" data-count="${key}">
                                                <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                    <label for="">Assignee Based On</label>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="radio" name="tvpActivity[${key}][assigneeType]" onchange="selectUserType(this)" value="1" checked="">
                                                        <label class="form-check-label" for="assigneeType">
                                                            Users Involved
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="tvpActivity[${key}][assigneeType]" onchange="selectUserType(this)" value="2">
                                                        <label class="form-check-label" for="formRadios2">
                                                            User Role
                                                        </label>
                                                    </div>

                                                </div>
                                                <div class="col-md-6 col-sm-12 mb-3 form-group userType">
                                                    <label for="owner_id">User Type</label>
                                                    <select class="form-control select2" name="tvpActivity[${key}][transactionTypeId]" placeholder="select an option">
                                                        <option value="">Select an option</option>
                                                        <option value="created by">Created By</option>
                                                        <option value="alloted to">Alloted TO</option>
                                                    </select>
                                                </div>
                                                <div class="row userRole m-0 p-0 d-none">
                                                <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                    <label for="owner_id">Assignee Role</label>
                                                    <select class="form-control select2" name="tvpActivity[${key}][assigneeRole]" placeholder="select an option">
                                                        <option data-select2-id="3">Select an option</option>
                                                        <option value="owner">Owner</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                    <label for="owner_id">Assignee</label>
                                                    <select class="form-control select2" name="tvpActivity[${key}][assignee]" placeholder="select an option">
                                                        <option data-select2-id="3">Select an option</option>
                                                        <option value="James Smith" data-select2-id="111">James Smith</option>
                                                    </select>
                                                </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                    <label for="owner_id">Activity Type</label>
                                                    <select class="form-control select2 name="tvpActivity[${key}][activityTypeId]" placeholder="select an option">
                                                        <option value="">Select an option</option>
                                                        <option value="1">Callibraion</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                    <label for="owner_id">Occurs</label>
                                                    <select class="form-control select2" name="tvpActivity[${key}][occurs]" placeholder="select an option">
                                                        <option value="">Select an option</option>
                                                        <option value="2">Daily</option>
                                                        <option value="3">Weekly</option>
                                                        <option value="4">Monthly</option>
                                                        <option value="5">Yearly</option>
                                                        <option value="6">One TIme</option>
                                                        <option value="7">Custom</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                    <label for="startAfter">Start Schedule After (Days)</label>
                                                    <p class="hint">The first activity will be created on these many days after the date in "Schedule based on". Leave blank or 0 to create the first activity on the same date</p>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" id="startAfter" name="tvpActivity[${key}][startAfter]" maxlength="10" min="0" />
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                    <label for="activityReminderId">Activity Reminders</label>
                                                    <select class="form-control select2" name="tvpActivity[${key}][activityReminderId]" placeholder="select an option">
                                                        <option value="">Select an option</option>
                                                        <option value="0">Same day</option>
                                                        <option value="1">1 day before</option>
                                                        <option value="2">2 day before</option>
                                                        <option value="3">3 day before</option>
                                                        <option value="4">4 day before</option>
                                                        <option value="5">5 day before</option>
                                                        <option value="6">6 day before</option>
                                                        <option value="7">7 day before</option>
                                                        <option value="8">8 day before</option>
                                                        <option value="9">9 day before</option>
                                                        <option value="10">10 day before</option>
                                                        <option value="11">11 day before</option>
                                                        <option value="12">12 day before</option>
                                                        <option value="13">13 day before</option>
                                                        <option value="14">14 day before</option>
                                                        <option value="15">15 day before</option>
                                                        <option value="16">16 day before</option>
                                                        <option value="17">17 day before</option>
                                                        <option value="18">18 day before</option>
                                                        <option value="19">19 day before</option>
                                                        <option value="20">20 day before</option>
                                                        <option value="21">21 day before</option>
                                                        <option value="22">22 day before</option>
                                                        <option value="23">23 day before</option>
                                                        <option value="24">24 day before</option>
                                                        <option value="25">25 day before</option>
                                                        <option value="26">26 day before</option>
                                                        <option value="27">27 day before</option>
                                                        <option value="28">28 day before</option>
                                                        <option value="29">29 day before</option>
                                                        <option value="30">30 day before</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                    <label for="scheduleBasedOnColumnControlId">Schedule Based On</label>
                                                    <p class="hint">Select the date which should be used as the start date of the schedule</p>
                                                    <select class="form-control select2" name="tvpActivity[${key}][scheduleBasedOnColumnControlId]" placeholder="select an option">
                                                        <option value="">Select an option</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 col-sm-12 mb-3 form-group">
                                                    <label for="customDays">Custom Days</label>
                                                    <p class="hint">Enter the number of days when the schedule should recur. For ex, 15 for fortnightly, 60 for bi-monthly, 180 for half yearly</p>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" id="customDays" name="tvpActivity[${key}][customDays]" maxlength="10" min="0" />
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-end"><span class="input-group-btn-vertical">
                                                        <button class="btn bg-body" onclick="addMoreDefaultActivity(this)" type="button"><i class="fas fa-solid fa-plus" style="color: #63E6BE;"></i></button>
                                                        <button class="btn bg-body" type="button" onclick=removeDefaultActivity(this)><i class="fas fa-times fa-solid" style="color:red;"></i></button>
                                                    </span>
                                                </div>
                                            </div>`);
    }

    function selectUserType(input) {
        if (input.value == '2') {
            var input = input.closest('.addDefaultActiveity').querySelector('.userRole');
            $(input).removeClass('d-none');
            var input = input.closest('.addDefaultActiveity').querySelector('.userType');
            $(input).addClass('d-none');
        } else if (input.value == '1') {
            var input = input.closest('.addDefaultActiveity').querySelector('.userRole');
            $(input).addClass('d-none');
            var input = input.closest('.addDefaultActiveity').querySelector('.userType');
            $(input).removeClass('d-none');
        }
    }

    function addLocationDeparment(input) {
        var departments = <?php echo json_encode($departments); ?>;
        var counter = $(input).closest('.addLocationDepartment').attr('data-count');
        var key = ++counter;
        $('#locationDepartment').append(`<div class="row align-items-center addLocationDepartment" data-count="${key}">
                                    <span class="col-md-1 mt-1">
                                        <button class="btn bg-body" type="button" onclick="addLocationDeparment(this)"><i class="fas fa-solid fa-plus" style="color: #63E6BE;"></i></button>
                                    </span>
                                    <span class="col-md-1 mt-1">
                                        <button class="btn bg-body" type="button" onclick="removeLocationDepartment(this)"><i class="fas fa-times fa-solid" style="color:red;"></i></button>
                                    </span>
                                    <div class="col-md-5 col-sm-12 mb-3 form-group">
                                        
                                        <select class="form-control select2" name="additionaltvp[${key}][departmentId]" placeholder="select an option">
                                            <option value="">Select an option</option>
                                            ${departments.map(value => `<option value="${value.id}">${value.name}</option>`).join('')}
                                        </select>

                                    </div>

                                    <div class="col-md-5 col-sm-12 mb-3 form-group">
                                       
                                        <select class="form-control select2" name="additionaltvp[${key}][userId]" placeholder="select an option">
                                            <option value="">Select an option</option>
                                            ${users.map(value=>`<option value="${value.id}">${value.name}</option>`).join('')}
                                            </select>

                                    </div>
                                </div>`);
    }

    function removeDefaultActivity(input) {
        $(input).closest('.addDefaultActiveity').remove();
    }

    function removeLocationDepartment(input) {
        $(input).closest('.addLocationDepartment').remove();
    }
</script>
<script>
    $(document).ready(function() {
        $("#categoryModal").on('shown.bs.modal', function() {

        });
    });

    function statusType(input) {
        var statusType = input.value;
        $.ajax({
            type: "get",
            url: "<?php echo base_url('admin/asset/get-status'); ?>",
            data: {
                statusType: statusType
            },
            dataType: "json",
            success: function(response) {
                if (response.status == true) {
                    $('.nextStatusIds').html(`
                    ${response.data.map(value=>`<option value="${value.status_id}">${value.status_name}</option>`).join('')
                    }
                    `);
                }
            }
        });
    }
</script>