<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Set Password</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta content="Admin" name="description" />
        <meta content="Admin" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo base_url('admin_assets/images/favicon.ico');?>" />

        <!-- Bootstrap Css -->
        <link href="<?php echo base_url('admin_assets/css/bootstrap.min.css');?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="<?php echo base_url('admin_assets/css/icons.min.css');?>" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="<?php echo base_url('admin_assets/css/app.min.css');?>" id="app-style" rel="stylesheet" type="text/css" />
    </head>

    <body class="authentication-bg bg-primary">
        <div class="home-center">
            <div class="home-desc-center">
                <div class="container">
                    <div class="home-btn">
                        <a href="<?php echo base_url();?>" class="text-white router-link-active"><i class="fas fa-home h2"></i></a>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-6 col-xl-5">
                            <div class="card">
                                <div class="card-body">
                                    <div class="px-2 py-3">
                                        <div class="text-center">
                                            <a href="<?php echo base_url();?>">
                                                <img src="<?php echo base_url('admin_assets/images/logo-dark.png');?>" height="100%" alt="logo" />
                                            </a>

                                            <h5 class="text-primary mb-2 mt-4">Set account password</h5>
											<p><?php echo $this->customer->obfuscate_email($this->session->userdata("user_email"));?></p>
                                        </div>
										<?php if($this->session->flashdata('msg')) { ?>
											<?php if($this->session->flashdata('is_success') == '1') { ?>
												<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <?= $this->session->flashdata('msg') ?> </div>
											<?php }else{ ?>
												<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <?= $this->session->flashdata('msg') ?> </div>
											<?php } ?>
										<?php } ?>
                                        <form class="form-horizontal mt-4 pt-2" method="POST" action="<?php echo base_url('account/submit_register');?>">
											<input type="hidden" name="email" id="email" value="<?php echo $this->session->userdata("user_email"); ?>" required />
											<input type="hidden" name="name" id="name" value="<?php echo $this->session->userdata("user_name"); ?>" required />
                                            <div class="row my-5 px-5 justify-content-center">
												<div class="mb-3">
													<label for="userpassword">Password</label>
													<input type="password" class="form-control" name="password" id="userpassword" placeholder="Enter password" required>
												</div>
											</div>
                                            <div>
                                                <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Continue</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5 text-center text-white">
                                <p>
                                    ©
                                    <script>
                                        document.write(new Date().getFullYear());
                                    </script>
                                     All Rights Reserved. <?php echo WEBSITE_NAME; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Log In page -->
        </div>

        <!-- JAVASCRIPT -->
        <script src="<?php echo base_url('admin_assets/libs/jquery/jquery.min.js');?>"></script>
        <script src="<?php echo base_url('admin_assets/libs/bootstrap/js/bootstrap.bundle.min.js');?>"></script>
        <script src="<?php echo base_url('admin_assets/libs/metismenu/metisMenu.min.js');?>"></script>
        <script src="<?php echo base_url('admin_assets/libs/simplebar/simplebar.min.js');?>"></script>
        <script src="<?php echo base_url('admin_assets/libs/node-waves/waves.min.js');?>"></script>

        <script src="<?php echo base_url('admin_assets/js/app.js');?>"></script>
		<script type="text/javascript">
			$(".otp-field").keyup(function () {
				if (this.value.length == this.maxLength) {
				  $(this).next('.otp-field').focus();
				}
			});
			
			$(function() {
				var charLimit = 1;
				$(".otp-field").keydown(function(e) {

					var keys = [8, 9, /*16, 17, 18,*/ 19, 20, 27, 33, 34, 35, 36, 37, 38, 39, 40, 45, 46, 144, 145];

					if (e.which == 8 && this.value.length == 0) {
						$(this).prev('.otp-field').focus();
					} else if ($.inArray(e.which, keys) >= 0) {
						return true;
					} else if (e.shiftKey || e.which >= 48 && e.which <= 57) {
						return true;
					} else if (this.value.length >= charLimit) {
						$(this).next('.otp-field').focus();
						return false;
					} else if (e.shiftKey || (e.which > 64 && e.which < 91)) {
						return false;
					}
				}).keyup (function () {
					if (this.value.length >= charLimit) {
						$(this).next('.otp-field').focus();
						return false;
					}
				});
			});
			
			$('#resend').on('click',function(e) {
				//alert('hi');
				e.preventDefault();
				var email=$("#email").val();
				$.ajax({
					url: '<?php echo base_url() ?>account/send_otp',
					type: "POST",
					//data:{email:email},
					complete: function() {
						$('.fa-spin').remove();
					},
					success: function(data){
						$("#ajax_response").html('<div style="margin-bottom:10px;line-height:30px;padding:10px;border:1px solid #555;">'+data+'</div>');
					},
				});
			});
		</script>
    </body>
</html>
