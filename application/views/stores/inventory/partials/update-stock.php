<div class="modal-header">
	<h5 class="modal-title" id="staticBackdropLabel">Update Inventory Stock</h5>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form action="<?php echo base_url('store/inventory/save-edited-stock');?>" method="post" id="form-add">
    <div class="modal-body">
        <div class="pb-3"><?php echo !empty($quick_detail->image) ? '<div class="product-desc"><img class="avatar-sm" src="'.base_url().$quick_detail->image.'" width="80px" /> <span class="ms-2">'.$quick_detail->name.'<br><pre>'. $quick_detail->name_ar .'</pre>'.'</span></div>' : '<div class="product-desc"><img class="avatar-sm" src="'.base_url().'images/notfound.jpg" width="80px" /> <span class="ms-2">'.$quick_detail->name.'<br><pre>'. $quick_detail->name_ar .'</pre></span></div>';?></div>
    	<input type="hidden" value="<?php echo $quick_detail->id;?>" id="inv_id" name="inv_id" required>
    	<div class="col-md-12 col-sm-12 col-xs-12 mb-3">
    		<label>Quantity<span class="text-danger">*</span></label>
    		<div>
    			<input class="form-control" required type="text range" min="1"max="10000" name="quantity" placeholder="Number between 1 - 10000" oninput="filterNonNumeric(this)"/>
    		</div>
    	</div>
		<div class="col-md-12 col-sm-12 col-xs-12 mb-3">
			<div class="form-group">
				<label class="control-label" for="stock_type">Stock Type<span class="text-danger">*</span></label>
				<select id="stock_type" name="stock_type" class="form-control form-select" required>
					<option value="">Select Type</option>
					<option value="in">Stock In</option>
					<option value="out" >Stock Out</option>
				</select>
			</div>
		</div>
		<div class="form-group col-lg-12 col-md-12 col-12 mb-3">
            <label for="remarks">Remarks (Optional)</label>
            <input type="text" class="form-control" name="remarks" placeholder="Remarks" autocomplete="off">
        </div>
    </div>
    <div class="modal-footer">
    	<button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Cancel</button>
    	<button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
    </div>
</form>