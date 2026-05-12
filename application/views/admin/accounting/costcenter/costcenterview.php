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
						<li class="breadcrumb-item active">View</li>
					</ol>
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
                    <div class="btn-group btn-group-md">
                            <a href="<?php echo base_url(); ?>admin/accounting/costcenters/headofficeedit" class="btn btn-custom-white"><i class="fas fa-pencil-alt"></i> Edit</a>
                            <a href="<?php echo base_url(); ?>admin/accounting/costcenters/costcenterview" class="btn btn-custom-white"><i class="fas fa-trash-alt"></i> Delete</a>
                            <a href="<?php echo base_url(); ?>admin/accounting/costcenters/costcentertransactions" class="btn btn-custom-white"><i class="mdi mdi-chart-bar"></i> View Report</a>
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
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content information_maincost p-3 text-muted">
                            <div class="tab-pane active" id="details" role="tabpanel">
                                <div class="input-fields">
                                    <h3 class="head-bar theme-color-a">
                                        <span class="details-info">
                                            Information </span>
                                    </h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="view-table">
                                                <tbody>
                                                    <tr>
                                                        <td width="160">
                                                            <strong>Name:</strong>
                                                        </td>
                                                        <td>Management</td>
                                                    </tr>

                                                    <tr>
                                                        <td width="160">
                                                            <strong>Is Parent Cost Center:</strong>
                                                        </td>
                                                        <td>No</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="view-table">

                                                <tbody>
                                                    <tr>
                                                        <td width="160">
                                                            <strong>Parent Cost Center:</strong>
                                                        </td>
                                                        <td>
                                                            Head Office 
                                                            <a style="text-decoration: underline;" href="<?php echo base_url(); ?>admin/accounting/costcenters/costcenterview"><u>#1</u></a>
                                                        </td>
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