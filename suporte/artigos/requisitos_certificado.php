<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Requisitos para emissão do certificado - CW Cursos</title>
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
                <h1><i class="bi bi-award"></i> Requisitos para emissão do certificado</h1>
                <p>Para que o certificado de um curso seja liberado, alguns critérios devem ser atendidos. Confira abaixo os requisitos obrigatórios:</p>
                <ul>
                    <li>✅ Concluir 100% do conteúdo do curso, incluindo todos os módulos e aulas.</li>
                    <li>✅ Realizar todas as atividades obrigatórias e avaliações, se houver.</li>
                    <li>✅ Obter a nota mínima exigida de 70% nas avaliações.</li>
                    <li>✅ Estar com a situação financeira regular (sem pendências de pagamento).</li>
                    <li>✅ Manter seus dados pessoais atualizados no perfil (nome completo e CPF corretos para emissão).</li>
                </ul>
                <p>Após cumprir todos os critérios, a opção para emissão do certificado será exibida automaticamente na página do curso.</p>
                <p>Caso você tenha dúvidas ou encontre algum problema, fale com nosso suporte:</p>
            </div>
            <div class="article-button">
                <a href="../ticket.php" class="btn-suporte"><i class="bi bi-chat-dots-fill"></i> Abrir um Ticket</a>
            </div>
        </article>
    </main>

    <?php include 'partials/footer.php'; ?>
</body>

</html>
