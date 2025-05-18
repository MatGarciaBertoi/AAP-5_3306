<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>O vídeo da aula não carrega, o que fazer? - CW Cursos</title>
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
                <h1><i class="bi bi-play-circle"></i> O vídeo da aula não carrega, o que fazer?</h1>
                <p>Se você está enfrentando problemas para carregar os vídeos das aulas, veja abaixo as possíveis causas e como resolver:</p>
                <ul>
                    <li>🔄 <strong>Atualize a página:</strong> Pressione <kbd>Ctrl</kbd> + <kbd>F5</kbd> no navegador para forçar o recarregamento.</li>
                    <li>🌐 <strong>Verifique sua conexão:</strong> Certifique-se de estar conectado à internet com boa estabilidade.</li>
                    <li>🧼 <strong>Limpe o cache do navegador:</strong> Cache corrompido pode afetar o carregamento dos vídeos.</li>
                    <li>🧪 <strong>Tente outro navegador:</strong> Recomendamos o uso do Google Chrome ou Mozilla Firefox.</li>
                    <li>🔒 <strong>Desative extensões bloqueadoras:</strong> Algumas extensões podem interferir no carregamento do player.</li>
                </ul>
                <p>Se nenhuma das opções acima resolver, entre em contato com nosso suporte técnico. Estamos prontos para ajudar você!</p>
            </div>
            <div class="article-button">
                <a href="../ticket.php" class="btn-suporte"><i class="bi bi-chat-dots-fill"></i> Abrir um Ticket</a>
            </div>
        </article>
    </main>

    <?php include 'partials/footer.php'; ?>
</body>

</html>
