<?php $this->load->view('company/layout/header');?>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <!-- start page title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="page-title">
							<h4>Product</h4>
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
								<li class="breadcrumb-item"><a href="javascript: void(0);">Product</a></li>
								<li class="breadcrumb-item active">Add Product</li>
							</ol>
						</div>
                    </div>
					<div class="col-sm-6">
						<div class="float-end d-none d-sm-block">
							<a href="<?php echo base_url('product-list'); ?>" class="btn btn-success"><i class="dripicons-chevron-left" style="vertical-align: middle;"></i> Go Back</a>
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
								<?php echo form_open("submit-product", array("id"=>"product-form", "enctype"=>"multipart/form-data", "class"=>"needs-validation custom-validation", "novalidate"=>"novalidate")); ?>
									<input type="hidden" id="id" name="id" value="<?php echo $id;?>">
									<div class="row">
										<div class="col-md-6">
											<div class="mb-3">
												<label for="name" class="form-label">Product Name English</label>
												<input type="text" maxlength="100" class="form-control" id="name" placeholder="Enter Product Name" name="name" value="<?php echo $name;?>" required>
												<div class="invalid-feedback">
													Please provide a product name.
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label for="name_arabic" class="form-label">Product Name Arabic</label>
												<input type="text" maxlength="100" class="form-control" id="name" placeholder="Enter Product Arabic Name" name="name_arabic" value="<?php echo $name_arabic;?>" required>
												<div class="invalid-feedback">
													Please provide a product arabic name.
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label for="sku" class="form-label">SKU</label>
												<input data-parsley-type="alphanum" type="text" maxlength="40" class="form-control" id="sku" placeholder="Product SKU" name="sku"  value="<?php echo $sku;?>" required>
												<div class="invalid-feedback">
													Please provide a product sku.
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label for="qty" class="form-label">Quantity</label>
												<input data-parsley-type="digits" type="text" class="form-control" maxlength="5" id="qty" value="<?php echo $qty;?>" placeholder="Enter Product Quantity" name="qty" required>
												<div class="invalid-feedback">
													Please provide a quantity.
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label for="cost_price" class="form-label">Cost Price</label>
												<input data-parsley-type="number" type="text" class="form-control" id="cost_price" value="<?php echo $cost_price;?>" placeholder="Enter Cost Price" name="cost_price" required>
												<div class="invalid-feedback">
													Please provide a cost price.
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label for="selling_price" class="form-label">Selling Price</label>
												<input data-parsley-type="number" type="text" class="form-control" id="selling_price" value="<?php echo $selling_price;?>" placeholder="Enter Selling Price" name="selling_price" required>
												<div class="invalid-feedback">
													Please provide a selling price.
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										
										<div class="col-md-6">
											<div class="mb-3">
												<label for="status" class="form-label">Status</label>
												<select class="form-control select2" name="status" style="width: 100%;" required>
													<option value="1" <?php echo ($status == '1') ? "selected":"";?>>Active</option>
													<option value="0" <?php echo ($status == '0') ? "selected":"";?>>Pending</option>
												</select>
												<div class="invalid-feedback">
													Please provide a company status.
												</div>
											</div>
										</div>
										
									</div>
									<div>
										<button class="btn btn-primary" type="submit">Submit form</button>
									</div>
								<?php echo form_close();?>

							</div>
						</div>
					</div> <!-- end col -->
				</div> <!-- end row -->
            </div>
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
<!-- end page content-->

<?php $this->load->view('company/layout/footer');?>
