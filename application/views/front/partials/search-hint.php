<?php if(count($results) > 0){ ?>
	<div class="search-result-inner">
		<div class="search-result-inner2">
			<div class="p-2 sticky-top bg-white search-result-heading">
				<h5 class="text-decoration-underline pt-3">Search result for <?= $term; ?> <button type="button" onclick="closeSearch()" class="btn-close float-end d-none d-md-block" style="font-size: 16px;"></button></h5>
			</div>
			<?php foreach($results as $result){?>
			<div class="row product-ct products_details">
				<div class="col-lg-2 col-md-2 col-sm-12 bd-r">
					<div class="product_item_img">
						<!--$this->customer->getResizeImage($result['image'],200,200)-->
						<img src="<?php echo ($result['image'] == "" OR !file_exists($result['image'])) ? 'assets/image/no-image.jpg':$result['image']; ?>" class="img-fluid" />
					</div>
				</div>
				<div class="col-lg-10 col-md-10 col-sm-12 px-0">
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
			<?php } }else{ ?>
			<div class="no-search-result px-5 pb-4">
				<div class="p-1 sticky-top bg-white">
					<h6 class="text-decoration-underline pt-3">Search result for <?= $term; ?> <button type="button" onclick="closeSearch()" class="btn-close float-end" style="font-size: 16px;"></button></h6>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12">
					No search result found, try another keyword.
				</div>
			</div>
		</div>
	</div>
<?php } ?>
