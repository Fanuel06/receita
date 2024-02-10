<?php

$name = "hg5pss68_bntds_azul";
$host = "5ps.site";
$user = "hg5pss68_bntds_azul";
$pass = '$YYFudTtt@bR';

try {
  $pdo = new PDO("mysql:host=$host;dbname=$name", $user, $pass);
} catch (PDOException $e) {
  echo "ERRO: " . $e->getMessage();
}