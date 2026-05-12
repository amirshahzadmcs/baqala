<?php $this->load->view("front/common/header");?>
	<div class="osahan-account">
	   <div class="p-3 border-bottom fixed-top" style="background-color:#f0f2f5">
		  <div class="d-flex align-items-center">
			 <h5 class="font-weight-bold m-0"><?php echo $this->lang->line('msg_my_account') ?></h5>
			 <a class="toggle ml-auto" href="#"><i class="icofont-navigation-menu"></i></a>
		  </div>
	   </div>
	   <?php if($this->session->flashdata('msg')) { ?>
			<?php if($this->session->flashdata('is_success') == '1') { ?>
				<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <?= $this->session->flashdata('msg') ?> </div>
			<?php }else{ ?>
				<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <?= $this->session->flashdata('msg') ?> </div>
			<?php } ?>
		<?php } ?>
	   <div class="p-4 profile text-center border-bottom" style="margin-top:3.5rem">
		  <img src="images/user-img.png" alt="user-img" class="img-fluid rounded-pill">
		  <h6 class="font-weight-bold m-0 mt-2"><?php echo $result->name;?></h6>
		  <p class="small text-muted"><?php echo $result->email;?></p>
		  <a href="account" class="btn btn-success btn-sm"><i class="icofont-pencil-alt-5"></i> <?php echo $this->lang->line('msg_edit_profile') ?></a>
	   </div>
	   <div class="account-sections">
		  <ul class="list-group">
			 <a href="order_history" class="text-decoration-none text-dark">
				<li class="border-bottom bg-white d-flex align-items-center p-3">
				   <i class="icofont-cart osahan-icofont bg-success"></i><?php echo $this->lang->line('msg_orders') ?>
				   <span class="badge badge-success p-1 badge-pill ml-auto"><i class="icofont-simple-right"></i></span>
				</li>
			 </a>
			 <a href="<?php echo base_url('wallet-history'); ?>" class="text-decoration-none text-dark">
				<li class="border-bottom bg-white d-flex align-items-center p-3">
				   <i class="icofont-wallet osahan-icofont bg-info"></i><?php echo $this->lang->line('msg_my_wallet') ?>
				   <span class="badge badge-success p-1 badge-pill ml-auto"><?php echo $result->wallet;?> SAR</span>
				</li>
			 </a>
			 <a href="<?php echo base_url('rewards-history'); ?>" class="text-decoration-none text-dark">
				<li class="border-bottom bg-white d-flex align-items-center p-3">
				   <i class="icofont-coins osahan-icofont bg-danger"></i><?php echo $this->lang->line('msg_my_rewards') ?>
				   <span class="badge badge-success p-1 badge-pill ml-auto"><?php echo $result->rewards;?> SAR</span>
				</li>
			 </a>
			 <?php if($result->role_id == 2 && $result->credit_account > 0){?>
			 <a href="credit-detail" class="text-decoration-none text-dark">
				<li class="border-bottom bg-white d-flex align-items-center p-3">
				   <i class="icofont-credit-card osahan-icofont bg-info"></i><?php echo $this->lang->line('msg_credit_bal') ?>
				   <span class="badge badge-success p-1 badge-pill ml-auto"><?php echo $this->customer->getCredit()->credit_avilable;?> SAR</span>
				</li>
			 </a>
			 <?php } ?>
			 <a href="account/address" class="text-decoration-none text-dark">
				<li class="border-bottom bg-white d-flex align-items-center p-3">
				   <i class="icofont-address-book osahan-icofont bg-dark"></i><?php echo $this->lang->line('msg_my_address') ?>
				   <span class="badge badge-success p-1 badge-pill ml-auto"><i class="icofont-simple-right"></i></span>
				</li>
			 </a>
			 <?php if($result->role_id < 2){?>
			 <a href="referral" class="text-decoration-none text-dark">
				<li class="border-bottom bg-white d-flex align-items-center p-3">
				   <i class="icofont-coins osahan-icofont bg-info"></i><?php echo $this->lang->line('msg_referral_code') ?>
				   <span class="badge badge-success p-1 badge-pill ml-auto"><i class="icofont-simple-right"></i></span>
				</li>
			 </a>
			 <?php } ?>
			 <a href="redeem" class="text-decoration-none text-dark">
				<li class="border-bottom bg-white d-flex align-items-center p-3">
				   <i class="icofont-ticket osahan-icofont bg-success"></i><?php echo $this->lang->line('msg_redeem') ?>
				   <span class="badge badge-success p-1 badge-pill ml-auto"><i class="icofont-simple-right"></i></span>
				</li>
			 </a>
			 <a href="terms-condition" class="text-decoration-none text-dark">
				<li class="border-bottom bg-white d-flex align-items-center p-3">
				   <i class="icofont-info-circle osahan-icofont bg-primary"></i><?php echo $this->lang->line('msg_terms_privacy_policy') ?>
				   <span class="badge badge-success p-1 badge-pill ml-auto"><i class="icofont-simple-right"></i></span>
				</li>
			 </a>
			 <a href="help-ticket" class="text-decoration-none text-dark">
				<li class="border-bottom bg-white d-flex align-items-center p-3">
				   <i class="icofont-phone osahan-icofont bg-warning"></i><?php echo $this->lang->line('msg_help_support') ?>
				   <span class="badge badge-success p-1 badge-pill ml-auto"><i class="icofont-simple-right"></i></span>
				</li>
			 </a>
			 <a href="logout" class="text-decoration-none text-dark">
				<li class="border-bottom bg-white d-flex  align-items-center p-3">
				   <i class="icofont-lock osahan-icofont bg-danger"></i> <?php echo $this->lang->line('msg_logout') ?>
				</li>
			 </a>
		  </ul>
	   </div>
	</div>
<?php
	$this->load->view("front/common/footer-nav");
	$this->load->view("front/common/footer");
?>
