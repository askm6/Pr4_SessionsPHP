<!DOCTYPE html>
<html>

<head>
  <title>Shopping list</title>
  <style>
    table,
    th,
    td {
      border: 1px solid black;
      border-collapse: collapse;
    }

    th,
    td {
      padding: 5px;
    }

    input[type=submit] {
      margin-top: 10px;
    }
  </style>
</head>

<body>
  <?php
  session_start();
  $totalValue = 0;
  $message = "";
  $error = "";
  if (!isset($_SESSION['list'])) {
    $_SESSION['list'] = [];
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
      $alreadyExist = false;
      foreach ($_SESSION['list'] as $index => $item) {
        if ($item['name'] == $_POST['name']) {
          $alreadyExist = true;
        }
      }
      if ($alreadyExist) {
        $error = "Item already exist";
      } else {
        $_SESSION['list'][] = ['name' => $_POST['name'], 'quantity' => $_POST['quantity'], 'price' => $_POST['price']];
        $message = "Item added properly.";
      }
    }

    if (isset($_POST['delete'])) {
      unset($_SESSION['list'][$_POST['index']]);
      $_SESSION['list'] = array_values($_SESSION['list']);
      $message = "Item deleted properly.";
    }

    if (isset($_POST['edit'])) {
      $index = $_POST['index'];
      $name = $_SESSION['list'][$index]['name'];
      $quantity = $_SESSION['list'][$index]['quantity'];
      $price = $_SESSION['list'][$index]['price'];
      $message = "Item selected properly.";
    }

    if (isset($_POST['update'])) {
      $alreadyExist = false;
      foreach ($_SESSION['list'] as $index => $item) {
        if ($item['name'] == $_POST['name']) {
          $alreadyExist = true;
        }
      }
      if ($alreadyExist) {
        $error = "Item already exist";
      } else {
        $_SESSION['list'][$_POST['index']] = ['name' => $_POST['name'], 'quantity' => $_POST['quantity'], 'price' => $_POST['price']];
        $message = "Item updated properly.";
      }
    }

    if (isset($_POST['total']) && !empty($_SESSION['list'])) {
      foreach ($_SESSION['list'] as $index => $item) {
        $totalValue += $item['quantity'] * $item['price'];
      }
    }
  }
  ?>
  <form method="post">
    <legend>
      <h1>Shopping list</h1>
    </legend>
    <label for="name">name:</label>
    <input type="text" name="name" id="name" value="<?php if (isset($name) && !empty($name)) {
      echo $name;
    } ?>">
    <br>

    <label for="quantity">quantity:</label>
    <input type="number" name="quantity" id="quantity" value="<?php if (isset($quantity) && !empty($quantity)) {
      echo $quantity;
    } ?>" required>
    <br>

    <label for="price">price:</label>
    <input type="number" name="price" id="price" min="0" value="<?php if (isset($price) && !empty($price)) {
      echo $price;
    } ?>" required>
    <br>

    <input type="hidden" name="index" value="<?php echo $index; ?>">
    <input type="submit" name="add" value="Add" required>
    <?php if (isset($index)) { ?>
      <input type="submit" name="update" value="Update" required> <?php } ?>
    <input type="submit" name="reset" value="Reset">
  </form>
  <p style="color:red;"><?php echo $error; ?></p>
  <p style="color:green;"><?php echo $message; ?></p>
  <?php if (isset($_SESSION['list']) && !empty($_SESSION['list'])) { ?>
    <table>
      <thead>
        <tr>
          <th>name</th>
          <th>quantity</th>
          <th>price</th>
          <th>cost</th>
          <th>actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($_SESSION['list'] as $index => $item) { ?>
          <tr>
            <td><?php echo $item['name']; ?></td>
            <td><?php echo $item['quantity']; ?></td>
            <td><?php echo $item['price']; ?></td>
            <td><?php echo $item['quantity'] * $item['price']; ?></td>
            <td>
              <form method="post">
                <input type="hidden" name="name" value="<?php echo $item['name']; ?>">
                <input type="hidden" name="quantity" value="<?php echo $item['quantity']; ?>">
                <input type="hidden" name="price" value="<?php echo $item['price']; ?>">
                <input type="hidden" name="index" value="<?php echo $index; ?>">
                <input type="submit" name="edit" value="Edit">
                <input type="submit" name="delete" value="Delete">
              </form>
            </td>
          </tr>
        <?php } ?>
        <tr>
          <td colspan="3" align="right"><strong>Total:</strong></td>
          <td><?php echo $totalValue; ?></td>
          <td>
            <form method="post">
              <input type="submit" name="total" value="Calculate total">
            </form>
          </td>
        </tr>
      </tbody>
    </table>
  <?php } ?>
</body>