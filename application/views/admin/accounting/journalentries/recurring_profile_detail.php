<?php $this->load->view('admin/home/header');?>

<style>
	.required-field{
		color: #f00;
	}
	.t_table td {
    border: 1px solid #555555;
    border-collapse: collapse;
    padding: 6px 19px 12px 28px;
    font-size: 13px;
}
	.size-inner-section {
		box-shadow: 0px 1px 4px #c5c5c5;
		border-radius: 5px;
		margin-bottom: 10px;
	}
	.cv-documents{
		border: 1px dashed #a9a9a9;
		padding: 6px;
		width: 130px;
		height: 130px;
		margin-top: -9px;
	}
	.image-container {
		position: relative;
		display: inline-block;
	}
	.image-container .overlay{
		opacity: 0;
	}
	.image-container:hover .overlay{
		background: #0006;
		opacity: .9;
		position: absolute;
		top: -9px;
		bottom: 0;
		width: 130px;
    	height: 130px;
	}
	.image-container:hover .edit {
		display: block;
	}
	.image-container .edit {
		padding-top: 7px;	
		padding-right: 7px;
		position: absolute;
		right: 0;
		left: 0;
		top: 20%;
		display: none;
	}

    .hideadvanced{
        display: none;
    }
    .showadvanced:focus{
        box-shadow: none !important;
    }
	.graytempmain .invoice-wrap {
    width: 100%;
    margin: 0 auto;
    background: #FFF;
    color: #000;
}
</style>
<div id="wait"><img src="<?= base_url('images/sample-loader.gif');?>" /><br>Loading..</div>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Recurring Journal Entry Profiles</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/accounting/journal/list"> Recurring Journal Entry Profiles</a></li>
						<li class="breadcrumb-item active"><?php echo $result->name;?>/# <?php  echo $result->id;?></li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a href="<?php echo base_url(); ?>admin/accounting/journal/journallogs" class="btn btn-primary btn-sm pull-right" title="Journal Logs">
                         Journal Logs</a>
										&nbsp;
					<a class="btn btn-custom-success btn-sm pull-right me-1" title="Own Store" href="<?php echo base_url('admin/accounting/journal/create')?>">
                        <i class="fa fa-plus"></i> Add Recurring Profile</a>
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
                                    <h1 style="float: none"> <?php echo $result->name;?>/# <?php  echo $result->id;?></h1>
                                    <div>
                                        <span class="invoice-client sub-heading sub-heading2">
                                        </span>
                                        <span class="invoice-client sub-heading sub-heading2"><i class="fa fa-building"></i> Main
                                            Branch</span>
                                    </div>
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
						<div class="row">
							<div class="col lg-4">
							<a class="btn btn-secondary">Edit</a>
							<a class="btn btn-secondary">Delete</a>
							<a href="<?php echo base_url('/admin/accounting/recurring/suspend-profile'); ?>"class="btn btn-secondary">Suspended</a>
							</div>

						</div>
					</div>
			</div>
			</div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#details" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Details</span>    
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#activity" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">ACtivity Log</span>    
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#journalentries" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">Journal Entries</span>    
                                </a>
                            </li>
                            
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="journalentries" role="tabpanel">
                                <div class="graytempmain">
                                    <div class="invoice-wrap">
                                        <div class="invoice-inner">
                                            <h2 class=""> Recurring Journal Entry Information</h2>
                                            <table class="f_table">
                                                <tbody>
												<?php 
													$account=getJournalentry($result->entry_id);
													// print_r($account);
													?>
                                                   <tr>
														<th>Name</th>
														<th>First Journal Entry Date</th>
														
												   </tr>
												   <tr>
														<td><?php echo $result->name;?></td>
														<td><?php echo $result->start_date;?></td>
												   </tr>
                                                   <tr class="mt-5">
														<th>Next Journal Entry Date</th>
														<th>Last Journal Entry Date</th>
														
												   </tr>
												   <tr>
														<td><?php echo $result->start_date;?></td>
														<td><?php echo $result->end_date;?></td>
												   </tr>
                                                   <tr class="mt-5">
														<th>Frequency</th>
														<th>Previous Journal Entry</th>
														
												   </tr>
												   <tr>
												   		<td><?php echo $result->frequency;?><?php echo $result->frequency_period;?></td>
												   		<td>JOURNAL ENTRY <?php echo $account->number; ?></td>
												   </tr>
                                                   <tr class="mt-5">
														<th>Profile Main Journal Entry</th>
														<th>Count of Journal Entrys</th>
												   </tr>
												   <tr>
												   <?php 
													$account=getJournalAccount($result->entry_id);
													count($account);
													// print_r($account);
													?>
														<td></td>
														<td><?php echo count($account);?></td>
												   </tr>
                                                </tbody>
                                            </table>
                                           
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="activity" role="tabpanel">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table id="regionTable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                                <div class="timeline timelinemain" >
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
                                                                        <span class="extend id-59062"><i class="fa"></i></span>
                                                                        <div class="timeline-meta row">
                                                                            <div class="col-md-12 text">
                                                                                <p>
                                                                                    <strong>Amanullah Kazi</strong> Added Journal Entry Line
                                                                                    <strong>
                                                                                        <a href="" target="_blank">#4</a>
                                                                                    </strong>
                                                                                    
                                                                                </p>
                                                                                <div class="changes">
                                                                                <div class="change">
                                                                                    <span class="title">Currency Debit:</span>
                                                                                    <div class="d-inline-flex changes-line">
                                                                                        <span class="old"><strike>3676.45 </strike></span> <span class="icon px-2"><i class="fas fa-arrow-right"></i></span> <span
                                                                                            class="new">1000</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="change">
                                                                                    <span class="title">Description:</span>
                                                                                    <div class="d-inline-flex changes-line">
                                                                                        <span class="old"><strike>3676.45 </strike></span> <span class="icon px-2"><i class="fas fa-arrow-right"></i></span> <span class="new">Sana Khan</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="change">
                                                                                    <span class="title">Journal Account:</span>
                                                                                    <div class="d-inline-flex changes-line">
                                                                                        <span class="old"><strike>3676.45 </strike></span> <span class="icon px-2"><i class="fas fa-arrow-right"></i></span> <span class="new">Basic Salaries Expense</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="change">
                                                                                    <span class="title">Debit:</span>
                                                                                    <div class="d-inline-flex changes-line">
                                                                                        <span class="old"><strike>3676.45 </strike></span> <span class="icon px-2"><i class="fas fa-arrow-right"></i></span> <span
                                                                                            class="new">1000</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="timeline-meta timeline-meta-footer d-flex">
                                                                            <div class="meta time">
                                                                                <i class="far mr-2 fa-clock"></i>
                                                                                <span>
                                                                                    08:05:55
                                                                                </span>
                                                                            </div>

                                                                            <div class="meta user tip observed tooltipstered" data-title="172.18.0.5">
                                                                                <i class="fas mr-2 fa-user-circle"></i>
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
                                                                        <span class="extend id-59062"><i class="fa"></i></span>
                                                                        <div class="timeline-meta row">
                                                                            <div class="col-md-12 text">
                                                                                <p>
                                                                                    <strong>Amanullah Kazi</strong> Added Journal Entry Line
                                                                                    <strong>
                                                                                        <a href="" target="_blank">#4</a>
                                                                                    </strong>
                                                                                    
                                                                                </p>
                                                                                <div class="changes">
                                                                                <div class="change">
                                                                                    <span class="title">Currency Debit:</span>
                                                                                    <div class="d-inline-flex changes-line">
                                                                                        <span class="old"><strike>3676.45 </strike></span> <span class="icon px-2"><i class="fas fa-arrow-right"></i></span> <span
                                                                                            class="new">1000</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="change">
                                                                                    <span class="title">Description:</span>
                                                                                    <div class="d-inline-flex changes-line">
                                                                                        <span class="old"><strike>3676.45 </strike></span> <span class="icon px-2"><i class="fas fa-arrow-right"></i></span> <span class="new">Sana Khan</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="change">
                                                                                    <span class="title">Journal Account:</span>
                                                                                    <div class="d-inline-flex changes-line">
                                                                                        <span class="old"><strike>3676.45 </strike></span> <span class="icon px-2"><i class="fas fa-arrow-right"></i></span> <span class="new">Basic Salaries Expense</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="change">
                                                                                    <span class="title">Debit:</span>
                                                                                    <div class="d-inline-flex changes-line">
                                                                                        <span class="old"><strike>3676.45 </strike></span> <span class="icon px-2"><i class="fas fa-arrow-right"></i></span> <span
                                                                                            class="new">1000</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="timeline-meta timeline-meta-footer d-flex">
                                                                            <div class="meta time">
                                                                                <i class="far mr-2 fa-clock"></i>
                                                                                <span>
                                                                                    08:05:55
                                                                                </span>
                                                                            </div>

                                                                            <div class="meta user tip observed tooltipstered" data-title="172.18.0.5">
                                                                                <i class="fas mr-2 fa-user-circle"></i>
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
                                                                        <span class="extend id-59062"><i class="fa"></i></span>
                                                                        <div class="timeline-meta row">
                                                                            <div class="col-md-12 text">
                                                                                <p>
                                                                                    <strong>Amanullah Kazi</strong> Added Journal Entry Line
                                                                                    <strong>
                                                                                        <a href="" target="_blank">#4</a>
                                                                                    </strong>
                                                                                    
                                                                                </p>
                                                                                <div class="changes">
                                                                                <div class="change">
                                                                                    <span class="title">Currency Debit:</span>
                                                                                    <div class="d-inline-flex changes-line">
                                                                                        <span class="old"><strike>3676.45 </strike></span> <span class="icon px-2"><i class="fas fa-arrow-right"></i></span> <span
                                                                                            class="new">1000</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="change">
                                                                                    <span class="title">Description:</span>
                                                                                    <div class="d-inline-flex changes-line">
                                                                                        <span class="old"><strike>3676.45 </strike></span> <span class="icon px-2"><i class="fas fa-arrow-right"></i></span> <span class="new">Sana Khan</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="change">
                                                                                    <span class="title">Journal Account:</span>
                                                                                    <div class="d-inline-flex changes-line">
                                                                                        <span class="old"><strike>3676.45 </strike></span> <span class="icon px-2"><i class="fas fa-arrow-right"></i></span> <span class="new">Basic Salaries Expense</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="change">
                                                                                    <span class="title">Debit:</span>
                                                                                    <div class="d-inline-flex changes-line">
                                                                                        <span class="old"><strike>3676.45 </strike></span> <span class="icon px-2"><i class="fas fa-arrow-right"></i></span> <span
                                                                                            class="new">1000</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="timeline-meta timeline-meta-footer d-flex">
                                                                            <div class="meta time">
                                                                                <i class="far mr-2 fa-clock"></i>
                                                                                <span>
                                                                                    08:05:55
                                                                                </span>
                                                                            </div>

                                                                            <div class="meta user tip observed tooltipstered" data-title="172.18.0.5">
                                                                                <i class="fas mr-2 fa-user-circle"></i>
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
                                                                        <span class="extend id-59062"><i class="fa"></i></span>
                                                                        <div class="timeline-meta row">
                                                                            <div class="col-md-12 text">
                                                                                <p>
                                                                                    <strong>Amanullah Kazi</strong> Added Journal Entry Line
                                                                                    <strong>
                                                                                        <a href="" target="_blank">#4</a>
                                                                                    </strong>
                                                                                    
                                                                                </p>
                                                                                <div class="changes">
                                                                                <div class="change">
                                                                                    <span class="title">Currency Debit:</span>
                                                                                    <div class="d-inline-flex changes-line">
                                                                                        <span class="old"><strike>3676.45 </strike></span> <span class="icon px-2"><i class="fas fa-arrow-right"></i></span> <span
                                                                                            class="new">1000</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="change">
                                                                                    <span class="title">Description:</span>
                                                                                    <div class="d-inline-flex changes-line">
                                                                                        <span class="old"><strike>3676.45 </strike></span> <span class="icon px-2"><i class="fas fa-arrow-right"></i></span> <span class="new">Sana Khan</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="change">
                                                                                    <span class="title">Journal Account:</span>
                                                                                    <div class="d-inline-flex changes-line">
                                                                                        <span class="old"><strike>3676.45 </strike></span> <span class="icon px-2"><i class="fas fa-arrow-right"></i></span> <span class="new">Basic Salaries Expense</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="change">
                                                                                    <span class="title">Debit:</span>
                                                                                    <div class="d-inline-flex changes-line">
                                                                                        <span class="old"><strike>3676.45 </strike></span> <span class="icon px-2"><i class="fas fa-arrow-right"></i></span> <span
                                                                                            class="new">1000</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="timeline-meta timeline-meta-footer d-flex">
                                                                            <div class="meta time">
                                                                                <i class="far mr-2 fa-clock"></i>
                                                                                <span>
                                                                                    08:05:55
                                                                                </span>
                                                                            </div>

                                                                            <div class="meta user tip observed tooltipstered" data-title="172.18.0.5">
                                                                                <i class="fas mr-2 fa-user-circle"></i>
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
                                                                        <span class="extend id-59062"><i class="fa"></i></span>
                                                                        <div class="timeline-meta row">
                                                                            <div class="col-md-12 text">
                                                                                <p>
                                                                                    <strong>Amanullah Kazi</strong> Added Journal Entry Line
                                                                                    <strong>
                                                                                        <a href="" target="_blank">#4</a>
                                                                                    </strong>
                                                                                    
                                                                                </p>
                                                                                <div class="changes">
                                                                                <div class="change">
                                                                                    <span class="title">Currency Debit:</span>
                                                                                    <div class="d-inline-flex changes-line">
                                                                                        <span class="old"><strike>3676.45 </strike></span> <span class="icon px-2"><i class="fas fa-arrow-right"></i></span> <span
                                                                                            class="new">1000</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="change">
                                                                                    <span class="title">Description:</span>
                                                                                    <div class="d-inline-flex changes-line">
                                                                                        <span class="old"><strike>3676.45 </strike></span> <span class="icon px-2"><i class="fas fa-arrow-right"></i></span> <span class="new">Sana Khan</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="change">
                                                                                    <span class="title">Journal Account:</span>
                                                                                    <div class="d-inline-flex changes-line">
                                                                                        <span class="old"><strike>3676.45 </strike></span> <span class="icon px-2"><i class="fas fa-arrow-right"></i></span> <span class="new">Basic Salaries Expense</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="change">
                                                                                    <span class="title">Debit:</span>
                                                                                    <div class="d-inline-flex changes-line">
                                                                                        <span class="old"><strike>3676.45 </strike></span> <span class="icon px-2"><i class="fas fa-arrow-right"></i></span> <span
                                                                                            class="new">1000</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="timeline-meta timeline-meta-footer d-flex">
                                                                            <div class="meta time">
                                                                                <i class="far mr-2 fa-clock"></i>
                                                                                <span>
                                                                                    08:05:55
                                                                                </span>
                                                                            </div>

                                                                            <div class="meta user tip observed tooltipstered" data-title="172.18.0.5">
                                                                                <i class="fas mr-2 fa-user-circle"></i>
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
                                                        <a class="no-print" target="_blank" style="text-decoration: underline; color: #0b56eb"
                                                            href="#"> Operations </a>
                                                        <a target="_parent" href="#" class="no-print btn btn-xs pull-right">
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
                                                        <a class="no-print" target="_blank" style="text-decoration: underline; color: #0b56eb"
                                                            href="#"> Operations </a>
                                                        <a target="_parent" href="" class="no-print btn btn-xs pull-right">
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
                                                        <a class="no-print" target="_blank" style="text-decoration: underline; color: #0b56eb"
                                                            href="#"> Operations </a>
                                                        <a target="_parent" href="#" class="no-print btn btn-xs pull-right">
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
                                                        <a class="no-print" target="_blank" style="text-decoration: underline; color: #0b56eb"
                                                            href="#">
                                                            Operations </a>
                                                        <a target="_parent" href="#" class="no-print btn btn-xs pull-right">
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
    $('#regionTable').dataTable({
    "lengthMenu": [
    [25, 50, 100, 500],
    [25, 50, 100, 500]
    ],
    order: [
    [0, 'asc']
    ],
    "responsive": true,
    fixedHeader: true,
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
