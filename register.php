<?php
$host = 'localhost';
$db = 'donor_db';
$user = 'root';
$pass = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $bloodType = $_POST['bloodType'];
    $phone = $_POST['number'];
    $lastDonation = $_POST['lastDonation'];
    $location = $_POST['location'];
    $aadharCardNumber = $_POST['aadharCardNumber'];

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("
            INSERT INTO donors (firstName, lastName, dob, gender, bloodType, phone, lastDonation, location, aadharCardNumber)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([$firstName, $lastName, $dob, $gender, $bloodType, $phone, $lastDonation, $location, $aadharCardNumber]);

        echo "Donor registered successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
