<div class="modal-header">
	<h5 class="modal-title" id="staticBackdropLabel">Inventory Detail</h5>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="pb-3"><?php echo !empty($quick_detail->image) ? '<div class="product-desc"><img class="avatar-sm" src="'.base_url().$quick_detail->image.'" width="80px" /> <span class="ms-2">'.$quick_detail->name.'<br><pre>'. $quick_detail->name_ar .'</pre>'.'</span></div>' : '<div class="product-desc"><img class="avatar-sm" src="'.base_url().'images/notfound.jpg" width="80px" /> <span class="ms-2">'.$quick_detail->name.'<br><pre>'. $quick_detail->name_ar .'</pre></span></div>';?></div>
        </div>
        <div class="col-md-12">
            <table class="table border" border="1">
                <tr>
                    <td width="50%"><h6>SKU: <span class="text-dark"><?php echo $quick_detail->parent_sku.'-'.$quick_detail->product_sku;?></span></h6></td>
                    <td width="50%"><h6>Barcode: <?php echo $quick_detail->barcode;?></h6></td>
                </tr>
                <tr>
                    <td width="50%"><h6>Size: <?php echo $quick_detail->size .' '. $quick_detail->unit_name;?></h6></td>
                    <td width="50%"><h6>Quantity: <?php echo $quick_detail->quantity;?> <?php echo $quick_detail->quantity > 0 ? '<span class="badge badge-pill badge-soft-success font-size-13">In Stock</span>':'<span class="badge badge-pill badge-soft-danger font-size-13">Out of Stock</span>';?></h6></td>
                </tr>
                <tr>
                    <td width="50%"><h6>Rack: <?php echo getRackName($quick_detail->rack_id);?></h6></td>
                    <td width="50%"><h6>Shelf: <?php echo getShelfName($quick_detail->shelves_id);?></h6></td>
                </tr>
                <tr>
                    <td width="50%"><h6>Brand: <?php echo getBrandName($quick_detail->brand_id);?></h6></td>
                    <td width="50%"><h6>Category: <?php echo getCategoryName($quick_detail->main_category);?></h6></td>
                </tr>
                <tr>
                    <td width="50%"><h6>Status: <?php echo $quick_detail->status == 1 ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>':'<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';?></h6></td>
                    <td width="50%"><h6></h6></td>
                </tr>
                <tr>
                    <td width="50%"><h6>Added Date: <br><?php echo date('d-m-Y h:i A', strtotime($quick_detail->created_at));?></h6></td>
                    <td width="50%"><h6>Updated Date: <br><?php echo (!empty($quick_detail->updated_at)) ? date('d-m-Y h i:A', strtotime($quick_detail->updated_at)) : 'NA';?></h6></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Cancel</button>
</div>