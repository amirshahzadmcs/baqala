<?php
$this->load->view('admin/home/header');
?>
<style>
span.required{
	color:red;
}
.alert_text{
	border:2px red solid;
}
.d-none{
	display:none;
}
ul.nav-pills li.nav-item{
	width:16.66% !important;
}


@media only screen and (max-width: 1240px) {
  ul.nav-pills li.nav-item{
		width:24% !important;
	}
}
@media only screen and (max-width: 767px) {
  ul.nav-pills li.nav-item{
		width:50% !important;
	}
}

.nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    color: #181818 !important;
    background-color: #e7e7e7!important;
}
.nav-tabs-custom .nav-item .nav-link::after {
    background: #005500!important;
}

/*-----Images -----*/
.box {
  display: block;
  margin: 10px;
  background-color: white;
  border-radius: 5px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
  transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
  overflow: hidden;
}

.upload-options {
  position: relative;
  height: 40px;
  background-color: cadetblue;
  cursor: pointer;
  overflow: hidden;
  text-align: center;
  transition: background-color ease-in-out 150ms;
}
.upload-options:hover {
  background-color: #7fb1b3;
}
.upload-options input {
  width: 0.1px;
  height: 0.1px;
  opacity: 0;
  overflow: hidden;
  position: absolute;
  z-index: -1;
}
.upload-options label {
  display: flex;
  align-items: center;
  width: 100%;
  height: 100%;
  font-weight: 400;
  text-overflow: ellipsis;
  white-space: nowrap;
  cursor: pointer;
  overflow: hidden;
}
.upload-options label::after {
  content: "\e035";
  font-family: "dripicons-v2";
  position: absolute;
  font-size: 2.2rem;
  color: #e6e6e6;
  top: calc(50% - 1.5rem);
  left: calc(50% - 1.25rem);
  z-index: 0;
}
.upload-options label span {
  display: inline-block;
  width: 50%;
  height: 100%;
  text-overflow: ellipsis;
  white-space: nowrap;
  overflow: hidden;
  vertical-align: middle;
  text-align: center;
}
.upload-options label span:hover i.material-icons {
  color: lightgray;
}

.js--image-preview {
  height: 180px;
  width: 100%;
  position: relative;
  overflow: hidden;
  /*background-image: url("");*/
  background-color: white;
  background-position: center center;
  background-repeat: no-repeat;
  background-size: cover;
}
.js--image-preview::after {
	content: "\F087C";
    font-family: "Material Design Icons";
    position: relative;
    font-size: 70px;
    color: #cbc9c9;
    top: calc(50% - 3rem);
    left: calc(50% - 2.2rem);
    z-index: 0;
}
.js--image-preview.js--no-default::after {
  display: none;
}
.js--image-preview:nth-child(2) {
  background-image: url("http://bastianandre.at/giphy.gif");
}

i.material-icons {
  transition: color 100ms ease-in-out;
  font-size: 2.25em;
  line-height: 55px;
  color: white;
  display: block;
}

.drop {
  display: block;
  position: absolute;
  background: rgba(95, 158, 160, 0.2);
  border-radius: 100%;
  transform: scale(0);
}

.animate {
  -webkit-animation: ripple 0.4s linear;
          animation: ripple 0.4s linear;
}

@-webkit-keyframes ripple {
  100% {
    opacity: 0;
    transform: scale(2.5);
  }
}

@keyframes ripple {
  100% {
    opacity: 0;
    transform: scale(2.5);
  }
}
.size-inner-section{
	box-shadow: 0px 1px 4px #c5c5c5;
	border-radius: 5px;
	margin-bottom: 10px;
}
.select2-container .select2-selection--single .select2-selection__rendered {
    padding-right: 30px !important;
}
.select2-container--default .select2-results__option[aria-selected=true] {
    background-color: #dfdfdf !important;
}
.save-img-prev{
	width: 100%;
	height: 100%;
}
.save-img-prev img{
	position: absolute;
    z-index: 9;
    object-fit: contain;
    width: 100%;
    height: 100%;
}
.btn-img-delete{
	position: absolute;
	z-index: 99;
	border-radius: 50%;
	width: 30px;
	height: 30px;
	right: 5px;
	top: 5px;
}
.btn-img-delete i{
	vertical-align: super;
	margin: 0px -4px;
}
/*---- Sidebar ----*/
.modal .modal-dialog-aside{
	width: 350px;
	max-width:80%; height: 100%; margin:0;
	transform: translate(0); transition: transform .2s;
}


.modal .modal-dialog-aside .modal-content{  height: inherit; border:0; border-radius: 0;}
.modal .modal-dialog-aside .modal-content .modal-body{ overflow-y: auto }
.modal.fixed-left .modal-dialog-aside{ margin-left:auto;  transform: translateX(100%); }
.modal.fixed-right .modal-dialog-aside{ margin-right:auto; transform: translateX(-100%); }

.modal.show .modal-dialog-aside{ transform: translateX(0);  }

</style>

<div id="wait"><i class="fa fa-spinner fa-spin"></i><br>Loading..</div>
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
                        <li class="breadcrumb-item active">Create / Edit</li>
                    </ol>
                </div>
            </div>
            <?php  $admin_id= $this->session->userdata('admin_id'); ?>
            <div class="col-sm-6">
                <div class="float-end d-sm-block">
                    <a class="btn btn-sm btn-custom-white pull-right me-2" title="Back" href="<?php echo base_url();?>admin/product"><i class="fa fa-reply"></i> Back</a>
                    <button type="submit" form="demo-form2" class="btn btn-sm btn-custom-success pull-right" title="Save"><i class="fa fa-save"></i> Save</button>
                </div>
                <?php if($this->admin->getInfo()){ $info = explode("--", $this->admin->getInfo()); $info_type = $info[0]; $msg_data = $info[1]; if($info_type == 2){ ?>
                <div class="alert alert-danger alert-dismissible fade show" style="position: fixed; z-index: 99; right: 20px; top: 90px; width: 50%;" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong><?php echo $msg_data;?></strong>
                </div>
                <?php } else{?>
                <div class="alert alert-info alert-dismissible fade show" style="position: fixed; z-index: 99; right: 20px; top: 90px; width: 50%;" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong><?php echo $msg_data;?></strong>
                </div>
                <?php } ?>
                <?php } $this->admin->removeInfo();?>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->
<div class="container-fluid">
    <div class="page-content-wrapper">
        <div class="row">
            <div class="col-lg-12 p-1">
                <div class="card mb-1">
                    <div class="card-body">
						<div class="product-info d-flex">
							<div class="product-img me-3">
								<?php echo
								!empty($main_image) ? '<img class="avatar-xl img-fluid mx-auto" src="'.base_url().$main_image.'" />' : '<img class="avatar-xl img-fluid mx-auto" src="'.base_url().'images/notfound.jpg" />';?>
							</div>

							<div class="text-left">
								<a href="javascript:;" class="text-dark">
									<h6 class="mb-2">Main SKU: <?= $parent_sku;?></h6>
								</a>
								<h6 class="mb-2">Brand: <?= $brand_name;?></h6>
								<h6 class="mb-2">Category: <?= $main_cat_name;?></h6>
								<h6 class="mt-2">Status: <?= ($status == 1) ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>'; ?></h6>
								<h6 class="mt-2">COD: <?= ($cod_available == 1) ? '<span class="badge badge-pill badge-soft-success font-size-13">Yes</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">No</span>'; ?></h6>
							    <h6 class="mt-2">Variation: <?= ($is_variation == 'yes') ? '<span class="badge badge-pill badge-soft-success font-size-13">Yes</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">No</span>'; ?></h6>
							    <h6 class="mt-2">B2B Availability: <?= ($b2b_availability == 'yes') ? '<span class="badge badge-pill badge-soft-success font-size-13">Yes</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">No</span>'; ?></h6>
							</div>
							<div class="ms-4"><a href="javascript:;" data-bs-toggle="modal" data-bs-target=".exampleModalFullscreen" class="float-end"><i class="mdi mdi-pencil-box-outline font-size-22"></i></a></div>
						</div>
					</div>
                </div>
            </div>
			
			<div class="col-lg-12 p-1">
                <div class="card">
                    <div class="card-body">
						<form id="demo-form2" method="post" action="<?php echo base_url()?>admin/product/edit" enctype="multipart/form-data" class="form-horizontal form-label-left" data-toggle="validator" role="form">
							<input type="hidden" name="product_id" value="<?php echo $id;?>" />
							<div id="addproduct-nav-pills-wizard" class="twitter-bs-wizard">
								<ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" data-bs-toggle="tab" href="#home" role="tab">
											<span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
											<span class="d-none d-sm-block">Home</span> 
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab">
											<span class="d-block d-sm-none"><i class="far fa-user"></i></span>
											<span class="d-none d-sm-block">Attributes</span> 
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-bs-toggle="tab" href="#messages1" role="tab">
											<span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
											<span class="d-none d-sm-block">Price Variation</span>   
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-bs-toggle="tab" href="#settings1" role="tab">
											<span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
											<span class="d-none d-sm-block">Images</span>    
										</a>
									</li>
									
									<li class="nav-item">
										<a class="nav-link" data-bs-toggle="tab" href="#review1" role="tab">
											<span class="d-block d-sm-none"><i class="fas fa-comment"></i></span>
											<span class="d-none d-sm-block">Reviews</span>    
										</a>
									</li>
								</ul>
								
								<div class="tab-content py-3 text-muted">
									<div class="tab-pane active" id="home" role="tabpanel">
										<h4 class="header-title">Basic Information</h4>
										<p class="card-title-desc">Fill all information below</p>
										<input type="hidden" id="product_id" name="product_id" value="<?php echo $id;?>" class="form-control">

										<div class="row">
										
											<div class="col-md-6 col-sm-6 col-xs-12 mb-3">
												<div class="form-group">
													<label class="control-label" for="name">Product Title (English)<span class="required">*</span>
													</label>
													<input type="text" id="name" name="name" value="<?php echo $name;?>" required="required" onblur="checkField('name')" class="form-control">
												</div>
											</div>

											<div class="col-md-6 col-sm-6 col-xs-12 mb-3">
												<div class="form-group text-end">
													<label class="control-label" for="name_ar">Product Title (Arabic)<span class="required">*</span></label>
													<input type="text" id="name_ar" name="name_ar" value="<?php echo htmlspecialchars($name_ar);?>" class="form-control rtl-input">
												</div>
											</div>

											<div class="col-md-6 col-sm-6 col-xs-12 mb-3">
												<div class="form-group">
													<label class="control-label" for="description">Product Description (English)</label>
													<textarea class="form-control length-textarea" name="description" maxlength="3000" rows="5" placeholder="This textarea has a limit of 3000 chars" style="min-height: 200px;"><?php echo $description;?></textarea>
												</div>
											</div>

											<div class="col-md-6 col-sm-6 col-xs-12 mb-3">
												<div class="form-group text-end">
													<label class="control-label" for="description_ar">Product Description (Arabic)
													</label>
													<textarea id="textarea" class="form-control rtl-input" name="description_ar" maxlength="3000" rows="5" placeholder="This textarea has a limit of 3000 chars" style="min-height: 200px;"><?php echo $description_ar;?></textarea>
												</div>
											</div>
											
											<div class="col-md-6 col-sm-6 col-xs-12 mb-3">
												<div class="form-group">
													<label class="control-label" for="moq">Minimum Order Quantity <span class="required">*</span></label>
													<input type="number" min="1" max="100" id="moq" name="moq" value="<?php echo $moq;?>" onblur="checkField('moq')"  required class="form-control">
												</div>
											</div>
											
											<div class="col-md-6 col-sm-6 col-xs-12 mb-3">
												<div class="form-group">
													<label class="control-label" for="meta_title">Meta Title <span class="required">*</span></label>
													<input type="text" id="meta_title" name="meta_title" value="<?php echo $meta_title;?>" onblur="checkField('meta_title')"  required class="form-control">
												</div>
											</div>

											<div class="col-md-12 col-sm-12 col-xs-12 mb-3">
												<div class="form-group">
													<label class="control-label" for="meta_description">Meta Description
													</label>
													<textarea id="meta_description" name="meta_description" class="form-control"><?php echo $meta_description;?></textarea>
												</div>
											</div>

											<div class="col-md-12 col-sm-12 col-xs-12 mb-3">
												<div class="form-group">
													<label class="control-label" for="meta_keyword">Meta Keywords</label>
													<input type="text" id="meta_keyword" name="meta_keyword" value="<?php echo $meta_keyword;?>" class="form-control">
												</div>
											</div>

										</div>
									</div>	
									
									
									<div class="tab-pane" id="profile1" role="tabpanel">
										<h4 class="header-title">Product Attributes</h4>
										<p class="card-title-desc">Fill all information below</p>
										<table id="attribute" class="table table-striped table-bordered table-hover">
											<thead>
												<tr>
													<td class="text-left" style="width: 40%;">Attribute</td>
													<td class="text-left">Text</td>
													<td></td>
												</tr>
											</thead>
											<tbody>
												<?php $attribute_row = 1;
												foreach($product_attribute->result() as $product_attributes){ ?>
												<tr id="attribute-row<?php echo $attribute_row; ?>">
													<td class="text-left">
														<input type="text" name="attribute_name[]" value="<?php echo $product_attributes->attribute_name; ?>" placeholder="Attribute Name" class="form-control mb-1" />
														<input type="text" name="attribute_name_ar[]" value="<?php echo $product_attributes->attribute_name_ar; ?>" placeholder="Attribute Name Arabic" class="form-control rtl-input" />
													</td>
													<td class="text-left">
														<textarea name="attribute_value[]" rows="5" placeholder="Attribute Value" class="form-control mb-1"><?php echo $product_attributes->attribute_value;?></textarea>
														<textarea name="attribute_value_ar[]" rows="5" placeholder="Attribute Value Arabic" class="form-control rtl-input"><?php echo $product_attributes->attribute_value_ar;?></textarea>
													</td>
													<td class="text-right">
														<button type="button" onclick="remove_attribute(<?php echo $attribute_row;?>)" data-toggle="tooltip" title="Remove" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></button>
													</td>
												</tr>
												<?php $attribute_row = $attribute_row + 1;}?>
											</tbody>

											<tfoot>
												<tr>
													<td colspan="2" style="width: 90%;"></td>
													<td class="text-right">
														<button type="button" onclick="addAttribute();" title="Add" class="btn btn-success btn-sm"><i class="fa fa-plus-circle"></i></button>
													</td>
												</tr>
											</tfoot>
										</table>
									</div>

									<div class="tab-pane" id="messages1" role="tabpanel">
										<h4 class="header-title">Size And Price</h4>
										<p class="card-title-desc">Create variations for your product.</p>
										
										<div id="size_sections">
											<?php if(!empty($product_size)){ ?>
											<?php foreach($product_size as $psize){?>
											<div class="size-inner-section">
												<input type="hidden" name="size_id[]" value="<?php echo $psize->id;?>" required>
												<div class="row p-3">
													<div class="col-md-3 col-sm-6 col-xs-12 mb-3">
														<div class="form-group">
															<label class="control-label" for="size">Size English <span class="required">*</span></label>
															<input type="text" name="size[]" value="<?php echo $psize->size;?>" class="form-control">
														</div>
													</div>
													<div class="col-md-3 col-sm-6 col-xs-12 mb-3">
														<div class="form-group">
															<label class="control-label" for="size">Size Arabic</label>
															<input type="text" name="size_arabic[]" value="<?php echo $psize->size_arabic;?>" class="form-control rtl-input">
														</div>
													</div>
													<div class="col-md-3 col-sm-6 col-xs-12 mb-3">
														<div class="form-group">
															<label class="control-label" for="size_unit">Size Unit English <span class="required">*</span></label>
															<select id="size_unit" name="size_unit[]" class="form-control">
																<option value="">Select Unit</option>
																<?php foreach($unit_list as $unit){ ?>
																<option value="<?= $unit->id;?>" <?php echo ($unit->id == $psize->size_unit) ? "selected":"" ?>><?= $unit->unit_name;?></option>
																<?php } ?>
															</select>
														</div>
													</div>
													
													<div class="col-md-3 col-sm-6 col-xs-12 mb-3">
														<div class="form-group">
															<label class="control-label">Product Barcode</label>
															<input type="text" name="barcode[]" value="<?php echo $psize->barcode;?>" class="form-control">
														</div>
													</div>
													
													<div class="col-md-3 col-sm-6 col-xs-12 mb-3">
														<div class="form-group">
															<label class="control-label">Product Price <span class="required">*</span></label>
															<input type="number" name="price[]" min="0" step="any" value="<?php echo $psize->price;?>" class="form-control">
														</div>
													</div>
													
													<div class="col-md-3 col-sm-6 col-xs-12 mb-3">
														<div class="form-group">
															<label class="control-label">Discounted Price</label>
															<input type="number" name="discounted_price[]" value="<?php echo $psize->discounted_price;?>" min="0" step="any" class="form-control">
														</div>
													</div>
													
													<div class="col-md-3 col-sm-6 col-xs-12 mb-3">
														<div class="form-group">
															<label class="control-label">Discount Expiry</label>
															<input type="date" name="disc_expiry[]" value="<?php echo $psize->disc_expiry;?>" class="form-control">
														</div>
													</div>
													
													<div class="col-md-3 col-sm-6 col-xs-12 mb-3">
														<div class="form-group">
															<label class="control-label">Cashback</label>
															<input type="number" name="cashback[]" value="<?php echo $psize->cashback;?>" min="0" step="any" class="form-control">
														</div>
													</div>
													
													<div class="col-md-3 col-sm-6 col-xs-12 mb-3">
														<div class="form-group">
															<label class="control-label">Cashback Expiry</label>
															<input type="date" name="cashback_expiry[]" value="<?php echo $psize->cashback_expiry;?>" class="form-control">
														</div>
													</div>
													
													<div class="col-md-3 col-sm-6 col-xs-12 mb-3">
														<div class="form-group">
															<label class="control-label">Product SKU</label>
															<input type="hidden" name="product_sku[]" value="<?php echo $psize->product_sku;?>" class="form-control" />
															<input type="text" value="<?php echo $parent_sku .'-'. $psize->product_sku;?>" class="form-control" disabled />
														</div>
													</div>
													
													<div class="col-md-3 col-sm-6 col-xs-12 mb-3">
														<div class="form-group">
															<label class="control-label">Seller SKU</label>
															<input type="text" name="seller_sku[]" value="<?php echo $psize->seller_sku;?>" class="form-control">
														</div>
													</div>

													<div class="col-md-3 col-sm-6 col-xs-12 mb-3">
														<div class="form-group">
															<label class="control-label" for="prod_rack<?= $psize->id; ?>">Select Product Rack</label>
															<select id="prod_rack<?= $psize->id; ?>" onChange="rackChange(this);" name="rack_id[]" class="form-control">
																<option value="">Select Rack</option>
																<?php foreach($racks as $rack){ ?>
																<option value="<?php echo $rack['id'];?>" <?php echo ($rack['id'] == $psize->rack) ? "selected":"" ?>><?php echo $rack['rack_name'];?></option>
																<?php } ?>
															</select>
														</div>
													</div>

													<div class="col-md-3 col-sm-6 col-xs-12 mb-3">
														<div class="form-group">
															<label class="control-label" for="prod_shelf<?= $psize->id; ?>">Select Product Shelf</label>
															<select id="prod_shelf<?= $psize->id; ?>" name="shelf_id[]" class="form-control">
																<option value="">----- Select Rack First -------</option>
																<?php foreach($shelfs as $shelf){ ?>
																<?php if($shelf['id'] == $psize->shelf){?>
																<option value="<?php echo $shelf['id'];?>" <?php echo ($shelf['id'] == $psize->shelf) ? "selected":"" ?>><?php echo $shelf['shelf_name'];?></option>
																<?php }} ?>
															</select>
														</div>
													</div>

													<?php if($is_variation == 'yes'){ ?>
													<p><a type="button" href="javascript:;" class="btn btn-link text-danger remove" data-size_id="<?php echo $psize->id;?>"><i class="fas fa-minus-square"></i> Remove</a></p>
													<?php } ?>
												</div>
											</div>
											<?php } ?>
											<?php }else{ ?>
											<div class="size-inner-section">
												<input type="hidden" name="size_id[]" value="" />
												<div class="row p-3">
													<div class="col-md-3 col-sm-6 col-xs-12 mb-3">
														<div class="form-group">
															<label class="control-label" for="size">Size English <span class="required">*</span></label>
															<input type="text" name="size[]" value="" class="form-control">
														</div>
													</div>
													<div class="col-md-3 col-sm-6 col-xs-12 mb-3">
														<div class="form-group">
															<label class="control-label" for="size">Size Arabic</label>
															<input type="text" name="size_arabic[]" value="" class="form-control rtl-input">
														</div>
													</div>
													<div class="col-md-3 col-sm-6 col-xs-12 mb-3">
														<div class="form-group">
															<label class="control-label" for="size_unit">Size Unit English <span class="required">*</span></label>
															<select id="size_unit" name="size_unit[]" class="form-control">
																<option value="">Select Unit</option>
																<?php foreach($unit_list as $unit){ ?>
																<option value="<?= $unit->id;?>"><?= $unit->unit_name;?></option>
																<?php } ?>
															</select>
														</div>
													</div>
													
													<div class="col-md-3 col-sm-6 col-xs-12 mb-3">
														<div class="form-group">
															<label class="control-label">Product Barcode</label>
															<input type="text" name="barcode[]" value="" class="form-control">
														</div>
													</div>
													
													<div class="col-md-3 col-sm-6 col-xs-12 mb-3">
														<div class="form-group">
															<label class="control-label">Product Price <span class="required">*</span></label>
															<input type="number" name="price[]" min="0" step="any" value="" class="form-control">
														</div>
													</div>
													
													<div class="col-md-3 col-sm-6 col-xs-12 mb-3">
														<div class="form-group">
															<label class="control-label">Discounted Price</label>
															<input type="number" name="discounted_price[]" value="" min="0" step="any" class="form-control">
														</div>
													</div>
													
													<div class="col-md-3 col-sm-6 col-xs-12 mb-3">
														<div class="form-group">
															<label class="control-label">Discount Expiry</label>
															<input type="date" name="disc_expiry[]" value="" class="form-control">
														</div>
													</div>
													
													<div class="col-md-3 col-sm-6 col-xs-12 mb-3">
														<div class="form-group">
															<label class="control-label">Cashback</label>
															<input type="number" name="cashback[]" value="" min="0" step="any" class="form-control">
														</div>
													</div>
													
													<div class="col-md-3 col-sm-6 col-xs-12 mb-3">
														<div class="form-group">
															<label class="control-label">Cashback Expiry</label>
															<input type="date" name="cashback_expiry[]" value="" class="form-control">
														</div>
													</div>
													
													<div class="col-md-3 col-sm-6 col-xs-12 mb-3">
														<div class="form-group">
															<label class="control-label">Product SKU</label>
															<input type="hidden" name="product_sku[]" value="" />
															<input type="text" value="" class="form-control" readonly />
														</div>
													</div>
													
													<div class="col-md-3 col-sm-6 col-xs-12 mb-3">
														<div class="form-group">
															<label class="control-label">Seller SKU</label>
															<input type="text" name="seller_sku[]" value="" class="form-control">
														</div>
													</div>

													<div class="col-md-3 col-sm-6 col-xs-12 mb-3">
														<div class="form-group">
															<label class="control-label" for="prod_rack">Select Product Rack</label>
															<select id="prod_rack" name="rack_id[]" onChange="rackChange(this);" class="form-control select2">
																<option value="">Select Rack</option>
																<?php foreach($racks as $rack){ ?>
																<option value="<?php echo $rack['id'];?>"><?php echo $rack['rack_name'];?></option>
																<?php } ?>
															</select>
														</div>
													</div>

													<div class="col-md-3 col-sm-6 col-xs-12 mb-3">
														<div class="form-group">
															<label class="control-label" for="prod_shelf">Select Product Shelf</label>
															<select id="prod_shelf" name="shelf_id[]" class="form-control">
																<option value="">----- Select Rack First -------</option>
															</select>
														</div>
													</div>

													<?php if($is_variation == 'yes'){ ?>
													<p><a type="button" href="javascript:;" class="btn btn-link text-danger remove" data-size_id="0"><i class="fas fa-minus-square"></i> Remove</a></p>
													<?php } ?>
												</div>
											</div>
											<?php } ?>
										</div>
										
										<?php if($is_variation == 'yes'){ ?>
										<p><a href="javascript:;" class='btn btn-success btn-sm addsection'><i class="fas fa-plus"></i> Add More</a></p>
										<?php } ?>
									</div>

									<div class="tab-pane" id="settings1" role="tabpanel">
										<h5 class="header-title">Product Images</h5>
										<p><b>Note:</b> 1000 x 1000 size recommended, Only jpg, png accepted and Image size should not greater than 1mb</p><br/>
										<div class="row d-flex">
											<h6 class="text-left">Main Image*</h6>
											<div class="col-md-3 p-0 box">
												<div class="js--image-preview" id="img_prev">
												<?php echo !empty($main_image) ? '<div class="save-img-prev"><a onclick="deleteImg(\'img_prev\',\'refresh-img1\')" class="btn btn-danger btn-img-delete"><i class="fas fa-trash"></i></a><img class="avatar-xl img-fluid mx-auto" src="'.base_url().$main_image.'" /></div>' : '';?>
												</div>
												<div class="upload-options">
													<label>
														<input type="file" name="main_image" class="image-upload refresh-img1" accept="image/*" />
														<input type="hidden" name="old_main_image" class="refresh-img1" value="<?php echo $main_image;?>" />
													</label>
												</div>
											</div>
										</div>
										<div class="row d-flex mt-4">
											<h6 class="text-left">Other Image</h6>
											<div class="col-md-2 p-0 box">
												<div class="js--image-preview" id="img_prev1">
													<?php echo !empty($product_image->other_img1) ? '<div class="save-img-prev"><a onclick="deleteImg(\'img_prev1\',\'refresh-img2\')" class="btn btn-danger btn-img-delete"><i class="fas fa-trash"></i></a><img class="avatar-xl img-fluid mx-auto" src="'.base_url().$product_image->other_img1.'" /></div>' : '';?>
												</div>
												<div class="upload-options">
													<label>
														<input type="file" class="image-upload refresh-img2" name="other_img1" accept="image/*" />
														<input type="hidden" name="old_other_img1" class="refresh-img2" value="<?php echo empty($product_image->other_img1) ? '' : $product_image->other_img1; ?>" />
													</label>
												</div>
											</div>

											<div class="col-md-2 p-0 box">
												<div class="js--image-preview" id="img_prev2">
													<?php echo !empty($product_image->other_img2) ? '<div class="save-img-prev"><a onclick="deleteImg(\'img_prev2\',\'refresh-img3\')" class="btn btn-danger btn-img-delete"><i class="fas fa-trash"></i></a><img class="avatar-xl img-fluid mx-auto" src="'.base_url().$product_image->other_img2.'" /></div>' : '';?>
												</div>
												<div class="upload-options">
													<label>
														<input type="file" class="image-upload refresh-img3" name="other_img2" accept="image/*" />
														<input type="hidden" name="old_other_img2" class="refresh-img3" value="<?php echo empty($product_image->other_img2) ? '' : $product_image->other_img2; ?>" />
													</label>
												</div>
											</div>
											
											<div class="col-md-2 p-0 box">
												<div class="js--image-preview" id="img_prev3">
													<?php echo !empty($product_image->other_img3) ? '<div class="save-img-prev"><a onclick="deleteImg(\'img_prev3\',\'refresh-img4\')" class="btn btn-danger btn-img-delete"><i class="fas fa-trash"></i></a><img class="avatar-xl img-fluid mx-auto" src="'.base_url().$product_image->other_img3.'" /></div>' : '';?>
												</div>
												<div class="upload-options">
													<label>
														<input type="file" class="image-upload refresh-img4" name="other_img3" accept="image/*" />
														<input type="hidden" name="old_other_img3" class="refresh-img4" value="<?php echo empty($product_image->other_img3) ? '' : $product_image->other_img3; ?>" />
													</label>
												</div>
											</div>
											
											<div class="col-md-2 p-0 box">
												<div class="js--image-preview" id="img_prev4">
													<?php echo !empty($product_image->other_img4) ? '<div class="save-img-prev"><a onclick="deleteImg(\'img_prev4\',\'refresh-img5\')" class="btn btn-danger btn-img-delete"><i class="fas fa-trash"></i></a><img class="avatar-xl img-fluid mx-auto" src="'.base_url().$product_image->other_img4.'" /></div>' : '';?>
												</div>
												<div class="upload-options">
													<label>
														<input type="file" class="image-upload refresh-img5" name="other_image4" accept="image/*" />
														<input type="hidden" name="old_other_img4" class="refresh-img5" value="<?php echo empty($product_image->other_img4) ? '' : $product_image->other_img4; ?>" />
													</label>
												</div>
											</div>
										</div>
									</div>
									
									<div class="tab-pane" id="review1" role="tabpanel">
										<h4 class="header-title">Product Reviews</h4>
										<p class="card-title-desc">Fill all information below</p>
										<table id="rating" class="table table-striped table-bordered table-hover">
											<thead>
												<tr>
													<td class="text-left">Rating</td>
													<td class="text-left">Review Text</td>
													<td class="text-left">Reviewer Name</td>
													<td style="width: 8%;"></td>
												</tr>
											</thead>
											<tbody>
												<?php $rating_row = 1;
												foreach($product_review->result() as $rating){ ?>
												<tr id="rating-row<?php echo $rating_row; ?>">
													<td class="text-left" style="width: 10%;">
														<input type="number" min="1" max="5" name="rating[]" value="<?php echo $rating->rating; ?>" placeholder="Rating out of 5" class="form-control" />
													</td>
													<td class="text-left">
														<div class="input-group">
															<textarea name="review_text[]" rows="5" placeholder="Text" class="form-control"><?php echo $rating->review_text;?></textarea>
														</div>
													</td>
													<td class="text-left" style="width: 20%;">
														<input type="text" name="rating_person[]" value="<?php echo $rating->rating_person; ?>" placeholder="Person Name" class="form-control" />
													</td>
													<td class="text-right">
														<button type="button" onclick="remove_rating(<?php echo $rating_row;?>)" data-toggle="tooltip" title="Remove" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></button>
													</td>
												</tr>
												<?php $rating_row = $rating_row + 1;}?>
											</tbody>

											<tfoot>
												<tr>
													<td colspan="3"></td>
													<td class="text-right">
														<button type="button" onclick="addRating();" title="Add" class="btn btn-success btn-sm"><i class="fa fa-plus-circle"></i></button>
													</td>
												</tr>
											</tfoot>
										</table>
									</div>
									
								</div>

							</div>

						</form>
					</div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
</div>
<!-- container-fluid -->
<div class="modal fade fixed-left exampleModalFullscreen" aria-labelledby="#exampleModalFullscreenLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-aside">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="exampleModalFullscreenLabel">Quick Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('admin/product/update_product'); ?>" method="POST" id="product_edit">
					<input type="hidden" name="main_id" value="<?php echo $id;?>" />
					<div class="row">
					    <div class="col-12 mb-2">
							<div class="form-group">
								<label>Main SKU</label>
								<input type="text" name="parent_sku" value="<?= $parent_sku;?>" class="form-control">
								<small>Enter product parent SKU</small><br/>
							</div>
						</div>
						<div class="col-12 mb-2">
							<div class="form-group">
								<label>Select Category</label>
								<select name="category_id" id="category_id" class="form-control select2" required>
									<option value="">Select </option>
									<?php
									foreach($categories as $category){?>
									<option value="<?php echo $category['id'];?>" <?php echo ($category['id'] == $main_category) ? "selected":"" ?>><?php echo $category['name'];?></option>
									<?php foreach($category['child'] as $child){?>
									<option value="<?php echo $child['id'];?>" <?php echo ($child['id'] == $main_category) ? "selected":"" ?>><?php echo $category['name'] . " > " . $child['name'];?></option>
									<?php foreach($child['child'] as $sub){?>
									<option value="<?php echo $sub['id'];?>" <?php echo ($sub['id'] == $main_category) ? "selected":"" ?>><?php echo $category['name'] . " > " . $child['name'] . " > " . $sub['name'];?></option>
									<?php }}}?>
								</select>
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<label class="control-label" for="first-name">Select brand </label>
								<select name="brand_id" id="brand_id" class="form-control select2" required onblur="checkField('brand_id')">
									<option value="">Select </option>
									<?php foreach($brand_list as $brand){?>
									<option value="<?php echo $brand->id;?>" <?php echo ($brand->id == $brand_id) ? "selected":"" ?>><?php echo $brand->brand_name;?></option>
									<?php } ?>
								</select>
							</div>
							<small>Select brand of your product</small><br/><br/>
						</div>
						<div class="col-12">
							<div class="form-group" style="min-height: 50px;">
								<label class="control-label" for="cod_available">COD Available</label>
								<div class="col-md-10 col-sm-12 col-xs-12 mb-3">
									<input type="checkbox" id="switch2" switch="bool" name="cod_available" <?php echo ($cod_available == '1') ? "checked":"" ?> />
									<label for="switch2" data-on-label="Yes" data-off-label="No"></label>
									<div><small>Switch ON, If cod available</small></div>
								</div>
							</div>
							<div class="form-group" style="min-height: 50px;">
								<label class="control-label" for="status">Product Status</label>
								<div class="col-md-10 col-sm-12 col-xs-12 mb-3">
									<input type="checkbox" id="switch1" switch="bool" name="status" <?php echo ($status == '1') ? "checked":"" ?> />
									<label for="switch1" data-on-label="Yes" data-off-label="No"></label>
									<div><small>Switch ON, If status active</small></div>
								</div>
							</div>
							<div class="form-group" style="min-height: 50px;">
								<label class="control-label" for="is_variation">Product Variation</label>
								<div class="col-md-10 col-sm-12 col-xs-12 mb-3">
									<input type="checkbox" id="switch3" switch="bool" name="is_variation" <?php echo ($is_variation == 'yes') ? "checked":"" ?> />
									<label for="switch3" data-on-label="Yes" data-off-label="No"></label>
									<div><small>Switch ON, If product has variation</small></div>
								</div>
							</div>
							<div class="form-group" style="min-height: 50px;">
								<label class="control-label" for="b2b_availability">B2B Available</label>
								<div class="col-md-10 col-sm-12 col-xs-12 mb-3">
									<input type="checkbox" id="switch4" switch="bool" name="b2b_availability" <?php echo ($b2b_availability == 'yes') ? "checked":"" ?> />
									<label for="switch4" data-on-label="Yes" data-off-label="No"></label>
									<div><small>Switch ON, If B2B available</small></div>
								</div>
							</div>
						</div>
						<div class="col-md-12" style="padding-top: 24px;">
							<button type="submit" class="btn btn-success btn-md float-end">Save Changes</button>
							<button type="button" onclick="window.location.href='<?php echo base_url(); ?>admin/product/add?id=<?php echo $id;?>'" class="btn btn-outline-danger btn-md float-end me-2">Cancel </button>
						</div>
					</div>
				</form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php $this->load->view('admin/home/footer');?>

<script>
$(document).ready(function () {
	//$("textarea.length-textarea").maxlength({alwaysShow:!0,warningClass:"badge bg-info",limitReachedClass:"badge bg-warning"});
	/*
    var clientid = $("#is_gift option:selected").attr("value");
    if (clientid == 1) {
        $("#g_value").removeClass("d-none");
    } else {
        $("#g_value").addClass("d-none");
    }
	*/
});

function deleteImg(name1,name2){
	if(confirm('Are you sure want to delete?')) {
		$('#'+name1).html('');
		$("."+name2).val('');
		//$("input[name='"+name2+"']").val('');
		return true;
	}else{
		return false;
	}
}

function deletePrev(thumb_id){
	if(confirm('Are you sure want to delete?')) {
		var thumb = document.getElementById(thumb_id);
		thumb.style.backgroundImage = '';
		$('#'+thumb_id).html('');
		$('#'+thumb_id).closest('.upload-options').find('input').val('');
		return true;
	}else{
		return false;
	}
}
	
function checkSKU() {
    var sku = $("#sku").val();
    if (sku !== "") {
        $.ajax({
            url: "<?php echo base_url();?>admin/product/checkSKU",
            type: "GET",
            data: "sku=" + $("#sku").val(),
            success: function (data) {
                $(".ajax-skucheck").html(data);
            },
            error: function () {},
        });
    } else {
        checkField("sku");
    }
}
/*
function checkSEO() {
    var seo_url = $("#seo").val();
    if (seo_url !== "") {
        //alert(seo_url);
        $.ajax({
            url: "<?php echo base_url();?>admin/product/checkSEO",
            type: "GET",
            data: "seo=" + seo_url,
            success: function (data) {
                //alert(data);
                $(".ajax-seocheck").html(data);
            },
            error: function () {},
        });
    } else {
        checkField("seo");
    }
}
*/
</script>
<script type="text/javascript">
	var attribute_row = <?php echo $attribute_row; ?>;

	function addAttribute() {
		html  = '<tr id="attribute-row' + attribute_row + '">';
		html += '  <td class="text-left" style="width: 20%;"><input type="text" name="attribute_name[]" value="" placeholder="Attribute English" class="form-control mb-1" /><input type="text" name="attribute_name_ar[]" value="" placeholder="Attribute Arabic" class="form-control rtl-input" /></td>';
		html += '  <td class="text-left">';
		html += '<textarea name="attribute_value[]" rows="5"  placeholder="Text English"  class="form-control mb-1"></textarea><textarea name="attribute_value_ar[]" rows="5"  placeholder="Text Arabic" class="form-control rtl-input"></textarea>';
		html += '  </td>';
		html += '  <td class="text-right"><button type="button" onclick="remove_attribute(' + attribute_row + ')" title="Remove" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></button></td>';
		html += '</tr>';

		$('#attribute tbody').append(html);
		attribute_row++;
	}

	function remove_attribute(u){
		$('#attribute-row'+u).remove();
	}

	var rating_row = <?php echo $rating_row; ?>;

	function addRating() {
		html  = '<tr id="rating-row' + rating_row + '">';
		html += '  <td class="text-left" style="width: 10%;"><input type="number" min="1" max="5" maxlength="1" name="rating[]" value="" placeholder="Rating" class="form-control" /></td>';
		html += '  <td class="text-left">';
		html += '<div class="input-group"><textarea name="review_text[]" rows="5" placeholder="Text" class="form-control"></textarea></div>';
		html += '  </td>';
		html += '  <td class="text-left" style="width: 20%;"><input type="text" name="rating_person[]" value="" placeholder="Person Name" class="form-control" /></td>';
		html += '  <td class="text-right"><button type="button" onclick="remove_rating(' + rating_row + ')" title="Remove" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></button></td>';
		html += '</tr>';

		$('#rating tbody').append(html);
		rating_row++;
	}

	function remove_rating(u){
		$('#rating-row'+u).remove();
	}
	/*
	$('input[name=\'sub_product\']').autocomplete({
		'source': function(request, response) {
			$.ajax({
				url: '<?php echo base_url()?>admin/product/get_product?term=' +  $('input[name=\'sub_product\']').val(),
				dataType: 'json',
				success: function(json) {
					response($.map(json, function(item) {
						return {
							label: item['name'],
							value: item['product_id']
						}
					}));
				}
			});
		},
		'select': function(event,ui) {
			$('#input-sub-product').val("");

			$('#sub-product' + ui.item.value).remove();

			$('#sub-product').append('<div id="sub-product' + ui.item.value + '"><i class="fa fa-minus-circle"></i> ' + ui.item.label + '<input type="hidden" name="sub-product[]" value="' + ui.item.value + '" /></div>');
		}
	});

	$('#sub-product').delegate('.fa-minus-circle', 'click', function() {
		$(this).parent().remove();
	});

	$(document).ready(function() {
		$('.summerNote').summernote({
			height: 200
		});
	});
	*/
	function checkField(u){
		var id = $("#"+u).val();
		if(id == ""){
			$("#"+u).addClass("alert_text");
		}
		else{
			$("#"+u).removeClass("alert_text");
		}
	}
</script>

<script>
	function initImageUpload(box) {
	  let uploadField = box.querySelector('.image-upload');

	  uploadField.addEventListener('change', getFile);

	  function getFile(e){
		let file = e.currentTarget.files[0];
		checkType(file);
	  }
	  
	  function previewImage(file){
		let thumb = box.querySelector('.js--image-preview'),
			reader = new FileReader();

		reader.onload = function() {
		  thumb.style.backgroundImage = 'url(' + reader.result + ')';
		  var thumb_id = $(thumb).attr('id')
		  //alert(thumb_id);
		  $(thumb).html('<div class="save-img-prev"><a onclick=\'deletePrev("'+thumb_id+'")\' class="btn btn-danger btn-img-delete"><i class="fas fa-trash"></i></a>')
		}
		reader.readAsDataURL(file);
		thumb.className += ' js--no-default';
	  }

	  function checkType(file){
		let imageType = /image.*/;
		if (!file.type.match(imageType)) {
		  throw 'File type not supported';
		} else if (!file){
		  throw 'Upload file';
		} else {
		  previewImage(file);
		}
	  }
	  
	}

	// initialize box-scope
	var boxes = document.querySelectorAll('.box');

	for (let i = 0; i < boxes.length; i++) {
	  let box = boxes[i];
	  initDropEffect(box);
	  initImageUpload(box);
	}

	/// drop-effect
	function initDropEffect(box){
	  let area, drop, areaWidth, areaHeight, maxDistance, dropWidth, dropHeight, x, y;
	  
	  // get clickable area for drop effect
	  area = box.querySelector('.js--image-preview');
	  area.addEventListener('click', fireRipple);
	  
	  function fireRipple(e){
		area = e.currentTarget
		// create drop
		if(!drop){
		  drop = document.createElement('span');
		  drop.className = 'drop';
		  this.appendChild(drop);
		}
		// reset animate class
		drop.className = 'drop';
		
		// calculate dimensions of area (longest side)
		areaWidth = getComputedStyle(this, null).getPropertyValue("width");
		areaHeight = getComputedStyle(this, null).getPropertyValue("height");
		maxDistance = Math.max(parseInt(areaWidth, 10), parseInt(areaHeight, 10));

		// set drop dimensions to fill area
		drop.style.width = maxDistance + 'px';
		drop.style.height = maxDistance + 'px';
		
		// calculate dimensions of drop
		dropWidth = getComputedStyle(this, null).getPropertyValue("width");
		dropHeight = getComputedStyle(this, null).getPropertyValue("height");
		
		// calculate relative coordinates of click
		// logic: click coordinates relative to page - parent's position relative to page - half of self height/width to make it controllable from the center
		x = e.pageX - this.offsetLeft - (parseInt(dropWidth, 10)/2);
		y = e.pageY - this.offsetTop - (parseInt(dropHeight, 10)/2) - 30;
		
		// position drop and animate
		drop.style.top = y + 'px';
		drop.style.left = x + 'px';
		drop.className += ' animate';
		e.stopPropagation();
		
	  }
	}
</script>
<script>
//define template
var template = $("#size_sections .size-inner-section:first").clone();

//define counter
var sectionsCount = 1;

//add new section
$("body").on("click", ".addsection", function () {
    //increment
    sectionsCount++;

    //loop through each input
    var section = template
        .clone()
        .find(":input").val("")
        .each(function () {
            //set id to store the updated section number
            var newId = this.id + sectionsCount;
			//alert(newId);
            //update for label
            $(this).prev().attr("for", newId);
            //$(this).prev().val('1');
            //$(this).find('input[name="product_sku"]').prev().val('');
			//$('#'+newId+ ' input[name="product_sku"]').prev().val(newId);
			//alert($('#2 input[name="product_sku[]"]').prev().val());
			//$('#'.newId).val(<?= $parent_sku .'-'; ?>newId);
			//$(this).prev().attr("data-id",newId);
			//$(this).attr("data-id",newId);
            //update id
            this.id = newId;
        })
        .end()
        //inject new section
        .appendTo("#size_sections");
    return false;
});

//remove section
$("#size_sections").on("click", ".remove", function () {
	var size_id = $(this).parent().parent().parent().find('input[name="size_id[]"]').val();
	//alert(size_id);
	if(confirm('Are you sure want to delete?')) {
		if(size_id > 0){
			$.ajax({
				url: "<?php echo base_url();?>admin/product/delete-size",
				type: "POST",
				data: {
					id: size_id
				},
				dataType: "json",
				success: function (data) {
					if(data.type == 'success'){
						Swal.fire({
							icon: 'success',
							title: 'Success',
							text: data.message,
  							timer: 1500
						});
					}else{
						Swal.fire({
							icon: 'error',
							title: 'Error',
							text: data.message,
							timer: 1500
						});
					}
				},
				error: function (data) {
					console.log(data);
				},
			});
			//fade out section
			$(this).parent().fadeOut(300, function () {
				//remove parent element (main section)
				$(this).parent().parent().empty();
				return false;
			});
		}else{
			//fade out section
			$(this).parent().fadeOut(300, function () {
				//remove parent element (main section)
				$(this).parent().parent().empty();
				return false;
			});
		}
	}else{
		return false;
	}
    return false;
});

/*----------- Rack and Shelf ------------*/
$(document).ready(function() {
	//getShelf();
});

function rackChange(sel){
	var selectedRack = sel.value;
	var rack_id = $(sel).attr("id");
	//alert( rack_id );
	$.ajax({
		url: "<?php echo base_url()?>admin/Product/getShelf",
		data: { "id": selectedRack },
		//dataType:"html",
		type: "post",
		success: function(data){
			var prod_shelf = rack_id.replace('prod_rack','prod_shelf');
			//alert('#'+prod_shelf);
			$('#'+prod_shelf).html(data);
		}
	});
}
/*
function getShelf(){
	//var selectedRack = $("#prod_rack option:selected").val();
	var selectedRack = $(this).find('input[name="prod_rack"]').val();
	var shelfID = '';
	alert(selectedRack);
	if(shelfID > 0){
		$.ajax({
			url: "<?php echo base_url()?>admin/Product/selectedShelf",
			data: { "id": selectedRack, "shelf_id": shelfID },
			//dataType:"html",
			type: "post",
			success: function(data){
				//alert(data);
				$('#prod_shelf').html(data);
			}
		});
	}
}
*/
</script>
