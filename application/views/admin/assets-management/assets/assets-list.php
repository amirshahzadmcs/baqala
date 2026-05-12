<?php $this->load->view('admin/home/header'); ?>
<style>
    .dataTables_wrapper::-webkit-scrollbar {
        display: none;
    }

    .nav-md .container.body .right_col {
        padding: 10px 10px 0;
        margin-left: 230px;
    }
</style>

<!-- start page title -->
<div class="page-title-box">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-title">
                    <h4>Assets</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Assets List</li>
                    </ol>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="float-end d-sm-block">
                    <?php if (check_action_permission(get_user_role(), 'all_assets', 'add_asset')): ?>
                        <a href="<?php echo base_url('admin/asset-manage/add-asset'); ?>" class="btn btn-custom-success btn-sm pull-right me-1"> <i class="fa fa-plus"></i> Create</a>
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
            <!-- <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="header-title mb-0">Search</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?php //echo base_url('admin/quotation/list'); 
                                        ?>" method="get" id="filter_form">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group mb-2">
                                        <label class="control-label" for="user_id" style="width:100%">Select Customer</label>
                                        <select id="user_id" name="client" class="form-control col-md-12 select2">
                                            <option value="">---- All Customer ----</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Estimate Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text">QTN-</span>
                                            <input type="number" id="_estimate_number" name="estimate_no" value="<?php //echo $this->input->get('estimate_no') ? $this->input->get('estimate_no') : ''; 
                                                                                                                    ?>" autocomplete="off" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group mb-2">
                                        <label class="d-block">Select Status </label>
                                        <select style="height:410px;" name="status" class="form-control select2 w-100">
                                            <option value="">All Status</option>
                                            <option value="pending">Pending</option>
                                            <option value="review">Review</option>
                                            <option value="approved">Approved</option>
                                            <option value="accept">Accepted</option>
                                            <option value="converted">Converted</option>
                                            <option value="delivered">Delivered</option>
                                            <option value="reject">Rejected</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="collapse" id="advanceFilter">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Total Price Between (Min and Max)</label>
                                                <div class="input-group">
                                                    <input type="number" id="_more_than" name="min_price" min="0" placeholder="0" value="" autocomplete="off" class="form-control">
                                                    <input type="number" id="_less_than" name="max_price" min="1" placeholder="100" value="" autocomplete="off" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Date Between (From and To)</label>
                                                <div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                                    <input type="text" class="form-control" id="_from" name="from" value="" autocomplete="off" placeholder="Start Date" />
                                                    <input type="text" class="form-control" id="_to" name="to" value="" autocomplete="off" placeholder="End Date" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Added By</label>
                                                <select class="form-control select2" id="added_by" name="added_by">
                                                    <option value="">--- All ---</option>
                                                    <option value="1">Admin</option>
                                                </select>
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
                                    <a href="<?php //echo base_url('admin/quotation/list'); 
                                                ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div> -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form id="myform" name="myform" method="post" action="">
                            <table id="assets-table" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>#</th>
                                        <th>Asset Name</th>
                                        <th>Asset Image</th>
                                        <th>Asset Code</th>
                                        <th>Category</th>
                                        <th>Data of Entry</th>
                                        <th>Location</th>
                                        <th>Created By</th>
                                        <th>STATUS</th>
                                        <th>Last Scanned Date</th>
                                        <th>Last Scanned By</th>
                                        <th>Modified Date</th>
                                        <th>Modified By</th>
                                        <th>Tools</th>
                                    </tr>
                                </thead>
                            </table>
                        </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
</div>

<!-- Modal -->
<div class="modal fade quotation-modal" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Create Quotation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="demo-form2" method="post" action="<?php echo base_url('admin/quotation/create-quotation') ?>" data-toggle="validator" role="form" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group">
                            <label class="control-label" for="customer_id" style="width:100%">Select Customer <span class="text-danger">*</span></label>
                            <select id="customer_id" name="customer_id" class="form-control col-md-12 select2" required>
                                <option value="">---- Select Customer ----</option>

                            </select>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label class="control-label" for="address_id" style="width:100%">Select Customer Address <span class="text-danger">*</span></label>
                            <select id="address_id" name="address_id" class="form-control select2" required>
                                <option value="">--- Select Customer First ---</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="control-label" for="payment_method">Payment Terms <span class="text-danger">*</span></label>
                            <select id="payment_method" name="payment_method" class="form-control select2" required>
                                <option value="">---- Select Payment Method ----</option>

                            </select>
                            <p><small>Note: Quotation will be expired after 15 days of date added.</small></p>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="name">Quotation Date: <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" placeholder="Pick Date" name="date_added" required />
                        </div>
                    </div>
                    <!--- Additional Field ---->
                    <div class="row">
                        <div class="col-md-12 mb-3 form-group">
                            <label class="form-label">Delivery Instructions (If any)</label>
                            <input id="instruction" name="instruction" type="text" class="form-control" />
                        </div>
                    </div>
                    <div class="row d-none" id="manualAddress">
                        <div class="col-md-6 mb-3 form-group">
                            <label>Deliver To:</label><br>
                            <label class="me-2">Label: </label><span id="c_address_label"></span><br />
                            <label class="me-2">Contact Person: </label><span id="c_person_name"></span><br />
                            <label class="me-2">Contact Number: </label><span id="c_contact_number"></span><br />
                            <label class="me-2">Email: </label><span id="c_email_address"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="me-2">Address: </label>
                            <span id="c_floor"></span> <span id="c_street_name"></span><br />
                            <span id="c_city_name"></span> <span id="c_country_name"></span>
                            <span id="c_zip_code"></span><br>
                            Landmark: <span id="c_reference"></span> <span id="c_extension"></span>
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
        $('#assets-table').dataTable({
            "lengthMenu": [
                [25, 50, 100, 500],
                [25, 50, 100, 500]
            ],
            order: [
                [0, 'asc']
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
            ],
            "responsive": true,
            // "processing":true,
            "serverSide": true,
            fixedHeader: true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url(); ?>admin/asset-manage/asset-list",
                type: "POST"
            },
            "columnDefs": [{
                "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18],
                "orderable": false
            }, ]
        });

    });
</script>