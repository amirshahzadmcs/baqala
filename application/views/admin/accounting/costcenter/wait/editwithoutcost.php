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
					<h4>Edit Without Cost Center</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/accounting/costcenters/list">Cost Center</a></li>
						<li class="breadcrumb-item active">Edit Without Cost Center</li>
					</ol>
				</div>
			</div>
            <div class="col-md-6 ">
                <div class="d-sm-block cost_mainin float-end">
                <button class="btn btn-custom-success btn-sm pull-right me-1" title="Save"><i class="fas fa-save"></i> Save </a>
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
						<h4 class="header-title mb-0">Edit Without Cost Center</h4>
					</div>
					<div class="card-body">
                    <form class="needs-validation" novalidate="">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="validationCustom02" class="form-label">Main Account</label>
                                    <select class="select2 form-control " data-placeholder="Nothing Select">
                                     <option value="1">Vehicles</option>
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Code</label>
                                    <input type="text" class="form-control" value="12" name="code" id="validationCustom02" placeholder="Code" required="">
                            
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" value="name" name="name" id="validationCustom02" placeholder="Name" required="">
                                </div>
                            </div>
                            <div class="col-md-12">
                                
                                <div class="">
                                <label>Type</label>
                                    <div class="form-check col-md-2 ml-2 mb-3">
                                        <input class="form-check-input" name="type" type="radio" id="formCheck1">
                                        <label class="form-check-label" for="formCheck1">
                                        Credit
                                        </label>
                                    </div>
                                    <div class="form-check col-md-2 mb-3">
                                        <input class="form-check-input" name="type" type="radio" id="formCheck2">
                                        <label class="form-check-label" for="formCheck2">
                                        Debit
                                        </label>
                                    </div>
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

<script>
    $('#selectall').click(function() { 
        $('.allcheck').filter(':checkbox').prop('checked', this.checked);
});
</script>

