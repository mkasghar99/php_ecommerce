<?php
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

    // Delete the product from the database
    $query = "DELETE FROM products WHERE id=$product_id";
    if (mysqli_query($conn, $query)) {
        header("Location: products.php");
    } else {
        echo "Error deleting product: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
