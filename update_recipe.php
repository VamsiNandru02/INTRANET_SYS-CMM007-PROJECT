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
    
    // Fetch existing recipe details
    $sql = "SELECT r_title AS title, chef_name AS chef, category, r_image AS image, r_description as description FROM recipe_table WHERE r_id = $r_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $recipe = $result->fetch_assoc();
    } else {
        echo "Recipe not found";
        exit;
    }
} else {
    echo "Recipe ID not provided";
    exit;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get updated recipe details from the form
    $title = $_POST['title'];
    $chef = $_POST['chef'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    // Update recipe details in the database
    $sql = "UPDATE recipe_table SET r_title='$title', chef_name='$chef', category='$category', r_description='$description' WHERE r_id=$r_id";

    if ($conn->query($sql) === TRUE) {
        // Recipe details updated successfully
        // Redirect to another page
        header("Location: recipe_details.php");
        exit;
    } else {
        echo "Error updating recipe details: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Recipe</title>
    <link rel="stylesheet" type="text/css" href="update.css">
</head>
<body>
    <h2>Update Recipe Details</h2>
    <form method="post">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($recipe['title']); ?>"><br>
        
        <label for="chef">Chef:</label><br>
        <input type="text" id="chef" name="chef" value="<?php echo htmlspecialchars($recipe['chef']); ?>"><br>
        
        <label for="category">Category:</label><br>
        <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($recipe['category']); ?>"><br>
        
        <label for="description">Description:</label><br>
        <textarea id="description" name="description"><?php echo htmlspecialchars($recipe['description']); ?></textarea><br>
        
        <input type="submit" value="Update Recipe">
    </form>
</body>
</html>
