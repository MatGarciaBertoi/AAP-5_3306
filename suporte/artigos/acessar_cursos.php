<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Como acessar meus cursos? - CW Cursos</title>
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
                <h1><i class="bi bi-play-circle-fill"></i> Como acessar meus cursos?</h1>
                <p>Para acessar seus cursos na plataforma CW Cursos, siga os passos abaixo:</p>
                <ol>
                    <li>Faça login na plataforma com seu e-mail e senha cadastrados.</li>
                    <li>Após o login, você será direcionado à <strong>Página Inicial</strong>.</li>
                    <li>Na página inicial, clique no <strong>“Painel do Aluno”</strong>.</li>
                    <li>Na página inicial do painel, você verá a lista de todos os cursos em que está matriculado.</li>
                    <li>Clique sobre o curso desejado para começar ou continuar as aulas.</li>
                </ol>
                <p>Importante: Certifique-se de estar logado com o e-mail correto e com o curso ativo/matriculado.</p>
                <p>Se mesmo após o login os cursos não aparecerem, entre em contato com nosso suporte.</p>
            </div>
            <div class="article-button">
                <a href="../ticket.php" class="btn-suporte"><i class="bi bi-chat-dots-fill"></i> Abrir um Ticket</a>
            </div>
        </article>
    </main>

    <?php include 'partials/footer.php'; ?>
</body>

</html>