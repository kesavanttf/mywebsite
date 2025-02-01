<?php
header('Content-Type: application/json');

// Database connection details
$host = 'localhost';
$db = 'donor_db';
$user = 'root';
$pass = '';

// Debugging: Check the request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit();
}

// Check if the aadharCardNumber is set in the POST data
if (!isset($_POST['aadharCardNumber'])) {
    echo json_encode(['success' => false, 'message' => 'Aadhar card number is missing.']);
    exit();
}

$aadharCardNumber = $_POST['aadharCardNumber'];

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare the delete statement
    $stmt = $pdo->prepare("DELETE FROM donors WHERE aadharCardNumber = ?");
    $stmt->execute([$aadharCardNumber]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Donor deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Donor not found.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
