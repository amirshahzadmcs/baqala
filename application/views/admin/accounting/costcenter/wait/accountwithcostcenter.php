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
						<li class="breadcrumb-item active">Accounts with Cost Center</li>
					</ol>
				</div>
			</div>
            <div class="col-md-6 ">
                <div class="d-sm-block float-end">
                    <button type="button" class="btn btn-custom-danger btn-sm pull-right" title="Delete"><i class="fa fa-trash"></i> Delete</button>
                    &nbsp;
                    <a class="btn btn-custom-success btn-sm pull-right me-1" title="Export"><i class="fa fa-plus"></i> Export</a>
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
                            <th>Journal Account Id</th>
                            <th>Journal Account</th>
                            <th>Journal Account Code</th>
                            <th>Cost Center</th>
                            <th>Cost Center Code</th>
                            <th>Percentage</th>
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
                            <td>121212</td>
                            <td>61</td>
                            <td>afsd</td>
                            <td>32</td>
                            <td>3%</td>
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

