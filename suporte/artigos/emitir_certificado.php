<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Como emitir meu certificado? - CW Cursos</title>
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
                <h1><i class="bi bi-award-fill"></i> Como emitir meu certificado?</h1>
                <p>Após a conclusão de um curso, você poderá emitir seu certificado diretamente pela plataforma. Veja o passo a passo:</p>
                <ol>
                    <li>Faça login na sua conta da CW Cursos.</li>
                    <li>Acesse a aba <strong>"Meus Cursos"</strong> ou <strong>“Galeria de Certificados”</strong>.</li>
                    <li>Selecione o curso que você concluiu.</li>
                    <li>Verifique se todos os módulos e atividades obrigatórias foram finalizados.</li>
                    <li>Se o curso estiver completo, aparecerá a opção <strong>“Emitir Certificado”</strong>.</li>
                    <li>Clique no botão <strong>"Emitir Certificado"</strong> e certificado será emitido em outra guia do navegador.</li>
                </ol>
                <p>O certificado será emitido com seu nome completo, nome do curso e data de conclusão.</p>
                <p>Se tiver qualquer problema na emissão, fale com nosso suporte pelo botão abaixo:</p>
            </div>
            <div class="article-button">
                <a href="../ticket.php" class="btn-suporte"><i class="bi bi-chat-dots-fill"></i> Abrir um Ticket</a>
            </div>
        </article>
    </main>

    <?php include 'partials/footer.php'; ?>
</body>

</html>
