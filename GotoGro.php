<?php

namespace GotoGro;

use mysqli;

//connects to databse with details form settings file
function create_connection()
{
    require("settings.php");
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

function add($table)
{
    $db = create_connection();
    global $query;
    switch ($table) {
        case 'grocery':
            $query = "INSERT INTO grocery (item_name, price, stock) VALUES ('{$_POST['name']}', '{$_POST['price']}', '{$_POST['stock']}' )";
            break;
        case 'sales':
            $query = "";
            break;
        case 'member':
            $memberID = mysqli_real_escape_string($db, $_POST['member_id']);
            $firstName = mysqli_real_escape_string($db, $_POST['first_name']);
            $lastName = mysqli_real_escape_string($db, $_POST['last_name']);
            $street = mysqli_real_escape_string($db, $_POST['street']);
            $suburb = mysqli_real_escape_string($db, $_POST['suburb']);
            $state = mysqli_real_escape_string($db, $_POST['state']);
            $postcode = mysqli_real_escape_string($db, $_POST['postcode']);
            $email = mysqli_real_escape_string($db, $_POST['email']);
            $contactNumber = mysqli_real_escape_string($db, $_POST['number']);
            $query = "INSERT INTO member (memberID, first_name, last_name, street, suburb, state, postcode, email, number) 
                  VALUES ('$memberID', '$firstName', '$lastName', '$street', '$suburb', '$state', '$postcode', '$email', '$contactNumber')";

            break;
        default:
            throw new \Exception("Invalid table name: $table", 1);
            break;
    }

    $result = mysqli_query($db, $query);
    $db->close();
    return $result;
}

function search($table, $input)
{
    $db = create_connection();
    global $query;

    switch ($table) {
        case 'grocery':
            $query = "SELECT * FROM grocery WHERE grocery_id LIKE '$input' OR price LIKE '$input' OR item_name LIKE '$input' ORDER BY grocery_id";
            break;
        case 'sales':
            $query = "SELECT * FROM sales WHERE sale_id LIKE '$input' OR item_name LIKE '$input' OR stock LIKE '$input' ORDER BY sale_id";
            break;
        case 'member':
            $query = "SELECT * FROM $table WHERE last_name LIKE '$input' OR first_name LIKE '$input' OR CONCAT_WS(' ',last_name, first_name) LIKE '$input' OR CONCAT_WS(' ',first_name, last_name) LIKE  '$input' OR memberID LIKE '$input' ORDER BY memberID";
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
    global $query;
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
    global $query;
    $db = create_connection();

    $id_name = "";

    switch ($table) {
        case 'grocery':
            $id_name = "grocery_id";
            break;
        case 'member':
            $id_name = "memberID";
            break;
        default:
            # code...
            break;
    }

    $query = "SELECT * FROM $table WHERE $id_name = '$input'";
    $result = mysqli_query($db, $query);
    if (!$result) {
        echo "<p>Something is wrong with ", $query, "</p>";
    } else {
        $row = mysqli_fetch_assoc($result);
        if ($row) {
            switch ($table) {
                case 'grocery':
                    // Display a form with the grocery item's current information for editing
                    echo "<h2>Edit Item</h2>";
                    echo "<form method='post'>";

                    echo "Grocery ID: {$row['grocery_id']}<br>";
                    echo "<input type='hidden' name='edited_groceryid' value='{$row['grocery_id']}' >";
                    echo "Price: <input type='text' name='edited_price' value='{$row['price']}'><br>";
                    echo "Item name: <input type='text' name='edited_itemname' value='{$row['item_name']}'><br>";
                    echo "Stock: <input type='text' name='edited_stock' value='{$row['stock']}'><br>";
                    echo "Stock minimum: <input type='text' name='edited_stock_min' value='{$row['stock_min']}'><br>";

                    echo "<input type='submit' name='update' value='Update'>";
                    echo "</form>";
                    break;

                case 'member':
                    // Display a form with the member's current information for editing
                    echo "<h2>Edit Member</h2>";
                    echo "<form method='post'>";
                    echo "Member ID: {$row['memberID']}<br>";
                    echo "<input type='text' name='edited_memberID' value='{$row['memberID']}' id='edited_memberID' readonly hidden>";
                    echo "Last Name: <input type='text' name='edited_last_name' value='{$row['last_name']}'><br>";
                    echo "First Name: <input type='text' name='edited_first_name' value='{$row['first_name']}'><br>";
                    echo "Street: <input type='text' name='edited_street' value='{$row['street']}'><br>";
                    echo "Suburb: <input type='text' name='edited_suburb' value='{$row['suburb']}'><br>";
                    echo "State: <input type='text' name='edited_state' value='{$row['state']}'><br>";
                    echo "Postcode: <input type='text' name='edited_post' value='{$row['postcode']}'><br>";
                    echo "Email: <input type='text' name='edited_email' value='{$row['email']}'><br>";
                    echo "Number: <input type='text' name='edited_number' value='{$row['number']}'><br>";

                    echo "<input type='submit' name='update' value='Update'>";
                    echo "</form>";
                    break;

                    // case 'sales':
                    //     // Display a form with the grocery item's current information for editing
                    //     echo "<h2>Edit Item</h2>";
                    //     echo "<form method='post'>";

                    //     echo "Grocery ID: {$row['grocery_id']}<br>";
                    //     echo "<input type='hidden' name='edited_groceryid' value='{$row['grocery_id']}' >";
                    //     echo "Price: <input type='text' name='edited_price' value='{$row['price']}'><br>";
                    //     echo "Item name: <input type='text' name='edited_itemname' value='{$row['item_name']}'><br>";
                    //     echo "Stock: <input type='text' name='edited_stock' value='{$row['stock']}'><br>";

                    //     echo "<input type='submit' name='update' value='Update'>";
                    //     echo "</form>";
                    //     break;
                default:
                    # code...
                    break;
            }
        } else {
            echo "<p>No item found with ID: $input</p>";
        }

        mysqli_free_result($result);
    }

    $db->close();
}

function update($update_query)
{
    $db = create_connection();
    $result = mysqli_query($db, $update_query);

    mysqli_free_result($result);

    $db->close();
    return $result;
}

function display_all($table)
{
    global $query;
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

function get_low_stock()
{
    $db = create_connection();

    $query = "SELECT * FROM grocery WHERE stock < stock_min";

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
