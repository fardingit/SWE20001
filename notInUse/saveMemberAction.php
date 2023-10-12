<?php
// Database connection details
$host = "sql12.freesqldatabase.com";
$user = "sql12644946";
$pwd = "IfITVsCdpC";
$sql_db = "sql12644946";
// Create a new PDO instance
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

// Sanitize and validate the input data
$firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
$lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
$contact = filter_input(INPUT_POST, 'contact', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);

// Check if any field is empty
if (empty($firstName) || empty($lastName) || empty($contact) || empty($email) || empty($address)) {
    echo "All fields are required.";
    exit();
}

// Prepare and execute the SQL statement
try {
    $stmt = $conn->prepare("INSERT INTO members (firstName, lastName, contact, email, address) VALUES (:firstName, :lastName, :contact, :email, :address)");
    $stmt->bindParam(':firstName', $firstName);
    $stmt->bindParam(':lastName', $lastName);
    $stmt->bindParam(':contact', $contact);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':address', $address);
    $stmt->execute();

    echo "Member added successfully";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the database connection
$conn = null;
?>
