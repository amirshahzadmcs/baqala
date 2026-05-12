<?php $this->load->view('admin/home/header');?>
<style>
span.required{
	color:red;
}
.alert_text{
	border:2px red solid;
}
</style>
<div class="page-title">
	<div class="title_left">
		<h3>Manage Stock</h3>
	</div>
	<div class="title_right">
		<?php if($this->admin->getInfo()){ 
		$info = explode("--", $this->admin->getInfo());
		$info_type = $info[0];
		$msg_data = $info[1];
		if($info_type == 2){
		?>  
		<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button></div>
		<?php } else{?>
		<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>
		<?php } echo $msg_data; ?> </div><?php } $this->admin->removeInfo();?>
	</div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h5><i class="fa fa-pencil"></i> Manage Stock</h5>
				</div>
				<div class="x_content">
					<div class="col-lg-6">
						<label>Search by SKU or Barcode</label>
						<?php echo form_open('admin/product/managestock_ajax', array("id"=>"searchForm")); ?>
							<div class="input-group custom-search-form">
								<input type="search" name="term" class="form-control" placeholder="Search by SKU or Barcode">
								<span class="input-group-btn">
									<button class="btn btn-default" type="submit">
									<span class="glyphicon glyphicon-search"></span>
									</button>
								</span>
							</div>
						<?php echo form_close();?>
					</div>
					<div class="col-md-12">
						<div id="searchResult"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('admin/home/footer');?>

<script>
	$('#searchForm').on('submit', (function(e) {
		e.preventDefault();
		$.ajax({
			url: '<?php echo base_url();?>admin/product/managestock_ajax',
			type: "POST",
			data:  new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			success: function(data){
				//alert(JSON.stringify(data));
				$('#searchResult').html(data);
			},
			error: function(data){
				alert('Someting went wrong, try again or contact to administrator.');
			}
		});
	}));
</script>