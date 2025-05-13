<?php
session_start();
require_once '../../../funcoes/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomeCurso = trim($_POST['curso']);
    $titulo = trim($_POST['titulo']);
    $conteudo = trim($_POST['conteudo-aula']);
    $video = trim($_POST['video']);

    // Verifica se o curso existe e é do usuário
    $stmt = $conexao->prepare("SELECT id FROM cursos WHERE nome = ? AND criado_por_id = ? AND tipo_criador = ?");
    $stmt->bind_param("sis", $nomeCurso, $_SESSION['id'], $_SESSION['tipo']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['mensagem'] = "Curso não encontrado ou acesso negado.";
        $_SESSION['mensagem_tipo'] = "erro";
        header("Location: ../add_aula.php");
        exit;
    }

    $curso = $result->fetch_assoc();
    $curso_id = $curso['id'];

    // Inserir aula
    $stmt = $conexao->prepare("INSERT INTO aulas (curso_id, titulo, conteudo, video_url) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $curso_id, $titulo, $conteudo, $video);

    if ($stmt->execute()) {
        $_SESSION['mensagem'] = "Aula adicionada com sucesso!";
        $_SESSION['mensagem_tipo'] = "sucesso";
    } else {
        $_SESSION['mensagem'] = "Erro ao adicionar aula.";
        $_SESSION['mensagem_tipo'] = "erro";
    }

    header("Location: ../add_aula.php");
    exit;
}
?>
