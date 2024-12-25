<?php
include 'connection.php';
session_start();

$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location:login.php');
    exit();
}
if(isset($_POST['logout'])){
    session_destroy();
    header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icon@1.10.2/font/bootsrap-icons.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Admin Panel</title>
</head>
<body>
    <?php include 'admin_header.php'; ?>
    <section class="dashboard">
        <h1 class="title">Dashboard</h1>
        <div class="box-container">
            <div class="box">
                <?php
                    $total_pendings = 0;
                    
                    $select_pendings = mysqli_query($conn, "SELECT * FROM `orders` WHERE `payment_status` = 'pending'")
                        or die('query failed');
                    
                    if ($select_pendings) {
                        while ($fetch_pendings = mysqli_fetch_assoc($select_pendings)) {
                            $total_pendings += $fetch_pendings['total_price'];
                        }
                    } else {
                        // If the query failed, display an error message
                        echo "Error fetching pending orders: " . mysqli_error($conn);
                    }
                ?>
                <h3>$ <?php echo $total_pendings; ?></h3>
                <p>Total Pendings</p>
            </div>
            <div class="box">
                <?php
                    $total_completed = 0;
                    
                    $select_completed = mysqli_query($conn, "SELECT * FROM `orders` WHERE `payment_status` = 'completed'")
                        or die('query failed');
                    
                    if ($select_completed) {
                        while ($fetch_completed = mysqli_fetch_assoc($select_completed)) {
                            $total_completed += $fetch_completed['total_price'];
                        }
                    } else {
                        echo "Error fetching cmpleted orders: " . mysqli_error($conn);
                    }
                ?>
                <h3>$ <?php echo $total_completed; ?></h3>
                <p>Total Completed</p>
            </div>
            <div class="box">
                <?php
                    
                    $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
                    $num_of_orders=mysqli_num_rows($select_orders);
                ?>
                <h3>$ <?php echo $num_of_orders; ?></h3>
                <p>Order Placed</p>
            </div>
            <div class="box">
                <?php
                    
                    $select_products = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
                    $num_of_products=mysqli_num_rows($select_orders);
                ?>
                <h3>$ <?php echo $num_of_products; ?></h3>
                <p>Product Added</p>
            </div>
            <div class="box">
                <?php
                    
                    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type='user'") or die('query failed');
                    $num_of_users=mysqli_num_rows($select_users);
                ?>
                <h3>$ <?php echo $num_of_users; ?></h3>
                <p>Registered User</p>
            </div>
            <div class="box">
                <?php
                    
                    $select_admins = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type='admin'") or die('query failed');
                    $num_of_admins=mysqli_num_rows($select_admins);
                ?>
                <h3>$ <?php echo $num_of_admins; ?></h3>
                <p>Total Admin</p>
            </div>
            <div class="box">
                <?php
                    
                    $select_totaluser = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
                    $num_of_totaluser=mysqli_num_rows($select_totaluser);
                ?>
                <h3>$ <?php echo $num_of_totaluser; ?></h3>
                <p>Total Users</p>
            </div>
            <div class="box">
                <?php
                    
                    $select_message = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');
                    $num_of_message=mysqli_num_rows($select_message);
                ?>
                <h3>$ <?php echo $num_of_message; ?></h3>
                <p>New Message</p>
            </div>
            
        </div>
    </section>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>
