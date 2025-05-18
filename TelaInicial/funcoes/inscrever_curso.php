<?php
include_once('../../funcoes/sessoes/check_aluno.php');
require_once '../../funcoes/conexao.php';

$aluno_id = $_SESSION['id'];
$curso_id = $_POST['curso_id'] ?? null;

if (!$curso_id) {
    header("Location: ../detalhes_curso.php?curso_id=$curso_id&erro=ID do curso não informado.");
    exit;
}

// Verifica se o aluno possui uma assinatura válida (ativa)
$sql_verifica_assinatura = "
    SELECT * FROM assinaturas 
    WHERE aluno_id = ? 
    AND (data_expiracao IS NULL OR data_expiracao >= NOW())
";
$stmt = $conexao->prepare($sql_verifica_assinatura);
$stmt->bind_param("i", $aluno_id);
$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows === 0) {
    header("Location: ../detalhes_curso.php?curso_id=$curso_id&erro=Você precisa ter uma assinatura ativa para se inscrever em um curso.");
    exit;
}

// Verifica se já está inscrito
$stmt = $conexao->prepare("SELECT * FROM inscricoes WHERE aluno_id = ? AND curso_id = ?");
$stmt->bind_param("ii", $aluno_id, $curso_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    header("Location: ../detalhes_curso.php?curso_id=$curso_id&erro=Você já está inscrito neste curso.");
    exit;
}

// Inscreve o aluno
$stmt = $conexao->prepare("INSERT INTO inscricoes (aluno_id, curso_id, data_inscricao) VALUES (?, ?, NOW())");
$stmt->bind_param("ii", $aluno_id, $curso_id);

if ($stmt->execute()) {
    header("Location: ../detalhes_curso.php?curso_id=$curso_id&sucesso=Inscrição realizada com sucesso!");
    exit;
} else {
    header("Location: ../detalhes_curso.php?curso_id=$curso_id&erro=Erro ao se inscrever no curso.");
    exit;
}
?>
