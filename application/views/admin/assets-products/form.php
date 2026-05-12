<?php $this->load->view('admin/home/header');?>
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
						<li class="breadcrumb-item active">Add/Edit</li>
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
						<form class="needs-validation" method="POST" action="<?php echo base_url('admin/assets/product/submit');?>" novalidate>
							<input type="hidden" id="id" name="id" value="<?php echo $id;?>">
							<div class="row">
								<div class="col-md-4">
									<div class="form-group mb-3">
										<label for="description" class="form-label">Product Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="description" value="<?php echo $description;?>" placeholder="Product Name" name="description" required>
										<div class="invalid-feedback">
											Please provide a product name.
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group mb-3">
										<label for="fa_category" class="form-label">Select Category <span class="text-danger">*</span></label>
										<select class="form-select select2" name="fa_category" id="fa_category" required>
											<option value="">--- Select Category ---</option>
											<?php 
											foreach($categories as $pcat){?>
											<option value="<?php echo $pcat->id;?>" <?php echo ($fa_category == $pcat->id) ? "selected":"";?>><?php echo $pcat->category_name;?></option>
											<?php } ?>
										</select>
										<div class="invalid-feedback">
											Please select a parent category.
										</div>
									</div>
								</div>
								<div class="col-md-4 col-sm-6 col-xs-12 mb-3">
									<div class="form-group">
										<label class="control-label" for="fa_subcategory">Select Sub Category</label>
										<select id="fa_subcategory" name="fa_subcategory" class="form-control select2">
											<option value="">----- Select Category First -------</option>
										</select>
										<div class="invalid-feedback">
											Please provide a sub category.
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group mb-3">
										<label for="prod_sr_no" class="form-label">Prod. sr. no <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="prod_sr_no" value="<?php echo $prod_sr_no;?>" name="prod_sr_no" required>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group mb-3">
										<label for="model_no" class="form-label">Model No. <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="model_no" value="<?php echo $model_no;?>" name="model_no" required>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group mb-3">
										<label for="supplier_id" class="form-label">Select Supplier <span class="text-danger">*</span></label>
										<select class="form-select select2" name="supplier_id" id="supplier_id" required>
											<option value="">--- Select Supplier ---</option>
											<?php 
											foreach(vendorsListHelper() as $supp){?>
											<option value="<?php echo $supp->id;?>" <?php echo ($supplier_id == $supp->id) ? "selected":"";?>><?php echo $supp->vendor_name;?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group mb-3">
										<label for="purchase_date" class="form-label">Purchase Date <span class="text-danger">*</span></label>
										<input type="date" class="form-control" id="purchase_date" value="<?php echo $purchase_date;?>" name="purchase_date" required>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group mb-3">
										<label for="warranty_exp" class="form-label">Warranty Date <span class="text-danger">*</span></label>
										<input type="date" class="form-control" id="warranty_exp" value="<?php echo $warranty_exp;?>" name="warranty_exp" required>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group mb-3">
										<label for="price" class="form-label">Price <span class="text-danger">*</span></label>
										<input id="price" name="price" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" required="" inputmode="numeric" value="<?php echo $price;?>" style="text-align: right;">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group mb-3">
										<label for="prod_condition" class="form-label">Condition <span class="text-danger">*</span></label>
										<select id="prod_condition" name="prod_condition" class="form-control" required>
											<option value="new" <?php echo ($prod_condition == 'new') ? "selected":"";?>>New</option>
											<option value="old" <?php echo ($prod_condition == 'old') ? "selected":"";?>>Old</option>
										</select>
										<div class="invalid-feedback">
											Please provide a product condition.
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group mb-3">
										<label for="unit_value" class="form-label">Unit Value <span class="text-danger">*</span></label>
										<input id="unit_value" name="unit_value" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" required="" inputmode="numeric" value="<?php echo $unit_value;?>" style="text-align: right;">
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="form-group mb-3">
										<label for="value" class="form-label">Value <span class="text-danger">*</span></label>
										<input id="value" name="value" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" required="" inputmode="numeric" value="<?php echo $value;?>" style="text-align: right;">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group mb-3">
										<label for="status-select" class="form-label">Status <span class="text-danger">*</span></label>
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
							<div>
								<button class="btn btn-custom-success" type="submit">Submit form</button>
							</div>
						</form>

					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<?php $this->load->view('admin/home/footer');?>
<script>
	
	$(document).ready(function() {
	    var category_id = "<?= ($fa_category == '') ? 'NULL' : $fa_category; ?>";
		//console.log(category_id);
	    selectedSubCat(category_id);
	});
	
	
	$('#fa_category').change(function() {
		var category_id = $(this).find('option:selected').val();
		$('#fa_subcategory').val('');
		selectedSubCat(category_id);
	});

	function selectedSubCat(category_id){
		var selected_subcat = "<?= ($fa_subcategory == '') ? 'NULL' : $fa_subcategory; ?>";
		//alert(selected_subcat);
		if(category_id !== 'NULL'){
			$.ajax({
				url: "<?php echo base_url(); ?>admin/assets/product/sub-cat",
				type: "POST",
				data: {'category_id':category_id},
				dataType: "json",
				success: function(data){
					var html = '<option value="">Select Sub Category</option>';
			
					if (Object.keys(data).length > 0) {
						$.each(data, function(index, item) {
							var isSelected = (selected_subcat == item.id ? 'selected' : '');
							html += '<option value="' + item.id + '" data-id="' + item.id + '" ' + isSelected + '>' + item.subcategory_name + '</option>';
						});
					} else {
						var html = '<option value="">No Sub Category found</option>';
					}
					$('#fa_subcategory').html(html);
				},
				error: function(data){
					alert(data);
				}
			});
		}
	}
</script>