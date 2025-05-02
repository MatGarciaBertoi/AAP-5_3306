<?php session_start(); ?>
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
        <?php include 'partials/header.php'; ?> <!-- Inclui o header -->
    </div>
    <main>
        <div class="container">
            <div class="content-main">

                <section class="planos-text">
                    <h1>Cursos de Marketing Digital!</h1>
                    <p>Aprimore-se com o melhor conteúdo em marketing digital e negócios.</p>
                    <a href="planos.php" class="planos-btn">Veja os Planos</a>
                </section>

                <section class="courses">
                    <div class="course-card">
                        <h3>Curso de SEO</h3>
                        <p>Otimização para mecanismos de busca e melhores práticas.</p>
                    </div>
                    <div class="course-card">
                        <h3>Marketing de Conteúdo</h3>
                        <p>Estratégias para engajar sua audiência e aumentar conversões.</p>
                    </div>
                    <div class="course-card">
                        <h3>Marketing nas Redes Sociais</h3>
                        <p>Planejamento e gestão de conteúdo para plataformas como Instagram, Facebook e Twitter.</p>
                    </div>
                    <div class="course-card">
                        <h3>Email Marketing</h3>
                        <p>Criação de campanhas de email para atrair e reter clientes.</p>
                    </div>
                    <div class="course-card">
                        <h3>Copywriting</h3>
                        <p>Escrita persuasiva para aumentar as vendas e o engajamento.</p>
                    </div>
                    <div class="course-card">
                        <h3>Gestão de Tráfego Pago</h3>
                        <p>Configuração de anúncios em Google Ads e redes sociais.</p>
                    </div>
                    <div class="course-card">
                        <h3>Funil de Vendas</h3>
                        <p>Desenvolvimento e otimização de funis de vendas para aumentar conversões.</p>
                    </div>
                    <div class="course-card">
                        <h3>Google Analytics</h3>
                        <p>Análise de dados para medir e otimizar o desempenho digital.</p>
                    </div>
                    <div class="course-card">
                        <h3>Marketing de Afiliados</h3>
                        <p>Estratégias para promover produtos de terceiros e ganhar comissões.</p>
                    </div>
                    <div class="course-card">
                        <h3>Branding Digital</h3>
                        <p>Construção e gestão de marcas no ambiente digital.</p>
                    </div>
                    <div class="course-card">
                        <h3>Influência e Parcerias</h3>
                        <p>Como trabalhar com influenciadores e criar parcerias estratégicas.</p>
                    </div>
                    <div class="course-card">
                        <h3>Estratégias de Conversão</h3>
                        <p>Técnicas para transformar visitantes em clientes fiéis.</p>
                    </div>
                </section>
            </div>
        </div>
    </main>
    <?php include 'partials/footer.php'; ?> <!-- Inclui o footer -->
</body>

</html>