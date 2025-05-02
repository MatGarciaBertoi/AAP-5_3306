<?php
// Verifica se o formulário foi submetido
if (isset($_POST['submit'])) {
    include_once('../../funcoes/conexao.php'); // Inclui o arquivo de configuração

    // Obtém os dados do formulário
    $nome = $_POST['nome'];
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confisenha = $_POST['confirmSenha'];
    $dataNascimento = $_POST['dataNascimento']; // Nova variável para a data de nascimento

    // Verifica se as senhas coincidem
    if ($senha !== $confisenha) {
        echo "<script>alert('As senhas não coincidem!');</script>";
        exit;
    }

    // Verifica se o usuário ou e-mail já estão cadastrados
    $checkQuery = "SELECT usuario, email FROM usuarios WHERE usuario = ? OR email = ?";
    $stmt = $conexao->prepare($checkQuery);
    $stmt->bind_param("ss", $usuario, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Se o nome de usuário já existe, exibe uma mensagem de erro
        $existing = $result->fetch_assoc();
        if ($existing['usuario'] === $usuario) {
            echo "<script>alert('O nome de usuário já existe. Escolha outro.');</script>";
        } else {
            echo "<script>alert('O e-mail já está em uso. Use outro.');</script>";
        }
        exit;
    }

    // Hash da senha para segurança
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Insere os dados no banco de dados
    $insertQuery = "INSERT INTO usuarios (nome, usuario, email, senha, data_nascimento, tipo, status) VALUES (?, ?, ?, ?, ?, 'aluno', 'ativo')";
    $stmt = $conexao->prepare($insertQuery);
    $stmt->bind_param("sssss", $nome, $usuario, $email, $senhaHash, $dataNascimento);

    if ($stmt->execute()) {
        // Aguarda um momento para garantir que o banco de dados seja atualizado corretamente
        sleep(1); // Adiciona uma pequena pausa para garantir a atualização do banco

        // Exibe mensagem de sucesso e redireciona para home.html
        echo "<script>
                    alert('Usuário cadastrado com sucesso!');
                    window.location.href = 'http://localhost/AAP-CW_Cursos/TelaInicial/index.php';
                    </script>";
    } else {
        echo "<script>alert('Erro ao cadastrar o usuário.');</script>";
    }

    // Fecha as conexões
    $stmt->close();
    $conexao->close();
}
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="shortcut icon" href="../../images/logotipocw.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="signup.css">
    <link rel="stylesheet" href="partials/style.css">
</head>

<body>
    <div class="header-main">
        <?php include 'partials/header.php'; ?>
    </div>
    <div class="container">
        <main class="container-main">
            <div class="card-image">
                <img src="../../images/homem-mulher-discutindo3.png" alt="Mulher de oculos sorrindo">
            </div>
            <div class="container-card">
                <form action="signup.php" method="POST">
                    <div class="card">
                        <h1>Cadastrar</h1>

                        <div id="msgError"></div>
                        <div id="msgSuccess"></div>

                        <div class="label-float">
                            <input type="text" name="nome" id="nome" placeholder=" " required />
                            <label id="labelNome" for="nome">Nome</label>
                        </div>

                        <div class="label-float">
                            <input type="text" name="usuario" id="usuario" placeholder=" " required />
                            <label id="labelUsuario" for="usuario">Usuário</label>
                        </div>

                        <div class="label-float">
                            <input type="email" name="email" required placeholder=" " />
                            <label for="email">E-mail</label>
                        </div>

                        <div class="label-float">
                            <input type="date" name="dataNascimento" id="dataNascimento" required />
                            <label for="dataNascimento">Data de Nascimento</label>
                        </div>


                        <div class="label-float">
                            <input type="password" name="senha" id="senha" placeholder=" " required />
                            <label id="labelSenha" for="senha">Senha</label>
                            <span class="mostrar-senha" onclick="toggleSenha('senha', this)">
                                <i class="bi bi-eye" aria-hidden="true"></i>
                            </span>
                            <div id="forcaSenha" class="forca-senha"></div>
                        </div>

                        <div class="label-float">
                            <input type="password" name="confirmSenha" id="confirmSenha" placeholder=" " required />
                            <label id="labelConfirmSenha" for="confirmSenha">Confirmar Senha</label>
                            <span class="mostrar-senha" onclick="toggleSenha('confirmSenha', this)">
                                <i class="bi bi-eye" aria-hidden="true"></i>
                            </span>
                        </div>

                        <div class="justify-center">
                            <button type="submit" name="submit">Cadastrar</button>
                        </div>
                        <div class="signup-button">
                            <!-- Link para a página de cadastro -->
                            <p>Já possui uma conta? <a href="signin.php">Fazer login</a></p>
                        </div>
                    </div>
                </form>
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

        // Força da senha
        document.getElementById("senha").addEventListener("input", function() {
            const valor = this.value;
            const forca = document.getElementById("forcaSenha");

            let nivel = 0;
            if (valor.length >= 6) nivel++;
            if (/[A-Z]/.test(valor)) nivel++;
            if (/[0-9]/.test(valor)) nivel++;
            if (/[^A-Za-z0-9]/.test(valor)) nivel++;

            if (nivel <= 1) {
                forca.textContent = "Senha fraca";
                forca.className = "forca-senha fraca";
            } else if (nivel === 2 || nivel === 3) {
                forca.textContent = "Senha média";
                forca.className = "forca-senha media";
            } else if (nivel >= 4) {
                forca.textContent = "Senha forte";
                forca.className = "forca-senha forte";
            } else {
                forca.textContent = "";
            }
        });
    </script>
</body>

</html>