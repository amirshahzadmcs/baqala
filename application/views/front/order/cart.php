<?php $this->load->view("front/common/header");?>
<section class="cart-pg mb-5">
    <div class="container">
        <hr />
        <div class="row cart_load_ajax">
            <div class="col-md-12">
				<?php if($results->num_rows()){?>
                	<div class="cart-dis">
						<div class="delete-cart">
							<a href="javascript:;" data-bs-toggle="modal" data-bs-target="#deleteModal" class="delete-link" data-toggle="modal">Empty Basket</a>
						</div>
                    	<h4>Your Basket</h4>
						<table class="table table-bordered item_table">
							<thead>
								<tr>
									<th scope="col" width="15%" class="mb-hidden">Code</th>
									<th scope="col" width="70%" class="name">Name</th>
									<th scope="col" width="10%" class="size text-start">Size</th>
									<th scope="col" width="5%" class="quantity text-center">Qty</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($results->result_array() as $result){?>
								<tr>
									<td class="mb-hidden"><?= $result['parent_sku'];?>-<?= $result['product_sku'];?> <span class="sku-divider">/</span> <?= $result['barcode'];?></td>
									<td>
										<a href="<?php echo base_url('product/'.$result['size_id']);?>"> <?= $result['name'];?> <span> <?= $result['name_ar']; ?></span></a>
										<div class="mobile-code"><span><?= $result['parent_sku'];?>-<?= $result['product_sku'];?> / </span> <span class="sku-divider"> <?= $result['barcode'];?></span></div>
									</td>
									<td class="stock-status-column cm-pd"><?= $result['size'];?> <?= $result['unit_name'];?></td>
									<td class="qty-title cm-pd">
										<input type="number" min="1" id="s_<?= $result['size_id'];?>" maxlength="3" name="quantity" value="<?= $result['quantity'];?>" class="form-control qty" data-size="<?= $result['size_id'];?>" data-product="<?= $result['product_id'];?>" onKeyUp="return addtocart('s_<?= $result['size_id'];?>');" style="width:50px" />
									</td>
								</tr>
								<?php } ?>
								<tr class="basket-total">
									<th colspan="4" style="text-align:right;font-size:16px;font-weight:bold;">Total Items: <span><?= $results->num_rows(); ?></span></th>
								</tr>
							</tbody>
						</table>
                	</div>
					<div class="cart-pg-checkout mt-3">
						<a href="<?= base_url();?>checkout">
							Checkout <span><i class="fal fa-chevron-right"></i></span>
						</a>
					</div>
				<?php }else{ ?>
					<h4>Your Basket</h4>
					<div class="bg-white">
						<div style="max-width:536px; width:100%;margin: 0 auto;text-align:center;">
							<img src="images/emptycart.jpg" style="width: 100%; max-width: 185px;display: initial;"><br/>
							<h3><?php echo $this->lang->line('msg_your_cart_empty') ?></h3>
							<p style="text-align: center;"><?php echo $this->lang->line('msg_no_item_in_cart') ?><br/> <?php echo $this->lang->line('msg_buy_something') ?></p>
							<br/>
							<center><a href="<?php echo base_url();?>" class="btn btn-primary"><?php echo $this->lang->line('msg_start_shopping') ?></a></center>
						</div>
					</div>
				<?php } ?>
            </div>
        </div>
    </div>
</section>
<!-- Modal -->
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <p>Are you sure you want to remove everything from your basket?</p>
		<div class="mt-3">
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			<button type="button" onclick="window.location.href='empty-basket'" class="btn btn-danger">Empty Basket</button>
		</div>
      </div>
      
    </div>
  </div>
</div>
<?php
	$this->load->view("front/common/footer");
?>
