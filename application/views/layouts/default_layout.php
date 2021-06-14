<?php
$isloggedin = $this->session->userdata('email') ? true : false;
$role = $isloggedin ? $this->session->userdata('role') : '';
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.facebook.com/2008/fbml">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=9" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=0" />
    <meta property="og:type" content="article" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <?php
    $meta_array = array(
        'title' => '',
        'image' => '',
        'description' => ''
    );

    if ($meta_array['title'] != '' || $meta_array['image'] != '' || $meta_array['description'] != '') {
    ?>
        <meta property="og:title" content="<?= $meta_array['title'] ?>" />
        <meta property="og:image" content="<?= $meta_array['image'] ?>" />
        <meta property="og:description" content="<?= $meta_array['description'] ?>" />
    <?php
    }
    ?>
    <meta name="twitter:site" content="" />
    <meta name="twitter:card" content="" />
    <meta name="twitter:creator" content="" />
    <meta name="theme-color" content="#ffffff" />
    <meta name="msapplication-navbutton-color" content="#ffffff" />
    <meta name="format-detection" content="telephone=no" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="/static/js/common/jquery_min.js" defer=""></script>
    <link href="/static/images/logo.png" type="image/x-icon" rel="icon" />
    <script src="/static/cdn/js/bootstrap.min.js" defer=''></script>
    <link rel="stylesheet" href="<?= base_url() ?>/static/cdn/css/bootstrap.min.css" />
    <title>.:.</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="/static/js/common/validate.js" defer="" type="text/javascript"></script> <!-- responsbale for validation -->
    <!-- <script src="/static/js/common/ui.js" defer="" type="text/javascript"></script> -->
    <script src="/static/js/common/npprogress.js" defer="" type="text/javascript"></script>
    <link rel="stylesheet" href="/static/css/common/np.css">
    <link rel="stylesheet" href="/static/css/common/offline-theme-chrome.css">
    <link rel="stylesheet" href="/static/css/common/offline-language-english.css">
    <link rel="stylesheet" href="/static/css/common/common.css">
    <script src="/static/js/common/form.js" defer="" type="text/javascript"></script>
    <!-- <script src="/static/js/common/migrate.js" defer="" type="text/javascript"></script> -->
    <script src="<?= base_url() ?>/static/js/common/base.js"></script>
    <!-- <script src="<?= base_url() ?>/static/js/common/offline.js"></script> -->
    <script src="<?= base_url() ?>/static/js/common/offline.min.js"></script>

    <script src="<?= base_url() ?>/static/js/common/alert.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body id="body">
    <div class="header" id="header">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid container">
                <a class="navbar-brand mb-0 h1" href="/"><i class="fa fa-home"></i> Hub</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <?php if ($isloggedin) {
                            if ($role == "seller") { ?>

                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="/seller/shop">Shop</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="/product/addproduct"> Add products</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="/product/adminProduct"> Admin Products</a>
                                </li>
                            <?php  } ?>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="/checkout/orders"><i class="fa fa-first-order" aria-hidden="true"></i> Orders</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="/cart"><i class="fa fa-shopping-cart"></i> Cart</a>
                            </li>
                        <?php  } ?>

                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/home/about"><i class="fa fa-info" aria-hidden="true"></i></a>
                        </li>

                    </ul>
                    <form class="d-flex">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <?php if ($isloggedin) { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="/profile"> <i class="fa fa-user"></i> Profile</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/credentials/logout"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
                                </li>
                            <?php  } else { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="/credentials/login"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/credentials/signup"><i class="fa fa-user-plus"></i> Signup</a>
                                </li>
                                <div class="dropdown">
                                    <a class="nav-link dropdown-toggle" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="<?php echo base_url() ?>static/images/google_logo.png" alt="">
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <li><a class="dropdown-item" href="/credentials/get_google/login">Login</a></li>
                                        <li><a class="dropdown-item" href="/credentials/get_google/buyer">Sign up as Buyer</a></li>
                                        <li><a class="dropdown-item" href="/credentials/get_google/seller">Sign up as seller</a></li>
                                    </ul>
                                </div>
                            <?php  } ?>
                        </ul>
                    </form>
                </div>
            </div>
        </nav>
    </div>
    <!-- <div class="container p-5">
        <div class="alert alert-warning offline none">You can only sign in when you have an active internet connection.</div>
        <div class="alert alert-success online none">active internet connection.</div>
    </div> -->
    <div id="wrapper">
        <?php echo $content ?>
    </div>
</body>
<script src="<?= base_url() ?>/static/js/common/load.js"></script>

</html>