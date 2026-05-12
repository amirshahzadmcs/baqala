<?php $this->load->view('admin/home/header');?>

<style>
.required-field {
    color: #f00;
}

.t_table td {
    border: 1px solid #555555;
    border-collapse: collapse;
    font-size: 13px;
}

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
<div id="wait"><img src="<?= base_url('images/sample-loader.gif');?>" /><br>Loading..</div>
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
                    <a href="<?php echo base_url('admin/accounting/journal/journallogs'); ?>"
                        class="btn btn-custom btn-sm pull-right me-1" title="Journal Logs">Journal Logs</a>&nbsp;
                    <a class="btn btn-custom-success btn-sm pull-right me-1" title="Add Journal"
                        href="<?php echo base_url('admin/accounting/journal/create')?>">
                        <i class="fa fa-plus"></i> Add Journal Entries</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->
<?php if(isset($result))
{?>
<div class="container-fluid">
    <div class="page-content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card table_mainlist">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <h1 style="float: none"> Journal #<?php echo $result->journal_no;?></h1>
                                        <div>
                                            <span class="invoice-client sub-heading sub-heading2"></span>
                                            <span class="invoice-client sub-heading sub-heading2"><i
                                                    class="fa fa-building"></i> Main Branch</span>
                                        </div>
                                    </div>
                                    <div class="ml-3 account_maina" style="clear: both;">
                                        <?php 
									$account_list=getJournalAccount($result->id);
									// print_r($account);
									$jentCount = 1;
									foreach ($account_list as $accountdetail)
									{?>
                                        <?php if($jentCount > 1){ echo '<i class="fas fa-long-arrow-alt-right"></i>';}?>
                                        <a href="<?php echo base_url('admin/chart-of-accounts/cats/'. $accountdetail['journal_account_id'])?>"
                                            class="midfirstbtn"
                                            target="_blank"><?php echo $accountdetail['branch_name']; ?></a>
                                        <?php $jentCount++;}
								?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div style="display: flex; align-items:center; justify-content:flex-end;">

                                    <div class="top-actionstop-actions-w100-mob">
                                        <div class="mb-opt-btn"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="btn-group btn-group-md">
                            <table>
                                <tr>
                                    <td><button type="button" class="btn btn-custom-white"><i
                                                class="fas fa-pencil-alt"></i> Edit</button></td>
                                    <td><a href="<?php echo base_url(); ?>admin/accounting/journal/print/<?php echo $result->journal_no;?>"
                                            type="button" class="btn btn-custom-white" id="" target="_blank"><i
                                                class="fas fa-print"></i> Print</button></td>
                                    <td><a href="<?php echo base_url(); ?>admin/accounting/journal/pdf/<?php echo $result->journal_no;?>"
                                            class="btn btn-custom-white"><i class="far fa-file-pdf"></i> PDF</a></td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-custom-white dropdown-toggle"
                                                data-bs-toggle="dropdown"><i class="far fa-clone"></i> Clone <i
                                                    class="fas fa-caret-down"></i></button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item"
                                                    href="<?php echo base_url()?>/admin/accounting/journal/add/<?php echo $result->journal_no;?>">Clone</a>
                                                <a class="dropdown-item" href="#"> Reverse Journal Entry</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td><a href="<?php echo base_url()?>/admin/accounting/journal/delete/<?php echo $result->journal_no;?>"
                                            type="button" class="btn btn-custom-white"><i class="fas fa-trash-alt"></i>
                                            Delete</a></td>
                                    <td> <?php 
								$sql ="SELECT * FROM recurring_journal_entry WHERE entry_id= '". $result->entry_id ."'";
								$query = $this->db->query($sql)->row(); if(!empty($query)) { ?><a class="btn btn-custom-white" type="button"
                                            href="<?php echo base_url()?>/admin/accounting/recurring/profile-detail/<?php echo $query->id;  ?>">
                                            <i class="fas fa-book"></i> View Recurring </a>
                                        <?php } else{ ?><a
                                            href="<?php echo base_url()?>/admin/accounting/journal/recurring-profile/<?php echo $result->journal_no;?>"
                                            type="button" class="btn btn-custom-white"><i class="fas fa-book"></i> Make
                                            Recurring</a>
                                        <?php } ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-custom-white dropdown-toggle"
                                                data-bs-toggle="dropdown"> Assign Cost Centers <i
                                                    class="fas fa-caret-down"></i></button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#"> Basic Salaries Expense (Debit 1,000
                                                    SR )</a>
                                                <a class="dropdown-item" href="#"> Basic Salaries Expense (Debit 3,000
                                                    SR )</a>
                                                <a class="dropdown-item" href="#"> Basic Salaries Expense (Debit 1,300
                                                    SR )</a>
                                                <a class="dropdown-item" href="#"> Salaries Payable (Credit 5,300 SR
                                                    )</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td><button type="button" class="btn btn-custom-white"><i class="fas fa-edit"></i>
                                            Mark as Draft</button></td>

                                </tr>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#journal" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Journal</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#journallog" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">Journal Log</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#activitylog" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">Activity Log</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#journalcostcenters" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">Journal Cost Centers</span>
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content py-3 text-muted">
                            <div class="tab-pane active" id="journal" role="tabpanel">
                                <div class="graytempmain">
                                    <div class="invoice-wrap">
                                        <div class="invoice-inner">
                                            <h2 class="">
                                                Journal Entry #<?php echo $result->journal_no;?></h2>
                                            <table class="f_table">
                                                <tbody>
                                                    <tr>
                                                        <td>Date:
                                                            <?php echo date("d/m/Y", strtotime($result->journal_date));?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Description: <?php echo $result->journal_description;?>
                                                        </td>
                                                        <td class="pull-right">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table id="listing_table" cellpadding="0" cellspacing="0" class="t_table">
                                                <tbody>

                                                    <tr class="bold">
                                                        <td colspan="2" width="30%">Account</td>
                                                        <td width="35%">Description</td>
                                                        <td width="15%">Cost Center</td>
                                                        <td width="10%">Debit</td>
                                                        <td width="10%">Credit</td>
                                                    </tr>

                                                    <?php 
													$account=getJournalEntries($result->id);
													// print_r($account);
													foreach ($account as $accountdetail)
													{?>
                                                    <tr>
                                                        <td><?php echo $accountdetail['code']; ?></td>
                                                        <td><?php echo $accountdetail['branch_name']; ?></td>
                                                        <td><?php echo $accountdetail['description']; ?></td>
                                                        <td><?php echo (!empty($accountdetail['cost_center'])) ? getCostCentDetail($accountdetail['cost_center'])->name : 'NA'; ?>
                                                        </td>
                                                        <td><?php echo $accountdetail['debit']; ?></td>
                                                        <td><?php echo $accountdetail['credit']; ?></td>
                                                    </tr>
                                                    <?php } ?>
                                                    <tr bgcolor="#e5e5e5" style="font-weight:bold;" class="bold">
                                                        <td colspan="4">Total</td>
                                                        <td style="word-wrap: break-word;">
                                                            <?php echo $result->debit_total;?>&nbsp;SR</td>
                                                        <td style="word-wrap: break-word;" colspan="1">
                                                            <?php echo $result->credit_total;?>&nbsp;SR</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="journallog" role="tabpanel">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <table id="logTable"
                                                class="table table-striped table-bordered dt-responsive nowrap"
                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Date</th>
                                                        <th>Action</th>
                                                        <th>Staff Member</th>
                                                        <th>Journal No</th>
                                                        <th>Name</th>
                                                        <th>Description</th>
                                                        <th>Currency Code</th>
                                                        <th>Debit</th>
                                                        <th>Credit</th>
                                                        <th>Local Debit</th>
                                                        <th>Local Credit</th>
                                                        <th>Journal Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
													$accountlog=getJournalAccountLog($result->id);
													// print_r($account);
													foreach ($accountlog as $accountlogs)
													{?>
                                                    <tr>
                                                        <td></td>
                                                        <td><?php echo date("d-m-Y", strtotime($accountlogs['created_at']));?></td>
                                                        <td><?php echo $accountlogs['action'];?></td>
                                                        <td><?php echo $accountlogs['action'];?></td>
                                                        <td><?php echo $accountlogs['journal_number'];?></td>
                                                        <td><?php echo $accountlogs['account_name']; ?> </td>
                                                        <td><?php echo $accountlogs['description']; ?></td>
                                                        <td><?php echo $accountlogs['currency_code'];?></td>
                                                        <td><?php echo $accountlogs['debit']; ?></td>
                                                        <td><?php echo $accountlogs['credit']; ?></td>
                                                        <td><?php echo $accountlogs['local_debit']; ?></td>
                                                        <td><?php echo $accountlogs['local_credit']; ?></td>
                                                        <td><?php echo date("d-m-Y", strtotime($accountlogs['entry_date']));?>
                                                        </td>
                                                    </tr>
                                                    <?php }?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div>
                            <div class="tab-pane" id="activitylog" role="tabpanel">
                                <div class="col-12">
                                    <div class="card mb-0">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col md-2">
                                                    <label class="form-label"></label>
                                                </div>
                                                <div class="col md-3">
                                                    <div>
                                                        <label class="form-label">All Actions</label>

                                                        <select class="select2 form-control select2-multiple"
                                                            multiple="multiple" placeholder="All Actions">
                                                            <optgroup>
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
                                                <div class="col md-3">
                                                    <div>
                                                        <label class="form-label">All Actions</label>
                                                        <select class="select2 form-control select2-multiple"
                                                            multiple="multiple" data-placeholder="All Actors">
                                                            <optgroup>
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
                                                <div class="col md-3">
                                                    <div class="mb-3">
                                                        <label class="form-label">Days</label>
                                                        <select class="form-control select2">
                                                            <option>All Actors</option>
                                                            <optgroup>
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
                                                <div class="col md-1">
                                                    <label class="form-label"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="timeline timelinemain">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body" style="background: #e4ebf2;">
                                                <div class="timeline-container">
                                                    <div class="timeline-end">
                                                        <p>26 August</p>
                                                    </div>
                                                    <div class="timeline-continue">
                                                        <div class="row timeline-right">
                                                            <div class="col-md-12">
                                                                <div class="timeline-box bg-light">
                                                                    <div class="media">
                                                                        <div class="timeline-item">
                                                                            <span class="extend id-59062"><i
                                                                                    class="fa"></i></span>
                                                                            <div class="timeline-meta row">
                                                                                <div class="col-md-12 text">
                                                                                    <p>
                                                                                        <strong>Amanullah Kazi</strong>
                                                                                        Added Journal Entry Line
                                                                                        <strong>
                                                                                            <a href=""
                                                                                                target="_blank">#4</a>
                                                                                        </strong>

                                                                                    </p>
                                                                                    <div class="changes">
                                                                                        <div class="change">
                                                                                            <span class="title">Currency
                                                                                                Debit:</span>
                                                                                            <div
                                                                                                class="d-inline-flex changes-line">
                                                                                                <span
                                                                                                    class="old"><strike>3676.45
                                                                                                    </strike></span>
                                                                                                <span
                                                                                                    class="icon px-2"><i
                                                                                                        class="fas fa-arrow-right"></i></span>
                                                                                                <span
                                                                                                    class="new">1000</span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="change">
                                                                                            <span
                                                                                                class="title">Description:</span>
                                                                                            <div
                                                                                                class="d-inline-flex changes-line">
                                                                                                <span
                                                                                                    class="old"><strike>3676.45
                                                                                                    </strike></span>
                                                                                                <span
                                                                                                    class="icon px-2"><i
                                                                                                        class="fas fa-arrow-right"></i></span>
                                                                                                <span class="new">Sana
                                                                                                    Khan</span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="change">
                                                                                            <span class="title">Journal
                                                                                                Account:</span>
                                                                                            <div
                                                                                                class="d-inline-flex changes-line">
                                                                                                <span
                                                                                                    class="old"><strike>3676.45
                                                                                                    </strike></span>
                                                                                                <span
                                                                                                    class="icon px-2"><i
                                                                                                        class="fas fa-arrow-right"></i></span>
                                                                                                <span class="new">Basic
                                                                                                    Salaries
                                                                                                    Expense</span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="change">
                                                                                            <span
                                                                                                class="title">Debit:</span>
                                                                                            <div
                                                                                                class="d-inline-flex changes-line">
                                                                                                <span
                                                                                                    class="old"><strike>3676.45
                                                                                                    </strike></span>
                                                                                                <span
                                                                                                    class="icon px-2"><i
                                                                                                        class="fas fa-arrow-right"></i></span>
                                                                                                <span
                                                                                                    class="new">1000</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div
                                                                                class="timeline-meta timeline-meta-footer d-flex">
                                                                                <div class="meta time">
                                                                                    <i class="far mr-2 fa-clock"></i>
                                                                                    <span>
                                                                                        08:05:55
                                                                                    </span>
                                                                                </div>

                                                                                <div class="meta user tip observed tooltipstered"
                                                                                    data-title="172.18.0.5">
                                                                                    <i
                                                                                        class="fas mr-2 fa-user-circle"></i>
                                                                                    <span>Amanullah Kazi</span>
                                                                                </div>
                                                                                <div class="meta branch">
                                                                                    <i class="fal mr-2 fa-building"></i>
                                                                                    <span>Main Branch</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row timeline-right">
                                                            <div class="col-md-12">
                                                                <div class="timeline-box bg-light">
                                                                    <div class="media">
                                                                        <div class="timeline-item">
                                                                            <span class="extend id-59062"><i
                                                                                    class="fa"></i></span>
                                                                            <div class="timeline-meta row">
                                                                                <div class="col-md-12 text">
                                                                                    <p>
                                                                                        <strong>Amanullah Kazi</strong>
                                                                                        Added Journal Entry Line
                                                                                        <strong>
                                                                                            <a href=""
                                                                                                target="_blank">#4</a>
                                                                                        </strong>

                                                                                    </p>
                                                                                    <div class="changes">
                                                                                        <div class="change">
                                                                                            <span class="title">Currency
                                                                                                Debit:</span>
                                                                                            <div
                                                                                                class="d-inline-flex changes-line">
                                                                                                <span
                                                                                                    class="old"><strike>3676.45
                                                                                                    </strike></span>
                                                                                                <span
                                                                                                    class="icon px-2"><i
                                                                                                        class="fas fa-arrow-right"></i></span>
                                                                                                <span
                                                                                                    class="new">1000</span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="change">
                                                                                            <span
                                                                                                class="title">Description:</span>
                                                                                            <div
                                                                                                class="d-inline-flex changes-line">
                                                                                                <span
                                                                                                    class="old"><strike>3676.45
                                                                                                    </strike></span>
                                                                                                <span
                                                                                                    class="icon px-2"><i
                                                                                                        class="fas fa-arrow-right"></i></span>
                                                                                                <span class="new">Sana
                                                                                                    Khan</span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="change">
                                                                                            <span class="title">Journal
                                                                                                Account:</span>
                                                                                            <div
                                                                                                class="d-inline-flex changes-line">
                                                                                                <span
                                                                                                    class="old"><strike>3676.45
                                                                                                    </strike></span>
                                                                                                <span
                                                                                                    class="icon px-2"><i
                                                                                                        class="fas fa-arrow-right"></i></span>
                                                                                                <span class="new">Basic
                                                                                                    Salaries
                                                                                                    Expense</span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="change">
                                                                                            <span
                                                                                                class="title">Debit:</span>
                                                                                            <div
                                                                                                class="d-inline-flex changes-line">
                                                                                                <span
                                                                                                    class="old"><strike>3676.45
                                                                                                    </strike></span>
                                                                                                <span
                                                                                                    class="icon px-2"><i
                                                                                                        class="fas fa-arrow-right"></i></span>
                                                                                                <span
                                                                                                    class="new">1000</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div
                                                                                class="timeline-meta timeline-meta-footer d-flex">
                                                                                <div class="meta time">
                                                                                    <i class="far mr-2 fa-clock"></i>
                                                                                    <span>
                                                                                        08:05:55
                                                                                    </span>
                                                                                </div>

                                                                                <div class="meta user tip observed tooltipstered"
                                                                                    data-title="172.18.0.5">
                                                                                    <i
                                                                                        class="fas mr-2 fa-user-circle"></i>
                                                                                    <span>Amanullah Kazi</span>
                                                                                </div>
                                                                                <div class="meta branch">
                                                                                    <i class="fal mr-2 fa-building"></i>
                                                                                    <span>Main Branch</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row timeline-right">
                                                            <div class="col-md-12">
                                                                <div class="timeline-box bg-light">
                                                                    <div class="media">
                                                                        <div class="timeline-item">
                                                                            <span class="extend id-59062"><i
                                                                                    class="fa"></i></span>
                                                                            <div class="timeline-meta row">
                                                                                <div class="col-md-12 text">
                                                                                    <p>
                                                                                        <strong>Amanullah Kazi</strong>
                                                                                        Added Journal Entry Line
                                                                                        <strong>
                                                                                            <a href=""
                                                                                                target="_blank">#4</a>
                                                                                        </strong>

                                                                                    </p>
                                                                                    <div class="changes">
                                                                                        <div class="change">
                                                                                            <span class="title">Currency
                                                                                                Debit:</span>
                                                                                            <div
                                                                                                class="d-inline-flex changes-line">
                                                                                                <span
                                                                                                    class="old"><strike>3676.45
                                                                                                    </strike></span>
                                                                                                <span
                                                                                                    class="icon px-2"><i
                                                                                                        class="fas fa-arrow-right"></i></span>
                                                                                                <span
                                                                                                    class="new">1000</span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="change">
                                                                                            <span
                                                                                                class="title">Description:</span>
                                                                                            <div
                                                                                                class="d-inline-flex changes-line">
                                                                                                <span
                                                                                                    class="old"><strike>3676.45
                                                                                                    </strike></span>
                                                                                                <span
                                                                                                    class="icon px-2"><i
                                                                                                        class="fas fa-arrow-right"></i></span>
                                                                                                <span class="new">Sana
                                                                                                    Khan</span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="change">
                                                                                            <span class="title">Journal
                                                                                                Account:</span>
                                                                                            <div
                                                                                                class="d-inline-flex changes-line">
                                                                                                <span
                                                                                                    class="old"><strike>3676.45
                                                                                                    </strike></span>
                                                                                                <span
                                                                                                    class="icon px-2"><i
                                                                                                        class="fas fa-arrow-right"></i></span>
                                                                                                <span class="new">Basic
                                                                                                    Salaries
                                                                                                    Expense</span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="change">
                                                                                            <span
                                                                                                class="title">Debit:</span>
                                                                                            <div
                                                                                                class="d-inline-flex changes-line">
                                                                                                <span
                                                                                                    class="old"><strike>3676.45
                                                                                                    </strike></span>
                                                                                                <span
                                                                                                    class="icon px-2"><i
                                                                                                        class="fas fa-arrow-right"></i></span>
                                                                                                <span
                                                                                                    class="new">1000</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div
                                                                                class="timeline-meta timeline-meta-footer d-flex">
                                                                                <div class="meta time">
                                                                                    <i class="far mr-2 fa-clock"></i>
                                                                                    <span>
                                                                                        08:05:55
                                                                                    </span>
                                                                                </div>

                                                                                <div class="meta user tip observed tooltipstered"
                                                                                    data-title="172.18.0.5">
                                                                                    <i
                                                                                        class="fas mr-2 fa-user-circle"></i>
                                                                                    <span>Amanullah Kazi</span>
                                                                                </div>
                                                                                <div class="meta branch">
                                                                                    <i class="fal mr-2 fa-building"></i>
                                                                                    <span>Main Branch</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="timeline-year">
                                                                    <p>25 August</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row timeline-right">
                                                            <div class="col-md-12">
                                                                <div class="timeline-box bg-light">
                                                                    <div class="media">
                                                                        <div class="timeline-item">
                                                                            <span class="extend id-59062"><i
                                                                                    class="fa"></i></span>
                                                                            <div class="timeline-meta row">
                                                                                <div class="col-md-12 text">
                                                                                    <p>
                                                                                        <strong>Amanullah Kazi</strong>
                                                                                        Added Journal Entry Line
                                                                                        <strong>
                                                                                            <a href=""
                                                                                                target="_blank">#4</a>
                                                                                        </strong>

                                                                                    </p>
                                                                                    <div class="changes">
                                                                                        <div class="change">
                                                                                            <span class="title">Currency
                                                                                                Debit:</span>
                                                                                            <div
                                                                                                class="d-inline-flex changes-line">
                                                                                                <span
                                                                                                    class="old"><strike>3676.45
                                                                                                    </strike></span>
                                                                                                <span
                                                                                                    class="icon px-2"><i
                                                                                                        class="fas fa-arrow-right"></i></span>
                                                                                                <span
                                                                                                    class="new">1000</span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="change">
                                                                                            <span
                                                                                                class="title">Description:</span>
                                                                                            <div
                                                                                                class="d-inline-flex changes-line">
                                                                                                <span
                                                                                                    class="old"><strike>3676.45
                                                                                                    </strike></span>
                                                                                                <span
                                                                                                    class="icon px-2"><i
                                                                                                        class="fas fa-arrow-right"></i></span>
                                                                                                <span class="new">Sana
                                                                                                    Khan</span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="change">
                                                                                            <span class="title">Journal
                                                                                                Account:</span>
                                                                                            <div
                                                                                                class="d-inline-flex changes-line">
                                                                                                <span
                                                                                                    class="old"><strike>3676.45
                                                                                                    </strike></span>
                                                                                                <span
                                                                                                    class="icon px-2"><i
                                                                                                        class="fas fa-arrow-right"></i></span>
                                                                                                <span class="new">Basic
                                                                                                    Salaries
                                                                                                    Expense</span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="change">
                                                                                            <span
                                                                                                class="title">Debit:</span>
                                                                                            <div
                                                                                                class="d-inline-flex changes-line">
                                                                                                <span
                                                                                                    class="old"><strike>3676.45
                                                                                                    </strike></span>
                                                                                                <span
                                                                                                    class="icon px-2"><i
                                                                                                        class="fas fa-arrow-right"></i></span>
                                                                                                <span
                                                                                                    class="new">1000</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div
                                                                                class="timeline-meta timeline-meta-footer d-flex">
                                                                                <div class="meta time">
                                                                                    <i class="far mr-2 fa-clock"></i>
                                                                                    <span>
                                                                                        08:05:55
                                                                                    </span>
                                                                                </div>

                                                                                <div class="meta user tip observed tooltipstered"
                                                                                    data-title="172.18.0.5">
                                                                                    <i
                                                                                        class="fas mr-2 fa-user-circle"></i>
                                                                                    <span>Amanullah Kazi</span>
                                                                                </div>
                                                                                <div class="meta branch">
                                                                                    <i class="fal mr-2 fa-building"></i>
                                                                                    <span>Main Branch</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="timeline-year">
                                                                    <p>25 August</p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row timeline-right">
                                                            <div class="col-md-12">
                                                                <div class="timeline-box bg-light">
                                                                    <div class="media">
                                                                        <div class="timeline-item">
                                                                            <span class="extend id-59062"><i
                                                                                    class="fa"></i></span>
                                                                            <div class="timeline-meta row">
                                                                                <div class="col-md-12 text">
                                                                                    <p>
                                                                                        <strong>Amanullah Kazi</strong>
                                                                                        Added Journal Entry Line
                                                                                        <strong>
                                                                                            <a href=""
                                                                                                target="_blank">#4</a>
                                                                                        </strong>

                                                                                    </p>
                                                                                    <div class="changes">
                                                                                        <div class="change">
                                                                                            <span class="title">Currency
                                                                                                Debit:</span>
                                                                                            <div
                                                                                                class="d-inline-flex changes-line">
                                                                                                <span
                                                                                                    class="old"><strike>3676.45
                                                                                                    </strike></span>
                                                                                                <span
                                                                                                    class="icon px-2"><i
                                                                                                        class="fas fa-arrow-right"></i></span>
                                                                                                <span
                                                                                                    class="new">1000</span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="change">
                                                                                            <span
                                                                                                class="title">Description:</span>
                                                                                            <div
                                                                                                class="d-inline-flex changes-line">
                                                                                                <span
                                                                                                    class="old"><strike>3676.45
                                                                                                    </strike></span>
                                                                                                <span
                                                                                                    class="icon px-2"><i
                                                                                                        class="fas fa-arrow-right"></i></span>
                                                                                                <span class="new">Sana
                                                                                                    Khan</span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="change">
                                                                                            <span class="title">Journal
                                                                                                Account:</span>
                                                                                            <div
                                                                                                class="d-inline-flex changes-line">
                                                                                                <span
                                                                                                    class="old"><strike>3676.45
                                                                                                    </strike></span>
                                                                                                <span
                                                                                                    class="icon px-2"><i
                                                                                                        class="fas fa-arrow-right"></i></span>
                                                                                                <span class="new">Basic
                                                                                                    Salaries
                                                                                                    Expense</span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="change">
                                                                                            <span
                                                                                                class="title">Debit:</span>
                                                                                            <div
                                                                                                class="d-inline-flex changes-line">
                                                                                                <span
                                                                                                    class="old"><strike>3676.45
                                                                                                    </strike></span>
                                                                                                <span
                                                                                                    class="icon px-2"><i
                                                                                                        class="fas fa-arrow-right"></i></span>
                                                                                                <span
                                                                                                    class="new">1000</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div
                                                                                class="timeline-meta timeline-meta-footer d-flex">
                                                                                <div class="meta time">
                                                                                    <i class="far mr-2 fa-clock"></i>
                                                                                    <span>
                                                                                        08:05:55
                                                                                    </span>
                                                                                </div>

                                                                                <div class="meta user tip observed tooltipstered"
                                                                                    data-title="172.18.0.5">
                                                                                    <i
                                                                                        class="fas mr-2 fa-user-circle"></i>
                                                                                    <span>Amanullah Kazi</span>
                                                                                </div>
                                                                                <div class="meta branch">
                                                                                    <i class="fal mr-2 fa-building"></i>
                                                                                    <span>Main Branch</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="journalcostcenters" role="tabpanel">
                                <div class="journal__cost__main">
                                    <table class="t_table table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th colspan="2">Cost Center</th>
                                                <th>Type</th>
                                                <th>Debit</th>
                                                <th>Credit</th>
                                                <th>Percentage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>
                                                    <a target="_parent" href="#"> Basic Salaries Expense </a>
                                                </th>
                                                <th> 310001</th>
                                                <th colspan="4"> &nbsp;</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="clearfix">
                                                        <strong class="operations__main">
                                                            <a class="no-print" target="_blank"
                                                                style="text-decoration: underline; color: #0b56eb"
                                                                href="#"> Operations </a>
                                                            <a target="_parent" href="#"
                                                                class="no-print btn btn-xs pull-right">
                                                                <i class="mdi mdi-close-thick"></i>
                                                            </a>
                                                        </strong>
                                                    </span>
                                                </td>
                                                <td> 10 </td>
                                                <td> Manual </td>
                                                <td> 1,000 </td>
                                                <td> 0.00 </td>
                                                <td> 100% </td>
                                            </tr>
                                            <tr>
                                                <th colspan="3">Account Totals</th>
                                                <th>1,000</th>
                                                <th>0.00</th>
                                                <th>100% </th>
                                            </tr>
                                            <tr>
                                                <td colspan="6">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <th> <a target="_parent" href="#"> Basic Salaries Expense </a></th>
                                                <th> 310001</th>
                                                <th colspan="4"> &nbsp;</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="clearfix">
                                                        <strong class="operations__main">
                                                            <a class="no-print" target="_blank"
                                                                style="text-decoration: underline; color: #0b56eb"
                                                                href="#"> Operations </a>
                                                            <a target="_parent" href=""
                                                                class="no-print btn btn-xs pull-right">
                                                                <i class="mdi mdi-close-thick"></i>
                                                            </a>
                                                        </strong>
                                                    </span>
                                                </td>
                                                <td> 10 </td>
                                                <td> Manual </td>
                                                <td> 3,000 </td>
                                                <td> 0.00 </td>
                                                <td> 100% </td>
                                            </tr>
                                            <tr>
                                                <th colspan="3">Account Totals</th>
                                                <th>3,000</th>
                                                <th>0.00</th>
                                                <th>100% </th>
                                            </tr>
                                            <tr>
                                                <td colspan="6">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <a target="_parent" href="#">
                                                        Salaries Payable </a>
                                                </th>
                                                <th> 229001</th>
                                                <th colspan="4"> &nbsp;</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="clearfix">
                                                        <strong class="operations__main">
                                                            <a class="no-print" target="_blank"
                                                                style="text-decoration: underline; color: #0b56eb"
                                                                href="#"> Operations </a>
                                                            <a target="_parent" href="#"
                                                                class="no-print btn btn-xs pull-right">
                                                                <i class="mdi mdi-close-thick"></i>
                                                            </a>
                                                        </strong>
                                                    </span>
                                                </td>
                                                <td> 10 </td>
                                                <td> Manual </td>
                                                <td> 0.00 </td>
                                                <td> 1,300 </td>
                                                <td> 100% </td>
                                            </tr>
                                            <tr>
                                                <th colspan="3">Account Totals</th>
                                                <th>0.00</th>
                                                <th>1,300</th>
                                                <th>100% </th>
                                            </tr>
                                            <tr>
                                                <td colspan="6">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <a target="_parent" href="#">
                                                        Salaries Payable </a>
                                                </th>
                                                <th> 229001</th>
                                                <th colspan="4"> &nbsp;</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="clearfix">
                                                        <strong class="operations__main">
                                                            <a class="no-print" target="_blank"
                                                                style="text-decoration: underline; color: #0b56eb"
                                                                href="#">
                                                                Operations </a>
                                                            <a target="_parent" href="#"
                                                                class="no-print btn btn-xs pull-right">
                                                                <i class="mdi mdi-close-thick"></i>
                                                            </a>
                                                        </strong>
                                                    </span>
                                                </td>
                                                <td> 10 </td>
                                                <td> Manual </td>
                                                <td> 0.00 </td>
                                                <td> 1,300 </td>
                                                <td> 100% </td>
                                            </tr>
                                            <tr>
                                                <th colspan="3">Account Totals</th>
                                                <th>0.00</th>
                                                <th>1,300</th>
                                                <th>100% </th>
                                            </tr>
                                            <tr>
                                                <td colspan="6">&nbsp;</td>
                                            </tr>
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
</div>
<?php } ?>
<!-- container-fluid -->
<?php $this->load->view('admin/home/footer');?>
<script>
$(document).ready(function() {
    $('#logTable').dataTable({
        "lengthMenu": [
            [25, 50, 100, 500],
            [25, 50, 100, 500]
        ],
        order: [
            [0, 'asc']
        ],
        "responsive": true,
        fixedHeader: true,
		"columnDefs": [{
            "targets": [0, 1, 2, 3, 4, 5, 6,7,8,9,10,11,12],
            "orderable": false
        }, ],
    });
});
</script>
<script type="text/javascript">
// function printDiv() 
// {
// 	var divToPrint=document.getElementById("journal");
//    newWin= window.open("");
//    newWin.document.write(divToPrint.outerHTML);
//    newWin.print();
//    newWin.close();

// }
</script>
