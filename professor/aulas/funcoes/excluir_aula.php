<?php
session_start();
require_once '../../../funcoes/conexao.php';

if (!isset($_SESSION['id'], $_SESSION['tipo'])) {
    $_SESSION['mensagem'] = 'Você precisa estar logado para acessar esta página.';
    $_SESSION['mensagem_tipo'] = 'erro';
    header('Location: ../../login.php');
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['mensagem'] = 'Aula inválida.';
    $_SESSION['mensagem_tipo'] = 'erro';
    header('Location: ../minhas_aulas.php');
    exit;
}

$id_aula = $_GET['id'];

// Verifica se a aula pertence ao usuário
$sql = "
    SELECT a.id FROM aulas a
    JOIN cursos c ON a.curso_id = c.id
    WHERE a.id = ? AND c.criado_por_id = ? AND c.tipo_criador = ?
";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("iis", $id_aula, $_SESSION['id'], $_SESSION['tipo']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['mensagem'] = 'Aula não encontrada ou acesso negado.';
    $_SESSION['mensagem_tipo'] = 'erro';
    header('Location: ../minhas_aulas.php');
    exit;
}

// Excluir aula
$delete = $conexao->prepare("DELETE FROM aulas WHERE id = ?");
$delete->bind_param("i", $id_aula);

if ($delete->execute()) {
    $_SESSION['mensagem'] = 'Aula excluída com sucesso.';
    $_SESSION['mensagem_tipo'] = 'sucesso';
} else {
    $_SESSION['mensagem'] = 'Erro ao excluir aula.';
    $_SESSION['mensagem_tipo'] = 'erro';
}

header('Location: ../minhas_aulas.php');
exit;
?>
