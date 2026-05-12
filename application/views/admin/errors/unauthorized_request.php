<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Unauthorized Access | <?php echo WEBSITE_NAME; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="Company" name="description" />
    <meta content="Company" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo base_url('admin_assets/images/favicon.ico'); ?>" />

    <!-- Bootstrap Css -->
    <link href="<?php echo base_url('admin_assets/css/bootstrap.min.css'); ?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?php echo base_url('admin_assets/css/icons.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?php echo base_url('admin_assets/css/app.min.css'); ?>" id="app-style" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('admin_assets/css/custom.css'); ?>" rel="stylesheet" type="text/css" />
</head>

<body class="authentication-bg bg-primary">
    <div class="home-center">
        <div class="home-desc-center">
            <div class="container">
                <div class="home-btn pt-lg-5">
                    <a href="<?php echo base_url(); ?>" class="text-white router-link-active"><i class="fas fa-home h2"></i></a>
                </div>

                <div class="row justify-content-center pt-5">
                    <div class="col-md-5 col-lg-5 col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="px-2 py-3">

                                    <div class="text-center">
                                        <a href="<?php echo base_url(); ?>">
                                            <img src="<?php echo base_url('assets/image/logo.png'); ?>" alt="logo">
                                        </a>

                                    </div>
                                    <div class="text-center p-3">
                                        <h1 class="error-page mt-5" style="font-size: 20px;"><span>Unauthorized Access!</span></h1>
                                        <p class="mb-4 mx-auto">Sorry, You do not have permission to access this page. </p>
                                        <a class="btn btn-primary waves-effect waves-light" href="<?php echo base_url('admin'); ?>"><i class="mdi mdi-home"></i> Go To Home</a>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="mt-1 text-center text-white">
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
    <script src="<?php echo base_url('admin_assets/js/app.js'); ?>"></script>
</body>

</html>