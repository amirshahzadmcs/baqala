<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Verify Email | Calcbook</title>
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
		<style>
			.opt {
				margin: 4px;
			}
		</style>
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

                                            <h5 class="text-primary mb-2 mt-4">Verify your email</h5>
                                            <p class="text-muted">Enter the 6-digit code we sent to your email.</p>
											<p><?php echo $this->customer->obfuscate_email($this->session->userdata("user_email")); echo $this->session->userdata('user_otp');?></p>
                                        </div>
										<?php if($this->session->flashdata('msg')) { ?>
											<?php if($this->session->flashdata('is_success') == '1') { ?>
												<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <?= $this->session->flashdata('msg') ?> </div>
											<?php }else{ ?>
												<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <?= $this->session->flashdata('msg') ?> </div>
											<?php } ?>
										<?php } ?>
                                        <form class="form-horizontal mt-4 pt-2" method="POST" action="<?php echo base_url('account/verify_user');?>">
											<input type="hidden" name="email" id="email" value="<?php echo $this->session->userdata("user_email"); ?>" required />
                                            <div class="row my-5 px-5 justify-content-center">
												<input class="otp-field form-control opt text-center col" placeholder="-" name="otp1" type="text" maxlength="1" required />
												<input class="otp-field form-control opt text-center col" placeholder="-" name="otp2" type="text" maxlength="1" required />
												<input class="otp-field form-control opt text-center col" placeholder="-" name="otp3" type="text" maxlength="1" required />
												<input class="otp-field form-control opt text-center col" placeholder="-" name="otp4" type="text" maxlength="1" required />
												<input class="otp-field form-control opt text-center col" placeholder="-" name="otp5" type="text" maxlength="1" required />
												<input class="otp-field form-control opt text-center col" placeholder="-" name="otp6" type="text" maxlength="1" required />
											</div>
                                            <div>
                                                <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Continue</button>
                                            </div>

                                            <div class="mt-4 text-center">
                                                <a href="javascript:void(0)" id="resend" class="text-muted"><i class="mdi mdi-reload me-1"></i> Resend Code</a>
                                            </div>
											<div id="ajax_response"></div>
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
				var maxLength = 1;
				if (this.value.length == maxLength) {
				  $(this).next('.otp-field').focus();
				}
			});
			$(".otp-field").keydown(function () {
				if (event.keyCode == 8 && this.value.length == "") {
				  $(this).prev('.otp-field').focus();
				}
				if (event.keyCode == 46 && this.value.length == "") {
				  $(this).prev('.otp-field').focus();
				}
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
