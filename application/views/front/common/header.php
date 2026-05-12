<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <base href="<?php echo base_url(); ?>" />
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta content="ie=edge" http-equiv="X-UA-Compatible" />
        <title>Baqala - Your Online Grocery Supermarket</title>
        <link rel="shortcut icon" href="<?php echo base_url('assets/image/favicon.png');?>" />
        <link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet" />
        <link href="<?php echo base_url('assets/css/style.css?v1.5');?>" rel="stylesheet" />
        <link href="<?php echo base_url('assets/css/mobile-nav.css');?>" rel="stylesheet" />
        <link href="<?php echo base_url('assets/css/responsive.css?v1.2');?>" rel="stylesheet" />
        <script> var base_url = '<?php echo base_url(); ?>';</script>
        <link href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" rel="stylesheet" />
    </head>
    <body>
        <div id="flash_message" style="position: fixed;z-index: 999;width: 25%;right: 2%;top: 50px;color: #fff;"></div>
        <header>
            <div class="top_header fixed-top">
                <div class="container">
                    <div class="row align-items-center justfiy-content-center">
                        <div class="col-xl-6 col-lg-4 col-sm-3 col-4">
                            <div class="account_info">
                                <ul>
                                    <li>
                                        <nav class="navbar navbar-expand-lg">
                                            <div class="navbar-collapse" id="navbarSupportedContent">
                                                <ul class="navbar-nav">
                                                    <li class="nav-item dropdown">
                                                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                                            <span><i class="fas fa-user"></i></span> حساب 
                                                        </a>
                                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                            <li>
                                                                <a class="dropdown-item" href="<?= base_url('quotation-history');?>"><i class="fa fa-clipboard-check"></i>&nbsp;Orders </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="<?= base_url('profile');?>"><i class="fa fa-user"></i>&nbsp;Profile </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="<?= base_url('change-password');?>"><i class="fa fa-cog"></i>&nbsp;Settings </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="<?= base_url('contact-us');?>"><i class="fa fa-envelope"></i>&nbsp;Contact us </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="<?= base_url('logout');?>"><i class="fa fa-sign-out-alt"></i>&nbsp;Logout </a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </div>
                                        </nav>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-8 col-md-9 col-sm-9 col-8">
                            <div class="top-bar-right text-end">
                                <ul>
                                    <li class="mb-search-bar">
                                        <div class="mb-search">
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#searchModal">
                                                <i class="fal fa-search"></i>
                                            </button>
                                        </div>
                                    </li>
                                    <li class="search-bar">
                                        <?php echo form_open('search', array("method"=>"get","id"=>"searchForm")); ?>
                                            <div class="search">
                                                <i class="fa fa-search"></i>
                                                <input type="search" name="term" class="form-control txt_search" autocomplete="off" placeholder="<?php echo $this->lang->line('msg_search_placeholder') ?>.." />
                                            </div>
                                        <?php echo form_close();?>
                                        <div class="searchResult"></div>
                                    </li>
                                    <li>
                                        <div class="cart">
                                            <a href="<?= base_url('cart');?>">
                                                <i class="fal fa-shopping-bag"></i>
                                                <span id="cart_number"><?php echo $this->customer->inCart();?></span><div class="loading"></div> <abbr></abbr>
                                            </a>
                                        </div>
                                    </li>
                                    
                                    <li class="checkout <?=($this->uri->segment(1) == 'checkout' ? 'd-none' : '');?>">
                                        <button onclick="window.location.href='<?= base_url();?>checkout'" <?= ($this->customer->inCart() > 0) ? '' : 'disabled'; ?>>Checkout <i class="fal fa-chevron-right"></i></button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="middle-header navigations">
                <div class="container">
                    <nav class="navbar navbar-expand-lg navbar-dark">
                        <div class="container mt-5">
                            <div class="logo">
                                <a class="nav-brand" href="<?= base_url();?>"><img alt="logo" src="assets/image/logo.png" /></a>
                            </div>
                            <button class="navbar-toggler btn-open first text-dark" type="button">
                                <i class="fal fa-bars"></i>
                            </button>
                            <div class="collapse navbar-collapse text-end" id="main_nav">
                                <ul class="navbar-nav ms-auto">
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?= base_url();?>">Home <span>مسكن</span> </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="<?= base_url();?>">Products <span>منتجات</span> </a>
                                    </li>

                                    <li class="nav-item"><a href="<?= base_url('contact-us');?>" class="nav-link">Contact Us</a></li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </header>
        <!-- =======================header End======================= -->