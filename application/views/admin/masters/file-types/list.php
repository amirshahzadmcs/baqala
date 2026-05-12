<?php $this->load->view('admin/home/header'); ?>

<!-- start page title -->
<div class="page-title-box">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-title">
                    <h4>Master File Types</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/master/file-types'); ?>">Master File Types</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
            </div>
            <?php $admin_id = $this->session->userdata('admin_id'); ?>
            <div class="col-sm-6">
                <div class="float-end d-sm-block">
                    <?php if (check_action_permission(get_user_role(), 'file_types', 'delete')): ?>
                        <button class="btn btn-custom-danger btn-sm pull-right me-2" onclick="confirm('Really want to delete this item?') ? $('#delete_form').submit() : false;" title="Delete"><i class="fa fa-trash"></i> Delete</button>
                    <?php endif;
                    if (check_action_permission(get_user_role(), 'file_types', 'add')): ?>
                        <a class="btn btn-custom-success btn-sm pull-right" title="Add" href="<?php echo base_url('admin/master/file-types/add') ?>"><i class="fa fa-plus"></i> Add File Type</a>
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
                        <?php echo form_open('admin/master/file-types/delete', array("id" => "delete_form")); ?>
                        <table id="itemTable" class="table table-striped table-bordered jambo_table bulk_action">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ID</th>
                                    <th>File Types (EN)</th>
                                    <th>File Types (AR)</th>
                                    <th>Sort Order</th>
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

<?php $this->load->view('admin/home/footer'); ?>

<script>
    $(document).ready(function() {

        $('#itemTable').dataTable({
            "lengthMenu": [
                [25, 50, 100, 500],
                [25, 50, 100, 500]
            ],
            "order": [
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
            "ajax": {
                url: "<?php echo base_url(); ?>admin/master/file-types/get-list",
                type: "POST",
                error: function(request, error) {
                    console.log(" Can't do because: " + JSON.stringify(request));
                },
            },
            "columnDefs": [{
                "targets": [0, 1, 2, 3, 4, 5, 6, 7],
                "orderable": false
            }, ]
        });
    });
</script>