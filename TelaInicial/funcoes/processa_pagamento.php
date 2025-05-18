<?php
include_once('../../funcoes/sessoes/check_aluno.php');
require_once '../../funcoes/conexao.php';

$aluno_id = $_SESSION['id'];
$plano_nome = $_POST['plano'] ?? '';
$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$celular = $_POST['celular'] ?? '';
$cpf = $_POST['cpf'] ?? '';
$forma_pagamento = $_POST['forma_pagamento'] ?? '';

$data_assinatura = date('Y-m-d H:i:s');
$data_expiracao = date('Y-m-d H:i:s', strtotime('+30 days'));

// Validação básica
if (!$plano_nome || !$nome || !$email || !$celular || !$cpf || !$forma_pagamento) {
    header("Location: ../assinar_plano.php?msg=campos_obrigatorios&plano=" . urlencode($plano_nome));
    exit;
}

// Busca o ID do plano pelo nome
$sql_plano = "SELECT id FROM planos WHERE nome = ? AND ativo = 1";
$stmt = $conexao->prepare($sql_plano);
$stmt->bind_param("s", $plano_nome);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: ../assinar_plano.php?msg=erro_ao_assinar&plano=" . urlencode($plano_nome));
    exit;
}

$row = $result->fetch_assoc();
$plano_id = $row['id'];

// Verifica se já existe uma assinatura ativa
$sql_check = "SELECT * FROM assinaturas 
              WHERE aluno_id = ? 
              AND (data_expiracao IS NULL OR data_expiracao >= NOW())";
$stmt = $conexao->prepare($sql_check);
$stmt->bind_param("i", $aluno_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    header("Location: ../assinar_plano.php?msg=assinatura_existente&plano=" . urlencode($plano_nome));
    exit;
}

// Insere a nova assinatura com plano_id
$sql_insert_assinatura = "INSERT INTO assinaturas (aluno_id, plano_id, data_assinatura, data_expiracao) 
                          VALUES (?, ?, ?, ?)";
$stmt = $conexao->prepare($sql_insert_assinatura);
$stmt->bind_param("iiss", $aluno_id, $plano_id, $data_assinatura, $data_expiracao);

if (!$stmt->execute()) {
    header("Location: ../assinar_plano.php?msg=erro_ao_assinar&plano=" . urlencode($plano_nome));
    exit;
}

// Insere o pagamento com o plano_id
$sql_insert_pagamento = "INSERT INTO pagamentos (aluno_id, plano_id, nome, email, celular, cpf, forma_pagamento, data_pagamento) 
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conexao->prepare($sql_insert_pagamento);
$stmt->bind_param("iissssss", $aluno_id, $plano_id, $nome, $email, $celular, $cpf, $forma_pagamento, $data_assinatura);
$stmt->execute(); // Pagamento não é bloqueante

// Redireciona com sucesso
header("Location: ../cursos.php?msg=assinatura_sucesso");
exit;
?>
