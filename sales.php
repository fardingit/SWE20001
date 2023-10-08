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

<?php
 //connects to databse with details form settings file
    require_once("settings.php");
    $conn = @mysqli_connect ($host,
        $user, 
        $pwd, 
        $sql_db
    );

    if (!$conn) {
        echo "<p>Database connection failure</p>";
    } 
    //connection is successful
    else {
    //connect to table applications
        $sql_table="sales";
        
        //if display all button is clicked, selects all columns and rows from table
        if(isset($_POST['display_all'])){
            $val = trim($_POST["val"]);
            $query = "select sale_id, item_name, date, amount FROM $sql_table
            ORDER BY sale_id"; 
            $result = mysqli_query($conn, $query);

            if (!$result) {
                echo "<p>Something is wrong with ", $query, "</p>";
            } 
            //result is true, displays all rows
            else {
                echo "<table border=\"1\">\n";
                echo "<tr>\n"
                ."<th scope=\"col\">sale_id</th>\n"            
                ."<th scope=\"col\">item_name</th>\n"
                ."<th scope=\"col\">date</th>\n" 
                ."<th scope=\"col\">amount</th>\n" 
                ."</tr>\n ";
                //loops throgh rows for the result
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>\n ";
                    echo "<td>", $row["sale_id"], "</td>\n "; 
                    echo "<td>", $row["item_name"],"</td>\n"; 
                    echo "<td>", $row["date"], "</td>\n ";
                    echo "<td>", $row["amount"], "</td>\n ";

                    echo "</tr>\n ";
                }
                echo "</table>\n ";
                mysqli_free_result ($result);
            }
        }
        //if the submit button is pressed takes the entered value and finds the needed rows 
        else if(isset($_POST['submit'])){
            $val = trim($_POST["val"]);
            $query = "SELECT sale_id, item_name, date, amount FROM $sql_table 
            WHERE sale_id LIKE '$val' 
            OR item_name LIKE '$val'
            OR date LIKE '$val'
            OR amount LIKE '$val'
            ORDER BY sale_id";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                echo "<p>Something is wrong with ", $query, "</p>";
            } 

            else {
                echo "<table border=\"1\">\n";
                echo "<tr>\n"
                ."<th scope=\"col\">sale_id</th>\n"            
                ."<th scope=\"col\">item_name</th>\n" 
                ."<th scope=\"col\">date</th>\n" 
                ."<th scope=\"col\">amount</th>\n" 
                ."</tr>\n ";

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>\n ";
                    echo "<td>", $row["sale_id"], "</td>\n "; 
                    echo "<td>", $row["item_name"], "</td>\n ";
                    echo "<td>", $row["date"],"</td>\n"; 
                    echo "<td>", $row["amount"],"</td>\n"; 

                    echo "</tr>\n ";
                }
                echo "</table>\n ";
                mysqli_free_result($result);
            }
        }
        //Delete button pressed, takes the value of entered and deletes all positions with that value
        else if(isset($_POST['delete'])){
            $val = trim($_POST["val"]);
            $query = "DELETE FROM $sql_table WHERE refnum='$val'";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                echo "<p>Something is wrong with ", $query, "</p>";
            }
            else {
                echo "<p> RECORD DELETED! </p>";
                
            } 
            
        }
        else if (isset($_POST['record'])){
            echo "<h2>Record New Sale</h2>";
            echo "<form id='sales_form' method='post' novalidate>";
            echo "Sale ID: <input type='text' name='sale_id' pattern='[0-9]{0,4}'><br>";
            echo "Item Name: <input type='text' name='item_name' pattern='[a-zA-z]{0,20}'><br>";
            echo "Date: <input type='text' name='date' pattern='\d{1,2}/\d{1,2}/\d{4}'><br>";
            echo "Amount: <input type='text' name='amount'pattern='[0-9]{0,4}'><br>";
            echo "<input type='submit' name='add_sale' value='Add Sale'>";
            echo "</form>";
        }if(isset($_POST['add_sale'])) {
            $sale_id = trim($_POST["sale_id"]);
            $item_name = trim($_POST["item_name"]);
            $date = trim($_POST["date"]);
            $amount = trim($_POST["amount"]);

            // Validate input and insert into the database
            if (!empty($sale_id) && !empty($item_name) && !empty($date) && !empty($amount)) {
                $insert_query = "INSERT INTO $sql_table (sale_id, item_name, date, amount) 
                                 VALUES ('$sale_id', '$item_name', '$date', '$amount')";
                $insert_result = mysqli_query($conn, $insert_query);
                
                if ($insert_result) {
                    echo "<p>New sale recorded successfully!</p>";
                } else {
                    echo "<p>Error recording new sale: " . mysqli_error($conn) . "</p>";
                }
            } else {
                echo "<p>Please fill in all fields to record a new sale.</p>";
            }
        }

        mysqli_close($conn);
    } 
?>

</section>

</body>

</html>