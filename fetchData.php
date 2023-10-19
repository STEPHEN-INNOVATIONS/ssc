<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Database connection parameters
$servername = "localhost";  // Change to your MySQL server address
$username = "root"; // Change to your MySQL username
$password = "jude7733"; // Change to your MySQL password
$dbname = "mediDB";

try {
    // Create a PDO database connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // Set PDO to throw exceptions on error
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL query to fetch medicines and side effects from the 'mediTable'
    $sql = "SELECT medicines, side_effects FROM mediTable";

    // Prepare and execute the query
    $stmt = $conn->query($sql);

    // Fetch the data as an associative array
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Close the database connection (not necessary with PDO)

    // Send the data as JSON
    header('Content-Type: application/json');
    echo json_encode($data);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
