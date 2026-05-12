<?php $this->load->view("front/common/header");?>

<section class="product-category">
   	<div class="container">
      	<hr />
      	<h4><?php echo $name;?> - <span>  <?= $arabic_name;?>  </span></h4>
      	
		<div class="product_cetagory" style="margin-top:1.5rem">
			<div class="contentWrapper">
				<?php if(!empty($sub_categories)){?>
				<div class="tabsWrapper">
					<ul class="tabs">
						<li onClick = "subcat('<?php echo $id;?>');" data-id="contentOne" class="active"><?php echo $this->lang->line('msg_all') ?></li>
						<?php $eid=1; foreach($sub_categories as $res) { ?>
						<li onClick = "onclickSubCat('<?php echo $res["id"];?>');" data-id="contentOne"><?php echo ($sel_lang === "arabic") ? $res['arabic_name'] : $res['name'];?></li>
						<?php $eid++; } ?>
					</ul>
				</div>
				<?php } ?>
				<div class="tabContent">
					<div class="contentOne" id="cat">
					</div>
				</div>
			</div>
		</div>
		<div id="sub_cat">
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
		</div>
   	</div>
</section>
<input type="hidden" id="offset_1" value="<?php echo $offset;?>">
<input type="hidden" id="total_products_1" value="<?php echo $product_count;?>">
<?php
	$this->load->view("front/common/footer");
?>
<script language="javascript">
    function view_more_products(){
    	$.ajax({
    		url: '<?php echo base_url();?>home/category_ajax',
    		type: "POST",
    		data: {"offset": $("#offset_1").val(), "product_count":$("#total_products_1").val(), "id":'<?php echo $id;?>', "sort_by":"<?php echo $this->input->get("sort_by");?>"},
    		success:
    		 function(data){
    			 var result = JSON.parse(data);
    			 $("#offset_1").val(result['newOffset'])
    			 $("#product_div").append(result['result']);
    			 //$(window).bind('scroll', bindScroll);
    			 if(!result['is_append']){
    				$(".btn_more").html("");
    			 }
    			 var n = $(".product-ct").length;
				 //alert(n);
    			 $("#prod_count").html(n);
    			 //$("#product_counter").load(' #product_counter');
    		},
    		error: function(data){
				alert(data);
			}
    	});
    }
</script>

<script id="rendered-js" >

// hide all contents accept from the first div
$('.tabContent div:not(:first)').toggle();

// hide the previous button
$('.previous').hide();

$('.tabs li').click(function () {

	if ($(this).is(':last-child')) {
		$('.next').hide();
	}else{
		$('.next').show();
	}

	if ($(this).is(':first-child')) {
		$('.previous').hide();
	}else{
		$('.previous').show();
	}

	var position = $(this).position();
	var corresponding = $(this).data("id");

	// scroll to clicked tab with a little gap left to show previous tabs
	scroll = $('.tabs').scrollLeft();
	$('.tabs').animate({
	'scrollLeft': scroll + position.left - 130 },
	900);

	// hide all content divs
	$('.tabContent div').hide();

	// show content of corresponding tab
	$('div.' + corresponding).toggle();

	// remove active class from currently not active tabs
	$('.tabs li').removeClass('active');

	// add active class to clicked tab
	$(this).addClass('active');
});

$('.next').click(function (e) {
	e.preventDefault();
	$('li.active').next('li').trigger('click');
});
$('.previous').click(function (e) {
	e.preventDefault();
	$('li.active').prev('li').trigger('click');
});
//# sourceURL=pen.js


// Sub Navbar
function onclickSubCat(Id){
    $.ajax({
        type: "post",
        url: "Home/getcategory",
        data: {
             'id':Id,
        },
        success: function (data){
        //  alert(data);
           $("#cat").html(data);
        },
        error: function (xhr, ajaxOptions, thrownError){

        }
    });
      $.ajax({
        type: "post",
        url: "Home/getcategory_new",
        data: {
            'id':Id,
        },
        success: function (data){
        //  alert(data);
           $("#sub_cat").html(data);
        },
        error: function (xhr, ajaxOptions, thrownError){

        }
    });
    return false;
}

function subcat(Id){
    $.ajax({
        type: "post",
        url: "Home/getcategory_new",
        data: {
            'id':Id,
        },
        success: function (data){
        //  alert(data);
           $("#sub_cat").html(data);
        },
        error: function (xhr, ajaxOptions, thrownError){

        }
    });
    return false;
}
</script>