<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="manage page" />
    <meta name="keywords" content="manage, ym studio" />
    <meta name="author" content="YM" />
    <link href="styles/style.css" rel="stylesheet" />

    <script src="scripts/memberValidation.js"></script>

    <title>grocery page</title>
</head>

<body>
    <form id="addMemberForm" method="post" novalidate>
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" pattern="/^[a-zA-Z' ]{0,20}+$/" required><br>
        <div class="feedback" id="firstName_feedback"></div>

        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" pattern="/^[a-zA-Z' ]{0,20}+$/" required><br>
        <div class="feedback" id="lastName_feedback"></div>

        <label for="contact">Contact:</label>
        <input type="tel" id="contact" name="contact" pattern="(?:\04\)?[1-9]\d\d\)?\d{3}\d{3}" required>
        <small>Format: (04xx) xxx xxx</small><br>
        <div class="feedback" id="contact_feedback"></div>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required><br>
        <div class="feedback" id="email_feedback"></div>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required><br>\
        <div class="feedback" id="address_feedback"></div>

        <button type="submit">Add Member</button>

    </form>

    
</body>
</html>
