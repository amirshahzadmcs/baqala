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
		<h3>Purchase Product List</h3>
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
					<h5><i class="fa fa-pencil"></i> Purchase Product List</h5>
				</div>
				<div class="x_content">
					<div class="col-md-12">
						<table id="example" class="table table-bordered">
							<thead>
								<tr>
									<th>#</th>
									<th>Image</th>
									<th>Name</th>
									<th>Sku</th>
									<th>Barcode</th>
									<th>Units</th>
								</tr>
							</thead>

							<tbody>
								<?php $i = 1; foreach($results as $product){?>
								<tr>
									<td><?php echo $i++;?></td>
									<td><img src="<?php echo base_url() . $product->product_image;?>" width="100px"/></td>
									<td><?php echo $product->product_name; ?><br/><?php echo $product->arabic_name; ?></td>
									<td><?php echo $product->product_sku; ?></td>
									<td><?php echo $product->barcode; ?></td>
									<td><?php echo $product->quantity; ?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('admin/home/footer');?>
<script>
$(document).ready(function(){
	$('#example').dataTable({
		"lengthMenu": [[25, 50, 100, 500], [25, 50, 100, 500]],
		dom: 'Blfrtip',
		buttons: [
			'csv'
		],
	});
});
</script>