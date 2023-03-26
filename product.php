<?php
include 'db.php';


// Retrieve products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

// Initialize variables
$product_url = $name = $image_url = $price = "";
$message = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["product_url"])) {
  $product_url = $_POST["product_url"];
  
  // Scrape the Amazon product page
  $dom = new DOMDocument();
  @$dom->loadHTMLFile($product_url);
  

// Extract the necessary data
$name_element = $dom->getElementById('productTitle');
$image_element = $dom->getElementById('landingImage');

if ($name_element !== null) {
  $name = $name_element->textContent;
}

if ($image_element !== null) {
  $image_url = $image_element->getAttribute('src');
}

$found_price = false;
$prices = $dom->getElementsByTagName('span');
foreach ($prices as $price_tag) {
  if ($price_tag->getAttribute('id') == 'tp_price_block_total_price_ww') {
    $price = $price_tag->getElementsByTagName('span')[0]->textContent;
    $found_price = true;
    break;
  }
}

// If a price was not found, set it to 0
if (!$found_price) {
  $price = 0;
}

// Clean up the extracted data
$name = trim($name);
$price = str_replace(',', '.', str_replace(' €', '', $price));
$price = number_format((float)$price, 2, '.', '');


  // Check if the price is not empty
  if (!empty($price)) {
    // Add the scraped data to the database
    $sql = "INSERT INTO products (name, image_url, price) VALUES ('$name', '$image_url', '$price')";
  } else {
    // Set the price to 0
    $price = 0;
    // Add the scraped data to the database
    $sql = "INSERT INTO products (name, image_url, price) VALUES ('$name', '$image_url', '$price')";
    $message .= "Warning: Price was empty, set to 0";
  }
  
  if ($conn->query($sql) === TRUE) {
    $message .= "Product added to database successfully!";
  } else {
    $message .= "Error adding product to database: " . $conn->error;
  }
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Product Page</title>
<link rel="stylesheet" href="assets/style/product.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<h1>Product Page</h1>
<nav>
<a href="index.php">Home</a>
<a href="product.php">Product</a>
</nav>

<h2>Add a new product</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
<label for="product_url">Product URL:</label>
<input type="text" name="product_url" id="product_url" required>
<input type="submit" value="Add Product">
</form>
<!-- Display a message to indicate if the product was added to the database or not -->
<?php if (!empty($message)): ?>
  <p><?php echo $message; ?></p>
  <?php endif; ?>
  
  <h2>Products</h2>
  
  <?php
  // Loop through the products and display their information
  while ($row = $result->fetch_assoc()) {
    echo '<div>';
    echo '<img src="' . $row['image_url'] . '" alt="' . $row['name'] . '">';
    echo '<h3>' . $row['name'] . '</h3>';
    echo '<p><strong>Price:</strong> ' . $row['price'] . '</p>';
    echo '</div>';
  }
  ?>
  
  
  </body>
  </html>
  