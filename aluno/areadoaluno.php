<?php
session_start();
include_once('../funcoes/conexao.php');

// Verifica se o usuário está logado e se é aluno
if (!isset($_SESSION['id']) || $_SESSION['tipo'] !== 'aluno') {
    header('Location: http://localhost/AAP-CW_Cursos/cadastro_login/aluno/signin.php');
    exit();
}

$aluno_id = $_SESSION['id'];
$nome = $_SESSION['nome'];
$usuario = $_SESSION['usuario'];

// Busca os cursos que o aluno está inscrito
$sql = "SELECT c.* FROM cursos c 
        INNER JOIN cursos_aluno ca ON ca.curso_id = c.id 
        WHERE ca.aluno_id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $aluno_id);
$stmt->execute();
$result = $stmt->get_result();
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
                <h1>Bem-vindo, <?php echo htmlspecialchars($usuario); ?>!</h1> <!-- Mostra o nome do usuário logado -->
                <p>Aqui você encontrará todas as informações sobre seus cursos, materiais e suporte.</p>
            </section>
            <section class="content">
                <h2>Seus Cursos</h2>
                <div class="courses">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($curso = $result->fetch_assoc()): ?>
                            <div class="course">
                                <h3><?php echo htmlspecialchars($curso['nome']); ?></h3>
                                <img src="../images/<?php echo htmlspecialchars($curso['imagem']); ?>" alt="Imagem do curso">
                                <p><?php echo htmlspecialchars($curso['descricao']); ?></p>
                                <a href="abacursos/abacursos.php?curso_id=<?php echo $curso['id']; ?>">Acessar</a>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>Você ainda não está inscrito em nenhum curso.</p>
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
</body>

</html>