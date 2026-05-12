<?php $this->load->view("front/common/header"); ?>
<link rel="stylesheet" href="css/tabbox1.css">
<div class="wrappage">

<div class="innerpageban"><img src="images/innerimg.jpg" width="100%" /></div>

  <div class="row-fluid">
<ol class="breadcrumb">
    <li><a href="#">Home</a></li>
    <li class="active">Wishlist</li>        
  </ol>
</div>



<div class="container">
<div class="col-sm-12"><ul class="tabs title-bar-tabs"> <li class="active"><a href="Javascript:void();">Wishlist</a></li> </ul></div>
</div>




<div class="container" id="ajax_response">

<?php 
if($result->num_rows()){
foreach($result->result() as $result){?>
<div class="col-xs-6 col-sm-4 col-md-3">

<div class="pdiv">

<?php echo (strtotime($result->date_modified . ' + 30 days') > time()) ? '<div class="new"><img src="images/new.png" /></div>' : ''; ?>
<?php echo ($result->discounted_price > 0) ? '<div class="sale"><img src="images/sale.png" /></div>' :''; ?>
<?php echo ($result->quantity > 0) ? '' : '<div class="outofstock"><img src="images/outofstock.png" /></div>'; ?>
<div class="pdivimg">
	<a href="<?php echo $result->seo;?>"><img src="<?php echo $result->image;?>" /></a> 
	<div class="pwishlist" data-toggle="tooltip" title="Remove wishlist"><i class="fa fa-times" onclick="remove_wishlist('<?php echo $result->wishlist_id;?>')"></i></div> 
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

          
</div>

</div>


<!-- Modal -->
<div id="quick_view_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      
      <div class="modal-body" id="quick_view_ajax" style="display:inline-block">
        
      </div>
      
    </div>

  </div>
</div>
<!--modal-->
<!----------ADD ONS-------------->
<div id="addOnModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:90%;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add on something to make it extra special!</h4>
      </div>
      <div class="modal-body">
      
       <div class="tabBox1 newtab">
  <ul class="tabs2">
  <?php
	foreach($addons as $adon){?>
    <li><a href="#tab<?php echo $adon['id']; ?>"><?php echo $adon['name'];?></a></li>
  <?php } ?>
  </ul>
 
  <div class="tabContainer1">
  
<?php foreach($addons as $ado){?>
<div id="tab<?php echo $ado['id'];?>" class="tabContent1">
 <?php foreach($ado['products'] as $pro){?>     
<div class="col-sm-2">
<div class="pdiv">
<div class="pdivimg"><img src="<?php echo $pro['image'];?>" /></div>

<div class="pcontent">
<div class="ptitle"><a href="Javascript:void(0);"><?php echo $pro['name'];?></a></div>
<div class="price">
<?php echo ($pro['discounted_price'] > 0) ? '<span>' . $this->customer->getRealRate($pro['price']) . '</span>' . $this->customer->getRealRate($pro['discounted_price']) : $this->customer->getRealRate($pro['price']); ?>
</div>
<div class="" id="modalbtnadr<?php echo $pro['id'];?>">
<?php if($pro['is_added'] == '0'){?>
<button class="btn btn-sm btn-success" id="btnadadon<?php echo $pro['id'];?>" onclick="addAddon('<?php echo $pro['id']; ?>','<?php echo $pro['size_id']; ?>')">Add</button>
<?php } else{?>
<button class="btn btn-sm btn-danger" id="btnremoveadon<?php echo $pro['cart_id'];?>" onclick="remove('<?php echo $pro['cart_id'];?>')">Remove</button>
<?php } ?>
</div>
</div>
</div>
</div>
 <?php } ?>


</div>
<?php } ?>    
     
</div>
</div>
      </div>
      <div class="modal-footer">
      <a href="cart" class="btn btn-default">Skip</a> 
      <a href="cart"><button type="button" class="btn btn-default continueaddon">Continue</button></a>
      </div>
    </div>

  </div>
</div>


<script type="text/javascript">
  $(".tabContent1").hide(); 
  $("ul.tabs2 li:first").addClass("active").show(); 
  $(".tabContent1:first").show(); 
 
  $("ul.tabs2 li").click(function () {
    $("ul.tabs2 li").removeClass("active"); 
    $(this).addClass("active"); 
    $(".tabContent1").hide(); 
    var activeTab = $(this).find("a").attr("href"); 
    $(activeTab).fadeIn(); 
    return false;
  });
</script>



<!--------END ADD ONS------------>


<?php $this->load->view("front/common/footer");?>

<script>
	 var add_to_cart = function(p,s){
		$.ajax({
			url: '<?php echo base_url();?>order/add_to_cart',
			type: "POST",
			data: {"product_id":p, "size_id":s, "quantity": 1},
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
	
	var addAddon = function(p,s){
		$.ajax({
			url: '<?php echo base_url();?>order/add_to_addon',
			type: "POST",
			data: {"product_id":p, "size_id":s, "quantity": 1},
			success:
			 function(data){
				var result = JSON.parse(data);
				if(result['success'] == '1'){
					var cartId = result['cart_id'];
					var cartnumber = result['in_cart'];
					$("#cart_number").html(cartnumber);
					$("#modalbtnadr"+p).html('<button class="btn btn-sm btn-danger" id="btnremoveadon'+cartId+'" onclick="remove('+cartId+')">Remove</button>');
				}
			},
			error: function(){}
		});
	}
	
	var remove = function(u){
	$.ajax({
url: '<?php echo base_url();?>order/remove_cart',
type: "POST",
data: {"id":u},
success:
 function(data){
	 var result = JSON.parse(data);
		var proid = result['product_id'];
		var sizeid = result['size_id'];
		var cartnumber = result['in_cart'];
		$("#cart_number").html(cartnumber);
		$("#modalbtnadr"+proid).html('<button class="btn btn-sm btn-success" id="btnadadon'+proid+'" onclick="addAddon('+proid+','+sizeid+')">Add</button>');
	
},
error: function(){}
});
}
	
	var quick_view = function(p){
		$.ajax({
			url: '<?php echo base_url();?>home/quick_view',
			type: "POST",
			data: {"id":p},
			success:
			 function(data){
			   $("#quick_view_ajax").html(data);
			   $("#quick_view_modal").modal('show');
			},
			error: function(){}
		});
	}
	
	var remove_wishlist = function(p){
		
		$.ajax({
			url: '<?php echo base_url();?>order/remove_from_wishist',
			type: "POST",
			data: {"id":p},
			success:
			function(data){
			  get_wishlist();
			},
			error: function(){}
		});
	}
	
	var get_wishlist = function(){
		$.ajax({
			url: '<?php echo base_url();?>order/wishlist_ajax',
			type: "GET",
			success:function(data){
			  $("#ajax_response").html(data);
			},
			error: function(){}
		});
	}
</script>