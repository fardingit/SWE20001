<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Rafia"/>
    <title>Add Member</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <form id="addMemberForm">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <!-- Add any additional fields as needed -->
        
        <input type="submit" value="Add Member">
    </form>
    <script src="formHandler.js"></script>
</body>
</html>
