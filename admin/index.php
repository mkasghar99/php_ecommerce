<?php
// Database connection settings
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'ecommerce';

// Check if the user is an admin
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../login.php"); // Redirect to the login page after logout
}

// Handle logout
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: ../login.php"); // Redirect to the login page after logout
}
// Create a database connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check if the connection was successful
if (!$conn) {
    die('Database connection failed: ' . mysqli_connect_error());
}

// Fetch products from the database
$query = 'SELECT * FROM products';
$result = mysqli_query($conn, $query);

if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Home</title>
    <style>
        /* Add your CSS styles here */
    </style>
</head>
<body>
    <h1>Admin Home</h1>
    <form method="post" action="">
        <input type="submit" name="logout" value="Logout">
    </form>
    <a href="add_product.php">Add New Product</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['description'] ?></td>
                    <td>$<?= number_format($row['price'], 2) ?></td>
                    <td>
                        <a href="edit_product.php?id=<?= $row['id'] ?>">Edit</a>
                        <a href="delete_product.php?id=<?= $row['id'] ?>">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
