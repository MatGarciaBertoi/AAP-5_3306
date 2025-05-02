<?php
session_start(); // Inicia a sessão
include_once('config.php'); // Inclui o arquivo de configuração

// Verifica se o formulário foi submetido
if (isset($_POST['submit'])) {
    $usuario = $_POST['usuario']; // Nome de usuário
    $email = $_POST['email']; // Email
    $senha = $_POST['senha'];

    // Verifica se o e-mail termina com "@cwadm.com" ou "@cwprof.com"
    if (preg_match("/@(cwadm|cwprof)\.com$/", $email)) {
        echo "<script>alert('E-mail não permitido para acesso.');</script>";
        exit();
    }

    // Prepara a consulta para verificar o usuário, o e-mail e o tipo "aluno"
    $loginQuery = "SELECT * FROM usuarios WHERE usuario = ? AND email = ? AND tipo = 'aluno'";
    $stmt = $conexao->prepare($loginQuery);
    $stmt->bind_param("ss", $usuario, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se o usuário foi encontrado
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifica se a senha está correta
        if (password_verify($senha, $user['senha'])) {
            $_SESSION['usuario'] = $user['usuario']; // Define a sessão do usuário
            header('Location: profile.php'); // Redireciona para o perfil do aluno
            exit();
        } else {
            echo "<script>alert('Senha incorreta!'); window.location.href = 'signin.html';</script>";
        }
    } else {
        echo "<script>alert('Usuário, e-mail ou tipo de conta incorretos!'); window.location.href = 'signin.html';</script>";
    }

    // Fecha a conexão
    $stmt->close();
    $conexao->close();
}
?>
