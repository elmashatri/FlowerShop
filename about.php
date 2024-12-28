<?php

include 'connection.php';
session_start();
$user_id=$_SESSION['user_id'];
if(!isset($user_id)){
    header('location:login.php');
}


?>

<style type="text/css">
    <?php include 'main.css';?>
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icon@1.10.2/font/bootsrap-icons.css">
    <title>About Us</title>
</head>
<body>
    <?php include 'header.php';?>

    <div class="banner">
        <h1>About Us</h1>
        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Facere saepe pariatur amet a quam quae earum quidem eius ut quas, nesciunt ullam aliquid, vero, nobis magnam corporis illo aut repellat?</p>
    </div>

    <div class="about">
        <div class="row">
            <div class="detail">
                <h1>visit our beautiful showroom</h1>
                <p>Our showroom is an expression of what we love doing; being creative with floral and plant 
                 arrangements. Whether you are looking for a florist for your perfect wedding, or just want to uplift
                 any room with some one of a kind living decor, Blossom With Love can help.   
                </p>
                <a href="shop.php" class="btn2">shop now</a>
            </div>
            <div class="img-box">
                <img src="image/1.png">
            </div>
        </div>
    </div>

    <div class="banner-2">
        <h1>Let Us Make Your Wedding Flawless</h1>
        <a href="shop.php" class="btn2">shop now</a>
    </div>

    <div class="services">
        <h1 class="title">our services</h1>
        <div class="box-container">
            <div class="box">
                <i class="bi bi-percent"></i>
                <h3>30% OFF + FREE SHIPPING</h3>
                <p>Starting at $36/mo. Plus, get $120 creditlyear on regular orders</p>
            </div>
            <div class="box">
                <i class="bi bi-asterisk"></i>
                <h3>FRESHEST BLOOMS</h3>
                <p>Exclusive farm-fresh flowers with our Happiness Guarantee</p>
            </div>
            <div class="box">
                <i class="bi bi-alarm"></i>
                <h3>SUPER FLEXIBLE</h3>
                <p>Customize recipient, dat, or flowers. Skip or cancel anytime.</p>
            </div>
        </div>
    </div>

    <div class="stylist">
        <h1 class="title">Florial stylist</h1>
        <p>Meet the Team That Makes Miracles Happen</p>
        <div class="box-container">
            <div class="box">
                <div class="img-box">
                    <img src="image/team0.png">
                    <div class="social-links">
                        <i class="bi bi-instagram"></i>
                        <i class="bi bi-youtube"></i>
                        <i class="bi bi-twitter"></i>
                        <i class="bi bi-whatsapp"></i>
                        <i class="bi bi-behance"></i>
                    </div>
                </div>
                <h3>elma shatri</h3>
                <p>developer</p>
            </div>
            <div class="box">
                <div class="img-box">
                    <img src="image/team0.png">
                    <div class="social-links">
                        <i class="bi bi-instagram"></i>
                        <i class="bi bi-youtube"></i>
                        <i class="bi bi-twitter"></i>
                        <i class="bi bi-whatsapp"></i>
                        <i class="bi bi-behance"></i>
                    </div>
                </div>
                <h3>elma shatri</h3>
                <p>developer</p>
            </div>
            <div class="box">
                <div class="img-box">
                    <img src="image/team0.png">
                    <div class="social-links">
                        <i class="bi bi-instagram"></i>
                        <i class="bi bi-youtube"></i>
                        <i class="bi bi-twitter"></i>
                        <i class="bi bi-whatsapp"></i>
                        <i class="bi bi-behance"></i>
                    </div>
                </div>
                <h3>elma shatri</h3>
                <p>developer</p>
            </div>
        </div>
    </div>

    <div class="testimonial-container">
    <h1 class="title">what people say</h1>
    <div class="container">
        <div class="testimonial-item active">
            <img src="image/test.png" width="200px" height="200px">
            <h3>elma shatri</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo laboriosam culpa magni placeat voluptatem libero, cumque quasi accusamus tenetur maxime sint incidunt assumenda ex ab nihil vel, in debitis. Delectus?</p>
        </div>
        <div class="testimonial-item">
            <img src="image/test0.png" width="200px" height="200px">
            <h3>elma shatri</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo laboriosam culpa magni placeat voluptatem libero, cumque quasi accusamus tenetur maxime sint incidunt assumenda ex ab nihil vel, in debitis. Delectus?</p>
        </div>
        <div class="testimonial-item">
            <img src="image/test1.png" width="200px" height="200px">
            <h3>elma shatri</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo laboriosam culpa magni placeat voluptatem libero, cumque quasi accusamus tenetur maxime sint incidunt assumenda ex ab nihil vel, in debitis. Delectus?</p>
        </div>
        <div class="left-arrow" onclick="prevSlide();"><i class="bi bi-arrow-left"></i></div>
        <div class="right-arrow" onclick="nextSlide();"><i class="bi bi-arrow-right"></i></div>
    </div>
</div>

    <?php include 'footer.php';?>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>