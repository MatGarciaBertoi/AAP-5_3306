<?php
session_start();
include_once('../../funcoes/conexao.php');

if (!isset($_SESSION['id']) || $_SESSION['tipo'] !== 'aluno') {
    header('Location: ../../cadastro_login/usuario/signin.php');
    exit;
}

// Verificar campos obrigatórios
if (empty($_POST['nome']) || empty($_POST['email']) || empty($_POST['cpf']) || empty($_POST['celular']) || empty($_POST['forma_pagamento']) || empty($_POST['plano'])) {
    header('Location: ../assinar_plano.php?msg=campos_obrigatorios');
    exit;
}

// Captura os dados do formulário
$aluno_id = $_SESSION['id'];
$plano = $_POST['plano'];
$data_assinatura = date('Y-m-d H:i:s');

// Definindo a expiração para 30 dias depois da assinatura (opcional)
$data_expiracao = date('Y-m-d H:i:s', strtotime('+30 days'));

// Verifica se o aluno já tem uma assinatura
$sqlCheck = "SELECT id FROM assinaturas WHERE aluno_id = ?";
$stmtCheck = $conexao->prepare($sqlCheck);
$stmtCheck->bind_param("i", $aluno_id);
$stmtCheck->execute();
$result = $stmtCheck->get_result();

if ($result->num_rows > 0) {
    // Já tem assinatura, atualizar
    $row = $result->fetch_assoc();
    $assinatura_id = $row['id'];

    $sqlUpdate = "UPDATE assinaturas SET plano = ?, data_assinatura = ?, data_expiracao = ? WHERE id = ?";
    $stmtUpdate = $conexao->prepare($sqlUpdate);
    $stmtUpdate->bind_param("sssi", $plano, $data_assinatura, $data_expiracao, $assinatura_id);

    if ($stmtUpdate->execute()) {
        header('Location: ../meuplano.php');
        exit;
    } else {
        header('Location: ../assinar_plano.php?msg=erro_ao_assinar');
        exit;
    }

} else {
    // Não tem assinatura, inserir nova
    $sqlInsert = "INSERT INTO assinaturas (aluno_id, plano, data_assinatura, data_expiracao) VALUES (?, ?, ?, ?)";
    $stmtInsert = $conexao->prepare($sqlInsert);
    $stmtInsert->bind_param("isss", $aluno_id, $plano, $data_assinatura, $data_expiracao);

    if ($stmtInsert->execute()) {
        header('Location: ../meuplano.php');
        exit;
    } else {
        header('Location: ../assinar_plano.php?msg=erro_ao_assinar');
        exit;
    }
}
?>
