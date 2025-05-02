<?php
session_start();
require_once '../../../funcoes/conexao.php';

if (!isset($_SESSION['id'], $_SESSION['tipo'], $_GET['id'])) {
  die("Acesso negado.");
}

$id_usuario = $_SESSION['id'];
$tipo_usuario = $_SESSION['tipo'];
$id_curso = (int) $_GET['id'];

// Verificar se o curso pertence ao usuário
$sql = "SELECT imagem FROM cursos WHERE id = ? AND criado_por_id = ? AND tipo_criador = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("iis", $id_curso, $id_usuario, $tipo_usuario);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
  $_SESSION['mensagem'] = 'Curso não encontrado ou acesso negado.';
  $_SESSION['mensagem_tipo'] = 'erro';
  header('Location: ../meus_cursos.php');
  exit;
}

$curso = $res->fetch_assoc();
$imagem = $curso['imagem'];

// Deleta o curso
$stmt = $conexao->prepare("DELETE FROM cursos WHERE id = ?");
$stmt->bind_param("i", $id_curso);
$stmt->execute();

// Remove a imagem do servidor
$caminho_imagem = "uploads/" . $imagem;
if (file_exists($caminho_imagem)) {
  unlink($caminho_imagem);
}

$_SESSION['mensagem'] = 'Curso excluído com sucesso.';
$_SESSION['mensagem_tipo'] = 'sucesso';
header('Location: ../meus_cursos.php');
exit;
