<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" href="<?php $this->asset('css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?php $this->asset('css/unicons.css') ?>">
    <link rel="stylesheet" href="<?php $this->asset('css/owl.carousel.min.css') ?>">
    <link rel="stylesheet" href="<?php $this->asset('css/owl.theme.default.min.css') ?>">

    <!-- MAIN STYLE -->
    <link rel="stylesheet" href="<?php $this->asset('css/tooplate-style.css') ?>">


</head>

<body>

<!-- MENU -->
<nav class="navbar navbar-expand-sm navbar-light">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a href="<?php $this->url('home/home'); ?>" class="nav-link"><span data-hover="home">Home</span></a>
                </li>
                <!--                <li class="nav-item">-->
                <!--                    <a href="#project" class="nav-link"><span data-hover="Projects">Projects</span></a>-->
                <!--                </li>-->
                <!--                <li class="nav-item">-->
                <!--                    <a href="#resume" class="nav-link"><span data-hover="Resume">Resume</span></a>-->
                <!--                </li>-->
                <!--                <li class="nav-item">-->
                <!--                    <a href="#contact" class="nav-link"><span data-hover="Contact">Contact</span></a>-->
                <!--                </li>-->
            </ul>

            <ul class="navbar-nav ml-lg-auto">
                <div class="ml-lg-4">
                    <div class="color-mode d-lg-flex justify-content-center align-items-center">
                        <i class="color-mode-icon"></i> Color mode
                    </div>
                </div>
            </ul>
        </div>
    </div>
</nav>

<!-- ABOUT -->
<section class="about full-screen d-lg-flex justify-content-center align-items-center" id="about">
    <div class="container">
        <div class="row">

            <div class="col-lg-6 col-md-12 col-12 d-flex align-items-center">
                <div class="login-wrapper my-auto col-lg-10 col-md-12 col-12">
                    <h1 class="login-title">Log in</h1>
                    <form action="<?php $this->url('user/userLogin'); ?>" method="post" class="form-group">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control"
                                   placeholder="email@example.com">
                        </div>
                        <div class="form-group mb-4">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control"
                                   placeholder="enter your passsword">
                        </div>
                        <input name="login" id="login"
                               class="btn btn-block login-btn  custom-btn custom-btn-bg custom-btn-link" type="submit"
                               value="Login">
                    </form>
                    <p class="login-wrapper-footer-text">Don't have an account? <a
                                href="<?php $this->url('user/registration'); ?>" class="text-reset">Register
                            here</a></p>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 col-12">
                <div class="about-image svg">
                    <img src="<?php $this->asset('images/what-is-cloud-storage-intro-700x544.png') ?>" class="img-fluid"
                         alt="svg image">
                </div>
            </div>

        </div>
    </div>
</section>
<footer class="footer py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-12">
            </div>
        </div>
    </div>
</footer>

<script src="<?php $this->asset('js/jquery-3.3.1.min.js') ?>"></script>
<script src="<?php $this->asset('js/popper.min.js') ?>"></script>
<script src="<?php $this->asset('js/bootstrap.min.js') ?>"></script>
<script src="<?php $this->asset('js/Headroom.js') ?>"></script>
<script src="<?php $this->asset('js/jQuery.headroom.js') ?>"></script>
<script src="<?php $this->asset('js/owl.carousel.min.js') ?>"></script>
<script src="<?php $this->asset('js/smoothscroll.js') ?>"></script>
<script src="<?php $this->asset('js/custom.js') ?>"></script>

</body>

</html>