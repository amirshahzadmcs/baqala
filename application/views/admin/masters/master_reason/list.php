<?php $this->load->view('admin/home/header'); ?>
<style>
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
        width: 30%;
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
                    <h4>Master Reasons</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/master/master-reason'); ?>">Master Reasons</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="float-end d-sm-block">
                    <?php if (check_action_permission(get_user_role(), 'suspend_reasons', 'add')): ?>
                        <button class="btn btn-custom-danger btn-sm pull-right me-2" onclick="confirm('Really want to delete this item?') ? $('#delete_form').submit() : false;" title="Delete"><i class="fa fa-trash"></i> Delete</button>
                    <?php endif;
                    if (check_action_permission(get_user_role(), 'suspend_reasons', 'edit')): ?>
                        <a class="btn btn-custom-success btn-sm pull-right" title="Add" id="load_add_modal"><i class="fa fa-plus"></i> Add Reasons</a>
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
                <!-- </div> -->
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
                        <?php echo form_open('admin/master/master-reason/delete', array("id" => "delete_form")); ?>
                        <table id="itemTable" class="table table-striped table-bordered jambo_table bulk_action">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ID</th>
                                    <th>Reason Title (EN)</th>
                                    <th>Reason Title (AR)</th>
                                    <th>Type</th>
                                    <th>Created On</th>
                                    <th>Updated On</th>
                                    <th>Tools</th>
                                </tr>
                            </thead>

                        </table>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
</div>
<!-- container-fluid -->

<div class="modal fade staticBackdrop fixed-left reasonModal" id="reasonModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="#reasonModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-aside">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="reasonModalLabel">Add Master Reasons</h5>
                <button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="submit" form="reasonForm" class="btn btn-custom-success">Save</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php $this->load->view('admin/home/footer'); ?>

<script>
    $(document).ready(function() {

        $('#itemTable').dataTable({
            "lengthMenu": [
                [25, 50, 100, 500],
                [25, 50, 100, 500]
            ],
            order: [
                [0, 'DESC']
            ],
            dom: 'Blfrtip',
            buttons: [{
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
            "serverSide": true,
            fixedHeader: true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url(); ?>admin/master/master-reason/get-list?type=suspend_reason",
                type: "POST",
                error: function(request, error) {
                    console.log(" Can't do because: " + JSON.stringify(request));
                },
            },
            "columnDefs": [{
                "targets": [0, 1],
                "orderable": false
            }, ]
        });
    });

    $(document).ready(function() {
        $('#load_add_modal').click(function() {
            $.ajax({
                url: "<?php echo base_url('admin/master/master-reason/add'); ?>",
                type: 'GET',
                success: function(response) {
                    $('#reasonModal').modal('show');
                    $('#reasonModal .modal-content').html(response);
                },
                error: function(request, error) {
                    console.log(" Can't do because: " + JSON.stringify(request));
                    alert('Error loading view');
                }
            });
        });
    });

    function editModal(id) {
        $.ajax({
            url: "<?php echo base_url('admin/master/master-reason/edit'); ?>",
            type: 'POST',
            data: {
                'id': id
            },
            dataType: 'json',
            success: function(response) {
                //console.log(response);
                $('#reasonModal').modal('show');
                $('#reasonModal .modal-content').html(response.output_html);
            },
            error: function(request, error) {
                console.log(" Can't do because: " + JSON.stringify(request));
                alert('Error loading view');
            }
        });
    }
</script>