<?php if(!empty($results)){
/*echo '<pre>';print_r($results);exit();*/
?>
	<?php foreach($results as $result){ ?>
	<div class="col-xs-12 col-sm-4 col-md-3 col-lg-2 item">
		<div class="pdiv">
			<div class="pdivimg"><a href="<?php echo $result->seo;?>"><img src="<?php echo ($result->image == "" OR !file_exists($result->image)) ? 'images/notfound.jpg':$result->image; ?>" class="img-responsive"/></a></div>
			<div class="pcontent">
				<div class="ptitle"><a href="<?php echo $result->seo;?>"><?php echo $result->name; ?></a></div>

				<div style="padding-top:10px;">
					<div class="col-md-12">
						<button data-id="<?php echo $result->id; ?>" class="btn-primary action-delete">Remove</button>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } }else{ ?>
	<div class="col-md-12" style="font-size:18px;min-height: 190px;">No browsing history found</div>	  
<?php } ?>