<?php if($result){ ?>
<?php echo form_open('admin/quotation/add_product_to_order', array("id"=>"editForm")); ?>
	<table id="size" class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<td colspan="1"><img src="<?php echo base_url($result->image);?>" width="100px" /></td>
				<td colspan="5">
					<b>Name</b>: <?php echo $result->name;?> ( <?php echo $result->name_hindi;?> )<br/>
					<b>SKU</b>: <?php echo $result->sku;?><br>
					<b>URL</b>: <a href="<?php echo $result->seo;?>"<?php echo $result->seo;?></a>
				</td>
			</tr>
			<tr>
				<td class="text-left">Size</td>
				<td class="text-left">Quantity (Avl. Qty <?php echo $result->quantity;?>)</td>
				<td class="text-left">Price</td>
				<td class="text-left">Discounted Price</td>
				<td class="text-left">Cashback</td>
				<td class="text-left">Barcode</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="text-left">
					<div class="input-group">
						<input type="hidden" name="order_id" value="<?php echo $this->input->get('oid');?>" required />
						<input type="hidden" name="product_id" value="<?php echo $result->id;?>" required />
						<input type="hidden" name="size_id" value="<?php echo $result->size_id;?>" required />
						<input type="text" name="size" placeholder="Size" class="form-control" value="<?php echo $result->size;?>" required readonly="readonly" />
					</div>
				</td>

				<td class="text-left">
					<div class="input-group">
						<input type="text" name="quantity" placeholder="Quantity" class="form-control" value="1" required />
					</div>
				</td>

				<td class="text-left">
					<div class="input-group">
						<input type="text" name="price" placeholder="Price" class="form-control" value="<?php echo $result->price;?>" required readonly="readonly" />
					</div>
				</td>

				<td class="text-left">
					<div class="input-group">
						<input type="text" name="discounted_price" placeholder="Discounted Price" class="form-control" value="<?php echo $result->discounted_price;?>" required readonly="readonly" />
					</div>
				</td>

				<td class="text-left">
					<div class="input-group">
						<input type="text" name="cashback" placeholder="Cashback" value="<?php echo $result->cashback;?>" class="form-control" required readonly="readonly">
					</div>
				</td>

				<td class="text-left">
					<div class="input-group">
						<input type="text" name="barcode" placeholder="barcode" value="<?php echo $result->barcode;?>" class="form-control" readonly="readonly">
					</div>
				</td>

			</tr>
			<tr>
				<td colspan="6">
					<button type="submit" class="btn btn-sm btn-info pull-right"  data-toggle="tooltip" title="Save"><i class="fa fa-save"></i> Add to order</button>
				</td>
			</tr>
		</tbody>
	</table>
<?php echo form_close();?>
<?php }else{ ?>
	<div><h4>No Result Found</h4></div>
<?php } ?>