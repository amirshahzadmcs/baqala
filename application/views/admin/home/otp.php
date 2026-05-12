<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Login | <?php echo WEBSITE_NAME; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta content="Company" name="description" />
        <meta content="Company" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo base_url('admin_assets/images/favicon.ico');?>" />

        <!-- Bootstrap Css -->
        <link href="<?php echo base_url('admin_assets/css/bootstrap.min.css');?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="<?php echo base_url('admin_assets/css/icons.min.css');?>" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="<?php echo base_url('admin_assets/css/app.min.css');?>" id="app-style" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url('admin_assets/css/custom.css');?>" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<style>
			.social-login .google-login{
				color: #5f5d5d;
				font-weight: 700;
				background: #ffffff;
				padding: 7px 56px;
				box-shadow: 0px 0px 3px;
				text-align: center;
				font-size: 18px;
			}
			.google-login:hover{
				text-decoration:none;
				color: #000;
			}
			.border-heading h4 {
			  display: flex;
			  align-items: center;
			  padding: 10px 0px;
			  font-size: 16px;
			}

			.border-heading h4:before,
			.border-heading h4:after {
			  content: "";
			  width: 100%;
			  height: 1px;
				background: #c3c3c3;
			}

			.border-heading h4:before{
			  margin: 0 40px 0 0;
			}

			.border-heading h4:after{
			  margin: 0 0 0 40px;
			}

            input[type="number"] {
                -webkit-appearance: textfield;
                -moz-appearance: textfield;
                appearance: textfield;
            }

            .otp-form {
                margin-top: 20px;
                padding: 20px;
                background-color: #fff;
                border-radius: 12px;
            }

            .otp-form .form-group {
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: nowrap;
                gap: 10px;
            }

            .otp-form .form-group .form-label {
                position: relative;
                font-size: 15px;
                font-weight: 600;
                color: #000;
            }

            .otp-form .form-group .form-label::before {
                content: "";
                position: absolute;
                width: 4px;
                height: 25px;
                top: 0;
                left: -20px;
                transform: translateX(-50%);
                background-color: #fff;
                border-radius: 4px;
            }

            [dir="rtl"] .otp-form .form-group .form-label::before {
                left: unset;
                right: -20px;
            }

            .otp-form .form-group .form-input::-webkit-outer-spin-button,
            .otp-form .form-group .form-input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            .otp-form .form-group .form-input .form-control {
                position: relative;
                text-align: center;
                padding: 15px;
                color: #000;
                background-color: #fff;
                border: 1px solid #ddd;
                border-radius: 5px;
            }

            @media (max-width: 600px) {
            .otp-form .form-group .form-input .form-control {
                padding: calc(10px + (15 - 10) * ((100vw - 320px) / (600 - 320)));
            }
            }

            .otp-form .form-group .form-input .form-control::-moz-placeholder {
                color: #797d83;
            }

            .otp-form .form-group .form-input .form-control::placeholder {
                color: #797d83;
            }

            .otp-form .form-group .form-input .form-control:focus {
                box-shadow: none;
                border: 1px solid #0c5711;
                -webkit-appearance: textfield;
                -moz-appearance: textfield;
                appearance: textfield;
            }
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }
		</style>
    </head>

    <body class="authentication-bg bg-primary">
        <div class="home-center">
            <div class="home-desc-center">
                <div class="container">
                    <div class="home-btn pt-lg-5">
                        <a href="<?php echo base_url();?>" class="text-white router-link-active"><i class="fas fa-home h2"></i></a>
                    </div>

                    <div class="row justify-content-center pt-5">
                        <div class="col-md-5 col-lg-5 col-xl-5">
                            <div class="card">
                                <div class="card-body">
                                    <div class="px-2 py-3">
                                        <div class="text-center">
                                            <a href="<?php echo base_url();?>">
                                                <img src="<?php echo base_url('admin_assets/images/logo.png');?>"  width="50%" alt="logo" />
                                            </a>
                                            <h5 class="text-primary mb-2 mt-4">Sign In To Your Account !</h5>
                                            <p class="text-muted">Enter your details to login to your account.</p>
                                            <p class="text-muted">Welcome “<?= $this->session->userdata('admin_login_data')['email']; ?>”. <a href="<?php echo base_url('admin/change-user');?>"><small>Change User ?</small></a></p>
                                        </div>
										<?php $debugOtp = $this->session->flashdata('debug_otp'); ?>
										<?php if($debugOtp) { ?>
											<div class="alert alert-warning alert-dismissible fade show" role="alert">Local debug OTP: <strong><?= $debugOtp ?></strong> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
										<?php } ?>
										<?php if($this->session->flashdata('login_error')) { ?>
											<?php if($this->session->flashdata('is_success') == '1') { ?>
												<div class="alert alert-success alert-dismissible fade show" role="alert"><?= $this->session->flashdata('login_error') ?> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
											<?php }else{ ?>
												<div class="alert alert-danger alert-dismissible fade show" role="alert"><?= $this->session->flashdata('login_error') ?> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
											<?php } ?>
										<?php } ?>
                                        <form class="otp-form" id="otpForm" method="POST" action="<?php echo base_url('admin/verify-otp');?>">
                                            <div class="form-group d-flex justify-content-between mb-3">
                                                <?php for ($i = 1; $i <= 6; $i++): ?>
                                                    <div class="form-input">
                                                        <input type="text" class="form-control <?= $i == 1 ? 'active' : '' ?>" 
                                                            placeholder="-" name="otp[]" id="five<?= $i ?>" 
                                                            onkeyup="onKeyUpEvent(<?= $i ?>, event)" 
                                                            onfocus="onFocusEvent(<?= $i ?>)" 
                                                            maxlength="1" pattern="\d*" inputmode="numeric" required 
                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,1);" 
                                                            onkeydown="return event.key !== 'Enter';">

                                                    </div>
                                                <?php endfor; ?>
                                            </div>
											
                                            <div class="mb-3">
                                                <div class="otp-nfo">
                                                    <span id="resendTimer" class="text-muted">You can resend OTP in <span id="timer">60</span>s</span>
                                                    <span id="resendOtpContainer" style="display: none;">Didn't receive an OTP? <button id="resendOtpBtn" class="btn btn-sm btn-link p-0" onclick="resendOtp()">Try now</button></span>
                                                </div>
                                            </div>
											
                                            <div>
                                                <button class="btn btn-custom-success w-100 waves-effect waves-light" type="submit">Sign In</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-1 text-center text-white">
                                <p class="text-dark">
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
        <script src="<?php echo base_url('admin_assets/js/app.js');?>"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script> 
            /*=====================
            otp js
            =======================*/
            function getCodeBoxElement(index) {
                return document.getElementById("five" + index);
            }

            function onKeyUpEvent(index, event) {
                const input = getCodeBoxElement(index);
                const value = input.value;

                if (value.length === 1) {
                    if (index < 6) {
                        getCodeBoxElement(index + 1).focus();
                    } else {
                        input.blur(); // remove focus if last
                    }
                } else if (event.key === "Backspace" && index > 1) {
                    getCodeBoxElement(index - 1).focus();
                }
            }


            function onFocusEvent(index) {
                for (item = 1; item < index; item++) {
                    const currentElement = getCodeBoxElement(item);
                    if (!currentElement.value) {
                    currentElement.focus();
                    break;
                    }
                }
            }

            $(document).ready(function () {
                $('#otpForm').on('submit', function (e) {
                    e.preventDefault();

                    const form = $(this);
                    const url = form.attr('action');
                    const submitButton = form.find('button[type="submit"]');

                    // Collect and validate OTP values
                    let otp = [];
                    let isValid = true;

                    $('input[name="otp[]"]').each(function () {
                        const val = $(this).val().trim();
                        if (val === '' || isNaN(val)) {
                            isValid = false;
                        }
                        otp.push(val);
                    });

                    if (!isValid || otp.join('').length !== 6) {
                        toastr.error('Please enter a valid 6-digit OTP.');
                        return;
                    }

                    // Disable button while processing
                    submitButton.prop('disabled', true).text('Verifying...');

                    // AJAX request
                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            otp: otp.join('')
                        },
                        success: function (response) {
                            if (response.success) {
                                window.location.href = response.redirect_url;
                            } else {
                                toastr.error(response.message || 'Invalid OTP. Please try again.');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr.responseText);
                            toastr.error('An unexpected error occurred. Please try again.');
                        },
                        complete: function () {
                            submitButton.prop('disabled', false).text('Sign In');
                        }
                    });
                });
            });

        </script>
        <script>
            let countdown = 60;
            let timerInterval = setInterval(function () {
                countdown--;
                document.getElementById("timer").innerText = countdown;

                if (countdown <= 0) {
                    clearInterval(timerInterval);
                    document.getElementById("resendTimer").style.display = "none";
                    document.getElementById("resendOtpContainer").style.display = "inline-block";
                }
            }, 1000);

            function resendOtp() {
                // Disable button to avoid spamming
                document.getElementById("resendOtpBtn").disabled = true;
                document.getElementById("resendOtpBtn").innerText = "Resending...";

                // AJAX to call resend OTP
                fetch("<?= base_url('admin/send-otp') ?>")
                    .then(response => {
                        if (!response.ok) throw new Error("Network response was not ok");
                        return response.text(); // You can return JSON if needed
                    })
                    .then(data => {
                        toastr.success("OTP has been resent.");
                        // Restart the timer
                        countdown = 60;
                        document.getElementById("timer").innerText = countdown;
                        document.getElementById("resendTimer").style.display = "inline";
                        document.getElementById("resendOtpContainer").style.display = "none";
                        document.getElementById("resendOtpBtn").disabled = false;
                        document.getElementById("resendOtpBtn").innerText = "Try now";

                        timerInterval = setInterval(function () {
                            countdown--;
                            document.getElementById("timer").innerText = countdown;

                            if (countdown <= 0) {
                                clearInterval(timerInterval);
                                document.getElementById("resendTimer").style.display = "none";
                                document.getElementById("resendOtpContainer").style.display = "inline-block";
                            }
                        }, 1000);
                    })
                    .catch(error => {
                        toastr.error("Failed to resend OTP. Please try again.");
                        document.getElementById("resendOtpBtn").disabled = false;
                        document.getElementById("resendOtpBtn").innerText = "Try now";
                    });
            }
        </script>
    </body>
</html>
