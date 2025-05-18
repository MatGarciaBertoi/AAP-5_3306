<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Como verificar pendências financeiras? - CW Cursos</title>
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
                <h1><i class="bi bi-exclamation-circle-fill"></i> Como verificar pendências financeiras?</h1>
                <p>Para manter seus cursos ativos e garantir o acesso completo, é importante estar em dia com seus pagamentos. Veja como verificar se há alguma pendência financeira:</p>
                <ol>
                    <li>Faça login na sua conta na CW Cursos.</li>
                    <li>Acesse a área <strong>“Meu Plano”</strong>.</li>
                    <li>Procure pela seção <strong>“Pagamentos”</strong>.</li>
                    <li>Você verá um resumo com os pagamentos realizados e possíveis pendências.</li>
                    <li>Se houver algum valor em aberto, serão exibidos os detalhes, como curso relacionado, data de vencimento e valor.</li>
                    <li>Clique em <strong>“Pagar Agora”</strong> para regularizar a situação.</li>
                </ol>
                <p>Mantendo seus pagamentos em dia, você garante acesso contínuo às aulas e à emissão de certificados.</p>
                <p>Se tiver dificuldades para encontrar ou quitar uma pendência, entre em contato com nosso suporte:</p>
            </div>
            <div class="article-button">
                <a href="../ticket.php" class="btn-suporte"><i class="bi bi-chat-dots-fill"></i> Abrir um Ticket</a>
            </div>
        </article>
    </main>

    <?php include 'partials/footer.php'; ?>
</body>

</html>
