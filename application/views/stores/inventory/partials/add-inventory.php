<div class="modal-header">
	<h5 class="modal-title" id="staticBackdropLabel">Add Product In Store</h5>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form action="<?php echo base_url('store/inventory/add-product');?>" method="post" id="form-add">
    <div class="modal-body">
        <div class="pb-3"><?php echo !empty($quick_detail->image) ? '<div class="product-desc"><img class="avatar-sm" src="'.base_url().$quick_detail->image.'" width="80px" /> <span class="ms-2">'.$quick_detail->name.'<br><pre>'. $quick_detail->name_ar .'</pre>'.'</span></div>' : '<div class="product-desc"><img class="avatar-sm" src="'.base_url().'images/notfound.jpg" width="80px" /> <span class="ms-2">'.$quick_detail->name.'<br><pre>'. $quick_detail->name_ar .'</pre></span></div>';?></div>
    	<input type="hidden" value="<?php echo $quick_detail->size_id;?>" id="productid" name="id" required>
    	<div class="col-md-12 col-sm-12 col-xs-12 mb-3">
    		<label>Unit Quantity</label>
    		<div>
    			<input class="form-control" required type="text range" min="1"max="10000" name="quantity" placeholder="Number between 1 - 10000" oninput="filterNonNumeric(this)"/>
    		</div>
    	</div>
    	<div class="col-md-12 col-sm-12 col-xs-12 mb-3">
			<div class="form-group">
				<label class="control-label" for="prod_rack">Select Product Rack</label>
				<select id="prod_rack" name="rack_id" onChange="rackChange(this);" class="form-control select2">
					<option value="">Select Rack</option>
					<?php foreach($racks as $rack){ ?>
					<option value="<?php echo $rack['id'];?>"><?php echo $rack['rack_name'];?></option>
					<?php } ?>
				</select>
			</div>
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12 mb-3">
			<div class="form-group">
				<label class="control-label" for="prod_shelf">Select Product Shelf</label>
				<select id="prod_shelf" name="shelf_id" class="form-control">
					<option value="">----- Select Rack First -------</option>
				</select>
			</div>
		</div>
    </div>
    <div class="modal-footer">
    	<button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Cancel</button>
    	<button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
    </div>
</form>