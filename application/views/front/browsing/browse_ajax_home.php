<?php if(!empty($results)){ ?>
	<div class="container">
		<div class="hading wrappad"><span style="float:left;">Your browsing history</span><a href="<?php echo base_url() .'browsing'; ?>" class="btn btn-link btn-md" style="float:right;">View all</a></div>
	</div>  
	<?php $num=0; foreach($results as $result){ ?>
		<?php if( ++$num < 9 ){ ?>
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
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
		<?php } ?>
	<?php } ?>
<?php } ?>