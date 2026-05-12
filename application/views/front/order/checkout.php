<?php $this->load->view("front/common/header");?>
<section class="checkout-pg mb-5">
	<?php if($results->num_rows()){?>
    <div class="container">
        <hr />
        <h4>Checkout</h4>
		<?php echo form_open("confirm-checkout" ,array("role"=>"form", "class"=>"w-100", 'id'=>'checkout_form')); ?>
        	<div class="row">
				<div class="col-lg-6">
					<table class="table-borderless">
						<thead>
							<tr>
								<th>Invoice To</th>
								<th>Deliver To</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<fieldset class="select-address body-text">
										<div id="billing_address_text" class="order-address">
										<span><?= $personal->name;?><br><?= $personal->company_name;?><br> <?= $personal->building_no;?><br> <?= $personal->street_name;?><br> <?= $personal->city_name;?>, <?= $personal->district;?><br> <?= $personal->postal_code;?><br> <?= $personal->country;?><span>
                                        </div>
									</fieldset>
								</td>
								<td>
									<fieldset class="select-address body-text">
										<div id="delivery_address_text" class="order-address">
                                            <?php if($address->num_rows()){ ?>
                                                <?php $selected_address = $address->row(); ?>
                                                <span><?= $selected_address->person_name;?><br> <?= $selected_address->building_villa_no;?><br> <?= $selected_address->street;?><br> <?= $selected_address->city;?>, <?= $selected_address->state;?><br> <?= $selected_address->postal;?><br> <?= $selected_address->country;?><span>
                                                <input type="hidden" name="delivery_address_id" id="delivery_address_id" value="<?= $selected_address->id;?>" required /> 
                                            <?php } else{?>
                                                No address found
                                            <?php } ?>
                                        </div>
										<a class="fw-bold address_popup" href="javascript:;" data-address="shipping_address"> Change</a>
									</fieldset>
								</td>
							</tr>
							
						</tbody>
					</table>
				</div>

				<div class="col-lg-6">
					<div class="">
						<div class="mb-3">
							<label>P.O. Number (if applicable)</label>
							<input type="text" class="form-control" name="po_number" id="order_po_number" />
						</div>
						<div class="mb-3">
							<label>Notes</label>
							<textarea class="form-control" rows="3"name="customer_note" id="order_customer_note"></textarea>
						</div>
					</div>
				</div>
        	</div>
		<?= form_close();?>

        <div class="row cart-pg mt-4">
            <div class="col-md-12">
			
				<div class="cart-dis">
					
					<table class="table table-bordered item_table">
						<thead>
							<tr>
								<th scope="col" width="15%" class="mb-hidden">Code</th>
								<th scope="col" width="70%" class="name">Name</th>
								<th scope="col" width="10%" class="size" style="text-align: center;">Size</th>
								<th scope="col" width="5%" class="quantity" style="text-align: center;">Qty</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($results->result_array() as $result){?>
							<tr>
								<td class="mb-hidden"><?= $result['parent_sku'];?>-<?= $result['product_sku'];?> <span class="sku-divider">/</span> <?= $result['barcode'];?></td>
								<td>
									<b><?= $result['name'];?> <span> <?= $result['name_ar']; ?></span></b>
									<div class="mobile-code"><span><?= $result['parent_sku'];?>-<?= $result['product_sku'];?> / </span> <span class="sku-divider"> <?= $result['barcode'];?></span></div>
								</td>
								<td class="stock-status-column cm-pd text-center"><?= $result['size'];?> <?= $result['unit_name'];?></td>
								<td class="qty-title cm-pd">
									<input type="number" value="<?= $result['quantity'];?>" class="form-control" style="width:50px" disabled />
								</td>
							</tr>
							<?php } ?>
							<tr class="basket-total">
								<th colspan="4" style="text-align:right;font-size:16px;font-weight:bold;">Total Items: <span><?= $results->num_rows(); ?></span></th>
							</tr>
						</tbody>
					</table>
				</div>
            </div>
        </div>

        <div class="checkout-pg-btn mt-3">
            <ul>
                <li>
                    <a href="<?= base_url('cart');?>">
                        <span><i class="fal fa-chevron-left"></i></span> Edit Basket
                    </a>
                </li>
                <li>
                    <button type="submit" form="checkout_form" class="btn btn-success confirm-order">
                        Confirm Order <span><i class="fal fa-chevron-right"></i></span>
					</button>
                </li>
            </ul>
        </div>
    </div>
	<?php } ?>
</section>

<!-- Modal -->
<div class="modal fade an-address" id="selectAddress" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Choose An Address</h5>
                <p></p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <input type="hidden" id="address_type" value="" />
				<ol class="address-list">
                    <?php if($address->num_rows()){ ?>
					<?php foreach($address->result() as $c_adrress){ ?>
					<li><a href="javascript:void(0)" onclick="checkoutAddress('<?= $c_adrress->id;?>')"><?= $c_adrress->person_name;?>, <?= $personal->company_name;?>, <?= $c_adrress->building_villa_no;?>, <?= $c_adrress->street;?>, <?= $c_adrress->city;?>, <?= $c_adrress->state;?>, <?= $c_adrress->postal;?>, <?= $c_adrress->country;?></a></li>
					<?php }}else{ ?>
                        <li class="p-3">No address found, contact to admin.</li>
                    <?php } ?>
				</ol>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view("front/common/footer");?>