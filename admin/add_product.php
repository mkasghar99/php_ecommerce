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
        // Create a database connection
        $conn = mysqli_connect($host, $username, $password, $database);
    
        // Check if the connection was successful
        if (!$conn) {
            die('Database connection failed: ' . mysqli_connect_error());
        }

        
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category'];


    // Insert the new product into the database
    $query = "INSERT INTO products (name, description, price, category_id) VALUES ('$name', '$description', $price, $category_id)";
    if (mysqli_query($conn, $query)) {
        echo "Product added successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close the database connection
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
    <h2>Add a New Product</h2>
        <form method="post" action="add_product.php">
            <label for="name">Name:</label>
            <input type="text" name="name" required>
            <br>
            <label for="description">Description:</label>
            <textarea name="description" required></textarea>
            <br>
            <label for="price">Price:</label>
            <input type="number" step="0.01" name="price" required>
            <br>
            <!-- Add a dropdown for selecting the product category -->
            <label for="category">Category:</label>
            <select name="category" required>
                <?php
                // Fetch categories from the database and populate the dropdown
                $categoryQuery = "SELECT * FROM categories";
                $categoryResult = mysqli_query($conn, $categoryQuery);
                
                while ($category = mysqli_fetch_assoc($categoryResult)) {
                    echo "<option value='" . $category['id'] . "'>" . $category['name'] . "</option>";
                }
                ?>
            </select>
            <input type="submit" value="Add Product">
        </form>
    </body>
</html>