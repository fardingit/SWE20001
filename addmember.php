<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Add Member</title>
</head>
<body>
    <form id="addMemberForm">
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" required><br>

        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" required><br>
        
        <label for="contact">Contact:</label>
        <input type="tel" id="contact" name="contact" pattern="(?:\04\)?[1-9]\d\d\)?\d{3}\d{3}" required>
        <small>Format: (04xx) xxx xxx</small><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required><br>

        <button type="submit">Add Member</button>

    </form>

    <script src="script.js"></script>
</body>
</html>
