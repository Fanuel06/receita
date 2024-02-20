<?php
require "./config.php";
session_start();

if (!isset($_SESSION['id'])) {
  header("Location: ./usuario/login.php");
  exit;
}

$user_id = $_SESSION['id'];

$user_name = $_SESSION['usuario'];

// Consultas para janeiro
$sql_receita_jan = "SELECT SUM(valor) AS total_receita_jan FROM receita WHERE id_do_usuario = :user_id AND data_mvto BETWEEN '2024-01-01' AND '2024-01-31'";
$stmt_receita_jan = $pdo->prepare($sql_receita_jan);
$stmt_receita_jan->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_receita_jan->execute();
$receita_jan = $stmt_receita_jan->fetch(PDO::FETCH_ASSOC);
$total_receita_jan = $receita_jan['total_receita_jan'] ?: 0;

$sql_despesa_jan = "SELECT SUM(valor) AS total_despesa_jan FROM despesa WHERE id_do_usuario = :user_id AND data_mvto BETWEEN '2024-01-01' AND '2024-01-31'";
$stmt_despesa_jan = $pdo->prepare($sql_despesa_jan);
$stmt_despesa_jan->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_despesa_jan->execute();
$despesa_jan = $stmt_despesa_jan->fetch(PDO::FETCH_ASSOC);
$total_despesa_jan = $despesa_jan['total_despesa_jan'] ?: 0;

// Consultas para fevereiro
$sql_receita_fev = "SELECT SUM(valor) AS total_receita_fev FROM receita WHERE id_do_usuario = :user_id AND data_mvto BETWEEN '2024-02-01' AND '2024-02-28'";
$stmt_receita_fev = $pdo->prepare($sql_receita_fev);
$stmt_receita_fev->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_receita_fev->execute();
$receita_fev = $stmt_receita_fev->fetch(PDO::FETCH_ASSOC);
$total_receita_fev = $receita_fev['total_receita_fev'] ?: 0;

$sql_despesa_fev = "SELECT SUM(valor) AS total_despesa_fev FROM despesa WHERE id_do_usuario = :user_id AND data_mvto BETWEEN '2024-02-01' AND '2024-02-28'";
$stmt_despesa_fev = $pdo->prepare($sql_despesa_fev);
$stmt_despesa_fev->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_despesa_fev->execute();
$despesa_fev = $stmt_despesa_fev->fetch(PDO::FETCH_ASSOC);
$total_despesa_fev = $despesa_fev['total_despesa_fev'] ?: 0;

// Consultas para Março
$sql_receita_mar = "SELECT SUM(valor) AS total_receita_mar FROM receita WHERE id_do_usuario = :user_id AND data_mvto BETWEEN '2024-03-01' AND '2024-03-31'";
$stmt_receita_mar = $pdo->prepare($sql_receita_mar);
$stmt_receita_mar->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_receita_mar->execute();
$receita_mar = $stmt_receita_mar->fetch(PDO::FETCH_ASSOC);
$total_receita_mar = $receita_mar['total_receita_mar'] ?: 0;

$sql_despesa_mar = "SELECT SUM(valor) AS total_despesa_mar FROM despesa WHERE id_do_usuario = :user_id AND data_mvto BETWEEN '2024-03-01' AND '2024-03-31'";
$stmt_despesa_mar = $pdo->prepare($sql_despesa_mar);
$stmt_despesa_mar->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_despesa_mar->execute();
$despesa_mar = $stmt_despesa_mar->fetch(PDO::FETCH_ASSOC);
$total_despesa_mar = $despesa_mar['total_despesa_mar'] ?: 0;

// Consultas para Abril
$sql_receita_abr = "SELECT SUM(valor) AS total_receita_abr FROM receita WHERE id_do_usuario = :user_id AND data_mvto BETWEEN '2024-04-01' AND '2024-04-31'";
$stmt_receita_abr = $pdo->prepare($sql_receita_abr);
$stmt_receita_abr->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_receita_abr->execute();
$receita_abr = $stmt_receita_abr->fetch(PDO::FETCH_ASSOC);
$total_receita_abr = $receita_abr['total_receita_abr'] ?: 0;

$sql_despesa_abr = "SELECT SUM(valor) AS total_despesa_abr FROM despesa WHERE id_do_usuario = :user_id AND data_mvto BETWEEN '2024-04-01' AND '2024-04-31'";
$stmt_despesa_abr = $pdo->prepare($sql_despesa_abr);
$stmt_despesa_abr->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_despesa_abr->execute();
$despesa_abr = $stmt_despesa_abr->fetch(PDO::FETCH_ASSOC);
$total_despesa_abr = $despesa_abr['total_despesa_abr'] ?: 0;

// Consultas para Maio
$sql_receita_mai = "SELECT SUM(valor) AS total_receita_mai FROM receita WHERE id_do_usuario = :user_id AND data_mvto BETWEEN '2024-05-01' AND '2024-05-31'";
$stmt_receita_mai = $pdo->prepare($sql_receita_mai);
$stmt_receita_mai->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_receita_mai->execute();
$receita_mai = $stmt_receita_mai->fetch(PDO::FETCH_ASSOC);
$total_receita_mai = $receita_mai['total_receita_mai'] ?: 0;

$sql_despesa_mai = "SELECT SUM(valor) AS total_despesa_mai FROM despesa WHERE id_do_usuario = :user_id AND data_mvto BETWEEN '2024-05-01' AND '2024-05-31'";
$stmt_despesa_mai = $pdo->prepare($sql_despesa_mai);
$stmt_despesa_mai->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_despesa_mai->execute();
$despesa_mai = $stmt_despesa_mai->fetch(PDO::FETCH_ASSOC);
$total_despesa_mai = $despesa_mai['total_despesa_mai'] ?: 0;
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Controle Financeiro</title>
  <link rel="stylesheet" href="./styles/style-grafico.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', { 'packages': ['corechart', 'bar'] });
    google.charts.setOnLoadCallback(drawStuff);

    function drawStuff() {

      var button = document.getElementById('change-chart');
      var chartDiv = document.getElementById('chart_div');

      var data = google.visualization.arrayToDataTable([
        ['Meses', 'Receita', 'Despesa'],
        ['Janeiro', <?= $total_receita_jan ?>, <?= $total_despesa_jan ?>],
        ['Fevereiro', <?= $total_receita_fev ?>, <?= $total_despesa_fev ?>],
        ['Março', <?= $total_receita_mar ?>, <?= $total_despesa_mar ?>],
        ['Abril', <?= $total_receita_abr ?>, <?= $total_despesa_abr ?>],
        ['Maio', <?= $total_receita_mai ?>, <?= $total_despesa_mai ?>]
      ]);

      var materialOptions = {
        width: 900,
        chart: {
          title: 'Controle Financeiro',
          subtitle: 'Receita à esquerda, Despesa à direita'
        },
        series: {
          0: { axis: 'Receita' },
          1: { axis: 'Despesa' }
        },
        axes: {
          y: {
            distance: { label: 'parsecs' },
            brightness: { side: 'Direita', label: 'Magnitude aparente' }
          }
        }
      };

      var classicOptions = {
        width: 900,
        series: {
          0: { targetAxisIndex: 0 },
          1: { targetAxisIndex: 1 }
        },
        title: 'Controle Financeiro - Receita à esquerda, Despesa à direita',
        vAxes: {
          0: { title: 'parsecs' },
          1: { title: 'Magnitude aparente' }
        }
      };

      function drawMaterialChart() {
        var materialChart = new google.charts.Bar(chartDiv);
        materialChart.draw(data, google.charts.Bar.convertOptions(materialOptions));
        button.innerText = 'Mudar para o Clássico';
        button.onclick = drawClassicChart;
      }

      function drawClassicChart() {
        var classicChart = new google.visualization.ColumnChart(chartDiv);
        classicChart.draw(data, classicOptions);
        button.innerText = 'Mudar para o Material';
        button.onclick = drawMaterialChart;
      }

      drawMaterialChart();
    };
  </script>
  <style>
    input,
    select,
    button {
    border-radius: 8px;
    width: auto;
    font-size: 18px;
    }
  </style>
<style>
    /* Estilo para centralizar o gráfico */
    body {
      display: relative;
      text-align: center;
      justify-content: center;
      align-items: center;
      margin: 0;
      height: 10vh;
      width: 100%;
      bottom: 0;
      }
  </style>
</head>

<body>
<header>
    <img src="./../Imagens/logo-finanç-branco.png" alt="">
        <div class="paginas">
            <ul>
                <li><a href="/Proz/receita/receita.php">Receitas</a></li>
                <li><a href="despesa/despesa.php">Despesas</a></li>
                <li><a href="categoria/categoria.php">Categorias</a></li>
                <li><a href="graficos.php">Controle Finaceiro</a></li>    
            </ul>
        </div>
</header>
<button id="change-chart">Mudar para o Clássico</button>
<br><br>
<div id="chart_div" style="width: 800px; height: 600px; margin: 0 auto;"></div>
  
  <footer>
        <p class="copy"><i class="bi bi-c-circle">Todos os direitos reservados.</i></p>
    </footer>

  <script src="https://kit.fontawesome.com/561265e797.js" crossorigin="anonymous"></script>
</body>

</html>