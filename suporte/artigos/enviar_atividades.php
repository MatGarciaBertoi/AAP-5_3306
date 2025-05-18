<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Como enviar atividades no curso? - CW Cursos</title>
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
                <h1><i class="bi bi-upload"></i> Como enviar atividades no curso?</h1>
                <p>Para enviar uma atividade na plataforma CW Cursos, siga os passos abaixo:</p>
                <ol>
                    <li>Acesse a plataforma e faça login com seu e-mail e senha cadastrados.</li>
                    <li>Entre no curso desejado e vá até a aba <strong>"Avaliações"</strong>, onde verá as atividades.</li>
                    <li>Leia atentamente as instruções da atividade.</li>
                    <li>Clique no botão <strong>“Enviar”</strong> e aguarde a confirmação na tela.</li>
                </ol>
                <p>Pronto! Sua atividade foi enviada e será avaliada pela equipe pedagógica em breve.</p>
                <p>Se tiver dificuldades no envio, utilize o botão abaixo para abrir um ticket de suporte:</p>
            </div>
            <div class="article-button">
                <a href="../ticket.php" class="btn-suporte"><i class="bi bi-chat-dots-fill"></i> Abrir um Ticket</a>
            </div>
        </article>
    </main>

    <?php include 'partials/footer.php'; ?>
</body>

</html>
