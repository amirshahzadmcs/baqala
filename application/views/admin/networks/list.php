<?php $this->load->view('admin/home/header'); ?>

<!-- start page title -->
<div class="page-title-box">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-title">
                    <h4>Master Network</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/network'); ?>">Master Network</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="float-end d-sm-block">
                    <?php if (check_action_permission(get_user_role(), 'networks', 'delete')): ?>
                        <button class="btn btn-custom-danger btn-sm pull-right" onclick="confirm('Really want to delete this item?') ? $('#delete_form').submit() : false;" title="Delete"><i class="fa fa-trash"></i> Delete</button>
                    <?php endif;
                    if (check_action_permission(get_user_role(), 'networks', 'add')): ?>
                        <a class="btn btn-custom-success btn-sm pull-right" title="Add" href="<?php echo base_url('admin/network/add') ?>"><i class="fa fa-plus"></i> Add</a>
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
                        <?php echo form_open('admin/network/delete', array("id" => "delete_form")); ?>
                        <table id="regionTable" class="table table-striped table-bordered jambo_table bulk_action">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ID</th>
                                    <th>Network Name</th>
                                    <th>Status</th>
                                    <th>Created On</th>
                                    <th>Updated On</th>
                                    <th>Tools</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($regions as $region) { ?>
                                    <tr>
                                        <td><input type="checkbox" class="checklist" value="<?php echo $region->id; ?>" name="check_list[]" /></td>
                                        <td><?php echo $region->id; ?></td>
                                        <td><?php echo $region->network_name; ?></td>
                                        <td><?php echo ($region->status == 1) ? '<div class="label label-success" >Enabled</div>' : '<div class="label label-danger">Disabled</div>'; ?></td>
                                        <td><?php echo $region->created_at; ?></td>
                                        <td><?php echo $region->updated_at; ?></td>
                                        <td><?= check_action_permission(get_user_role(), 'networks', 'add') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" href="' . base_url() . 'admin/network/add?id=' . $region->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : ''; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
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

        $('#regionTable').dataTable({
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
            fixedHeader: true,
        });
    });
</script>