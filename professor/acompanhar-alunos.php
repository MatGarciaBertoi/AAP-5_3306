<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acompanhar Alunos - CW Cursos</title>
    <link rel="shortcut icon" href="../images/logotipocw.png" />
    <link rel="stylesheet" href="partials/style.css">
    <link rel="stylesheet" href="css/index.css">
</head>

<body>

    <?php include 'partials/header.php'; ?> <!-- Inclui o header -->

    <div class="container">
        <div class="welcome-text">
            <h1>Acompanhar Alunos</h1>
            <p>Veja o progresso dos seus alunos 📈</p>
        </div>
        <section class="list-section">
            <div class="course-card">
                <h3>João Silva</h3>
                <p>Curso: Programação Web do Zero</p>
                <p>Progresso: 75%</p>
                <button class="btn-publicar">Ver Detalhes</button>
            </div>

            <div class="course-card">
                <h3>Maria Oliveira</h3>
                <p>Curso: Design Gráfico Moderno</p>
                <p>Progresso: 40%</p>
                <button class="btn-publicar">Ver Detalhes</button>
            </div>

            <!-- + Outros alunos matriculados -->
        </section>
    </div>
    <?php include 'partials/footer.php'; ?> <!-- Inclui o footer -->
</body>

</html>