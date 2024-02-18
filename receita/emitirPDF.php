<?php
require "../config.php";
require_once '../vendor/autoload.php';

use Dompdf\Dompdf;

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../usuario/login.php");
    exit;
}

$user_id = $_SESSION['id'];

$user_name = $_SESSION['usuario'];

$sql_receita = "SELECT * FROM receita WHERE id_do_usuario = :user_id";
$stmt_receita = $pdo->prepare($sql_receita);
$stmt_receita->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_receita->execute();
$dados = $stmt_receita->fetchAll(PDO::FETCH_ASSOC);

// Inicializar o DomPDF
$dompdf = new Dompdf();

// Construir o HTML do relatório
$html = '<!DOCTYPE html>';
$html .= '<html lang="pt-BR">';
$html .= '<head><meta charset="UTF-8"><title>Relatório de Receitas</title>';
$html .= '<style>';
$html .= 'body { font-family: Arial, sans-serif; }';
$html .= 'h1 { text-align: center; margin-bottom: 20px; }';
$html .= 'table { width: 100%; border-collapse: collapse; }';
$html .= 'th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }';
$html .= 'th { background-color: #f2f2f2; }';
$html .= 'tr:nth-child(even) { background-color: #f2f2f2; }';
$html .= 'tr:hover { background-color: #ddd; }';
$html .= '</style>';
$html .= '</head>';
$html .= '<body>';
$html .= '<h1>Relatório de Receitas</h1>';
$html .= '<table>';
$html .= '<thead><tr><th>Número</th><th>Descrição</th><th>Valor</th><th>Status</th><th>Data</th></tr></thead>';
$html .= '<tbody>';
$numero = 1;
foreach ($dados as $dado) {
    $html .= '<tr>';
    $html .= '<td>' . $numero++ . '</td>';
    $html .= '<td>' . $dado['descricao'] . '</td>';
    $html .= '<td>' . $dado['valor'] . '</td>';
    $html .= '<td>' . $dado['status_pago'] . '</td>';
    $html .= '<td>' . $dado['data_mvto'] . '</td>';
    $html .= '</tr>';
}
$html .= '</tbody></table>';
$html .= '</body></html>';

// Carregar o HTML no DomPDF
$dompdf->loadHtml($html);

// Definir opções de renderização (opcional)
$dompdf->setPaper('A4', 'portrait');

// Renderizar o PDF
$dompdf->render();

// Saída do PDF para o navegador
$dompdf->stream('relatorio_receitas.pdf', array('Attachment' => 0));
?>