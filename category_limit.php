<?php

require_once "db.php";
session_start();
$userID =  $_SESSION["user_id"] ;

if (!isset($userID)) {
    header("Location: login.php");
    exit;
}

$getcat = $db->query("SELECT * FROM categories");
$categories = $getcat->fetchAll(PDO::FETCH_ASSOC);

if($_SERVER["REQUEST_METHOD"] == "POST"){

  $category = $_POST['category_id'];
  $monthly_limit = $_POST['limit_amount'];
  $month = $_POST['month'];
  $year = $_POST['year'];


  $stmtLimit = $db->prepare("INSERT INTO category_limits (user_id,category_id,month,year,limit_amount)VALUES(?,?,?,?,?)");
  $stmtLimit->execute([$userID,$category,$month,$year,$monthly_limit]);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="/images/icoProfile.png"> 
    <link rel="stylesheet" href="style/main.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>category limit form</title>
</head>
<body>

<!-- category limit -->
<section class="section_category_limit">
<form class="limit-form" action="category_limit.php" method="POST">

  <h3>Set Monthly Limit</h3>

  <!-- Category -->
  <div class="form-group">
    <div class="close">
      <a style="text-decoration: none;" href="expenses.php">
          ×
        </a>
    </div>
    <label>Category</label>
    <select name="category_id" required>
      <option value="">Select category</option>
      <?php forEach($categories as $cat) { ?>
      <option value=<?= $cat['id'] ?> ><?= $cat['icon'] ?> <?= $cat['name'] ?></option>
      <?php } ?>

    </select>
  </div>

  <!-- Limit Amount -->
  <div class="form-group">
    <label>Monthly Limit (DH)</label>
    <input
      type="number"
      name="limit_amount"
      placeholder="1500"
      min="1"
      step="0.01"
      required
    >
  </div>

  <!-- Month -->
  <div class="form-group">
    <label>Month</label>
    <select name="month" required>
      <option value="">Select month</option>
      <option value="1">January</option>
      <option value="2">February</option>
      <option value="3">March</option>
      <option value="4">April</option>
      <option value="5">May</option>
      <option value="6">June</option>
      <option value="7">July</option>
      <option value="8">August</option>
      <option value="9">September</option>
      <option value="10">October</option>
      <option value="11">November</option>
      <option value="12">December</option>
    </select>
  </div>

  <!-- Year -->
  <div class="form-group">
    <label>Year</label>
    <input
      type="number"
      name="year"
      placeholder="2025"
      min="2020"
      required
    >
  </div>

  <button type="submit">Save Limit</button>

</form>
      </section>

</body>
</html>