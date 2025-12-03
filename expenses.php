<?php

require_once 'db.php';

$sql = "SELECT * FROM expense";

$stmt = $db -> query($sql);
$expenses_table = $stmt -> fetchAll (PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Noto+Sans+Thaana:wght@100..900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/style/main.css"> 
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income & Expenses Tracker – Gestion simple des finances personnelles</title>
</head>
<body>

<main class="container">

<section class="sidebar">
    <div class="logo">
    
<div class="svg">   
<img src="/images/logo.png" alt="logo"/>
</div>
    </div>
        <div class="profile">
            <img src="/images/profile.jpg" alt="">
            <div class="user_name_role">
                <p>Fakhreddine Largou</p>
                <p>Project Manager</p>
            </div>
        </div>
        <div class="Continer_links">
           <ul class="links">
               <li><a href="/index.php">Dashboard <svg xmlns="http://www.w3.org/2000/svg" width="18px" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#6b7280" d="M341.8 72.6C329.5 61.2 310.5 61.2 298.3 72.6L74.3 280.6C64.7 289.6 61.5 303.5 66.3 315.7C71.1 327.9 82.8 336 96 336L112 336L112 512C112 547.3 140.7 576 176 576L464 576C499.3 576 528 547.3 528 512L528 336L544 336C557.2 336 569 327.9 573.8 315.7C578.6 303.5 575.4 289.5 565.8 280.6L341.8 72.6zM304 384L336 384C362.5 384 384 405.5 384 432L384 528L256 528L256 432C256 405.5 277.5 384 304 384z"/></svg></a></li>
               <li><a href="/Incomes.php">Incomes <svg xmlns="http://www.w3.org/2000/svg" width="18px"  viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#6b7280" d="M264 112L376 112C380.4 112 384 115.6 384 120L384 160L256 160L256 120C256 115.6 259.6 112 264 112zM208 120L208 160L128 160C92.7 160 64 188.7 64 224L64 320L576 320L576 224C576 188.7 547.3 160 512 160L432 160L432 120C432 89.1 406.9 64 376 64L264 64C233.1 64 208 89.1 208 120zM576 368L384 368L384 384C384 401.7 369.7 416 352 416L288 416C270.3 416 256 401.7 256 384L256 368L64 368L64 480C64 515.3 92.7 544 128 544L512 544C547.3 544 576 515.3 576 480L576 368z"/></svg></a></li>
               <li><a class="Wr" href="/expenses.php">Expenses <svg xmlns="http://www.w3.org/2000/svg" width="18px"  viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#6b7280" d="M544.4 304L368.4 304C350.7 304 336.4 289.7 336.4 272L336.4 96C336.4 78.3 350.8 63.8 368.3 66.1C475.3 80.3 560.1 165.1 574.3 272.1C576.6 289.6 562.1 304 544.4 304zM254.6 101.2C272.7 97.4 288.4 112.2 288.4 130.7L288.4 328C288.4 333.6 290.4 339 293.9 343.3L426 502.7C437.7 516.8 435.2 538.1 419.1 546.8C385 565.4 345.9 576 304.4 576C171.9 576 64.4 468.5 64.4 336C64.4 220.5 145.9 124.1 254.6 101.2zM509.8 352L573.8 352C592.3 352 607.1 367.7 603.3 385.8C593.1 434.2 568.3 477.2 533.7 510C521.4 521.7 502.1 519.2 491.3 506.1L406.9 404.4C389.6 383.5 404.5 352 431.5 352L509.7 352z"/></svg></a></li>
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
    </section>


    <section class="main">

    <div class="icon_salle">
        <div class="in_icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="18px"  viewBox="0 0 640 640"><path fill="#3b82f6" d="M544.4 304L368.4 304C350.7 304 336.4 289.7 336.4 272L336.4 96C336.4 78.3 350.8 63.8 368.3 66.1C475.3 80.3 560.1 165.1 574.3 272.1C576.6 289.6 562.1 304 544.4 304zM254.6 101.2C272.7 97.4 288.4 112.2 288.4 130.7L288.4 328C288.4 333.6 290.4 339 293.9 343.3L426 502.7C437.7 516.8 435.2 538.1 419.1 546.8C385 565.4 345.9 576 304.4 576C171.9 576 64.4 468.5 64.4 336C64.4 220.5 145.9 124.1 254.6 101.2zM509.8 352L573.8 352C592.3 352 607.1 367.7 603.3 385.8C593.1 434.2 568.3 477.2 533.7 510C521.4 521.7 502.1 519.2 491.3 506.1L406.9 404.4C389.6 383.5 404.5 352 431.5 352L509.7 352z"/></svg>
        </div>

        
        Expenses
    </div>

    <section class="section_table">

    <div class="card">
  <h2 class="title">Expenses</h2>

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
      <?php foreach($expenses_table as $el) { ?>
        <tr>
          <td>
            <span class="dot red"></span> <?= $el["id"] ?>
          </td>
          <td class="amount negative"><?= $el["montent"] ?> DH</td>
          <td><?= $el["description"] ?></td>
          <td><span class="badge red-b"><?= $el["date"] ?></span></td>
        </tr>
        <?php } ?>
        

    </tbody>
  </table>
</div>




    </section>

    </section>
</main>
    
</body>
</html>