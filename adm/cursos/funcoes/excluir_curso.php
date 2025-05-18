<?php
session_start();
require_once '../../../funcoes/conexao.php';

// Verifica se está logado como administrador
if (!isset($_SESSION['id']) || $_SESSION['tipo'] !== 'administrador') {
    die("Acesso negado. Somente administradores podem realizar esta ação.");
}

// Verifica se o ID foi passado
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID do curso não fornecido.");
}

$curso_id = intval($_GET['id']);

// Primeiro, busca o caminho da imagem
$sql_select = "SELECT imagem FROM cursos WHERE id = ?";
$stmt_select = $conexao->prepare($sql_select);
$stmt_select->bind_param("i", $curso_id);
$stmt_select->execute();
$stmt_select->store_result();

if ($stmt_select->num_rows > 0) {
    $stmt_select->bind_result($imagem);
    $stmt_select->fetch();

    // Caminho completo para a imagem
    $caminho_imagem = '../../../' . $imagem;

    // Exclui a imagem, se existir
    if (!empty($imagem) && file_exists($caminho_imagem)) {
        unlink($caminho_imagem);
    }

    // Agora exclui o curso do banco
    $sql_delete = "DELETE FROM cursos WHERE id = ?";
    $stmt_delete = $conexao->prepare($sql_delete);
    $stmt_delete->bind_param("i", $curso_id);

    if ($stmt_delete->execute()) {
        header("Location: ../list_courses.php?sucesso=1");
        exit();
    } else {
        header("Location: ../list_courses.php?erro=1");
        exit();
    }
} else {
    // Curso não encontrado
    header("Location: ../list_courses.php?erro=1");
    exit();
}
?>
