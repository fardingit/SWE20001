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


        <section id="manage">
            <h1>Members Table</h1>
            <p>In order to manage the table:<br> First enter the needed value and press the required button. 
                To search for result, enter value and press search. <br>To delete (deletes by refnum only) 
                enter the required refnum then PRESS DELETE not search. To change status, enter the ID number <br>
                then select the desired status, then click on Change status. Thank you! 
            </p>

        
        <form method="post" >
        
            <p class="val">	<input type="text" name="val" id="val" />
            
                <input type="submit" name="submit" value="Search" />
                <input type="submit" name="delete" value="Delete">
                <input type="submit" name="Edit" value="Edit">
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
        $sql_table="member";
        //DOES NOT create a new table if current doesnt exist.. to be added in "addmember"
        //if display all button is clicked, selects all columns and rows from table
        if(isset($_POST['display_all'])){
            $val = trim($_POST["val"]);
            $query = "select EOInumber, last_name, first_name, 
            street, suburb, state, postcode, email, number FROM $sql_table 
            ORDER BY EOInumber";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                echo "<p>Something is wrong with ", $query, "</p>";
            } 
            //result is true, displays all rows
            else {
                echo "<table border=\"1\">\n";
                echo "<tr>\n"
                ."<th scope=\"col\">EOInumber</th>\n" 
                ."<th scope=\"col\">last_name</th>\n" 
                ."<th scope=\"col\">first_name</th>\n" 
                ."<th scope=\"col\">street</th>\n" 
                ."<th scope=\"col\">suburb</th>\n"
                ."<th scope=\"col\">state</th>\n" 
                ."<th scope=\"col\">postcode</th>\n" 
                ."<th scope=\"col\">email</th>\n"
                ."<th scope=\"col\">number</th>\n" 
                ."</tr>\n ";
                //loops throgh rows for the result
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>\n ";
                    echo "<td>", $row["EOInumber"],"</td>\n"; 
            
                    echo "<td>", $row["last_name"], "</td>\n "; 
                    echo "<td>", $row["first_name"],"</td>\n"; 
                    echo "<td>", $row["street"], "</td>\n ";
                    echo "<td>", $row["suburb"], "</td>\n "; 
                    echo "<td>", $row["state"],"</td>\n"; 
                    echo "<td>", $row["postcode"], "</td>\n ";
                    echo "<td>", $row["email"], "</td>\n "; 
                    echo "<td>", $row["number"],"</td>\n"; 
                    echo "</tr>\n ";
                }
                echo "</table>\n ";
                mysqli_free_result ($result);
            }
        }
        //if the submit button is pressed takes the entered value and finds the needed rows 
        else if(isset($_POST['submit'])){
            $val = trim($_POST["val"]);
            $query = "select EOInumber, last_name, first_name, 
            street, suburb, state, postcode, email, number FROM $sql_table 
            WHERE last_name LIKE '$val%' 
            OR first_name LIKE '$val%'
            OR CONCAT_WS(' ',last_name, first_name) LIKE  '$val%'
            OR CONCAT_WS(' ',first_name, last_name) LIKE  '$val%'
            OR EOInumber LIKE '$val%'
            ORDER BY EOInumber";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                echo "<p>Something is wrong with ", $query, "</p>";
            } 

            else {
                echo "<table border=\"1\">\n";
                echo "<tr>\n"
                ."<th scope=\"col\">EOInumber</th>\n"            
                ."<th scope=\"col\">last_name</th>\n" 
                ."<th scope=\"col\">first_name</th>\n" 
                ."<th scope=\"col\">street</th>\n" 
                ."<th scope=\"col\">suburb</th>\n"
                ."<th scope=\"col\">state</th>\n" 
                ."<th scope=\"col\">postcode</th>\n" 
                ."<th scope=\"col\">email</th>\n"
                ."<th scope=\"col\">number</th>\n" 
                ."</tr>\n ";

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>\n ";
                    echo "<td>", $row["EOInumber"],"</td>\n"; 
                    echo "<td>", $row["last_name"], "</td>\n "; 
                    echo "<td>", $row["first_name"],"</td>\n"; 
                    echo "<td>", $row["street"], "</td>\n ";
                    echo "<td>", $row["suburb"], "</td>\n "; 
                    echo "<td>", $row["state"],"</td>\n"; 
                    echo "<td>", $row["postcode"], "</td>\n ";
                    echo "<td>", $row["email"], "</td>\n "; 
                    echo "<td>", $row["number"],"</td>\n"; 
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