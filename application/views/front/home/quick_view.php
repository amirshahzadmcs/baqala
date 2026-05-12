<div class="">
<div class="text-left webcontent"><strong><?php echo $result['name']; ?></strong></div>

<div class="col-sm-5 wrappad">
<img src="<?php echo $result['image'];?>" title="" class="img-responsive">


</div> 



<div class="col-sm-7 wrappad webcontent">

<div class="col-sm-12">
<table width="270">

<tr><td width="100"><strong>Brand </strong> </td><td width="15">:</td><td><?php /* echo $result['brand']; */ ?>Saugat Traders</td></tr>
<tr><td colspan="3">&nbsp;</td></tr>
<tr><td><strong>Product Code</strong> </td><td width="15">:</td><td><?php echo $result['sku']; ?></td></tr>
<tr><td colspan="3">&nbsp;</td></tr>
<tr><td><strong>Availability</strong> </td><td width="15">:</td><td><?php echo $result['total_count'] > 0 ? 'In Stock' : 'Out Of Stock'; ?> </td></tr>
</table>
<br/>


</div>


<div class="clearfix"></div>
<hr />


<div class="col-sm-12">

<div class="qty" <?php echo COUNT($result['sizes']) > 1 ? '':'style="display:none;"';?>>

<table width="270">
	<tr>
		<td width="100"><strong>Size</strong></td>
		<td width="15">:</td>
		<td><select name="size" id="size" onchange="get_price()">
		<?php foreach($result['sizes'] as $siz){?>	
			<option value="<?php echo $siz['id'];?>" <?php echo $siz['quantity'] < 1 ? "disabled":""; ?>><?php echo $siz['size'];?></option>
		<?php } ?>
		</select></td>
	</tr>
</table>
</div>

<?php foreach($result['sizes'] as $size){?>
<div class="detailprice hidden" id="price<?php echo $size['id'];?>">
	<?php echo $size['discounted_price'] > 0 ? '<span>' . $this->customer->getRealRate($size['price']) . '</span> ' . $this->customer->getRealRate($size['discounted_price']) . ' <div class="label label-success">20% off</div>' : $this->customer->getRealRate($size['price']); ?><br />
</div>
<?php } ?>
<div><strong>This product is eligible for free shipping in all over India.</strong></div>

</div>

<div>
<?php if($result['total_count'] > 0){ ?>
<div class="col-sm-6"><button class="btn detailaddtocart" onclick="add_cart('<?php echo $result['id'];?>')">Buy Now</button></div>
<?php } else{?>

<?php } ?>

</div>

<!--div class="col-sm-12">Tags : 
<?php 
/* $tags = explode(",", $result['tag']);
foreach($tags as $tag){ ?>
<a href="#"><?php echo $tag;?> &nbsp;</a> 
<?php }  */?>
</div -->


<div class="col-sm-12"><div class="addthis_inline_share_toolbox_lsvk"></div></div>


<div  class="col-sm-12" style="margin-top:30px;"><img src="images/detail-payment-icon.jpg" style="max-width:492px; width:100%;" /></div>
</div>

</div>
<script>
get_price();
function get_price(){
		var price_id = $("#size").val();
		$(".detailprice").addClass("hidden");
		$("#price"+price_id).removeClass("hidden");
	}
function add_cart(p){
		$.ajax({
			url: '<?php echo base_url();?>order/add_to_cart',
			type: "POST",
			data: {"product_id":p, "size_id":$("#size").val(), "quantity": 1},
			success:
			 function(data){
				 var result = JSON.parse(data);
				 var cartnumber = result['in_cart'];
				 $("#cart_number").html(cartnumber);
				 $("#addOnModal").modal('show');
			},
			error: function(){}
		});
	}
</script>