<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Database connection settings
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'ecommerce';
    // Create a database connection
    $conn = mysqli_connect($host, $username, $password, $database);

    // Check if the connection was successful
    if (!$conn) {
        die('Database connection failed: ' . mysqli_connect_error());
    }

    // Insert the new product into the database
    $query = "INSERT INTO products (name, description, price) VALUES ('$name', '$description', $price)";
    if (mysqli_query($conn, $query)) {
        echo "Product added successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
