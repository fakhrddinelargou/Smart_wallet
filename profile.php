<?php
 require_once "db.php";
 session_start();
 $userName = $_SESSION["user_name"];
 $user_id = $_SESSION["user_id"];
 if(!isset($user_id)){
    header("Location: login.php");
 }

$userCard =$db->prepare("SELECT * FROM cards WHERE user_id = ?");
$userCard->execute([$user_id]);
$cards = $userCard->fetchAll(PDO::FETCH_ASSOC);

$incomes = $db->prepare("SELECT SUM(amount) AS totalIncome FROM income WHERE user_id = ?");
$incomes->execute([$user_id]);
$totalIncome = $incomes->fetch(PDO::FETCH_ASSOC);

$expenses = $db->prepare("SELECT SUM(amount) AS totalExpense FROM expense WHERE user_id = ?");
$expenses->execute([$user_id]);
$totalExpense = $expenses->fetch(PDO::FETCH_ASSOC);

$countCards = $db->prepare("SELECT COUNT(*) AS count_cards FROM cards WHERE user_id = ?");
$countCards->execute([$user_id]);
$totalCard = $countCards->fetch(PDO::FETCH_ASSOC);



$totalcards = $totalCard["count_cards"];
$totalExpenses = $totalExpense["totalExpense"];
$totalIncomes = $totalIncome["totalIncome"];
$balance = $totalIncomes - $totalExpenses;


$idCards = $db->prepare("SELECT id  FROM cards WHERE user_id = ? ");
$idCards->execute([$user_id]);
$id_Card = $idCards->fetchAll(PDO::FETCH_ASSOC);

foreach($id_Card as $id){
$ids  = $id["id"];
$cardBalance = $db->prepare("SELECT SUM(amount) AS card_balance FROM income WHERE card_id = ? ");
$cardBalance->execute([$ids]);
$inBalance = $cardBalance->fetch(PDO::FETCH_ASSOC);

}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="icon" href="/images/icoProfile.png"> 

<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/style/main.css"> 
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile</title>

    <style>
        .main {
  padding: 32px;
  background: #f9fafb;
  
}

.page-header h1 {
  font-size: 26px;
  font-weight: 700;
}

.page-header p {
  color: #6b7280;
  margin-top: 4px;
}

.main-grid {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 24px;
  margin-top: 24px;
}
/* card */
.cards-header{
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
}
.cards-page {
  padding: 20px;
}

.btn-add {
  background: #6366f1;
  color: white;
  border: none;
  padding: 8px 14px;
  border-radius: 10px;
  cursor: pointer;
text-decoration: none;
  
}
/* ===== BANK CARD ===== */

.bank-card {
  width: 340px;
  height: 210px;
  border-radius: 18px;
  padding: 20px;
  color: #fff;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  box-shadow: 0 20px 40px rgba(0,0,0,0.25);
  font-family: 'Inter', sans-serif;
  position: relative;
  overflow: hidden;
}
.bank-cards {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 24px;
  justify-items: center;
}


@media (max-width: 900px) {
  .bank-cards {
    grid-template-columns: 1fr;
  }
}

/* VISA STYLE */
.bank-card.visa {
  background: linear-gradient(135deg, #1e3a8a, #2563eb);
}

/* HEADER */
.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.card-type {
  font-size: 18px;
  font-weight: 700;
  letter-spacing: 2px;
}

/* CHIP */
.card-chip {
  width: 45px;
  height: 32px;
  border-radius: 6px;
  background: linear-gradient(135deg, #e5e7eb, #9ca3af);
}

/* CARD NUMBER */
.card-number {
  font-size: 20px;
  letter-spacing: 3px;
  font-weight: 500;
  margin-top: 10px;
}

/* BALANCE */
.card-balance small {
  font-size: 12px;
  opacity: 0.85;
}

.card-balance .amount {
  font-size: 24px;
  font-weight: 700;
  margin-top: 4px;
}

/* FOOTER */
.card-footer {
  display: flex;
  justify-content: space-between;
}

.card-footer small {
  font-size: 11px;
  opacity: 0.8;
}

.card-footer p {
  font-size: 13px;
  font-weight: 600;
  margin-top: 2px;
}

/* GLASS EFFECT */
.bank-card::after {
  content: "";
  position: absolute;
  top: -40%;
  right: -40%;
  width: 200px;
  height: 200px;
  background: rgba(255,255,255,0.15);
  border-radius: 50%;
}

/* BALANCE ROW */
.balance-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.toggle-balance {
  background: rgba(255,255,255,0.2);
  border: none;
  color: white;
  font-size: 10px;
  padding: 6px 8px;
  border-radius: 8px;
  cursor: pointer;
    display: flex;
  align-items: center;
  justify-content: center;
}
.toggle-balance svg{
    width: 18px;
}

.toggle-balance:hover {
  background: rgba(255,255,255,0.35);

}

/* Profile Section */
.profile-card {
  background: white;
  padding: 24px;
  border-radius: 16px;
  text-align: center;
  box-shadow: 0 8px 24px rgba(0,0,0,0.04);
}

.profile-card img {
  width: 70px;
  height: 70px;
  border-radius: 50%;
  margin-bottom: 12px;
}

.profile-card .role {
  color: #6b7280;
  font-size: 14px;
}

.stats-card {
  background: white;
  margin-top: 16px;
  padding: 20px;
  border-radius: 16px;
  box-shadow: 0 8px 24px rgba(0,0,0,0.04);
  display: flex;
  flex-direction : column;
  gap: 10px;
}
.stats-card h4{
    margin-bottom: 15px;

}

.stat {
  display: flex;
  justify-content: space-between;
  margin-bottom: 12px;
}

.stat p {
  color: #6b7280;
}

.redd{
    color:red !important;
}
.greenn{
    color:green !important;
}
    </style>
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
               <li><a  href="/index.php">Dashboard <svg xmlns="http://www.w3.org/2000/svg" width="18px" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#6b7280" d="M341.8 72.6C329.5 61.2 310.5 61.2 298.3 72.6L74.3 280.6C64.7 289.6 61.5 303.5 66.3 315.7C71.1 327.9 82.8 336 96 336L112 336L112 512C112 547.3 140.7 576 176 576L464 576C499.3 576 528 547.3 528 512L528 336L544 336C557.2 336 569 327.9 573.8 315.7C578.6 303.5 575.4 289.5 565.8 280.6L341.8 72.6zM304 384L336 384C362.5 384 384 405.5 384 432L384 528L256 528L256 432C256 405.5 277.5 384 304 384z"/></svg></a></li>
               <li><a href="/Incomes.php">Incomes <svg xmlns="http://www.w3.org/2000/svg" width="18px"  viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#6b7280" d="M264 112L376 112C380.4 112 384 115.6 384 120L384 160L256 160L256 120C256 115.6 259.6 112 264 112zM208 120L208 160L128 160C92.7 160 64 188.7 64 224L64 320L576 320L576 224C576 188.7 547.3 160 512 160L432 160L432 120C432 89.1 406.9 64 376 64L264 64C233.1 64 208 89.1 208 120zM576 368L384 368L384 384C384 401.7 369.7 416 352 416L288 416C270.3 416 256 401.7 256 384L256 368L64 368L64 480C64 515.3 92.7 544 128 544L512 544C547.3 544 576 515.3 576 480L576 368z"/></svg></a></li>
               <li><a href="/expenses.php">Expenses <svg xmlns="http://www.w3.org/2000/svg" width="18px"  viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#6b7280" d="M544.4 304L368.4 304C350.7 304 336.4 289.7 336.4 272L336.4 96C336.4 78.3 350.8 63.8 368.3 66.1C475.3 80.3 560.1 165.1 574.3 272.1C576.6 289.6 562.1 304 544.4 304zM254.6 101.2C272.7 97.4 288.4 112.2 288.4 130.7L288.4 328C288.4 333.6 290.4 339 293.9 343.3L426 502.7C437.7 516.8 435.2 538.1 419.1 546.8C385 565.4 345.9 576 304.4 576C171.9 576 64.4 468.5 64.4 336C64.4 220.5 145.9 124.1 254.6 101.2zM509.8 352L573.8 352C592.3 352 607.1 367.7 603.3 385.8C593.1 434.2 568.3 477.2 533.7 510C521.4 521.7 502.1 519.2 491.3 506.1L406.9 404.4C389.6 383.5 404.5 352 431.5 352L509.7 352z"/></svg></a></li>
           </ul>
        </div>
    <button class="logout">
        <a href="index.php?logout=1">Log out</a>
    </button>
    </section>
  <section class="main">

  <!-- Page Header -->
  <div class="page-header">
    <h1>My Wallet</h1>
    <p>Manage your cards and profile</p>
  </div>

  <div class="main-grid">

    <!-- LEFT: Cards Section -->
   <div class="cards-page">

  <div class="cards-header">
    <h1>My Cards</h1>
    <a href="card.php" class="btn-add">+ Add Card</a>
  </div>

  <div class="bank-cards">
      
      <?php foreach($cards as $card) { ?>
      <!-- Card -->
<div class="bank-card visa">

  <!-- HEADER -->
  <div class="card-header">
    <span class="card-type">VISA</span>
    <span class="card-chip"></span>
  </div>

  <!-- CARD NUMBER -->
  <div class="card-number">
    **** **** **** <?= $card['last_four'] ?>
  </div>

  <!-- BALANCE -->
  <div class="card-balance">
    <small>Available balance</small>

    <div class="balance-row">
      <p class="amount" data-balance=<?= $card['balance'] ?> ><?= $card['balance'] > 0 ? $card['balance'] : "00.0" ?> DH</p>

      <button class="toggle-balance" onclick="toggleBalance(this)">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#f0f0f0d2"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/></svg>
      </button>
    </div>
  </div>

  <!-- FOOTER -->
  <div class="card-footer">
    <div>
      <small>Card holder</small>
      <p><?= strtoupper($card['card_holder']) ?></p>
    </div>
    <div>
      <small>Expires</small>
      <p><?= $card['expiry_month'] ?>/<?= $card['expiry_year'] ?></p>
    </div>
    
</div>

</div>
<?php } ?>





</div>

</div>

    <!-- RIGHT: Profile / Summary -->
    <div class="profile-section">

      <div class="profile-card">
        <img src="/images/profile.jpg" alt="profile">
        <h3><?= $userName ?></h3>
        <p class="role">Project Manager</p>
      </div>

       <div class="stats-card">
    <h4>Summary</h4>

    <div class="stat">
      <p>Total Cards</p>
      <strong><?= $totalcards ?></strong>
    </div>

    <div class="stat">
      <p>Total Incomes</p>
      <strong><?= $totalIncomes > 0 ? $totalIncomes : "00.0" ?> DH</strong>
    </div>

    <div class="stat">
      <p>Total Expenses</p>
      <strong><?= $totalExpenses  > 0 ? $totalExpenses : "00.0" ?> DH</strong>
    </div>

    <div class="stat total <?= $balance  < 0 ? "redd" : "greenn" ?>">
      <p>Total Balance</p>
      <strong><?= $balance > 0  ? "+" . $balance : $balance ?> DH</strong>
    </div>
    
  </div>

</div>

    </div>

  </div>

</div>


</section>


</main>
<script>
function toggleBalance(btn) {
  const amount = btn.closest('.balance-row').querySelector('.amount');
  const realBalance = amount.getAttribute('data-balance');

  if (amount.classList.contains('hidden')) {
    // Show balance
    amount.textContent = Number(realBalance).toLocaleString() + ' DH';
    amount.classList.remove('hidden');
    btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#f0f0f0d2"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/></svg>`;
  } else {
    // Hide balance
    amount.textContent = '•••• DH';
    amount.classList.add('hidden');
    btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#f0f0f0d2"><path d="m644-428-58-58q9-47-27-88t-93-32l-58-58q17-8 34.5-12t37.5-4q75 0 127.5 52.5T660-500q0 20-4 37.5T644-428Zm128 126-58-56q38-29 67.5-63.5T832-500q-50-101-143.5-160.5T480-720q-29 0-57 4t-55 12l-62-62q41-17 84-25.5t90-8.5q151 0 269 83.5T920-500q-23 59-60.5 109.5T772-302Zm20 246L624-222q-35 11-70.5 16.5T480-200q-151 0-269-83.5T40-500q21-53 53-98.5t73-81.5L56-792l56-56 736 736-56 56ZM222-624q-29 26-53 57t-41 67q50 101 143.5 160.5T480-280q20 0 39-2.5t39-5.5l-36-38q-11 3-21 4.5t-21 1.5q-75 0-127.5-52.5T300-500q0-11 1.5-21t4.5-21l-84-82Zm319 93Zm-151 75Z"/></svg>`;
  }
}
</script>

</body>
</html>