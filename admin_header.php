<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icon@1.10.2/font/bootsrap-icons.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Document</title>
</head>
<body>
    <header class="header">
        <div class="flex">
            <a href="admin.php" class="logo">Admin <span>Pannel</span></a>
            <nav class="navbar">
                <a href="admin.php">Home</a>
                <a href="admin_product.php">Products</a>
                <a href="admin_orders.php">Orders</a>
                <a href="admin_user.php">Users</a>
                <a href="admin_message.php">Message</a>
            </nav>
            <div class="icons">
                <i class="bi bi-list" id="menu-btn"></i>
                <i class="bi bi-user" id="user-btn"></i>
            </div>
            <div class="user-box">
                <p>Username: <span><?php echo $_SESSION['admin_name'];?></span></p>
                <p>Email: <span><?php echo $_SESSION['admin_email'];?></span></p>
                <form method="post" class="logout">
                    <button name="logout" class="logout-btn">Log Out</button>
                </form>
            </div>
        </div>
    </header>
</body>
</html>
