<?php $this->load->view("front/common/header");?>
<div class="osahan-search">
    <div class="p-3 border-bottom">
        <div class="d-flex align-items-center">
            <a class="font-weight-bold text-success text-decoration-none" onclick="goBack()" href="javascript:void(0)"> <i class="icofont-rounded-left back-page"></i></a>
            <h5 class="font-weight-bold m-0 ml-3">Search Product</h5>
            <a class="toggle ml-auto hc-nav-trigger hc-nav-1" href="#"><i class="icofont-navigation-menu"></i></a>
        </div>
    </div>
</div>
<div class="align-items-center p-3">
	<?php echo form_open('home/search', array("id"=>"searchForm")); ?>
	<div class="input-group rounded shadow-sm overflow-hidden bg-white">
		<div class="input-group-prepend">
			<button type="submit" class="border-0 btn btn-outline-secondary text-success bg-white"><i class="icofont-search"></i></button>
		</div>
		<input type="text" name="term" class="txt_search shadow-none border-0 form-control pl-0" placeholder="Search for Products.." aria-label="" aria-describedby="basic-addon1" value="" />
	</div>
	<?php echo form_close();?>
</div>
<div class="searchResult"></div>


<?php 
$this->load->view("front/common/footer-nav");
$this->load->view("front/common/footer");
?>
