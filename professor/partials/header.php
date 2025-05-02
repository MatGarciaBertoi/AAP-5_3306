<header>
    <div class="logo">
        <a href="../TelaInicial/index.php"><img src="../images/logocwbranco_transparente.png" alt="Logo CW Cursos"></a>
    </div>
    <nav class="nav-main">
        <ul>
            <li><a href="index.php">Tela Inicial</a></li>
            <li><a href="cursos/add_cursos.php">Criar Curso</a></li>
            <li><a href="cursos/add_aula.php">Adicionar Aula</a></li>
            <li><a href="cursos/meus_cursos.php">Meus Cursos</a></li>
            <li><a href="cursos/minhas_aulas.php">Minhas Aulas</a></li>
            <li><a href="responder-perguntas.php">Responder Perguntas</a></li>
            <li><a href="acompanhar-alunos.php">Acompanhar Alunos</a></li>
        </ul>
        <div class="btn-alunos">
            <div id="perfilAlunoBtn" class="perfil-aluno-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#333" viewBox="0 0 24 24">
                    <path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z" />
                </svg>
            </div>

            <!-- Container de opções -->
            <div id="perfilAlunoOpcoes" class="perfil-opcoes">
                <a href="profile.php">Meu Perfil</a>
                <a href="../suporte/suporte.php" target="_blank">Central de Ajuda</a>
                <a href="../funcoes/sessoes/logout.php">Sair</a>
            </div>
        </div>
    </nav>
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