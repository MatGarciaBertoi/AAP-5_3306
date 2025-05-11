<?php
session_start();
include_once('../../../funcoes/conexao.php');

if (!isset($_SESSION['id']) || $_SESSION['tipo'] !== 'aluno') {
    header('Location: ../cadastro_login/aluno/signin.php');
    exit();
}

$aluno_id = $_SESSION['id'];
$aula_id = intval($_POST['aula_id']);

// Insere ou atualiza progresso
$sql = "INSERT INTO progresso_aula (aluno_id, aula_id, concluida) 
        VALUES (?, ?, 1) 
        ON DUPLICATE KEY UPDATE concluida = 1, data_conclusao = CURRENT_TIMESTAMP";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("ii", $aluno_id, $aula_id);
$stmt->execute();

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();
