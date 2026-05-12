<?php $this->load->view('admin/home/header');?>
<style> 
input, textarea, select, .select2{
    pointer-events: none;
}
</style>
<div id="wait"><img src="<?= base_url('images/sample-loader.gif');?>" /><br>Loading..</div>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Assets Products</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/assets/product/list');?>">Assets Product</a></li>
						<li class="breadcrumb-item active">Detail</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-none d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-1" title="Back" href="<?php echo base_url('admin/assets/product/list');?>"><i class="fa fa-reply"></i> Back</a>
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
                        <input type="hidden" id="id" name="id" value="<?php echo $id;?>">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="description" class="form-label">Product Name</label>
                                    <input type="text" class="form-control" id="description" value="<?php echo $description;?>" placeholder="Product Name" name="description" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="category_name" class="form-label">Product Category</label>
                                    <input type="text" class="form-control" id="category_name" value="<?php echo $category_name;?>" name="description" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="sub_cat_name" class="form-label">Product Sub Category</label>
                                    <input type="text" class="form-control" id="sub_cat_name" value="<?php echo $sub_cat_name;?>" name="description" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="prod_sr_no" class="form-label">Prod. sr. no</label>
                                    <input type="text" class="form-control" id="prod_sr_no" value="<?php echo $prod_sr_no;?>" name="prod_sr_no" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="model_no" class="form-label">Model No.</label>
                                    <input type="text" class="form-control" id="model_no" value="<?php echo $model_no;?>" name="model_no" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="purchase_date" class="form-label">Purchase Date</label>
                                    <input type="date" class="form-control" id="purchase_date" value="<?php echo $purchase_date;?>" name="purchase_date" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="warranty_exp" class="form-label">Warranty Date</label>
                                    <input type="date" class="form-control" id="warranty_exp" value="<?php echo $warranty_exp;?>" name="warranty_exp" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="price" class="form-label">Price</label>
                                    <input id="price" name="price" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" required="" inputmode="numeric" value="<?php echo $price;?>" style="text-align: right;">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="prod_condition" class="form-label">Condition</label>
                                    <select id="prod_condition" name="prod_condition" class="form-control" required>
                                        <option value="new" <?php echo ($prod_condition == 'new') ? "selected":"";?>>New</option>
                                        <option value="old" <?php echo ($prod_condition == 'old') ? "selected":"";?>>Old</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="unit_value" class="form-label">Unit Value</label>
                                    <input id="unit_value" name="unit_value" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" required="" inputmode="numeric" value="<?php echo $unit_value;?>" style="text-align: right;">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="qty" class="form-label">Quantity</label>
                                    <input type="number" class="form-control" id="qty" value="<?php echo $qty;?>" name="qty" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="value" class="form-label">Value</label>
                                    <input id="value" name="value" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" required="" inputmode="numeric" value="<?php echo $value;?>" style="text-align: right;">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="vendor_name" class="form-label">Vendor Name</label>
                                    <input type="text" class="form-control" id="vendor_name" value="<?php echo $vendor_name;?>" name="vendor_name" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="ip" class="form-label">IP Address</label>
                                    <input type="text" class="form-control" id="ip" value="<?php echo $ip;?>" name="ip" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Employee Name</label>
                                    <input type="text" class="form-control" value="<?php echo $emp_name;?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Employee Designation</label>
                                    <input type="text" class="form-control" value="<?php echo $emp_designation;?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="status-select" class="form-label">Status</label>
                                    <select id="status-select" name="status" class="form-control" required>
                                        <option value="active" <?php echo ($status == 'active') ? "selected":"";?>>Active</option>
                                        <option value="inactive" <?php echo ($status == 'inactive') ? "selected":"";?>>Deactive</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please provide a status.
                                    </div>
                                </div>
                            </div>
                        </div>

					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<?php $this->load->view('admin/home/footer');?>