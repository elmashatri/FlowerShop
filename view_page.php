<?php

include 'connection.php';
session_start();

$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
    header('location:login.php');
    exit();
}
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_name']) || !isset($_SESSION['admin_email'])) {
    header("Location: login.php");
    exit();
}

/*Shtimi i produkteve ne wishlist*/
if (isset($_POST['add_to_wishlist'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];

    $wishlist_number = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name='$product_name' AND user_id='$user_id'") or die(mysqli_error($conn));
    $cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE name='$product_name' AND user_id='$user_id'") or die(mysqli_error($conn));
    
    if (mysqli_num_rows($wishlist_number) > 0) {
        $message[] = 'Product already exists in wishlist';
    } else if (mysqli_num_rows($cart_number) > 0) {
        $message[] = 'Product already exists in cart';
    } else {
        mysqli_query($conn, "INSERT INTO `wishlist`(`user_id`, `pid`, `name`, `price`, `image`) VALUES ('$user_id', '$product_id', '$product_name', '$product_price', '$product_image')") or die(mysqli_error($conn));
        $message[] = 'Product successfully added to wishlist';
    }
}

/*Shtimi i produkteve ne cartt*/
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE name='$product_name' AND user_id='$user_id'") or die(mysqli_error($conn));
    
    if (mysqli_num_rows($cart_number) > 0) {
        $message[] = 'Product already exists in cart';
    } else {
        mysqli_query($conn, "INSERT INTO `cart`(`user_id`, `pid`, `name`, `price`,`quantity`, `image`) VALUES ('$user_id', '$product_id', '$product_name', '$product_price','$product_quantity', '$product_image')") or die(mysqli_error($conn));
        $message[] = 'Product successfully added to cart';
    }
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
        <h1>Product Detail</h1>
        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Facere saepe pariatur amet a quam quae earum quidem eius ut quas, nesciunt ullam aliquid, vero, nobis magnam corporis illo aut repellat?</p>
    </div>

    <div class="product-detail">
    <?php
    if (isset($_GET['pid'])) {
        $pid = mysqli_real_escape_string($conn, $_GET['pid']); 
        $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE `id` = '$pid'") or die(mysqli_error($conn));
        
        if (mysqli_num_rows($select_products) > 0) {
            while ($fetch_products = mysqli_fetch_assoc($select_products)) {
    ?>
    <form action="" method="post" class="box view_page">
        <img src="image/<?php echo htmlspecialchars($fetch_products['image']); ?>" alt="Product Image">
        <div class="details">
            <div class="name"><?php echo htmlspecialchars($fetch_products['name']); ?></div>
            <div class="price">$<?php echo htmlspecialchars($fetch_products['price']); ?>/-</div>
            <div class="description"><?php echo htmlspecialchars($fetch_products['product_detail']); ?></div>
            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($fetch_products['id']); ?>">
            <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($fetch_products['name']); ?>">
            <input type="hidden" name="product_price" value="<?php echo htmlspecialchars($fetch_products['price']); ?>">
            <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($fetch_products['image']); ?>">
            <div class="actions">
                <button type="submit" name="add_to_wishlist" class="bi bi-heart"></button>
                <input type="number" name="product_quantity" value="1" min="1" class="quantity">
                <button type="submit" name="add_to_cart" class="bi bi-cart"></button>
            </div>
        </div>
    </form>
    <?php
            }
        } else {
            echo "<p class='error'>No product found with this ID.</p>";
        }
    } else {
        echo "<p class='error'>Product ID not provided.</p>";
    }
    ?>
</div>


    <?php include 'footer.php'; ?>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>
