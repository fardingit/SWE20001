<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="manage page" />
    <meta name="keywords" content="manage, ym studio" />
    <meta name="author" content="YM" />
    <link href="styles/style.css" rel="stylesheet" />

    <title>Home page</title>
</head>

<body>
    <div id="navbar">
        <a id="sales_heading" href="sales.php"> Sales</a>
        <a id="grocery_heading" href="grocery.php">grocery</a>
        <a id="members_heading" href="members.php">members</a>
        <a id="index_heading" href="index.html">Home</a>
    </div>


    <section id="manage">
        <h1>Members Table</h1>
        <p>In order to manage the table:<br> First enter the needed value and press the required button.
            To search for result, enter value and press search. <br>To delete (deletes by refnum only)
            enter the required refnum then PRESS DELETE not search. To change status, enter the ID number <br>
            then select the desired status, then click on Change status. Thank you!
        </p>

        <form method="post">

            <p class="val"> <input type="text" name="val" id="val" />
                <input type="submit" name="search" value="Search" />
                <input type="submit" name="delete" value="Delete">
                <input type="submit" name="edit" value="Edit">
                <input type="submit" name="display_all" value="Display whole table">
            </p>
            
        </form>

        <?php

        $sql_table = "member";
        include 'get_result.php';
        ?>

    </section>

</body>

</html>