<?php
// Verifica se o formulário foi enviado
if (isset($_POST['SendRecupSenha'])) {
    if (isset($_POST["email"])) {
        $email = $_POST["email"];

        // Gera um token aleatório seguro
        $token = bin2hex(random_bytes(16));

        // Cria o hash do token para salvar no banco de dados
        $token_hash = hash("sha256", $token);

        // Define o tempo de expiração do token (30 minutos a partir de agora)
        $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

        // Inclui o arquivo de conexão
        $conexao = require __DIR__ . "/../funcoes/conexao.php";

        // Prepara e executa o UPDATE para salvar o token e a expiração
        $sql = "UPDATE usuarios 
                SET reset_token_hash = ?, reset_token_expires_at = ?
                WHERE email = ?";
        
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("sss", $token_hash, $expiry, $email);
        $stmt->execute();

        // Verifica se algum registro foi atualizado (ou seja, se o e-mail existe)
        if ($conexao->affected_rows) {
            // Carrega e configura o PHPMailer
            $mail = require __DIR__ . "/../lib/phpmailer/mailer.php";

            $mail->setFrom("cwcursos21@gmail.com"); // Remetente
            $mail->addAddress($email);              // Destinatário
            $mail->Subject = "CW Cursos - Alterar Senha"; // Assunto do email

            // Cria o link com o token
            $link = "http://localhost/AAP-CW_Cursos/cadastro_login/redefinir_senha.php?token=$token";

            // Corpo do e-mail com o link de recuperação
            $mail->Body = <<<END
Clique <a href="$link">aqui</a> para redefinir sua senha.<br>
Esse link é válido por 30 minutos.
END;

            // Tenta enviar o e-mail
            try {
                $mail->send();
                echo "E-mail enviado com sucesso! Verifique sua caixa de entrada.";
            } catch (Exception $e) {
                echo "Erro ao enviar o e-mail: {$mail->ErrorInfo}";
            }
        } else {
            echo "E-mail não encontrado em nossa base de dados.";
        }

        $stmt->close();
    } else {
        echo "Por favor, forneça um endereço de e-mail.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha - CW Cursos</title>
    <link rel="shortcut icon" href="../images/logotipocw.png" />
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="back-button">
        <a href="aluno/signin.php"><i class="bi bi-arrow-left-circle"></i></a>
    </div>

    <div class="container">
        <div class="card">
            <h1>Recuperar Senha</h1>
            <p>Informe o e-mail cadastrado e enviaremos um link para redefinição de senha.</p>
            <form action="recuperar_senha.php" method="POST">
                <div id="msgError"></div>

                <div class="label-float">
                    <input type="email" name="email" required autofocus>
                    <label for="email">E-mail</label>
                </div>

                <div class="justify-center">
                    <input class="inputSubmit" type="submit" name="SendRecupSenha" value="Enviar link para alteração">
                </div>
            </form>
        </div>
    </div>
</body>

</html>
