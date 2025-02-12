<!DOCTYPE html>
<html>

<body>

  <?php

  $inventory = ["soft drink", "milk"];

  session_start();
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $error = false;
    if (!empty($_POST['name'])) {
      $_SESSION["name"] = $_POST["name"];
    }
    if (!isset($_SESSION["inventory"]) || empty($_SESSION["inventory"])) {
      foreach ($inventory as $product) {
        $_SESSION["inventory"][$product] = 0;
      }
    }
    if (isset($_POST["add"]) && !empty($_POST["quantity"])) {
      $_SESSION["inventory"][$_POST["product"]] += $_POST["quantity"];
    } elseif (isset($_POST["remove"]) && ($_SESSION["inventory"][$_POST["product"]] - $_POST["quantity"]) >= 0 && !empty($_POST["quantity"])) {
      $_SESSION["inventory"][$_POST["product"]] -= $_POST["quantity"];
    } else {
      $error = true;
    }
  }
  ?>
  <form method="post" enctype="multipart/form-data">
    <legend>
      <h1>Supermarket management</h1>
    </legend>

    <label for="name">Worker name:</label>
    <input type="text" name="name" id="name" <?php if (!empty($_SESSION["name"])) {
      echo 'placeholder="' . $_SESSION["name"] . '"';
    } else {
      echo 'required';
    } ?>>
    <br><br>

    <label for="product">
      <h2>Choose product: </h2>
    </label>
    <select name="product" id="product" style="background: none; 
                                        border: 1px solid rgb(148, 148, 148); 
                                        border-radius: 4px;" required>
      <option value="" selected hidden></option>
      <?php foreach ($inventory as $product) { ?>
        <option value="<?php echo $product; ?>"><?php echo ucwords($product); ?></option>';
      <?php } ?>
    </select>
    <br>

    <label for="quantity">
      <h2>Product quantity:</h2>
    </label>
    <input type="number" name="quantity" id="quantity" min="1">
    <br><br>

    <button type="submit" name="add" required>add</button>
    <button type="submit" name="remove" required>remove</button>
    <button type="reset" name="reset">reset</button>

  </form>
  <?php
  if (($_SERVER["REQUEST_METHOD"] == "POST")) {
    echo "<h2>Inventory: </h2>";
    echo "Worker: " . htmlspecialchars($_SESSION["name"]) . "<br><br>";
    foreach ($_SESSION["inventory"] as $key => $value) {
      echo "units " . $key . ": " . htmlspecialchars($value) . "<br><br>";
    }
  }
  if ((isset($_POST["remove"])) && ($error == true)) {
    echo "Error: trataste de quitar mas productos de los posibles";
  }
  ?>

</body>

</html>