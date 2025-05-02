<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Administração</title>
    <link rel="shortcut icon" href="../images/logotipocw.png" />
    <link rel="stylesheet" href="partials/style.css">
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <?php include 'partials/header.php'; ?> <!-- Inclui o header -->
    <div class="container">
        <main>
            <section id="dashboard" class="section active">
                <h2>Dashboard</h2>

                <p class="intro-text">
                    Bem-vindo ao <strong>Painel de Administração</strong> da Plataforma de Cursos CW!
                </p>

                <p class="description-text">
                    Este é o seu centro de controle para gerenciar todos os recursos da plataforma. Aqui você poderá:
                </p>

                <div class="dashboard-list">
                    <div class="dashboard-item"><strong>Dashboard:</strong> Visão geral e navegação rápida entre as seções.</div>
                    <div class="dashboard-item"><strong>Cursos:</strong> Adicione, edite ou remova cursos, incluindo descrição, duração, imagem e vídeo.</div>
                    <div class="dashboard-item"><strong>Usuários:</strong> Gerencie alunos, professores e administradores, controlando acessos e atualizações de dados.</div>
                    <div class="dashboard-item"><strong>Suporte:</strong> Visualize e responda mensagens de usuários, acompanhando suas dúvidas e sugestões.</div>
                    <div class="dashboard-item"><strong>Acessibilidade:</strong> Configure recursos como aumento de fonte e ativação de legendas para maior inclusão.</div>
                </div>

                <p class="final-text">
                    Utilize o menu acima para navegar entre as seções e administrar a plataforma de forma prática e eficiente.
                </p>
            </section>
        </main>

    </div>
    <?php include 'partials/footer.php'; ?> <!-- Inclui o footer -->
</body>

</html>