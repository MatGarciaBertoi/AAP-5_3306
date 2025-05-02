<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CW Cursos - Suporte</title>
    <link rel="shortcut icon" href="../images/logotipocw.png" />
    <link rel="stylesheet" href="partials/style.css">
    <link rel="stylesheet" href="css/ticket.css">
    <!--BOOTSTRAPS inicio-->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <!--BOOTSRAPS FIM-->
</head>

<body>
    <header class="navbar">
        <?php include 'partials/header.php'; ?> <!-- Inclui o header -->
    </header>

    <main>
        <!-- Seção de contato -->
        <section id="contact">
            <h2>Contato</h2> <!-- Subtítulo da seção -->
            <form id="contact-form" action="funcoes/processa_ticket.php" method="post">
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="subject">Assunto:</label>
                <input type="text" id="subject" name="subject" required>

                <label for="message">Mensagem:</label>
                <textarea id="message" name="message" required></textarea>

                <button type="submit" class="btn-submit">Enviar</button>
            </form>

            <div id="response-message" class="hidden success-message">
                <i class="bi bi-check-circle"></i> Sua mensagem foi enviada!
            </div>
        </section>
    </main>
    <?php include 'partials/footer.php'; ?> <!-- Inclui o footer -->
</body>

</html>