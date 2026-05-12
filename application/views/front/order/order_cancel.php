<?php $this->load->view("front/common/header");?>
<style>
.prod-cart-icon{
	color: #ffffff !important;
    position: absolute;
    right: 25px;
    bottom: -26px;
}
</style>
<div class="page-wrapper single-prouct fixed-top" style="background-color:#f0f2f5">
    <div class="p-3 border-bottom">
        <div class="d-flex align-items-center">
            <h5 class="font-weight-bold m-0">Order Cancel</h5>
            <a class="toggle ml-auto" href="#"><i class="icofont-navigation-menu"></i></a>
        </div>
    </div>
</div>
<main class="main mt-6" style="margin-top:3.5rem">
    <div class="page-content pb-0">
        <div style="max-width:536px; width:100%; margin:auto;text-align:center;">
        	<img src="images/order-cancel.png" width="70%" style="display: initial;">
        	<h3>Order not placed.</h3>
        	<br/><br/>
        	<a href="<?php echo base_url(); ?>" class="btn btn-danger">Continue Shopping</a>
        </div>
    </div>
</main>

<?php 
$this->load->view("front/common/footer-nav");
$this->load->view("front/common/footer");?>
