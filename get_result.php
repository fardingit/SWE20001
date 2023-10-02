<?php
require_once('GotoGro.php');
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

use GotoGro as GG;

$query = "";

//if the search button is pressed takes the entered value and finds the needed rows 
if (isset($_POST['search'])) {
    $val = trim($_POST["val"]);
    $result = GG\search($sql_table, $val);

    if ($result) {
        echo GG\format_table($result);
        mysqli_free_result($result);
    } else $err_flag = true;
}

//if display all button is clicked, selects all columns and rows from table
else if (isset($_POST['display_all'])) {
    $val = trim($_POST["val"]);
    $result = GG\display_all($sql_table);
    //result is true, displays all rows
    if ($result) {
        echo GG\format_table($result);
        mysqli_free_result($result);
    } else $err_flag = true;
}

// Add function
else if (isset($_POST['add'])) {
    $result = GG\add($sql_table);
    if ($result) {
        echo "{$_POST['name']} successfully added!";
    } else $err_flag = true;
}

// Delete button pressed, takes the value of entered and deletes all positions with that value
else if (isset($_POST['delete'])) {
    $val = trim($_POST["val"]);
    $result = GG\delete($sql_table, $val);

    if ($result > 0) {
        echo "<p> RECORD DELETED! </p>";
    } else if ($result == 0) {
        echo "<p> Nothing deleted? </p>";
    } else $err_flag = true;
}

// Retrieve values for editing
else if (isset($_POST['edit'])) {
    $val = trim($_POST["val"]);
    GG\edit($sql_table, $val);
}

// Send edited values to update
if (isset($_POST['update'])) {

    switch ($sql_table) {
        case 'grocery':
            $edited_groceryid = trim($_POST["edited_groceryid"]);
            $edited_price = trim($_POST["edited_price"]);
            $edited_itemname = trim($_POST["edited_itemname"]);
            $edited_stock = trim($_POST["edited_stock"]);

            // Construct an SQL UPDATE query
            $update_query = "UPDATE $sql_table SET 
                     price = '$edited_price', 
                     item_name = '$edited_itemname',
                     stock = '$edited_stock'
                     WHERE grocery_id = '$edited_groceryid'";
            break;
        case 'member':
            $edited_memberID = trim($_POST["edited_memberID"]);
            $edited_last_name = trim($_POST["edited_last_name"]);
            $edited_first_name = trim($_POST["edited_first_name"]);
            $edited_street = trim($_POST["edited_street"]);
            $edited_suburb = trim($_POST["edited_suburb"]);
            $edited_state = trim($_POST["edited_state"]);
            $edited_post = trim($_POST["edited_post"]);
            $edited_email = trim($_POST["edited_email"]);
            $edited_number = trim($_POST["edited_number"]);

            // Construct an SQL UPDATE query
            $update_query = "UPDATE $sql_table SET 
            last_name = '$edited_last_name',
            first_name = '$edited_first_name',
            street = '$edited_street',
            suburb = '$edited_suburb',
            state = '$edited_state',
            postcode = '$edited_post',
            email = '$edited_email',
            number = '$edited_number'
            WHERE memberID = '$edited_memberID'";
            break;

        default:
            # code...
            break;
    }
    $update_result = GG\update($update_query); // mysqli_query($db, $update_query);

    if (!$update_result) {
        echo "<p>Something is wrong with {$update_query}</p>";
    } else {
        echo "<p>Information updated successfully!</p>";
    }
    return $update_result;
}

if (isset($err_flag)) {
    echo "<p>Something is wrong with:", $query, "</p>";
}
