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

// Buscar o ID do plano pelo nome
$sql_plano = "SELECT id FROM planos WHERE nome = ? AND ativo = 1";
$stmt = $conexao->prepare($sql_plano);
$stmt->bind_param("s", $plano_nome);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: ../assinar_plano.php?msg=erro_plano_invalido&plano=" . urlencode($plano_nome));
    exit;
}

$row = $result->fetch_assoc();
$plano_id = $row['id'];

// Expira assinatura anterior, se houver (atualiza para data atual)
$sql_expira = "UPDATE assinaturas 
               SET data_expiracao = NOW()
               WHERE aluno_id = ? AND (data_expiracao IS NULL OR data_expiracao > NOW())";
$stmt = $conexao->prepare($sql_expira);
$stmt->bind_param("i", $aluno_id);
$stmt->execute(); // mesmo que não exista, segue o fluxo

// Insere nova assinatura
$sql_insert_assinatura = "INSERT INTO assinaturas (aluno_id, plano_id, data_assinatura, data_expiracao) 
                          VALUES (?, ?, ?, ?)";
$stmt = $conexao->prepare($sql_insert_assinatura);
$stmt->bind_param("iiss", $aluno_id, $plano_id, $data_assinatura, $data_expiracao);

if (!$stmt->execute()) {
    header("Location: ../assinar_plano.php?msg=erro_ao_assinar&plano=" . urlencode($plano_nome));
    exit;
}

// Registra o pagamento
$sql_insert_pagamento = "INSERT INTO pagamentos (aluno_id, plano_id, nome, email, celular, cpf, forma_pagamento, data_pagamento) 
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conexao->prepare($sql_insert_pagamento);
$stmt->bind_param("iissssss", $aluno_id, $plano_id, $nome, $email, $celular, $cpf, $forma_pagamento, $data_assinatura);
$stmt->execute(); // pagamento não bloqueante

// Redireciona com sucesso
header("Location: ../meuplano.php?msg=assinatura_sucesso");
exit;
?>