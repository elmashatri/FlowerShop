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
    <title>Flower Shop</title>
</head>
<body>
    <?php include 'header.php';?>

    <div class="slider-section">
    <div class="slide-show-container">
        <div class="wrapper wrapper-one">
            <div class="wraper-text">Inspired by nature</div>
        </div>
        <div class="wrapper wrapper-two">
            <div class="wraper-text">Fresh flower for you</div>
        </div>
        <div class="wrapper wrapper-three">
            <div class="wraper-text">Enjoy the beauty</div>
        </div>
    </div>
</div>

    <div class="row">
        <div class="card">
            <div class="detail">
                <span>30% OFF TODAY</span>
                <h1>Simple & Elegant</h1>
                <a href="shop.php">Shop Now</a>
            </div>
        </div>
        <div class="card">
            <div class="detail">
                <span>30% OFF TODAY</span>
                <h1>Simple & Elegant</h1>
                <a href="shop.php">Shop Now</a>
            </div>
        </div>
        <div class="card">
            <div class="detail">
                <span>30% OFF TODAY</span>
                <h1>Simple & Elegant</h1>
                <a href="shop.php">Shop Now</a>
            </div>
        </div>
    </div>

    <div class="categories">
        <h1 class="title">TOP CATEGORIES</h1>
        <div class="box-container">
            <div class="box">
                <img src="image/cat1.png" alt="Birthday">
                <span>Birthday</span>
            </div>
            <div class="box">
                <img src="image/cat2.png" alt="NextDay">
                <span>Next Day</span>
            </div>
            <div class="box">
                <img src="image/cat3.png" alt="Plant">
                <span>Plant</span>
            </div>
            <div class="box">
                <img src="image/cat4.png" alt="Wedding">
                <span>Wedding</span>
            </div>
            <div class="box">
                <img src="image/cat5.png" alt="Sympathy">
                <span>Sympathy</span>
            </div>
        </div>
    </div>

    <div class="banner3">
        <div class="detail">
            <span>BETTER THAN CAKE</span>
            <h1>BIETHDAY BOUQS</h1>
            <p>Believe in birthday magic? (You will.) Celebrate with party-ready blooms!</p>
            <a href="shop.php">Explore <i class="bi bi-arrow-right"></i></a>
        </div>
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
        // Corrected SQL query with backticks for the table name
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

    <div class="more">
        <a href="shop.php">Load More</a>
        <i class="bi bi-arrow-down"></i>
    </div>
</div>



    <?php include 'footer.php';?>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>