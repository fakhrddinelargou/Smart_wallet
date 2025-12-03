<?php

$host = "localhost";
$dbname ="smart_wallet";
$user = "root";
$pss = "";
try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pss);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "DB OK"; // t9dar t7elha gher bach ttesti
} catch (PDOException $e) {
    die("Erreur connexion DB: " . $e->getMessage());
}

?>