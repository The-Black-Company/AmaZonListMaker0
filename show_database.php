<!DOCTYPE html>
<html>
<head>
  <title>All Products</title>
<link rel="stylesheet" href="assets/style/show_db.css">
</head>
<body>
  <h1>All Products</h1>
  <?php
  include 'db.php';

  // Select all rows from the 'products' table
  $sql = "SELECT * FROM products";
  $result = $conn->query($sql);

  // If there are rows, display them in a table
  if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Name</th><th>Image URL</th><th>Price</th></tr>";
    while ($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td>" . $row["name"] . "</td>";
      echo "<td>" . $row["image_url"] . "</td>";
      echo "<td>" . $row["price"] . "</td>";
      echo "</tr>";
    }
    echo "</table>";
  } else {
    echo "No products found.";
  }

  $conn->close();
  ?>
</body>
</html>
