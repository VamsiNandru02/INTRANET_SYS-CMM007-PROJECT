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

// Fetch recipe details based on the provided r_id
if(isset($_GET['r_id'])) {
    $r_id = $_GET['r_id'];
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

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Details</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #47865e;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-container {
            display: flex;
            align-items: center;
        }

        .logo {
            max-width: 90px;
            margin-right: 20px;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            color: #fff;;
        }

        p {
            text-align: center;
            color: #fff;
        }

        img {
            display: block;
            margin: 0 auto;
            width: 100px;
            height: 120px;
            object-fit: cover;
            border-radius: 5px;
            margin-top: 20px;
        }

        button {
            margin: 10px;
            padding: 8px 16px;
            background-color: #47865e;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-container">
            <img class="logo" src="images/main_logo.jpg" alt="Logo">
        </div>
    </div>
    <h1><?php echo htmlspecialchars($recipe['title']); ?></h1>
    <p><strong>Category:</strong> <?php echo htmlspecialchars($recipe['category']); ?></p>
    <p><strong>Chef Name:</strong> <?php echo htmlspecialchars($recipe['chef']); ?></p>
    <p><strong>How To Make Recipe:</strong><br><?php echo htmlspecialchars($recipe['description']); ?></p>
    <img src="<?php echo htmlspecialchars($recipe['image']); ?>" alt="<?php echo htmlspecialchars($recipe['title']); ?>">
    <div>
        <button onclick="updateRecipe(<?php echo $r_id; ?>)">Update Recipe</button>
        <button onclick="deleteRecipe(<?php echo $r_id; ?>)">Delete Recipe</button>
    </div>

    <script>
        function updateRecipe(r_id) {
            // Redirect to update recipe page with recipe ID as a query parameter
            window.location.href = "update_recipe.php?r_id=" + r_id;
        }

        function deleteRecipe(r_id) {
            // Send AJAX request to delete recipe and then redirect to main page
            if(confirm("Are you sure you want to delete this recipe?")) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // Redirect to main page after successful deletion
                        window.location.href = "main_page.php";
                    }
                };
                xhr.open("GET", "delete_recipe.php?r_id=" + r_id, true);
                xhr.send();
            }
        }
    </script>
</body>
</html>
