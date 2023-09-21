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

// Define the number of products per page
$productsPerPage = 2; // You can adjust this value

// Get the current page number from the URL (e.g., products.php?page=2)
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the starting product index for the current page
$start = ($page - 1) * $productsPerPage;

//  SQL query to include LIMIT
$query = "SELECT * FROM products LIMIT $start, $productsPerPage";
$result = mysqli_query($conn, $query);

if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}


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
                        <!-- Add to Cart form -->
<form method="post" action="cart.php">
    <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
    <input type="hidden" name="product_name" value="<?= $row['name'] ?>">
    <input type="hidden" name="product_price" value="<?= number_format($row['price'], 2) ?>">
    <input type="number" name="quantity" value="1" min="1">
    <input type="submit" name="add_to_cart" value="Add to Cart">
</form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

<?php
// Calculate the total number of products
$totalProductsQuery = "SELECT COUNT(*) as total FROM products";
$totalProductsResult = mysqli_query($conn, $totalProductsQuery);
$totalProductsRow = mysqli_fetch_assoc($totalProductsResult);
$totalProducts = $totalProductsRow['total'];

// Calculate the total number of pages
$totalPages = ceil($totalProducts / $productsPerPage);

// Generate pagination links
echo '<div class="pagination">';
for ($i = 1; $i <= $totalPages; $i++) {
    if ($i == $page) {
        echo "<span class='current'>$i</span>";
    } else {
        echo "<a href='index.php?page=$i'>$i</a>";
    }
}
echo '</div>';

?>

</body>
</html>
