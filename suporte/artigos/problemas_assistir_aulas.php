<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Problemas para assistir às aulas - CW Cursos</title>
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
                <h1><i class="bi bi-exclamation-triangle-fill"></i> Problemas para assistir às aulas</h1>
                <p>Se você está enfrentando dificuldades para assistir às aulas na plataforma CW Cursos, veja abaixo algumas soluções que podem ajudar:</p>
                <ul>
                    <li><strong>Verifique sua conexão com a internet:</strong> Certifique-se de estar conectado a uma rede estável e rápida.</li>
                    <li><strong>Atualize o navegador:</strong> Recomendamos usar o <em>Google Chrome</em> ou <em>Mozilla Firefox</em> atualizados.</li>
                    <li><strong>Limpe o cache do navegador:</strong> Cookies e arquivos temporários podem interferir no carregamento dos vídeos.</li>
                    <li><strong>Desative bloqueadores de anúncios ou extensões:</strong> Alguns plugins podem impedir o carregamento correto do player.</li>
                    <li><strong>Use outro dispositivo ou navegador:</strong> Para testar se o problema é local.</li>
                </ul>
                <p>Se após seguir essas dicas o problema continuar, entre em contato com nosso suporte e informe os detalhes (mensagens de erro, print, dispositivo usado etc).</p>
            </div>
            <div class="article-button">
                <a href="../ticket.php" class="btn-suporte"><i class="bi bi-chat-dots-fill"></i> Abrir um Ticket</a>
            </div>
        </article>
    </main>

    <?php include 'partials/footer.php'; ?>
</body>

</html>
