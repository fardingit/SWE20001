<?php
session_start();
include "userdb_conn.php";

// Checking if 'uname' and 'password' are set
if(isset($_POST['uname']) && isset($_POST['password'])) {

    // Validating input function
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data; // Corrected: added "$" before "data"
    }

    // Validating and sanitizing input
    $uname = validate($_POST['uname']);
    $pass = validate($_POST['password']);

    // Checking for empty credentials
    if(empty($uname)) {
        header ("Location: index.php?error=User name is required.");
        exit();
    } else if(empty($pass)) {
        header ("Location: index.php?error=Password is required.");
        exit();
    }

    // SQL query, avoid using direct variables ($uname, $pass) to prevent SQL injection
    $sql = "SELECT * FROM users WHERE user_name=?"; // Using placeholders
    $stmt = mysqli_prepare($conn, $sql); // Preparing the SQL statement
    mysqli_stmt_bind_param($stmt, "s", $uname); // Binding parameters

    // Execute statement
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Checking result
    if(mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Verifying hashed password and starting a session
        if(password_verify($pass, $row['password'])) { // Use password_verify()
            echo "Successfully logged in.";
            $_SESSION['user_name'] = $row['user_name'];
            $_SESSION['name'] = $row['name']; // Not 'password' I assume it was a mistake
            $_SESSION['id'] = $row['id'];
            header("Location: index.html");
            exit();
        } else {
            header("Location: login_index.php?error=Incorrect user name or password.");
            exit();
        }
    } else {
        header("Location: login_index.php");
        exit();
    }
} else { // Added to handle case where 'uname' or 'password' is not set
    header("Location: login_index.php");
    exit();
}
?>
