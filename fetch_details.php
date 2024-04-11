<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Main Page</title>
  <style>
    /* Your existing CSS styles */
  </style>
</head>
<body>
  <div class="header">
    <div class="logo-container">
      <img class="logo" src="images/main_logo.jpg" alt="Logo">
      <h1>Welcome to Recipe Website</h1>
    </div>
    
    <div class="search-bar-container">
      <button class="add-recipe-button" onclick="redirectToRecipeForm()">Add Recipe</button>
      <input type="text" class="search-bar" id="title-filter" placeholder="Search by Recipe Title...">      
      <input type="text" class="search-bar" id="chef-filter" placeholder="Search by Chef...">
      <input type="text" class="search-bar" id="category-filter" placeholder="Search by Category...">
      <button class="logout-button" onclick="logout()">Logout</button>
    </div>
  </div>
  
  <h2 class="quote">"Good food is the foundation of genuine happiness." - Auguste Escoffier</h2>

  <div class="recipes-container">
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
    $sql = "SELECT r_title AS title, chef_name AS chef, category, r_image AS image, r_url AS url FROM recipe_table";
    $result = $conn->query($sql);

    // Generate HTML for each recipe item
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="recipe-item" data-title="' . $row['title'] . '" data-chef="' . $row['chef'] . '" data-category="' . $row['category'] . '" onclick="viewRecipe(\'' . $row['url'] . '\')">';
            echo '<img src="' . $row['image'] . '" alt="' . $row['title'] . '">';
            echo '</div>';
        }
    }

    // Close the database connection
    $conn->close();
    ?>
  </div>

  <script>
    function logout() {
      // Redirect to logout page
      window.location.href = "logout.php";
    }

    function viewRecipe(url) {
      // Open the recipe page
      window.open(url, "_blank");
    }

    function redirectToRecipeForm() {
      // Redirect to add recipe form page
      window.location.href = "add_recipe.html";
    }
  </script>
  
  <!-- Footer Section -->
  <footer>
    <div class="footer-content">
      <div class="contact-us">
        <h2>Contact Us</h2>
        <p>Email: recipe.com</p>
        <p>Phone: 07423077374</p>
        <address>470 George street, Aberdeen, AB25 3XH
      </div>
    </div>
  </footer>
</body>
</html>
