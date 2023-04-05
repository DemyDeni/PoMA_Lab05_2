<?php
$remove_out = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (!empty($_POST["remove"])) {
    try {
      $conn = new PDO("mysql:host=localhost;dbname=lab09", "root", "admin");
      $id = $_POST["remove"];
      $sql = "DELETE FROM articles WHERE id = $id";
      $conn->exec($sql);
      $remove_out = "Entry removed";
    } catch (PDOException $e) {
      $remove_out .= "Removing error: " . $e->getMessage();
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
  <table>
    <tbody>
      <thead>
        <td>Name</td>
        <td>Category</td>
        <td>Price</td>
        <td>Remove</td>
      </thead>
      <?php
      try {
        $conn = new PDO("mysql:host=localhost;dbname=lab09", "root", "admin");
        $sql = "SELECT * FROM articles";
        $result = $conn->query($sql);
        while ($row = $result->fetch()) {
          echo "<tr>";
          echo "<td>" . $row["name"] . "</td>";
          echo "<td>" . $row["category"] . "</td>";
          echo "<td>" . $row["price"] . "</td>";
          echo "<td>";
      ?><form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="remove" value="<?= $row["id"] ?>">
        <button type="submit">Remove</button>
      </form><?php
          echo "</td>";
          echo "</tr>";
        }
      } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
      }
            ?>
    </tbody>
  </table><br>
  <?= $remove_out ?>
</body>

</html>
