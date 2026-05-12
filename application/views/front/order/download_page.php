<?php $this->load->view("front/common/header");?>
<div class="osahan-success bg-success vh-100" style="position: absolute;width: 100%;">
    
</div>
<!-- continue -->
<div class="fixed-top fixed-top-auto bg-white rounded p-3 mx-3 text-center" style="top: 18%;">
    <div class="p-5 text-center">
        <i class="icofont-ebook display-1 text-warning" style="font-size: 8rem;"></i>
		<h6 class="text-white"> <b></b></h6>
    </div>
    <h6 class="font-weight-bold mb-2">Thanks for visiting</h6>
    <p class="text-muted">You can download invoice by clicking below button.</p>
    <a href="<?php echo 'https://www.baqalastation.com/app/print-invoice?id='.$this->input->get('id');?>" class="btn rounded btn-warning btn-lg btn-block" style="font-size: 26px !important;"><i class="icofont-download"></i> Download</a>
</div>
<?php $this->load->view("front/common/footer");?>
