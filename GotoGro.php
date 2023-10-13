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
            $name_input = mysqli_real_escape_string($db, $_POST['name_input']);
            $price = mysqli_real_escape_string($db, $_POST['price_input']);
            $stock = mysqli_real_escape_string($db, $_POST['stock_input']);

            $query = "INSERT INTO grocery (item_name, price, stock) 
                VALUES ('$name_input', '$price', '$stock')";
            break;
        case 'sales':
            $item_name = mysqli_real_escape_string($db, $_POST['item_name']);
            $date = mysqli_real_escape_string($db, $_POST['date']);
            $amount = mysqli_real_escape_string($db, $_POST['amount_input']);

            $query = "INSERT INTO sales (item_name, date, amount) 
                VALUES ('$item_name', '$date', '$amount')";
            break;
        case 'member':
            $memberID = mysqli_real_escape_string($db, $_POST['member_id']);
            $first_name = mysqli_real_escape_string($db, $_POST['first_name']);
            $lastName = mysqli_real_escape_string($db, $_POST['last_name']);
            $street = mysqli_real_escape_string($db, $_POST['street']);
            $suburb = mysqli_real_escape_string($db, $_POST['suburb']);
            $state = mysqli_real_escape_string($db, $_POST['state']);
            $postcode = mysqli_real_escape_string($db, $_POST['postcode']);
            $email = mysqli_real_escape_string($db, $_POST['email']);
            $contactNumber = mysqli_real_escape_string($db, $_POST['number']);
            $query = "INSERT INTO member (memberID, first_name, last_name, street, suburb, state, postcode, email, number) 
                  VALUES ('$memberID', '$first_name', '$lastName', '$street', '$suburb', '$state', '$postcode', '$email', '$contactNumber')";

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
            $query = "SELECT * FROM sales WHERE sale_id LIKE '$input' OR item_name LIKE '$input' OR amount LIKE '$input' OR date LIKE '$input' ORDER BY sale_id";
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
            $query = "DELETE FROM sales WHERE sale_id='$input'";
            break;
        case 'member':
            $query = "DELETE FROM member WHERE memberID='$input'";
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
        case 'sales':
            $id_name = "sale_id";
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

                    case 'sales':
                        // NO SALES EDITING NEEDED (CODE UNUSED)
                         echo "<h2>Edit Item</h2>";
                         echo "<form method='post'>";
    
                         echo "Sales ID: {$row['sale_id']}<br>";
                         echo "<input type='hidden' name='edited_sale_id' value='{$row['sale_id']}' >";
                         echo "Item Name: <input type='text' name='edited_salesitemname' value='{$row['item_name']}'><br>";
                         echo "Date: <input type='text' name='edited_date' value='{$row['date']}'><br>";
                         echo "Amount: <input type='text' name='edited_amount' value='{$row['amount']}'><br>";
    
                         echo "<input type='submit' name='update' value='Update'>";
                         echo "</form>";
                         break;
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
function calculateTotalPrice($start_date, $end_date)
{
    $db = create_connection();
    $sql = "SELECT SUM(price) AS total_price FROM sales WHERE date >= '$start_date' AND date <= '$end_date'";

    $result = mysqli_query($db, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total_price'];
    }

    return 0;
}
function generateSalesCsvReport()
{
    require_once("settings.php");

    // Enable error reporting for debugging
    error_reporting(E_ALL);

    $conn = @mysqli_connect($host, $user, $pwd, $sql_db);

    if (!$conn) {
        echo "<p>Database connection failure</p>";
        return;
    }

    $query = "SELECT sale_id, item_name, date, amount, price FROM sales";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "<p>Database query error: " . mysqli_error($conn) . "</p>";
        return;
    }
    $file = fopen('sales_data.csv', 'w');

    // Write the CSV header
    fputcsv($file, array('Sale ID', 'Item Name', 'Date', 'Amount', 'Price'));

    // Write the data rows
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($file, $row);
    }

    fclose($file);



    mysqli_close($conn);
}
function generateGroceryCsvReport()
{
  
    $conn=create_connection();

    $query = "SELECT grocery_id, price, item_name, stock, stock_min FROM grocery";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "<p>Database query error: " . mysqli_error($conn) . "</p>";
        return;
    }
    $file = fopen('grocery_data.csv', 'w');

    // Write the CSV header
    fputcsv($file, array('Item ID', 'Price', 'Item Name', 'Stock', 'Stock mininmum'));

    // Write the data rows
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($file, $row);
    }

    fclose($file);



    mysqli_close($conn);
}
function generateMemberCsvReport()
{
  
    $conn=create_connection();

    $query = "SELECT memberID, first_name, last_name, street, suburb, state, postcode, email, number FROM member";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "<p>Database query error: " . mysqli_error($conn) . "</p>";
        return;
    }
    $file = fopen('member_data.csv', 'w');

    // Write the CSV header
    fputcsv($file, array('Member ID', 'First Name', 'Last Name', 'Street', 'Suburb ', 'State ','PostCode', 'Email ', 'Number '));

    // Write the data rows
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($file, $row);
    }

    fclose($file);



    mysqli_close($conn);
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

