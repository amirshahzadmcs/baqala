<?php $this->load->view('stores/layout/header');?>
<div class="main-content">
    <div class="page-content">
        <!-- start page title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="page-title">
							<h4>Add Inventory</h4>
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
								<li class="breadcrumb-item"><a href="<?php echo base_url('store/inventory');?>">Inventory</a></li>
								<li class="breadcrumb-item active">Add</li>
							</ol>
						</div>
                    </div>
					<div class="col-sm-6">
					    <div>
							<?php if($this->store->getInfo()){ 
							$info = explode("--", $this->store->getInfo());
							$info_type = $info[0];
							$msg_data = $info[1];
							if($info_type == 2){
							?>  
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								<strong>Error!</strong>  <?php echo $msg_data; ?>
							</div>
							<?php } else{?>
							<div class="alert alert-success alert-dismissible fade show" role="alert">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								<strong>Success!</strong>  <?php echo $msg_data; ?>
							</div>
							<?php } } $this->store->removeInfo();?>
						</div>
					</div>
                </div>
            </div>
        </div>
        <!-- end page title -->
	
        <div class="container-fluid">
            <div class="page-content-wrapper">
				
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h4 class="header-title mb-0">Search Product</h4>
					</div>
					<div class="card-body">
						<form action="<?php echo base_url('store/inventory');?>" method="get" id="filter_form">
							<div class="row">
    							<div class="col-lg-3 col-md-3 col-sm-12">
    								<div class="form-group mb-2">
    									<label>Search By Name</label>
    									<input type="text" id="keyword" name="keyword" placeholder="Enter name or code" value="<?php echo $this->input->get('keyword');?>" autocomplete="off" class="form-control">
    								</div>
    							</div>
    							<div class="col-lg-3 col-md-3 col-sm-12">
    								<div class="form-group mb-2">
    									<label>Barcode</label>
    									<input type="text" id="barcode" name="barcode" placeholder="Enter product barcode" value="<?php echo $this->input->get('barcode');?>" autocomplete="off" class="form-control">
    								</div>
    							</div>
    							<div class="col-lg-3 col-md-3 col-sm-12">
    								<div class="form-group mb-2">
    									<label>Select Category</label>
    									<select class="form-control show-tick select2" name="category_id" id="category_id">
											<option value="">[Any Category]</option>
											<?php foreach($categories as $category){?>
											<option value="<?php echo $category['id'];?>" <?php echo ($this->input->get('category_id') == $category['id']) ? 'selected':'';?>><?php echo $category['name'];?></option>
											<?php foreach($category['child'] as $child){ ?>
											<option value="<?php echo $child['id'];?>" <?php echo ($this->input->get('category_id') == $child['id']) ? 'selected':'';?>><?php echo $category['name'] . " >" . $child['name'];?></option>
											<?php foreach($child['child'] as $sub){ ?>
											<option value="<?php echo $sub['id'];?>" <?php echo ($this->input->get('category_id') == $sub['id']) ? 'selected':'';?>><?php echo $category['name'] . " >" . $child['name'] . " > " . $sub['name'];?></option>
											<?php }}}?>
										</select>
    								</div>
    							</div>
    							<div class="col-lg-3 col-md-3 col-sm-12">
									<div class="form-group mb-2">
    									<label class="control-label" for="brand">Select brand </label>
    									<select style="height:410px;" name="brand" id="brand" class="form-control select2">
    										<option value="">[Any Brand]</option>
    										<?php foreach($brand_list as $brand){?>
    										<option value="<?php echo $brand->id;?>" <?php echo ($this->input->get('brand') == $brand->id) ? 'selected':'';?>><?php echo $brand->brand_name;?></option>
    										<?php } ?>
    									</select>
									</div>
								</div>
    						</div>
							<div class="row mt-2">
    							<div class="col-lg-6 col-md-6 col-sm-12">
    								
    							</div>
    							<div class="col-lg-6 col-md-6 col-sm-12">
    								<button type="submit" class="btn btn-success btn-md float-end ms-2">Apply Filter</button>
    								<a href="<?php echo base_url('store/inventory');?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
    							</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="card">
					    <?php if(!empty($this->input->get('keyword')) || !empty($this->input->get('category_id')) || !empty( $this->input->get('brand')) || !empty($this->input->get('brand'))){ ?>
					    <h6 class="px-4 pt-4">Total <?php echo count((array)$productlist);?> Products Found.</h6>
					    <?php if(!empty($productlist)){ ?>
						<div class="card-body">
							<div class="table-responsive">

    							<table id="" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    								<thead style="background-color:#74788d; color: white;">
        								<tr>
        									<th width="4%" align="center">S.NO</th>
        									<th width="10%" align="left">PRODUCT SKU</th>
        									<th width="12%" align="left">BARCODE</th>
        									<th width="54%" class="text-center">PRODUCT DESCRIPTION</th>
        									<th width="10%" align="left">SIZE</th>
        									<th width="10%" class="text-center">ACTION</th>
        								</tr>
    								</thead>
    								<tbody id="storelist">
    								<?php
    								$i=1;
    								foreach($productlist as $storeproduct){ 
    								?>
    								<tr >
    									<td style="text-align:left;"><?php echo $i;?></td>
    									<td><?php echo $storeproduct->parent_sku.'-'.$storeproduct->product_sku;?></td>
										<td><?php echo $storeproduct->barcode; ?></td>
    									<td><?php echo !empty($storeproduct->image) ? '<div class="product-desc"><a class="image-popup-vertical-fit" href="'.$storeproduct->image.'" title="'.$storeproduct->name.'"><img class="avatar-sm" src="'.base_url().$storeproduct->image.'" width="80px" /></a> <span class="ms-2 w-100">'.$storeproduct->name.'<br><pre>'. $storeproduct->name_ar .'</pre>'.'</span></div>' : '<div class="product-desc"><img class="avatar-sm" src="'.base_url().'images/notfound.jpg" width="80px" /> <span class="ms-2 w-100">'.$storeproduct->name.'<br><pre>'. $storeproduct->name_ar .'</pre></span></div>';?></td>
    									<td  style="text-align:left;"><strong><?php echo $storeproduct->size .' '. $storeproduct->unit_name; ?></strong></td>
    									<td style="text-align:center;">
										<?php
										$account=getstock($storeproduct->product_id);
										if(!empty($account)){
										?>
										<button type="button" class="btn btn-danger btn-sm waves-effect waves-light" disabled>Added</button>
										<?php } else { ?>
    									<button type="button" class="btn btn-success btn-sm waves-effect waves-light" onclick="addproduct('<?php echo $storeproduct->size_id;?>')">Add To Store</button>
    									<?php } ?>
    									</td>
    									
    								</tr>
    								<?php $i++;  } ?>
    								</tbody>
    							</table>
							</div>
						</div>
						<?php }else{ ?>
						<div class="card-body"><h5 class="text-center">No Product Found, Try with another filter.</h5></div>
						<?php } ?>
						<?php }else{ ?>
						<div class="card-body"><h5 class="text-center">Search product to add in your store.</h5></div>
						<?php } ?>
					</div>
				</div> <!-- end col -->
			</div> <!-- end row -->
		</div>
	</div>
</div>
</div>

<!-- Modal -->
<div class="modal fade addProductModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="productModalContent">
			
		</div>
	</div>
</div>
<?php $this->load->view('stores/layout/footer');?>

<script type="text/javascript">

    function addproduct(id) {
		if (id > 0) {
			$.ajax({
				type: "post",
				url: "<?php echo base_url('store/inventory/add-product-modal'); ?>",
				data: {
					'id': id,
				},
				//dataType: "json",
				success: function(response) {
					//console.log(response);
					$('.addProductModal').modal('show');
					$('#productModalContent').html(response);
				},
				error: function(request, error) {
					//console.log(" Can't do because: " + JSON.stringify(request));
					$('#productModalContent').after(JSON.stringify(request));
				},
			});
		} else {
			alert('Invalid request id!');
		}
	}
	
	function filterNonNumeric(input) {
        // Remove non-numeric characters from the input value
        input.value = input.value.replace(/[^0-9]/g, '');
    }
    
    function rackChange(sel){
    	var selectedRack = sel.value;
    	var rack_id = $(sel).attr("id");
    	//alert( rack_id );
    	$.ajax({
    		url: "<?php echo base_url()?>store/InventoryController/getShelf",
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
</script>
