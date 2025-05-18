<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Como mudar minha senha? - CW Cursos</title>
    <link rel="shortcut icon" href="../../images/logotipocw.png" />
    <link rel="stylesheet" href="partials/style.css">
    <link rel="stylesheet" href="css/artigo_unico.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
</head>

<body>
    <header class="navbar">
        <?php include 'partials/header.php'; ?>
        <div class="nav-central">
            <h1> Artigos de Ajuda</h1>
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Pesquise artigos de ajuda...">
            </div>
        </div>
    </header>

    <main class="article-container">
        <article class="article-content">
            <div class="article-main">
                <h1><i class="bi bi-shield-lock-fill"></i> Como mudar minha senha?</h1>
                <p>Se você deseja alterar sua senha enquanto estiver logado na plataforma, siga os passos abaixo:</p>
                <ol>
                    <li>Acesse seu perfil clicando no seu nome ou na opção “Meu Perfil” no menu superior.</li>
                    <li>Clique na  <strong>"Engrenagem"</strong> ou "⚙️".</li>
                    <li>Digite sua senha atual para confirmação.</li>
                    <li>Digite a nova senha desejada e confirme digitando novamente.</li>
                    <li>Clique em <strong>“Salvar Alterações”</strong>.</li>
                </ol>
                <p>Pronto! Sua senha foi alterada com sucesso. Da próxima vez que for acessar, use a nova senha.</p>
                <p>Importante: Use uma senha forte, com letras maiúsculas, minúsculas, números e símbolos para manter sua conta protegida.</p>
            </div>
            <div class="article-button">
                <a href="../ticket.php" class="btn-suporte"><i class="bi bi-chat-dots-fill"></i> Abrir um Ticket</a>
            </div>
        </article>
    </main>

    <?php include 'partials/footer.php'; ?>
</body>

</html>
