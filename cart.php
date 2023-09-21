<?php
session_start();

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add a product to the cart
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $quantity = $_POST['quantity'];

    // Create a cart item
    $item = [
        'id' => $product_id,
        'name' => $product_name,
        'price' => $product_price,
        'quantity' => $quantity,
    ];

    // Add the item to the cart
    $_SESSION['cart'][] = $item;
}

// Remove a product from the cart
if (isset($_GET['remove'])) {
    $index = $_GET['remove'];
    unset($_SESSION['cart'][$index]);
    $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index the cart array
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart</title>
    <style>
        /* Add your CSS styles here */
    </style>
</head>
<body>
    <h1>Shopping Cart</h1>

    <!-- Display cart items -->
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total = 0;
            foreach ($_SESSION['cart'] as $index => $item):
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
            ?>
            <tr>
                <td><?= $item['name'] ?></td>
                <td>$<?= number_format($item['price'], 2) ?></td>
                <td><?= $item['quantity'] ?></td>
                <td>$<?= number_format($subtotal, 2) ?></td>
                <td><a href="cart.php?remove=<?= $index ?>">Remove</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p>Total: $<?= number_format($total, 2) ?></p>

    <!-- Add more products or a checkout button here -->
</body>
</html>
