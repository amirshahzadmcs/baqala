<?php $this->load->view('front/common/header');?>
<section class="order-table mb-5">
    <div class="container">
        <hr />
        <h4>Change Password</h4>

        <div class="row">
            <div class="col-md-5">
                <div class="account-setting">
                    <div class="p-3">
                        <?php if($this->session->flashdata('msg')) { ?>
                            <?php if($this->session->flashdata('is_success') == 1) { ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert"> <?= $this->session->flashdata('msg') ?> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
                            <?php }else{ ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert"> <?= $this->session->flashdata('msg') ?> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
                            <?php } ?>
                        <?php } ?>
                        <?php echo form_open('update-password');?>
                            <div class="form-group mb-3">
                                <label for="exampleInputOLDPassword1">Old Password</label>
                                <input type="password" placeholder="Enter Old Password" name="old_password" maxlength="100" class="form-control" id="exampleInputOLDPassword1" required />
                            </div>
                            <div class="form-group mb-3">
                                <label for="exampleInputNEWPassword1">New Password</label>
                                <input type="password" placeholder="Enter New Password" name="new_password" class="form-control" id="password" maxlength="100" required />
                            </div>
                            <div class="form-group mb-3">
                                <label for="confirm_password">Confirmation Password</label>
                                <input placeholder="Enter Confirmation Password" type="password" name="confirm_password" class="form-control" maxlength="100" id="confirm_password" required />
                                <div id="message"></div>
                            </div>
                            <div class="text-left">
                                <button type="submit" class="btn btn-primary btn-block btn-md">Save Changes</button>
                            </div>
                        <?php echo form_close();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php 
$this->load->view("front/common/footer");
?>
<script type="text/javascript">
	$(document).ready(function(e) {
		$('#password, #confirm_password').on('keyup', function () {
		  if ($('#password').val() == $('#confirm_password').val()) {
			$('#message').html('Matching').css('color', 'green');
		  } else 
			$('#message').html('Not Matching').css('color', 'red');
		});
	});
</script>