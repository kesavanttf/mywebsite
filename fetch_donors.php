<?php
header('Content-Type: application/json');

// Database connection details
$host = 'localhost';
$db = 'donor_db';
$user = 'root';  // Use your database username
$pass = '';      // Use your database password

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch donor data
    $stmt = $pdo->query("
        SELECT firstName, lastName, dob, gender, bloodType, phone, lastDonation, location, aadharCardNumber 
        FROM donors
    ");

    $donors = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the data as JSON
    echo json_encode($donors);

} catch (PDOException $e) {
    // Return an error in JSON format
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
