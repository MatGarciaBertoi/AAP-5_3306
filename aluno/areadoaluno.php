<?php
include_once('../funcoes/sessoes/check_aluno.php');
include_once('../funcoes/conexao.php');

$aluno_id = $_SESSION['id'];
$nome = $_SESSION['nome'];
$usuario = $_SESSION['usuario'];

// Busca os cursos que o aluno está inscrito
$sql = "SELECT c.*, i.data_inscricao, i.id AS inscricao_id FROM cursos c 
        INNER JOIN inscricoes i ON i.curso_id = c.id 
        WHERE i.aluno_id = ?
        AND c.id NOT IN (
            SELECT curso_id FROM cursos_concluidos WHERE aluno_id = ?
        )";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("ii", $aluno_id, $aluno_id); // Agora são dois parâmetros
$stmt->execute();
$result = $stmt->get_result();

// Busca os cursos concluídos pelo aluno
$sql_concluidos = "SELECT c.*, cc.data_conclusao FROM cursos c 
                   INNER JOIN cursos_concluidos cc ON cc.curso_id = c.id 
                   WHERE cc.aluno_id = ?";
$stmt_concluidos = $conexao->prepare($sql_concluidos);
$stmt_concluidos->bind_param("i", $aluno_id);
$stmt_concluidos->execute();
$result_concluidos = $stmt_concluidos->get_result();

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área do Aluno</title>
    <link rel="shortcut icon" href="../images/logotipocw.png" />
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="partials/style.css">
</head>

<body>
    <?php include 'partials/header.php'; ?> <!-- Inclui o header -->
    <div class="container">
        <main>
            <section class="welcome">
                <h1>Bem-vindo, <?= htmlspecialchars($usuario); ?>!</h1>
                <p>Aqui você encontrará todos os cursos que está matriculado.</p>
            </section>

            <section class="content">
                <div class="content-header">
                    <h2>Seus Cursos</h2>
                </div>
                <div class="tabs">
                    <button class="tab-button active" onclick="mostrarAba('abaAndamento')">Cursos em Andamento</button>
                    <button class="tab-button" onclick="mostrarAba('abaConcluidos')">Cursos Concluídos</button>
                </div>

                <div id="abaAndamento" class="tab-content" style="display: block;">
                    <?php if ($result->num_rows > 0): ?>
                        <div class="courses"> <!-- Adicione esta div -->
                            <?php while ($curso = $result->fetch_assoc()): ?>
                                <div class="course">
                                    <h3><?= htmlspecialchars($curso['nome']); ?></h3>
                                    <?php if (!empty($curso['imagem'])): ?>
                                        <img src="../<?= htmlspecialchars($curso['imagem']); ?>" alt="Imagem do curso">
                                    <?php endif; ?>
                                    <p><?= htmlspecialchars($curso['descricao']); ?></p>
                                    <p><strong>Inscrito em:</strong> <?= date('d/m/Y H:i', strtotime($curso['data_inscricao'])); ?></p>
                                    <div class="buttons">
                                        <a href="abacursos/abacursos.php?curso_id=<?= $curso['id']; ?>">Acessar</a>
                                        <form action="funcoes/cancelar_inscricao.php" method="POST" onsubmit="return confirm('Tem certeza que deseja cancelar sua inscrição neste curso?');" style="margin-top:10px;">
                                            <input type="hidden" name="inscricao_id" value="<?= $curso['inscricao_id']; ?>">
                                            <button type="submit">Cancelar Inscrição</button>
                                        </form>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div> <!-- Feche a div aqui -->
                    <?php else: ?>
                        <p>Você ainda não está inscrito em nenhum curso.</p>
                    <?php endif; ?>
                </div>


                <div id="abaConcluidos" class="tab-content" style="display: none;">
                    <?php if ($result_concluidos->num_rows > 0): ?>
                        <div class="courses"> <!-- Adicione esta div -->
                            <?php while ($curso = $result_concluidos->fetch_assoc()): ?>
                                <div class="course">
                                    <h3><?= htmlspecialchars($curso['nome']); ?></h3>
                                    <?php if (!empty($curso['imagem'])): ?>
                                        <img src="../<?= htmlspecialchars($curso['imagem']); ?>" alt="Imagem do curso">
                                    <?php endif; ?>
                                    <p><?= htmlspecialchars($curso['descricao']); ?></p>
                                    <p><strong>Concluído em:</strong> <?= date('d/m/Y H:i', strtotime($curso['data_conclusao'])); ?></p>
                                    <div class="buttons">
                                        <a href="abacursos/abacursos.php?curso_id=<?= $curso['id']; ?>">Revisar Curso</a>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div> <!-- Feche a div aqui -->
                    <?php else: ?>
                        <p>Você ainda não concluiu nenhum curso.</p>
                    <?php endif; ?>
                </div>

            </section>

        </main>
    </div>
    <?php include 'partials/footer.php'; ?> <!-- Inclui o footer -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const courses = document.querySelectorAll('.course');

            courses.forEach(course => {
                course.addEventListener('mouseover', function() {
                    this.style.transform = 'scale(1.05)';
                });

                course.addEventListener('mouseout', function() {
                    this.style.transform = 'scale(1)';
                });
            });

            const userGreeting = document.querySelector('.welcome h1');
            userGreeting.classList.add('animate__animated', 'animate__fadeInDown');
        });
    </script>

    <script>
        function mostrarAba(id) {
            // Esconde todos os conteúdos
            const abas = document.querySelectorAll('.tab-content');
            abas.forEach(aba => aba.style.display = 'none');

            // Remove 'active' de todos os botões
            const botoes = document.querySelectorAll('.tab-button');
            botoes.forEach(btn => btn.classList.remove('active'));

            // Mostra o conteúdo selecionado
            document.getElementById(id).style.display = 'block';
            event.target.classList.add('active');
        }
    </script>

</body>

</html>