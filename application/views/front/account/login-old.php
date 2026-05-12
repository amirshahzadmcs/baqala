<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <base href="<?php echo base_url(); ?>" />
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta content="ie=edge" http-equiv="X-UA-Compatible" />
        <title>Baqala Station B2B | Login</title>
        <link rel="shortcut icon" href="<?php echo base_url('assets/image/favicon.png');?>" />
        <link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet" />
          
        <link href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" rel="stylesheet" />
        <style>
            body, html {
                height: 100%;
                background-repeat: no-repeat;
                background-color: #f7f2eb;
                overflow: hidden;
                position: relative;
                height: 100%;
            }
            .card-container.card {
                max-width: 400px;
                padding: 40px 40px;
            }

            .btn {
                font-weight: 700;
                height: 36px;
                -moz-user-select: none;
                -webkit-user-select: none;
                user-select: none;
                cursor: default;
            }

            /*
            * Card component
            */
            .card {
                background-color: #ffffff;
                /* just in case there no content*/
                padding: 20px 25px 30px;
                margin: 0 auto 25px;
                margin-top: 50px;
                /* shadows and rounded borders */
                -moz-border-radius: 2px;
                -webkit-border-radius: 2px;
                border-radius: 2px;
                -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
                -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
                box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
            }

            .profile-img-card {
                margin: 0 auto 10px;
                display: block;
            }

            /*
            * Form styles
            */
            .profile-name-card {
                font-size: 16px;
                font-weight: bold;
                text-align: center;
                margin: 10px 0 0;
                min-height: 1em;
            }

            .reauth-email {
                display: block;
                color: #404040;
                line-height: 2;
                margin-bottom: 10px;
                font-size: 14px;
                text-align: center;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
                -moz-box-sizing: border-box;
                -webkit-box-sizing: border-box;
                box-sizing: border-box;
            }

            .form-signin #inputEmail,
            .form-signin #inputPassword {
                direction: ltr;
                height: 44px;
                font-size: 16px;
            }

            .form-signin input[type=email],
            .form-signin input[type=password],
            .form-signin input[type=text],
            .form-signin button {
                width: 100%;
                display: block;
                margin-bottom: 10px;
                z-index: 1;
                position: relative;
                -moz-box-sizing: border-box;
                -webkit-box-sizing: border-box;
                box-sizing: border-box;
            }

            .form-signin .form-control:focus {
                border-color: rgb(104, 145, 162);
                outline: 0;
                -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgb(104, 145, 162);
                box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgb(104, 145, 162);
            }

            .btn.btn-signin {
                /*background-color: #4d90fe; */
                background-color: rgb(104, 145, 162);
                /* background-color: linear-gradient(rgb(104, 145, 162), rgb(12, 97, 33));*/
                padding: 0px;
                font-weight: 700;
                font-size: 14px;
                height: 36px;
                -moz-border-radius: 3px;
                -webkit-border-radius: 3px;
                border-radius: 3px;
                border: none;
                -o-transition: all 0.218s;
                -moz-transition: all 0.218s;
                -webkit-transition: all 0.218s;
                transition: all 0.218s;
            }

            .btn.btn-signin:hover,
            .btn.btn-signin:active,
            .btn.btn-signin:focus {
                background-color: rgb(12, 97, 33);
            }

            .forgot-password {
                color: rgb(104, 145, 162);
            }

            .forgot-password:hover,
            .forgot-password:active,
            .forgot-password:focus{
                color: rgb(12, 97, 33);
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="card card-container">
                <img id="profile-img" class="profile-img-card" src="<?= base_url('assets/image/logo.png');?>" />
                <p id="profile-name" class="profile-name-card"></p>
                <?php if ($this->session->flashdata('login_msg')) { ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <?= $this->session->flashdata('login_msg') ?>
                    </div>
                <?php } ?>
                <form class="form-signin" action="<?= base_url('login-submit');?>" method="POST">
                    <input type="hidden" name="auth" value="<?php echo md5(time()."f2sf1b35z4b");?>" />
                    <input type="hidden" name="redirection_path" value="<?php echo $this->input->get('arial_path');?>" />
                    <div class="form-group mb-3">
                        <label class="mb-1">Corporate ID</label>
                        <input type="text" name="email" class="form-control" placeholder="Enter Corporate ID" maxlength="<?= CR_LENGTH; ?>" autocomplete="off" required autofocus />
                    </div>
					<div class="form-group mb-3">
                        <label class="mb-1">Username</label>
                        <input type="text" id="inputUsername" name="username" class="form-control" placeholder="Enter Username" maxlength="55" autocomplete="off" required autofocus />
                    </div>
                    <div class="form-group">
                        <label class="mb-1">Password</label>
                        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Enter Password" autocomplete="off" required />
                    </div>
					<!--
                    <div class="form-group mb-3 float-end">
                        <a href="#" class="forgot-password">
                            Forgot the password?
                        </a>
                    </div>
					-->
					<div class="form-group mt-4">
                    	<button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Sign in</button>
					</div>
                </form>
                <!-- /form -->
                <!--<p class="mt-2 text-center">New Customer? <a href="#" class="forgot-password">Signup</a></p>-->
            </div>
            <!-- /card-container -->
        </div>
        <!-- /container -->

        <script src="<?php echo base_url('assets/js/jquery.min.js');?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
    </body>
</html>
