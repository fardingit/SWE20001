<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="description" content="home page" />
    <meta name="keywords" content="home, index, first" />
    <meta name="author" content="YM" />
    <link href="styles/style.css" type="text/css" rel="stylesheet" />
    <title>Home page</title>
</head>

<?php
if (!isset($_SERVER['HTTP_REFERER']) || strpos($_SERVER['HTTP_REFERER'], 'login_index.php') === false) {
?>
    <body id="index_body">
        <h1>Welcome to Goto Grocery Management System!</h1>
        <h3>Staff access only</h3>
        <a id='loginref' href='login_index.php'>
            <span>Proceed to Login</span>
            <i></i>
        </a>
    </body>
</html>
<?php
    header('HTTP/1.0 403 Forbidden', true, 403);
    exit;
}
?>

<body id="index_body">
    <h1 id="options">Databases</h1>

    <a class="home_option" href="members.php" id="memberst">
        <span class="text">Members</span>
        <i></i>
    </a>
    <a class="home_option" href="grocery.php" id="groceryt">
        <span class="text">Grocery</span>
        <i></i>
    </a>
    <a class="home_option" href="sales.php" id="salest">
        <span class="text">Sales</span>
        <i></i>
    </a>

    <footer>GotoGro: MRM 2023</footer>
</body>
</html>
