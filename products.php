<?php
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

// Fetch products from the database
$query = 'SELECT * FROM products';
$result = mysqli_query($conn, $query);

if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
    <style>
        /* Add your CSS styles here */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
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
    <input type="submit" value="Add Product">
</form>


    <h1>Products</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
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
