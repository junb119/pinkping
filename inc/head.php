<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/dbcon.php';

if(isset($_COOKIE['recent_viewed'])){
    $recent_viewed = json_decode($_COOKIE['recent_viewed']);
    $resultString = implode(",", $recent_viewed);
    
    $sql = "SELECT * FROM products WHERE pid in ({$resultString})";
    $result = $mysqli -> query($sql);
    while($row = $result ->fetch_object()){
        $rva[] = $row;
    }
    // print_r($rva);
}
$ssid =session_id();
$cartSql = "SELECT p.thumbnail, p.pid, p.name, p.price, c.cartid, c.cnt, c.options, c.total FROM products p join cart c on p.pid=c.pid WHERE c.ssid='{$ssid}'";


// echo $cartSql;
$cartResult = $mysqli->query($cartSql);
while ($row = $cartResult->fetch_object()){
    $cartArr[] =$row;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title><?=$title;?> | Karl - Fashion Ecommerce</title>

    <!-- Favicon  -->
    <link rel="icon" href="img/core-img/favicon.ico">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="css/core-style.css">
    <link rel="stylesheet" href="style.css">

    <!-- Responsive CSS -->
    <link href="css/responsive.css" rel="stylesheet">

</head>

<body>
    <div class="catagories-side-menu">
        <!-- Close Icon -->
        <div id="sideMenuClose">
            <i class="ti-close"></i>
        </div>
        <!--  Side Nav  -->
        <div class="nav-side-menu">
            <div class="menu-list">
                <h6>Categories</h6>
                <ul id="menu-content" class="menu-content collapse out">
                    <!-- Single Item -->
                    <li data-toggle="collapse" data-target="#women" class="collapsed active">
                        <a href="#">Woman wear <span class="arrow"></span></a>
                        <ul class="sub-menu collapse" id="women">
                            <li><a href="#">Midi Dresses</a></li>
                            <li><a href="#">Maxi Dresses</a></li>
                            <li><a href="#">Prom Dresses</a></li>
                            <li><a href="#">Little Black Dresses</a></li>
                            <li><a href="#">Mini Dresses</a></li>
                        </ul>
                    </li>
                    <!-- Single Item -->
                    <li data-toggle="collapse" data-target="#man" class="collapsed">
                        <a href="#">Man Wear <span class="arrow"></span></a>
                        <ul class="sub-menu collapse" id="man">
                            <li><a href="#">Man Dresses</a></li>
                            <li><a href="#">Man Black Dresses</a></li>
                            <li><a href="#">Man Mini Dresses</a></li>
                        </ul>
                    </li>
                    <!-- Single Item -->
                    <li data-toggle="collapse" data-target="#kids" class="collapsed">
                        <a href="#">Children <span class="arrow"></span></a>
                        <ul class="sub-menu collapse" id="kids">
                            <li><a href="#">Children Dresses</a></li>
                            <li><a href="#">Mini Dresses</a></li>
                        </ul>
                    </li>
                    <!-- Single Item -->
                    <li data-toggle="collapse" data-target="#bags" class="collapsed">
                        <a href="#">Bags &amp; Purses <span class="arrow"></span></a>
                        <ul class="sub-menu collapse" id="bags">
                            <li><a href="#">Bags</a></li>
                            <li><a href="#">Purses</a></li>
                        </ul>
                    </li>
                    <!-- Single Item -->
                    <li data-toggle="collapse" data-target="#eyewear" class="collapsed">
                        <a href="#">Eyewear <span class="arrow"></span></a>
                        <ul class="sub-menu collapse" id="eyewear">
                            <li><a href="#">Eyewear Style 1</a></li>
                            <li><a href="#">Eyewear Style 2</a></li>
                            <li><a href="#">Eyewear Style 3</a></li>
                        </ul>
                    </li>
                    <!-- Single Item -->
                    <li data-toggle="collapse" data-target="#footwear" class="collapsed">
                        <a href="#">Footwear <span class="arrow"></span></a>
                        <ul class="sub-menu collapse" id="footwear">
                            <li><a href="#">Footwear 1</a></li>
                            <li><a href="#">Footwear 2</a></li>
                            <li><a href="#">Footwear 3</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div id="wrapper">

        <!-- ****** Header Area Start ****** -->
        <header class="header_area">
            <!-- Top Header Area Start -->
            <div class="top_header_area">
                <div class="container h-100">
                    <div class="row h-100 align-items-center justify-content-end">

                        <div class="col-12 col-lg-12">
                            <div class="top_single_area d-flex align-items-center">
                                <!-- recent view Area -->
                                <div class="header-cart-menu d-flex align-items-center mr-auto">
                                    <!-- Cart Area -->
                                    <div class="recentview">
                                        <a href="#" id="header-recent-btn" target="_blank"><span
                                                class="cart_quantity">2</span> <i class="ti-bag"></i> recent viewed</a>
                                        <!-- Cart List Area Start -->
                                        <ul class="recent-list">
                                            <?php
                                            if (isset($rva)) {
                                                foreach($rva as $item) {
                                            ?>
                                            <li>
                                                <a href="/pinkping/product-details.php?pid=<?=$item->pid?>" class="image"><img src="<?= $item->thumbnail?>"
                                                        class="cart-thumb" alt=""></a>
                                                <div class="cart-item-desc">
                                                    <h6><a href="/pinkping/product-details.php?pid=<?=$item->pid?>"><?= $item->name?></a></h6>
                                                    <h6><?= $item->price?></h6>
                                                </div>
                                            </li>
                                            <?php
                                            }}
                                            ?>
                                        </ul>
                                    </div>

                                </div>
                                <!-- Logo Area -->
                                <div class="top_logo">
                                    <a href="index.php"><img src="img/core-img/logo.png" alt=""></a>
                                </div>
                                <!-- Cart & Menu Area -->
                                <div class="header-cart-menu d-flex align-items-center ml-auto">
                                    <!-- Cart Area -->
                                    
                                    <div class="cart">
                                        <a href="#" id="header-cart-btn" target="_blank">
                                        <?php if (isset($cartArr)) {  ?>    
                                        <span
                                                class="cart_quantity"><?=count($cartArr);?></span>
                                                <?php } ?>
                                                <i class="ti-bag"></i> Your Bag $20</a>
                                        <!-- Cart List Area Start -->
                                        <ul class="cart-list">
                                            <?php
                                            if (isset($cartArr)){
                                                foreach($cartArr as $ca) {
                                            ?>
                                            <li>
                                                <a href="pinkping/product-details.php?pid=<?=$ca->pid?>" class="image"><img src="<?=$ca->thumbnail?>"
                                                        class="cart-thumb" alt=""></a>
                                                <div class="cart-item-desc">
                                                    <h6><a href="pinkping/product-details.php?pid=<?=$ca->pid;?>"><?=$ca->name?></a></h6>
                                                    <p><?=$ca->options?> x <span class="price"><?=$ca->cnt?></span></p>
                                                </div>
                                                <span class="dropdown-product-remove"><i class="icon-cross"></i></span>
                                            </li>
                                            <?php
                                            }}
                                            ?>
                                        </ul>
                                    </div>
                                    <div class="header-right-side-menu ml-15">
                                        <a href="#" id="sideMenuBtn"><i class="ti-menu" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Top Header Area End -->
            <div class="main_header_area">
                <div class="container h-100">
                    <div class="row h-100">
                        <div class="col-12 d-md-flex justify-content-between">
                            <!-- Header Social Area -->
                            <div class="header-social-area">
                                <a href="#"><span class="karl-level">Share</span> <i class="fa fa-pinterest"
                                        aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                            </div>
                            <!-- Menu Area -->
                            <div class="main-menu-area">
                                <nav class="navbar navbar-expand-lg align-items-start">

                                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                                        data-target="#karl-navbar" aria-controls="karl-navbar" aria-expanded="false"
                                        aria-label="Toggle navigation"><span class="navbar-toggler-icon"><i
                                                class="ti-menu"></i></span></button>

                                    <div class="collapse navbar-collapse align-items-start collapse" id="karl-navbar">
                                        <ul class="navbar-nav animated" id="nav">
                                            <li class="nav-item active"><a class="nav-link" href="index.html">Home</a>
                                            </li>
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="#" id="karlDropdown"
                                                    role="button" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">Pages</a>
                                                <div class="dropdown-menu" aria-labelledby="karlDropdown">
                                                    <a class="dropdown-item" href="index.php">Home</a>
                                                    <a class="dropdown-item" href="shop.php">Shop</a>
                                                    <a class="dropdown-item" href="product-details.php">Product
                                                        Details</a>
                                                    <a class="dropdown-item" href="cart.php">Cart</a>
                                                    <a class="dropdown-item" href="checkout.html">Checkout</a>
                                                </div>
                                            </li>
                                            <li class="nav-item"><a class="nav-link" href="#">Dresses</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#"><span
                                                        class="karl-level">hot</span> Shoes</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                                        </ul>
                                    </div>
                                </nav>
                            </div>
                            <!-- Help Line -->
                            <div class="help-line">
                                <a href="tel:+346573556778"><i class="ti-headphone-alt"></i> +34 657 3556 778</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- ****** Header Area End ****** -->

        <!-- ****** Top Discount Area Start ****** -->
        <section class="top-discount-area d-md-flex align-items-center">
            <!-- Single Discount Area -->
            <div class="single-discount-area">
                <h5>Free Shipping &amp; Returns</h5>
                <h6><a href="#">BUY NOW</a></h6>
            </div>
            <!-- Single Discount Area -->
            <div class="single-discount-area">
                <h5>20% Discount for all dresses</h5>
                <h6>USE CODE: Colorlib</h6>
            </div>
            <!-- Single Discount Area -->
            <div class="single-discount-area">
                <h5>20% Discount for students</h5>
                <h6>USE CODE: Colorlib</h6>
            </div>
        </section>
        <!-- ****** Top Discount Area End ****** -->