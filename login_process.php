<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection settings
    $host = 'localhost';
    $username_db = 'root';
    $password_db = '';
    $database = 'ecommerce';

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Create a database connection
    $conn = mysqli_connect($host, $username_db, $password_db, $database);

    // Check if the connection was successful
    if (!$conn) {
        die('Database connection failed: ' . mysqli_connect_error());
    }

    // Query to check user credentials
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            // After successful login:
            session_start();
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            header("Location: admin/index.php");
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "User not found.";
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
