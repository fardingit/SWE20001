<?php
require_once("settings.php");

// Connect to the database
$conn = @mysqli_connect($host, $user, $pwd, $sql_db);

// Check for successful connection
if (!$conn) {
    echo "Database connection failure";
    exit;
}

// Get the form data
$name = mysqli_real_escape_string($conn, $_POST['name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);

// SQL query to insert the new member
$sql = "INSERT INTO members (name, email) VALUES ('$name', '$email')";

// Execute the query
if (mysqli_query($conn, $sql)) {
    echo "New member added successfully";
} else {
    echo "Error: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>
