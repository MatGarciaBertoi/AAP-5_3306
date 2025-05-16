<?php
require_once '../../../funcoes/conexao.php';
session_start();

if (!isset($_SESSION['id']) || !isset($_POST['curso_id'])) {
    die("Acesso negado.");
}

$curso_id = (int) $_POST['curso_id'];
$titulo = trim($_POST['titulo']);
$conteudo = trim($_POST['conteudo']);
$video_url = trim($_POST['video_url']);

if (empty($titulo) || empty($conteudo) || empty($video_url)) {
    die("Todos os campos são obrigatórios.");
}

$sql = "INSERT INTO aulas (curso_id, titulo, conteudo, video_url) VALUES (?, ?, ?, ?)";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("isss", $curso_id, $titulo, $conteudo, $video_url);

if ($stmt->execute()) {
    header("Location: ../ver_conteudo_curso.php?id=$curso_id");
    exit();
} else {
    echo "Erro ao cadastrar aula: " . $stmt->error;
}
?>
