<?php




require_once "db.php";
$fullName = "";
$email = "";
$password = "";
$message="";

if($_SERVER["REQUEST_METHOD"] == "POST"){

$fullName = $_POST["fullName"];
$email = $_POST["email"];
$password = $_POST["password"];

if (empty($fullName) || empty($email) || empty($password)) {
  
  $message = "Please Enter Corruct Informations";
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $message = "Invalid Email";
} else{
  $checkEmail = $db->prepare("SELECT * FROM registers WHERE email = ? LIMIT 1");
  $checkEmail->execute([$email]);
  $ftEmail = $checkEmail->fetch(PDO::FETCH_ASSOC);
  
  if ($ftEmail) {
    $message = "Email is already exist";
  } else{
    
    $hashpass = password_hash($password , PASSWORD_DEFAULT);
    
    
    $reUser = $db->prepare("INSERT INTO registers (fullName , email,password) VALUES (?,?,?)");
    $reUser->execute([$fullName , $email , $hashpass]);
    
    $userId =$db->lastInsertId();
    $IP_Address = $_SERVER['REMOTE_ADDR'];
    $stmtIp = $db->prepare("INSERT INTO user_ips (user_id,ip_address) VALUES (?,?)");
    $stmtIp->execute([$userId,$IP_Address]);




  header("Location: login.php");


    }
  
  }
   

}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        /* From Uiverse.io by alexruix */ 
.form-box {
  max-width: 300px;
  background: #f1f7fe;
  overflow: hidden;
  border-radius: 16px;
  color: #010101;
}

.form {
  position: relative;
  display: flex;
  flex-direction: column;
  padding: 32px 24px 24px;
  gap: 16px;
  text-align: center;
}

/*Form text*/
.title {
  font-weight: bold;
  font-size: 1.6rem;
}

.subtitle {
  font-size: 1rem;
  color: #666;
}

/*Inputs box*/
.form-container {
  overflow: hidden;
  border-radius: 8px;
  background-color: #fff;
  margin: 1rem 0 .5rem;
  width: 100%;
}

.input {
  background: none;
  border: 0;
  outline: 0;
  height: 40px;
  width: 100%;
  border-bottom: 1px solid #eee;
  font-size: .9rem;
  padding: 8px 15px;
}

.form-section {
  padding: 16px;
  font-size: .85rem;
  background-color: #e0ecfb;
  box-shadow: rgb(0 0 0 / 8%) 0 -1px;
}

.form-section a {
  font-weight: bold;
  color: #0066ff;
  transition: color .3s ease;
}

.form-section a:hover {
  color: #005ce6;
  text-decoration: underline;
}

/*Button*/
.form button {
  background-color: #0066ff;
  color: #fff;
  border: 0;
  border-radius: 24px;
  padding: 10px 16px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: background-color .3s ease;
}

.form button:hover {
  background-color: #005ce6;
}

.error{
    border-color : red !important;
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
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/style/main.css">
<link rel="icon" href="/images/icoProfile.png"> 

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
</head>
<body>
<?php if ($_SERVER["REQUEST_METHOD"] === "POST") {  ?>
  <div class="alert">
    <h4>Error</h4>
    <p><?= htmlspecialchars($message) ?></p>
  </div>
<?php  } ?>

<section class="container">

    <div class="form-box">
        <form class="form" action="regester.php" method="POST">
            <span class="title">Sign up</span>
            <span class="subtitle">Create a free account with your email.</span>
            <div class="form-container">
                <input type="text" class="input" name="fullName" placeholder="Full Name">
                <input type="email" class="input <?= empty($ftEmail) ? "error" : ""  ?>" name="email" placeholder="Email">
                <input type="password" class="input" name="password" placeholder="Password">
            </div>
            <button type="submit" >Sign up</button>
        </form>
        <div class="form-section">
            <p>Have an account? <a href="login.php">Log in</a> </p>
        </div>
    </div>
    
</section>
</body>
</html>