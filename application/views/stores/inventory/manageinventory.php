<?php $this->load->view('stores/layout/header');?>
<div class="main-content">
    <div class="page-content">
        <!-- start page title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="page-title">
							<h4>Manage Inventory</h4>
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
								<li class="breadcrumb-item"><a href="javascript: void(0);">Manage Inventory</a></li>
								<li class="breadcrumb-item active">Product List</li>
							</ol>
						</div>
                    </div>
					<div class="col-sm-6">
					    <div class="flash-message">
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
    					<div class="float-end d-none d-sm-block">
    					    <div class="btn-group me-1">
        						<button class="btn btn-custom-danger btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        							Bulk Action <i class="mdi mdi-chevron-down"></i>
        						</button>
        						<div class="dropdown-menu">
        							<div class="dropdown-divider"></div>
        							<a class="dropdown-item" onclick="EnableStatus()" href="javascript:;">Activate Product</a>
        							<div class="dropdown-divider"></div>
        							<a class="dropdown-item" onclick="DisableStatus()" href="javascript:;">Deactivate Product</a>
        							<div class="dropdown-divider"></div>
        						</div>
        					</div>
        					<a class="btn btn-custom-success btn-sm pull-right" title="Add" href="<?php echo base_url('store/inventory')?>" target="_blank"><i class="fa fa-plus"></i> Add New Product</a>
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
							<h4 class="header-title mb-0">Search</h4>
						</div>
						<div class="card-body">
							<form action="<?php echo base_url('store/inventory/manage-inventory');?>" method="get" id="filter_form">
								<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Search Keywords</label>
										<input type="text" id="keyword" name="keyword" placeholder="Enter name or SKU" value="<?php if(!empty($searchingdata)){ echo $searchingdata['0'];}?>" autocomplete="off" class="form-control">
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Barcode</label>
										<input type="text" id="barcode" name="barcode" placeholder="Enter product barcode" value="<?php if(!empty($searchingdata)){ echo $searchingdata['1'];}?>" autocomplete="off" class="form-control">
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-12">
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
								<div class="collapse" id="advanceFilter" style="">
									<div class="row">
										<div class="col-lg-4 col-md-4 col-sm-12">
											<div class="form-group mb-2">
    											<label class="control-label" for="brand">Select Brand </label>
    											<select style="height:410px;" name="brand" id="brand" class="form-control select2">
    												<option value="">[Any Brand]</option>
    												<?php foreach($brand_list as $brand){?>
    												<option value="<?php echo $brand->id;?>" <?php echo ($this->input->get('brand') == $brand->id) ? 'selected':'';?>><?php echo $brand->brand_name;?></option>
    												<?php } ?>
    											</select>
											</div>
										</div>
									    <div class="col-lg-4 col-md-4 col-sm-12">
											<div class="form-group mb-2">
												<label>Date Between (From and To)</label>
												<div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
													<input type="text" class="form-control" id="_from" name="from" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" autocomplete="off" placeholder="Start Date" />
													<input type="text" class="form-control" id="_to" name="to" value="<?php echo $this->input->get('to') ? $this->input->get('to') : ''; ?>" autocomplete="off" placeholder="End Date" />
												</div>
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-12">
											<div class="form-group mb-2">
												<label class="d-block">Select Status </label>
												<select style="height:410px;" name="status" class="form-control select2 w-100">
													<option value="">[Any Status]</option>
													<option value="yes" <?php echo ($this->input->get('status') == 'yes') ? 'selected':'';?>>Active</option>
													<option value="no" <?php echo ($this->input->get('status') == 'no') ? 'selected':'';?>>Inactive</option>
												</select>
											</div>
										</div>
									</div>
								</div>
								</div>
								<div class="row mt-2">
    								<div class="col-lg-6 col-md-6 col-sm-12">
    									<button class="btn btn-outline-secondary waves-effect waves-light" type="button" data-bs-toggle="collapse" data-bs-target="#advanceFilter" aria-expanded="true" aria-controls="advanceFilter"><i class="fas fa-sliders-h"></i> Advance Search</button>
    								</div>
    								<div class="col-lg-6 col-md-6 col-sm-12">
    									<button type="submit" class="btn btn-success btn-md float-end ms-2">Apply Filter</button>
    									<a href="<?php echo base_url('store/inventory/manage-inventory');?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
    								</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-body">
								<form id="myform" name="myform" method="post" action="">
									<table id="storeInventory" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
										<thead>
											<tr style="background-color:#74788d !important; color: white;">
												<th align="center">#</th>
												<th align="center">S.NO</th>
												<th align="left">PRODUCT SKU</th>
												<th align="left">BARCODE</th>
												<th class="text-center">PRODUCT DESCRIPTION</th>
												<th align="left">SIZE</th>
												<th align="left">QTY</th>
												<th align="left">RACK</th>
												<th align="left">SHELF</th>
												<th align="left">STATUS</th>
												<th align="left">DATE ADDED</th>
												<th class="text-center">ACTION</th>
											</tr>
										</thead>
					
										<tbody>
										
										</tbody>
									</table>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade inventoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="inventoryModalContent">
			
		</div>
	</div>
</div>
<?php $this->load->view('stores/layout/footer');?>

<script type="text/javascript">
	function editProduct(id) {
		if (id > 0) {
			$.ajax({
				type: "post",
				url: "<?php echo base_url('store/inventory/update-inventory'); ?>",
				data: {
					'id': id,
				},
				//dataType: "json",
				success: function(response) {
					//console.log(response);
					$('.inventoryModal').modal('show');
					$('#inventoryModalContent').html(response);
				},
				error: function(request, error) {
					//console.log(" Can't do because: " + JSON.stringify(request));
					$('#inventoryModalContent').after(JSON.stringify(request));
				},
			});
		} else {
			alert('Invalid request id!');
		}
	}
	
	function stockUpdate(id) {
		if (id > 0) {
			$.ajax({
				type: "post",
				url: "<?php echo base_url('store/inventory/update-stock'); ?>",
				data: {
					'id': id,
				},
				//dataType: "json",
				success: function(response) {
					//console.log(response);
					$('.inventoryModal').modal('show');
					$('#inventoryModalContent').html(response);
				},
				error: function(request, error) {
					//console.log(" Can't do because: " + JSON.stringify(request));
					$('#inventoryModalContent').after(JSON.stringify(request));
				},
			});
		} else {
			alert('Invalid request id!');
		}
	}
	
	function productDetail(id) {
		if (id > 0) {
			$.ajax({
				type: "post",
				url: "<?php echo base_url('store/inventory/inventory-detail'); ?>",
				data: {
					'id': id,
				},
				//dataType: "json",
				success: function(response) {
					//console.log(response);
					$('.inventoryModal').modal('show');
					$('#inventoryModalContent').html(response);
				},
				error: function(request, error) {
					//console.log(" Can't do because: " + JSON.stringify(request));
					$('#inventoryModalContent').after(JSON.stringify(request));
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
    
    function selectedShelf(sel){
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
	
	$(document).ready(function() {
    	$('#storeInventory').dataTable({
    		"lengthMenu": [[25, 50, 100, 500], [25, 50, 100, 500]],
    		//order: [[0, 'asc']],
    		dom: 'Blfrtip',
    		buttons: [
    			{
    				extend: "csv",
    				className: "btn-md"
    			},
    			{
    				extend: "excel",
    				className: "btn-md"
    			},
    			{
    				extend: "pdfHtml5",
    				className: "btn-md"
    			},
    			{
    				extend: "print",
    				className: "btn-md"
    			},
    		],
    
    		"responsive": true,
    		"processing":true,
    		"serverSide":true,
    		"fixedHeader": true,
			"searching": true,
    		"ajax":{
    			url:"<?php echo base_url();?>store/inventory/store-products?keyword=<?php echo $this->input->get('keyword')?>&barcode=<?php echo $this->input->get('barcode')?>&category_id=<?php echo $this->input->get('category_id')?>&brand=<?php echo $this->input->get('brand')?>&from=<?php echo $this->input->get('from')?>&to=<?php echo $this->input->get('to')?>&status=<?php echo $this->input->get('status')?>",
    			type:"POST"
    		},
    		"columnDefs":[
    			{
    			 "targets":[0,1,2,3,4,5,6,7,8,9,10,11],
    			 "orderable":false
    			},
    		],
    	});
    	
    });
    
    var EnableStatus = function () {
		var inputCount = $('[name="check_list[]"]:checked').length;
		if (inputCount > 0) {
			if (confirm("Do you want to enable selected product?") == true) {
				changeActionAndSubmit("store/inventory/activate-product");
			} else {
				userPreference = "Action Cancelled!";
			}
		} else {
			alert("Plese select check box first");
		}
	};

	function DisableStatus() {
		var inputCount = $('[name="check_list[]"]:checked').length;
		if (inputCount > 0) {
			if (confirm("Do you want to disable selected product?") == true) {
				changeActionAndSubmit("store/inventory/deactivate-product");
			} else {
				userPreference = "Action Cancelled!";
			}
		} else {
			alert("Plese select check box first");
		}
	}

	function changeActionAndSubmit(action) {
		document.getElementById("myform").action = action;
		document.getElementById("myform").submit();
	}
</script>
