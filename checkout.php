<?php

include 'connection.php';
session_start();
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
    exit();
}


?>

<style type="text/css">
    <?php include 'main.css'; ?>
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <title>Flower Shop</title>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="banner">
        <h1>Checkout Page</h1>
        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Facere saepe pariatur amet a quam quae earum quidem eius ut quas, nesciunt ullam aliquid, vero, nobis magnam corporis illo aut repellat?</p>
    </div>
    
    <div class="checkout-form">
        <h1 class="title">payment process</h1>
        <div class="display-order">
            <?php
                $select_cart=mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id='$user_id'");
                $total=0;
                $grand_total=0;
                if(mysqli_num_rows($select_cart)>0){
                    while($fetch_cart=mysqli_fetch_assoc($select_cart)){
                        $total_price=number_format($fetch_cart['price']*$fetch_cart['quantity']);
                        $grand_total=$total+=$total_price;

                ?>
                <span><?= $fetch_cart['name'];?>(<?= $fetch_cart['quantity'];?>)</span>
                <?php
                    }
                }
                ?>
                <span class="grand-total">Total Amount Payable: $<?= $grand_total; ?>/-</span>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>
