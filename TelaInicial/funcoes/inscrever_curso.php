<?php
session_start();
require_once '../../funcoes/conexao.php';

if (!isset($_SESSION['id']) || $_SESSION['tipo'] !== 'aluno') {
    header('Location: ../../cadastro_login/aluno/signin.php');
    exit;
}

$aluno_id = $_SESSION['id'];
$curso_id = $_POST['curso_id'] ?? null;

if (!$curso_id) {
    echo "ID do curso não informado.";
    exit;
}

// Verifica se já está inscrito
$stmt = $conexao->prepare("SELECT * FROM inscricoes WHERE aluno_id = ? AND curso_id = ?");
$stmt->bind_param("ii", $aluno_id, $curso_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Você já está inscrito neste curso.";
    exit;
}

// Inscreve o aluno
$stmt = $conexao->prepare("INSERT INTO inscricoes (aluno_id, curso_id, data_inscricao) VALUES (?, ?, NOW())");
$stmt->bind_param("ii", $aluno_id, $curso_id);

if ($stmt->execute()) {
    header("Location: ../cursos.php?msg=inscricao_sucesso");
    exit;
} else {
    echo "Erro ao se inscrever no curso.";
}
?>
