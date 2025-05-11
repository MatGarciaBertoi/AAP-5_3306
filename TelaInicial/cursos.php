<?php
session_start();
include '../funcoes/conexao.php'; // Arquivo com a conexão ao banco
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CW Cursos - Marketing Digital</title>
    <link rel="shortcut icon" href="../images/logotipocw.png" />
    <link rel="stylesheet" href="css/cursos.css">
    <link rel="stylesheet" href="partials/style.css">
</head>

<body>
    <div class="header-main">
        <?php include 'partials/header.php'; ?>
    </div>
    <main>
        <div class="container">
            <div class="content-main">

                <section class="planos-text">
                    <h1>Cursos de Marketing Digital!</h1>
                    <p>Aprimore-se com o melhor conteúdo em marketing digital e negócios.</p>
                    <a href="planos.php" class="planos-btn">Veja os Planos</a>
                </section>

                <section class="filtros-cursos">
                    <label for="filtroCategoria">Categoria:</label>
                    <select id="filtroCategoria">
                        <option value="todas">Todas</option>
                        <option value="Marketing Digital">Marketing Digital</option>
                        <option value="Vendas">Vendas</option>
                        <option value="Negócios">Negócios</option>
                    </select>

                    <label for="filtroDificuldade">Dificuldade:</label>
                    <select id="filtroDificuldade">
                        <option value="todas">Todas</option>
                        <option value="iniciante">Iniciante</option>
                        <option value="intermediario">Intermediário</option>
                        <option value="avancado">Avançado</option>
                    </select>

                </section>


                <section class="courses">
                    <?php
                    $sql = "SELECT * FROM cursos";
                    $result = $conexao->query($sql);

                    if ($result->num_rows > 0) {
                        while ($curso = $result->fetch_assoc()) {
                            echo "<a href='detalhes_curso.php?curso_id=" . $curso['id'] . "' class='course-card-link'>";
                            echo "<div class='course-card categoria-" . strtolower($curso['categoria']) . " dificuldade-" . strtolower($curso['dificuldade']) . "'>";

                            if (!empty($curso['imagem'])) {
                                echo "<img src='../professor/cursos/funcoes/uploads/" . htmlspecialchars($curso['imagem']) . "' alt='Imagem do curso' class='course-img'>";
                            }

                            echo "<h3>" . htmlspecialchars($curso['nome']) . "</h3>";
                            echo "<p class='course-desc'>" . htmlspecialchars($curso['descricao']) . "</p>";

                            echo "<div class='course-meta'>";
                            echo "<span class='categoria'>" . htmlspecialchars($curso['categoria']) . "</span>";
                            $dificuldade = htmlspecialchars($curso['dificuldade']);
                            echo "<span class='dificuldade $dificuldade'>" . ucfirst($dificuldade) . "</span>";
                            echo "</div>"; // .course-meta

                            echo "</div>";
                            echo "</a>";
                        }
                    } else {
                        echo "<p>Nenhum curso disponível no momento.</p>";
                    }
                    ?>
                </section>

            </div>
        </div>
    </main>
    <?php include 'partials/footer.php'; ?>

    <script>
        const filtroCategoria = document.getElementById('filtroCategoria');
        const filtroDificuldade = document.getElementById('filtroDificuldade');
        const filtroBusca = document.getElementById('filtroBusca');
        const cards = document.querySelectorAll('.course-card');

        function filtrarCursos() {
            const categoriaSelecionada = filtroCategoria.value.toLowerCase();
            const dificuldadeSelecionada = filtroDificuldade.value.toLowerCase();
            const textoBusca = filtroBusca.value.toLowerCase();

            cards.forEach(card => {
                const categoriaClasse = card.classList.contains(`categoria-${categoriaSelecionada}`);
                const dificuldadeClasse = card.classList.contains(`dificuldade-${dificuldadeSelecionada}`);

                const mostrarCategoria = categoriaSelecionada === "todas" || categoriaClasse;
                const mostrarDificuldade = dificuldadeSelecionada === "todas" || dificuldadeClasse;

                const textoCard = card.textContent.toLowerCase();
                const mostrarBusca = textoCard.includes(textoBusca);

                if (mostrarCategoria && mostrarDificuldade && mostrarBusca) {
                    card.style.display = "block";
                } else {
                    card.style.display = "none";
                }
            });
        }

        filtroCategoria.addEventListener('change', filtrarCursos);
        filtroDificuldade.addEventListener('change', filtrarCursos);
        filtroBusca.addEventListener('input', filtrarCursos);
    </script>


</body>

</html>