<?php $this->load->view('admin/home/header');?>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Product Management</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/product">Product List</a></li>
						<li class="breadcrumb-item active">Bulk Add</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url();?>admin/product"><i class="fa fa-reply"></i> Back</a>
					<button form="demo-form2" type="submit" class="btn btn-sm btn-success pull-right" title="Save"><i class="fa fa-save"></i> Save</button>
				</div>
			</div>
		</div>
	</div>
</div>
 <!-- end page title -->

<div class="container-fluid">
	<div class="page-content-wrapper">
		<div class="row justify-content-center">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<?php echo form_open("admin/product/add_bulk", array("id"=>"demo-form2", "enctype"=>"multipart/form-data", "class"=>"form-horizontal form-label-left")); ?>
						<div role="tabpanel" class="tab-pane active in" id="tab_content1" aria-labelledby="home-tab">
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="csv_file">CSV File <span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="file" id="csv_file" name="csv_file" required="required" accept=".csv" class="form-control col-md-7 col-xs-12">
								</div>
							</div>
						</div>
						<?php echo form_close(); ?>
						<div class="mt-3">
							To download sample CSV click here <a href="<?php echo base_url('images/warehouse-bulk-sample.csv');?>" style="color:green" download><b>Sample CSV</b></a>
						</div>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<?php $this->load->view('admin/home/footer');?>
