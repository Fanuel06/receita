<?php
require "../config.php";
session_start();

if (!isset($_SESSION['id'])) {
  header("Location: ../usuario/login.php");
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
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Controle Financeiro</title>
  <link rel="stylesheet" href="style.css">
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
        ['Março', 30000, 30000],
        ['Abril', 50000, 50000],
        ['Maio', 60000, 60000]
      ]);

      var materialOptions = {
        width: 900,
        chart: {
          title: 'Controle Financeiro',
          subtitle: 'distância à esquerda, brilho à direita'
        },
        series: {
          0: { axis: 'dist' },
          1: { axis: 'brightness' }
        },
        axes: {
          y: {
            distance: { label: 'parsecs' },
            brightness: { side: 'right', label: 'apparent magnitude' }
          }
        }
      };

      var classicOptions = {
        width: 900,
        series: {
          0: { targetAxisIndex: 0 },
          1: { targetAxisIndex: 1 }
        },
        title: 'Controle Financeiro - distância à esquerda, brilho à direita',
        vAxes: {
          0: { title: 'parsecs' },
          1: { title: 'apparent magnitude' }
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
</head>

<body>

  <button id="change-chart">Mudar para o Clássico</button>
  <br><br>
  <div id="chart_div" style="width: 800px; height: 500px;"></div>
</body>

</html>