<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="manage page" />
    <meta name="keywords" content="manage, ym studio" />
    <meta name="author" content="YM" />
    <link href="styles/style.css" rel="stylesheet" />

    <script src="scripts/groceryValidation.js"></script>

    <title>grocery page</title>
</head>

<body>
     <!-- changed the nav bar style -->
     <div id="navbar">
        <a id="index_heading" href="index.php">Home</a>
        <a id="members_heading" href="members.php">Members</a>
        <a id="grocery_heading" href="grocery.php">Grocery</a>
        <a id="sales_heading" href="sales.php">Sales</a>
        <a id="downloadLink" style="display: none;" href="sales_data.csv" download="sales_data.csv">Download File</a>


    </div>


    <section id="grocery">
        <?php
        //low stock alert
        require_once('GotoGro.php');
        $low_stock = GotoGro\get_low_stock();
        if ($low_stock->num_rows > 0)
        {
            echo "<p><strong>ALERT:</strong> the following stock(s) are below set minimums:";
            echo GotoGro\format_table($low_stock);
        }
        ?>

        <h1>Grocery Table</h1>
        <p>In order to manage the table:<br> First enter the needed value and press the required button.
            To search for result, enter value and press search. <br>To delete (deletes by refnum only)
            enter the required refnum then PRESS DELETE not search. To change status, enter the ID number <br>
            then select the desired status, then click on Change status. Thank you!
        </p>


        <form method="post">

            <p class="val"> <input type="text" name="val" id="val" />
                <input type="submit" name="add_grocery" value="Add" />
                <input type="submit" name="search" value="Search" />
                <input type="submit" name="delete" value="Delete">
                <input type="submit" name="edit" value="Edit">
                <input type="submit" name="display_all" value="Display whole table">
                <input type="submit" name="generate_csv" value="Download report">        
            </p>

        </form>


        <?php
            $sql_table = "grocery";
            include 'get_result.php';
            
            if (isset($_POST['add_grocery'])){
                echo "<h2>Add Grocery item</h2>";
                echo "<form id='grocery_form' method='post' novalidate>";
                echo "<label for='name_input'>Name:</label><input type='text' name='name_input' id='name_input' required/>";
                echo "<div class='feedback' id='name_feedback'></div>";
                    
                echo "<label for='price_input'>Price: $</label><input type='number' name='price_input' size='8' id='price_input' required/>";
                echo "<div class='feedback' id='price_feedback'></div>";
                    
                echo "<label for='stock_input'>Stock:</label><input type='number' name='stock_input' size='8' id='stock_input'/>";
                echo "<div class='feedback' id='stock_feedback'></div>";

                echo "<input type='submit' name='add' value='Add Item'>";
                    
            }
        ?>

    </section>

</body>

</html>
