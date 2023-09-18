<?php

namespace GotoGro;

use mysqli;

//connects to databse with details form settings file
function create_connection()
{
    require_once("settings.php");
    $conn = @mysqli_connect(
        $host,
        $user,
        $pwd,
        $sql_db
    );

    if (!$conn) {
        echo "<p>Database connection failure</p>";
    }
    return $conn;
}

function search($table, $input)
{
    $db = create_connection();

    switch ($table) {
        case 'grocery':
            $query = "SELECT * FROM grocery WHERE grocery_id LIKE '$input' OR price LIKE '$input' OR item_name LIKE '$input' ORDER BY grocery_id";
            break;
        case 'sales':
            $query = "SELECT * FROM sales WHERE sale_id LIKE '$input' OR item_name LIKE '$input' OR stock LIKE '$input' ORDER BY sale_id";
            break;
        case 'member':
            $query = "SELECT * FROM member WHERE EOInumber LIKE '$input' OR first_name LIKE '$input' OR last_name LIKE '$input' ORDER BY EOInumber";
            break;
        default:
            throw new \Exception("Invalid table name: $table", 1);
            break;
    }

    $result = mysqli_query($db, $query);
    $db->close();

    return $result;
}

function delete($table, $input)
{
    $db = create_connection();
    switch ($table) {
        case 'grocery':
            $query = "DELETE FROM grocery WHERE grocery_id='$input'";
            break;
        case 'sales':
            $query = "DELETE FROM sales WHERE sales_id='$input'";
            break;
        case 'member':
            $query = "DELETE FROM member WHERE member_id='$input'";
            break;
        default:
            throw new \Exception("Invalid table name: $table", 1);
            break;
    }

    mysqli_query($db, $query);
    // the result of above just seems to be true/false
    $result = mysqli_affected_rows($db);
    $db->close();

    return $result;
}

function edit($table, $input)
{
    $db = create_connection();
    $query = "SELECT * FROM $table WHERE grocery_id = '$input'";
    $result = mysqli_query($db, $query);
    if (!$result) {
        echo "<p>Something is wrong with ", $query, "</p>";
    }else {
        $row = mysqli_fetch_assoc($result);
        if ($row) {
            // Display a form with the member's current information for editing
            echo "<h2>Edit Item</h2>";
            echo "<form method='post'>";
            
            echo "Grocery ID: <input type='text' name='edited_groceryid' value='{$row['grocery_id']}'><br>";
            echo "Price: <input type='text' name='edited_price' value='{$row['price']}'><br>";
            echo "Item name: <input type='text' name='edited_itemname' value='{$row['item_name']}'><br>";
            echo "Stock: <input type='text' name='edited_stock' value='{$row['stock']}'><br>";

            echo "<input type='submit' name='update' value='Update'>";
            echo "</form>";
        } else {
            echo "<p>No item found with ID: $input</p>";
        }

        mysqli_free_result($result);
        if (isset($_POST['update'])) {
            $edited_groceryid = trim($_POST["edited_groceryid"]);
            $edited_price = trim($_POST["edited_price"]);
            $edited_itemname = trim($_POST["edited_itemname"]);
            $edited_stock = trim($_POST["edited_stock"]);
    
            // Construct an SQL UPDATE query
            $update_query = "UPDATE $table SET 
                             price = '$edited_price', 
                             item_name = '$edited_itemname',
                             stock = '$edited_stock',
                             grocery_id = '$edited_groceryid'                                 
                             WHERE grocery_id = '$edited_groceryid'";
    
            $update_result = mysqli_query($db, $update_query);
    
            if (!$update_result) {
                echo "<p>Something is wrong with the update query</p>";
            } else {
                echo "<p>Member information updated successfully!</p>";
            }
            return $update_result;
        }
    }
    
    $db->close();

    
}

function display_all($table)
{
    $db = create_connection();

    switch ($table) {
        case 'grocery':
            $query = "SELECT * FROM grocery";
            break;
        case 'sales':
            $query = "SELECT * FROM sales";
            break;
        case 'member':
            $query = "SELECT * FROM member";
            break;
        default:
            throw new \Exception("Invalid table name: $table", 1);
            break;
    }

    $result = mysqli_query($db, $query);
    $db->close();

    return $result;
}

function format_table($query_result)
{
    $html = "<table border=\"1\">\n";
    $html .= "<tr>\n";
    $fields = mysqli_fetch_fields($query_result);
    foreach ($fields as $field) {
        $html .= "<th scope=\"col\">$field->name</th>\n";
    }
    $html .= "</tr>\n";

    while ($row = mysqli_fetch_row($query_result)) {
        $html .= "<tr>\n";
        foreach ($row as $cell) {
            $html .= "<td> $cell </td>\n ";
        }
        $html .= "</tr>\n";
    }
    $html .= "</table>\n ";
    return $html;
}
