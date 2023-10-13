
<?php
require_once('GotoGro.php');

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
        echo "successfully added!";
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
            $edited_stock_min = trim($_POST["edited_stock_min"]);

            // Construct an SQL UPDATE query
            $update_query = "UPDATE $sql_table SET 
                     price = '$edited_price', 
                     item_name = '$edited_itemname',
                     stock = '$edited_stock',
                     stock_min = '$edited_stock_min'
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

            case 'sales':
                 $edited_sale_id = trim($_POST["edited_sale_id"]);
                 $edited_salesitemname = trim($_POST["edited_salesitemname"]);
                 $edited_date = trim($_POST["edited_date"]);
                 $edited_amount = trim($_POST["edited_amount"]);

    
                 // Construct an SQL UPDATE query
                 $update_query = "UPDATE $sql_table SET 
                        price = '$edited_salesitemname', 
                        item_name = '$edited_date',
                        stock = '$edited_amount'
                        WHERE sale_id = '$edited_sale_id'";
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
if (isset($_POST['calculate_total'])) 
{
    echo "<h2>Enter dates</h2>";
    echo "<form id='dateinput' method='post' novalidate>";
    echo "<label for='date'>Starting: </label><input type='date' name='start_date' size='8' id='start_date' required/>";
    echo "<div class='feedback' id='start_date_feedback'></div>";
    echo "<label for='date'>Ending: </label><input type='date' name='end_date' size='8' id='end_date' required/>";
    echo "<div class='feedback' id='end_date_feedback'></div>";
    echo "<input type='submit' name='calculate_sales' value='Calculate sales'>"; 
    
}
if (isset($_POST['calculate_sales'])) 
    {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $total_price = GG\calculateTotalPrice($start_date, $end_date);
    if ($total_price > 0) {
        echo "Total sales between $start_date and $end_date: $$total_price";
    } else {
        echo "No sales data found for the selected date range.";
    }
    }
if (isset($_POST['generate_csv'])) 
{
    switch ($sql_table) {
        case 'grocery':
            GG\generateGroceryCsvReport();
            echo '<script>';
            echo 'function downloadFile() {';
            echo '  var downloadLink = document.createElement("a");';
            echo '  downloadLink.href = "grocery_data.csv";'; // Set the CSV file path
            echo '  downloadLink.download = "grocery.csv";'; // Set the desired file name
            echo '  downloadLink.style.display = "none";';
            echo '  document.body.appendChild(downloadLink);';
            echo '  downloadLink.click();';
            echo '  document.body.removeChild(downloadLink);';
            echo '}';
            echo 'downloadFile();';
            echo '</script>';
            break;
        case 'sales':
            GG\generateSalesCsvReport();
            echo '<script>';
            echo 'var downloadLink = document.createElement("a");';
            echo 'downloadLink.href = "sales_data.csv";'; // Set the CSV file path
            echo 'downloadLink.download = "sales.csv";'; // Set the desired file name
            echo 'downloadLink.style.display = "none";';
            echo 'document.body.appendChild(downloadLink);';
            echo 'downloadLink.click();';
            echo 'document.body.removeChild(downloadLink);';
            echo '</script>';
            break;
        case 'member':
            GG\generateMemberCsvReport(); 
            echo '<script>';
            echo 'function downloadFileMembers() {';
            echo '  var downloadLink = document.createElement("a");';
            echo '  downloadLink.href = "member_data.csv";'; // Set the CSV file path
            echo '  downloadLink.download = "members.csv";'; // Set the desired file name
            echo '  downloadLink.style.display = "none";';
            echo '  document.body.appendChild(downloadLink);';
            echo '  downloadLink.click();';
            echo '  document.body.removeChild(downloadLink);';
            echo '}';
            echo 'downloadFileMembers();';
            echo '</script>';
            break;




        }
}   

if (isset($err_flag)) {
    echo "<p>Something is wrong with:", $query, "</p>";
}


