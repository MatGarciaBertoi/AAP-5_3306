<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CW Cursos - Marketing Digital</title>
    <link rel="shortcut icon" href="../images/logotipocw.png" />
    <link rel="stylesheet" href="css/planos.css">
    <link rel="stylesheet" href="partials/style.css">
</head>

<body>
    <div class="header-main">
        <?php include 'partials/header.php'; ?> <!-- Inclui o header -->
    </div>
    <main>
        <div class="container">
            <div class="content-main">
                <section class="planos-section">
                    <h2>Escolha seu Plano</h2>
                    <div class="planos-container">

                        <div class="plano-card">
                            <h3>Essencial</h3>
                            <p>Ideal para quem quer acesso completo aos nossos cursos.</p>
                            <ul>
                                <li>Acesso ilimitado a todos os cursos</li>
                                <li>Material de apoio</li>
                                <li>Certificados digitais</li>
                            </ul>
                            <a href="#" class="btn-assinar">Assinar</a>
                        </div>

                        <div class="plano-card destaque">
                            <h3>Profissional</h3>
                            <p>Para quem busca suporte e aprendizado contínuo.</p>
                            <ul>
                                <li>Todos os benefícios do Essencial +</li>
                                <li>Webinars exclusivos</li>
                                <li>Suporte prioritário</li>
                            </ul>
                            <a href="#" class="btn-assinar">Assinar</a>
                        </div>

                        <div class="plano-card">
                            <h3>Empreendedor</h3>
                            <p>Para quem quer escalar seus resultados com acompanhamento especial.</p>
                            <ul>
                                <li>Todos os benefícios do Profissional +</li>
                                <li>Mentorias ao vivo</li>
                                <li>Consultoria personalizada</li>
                                <li>Acesso antecipado a novos cursos</li>
                            </ul>
                            <a href="#" class="btn-assinar">Assinar</a>
                        </div>

                    </div>
                </section>
            </div>
    </main>
    <?php include 'partials/footer.php'; ?> <!-- Inclui o footer -->
</body>

</html>