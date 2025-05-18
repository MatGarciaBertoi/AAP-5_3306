<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Esqueci meu e-mail de acesso - CW Cursos</title>
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
                <h1><i class="bi bi-envelope-exclamation-fill"></i> Esqueci meu e-mail de acesso</h1>
                <p>Se você não se lembra do e-mail usado para acessar a CW Cursos, siga estas orientações:</p>
                <ol>
                    <li>Tente lembrar se você usou um e-mail pessoal, institucional ou alternativo.</li>
                    <li>Verifique se recebeu algum e-mail da CW Cursos em suas contas (inclusive na lixeira ou spam).</li>
                    <li>Se você ainda tiver acesso ao número de telefone ou outro dado cadastrado, isso pode ajudar na identificação da conta.</li>
                    <li>Caso não consiga lembrar o e-mail, entre em contato com o suporte para que possamos localizar sua conta.</li>
                </ol>
                <p>É importante ter algum dado para confirmar sua identidade, como:</p>
                <ul>
                    <li>Nome completo;</li>
                    <li>CPF ou outro documento (se assinou algum plano);</li>
                    <li>Data aproximada de cadastro;</li>
                    <li>Nome de algum curso que você se matriculou.</li>
                </ul>
                <p>Com essas informações, nossa equipe poderá ajudá-lo a recuperar o acesso com segurança.</p>
            </div>
            <div class="article-button">
                <a href="../ticket.php" class="btn-suporte"><i class="bi bi-chat-dots-fill"></i> Abrir um Ticket</a>
            </div>
        </article>
    </main>

    <?php include 'partials/footer.php'; ?>
</body>

</html>
