<?php
include 'connection.php';

if(isset($_POST['submit_btn'])){  
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $cpassword = htmlspecialchars($_POST['cpassword']);

    $name = mysqli_real_escape_string($conn, $name);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);
    $cpassword = mysqli_real_escape_string($conn, $cpassword);

    $select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE `email` = '$email'") or die('Query failed');
    
    if(mysqli_num_rows($select_user) > 0){
        $message[] = 'User already exists';
    } else {
        if($password != $cpassword){
            $message[] = 'Passwords do not match';
        } else {
            mysqli_query($conn, "INSERT INTO `users` (`name`, `email`, `password`) VALUES ('$name', '$email', '$password')") or die('Query failed');
            $message[] = 'Registered successfully';
            header('location: login.php');
            exit(); 
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>User Registration Page</title>
</head>
<body>
    <?php
        if(isset($message)){
            foreach($message as $msg){  
                echo '
                    <div class="message">
                        <span>'.$msg.'</span>
                        <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
                    </div>
                ';
            }
        }
    ?>

    <section class="form-container">
        <form action="" method="post">
            <h3>Register Now</h3>
            <input type="text" name="name" placeholder="Enter your name" required>
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="password" name="password" placeholder="Enter your password" required>
            <input type="password" name="cpassword" placeholder="Re-enter your password" required>
            <input type="submit" name="submit_btn" class="btn" value="Register Now"> 
            <p>Already have an account? <a href="login.php">Login Now</a></p>
        </form>
    </section>
</body>
</html>

