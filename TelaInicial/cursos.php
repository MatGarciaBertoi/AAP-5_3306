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
                        <?php
                        $sql_enum = "SHOW COLUMNS FROM cursos LIKE 'categoria'";
                        $res_enum = $conexao->query($sql_enum);
                        if ($res_enum && $res_enum->num_rows > 0) {
                            $row_enum = $res_enum->fetch_assoc();
                            $enum_str = $row_enum['Type'];
                            preg_match_all("/'([^']+)'/", $enum_str, $matches);
                            foreach ($matches[1] as $categoria) {
                                echo "<option value=\"" . htmlspecialchars($categoria) . "\">" . htmlspecialchars($categoria) . "</option>";
                            }
                        }
                        ?>
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
                            $categoriaClasse = 'categoria-' . preg_replace('/[^a-z0-9]+/i', '', strtolower(str_replace([' ', 'á', 'ã', 'é', 'ê', 'í', 'ó', 'ô', 'ú', 'ç'], ['', 'a', 'a', 'e', 'e', 'i', 'o', 'o', 'u', 'c'], $curso['categoria'])));
                            $dificuldadeClasse = 'dificuldade-' . strtolower($curso['dificuldade']);
                            echo "<div class='course-card $categoriaClasse $dificuldadeClasse'>";


                            if (!empty($curso['imagem'])) {
                                echo "<img src='../" . htmlspecialchars($curso['imagem']) . "' alt='Imagem do curso' class='course-img'>";
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
        const cards = document.querySelectorAll('.course-card-link');

        function filtrarCursos() {
            const categoriaSelecionada = filtroCategoria.value.toLowerCase().replace(/[^a-z0-9]/g, '');
            const dificuldadeSelecionada = filtroDificuldade.value.toLowerCase();

            cards.forEach(cardLink => {
                const card = cardLink.querySelector('.course-card');
                const categoriaClasse = card.classList.contains(`categoria-${categoriaSelecionada}`);
                const dificuldadeClasse = card.classList.contains(`dificuldade-${dificuldadeSelecionada}`);

                const mostrarCategoria = categoriaSelecionada === "todas" || categoriaClasse;
                const mostrarDificuldade = dificuldadeSelecionada === "todas" || dificuldadeClasse;

                if (mostrarCategoria && mostrarDificuldade) {
                    cardLink.style.display = "block"; // esconder ou mostrar o <a>
                } else {
                    cardLink.style.display = "none";
                }
            });
        }

        filtroCategoria.addEventListener('change', filtrarCursos);
        filtroDificuldade.addEventListener('change', filtrarCursos);
    </script>


</body>

</html>