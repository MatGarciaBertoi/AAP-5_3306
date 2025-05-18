<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Formas de pagamento aceitas - CW Cursos</title>
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
                <h1><i class="bi bi-credit-card"></i> Formas de pagamento aceitas</h1>
                <p>Na CW Cursos, oferecemos diversas formas de pagamento para facilitar sua matrícula:</p>
                <ul>
                    <li><strong>Cartão de Crédito:</strong> Parcelamento em até 12x dependendo do valor do curso.</li>
                    <li><strong>PIX:</strong> Pagamento instantâneo com liberação imediata do curso após confirmação.</li>
                    <li><strong>PayPal:</strong> Pagamento seguro com a possibilidade de usar saldo da conta ou cartão de crédito vinculado. Ideal para quem prefere não informar os dados do cartão diretamente na plataforma.</li>
                </ul>
                <p>Escolha a forma mais conveniente para você no momento da matrícula.</p>
                <p>Se tiver dúvidas sobre pagamentos, clique no botão abaixo e fale com nosso suporte:</p>
            </div>
            <div class="article-button">
                <a href="../ticket.php" class="btn-suporte"><i class="bi bi-chat-dots-fill"></i> Abrir um Ticket</a>
            </div>
        </article>
    </main>

    <?php include 'partials/footer.php'; ?>
</body>

</html>
