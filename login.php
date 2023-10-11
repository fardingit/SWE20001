<?php
session_start();

require_once("settings.php");
    $conn = @mysqli_connect ($host,
        $user, 
        $pwd, 
        $sql_db

if(isset($_POST['uname']) && isset($_POST['password'])) {

    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return data;
    }
}

$uname = validate($_POST['uname']);
$pass = validate($_POST['password']);

if(empty($uname)) {
    header ("Location: index.php?error=User name is required.");
    exit();
}
else if(empty($pass)) {
    header ("Location: index.php?error=Password is required.");
    exit();
}

$sql = "SELECT * FROM users WHERE user_name='$uname' AND password='$pass'";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    if($row['user name'] === $uname && $row['password'] === $pass) {
        echo "Successfully logged in.";
        $_SESSION['user_name'] = $row['user_name'];
        $_SESSION['password'] = $row['name'];
        $_SESSION['id'] = $row['id'];
        header("Location: index.html");
        exit();
    }
    else {
        header("Location: login_index.php?error=Incorrect user name or password.");
        exit();
    }
}
else {
    header("Location: login_index.php");
    exit();
}