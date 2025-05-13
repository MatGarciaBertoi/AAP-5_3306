<?php
session_start();
require_once '../../../funcoes/conexao.php';

if (!isset($_POST['id'], $_POST['curso_id'], $_POST['titulo'], $_POST['tipo'], $_POST['descricao'])) {
    die("Dados incompletos.");
}

$id = (int) $_POST['id'];
$curso_id = (int) $_POST['curso_id'];
$titulo = trim($_POST['titulo']);
$tipo = trim($_POST['tipo']);
$descricao = trim($_POST['descricao']);

$sql = "UPDATE avaliacoes SET titulo = ?, tipo = ?, descricao = ? WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("sssi", $titulo, $tipo, $descricao, $id);

if ($stmt->execute()) {
    header("Location: ../ver_conteudo.php?id=" . $curso_id);
    exit;
} else {
    echo "Erro ao atualizar avaliação: " . $conexao->error;
}
