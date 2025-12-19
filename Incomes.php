<?php
require_once 'db.php';

 session_start();
$userID =  $_SESSION["user_id"] ;
$userName =  $_SESSION["user_name"] ;
if (!isset($userID)) {
    header("Location: login.php");
    exit;
}
 if(isset($_GET['logout'])){
    session_unset();
    session_destroy();
    header("Location: login.php");
 }
// AFFICHER INCOMES
$sql = "SELECT * FROM income WHERE user_id =  $userID ";
$stmt = $db->query($sql);
$incomes_table = $stmt->fetchAll(PDO::FETCH_ASSOC);
// OPEN FORM
$show_form = isset($_GET['show']) ? true : false;

$amount ="";
$description ="";
$date ="";
$last_four="";
$errorMessage = "";
$successMessage ="";


if (isset($_GET['edit'])) {
    $edit = intval($_GET['edit']);
    $stmt = $db->prepare("SELECT * FROM income WHERE id=?");
    $stmt->execute([$edit]);
    $getData = $stmt->fetch(PDO::FETCH_ASSOC);
    $show_form = true;
}

$getCards = $db->prepare("SELECT card_holder,last_four FROM cards WHERE user_id = ?");
$getCards->execute([$userID]);
$cards = $getCards->fetchAll(PDO::FETCH_ASSOC);




if($_SERVER["REQUEST_METHOD"] == "POST"){

  $id = $_POST['id'];
  $amount =$_POST['amount'];
$description =$_POST['description'];
$date =$_POST['date'];
$last_four=$_POST["card"];

if(!empty($id)){
  
    $stmt = $db->prepare("UPDATE income 
                                   SET amount=?, description=?, date=?
                                   WHERE id=?");
            $stmt->execute([$amount,$description,$date,$id]);
            $successMessage = "Income updated successfully";
           
}else{

  if(!is_numeric($amount) && empty($amount) ||  empty($description) || empty($date) ){

    $errorMessage = "All feilds are requered";

  }else{
    
    $getCardId = $db->prepare("SELECT id FROM cards WHERE last_four = ?");
    $getCardId->execute([$last_four]);
    $getId = $getCardId->fetch(PDO::FETCH_ASSOC);
    $card_id = $getId["id"];
    $stmt = $db->prepare("INSERT INTO income (amount, description, date , user_id , card_id)
                                  VALUES (?, ?, ? , ? , ?)");
            $stmt->execute([$amount,$description,$date,$userID,$card_id]);
            $successMessage = "Income added successfully";
          }

}

}












if(isset($_GET['dt'])) {

    $delet = intval($_GET['dt']);  
    $stmt = $db->prepare("DELETE FROM income WHERE id = ?");
    $stmt->execute([$delet]);
    header("Location: Incomes.php?deleted=1");
    exit;
}




?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Noto+Sans+Thaana:wght@100..900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/style/main.css">
<link rel="icon" href="/images/icoProfile.png"> 
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incomes</title>
</head>
<body>

<main class="container">

<section class="sidebar ">
    <div class="logo">
    
<div class="svg">   
<img src="/images/logo.png" alt="logo"/>
</div>
    </div>
        <div class="profile">
            <img src="/images/profile.jpg" alt="">
            <div class="user_name_role">
                    <a  href="profile.php">
                   
                   <p><?= $userName ?></p>
               </a>
                <p>Project Manager</p>
            </div>
        </div>
        <div class="Continer_links">
           <ul class="links">
               <li><a  href="/index.php">Dashboard <svg  xmlns="http://www.w3.org/2000/svg" width="18px" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#6b7280" d="M341.8 72.6C329.5 61.2 310.5 61.2 298.3 72.6L74.3 280.6C64.7 289.6 61.5 303.5 66.3 315.7C71.1 327.9 82.8 336 96 336L112 336L112 512C112 547.3 140.7 576 176 576L464 576C499.3 576 528 547.3 528 512L528 336L544 336C557.2 336 569 327.9 573.8 315.7C578.6 303.5 575.4 289.5 565.8 280.6L341.8 72.6zM304 384L336 384C362.5 384 384 405.5 384 432L384 528L256 528L256 432C256 405.5 277.5 384 304 384z"/></svg></a></li>
               <li><a class="Wr" href="/Incomes.php">Incomes <svg xmlns="http://www.w3.org/2000/svg" width="18px"  viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#6b7280" d="M264 112L376 112C380.4 112 384 115.6 384 120L384 160L256 160L256 120C256 115.6 259.6 112 264 112zM208 120L208 160L128 160C92.7 160 64 188.7 64 224L64 320L576 320L576 224C576 188.7 547.3 160 512 160L432 160L432 120C432 89.1 406.9 64 376 64L264 64C233.1 64 208 89.1 208 120zM576 368L384 368L384 384C384 401.7 369.7 416 352 416L288 416C270.3 416 256 401.7 256 384L256 368L64 368L64 480C64 515.3 92.7 544 128 544L512 544C547.3 544 576 515.3 576 480L576 368z"/></svg></a></li>
               <li><a href="/expenses.php">Expenses <svg xmlns="http://www.w3.org/2000/svg" width="18px"  viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#6b7280" d="M544.4 304L368.4 304C350.7 304 336.4 289.7 336.4 272L336.4 96C336.4 78.3 350.8 63.8 368.3 66.1C475.3 80.3 560.1 165.1 574.3 272.1C576.6 289.6 562.1 304 544.4 304zM254.6 101.2C272.7 97.4 288.4 112.2 288.4 130.7L288.4 328C288.4 333.6 290.4 339 293.9 343.3L426 502.7C437.7 516.8 435.2 538.1 419.1 546.8C385 565.4 345.9 576 304.4 576C171.9 576 64.4 468.5 64.4 336C64.4 220.5 145.9 124.1 254.6 101.2zM509.8 352L573.8 352C592.3 352 607.1 367.7 603.3 385.8C593.1 434.2 568.3 477.2 533.7 510C521.4 521.7 502.1 519.2 491.3 506.1L406.9 404.4C389.6 383.5 404.5 352 431.5 352L509.7 352z"/></svg></a></li>
           </ul>
        </div>
    <!-- <div class="contianer_btns">
        <label for="hide_sidebar">
            &times;
        </label>
        <label for="show_sidedebar">
            <img src="images/menu.svg" alt="menu">
        </label>
        <input class="hidden" type="chechbox" id="hide_sidebar">
        <input class="hidden" type="chechbox" id="show_sidebar">
    </div> -->
        <button class="logout">
        <a href="Incomes.php?logout=1">Log out</a>
    </button>
    </section>


    <section class="main">

    <div class="icon_salle">
        <div class="in_icon">
         <svg xmlns="http://www.w3.org/2000/svg" width="18px"  viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#3b82f6" d="M264 112L376 112C380.4 112 384 115.6 384 120L384 160L256 160L256 120C256 115.6 259.6 112 264 112zM208 120L208 160L128 160C92.7 160 64 188.7 64 224L64 320L576 320L576 224C576 188.7 547.3 160 512 160L432 160L432 120C432 89.1 406.9 64 376 64L264 64C233.1 64 208 89.1 208 120zM576 368L384 368L384 384C384 401.7 369.7 416 352 416L288 416C270.3 416 256 401.7 256 384L256 368L64 368L64 480C64 515.3 92.7 544 128 544L512 544C547.3 544 576 515.3 576 480L576 368z"/></svg>
        </div>

        
        Incomes
    </div>

    <section class="section_table">

    <div class="card">




      <div class="create">
<a style="text-decoration: none;" href="incomes.php?show=1">

  <button class="Btn">
    
    <div class="sign">+</div>
    
    <div class="text">Create</div>
  </button>
</a>
      </div>
  <h2 class="title">Incomes</h2>

  <table class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>Montant</th>
        <th>Description</th>
        <th>Date</th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($incomes_table as $el) {  ?>
        <tr>
          <td>
            <span class="dot blue"></span> <?= $el['id'] ?>
          </td>
          <td class="amount positive">$<?= $el['amount'] ?></td>
          <td><?= $el['description'] ?></td>
          <td><span class="badge blue-b"><?= $el['date'] ?></span></td>
<td class="actions-cell">
  <div class="actions">
    <span class="dots">⋮</span>

    <div class="menu">
      
      <a href="Incomes.php?dt=<?= $el['id'] ?>" class="menu-item delete">
        🗑️ Delete
      </a>

      <a href="Incomes.php?edit=<?= $el['id'] ?>" class="menu-item edit">
        ✏️ Edit
      </a>

    </div>
  </div>
</td>

        </tr>
        <?php  } ?>

    </tbody>
  </table>
</div>



    </section >


    </section>
</main>
<!-- DELETE SUCCESS -->
        <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1) { ?>
    <div class="alert-success" id="successCard">
      <span>✔ Item deleted successfully</span>
    </div>
<?php  } ?>
    

<!-- OPEN FORM -->
<?php if($show_form || isset($_GET['edit'])) { ?> 
<section class="container_form">
<!-- INPUT INVALID -->
<?php
if(!empty($errorMessage)){

  echo "
  <div class='alert-error'>
  <span class='icon'>⚠️</span>
  <p>$errorMessage</p>
  </div>
  
  ";
  }
?>
<!-- INPUT VALID -->
<?php
if(!empty($successMessage)){

  echo "
  <div class='alert-success'>
  <span class='icon'>✔</span>
  <p>$successMessage</p>
  </div>
  
  ";
  }
?>


 

      <div class="card form-card">
        <a style="text-decoration: none;" href="incomes.php">

          <button class="close-btn" type="button">×</button>
        </a>
 <h2 class="title"><?= isset($getData) ? "Edit Transaction" : "Add Transaction" ?></h2>


  <form action="incomes.php?<?= isset($getData) ? "edit=".$getData['id'] : "show=1"  ?>" method="POST" class="form">
      <input type="hidden" name="id" value="<?= isset($getData) ? $getData['id'] : "" ?>">
      <!-- choose card -->
        <div>
          <select name="card" required>
            <option value="">select card</option>
            <?php foreach($cards as $card) {  ?>
          <option value=<?= $card["last_four"] ?>>
            <div class="cardOption">
              <p><?= $card["card_holder"] ?></p>
              <p>**** **** **** <?= $card["last_four"] ?></p>
            </div>
          </option>
          <?php } ?>
          </select>
        </div>
      
    <!-- MONTANT -->
    <div class="form-group">
      <label>Montant</label>
      <input type="number" placeholder="Ex: 1500" name="amount" value="<?= isset($getData) ? $getData['amount'] : $amount  ?>"   >
    </div>

    <!-- DESCRIPTION -->
    <div class="form-group">
      <label>Description</label>
      <input type="text" placeholder="Ex: Salary or Groceries" name="description" value="<?= isset($getData) ? $getData['description'] : $description  ?>" >
    </div>

    <!-- DATE -->
    <div class="form-group">
      <label>Date</label>
      <input type="date" name="date" value="<?= isset($getData) ? $getData['date'] : $date  ?>" >
    </div>

    <!-- BUTTON -->
     
    <button class="submit-btn" type="submit"><?= isset($getData) ? "Update" : "Add" ?></button>

  </form>
</div>

</section>
<?php } ?>


<script src="main.js"></script>

</body>
</html>