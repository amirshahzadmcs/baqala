<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <base href="<?php echo base_url(); ?>" />
    <meta content="ie=edge" http-equiv="X-UA-Compatible">
    <title>Baqala Station</title>
    <link href="img/Fevicon.png" rel="icon" type="image/png">
    <link href="css/style.css" rel="stylesheet">
    <link href="images/front/favicon.png" rel="shortcut icon">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Philosopher:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Tenali+Ramakrishna&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />


</head>

<body>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            overflow-x: hidden;
        }

        * {
            padding: 0px;
            margin: 0px;
        }

        .upcoming-page {
            background-image: url('./images/front/home-bg.png');
            background-size: cover;
            padding-bottom: 50px;
            min-height: 800px;
            height: 100vh;

        }

        .container {
            max-width: 1240px;
            margin: 0 auto;
            padding: 20px;
        }

        .logo a img {
            width: 20%;
            /* background: #fff; */
        }

        .upcoming-content {
            margin-top: 40px;
            color: #fff;
            font-size: 45px;
            font-weight: 600;
            line-height: 70px;
            letter-spacing: 1.5px;
            font-family: 'Roboto', sans-serif;
        }

        .download-content h3 {
            color: #ffff00;
            font-size: 46px;
            font-weight: 600;
            font-family: 'Philosopher', sans-serif;
            letter-spacing: 1px;
        }

        .download-content p {
            color: #fff;
        }

        .download-content p {
            font-size: 18px;
            letter-spacing: 1px;
            color: #fff;
            padding: 10px 0px;
        }

        .questions {
            margin: 10px 0px;
        }

        .questions span {
            color: #fff;
            font-weight: 600;
        }

        .questions p {
            color: #fff;
            line-height: 32px;
            font-size: 18px;
            letter-spacing: 1px;
            font-weight: normal;
        }

        .download-btn p {
            color: #fff;
            letter-spacing: 1px;
            font-size: 18px;
            padding-top: 20px;
        }

        .download-btn {
            margin-top: 20px;
        }

        .shopping-step li {
            list-style: none;
            color: #fff;
            display: inline-block;
            text-align: center;
            margin-right: 24px;
            margin-top: 30px;
            margin-bottom: 30px;
        }

        .shopping-step li span img {
            border-radius: 50%;
            background: #fff;
            height: 50px;
            width: 50px;
            display: block;
            padding: 5px;
        }

        .policy-icon {
            border-top: 1px solid#789c8a;
            width: 40%;
            margin-top: 20px;
        }

        .policy-icon li {
            line-height: none;
            display: inline-block;
            margin-top: 20px;
            margin-right: 20px;
        }

        .policy-icon li a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            transition: 0.6s;
            font-weight: 500;
            letter-spacing: 1px;
        }

        .policy-icon li a:hover {
            color: #ff0;
        }

        .social-icon li {
            list-style: none;
            display: inline-block;
            margin-top: 20px;
            margin-right: 20px;
        }

        .social-icon li a {
            background: #fff;
            color: #000;
            height: 40px;
            width: 40px;
            line-height: 40px;
            display: block;
            text-align: center;
            font-size: 21px;
            border-radius: 50%;
            text-decoration: none;
        }

        .social-icon li a:hover {
            background: #ff0;
            color: #000;
        }

        .upcoming-content span {
            padding: 5px 20px;
            background: #fff;
            color: #000000;
        }

        .upcoming-content span {
            width: 100%;
            height: 100%;
            color: black;
            font-weight: bold;
            animation: myanimation 8s infinite;
        }

        @keyframes myanimation {
            0% {
                background-color: #bbd62f;
            }

            25% {
                background-color: #e2e201;
            }

            50% {
                background-color: #ffbaa6;
            }

            75% {
                background-color: #e4ff00ad;
            }

            100% {
                background-color: #cc6e16;
            }
        }

        @media (max-width:768px) {


            .upcoming-content {
                font-size: 26px;
                margin-top: 10px;
            }

            .download-content h3 {
                font-size: 28px;
            }

            .upcoming-page {
                padding-bottom: 50px;
                min-height: 460px;
                height: 100vh;
            }


        }



        @media (max-width:520px) {

            body {
                overflow-x: auto;
            }

            .logo a img {
                width: 40%;

            }

            .upcoming-content {
                font-size: 18px;
                margin-top: 0px;
                line-height: 30px;
                margin-top: 15px;

            }

            .download-content h3 {
                font-size: 21px;
            }

            .policy-icon {
                width: 100%;
            }

            .questions p {
                font-size: 16px;

            }

            .download-btn {

                margin-top: 0px;

            }

            .download-btn p {
                font-size: 16px;
                padding-top: 10px;

            }

            .download-content p {
                font-size: 16px;
            }

            .social-icon li {
                margin-top: 10px;


            }

            .upcoming-page {
                min-height: 700px;


            }

            .shopping-step li {
                margin-right: 24px;
                margin-top: 10px;

            }

            .shopping-step li span img {
                height: 40px;
                width: 40px;
                padding: 3px;

            }

            .upcoming-page {

                padding-bottom: 50px;
                min-height: 650px;
                height: 100vh;

            }

            .download-content p {
                line-height: 26px;
            }

            .download-btn p {
                line-height: 26px;
            }
        }

        @media (max-width:375px) {

            .policy-icon li a {
                font-size: 15px;
            }

            .shopping-step li {
                margin-right: 30px;
            }
        }

        .login-urls {
            padding: 14px 20px;
            background: #fff;
            font-weight: 600;
            color: #000;
            text-decoration: none;
            border-radius: 42px;
        }

        .login-urls:hover {
            background: #4caf50;
            color: #fff;
        }
    </style>
    <div class="upcoming-page">
        <div class="container">
            <div class="logo">
                <a href="#"><img alt="logo" src="assets/image/logo.png"></a>
            </div>
            <div class="upcoming-content">
                Groceries delivered from store to door
            </div>
            <div class="download-content">
                <h3>Download Baqala Station<sup>®️</sup></h3>
                <p>and just order your grocery from the comfort of your home</p>
            </div>
            <div class="questions">
                <p><span>Any questions :</span> cc@baqalastation.com</p>
                <p><span>Talk to us :</span> 0593935577</p>
            </div>
            <div class="download-btn">
                <a href="#"><img alt="logo" src="images/front/app-icon.png"></a>
                <!-- <p>Baqala Station®️ is a new store to door grocery service in a jiffy.</p> -->
                <p>Login Url.</p>
            </div>
            <div class="shopping-step">
                <ul>
                    <li><a href="<?php echo base_url('login'); ?>" class="login-urls" target="_blank"><i class="fa fa-lock"></i> B2B Login</a></li>
                    <li><a href="<?php echo base_url('logistic-partner/login'); ?>" class="login-urls" target="_blank"><i class="fa fa-lock"></i> Logistic Partner</a></li>
                    <li><a href="<?php echo base_url('delivery-partner/login'); ?>" class="login-urls" target="_blank"><i class="fa fa-lock"></i> Rider Login</a></li>
                    <li><a href="<?php echo base_url('store/login'); ?>" class="login-urls" target="_blank"><i class="fa fa-lock"></i> Store Login</a></li>
                    <li><a href="<?php echo base_url('hiring-agency/login'); ?>" class="login-urls" target="_blank"><i class="fa fa-lock"></i> Hiring Agency</a></li>
                    <li><a href="<?php echo base_url('team-leader/login'); ?>" class="login-urls" target="_blank"><i class="fa fa-lock"></i> Team Leader</a></li>
                    <li><a href="<?php echo base_url('gate-keeper/login'); ?>" class="login-urls" target="_blank"><i class="fa fa-lock"></i> Gate Keeper</a></li>
                    <!-- <li><span><img alt="logo" src="images/front/icon-1.png"></span><br>
                    1- Login</li>
                    <li><span><img alt="logo" src="images/front/icon-2.png"></span><br>
                    2- Pick</li>
                    <li><span><img alt="logo" src="images/front/icon-3.png"></span><br>
                    3- Cart</li> -->
                </ul>
            </div>
            <div class="policy-icon">
                <ul>
                    <li>
                        <a href="#">Privacy Policy</a>
                    </li>
                    <li>
                        <a href="#">Terms & Conditions</a>
                    </li>
                </ul>
            </div>
            <div class="social-icon">
                <ul>
                    <li>
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>



</body>

</html>