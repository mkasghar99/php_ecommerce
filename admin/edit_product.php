<?php
// Check if the user is an admin
session_start();
if ($_SESSION['role'] !== 'admin') {
    die('Access denied. Only administrators can access this page.');
}

// Database connection settings
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'ecommerce';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Create a database connection
    $conn = mysqli_connect($host, $username, $password, $database);

    // Check if the connection was successful
    if (!$conn) {
        die('Database connection failed: ' . mysqli_connect_error());
    }

    // Fetch product data by ID
    $query = "SELECT * FROM products WHERE id = $product_id";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Query failed: ' . mysqli_error($conn));
    }

    $product = mysqli_fetch_assoc($result);

    // Close the database connection
    mysqli_close($conn);
} else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Create a database connection
    $conn = mysqli_connect($host, $username, $password, $database);

    // Check if the connection was successful
    if (!$conn) {
        die('Database connection failed: ' . mysqli_connect_error());
    }

    // Update the product in the database
    $query = "UPDATE products SET name='$name', description='$description', price=$price WHERE id=$product_id";
    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
    } else {
        echo "Error updating product: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <style>
        /* Add your CSS styles here */
    </style>
</head>
<body>
    <h1>Edit Product</h1>
    <form method="post" action="edit_product.php">
        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?= $product['name'] ?>" required>
        <br>
        <label for="description">Description:</label>
        <textarea name="description" required><?= $product['description'] ?></textarea>
        <br>
        <label for="price">Price:</label>
        <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required>
        <br>
        <input type="submit" name="update" value="Update Product">
    </form>
</body>
</html>
