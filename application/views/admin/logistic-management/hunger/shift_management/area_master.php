<?php $this->load->view('admin/home/header'); ?>
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

    .size-inner-section {
        box-shadow: 0px 1px 4px #c5c5c5;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    #responseContainer2 {
        position: absolute;
        width: 94%;
    }
</style>

<!-- start page title -->
<div class="page-title-box">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-title">
                    <h4>Area List</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/logistic-management/hunger/hunger-area'); ?>">Area</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
            </div>
            <?php $admin_id = $this->session->userdata('admin_id'); ?>
            <div class="col-sm-6 message_place">
                <div class="float-end d-sm-block">
                    <!-- <button type="button" class="btn btn-custom-danger btn-sm pull-right" onclick="deleteAction()" title="Delete"><i class="fa fa-trash me-1"></i> Delete</button> -->
                    <?php if (check_action_permission(get_user_role(), 'area_master', 'create_area')): ?>
                        <button type="button" class="btn btn-custom-success btn-sm pull-right" data-bs-toggle="modal" data-bs-target="#areaModal" title="Create"><i class="fa fa-plus me-1"></i>Create Area</button>
                    <?php endif; ?>
                </div>
                <?php if ($this->admin->getInfo()) {
                    $info = explode("--", $this->admin->getInfo());
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
                        <form action="<?php echo base_url('admin/logistic-management/hunger/hunger-area'); ?>" method="get" id="filter_form">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group mb-2">
                                        <label>Search by Area Name</label>
                                        <input type="search" id="keyword" name="name" placeholder="Search by Team Name" value="<?php echo $this->input->get('name') ? $this->input->get('name') : ''; ?>" autocomplete="off" class="form-control">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-6 col-md-6 col-sm-12">

                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <button type="submit" class="btn btn-success btn-md float-end ms-2">Apply Filter</button>
                                        <a href="<?php echo base_url('admin/logistic-management/hunger/hunger-area'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
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
                            <table id="masterAreaTable" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Name</th>
                                        <th>Name(Ar)</th>
                                        <th>Status</th>
                                        <th>Created At</th>
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
<!-- container-fluid -->

<!-- Create Team -->
<div class="modal fade fixed-left areaModal" id="areaModal" data-bs-backdrop="static" aria-labelledby="#replacementModalModalLabel2" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-aside">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="areaModalLabel">Create Area</h5>
                <button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="responseContainer"></div>
                <div id="searchResult2" class="mt-4">
                    <div class="size-inner-section px-1 py-1 mx-1">
                        <div class="card-header">Fill Area Detail</div>
                        <?php echo form_open("admin/logistic-management/hunger/create-area", array("id" => "createAreaForm", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
                        <input type="hidden" name="area_id" id="areaId" value="">
                        <div class="row p-2">
                            <div class="col-md-6 col-sm-12 mb-2 form-group">
                                <label for="areaName">EN Name:<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="areaName" name="name" required />
                            </div>

                            <div class="col-md-6 col-sm-12 mb-2 form-group">
                                <label for="areaArName">Arabic Name:<span class="text-danger">*</span></label>
                                <input type="text" class="form-control rtl-input" id="areaArName" name="ar_name" required />
                            </div>
                            <div class="col-md-12 col-sm-12 mb-2 form-group">
                                <label for="areaArName">Status:<span class="text-danger">*</span></label>
                                <select name="status" id="areaStatus" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="searchModalFooter2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetModalData()">Cancel</button>
                <button type="submit" form="createAreaForm" class="btn btn-custom-success" id="submitBtn">Submit</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/home/footer'); ?>
<script src="<?php echo base_url('admin_assets/js/shift_management.js') ?>"></script>

<script>
    $(document).ready(function() {
        initializeAreaTable();
    });

    $('#createAreaForm').parsley().on('form:submit', function() {
        var form = $(this.$element);
        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: form.serialize(),
            dataType: "json",
            success: function(response) {
                if (response.status) {
                    form.closest('.modal').modal('hide');
                    alertSuccess(response.message);
                    resetAreaModal();
                    initializeAreaTable();
                } else {
                    form.closest('.modal').modal('hide');
                    alertError(response.message);
                }
            },
            error: function() {
                alertError('An error occurred while processing your request.');
            }
        });
        return false;
    });
</script>