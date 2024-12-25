<?php
include 'connection.php';
session_start();

$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location:login.php');
    exit();
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('location:login.php');
    exit();
}

/* Shto produktin e ri */
if (isset($_POST['add_product'])) {
    $product_name = mysqli_real_escape_string($conn, $_POST['name']);
    $product_price = mysqli_real_escape_string($conn, $_POST['price']);
    $product_detail = mysqli_real_escape_string($conn, $_POST['detail']);
    $image = $_FILES['image']['name']; 
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_size = $_FILES['image']['size'];
    $image_folder = 'image/' . $image;

    $select_product_name = mysqli_query($conn, "SELECT `name` FROM `products` WHERE `name` = '$product_name'") 
        or die('Query failed: ' . mysqli_error($conn));

    if (mysqli_num_rows($select_product_name) > 0) {
        $message[] = 'Product name already exists!';
    } else {
        $insert_product = mysqli_query($conn, "INSERT INTO `products` (`name`, `price`, `product_detail`, `image`) 
            VALUES ('$product_name', '$product_price', '$product_detail', '$image')") 
            or die('Query failed: ' . mysqli_error($conn));

        if ($insert_product) {
            if ($image_size > 2000000) {
                $message[] = 'Product image size is too large!';
            } else {
                if (move_uploaded_file($image_tmp_name, $image_folder)) {
                    $message[] = 'Product added successfully!';
                } else {
                    $message[] = 'Failed to upload the product image.';
                }
            }
        }
    }
}

/* Fshij produktin */
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']); 
    $select_delete_image = mysqli_query($conn, "SELECT `image` FROM `products` WHERE `id` = $delete_id") or die('Query failed');
    if (mysqli_num_rows($select_delete_image) > 0) {
        $fetch_delete_image = mysqli_fetch_assoc($select_delete_image);
        $image_path = 'image/' . $fetch_delete_image['image'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        mysqli_query($conn, "DELETE FROM `products` WHERE `id` = $delete_id") or die('Query failed');
        mysqli_query($conn, "DELETE FROM `cart` WHERE `pid` = $delete_id") or die('Query failed');
        mysqli_query($conn, "DELETE FROM `wishlist` WHERE `pid` = $delete_id") or die('Query failed');
        header('location:admin_product.php');
        exit();
    } else {
        echo 'Product not found';
    }
}

/* Ripërditësimi i produkteve */
if (isset($_POST['update_product'])) {
    $update_p_id = intval($_POST['update_p_id']); 
    $update_p_name = mysqli_real_escape_string($conn, $_POST['update_p_name']);
    $update_p_price = floatval($_POST['update_p_price']); 
    $update_p_detail = mysqli_real_escape_string($conn, $_POST['update_p_detail']);

    $update_p_img = $_FILES['update_p_image']['name'];
    $update_p_img_tmp_name = $_FILES['update_p_image']['tmp_name']; 
    $update_p_img_folder = 'image/' . $update_p_img;

    if (!empty($update_p_img)) {
        if (!move_uploaded_file($update_p_img_tmp_name, $update_p_img_folder)) {
            $message[] = 'Failed to upload the image.';
        }
        $update_query = mysqli_query(
            $conn,
            "UPDATE `products` 
             SET `name` = '$update_p_name', 
                 `price` = '$update_p_price', 
                 `product_detail` = '$update_p_detail', 
                 `image` = '$update_p_img' 
             WHERE `id` = '$update_p_id'"
        ) or die('Query failed: ' . mysqli_error($conn));
    } else {
        $update_query = mysqli_query(
            $conn,
            "UPDATE `products` 
             SET `name` = '$update_p_name', 
                 `price` = '$update_p_price', 
                 `product_detail` = '$update_p_detail' 
             WHERE `id` = '$update_p_id'"
        ) or die('Query failed: ' . mysqli_error($conn));
    }
    if ($update_query) {
        $message[] = 'Product updated successfully.';
        header('location:admin_product.php');
        exit();
    } else {
        $message[] = 'Product update failed.';
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Add Product</title>
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

    <section class="add-products">
        <form method="post" action="" enctype="multipart/form-data">
            <h1 class="title">Add New Product</h1>
            <div class="input-field">
                <label>Product Name</label>
                <input type="text" name="name" required>
            </div>
            <div class="input-field">
                <label>Product Price</label>
                <input type="text" name="price" required>
            </div>
            <div class="input-field">
                <label>Product Detail</label>
                <textarea name="detail" required></textarea>
            </div>
            <div class="input-field">
                <label>Product Image</label>
                <input type="file" name="image" accept="image/jpg, image/png, image/jpeg, image/webp" required>
            </div>
            <input type="submit" name="add_product" value="Add Product" class="btn">
        </form>
    </section>

    <!--Shfaq produktet-->
    <section class="show-products">
    <div class="box-container">
        <?php
        $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('Query failed: ' . mysqli_error($conn));

        if (mysqli_num_rows($select_products) > 0) {
            while ($fetch_products = mysqli_fetch_assoc($select_products)) {
                ?>
                <div class="box">
                    <img src="image/<?php echo htmlspecialchars($fetch_products['image']); ?>" alt="Product Image">
                    <p>Price: $ <?php echo htmlspecialchars($fetch_products['price']); ?></p>
                    <h4><?php echo htmlspecialchars($fetch_products['name']); ?></h4>
                    <p class="detail"><?php echo htmlspecialchars($fetch_products['product_detail']); ?></p>
                    <a href="admin_product.php?edit=<?php echo urlencode($fetch_products['id']); ?>" class="edit">Edit</a>
                    <a href="admin_product.php?delete=<?php echo urlencode($fetch_products['id']); ?>" class="delete" onclick="return confirm('Delete this product?');">Delete</a>
                </div>
                <?php
            }
        } else {
            echo '<p>No products found!</p>';
        }
        ?>
    </div>
    </section>
    <section class="update-container">
    <?php
    if (isset($_GET['edit'])) {
        $edit_id = intval($_GET['edit']); 

        $edit_query = mysqli_query($conn, "SELECT * FROM `products` WHERE `id` = $edit_id") or die('Query failed: ' . mysqli_error($conn));

        if (mysqli_num_rows($edit_query) > 0) {
            while ($fetch_edit = mysqli_fetch_assoc($edit_query)) {
                ?>
                <form method="post" action="" enctype="multipart/form-data">
                    <img src="image/<?php echo $fetch_edit['image']; ?>" alt="Product Image">
                    <input type="hidden" name="update_p_id" value="<?php echo $fetch_edit['id']; ?>">
                    <input type="text" name="update_p_name" value="<?php echo $fetch_edit['name']; ?>" required>
                    <input type="number" min="0" name="update_p_price" value="<?php echo $fetch_edit['price']; ?>" required>
                    <textarea name="update_p_detail" required><?php echo $fetch_edit['product_detail']; ?></textarea>
                    <input type="file" name="update_p_image" accept="image/png, image/jpg, image/jpeg, image/webp">
                    <input type="submit" name="update_product" value="Update" class="edit">
                    <input type="reset" value="Cancel" class="option-btn btn" onclick="redirectToProducts();">
                </form>
                <?php
            }
            echo "<script>document.querySelector('.update-container').style.display='block';</script>";
        } else {
            echo "<p>No product found to edit.</p>";
        }
    }
    ?>
</section>

    <script type="text/javascript" src="script.js"></script>
</body>
</html>
