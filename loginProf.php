<?php
session_start(); // Inicia a sessão
include_once('config.php'); // Inclui o arquivo de configuração

// Verifica se o formulário foi submetido
if (isset($_POST['submit'])) {
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verifica se o e-mail termina com "@cwprof.com"
    if (!preg_match("/@cwprof\.com$/", $email)) {
        echo "<script>alert('E-mail inválido. Use um e-mail com o domínio @cwprof.com.');</script>";
        exit();
    }

    // Prepara a consulta para verificar o usuário, o e-mail e o tipo "professor"
    $loginQuery = "SELECT * FROM usuarios WHERE usuario = ? AND email = ? AND tipo = 'professor'";
    $stmt = $conexao->prepare($loginQuery);
    $stmt->bind_param("ss", $usuario, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se o usuário foi encontrado
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifica se a senha está correta
        if (password_verify($senha, $user['senha'])) {
            $_SESSION['usuario'] = $user['usuario'];
            header('Location: Painel professor/index.html'); // Redireciona para o painel do professor
            exit();
        } else {
            echo "<script>alert('Senha incorreta!');</script>";
        }
    } else {
        echo "<script>alert('Usuário, e-mail ou tipo de conta incorretos!');</script>";
    }

    // Fecha a conexão
    $stmt->close();
    $conexao->close();
}
?>
