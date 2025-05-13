<?php
session_start();
require_once '../../../funcoes/conexao.php';

if (!isset($_SESSION['id']) || !isset($_SESSION['tipo'])) {
    die("Acesso negado.");
}

$aula_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Buscar aula para saber o curso_id
$sqlBusca = "SELECT curso_id FROM aulas WHERE id = ?";
$stmtBusca = $conexao->prepare($sqlBusca);
$stmtBusca->bind_param("i", $aula_id);
$stmtBusca->execute();
$result = $stmtBusca->get_result();
$aula = $result->fetch_assoc();

if (!$aula) {
    die("Aula não encontrada.");
}

$curso_id = $aula['curso_id'];

// Excluir aula
$sqlExcluir = "DELETE FROM aulas WHERE id = ?";
$stmtExcluir = $conexao->prepare($sqlExcluir);
$stmtExcluir->bind_param("i", $aula_id);

if ($stmtExcluir->execute()) {
    header("Location: ../ver_conteudo_curso.php?id=" . $curso_id);
    exit;
} else {
    echo "Erro ao excluir a aula.";
}
