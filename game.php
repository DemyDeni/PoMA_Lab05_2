<?php
session_start();
function deleteData()
{
  unset($_SESSION["maxNum"]);
  unset($_SESSION["drawNum"]);
  unset($_SESSION["guesses"]);
}
function setDefaultMaxNum()
{
  if (empty($_SESSION["maxNum"])) {
    $_SESSION["maxNum"] = 20; // set default max number if not specified
  }
}

$showCookies = false;
$timeShift = 15;

$backColor = "#ffffff";
$fontSize = 16;
$boxColor = "#ffffff";
if (!empty($_COOKIE["backColor"])) {
  $backColor = $_COOKIE["backColor"];
}
if (!empty($_COOKIE["fontSize"])) {
  $fontSize = $_COOKIE["fontSize"];
}
if (!empty($_COOKIE["boxColor"])) {
  $boxColor = $_COOKIE["boxColor"];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["maxNum"])) {
    setDefaultMaxNum();
  } else {
    deleteData();
    $_SESSION["maxNum"] = $_POST["maxNum"]; // set max number
  }

  if (!empty($_POST["drawNum"])) {
    setDefaultMaxNum();
    $_SESSION["drawNum"] = random_int(0, $_SESSION["maxNum"]); // save target number
  }

  if (!empty($_POST["guessNum"]) && !empty($_SESSION["drawNum"])) {
    $target = $_SESSION["drawNum"];
    $guess = $_POST["guessNum"];

    if (empty($_SESSION["guesses"])) { // set guesses if first time
      $arr = [];
      $_SESSION["guesses"] = $arr;
    }
    array_push($_SESSION["guesses"], $guess); // add current guess to history
  }

  if (!empty($_POST["deleteData"])) {
    deleteData();
  }

  if (!empty($_POST["deleteCookies"])) {
    $timeShift = -1;
    $backColor = "#ffffff";
    $fontSize = 16;
    $boxColor = "#ffffff";
  }

  if (!empty($_POST["decorate"])) {
    if (!empty($_POST["backColor"])) {
      $backColor = $_POST["backColor"];
    }
    if (!empty($_POST["fontSize"])) {
      $fontSize = $_POST["fontSize"];
    }
    if (!empty($_POST["boxColor"])) {
      $boxColor = $_POST["boxColor"];
    }
  }

  if (!empty($_POST["showCookies"])) {
    $showCookies = true;
  }
}

setcookie("backColor", $backColor, time() + $timeShift, "/");
setcookie("fontSize", $fontSize, time() + $timeShift, "/");
setcookie("boxColor", $boxColor, time() + $timeShift, "/");

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>The best website 8</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="WSP lab list 08" />
    <meta name="keywords" content="WSP-Lab: Laboratory 8, Lab 8 page main" />
    <style>
        body {
          background-color: <?= $backColor ?>;
          font-size: <?= $fontSize ?>px !important;
        }
        div {
          border-style: solid;
          border-color: <?= $boxColor ?>;
        }
    </style>
  </head>
  <body>
  <a href="../index.html">Main page</a> <br /><br />
    <div id="setMaxNumber">
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        Set maximum number: <input type="number" id="maxNum" name="maxNum" value="<?php
        if (empty($_SESSION["maxNum"])) {
          echo 20;
        } else {
          echo $_SESSION["maxNum"];
        } ?>">
        <button type="submit" id="submit">Set</button>
      </form>
      Current maximum number: <?php
      if (!empty($_SESSION["maxNum"])) {
        echo $_SESSION["maxNum"];
      } else {
        echo "not set. using 20";
      } ?>
    </div>
    <br />
    <div id="drawNumber">
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        Draw number <input type="hidden" id="drawNum" name="drawNum" value="1">
        <button type="submit" id="submit">Draw</button>
      </form><br>
      <?php
      if (!empty($_SESSION["drawNum"])) {
        echo "Number set! ";
      } else {
        echo "Number not set!";
      }
      ?>
    </div>
    <br />
    <div id="guessNumber">
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        Guess number: <input type="number" id="guessNum" name="guessNum">
        <button type="submit" id="submit" <?php if (empty($_SESSION["drawNum"])) { echo "disabled"; } ?>>Guess</button>
      </form>
      <div id="guessHistory">
        Guessing history:
        <?php
        if (!empty($_SESSION["guesses"]) && !empty($_SESSION["drawNum"])) {
          $guesses = $_SESSION["guesses"];
          $target = $_SESSION["drawNum"];
          ?> <table><tbody id = "history"><thead><td>Attempt</td><td>Value</td></thead> <?php
          $removeAll = false;
          for ($i=0; $i < count($guesses); $i++) { // go throw all guesses
            ?> <tr><td><?=$i + 1?></td><td> <?php
              if ($guesses[$i] > $target) {
                echo "$guesses[$i] - too large";
              } elseif ($guesses[$i] < $target) {
                echo "$guesses[$i] - too small";
              } else {
                echo "$guesses[$i] - guessed";
                $removeAll = true;
              }
            ?> </td></tr> <?php
          }
          if ($removeAll) { // remove all guesses and draw number
            deleteData();
          }
          ?> </tbody></table> <?php
        }
        ?>
      </div>
    </div>
    <br />
    <div id="deleteData">
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" id="deleteData" name="deleteData" value="1">
        <button type="submit" id="submit">Delete data</button>
      </form>
    </div>
    <br />
    <div id="decoratePage">
      Decorating page <br />
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        Background color: <input type="color" id="backColor" name="backColor" value="#996c8d"> <br />
        Font size: <input type="number" id="fontSize" name="fontSize" value="40"> <br />
        Boxes color: <input type="color" id="boxColor" name="boxColor" value="#000000"> <br />
        <input type="hidden" id="decorate" name="decorate" value="1">
        <button type="submit" id="submit">Decorate for 15 seconds</button>
      </form>
    </div>
    <br />
    <div id="deleteCookies">
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" id="deleteCookies" name="deleteCookies" value="1">
        <button type="submit" id="submit">Delete cookies</button>
      </form>
    </div>
    <br />
    <div id="showCookies">
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" id="showCookies" name="showCookies" value="1">
        <button type="submit" id="submit">Show cookies</button>
      </form>
      <div id="cookies">
        <?php
          if ($showCookies) {
            echo '<pre>Session variables:<br />' . print_r($_SESSION, true) . '</pre><br />';
            echo '<pre>Cookie variables:<br />' . print_r($_COOKIE, true) . '</pre>';
          }
        ?>
      </div>
    </div>
  </body>
</html>
