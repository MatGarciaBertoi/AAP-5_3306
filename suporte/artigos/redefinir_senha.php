<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Como redefinir minha senha? - CW Cursos</title>
    <link rel="shortcut icon" href="../../images/logotipocw.png" />
    <link rel="stylesheet" href="partials/style.css">
    <link rel="stylesheet" href="css/artigo_unico.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
</head>

<body>
    <header class="navbar">
        <?php include 'partials/header.php'; ?> <!-- Inclui o header -->
        <div class="nav-central">
            <h1> Artigos de Ajuda</h1> <!-- Título principal da página -->
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Pesquise artigos de ajuda...">
            </div>
        </div>
    </header>

    <main class="article-container">
        <article class="article-content">
            <div class="article-main">
                <h1><i class="bi bi-key-fill"></i> Como redefinir minha senha?</h1>
                <p>Se você esqueceu sua senha ou deseja alterá-la, siga os passos abaixo para redefinir com segurança:</p>
                <ol>
                    <li>Acesse a <strong><a href="../../cadastro_login/recuperar_senha.php">página de recuperação de senha</a></strong>.</li>
                    <li>Digite seu e-mail de cadastro e clique em <strong>“Enviar link para alteração”</strong>.</li>
                    <li>Verifique sua caixa de entrada (ou spam) no e-mail para encontrar o link enviado.</li>
                    <li>Clique no link, onde será redirecionado para a página de redefinir senha, crie uma nova senha e confirme.</li>
                    <li>Clique em <strong>“Alterar Senha”</strong> e pronto! Sua senha foi atualizada.</li>
                </ol>
                <p>Se continuar com dificuldades, entre em contato com nosso suporte através do botão abaixo:</p>
            </div>
            <div class="article-button">
                <a href="../ticket.php" class="btn-suporte"><i class="bi bi-chat-dots-fill"></i> Abrir um Ticket</a>
            </div>
        </article>
    </main>

    <?php include 'partials/footer.php'; ?>
</body>

</html>