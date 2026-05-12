<?php foreach($category_list->result_array() as $cat){ ?>
	<?php if($cat['account_type'] == '0'){ ?>
	<li>
		<span class="caret" onclick="quickSidebar(this)" data-id="<?php echo $cat['branch_id'];?>"><a href="<?php echo base_url('admin/chart-of-accounts/cats/'.$cat['branch_id']); ?>"><?php echo $cat['branch_name']; ?></a></span>
		<ul class="nested" id="list_<?php echo $cat['branch_id'];?>">

		</ul>
	</li>
	<?php }else{ ?>
	<li><span class="file-type"><?php echo $cat['branch_name'];?></span></li>
	<?php } ?>
<?php } ?>
<script>
	var toggler = document.getElementsByClassName("caret");
	var i;

	for (i = 0; i < toggler.length; i++) {
		toggler[i].addEventListener("click", function() {
			this.parentElement.querySelector(".nested").classList.toggle("active");
			this.classList.toggle("caret-down");
		});
	}
</script>
