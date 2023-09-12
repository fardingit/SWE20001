<?php
require_once('GotoGro.php');

use GotoGro as GG;

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

//Delete button pressed, takes the value of entered and deletes all positions with that value
else if (isset($_POST['delete'])) {
    $val = trim($_POST["val"]);
    $result = GG\delete($sql_table, $val);

    if ($result > 0) {
        echo "<p> RECORD DELETED! </p>";
    } else if ($result == 0) {
        echo "<p> Nothing deleted? </p>";
    } else $err_flag = true;
}

if (isset($err_flag)) {
    echo "<p>Something is wrong with ", $query, "</p>";
}
