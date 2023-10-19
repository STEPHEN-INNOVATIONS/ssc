<?php
// Database connection parameters
$servername = "localhost";  // Change to your MySQL server address
$username = "root"; // Change to your MySQL username
$password = "jude7733"; // Change to your MySQL password
$dbname = "mediDB";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch medicines and side effects from the 'mediTable'
$sql = "SELECT medicines, side_effects FROM mediTable";

$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Add medicines and side effects to the data array
        $data[] = array(
            'medicines' => $row['medicines'],
            'side_effects' => $row['side_effects']
        );
    }
}

// Close the database connection
$conn->close();

// Send the data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
