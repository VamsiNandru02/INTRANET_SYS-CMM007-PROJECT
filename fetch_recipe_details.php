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

// Fetch recipe details from the database
$sql = "SELECT r_title AS title, chef_name AS chef, category, r_image AS image FROM
 recipe_table";
$result = $conn->query($sql);

// Initialize variables to store fetched data
$titles = [];
$chefs = [];
$categories = [];
$images = [];
$urls = [];

// Store fetched data in separate variables
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $titles[] = $row['title'];
        $chefs[] = $row['chef'];
        $categories[] = $row['category'];
        $images[] = $row['image'];
        $urls[] = $row['url'];
    }
}

// Close the database connection
$conn->close();

// Prepare the data as an associative array
$data = [
    'titles' => $titles,
    'chefs' => $chefs,
    'categories' => $categories,
    'images' => $images,
    'urls' => $urls
];

// Send the fetched data as JSON response
header('Content-Type: application/json');
echo json_encode($data);
?>
