<?php $this->load->view('admin/home/header');?>

<style>
	.required-field{
		color: #f00;
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
    .cost_mainin a.dropdown-item {
    color: #3a3e63;
    padding: 3px 12px;
    transition: all .2s ease-in-out;
    border-bottom: 1px solid rgba(0,0,0,.04);
    min-height: 40px;
    line-height: 40px;
}
.cost_mainin a.dropdown-item:hover {
    background: #f1f1f1;
}
</style>
<div id="wait"><img src="<?= base_url('images/sample-loader.gif');?>" /><br>Loading..</div>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Cost Center</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/accounting/chartaccounts/list">Cost Center</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end cost_mainin d-sm-block">
                    <span class="dropdown">
                        <a target="_blank" href="javascript:;" class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-chart-pie"></i> <i class="fas fa-caret-down"></i></a>
                         <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?php echo base_url('admin/accounting/costcenters/costcenterreport'); ?>">Cost Center Report</a></li>
                            <li><a class="dropdown-item" href="<?php echo base_url('admin/accounting/costcenters/accountwithoutcostcenter'); ?>">Accounts without Cost Center</a></li>
                            <li><a class="dropdown-item" href="<?php echo base_url('admin/accounting/costcenters/accountwithcostcenter'); ?>">Accounts with Cost Center</a></li>
                            <li><a class="dropdown-item" href="<?php echo base_url('admin/accounting/costcenters/alltransaction'); ?>">All transactions</a></li>
                        </ul>
                    </span>
					&nbsp;
					<a class="btn btn-custom-success btn-sm pull-right me-1" title="Own Store" data-bs-toggle="modal" data-bs-target="#addcostcenterheadmodel" >
                        <i class="fa fa-plus"></i> Add Cost Center</a>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end page title -->
    

<div class="container-fluid">
	<div class="page-content-wrapper">
    <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title head__titlehide mb-4">Cost Center List</h4>
                        <div class="header__pages headershow" style="z-index: 1; top: 45px;">
                            <div class="container-fluid">
                                <div class="row align-items-center">
                                    <div class="col-sm-8">
                                        <div class="row align-items-center">
                                            <div class="col-sm-12 head-info">
                                                <div class="pages-head-title">
                                                    <h2 class="d-flex align-items-center">Assets <span class="fs-14">#1</span>
                                                    <div class="dropdown">
                                                    <button type="button" class="btn dropdown-toggle"  data-bs-toggle="dropdown">
                                                        <i class="fas fa-cog fs-12"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a target="_blank" class="dropdown-item" href="<?php echo base_url('admin/accounting/costcenters/costcenterview'); ?>"><i class="fas fa-eye text-success"></i> View</a></li>
                                                        <li><a data-bs-toggle="modal" data-bs-target="#editassetsmodel" class="dropdown-item" href="javascript:;"><i class="mdi text-info mdi-pencil-box-outline"></i> Edit</a></li>
                                                        
                                                    </ul>
                                                    </div>
                                                    </h2>
                                                    <div class="route-links"><span>Assets<span
                                                                class="tip-circle lazy-tip tooltipstered non observed"
                                                                data-title="assets-cat"><i class="fas fa-question-circle" style="margin-left:5px;"></i></span></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 text_rightcol">
                                        <div class="action-buttons d-inline-block">
                                            <div class="btn-group ml-3" role="group" aria-label="padination">
                                                <a target="_blank" href="<?php echo base_url('admin/accounting/chartaccounts/chart-transactions') ?>" class="btn btn-secondary"><i class="fas fa-chart-pie"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="header__pages headerinnershow" style="z-index: 1; top: 45px;">
                            <div class="container-fluid">
                                <div class="row align-items-center">
                                    <div class="col-sm-8">
                                        <div class="row align-items-center">
                                            <div class="col-sm-12 head-info">
                                                <div class="pages-head-title">
                                                    <h2 class="d-flex align-items-center">Assets <span class="fs-14">#1</span>
                                                    <div class="dropdown">
                                                    <button type="button" class="btn dropdown-toggle"  data-bs-toggle="dropdown">
                                                        <i class="fas fa-cog fs-12"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a target="_blank" class="dropdown-item" href="#"><i class="fas fa-eye text-success"></i> View</a></li>
                                                        <li><a data-bs-toggle="modal" data-bs-target="#editheadermodel" class="dropdown-item" href="javascript:;"><i class="mdi text-info mdi-pencil-box-outline"></i> Edit</a></li>
                                                        <li><a target="_blank" class="dropdown-item" href="#"><i class="mdi text-danger mdi-trash-can-outline"></i> Delete</a></li>
                                                    </ul>
                                                    </div>
                                                    </h2>
                                                    <div class="route-links"><span>Assets<span
                                                                class="tip-circle lazy-tip tooltipstered non observed"
                                                                data-title="assets-cat"><i class="fas fa-question-circle"></i></span></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 text_rightcol">
                                        <div class="credit-wrap text-right d-inline-block align-middle">
                                            <div class="credit-container px-2 credit-overdue" style="border-color: rgb(14, 132, 84);">
                                                <p class="cost">SAR&nbsp;183,829.58</p>
                                                <p class="type">Debit</p>
                                            </div>
                                        </div>
                                        <div class="action-buttons d-inline-block">
                                            <div class="btn-group ml-3" role="group" aria-label="padination"><a target="_blank"
                                                    href="" class="btn btn-secondary"><i class="fas fa-chart-pie"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="chart__of__accounts__container">
                            <div class="row chart-of-accounts-row">
                            <div class="chart-of-accounts-col col-md-3 chart-of-accounts-col-3">
                                <div class="chart-account-search">
                                <div class="col-lg-12">
                                        <div class="mb-0">
                                            <select class="form-control select2-search-disable">
                                                <option>Search</option>
                                                <optgroup>
                                                    <option value="CA">No Result</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="chart-of-accounts-col-3-body-container">
                                 
                                    <ul class="treeRoot">
                                        <li class="hasSubMenu first_border"><span><i class="fas fa-folder"></i><a href="<?php echo base_url('admin/accounting/costcenters/list'); ?>"> Head Office</a></span>
                                            <ul class="activeSubMenu">
                                                <li class="hasSubMenu header__inner__hide">
                                                <span><i class="fas fa-file"></i><a href="<?php echo base_url('admin/accounting/costcenters/list'); ?>"> Management</a></span>
                                                </li>
                                                <li class="hasSubMenu header__inner__hide">
                                                <span><i class="fas fa-file"></i><a href="<?php echo base_url('admin/accounting/costcenters/list'); ?>"> Finance & Accounts</a></span>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="hasSubMenu first_border"><span><i class="fas fa-folder"></i> <a href="<?php echo base_url('admin/accounting/chartaccounts/list'); ?>">Logistics - Third Party Delivery</a></span>
                                            <ul class="activeSubMenu">
                                                <li class="hasSubMenu header__inner__hide">
                                                <span><i class="fas fa-file"></i><a href="<?php echo base_url('admin/accounting/costcenters/list'); ?>"> Jahez</a></span>
                                                </li>
                                                <li class="hasSubMenu header__inner__hide">
                                                <span><i class="fas fa-file"></i><a href="<?php echo base_url('admin/accounting/costcenters/list'); ?>"> Chefz</a></span>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="hasSubMenu first_border"><span><i class="fas fa-folder"></i><a href="<?php echo base_url('admin/accounting/chartaccounts/list'); ?>"> E-Commerce</a></span>
                                            <ul class="activeSubMenu">
                                                <li class="hasSubMenu header__inner__hide">
                                                <span><i class="fas fa-file"></i><a href="<?php echo base_url('admin/accounting/costcenters/list'); ?>"> E-Commerce </a></span>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="hasSubMenu first_border"><span><i class="fas fa-folder"></i><a href="<?php echo base_url('admin/accounting/chartaccounts/list'); ?>"> Sales & Operations</a></span>
                                            <ul class="activeSubMenu">
                                                <li class="hasSubMenu header__inner__hide">
                                                <span><i class="fas fa-file"></i><a href="<?php echo base_url('admin/accounting/costcenters/list'); ?>"> Operations</a></span>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="chart-of-accounts-col col-md-9 chart-of-accounts-col-9">
                                <div class="chart-of-accounts-col-9-filters-container">
                                    
                                    <!-- <div class="row mb-3">
                                        <div class="col-sm-5"></div>
                                            <label for="example-text-input" class="col-sm-3 text-right col-form-label">Journals Branch</label>
                                            <div class="col-sm-4">
                                                <select class="form-select" aria-label="Default select example">
                                                    <option >All Branches</option>
                                                    <option >Main Branch</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                    </div> -->
                                <div id="chart-of-accounts-child-board" class="chart-of-accounts-col-9-body-container">
                                    <div style="position: relative;">
                                        <table
                                            class="list-table table table-hover not-clickable chart-of-accounts-col-9-body-container-table">
                                            <tbody>
                                                <tr class="chart-of-accounts-col-9-body-container-table-row">
                                                    <td class="border-0"><a href="<?php echo base_url('admin/accounting/costcenters/list'); ?>">
                                                            <div class="chart-of-accounts-col-9-body-container-table-item">
                                                                <div class="item-container d-flex">
                                                                <i class="fas fa-file"></i>
                                                                    <div class="details">
                                                                        <p class="name">Management</p>
                                                                        <p class="id">#1</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a></td>
                                                    
                                                    <td class="border-0 text-right" width="50">
                                                    
                                                    <div class="dropdown"><a class="btn btn-sm btn-secondary dropdown-toggle" href="<?php echo base_url('admin/accounting/costcenters/list'); ?>"
                                                            role="button" data-bs-toggle="dropdown" ><i class="mdi mdi-dots-horizontal"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#editfoldermodel" class="edit-action dropdown-item">
                                                            <i class="mdi mdi-open-in-new text-info"></i> Open</a>
                                                                <a href="<?php echo base_url('admin/accounting/costcenters/costcenterview'); ?>" class="edit-action dropdown-item">
                                                                <i class="far fa-eye text-success"></i> View</a>
                                                                <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#editcostcentermodel" class="edit-action dropdown-item">
                                                                <i class="far fa-edit text-info mr-2"></i> Edit</a>
                                                                <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#editfoldermodel" class="edit-action dropdown-item">
                                                                <i class="fas fa-trash-alt text-danger"></i> Delete</a>

                                                            </div>
                                                    </div>
                                                    </td>
                                                </tr>
                                                <tr class="chart-of-accounts-col-9-body-container-table-row">
                                                    <td class="border-0"><a href="<?php echo base_url('admin/accounting/costcenters/list'); ?>">
                                                            <div class="chart-of-accounts-col-9-body-container-table-item">
                                                                <div class="item-container d-flex">
                                                                <i class="fas fa-file"></i>
                                                                    <div class="details">
                                                                        <p class="name">Finance & Accounts</p>
                                                                        <p class="id">#1</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a></td>
                                                    
                                                    <td class="border-0 text-right" width="50">
                                                    
                                                    <div class="dropdown"><a class="btn btn-sm btn-secondary dropdown-toggle" href="<?php echo base_url('admin/accounting/costcenters/list'); ?>"
                                                            role="button" data-bs-toggle="dropdown" ><i class="mdi mdi-dots-horizontal"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                        <a href="<?php echo base_url('admin/accounting/costcenters/costcenterview'); ?>" class="edit-action dropdown-item">
                                                                <i class="far fa-eye text-success"></i> View</a>
                                                                <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#editcostcentermodel" class="edit-action dropdown-item">
                                                                <i class="far fa-edit text-info mr-2"></i> Edit</a>
                                                                <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#editfoldermodel" class="edit-action dropdown-item">
                                                                <i class="fas fa-trash-alt text-danger"></i> Delete</a>
                                                            </div>
                                                    </div>
                                                    </td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#addcostcentermodel" class="add-account  font-weight-bold">
                                        <i class="fas fa-plus-circle"></i><span>Add Cost Center</span>
                                    </a>
                                    <div class="pagination-items"></div>
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
<!-- container-fluid -->

<!-- Model add -->
<div class="modal" id="addcostcentermodel">
    <div class="modal-dialog  modal-lg modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Add Cost Center</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form class="needs-validation" novalidate="">

                <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="validationCustom03" class="form-label">Name</label>
                                <input type="text" class="form-control" id="validationTooltip02"  required="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="validationCustom03" class="form-label">Code</label>
                                <input type="text" class="form-control" id="validationTooltip02" value="132" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Parent Cost Center</label>
                                <select class="form-select" id="validationCustom03" required="">
                                    <option value="">Please Select Cost Center</option>
                                    <option value="Head Office">Head Office</option>
                                    <option value="Logistics - Third Party Delivery">Logistics - Third Party Delivery</option>
                                    <option value="E-Commerce">E-Commerce</option>
                                    <option value="Sales & Operations">Sales & Operations</option>
                                </select>
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label></label>
                            <div class="">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="formCheck2">
                                    <label class="form-check-label" for="formCheck2">
                                    Is Parent Cost Center?
                                    </label>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    

                    
                        
                        

                    <div class="row">
                        <div class="col-md-9"></div>
                        <div class="col-md-3">
                            <div class="mb-3 pull-right">
                            <button type="submit" class="btn btn-success mt-2 form-control">Submit</button>
                            </div>
                        </div>
                        
                    </div>
                    
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Edit form -->
<div class="modal" id="editcostcentermodel">
    <div class="modal-dialog  modal-lg modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Edit Cost Center</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form class="needs-validation" novalidate="">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="validationCustom03" class="form-label">Name</label>
                                <input type="text" class="form-control" id="validationTooltip02"  required="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="validationCustom03" class="form-label">Code</label>
                                <input type="text" class="form-control" id="validationTooltip02" value="132" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Parent Cost Center</label>
                                <select class="form-select" id="validationCustom03" required="">
                                    <option value="">Please Select Cost Center</option>
                                    <option value="Head Office">Head Office</option>
                                    <option value="Logistics - Third Party Delivery">Logistics - Third Party Delivery</option>
                                    <option value="E-Commerce">E-Commerce</option>
                                    <option value="Sales & Operations">Sales & Operations</option>
                                </select>
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label></label>
                            <div class="">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="formCheck2">
                                    <label class="form-check-label" for="formCheck2">
                                    Is Parent Cost Center?
                                    </label>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-9"></div>
                        <div class="col-md-3">
                            <div class="mb-3 pull-right">
                            <button type="submit" class="btn btn-success mt-2 form-control">Update</button>
                            </div>
                        </div>
                        
                    </div>
                    
                </form>
            </div>

        </div>
    </div>
</div>


<div class="modal" id="addcostcenterheadmodel">
    <div class="modal-dialog  modal-xl modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Add Cost Center</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form class="needs-validation" novalidate="">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="validationCustom03" class="form-label">Name</label>
                                <input type="text" class="form-control" id="validationTooltip02"  required="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="validationCustom03" class="form-label">Code</label>
                                <input type="text" class="form-control" id="validationTooltip02" value="132" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Parent Cost Center</label>
                                <select class="form-select" id="validationCustom03" required="">
                                    <option value="">Please Select Cost Center</option>
                                    <option value="Head Office">Head Office</option>
                                    <option value="Logistics - Third Party Delivery">Logistics - Third Party Delivery</option>
                                    <option value="E-Commerce">E-Commerce</option>
                                    <option value="Sales & Operations">Sales & Operations</option>
                                </select>
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label></label>
                            <div class="">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="formCheck2">
                                    <label class="form-check-label" for="formCheck2">
                                    Is Parent Cost Center?
                                    </label>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-9"></div>
                        <div class="col-md-3">
                            <div class="mb-3 pull-right">
                            <button type="submit" class="btn btn-success mt-2 form-control">Save</button>
                            </div>
                        </div>
                        
                    </div>
                    
                </form>
            </div>

        </div>
    </div>
</div>






<div class="modal" id="editassetsmodel">
    <div class="modal-dialog  modal-lg modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Edit Cost Center</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form class="needs-validation" novalidate="">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="validationCustom03" class="form-label">Name</label>
                                <input type="text" class="form-control" value="Head Office" id="validationTooltip02"  required="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="validationCustom03" class="form-label">Code</label>
                                <input type="text" class="form-control" id="validationTooltip02" value="1" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Parent Cost Center</label>
                                <select class="form-select" id="validationCustom03" required="">
                                    <option value="">Please Select Cost Center</option>
                                    <option value="Head Office">Head Office</option>
                                    <option value="Logistics - Third Party Delivery">Logistics - Third Party Delivery</option>
                                    <option value="E-Commerce">E-Commerce</option>
                                    <option value="Sales & Operations">Sales & Operations</option>
                                </select>
                                
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-9"></div>
                        <div class="col-md-3">
                            <div class="mb-3 pull-right">
                            <button type="submit" class="btn btn-success mt-2 form-control">Update</button>
                            </div>
                        </div>
                        
                    </div>
                    
                </form>
            </div>

        </div>
    </div>
</div>

<!-- edit header form -->
<div class="modal" id="editheadermodel">
    <div class="modal-dialog  modal-lg modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Edit Account</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form class="needs-validation" novalidate="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="validationCustom03" class="form-label">Code</label>
                                <input type="text" name="code" class="form-control" id="validationTooltip02" value="132" required="">
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="validationCustom03" class="form-label">Name</label>
                                <input type="text" value="adf" name="name" placeholder="Name" class="form-control" id="validationTooltip02"  required="">
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="row">
                        <label> Type</label>
                        <div class="col-md-4">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="formRadios" id="formRadios1">
                                <label class="form-check-label" for="formRadios1">
                                    Credit
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="formRadios" id="formRadios2">
                                <label class="form-check-label" for="formRadios2">
                                    Debit 
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-9"></div>
                        <div class="col-md-3">
                            <div class="mb-3 pull-right">
                            <button type="submit" class="btn btn-success mt-2 form-control">Update</button>
                            </div>
                        </div>
                        
                    </div>
                    
                </form>
            </div>

        </div>
    </div>
</div>

<!-- edit header form inner -->
<div class="modal" id="editheaderinnermodel">
    <div class="modal-dialog  modal-lg modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Edit Account</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form class="needs-validation" novalidate="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="validationCustom03" class="form-label">Code</label>
                                <input type="text" name="code" class="form-control" id="validationTooltip02" value="132" required="">
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="validationCustom03" class="form-label">Name</label>
                                <input type="text" value="adf" name="name" placeholder="Name" class="form-control" id="validationTooltip02"  required="">
                            </div>
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                        <div class="mb-3">
                                <label class="form-label">Main Account</label>
                                <select class="form-control select2">
                                    <option>Select</option>
                                    <optgroup label="Alaskan/Hawaiian Time Zone">
                                        <option value="AK">Alaska</option>
                                        <option value="HI">Hawaii</option>
                                    </optgroup>
                                    <optgroup label="Pacific Time Zone">
                                        <option value="CA">California</option>
                                        <option value="NV">Nevada</option>
                                        <option value="OR">Oregon</option>
                                        <option value="WA">Washington</option>
                                    </optgroup>
                                </select>

                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="row">
                        <label> Type</label>
                        <div class="col-md-4">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="formRadios" id="formRadios1">
                                <label class="form-check-label" for="formRadios1">
                                    Credit
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="formRadios" id="formRadios2">
                                <label class="form-check-label" for="formRadios2">
                                    Debit 
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-9"></div>
                        <div class="col-md-3">
                            <div class="mb-3 pull-right">
                            <button type="submit" class="btn btn-success mt-2 form-control">Update</button>
                            </div>
                        </div>
                        
                    </div>
                    
                </form>
            </div>

        </div>
    </div>
</div>
<?php $this->load->view('admin/home/footer');?>
<script>
    $("ul.treeRoot li span").on("click",function(){
if($(this).parent().hasClass("hasSubMenu")){
   if($(this).parent().find("ul").hasClass("activeSubMenu")){
  		$(this).parent().find("ul").removeClass("activeSubMenu");
   }else{    	 $(this).parent().find("ul").addClass("activeSubMenu");	
  }
}	
});
</script>
<script>
$(document).ready(function(){
  $(".first_border").click(function(){
    $(".headershow").show();
  });
  $(".first_border").click(function(){
    $(".head__titlehide").hide();
  });

//   $(".header__inner__hide").click(function(){
//     $(".headerinnershow").show();
//   });
//   $(".header__inner__hide").click(function(){
//     $(".headershow").hide();
//   });
//   $(".first_border").click(function(){
//     $(".headerinnershow").hide();
//   });
});
</script>
<script>
$(document).ready(function() {
	$('#store-table').dataTable({
		"lengthMenu": [[25, 50, 100, 500], [25, 50, 100, 500]],
		//order: [[0, 'asc']],
		dom: 'Blfrtip',
		buttons: [
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
		"processing":true,
		"serverSide":true,
		"fixedHeader": true,
		
		"columnDefs":[
			{
			 "targets":[0,1,2,3,4,5,6,],
			 "orderable":false
			},
		],
	});
});
$.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) { 
console.log(message);
};



</script>
<!-- Chart of Accounts -->
