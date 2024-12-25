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
    exit();
}

/*Fshierja e order nga database */
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']); 
        mysqli_query($conn, "DELETE FROM `orders` WHERE `id` = $delete_id") or die('Query failed');
        header('location:admin_orders.php');
        exit();
}

/*Përditësimi i order */
if (isset($_POST['update_order'])) {
    $order_id = $_POST['order_id'];
    $update_payment = $_POST['update_payment'];
    $update_query = mysqli_query($conn, "UPDATE `orders` SET `payment_status` = '$update_payment' WHERE `id` = '$order_id'") or die('Query failed: ' . mysqli_error($conn));
    if ($update_query) {
        $message[] = 'Payment Status Updated Successfully';
    }
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
    
    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '
                <div class="message">
                    <span>' . $message . '</span>
                    <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
                </div>
            ';
        }
    }
    ?>

    <section class="order-container">
        <h1 class="title">Total Placed Orders</h1>
        <div class="box-container">
            <?php
                $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('Query failed: ' . mysqli_error($conn));
                if(mysqli_num_rows($select_orders) > 0){
                    while($fetch_orders = mysqli_fetch_assoc($select_orders)){
            ?>
            <div class="box">
                <p>User Name: <span><?php echo $fetch_orders['name'];?></span></p>
                <p>User Id: <span><?php echo $fetch_orders['user_id'];?></span></p>
                <p>Placed On: <span><?php echo $fetch_orders['placed_on'];?></span></p>
                <p>Number: <span><?php echo $fetch_orders['number'];?></span></p>
                <p>Email: <span><?php echo $fetch_orders['email'];?></span></p>
                <p>Total Price: <span><?php echo $fetch_orders['total_price'];?>/-</span></p>
                <p>Method: <span><?php echo $fetch_orders['method'];?></span></p>
                <p>Address: <span><?php echo $fetch_orders['address'];?></span></p>
                <p>Total Products: <span><?php echo $fetch_orders['total_products'];?></span></p>
                <form method="post">
                    <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id'];?>">
                    <select name="update_payment">
                        <option disabled selected><?php echo $fetch_orders['payment_status'];?></option>
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                    </select>
                    <input type="submit" name="update_order" value="Update Order" class="btn">
                    <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" class="delete" onclick="return confirm('Are you sure you want to delete this order?')">Delete</a>
                </form>
            </div>
            <?php
                    }
                } else {
                    echo "<p>No orders found.</p>";
                }
            ?>
        </div>
    </section>

    <script type="text/javascript" src="script.js"></script>
</body>
</html>
