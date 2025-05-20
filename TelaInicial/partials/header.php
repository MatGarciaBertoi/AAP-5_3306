<header class="navbar">
    <div class="nav-header">
        <div class="logo"><a href="index.php">
                <img src="../images/logocwpreto_transparente.png" alt="Logo da CW Cursos" />
            </a></div>
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="O que você gostaria de aprender?" autocomplete="off" />
            <ul id="searchResults" class="search-results"></ul>
        </div>

        <nav class="nav-botoes">
            <?php if (isset($_SESSION['id'])): ?>
                <?php if ($_SESSION['tipo'] === 'aluno'): ?>
                    <div class="btn-area">
                        <a href="../aluno/areadoaluno.php" class="planos-btn">Área do Aluno</a>
                    </div>
                <?php elseif ($_SESSION['tipo'] === 'professor'): ?>
                    <div class="btn-area">
                        <a href="../professor/index.php" class="planos-btn">Área do Professor</a>
                    </div>
                <?php elseif ($_SESSION['tipo'] === 'administrador'): ?>
                    <div class="btn-area">
                        <a href="../administrador/index.php" class="planos-btn">Área do Administrador</a>
                    </div>
                <?php endif; ?>

                <div class="btn-alunos">
                    <div id="perfilAlunoBtn" class="perfil-aluno-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#333" viewBox="0 0 24 24">
                            <path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z" />
                        </svg>
                    </div>

                    <!-- Container de opções -->
                    <div id="perfilAlunoOpcoes" class="perfil-opcoes">
                        <a href="../<?= $_SESSION['tipo'] ?>/profile.php">Meu Perfil</a>
                        <?php if ($_SESSION['tipo'] === 'aluno'): ?>
                            <a href="../aluno/meuplano.php">Meu Plano</a>
                        <?php endif; ?>
                        <a href="../funcoes/sessoes/logout.php">Sair</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="../cadastro_login/professor/signin.php" class="planos-btn">Seja um Professor</a>
                <a href="../cadastro_login/usuario/signin.php" class="planos-btn">Entrar</a>
                <a href="../cadastro_login/usuario/signup.php" class="planos-btn">Cadastrar-se</a>
            <?php endif; ?>
        </nav>

    </div>

    <div class="nav-main">
        <nav class="menu-desktop">
            <div class="menu-container">
                <div class="menu-toggle" id="menuToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>

                <div class="menu-items" id="menuItems">
                    <div class="main-container">
                        <div class="main-content">
                            <a href="index.php"> Início </a>
                        </div>
                    </div>

                    <div class="main-container">
                        <div class="main-content">
                            <a href="cursos.php">Cursos</a>
                        </div>
                    </div>

                    <div class="main-container">
                        <div class="main-content">
                            <a href="sobre.php">Sobre</a>
                        </div>
                    </div>

                    <div class="main-container">
                        <div class="main-content">
                            <a href="ajuda.php">Ajuda</a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>

<?php include '../funcoes/usuario/acessibilidade.php'; ?>

<!--perfil-->
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

<!--Barra de Pesquisa-->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('searchInput');
        const results = document.getElementById('searchResults');
        let cursos = [];

        // Função para carregar cursos via fetch
        async function carregarCursos() {
            try {
                const resposta = await fetch('funcoes/obter_cursos.php');
                if (resposta.ok) {
                    cursos = await resposta.json();
                } else {
                    console.error('Erro ao carregar cursos');
                }
            } catch (error) {
                console.error('Erro na requisição:', error);
            }
        }

        // Carrega cursos assim que a página carregar
        carregarCursos();

        input.addEventListener('input', () => {
            const termo = input.value.trim().toLowerCase();
            if (!termo) {
                results.style.display = 'none';
                results.innerHTML = '';
                return;
            }

            const filtrados = cursos.filter(curso =>
                curso.nome.toLowerCase().includes(termo)
            );

            if (filtrados.length === 0) {
                results.innerHTML = '<li>Nenhum curso encontrado</li>';
            } else {
                results.innerHTML = filtrados.map(curso => `
                <li data-link="${curso.link}">${curso.nome} <small style="color:#777;">(${curso.categoria})</small></li>
            `).join('');
            }
            results.style.display = 'block';
        });

        results.addEventListener('click', (e) => {
            if (e.target.tagName === 'LI' && e.target.dataset.link) {
                window.location.href = e.target.dataset.link;
            }
        });

        document.addEventListener('click', (e) => {
            if (!input.contains(e.target) && !results.contains(e.target)) {
                results.style.display = 'none';
            }
        });
    });
</script>

<!-- Chatra {literal} -->
<script src="../funcoes/chatbot/usuarios/chatra.js"> </script>