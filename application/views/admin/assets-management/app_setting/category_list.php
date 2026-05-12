<?php $this->load->view('admin/home/header'); ?>
<style>
    .dataTables_wrapper::-webkit-scrollbar {
        display: none;
    }

    .nav-md .container.body .right_col {
        padding: 10px 10px 0;
        margin-left: 230px;
    }

    input[switch=primary]:checked+label {
        background-color: #ffc107;
    }

    .asset_category__main .accordion-body {
        padding-left: 5px !important;
        padding-right: 5px !important;
    }

    .assignee_based_on__main .form-check-input:checked {
        background-color: #ffc107;
        border-color: #ffc107;
    }

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
            <div class="col-sm-4">
                <div class="page-title">
                    <h4>Asset Categories</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/asset/all-categories'); ?>">Category</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
            </div>
            <div class="col-sm-3">
                <!-- <div class="d-flex align-items-center">
                    <select class="form-control select2 sm">
                        <option>Select</option>
                        <option value="">Default View</option>
                    </select>
                    <a href="javascript:;" data-bs-target="#customviewModal" data-bs-toggle="modal" class="btn btn-sm pull-right me-1"> <i class="fas fa-plus"></i> </a>
                </div> -->
            </div>
            <div class="col-sm-5">
                <div class="float-end d-sm-block">
                    <a href="javascript:;" class="btn btn-custom-danger btn-sm pull-right me-1" onclick="location.reload()"> <i class="fas fa-sync"></i> </a>
                    <?php if (check_action_permission(get_user_role(), 'categories', 'create_category')): ?>
                        <a href="javascript:;" data-bs-target="#categoryModal" data-bs-toggle="modal" class="btn btn-custom-success btn-sm pull-right me-1"> <i class="fa fa-plus"></i> Create</a>
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
                                        <!-- <th># <input type="checkbox" name="checkAll" class="checkAll checkbox"></th> -->
                                        <th>S.No.</th>
                                        <th>Parent Category</th>
                                        <th>Category Name</th>
                                        <th>Category Name(AR)</th>
                                        <th>Category Code</th>
                                        <th>Default Transfer Duration</th>
                                        <th>Category Path</th>
                                        <th>Actual Cost</th>
                                        <th>Cascade</th>
                                        <th>Allow Auto Extend</th>
                                        <th>Billing Cost</th>
                                        <th>End of Life</th>
                                        <th>Depreciation %</th>
                                        <th>Scrap Value</th>
                                        <th>Income Tax Depreciation%</th>
                                        <th>Created By</th>
                                        <th>Date of Entry</th>
                                        <th>Default Vendor</th>
                                        <th>Auto Assign</th>
                                        <th>Tools</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($categories as $cat) {
                                        $parent = getParentCategory($cat->categoryId);
                                        $path = getParentCategory($cat->categoryId);
                                        if (!empty($parent)) {
                                            array_pop($parent);
                                        }
                                    ?>
                                        <tr>
                                            <!-- <td>
                                            <input type="checkbox" name="checklist[]" class="checkboxesall checkbox"  value="2">
                                        </td> -->
                                            <td>1</td>
                                            <td><?php echo implode(' >', $parent) ?></td>
                                            <td><?php echo $cat->categoryName; ?></td>
                                            <td><?php echo $cat->categoryArabicName; ?></td>
                                            <td><?php echo $cat->categoryCode; ?></td>
                                            <td><?php echo $cat->transferDuration; ?> <?php echo $cat->transferDurationType == '1' ? 'Day(s)' : ($cat->transferDurationType == '2' ? 'Month(s)' : ($cat->transferDurationType == '3' ? 'Year(s)' : '')); ?></td>
                                            <td><?php echo implode(' >', $path); ?></td>
                                            <td><?php echo $cat->actualCost; ?></td>
                                            <td><?php echo $cat->isCasCade ? 'Yes' : 'No'; ?></td>
                                            <td><?php echo $cat->allowAutoExtend ? 'Yes' : 'No'; ?></td>
                                            <td><?php echo $cat->billingCost; ?></td>
                                            <td><?php echo $cat->endOfLife; ?> <?php echo $cat->endOfLifeType == '1' ? 'Day(s)' : ($cat->endOfLifeType == '2' ? 'Month(s)' : ($cat->endOfLifeType == '3' ? 'Year(s)' : '')); ?></td>
                                            <td><?php echo $cat->depreciation; ?></td>
                                            <td><?php echo $cat->scrapValue; ?> <?php echo $cat->scrapValueType == '1' ? '-Percentage(%)' : ($cat->scrapValueType == '2' ? '-Amount' : ''); ?></td>
                                            <td><?php echo $cat->depreciationTaxPct; ?></td>
                                            <td><?php echo $cat->categoryCreatedBy; ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($cat->categoryCreatedAt)); ?></td>
                                            <td><?php echo $cat->transferDurationType == '1' ? 'AMC Vendor' : ($cat->transferDurationType == '2' ? 'Asset Vendor' : ($cat->transferDurationType == '3' ? 'Warrenty Vendor' : '')); ?></td>
                                            <td><?php echo $cat->autoAssign ? 'Yes' : 'No'; ?></td>
                                            <td>
                                                <?php if (check_action_permission(get_user_role(), 'categories', 'update_category')): ?>
                                                    <a class="btn btn-outline-secondary btn-custom-light btn-sm" title="Edit" href="javascript:void(0)" category_id="<?php echo $cat->categoryId; ?>" onclick="admin_edit_category(this)">
                                                        <i class="mdi mdi-pencil font-size-18"></i>
                                                    </a>
                                                <?php endif;
                                                if (check_action_permission(get_user_role(), 'categories', 'delete_category')): ?>
                                                    <a class="btn btn-outline-danger btn-custom-light btn-sm edit pt-1 pb-1 pr-2 pl-2" title="Delete" href="<?php echo base_url('admin/asset/delete-category?id=' . $cat->categoryId); ?>">
                                                        <i class="fas fa-trash-alt font-size-18"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <a class="btn btn-outline-info btn-custom-light btn-sm edit" title="View" href="javascript:void(0)" category_id="<?php echo $cat->categoryId; ?>" category_name="<?php echo $cat->categoryName; ?>" category_ar_name="<?php echo $cat->categoryArabicName; ?>" category_code="<?php echo $cat->categoryCode; ?>" category_path="<?php echo implode(' >', $path); ?>" onclick="admin_view_category(this)">
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
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Categrory View Modal -->
<div class="modal fade" id="categoryViewModal" role="dialog" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mt-0">Asset Category</h5>
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
                            <label class="form-label">Parent Category</label><br>
                            <span class="text-muted">Plant & Machinery</span>
                        </div>
                        <div class="col-md-6 mb-4 form-group">
                            <label class="form-label">Category Name</label><br>
                            <span class="text-muted category_view_name">DG Set</span>
                        </div>
                        <div class="col-md-6 mb-4 form-group">
                            <label class="form-label">Category Name Arabic</label><br>
                            <span class="text-muted category_view_ar_name">DG Set</span>
                        </div>
                        <div class="col-md-6 mb-4 form-group">
                            <label class="form-label">Category Code</label><br>
                            <span class="text-muted category_view_code">DG</span>
                        </div>
                        <div class="col-md-6 mb-4 form-group">
                            <label class="form-label">Default Transfer Duration</label><br>
                            <span class="text-muted view_default_transfer">HR</span>
                        </div>
                        <div class="col-md-6 mb-4 form-group">
                            <label class="form-label">Category Path</label><br>
                            <span class="text-muted category_view_path">Plant & Machinery > DG Set</span>
                        </div>
                        <div class="col-md-6 mb-4 form-group">
                            <label class="form-label">Actuall Cost</label><br>
                            <span class="text-muted view_actual_cost"></span>
                        </div>
                        <div class="col-md-6 mb-4 form-group">
                            <label class="form-label">Cascade</label><br>
                            <span class="text-muted view_cascade"></span>
                        </div>
                        <div class="col-md-6 mb-4 form-group">
                            <label class="form-label">Allow Auto Extend</label><br>
                            <span class="text-muted view_auto_extend">No</span>
                        </div>
                        <div class="col-md-6 mb-4 form-group">
                            <label class="form-label">Billing Cost</label><br>
                            <span class="text-muted view_billing_cost"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingOne">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="true" aria-controls="flush-collapseOne">
                                            <b>Financial Information</b>
                                        </button>
                                    </h2>
                                    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-4 form-group">
                                                    <label class="form-label">End of Life</label><br>
                                                    <span class="text-muted view_end_of_life"></span>
                                                </div>
                                                <div class="col-md-6 mb-4 form-group">
                                                    <label class="form-label">Depreciation %</label><br>
                                                    <span class="text-muted view_depreciation"></span>
                                                </div>
                                                <div class="col-md-6 mb-4 form-group">
                                                    <label class="form-label">Scrap Value</label><br>
                                                    <span class="text-muted view_scrap_val"></span>
                                                </div>
                                                <div class="col-md-6 mb-4 form-group">
                                                    <label class="form-label">Income Tax Depreciation%</label><br>
                                                    <span class="text-muted view_tax_depreciation"></span>
                                                </div>
                                                <div class="col-md-6 mb-4 form-group">
                                                    <label class="form-label">Created By</label><br>
                                                    <span class="text-muted view_created_by">Support</span>
                                                </div>
                                                <div class="col-md-6 mb-4 form-group">
                                                    <label class="form-label">Date of Entry</label><br>
                                                    <span class="text-muted view_created_at"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                            <b>Default Activity Schedules For Assets In This Category</b>
                                        </button>
                                    </h2>
                                    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <div class="row">
                                                <div class="col-md-12 mb-4">
                                                    <table id="asset-table" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th># </th>
                                                                <th>S.No.</th>
                                                                <th>Assignee Based On</th>
                                                                <th>User Type</th>
                                                                <th>Assignee Role</th>
                                                                <th>Assignee</th>
                                                                <th>Activity Type</th>
                                                                <th>Occurs</th>
                                                                <th>Start Schedule After (Days)</th>
                                                                <th>Activity Reminders</th>
                                                                <th>Schedule Based On</th>
                                                                <th>Custom Days</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="defaultActivity">

                                                        </tbody>
                                                    </table>
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
                                                <div class="col-md-6 mb-4 form-group">
                                                    <label class="form-label">Default Vendor</label><br>
                                                    <span class="text-muted view_default_vendor_name"></span>
                                                </div>
                                                <div class="col-md-6 mb-4 form-group">
                                                    <label class="form-label">Auto Assign</label><br>
                                                    <span class="text-muted view_auto_assign"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
<!-- Widget All Edit Modal -->
<div class="modal fade quotation-modal" id="multieditModal" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mt-0">Upload Multiple Department</h5>
                </div>
                <div>
                    <button type="button" class="btn btn-sm"><i class="fas fa-pencil-alt"></i></button>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <button class="btn btn-custom-white"><i class="fas fa-download"></i></button>
                        <button class="btn btn-custom-white"><i class="fas fa-upload"></i></button>
                        <button class="btn btn-custom-white"><i class="fas fa-info"></i></button>
                    </div>
                    <div class="col-md-12">
                        <p class="mb-1">Add Department Data</p>
                    </div>
                </div>
                <div class="">
                    <table class="table table-bordered table-editable table-nowrap align-middle table-edits">
                        <thead>
                            <tr>
                                <th>S. No.</th>
                                <th>Department Name *</th>
                                <th>Department Code</th>
                                <th>Contact Person</th>
                                <th>Description</th>
                                <th>Created By</th>
                                <th>Date Of Entry</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr data-id="1">
                                <td>1</td>
                                <td data-field="text">Human Resources</td>
                                <td data-field="text">HR</td>
                                <td data-field="contactperson"></td>
                                <td data-field="text"></td>
                                <td data-field="text"></td>
                                <td>
                                    <div class="input-group" id="datepicker1">
                                        <input type="date" class="form-control">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="demo-form2" class="btn btn-success">Submit</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->







<?php $this->load->view('admin/home/footer'); ?>
<script type="text/javascript">
    var dattribute_row = <?php echo $dattribute_row; ?>;
    var roles = <?php echo json_encode($roles); ?>

    function adddAttribute(event) {
        event.preventDefault();
        html = '<div class="card" id="dattribute-row' + dattribute_row + '"><div class="card-body cardSection">';
        html += ' <div class="row assignee_based_on__main"><div class="col-md-6 mb-3 form-group"><div><h5 class="font-size-14 mb-2">Assignee Based On</h5>';

        html += ' <div class="form-check mb-1"><input class="form-check-input user__involved" onchange="user__involved(this)" type="radio" name="tvpActivity[' + dattribute_row + '][activity_assignee_type]" id="tvpActivity[' + dattribute_row + '][activity_assignee_type]' + dattribute_row + '1" value="1"><label class="form-check-label user__involved" for="tvpActivity[' + dattribute_row + '][activity_assignee_type]' + dattribute_row + '1">Users Involved</label></div>';

        html += ' <div class="form-check"><input class="form-check-input user__role" onchange="user__role(this)" type="radio" name="tvpActivity[' + dattribute_row + '][activity_assignee_type]" id="tvpActivity[' + dattribute_row + '][activity_assignee_type]' + dattribute_row + '2" value="2"><label class="form-check-label user__role" for="tvpActivity[' + dattribute_row + '][activity_assignee_type]' + dattribute_row + '2"> User Role</label></div></div></div>';

        html += ' <div class="col-md-6 mb-3 form-group user_role__hide"><label class="control-label" for="address_id" style="width:100%">User Type</label><select class="form-control select2" name="tvpActivity[' + dattribute_row + '][activity_user_type]"> <option value="0">Select</option><option value="1">Created To</option><option value="2">Alloted To</option><option value="3">Category Head</option></select></div></div>';

        html += ' <div class="row assignee_based_on__main">';

        html += '<div class="row involved__hide"><div class="col-md-6 mb-3"><label class="control-label" for="activity_assignee_role" style="width:100%">Assignee Role</label><select class="form-control select2" name="tvpActivity[' + dattribute_row + '][activity_assignee_role]" onchange="getAssignee(this)"><option value="0">Select an Option</option>' + roles.map((value) => `<option value="${value.id}">${value.name}</option>`).join('') + '</select></div>';

        html += ' <div class="col-md-6 mb-3"><label class="control-label" for="activity_assignee" style="width:100%">Assignee</label><select class="form-control select2 assigneeOption" name="tvpActivity[' + dattribute_row + '][activity_assignee]"><option value="0">Select an Option</option></select></div></div>';

        html += ' <div class="col-md-6 mb-3"><label class="control-label" for="activity_type_id" style="width:100%">Activity Type</label><select class="form-control select2" name="tvpActivity[' + dattribute_row + '][activity_type_id]"><option value="0">Select an Option</option><option>Calibration</option></select></div>';

        html += ' <div class="col-md-6 mb-3"><label class="control-label" for="activity_occurs" style="width:100%">Occurs</label><select class="form-control select2" name="tvpActivity[' + dattribute_row + '][activity_occurs]"><option value="0">Select an Option</option><option>Daily</option></select></div>';

        html += ' <div class="col-md-6 mb-3"><label class="control-label" for="activity_start_after" style="width:100%">Start Schedule After (Days)</label><p style="font-size:13px;">The first activity will be created on these many days after the date in "Schedule based on". Leave blank or 0 to create the first activity on the same date</p><input id="instruction" name="tvpActivity[' + dattribute_row + '][activity_start_after]" type="number" class="form-control" /></div>';

        html += ' <div class="col-md-6 mb-3"><label class="control-label" for="activity_reminder" style="width:100%">Activity Reminders</label><select class="form-control select2" name="tvpActivity[' + dattribute_row + '][activity_reminder]"> <option value="0">Select an Option</option><option value="1">Same day</option><option value="2">1 day before</option><option value="3">2 day before</option><option value="4">3 day before</option><option value="5">4 day before</option><option value="6">5 day before</option></select></div>';

        html += ' <div class="col-md-6 mb-3"><label class="control-label" for="activity_schedule" style="width:100%">Schedule Based On</label><p style="font-size:13px;">Select the date which should be used as the start date of the schedule</p><select class="form-control select2" name="tvpActivity[' + dattribute_row + '][activity_schedule]"><option value="0">Select an Option</option></select></div>';

        html += ' <div class="col-md-6 mb-3"><label class="control-label" for="activity_custom_days" style="width:100%">Custom Days</label><p style="font-size:13px;">Enter the number of days when the schedule should recur. For ex, 15 for fortnightly, 60 for bi-monthly, 180 for half yearly</p><input id="instruction" name="tvpActivity[' + dattribute_row + '][activity_custom_days]" type="number" class="form-control" /></div></div>';
        html += '<div class="row"><div class="col-md-12 text-end"><hr><button class="btn btn-outline-info btn-custom-light" onclick="adddAttribute(event);"><i class="fas fa-plus"></i></button><button class="btn btn-outline-danger btn-custom-light" onclick="remove_dattribute(' + dattribute_row + ')"><i class="mdi mdi-close-thick"></i></button></div></div>';
        html += '</div></div>';

        $('#detail .detail__inner').append(html);
        dattribute_row++;
        $('.select2').select2();
    }

    function remove_dattribute(u) {
        $('#dattribute-row' + u).remove();
    }
</script>

<script>
    function user__involved(input) {
        var parent = $(input).closest('.cardSection');
        parent.find(".involved__hide").hide();
        parent.find(".user_role__hide").show();
    }

    function user__role(input) {
        var parent = $(input).closest('.cardSection');
        parent.find(".user_role__hide").hide();
        parent.find(".involved__hide").show();
    };

    function getAssignee(input) {
        var assignee = $(input).closest('.involved__hide').find('.assigneeOption');
        var role_id = $(input).find('option:selected').val();
        $.ajax({
            type: "get",
            url: "<?php echo base_url('admin/asset/get-assignee'); ?>",
            data: {
                role_id: role_id
            },
            dataType: "json",
            success: function(response) {
                if (response.status == true) {
                    assignee.html(`<option value="">Select an Option</option>${response.assignee.map((value) => `<option value="${value.id}">${value.first_name}</option>`).join('')}`);
                }
            }
        });
    }
</script>

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
            "processing": true,
            "serverSide": false,
            fixedHeader: true,
            "ordering": false
        });

    });
</script>