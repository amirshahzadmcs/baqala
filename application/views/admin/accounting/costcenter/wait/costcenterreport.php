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
						<li class="breadcrumb-item active">Cost Center Report</li>
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
            
        <div class="col-12">
				<div class="card">
					<div class="card-header">
						<h4 class="header-title mb-0">Cost Center Report</h4>
					</div>
					<div class="card-body">
                    <form class="needs-validation" novalidate="">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Group By:</label>
                                    <select class="select2 form-control "
                                     data-placeholder="Nothing Select">
                                        <option>Cost Centers</option>
                                        <option>Journal Accounts</option>
                                        <optgroup label="Period">
                                            <option class="period" value="daily">Daily</option>
                                            <option class="period" value="weekly">Weekly</option>
                                            <option class="period" value="monthly">Monthly</option>
                                            <option class="period" value="yearly">Yearly</option>
					                    </optgroup>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="validationCustom03" class="form-label">Parent Cost Center:</label>
                                    <select class="select2 form-control select2-multiple"
                                    multiple="multiple" data-placeholder="Nothing Select">
                                        <option>All</option>
                                        <option>Head Office</option>
                                        <option>Logistics - Third Party Delivery</option>
                                        <option>E-Commerce</option>
                                        <option>Sales & Operations</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Secondary Cost Center:</label>
                                    <select class="select2 form-control select2-multiple"
                                    multiple="multiple" data-placeholder="Nothing Select">
                                        <option>All</option>
                                        <option>Management</option>
                                        <option>Human Resource & Admin</option>
                                        <option>Information Technology</option>
                                        <option>Finance & Accounts</option>
                                        <option>Jahez</option>
                                        <option>E-Commerce </option>
                                    </select>



                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-2">
                                    <label class="form-label">Account:</label>
                                    <select class="select2 form-control "
                                     data-placeholder="Nothing Select">
                                        <option>Default Account</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="mb-2">
                                    <label class="form-label">Date Range:</label>
                                    <div class="input-group" id="datepicker1">
                                        <input type="text" class="form-control" placeholder="dd M, yyyy"
                                            data-date-format="dd M, yyyy" data-date-container='#datepicker1' data-provide="datepicker">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <label class="form-label">Branch:</label>
                                    <select class="select2 form-control select2-multiple"
                                    multiple="multiple" data-placeholder="Nothing Select">
                                        <option> Main Branch</option>
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3 ">
                                    <!-- <label class="form-label">&nbsp;</label> -->
                                    <button type="submit" class="btn btn-success ml-0 btn-md">Show Report</button>
                                </div>
                            </div>
                           
                        </div>
                        </form>
					</div>
				</div>
			</div>
          
        </div>

        <div class="col-12 mb-3 mx-auto">
            <div class="card">
                <div class="card-body bg-soft-warning text-center pb-2">
                    <p class="fw-bold">No results found to match these filters</p>
                    <p class="fw-bold">Change search filters and try again</p>
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