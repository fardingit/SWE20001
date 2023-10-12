<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta name="description" content="manage page"/>
        <meta name="keywords" content="manage, ym studio"/>
        <meta name="author" content="YM"/>
        <link href="styles/style.css" rel="stylesheet"/>
        <script src="scripts/salesValidation.js"></script>
        
        <title>Home page</title>
    </head>

    <body>  
    
      <!-- changed the nav bar style -->
      <div id="navbar">
        <a id="index_heading" href="index.php">Home</a>
        <a id="members_heading" href="members.php">Members</a>
        <a id="grocery_heading" href="grocery.php">Grocery</a>
        <a id="sales_heading" href="sales.php">Sales</a>
     </div>
        


        <section id="sales">
            <h1>Sales Table</h1>
            <p>In order to manage the table:<br> First enter the needed value and press the required button. 
                To search for result, enter value and press search. <br>To delete (deletes by refnum only) 
                enter the required refnum then PRESS DELETE not search. To change status, enter the ID number <br>
                then select the desired status, then click on Change status. Thank you! 
            </p>

        
        <form method="post" >
        
            <p class="val">	<input type="text" name="val" id="val" />

                <input type="submit" name="add_sales" value="Record new">
                <input type="submit" name="search" value="Search" />
                <input type="submit" name="delete" value="Delete">
                <input type="submit" name="edit" value="Edit">
                <input type="submit" name="display_all" value="Display whole table">
            </p>

        </form>

        <?php
            $sql_table = "sales";
            include 'get_result.php';
            if (isset($_POST['add_sales'])){
                echo "<h2>Add Sales item</h2>";
                echo "<form id='sales_form' method='post' novalidate>";
                
                echo "<label for='item_name'>Name:</label><input type='text' name='name' id='item_name' required/>";
                echo "<div class='feedback' id='item_name_feedback'></div>";
                    
                echo "<label for='date'>Date: $</label><input type='number' name='date' size='8' id='date' required/>";
                echo "<div class='feedback' id='date_feedback'></div>";
                    
                echo "<label for='amount_input'>Amount:</label><input type='number' name='amount' size='8' id='amount_input'/>";
                echo "<div class='feedback' id='amount_feedback'></div>";

                echo "<input type='submit' name='add' value='Add Item'>";
                    
            }
        ?>

</section>

</body>

</html>