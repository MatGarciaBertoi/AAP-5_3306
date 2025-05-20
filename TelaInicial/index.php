<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CW Cursos - Marketing Digital</title>
    <link rel="shortcut icon" href="../images/logotipocw.png" />
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="partials/style.css">
    <!--Google Fontes Inicio-->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />
    <!--Google Fontes FIM-->
    <!--BOOTSTRAPS inicio-->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <!--BOOTSRAPS FIM-->
</head>

<body>
    <div class="header-main">
        <?php include 'partials/header.php'; ?> <!-- Inclui o header -->
    </div>
    <main>
        <div class="container">
            <section class="topo-do-site">
                <div class="interface">
                    <div class="flex">
                        <div class="txt-topo-site">
                            <h1>
                                Desperte seu potencial: Explore novos horizontes com nossos
                                cursos online de excelência!
                            </h1>
                            <p>
                                Transformamos conhecimento em oportunidades tangíveis. Com uma
                                variedade de cursos online, capacitamos você para o sucesso na
                                área de Marketing Digital. Descubra o poder da aprendizagem
                                flexível e personalizada.
                            </p>

                            <div class="btn-cursos">
                                <a href="cursos.php">
                                    <button>Acesse os Planos</button>
                                </a>
                            </div>
                        </div>
                        <!--txt-topo-site-->
                        <div class="img-topo-site">
                            <img src="../images/imagemsistema01.png" />
                        </div>
                        <!--img-topo-site-->
                    </div>
                    <!--flex-->
                </div>
                <!--interface do topo do site-->
            </section>
            <!--topo do site-->

            <section class="especialidades">
                <div class="interface">
                    <h2 class="titulo">NOSSAS <span>ESPECIALIDADES</span></h2>
                    <div class="felx">
                        <div class="especialidades-box">
                            <i class="bi bi-code-square"></i>
                            <h3>Cursos de MKD</h3>
                            <p>
                                Estudar marketing digital é uma escolha estratégica para quem
                                busca se destacar em um mercado competitivo, pois oferece
                                conhecimentos fundamentais para entender e influenciar o
                                comportamento do consumidor online, impulsionando resultados
                                tangíveis para empresas e marcas.
                            </p>
                        </div>
                        <!--especialidades-box-->

                        <div class="especialidades-box">
                            <i class="bi bi-cart"></i>
                            <h3>Sobre os Cursos</h3>
                            <p>
                                A CW oferece cursos online de marketing digital, cobrindo desde
                                conceitos básicos até estratégias avançadas, como SEO, mídias
                                sociais, publicidade online e análise de dados. Os alunos
                                recebem instrução prática e suporte especializado para aplicar
                                suas habilidades de forma eficaz.
                            </p>
                        </div>
                        <!--especialidades-box-->

                        <div class="especialidades-box">
                            <i class="bi bi-hand-index-fill"></i>
                            <h3>Sobre a CW</h3>
                            <p>
                                Na CW, estamos comprometidos com o sucesso de nossos alunos,
                                oferecendo suporte personalizado e recursos interativos para
                                garantir uma experiência de aprendizado enriquecedora e eficaz.
                                Junte-se a nós e embarque na jornada para dominar o marketing
                                digital. Clique para saber mais.
                            </p>
                        </div>
                        <!--especialidades-box-->
                    </div>
                    <!--flex-->
                </div>
                <!--interface/especialidades-->
            </section>
            <!--especialidades-->

            <section class="sobre">
                <div class="interface">
                    <div class="flex">
                        <div class="img-sobre">
                            <img src="../images/mulher-escritorio.png" alt="" />
                        </div>
                        <!--img-sobre-->

                        <div class="txt-sobre">
                            <h2>SAIBA MAIS SOBRE <span> O MKT DIGITAL.</span></h2>
                            <p>
                                Marketing digital é a promoção de produtos, serviços ou marcas
                                através de canais online como redes sociais, sites, e-mails e
                                motores de busca. Isso envolve estratégias como conteúdo
                                relevante, SEO para melhorar a visibilidade online, anúncios
                                pagos, e-mail marketing e interações em mídias sociais. A
                                vantagem reside na capacidade de segmentação e mensuração em
                                tempo real, permitindo alcançar e engajar o público-alvo de
                                forma mais eficaz.
                            </p>
                            <p>
                                No mundo digital atual, dominar o marketing online é essencial.
                                A internet democratizou o acesso ao conhecimento nessa área,
                                tornando-o crucial para carreiras e empreendimentos. Habilidades
                                em marketing digital são valorizadas no mercado de trabalho e
                                oferecem vantagens significativas para empreendedores. Contudo,
                                é importante manter-se atualizado, pois o cenário digital está
                                em constante evolução. Em resumo, o marketing digital não é
                                apenas uma habilidade, mas sim uma necessidade para se destacar
                                no mundo online atual.
                            </p>
                            <div class="btn-social">
                                <a href="#"><button><i class="bi bi-instagram"></i></button></a>
                                <a href="https://www.youtube.com/watch?v=lwuVOQTNxkA" target="_blank"><button><i class="bi bi-youtube"></i></button></a>
                                <a href="#"><button><i class="bi bi-tiktok"></i></button></a>
                            </div>
                            <!--btn-social-->
                        </div>
                        <!--txt-sobre-->
                    </div>
                    <!--flex-->
                </div>
                <!--interface-->
            </section>
            <!--sobre-->
        </div>
    </main>
    <?php include 'partials/footer.php'; ?> <!-- Inclui o footer -->
    <script>
        const menuToggle = document.getElementById("menuToggle");
        const menuItems = document.getElementById("menuItems");

        menuToggle.addEventListener("click", () => {
            menuItems.classList.toggle("show");
        });
    </script>
    <!--Script para ativar o dropdown do menu de navegação-->
</body>

</html>