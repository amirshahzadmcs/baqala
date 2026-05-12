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
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/accounting/costcenters/list">Cost Center</a></li>
						<li class="breadcrumb-item active">All Transaction</li>
					</ol>
				</div>
			</div>
            <div class="col-md-6 ">
                <div class="d-sm-block cost_mainin float-end">
                    <span class="dropdown">
                        <a target="_blank" href="javascript:;" class="btn btn-sm btn-custom-success dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-plus"></i> Manage <i class="fas fa-caret-down"></i></a>
                         <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?php echo base_url('admin/accounting/costcenters/managecostcenters'); ?>">Manage Cost Centers</a></li>
                            <li><a class="dropdown-item" href="<?php echo base_url('admin/accounting/costcenters/costcenterreport'); ?>">Cost Centers Report</a></li>
                            <li><a class="dropdown-item" href="<?php echo base_url('admin/accounting/costcenters/accountwithoutcostcenter'); ?>">Accounts without Cost Center</a></li>
                            <li><a class="dropdown-item" href="<?php echo base_url('admin/accounting/costcenters/accountwithcostcenter'); ?>">Accounts with Cost Center</a></li>
                        </ul>
                    </span>
                    <!-- <a class="btn btn-custom-success btn-sm pull-right me-1" title="Export"><i class="fa fa-plus"></i> Manage <i class="fas fa-caret-down"></i></a> -->
                </div>
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
                    <form class="needs-validation" novalidate="">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Account</label>
                                    <select class="select2 form-control "
                                     data-placeholder="Nothing Select">
                                     <option value="1">Any Account</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Cost Center</label>
                                    <select class="select2 form-control " data-placeholder="Nothing Select">
                                     <option value="1">Any Cost Center</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Date Range</label>
                                    <div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#datepicker6">
                                        <input type="text" class="form-control" name="start" placeholder="Start Date">
                                        <input type="text" class="form-control" name="end" placeholder="End Date">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3 float-end">
                                    <!-- <label class="form-label">&nbsp;</label> -->
                                    <button type="reset" class="btn btn-secondary ml-0 btn-md">Reset</button>
                                    <button type="submit" class="btn btn-success ml-0 btn-md">Search</button>
                                </div>
                            </div>
                        </div> 
                        
                        </form>
					</div>
				</div>
			</div>
          
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                           
                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>Transaction</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th class="float-end"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <div class="invoice-row entry-info">
                                    <div class="project-client">
                                        <span class="project">
                                            <span class="expense-date"><h5> 07/09/2023  (#99)</h5></span>
                                        </span>
                                     </div>
                                <div> 
                                <span> Sales - DMHI - <a style="color: #2712D3; text-decoration: underline;" href="<?php echo base_url('/admin/accounting/journal/journaldetails'); ?>"><u>Journal #JRN000076</u></a></span>
                                    </div>
                                </div>
                            </td>
                            <td><h4>240.00</h4></td>
                            <td></td>
                            <td class="float-end">
                            <span class="dtr-data">
                                <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="<?php echo base_url('admin/accounting/costcenters/alltransactionedit'); ?>"><i class="mdi mdi-pencil"></i></a> 
                                <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Delete" href="<?php echo base_url('admin/accounting/costcenters/alltransaction'); ?>"><i class="fas fa-trash-alt"></i></a>
                            </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="invoice-row entry-info">
                                    <div class="project-client">
                                        <span class="project">
                                            <span class="expense-date"><h5> 07/09/2023  (#98)</h5></span>
                                        </span>
                                     </div>
                                <div> 
                                <span> Sales - POS Client - <a style="color: #2712D3; text-decoration: underline;" href="<?php echo base_url('/admin/accounting/journal/journaldetails'); ?>"><u>Journal #JRN000075</u></a></span>
                                </div>
                            </div>
                            </td>
                            <td><h4>1,558.34</h4></td>
                            <td></td>
                            <td class="float-end">
                                <span class="dtr-data">
                                    <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="<?php echo base_url('admin/accounting/costcenters/alltransactionedit'); ?>"><i class="mdi mdi-pencil"></i></a> 
                                    <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Delete" href="<?php echo base_url('admin/accounting/costcenters/alltransaction'); ?>"><i class="fas fa-trash-alt"></i></a>
                                </span>
                            </td>
                        </tr>
                       
                        </tbody>

                        
                    </table>
                    
                </div>
            </div>
        </div>
	</div>
</div>

<!-- container-fluid -->
<?php $this->load->view('admin/home/footer');?>
<script>
    $(document).ready(function() {
    $('#activelog').dataTable({
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

<script>
    $('#selectall').click(function() { 
        $('.allcheck').filter(':checkbox').prop('checked', this.checked);
});
</script>

