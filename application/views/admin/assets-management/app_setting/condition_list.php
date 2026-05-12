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
                    <h4>Condition</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/asset/all-conditions'); ?>">Condition</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
            </div>
            <?php $admin_id = $this->session->userdata('admin_id'); ?>

            <div class="col-sm-6">
                <div class="float-end d-sm-block">
                    <a href="javascript:;" class="btn btn-custom-danger btn-sm pull-right me-1" onclick="location.reload()"> <i class="fas fa-sync"></i> </a>
                    <?php if (check_action_permission(get_user_role(), 'condition', 'create_condition')): ?>
                        <a href="javascript:;" data-bs-target="#conditionModal" data-bs-toggle="modal" class="btn btn-custom-success btn-sm pull-right me-1"> <i class="fa fa-plus"></i> Create</a>
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
                                        <th>Condition Name</th>
                                        <th>Condition Name(AR)</th>
                                        <th>Date of Entry</th>
                                        <th>Created By</th>
                                        <th>Tools</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($conditions as $condition) { ?>
                                        <tr>
                                            <td><?php echo  $i++; ?></td>
                                            <td><?php echo $condition->condition_name; ?></td>
                                            <td><?php echo $condition->condition_ar_name; ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($condition->created_at)); ?></td>
                                            <td><?php echo $condition->created_by; ?></td>
                                            <td>
                                                <?php if (check_action_permission(get_user_role(), 'condition', 'update_condition')): ?>
                                                    <a class="btn btn-outline-secondary btn-custom-light btn-sm edit admin_edit_condition" title="Edit" href="javascript:void(0)" <?php echo 'condition_id=' . $condition->condition_id . ' condition_name=' . $condition->condition_name . ' condition_ar_name=' . $condition->condition_ar_name; ?>>
                                                        <i class="mdi mdi-pencil font-size-18"></i>
                                                    </a>
                                                <?php endif;
                                                if (check_action_permission(get_user_role(), 'condition', 'delete_condition')): ?>
                                                    <a class="btn btn-outline-danger btn-custom-light btn-sm edit pt-1 pb-1 pr-2 pl-2" title="Delete" href="<?php echo base_url('admin/asset/delete-condition?id=' . $condition->condition_id) ?>">
                                                        <i class="fas fa-trash-alt font-size-18"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <a class="btn btn-outline-info btn-custom-light btn-sm edit admin_view_condition" title="View" href="javascript:void(0)" <?php echo 'condition_name=' . $condition->condition_name . ' condition_ar_name=' . $condition->condition_ar_name; ?>>
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

<!-- Condition add/Edit  Modal -->
<div class="modal fade " id="conditionModal" role="dialog" aria-labelledby="conditionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mt-0">Add Asset Condition</h5>
                </div>
                <div>
                    <!-- <a href="<?php echo base_url() ?>admin/application-manage/department-form-builder" class="btn btn-sm"><i class="fas fa-pencil-alt"></i></a> -->
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <form id="admin_add_condition" method="post" action="<?php echo base_url('admin/asset/create-condition'); ?>" data-toggle="validator" role="form" enctype="multipart/form-data" data-parsley-validate>
                    <input type="hidden" name="condition_id" class="condition_id" value="">
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Condition Name <span class="text-danger">*</span></label>
                            <input name="condition_name" type="text" class="form-control condition_name" data-parsley-error-message="Name field is required" required />
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label class="form-label">Condition Arabic Name</label>
                            <input name="condition_ar_name" type="text" class="form-control condition_ar_name" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="admin_add_condition" class="btn btn-success submit_button">Submit</button>
            </div>
        </div>
    </div>
</div>

<!-- Condition View Modal -->
<div class="modal fade " id="conditionViewModal" role="dialog" aria-labelledby="conditionViewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mt-0">Condition Details</h5>
                </div>
                <div>
                    <!-- <button type="button" class="btn btn-sm"><i class="fas fa-pencil-alt"></i></button> -->
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-4 form-group">
                        <label class="form-label">Condition Name</label><br>
                        <span class="text-muted condition_view_name">Human Resources</span>
                    </div>
                    <div class="col-md-6 mb-4 form-group">
                        <label class="form-label">Condition Arabic Name</label><br>
                        <span class="text-muted condition_view_ar_name">Human Resources</span>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->





<?php $this->load->view('admin/home/footer'); ?>
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
            "ordering": false
            // fixedHeader: false,
            // "order": [],
            // "columnDefs": [{
            //     "targets": [0, 1, 2, 3, 4, 5, 6, 7],
            //     "orderable": false,
            // }, ]
        });

    });
</script>