<?php
// responderTicket.php

// Permite resposta JSON
header('Content-Type: application/json');

// Inclui a conexão com o banco
$conexao = require_once '../../funcoes/conexao.php';

// Pega os dados enviados via POST
$ticketId = $_POST['ticketId'] ?? null;
$resposta = $_POST['resposta'] ?? null;

if (!$ticketId || !$resposta) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Dados incompletos']);
    exit;
}

// Buscar e-mail e nome do dono do ticket
$stmtEmail = $conexao->prepare("SELECT email, nome FROM tickets WHERE id = ?");
$stmtEmail->bind_param("i", $ticketId);
$stmtEmail->execute();
$stmtEmail->bind_result($emailCliente, $nomeCliente);
$stmtEmail->fetch();
$stmtEmail->close();

// Insere a resposta na tabela de respostas
$stmt = $conexao->prepare("INSERT INTO respostas_tickets (ticket_id, resposta) VALUES (?, ?)");
$stmt->bind_param("is", $ticketId, $resposta);

if ($stmt->execute()) {
    // Atualizar o status do ticket para "Fechado"
    $update = $conexao->prepare("UPDATE tickets SET status = 'Fechado' WHERE id = ?");
    $update->bind_param("i", $ticketId);
    $update->execute();
    $update->close();

    // Enviar e-mail simples de notificação
    if ($emailCliente) {
        $assunto = "Resposta ao seu ticket de suporte";
        $mensagemEmail = "Olá {$nomeCliente},\n\nSua dúvida foi respondida! Confira no painel de suporte.\n\nResposta enviada:\n{$resposta}\n\nAtenciosamente,\nEquipe de Suporte.";
        $headers = "From: suporte@seudominio.com\r\n" .
                   "Reply-To: suporte@seudominio.com\r\n" .
                   "Content-Type: text/plain; charset=UTF-8\r\n";

        @mail($emailCliente, $assunto, $mensagemEmail, $headers);
    }

    echo json_encode(['status' => 'sucesso', 'mensagem' => 'Resposta enviada, ticket fechado e cliente notificado!']);
} else {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao enviar resposta.']);
}

$stmt->close();
$conexao->close();
?>