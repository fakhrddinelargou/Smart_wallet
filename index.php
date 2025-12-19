<?php


require_once "db.php";
 session_start();
 if(isset($_GET['logout'])){
    session_unset();
    session_destroy();
    header("Location: login.php");
 }
$userID =  $_SESSION["user_id"] ;
$userName =  $_SESSION["user_name"] ;
if (!isset($userID)) {
    header("Location: login.php");
    exit;
}
$expStmt=$db->query("SELECT SUM(amount) AS total_expenses FROM expense WHERE user_id = $userID ");
$ttldr = $expStmt->fetch(PDO::FETCH_ASSOC);
$ttl = $ttldr["total_expenses"]  ?? 0;


$incStmt =$db->query("SELECT SUM(amount) AS total_incomes FROM income WHERE user_id = $userID");
$tllinc =$incStmt->fetch(PDO::FETCH_ASSOC);
$ttlin = $tllinc['total_incomes'] ?? 0 ;

$tcb = $ttlin - $ttl;

// $date = date("Y-m-d")
$currYear = date("Y");
$currMonth = date("m");
$gdataI = $db->query("SELECT  SUM(amount)  AS total_month_incomes FROM income  WHERE  user_id = $userID AND  YEAR(date)=$currYear  AND MONTH(date)=$currMonth  ");
$gdatacI = $gdataI->fetch(PDO::FETCH_ASSOC);
$tlasmonthI = $gdatacI['total_month_incomes'] ?? 0;


$gdataE =$db -> query("SELECT SUM(amount) AS total_month_expenses FROM expense WHERE user_id = $userID AND YEAR(date)=$currYear AND MONTH(date)=$currMonth");
$gdatacE = $gdataE->fetch(PDO::FETCH_ASSOC);
$tlasmonthE = $gdatacE['total_month_expenses'] ?? 0;


$yearsIncome = $db->query("
    SELECT YEAR(date) AS year, SUM(amount) AS total
    FROM income WHERE  user_id = $userID GROUP BY YEAR(date)
")->fetchAll(PDO::FETCH_ASSOC);


$yearsExpense = $db->query("
    SELECT YEAR(date) AS year, SUM(amount) AS total
    FROM expense
  WHERE user_id = $userID GROUP BY YEAR(date)
")->fetchAll(PDO::FETCH_ASSOC);


$labels = [];
$incomeData = [];
$expenseData = [];

foreach ($yearsIncome as $row) {
    $labels[] = $row['year'];
    $incomeData[] = $row['total'];
}

foreach ($yearsExpense as $row) {
    $year = $row['year'];
    $key = array_search($year, $labels);

    if ($key !== false) {
        $expenseData[$key] = $row['total'];
    } else {
        $labels[] = $year;
        $incomeData[] = 0;
        $expenseData[] = $row['total'];
    }
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
    <title>Dashboard</title>
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
               <li><a class="Wr" href="/index.php">Dashboard <svg xmlns="http://www.w3.org/2000/svg" width="18px" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#6b7280" d="M341.8 72.6C329.5 61.2 310.5 61.2 298.3 72.6L74.3 280.6C64.7 289.6 61.5 303.5 66.3 315.7C71.1 327.9 82.8 336 96 336L112 336L112 512C112 547.3 140.7 576 176 576L464 576C499.3 576 528 547.3 528 512L528 336L544 336C557.2 336 569 327.9 573.8 315.7C578.6 303.5 575.4 289.5 565.8 280.6L341.8 72.6zM304 384L336 384C362.5 384 384 405.5 384 432L384 528L256 528L256 432C256 405.5 277.5 384 304 384z"/></svg></a></li>
               <li><a href="/Incomes.php">Incomes <svg xmlns="http://www.w3.org/2000/svg" width="18px"  viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#6b7280" d="M264 112L376 112C380.4 112 384 115.6 384 120L384 160L256 160L256 120C256 115.6 259.6 112 264 112zM208 120L208 160L128 160C92.7 160 64 188.7 64 224L64 320L576 320L576 224C576 188.7 547.3 160 512 160L432 160L432 120C432 89.1 406.9 64 376 64L264 64C233.1 64 208 89.1 208 120zM576 368L384 368L384 384C384 401.7 369.7 416 352 416L288 416C270.3 416 256 401.7 256 384L256 368L64 368L64 480C64 515.3 92.7 544 128 544L512 544C547.3 544 576 515.3 576 480L576 368z"/></svg></a></li>
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
        <a href="index.php?logout=1">Log out</a>
    </button>

    </section>


    <section class="main">
 <div class="icon_salle icon_dash">
        <div class="in_icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="18px" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#3b82f6" d="M341.8 72.6C329.5 61.2 310.5 61.2 298.3 72.6L74.3 280.6C64.7 289.6 61.5 303.5 66.3 315.7C71.1 327.9 82.8 336 96 336L112 336L112 512C112 547.3 140.7 576 176 576L464 576C499.3 576 528 547.3 528 512L528 336L544 336C557.2 336 569 327.9 573.8 315.7C578.6 303.5 575.4 289.5 565.8 280.6L341.8 72.6zM304 384L336 384C362.5 384 384 405.5 384 432L384 528L256 528L256 432C256 405.5 277.5 384 304 384z"/></svg>
        </div>

        
        Dashboard
    </div>
<section class="dashboard-cards">

  <!-- Total Income -->
  <div class="card">
    <p class="label">Total Income</p>
    <h2 class="value" id="totalIncome"><?= $ttlin ?> DH</h2>
  </div>

  <!-- Total Expenses -->
  <div class="card red">
    <p class="label">Total Expenses</p>
    <h2 class="value" id="totalExpenses"><?= $ttl ?> DH</h2>
  </div>

  <!-- Current Balance -->
<div class="balance-card <?= ($tcb < 0) ? 'negative' : 'positive' ?>">
    <h3>Current Balance</h3>

    <p class="amount">
        <?= ($tcb < 0 ? '-' : '') . abs($tcb) ?> DH
    </p>

    <?php if ($tcb < 0): ?>
        <span class="warning">⚠️ You are spending more than you earn</span>
    <?php else: ?>
        <span class="success">✔ Budget is in good standing</span>
    <?php endif; ?>
</div>


  <!-- This Month Income -->
  <div class="card">
    <p class="label">Income This Month</p>
    <h2 class="value" id="incomeMonth"><?= $tlasmonthI ?>  DH</h2>
  </div>

  <!-- This Month Expenses -->
  <div class="card red">
    <p class="label">Expenses This Month</p>
    <h2 class="value" id="expensesMonth"><?= $tlasmonthE ?> DH</h2>
  </div>

</section>



    <section class="chart_container">
        


<div style="width: 500px;">
<canvas id="chartReEx"></canvas>
</div>


</section>
    </section>
</main>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

        let labels = <?= json_encode($labels) ?>;
let incomeData = <?= json_encode($incomeData) ?>;
let expenseData = <?= json_encode($expenseData) ?>;   
 const ctx = document.getElementById('chartReEx').getContext('2d');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Revenus',
                data: incomeData,
                backgroundColor: 'rgba(27, 165, 31, 0.8)'
            },
            {
                label: 'Dépenses',
                data: expenseData,
                backgroundColor: 'rgba(232, 41, 27, 0.8)'
            }
        ]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});




</script>
</body>
</html>