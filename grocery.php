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


    <section id="grocery">
        <h1>Grocery Table</h1>
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

        <form method="post">

            <p class="val">
                Add Grocery<br>
                <label for="name_input">Name:</label> <input type="text" name="name" id="name_input" pattern="[A-Za-z]{0,20}" required/>
                <label for="price_input">Price: $</label> <input type="number" name="price" size="8" id="price_input" pattern="[0-9]{0,4}" required/>
                <label for="stock_input">Stock:</label><input type="number" name="stock" size="8" pattern="[0-9]{0,5}" id="stock_input"/>
                <input type="submit" name="add" value="Add">
            </p>

        </form>

        <?php
        $sql_table = "grocery";
        include 'get_result.php';
        ?>

    </section>

</body>

</html>