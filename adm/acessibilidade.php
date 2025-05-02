<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Administração</title>
    <link rel="shortcut icon" href="../images/logotipocw.png" />
    <link rel="stylesheet" href="partials/style.css">
    <link rel="stylesheet" href="css/acessibilidade.css">
</head>

<body>
    <?php include 'partials/header.php'; ?> <!-- Inclui o header -->
    <div class="container">

        <main>

            <section id="acessibilidade" class="section">
                <h2>Configurações de Acessibilidade</h2>
                <button onclick="adjustAccessibility('increaseFont')">Aumentar Letra</button>
                <button onclick="adjustAccessibility('decreaseFont')">Diminuir Letra</button>
                <button onclick="alert('Ativar Legendas')">Ativar Legendas</button>
            </section>

        </main>
    </div>
    <?php include 'partials/footer.php'; ?> <!-- Inclui o footer -->
    <script>
        function adjustAccessibility(action) {
            if (action === 'increaseFont') {
                document.body.style.fontSize = 'larger';
                alert('Fonte aumentada!');
            } else if (action === 'decreaseFont') {
                document.body.style.fontSize = 'smaller';
                alert('Fonte diminuída!');
            }
        }
    </script>
</body>

</html>