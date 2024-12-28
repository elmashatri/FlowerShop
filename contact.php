<?php

include 'connection.php';
session_start();
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
    exit();
}

/*------------------send message---------------------*/
if(isset($_POST['submit-btn'])){
    $name=mysqli_real_escape_string($conn, $_POST['name']);
    $email=mysqli_real_escape_string($conn, $_POST['email']);
    $number=mysqli_real_escape_string($conn, $_POST['number']);
    $message=mysqli_real_escape_string($conn, $_POST['message']);

    $select_message=mysqli_query($conn, "SELECT * FROM `message` WHERE name='$name' AND email='$email' AND number='$number' AND message='$message'") or die('query failed');
    if(mysqli_num_rows($select_message)>0){
        echo 'message already send';
    }else{
        mysqli_query($conn, "INSERT INTO `message`(`user_id`, `name`, `number`, `message`) VALUES ('$user_id', '$name', '$number', '$message')") or die('query failed');
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
        <h1>My contact</h1>
        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Facere saepe pariatur amet a quam quae earum quidem eius ut quas, nesciunt ullam aliquid, vero, nobis magnam corporis illo aut repellat?</p>
    </div>
    
    <div class="help">
        <h1 class="title">need help</h1>
        <div class="box-container">
            <div class="box">
                <div>
                    <img src="image/icon0.png" width="200px" height="200px">
                    <h2>address</h2>
                </div>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p>
            </div>
            <div class="box">
                <div>
                    <img src="image/icon1.png" width="200px" height="200px">
                    <h2>opening</h2>
                </div>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p>
            </div>
            <div class="box">
                <div>
                    <img src="image/icon2.png" width="200px" height="200px">
                    <h2>our contact</h2>
                </div>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p>
            </div>
            <div class="box">
                <div>
                    <img src="image/icon3.png" width="200px" height="200px">
                    <h2>special offer</h2>
                </div>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p>
            </div>
        </div>
    </div>

    <div class="form-container">
        <div class="form-section">
            <form method="post">
                <h1>send us your question!</h1>
                <p>we'll get back to you within two days.</p>
                <div class="input-field">
                    <label>your name</label>
                    <input type="text" name="name">
                </div>
                <div class="input-field">
                    <label>your email</label>
                    <input type="text" name="email">
                </div>
                <div class="input-field">
                    <label>your number</label>
                    <input type="text" name="number">
                </div>
                <div class="input-field">
                    <label>message</label>
                    <textarea name="message"></textarea>
                </div>
                <input type="submit" name="submit-btn" class="btn" value="send message">
            </form>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>
