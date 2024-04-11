<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rgstr_tbl";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$successMessage = "";


$recipeTitle = $_POST['recipe-title'];
$recipeCategory = $_POST['recipe-category'];
$recipeDescription = $_POST['recipe-description'];
$chefName = $_POST['chef-name'];

// File upload
$targetDir = "http://localhost/php/recipesjpg/";
$targetFile = $targetDir . basename($_FILES["recipe-image"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["recipe-image"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }
}

// Check file size
if ($_FILES["recipe-image"]["size"] > 50000000) {
    $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    $uploadOk = 0;
}

// Insert recipe data into database if upload is successful
if ($uploadOk == 1) {
    $sql = "INSERT INTO recipe_table (r_title, category, r_description, chef_name, r_image) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $recipeTitle, $recipeCategory, $recipeDescription, $chefName, $targetFile);
    if ($stmt->execute()) {
        $successMessage = "Recipe added successfully";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Added</title>
    <style>
        .success-message {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <?php if (!empty($successMessage)): ?>
        <div class="success-message"><?php echo $successMessage; ?></div>
    <?php endif; ?>
    <!-- Add your HTML content here -->
</body>
</html>
