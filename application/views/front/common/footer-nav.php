		<!-- Footer -->
		<div class="osahan-menu-fotter fixed-bottom bg-white text-center border-top">
			<div class="row m-0">
				<a href="<?php echo base_url(); ?>" class="text-muted small col font-weight-bold text-decoration-none p-2 <?=($this->uri->segment(1) == '' ? 'selected' : '');?>">
					<p class="h5 m-0"><i class="icofont-home"></i></p>
					<span style="overflow: hidden;text-overflow: ellipsis;display: -webkit-box;line-clamp: 1;-webkit-line-clamp: 1;-webkit-box-orient: vertical;"><?php echo $this->lang->line('msg_home') ?></span>
				</a>
				<a href="cart" class="text-muted col small text-decoration-none p-2 <?=($this->uri->segment(1) == 'cart' ? 'selected' : '');?>">
					<p class="h5 m-0 cart-badge1"><i class="icofont-cart"></i><span id="cart_number" class="badge"><?php echo $this->customer->inCart();?></span></p>
					<?php echo $this->lang->line('msg_cart_name') ?>
				</a>
				<a href="order_history" class="text-muted col small text-decoration-none p-2 <?=($this->uri->segment(1) == 'order_history' ? 'selected' : '');?>">
					<p class="h5 m-0"><i class="icofont-bag"></i></p>
					<?php echo $this->lang->line('msg_my_order') ?>
				</a>
				<?php if($this->customer->isLogged()){?>
				<a href="dashboard" class="text-muted small col text-decoration-none p-2 <?=($this->uri->segment(1) == 'dashboard' ? 'selected' : '');?>">
					<p class="h5 m-0"><i class="icofont-user"></i></p>
					<?php echo $this->lang->line('msg_account') ?>
				</a>
				<?php }else{ ?>
				<a href="login?auth=<?php echo md5(time()."jbng5453zfb3z");?>&arial_path=<?php echo base_url(uri_string());?>" class="text-muted small col text-decoration-none p-2 <?=($this->uri->segment(1) == 'login' ? 'selected' : '');?>">
					<p class="h5 m-0"><i class="icofont-user"></i></p>
					<?php echo $this->lang->line('msg_account') ?>
				</a>
				<?php } ?>
			</div>
		</div>
