<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rgstr_tbl";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form data
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$mobile = $_POST['mobile'];
$role = $_POST['role'];

// Insert data into database
$sql = "INSERT INTO rgstr (name, mail_id, pass_code, mobile_num, role)
        VALUES ('$name', '$email', '$password', '$mobile', '$role')";

if ($conn->query($sql) === TRUE) {
    header("http://localhost/php/success_page.html");
    echo "Registartion is Successfull";
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
