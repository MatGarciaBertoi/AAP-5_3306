<?php
session_start();
include_once('../../../funcoes/conexao.php');

if (!isset($_SESSION['id']) || $_SESSION['tipo'] !== 'aluno') {
    header('Location: ../cadastro_login/aluno/signin.php');
    exit();
}

$aluno_id = $_SESSION['id'];
$aula_id = isset($_POST['aula_id']) ? intval($_POST['aula_id']) : 0;

if ($aula_id <= 0) {
    die("ID da aula inválido.");
}

// Verifica se já existe um registro para essa aula e aluno
$stmt = $conexao->prepare("SELECT id FROM progresso_aula WHERE aluno_id = ? AND aula_id = ?");
$stmt->bind_param("ii", $aluno_id, $aula_id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    // Já existe: atualizar para concluída
    $stmt = $conexao->prepare("UPDATE progresso_aula SET concluida = 1, data_conclusao = NOW() WHERE aluno_id = ? AND aula_id = ?");
    $stmt->bind_param("ii", $aluno_id, $aula_id);
    $stmt->execute();
} else {
    // Não existe: inserir novo registro como concluído
    $stmt = $conexao->prepare("INSERT INTO progresso_aula (aluno_id, aula_id, concluida, data_conclusao) VALUES (?, ?, 1, NOW())");
    $stmt->bind_param("ii", $aluno_id, $aula_id);
    $stmt->execute();
}

// Redireciona de volta para a página do conteúdo do curso
// Como você não está passando o curso_id por POST, pode ser interessante armazená-lo como hidden input também.
header("Location: ../ver_conteudo.php?curso_id=" . (isset($_GET['curso_id']) ? intval($_GET['curso_id']) : ''));
exit();
