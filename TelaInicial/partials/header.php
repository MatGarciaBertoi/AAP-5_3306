<header class="navbar">
    <div class="nav-header">
        <div class="logo"><a href="index.php">
                <img src="../images/logocwpreto_transparente.png" alt="Logo da CW Cursos" />
            </a></div>
        <div class="search-bar">
            <input type="text" placeholder="O que você gostaria de aprender?">
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
                        <a href="../adm/index.php" class="planos-btn">Área do Administrador</a>
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
                        <a href="../<?= $_SESSION['tipo'] ?>/profile.php">Conta</a>
                        <a href="configuracoes.php">Minhas Compras</a>
                        <a href="../funcoes/sessoes/logout.php">Sair</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="../cadastro_login/professor/signin.php" class="planos-btn">Seja um Professor</a>
                <a href="../cadastro_login/aluno/signin.php" class="planos-btn">Entrar</a>
                <a href="../cadastro_login/aluno/signup.php" class="planos-btn">Cadastrar-se</a>
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

<!-- Chatra {literal} -->
<script>
    (function(d, w, c) {
        w.ChatraID = 'igHEh7N4PEvoDEkR7';
        var s = d.createElement('script');
        w[c] = w[c] || function() {
            (w[c].q = w[c].q || []).push(arguments);
        };
        s.async = true;
        s.src = 'https://call.chatra.io/chatra.js';
        if (d.head) d.head.appendChild(s);
    })(document, window, 'Chatra');
    window.ChatraSetup = {
        colors: {
            buttonText: '#F1F3F4',
            /* chat button text color */
            buttonBg: '#1A73E8' /* chat button background color */
        }
    };
</script>
<!-- /Chatra {/literal} -->