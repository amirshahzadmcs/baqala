<?php $this->load->view("front/common/header");?>
<div class="osahan-listing">
	<div class="p-3 fixed-top" style="background-color:#f0f2f5">
		<div class="d-flex align-items-center">
			<a class="font-weight-bold text-success text-decoration-none" onclick="goBack()" href="javascript:void(0)"><i class="icofont-rounded-left back-page"></i></a><span class="font-weight-bold ml-3 h6 mb-0"><?php echo $name;?> </span>
			<a class="toggle ml-auto" href="#"><i class="icofont-navigation-menu"></i></a>
		</div>
	</div>

	<?php //echo '<pre>';print_r($result);'</pre>'; ?>
	<div class="osahan-listing px-3 bg-white" style="margin-top:3.5rem">
		<?php if(count($result) > 0){ ?>
			<div class="p-2">
				<div class="d-flex align-items-center">
					<div class="toolbox-info"><?php echo $this->lang->line('msg_showing') ?> <span id="prod_count"> <?php echo count($result); ?> </span><span><?php echo $this->lang->line('msg_of').' '. $product_count;?></span> <?php echo $this->lang->line('msg_product') ?></div>
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
								<?php if($result['prices'][0]['quantity'] > 0){?>
								<button class="btn btn-success btn-sm ml-auto single ct-rtl <?php echo $result['prices'][0]['cart_quantity'] <= 0 ? '':'d-none'; ?>" <?php echo $result['prices'][0]['quantity'] <= 0 ? 'disabled':'';?>>+</button>
								<?php } ?>
								<div class="input-group input-spinner ml-auto cart-items-number multi ct-rtl <?php echo $result['prices'][0]['cart_quantity'] == 0 ? 'd-none':''; ?>">
									<div class="input-group-prepend">
										<button class="btn btn-success btn-sm button_qty_plus" type="button" id="button-plus">+</button>
									</div>
									<input type="text" class="form-control qty" value="<?php echo $result['prices'][0]['cart_quantity'] == 0 ? 1:$result['prices'][0]['cart_quantity']; ?>" />
									<div class="input-group-append">
										<button class="btn btn-success btn-sm button_qty_minus" type="button" id="button-minus">−</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="row justify-content-center pt-2">
				<?php if($is_append){ ?>
				<div class="btn_more">
					<button class="btn btn-link"><i class="fa fa-circle-o-notch fa-spin fa-2x"></i> <span style="font-size:20px;">Loading...</span></button>
				</div>
				<?php } ?>
			</div>
		<?php }else{ ?>
			<div class="row justify-content-center" style="min-height: 82vh;">
				<div class="col-md-12">
					<div style="margin:auto;"><img src="images/no-product.jpg" style="width:100%;"></div>
				</div>
				<div class="col-md-12" style="text-align: center;display: block;"><h5>No product in this category. Try another category.</h5></div>
				<div class="col-md-12" style="text-align: center;display: block;"><button class="btn btn-primary btn-md" onclick="window.location.href='<?php base_url(); ?>'">Back To Home</button></div>
			</div>
	<?php } ?>
	</div>

</div>
<input type="hidden" id="offset_1" value="<?php echo $offset;?>">
<input type="hidden" id="total_products_1" value="<?php echo $product_count;?>">
<?php
	$this->load->view("front/common/footer-nav");
	$this->load->view("front/common/footer");
?>
<script language="javascript">
    function view_more_products(){
    	$.ajax({
    		url: '<?php echo base_url();?>home/category_ajax',
    		type: "POST",
    		data: {"offset": $("#offset_1").val(), "product_count":$("#total_products_1").val(), "sort_by":"<?php echo $this->input->get("sort_by");?>"},
    		success:
    		 function(data){
    			 var result = JSON.parse(data);
    			 $("#offset_1").val(result['newOffset'])
    			 $("#product_div").append(result['result']);
    			 $(window).bind('scroll', bindScroll);
    			 if(!result['is_append']){
    				$(".btn_more").html("");
    			 }
    			 var n = $(".products_details").length;
    			 $("#prod_count").html(n);
    			 //$("#product_counter").load(' #product_counter');
    		},
    		error: function(){}
    	});
    }

	function bindScroll(){
		if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
			$(window).unbind('scroll');
			view_more_products();
		}
	}

	$(window).scroll(bindScroll);
</script>
