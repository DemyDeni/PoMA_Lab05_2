<?php
$create_out = '';
$delete_out = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (!empty($_POST["create"])) {
    try {
      $conn = new PDO("mysql:host=localhost", "root", "admin");
      $sql = "CREATE DATABASE lab09";
      $conn->exec($sql);
      $sql = "USE lab09; CREATE TABLE articles (
        id int auto_increment primary key,
        name varchar(255),
        category varchar(255),
        price float
        );";
      $conn->exec($sql);
      $create_out = "Database and table has been created";
    } catch (PDOException $e) {
      $create_out = "Create error: " . $e->getMessage();
    }
  }
  if (!empty($_POST["delete"])) {
    try {
      $conn = new PDO("mysql:host=localhost", "root", "admin");
      $sql = "DROP DATABASE lab09";
      $conn->exec($sql);
      $delete_out = "Database has been deleted";
    } catch (PDOException $e) {
      $delete_out = "Delete error: " . $e->getMessage();
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
    <input type="hidden" id="decorate" name="create" value="1">
    <button type="submit" id="submit">Create tables</button>
  </form><br>
  <?= $create_out ?><br>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <input type="hidden" id="decorate" name="delete" value="1">
    <button type="submit" id="submit">Delete tables</button>
  </form><br>
  <?= $delete_out ?>
</body>

</html>
