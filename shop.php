<?php

include 'connection.php';
session_start();
$user_id=$_SESSION['user_id'];
if(!isset($user_id)){
    header('location:login.php');
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
    $product_quantity=$_POST['product_quantity'];

    $cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE name='$product_name' AND user_id='$user_id'") or die(mysqli_error($conn));
    
    if (mysqli_num_rows($cart_number) > 0) {
        $message[] = 'Product already exists in cart';
    } else {
        mysqli_query($conn, "INSERT INTO `cart`(`user_id`, `pid`, `name`, `price`,`quantity` ,`image`) VALUES ('$user_id', '$product_id', '$product_name', '$product_price','$product_quantity', '$product_image')") or die(mysqli_error($conn));
        $message[] = 'Product successfully added to cart';
    }
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
    <title>Flower Shop</title>
</head>
<body>
    <?php include 'header.php';?>

    <div class="banner">
        <h1>Our Shop</h1>
        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Facere saepe pariatur amet a quam quae earum quidem eius ut quas, nesciunt ullam aliquid, vero, nobis magnam corporis illo aut repellat?</p>
    </div>
    <div class="shop">
    <h1 class="title">Shop Best Sellers</h1>
    <?php
    if (isset($message)) {
        foreach ($message as $msg) {
            echo '
                <div class="message">
                    <span>' . htmlspecialchars($msg) . '</span>
                    <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
                </div> 
            ';
        }
    }
    ?>
    <div class="box-container">
        <?php
        $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('Query failed: ' . mysqli_error($conn));

        if (mysqli_num_rows($select_products) > 0) {
            while ($fetch_products = mysqli_fetch_assoc($select_products)) {
        ?>
        <form action="" method="post" class="box">
            <img src="image/<?php echo htmlspecialchars($fetch_products['image']); ?>" alt="Product Image">
            <div class="price">$<?php echo htmlspecialchars($fetch_products['price']); ?>/-</div>
            <div class="name"><?php echo htmlspecialchars($fetch_products['name']); ?></div>
            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($fetch_products['id']); ?>">
            <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($fetch_products['name']); ?>">
            <input type="hidden" name="product_price" value="<?php echo htmlspecialchars($fetch_products['price']); ?>">
            <input type="hidden" name="product_quantity" value="1" min="0">
            <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($fetch_products['image']); ?>">
            <div class="icon">
                <a href="view_page.php?pid=<?php echo htmlspecialchars($fetch_products['id']); ?>" class="bi bi-eye-fill"></a>
                <button type="submit" name="add_to_wishlist" class="bi bi-heart"></button>
                <button type="submit" name="add_to_cart" class="bi bi-cart"></button>
            </div>
        </form>
        <?php
            }
        } else {
            echo '<p class="empty">No products added yet!</p>';
        }
        ?>
    </div>
</div>



    <?php include 'footer.php';?>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>