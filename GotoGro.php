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
    //TODO    
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
