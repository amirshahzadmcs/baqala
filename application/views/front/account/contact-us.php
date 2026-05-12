<?php $this->load->view("front/common/header");?>
<section class="order-table mb-5">
    <div class="container">
        <hr />

        <h4>Contact us</h4>

        <div class="row">
            <div class="col-md-5">
                <div class="account-setting">
                    <?php echo form_open("submit-contact");?>
                        <div class="row">
                            <div class="mb-3">
                                <label>Your Email</label>
                                <input type="text" name="email" class="form-control" value="" />
                            </div>

                            <div class="mb-3">
                                <label>Your Message</label>
                                <textarea class="form-control" name="message" rows="3" style="height: 141px;"></textarea>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn account-setting-btn">Submit</button>
                            </div>
                        </div>
                    <?= form_close();?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
	$this->load->view("front/common/footer");
?>