<?php
require_once "db.php";
session_start();
$message="";
$user_id = $_SESSION["user_id"];
$user_fullName = $_SESSION["user_name"];
 if(!isset($user_id)){
    header("Location: login.php");
 }

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $card_number =$_POST["card_number"]; 
    $card_holder = $_POST["card_holder"];
    $card_type = $_POST["card_type"];
    $expiry_month = $_POST["expiry_month"];
    $expiry_year = $_POST["expiry_year"];
    $cleanCardNumber = str_replace(' ', '', $card_number);
    $last_four = substr($cleanCardNumber, -4);
    $checkCard = $db->prepare("SELECT card_number FROM cards WHERE card_number = ? ");
    $checkCard->execute([$cleanCardNumber]);
    $check_card = $checkCard->fetch(PDO::FETCH_ASSOC);

    if(empty($check_card["card_number"])){
        $addCard = $db->prepare("INSERT INTO cards (user_id	,card_number,last_four,card_type,card_holder,expiry_month,expiry_year) VALUES (?,?,?,?,?,?,?)");
        $addCard->execute([$user_id,$cleanCardNumber,$last_four ,$card_type,$card_holder,$expiry_month,$expiry_year ]);
        header("Location: profile.php");
    }else{
        $message = "⚠️ This card already existe";
    }
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="/images/icoProfile.png"> 
  <title>Add New Card</title>

  <!-- Google Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Inter', sans-serif;
    }

    body {
      min-height: 100vh;
      background: linear-gradient(135deg, #f9fafb, #eef2ff);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* ===== FORM CARD ===== */
    .add-card-form {
      width: 100%;
      max-width: 420px;
      background: white;
      padding: 32px;
      border-radius: 18px;
      box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    }

    .add-card-form h2 {
      font-size: 22px;
      margin-bottom: 24px;
      text-align: center;
      font-weight: 700;
      color: #111827;
    }

    .form-group {
      display: flex;
      flex-direction: column;
      margin-bottom: 16px;
    }

    .form-group label {
      font-size: 13px;
      margin-bottom: 6px;
      color: #374151;
      font-weight: 500;
    }

    .form-group input,
    .form-group select {
      padding: 12px 14px;
      border-radius: 12px;
      border: 1px solid #d1d5db;
      outline: none;
      font-size: 14px;
      transition: border 0.2s;
    }

    .form-group input::placeholder {
      color: #9ca3af;
    }

    .form-group input:focus,
    .form-group select:focus {
      border-color: #6366f1;
    }

    .form-row {
      display: flex;
      gap: 12px;
    }

    /* SUBMIT BUTTON */
    .btn-submit {
      width: 100%;
      margin-top: 20px;
      padding: 14px;
      border: none;
      border-radius: 14px;
      background: linear-gradient(135deg, #6366f1, #4f46e5);
      color: white;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
      transition: transform 0.15s, box-shadow 0.15s;
    }

    .btn-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(79,70,229,0.35);
    }

    /* SMALL NOTE */
    .note {
      margin-top: 16px;
      font-size: 12px;
      color: #6b7280;
      text-align: center;
    }

    .mssg{
        position: absolute;
        top: 10px;
        left:50px;
        
        background: #000000e3;
        width: 450px;
        height: 100px;
        border-radius:5px;
        color:white;
        display: flex;
        align-items: center;
        padding: 10px;
        padding-left: 20px;
        opacity: 0;
 animation: showHide 4s ease forwards;
}

@keyframes showHide {
  0% {
    opacity: 0;
    transform: translateY(-8px);
  }
  10% {
    opacity: 1;
    transform: translateY(0);
  }
  80% {
    opacity: 1;
    transform: translateY(0);
  }
  100% {
    opacity: 0;
    transform: translateY(-8px);
  }
}
  </style>
</head>
<body>

<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
    echo "
    <div class='mssg'>
        <p><?= $message ?></p>
    </div>
    
    ";
}
?>


  <form class="add-card-form" action="card.php" method="POST">

    <h2>Add New Card</h2>

    <!-- Card Number -->
    <div class="form-group">
      <label>Card Number</label>
      <input 
        type="text" 
        name="card_number"
        placeholder="1234 5678 9012 3456"
        maxlength="16"
        minlength="16"
        required
      >
    </div>

    <!-- Card Holder -->
    <div class="form-group">
      <label>Card Holder</label>
      <input 
        type="text" 
        value=<?= $user_fullName ?>
        name="card_holder"
        placeholder="FULL NAME"
        required
      >
    </div>

    <!-- Card Type -->
    <div class="form-group">
      <label>Card Type</label>
      <select name="card_type" required>
        <option value="">Select card type</option>
        <option value="VISA">VISA</option>
        <option value="MASTERCARD">MASTERCARD</option>
      </select>
    </div>

    <!-- Expiry -->
    <div class="form-row">
      <div class="form-group">
        <label>Expiry Month</label>
        <input 
          type="number" 
          name="expiry_month"
          min="1" 
          max="12" 
          placeholder="MM"
          required
        >
      </div>

      <div class="form-group">
        <label>Expiry Year</label>
        <input 
          type="number" 
          name="expiry_year"

          min="24" 
          max="100" 
          placeholder="YYYY"
          required
        >
      </div>
    </div>

    <button type="submit" class="btn-submit">
      Add Card
    </button>

    <p class="note">
      Your card information is securely handled.
    </p>

  </form>

</body>
</html>
