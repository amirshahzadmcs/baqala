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

    .icon-with-shadow {
        cursor: pointer;
        display: inline-block;
        font-size: 18px;
        color: #333;
        text-align: center;
        line-height: 1;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 0 6px 20px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease;
    }

    .icon-with-shadow:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2), 0 12px 40px rgba(0, 0, 0, 0.2);
    }

    .rider-detail {
        border: 1px solid #eaeaea;
        padding: 20px;
        border-radius: 10px;
        background-color: #ffffff;
    }

    .rider-info h4 {
        font-weight: bold;
    }

    .rider-info small {
        color: #6c757d;
    }

    .rider-details dl {
        margin-bottom: 0;
    }

    .rider-details dt {
        font-weight: bold;
    }

    .rider-details dd {
        margin-bottom: 10px;
        color: #333;
    }

    .modal-header {
        border-bottom: none;
    }

    .modal-header .modal-title {
        font-weight: bold;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .size-inner-section {
        background-color: #f7f7f7;
        border-radius: 8px;
        padding: 15px;
    }

    .img-fluid {
        max-width: 80px;
        height: auto;
        border-radius: 50%;
        margin-bottom: 15px;
    }
</style>

<!-- start page title -->
<div class="page-title-box">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-title">
                    <h4>Hunger Team</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/logistic-management/hunger/team-list'); ?>">Hunger Team</a></li>
                        <li class="breadcrumb-item active">View</li>
                    </ol>
                </div>
            </div>
            <div class="col-sm-6 message_place">
                <div class="float-end d-sm-block">
                    <a class="btn btn-sm btn-custom-white pull-right me-2" title="Back" href="<?php echo base_url('admin/logistic-management/hunger/hunger-team') ?>"><i class="fa fa-reply"></i> Back</a>
                    <?php if (check_action_permission(get_user_role(), 'hunger_team', 'team_edit')): ?>
                        <a href="<?php echo base_url('admin/logistic-management/hunger/print-hunger-team?team_id=' . $this->input->get('team_id')); ?>" class="btn btn-custom-success btn-sm pull-right" title="Print" target="_blank">
                            <i class="fa fa-print me-1"></i>Print Pdf
                        </a>
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
                    <div class="card-body">
                        <div class="row size-inner-section px-2 py-4 mx-2">
                            <div class="w-50">
                                <h4 class="header-title float-start">Team Information</h4>
                            </div>
                            <table class="table">
                                <tr>
                                    <td>Name :</td>
                                    <td><span id="teamName"></span></td>
                                    <td rowspan="2" class="align-content-center">
                                        <button type="button" class="btn btn-custom-success btn-sm pull-right" title="Change" onclick="editTeam(this)">
                                            <i class="fa fa-pencil-alt me-1"></i>Add Team Member
                                        </button>
                                    </td>
                                </tr>
                                <tr class="border-white">
                                    <td>Team Leader :</td>
                                    <td id="teamLeader"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="row size-inner-section px-2 py-4 mx-2">
                            <div class="w-50">
                                <h4 class="header-title float-start">Team Members</h4>
                            </div>

                            <div class="teamMembers">
                                <table class="table border">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Emp. No.</th>
                                            <th>Full Name</th>
                                            <th>Mobile No.</th>
                                            <th>Id Number</th>
                                            <th>Platform</th>
                                            <th>Joining Date</th>
                                            <th>Status</th>
                                            <th>Tool</th>
                                        </tr>
                                    </thead>
                                    <tbody id="teamData">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- container-fluid -->

<!-- Create Team -->
<div class="modal fade fixed-left editTeamModal" id="editTeamModal" data-bs-backdrop="static" aria-labelledby="#replacementModalModalLabel2" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-aside">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="editTeamModalLabel">Team Detail</h5>
                <button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="responseContainer"></div>
                <div id="searchResult2" class="mt-4">
                    <div class="size-inner-section px-1 py-1 mx-1">
                        <?php echo form_open("admin/logistic-management/hunger/team_update", array("id" => "editTeamForm", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
                        <input type="hidden" id="teamId" name="teamId" value="">
                        <div class="row p-2">
                            <div class="col-md-12 col-sm-12 mb-2 form-group">
                                <label for="teamName">Team Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="team_name" name="team_name" required />
                            </div>
                            <div class="col-md-12 col-sm-12 mb-2 form-group">
                                <label for="teamLeader">Team Leader <span class="text-danger">*</span></label>
                                <select class="form-control select2" name="team_leader" id="team_leader" data-parsley-errors-container="#teamLeaderError" required>
                                </select>
                                <div id="teamLeaderError"></div>
                            </div>
                            <div class="col-md-12 col-sm-12 mb-2 form-group">
                                <label for="Team">Add Team Member<span class="text-danger">*</span></label>
                                <select name="team[]" id="Team" class="form-select select2" multiple data-parsley-errors-container="#teamError">
                                </select>
                                <div id="teamError"></div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="searchModalFooter2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetModalData()">Cancel</button>
                <button type="submit" form="editTeamForm" class="btn btn-custom-success" id="submitBtn">Submit</button>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->


<!-- Move Team Member-->
<div class="modal fade fixed-left moveTeamModal" id="moveTeamModal" data-bs-backdrop="static" aria-labelledby="#replacementModalModalLabel2" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-aside">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="moveTeamModalLabel">Member Move</h5>
                <button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-4">
                    <div class="size-inner-section px-1 py-1 mx-1">
                        <?php echo form_open("admin/logistic-management/hunger/team_member_moveUpdate", array("id" => "moveTeamForm", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
                        <input type="hidden" id="fromTeamId" name="fromTeamId" value="">
                        <input type="hidden" id="teamMemberId" name="teamMemberId" value="">
                        <div class="row p-2">
                            <div class="col-md-12 col-sm-12 mb-2 form-group">
                                <label for="teamLeader">Move To<span class="text-danger">*</span></label>
                                <select class="form-control select2" name="move_to" id="move_to" data-parsley-errors-container="#teamError" required>
                                </select>
                                <div id="teamError"></div>
                            </div>

                            <div class="col-md-12 col-sm-12 mb-2 form-group">
                                <label for="teamName">Reason<span class="text-danger">*</span></label>
                                <textarea class="form-control" name="memberMoveReason" id="memberMoveReason" placeholder="Enter here..." required></textarea>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="searchModalFooter2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetModalData()">Cancel</button>
                <button type="submit" form="moveTeamForm" class="btn btn-custom-success" id="submitBtn">Submit</button>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->

<!-- Team Leader View -->

<div class="modal fade fixed-left viewTeamLeaderModal" id="viewTeamLeaderModal" data-bs-backdrop="static" aria-labelledby="#replacementModalModalLabel2" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-aside">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="viewTeamLeaderModalLabel">Team Leader Information</h5>
                <button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="responseContainer"></div>
                <div class="mt-4" id="viewTeamLeaderInformation">
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- Team Leader View End -->
<?php $this->load->view('admin/home/footer'); ?>
<script src="<?php echo base_url('admin_assets/js/hunger-team.js') ?>"></script>

<script>
    $(document).ready(function() {
        teamData(getUrlParameter('team_id'));
    });

    $('#editTeamForm').parsley().on('form:submit', function() {
        var form = $(this.$element);
        $.ajax({
            type: "post",
            url: form.attr('action'),
            data: form.serialize(),
            dataType: "json",
            success: function(response) {
                if (response.status) {
                    $('#editTeamModal').modal('hide');
                    teamData(getUrlParameter('team_id'));
                    alertSuccess(response.message);
                    form.find('select').val(null).trigger('change');
                } else {
                    alertError(response.message);
                }
            }
        });
        return false;
    });

    $('#moveTeamForm').parsley().on('form:submit', function() {
        var form = $(this.$element);
        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: form.serialize(),
            dataType: "json",
            success: function(response) {
                if (response.status) {
                    $('#moveTeamModal').modal('hide');
                    form.trigger('reset');
                    teamData(getUrlParameter('team_id'));
                    alertSuccess(response.message);
                } else {
                    alertError(response.message);
                }
            },
        });
        return false;
    });
</script>