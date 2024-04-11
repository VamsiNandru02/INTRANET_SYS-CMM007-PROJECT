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

// Check if recipe ID is provided
if(isset($_GET['r_id'])) {
    $r_id = $_GET['r_id'];
    
    // Prepare SQL statement to delete the recipe
    $sql = "DELETE FROM recipe_table WHERE r_id = $r_id";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "Recipe deleted successfully";
    } else {
        echo "Error deleting recipe: " . $conn->error;
    }
} else {
    echo "Recipe ID not provided";
}

// Close the database connection
$conn->close();
?>
