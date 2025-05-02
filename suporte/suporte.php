<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CW Cursos - Suporte</title>
    <link rel="shortcut icon" href="../images/logotipocw.png" />
    <link rel="stylesheet" href="partials/style.css">
    <link rel="stylesheet" href="css/suporte.css">
    <!--BOOTSTRAPS inicio-->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <!--BOOTSRAPS FIM-->
</head>

<body>
    <header class="navbar">
        <?php include 'partials/header.php'; ?> <!-- Inclui o header -->
        <div class="nav-central">
            <h1>Como podemos ajudar?</h1> <!-- Título principal da página -->
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Pesquise por ajuda...">
            </div>
        </div>
    </header>

    <main>
        <section class="help-categories">
            <div class="categories-grid">
                <a href="#" class="category-item">
                    <i class="bi bi-person-lock"></i>
                    <h3>Acesso e Login</h3>
                    <p>Problemas para acessar ou redefinir senha.</p>
                </a>

                <a href="#" class="category-item">
                    <i class="bi bi-book"></i>
                    <h3>Cursos e Aulas</h3>
                    <p>Saiba como acessar seus cursos e conteúdos.</p>
                </a>

                <a href="#" class="category-item">
                    <i class="bi bi-credit-card"></i>
                    <h3>Pagamentos</h3>
                    <p>Formas de pagamento e pendências financeiras.</p>
                </a>

                <a href="#" class="category-item">
                    <i class="bi bi-award"></i>
                    <h3>Certificados</h3>
                    <p>Emissão e requisitos para gerar certificados.</p>
                </a>

                <a href="#" class="category-item">
                    <i class="bi bi-gear"></i>
                    <h3>Suporte Técnico</h3>
                    <p>Problemas técnicos? Estamos aqui para ajudar.</p>
                </a>

                <a href="ticket.php" class="category-item special">
                    <i class="bi bi-envelope-plus"></i>
                    <h3>Abrir um Chamado</h3>
                    <p>Não encontrou o que precisa? Fale conosco.</p>
                </a>
            </div>
        </section>
    </main>

    <?php include 'partials/footer.php'; ?> <!-- Inclui o footer -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById('searchInput');
            const cards = document.querySelectorAll('.category-item');

            searchInput.addEventListener('input', function() {
                const searchText = searchInput.value.toLowerCase();

                cards.forEach(card => {
                    const cardText = card.textContent.toLowerCase();
                    if (cardText.includes(searchText)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    </script>

</body>

</html>