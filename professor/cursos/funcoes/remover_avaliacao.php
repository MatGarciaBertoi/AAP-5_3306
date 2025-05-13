<?php
session_start();
require_once '../../../funcoes/conexao.php';

if (!isset($_SESSION['id']) || !isset($_GET['id'])) {
    die("Acesso negado.");
}

$id = (int) $_GET['id'];

// Pegando o curso_id antes de excluir (para redirecionamento correto)
$stmt = $conexao->prepare("SELECT curso_id FROM avaliacoes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$avaliacao = $result->fetch_assoc();

if (!$avaliacao) {
    die("Avaliação não encontrada.");
}

$curso_id = $avaliacao['curso_id'];

$sql = "DELETE FROM avaliacoes WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: ../ver_conteudo_curso.php?id=$curso_id");
exit;
