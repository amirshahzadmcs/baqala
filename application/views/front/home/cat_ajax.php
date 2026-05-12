<?php if(count($results) > 0){ ?>
	<div class="toolbox-info"><?php echo $this->lang->line('msg_showing') ?> <span id="prod_count"><?php echo count($results); ?></span><span> <?php echo $this->lang->line('msg_of') .' '. $product_count;?></span> <?php echo $this->lang->line('msg_product') ?></div>
	<div id="product_div">	
		<?php foreach($results as $result){?>
		<div class="row product-ct products_details">
			<div class="col-lg-1 col-md-1 col-sm-12 bd-r">
				<div class="product_item_img">
					<img src="<?php echo ($result['image'] == "" OR !file_exists($result['image'])) ? 'assets/image/no-image.jpg':$this->customer->getResizeImage($result['image'],200,200); ?>" class="img-fluid" />
				</div>
			</div>
			<div class="col-lg-11 col-md-11 col-sm-12 px-0">
				<table class="border-none item_table" width="100%">
					<thead>
						<tr>
							<td colspan="4">
								<div class="product_item_title cm-pd">
									<a href="<?php echo base_url('product/'.$result['size_id']);?>"> <?= $result['name'];?> <span> <?= $result['name_arabic']; ?></span> <span class="chevron-right float-end"><i class="fa fa-chevron-right"></i></span> </a>
								</div>
							</td>
						</tr>
						<tr class="table-heading">
							<th class="sku cm-pd" width="75%">
								<span class="code">Code</span>
							</th>
							<th class="stock-status-column cm-pd text-center" width="20%">Size</th>
							<th class="input cm-pd text-center" width="5%">Qty.</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="sku cm-pd">
								<span class="mobile-only"><strong></strong></span><?= $result['parent_sku'];?>-<?= $result['sku'];?> <span class="sku-divider">/</span> <?= $result['barcode'];?>
							</td>
							<td class="stock-status-column cm-pd text-center"><span class="stock-status sold-out"><?= $result['size'];?> <?= $result['unit_name'];?></span></td>
							<td class="qty-title cm-pd">
							<input type="number" min="1" id="s_<?= $result['size_id'];?>" maxlength="3" name="quantity" value="<?= $result['cart_quantity'];?>" class="form-control qty" data-size="<?= $result['size_id'];?>" data-product="<?= $result['prod_id'];?>" onKeyUp="return addtocart('s_<?= $result['size_id'];?>');" style="width:50px" />
							</td >
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<?php } ?>
	</div>
	<div class="row justify-content-center pt-2">
		<?php if($is_append){ ?>
		<div class="btn_more text-center mb-4">
			<button onclick="view_more_products();" class="btn btn-dark btn-sm"><i class="fa fa-circle-o-notch fa-spin fa-2x"></i> <span style="font-size:16px;">Load More...</span></button>
		</div>
		<?php } ?>
	</div>
<?php }else{ ?>
	<div class="row justify-content-center">
		<div class="col-md-12 mt-3" style="text-align: center;display: block;"><h5><?php echo $this->lang->line('msg_no_product_found') ?></h5></div>
		<div class="col-md-12 my-3" style="text-align: center;display: block;"><button class="btn btn-primary btn-md" onclick="window.location.href='<?php base_url(); ?>'"><?php echo $this->lang->line('msg_back_to_home') ?></button></div>
	</div>
<?php } ?>