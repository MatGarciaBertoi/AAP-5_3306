<?php
session_start();
require_once '../../../funcoes/conexao.php';

if (!isset($_SESSION['id']) || $_SESSION['tipo'] !== 'professor') {
    die("Acesso negado.");
}

$questao_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$sql = "SELECT avaliacao_id FROM questoes WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $questao_id);
$stmt->execute();
$result = $stmt->get_result();
$questao = $result->fetch_assoc();

if (!$questao) {
    die("Questão não encontrada.");
}

$avaliacao_id = $questao['avaliacao_id'];

// Remover a questão
$sqlDelete = "DELETE FROM questoes WHERE id = ?";
$stmtDelete = $conexao->prepare($sqlDelete);
$stmtDelete->bind_param("i", $questao_id);
$stmtDelete->execute();

header("Location: ../ver_questoes.php?avaliacao_id=$avaliacao_id");
exit;
