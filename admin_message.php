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

/*Fshierja e user nga database */
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']); 
        mysqli_query($conn, "DELETE FROM `message` WHERE `id` = $delete_id") or die('Query failed');
        header('location:admin_user.php');
        exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icon@1.10.2/font/bootsrap-icons.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Admin Pannel</title>
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

    <section class="user-container">
        <h1 class="title">Total Messages</h1>
        <div class="box-container">
        <?php
                $select_message = mysqli_query($conn, "SELECT * FROM `message`") or die('Query failed: ' . mysqli_error($conn));
                if(mysqli_num_rows($select_message) > 0){
                    while($fetch_message = mysqli_fetch_assoc($select_message)){
        ?>
        <div class="box">
            <p>User Id: <span><?php echo $fetch_message['user_id'];?></span></p>
            <p>User Name: <span><?php echo $fetch_message['name'];?></span></p>
            <p>Email: <span><?php echo $fetch_message['email'];?></span></p>
            <p><?php echo $fetch_message['message'];?></p>
            <a href="admin_message.php?delete=<?php echo $fetch_message['id'];?>" class="delete" onclick="return confirm('delete this')">Delete</a>
        </div>
        <?php
                    }
                } else {
                    echo '<p class="empty" >No message yet.</p>';
                }
            ?>
        </div>
    </section>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>
