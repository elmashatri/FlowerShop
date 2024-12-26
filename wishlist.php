<?php

include 'connection.php';
session_start();
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
    exit();
}

/*Shtimi i produkteve ne cartt*/
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity =1;

    $cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE name='$product_name' AND user_id='$user_id'") or die(mysqli_error($conn));
    
    if (mysqli_num_rows($cart_number) > 0) {
        $message[] = 'Product already exists in cart';
    } else {
        mysqli_query($conn, "INSERT INTO `cart`(`user_id`, `pid`, `name`, `price`,`quantity`, `image`) VALUES ('$user_id', '$product_id', '$product_name', '$product_price','$product_quantity', '$product_image')") or die(mysqli_error($conn));
        $message[] = 'Product successfully added to cart';
    }
}

/*Fshierja e produkteve nga wishlist */
if(isset($_GET['delete'])){
    $delete_id=$_GET['delete'];
    mysqli_query($conn, "DELETE FROM `wishlist` WHERE id='$delete_id'") or die('query failed');
    header('location:wishlist.php');
}

/*Fshierja e produkteve nga wishlist */
if(isset($_GET['delete_all'])){
    mysqli_query($conn, "DELETE FROM `wishlist` WHERE user_id='$delete_id'") or die('query failed');
    header('location:wishlist.php');
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
        <h1>My Wishlist</h1>
        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Facere saepe pariatur amet a quam quae earum quidem eius ut quas, nesciunt ullam aliquid, vero, nobis magnam corporis illo aut repellat?</p>
    </div>
    <div class="shop">
        <h1 class="title">Products added to wishlist</h1>
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
            $grand_total = 0;
            $select_wishlist = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE `user_id` = '$user_id'") or die('Query failed: ' . mysqli_error($conn));

            if (mysqli_num_rows($select_wishlist) > 0) {
                while ($fetch_wishlist = mysqli_fetch_assoc($select_wishlist)) {
            ?>
            <form action="" method="post" class="box">
                <div class="icon">
                    <a href="wishlist.php?delete=<?php echo htmlspecialchars($fetch_wishlist['id']); ?>" class="bi bi-x-circle"></a>
                    <a href="view_page.php?pid=<?php echo htmlspecialchars($fetch_wishlist['pid']); ?>" class="bi bi-eye-fill"></a>
                </div>
                <img src="image/<?php echo htmlspecialchars($fetch_wishlist['image']); ?>" alt="Product Image">
                <div class="price">$<?php echo htmlspecialchars($fetch_wishlist['price']); ?>/-</div>
                <div class="name"><?php echo htmlspecialchars($fetch_wishlist['name']); ?></div>
                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($fetch_wishlist['pid']); ?>">
                <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($fetch_wishlist['name']); ?>">
                <input type="hidden" name="product_price" value="<?php echo htmlspecialchars($fetch_wishlist['price']); ?>">
                <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($fetch_wishlist['image']); ?>">
                <button type="submit" name="add_to_cart" class="btn2">Add to cart <i class="bi bi-cart"></i></button>
            </form>
            <?php
                $grand_total+=$fetch_wishlist['price'];
                }
            } else {
                echo '';
            }
            ?>
        </div>
        <div class="wishlist_total">
            <p>Total amount payable: <span>$<?php echo $grand_total ?>/-</span></p>
            <a href="shop.php">Continue Shoping</a>
            <a href="wishlist.php?delete_all" class="btn2 <?php echo ($grand_total>1)?'':'disabled'?>" onclick="return confirm('do you want to delete all from wishlist')">delete all</a>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>
