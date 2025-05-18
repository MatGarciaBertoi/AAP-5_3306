<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Problemas de login ou travamento - CW Cursos</title>
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
                <h1><i class="bi bi-exclamation-triangle-fill"></i> Problemas de login ou travamento</h1>
                <p>Se você está com dificuldades para fazer login ou a plataforma está travando, veja algumas orientações para resolver:</p>
                <ul>
                    <li>🔐 <strong>Verifique seu e-mail e senha:</strong> Certifique-se de que está digitando corretamente. Use o botão <strong>"mostrar senha"</strong>.</li>
                    <li>🧹 <strong>Limpe o cache e os cookies do navegador:</strong> Isso pode resolver falhas na autenticação.</li>
                    <li>🌐 <strong>Use um navegador atualizado:</strong> A plataforma funciona melhor em versões recentes do Chrome ou Firefox.</li>
                    <li>📶 <strong>Internet instável:</strong> Conexões lentas podem causar falhas no carregamento. Reinicie o roteador se necessário.</li>
                    <li>🛡️ <strong>Desative extensões de navegador:</strong> Algumas extensões, como bloqueadores de anúncios, podem causar conflitos.</li>
                </ul>
                <p>Se o problema persistir, entre em contato com nossa equipe de suporte para que possamos ajudar da melhor forma!</p>
            </div>
            <div class="article-button">
                <a href="../ticket.php" class="btn-suporte"><i class="bi bi-chat-dots-fill"></i> Abrir um Ticket</a>
            </div>
        </article>
    </main>

    <?php include 'partials/footer.php'; ?>
</body>

</html>
