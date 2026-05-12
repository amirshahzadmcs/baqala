<?php $this->load->view("front/common/header");?>
<style>
	.manage-history{
		float: right;
		font-size: 16px;
		text-decoration: none;
		color: #000000;
	}
	.card-body{
		padding: 25px 22px 50px;
		border: 1px solid #ececec;
		margin: 22px;
	}
</style>
<div class="wrappage">
	<div>
		<ol class="breadcrumb">
			<li><a href="/">Home</a></li>
			<li class="active">Browsing History</li>
		</ol>
	</div>
	<div class="container"><h1 style="font-size:24px;">
		Your Recently Viewed Items
		<a class="manage-history" data-toggle="collapse" href="#collapseHSetting" role="button" aria-expanded="false" aria-controls="collapseExample">
			Manage History <i class="fa fa-chevron-circle-down"></i>
		</a>
		</h1>
	</div>
	<div class="collapse" id="collapseHSetting">
		<div class="col-md-12">
			<div class="card card-body">
				<div class="col-md-2">
					<h4>Manage history</h4>
				</div>
				<div class="col-md-3">
					<button class="btn btn-default all-browse-delete">Remove all items from list</button>
				</div>
				<div class="col-md-3">
				
				</div>
			</div>
		</div>
	</div>
	<div class="container webcontent" id="browse_value_ajax"></div>
</div>

<script>

function getData(){	
	$.ajax({	
		url: '<?php echo base_url();?>home/browse_ajax',		
		type: "POST",		
		data: {"id":localStorage.getItem("kiranaBrowseItems")},		
		success: function(data){			
			$("#browse_value_ajax").html(data);		
		},		
		error: function(){}	
	});
}

$(document).on('click', '.action-delete', function(){
	var kiranaBrowseItems = JSON.parse(localStorage.getItem("kiranaBrowseItems"));
	var id = $(this).data('id');
	var remainItems = kiranaBrowseItems.filter(function(aIData){ return aIData.id != id });
	localStorage.setItem("kiranaBrowseItems", JSON.stringify(remainItems));
	getData();	
});

$(document).on('click', '.all-browse-delete', function(){
	localStorage.removeItem("kiranaBrowseItems");
	getData();	
});

$(document).on('blur', '.action-update', function(){
	var kiranaBrowseItems = JSON.parse(localStorage.getItem("kiranaBrowseItems"));
	var id = $(this).data('id');
	var updatationIndex = kiranaBrowseItems.findIndex(function(x){return x.id == id;});
	kiranaBrowseItems[updatationIndex].quantity = $(this).val();
	localStorage.setItem("kiranaBrowseItems", JSON.stringify(kiranaBrowseItems));
	getData();	
});

(function(){	
	getData();
}());

</script>

<?php $this->load->view("front/common/footer");?>