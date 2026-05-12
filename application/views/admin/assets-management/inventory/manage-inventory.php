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
                    <h4>Inventory</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">List of Inventory</li>
                    </ol>
                </div>
            </div>
            <?php $admin_id = $this->session->userdata('admin_id'); ?>
            <div class="col-sm-6">
                <div class="float-end d-sm-block">
                    <!-- <a href="javascript:;" data-bs-target="#reportwidgetModal" data-bs-toggle="modal" class="btn btn-custom-dark btn-sm pull-right me-1"> <i class="fas fa-file-invoice"></i> </a> -->
                    <!-- <a href="javascript:;" class="btn btn-custom-warning btn-sm pull-right me-1"> <i class="fas fa-download"></i> </a> -->
                    <a href="javascript:void(0);" class="btn btn-custom-danger btn-sm pull-right me-1" onclick="location.reload()"> <i class="fas fa-sync"></i> </a>
                    <!-- <a href="javascript:;" data-bs-target="#itemsModal" data-bs-toggle="modal" class="btn btn-custom-success btn-sm pull-right me-1"> <i class="fa fa-plus"></i> Create</a> -->

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
                            <table id="inventory-items" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Item Code</th>
                                        <th>Image</th>
                                        <th>SKU</th>
                                        <th>Item Name</th>
                                        <th>Item Name(Ar)</th>
                                        <th>Available Stock</th>
                                        <th>Amount</th>
                                        <th>Unit </th>
                                        <th>Category</th>
                                        <th>Tools</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>IM00004</td>
                                        <td></td>
                                        <td>568236</td>
                                        <td>Earbuds</td>
                                        <td>سماعات الأذن</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="d-flex">
                                            <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-bs-target="#inventoryaddModal" data-bs-toggle="modal" title="Edit" href="">
                                                <i class="mdi mdi-plus font-size-18"></i>
                                            </a>
                                            <a class="btn btn-outline-secondary btn-custom-light btn-sm edit pt-1 pb-1 pr-2 pl-2" title="Delete" href="">
                                                <i class="far fa-copy font-size-18"></i>
                                            </a>
                                            <a class="btn btn-outline-danger btn-custom-light btn-sm edit pt-1 pb-1 pr-2 pl-2" title="Delete" href="">
                                                <i class="fas fa-trash-alt font-size-18"></i>
                                            </a>
                                            <a onclick="window.print()" class="btn btn-outline-secondary btn-custom-light btn-sm edit pt-1 pb-1 pr-2 pl-2" title="Delete">
                                                <i class="fas fa-print font-size-18"></i>
                                            </a>
                                            <a class="btn btn-outline-info btn-custom-light btn-sm edit" data-bs-target="#itemsviewModal" data-bs-toggle="modal" title="View" href="">
                                                <i class="mdi mdi-eye font-size-18"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
</div>



<!-- Inventory Edit Modal -->
<div class="modal fade " id="inventoryaddModal" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mt-0">Add Inventory</h5>
                </div>
                <div>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">

                <form id="demo-form2" method="post" action="" data-toggle="validator" role="form" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Addition Date</label>
                            <div class="input-group" id="datepicker1">
                                <input type="text" name="addition_date" class="form-control" placeholder="dd M, yyyy" data-date-format="dd M, yyyy" data-date-container='#datepicker1' data-provide="datepicker" value="<?php echo date('F j, Y'); ?>">

                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label mb-0">Stock Point Type <span class="text-danger">*</span></label>
                            <p style="color: #a1a5b7 !important; font-size: 13px; margin-bottom: 0px;">Whether the inventory should be added on Location/User/Asset</p>
                            <select class="form-control select2" data-placeholder="Choose ..." name="stock_type" id="stockTypeChange">
                                <option value="1">User</option>
                                <option value="2">Item</option>
                                <option value="3">Asset</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label mb-0">Addition By</label>
                            <select class="form-control select2" data-placeholder="Choose ..." name="addition_by">
                                <option value="">Amanullah (aman@mahaalfala.com)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Remarks</label>
                            <input id="instruction" name="remark" type="text" class="form-control"/>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Stock Point new <span class="text-danger"> *</span></label>
                            <input id="instruction" name="stock_point" type="text" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Email CC</label>
                            <select class="select2 form-control select2-multiple" name="email_cc" multiple="multiple" data-placeholder="Choose ...">
                                <option value="AK">Alaska</option>
                                <option value="HI">Hawaii</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label mb-0">Mode <span class="text-danger"> *</span></label>
                            <select class="form-control select2" data-placeholder="Choose ..." name="mode">
                                <option value="Opening Stock">Opening Stock</option>
                                <option value="Purchase">Purchase</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label mb-0">Vendor</label>
                            <select class="form-control select2" data-placeholder="Choose ..." name="vendor">
                                <option value="Opening Stock">Acme Inc.(S00081)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Upload Files</label>
                            <div id="myDropzone" class="dropzone">
                                <div class="fallback">
                                    <input name="inventory_files" id="attachment" accept="image/png, image/jpeg, image/jpg, image/gif, image/svg, image/webp" data-max-file-size="2M" data-height="100" class="form-control" type="file" name="file" />
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h5>Items</h5>
                        </div>
                    </div>

                    <table id="detail" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <td>Item</td>
                                <td>Item Code </td>
                                <td>Tax Code </td>
                                <td>Batch No </td>
                                <td>Batch Date </td>
                                <td>Rate </td>
                                <td>Quantity </td>
                                <td> </td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $dattribute_row = 1; { ?>

                                <tr id="dattribute-row">
                                    <td style="width:14%;">
                                        <select class="form-control select2">
                                            <option>Select an Option</option>
                                            <option>Owner</option>
                                        </select>
                                    </td>
                                    <td style="width:14%;">
                                        <input id="instruction" type="text" class="form-control" />
                                    </td>
                                    <td style="width:14%;">
                                        <input id="instruction" type="text" class="form-control" />
                                    </td>
                                    <td style="width:14%;">
                                        <input id="instruction" type="number" class="form-control" />
                                    </td>
                                    <td style="width:14%;">
                                        <div class="input-group" id="datepicker1">
                                            <input type="text" class="form-control" placeholder="dd M, yyyy" data-date-format="dd M, yyyy" data-date-container='#datepicker1' data-provide="datepicker">
                                        </div>
                                    </td>
                                    <td style="width:14%;">
                                        <input id="instruction" type="text" class="form-control" />
                                    </td>
                                    <td style="width:14%;">
                                        <input id="instruction" type="number" class="form-control" />
                                    </td>

                                    <td class="text-right">
                                        <button type="button" onclick="remove_dattribute(<?php echo $dattribute_row; ?>)" data-toggle="tooltip" title="Remove" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></button>
                                    </td>
                                </tr>
                            <?php $dattribute_row = $dattribute_row + 1;
                            } ?>
                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="7"></td>
                                <td class="text-right">
                                    <button type="button" onclick="adddAttribute();" title="Add" class="btn btn-success btn-sm"><i class="fa fa-plus-circle"></i></button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="demo-form2" class="btn btn-success">Update</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php $this->load->view('admin/home/footer'); ?>

<script type="text/javascript">
    var dattribute_row = <?php echo $dattribute_row; ?>;

    function adddAttribute() {
        html = '<tr id="dattribute-row' + dattribute_row + '">';
        html += ' <td style="width:14%;"><select  class="form-control select2"><option >Select an Option</option><option>Owner</option></select></td>';
        html += ' <td style="width:14%;"><input id="instruction" type="text" class="form-control" /></td>';
        html += ' <td style="width:14%;"><input id="instruction" type="text" class="form-control" /></td>';
        html += ' <td style="width:14%;"><input id="instruction" type="number" class="form-control" /></td>';
        html += ' <td style="width:14%;"><div class="input-group" id="datepicker1"><input type="text" class="form-control" placeholder="dd M, yyyy" data-date-format="dd M, yyyy" data-date-container="#datepicker1" data-provide="datepicker"></div></td>';
        html += ' <td style="width:14%;"><input id="instruction" type="text" class="form-control" /></td>';
        html += ' <td style="width:14%;"><input id="instruction" type="number" class="form-control" /></td>';
        html += '<td><button type="button" onclick="remove_dattribute(' + dattribute_row + ')" data-toggle="tooltip" title="Remove"class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></button><td>';
        html += '</tr>';

        $('#detail tbody').append(html);

        dattribute_row++;
    }

    function remove_dattribute(u) {
        $('#dattribute-row' + u).remove();
    }
</script>

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
        var table = $('#inventory-items').dataTable({
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
            searching: true,
            ordering: false,
            ajax: {
                url: "<?php echo base_url() ?>admin/asset/inventory/list-items",
                type: "POST",
                error: function(request, error) {
                    console.log(" Can't do because: " + JSON.stringify(request));
                },
            },

            columnDefs: [{
                targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                orderable: false,
            }, ],
        });

    });



    Dropzone.autoDiscover = false;

    $(document).ready(function() {
        // Initialize Dropzone
        var myDropzone = new Dropzone("#myDropzone", {
            url: "{{ route('image.upload') }}",
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: 2, // MB
            acceptedFiles: 'image/*',
            dictDefaultMessage: 'Drop files here or click to upload',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(file, response) {
                console.log('File uploaded successfully:', response.url);
            },
            error: function(file, response) {
                console.error('Error uploading file:', response);
            }
        });
    });
</script>