<!-- Basic login page, not styled -->
<!DOCTYPE html>
<html>

<head>
    <title> Login page </title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <form id="login form" method="post">
        <h2>LOGIN</h2>
        <label> User Name </label>
        <input type="text" name="uname" palceholder="User name"><br>
        <label> Password </label> 
        <input type="password" name="password"palceholder="Password"><br>

        <button type="submit">Login</button>
    </form>

    <?php
    session_start();
require_once('settings.php');//seperate table for login credentials
$_SESSION['isLoggedIn'] = false;//attempt at a getting a local variable to store login state(failed/gave up) 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['uname'];
    $password = $_POST['password'];

    $conn = mysqli_connect($host, $user, $pwd, $sql_db);

    if (!$conn) {
        die("Database connection error: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM UserCredentials WHERE username = '$username'";

    $result = mysqli_query($conn, $sql);
    

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if ($password == $row['password']) {
            echo "Login successful!";
            header('Location: index.php');//refers to index, access now granted to index since it is referred from the correct source
        exit;
        } else {
            echo "Incorrect password." ;

        }
    } else {
        echo "User not found.";
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
<script>

</script>

</body>

</html>