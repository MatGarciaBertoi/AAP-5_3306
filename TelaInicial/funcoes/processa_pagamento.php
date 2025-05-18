<?php
include_once('../../funcoes/sessoes/check_aluno.php');
require_once '../../funcoes/conexao.php';

$aluno_id = $_SESSION['id'];
$plano = $_POST['plano'] ?? '';
$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$celular = $_POST['celular'] ?? '';
$cpf = $_POST['cpf'] ?? '';
$forma_pagamento = $_POST['forma_pagamento'] ?? '';

// Simulando duração da assinatura (30 dias, por exemplo)
$data_assinatura = date('Y-m-d H:i:s');
$data_expiracao = date('Y-m-d H:i:s', strtotime('+30 days'));

// Validação básica
if (!$plano || !$nome || !$email || !$celular || !$cpf || !$forma_pagamento) {
    header("Location: ../assinar_plano.php?msg=campos_obrigatorios&plano=" . urlencode($plano));
    exit;
}

// Verifica se já existe uma assinatura ativa
$sql_check = "SELECT * FROM assinaturas 
              WHERE aluno_id = ? 
              AND (data_expiracao IS NULL OR data_expiracao >= NOW())";
$stmt = $conexao->prepare($sql_check);
$stmt->bind_param("i", $aluno_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    header("Location: ../assinar_plano.php?msg=assinatura_existente&plano=" . urlencode($plano));
    exit;
}

// Insere a nova assinatura
$sql_insert = "INSERT INTO assinaturas (aluno_id, plano, data_assinatura, data_expiracao) 
               VALUES (?, ?, ?, ?)";
$stmt = $conexao->prepare($sql_insert);
$stmt->bind_param("isss", $aluno_id, $plano, $data_assinatura, $data_expiracao);

if ($stmt->execute()) {
    header("Location: ../cursos.php?msg=assinatura_sucesso");
    exit;
} else {
    header("Location: ../assinar_plano.php?msg=erro_ao_assinar&plano=" . urlencode($plano));
    exit;
}
?>
