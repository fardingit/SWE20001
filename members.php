<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="manage page" />
    <meta name="keywords" content="manage, ym studio" />
    <meta name="author" content="YM" />
    <link href="styles/style.css" rel="stylesheet" />

    <title>Home page</title>
</head>

<body>
     <!-- changed the nav bar style -->
     <h2 id="options">Members</h2>
    <div id="navbar">
        <a id="index_heading" href="index.php">Home</a>
        <a id="members_heading" href="members.php">Members</a>
        <a id="grocery_heading" href="grocery.php">Grocery</a>
        <a id="sales_heading" href="sales.php">Sales</a>
    </div>



    <section id="manage">
        <h1>Members Table</h1>
        <p>In order to manage the table:<br> First enter the needed value and press the required button.
            To search for result, enter value and press search. <br>To delete (deletes by refnum only)
            enter the required refnum then PRESS DELETE not search. To change status, enter the ID number <br>
            then select the desired status, then click on Change status. Thank you!
        </p>

        <form method="post">

            <p class="val"> <input type="text" name="val" id="val" />
                <input type="submit" name="add_member" value="Add" />
                <input type="submit" name="search" value="Search" />
                <input type="submit" name="delete" value="Delete">
                <input type="submit" name="edit" value="Edit">
                <input type="submit" name="display_all" value="Display whole table">
                <input type="submit" name="generate_csv" value="Download report">        

            </p>
            
        </form>

        <?php

            $sql_table = "member";
            include 'get_result.php';
            if (isset($_POST['add_member'])){//cleaner look, form shows up only when add button is pressed, other functionality refactored into getresult and gotogro.php
                echo "<h2>Add new member</h2>";
                echo "<form id='addMemberForm' method='post' onsubmit='return validate();' novalidate>";

                echo "Member ID: <input id = 'member_id' type='text' name='member_id' ><br>";
                echo "First Name: <input id = 'first_name' type='text' name='first_name' ><br>";
                echo "Last Name: <input id = 'last_name' type='text' name='last_name' ><br>";

                echo "Street: <input id = 'street' type='text' name='street' ><br>";
                echo "Suburb: <input id = 'suburb' type='text' name='suburb' ><br>";
                echo "State: <input id = 'state' type='text' name='state' ><br>";
                echo "Postcode: <input id = 'postcode' type='text' name='postcode' ><br>";  

                echo "Email: <input id= 'email' type='text' name='email' ><br>";  
                echo "Contact Number: <input id = 'number' type='text' name='number' ><br>";       
                
                echo "<input type='submit' name='add' value='Add Member'>";           
            }
    
        ?>
    </section>
    <div id="errorMessages"></div>
    <script src="scripts/memberValidation.js"></script>
</body>

</html>
