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
						<li class="breadcrumb-item active">Office Edit</li>
					</ol>
				</div>
			</div>
            <div class="col-sm-6">
				<div class="float-end d-sm-block">
                    <a class="btn btn-sm btn-custom-danger pull-right" title="Back" href="<?php echo base_url(); ?>admin/accounting/costcenters/costcenterview"><i class="mdi mdi-close"></i> Cancel</a>
				    <button class="btn btn-sm btn-custom-success pull-right me-1" href=""><i class="mdi mdi-content-save"></i> Save</button>
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
						<h4 class="header-title mb-0">Head Offie Edit</h4>
					</div>
					<div class="card-body">
                    <form class="needs-validation" novalidate="">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="validationCustom03" class="form-label">Name</label>
                                    <input type="text" value="Head Office" class="form-control" id="validationTooltip02"  required="">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="validationCustom03" class="form-label">Code</label>
                                    <input type="text" class="form-control" id="validationTooltip02" value="132" required="">
                                </div>
                            </div>
                            <div class="col-md-12">
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
                        </form>
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