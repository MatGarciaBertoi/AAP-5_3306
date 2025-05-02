<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Venha ensinar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../images/logotipocw.png" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="signin.css">
    <link rel="stylesheet" href="partials/style.css">
</head>

<body>

    <div class="header-main">
        <?php include 'partials/header.php'; ?> <!-- Inclui o header -->
    </div>
    <div class="container">
        <div class="container-main">
            <div class="container-card">
                <div class="card">
                    <h1>Venha dar aulas com a gente</h1>
                    <p>Seja um professor da CW e transforme vidas ensinando</p>
                    <?php
                    if (!empty($_SESSION['msg'])) {
                        echo "<div class='error-msg'>" . $_SESSION['msg'] . "</div>";
                        unset($_SESSION['msg']);
                    }
                    ?>

                    <div class="justify-center">
                        <a href="forms.php" class="inputSubmit" style="text-align: center;">Começar agora</a>
                    </div>
                </div>
            </div>
            <div class="card-image">
                <img src="../../images/mulher-sorrindo.png" alt="Mulher de oculos sorrindo">
            </div>
        </div>
        <section class="info-section">
            <h2>Existem muitos motivos para fazer parte dessa jornada</h2>
            <div class="card-grid">
                <div class="info-card">
                    <h3>Seu estilo de ensino</h3>
                    <p>Compartilhe sua experiência em marketing e negócios como preferir. Tenha liberdade para criar e controle total sobre seu conteúdo.</p>
                </div>
                <div class="info-card">
                    <h3>Inspire empreendedores</h3>
                    <p>Ajude profissionais e iniciantes a dominarem estratégias, técnicas e ferramentas do mundo dos negócios.</p>
                </div>
                <div class="info-card">
                    <h3>Ganhe reconhecimento e renda</h3>
                    <p>Amplie sua visibilidade, construa autoridade no mercado e receba por cada nova inscrição paga em seu curso.</p>
                </div>
            </div>

            <h2>Como começar</h2>
            <div class="card-grid">
                <div class="info-card">
                    <h3>Planeje seu conteúdo</h3>
                    <p>Ensine o que você domina e explore temas em alta no marketing digital. Estruture sua grade com a ajuda da CW.</p>
                </div>
                <div class="info-card">
                    <h3>Grave com o que você tem</h3>
                    <p>Use celular ou notebook. Com áudio claro e conteúdo de valor, você já pode publicar um curso atrativo.</p>
                </div>
                <div class="info-card">
                    <h3>Lance e promova</h3>
                    <p>Compartilhe seu curso nas redes sociais. A CW também divulga para uma base de alunos interessados.</p>
                </div>
            </div>
            <div class="info-block">
                <h2>Conte com suporte</h2>
                <p>Nosso time está pronto para revisar, orientar e apoiar você em todas as etapas do seu curso.</p>
            </div>
        </section>
    </div>

    <?php include 'partials/footer.php'; ?> <!-- Inclui o footer -->
</body>

</html>