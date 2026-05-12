<?php if($result->num_rows()){?>
	<?php $total = 0;
	$total_saving = 0;
	foreach($result->result() as $result)
	{?>
		<div class="cart-items bg-white position-relative border-bottom">
			<div class="d-flex align-items-center p-3">
				<a href="product/<?php echo $result->seo;?>"><img src="<?php echo ($result->image == "" OR !file_exists($result->image)) ? 'images/notfound.jpg':$result->image; ?>" class="img-fluid" /></a>
				<div class="remove-col">
					<button class="btn-remove" onclick="remove('<?php echo $result->id; ?>')" data-original-title="Remove"><i class="icofont-close"></i></button>
				</div>
				<a class="ml-2 text-dark text-decoration-none w-100">
					<p class="mb-1"><?php echo ($sel_lang === "arabic") ? $result->name_hindi : $result->name;?></p>
					<p class="text-muted mb-2"><span class="text-success mr-1"><?php echo $result->price;?>/<?php echo $result->size; ?></span></p>
					<p class="total_price font-weight-bold m-0">
						<?php echo $result->price;?> x <?php echo $result->quantity;?> = <?php $ttot = $result->price * $result->quantity; echo $ttot;?></p>
					<div class="d-flex align-items-center">
						<div class="input-group input-spinner ml-auto cart-items-number">
							<div class="input-group-prepend">
								<button class="btn btn-success btn-sm" type="button" id="button-plus" onclick="pluss('<?php echo $result->id;?>')">+</button>
							</div>
							<input type="text" class="form-control" id="quantity<?php echo $result->id;?>" value="<?php echo $result->quantity;?>" readonly />
							<div class="input-group-append">
								<button class="btn btn-success btn-sm" type="button" id="button-minus" onclick="minus('<?php echo $result->id;?>')">−</button>
							</div>
						</div>
					</div>
				</a>
			</div>
		</div>
	<?php
		$saving = $result->quantity * ($result->real_price - $result->price);
		$total = $total + $ttot;
		$total_saving += $saving;
	}
		if($this->session->userdata('promotion_code')){
			$promotion_code = $this->session->userdata('promotion_code');
			$discount_amount = $promotion_code['discount_amount'];

			$code = $promotion_code['code'];
		}
		else{
			$discount_amount = 0;
			$code = '';
		}
		$total_after_promo = $total - $discount_amount;
		$shipping = $this->customer->getShipping($total_after_promo);
		/*
		$shipping = $total_after_promo >= 199 ? 0 : 15;

		if($total_after_promo <= 750){
		$shipping = 199;
		}elseif($total_after_promo >= 751 && $total_after_promo <= 2500){
		$shipping = 149;
		}elseif($total_after_promo >= 2501 && $total_after_promo <= 5000){
		$shipping = 99;
		}else{
		$shipping = 49;
		}
		*/
	?>
	<div class="address p-3 bg-white">
		<h6 class="text-dark m-0"><?php echo $this->lang->line('msg_promo_code') ?></h6>
	</div>
	<div class="bg-white">
		<?php if($this->session->userdata('promotion_code')){ ?>
			<div class="col-12 m-0 p-3">
				<span class="font-weight-bold px-2" style="font-size: 20px;border: 1px dashed;"><?php echo $promotion_code['code'];?></span> <span class="float-right"><a id="remove_promotion" class="text-danger font-weight-bold">Remove Code</a></span>
			</div>
		<?php }else{ ?>
			<div class="accordion" id="accordionExample">
				<div class="d-flex align-items-center" id="headingThree">
					<a class="p-3 d-flex align-items-center text-decoration-none text-success w-100" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						<i class="icofont-badge mr-3"></i> <?php echo $this->lang->line('msg_add_promo_code') ?>
						<i class="icofont-rounded-down ml-auto"></i>
					</a>
				</div>
				<div id="collapseThree" class="collapse p-3 border-top" aria-labelledby="headingThree" data-parent="#accordionExample">
					<form class="row" method="post" action="<?php echo base_url();?>order/set_promotion" id="set_promotion">
						<div class="col-8 m-0 pr-1">
							<input type="hidden" id="total_ajax" name="total_price" value="<?php echo $total;?>" required />
							<input type="text" class="form-control" id="code" name="code" placeholder="<?php echo $this->lang->line('msg_enter_promo_code') ?>" required />
						</div>
						<div class="col-4 pl-1">
							<button type="submit" class="btn btn-success btn-block"><?php echo $this->lang->line('msg_submit') ?></button>
						</div>
					</form>
				</div>
			</div>
		<?php } ?>
	</div>
	<div class="address px-2 pb-0 w-100 border-bottom bg-white " style="position: absolute;top: 60px;">
		<div class="p-2">
		<?php if($shipping > 0){
			$RemainingShip = $this->customer->getShippingDetail($total_after_promo);
			$RemainingFreeShip = $RemainingShip - $total_after_promo;
			$RemainingShipPercent = round(($RemainingFreeShip*100)/$RemainingShip);
		?>
			<p class="m-0 text-dark d-flex align-items-center font-weight-bold"><?php echo $this->lang->line('msg_remaining') ?> &nbsp;<span class="text-danger"> SAR <?php echo $RemainingFreeShip; ?> </span>&nbsp; <?php echo $this->lang->line('msg_to_get_free_delivery') ?></p>
			<div class="progress rounded mt-1">
				<div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo 100 - $RemainingShipPercent;?>%;"></div>
			</div>
		<?php }else{?>
			<p class="m-0 text-dark d-flex align-items-center font-weight-bold"><?php echo $this->lang->line('msg_eligible_free_delv') ?></p>
			<div class="progress rounded mt-1">
				<div class="progress-bar bg-success" role="progressbar" style="width: 100%;"></div>
			</div>
		<?php } ?>
		</div>
	</div>
	<div class="p-3 mt-5">
		<a href="order-address" class="text-decoration-none">
			<div class="rounded shadow bg-success d-flex align-items-center p-3 text-white">
				<div class="more">
					<p class="small m-0"><?php echo $this->lang->line('msg_shipping_charge') ?>: <?php echo $shipping; ?> SAR</p>
					<?php if($this->session->userdata('promotion_code')){ ?>
					<p class="small m-0">Promotional Code (<?php echo $promotion_code['code'];?>): <?php echo $discount_amount;?> SAR</p>
					<?php } ?>
					<h6 class="m-0"><?php echo $this->lang->line('msg_sub_total') ?>: <?php echo $total_after_promo + $shipping;?> SAR</h6>
					<p class="small m-0"><?php echo $this->lang->line('msg_proceed_to_check') ?></p>
				</div>
				<div class="ml-auto"><i class="icofont-simple-right"></i></div>
			</div>
		</a>
	</div>
<?php } else{ ?>
	<div class="bg-white">
		<div style="max-width:536px; width:100%; height: 100vh;text-align:center;">
			<img src="images/emptycart.jpg" style="width: 100%; max-width: 185px;display: initial;"><br/>
			<h3><?php echo $this->lang->line('msg_your_cart_empty') ?></h3>
			<p style="text-align: center;"><?php echo $this->lang->line('msg_no_item_in_cart') ?><br/> <?php echo $this->lang->line('msg_buy_something') ?></p>
			<br/>
			<center><a href="<?php echo base_url();?>" class="btn btn-primary"><?php echo $this->lang->line('msg_start_shopping') ?></a></center>
		</div>
	</div>
<?php } ?>
