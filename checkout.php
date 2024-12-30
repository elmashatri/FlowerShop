<?php

include 'connection.php';
session_start();
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
    exit();
}

/* Order */
if (isset($_POST['order_btn'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $address = mysqli_real_escape_string(
        $conn,
        $_POST['street'] . ', ' . $_POST['city'] .  ', ' . $_POST['country']);
    $placed_on = date('d-M-Y');
    $cart_total = 0;
    $cart_products = [];
    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id='$user_id'") or die('Query failed');
    if (mysqli_num_rows($cart_query) > 0) {
        while ($cart_item = mysqli_fetch_assoc($cart_query)) {
            $cart_products[] = $cart_item['name'] . ' (' . $cart_item['quantity'] . ')';
            $sub_total = $cart_item['price'] * $cart_item['quantity'];
            $cart_total += $sub_total;
        }
    }
    $total_products = implode(', ', $cart_products);
    mysqli_query($conn, "INSERT INTO `orders` (`user_id`, `name`, `email`, `number`, `method`, `address`, `total_products`, `total_price`, `placed_on`) VALUES ('$user_id', '$name', '$email', '$number', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('Insert query failed');
    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id='$user_id'") or die('Delete query failed');
    $message[] = 'Order placed successfully';
    header('location:checkout.php');
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
        <?php
        if(isset($message)){
            foreach($message as $msg){  
                echo '
                    <div class="message">
                        <span>'.$msg.'</span>
                        <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
                    </div>
                ';
            }
        }
    ?>
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
        <form method="post">
            <div class="input-field">
                <label>your name</label>
                <input type="text" name="name" placeholder="enter your name">
            </div>
            <div class="input-field">
                <label>your number</label>
                <input type="text" name="number" placeholder="enter your number">
            </div>
            <div class="input-field">
                <label>your email</label>
                <input type="text" name="email" placeholder="enter your email">
            </div>
            <div class="input-field">
                <label>select payment method: </label>
                <select name="method">
                    <option selected disabled>select payment method</option>
                    <option value="cash on delivery">cash on delivery</option>
                    <option value="credit card">credit card</option>
                    <option value="paypal">paypal</option>
                    <option value="paytm">paytm</option>
                </select>
            </div>
            <div class="input-field">
                <label>street:</label>
                <input type="text" name="street" placeholder="street">
            </div>
            <div class="input-field">
                <label>city:</label>
                <input type="text" name="city" placeholder="city">
            </div>
            <div class="input-field">
                <label>country:</label>
                <input type="text" name="country" placeholder="country">
            </div>
            <input type="submit" name="order_btn" class="btn" value="order now">
        </form>
    </div>

    <?php include 'footer.php'; ?>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>
