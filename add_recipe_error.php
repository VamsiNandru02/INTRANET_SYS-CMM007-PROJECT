<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rgstr_tbl";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
/*if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if user is not logged in
    header("Location: login_page.html");
    exit;
}*/

// Fetch user role from database
$user_id = $_SESSION['mail_id'];
$sql = "SELECT role FROM rgstr_tbl WHERE id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_role = $row['role'];
} else {
    // Handle the case if user role is not found
    $user_role = "";
}

// Check if user role is chef or recipe_seeker
if ($user_role == 'chef') {
    // Redirect to add recipe page if user is a chef
    header("Location: add_recipe.html");
    exit;
} else {
    // Set error message if user is not a chef
    $error_message = "Recipe Seekers are not allowed to add a new recipe.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Recipe Error</title>
    <style>
        .error-message {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="error-message"><?php echo $error_message; ?></div>
</body>
</html>
