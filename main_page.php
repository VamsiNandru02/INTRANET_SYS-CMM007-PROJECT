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

// Initialize an empty array to store recipes
$recipes = [];

// Fetch all recipe details from the database by default
$sql = "SELECT r_title AS title, chef_name AS chef, category, r_image AS image, r_id FROM recipe_table";
$result = $conn->query($sql);

// Store fetched data in the array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $recipes[] = $row;
    }
}

// Check if search criteria provided
if (isset($_GET['search'])) {
    $search = $_GET['search'];

    // Filter recipes by title, category, or chef name
    $filteredRecipes = array_filter($recipes, function($recipe) use ($search) {
        return strpos(strtolower($recipe['title']), strtolower($search)) !== false ||
               strpos(strtolower($recipe['category']), strtolower($search)) !== false ||
               strpos(strtolower($recipe['chef']), strtolower($search)) !== false;
    });
} else {
    // If no search criteria provided, display all recipes
    $filteredRecipes = $recipes;
}

// Close the database connection
//$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Main Page</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
  <div class="header">
    <div class="logo-container">
      <img class="logo" src="images/main_logo.jpg" alt="Logo">
      <h1>Welcome to Recipe Website</h1>
    </div>
    
    <div class="search-bar-container">
      <button class="add-recipe-button" onclick="redirectToRecipeForm()">Add Recipe</button>
      <form action="main_page.php" method="get">
        <input type="text" class="search-bar" name="search" placeholder="Search by Recipe Title, Category, or Chef...">
        <button type="submit">Search</button>
      </form>
      <button class="logout-button" onclick="logout()">Logout</button>
    </div>
  </div>
  
  <h2 class="quote">"Good food is the foundation of genuine happiness." - Auguste Escoffier</h2>

  <div class="recipes-container">
    <?php foreach ($filteredRecipes as $recipe): ?>
        <div class="recipe-item" data-title="<?php echo htmlspecialchars($recipe['title']); ?>"
    data-chef="<?php echo htmlspecialchars($recipe['chef']); ?>"
    data-category="<?php echo htmlspecialchars($recipe['category']); ?>"
    data-r-id="<?php echo htmlspecialchars($recipe['r_id']); ?>"
    onclick="viewRecipe('<?php echo $recipe['r_id']; ?>')">
    <img src="<?php echo htmlspecialchars($recipe['image']); ?>"
        alt="<?php echo htmlspecialchars($recipe['title']); ?>">
    <div class="recipe-title"><?php echo htmlspecialchars($recipe['title']); ?></div>
</div>

    <?php endforeach; ?>
  </div>

  <script>
    function logout() {
      // Redirect to logout page
      window.location.href = "logout.php";
    }

    function viewRecipe(recipeId) {
      // Redirect to recipe details page with the recipe ID
      window.location.href = "recipe_details.php?r_id=" + recipeId;
    }

    function redirectToRecipeForm() {
      // Redirect to add recipe form page
      <?php if (isset($_GET['role']) !== 'chef'): ?>
        // Redirect to add recipe form page if user is a chef
        alert("You need to be a chef to add recipes.");       
        <?php else: ?>
      window.location.href = "add_recipe.html";
      <?php endif; ?>
    }
  </script>
  
  <!-- Footer Section -->
  <footer>
    <div class="footer-content">
      <div class="contact-us">
        <h2>Contact Us</h2>
        <p>Email: recipe.com</p>
        <p>Phone: 07423077374</p>
        <address>470 George street, Aberdeen, AB25 3XH</address>
      </div>
    </div>
  </footer>
</body>
</html>
