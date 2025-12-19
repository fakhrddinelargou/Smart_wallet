<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require_once "db.php";

session_start();
$message="";

if(!isset($_SESSION["user_id"]) || !isset($_SESSION["email_token"])){
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $code = $_POST["otp"];
     echo $code;
  if(!ctype_digit($code) || strlen($code) !== 6){
    $message="Invalid OTP";
  }else{
    
    $email_token = $_SESSION["email_token"];
    $email_token_expire = $_SESSION["email_token_expire"];
    
    if(time() > $email_token_expire){
      $message = "Code is dead";
    }elseif($code == $email_token){
      
      $userId = $_SESSION["user_id"];
      $newIp = $_SERVER["REMOTE_ADDR"];

      $checkIp = $db->prepare("SELECT id FROM user_ips WHERE user_id = ? AND ip_address = ?");
      $checkIp->execute([$userId,$newIp]); 
      $userIp = $checkIp->fetch(PDO::FETCH_ASSOC);

    if(!$userIp){

      $checkEmail = $db->prepare("SELECT email FROM registers WHERE id = ?");
      $checkEmail->execute([$userId]);
      $emailRow = $checkEmail->fetch(PDO::FETCH_ASSOC);
      $email = $emailRow['email'];

      $addUserIp = $db->prepare("INSERT INTO user_ips (user_id,ip_address) VALUES (?,?)");
      $addUserIp->execute([$_SESSION["user_id"],$newIp]);
      
      $mail = new PHPMailer(true);

      try{

        $mail->isSMTP(); 
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true; 
        $mail->Username = getenv('EMAIL'); 
        $mail->Password = getenv('APP_PASSWORD'); 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port = 587;
         $mail->setFrom(getenv('EMAIL'), 'Smart Wallet');
        $mail->addAddress($email);
        $mail->Subject = 'Verify your email';
        $mail->Body = "Your account was accessed from a new location.\n\nIP Address: {$newIp}";
        $mail->send();

      }catch(Exception $e){
        echo "Error" . $e->getMessage();
      }
    }

      unset($_SESSION["email_token"] , $_SESSION["email_token_expire"]);
      header("Location: Incomes.php");
      exit;
    
  }else{
      $message= "code is incorrect";
  }
}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Email Verification</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="/images/icoProfile.png"> 

  <style>
    *{
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }
    body{
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #f4f6f8;
    }
    .otp-box{
      width: 100%;
      max-width: 380px;
      background: #fff;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
      text-align: center;
    }
    .otp-box h2{
      margin-bottom: 10px;
      color: #333;
    }
    .otp-box p{
      font-size: 14px;
      color: #666;
      margin-bottom: 20px;
    }
    .otp-inputs{
      display: flex;
      justify-content: space-between;
      gap: 10px;
      margin-bottom: 20px;
    }
    .otp-inputs input{
      width: 100%;
      height: 55px;
      text-align: center;
      font-size: 20px;
      border: 1px solid #ddd;
      border-radius: 8px;
      outline: none;
    }
    .otp-inputs input:focus{
      border-color: #4f46e5;
    }
    button{
      width: 100%;
      padding: 14px;
      border: none;
      border-radius: 8px;
      background: #4f46e5;
      color: #fff;
      font-size: 16px;
      cursor: pointer;
    }
    button:hover{
      background: #4338ca;
    }
    .resend{
      margin-top: 15px;
      font-size: 13px;
    }
    .resend a{
      color: #4f46e5;
      text-decoration: none;
    }

    .alert {
  width: 100%;
  max-width: 420px;
  padding: 16px 18px;
  margin: 20px auto;
  border-radius: 12px;
  background: #fdecea;
  color: #611a15;
  border-left: 5px solid #e53935;
  font-family: Arial, sans-serif;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
  animation: fadeIn 0.4s ease-in-out;
  position: absolute;
  top: 20px;
  left: 50%;
  transform: translate(-50%);
  
}

.alert h4 {
  margin: 0 0 8px;
  font-size: 16px;
  font-weight: 600;
}

.alert p {
  margin: 0;
  font-size: 14px;
  line-height: 1.5;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-8px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

  </style>
</head>
<body>
<?php if ($_SERVER["REQUEST_METHOD"] === "POST") {  ?>
  <div class="alert">
    <h4>Error</h4>
    <p><?= htmlspecialchars($message) ?></p>
  </div>
<?php  } ?>
  <form class="otp-box" method="POST" action="verification_email.php">
    <h2>Email Verification</h2>
    <p>Enter the 6-digit code sent to your email</p>

    <div class="otp-inputs">
      <input type="text" maxlength="1" required>
      <input type="text" maxlength="1" required>
      <input type="text" maxlength="1" required>
      <input type="text" maxlength="1" required>
      <input type="text" maxlength="1" required>
      <input type="text" maxlength="1" required>
    </div>

    
    <input type="hidden" name="otp" id="otp">

    <button type="submit">Verify</button>

    <div class="resend">
      Didn’t receive the code? <a href="#">Resend</a>
    </div>
  </form>

  <script>
    const inputs = document.querySelectorAll(".otp-inputs input");
    const hiddenInput = document.getElementById("otp");

    inputs.forEach((input, index) => {
      input.addEventListener("input", () => {
        if (input.value.length === 1 && inputs[index + 1]) {
          inputs[index + 1].focus();
        }
        hiddenInput.value = Array.from(inputs).map(i => i.value).join("");
      });

      input.addEventListener("keydown", (e) => {
        if (e.key === "Backspace" && !input.value && inputs[index - 1]) {
          inputs[index - 1].focus();
        }
      });
    });
  </script>

</body>
</html>


