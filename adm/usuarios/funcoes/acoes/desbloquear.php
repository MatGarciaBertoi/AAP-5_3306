<?php
include '../../../../funcoes/conexao.php';
$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $conexao->prepare("UPDATE usuarios SET status = 'ativo' WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: {$_SERVER['HTTP_REFERER']}");
exit;