<?php
require '../../funcoes/conexao.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de formulário inválido.");
}

$id = (int) $_GET['id'];

$sql = "SELECT * FROM formularios WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    die("Formulário não encontrado.");
}

$formulario = $resultado->fetch_assoc();

// Definir headers para download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="formulario_' . $id . '.csv"');

$output = fopen('php://output', 'w');

// Cabeçalhos (exceto id e usuario_id)
$cabecalhos = [];
$valores = [];

foreach ($formulario as $campo => $valor) {
    if ($campo === 'id' || $campo === 'usuario_id') continue;
    $cabecalhos[] = ucfirst(str_replace("_", " ", $campo));
    $valores[] = $valor;
}

// Escreve no CSV
fputcsv($output, $cabecalhos);
fputcsv($output, $valores);

fclose($output);
$stmt->close();
$conexao->close();
exit;
