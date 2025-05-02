<?php
session_start();
include_once('../funcoes/conexao.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header('Location: signin.html'); // Redireciona para a página de login se não estiver logado
    exit();
}

$usuario = $_SESSION['usuario']; // Recupera o nome do usuário
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
                    <div class="course">
                        <h3>SEO</h3>
                        <img src="../images/seoavançado.png" alt="Imagem do curso SEO">
                        <p>Aprenda as melhores práticas de otimização para motores de busca.</p>
                        <a href="abacursos/abacursos.php">Acessar</a>
                    </div>
                    <div class="course">
                        <h3>Curso de Marketing de Redes Sociais</h3>
                        <img src="../images/cursodeMidiasDigitais_curso.png" alt="Imagem do curso de Marketing de Redes Sociais">
                        <p>Crie conteúdo que engaja e converte.</p>
                        <a href="abacursos/abacursos.php">Acessar</a>
                    </div>
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