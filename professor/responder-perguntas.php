<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Responder Perguntas - CW Cursos</title>
    <link rel="shortcut icon" href="../images/logotipocw.png" />
    <link rel="stylesheet" href="partials/style.css">
    <link rel="stylesheet" href="css/index.css">
</head>

<body>

    <?php include 'partials/header.php'; ?> <!-- Inclui o header -->

    <div class="container">
        <div class="welcome-text">
            <h1>Responder Perguntas</h1>
            <p>Veja e responda dúvidas dos seus alunos ✏️</p>
        </div>
        <section class="list-section">
            <div class="question-card">
                <h3>Curso: Programação Web do Zero</h3>
                <p><strong>Aluno:</strong> João Silva</p>
                <p><strong>Pergunta:</strong> Poderia explicar melhor a diferença entre HTML e CSS?</p>
                <textarea class="answer-input" rows="3" placeholder="Escreva sua resposta aqui..."></textarea>
                <button class="btn-publicar">Responder</button>
            </div>

            <div class="question-card">
                <h3>Curso: Design Gráfico Moderno</h3>
                <p><strong>Aluno:</strong> Maria Oliveira</p>
                <p><strong>Pergunta:</strong> Qual programa você recomenda para iniciantes?</p>
                <textarea class="answer-input" rows="3" placeholder="Escreva sua resposta aqui..."></textarea>
                <button class="btn-publicar">Responder</button>
            </div>

            <!-- + Outras perguntas recebidas -->
        </section>
    </div>

    <?php include 'partials/footer.php'; ?> <!-- Inclui o footer -->
</body>

</html>