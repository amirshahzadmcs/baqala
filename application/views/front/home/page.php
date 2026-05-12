<?php $this->load->view("front/common/header");?>
<style>
.page-desc p{text-align:justify;}
</style>
<div class="osahan-help">
    <div class="p-3 border-bottom fixed-top" style="background-color:#f0f2f5">
        <div class="d-flex align-items-center">
            <a class="font-weight-bold text-success text-decoration-none" onclick="goBack()" href="javascript:void(0)"> <i class="icofont-rounded-left back-page"></i></a>
            <h6 class="font-weight-bold m-0 ml-3"><?php echo ($sel_lang === "arabic") ? $result->arabic_name : $result->name;?></h6>
            <a class="toggle ml-auto" href="#"><i class="icofont-navigation-menu"></i></a>
        </div>
    </div>
</div>
<div class="page-desc p-3" style="margin-top:3.5rem">
    <h4 class="mb-3"><?php echo ($sel_lang === "arabic") ? $result->arabic_name : $result->name;?></h4>
    <p class="text-muted">
        <?php echo ($sel_lang === "arabic") ? $result->arabic_text_data : $result->text_data;?>
    </p>
</div>
<?php 
$this->load->view("front/common/footer-nav");
$this->load->view("front/common/footer");
?>
