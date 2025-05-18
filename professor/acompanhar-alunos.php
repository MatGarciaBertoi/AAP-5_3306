<?php
session_start();
include '../funcoes/conexao.php';
?>
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
            <?php
            // Consulta para obter alunos, cursos concluídos e feedbacks
            $query = "
                SELECT 
                    u.nome AS nome_aluno,
                    c.nome AS nome_curso,
                    cc.data_conclusao,
                    f.comentario,
                    f.data_envio
                FROM cursos_concluidos cc
                JOIN usuarios u ON cc.aluno_id = u.id
                JOIN cursos c ON cc.curso_id = c.id
                LEFT JOIN feedbacks f ON f.aluno_id = cc.aluno_id AND f.curso_id = cc.curso_id
                ORDER BY cc.data_conclusao DESC
            ";

            $result = mysqli_query($conexao, $query);

            if (mysqli_num_rows($result) > 0):
                while ($row = mysqli_fetch_assoc($result)):
            ?>
                <div class="course-card">
                    <h3><?= htmlspecialchars($row['nome_aluno']) ?></h3>
                    <p>Curso: <?= htmlspecialchars($row['nome_curso']) ?></p>
                    <p>Data de Conclusão: <?= date('d/m/Y', strtotime($row['data_conclusao'])) ?></p>

                    <?php if (!empty($row['comentario'])): ?>
                        <p><strong>Feedback:</strong> <?= nl2br(htmlspecialchars($row['comentario'])) ?></p>
                    <?php else: ?>
                        <p><em>Feedback ainda não enviado.</em></p>
                    <?php endif; ?>
                </div>
            <?php
                endwhile;
            else:
                echo "<p>Nenhum curso concluído até o momento.</p>";
            endif;
            ?>
        </section>
    </div>

    <?php include 'partials/footer.php'; ?> <!-- Inclui o footer -->
</body>

</html>
