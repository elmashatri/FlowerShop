<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_name']) || !isset($_SESSION['admin_email'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Rio Flower Shop</title>
</head>
<body>
    <header class="header">
        <div class="flex">
            <a href="admin.php" class="logo">Rio <span>Flower Shop</span></a>
            <nav class="navbar">
                <a href="index.php">Home</a>
                <a href="shop.php">Shop</a>
                <a href="orders.php">Orders</a>
                <a href="about.php">About</a>
                <a href="contact.php">Contact</a>
            </nav>
            <div class="icons">
                <i class="bi bi-list" id="menu-btn"></i>
                <i class="bi bi-person" id="user-btn"></i>
            </div>
            <div class="user-box">
                <p>Username: <span><?php echo htmlspecialchars($_SESSION['user_name']); ?></span></p>
                <p>Email: <span><?php echo htmlspecialchars($_SESSION['user_email']); ?></span></p>
                <form method="post" class="logout">
                    <button type="submit" name="logout" class="logout-btn">Log Out</button>
                </form>
            </div>
        </div>
    </header>

    <?php
    if (isset($_POST['logout'])) {
        session_unset();  
        session_destroy();  
        header("Location: login.php");  
        exit();
    }
    ?>
</body>
</html>
