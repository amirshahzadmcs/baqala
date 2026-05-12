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
					<h4>Manage Cost Center</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/accounting/costcenters/list">Cost Center</a></li>
						<li class="breadcrumb-item active">Manage Cost Center</li>
					</ol>
				</div>
			</div>
            <div class="col-md-6">
             
            <div class="d-sm-block cost_mainin float-end">
            <a class="btn btn-custom-danger btn-sm pull-right me-1" title="Add Cost Center"><i class="fas fa-trash-alt"></i></a>
            &nbsp; 
                    <span class="dropdown">
                        <a target="_blank" href="javascript:;" class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-chart-pie"></i> <i class="fas fa-caret-down"></i></a>
                         <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?php echo base_url('admin/accounting/costcenters/costcenterreport'); ?>">Cost Centers Report</a></li>
                            <li><a class="dropdown-item" href="<?php echo base_url('admin/accounting/costcenters/accountwithoutcostcenter'); ?>">Accounts without Cost Center</a></li>
                            <li><a class="dropdown-item" href="<?php echo base_url('admin/accounting/costcenters/accountwithcostcenter'); ?>">Accounts with Cost Center</a></li>
                        </ul>
                    </span>
                    &nbsp;
                    <a href="<?php echo base_url('admin/accounting/costcenters/addcostcenter'); ?>" class="btn btn-custom-success btn-sm pull-right me-1" title="Add Cost Center"><i class="fa fa-plus"></i> Add Cost Center</a>
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
                <div class="card-body">
                
                           
                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>
                                <div class="form-check form-check-right">
                                    <input class="form-check-input" type="checkbox" id="selectall">
                                </div>
                            </th>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Is Primary Cost Center?</th>
                            <th>Actions</th>
                        </tr>
                        </thead>


                        <tbody>
                        <tr>
                            <td>
                                <div class="form-check form-check-right mb-3">
                                    <input name="sample[]" class="form-check-input allcheck" type="checkbox" id="formCheckRight1">
                                </div>
                            </td>
                            <td>1</td>
                            <td>Head Office</td>
                            <td>1</td>
                            <td>Yes</td>
                            <td class="float-end">
                            <span class="dtr-data">
                                <a class="btn btn-outline-secondary btn-sm edit" title="Edit" href="<?php echo base_url('admin/accounting/costcenters/alltransaction'); ?>">Transactions</a> 
                                <a class="btn btn-outline-secondary btn-sm edit" title="Edit" href="<?php echo base_url('admin/accounting/costcenters/costcenterview'); ?>">Accounts</a> 
                                    <a class="btn btn-outline-secondary btn-sm edit" title="Edit" href="<?php echo base_url('admin/accounting/costcenters/editcostcenter'); ?>"><i class="mdi mdi-pencil"></i></a> 
                                    <a class="btn btn-outline-secondary btn-sm edit" title="Delete" href="javascript:;"><i class="fas fa-trash-alt"></i></a>
                            </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-check form-check-right mb-3">
                                    <input name="sample[]" class="form-check-input allcheck" type="checkbox" id="formCheckRight1">
                                </div>
                            </td>
                            <td>1</td>
                            <td>Head Office</td>
                            <td>1</td>
                            <td>Yes</td>
                            <td class="float-end">
                            <span class="dtr-data">
                                <a class="btn btn-outline-secondary btn-sm edit" title="Edit" href="<?php echo base_url('admin/accounting/costcenters/alltransaction'); ?>">Transactions</a> 
                                <a class="btn btn-outline-secondary btn-sm edit" title="Edit" href="<?php echo base_url('admin/accounting/costcenters/costcenterview'); ?>">Accounts</a> 
                                    <a class="btn btn-outline-secondary btn-sm edit" title="Edit" href="<?php echo base_url('admin/accounting/costcenters/editcostcenter'); ?>"><i class="mdi mdi-pencil"></i></a> 
                                    <a class="btn btn-outline-secondary btn-sm edit" title="Delete" href="javascript:;"><i class="fas fa-trash-alt"></i></a>
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

