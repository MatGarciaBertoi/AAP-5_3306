<header>
    <div class="logo">
        <a href="../../TelaInicial/index.php">
            <img src="../../images/logocwbranco_transparente.png" alt="Logo CW Cursos">
        </a>
    </div>
    <nav class="nav-main">
        <ul>
            <li><a href="../index.php">Tela Inicial</a></li>

            <!-- Dropdown Cursos -->
            <li class="dropdown">
                <a href="#">Cursos ▾</a>
                <ul class="dropdown-menu">
                    <li><a href="../cursos/add_cursos.php">Criar Curso</a></li>
                    <li><a href="../cursos/meus_cursos.php">Meus Cursos</a></li>
                </ul>
            </li>

            <!-- Dropdown Aulas -->
            <li class="dropdown">
                <a href="#">Aulas ▾</a>
                <ul class="dropdown-menu">
                    <li><a href="add_aula.php">Adicionar Aula</a></li>
                    <li><a href="minhas_aulas.php">Minhas Aulas</a></li>
                </ul>
            </li>

            <li><a href="../responder-perguntas.php">Responder Perguntas</a></li>
            <li><a href="../acompanhar-alunos.php">Acompanhar Alunos</a></li>
        </ul>

        <div class="btn-alunos">
            <div id="perfilAlunoBtn" class="perfil-aluno-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#333" viewBox="0 0 24 24">
                    <path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z" />
                </svg>
            </div>

            <!-- Container de opções -->
            <div id="perfilAlunoOpcoes" class="perfil-opcoes">
                <a href="../profile.php">Meu Perfil</a>
                <a href="../../suporte/suporte.php" target="_blank">Central de Ajuda</a>
                <a href="../../funcoes/sessoes/logout.php">Sair</a>
            </div>
        </div>
    </nav>
</header>

<?php include '../../funcoes/usuario/acessibilidade.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const perfilBtn = document.getElementById('perfilAlunoBtn');
        const opcoes = document.getElementById('perfilAlunoOpcoes');

        perfilBtn.addEventListener('click', function(e) {
            e.stopPropagation(); // para não fechar na hora de abrir
            opcoes.classList.toggle('show');
        });

        document.addEventListener('click', function(event) {
            if (!perfilBtn.contains(event.target) && !opcoes.contains(event.target)) {
                opcoes.classList.remove('show');
            }
        });
    });
</script>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const dropdowns = document.querySelectorAll(".dropdown");

    dropdowns.forEach(dropdown => {
      const trigger = dropdown.querySelector("a");

      trigger.addEventListener("click", (e) => {
        e.preventDefault();

        // Fecha outros dropdowns
        dropdowns.forEach(d => {
          if (d !== dropdown) d.classList.remove("open");
        });

        // Alterna o dropdown clicado
        dropdown.classList.toggle("open");
      });
    });

    // Fecha o dropdown se clicar fora
    document.addEventListener("click", (e) => {
      if (!e.target.closest(".dropdown")) {
        dropdowns.forEach(d => d.classList.remove("open"));
      }
    });
  });
</script>

<!-- Chatra {literal} -->
<script src="../../funcoes/chatbot/usuarios/chatra.js"> </script>