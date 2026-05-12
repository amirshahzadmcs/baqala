<?php $this->load->view("front/common/header"); ?>
<?php //'<pre>';print_r($result);'</pre>';exit(); ?>
<div class="osahan-listing">
	<div class="p-3 fixed-top" style="background-color:#f0f2f5">
		<div class="d-flex align-items-center">
			<a class="font-weight-bold text-success text-decoration-none" onclick="goBack()" href="javascript:void(0)"><i class="icofont-rounded-left back-page"></i></a><span class="font-weight-bold ml-3 h6 mb-0">Search Result</span>
			<a class="toggle ml-auto" href="#"><i class="icofont-navigation-menu"></i></a>
		</div>
	</div>
	<div class="osahan-listing px-3 bg-white mt-3">
		<?php if(count($result) > 0){ ?>
			<div class="p-2">
				<div class="d-flex align-items-center">
					<div class="toolbox-info">Search for <span><?php echo html_entity_decode($term);?></div>
				</div>
			</div>
			<div class="row border-bottom border-top" id="product_div">
				<?php foreach($result as $result){?>
				<div class="col-6 p-0 border-right border-bottom products_details">
					<div class="list-card-image">
						<div class="member-plan position-absolute <?php echo $result['prices'][0]['discounted_price'] > 0 ? '':'d-none';?>"><span class="badge m-3 badge-danger"><?php echo round($result['prices'][0]['percent']);?>%</span></div>
						<?php if($result['prices'][0]['quantity'] <= 0){?>
							<div class="outofstock"></div>
						<?php } ?>
						<div class="p-2">
							<a href="product/<?php echo $result['seo'];?>" class="text-dark">
								<img src="<?php echo ($result['image'] == "" OR !file_exists($result['image'])) ? 'images/notfound.jpg':$this->customer->getResizeImage($result['image'],200,200); ?>" class="img-fluid item-img w-100 mb-3" />
							</a>
							<h6 class="product_name"><a href="product/<?php echo $result['seo'];?>" class="text-dark"><?php echo ($sel_lang === "arabic") ? $result['name_hindi'] : $result['name'];?></a></h6>
							<div class="d-flex align-items-center">
								<h6 class="price m-0">
									<?php if($result['prices'][0]['discounted_price'] > 0){ ?>
										<del><?php echo $result['prices'][0]['price'];?> </del> &nbsp;&nbsp;
										<span class="text-success"><?php echo $result['prices'][0]['discounted_price'];?> SAR</span>
									<?php }else{ ?>
										<span class="text-success"><?php echo $result['prices'][0]['price'];?> SAR</span>
									<?php } ?>
								</h6>
							</div>
							<div class="d-flex align-items-center pt-2 add">
								<div class="btn-group bakala-radio btn-group-toggle" data-toggle="buttons">
									<?php $s=1;foreach($result['prices'] as $price){?>
									<label class="btn btn-secondary btn-sm active"><input type="radio" name="options" class="select_unit" data-cart_quantity="<?php echo $price['cart_quantity']; ?>" data-percent="<?php echo $price['percent']; ?>" data-price="<?php echo $price['price'];?>" data-discounted_price="<?php echo $price['discounted_price'];?>" data-quantity="<?php echo $price['quantity'];?>" data-product_id="<?php echo $result['id'];?>" data-size="<?php echo $price['id'];?>" id="option<?php echo $s;?>" <?php if($s== 1){ echo 'checked'; }?> /><?php echo $price['size'];?></label>
									<?php $s++;} ?>
								</div>
								<?php if($result['is_gift'] > 0){?>
										<a href="buy_now?gid=<?php echo $result['id'];?>" class="m_button ml-auto text-success">Buy Now</a>
									<?php }else{ ?>
									<?php if($result['prices'][0]['quantity'] > 0){?>
									<button class="btn btn-success btn-sm ml-auto single <?php echo $result['prices'][0]['cart_quantity'] <= 0 ? '':'d-none'; ?>" <?php echo $result['prices'][0]['quantity'] <= 0 ? 'disabled':'';?>>+</button>
									<?php } ?>
									<div class="input-group input-spinner ml-auto cart-items-number multi <?php echo $result['prices'][0]['cart_quantity'] == 0 ? 'd-none':''; ?>">
										<div class="input-group-prepend">
											<button class="btn btn-success btn-sm button_qty_plus" type="button" id="button-plus">+</button>
										</div>
										<input type="text" class="form-control qty" value="<?php echo $result['prices'][0]['cart_quantity'] == 0 ? 1:$result['prices'][0]['cart_quantity']; ?>" />
										<div class="input-group-append">
											<button class="btn btn-success btn-sm button_qty_minus" type="button" id="button-minus">−</button>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
		<?php }else{ ?>
			<div class="row justify-content-center">
				<div class="col-md-12">
					<div style="margin:auto;"><img src="images/no-product.jpg" style="width:100%;max-width:300px;"></div>
				</div>
				<div class="col-md-12" style="text-align: center;display: block;"><h5>No product in found. Try another term.</h5></div>
			</div>
		<?php } ?>
	</div>

</div>
<?php 
    $this->load->view("front/common/footer-nav");
    $this->load->view("front/common/footer");
?>

