<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CW Cursos - Suporte</title>
    <link rel="shortcut icon" href="../images/logotipocw.png" />
    <link rel="stylesheet" href="partials/style.css">
    <link rel="stylesheet" href="css/artigos.css">
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
            <h1> Artigos de Ajuda</h1> <!-- Título principal da página -->
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Pesquise artigos de ajuda...">
            </div>
        </div>
    </header>

    <main>
        <section class="articles-section">
            <div class="articles-grid">

                <div class="article-card">
                    <h3><i class="bi bi-person-lock"></i> Acesso e Login</h3>
                    <ul>
                        <li><a href="#">Como redefinir minha senha?</a></li>
                        <li><a href="#">Esqueci meu e-mail de acesso</a></li>
                        <li><a href="#">Como mudar minha senha?</a></li>
                    </ul>
                </div>

                <div class="article-card">
                    <h3><i class="bi bi-book"></i> Cursos e Aulas</h3>
                    <ul>
                        <li><a href="#">Como acessar meus cursos?</a></li>
                        <li><a href="#">Problemas para assistir às aulas</a></li>
                        <li><a href="#">Como enviar atividades no curso?</a></li>
                    </ul>
                </div>

                <div class="article-card">
                    <h3><i class="bi bi-credit-card"></i> Pagamentos</h3>
                    <ul>
                        <li><a href="#">Formas de pagamento aceitas</a></li>
                        <li><a href="#">Como verificar pendências financeiras?</a></li>
                    </ul>
                </div>

                <div class="article-card">
                    <h3><i class="bi bi-award"></i> Certificados</h3>
                    <ul>
                        <li><a href="#">Como emitir meu certificado?</a></li>
                        <li><a href="#">Requisitos para emissão do certificado</a></li>
                    </ul>
                </div>

                <div class="article-card">
                    <h3><i class="bi bi-gear"></i> Suporte Técnico</h3>
                    <ul>
                        <li><a href="#">O vídeo da aula não carrega, o que fazer?</a></li>
                        <li><a href="#">Problemas de login ou travamento</a></li>
                    </ul>
                </div>

            </div>
        </section>
    </main>

    <?php include 'partials/footer.php'; ?> <!-- Inclui o footer -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById('searchInput');
            const cards = document.querySelectorAll('.article-card');

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