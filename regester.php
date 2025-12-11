<?php

require_once "db.php";
$fullName ="";
$email ="";
$pssword ="";

if($_SERVER["REQUEST_METHOD"] == "POST"){
$fullName = $_POST["fullName"];
$email = $_POST["email"];
$password = $_POST["password"];
$hashpass = password_hash($password , PASSWORD_DEFAULT);


$checkEmail = $db->query("SELECT * FROM registers WHERE email = '$email' LIMIT 1");
$ftEmail = $checkEmail->fetch(PDO::FETCH_ASSOC);
if(!empty($fullName) && empty($ftEmail) && !empty($password) ){

    
    
    $reUser = $db->prepare("INSERT INTO registers (fullName , email,password) VALUES (?,?,?)");
    $reUser->execute([$fullName , $email , $hashpass]);
    header("Location: login.php");

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
    </style>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/style/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

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
            <button>Sign up</button>
        </form>
        <div class="form-section">
            <p>Have an account? <a href="">Log in</a> </p>
        </div>
    </div>
    
</section>
</body>
</html>