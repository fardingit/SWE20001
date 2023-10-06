<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta name="description" content="manage page"/>
        <meta name="keywords" content="manage, ym studio"/>
        <meta name="author" content="YM"/>
        <link href="styles/style.css" rel="stylesheet"/>
        
        <title>Home page</title>
    </head>

    <body>  
        <div id="navbar">
            <a id="sales_heading" href="sales.php"> Sales</a>
            <a id="grocery_heading" href="grocery.php">grocery</a>
            <a id="members_heading" href="members.php">members</a>
            <a id="index_heading" href="index.html">Home</a>
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
            
                <input type="submit" name="submit" value="Search" />
                <input type="submit" name="delete" value="Delete">
                <input type="submit" name="record" value="Record new">
                <input type="submit" name="display_all" value="Display whole table">
            </p>

        </form>

        <form method="post" >
        
        <p class="val">
            Record New Sale<br>
            <label for="name_input">Sale ID:</label><input type='text' name='sale_id' pattern='[0-9]{0,4}'><br>
            <label for="name_input">Item Name:</label><input type='text' name='item_name' pattern='[a-zA-z]{0,20}'><br>
            <label for="name_input">Date:</label> <input type='text' name='date' pattern='\d{1,2}/\d{1,2}/\d{4}'><br>
            <label for="name_input">Amount:</label><input type='text' name='amount'pattern='[0-9]{0,4}'><br>
            <input type='submit' name='add_sale' value='Add Sale'>
        </p>

        </form>

    <?php
        $sql_table = "sales";
        include 'get_result.php';
    ?>

</section>

</body>

</html>