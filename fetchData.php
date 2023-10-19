<?php
// Enable CORS (Cross-Origin Resource Sharing)
header("Access-Control-Allow-Origin: *"); // Replace "*" with the specific origin you want to allow.

// Allow the following HTTP methods (you can adjust this based on your needs)
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Allow specific headers (e.g., Content-Type, Authorization) in the request
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Allow credentials (e.g., cookies, HTTP authentication) to be included in the request
header("Access-Control-Allow-Credentials: true");

// Optionally, set the maximum age for preflight requests (in seconds)
header("Access-Control-Max-Age: 86400"); // 24 hours

// Check if this is a preflight request (OPTIONS method) and respond accordingly
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // Return a 200 OK response without content to handle preflight requests
    http_response_code(200);
    exit();
}

// Your PHP code to handle the actual request goes here
// For example, you can fetch data from a database and return it as JSON

// Set the response Content-Type to JSON
header("Content-Type: application/json");

// Your response data (e.g., database query results) goes here
$responseData = array(
    "message" => "Data retrieved successfully",
    "data" => array(/* Your data here */)
);

// Encode the response as JSON and output it
echo json_encode($responseData);

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
