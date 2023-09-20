<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection settings
    $host = 'localhost';
    $username_db = 'root';
    $password_db = '';
    $database = 'ecommerce';

    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Create a database connection
    $conn = mysqli_connect($host, $username_db, $password_db, $database);

    // Check if the connection was successful
    if (!$conn) {
        die('Database connection failed: ' . mysqli_connect_error());
    }

    // Insert the new user into the database
    $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    if (mysqli_query($conn, $query)) {
        echo "Registration successful. <a href='login.php'>Login</a>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
