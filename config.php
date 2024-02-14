<?php

$name = "hg5pss68_bntds_azul";
$host = "5ps.site";
$user = "hg5pss68_bntds_azul";
$pass = '$YYFudTtt@bR';

try {
  $pdo = new PDO("mysql:host=$host;dbname=$name", $user, $pass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "ERRO: " . $e->getMessage();
  $pdo = null;
}
?>