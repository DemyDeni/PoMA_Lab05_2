<?php
$add_out = '';
$add_many_out = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (!empty($_POST["add"])) {
    try {
      $conn = new PDO("mysql:host=localhost;dbname=lab09", "root", "admin");
      $name = $_POST["name"];
      $category = $_POST["category"];
      $price = $_POST["price"];
      $sql = "INSERT INTO articles (name,category,price) VALUES ('$name', '$category', $price);";
      $conn->exec($sql);
      $add_out = "Entry added";
    } catch (PDOException $e) {
      $add_out .= "Add error: " . $e->getMessage();
    }
  }
  if (!empty($_POST["add_many"])) {
    $names = array('John', 'Mary', 'Robert', 'James', 'Michael', 'David', 'William', 'Richard', 'Joseph', 'Thomas');
    $categories = array('food', 'sport', 'electronics');
    try {
      $conn = new PDO("mysql:host=localhost;dbname=lab09", "root", "admin");
      $sql = "INSERT INTO articles (name,category,price) VALUES";
      $num = $_POST["add_many_num"];
      for ($i = 0; $i < $num - 1; $i++) {
        $name = $names[array_rand($names, 1)];
        $category = $categories[array_rand($categories, 1)];
        $price = random_int(1, 100) / 1.3;
        $sql .= "('$name', '$category', $price),";
      }
      $name = $names[array_rand($names, 1)];
      $category = $categories[array_rand($categories, 1)];
      $price = random_int(1, 100) / 1.3;
      $sql .= "('$name', '$category', $price);";

      $conn->exec($sql);
      $add_many_out = "Added $num entries";
    } catch (PDOException $e) {
      $add_many_out = "Add many error: " . $e->getMessage();
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>The best website 9</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="description" content="WSP lab list 09" />
  <meta name="keywords" content="WSP-Lab: Laboratory 9, Lab 9 page form" />
</head>

<body>
  <nav>
    <a href="./index.html">Main page</a>
    <a href="./create.php">Create</a>
    <a href="./add.php">Add</a>
    <a href="./show.php">Show</a>
    <a href="./show3.php">Show 3</a>
  </nav>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    Name: <input type="text" name="name" value="John"><br>
    Category: <input type="text" name="category" value="food"><br>
    Price: <input type="number" name="price" value="10.0"><br>
    <input type="hidden" name="add" value="1">
    <button type="submit">Add entry to table</button>
  </form><br>
  <?= $add_out ?><br>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    Number: <input type="number" name="add_many_num" value="20"><br>
    <input type="hidden" name="add_many" value="1">
    <button type="submit">Add many entries to table</button>
  </form><br>
  <?= $add_many_out ?>
</body>

</html>
