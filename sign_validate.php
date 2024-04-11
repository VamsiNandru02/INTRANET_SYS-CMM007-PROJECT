<?php
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

// Form data
$email = $_POST['username']; //"vansinandru25@gmail.com"; //
$password = $_POST['password']; //"756847g"; //

// Check if email and password match in the database using prepared statements
$sql = "SELECT * FROM rgstr WHERE mail_id = ? AND pass_code = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $password); // Corrected type definition string
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // User exists, set session or redirect to main_page.php
    session_start();
    $_SESSION['email'] = $email; // You can store more user data in session if needed

    // Fetch the user's role from the database
    $user = $result->fetch_assoc();
    $role = $user['role']; // Assuming the column name for role is 'role'
    
    // Redirect to main_page.php with role parameter
    header("Location: main_page.php?role=$role");
} else {
    // User doesn't exist or credentials are incorrect
    echo "Invalid email or password";
}

$stmt->close();
$conn->close();
?>
