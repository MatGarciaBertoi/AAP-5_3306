<?php
include_once('../../funcoes/conexao.php');

if (isset($_GET['email']) && isset($_GET['token'])) {
    $email = $_GET['email'];
    $token = $_GET['token'];

    $stmt = $conexao->prepare("SELECT * FROM usuarios WHERE email = ? AND token_ativacao = ?");
    $stmt->bind_param("ss", $email, $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $update = $conexao->prepare("UPDATE usuarios SET status = 'ativo', token_ativacao = NULL WHERE email = ?");
        $update->bind_param("s", $email);
        $update->execute();

        echo "<script>alert('Conta ativada com sucesso! Você já pode fazer login.'); window.location.href = 'signin.php';</script>";
    } else {
        echo "<script>alert('Link inválido ou expirado.'); window.location.href = 'signup.php';</script>";
    }

    $stmt->close();
    $conexao->close();
} else {
    echo "<script>alert('Parâmetros inválidos.'); window.location.href = 'signup.php';</script>";
}
