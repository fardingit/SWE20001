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
if (isset($_SERVER['HTTP_REFERER'])) {//makeshift authentication, checks if reference came from login page, only allows accces then
    $referrer = $_SERVER['HTTP_REFERER'];
    
    if (strpos($referrer, 'login_index.php') !== false) {

    } else {
        echo "<a id='loginref' href='login_index.php'>Login</a>";
        header('HTTP/1.0 403 Forbidden', true, 403);
        die("<h2>Please Login</h2>");
    }
} else {
    echo "<a id='loginref' href='login_index.php'>Login</a>";
    header('HTTP/1.0 403 Forbidden', true, 403);
    die("<h2> Please Login</h2>");
}
?>
<body id="index_body">
    <h1 id="options">Databases</h1>

    <a class="home_option" href="members.php" id="memberst">
        <span>Members</span>
        <i></i>
    </a>
    <a class "home_option" href="grocery.php" id="groceryt">
        <span>Grocery</span>
        <i></i>
    </a>
    <a class="home_option" href="sales.php" id="salest">
        <span>Sales</span>
        <i></i>
    </a>

    <footer>GotoGro: MRM 2023</footer>
</body>
</html>
