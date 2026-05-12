<div style="position:fixed;z-index:99;right:20px;width:50%;top:90px;">
	<?php if($this->admin->getInfo()){ 
	$info = explode("--", $this->admin->getInfo());
	$info_type = $info[0];
	$msg_data = $info[1];
	if($info_type == 2){
	?>  
	<div class="alert alert-danger alert-dismissible fade show" role="alert">
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		<strong>Error!</strong>  <?php echo $msg_data; ?>
	</div>
	<?php } else{?>
	<div class="alert alert-success alert-dismissible fade show" role="alert">
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		<strong>Success!</strong>  <?php echo $msg_data; ?>
	</div>
	<?php } } $this->admin->removeInfo();?>
</div>
