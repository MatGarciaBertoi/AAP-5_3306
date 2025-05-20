<?php
session_start();
include_once('../../funcoes/conexao.php');

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {

    $login = $_POST['login'];
    $senha = $_POST['senha'];

    $query = "SELECT * FROM usuarios WHERE usuario = ? OR email = ?";
    $stmt = $conexao->prepare($query);
    $stmt->bind_param("ss", $login, $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($senha, $user['senha'])) {
            // Verifica o status da conta
            if ($user['status'] === 'bloqueado') {
                $mensagemErro = "Sua conta está bloqueada. Por favor, entre em contato com o suporte.";
            } elseif ($user['status'] === 'pendente') {
                $mensagemErro = "Sua conta ainda não foi ativada. Verifique seu e-mail e clique no link de ativação.";
            } elseif ($user['status'] === 'ativo') {
                // Login bem-sucedido
                $_SESSION['id'] = $user['id'];
                $_SESSION['nome'] = $user['nome'];
                $_SESSION['usuario'] = $user['usuario'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['tipo'] = $user['tipo'];
                $_SESSION['status'] = $user['status'];

                // Redirecionamento conforme o tipo
                if ($user['tipo'] === 'administrador') {
                    header("Location: http://localhost/AAP-5_3306/administrador/index.php");
                    exit;
                } elseif ($user['tipo'] === 'professor') {
                    header("Location: http://localhost/AAP-5_3306/professor/index.php");
                    exit;
                } elseif ($user['tipo'] === 'aluno') {
                    header("Location: http://localhost/AAP-5_3306/TelaInicial/index.php");
                    exit;
                } else {
                    $mensagemErro = "Tipo de usuário desconhecido.";
                }
            } else {
                $mensagemErro = "Status de conta inválido.";
            }
        } else {
            $mensagemErro = "Senha incorreta.";
        }
    } else {
        $mensagemErro = "Usuário ou e-mail não encontrados.";
    }

    $stmt->close();
    $conexao->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="../../images/logotipocw.png" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="signin.css">
<link rel="stylesheet" href="partials/style.css">
<title>Sign-in</title>
</head>

<body>
    <div class="header-main">
        <?php include 'partials/header.php'; ?> <!-- Inclui o header -->
    </div>
    <!-- Container principal -->
    <div class="container">
        <main class="container-main">
            <div class="card-image">
                <img src="../../images/homem-mulher-discutindo2.png" alt="Mulher de oculos sorrindo">
            </div>
            <div class="container-card">
                <div class="card">
                    <h1>Entrar</h1> <!-- Título do formulário -->
                    <form action="" method="POST"> <!-- Formulário de login -->

                        <!-- Campo de usuário com label flutuante -->
                        <div class="label-float">
                            <input type="text" name="login" id="login" required />
                            <label for="login">Usuário ou E-mail</label>
                        </div>

                        <!-- Campo de senha com label flutuante -->
                        <div class="label-float">
                            <input type="password" name="senha" id="senha" placeholder=" " maxlength="15" required />
                            <label id="senhaLabel" for="senha">Senha</label>
                            <span class="mostrar-senha" onclick="toggleSenha('senha', this)">
                                <i class="bi bi-eye" aria-hidden="true"></i>
                            </span> <!-- Ícone de olho -->
                        </div>

                        <!-- Campo de esqueci a senha com link para a página de recuperar a senha -->
                        <div class="esqueci-group">
                            <div class="esqueci">
                                <a href="../recuperar_senha.php">Esqueci minha senha</a>
                            </div>
                        </div>

                        <!-- Mensagem de erro -->
                        <div id="msgError">
                            <?php if (!empty($mensagemErro)) : ?>
                                <p class="erro"><?php echo $mensagemErro; ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Botão de submit centralizado -->
                        <div class="justify-center">
                            <input class="inputSubmit" type="submit" name="submit" value="Entrar">
                        </div>
                    </form>
                    <div class="signup-button">
                        <!-- Link para a página de cadastro -->
                        <p>Não tem uma conta? <a href="signup.php">Cadastre-se</a></p>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <?php include 'partials/footer.php'; ?> <!-- Inclui o footer -->
    <script>
        function toggleSenha(id, el) {
            const input = document.getElementById(id);
            const icon = el.querySelector('i');

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            }
        }

        // Aguarda o DOM carregar
        document.addEventListener("DOMContentLoaded", function() {
            const msgError = document.querySelector("#msgError .erro");

            if (msgError) {
                // Aplica efeito de fade-in
                msgError.style.opacity = 0;
                msgError.style.transition = "opacity 0.5s ease-in-out";
                setTimeout(() => {
                    msgError.style.opacity = 1;
                }, 100);

                // Depois de 4 segundos, aplica fade-out e remove do DOM
                setTimeout(() => {
                    msgError.style.opacity = 0;
                    setTimeout(() => {
                        msgError.remove();
                    }, 500); // Tempo do fade-out
                }, 4000); // Tempo de exibição antes de sumir
            }
        });
    </script>
</body>

</html>