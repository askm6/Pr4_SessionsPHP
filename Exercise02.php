<!DOCTYPE html>
<html>

<body>

  <?php
  session_start();
  if (!isset($_SESSION["array"]) || empty($_SESSION["array"])) {
    for ($i = 0; $i < 3; $i++) {
      $_SESSION["array"][$i] = $i * 10 + 10;
    }
  }
  ?>
  <form method="post" enctype="multipart/form-data">
    <legend>
      <h1>Modify array saved in session</h1>
    </legend>

    <label for="position">Position to modify: </label>
    <select name="position" id="position"
      style="background: none; border: 1px solid rgb(148, 148, 148); border-radius: 4px;">
      <option value="" selected hidden></option>
      <?php foreach ($_SESSION["array"] as $key => $value) { ?>
        <option value="<?php echo $key; ?>"><?php echo $key; ?></option>';
      <?php } ?>
    </select>
    <br><br>

    <label for="value">New value: </label>
    <input type="number" name="value" id="value" min="1">
    <br><br>

    <button type="submit" name="modify" required>Modify</button>
    <button type="submit" name="average" required>Average</button>
    <button type="reset" name="reset">Reset</button>
    <br><br>

  </form>
  <?php
  if (isset($_POST["modify"]) && ($_SERVER["REQUEST_METHOD"] == "POST")) {
    if (empty($_POST["value"])) {
      $_SESSION["array"][$_POST["position"]] = 0;
    } else {
      $_SESSION["array"][$_POST["position"]] = $_POST["value"];
    }

  }
  echo "Current array: ";
  foreach ($_SESSION["array"] as $key => $value) {
    echo $value;
    if ($key < (count($_SESSION["array"]) - 1)) {
      echo ", ";
    } else {
      echo "<br><br>";
    }
  }
  if (isset($_POST["average"]) && ($_SERVER["REQUEST_METHOD"] == "POST")) {
    $average = 0;
    foreach ($_SESSION["array"] as $value) {
      $average += $value;
    }
    $average /= count($_SESSION["array"]);
    echo "Average: " . round($average, 2);
  }
  ?>

</body>

</html>