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
    td.newboxchange {
    background: #fccd42;
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
						
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/accounting/journal/list">Journal Entry</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/accounting/journal/list"> Recurring Journal Entry Profiles</a></li>
						<li class="breadcrumb-item active">Create</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom pull-right" title="Back" href="<?php echo base_url(); ?>admin/accounting/journal/list">
                        <i class="fa fa-reply"></i> Back</a>
										&nbsp;
					<button type="submit"  form="demo-form2" class="btn btn-sm btn-custom-success pull-right total" title="Save" >
                        <i class="fa fa-save"></i> Save</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end page title -->

<div class="container-fluid">
	<div class="page-content-wrapper">
    <form id="demo-form2" class="needs-validation" action="<?php echo base_url(); ?>admin/accounting/recurring/add-profile" method="post">
    <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-4">Recurring Journal Entry Information</h4>
                            <!-- <form class="needs-validation" novalidate> -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="validationCustom02" class="form-label">Name</label>
                                        <input type="text" class="form-control col-md-6" id="name"  required name="name">
										<input type="hidden" value="<?php echo $entry; ?>" name="entry_id">
                                        <div class="valid-feedback">
                                        Name
                                        </div>
                                    </div>
                                </div>
								<div class="col-md-6">
                                    <div class="mb-3">
                                        <label  class="form-label">Start Date</label>
                                        <div class="input-group" id="datepicker2">
                                            <input type="text" id="sdate" class="form-control" placeholder="dd M, yyyy" data-provide="datepicker" data-date-container="#datepicker2" data-date-format="yyyy-m-dd" data-date-autoclose="true" name="startdate">
                                        </div>
                                          <div class="invalid-feedback">
                                            Please select a valid date.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label  class="form-label">Frequency</label>
										<input type="text" class="form-control col-md-6" id="frequencyr"  required name="frequency">
                                        <div class="valid-feedback">
                                        	Frequency
										</div>
                                       
                                        <div class="invalid-feedback">
                                            Please select a valid state.
                                        </div>
                                    </div>
                                </div>
								<div class="col-md-3">
                                    <div class="mt-4">
									<select class="form-control select2 p-3" id="frequencyr_periods"style="height: 38px !important;" name="frequencyr_period">
                                            <optgroup>
                                                <option value="day">Day[S]</option>
                                                <option value="week">Week[S]</option>
                                                <option value="month" selected>Month[S]</option>
                                                <option value="year">Year[S]</option>
                                            </optgroup>
                                          
                                        </select>
									</div>
								</div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label  class="form-label">End  Date</label>
                                        <div class="input-group" id="datepicker2">
                                            <input type="text" id="edate" class="form-control" placeholder="dd M, yyyy" data-provide="datepicker" data-date-container="#datepicker2" data-date-format="yyyy-m-dd" data-date-autoclose="true" name="enddate">
                                        </div>
                                          <div class="invalid-feedback">
                                            Please select a valid date.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- </form> -->
                    </div>
                </div>
            </div>
        </div>
        </form>
	</div>
</div>
<!-- container-fluid -->
<?php $this->load->view('admin/home/footer');?>


 