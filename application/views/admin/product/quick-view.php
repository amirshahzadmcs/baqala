<div class="row">
    <div class="col-12">
        <div class="panel panel-default">
            <div class="row p-2">
				<div class="col-md-12"><h6 class="panel-title font-size-14">Product Name - <?php echo $name;?></h6></div>
				<div class="col-md-12"><h6 class="panel-title font-size-14">Product ID - <?php echo $prod_id;?></h6></div>
				<div class="col-md-12"><h6 class="panel-title font-size-14">Product SKU - <?php echo $parent_sku;?></h6></div><hr/>
            </div>
            <div class="row">
				<div class="col-md-12">
					<h4 class="header-title ms-2">Size And Price</h4>
					<p class="card-title-desc ms-2 mb-1">Update variations for this product.</p>
					<form id="demo-form2" method="post" action="<?php echo base_url()?>admin/product/update_size" class="form-horizontal form-label-left" data-toggle="validator" role="form">
						<input type="hidden" name="product_id" value="<?php echo $prod_id;?>" />
						<div id="size_sections">
							<?php if(!empty($product_size)){ ?>
							<?php foreach($product_size as $psize){?>
							<input type="hidden" name="size_id[]" value="<?php echo $psize->id;?>" />
							<div class="size-inner-section">
								<div class="row p-3">
									<!--
									<div class="col-md-3 col-sm-6 col-xs-12 mb-3">
										<div class="form-group">
											<label class="control-label" for="size">Size English</label>
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
											<label class="control-label" for="size_unit">Size Unit English</label>
											<select style="height:410px;" id="size_unit" name="size_unit[]" class="form-control">
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
									-->
									<div class="col mb-3">
										<div class="form-group">
											<label class="control-label">Product Price</label>
											<input type="number" name="price[]" min="0" step="any" value="<?php echo $psize->price;?>" class="form-control">
										</div>
									</div>
									
									<div class="col mb-3">
										<div class="form-group">
											<label class="control-label">Discounted Price</label>
											<input type="number" name="discounted_price[]" value="<?php echo $psize->discounted_price;?>" min="0" step="any" class="form-control">
										</div>
									</div>
									
									<div class="col mb-3">
										<div class="form-group">
											<label class="control-label">Discount Expiry</label>
											<input type="date" name="disc_expiry[]" value="<?php echo $psize->disc_expiry;?>" class="form-control">
										</div>
									</div>
									
									<div class="col mb-3">
										<div class="form-group">
											<label class="control-label">Cashback</label>
											<input type="number" name="cashback[]" value="<?php echo $psize->cashback;?>" min="0" step="any" class="form-control">
										</div>
									</div>
									
									<div class="col mb-3">
										<div class="form-group">
											<label class="control-label">Cashback Expiry</label>
											<input type="date" name="cashback_expiry[]" value="<?php echo $psize->cashback_expiry;?>" class="form-control">
										</div>
									</div>
									<!--
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
											<select style="height:410px;" id="prod_rack<?= $psize->id; ?>" onChange="rackChange(this);" name="rack_id[]" class="form-control">
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
											<select style="height:410px;" id="prod_shelf<?= $psize->id; ?>" name="shelf_id[]" class="form-control">
												<option value="">----- Select Rack First -------</option>
												<?php foreach($shelfs as $shelf){ ?>
												<?php if($shelf['id'] == $psize->shelf){?>
												<option value="<?php echo $shelf['id'];?>" <?php echo ($shelf['id'] == $psize->shelf) ? "selected":"" ?>><?php echo $shelf['shelf_name'];?></option>
												<?php }} ?>
											</select>
										</div>
									</div>
									-->
								</div>
							</div>
							<hr>
							<?php }}else{ ?>
							<p class="text-center">No Variation found</p>
							<?php } ?>
						</div>
						<button type="submit" class="btn btn-success float-end"> Update Price</button>
					</form>
					
				</div>
            </div>
        </div>
    </div>
</div> <!-- end row -->
