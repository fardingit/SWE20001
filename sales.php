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
            $query = "select sale_id, item_name, stock FROM $sql_table
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
                ."<th scope=\"col\">stock</th>\n" 
                ."</tr>\n ";
                //loops throgh rows for the result
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>\n ";
                    echo "<td>", $row["sale_id"], "</td>\n "; 
                    echo "<td>", $row["item_name"],"</td>\n"; 
                    echo "<td>", $row["stock"], "</td>\n ";

                    echo "</tr>\n ";
                }
                echo "</table>\n ";
                mysqli_free_result ($result);
            }
        }
        //if the submit button is pressed takes the entered value and finds the needed rows 
        else if(isset($_POST['submit'])){
            $val = trim($_POST["val"]);
            $query = "SELECT sale_id, item_name, stock FROM $sql_table 
            WHERE sale_id LIKE '$val' 
            OR item_name LIKE '$val'
            OR stock LIKE '$val'
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
                ."<th scope=\"col\">stock</th>\n" 
                ."</tr>\n ";

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>\n ";
                    echo "<td>", $row["sale_id"], "</td>\n "; 
                    echo "<td>", $row["item_name"], "</td>\n ";
                    echo "<td>", $row["stock"],"</td>\n"; 

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

        mysqli_close($conn);
    } 
?>

</section>

</body>

</html>