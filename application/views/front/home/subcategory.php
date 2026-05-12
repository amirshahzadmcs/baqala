<div class="sub-category-filter">
	<ul class="navs">
		<?php if(!empty($result)){?>
		<li><a href="javascript:void(0)" onClick = "subcat('<?php echo $ids;?>');" class="active"><?php echo $this->lang->line('msg_all') ?></a></li>
		<?php }?>
		<?php $id=1; foreach($result as $res ) { ?>
		<li>
			<a href="javascript:void(0)" onClick = "subcat('<?php echo $res["id"];?>');">
			<?php echo ($sel_lang === "arabic") ? $res['arabic_name'] : $res['name'];?>
			</a>
		</li>
		<?php $id++;} ?>
	</ul>
</div>
<script>
var selector = '.navs a';
$(selector).on('click', function(){
	$(selector).removeClass('active');
	$(this).addClass('active');
});
</script>
