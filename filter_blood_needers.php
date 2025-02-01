<?php
header("Access-Control-Allow-Origin: *"); // Allow requests from any origin (for cross-origin requests)
header("Content-Type: application/json; charset=UTF-8"); // Set the response content type to JSON

$servername = "localhost";
$username = "root";
$password = "";
$database = "donor_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$location = isset($_GET['location']) ? $_GET['location'] : '';
$blood_type = isset($_GET['blood_type']) ? $_GET['blood_type'] : '';

$sql = "SELECT * FROM blood_needers WHERE 1";

if (!empty($location)) {
    $sql .= " AND location LIKE '%$location%'"; // Use LIKE for partial matches
}

if (!empty($blood_type)) {
    $sql .= " AND blood_type = '$blood_type'";
}

$result = $conn->query($sql);

$blood_needers = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $blood_needers[] = $row;
    }
}

echo json_encode($blood_needers); // Return the results as JSON

$conn->close();
?>