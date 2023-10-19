<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "jude7733";
$dbname = "mediDB";

try {
    // Create a PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the form has been submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Hash the password using password_hash for secure password hashing
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare an SQL query to insert data into the 'user' table
        $sql = "INSERT INTO user (email, password) VALUES (:email, :password)";

        // Use a prepared statement to securely insert data
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);

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
} catch (PDOException $e) {
    // Handle database connection errors
    die("Connection failed: " . $e->getMessage());
}

// Close the database connection (optional, as PDO automatically closes the connection at the end of the script)
$conn = null;
?>
