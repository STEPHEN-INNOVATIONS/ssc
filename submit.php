<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "jude7733";
$dbname = "mediDB";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Hash the password using md5 (not recommended for secure password hashing)
    $hashed_password = md5($password);

    // Prepare an SQL query to insert data into the 'user' table
    $sql = "INSERT INTO user (email, password) VALUES (?, ?)";

    // Use a prepared statement to securely insert data
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $hashed_password);

    if ($stmt->execute()) {
        // Data has been inserted successfully
        header("Location: index.html");
        exit; // Terminate the script to ensure the redirection happens
    } else {
        // Error occurred during data insertion
        header("Location: index.html");
        exit; // Terminate the script to ensure the redirection happens
    }
    
    
}

// Close the database connection
$conn->close();
?>
