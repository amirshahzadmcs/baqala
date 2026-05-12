<?php if($result->num_rows()){
	foreach($result->result() as $result){?>
<div class="col-xs-6 col-sm-4 col-md-3">

<div class="pdiv">

<?php echo (strtotime($result->date_modified . ' + 30 days') > time()) ? '<div class="new"><img src="images/new.png" /></div>' : ''; ?>
<?php echo ($result->discounted_price > 0) ? '<div class="sale"><img src="images/sale.png" /></div>' :''; ?>
<?php echo ($result->quantity > 0) ? '' : '<div class="outofstock"><img src="images/outofstock.png" /></div>'; ?>
<div class="pdivimg">
	<a href="<?php echo $result->seo;?>"><img src="<?php echo $result->image;?>" /></a> 
	<div class="pwishlist" data-toggle="tooltip" title="Add to wishlist"><i class="fa fa-times" onclick="remove_wishlist('<?php echo $result->wishlist_id;?>')"></i></div> 
	<div class="quickview" data-toggle="tooltip" title="Quick View"><i class="fa fa-search-plus" onclick="quick_view('<?php echo $result->id;?>')"></i></div>
</div>

<div class="pcontent">
<div class="ptitle"><a href="<?php echo $result->seo;?>"><?php echo $result->name;?></a></div>
<div class="price">
<?php echo ($result->discounted_price > 0) ? '<span>' . $this->customer->getRealRate($result->price) . '</span>' . $this->customer->getRealRate($result->discounted_price) .' <div class="label label-success">save ' . round($result->percent) . '%</div>' : $this->customer->getRealRate($result->price); ?>
</div>
<div class="">
	
	
	<?php if($result->quantity > 0){ ?> 
<button onclick="add_to_cart('<?php echo $result->id;?>','<?php echo $result->size_id; ?>')" class="btn buynowbut">Buy Now</button>
<?php } else{?>
<button disabled class="btn buynowbut">Buy Now</button>
<?php } ?>
</div>
</div>
</div>


</div>

<?php } } else{ ?>
	
	<div style="max-width:536px; width:100%; margin:auto;text-align:center;">
	<img src="images/emptywishlist.jpg">
	<h3>OOOpppss!!! Wishlist is empty.</h3>
	</div>
	
<?php } ?>