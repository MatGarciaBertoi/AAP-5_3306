<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CW Cursos - Cursos de Marketing Digital</title>
  <link rel="shortcut icon" href="../images/logotipocw.png" />
  <link rel="stylesheet" href="partials/style.css">
  <link rel="stylesheet" href="css/sobre.css">
</head>

<body>
  <div class="header-main">
    <?php include 'partials/header.php'; ?> <!-- Inclui o header -->
  </div>
  <main>
    <div class="container">
      <section id="about" class="about">
        <div class="about-main">
          <div class="sw-about">
            <h1>Sobre a <span>CW Cursos</span></h1>
            <p>
              A CW Cursos é uma empresa dedicada a fornecer cursos online de alta
              qualidade em marketing digital. Nosso diferencial é a acessibilidade
              para pessoas surdas, garantindo que todos possam aprender e se
              desenvolver em suas carreiras.
            </p>
          </div>

          <div class="executives">
            <h2>Executivos</h2>
            <ul>
              <li>
                Matheus Garcia Bertoi:
                <span>Diretor Executivo. É o principal responsável pela nossa gestão,
                  tomando as principais decisões corporativas, gerenciando
                  operações e recursos da empresa.</span>
              </li>
              <li>
                Jonathans Yoshioka Olsen:
                <span>Gerente Financeiro. Responsável pela gestão financeira da
                  empresa, incluindo planejamento financeiro, gestão de riscos,
                  relatórios financeiros, e análise de dados financeiros para
                  orientar as decisões estratégicas da empresa.</span>
              </li>
              <li>
                Denilson Conceição de Oliveira:
                <span>Gerente de Marketing. Responsável por todas as atividades de marketing dentro da empresa, incluindo estratégias de publicidade, pesquisa de mercado, desenvolvimento de produtos e comunicação com o cliente.</span>
              </li>
              <li>
                Leonardo Zanata de Jesus:
                <span>Gerente de Tecnologia. Responsável por supervisionar a gestão e
                  as estratégias tecnológicas da empresa, além de estar
                  encarregado de implementar novas tecnologias que possam melhorar
                  os produtos ou serviços da empresa.</span>
              </li>
            </ul>
          </div>
        </div>

        <div class="img-office">
          <img src="../images/homem-escritorio.png" alt="Homem sentado no Escritório">
        </div>
      </section>

      <section id="team" class="team">
        <h1>Nosso<span>Time</span></h1>
        <div class="team-members">
          <div class="member">
            <img src="../images/imgcapaexemplo.jpg" alt="Membro da Equipe" />
            <h3>Matheus Garcia Bertoi</h3>
            <p>CEO</p>
          </div>
          <div class="member">
            <img src="../images/membrojonathans.jpeg" alt="Membro da Equipe" />
            <h3>Jonathans Yoshioka Olsen</h3>
            <p>CFO</p>
          </div>
          <div class="member">
            <img src="../images/membroDenilson.jpeg" alt="Membro da Equipe" />
            <h3>Denilson Conceição de Oliveira</h3>
            <p>COO</p>
          </div>
          <div class="member">
            <img src="../images/membroLeonardo.jpg" alt="Membro da Equipe" />
            <h3>Leonardo Zanata de Jesus</h3>
            <p>CTO</p>
          </div>
        </div>
      </section>
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