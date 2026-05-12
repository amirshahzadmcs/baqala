<?php $this->load->view('admin/home/header'); ?>

<style>
    .size-inner-section {
        box-shadow: 0px 1px 4px #c5c5c5;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    .hideadvanced {
        display: none;
    }

    .showadvanced:focus {
        box-shadow: none !important;
    }
</style>
<div id="wait"><img src="<?= base_url('images/sample-loader.gif'); ?>" /><br>Loading..</div>
<!-- start page title -->
<div class="page-title-box">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-title">
                    <h4>Journal Entries</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a
                                href="<?php echo base_url(); ?>admin/accounting/journal/list">Journal Entries</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="float-end d-sm-block">
                    <?php if (check_action_permission(get_user_role(), 'journal_entry_', 'journallogs')): ?>
                        <a href="<?php echo base_url(); ?>admin/accounting/journal/journallogs"
                            class="btn btn-custom-success btn-sm pull-right me-1" title="Journal Logs">
                            <i class="mdi mdi-radiology-box-outline"></i> Journal Logs</a>
                    <?php endif; ?>
                    <?php
                    $sql = "SELECT * FROM recurring_journal_entry";
                    $query = $this->db->query($sql)->result();
                    if (!empty($query) && check_action_permission(get_user_role(), 'journal_entry_', 'recurring_profile')) { ?>
                        <a class="btn btn-custom-success btn-sm pull-right me-1" type="button"
                            href="<?php echo base_url() ?>/admin/accounting/recurring/recurring-profile"> <i
                                class="fas fa-book"></i> Recurring Journal Profiles</a>
                    <?php }
                    if (check_action_permission(get_user_role(), 'journal_entry_', 'createjournal')): ?>
                        &nbsp;
                        <a class="btn btn-custom-success btn-sm pull-right me-1" title="Own Store"
                            href="<?php echo base_url('admin/accounting/journal/create') ?>">
                            <i class="fa fa-plus"></i> Add Journal Entries</a>
                    <?php endif; ?>
                </div>
                <?php if ($this->admin->getInfo()) {
                    $info = explode("--", $this->admin->getInfo());
                    $info_type = $info[0];
                    $msg_data = $info[1];
                    if ($info_type == 2) {
                ?>
                        <div class="alert alert-danger alert-dismissible fade show"
                            style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <strong><?php echo $msg_data; ?></strong>
                        </div>
                    <?php } else { ?>
                        <div class="alert alert-info alert-dismissible fade show"
                            style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
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

<div class="container-fluid">
    <div class="page-content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="header-title mb-0">Search</h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="get" id="filter_form">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Account</label>
                                        <select class="form-control select2 p-3" style="height: 38px !important;">
                                            <optgroup label="Arizona main">
                                                <option value="AZ">Arizona</option>
                                                <option value="CO">Colorado</option>
                                                <option value="ID">Idaho</option>
                                            </optgroup>
                                            <optgroup label="Arizona main">
                                                <option value="AZ">Arizona</option>
                                                <option value="CO">Colorado</option>
                                                <option value="ID">Idaho</option>
                                            </optgroup>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please select a valid state.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="validationCustom02" class="form-label">Description</label>
                                        <input type="text" class="form-control" id="validationCustom02"
                                            placeholder="Description" required>
                                        <div class="valid-feedback">
                                            Description
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Date Range</label>

                                        <div class="input-daterange input-group" id="datepicker6"
                                            data-date-format="dd M, yyyy" data-date-autoclose="true"
                                            data-provide="datepicker" data-date-container='#datepicker6'>
                                            <input type="text" class="form-control" name="start"
                                                placeholder="Start Date" />
                                            <input type="text" class="form-control" name="end" placeholder="End Date" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="validationCustom03" class="form-label">Source</label>
                                        <select class="form-select" id="validationCustom03" required>
                                            <option value="">Any</option>
                                            <option value="0">Manual Journal</option>
                                            <option value="invoice">Invoice</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please select a valid state.
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="validationCustom04" class="form-label">Number</label>
                                        <input type="text" class="form-control" id="validationCustom04"
                                            placeholder="Number" required>
                                        <div class="invalid-feedback">
                                            Please provide a valid Number.
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Journal Status</label>
                                        <select class="select2 form-control select2-multiple" multiple="multiple"
                                            data-placeholder="Choose ...">
                                            <optgroup label="Pacific Time Zone">
                                                <option value="CA">California</option>
                                                <option value="NV">Nevada</option>
                                                <option value="OR">Oregon</option>
                                                <option value="WA">Washington</option>
                                            </optgroup>
                                            <optgroup label="Mountain Time Zone">
                                                <option value="AZ">Arizona</option>
                                                <option value="CO">Colorado</option>
                                                <option value="ID">Idaho</option>
                                                <option value="MT">Montana</option>
                                                <option value="NE">Nebraska</option>
                                                <option value="NM">New Mexico</option>
                                                <option value="ND">North Dakota</option>
                                                <option value="UT">Utah</option>
                                                <option value="WY">Wyoming</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Cost Center</label>
                                        <select name="mode" id="mode" class="form-select">
                                            <option value="">[All Cost Center]</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="collapse" id="advanceFilter">
                                <div class="row">
                                    <div class="col-md-2 ">
                                        <div class="mb-3">
                                            <label for="validationCustom04" class="form-label">Amount More Than</label>
                                            <input type="text" class="form-control" id="validationCustom04" required>
                                            <div class="invalid-feedback">
                                                Please provide a valid Number.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label for="validationCustom04" class="form-label">Amount Less Than</label>
                                            <input type="text" class="form-control" id="validationCustom04" required>
                                            <div class="invalid-feedback">
                                                Please provide a valid Number.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="mb-3">
                                            <label class="form-label">Date Range</label>

                                            <div class="input-daterange input-group" id="datepicker6"
                                                data-date-format="dd M, yyyy" data-date-autoclose="true"
                                                data-provide="datepicker" data-date-container='#datepicker6'>
                                                <input type="text" class="form-control" name="start"
                                                    placeholder="Start Date" />
                                                <input type="text" class="form-control" name="end"
                                                    placeholder="End Date" />
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <button class="btn btn-outline-secondary waves-effect waves-light" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#advanceFilter" aria-expanded="false"
                                        aria-controls="advanceFilter"><i class="fas fa-sliders-h"></i> Advance
                                        Search</button>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <button type="submit" class="btn btn-success btn-md float-end ms-2">Apply
                                        Filter</button>
                                    <a href="" class="btn btn-danger btn-md float-end">Reset Filter</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body mainnewbody">
                        <div class="mainresulttitle">
                            <p>Result</p>
                            <div class="dropdown dropstart">
                                <a type="button" class="dropdown-toggle" data-bs-toggle="dropdown">
                                    Sort By <i class="fas fa-sort"></i></a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item"
                                            href="<?php echo base_url('admin/accounting/journal/list') ?>"><i
                                                class="fas fa-sort-alpha-down-alt"></i> Created Date</a></li>
                                    <li><a class="dropdown-item"
                                            href="<?php echo base_url('admin/accounting/journal/list') ?>"><i
                                                class="fas fa-sort-alpha-down"></i> Number</a></li>
                                    <li><a class="dropdown-item"
                                            href="<?php echo base_url('admin/accounting/journal/list') ?>"><i
                                                class="fas fa-sort-alpha-down-alt"></i> Date</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="index table_mainlist entry-content overflow-autopc">
                            <?php if ($result->num_rows() > 0) { ?>
                                <ul class="day-view-entry-list">
                                    <?php
                                    foreach ($result->result() as $listdata) { ?>
                                        <li class="day-view-entry entrylist day-view-entry-label">
                                            <table cellspacing="0" cellpadding="0">
                                                <tbody>
                                                    <tr>
                                                        <td width="30%" class="clickable">
                                                            <div class="invoice-row entry-info">
                                                                <div class="task-notes">
                                                                    <a class="firstanchor"
                                                                        href="<?php echo base_url('admin/accounting/journal/journaldetails/' . $listdata->id); ?>">
                                                                        <span class="project">#<?php echo $listdata->journal_no; ?></span>
                                                                        - <span class="expense-date">
                                                                            <?php echo date('d/m/Y', strtotime($listdata->journal_date)); ?>
                                                                        </span>
                                                                    </a>
                                                                </div>
                                                                <div class="project-client">
                                                                    <a class="secondanchor" href="<?php echo base_url('admin/accounting/journal/journaldetails/' . $listdata->id); ?>">
                                                                        <span class="project"><?php echo $listdata->journal_description; ?></span>
                                                                    </a>
                                                                </div>
                                                                <ul class="meta-details">
                                                                    <li>
                                                                        <div class="added-by">
                                                                            <span class="added-by-label"><i class="fa fa-building"></i></span>
                                                                            <span class="added-by-value" style="margin-left: 5px"><strong>Main Branch</strong></span>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                        <td class="journal-log-mb" width="35%">
                                                            <?php
                                                            $account = getJournalAccount($listdata->id);
                                                            // print_r($account);
                                                            $jentCount = 1;
                                                            foreach ($account as $accountdetail) { ?>
                                                                <?php if ($jentCount > 1) {
                                                                    echo '<i class="fas fa-long-arrow-alt-right"></i>';
                                                                } ?>
                                                                <a href="<?php echo base_url('admin/chart-of-accounts/cats/' . $accountdetail['journal_account_id']) ?>" class="midfirstbtn" target="_blank"><?php echo $accountdetail['branch_name']; ?></a>
                                                            <?php $jentCount++;
                                                            } ?>
                                                            <div>
                                                                <ul class="meta-details">
                                                                    <br>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                        <td width="30%"><?php if ($listdata->attachments !== '') { ?><img src="<?php echo base_url('admin/uploads/journal/' . $listdata->attachments) ?>" alt="<?php echo $listdata->journal_no; ?>"><?php } ?></td>
                                                        <td class="entry-time" width="10%">
                                                            <span> <?php echo $listdata->debit_total ?>&nbsp;SAR</span>
                                                        </td>
                                                        <td class="entry-button" width="10%">
                                                            <?php
                                                            $role = get_user_role();
                                                            $view = check_action_permission($role, 'journal_entry_', 'journaldetails');
                                                            $edit = check_action_permission($role, 'journal_entry_', 'edit');
                                                            $delete = check_action_permission($role, 'journal_entry_', 'delete');

                                                            if ($view || $edit || $delete): ?>
                                                                <div class="dropdown mobile-options mainresulttitle">
                                                                    <button class="btn btn-lg btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                                        <span class="fa fa-ellipsis-h"></span>
                                                                    </button>
                                                                    <ul class="dropdown-menu">
                                                                        <?php if ($view): ?>
                                                                            <li>
                                                                                <a class="dropdown-item" href="<?= base_url('admin/accounting/journal/journaldetails/' . $listdata->id) ?>">
                                                                                    <i class="far fa-eye text-success"></i> View
                                                                                </a>
                                                                            </li>
                                                                        <?php endif; ?>

                                                                        <?php if ($edit): ?>
                                                                            <li>
                                                                                <a class="dropdown-item" href="<?= base_url('admin/accounting/journal/edit/' . $listdata->id) ?>">
                                                                                    <i class="far fa-edit text-primary"></i> Edit
                                                                                </a>
                                                                            </li>
                                                                        <?php endif; ?>

                                                                        <?php if ($delete): ?>
                                                                            <li>
                                                                                <a class="dropdown-item" href="<?= base_url('admin/accounting/journal/delete/' . $listdata->id) ?>"
                                                                                    onclick="return confirm('Are you sure you want to delete this entry?');">
                                                                                    <i class="fas fa-trash-alt text-danger"></i> Delete
                                                                                </a>
                                                                            </li>
                                                                        <?php endif; ?>
                                                                    </ul>
                                                                </div>
                                                            <?php endif; ?>
                                                        </td>

                                                    </tr>

                                                </tbody>
                                            </table>
                                        </li>
                                    <?php } ?>
                                </ul>
                            <?php } else {
                                echo '<div class="text-center">No Journal Found</div>';
                            } ?>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
</div>
<!-- container-fluid -->
<?php $this->load->view('admin/home/footer'); ?>
<script>
    $(document).ready(function() {
        $(".showadvanced").click(function() {
            $(".hideadvanced").toggle();
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#store-table').dataTable({
            "lengthMenu": [
                [25, 50, 100, 500],
                [25, 50, 100, 500]
            ],
            //order: [[0, 'asc']],
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
            "fixedHeader": true,

            "columnDefs": [{
                "targets": [0, 1, 2, 3, 4, 5, 6],
                "orderable": false
            }, ],
        });
    });
    $.fn.dataTable.ext.errMode = function(settings, helpPage, message) {
        console.log(message);
    };
</script>
<!-- Chart of Accounts -->