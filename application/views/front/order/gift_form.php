<?php $this->load->view("front/common/header");?>
<style>
body{background-color:#fff;}
</style>
<div class="osahan-cart">
    <div class="p-3 border-bottom fixed-top" style="background-color:#f0f2f5">
        <div class="d-flex align-items-center">
			<a class="font-weight-bold text-success text-decoration-none" onclick="goBack()" href="javascript:void(0)"><i class="icofont-rounded-left back-page"></i> Gift Information</a>
            <a class="toggle ml-auto" href="#"><i class="icofont-navigation-menu"></i></a>
        </div>
    </div>
    <div class="osahan-body" style="margin-top:3.5rem">
		<?php if($this->session->flashdata('msg')) { ?>
			<?php if($this->session->flashdata('is_success') == '1') { ?>
				<div class="alert alert-success flash-message bg-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <?= $this->session->flashdata('msg') ?> </div>
			<?php }else{ ?>
				<div class="alert alert-danger flash-message bg-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <?= $this->session->flashdata('msg') ?> </div>
			<?php } ?>
		<?php } ?>
		<div class="p-3 bg-white">
			<p class="font-weight-bold m-0">Enter your Gift Card details:</p>
			<div class="row">
			<?php echo form_open("gift-checkout" ,array("role"=>"form", "class"=>"form-horizontal w-100", 'id'=>'gift_form')); ?>
				<div class="col-sm-12">
					<p>Gift card will be delivered through email only.</p>
				</div>
				<input type="hidden" name="gid" id="gid" value="<?php echo $this->input->get('gid');?>" required />
				<div class="form-group">
					<label class="control-label col-sm-2" for="recipient_name">Recipient Name:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="recipient_name" placeholder="Recipient Name" name="recipient_name" maxlength="150" required />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="g_to">Recipient Email:</label>
					<div class="col-sm-10">
						<input type="email" class="form-control" id="g_to" placeholder="email id" name="g_to" maxlength="150" required />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="g_from">From:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="g_from" placeholder="Your Name" name="g_from" maxlength="150" required />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="g_message">Message:</label>
					<div class="col-sm-10">
						<textarea class="form-control" id="g_message" name="g_message" placeholder="Any custom message"></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						<button type="submit" class="btn btn-success btn-block">Proceed to checkout</button>
					</div>
				</div>
			<?php echo form_close(); ?> 
			</div>
		</div>
    </div>
</div>

<?php
	$this->load->view("front/common/footer-nav");
	$this->load->view("front/common/footer");
?>
